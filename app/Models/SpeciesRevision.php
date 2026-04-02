<?php
require_once '../core/Model.php';

class SpeciesRevision extends Model {
    protected static $table = 'revisiones_especies';

    public static function getPendingWithDetails() {
        return self::query("
            SELECT r.*, e.nombre as especie_nombre, u.nombre as usuario_nombre 
            FROM revisiones_especies r 
            JOIN especies e ON r.especie_id = e.id 
            JOIN usuarios u ON r.usuario_id = u.id 
            WHERE r.estado = 'pendiente'
            ORDER BY r.fecha_creacion ASC
        ");
    }
}
