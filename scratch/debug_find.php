<?php
require_once 'config.php';
require_once 'app/Models/Species.php';
require_once 'core/Database.php';

try {
    $species = Species::find(1);
    echo "KEYS FOUND: " . implode(', ', array_keys($species)) . "\n";
    echo "DATA: " . json_encode($species, JSON_PRETTY_PRINT) . "\n";
} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
}
