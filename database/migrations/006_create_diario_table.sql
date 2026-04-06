-- Diario de la Colonia
CREATE TABLE IF NOT EXISTS diario (
    id INT AUTO_INCREMENT PRIMARY KEY,
    colonia_id INT NOT NULL,
    tipo_evento VARCHAR(50) DEFAULT 'Observación',
    stock_id INT NULL,
    cantidad_usada DECIMAL(10,2) NULL,
    entrada TEXT NOT NULL,
    fecha_entrada DATE NOT NULL,
    imagen_url VARCHAR(255),
    is_visible TINYINT(1) DEFAULT 1,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (colonia_id) REFERENCES colonias(id) ON DELETE CASCADE,
    FOREIGN KEY (stock_id) REFERENCES stock_alimento(id) ON DELETE SET NULL
);
