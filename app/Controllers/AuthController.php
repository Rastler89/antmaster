<?php
require_once '../app/Models/User.php';

class AuthController extends Controller {
    public function loginForm() {
        if (is_logged_in()) $this->redirect('/');
        $this->view('auth/login');
    }

    public function login() {
        if (is_logged_in()) $this->redirect('/');
        
        $email = $_POST['email'] ?? '';
        $password = $_POST['password'] ?? '';
        
        $user = User::whereOne('email', '=', $email);

        if ($user && password_verify($password, $user['password'])) {
            if (isset($user['is_banned']) && $user['is_banned'] == 1) {
                $this->view('auth/login', ['error' => 'Tu cuenta ha sido suspendida. Contacta con soporte para más información.', 'email' => $email]);
                return;
            }

            // Registrar last_login
            User::update($user['id'], ['last_login' => date('Y-m-d H:i:s')]);

            $_SESSION['user_id'] = $user['id'];
            $_SESSION['user_name'] = $user['nombre'];
            $_SESSION['user_rol'] = $user['rol'];
            $_SESSION['user_settings'] = json_decode($user['settings'] ?? '{}', true);
            
            $redirectTo = $_SESSION['redirect_to'] ?? '/';
            unset($_SESSION['redirect_to']);
            $this->redirect($redirectTo);
        } else {
            $this->view('auth/login', ['error' => 'Credenciales incorrectas.', 'email' => $email]);
        }
    }

    public function registerForm() {
        if (is_logged_in()) $this->redirect('/');
        $this->view('auth/register');
    }

    public function register() {
        if (is_logged_in()) $this->redirect('/');

        $nombre = $_POST['nombre'] ?? '';
        $email = $_POST['email'] ?? '';
        $password = $_POST['password'] ?? '';
        
        if (User::whereOne('email', '=', $email)) {
            $this->view('auth/register', ['error' => 'El email ya está registrado.', 'nombre' => $nombre, 'email' => $email]);
            return;
        }

        // Generar slug único basado en el nombre
        $slug = strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', $nombre)));
        $tempSlug = $slug;
        $i = 1;
        while (User::whereOne('slug', '=', $tempSlug)) {
            $tempSlug = $slug . '-' . $i++;
        }
        $slug = $tempSlug;

        $data = [
            'nombre' => $nombre,
            'email' => $email,
            'slug' => $slug,
            'password' => password_hash($password, PASSWORD_DEFAULT)
        ];

        if (User::create($data)) {
            $user = User::whereOne('email', '=', $email);
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['user_name'] = $user['nombre'];
            $_SESSION['user_rol'] = $user['rol'];
            $_SESSION['user_settings'] = json_decode($user['settings'] ?? '{}', true);
            $this->redirect('/');
        } else {
            $this->view('auth/register', ['error' => 'Error al registrar el usuario.', 'nombre' => $nombre, 'email' => $email]);
        }
    }

    public function logout() {
        session_destroy();
        $this->redirect('/login');
    }
}
