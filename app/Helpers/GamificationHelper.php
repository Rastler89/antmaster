<?php

class GamificationHelper {
    
    /**
     * Define los rangos por XP
     */
    public static function getRank($xp, $isAdmin = false) {
        if ($isAdmin) return 'Fundador del Hormiguero';
        
        if ($xp < 101) return 'Huevo';
        if ($xp < 251) return 'Larva';
        if ($xp < 501) return 'Pupa';
        if ($xp < 1001) return 'Forrajeadora Novata';
        if ($xp < 2501) return 'Forrajeadora Veterana';
        if ($xp < 5001) return 'Exploradora';
        if ($xp < 10001) return 'Soldado';
        if ($xp < 20001) return 'Mayor (Super-Soldado)';
        if ($xp < 50001) return 'Sub-Reina';
        return 'Reina Madre';
    }

    /**
     * Calcula el XP total de un usuario basado en sus registros actuales
     */
    public static function calculateTotalXP($userId) {
        $db = Database::getConnection();
        
        // 1. XP por colonias (+50)
        $stmt = $db->prepare("SELECT COUNT(*) FROM colonias WHERE usuario_id = ?");
        $stmt->execute([$userId]);
        $xpColonias = $stmt->fetchColumn() * 50;
        
        // 2. XP por diarios (+10)
        $stmt = $db->prepare("SELECT COUNT(d.id) FROM diario d JOIN colonias c ON d.colonia_id = c.id WHERE c.usuario_id = ?");
        $stmt->execute([$userId]);
        $xpDiarios = $stmt->fetchColumn() * 10;
        
        // 3. XP por fichas aprobadas (+250)
        $stmt = $db->prepare("SELECT COUNT(*) FROM revisiones_especies WHERE usuario_id = ? AND estado = 'aprobada'");
        $stmt->execute([$userId]);
        $xpFichas = $stmt->fetchColumn() * 250;
        
        // 4. XP por items de stock (+5)
        $stmt = $db->prepare("SELECT COUNT(*) FROM stock_alimento WHERE usuario_id = ?");
        $stmt->execute([$userId]);
        $xpStock = $stmt->fetchColumn() * 5;

        return (int)($xpColonias + $xpDiarios + $xpFichas + $xpStock);
    }

    /**
     * Verifica y otorga medallas pendientes
     */
    public static function checkAndAwardBadges($userId) {
        $db = Database::getConnection();
        
        // Obtener estadísticas actuales
        $counts = [
            'diarios' => self::getCount($db, "SELECT COUNT(d.id) FROM diario d JOIN colonias c ON d.colonia_id = c.id WHERE c.usuario_id = ?", $userId),
            'colonias' => self::getCount($db, "SELECT COUNT(*) FROM colonias WHERE usuario_id = ?", $userId),
            'fichas' => self::getCount($db, "SELECT COUNT(*) FROM revisiones_especies WHERE usuario_id = ? AND estado = 'aprobada'", $userId),
            'stock' => self::getCount($db, "SELECT COUNT(*) FROM stock_alimento WHERE usuario_id = ?", $userId)
        ];

        // Obtener logros que el usuario aún no tiene
        $stmt = $db->prepare("
            SELECT * FROM logros 
            WHERE id NOT IN (SELECT logro_id FROM logros_usuarios WHERE usuario_id = ?)
        ");
        $stmt->execute([$userId]);
        $availableBadges = $stmt->fetchAll();

        $awarded = 0;
        foreach ($availableBadges as $badge) {
            $type = $badge['requisito_tipo'];
            $value = $badge['requisito_valor'];
            
            if (isset($counts[$type]) && $counts[$type] >= $value) {
                $ins = $db->prepare("INSERT IGNORE INTO logros_usuarios (usuario_id, logro_id) VALUES (?, ?)");
                if ($ins->execute([$userId, $badge['id']])) {
                    $awarded++;
                }
            }
        }
        
        return $awarded;
    }

    private static function getCount($db, $sql, $id) {
        $stmt = $db->prepare($sql);
        $stmt->execute([$id]);
        return (int)$stmt->fetchColumn();
    }

    /**
     * Suma XP a un usuario específico
     */
    public static function addXP($userId, $amount) {
        $db = Database::getConnection();
        $stmt = $db->prepare("UPDATE usuarios SET xp = xp + ? WHERE id = ?");
        return $stmt->execute([$amount, $userId]);
    }
}
