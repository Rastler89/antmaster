-- Permitir nuevas especies (especie_id nulo)
ALTER TABLE revisiones_especies MODIFY especie_id INT NULL;

-- Añadir motivo de rechazo para el log
ALTER TABLE revisiones_especies ADD COLUMN IF NOT EXISTS motivo_rechazo TEXT DEFAULT NULL AFTER estado;
