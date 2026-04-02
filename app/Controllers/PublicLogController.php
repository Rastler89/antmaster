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

        $data = [
            'colony'  => $colony,
            'history' => $history,
            'diary'   => $visibleDiary,
            'title'   => 'Log de ' . $colony['nombre'] . ' (' . $colony['usuario_nombre'] . ') | AntMaster Pro'
        ];
        
        $this->view('colony/public_show', $data);
    }
}
