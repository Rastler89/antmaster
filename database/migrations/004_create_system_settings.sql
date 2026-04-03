-- Migración para crear la tabla de ajustes del sistema y control de versiones
-- Esta tabla permitirá rastrear la versión actual de la base de datos de manera eficiente.

CREATE TABLE IF NOT EXISTS system_settings (
    id INT AUTO_INCREMENT PRIMARY KEY,
    setting_key VARCHAR(50) UNIQUE NOT NULL,
    setting_value VARCHAR(255),
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- Insertar versión inicial (asumiendo que las 3 anteriores ya se ejecutaron o se están ejecutando)
INSERT IGNORE INTO system_settings (setting_key, setting_value) VALUES ('db_version', '1.0.0');
