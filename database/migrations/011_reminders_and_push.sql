-- Migración 011: Sistema de Recordatorios y Web Push Notifications

-- 1. Tabla de Recordatorios
CREATE TABLE IF NOT EXISTS recordatorios (
    id INT AUTO_INCREMENT PRIMARY KEY,
    usuario_id INT NOT NULL,
    colonia_id INT NULL,
    titulo VARCHAR(255) NOT NULL,
    descripcion TEXT NULL,
    clase ENUM('humedad', 'limpieza', 'antifugas', 'hibernacion', 'alimentacion', 'otros') DEFAULT 'otros',
    frecuencia ENUM('unica', 'diaria', 'semanal', 'quincenal', 'mensual') DEFAULT 'unica',
    fecha_proxima DATE NOT NULL,
    completado TINYINT(1) DEFAULT 0,
    fecha_ultima_vez DATE NULL,
    fecha_creacion TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (usuario_id) REFERENCES usuarios(id) ON DELETE CASCADE,
    FOREIGN KEY (colonia_id) REFERENCES colonias(id) ON DELETE CASCADE,
    INDEX (fecha_proxima),
    INDEX (completado)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 2. Tabla de Suscripciones Push
CREATE TABLE IF NOT EXISTS user_push_subscriptions (
    id INT AUTO_INCREMENT PRIMARY KEY,
    usuario_id INT NOT NULL,
    endpoint TEXT NOT NULL,
    p256dh VARCHAR(255) NOT NULL,
    auth VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (usuario_id) REFERENCES usuarios(id) ON DELETE CASCADE,
    UNIQUE(usuario_id, endpoint(255))
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
