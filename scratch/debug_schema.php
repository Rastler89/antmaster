<?php
require_once __DIR__ . '/../config.php';
require_once __DIR__ . '/../core/Database.php';

try {
    $db = Database::getConnection();
    echo "Host: " . DB_HOST . "\n";
    echo "DB: " . DB_NAME . "\n";
    
    $tables = $db->query("SHOW TABLES")->fetchAll(PDO::FETCH_COLUMN);
    echo "Tables: " . implode(", ", $tables) . "\n";
    
    foreach ($tables as $table) {
        if (strtolower($table) === 'usuarios') {
            echo "Columns in $table:\n";
            $columns = $db->query("SHOW COLUMNS FROM $table")->fetchAll();
            foreach ($columns as $col) {
                echo " - " . $col['Field'] . " (" . $col['Type'] . ")\n";
            }
        }
    }

} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
