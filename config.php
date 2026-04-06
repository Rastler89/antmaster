<?php
define('ROOT_PATH', __DIR__);
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
define('APP_VERSION', '1.1.2');

// Detección de BASE_URL más robusta
$baseUrl = str_replace('/index.php', '', $_SERVER['SCRIPT_NAME'] ?? '');
$baseUrl = str_replace('/public', '', $baseUrl);
define('BASE_URL', $baseUrl);

// --- Soporte Multi-idioma (i18n) ---
$available_langs = ['es', 'en', 'fr'];
$default_lang = 'es';

// 1. Determinar el idioma actual (Session > Cookie > Browser > Default)
if (isset($_GET['lang']) && in_array($_GET['lang'], $available_langs)) {
    $_SESSION['lang'] = $_GET['lang'];
    setcookie('lang', $_GET['lang'], time() + (86400 * 30), "/"); // 30 días
}

if (!isset($_SESSION['lang'])) {
    if (isset($_COOKIE['lang']) && in_array($_COOKIE['lang'], $available_langs)) {
        $_SESSION['lang'] = $_COOKIE['lang'];
    } else {
        // Detección por navegador
        $browser_lang = substr($_SERVER['HTTP_ACCEPT_LANGUAGE'] ?? 'es', 0, 2);
        $_SESSION['lang'] = in_array($browser_lang, $available_langs) ? $browser_lang : $default_lang;
    }
}

define('APP_LANG', $_SESSION['lang']);

// 2. Cargar diccionario
$lang_file = __DIR__ . "/app/Lang/" . APP_LANG . "/messages.php";
$translations = file_exists($lang_file) ? require $lang_file : [];

/**
 * Función de traducción global
 * @param string $key Clave de la traducción
 * @param array $params Parámetros para sustituir (ej: ['name' => 'John'])
 * @return string Texto traducido
 */
function __($key, $params = []) {
    global $translations;
    $text = $translations[$key] ?? $key;
    
    foreach ($params as $k => $v) {
        $text = str_replace(":$k", $v, $text);
    }
    return $text;
}
// -----------------------------------

// Configuración de SEO
define('APP_DESCRIPTION', __('seo_description'));
define('APP_KEYWORDS', __('seo_keywords'));
define('APP_IMAGE', 'assets/img/og-preview.png'); // Sin barra inicial

// Función para manejar assets (CSS, JS, Imágenes)
function asset($path) {
    $path = ltrim($path, '/');
    $fullPath = __DIR__ . '/public/' . $path;
    
    // Si el archivo existe físicamente en /public
    if (file_exists($fullPath)) {
        // Si ya estamos sirviendo desde la carpeta /public (común en despliegues)
        if (strpos($_SERVER['SCRIPT_NAME'] ?? '', '/public/') === false) {
             // Si el script actual NO está en /public pero el servidor redirige allí
             // (como en el .htaccess de la raíz), devolvemos la ruta simple
             return BASE_URL . '/' . $path;
        }
        return BASE_URL . '/public/' . $path;
    }
    return BASE_URL . '/' . $path;
}


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
    if (!$date_string) return __('time_na');
    
    $start = new DateTime($date_string);
    $now = new DateTime();
    $interval = $start->diff($now);

    $parts = [];
    if ($interval->y > 0) $parts[] = $interval->y . __('time_years_short');
    if ($interval->m > 0) $parts[] = $interval->m . __('time_months_short');
    if ($interval->d > 0) $parts[] = $interval->d . __('time_days_short');

    if (empty($parts)) return __('time_today');

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