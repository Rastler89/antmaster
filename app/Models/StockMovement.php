<?php
require_once '../core/Model.php';

class StockMovement extends Model {
    protected static $table = 'stock_movimientos';

    public static function forStock($stockId) {
        $stmt = static::db()->prepare("SELECT * FROM " . static::$table . " WHERE stock_id = ? ORDER BY fecha_registro DESC");
        $stmt->execute([$stockId]);
        return $stmt->fetchAll();
    }
}
