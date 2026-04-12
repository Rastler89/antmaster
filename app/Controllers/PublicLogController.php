<?php
require_once '../app/Models/Colony.php';

class PublicLogController extends Controller {
    public function show($user, $colony) {
        $result = Colony::findBySlug($user, $colony);
        
        if (!$result) {
            http_response_code(404);
            $this->view('errors/404', ['title' => 'Log No Encontrado']);
            return;
        }

        $colony = $result[0];
        $id = $colony['id'];
        
        // Historial completo
        $history = Colony::getHistory($id);
        
        // Diario Filtrado (Solo visibles)
        $diary = Colony::getDiary($id);
        $visibleDiary = array_filter($diary, function($entry) {
            return (int)$entry['is_visible'] === 1;
        });

        $title = 'Log de ' . $colony['nombre'] . ' de ' . $colony['usuario_nombre'] . ' | AntMaster Pro';
        $desc = "Sigue la evolución de la colonia de " . ($colony['especie_nombre'] ?? 'hormigas') . " de " . $colony['usuario_nombre'] . ". " . count($visibleDiary) . " entradas en el diario. Población: " . $colony['poblacion_actual'] . " hormigas.";

        $json_ld = json_encode([
            "@context" => "https://schema.org",
            "@type" => "Dataset",
            "name" => "Log de Colonia: " . $colony['nombre'],
            "description" => "Registro público de observaciones y crecimiento de colonia de " . ($colony['especie_nombre'] ?? 'hormigas') . ".",
            "creator" => [
                "@type" => "Person",
                "name" => $colony['usuario_nombre']
            ],
            "publisher" => [
                "@type" => "Organization",
                "name" => "AntMaster Pro"
            ]
        ], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);

        $og_image_url = null;
        if (!empty($colony['imagen_portada'])) {
            $og_image_url = rtrim(BASE_URL, '/') . asset($colony['imagen_portada']);
        }

        $data = [
            'colony'  => $colony,
            'history' => $history,
            'diary'   => $visibleDiary,
            'title'   => $title,
            'description' => $desc,
            'og_type' => 'article',
            'og_image' => $og_image_url,
            'json_ld' => $json_ld
        ];
        
        $this->view('colony/public_show', $data);
    }
}
