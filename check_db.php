<?php
require_once 'config.php';
require_once 'core/Database.php';
require_once 'core/Migrator.php';

echo "Running Migrations...\n";
Migrator::run();

$pdo = Database::getConnection();
$tables = ['diario', 'revisiones_especies'];

foreach ($tables as $table) {
    try {
        $stmt = $pdo->query("DESCRIBE $table");
        echo "Table '$table' exists.\n";
    } catch (PDOException $e) {
        echo "Table '$table' DOES NOT exist: " . $e->getMessage() . "\n";
    }
}
