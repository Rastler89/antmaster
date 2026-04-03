<?php

class Migrator {
    public static function run() {
        $pdo = Database::getConnection();

        // 1. Asegurar que las tablas de control existen
        $pdo->exec("CREATE TABLE IF NOT EXISTS migrations (
            id INT AUTO_INCREMENT PRIMARY KEY,
            migration VARCHAR(255) NOT NULL UNIQUE,
            executed_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
        )");

        $pdo->exec("CREATE TABLE IF NOT EXISTS system_settings (
            id INT AUTO_INCREMENT PRIMARY KEY,
            setting_key VARCHAR(50) UNIQUE NOT NULL,
            setting_value VARCHAR(255),
            updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
        )");

        // 2. Verificación rápida de Versión
        $stmt = $pdo->prepare("SELECT setting_value FROM system_settings WHERE setting_key = 'db_version'");
        $stmt->execute();
        $dbVersion = $stmt->fetchColumn();

        // Si la versión es correcta (y existe el registro), saltar el escaneo por rendimiento
        if ($dbVersion && defined('APP_VERSION') && $dbVersion === APP_VERSION) {
            return;
        }

        // 3. Escaneo de archivos de migración
        $migrationsDir = __DIR__ . '/../database/migrations/';
        if (!is_dir($migrationsDir)) {
            mkdir($migrationsDir, 0777, true);
        }

        $files = scandir($migrationsDir);
        $migrationFiles = array_filter($files, function($file) {
            return pathinfo($file, PATHINFO_EXTENSION) === 'sql' || pathinfo($file, PATHINFO_EXTENSION) === 'php';
        });

        sort($migrationFiles);

        $stmt = $pdo->query("SELECT migration FROM migrations");
        $executed = $stmt->fetchAll(PDO::FETCH_COLUMN);

        $anyExecuted = false;
        foreach ($migrationFiles as $file) {
            if (!in_array($file, $executed)) {
                $ext = pathinfo($file, PATHINFO_EXTENSION);
                $filePath = $migrationsDir . $file;

                try {
                    if ($ext === 'sql') {
                        $sql = file_get_contents($filePath);
                        if (!empty(trim($sql))) {
                            $pdo->exec($sql);
                        }
                    } elseif ($ext === 'php') {
                        require_once $filePath;
                    }
                    
                    $insert = $pdo->prepare("INSERT INTO migrations (migration) VALUES (?)");
                    $insert->execute([$file]);
                    $anyExecuted = true;
                } catch (Exception $e) {
                    error_log("Error running migration $file : " . $e->getMessage());
                    // Puedes decidir si detener todo o seguir
                }
            }
        }

        // 4. Actualizar versión en la DB si cambió algo o no estaba iniciada
        if ($anyExecuted || ($dbVersion !== APP_VERSION)) {
            $pdo->prepare("INSERT INTO system_settings (setting_key, setting_value) 
                           VALUES ('db_version', ?) 
                           ON DUPLICATE KEY UPDATE setting_value = ?")
                ->execute([APP_VERSION, APP_VERSION]);
        }
    }
}
