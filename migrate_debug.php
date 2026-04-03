<?php
require_once 'config.php';
require_once 'core/Database.php';
require_once 'core/Migrator.php';

echo "Running migrations from CLI...\n";
try {
    Migrator::run();
    echo "Migrations finished successfully.\n";
} catch (Exception $e) {
    echo "ERROR during migrations: " . $e->getMessage() . "\n";
}
