-- Base de datos para el Gestor de Hormigas

-- Tabla de Usuarios
CREATE TABLE IF NOT EXISTS usuarios (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(100) NOT NULL,
    slug VARCHAR(150) UNIQUE,
    email VARCHAR(150) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    rol ENUM('usuario', 'admin') DEFAULT 'usuario',
    fecha_registro TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Tabla de Especies (Fichas de Cría)
CREATE TABLE IF NOT EXISTS especies (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(100) NOT NULL,
    nombre_cientifico VARCHAR(150) UNIQUE NOT NULL,
    dificultad ENUM('Principiante', 'Intermedio', 'Experto', 'Avanzado') DEFAULT 'Principiante',
    temperatura VARCHAR(50),
    humedad VARCHAR(50),
    velocidad_crecimiento VARCHAR(100),
    tamano VARCHAR(100),
    castas VARCHAR(100),
    reproduccion VARCHAR(100),
    localizacion TEXT,
    vuelos VARCHAR(100),
    descripcion TEXT,
    alimentacion TEXT,
    consejos_cria TEXT
);

-- Revisiones de Fichas (Wiki features)
CREATE TABLE IF NOT EXISTS revisiones_especies (
    id INT AUTO_INCREMENT PRIMARY KEY,
    usuario_id INT NOT NULL,
    especie_id INT NOT NULL,
    cambios_solicitados JSON NOT NULL,
    estado ENUM('pendiente', 'aprobada', 'rechazada') DEFAULT 'pendiente',
    fecha_creacion TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (usuario_id) REFERENCES usuarios(id) ON DELETE CASCADE,
    FOREIGN KEY (especie_id) REFERENCES especies(id) ON DELETE CASCADE
);

-- Tabla de Colonias
CREATE TABLE IF NOT EXISTS colonias (
    id INT AUTO_INCREMENT PRIMARY KEY,
    usuario_id INT NOT NULL,
    especie_id INT NOT NULL,
    nombre VARCHAR(100) NOT NULL,
    descripcion TEXT,
    fecha_adquisicion DATE NOT NULL,
    tipo_hormiguero VARCHAR(100),
    poblacion_actual INT DEFAULT 0,
    is_public TINYINT(1) DEFAULT 0,
    public_slug VARCHAR(150),
    FOREIGN KEY (usuario_id) REFERENCES usuarios(id) ON DELETE CASCADE,
    FOREIGN KEY (especie_id) REFERENCES especies(id) ON DELETE CASCADE,
    UNIQUE INDEX (usuario_id, public_slug)
);

-- Historial de Población
CREATE TABLE IF NOT EXISTS historial_poblacion (
    id INT AUTO_INCREMENT PRIMARY KEY,
    colonia_id INT NOT NULL,
    poblacion INT NOT NULL,
    detalles_json JSON DEFAULT NULL,
    fecha_registro TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (colonia_id) REFERENCES colonias(id) ON DELETE CASCADE
);

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

-- Stock de Alimento
CREATE TABLE IF NOT EXISTS stock_alimento (
    id INT AUTO_INCREMENT PRIMARY KEY,
    usuario_id INT NOT NULL,
    nombre VARCHAR(100) NOT NULL,
    categoria VARCHAR(50) DEFAULT 'Otros',
    cantidad DECIMAL(10,2) NOT NULL,
    unidad VARCHAR(20) NOT NULL,
    FOREIGN KEY (usuario_id) REFERENCES usuarios(id) ON DELETE CASCADE
);

-- Datos iniciales para especies (Fichas de cría)
INSERT IGNORE INTO especies (nombre, nombre_cientifico, dificultad, temperatura, humedad, descripcion, alimentacion, consejos_cria) VALUES 
('Hormiga Cosechadora', 'Messor barbarus', 'Principiante', '22-28°C', '50-70%', 'Famosas por recolectar semillas. Ideales para empezar.', 'Semillas, ocasionalmente insectos pequeños.', 'Necesitan una zona de forrajeo seca para las semillas y humedad en el nido.'),
('Hormiga de Jardín', 'Lasius niger', 'Principiante', '20-25°C', '60-80%', 'Muy resistentes y activas. Colonias crecen rápido.', 'Líquidos azucarados, moscas, grillos.', 'Hibernan de noviembre a marzo.'),
('Hormiga Gigante', 'Camponotus cruentatus', 'Intermedio', '23-28°C', '40-60%', 'Una de las especies más grandes de Europa. Muy agresivas.', 'Miel, azúcar, insectos.', 'Crecimiento lento los primeros años, requieren paciencia.');
