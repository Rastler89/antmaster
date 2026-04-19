<?php
require_once __DIR__ . '/../config.php';
require_once __DIR__ . '/../core/Database.php';
require_once __DIR__ . '/../app/Helpers/GamificationHelper.php';

try {
    echo "Attempting to add XP to user 1...\n";
    $result = GamificationHelper::addXP(1, 10);
    if ($result) {
        echo "Successfully added 10 XP to user 1.\n";
    } else {
        echo "Failed to add XP (no error, but result was false).\n";
    }
} catch (Exception $e) {
    echo "CAUGHT ERROR: " . $e->getMessage() . "\n";
}
