<?php
require 'config.php';
require 'core/Database.php';
$db = Database::getConnection();

// Check user
$stmt = $db->prepare("SELECT id, rol, nombre FROM usuarios WHERE email = ?");
$stmt->execute(['admin@antmaster.com']);
$user = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$user) {
    echo "USER NOT FOUND\n";
} else {
    echo "USER FOUND: " . $user['nombre'] . " (ID: " . $user['id'] . ") ROL: " . $user['rol'] . "\n";
    
    // Ensure it is admin
    if ($user['rol'] !== 'admin') {
        $db->prepare("UPDATE usuarios SET rol = 'admin' WHERE id = ?")->execute([$user['id']]);
        echo "ROLE UPDATED TO ADMIN\n";
    }

    // Set password to 'admin123'
    $hash = password_hash('admin123', PASSWORD_DEFAULT);
    $db->prepare("UPDATE usuarios SET password = ? WHERE id = ?")->execute([$hash, $user['id']]);
    echo "PASSWORD UPDATED TO: admin123\n";
}
