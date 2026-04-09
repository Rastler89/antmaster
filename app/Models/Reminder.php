<?php
require_once '../core/Model.php';

class Reminder extends Model {
    protected static $table = 'recordatorios';

    public static function forColony($colonyId) {
        $stmt = static::db()->prepare("SELECT * FROM " . static::$table . " WHERE colonia_id = ? AND completado = 0 ORDER BY fecha_proxima ASC");
        $stmt->execute([$colonyId]);
        return $stmt->fetchAll();
    }

    public static function getPendingForUser($userId) {
        $stmt = static::db()->prepare("SELECT r.*, c.nombre as colonia_nombre 
                                     FROM " . static::$table . " r 
                                     LEFT JOIN colonias c ON r.colonia_id = c.id 
                                     WHERE r.usuario_id = ? AND r.completado = 0 AND r.fecha_proxima <= CURRENT_DATE 
                                     ORDER BY r.fecha_proxima ASC");
        $stmt->execute([$userId]);
        return $stmt->fetchAll();
    }

    public static function complete($id) {
        $reminder = self::find($id);
        if (!$reminder) return false;

        if ($reminder['frecuencia'] === 'unica') {
            return self::update($id, ['completado' => 1, 'fecha_ultima_vez' => date('Y-m-d')]);
        }

        // Recurrente: Calcular proxima fecha
        $nextDate = self::calculateNextDate($reminder['fecha_proxima'], $reminder['frecuencia']);
        return self::update($id, [
            'fecha_proxima' => $nextDate,
            'fecha_ultima_vez' => date('Y-m-d')
        ]);
    }

    private static function calculateNextDate($currentDate, $frequency) {
        $date = new DateTime($currentDate);
        switch ($frequency) {
            case 'diaria':    $date->modify('+1 day'); break;
            case 'semanal':   $date->modify('+1 week'); break;
            case 'quincenal': $date->modify('+2 weeks'); break;
            case 'mensual':   $date->modify('+1 month'); break;
        }
        return $date->format('Y-m-d');
    }
}
