<?php
require_once 'config.php';
require_once 'core/Database.php';

try {
    $pdo = Database::getConnection();

    $translations = [
        ['name' => 'Hormiga de Jardín', 'translations' => [
            'es' => ['nombre' => 'Hormiga de Jardín', 'desc' => 'La clásica hormiga negra de jardín. Muy activa y fácil de criar.', 'diet' => 'Líquidos dulces e insectos pequeños.', 'tips' => 'Niveles de humedad medios. Muy resistentes.'],
            'en' => ['nombre' => 'Black Garden Ant', 'desc' => 'The classic black garden ant. Very active and easy to breed.', 'diet' => 'Sweet liquids and small insects.', 'tips' => 'Medium humidity levels. Very hardy.'],
            'fr' => ['nombre' => 'Fourmi Noire des Jardins', 'desc' => 'La fourmi noire classique des jardins. Très active et facile à élever.', 'diet' => 'Liquides sucrés et petits insectes.', 'tips' => 'Niveaux d\'humidité moyens. Très résistante.']
        ]],
        ['name' => 'Hormiga Gigante', 'translations' => [
            'es' => ['nombre' => 'Hormiga Gigante', 'desc' => 'Una de las especies más grandes de Europa. Impresionante tamaño y comportamiento.', 'diet' => 'Líquidos dulces, fruta e insectos.', 'tips' => 'Humedad baja. Necesitan espacio debido a su tamaño.'],
            'en' => ['nombre' => 'Giant Ant', 'desc' => 'One of the largest species in Europe. Impressive size and behavior.', 'diet' => 'Sweet liquids, fruit and insects.', 'tips' => 'Low humidity. They need space due to their size.'],
            'fr' => ['nombre' => 'Fourmi Géante', 'desc' => 'L\'une des plus grandes espèces d\'Europe. Taille et comportement impressionnants.', 'diet' => 'Liquides sucrés, fruits et insectes.', 'tips' => 'Humidité faible. Nécessitent de l\'espace en raison de leur taille.']
        ]],
        ['name' => 'Temnothorax unisfasciatus', 'translations' => [
            'es' => ['nombre' => 'Temnothorax', 'desc' => 'Hormigas minúsculas que suelen habitar en bellotas o grietas. Ideales para espacios pequeños.', 'diet' => 'Pequeños insectos y gotas de miel/agua.', 'tips' => 'Bajos requisitos, muy adaptables.'],
            'en' => ['nombre' => 'Acorn Ant', 'desc' => 'Tiny ants that usually inhabit acorns or crevices. Ideal for small spaces.', 'diet' => 'Small insects and honey/water droplets.', 'tips' => 'Low requirements, very adaptable.'],
            'fr' => ['nombre' => 'Fourmi des Glands', 'desc' => 'Fourmis minuscules qui habitent généralement dans les glands ou les crevasses. Idéales pour les petits espaces.', 'diet' => 'Petits insectes et gouttelettes de miel/eau.', 'tips' => 'Faibles exigences, très adaptable.']
        ]]
    ];

    foreach ($translations as $item) {
        $stmt = $pdo->prepare("SELECT id FROM especies WHERE nombre = ?");
        $stmt->execute([$item['name']]);
        $row = $stmt->fetch();
        
        if ($row) {
            $species_id = $row['id'];
            foreach ($item['translations'] as $lang => $data) {
                $stmt_tr = $pdo->prepare("REPLACE INTO especies_traducciones (especie_id, idioma, nombre, descripcion, alimentacion, consejos_cria) VALUES (?, ?, ?, ?, ?, ?)");
                $stmt_tr->execute([
                    $species_id,
                    $lang,
                    $data['nombre'],
                    $data['desc'],
                    $data['diet'],
                    $data['tips']
                ]);
                echo "Updated ($lang) for species $species_id ({$item['name']})\n";
            }
        } else {
            echo "Species not found: {$item['name']}\n";
        }
    }

} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
}
