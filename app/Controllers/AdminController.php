<?php

require_once '../app/Models/User.php';
require_once '../app/Models/Colony.php';
require_once '../app/Models/SpeciesRevision.php';
require_once '../app/Models/Stock.php';
require_once '../app/Helpers/SystemInfo.php';

class AdminController extends Controller {

    public function dashboard() {
        require_admin(); // Proteger acceso exclusivo para admins

        $pdo = Database::getConnection();

        // Estadísticas básicas
        $stats = [
            'total_users' => 0,
            'active_users' => 0, // logueados en los últimos 30 días
            'banned_users' => 0,
            'total_colonies' => 0,
            'avg_colonies_per_user' => 0,
            'draft_species_count' => 0,
            'db_size' => SystemInfo::getDatabaseSize(),
            'server' => SystemInfo::getServerInfo()
        ];

        // Usuarios totales y baneados
        $usuarios_data = $pdo->query("SELECT 
            COUNT(*) as total, 
            SUM(CASE WHEN is_banned = 1 THEN 1 ELSE 0 END) as baneados,
            SUM(CASE WHEN last_login >= NOW() - INTERVAL 30 DAY THEN 1 ELSE 0 END) as activos
        FROM usuarios")->fetch();

        $stats['total_users'] = $usuarios_data['total'] ?? 0;
        $stats['banned_users'] = $usuarios_data['baneados'] ?? 0;
        $stats['active_users'] = $usuarios_data['activos'] ?? 0;

        // Colonias
        $colonias_data = $pdo->query("SELECT COUNT(*) as total FROM colonias")->fetch();
        $stats['total_colonies'] = $colonias_data['total'] ?? 0;

        if ($stats['total_users'] > 0) {
            $stats['avg_colonies_per_user'] = round($stats['total_colonies'] / $stats['total_users'], 2);
        }

        // Conteo de especies borrador
        $drafts_data = $pdo->query("SELECT COUNT(*) as total FROM especies WHERE is_draft = 1")->fetch();
        $stats['draft_species_count'] = $drafts_data['total'] ?? 0;

        // --- Nuevas métricas de sesión (Rastreo avanzado) ---
        $session_stats = $pdo->query("
            SELECT 
                AVG(TIMESTAMPDIFF(SECOND, login_at, last_activity_at)) as avg_duration,
                COUNT(DISTINCT CASE WHEN last_activity_at >= NOW() - INTERVAL 1 DAY THEN user_id END) as users_today,
                COUNT(DISTINCT CASE WHEN last_activity_at >= NOW() - INTERVAL 7 DAY THEN user_id END) as users_week,
                COUNT(DISTINCT CASE WHEN last_activity_at >= NOW() - INTERVAL 30 DAY THEN user_id END) as users_month
            FROM user_sessions
            WHERE last_activity_at > login_at
        ")->fetch();

        $stats['avg_session_duration'] = round($session_stats['avg_duration'] ?? 0);
        $stats['users_today'] = $session_stats['users_today'] ?? 0;
        $stats['users_week'] = $session_stats['users_week'] ?? 0;
        $stats['users_month'] = $session_stats['users_month'] ?? 0;

        // Metricas de Retención (DAU/MAU)
        $stats['retention_rate'] = ($stats['users_month'] > 0) ? round(($stats['users_today'] / $stats['users_month']) * 100, 1) : 0;

        // --- MÉTRICAS DE SALUD DE LA PLATAFORMA ---
        
        // 1. Tasa de Cuidado Global (Reminders hoy)
        $care_data = $pdo->query("
            SELECT 
                COUNT(*) as total,
                SUM(CASE WHEN completado = 1 THEN 1 ELSE 0 END) as completados
            FROM recordatorios 
            WHERE fecha_proxima = CURRENT_DATE
        ")->fetch();
        $stats['care_index'] = ($care_data['total'] > 0) ? round(($care_data['completados'] / $care_data['total']) * 100) : 100;

        // 2. Cobertura de Conocimiento (Especies verificadas)
        $knowledge_data = $pdo->query("
            SELECT 
                COUNT(*) as total,
                SUM(CASE WHEN is_draft = 0 THEN 1 ELSE 0 END) as verificadas
            FROM especies
        ")->fetch();
        $stats['knowledge_coverage'] = ($knowledge_data['total'] > 0) ? round(($knowledge_data['verificadas'] / $knowledge_data['total']) * 100) : 0;

        // 3. Suscripciones Push Activas
        $push_data = $pdo->query("SELECT COUNT(*) as total FROM user_push_subscriptions")->fetch();
        $stats['push_subscriptions'] = $push_data['total'] ?? 0;

        // 4. Mensaje de Alerta del Sistema
        $alert_data = $pdo->query("SELECT setting_value FROM system_settings WHERE setting_key = 'system_alert_message'")->fetch();
        $stats['system_alert'] = $alert_data['setting_value'] ?? '';

        // Listado de usuarios para gestionar con estadísticas de compromiso mejoradas
        $users = $pdo->query("
            SELECT u.id, u.nombre, u.email, u.rol, u.fecha_registro, u.last_login, u.is_banned,
                   (SELECT COUNT(*) FROM colonias WHERE usuario_id = u.id) as colonies_count,
                   (SELECT COUNT(*) FROM diario d JOIN colonias c ON d.colonia_id = c.id WHERE c.usuario_id = u.id) as diary_count,
                   (SELECT AVG(TIMESTAMPDIFF(SECOND, login_at, last_activity_at)) FROM user_sessions WHERE user_id = u.id AND last_activity_at > login_at) as avg_session,
                   (SELECT SUM(TIMESTAMPDIFF(SECOND, login_at, last_activity_at)) FROM user_sessions WHERE user_id = u.id AND last_activity_at > login_at) as total_time
            FROM usuarios u 
            ORDER BY u.id DESC
        ")->fetchAll();

        // --- Datos para Gráficos ---
        
        // 1. Crecimiento de Usuarios (Últimos 12 meses)
        $user_growth_raw = $pdo->query("
            SELECT DATE_FORMAT(fecha_registro, '%Y-%m') as mes, COUNT(*) as total 
            FROM usuarios 
            GROUP BY mes 
            ORDER BY mes ASC 
            LIMIT 12
        ")->fetchAll();
        
        $chart_user_growth = [
            'labels' => array_column($user_growth_raw, 'mes'),
            'data'   => array_column($user_growth_raw, 'total')
        ];

        // 2. Distribución de Especies (Top 10)
        $species_dist_raw = $pdo->query("
            SELECT e.nombre_cientifico as etiqueta, COUNT(c.id) as total 
            FROM colonias c 
            JOIN especies e ON c.especie_id = e.id 
            GROUP BY e.id 
            ORDER BY total DESC 
            LIMIT 10
        ")->fetchAll();

        $chart_species_dist = [
            'labels' => array_column($species_dist_raw, 'etiqueta'),
            'data'   => array_column($species_dist_raw, 'total')
        ];

        // 3. Heatmap de Actividad (Por hora del día)
        $heatmap_raw = $pdo->query("
            SELECT HOUR(login_at) as hora, COUNT(*) as total 
            FROM user_sessions 
            WHERE login_at >= NOW() - INTERVAL 30 DAY
            GROUP BY hora 
            ORDER BY hora ASC
        ")->fetchAll();

        $heatmap_data = array_fill(0, 24, 0);
        foreach ($heatmap_raw as $row) {
            $heatmap_data[(int)$row['hora']] = (int)$row['total'];
        }

        // 4. Eventos Recientes (Logins, colonias, registros)
        $recent_events = $pdo->query("
            (SELECT 'user_reg' as type, nombre as description, fecha_registro as date FROM usuarios ORDER BY fecha_registro DESC LIMIT 5)
            UNION ALL
            (SELECT 'colony_new' as type, nombre as description, fecha_adquisicion as date FROM colonias ORDER BY fecha_adquisicion DESC LIMIT 5)
            UNION ALL
            (SELECT 'login' as type, (SELECT nombre FROM usuarios WHERE id = user_id) as description, login_at as date FROM user_sessions ORDER BY login_at DESC LIMIT 5)
            ORDER BY date DESC LIMIT 10
        ")->fetchAll();

        // 5. Revisiones Pendientes
        $pending_revisions = SpeciesRevision::getPendingWithDetails();
        $stats['pending_revisions'] = count($pending_revisions);

        $this->view('admin/dashboard', [
            'stats' => $stats, 
            'users' => $users,
            'chart_user_growth' => $chart_user_growth,
            'chart_species_dist' => $chart_species_dist,
            'heatmap_data' => $heatmap_data,
            'recent_events' => $recent_events,
            'pending_revisions' => array_slice($pending_revisions, 0, 5)
        ]);
    }

    public function toggleBan($id) {
        require_admin();

        // Evitar banearse a uno mismo
        if ($_SESSION['user_id'] == $id) {
            // Manejar error o simplemente redirigir
            $this->redirect('/admin/dashboard');
            return;
        }

        $user = User::find($id);
        if ($user) {
            $newStatus = ($user['is_banned'] == 1) ? 0 : 1;
            User::update($id, ['is_banned' => $newStatus]);
        }

        $this->redirect('/admin/dashboard');
    }

    public function viewUser($id) {
        require_admin();

        $user = User::find($id);
        if (!$user) {
            $this->redirect('/admin/dashboard');
        }

        $data = [
            'user'     => $user,
            'colonies' => Colony::getUserColonies($id),
            'stock'    => Stock::where('usuario_id', '=', $id),
            'title'    => 'Detalle de Usuario | Admin'
        ];

        $this->view('admin/user_detail', $data);
    }

    public function editUserStock($stockId) {
        require_admin();
        
        $stock = Stock::whereOne('id', '=', $stockId);
        if ($stock) {
            $cantidad = (float)($_POST['cantidad'] ?? $stock['cantidad']);
            Stock::update($stockId, ['cantidad' => $cantidad]);
            $_SESSION['success'] = "Stock del usuario actualizado (Admin).";
            $this->redirect('/admin/usuarios/ver/' . $stock['usuario_id']);
        } else {
            $this->redirect('/admin/dashboard');
        }
    }

    public function deleteUserStock($stockId) {
        require_admin();
        
        $stock = Stock::whereOne('id', '=', $stockId);
        if ($stock) {
            $userId = $stock['usuario_id'];
            Stock::delete($stockId);
            $_SESSION['success'] = "Stock eliminado (Admin).";
            $this->redirect('/admin/usuarios/ver/' . $userId);
        } else {
            $this->redirect('/admin/dashboard');
        }
    }

    public function deleteUserColony($colonyId) {
        require_admin();
        
        $colony = Colony::find($colonyId);
        if ($colony) {
            $userId = $colony['usuario_id'];
            if ($colony['imagen']) {
                @unlink('uploads/colonies/' . $colony['imagen']);
            }
            Colony::delete($colonyId);
            $_SESSION['success'] = "Colonia eliminada (Admin).";
            $this->redirect('/admin/usuarios/ver/' . $userId);
        } else {
            $this->redirect('/admin/dashboard');
        }
    }

    public function runMigrations() {
        require_admin();
        require_once '../core/Migrator.php';
        Migrator::run(true);
        $_SESSION['success'] = "Migraciones forzadas ejecutadas con éxito.";
        $this->redirect('/admin/dashboard');
    }

    public function updateBroadcast() {
        require_admin();
        $message = trim($_POST['message'] ?? '');
        $pdo = Database::getConnection();
        
        // Upsert simple para system_settings
        $stmt = $pdo->prepare("INSERT INTO system_settings (setting_key, setting_value) VALUES ('system_alert_message', ?) 
                               ON DUPLICATE KEY UPDATE setting_value = ?, updated_at = CURRENT_TIMESTAMP");
        $stmt->execute([$message, $message]);

        $_SESSION['success'] = "Comunicado global actualizado.";
        $this->redirect('/admin/dashboard');
    }

    public function cleanupLogs() {
        require_admin();
        $pdo = Database::getConnection();
        
        // Limpiar sesiones de más de 30 días
        $pdo->query("DELETE FROM user_sessions WHERE login_at < NOW() - INTERVAL 30 DAY");
        
        $_SESSION['success'] = "Mantenimiento completado: Logs de sesiones antiguas eliminados.";
        $this->redirect('/admin/dashboard');
    }
}
