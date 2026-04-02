<?php

require_once '../app/Models/User.php';
require_once '../app/Models/Colony.php';

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

        $this->view('admin/dashboard', ['stats' => $stats, 'users' => $users]);
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
}
