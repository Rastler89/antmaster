-- Migración 009: Añadir columna is_draft a la tabla especies
-- Esto evita errores en producción al registrar colonias con especies nuevas
-- y permite el flujo de aprobación administrativa.

ALTER TABLE especies ADD COLUMN is_draft TINYINT(1) DEFAULT 0;
