-- Migration 008: Añadir columna de ajustes a usuarios
ALTER TABLE usuarios ADD COLUMN IF NOT EXISTS settings TEXT NULL AFTER is_banned;
