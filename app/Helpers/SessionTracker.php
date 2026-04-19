<?php

class SessionTracker {
    /**
     * Registra el inicio de una nueva sesión
     */
    public static function startSession($userId) {
        $db = Database::getConnection();
        $sessionId = session_id();
        $ip = $_SERVER['REMOTE_ADDR'] ?? null;
        $ua = $_SERVER['HTTP_USER_AGENT'] ?? null;

        $stmt = $db->prepare("INSERT INTO user_sessions (user_id, session_id, ip_address, user_agent) VALUES (?, ?, ?, ?)");
        $stmt->execute([$userId, $sessionId, $ip, $ua]);
        
        $_SESSION['last_activity_update'] = time();
    }

    /**
     * Actualiza el timestamp de última actividad
     */
    public static function updateActivity() {
        if (!isset($_SESSION['user_id'])) return;

        // Limitar actualizaciones a una vez por minuto para no saturar la DB
        if (isset($_SESSION['last_activity_update']) && (time() - $_SESSION['last_activity_update']) < 60) {
            return;
        }

        $db = Database::getConnection();
        $sessionId = session_id();
        $userId = $_SESSION['user_id'];
        
        $stmt = $db->prepare("UPDATE user_sessions SET last_activity_at = CURRENT_TIMESTAMP WHERE session_id = ? AND user_id = ?");
        $stmt->execute([$sessionId, $userId]);

        // Si no existe el registro de sesión actual (ej. sesión antigua), lo creamos
        if ($stmt->rowCount() === 0) {
            self::startSession($userId);
        } else {
            $_SESSION['last_activity_update'] = time();
        }
    }

    /**
     * Obtiene estadísticas de sesión para un usuario
     */
    public static function getUserStats($userId) {
        $db = Database::getConnection();
        
        // Tiempo promedio en segundos por sesión (excluyendo sesiones de menos de 10 segundos)
        // Definimos sesión como la diferencia entre login y última actividad
        $sql = "SELECT 
                    AVG(TIMESTAMPDIFF(SECOND, login_at, last_activity_at)) as avg_duration,
                    SUM(TIMESTAMPDIFF(SECOND, login_at, last_activity_at)) as total_duration,
                    COUNT(*) as total_sessions
                FROM user_sessions 
                WHERE user_id = ? AND last_activity_at > login_at";
        
        $stmt = $db->prepare($sql);
        $stmt->execute([$userId]);
        return $stmt->fetch();
    }
    
    /**
     * Formatea segundos a un formato legible (H:i:s o i:s)
     */
    public static function formatDuration($seconds) {
        if (!$seconds) return "0s";
        
        $seconds = (int)$seconds;
        
        $h = floor($seconds / 3600);
        $m = floor(($seconds % 3600) / 60);
        $s = $seconds % 60;
        
        if ($h > 0) {
            return "{$h}h {$m}m";
        }
        if ($m > 0) {
            return "{$m}m {$s}s";
        }
        return "{$s}s";
    }
}
