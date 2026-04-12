<?php
require_once '../app/Models/Stock.php';

class StockController extends Controller {
    public function index() {
        require_login();
        
        $data = [
            'stocks'  => Stock::where('usuario_id', '=', $_SESSION['user_id']),
            'title'   => 'Gestión de Stock | AntMaster Pro',
            'success' => $_SESSION['success'] ?? '',
            'error'   => $_SESSION['error'] ?? ''
        ];
        
        unset($_SESSION['success'], $_SESSION['error']);
        
        $this->view('stock/index', $data);
    }
    
    public function store() {
        require_login();
        
        $data = [
            'usuario_id' => $_SESSION['user_id'],
            'nombre'     => $_POST['nombre'] ?? '',
            'categoria'  => $_POST['categoria'] ?? 'Otros',
            'cantidad'   => $_POST['cantidad'] ?? 0,
            'unidad'     => $_POST['unidad'] ?? '',
            'punto_pedido' => $_POST['punto_pedido'] ?? 10.00,
            'fecha_caducidad' => $_POST['fecha_caducidad'] ?: null,
            'notas'      => $_POST['notas'] ?? ''
        ];
        
        if (Stock::create($data)) {
            $stockId = Database::getConnection()->lastInsertId();
            // Registrar movimiento inicial
            require_once '../app/Models/StockMovement.php';
            StockMovement::create([
                'stock_id'   => $stockId,
                'usuario_id' => $_SESSION['user_id'],
                'tipo'       => 'ENTRADA',
                'cantidad'   => $data['cantidad'],
                'motivo'     => 'Carga inicial de inventario'
            ]);

            // Gamificación: +5 XP
            require_once '../app/Helpers/GamificationHelper.php';
            GamificationHelper::addXP($_SESSION['user_id'], 5);
            GamificationHelper::checkAndAwardBadges($_SESSION['user_id']);

            $_SESSION['success'] = 'Stock añadido correctamente.';
        } else {
            $_SESSION['error'] = 'Error al guardar el stock.';
        }
        
        $this->redirect('/stock');
    }

    public function adjust($id) {
        require_login();
        
        $stock = Stock::whereOne('id', '=', $id);
        if (!$stock || $stock['usuario_id'] != $_SESSION['user_id']) {
            $_SESSION['error'] = 'No tienes permiso.';
            $this->redirect('/stock');
        }

        $tipo = $_POST['tipo']; // ENTRADA / SALIDA
        $cantidad = (float)$_POST['cantidad'];
        $motivo = $_POST['motivo'] ?: 'Ajuste manual';

        if (Stock::addMovement($id, $tipo, $cantidad, $motivo)) {
            $_SESSION['success'] = 'Stock actualizado con éxito.';
        } else {
            $_SESSION['error'] = 'Error al actualizar el stock.';
        }

        $this->redirect('/stock');
    }

    public function history($id) {
        require_login();
        $stock = Stock::find($id);
        if (!$stock || ($stock['usuario_id'] != $_SESSION['user_id'] && !is_admin())) {
            return $this->json(['error' => 'No encontrado'], 404);
        }

        $history = Stock::getHistory($id);
        return $this->json($history);
    }
    
    // Convertiremos a DESTROY para usar _method=DELETE
    public function destroy($id) {
        require_login();
        
        $stock = Stock::whereOne('id', '=', $id);
        
        if ($stock && $stock['usuario_id'] == $_SESSION['user_id']) {
            if (Stock::delete($id)) {
                $_SESSION['success'] = 'Stock eliminado correctamente.';
            } else {
                $_SESSION['error'] = 'Error al eliminar.';
            }
        } else {
            $_SESSION['error'] = 'No tienes permiso o el stock no existe.';
        }
        
        $this->redirect('/stock');
    }
}
