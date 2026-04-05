<?php
require_once 'config.php';
require_once 'core/Database.php';

try {
    $pdo = Database::getConnection();
    
    // Messor barbarus (ID usually 1 if it's the first one inserted)
    $species_id = 1; 

    // English Translation
    $stmt_en = $pdo->prepare("REPLACE INTO especies_traducciones (especie_id, idioma, nombre, descripcion, alimentacion, consejos_cria) VALUES (?, 'en', ?, ?, ?, ?)");
    $stmt_en->execute([
        $species_id,
        'Harvester Ant',
        'Famous for collecting seeds. Ideal for beginners due to their hardiness.',
        'Seeds, occasionally small insects.',
        'They need a dry foraging area for seeds and moisture in the nest.'
    ]);

    // French Translation
    $stmt_fr = $pdo->prepare("REPLACE INTO especies_traducciones (especie_id, idioma, nombre, descripcion, alimentacion, consejos_cria) VALUES (?, 'fr', ?, ?, ?, ?)");
    $stmt_fr->execute([
        $species_id,
        'Fourmi Moissonneuse',
        'Célèbre pour la récolte des graines. Idéale pour les débutants.',
        'Graines, parfois de petits insectes.',
        'Nécessite une zone de récolte sèche pour les graines et de l\'humidité dans le nid.'
    ]);

    echo "Traducciones de ejemplo añadidas correctamente.\n";

} catch (PDOException $e) {
    die("Error: " . $e->getMessage());
}
