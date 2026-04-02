-- Añadir columnas para el panel de administración
ALTER TABLE usuarios ADD COLUMN IF NOT EXISTS last_login TIMESTAMP NULL DEFAULT NULL AFTER rol;
ALTER TABLE usuarios ADD COLUMN IF NOT EXISTS is_banned TINYINT(1) DEFAULT 0 AFTER `last_login`;
