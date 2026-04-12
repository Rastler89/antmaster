<?php
require_once 'config.php';
require_once 'core/Database.php';

try {
    $pdo = Database::getConnection();
    
    // Check missing translations for species
    $sql = "SELECT e.id, e.nombre, 
            (SELECT COUNT(*) FROM especies_traducciones et WHERE et.especie_id = e.id AND et.idioma = 'en') as has_en,
            (SELECT COUNT(*) FROM especies_traducciones et WHERE et.especie_id = e.id AND et.idioma = 'fr') as has_fr,
            (SELECT COUNT(*) FROM especies_traducciones et WHERE et.especie_id = e.id AND et.idioma = 'es') as has_es
            FROM especies e";
            
    $stmt = $pdo->query($sql);
    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    echo "Species Translation Status:\n";
    echo str_pad("Species", 30) . " | ES | EN | FR |\n";
    echo str_repeat("-", 45) . "\n";
    
    foreach ($results as $row) {
        echo str_pad($row['nombre'], 30) . " | " . 
             ($row['has_es'] ? "OK" : "--") . " | " . 
             ($row['has_en'] ? "OK" : "--") . " | " . 
             ($row['has_fr'] ? "OK" : "--") . " |\n";
    }

} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
}
