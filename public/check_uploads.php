<?php
require_once '../config.php';

echo "<h1>Diagnóstico de Subidas - AntMaster Pro</h1>";
echo "<b>ROOT_PATH:</b> " . ROOT_PATH . "<br>";
echo "<b>UPLOAD_PATH:</b> " . UPLOAD_PATH . "<br>";
echo "<b>UPLOAD_URL:</b> " . UPLOAD_URL . "<br><br>";

echo "<h3>Límites del Servidor</h3>";
echo "<b>post_max_size:</b> " . ini_get('post_max_size') . "<br>";
echo "<b>upload_max_filesize:</b> " . ini_get('upload_max_filesize') . "<br>";
echo "<b>memory_limit:</b> " . ini_get('memory_limit') . "<br><br>";

echo "<h3>Librerías</h3>";
$gdInfo = extension_loaded('gd') ? "<span style='color:green;'>SÍ (Activada)</span>" : "<span style='color:red;'>NO (Desactivada)</span>";
echo "<b>GD Library:</b> " . $gdInfo . "<br><br>";

if (!is_dir(UPLOAD_PATH)) {
    echo "<span style='color:red;'>ERROR: El directorio de subidas NO existe. Intentando crear...</span><br>";
    if (mkdir(UPLOAD_PATH, 0777, true)) {
        echo "<span style='color:green;'>ÉXITO: Directorio creado.</span><br>";
    } else {
        echo "<span style='color:red;'>ERROR: No se pudo crear el directorio. Revisa permisos del padre.</span><br>";
    }
} else {
    echo "<span style='color:green;'>INFO: El directorio de subidas existe.</span><br>";
}

if (is_writable(UPLOAD_PATH)) {
    echo "<span style='color:green;'>ÉXITO: El directorio es ESCRIBIBLE.</span><br>";
    
    $testFile = UPLOAD_PATH . '/test_write.txt';
    if (file_put_contents($testFile, "Test de escritura: " . date('Y-m-d H:i:s'))) {
        echo "<span style='color:green;'>ÉXITO: Archivo de prueba creado correctamente.</span><br>";
        unlink($testFile);
    } else {
        echo "<span style='color:red;'>ERROR: Falló la escritura del archivo de prueba.</span><br>";
    }
} else {
    echo "<span style='color:red;'>ERROR: El directorio NO tiene permisos de escritura para el servidor web (www-data).</span><br>";
}

echo "<br><br><a href='" . BASE_URL . "'>Volver al Inicio</a>";
