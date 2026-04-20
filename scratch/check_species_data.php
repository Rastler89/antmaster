<?php
require_once 'config.php';
try {
    $stmt = $pdo->query("SELECT * FROM especies LIMIT 5");
    $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
    echo json_encode($data, JSON_PRETTY_PRINT);
} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
}
