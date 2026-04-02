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
            'unidad'     => $_POST['unidad'] ?? ''
        ];
        
        if (Stock::create($data)) {
            $_SESSION['success'] = 'Stock añadido correctamente.';
        } else {
            $_SESSION['error'] = 'Error al guardar el stock.';
        }
        
        $this->redirect('/stock');
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
