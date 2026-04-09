<?php
require_once '../app/Models/Reminder.php';
require_once '../app/Models/PushSubscription.php';
require_once '../app/Helpers/WebPushHelper.php';

class ReminderController extends Controller {
    
    public function store() {
        require_login();
        
        $colonyId = $_POST['colonia_id'] ?? null;
        $data = [
            'usuario_id'    => $_SESSION['user_id'],
            'colonia_id'    => $colonyId !== '' ? $colonyId : null,
            'titulo'        => $_POST['titulo'] ?? 'Recordatorio',
            'descripcion'   => $_POST['descripcion'] ?? '',
            'clase'         => $_POST['clase'] ?? 'otros',
            'frecuencia'    => $_POST['frecuencia'] ?? 'unica',
            'fecha_proxima' => $_POST['fecha_proxima'] ?? date('Y-m-d'),
            'completado'    => 0
        ];

        if (Reminder::create($data)) {
            $_SESSION['success'] = "Recordatorio programado correctamente.";
        } else {
            $_SESSION['error'] = "Error al crear el recordatorio.";
        }

        if ($colonyId) {
            $this->redirect('/colonias/ver/' . $colonyId);
        } else {
            $this->redirect('/dashboard');
        }
    }

    public function complete($id) {
        require_login();
        if (Reminder::complete($id)) {
            // Gamificación: +15 XP
            require_once '../app/Helpers/GamificationHelper.php';
            GamificationHelper::addXP($_SESSION['user_id'], 15);
            GamificationHelper::checkAndAwardBadges($_SESSION['user_id']);

            $_SESSION['success'] = "¡Tarea completada!";
        } else {
            $_SESSION['error'] = "No se pudo actualizar la tarea.";
        }
        $this->redirect($_SERVER['HTTP_REFERER'] ?: '/dashboard');
    }

    public function subscribe() {
        require_login();
        $input = json_decode(file_get_contents('php://input'), true);
        
        if (!$input) {
            return $this->json(['error' => 'Invalid data'], 400);
        }

        if (PushSubscription::subscribe($_SESSION['user_id'], $input)) {
            return $this->json(['success' => true]);
        }
        return $this->json(['error' => 'Database error'], 500);
    }

    /**
     * Este método será invocado por el Cron Job
     */
    public function process() {
        // Podríamos añadir un token de seguridad aquí si no se protege por .htaccess
        
        $pendingReminders = Reminder::query("SELECT r.*, u.id as user_id 
                                           FROM recordatorios r 
                                           JOIN usuarios u ON r.usuario_id = u.id 
                                           WHERE r.completado = 0 
                                           AND r.fecha_proxima = CURRENT_DATE");

        foreach ($pendingReminders as $r) {
            $msg = "Tu colonia necesita atención: " . $r['titulo'];
            WebPushHelper::send($r['user_id'], "Recordatorio AntMaster", $msg, BASE_URL . '/colonias/ver/' . $r['colonia_id']);
            
            // Si es un recordatorio único, lo marcamos como procesado (aunque el usuario deba completarlo manualmente)
            // O mejor: lo dejamos hasta que el usuario le de a "Hecho".
        }
        
        return $this->json(['processed' => count($pendingReminders)]);
    }
}
