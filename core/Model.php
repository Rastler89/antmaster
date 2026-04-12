<?php
abstract class Model {
    protected static $table;
    protected $attributes = [];

    public function __construct($data = []) {
        $this->attributes = $data;
    }

    public function __get($name) {
        if ($name === 'attributes') {
            return $this->attributes;
        }
        return $this->attributes[$name] ?? null;
    }

    // Obtener conexión estática a la BD
    protected static function db() {
        return Database::getConnection();
    }

    public static function all() {
        if (!static::$table) throw new Exception("Tabla no definida en el modelo.");
        $stmt = static::db()->query("SELECT * FROM " . static::$table);
        return $stmt->fetchAll();
    }

    public static function find($id) {
        if (!static::$table) throw new Exception("Tabla no definida en el modelo.");
        $stmt = static::db()->prepare("SELECT * FROM " . static::$table . " WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch();
    }

    public static function where($column, $operator, $value = null) {
        // Fallback: si se pasan 2 argumentos asume operador "="
        if ($value === null) {
            $value = $operator;
            $operator = '=';
        }
        $stmt = static::db()->prepare("SELECT * FROM " . static::$table . " WHERE $column $operator ?");
        $stmt->execute([$value]);
        return $stmt->fetchAll();
    }
    
    public static function whereOne($column, $operator, $value = null) {
        if ($value === null) {
            $value = $operator;
            $operator = '=';
        }
        $stmt = static::db()->prepare("SELECT * FROM " . static::$table . " WHERE $column $operator ? LIMIT 1");
        $stmt->execute([$value]);
        return $stmt->fetch();
    }

    public static function create(array $data) {
        $columns = implode(', ', array_keys($data));
        $placeholders = implode(', ', array_fill(0, count($data), '?'));
        
        $sql = "INSERT INTO " . static::$table . " ($columns) VALUES ($placeholders)";
        $stmt = static::db()->prepare($sql);
        return $stmt->execute(array_values($data));
    }

    public static function update($id, array $data) {
        $set = "";
        $values = [];
        foreach ($data as $column => $value) {
            $set .= "$column = ?, ";
            $values[] = $value;
        }
        $set = rtrim($set, ', ');
        $values[] = $id;

        $sql = "UPDATE " . static::$table . " SET $set WHERE id = ?";
        $stmt = static::db()->prepare($sql);
        return $stmt->execute($values);
    }

    public static function delete($id) {
        $stmt = static::db()->prepare("DELETE FROM " . static::$table . " WHERE id = ?");
        return $stmt->execute([$id]);
    }

    // Método flexible para consultas crudas personalizadas
    public static function query($sql, $params = []) {
        $stmt = static::db()->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchAll();
    }
}
