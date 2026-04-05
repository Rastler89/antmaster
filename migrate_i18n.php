<?php
require_once 'config.php';
require_once 'core/Database.php';

try {
    $pdo = Database::getConnection();
    
    // 1. Create especies_traducciones table
    $sql_create = "CREATE TABLE IF NOT EXISTS especies_traducciones (
        id INT AUTO_INCREMENT PRIMARY KEY,
        especie_id INT NOT NULL,
        idioma CHAR(2) NOT NULL,
        nombre VARCHAR(100),
        descripcion TEXT,
        alimentacion TEXT,
        consejos_cria TEXT,
        localizacion TEXT,
        UNIQUE INDEX (especie_id, idioma),
        FOREIGN KEY (especie_id) REFERENCES especies(id) ON DELETE CASCADE
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;";
    
    $pdo->exec($sql_create);
    echo "Tabla 'especies_traducciones' creada correctamente.\n";

    // 2. Migrate existing Spanish data
    $stmt = $pdo->query("SELECT id, nombre, descripcion, alimentacion, consejos_cria, localizacion FROM especies");
    $species = $stmt->fetchAll();
    
    foreach ($species as $s) {
        $stmt_insert = $pdo->prepare("REPLACE INTO especies_traducciones (especie_id, idioma, nombre, descripcion, alimentacion, consejos_cria, localizacion) VALUES (?, 'es', ?, ?, ?, ?, ?)");
        $stmt_insert->execute([
            $s['id'],
            $s['nombre'],
            $s['descripcion'],
            $s['alimentacion'],
            $s['consejos_cria'],
            $s['localizacion']
        ]);
        echo "Migrada traducción ES para: " . $s['nombre'] . "\n";
    }

    echo "Migración completada con éxito.\n";

} catch (PDOException $e) {
    die("Error en migración: " . $e->getMessage());
}
