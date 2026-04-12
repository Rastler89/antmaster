<?php
/**
 * Script de inicialización retroactiva de Gamificación y Perfiles
 */
require_once __DIR__ . '/../config.php';
require_once __DIR__ . '/../core/Database.php';
require_once __DIR__ . '/../app/Helpers/GamificationHelper.php';

$db = Database::getConnection();

echo "--- Iniciando Migración Retroactiva ---\n";

// 1. Ejecutar SQL de migración (si no se ha ejecutado ya)
$sqlFile = __DIR__ . '/../database/migrations/012_gamification_and_profiles.sql';
if (file_exists($sqlFile)) {
    echo "Ejecutando SQL de migración...\n";
    $sql = file_get_contents($sqlFile);
    $statements = array_filter(array_map('trim', explode(';', $sql)));
    
    foreach ($statements as $stmt) {
        try {
            $db->exec($stmt);
        } catch (Exception $e) {
            // Ignorar errores de "columna ya existe" o "tabla ya existe"
            if (strpos($e->getMessage(), 'Duplicate column name') === false && 
                strpos($e->getMessage(), 'already exists') === false) {
                echo "Nota en '{$stmt}': " . $e->getMessage() . "\n";
            }
        }
    }
    echo "Procesamiento de SQL completado.\n";
}

// 2. Procesar usuarios
$users = $db->query("SELECT id, nombre FROM usuarios")->fetchAll();

foreach ($users as $user) {
    echo "Procesando usuario: {$user['nombre']} (ID: {$user['id']})...\n";
    
    // Generar Slug
    $slug = strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', $user['nombre'])));
    // Verificar si el slug ya existe (añadir número si es necesario)
    $checkSlug = $db->prepare("SELECT id FROM usuarios WHERE slug = ? AND id != ?");
    $checkSlug->execute([$slug, $user['id']]);
    if ($checkSlug->fetch()) {
        $slug .= '-' . $user['id'];
    }
    
    // Calcular XP
    $totalXP = GamificationHelper::calculateTotalXP($user['id']);
    
    // Actualizar usuario
    $update = $db->prepare("UPDATE usuarios SET slug = ?, xp = ? WHERE id = ?");
    $update->execute([$slug, $totalXP, $user['id']]);
    
    // Otorgar medallas
    $badgesAwarded = GamificationHelper::checkAndAwardBadges($user['id']);
    
    echo " -> Slug: {$slug} | XP: {$totalXP} | Medallas otorgadas: {$badgesAwarded}\n";
}

echo "--- Proceso completado con éxito ---\n";
