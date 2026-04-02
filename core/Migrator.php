<?php

class Migrator {
    public static function run() {
        $pdo = Database::getConnection();

        // Asegurar que la tabla migrations existe
        $pdo->exec("CREATE TABLE IF NOT EXISTS migrations (
            id INT AUTO_INCREMENT PRIMARY KEY,
            migration VARCHAR(255) NOT NULL UNIQUE,
            executed_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
        )");

        $migrationsDir = __DIR__ . '/../database/migrations/';
        if (!is_dir($migrationsDir)) {
            mkdir($migrationsDir, 0777, true);
        }

        // Obtener archivos de migración
        $files = scandir($migrationsDir);
        $migrationFiles = array_filter($files, function($file) {
            return pathinfo($file, PATHINFO_EXTENSION) === 'sql' || pathinfo($file, PATHINFO_EXTENSION) === 'php';
        });

        // Ordenar asumiendo archivos tipo 001_..., 002_...
        sort($migrationFiles);

        // Obtener ejecutadas
        $stmt = $pdo->query("SELECT migration FROM migrations");
        $executed = $stmt->fetchAll(PDO::FETCH_COLUMN);

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
                    
                    // Registrar como ejecutada
                    $insert = $pdo->prepare("INSERT INTO migrations (migration) VALUES (?)");
                    $insert->execute([$file]);
                } catch (Exception $e) {
                    error_log("Error running migration $file : " . $e->getMessage());
                    // Dependiendo de si quieres que bloquee o no:
                    // die("Migration error: " . $e->getMessage());
                }
            }
        }
    }
}
