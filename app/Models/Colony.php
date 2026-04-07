<?php
require_once '../core/Model.php';

class Colony extends Model {
    protected static $table = 'colonias';

    public static function getUserColonies($userId) {
        $lang = defined('APP_LANG') ? APP_LANG : 'es';
        return self::query("
            SELECT c.*, COALESCE(t.nombre, e.nombre) as especie_nombre, e.nombre_cientifico as especie_nombre_cientifico
            FROM colonias c 
            JOIN especies e ON c.especie_id = e.id 
            LEFT JOIN especies_traducciones t ON e.id = t.especie_id AND t.idioma = ?
            WHERE c.usuario_id = ?
        ", [$lang, $userId]);
    }

    public static function findWithSpecies($id, $userId = null) {
        $lang = defined('APP_LANG') ? APP_LANG : 'es';
        
        $sql = "
            SELECT c.*, COALESCE(t.nombre, e.nombre) as especie_nombre, e.nombre_cientifico as especie_nombre_cientifico
            FROM colonias c 
            JOIN especies e ON c.especie_id = e.id 
            LEFT JOIN especies_traducciones t ON e.id = t.especie_id AND t.idioma = ?
            WHERE c.id = ?
        ";
        $params = [$lang, $id];

        if ($userId !== null) {
            $sql .= " AND c.usuario_id = ?";
            $params[] = $userId;
        }

        $result = self::query($sql, $params);
        return $result ? $result[0] : null;
    }

    public static function addHistory($colonyId, $population, $details = null) {
        return self::query("
            INSERT INTO historial_poblacion (colonia_id, poblacion, detalles_json, fecha_registro) 
            VALUES (?, ?, ?, CURRENT_TIMESTAMP)
        ", [$colonyId, $population, $details]);
    }

    public static function getHistory($colonyId) {
        return self::query("
            SELECT poblacion, detalles_json, fecha_registro 
            FROM historial_poblacion 
            WHERE colonia_id = ? 
            ORDER BY fecha_registro ASC
        ", [$colonyId]);
    }

    public static function addDiaryEntry($colonyId, $data) {
        return self::query("
            INSERT INTO diario (colonia_id, tipo_evento, stock_id, cantidad_usada, entrada, fecha_entrada, imagen_url, created_at) 
            VALUES (?, ?, ?, ?, ?, ?, ?, CURRENT_TIMESTAMP)
        ", [
            $colonyId, 
            $data['tipo_evento'] ?? 'Observación', 
            $data['stock_id'] ?? null,
            $data['cantidad_usada'] ?? null,
            $data['entrada'] ?? '', 
            $data['fecha_entrada'] ?? date('Y-m-d'), 
            $data['imagen_url'] ?? null
        ]);
    }

    public static function getDiary($colonyId) {
        return self::query("
            SELECT d.*, s.nombre as stock_nombre, s.unidad as stock_unidad 
            FROM diario d 
            LEFT JOIN stock_alimento s ON d.stock_id = s.id 
            WHERE d.colonia_id = ? 
            ORDER BY d.created_at DESC
        ", [$colonyId]);
    }

    public static function getGlobalHistory($userId, $days = 30) {
        $whereClause = ($days != 'all') ? "AND hp.fecha_registro >= DATE_SUB(NOW(), INTERVAL ? DAY)" : "";
        $params = ($days != 'all') ? [$userId, (int)$days] : [$userId];
        
        return self::query("
            SELECT hp.poblacion, hp.fecha_registro, c.nombre as colony_name
            FROM historial_poblacion hp
            JOIN colonias c ON hp.colonia_id = c.id
            WHERE c.usuario_id = ? $whereClause
            ORDER BY hp.fecha_registro ASC
        ", $params);
    }

    public static function findBySlug($userSlug, $colonySlug) {
        $lang = defined('APP_LANG') ? APP_LANG : 'es';
        return self::query("
            SELECT c.*, COALESCE(t.nombre, e.nombre) as especie_nombre, u.nombre as usuario_nombre, u.slug as usuario_slug
            FROM colonias c
            JOIN usuarios u ON c.usuario_id = u.id
            JOIN especies e ON c.especie_id = e.id
            LEFT JOIN especies_traducciones t ON e.id = t.especie_id AND t.idioma = ?
            WHERE u.slug = ? AND c.public_slug = ? AND c.is_public = 1
        ", [$lang, $userSlug, $colonySlug]);
    }

    public static function togglePublic($id, $isPublic, $slug = null) {
        $data = ['is_public' => $isPublic];
        if ($slug) $data['public_slug'] = $slug;
        return self::update($id, $data);
    }

    public static function toggleDiaryVisibility($entryId, $isVisible) {
        return self::query("UPDATE diario SET is_visible = ? WHERE id = ?", [(int)$isVisible, $entryId]);
    }

    public static function getSpeciesAverageHistory($especieId) {
        // Obtenemos los promedios de población agrupados por "días desde la adquisición"
        // para estandarizar el crecimiento de diferentes colonias.
        return self::query("
            SELECT ROUND(AVG(hp.poblacion)) as avg_poblacion, DATEDIFF(hp.fecha_registro, c.fecha_adquisicion) as days_offset
            FROM historial_poblacion hp
            JOIN colonias c ON hp.colonia_id = c.id
            WHERE c.especie_id = ?
            GROUP BY days_offset
            HAVING days_offset >= 0
            ORDER BY days_offset ASC
        ", [$especieId]);
    }

    public static function getSpeciesDistribution($userId) {
        return self::query("
            SELECT e.nombre as especie, COUNT(c.id) as total 
            FROM colonias c
            JOIN especies e ON c.especie_id = e.id
            WHERE c.usuario_id = ?
            GROUP BY e.id
        ", [$userId]);
    }
}
