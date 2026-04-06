<?php
// 005_add_i18n_support.php
// Esta migración crea la tabla de traducciones y migra los datos existentes.

try {
    // 1. Crear tabla especies_traducciones si no existe
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

    // 2. Migrar datos existentes en español (es) desde la tabla 'especies'
    // Solo si no existen ya en la tabla de traducciones
    $stmt = $pdo->query("SELECT id, nombre, descripcion, alimentacion, consejos_cria, localizacion FROM especies");
    $species = $stmt->fetchAll();
    
    foreach ($species as $s) {
        // Usamos INSERT IGNORE para no duplicar si la migración se corre de nuevo manualmente
        $stmt_insert = $pdo->prepare("INSERT IGNORE INTO especies_traducciones 
            (especie_id, idioma, nombre, descripcion, alimentacion, consejos_cria, localizacion) 
            VALUES (?, 'es', ?, ?, ?, ?, ?)");
        
        $stmt_insert->execute([
            $s['id'],
            $s['nombre'],
            $s['descripcion'],
            $s['alimentacion'],
            $s['consejos_cria'],
            $s['localizacion']
        ]);
    }

} catch (PDOException $e) {
    throw new Exception("Error en migración 005: " . $e->getMessage());
}
