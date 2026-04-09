-- Migración 010: Sistema de Gestión de Stock Profesional

-- 1. Ampliar tabla de stock actual
ALTER TABLE stock_alimento 
ADD COLUMN punto_pedido DECIMAL(10,2) DEFAULT 10.00,
ADD COLUMN fecha_caducidad DATE NULL,
ADD COLUMN notas TEXT NULL;

-- 2. Crear tabla de movimientos/historial
CREATE TABLE IF NOT EXISTS stock_movimientos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    stock_id INT NOT NULL,
    usuario_id INT NOT NULL,
    tipo ENUM('ENTRADA', 'SALIDA', 'AJUSTE') NOT NULL,
    cantidad DECIMAL(10,2) NOT NULL,
    motivo VARCHAR(255) NOT NULL,
    diario_id INT NULL,
    fecha_registro TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (stock_id) REFERENCES stock_alimento(id) ON DELETE CASCADE,
    FOREIGN KEY (usuario_id) REFERENCES usuarios(id) ON DELETE CASCADE,
    FOREIGN KEY (diario_id) REFERENCES diario(id) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 3. Crear movimientos iniciales para el stock existente (Opcional, para coherencia)
INSERT INTO stock_movimientos (stock_id, usuario_id, tipo, cantidad, motivo)
SELECT id, usuario_id, 'ENTRADA', cantidad, 'Carga inicial de inventario'
FROM stock_alimento;
