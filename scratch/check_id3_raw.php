<?php
require_once 'config.php';
try {
    echo "--- ESPECIES (ID 3) ---\n";
    $stmt = $pdo->prepare("SELECT * FROM especies WHERE id = 3");
    $stmt->execute();
    echo json_encode($stmt->fetch(), JSON_PRETTY_PRINT) . "\n\n";

    echo "--- TRADUCCIONES (ID 3) ---\n";
    $stmt = $pdo->prepare("SELECT * FROM especies_traducciones WHERE especie_id = 3");
    $stmt->execute();
    echo json_encode($stmt->fetchAll(), JSON_PRETTY_PRINT) . "\n";
} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
}
