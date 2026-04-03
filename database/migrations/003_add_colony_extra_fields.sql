-- Migración para añadir campos faltantes a la tabla colonias
-- Estos campos son necesarios para la funcionalidad de imágenes y población detallada (castas)

ALTER TABLE colonias ADD COLUMN imagen VARCHAR(255) NULL AFTER poblacion_actual;
ALTER TABLE colonias ADD COLUMN poblacion_detallada JSON NULL AFTER imagen;
