<?php
require_once __DIR__ . '/../config.php';
require_once __DIR__ . '/../core/Database.php';

try {
    echo "Connecting to: " . DB_HOST . " / " . DB_NAME . "\n";
    $db = Database::getConnection();
    
    // Check if xp column exists
    echo "Checking columns in 'usuarios' table...\n";
    $stmt = $db->query("SHOW COLUMNS FROM usuarios");
    $columns = $stmt->fetchAll(PDO::FETCH_COLUMN);
    echo "Columns: " . implode(", ", $columns) . "\n";
    
    if (in_array('xp', $columns)) {
        echo "Column 'xp' already exists.\n";
    } else {
        echo "Column 'xp' is missing. Attempting to add it along with other gamification columns...\n";
        
        $sql = "
            ALTER TABLE usuarios ADD COLUMN IF NOT EXISTS slug VARCHAR(100) UNIQUE NULL AFTER nombre;
            ALTER TABLE usuarios ADD COLUMN IF NOT EXISTS bio TEXT NULL AFTER settings;
            ALTER TABLE usuarios ADD COLUMN IF NOT EXISTS profile_image VARCHAR(255) NULL AFTER bio;
            ALTER TABLE usuarios ADD COLUMN IF NOT EXISTS is_public TINYINT(1) DEFAULT 1 AFTER profile_image;
            ALTER TABLE usuarios ADD COLUMN IF NOT EXISTS xp INT DEFAULT 0 AFTER is_public;
        ";
        
        // Split and execute each statement
        $statements = array_filter(array_map('trim', explode(';', $sql)));
        foreach ($statements as $stmt) {
            try {
                $db->exec($stmt);
                echo "Executed: " . substr($stmt, 0, 50) . "...\n";
            } catch (Exception $e) {
                echo "Error executing statement: " . $e->getMessage() . "\n";
            }
        }
        
        echo "Migration applied.\n";
    }
    
    // Also check if 'logros' and 'logros_usuarios' tables exist
    $tables = $db->query("SHOW TABLES LIKE 'logros'")->fetch();
    if (!$tables) {
        echo "Table 'logros' is missing. You should run the full migration 012.\n";
    }

} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
