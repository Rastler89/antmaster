<?php
require_once 'config.php';
try {
    $stmt = $pdo->query("DESCRIBE especies");
    $columns = $stmt->fetchAll(PDO::FETCH_ASSOC);
    echo json_encode($columns, JSON_PRETTY_PRINT);
} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
}
