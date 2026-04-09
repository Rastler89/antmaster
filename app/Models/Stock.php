<?php
require_once '../core/Model.php';

class Stock extends Model {
    protected static $table = 'stock_alimento';

    /**
     * Añade un movimiento de stock y actualiza el balance total.
     */
    public static function addMovement($stockId, $tipo, $cantidad, $motivo, $diarioId = null) {
        $stock = self::find($stockId);
        if (!$stock) return false;

        $nuevaCantidad = $stock['cantidad'];
        if ($tipo === 'ENTRADA') {
            $nuevaCantidad += $cantidad;
        } elseif ($tipo === 'SALIDA') {
            $nuevaCantidad -= $cantidad;
        } elseif ($tipo === 'AJUSTE') {
            // En ajuste, la cantidad pasada es la nueva cantidad absoluta
            $nuevaCantidad = $cantidad;
        }

        // 1. Actualizar el stock principal
        self::update($stockId, ['cantidad' => $nuevaCantidad]);

        // 2. Registrar el movimiento
        require_once '../app/Models/StockMovement.php';
        return StockMovement::create([
            'stock_id'   => $stockId,
            'usuario_id' => $stock['usuario_id'],
            'tipo'       => $tipo,
            'cantidad'   => $cantidad,
            'motivo'     => $motivo,
            'diario_id'  => $diarioId
        ]);
    }

    public static function getHistory($stockId) {
        require_once '../app/Models/StockMovement.php';
        return StockMovement::forStock($stockId);
    }
}
