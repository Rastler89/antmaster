<?php
// Configuración de la Base de Datos
$env_db_host = getenv('DB_HOST') ?: ($_ENV['DB_HOST'] ?? $_SERVER['DB_HOST'] ?? 'localhost');
$env_db_name = getenv('DB_NAME') ?: ($_ENV['DB_NAME'] ?? $_SERVER['DB_NAME'] ?? 'gestor_hormigas');
$env_db_user = getenv('DB_USER') ?: ($_ENV['DB_USER'] ?? $_SERVER['DB_USER'] ?? 'root');
$env_db_pass = getenv('DB_PASS') ?: ($_ENV['DB_PASS'] ?? $_SERVER['DB_PASS'] ?? '544728');

define('DB_HOST', $env_db_host === 'localhost' ? '127.0.0.1' : $env_db_host);
define('DB_NAME', $env_db_name);
define('DB_USER', $env_db_user);
define('DB_PASS', $env_db_pass);

// Configuración de la Aplicación
define('APP_NAME', 'AntMaster Pro');
define('BASE_URL', getenv('APP_ENV') === 'docker' ? '' : '/laravel'); // Ajustar según la carpeta en Laragon / Docker


// Conexión PDO
try {
    $pdo = new PDO("mysql:host=" . DB_HOST . ";dbname=" . DB_NAME . ";charset=utf8mb4", DB_USER, DB_PASS);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("Error de conexión: " . $e->getMessage());
}

// Iniciar Sesión
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Funciones de utilidad
function redirect($url)
{
    header("Location: " . $url);
    exit();
}

function is_logged_in()
{
    // Cargar rol y ajustes automáticamente en sesiones antiguas
    if (isset($_SESSION['user_id']) && (!isset($_SESSION['user_rol']) || !isset($_SESSION['user_settings']))) {
        require_once 'core/Database.php';
        $pdo = Database::getConnection();
        $stmt = $pdo->prepare("SELECT rol, settings FROM usuarios WHERE id = ?");
        $stmt->execute([$_SESSION['user_id']]);
        $user = $stmt->fetch();
        
        if ($user) {
            $_SESSION['user_rol'] = $user['rol'];
            $_SESSION['user_settings'] = json_decode($user['settings'] ?? '{}', true);
        }
    }
    return isset($_SESSION['user_id']);
}

function require_login()
{
    if (!is_logged_in()) {
        $_SESSION['redirect_to'] = $_SERVER['REQUEST_URI'];
        redirect('/login');
    }
}

function is_admin()
{
    return isset($_SESSION['user_rol']) && $_SESSION['user_rol'] === 'admin';
}

function require_admin()
{
    if (!is_admin()) {
        header('HTTP/1.0 403 Forbidden');
        echo "403 Forbidden: Permisos de Administrador requeridos.";
        exit;
    }
}

function get_time_elapsed($date_string)
{
    if (!$date_string) return 'N/A';
    
    $start = new DateTime($date_string);
    $now = new DateTime();
    $interval = $start->diff($now);

    $parts = [];
    if ($interval->y > 0) $parts[] = $interval->y . 'a';
    if ($interval->m > 0) $parts[] = $interval->m . 'm';
    if ($interval->d > 0) $parts[] = $interval->d . 'd';

    if (empty($parts)) return 'Hoy';

    return implode(' ', $parts);
}

function current_url() {
    $uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
    if (defined('BASE_URL') && strpos($uri, BASE_URL) === 0) {
        $uri = substr($uri, strlen(BASE_URL));
    }
    return $uri ?: '/';
}
?>