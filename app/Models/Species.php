<?php
require_once '../core/Model.php';

class Species extends Model {
    protected static $table = 'especies';

    /**
     * Obtener todas las especies con su traducción correspondiente
     */
    public static function all() {
        $lang = defined('APP_LANG') ? APP_LANG : 'es';
        
        $sql = "SELECT e.*, 
                       COALESCE(t.nombre, e.nombre) as nombre,
                       COALESCE(t.descripcion, e.descripcion) as descripcion,
                       COALESCE(t.alimentacion, e.alimentacion) as alimentacion,
                       COALESCE(t.consejos_cria, e.consejos_cria) as consejos_cria,
                       COALESCE(t.localizacion, e.localizacion) as localizacion
                FROM especies e
                LEFT JOIN especies_traducciones t ON e.id = t.especie_id AND t.idioma = ?
                ORDER BY e.nombre_cientifico ASC";
        
        $stmt = static::db()->prepare($sql);
        $stmt->execute([$lang]);
        return $stmt->fetchAll();
    }

    /**
     * Encontrar una especie por ID con su traducción
     */
    public static function find($id) {
        $lang = defined('APP_LANG') ? APP_LANG : 'es';
        
        $sql = "SELECT e.*, 
                       COALESCE(t.nombre, e.nombre) as nombre,
                       COALESCE(t.descripcion, e.descripcion) as descripcion,
                       COALESCE(t.alimentacion, e.alimentacion) as alimentacion,
                       COALESCE(t.consejos_cria, e.consejos_cria) as consejos_cria,
                       COALESCE(t.localizacion, e.localizacion) as localizacion
                FROM especies e
                LEFT JOIN especies_traducciones t ON e.id = t.especie_id AND t.idioma = ?
                WHERE e.id = ?";
        
        $stmt = static::db()->prepare($sql);
        $stmt->execute([$lang, $id]);
        return $stmt->fetch();
    }

    /**
     * Obtener todas las especies junto con una lista de las traducciones disponibles
     */
    public static function allWithTranslationStats() {
        $sql = "SELECT e.id, e.nombre_cientifico, e.nombre as nombre_es,
                       GROUP_CONCAT(t.idioma) as idiomas_traducidos
                FROM especies e
                LEFT JOIN especies_traducciones t ON e.id = t.especie_id
                GROUP BY e.id
                ORDER BY e.nombre_cientifico ASC";
        
        return static::db()->query($sql)->fetchAll();
    }

    /**
     * Obtener los datos de traducción para una especie e idioma específicos
     */
    public static function getTranslation($id, $lang) {
        $stmt = static::db()->prepare("SELECT * FROM especies_traducciones WHERE especie_id = ? AND idioma = ?");
        $stmt->execute([$id, $lang]);
        return $stmt->fetch();
    }

    /**
     * Crear o actualizar una traducción
     */
    public static function updateOrCreateTranslation($species_id, $lang, $data) {
        $sql = "REPLACE INTO especies_traducciones (especie_id, idioma, nombre, descripcion, alimentacion, consejos_cria, localizacion) 
                VALUES (?, ?, ?, ?, ?, ?, ?)";
        
        $stmt = static::db()->prepare($sql);
        return $stmt->execute([
            $species_id,
            $lang,
            $data['nombre'] ?? null,
            $data['descripcion'] ?? null,
            $data['alimentacion'] ?? null,
            $data['consejos_cria'] ?? null,
            $data['localizacion'] ?? null
        ]);
    }

    /**
     * Buscar especies por nombre o nombre científico
     */
    public static function search($query) {
        $lang = defined('APP_LANG') ? APP_LANG : 'es';
        $query = "%$query%";
        
        $sql = "SELECT e.*, 
                       COALESCE(t.nombre, e.nombre) as nombre
                FROM especies e
                LEFT JOIN especies_traducciones t ON e.id = t.especie_id AND t.idioma = ?
                WHERE e.nombre_cientifico LIKE ? OR e.nombre LIKE ? OR t.nombre LIKE ?
                ORDER BY e.nombre_cientifico ASC
                LIMIT 10";
        
        $stmt = static::db()->prepare($sql);
        $stmt->execute([$lang, $query, $query, $query]);
        return $stmt->fetchAll();
    }
}

