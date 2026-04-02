<?php
require_once '../app/Models/User.php';
require_once '../core/ThemeManager.php';

class SettingsController extends Controller {
    public function index() {
        require_login();
        
        $user = User::find($_SESSION['user_id']);
        $settings = json_decode($user['settings'] ?? '{}', true);
        
        $data = [
            'settings' => $settings,
            'themes'   => ThemeManager::getThemes(),
            'title'    => 'Ajustes de Accesibilidad | AntMaster Pro',
            'success'  => $_SESSION['success'] ?? '',
            'error'    => $_SESSION['error'] ?? ''
        ];
        
        unset($_SESSION['success'], $_SESSION['error']);
        $this->view('settings/index', $data);
    }
    
    public function update() {
        require_login();
        
        $settings = [
            'theme'           => $_POST['theme'] ?? 'messor',
            'high_contrast'   => isset($_POST['high_contrast']),
            'reduced_motion'  => isset($_POST['reduced_motion']),
            'colorblind_mode' => $_POST['colorblind_mode'] ?? 'none'
        ];
        
        if (User::update($_SESSION['user_id'], ['settings' => json_encode($settings)])) {
            $_SESSION['user_settings'] = $settings; // Sincronizar sesión
            $_SESSION['success'] = 'Preferencias guardadas correctamente.';
        } else {
            $_SESSION['error'] = 'Error al guardar los ajustes.';
        }
        
        $this->redirect('/settings');
    }
}
