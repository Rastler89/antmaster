-- Revisiones de Fichas (Wiki features)
CREATE TABLE IF NOT EXISTS revisiones_especies (
    id INT AUTO_INCREMENT PRIMARY KEY,
    usuario_id INT NOT NULL,
    especie_id INT NULL,
    cambios_solicitados JSON NOT NULL,
    estado ENUM('pendiente', 'aprobada', 'rechazada') DEFAULT 'pendiente',
    motivo_rechazo TEXT DEFAULT NULL,
    fecha_creacion TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (usuario_id) REFERENCES usuarios(id) ON DELETE CASCADE,
    FOREIGN KEY (especie_id) REFERENCES especies(id) ON DELETE CASCADE
);
