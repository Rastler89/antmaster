<?php

class SystemInfo {
    /**
     * Obtiene el tamaño de la base de datos
     */
    public static function getDatabaseSize() {
        try {
            $db = Database::getConnection();
            $dbname = DB_NAME;
            $stmt = $db->query("SELECT SUM(data_length + index_length) / 1024 / 1024 AS size FROM information_schema.TABLES WHERE table_schema = '$dbname'");
            $result = $stmt->fetch();
            return round($result['size'] ?? 0, 2) . ' MB';
        } catch (Exception $e) {
            return 'N/A';
        }
    }

    /**
     * Obtiene información básica del servidor
     */
    public static function getServerInfo() {
        return [
            'php_version' => PHP_VERSION,
            'server_software' => $_SERVER['SERVER_SOFTWARE'] ?? 'Unknown',
            'os' => PHP_OS,
            'memory_limit' => ini_get('memory_limit'),
            'post_max_size' => ini_get('post_max_size'),
            'upload_max_filesize' => ini_get('upload_max_filesize')
        ];
    }
    
    /**
     * Obtiene estadísticas de carga (Solo en Linux)
     */
    public static function getSystemLoad() {
        if (function_exists('sys_getloadavg')) {
            $load = sys_getloadavg();
            return $load[0] . ' ' . $load[1] . ' ' . $load[2];
        }
        return 'Not available';
    }
}
