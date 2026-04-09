<?php
require_once '../app/Models/Colony.php';
require_once '../app/Models/Species.php';
require_once '../app/Models/Stock.php';
require_once '../app/Helpers/ImageHelper.php';

class ApiController extends Controller {
    
    /**
     * Devuelve todos los datos del usuario para sincronización inicial
     */
    public function data() {
        if (!is_logged_in()) {
            return $this->json(['error' => 'Unauthorized'], 401);
        }

        $userId = $_SESSION['user_id'];
        
        $colonies = Colony::getUserColonies($userId);
        $species = Species::all();
        $stocks = Stock::where('usuario_id', '=', $userId);
        
        // Para cada colonia, obtener su diario e historial
        foreach ($colonies as &$colony) {
            $colony['diary'] = Colony::getDiary($colony['id']);
            $colony['history'] = Colony::getHistory($colony['id']);
        }

        return $this->json([
            'user_id' => $userId,
            'colonies' => $colonies,
            'species' => $species,
            'stocks' => $stocks,
            'server_time' => date('Y-m-d H:i:s')
        ]);
    }

    /**
     * Procesa una cola de acciones offline
     */
    public function sync() {
        if (!is_logged_in()) {
            return $this->json(['error' => 'Unauthorized'], 401);
        }

        $input = json_decode(file_get_contents('php://input'), true);
        $actions = $input['actions'] ?? [];
        $results = [];

        foreach ($actions as $action) {
            $type = $action['type'] ?? '';
            $payload = $action['payload'] ?? [];
            $timestamp = $action['timestamp'] ?? null;
            
            $res = ['id' => $action['id'] ?? null, 'success' => false];

            try {
                switch ($type) {
                    case 'ADD_DIARY':
                        $colonyId = $payload['colony_id'];
                        // Verificar propiedad
                        $colony = Colony::find($colonyId);
                        if ($colony && ($colony['usuario_id'] == $_SESSION['user_id'] || is_admin())) {
                            // Manejar imagen si viene en base64 o similar (por ahora solo texto)
                            $data = [
                                'tipo_evento' => $payload['tipo_evento'],
                                'entrada' => $payload['entrada'],
                                'fecha_entrada' => $payload['fecha_entrada'],
                                'stock_id' => $payload['stock_id'] ?? null,
                                'cantidad_usada' => $payload['cantidad_usada'] ?? null,
                                'imagen_url' => $payload['imagen_url'] ?? null // Si ya se subió
                            ];
                            if (Colony::addDiaryEntry($colonyId, $data)) {
                                $res['success'] = true;
                            }
                        }
                        break;

                    case 'UPDATE_POPULATION':
                        $colonyId = $payload['colony_id'];
                        $colony = Colony::find($colonyId);
                        if ($colony && ($colony['usuario_id'] == $_SESSION['user_id'] || is_admin())) {
                            $total = (int)$payload['poblacion'];
                            $detalles = $payload['detalles_json'] ?? null;
                            
                            Colony::addHistory($colonyId, $total, $detalles);
                            Colony::update($colonyId, [
                                'poblacion_actual' => $total,
                                'poblacion_detallada' => $detalles
                            ]);
                            $res['success'] = true;
                        }
                        break;
                    
                    case 'UPDATE_STOCK':
                        $stockId = $payload['stock_id'];
                        $stock = Stock::whereOne('id', '=', $stockId);
                        if ($stock && ($stock['usuario_id'] == $_SESSION['user_id'] || is_admin())) {
                            Stock::update($stockId, ['cantidad' => $payload['cantidad']]);
                            $res['success'] = true;
                        }
                        break;
                }
            } catch (Exception $e) {
                $res['error'] = $e->getMessage();
            }
            
            $results[] = $res;
        }

        return $this->json(['results' => $results]);
    }

    /**
     * Helper para devolver JSON con código de estado
     */
    protected function json($data, $code = 200) {
        http_response_code($code);
        header('Content-Type: application/json');
        echo json_encode($data);
        exit();
    }
}
