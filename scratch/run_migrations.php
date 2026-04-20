<?php
require_once 'config.php';
require_once 'core/Database.php';
require_once 'core/Migrator.php';

try {
    Migrator::run();
    echo "Migrations executed successfully.\n";
} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
