-- Añadir campos biológicos a la tabla de traducciones para permitir visualización multilingüe completa
ALTER TABLE especies_traducciones 
ADD COLUMN velocidad_crecimiento VARCHAR(100) DEFAULT NULL,
ADD COLUMN tamano VARCHAR(100) DEFAULT NULL,
ADD COLUMN castas VARCHAR(100) DEFAULT NULL,
ADD COLUMN reproduccion VARCHAR(100) DEFAULT NULL,
ADD COLUMN vuelos VARCHAR(100) DEFAULT NULL;
