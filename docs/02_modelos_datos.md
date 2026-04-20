# 🗄️ Modelos de Datos y Base de Datos

AntMaster Pro utiliza MySQL con una capa de abstracción sencilla inspirada en el patrón Active Record.

## 1. El Modelo Base (`core/Model.php`)
Todos los modelos extienden de esta clase abstracta, lo que les otorga capacidades CRUD inmediatas:
- `all()`: Devuelve todos los registros.
- `find($id)`: Busca por ID primario.
- `where($col, $val)`: Filtra registros.
- `create($data)`: Inserta un nuevo registro.
- `update($id, $data)`: Actualiza por ID.

## 2. Sistema de Migraciones (`core/Migrator.php`)
Las migraciones se encuentran en `database/migrations/`. 
- **Ejecución Automática**: Cada vez que se carga la página, el sistema revisa si hay archivos `.sql` nuevos y los ejecuta.
- **Persistencia**: Se lleva un registro de las migraciones aplicadas en la tabla `migrations` para evitar duplicados.

## 3. Relación de Especies e i18n
La base de datos maneja traducciones dinámicas de la siguiente manera:
- **`especies`**: Tabla maestra con los datos técnicos (ID, nombre científico, dificultad).
- **`especies_traducciones`**: Tabla con los textos localizables (`nombre`, `descripcion`, `alimentacion`, etc.) vinculados por `especie_id`.

### Lógica de Fallback (`COALESCE`)
En `Species::find()`, el sistema intenta obtener el texto en el idioma actual. Si el campo está vacío en ese idioma, utiliza automáticamente el valor de la tabla maestra (español) mediante la función `COALESCE(NULLIF(t.campo, ''), e.campo)`.

## 4. Gestión de Conexiones (`core/Database.php`)
Utiliza un patrón Singleton para asegurar que solo exista una instancia de PDO durante la ejecución, optimizando los recursos del servidor.

---
> [!IMPORTANT]
> Para añadir una columna a una tabla existente, **nunca** modifiques el archivo `database.sql` directamente. Crea un nuevo archivo `.sql` numerado en `database/migrations/` (ej: `018_add_field_to_users.sql`).
