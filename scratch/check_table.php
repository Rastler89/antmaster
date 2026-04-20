<?php
require_once 'app/Config/Database.php';
require_once 'core/Database.php';

$db = Database::getConnection();
try {
    $stmt = $db->query("DESCRIBE revisiones_especies");
    $columns = $stmt->fetchAll(PDO::FETCH_ASSOC);
    echo json_encode($columns, JSON_PRETTY_PRINT);
} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
}
