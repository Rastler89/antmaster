<?php
require_once 'config.php';
require_once 'core/Database.php';
$pdo = Database::getConnection();
$stmt = $pdo->query("SHOW COLUMNS FROM colonias");
$columns = $stmt->fetchAll(PDO::FETCH_ASSOC);
foreach($columns as $c) {
    echo $c['Field'] . "\n";
}
