<?php

require_once '../app/Models/User.php';
require_once '../app/Models/Colony.php';
require_once '../app/Models/SpeciesRevision.php';
require_once '../app/Models/Stock.php';

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
            'avg_colonies_per_user' => 0
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

        // Listado de usuarios para gestionar
        $users = $pdo->query("SELECT id, nombre, email, rol, fecha_registro, last_login, is_banned FROM usuarios ORDER BY id DESC")->fetchAll();

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
        // Usamos el nombre científico para evitar ambigüedades
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

        // 3. Revisiones Pendientes (NUEVO)
        $pending_revisions = SpeciesRevision::getPendingWithDetails();
        $stats['pending_revisions'] = count($pending_revisions);

        $this->view('admin/dashboard', [
            'stats' => $stats, 
            'users' => $users,
            'chart_user_growth' => $chart_user_growth,
            'chart_species_dist' => $chart_species_dist,
            'pending_revisions' => array_slice($pending_revisions, 0, 5) // Mostramos solo las 5 más recientes
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
}
