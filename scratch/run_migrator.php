<?php
require_once 'config.php';
require_once 'core/Database.php';
require_once 'core/Migrator.php';

try {
    echo "Running migrations...\n";
    Migrator::run(true);
    echo "Done!\n";
} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
