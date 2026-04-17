<?php
session_start();

require_once '../config.php';

// Forzar HTTPS (Compatible con Proxies como Dokploy/Traefik)
$isHttps = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on') || 
           (isset($_SERVER['HTTP_X_FORWARDED_PROTO']) && $_SERVER['HTTP_X_FORWARDED_PROTO'] === 'https');

$isLocal = preg_match('/^(localhost|127\.0\.0\.1)(:\d+)?$/', $_SERVER['HTTP_HOST'] ?? '');

if (!$isHttps && !$isLocal) {
    header('Location: https://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'], true, 301);
    exit;
}
require_once '../core/Database.php';
require_once '../core/Router.php';
require_once '../core/View.php';
require_once '../core/Controller.php';
require_once '../core/Migrator.php';

// Ejecutar migraciones automáticamente si las hay
Migrator::run();

// Rastreo de actividad de usuario
if (isset($_SESSION['user_id'])) {
    require_once '../app/Helpers/SessionTracker.php';
    SessionTracker::updateActivity();
}

$router = new Router();

// Rutas base
$router->get('/', 'DashboardController@index');
$router->get('/login', 'AuthController@loginForm');
$router->post('/login', 'AuthController@login');
$router->get('/register', 'AuthController@registerForm');
$router->post('/register', 'AuthController@register');
$router->get('/logout', 'AuthController@logout');

// Páginas de Información (Públicas)
$router->get('/acerca-de', 'PageController@about');
$router->get('/guia-de-uso', 'PageController@guide');
$router->get('/changelog', 'PageController@changelog');

$router->get('/colonias', 'ColonyController@index');
$router->get('/colonias/nueva', 'ColonyController@create');
$router->post('/colonias/nueva', 'ColonyController@store');
$router->get('/colonias/ver/{id}', 'ColonyController@show');
$router->get('/colonias/editar/{id}', 'ColonyController@edit');
$router->post('/colonias/editar/{id}', 'ColonyController@update');
$router->post('/colonias/borrar/{id}', 'ColonyController@destroy');
$router->post('/colonias/poblacion/{id}', 'ColonyController@addPopulation');
$router->post('/colonias/diario/{id}', 'ColonyController@addDiary');
$router->get('/colonias/galeria/{id}', 'ColonyController@gallery');

$router->get('/settings', 'SettingsController@index');
$router->post('/settings', 'SettingsController@update');

$router->get('/stock', 'StockController@index');
$router->post('/stock', 'StockController@store');
$router->post('/stock/adjust/{id}', 'StockController@adjust');
$router->get('/api/stock/history/{id}', 'StockController@history');
$router->delete('/stock/{id}', 'StockController@destroy');

$router->post('/reminders', 'ReminderController@store');
$router->post('/reminders/complete/{id}', 'ReminderController@complete');
$router->post('/api/push/subscribe', 'ReminderController@subscribe');
$router->get('/cron/reminders', 'ReminderController@process');

$router->get('/especies', 'EspeciesController@index');
$router->get('/especies/ver/{id}', 'EspeciesController@show');
$router->get('/especies/proponer', 'EspeciesController@proposeNew');
$router->post('/especies/proponer', 'EspeciesController@storeNewProposal');
$router->get('/especies/editar/{id}', 'EspeciesController@edit');
$router->post('/especies/editar/{id}', 'EspeciesController@proposeEdit');
$router->get('/especies/search', 'EspeciesController@search');

$router->get('/admin/revisiones', 'EspeciesController@pendingRevisions');
$router->get('/admin/revisiones/historial', 'EspeciesController@historyRevisions');
$router->put('/admin/revisiones/{id}', 'EspeciesController@resolveRevision');

// Panel de Administración (Usuarios y Estadísticas)
$router->get('/admin/dashboard', 'AdminController@dashboard');
$router->post('/admin/run_migrations', 'AdminController@runMigrations');
$router->post('/admin/usuarios/ban/{id}', 'AdminController@toggleBan');
$router->get('/admin/usuarios/ver/{id}', 'AdminController@viewUser');
$router->post('/admin/usuarios/stock/editar/{id}', 'AdminController@editUserStock');
$router->post('/admin/usuarios/stock/borrar/{id}', 'AdminController@deleteUserStock');
$router->post('/admin/usuarios/colonia/borrar/{id}', 'AdminController@deleteUserColony');
$router->post('/admin/update_broadcast', 'AdminController@updateBroadcast');
$router->post('/admin/cleanup_logs', 'AdminController@cleanupLogs');

// Gestión de Especies y Traducciones (Admin)
$router->get('/admin/especies', 'AdminEspeciesController@index');
$router->post('/admin/especies/publicar/{id}', 'AdminEspeciesController@publish');
$router->get('/admin/especies/editar/{id}', 'AdminEspeciesController@edit');
$router->post('/admin/especies/editar/{id}', 'AdminEspeciesController@update');
$router->get('/admin/especies/traducir/{id}', 'AdminEspeciesController@translate');
$router->post('/admin/especies/traducir/{id}', 'AdminEspeciesController@storeTranslation');

// API PWA (Sincronización Offline)
$router->get('/api/data', 'ApiController@data');
$router->post('/api/sync', 'ApiController@sync');

// Rutas Públicas (Logs Compartibles)
$router->get('/log/{user}/{colony}', 'PublicLogController@show');

// Rutas de Perfil y Gamificación
$router->get('/u/{slug}', 'ProfileController@show');
$router->get('/perfil/editar', 'ProfileController@edit');
$router->post('/perfil/actualizar', 'ProfileController@update');

// Gestión de Privacidad
$router->post('/colonias/publico/{id}', 'ColonyController@togglePublic');
$router->post('/diario/visibilidad/{id}', 'ColonyController@toggleDiaryVisibility');

// Capturar URI actual
$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

// Eliminar BASE_URL de la URI (e.g. '/laravel')
if (defined('BASE_URL') && strpos($uri, BASE_URL) === 0) {
    $uri = substr($uri, strlen(BASE_URL));
}

if (empty($uri)) {
    $uri = '/';
}

$router->dispatch($uri, $_SERVER['REQUEST_METHOD']);
