<?php
session_start();

require_once '../config.php';
require_once '../core/Database.php';
require_once '../core/Router.php';
require_once '../core/View.php';
require_once '../core/Controller.php';
require_once '../core/Migrator.php';

// Ejecutar migraciones automáticamente si las hay
Migrator::run();

$router = new Router();

// Rutas base
$router->get('/', 'DashboardController@index');
$router->get('/login', 'AuthController@loginForm');
$router->post('/login', 'AuthController@login');
$router->get('/register', 'AuthController@registerForm');
$router->post('/register', 'AuthController@register');
$router->get('/logout', 'AuthController@logout');

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
$router->delete('/stock/{id}', 'StockController@destroy');

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
$router->post('/admin/usuarios/ban/{id}', 'AdminController@toggleBan');

// Gestión de Especies y Traducciones (Admin)
$router->get('/admin/especies', 'AdminEspeciesController@index');
$router->get('/admin/especies/traducir/{id}', 'AdminEspeciesController@translate');
$router->post('/admin/especies/traducir/{id}', 'AdminEspeciesController@storeTranslation');

// Rutas Públicas (Logs Compartibles)
$router->get('/log/{user}/{colony}', 'PublicLogController@show');

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
