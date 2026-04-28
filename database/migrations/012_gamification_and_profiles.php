<?php
// Migration 012: Perfiles de Usuario y Gamificación
// Rescrito como PHP para manejar errores de columnas duplicadas si la migración falló a medias

if (!isset($pdo)) {
    $pdo = Database::getConnection();
}

$queries = [
    // 1. Ampliar tabla usuarios
    "ALTER TABLE usuarios ADD COLUMN slug VARCHAR(100) UNIQUE NULL AFTER nombre",
    "ALTER TABLE usuarios ADD COLUMN bio TEXT NULL AFTER settings",
    "ALTER TABLE usuarios ADD COLUMN profile_image VARCHAR(255) NULL AFTER bio",
    "ALTER TABLE usuarios ADD COLUMN is_public TINYINT(1) DEFAULT 1 AFTER profile_image",
    "ALTER TABLE usuarios ADD COLUMN xp INT DEFAULT 0 AFTER is_public",

    // 2. Ampliar tabla colonias
    "ALTER TABLE colonias ADD COLUMN is_public TINYINT(1) DEFAULT 0 AFTER imagen",

    // 3. Crear tabla de logros (Maestro)
    "CREATE TABLE IF NOT EXISTS logros (
        id INT AUTO_INCREMENT PRIMARY KEY,
        categoria VARCHAR(50) NOT NULL,
        nombre VARCHAR(100) NOT NULL,
        descripcion TEXT,
        requisito_tipo VARCHAR(50) NOT NULL,
        requisito_valor INT NOT NULL,
        nivel VARCHAR(20) DEFAULT 'bronce',
        icono_svg TEXT,
        fecha_creacion TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    )",

    // 4. Crear tabla de logros conseguidos por usuarios
    "CREATE TABLE IF NOT EXISTS logros_usuarios (
        id INT AUTO_INCREMENT PRIMARY KEY,
        usuario_id INT NOT NULL,
        logro_id INT NOT NULL,
        fecha_conseguido TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        FOREIGN KEY (usuario_id) REFERENCES usuarios(id) ON DELETE CASCADE,
        FOREIGN KEY (logro_id) REFERENCES logros(id) ON DELETE CASCADE,
        UNIQUE KEY (usuario_id, logro_id)
    )",

    // 5. Insertar logros base (Ejemplos iniciales)
    "INSERT IGNORE INTO logros (categoria, nombre, descripcion, requisito_tipo, requisito_valor, nivel) VALUES
    ('diarios', 'Historiador de Bronce', 'Escribe 10 entradas de diario', 'diarios', 10, 'bronce'),
    ('diarios', 'Historiador de Plata', 'Escribe 50 entradas de diario', 'diarios', 50, 'plata'),
    ('diarios', 'Historiador de Oro', 'Escribe 200 entradas de diario', 'diarios', 200, 'oro'),
    ('ciencias', 'Taxónomo de Bronce', 'Colabora con 1 ficha de especie aprobada', 'fichas', 1, 'bronce'),
    ('ciencias', 'Taxónomo de Plata', 'Colabora con 5 fichas de especie aprobadas', 'fichas', 5, 'plata'),
    ('coleccion', 'Mirmecólogo de Bronce', 'Registra 3 colonias activas', 'colonias', 3, 'bronce'),
    ('coleccion', 'Mirmecólogo de Plata', 'Registra 10 colonias activas', 'colonias', 10, 'plata'),
    ('almacen', 'Intendente de Bronce', 'Registra 5 items en tu stock', 'stock', 5, 'bronce')"
];

foreach ($queries as $sql) {
    try {
        $pdo->exec($sql);
    } catch (PDOException $e) {
        $code = $e->getCode();
        $msg = $e->getMessage();
        
        // Ignorar 1060 Duplicate column name o 42S21 (SQLSTATE column already exists)
        if ($code == '42S21' || strpos($msg, 'Duplicate column name') !== false || strpos($msg, '1060') !== false) {
            continue;
        }
        
        // Ignorar 1050 Table already exists o 42S01 (SQLSTATE table already exists)
        if ($code == '42S01' || strpos($msg, 'already exists') !== false || strpos($msg, '1050') !== false) {
            continue;
        }

        // Si es otro error, lanzarlo para que el Migrator lo capture
        throw $e;
    }
}
