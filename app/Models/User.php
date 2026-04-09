<?php
require_once '../core/Model.php';

class User extends Model {
    protected static $table = 'usuarios';

    /**
     * Obtiene el rango del usuario basado en su XP
     */
    public function getRank() {
        require_once '../app/Helpers/GamificationHelper.php';
        $xp = $this->attributes['xp'] ?? 0;
        $role = strtolower($this->attributes['rol'] ?? '');
        return GamificationHelper::getRank($xp, $role === 'admin');
    }

    /**
     * Busca un usuario por su slug (URL de perfil)
     */
    public static function findBySlug($slug) {
        $db = Database::getConnection();
        $stmt = $db->prepare("SELECT * FROM usuarios WHERE slug = ? AND is_public = 1");
        $stmt->execute([$slug]);
        $data = $stmt->fetch();
        return $data ? new self($data) : null;
    }
}
