<?php
/**
 * Generador de llaves VAPID para AntMaster Pro
 */
require_once __DIR__ . '/vendor/autoload.php';

use Minishlink\WebPush\VAPID;

echo "--- GENERADOR DE LLAVES VAPID ---\n";

try {
    $keys = VAPID::createVapidKeys();
    
    echo "\nCopia estos valores en tu archivo config.php:\n\n";
    echo "define('VAPID_PUBLIC_KEY',  '" . $keys['publicKey'] . "');\n";
    echo "define('VAPID_PRIVATE_KEY', '" . $keys['privateKey'] . "');\n";
    echo "\n--------------------------------\n";
    
} catch (Exception $e) {
    echo "\nERROR: No se pudieron generar las llaves.\n";
    echo "Detalle: " . $e->getMessage() . "\n";
    echo "\nPosible causa: La extensión OpenSSL no está configurada correctamente en tu PHP local.\n";
    echo "Prueba a ejecutarlo dentro de tu contenedor Docker si el error persiste.\n";
}
