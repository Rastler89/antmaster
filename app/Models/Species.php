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
}
