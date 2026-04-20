<?php
require_once '../core/Model.php';

class SpeciesRevision extends Model {
    protected static $table = 'revisiones_especies';

    public static function getPendingWithDetails() {
        return self::query("
            SELECT r.*, e.nombre as especie_nombre, u.nombre as usuario_nombre 
            FROM revisiones_especies r 
            LEFT JOIN especies e ON r.especie_id = e.id 
            JOIN usuarios u ON r.usuario_id = u.id 
            WHERE r.estado = 'pendiente'
            ORDER BY r.fecha_creacion ASC
        ");
    }

    public static function getHistoryWithDetails() {
        return self::query("
            SELECT r.*, e.nombre as especie_nombre, u.nombre as usuario_nombre 
            FROM revisiones_especies r 
            LEFT JOIN especies e ON r.especie_id = e.id 
            JOIN usuarios u ON r.usuario_id = u.id 
            WHERE r.estado != 'pendiente'
            ORDER BY r.fecha_creacion DESC
        ");
    }

    /**
     * Enriquecer las revisiones con los datos actuales de la especie para comparar
     */
    public static function enrichWithOriginalData(&$revisiones) {
        foreach ($revisiones as &$rev) {
            if ($rev['especie_id']) {
                $species = Species::find($rev['especie_id']);
                if ($species) {
                    $cambios = json_decode($rev['cambios_solicitados'], true);
                    $original = [];
                    foreach ($cambios as $key => $val) {
                        $original[$key] = $species[$key] ?? null;
                    }
                    $rev['datos_originales'] = $original;
                }
            }
        }
    }
}
