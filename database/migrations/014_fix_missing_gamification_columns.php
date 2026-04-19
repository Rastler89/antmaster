<?php
/**
 * Migration 014: Garantizar columnas de gamificación
 * Este archivo se asegura de que las columnas críticas de la migración 012 existan,
 * reparando instalaciones donde la migración 012 pudo haber fallado parcialmente.
 */

// $pdo ya está disponible en el scope del Migrator
if (!isset($pdo)) {
    $pdo = Database::getConnection();
}

$columnsToFix = [
    'slug' => "ALTER TABLE usuarios ADD COLUMN slug VARCHAR(100) UNIQUE NULL AFTER nombre",
    'bio' => "ALTER TABLE usuarios ADD COLUMN bio TEXT NULL AFTER settings",
    'profile_image' => "ALTER TABLE usuarios ADD COLUMN profile_image VARCHAR(255) NULL AFTER bio",
    'is_public' => "ALTER TABLE usuarios ADD COLUMN is_public TINYINT(1) DEFAULT 1 AFTER profile_image",
    'xp' => "ALTER TABLE usuarios ADD COLUMN xp INT DEFAULT 0 AFTER is_public"
];

foreach ($columnsToFix as $colName => $sql) {
    try {
        // Verificar si la columna existe
        $check = $pdo->query("SHOW COLUMNS FROM usuarios LIKE '$colName'")->fetch();
        if (!$check) {
            $pdo->exec($sql);
        }
    } catch (Exception $e) {
        error_log("Migración 014 ERROR al procesar '$colName': " . $e->getMessage());
    }
}

// También asegurar que la tabla de logros existe
try {
    $pdo->exec("CREATE TABLE IF NOT EXISTS logros (
        id INT AUTO_INCREMENT PRIMARY KEY,
        categoria VARCHAR(50) NOT NULL,
        nombre VARCHAR(100) NOT NULL,
        descripcion TEXT,
        requisito_tipo VARCHAR(50) NOT NULL,
        requisito_valor INT NOT NULL,
        nivel VARCHAR(20) DEFAULT 'bronce',
        icono_svg TEXT,
        fecha_creacion TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    )");
    
    $pdo->exec("CREATE TABLE IF NOT EXISTS logros_usuarios (
        id INT AUTO_INCREMENT PRIMARY KEY,
        usuario_id INT NOT NULL,
        logro_id INT NOT NULL,
        fecha_conseguido TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        FOREIGN KEY (usuario_id) REFERENCES usuarios(id) ON DELETE CASCADE,
        FOREIGN KEY (logro_id) REFERENCES logros(id) ON DELETE CASCADE,
        UNIQUE KEY (usuario_id, logro_id)
    )");
} catch (Exception $e) {
    error_log("Migración 014 ERROR al asegurar tablas de logros: " . $e->getMessage());
}
