# 🚀 Guía de Extensión para Desarrolladores

Si eres un nuevo programador en AntMaster Pro, aquí tienes una receta rápida para las tareas más comunes.

## Cómo añadir un nuevo Módulo (Ej: "Premios")

1. **Base de Datos**: Crea una migración en `database/migrations/` para crear la tabla `premios`.
2. **Modelo**: Crea `app/Models/Award.php` que extienda de `Model`. Define `protected static $table = 'premios';`.
3. **Controlador**: Crea `app/Controllers/AwardController.php`.
    - Implementa métodos como `index()`, `show()`, `store()`.
4. **Vistas**: Crea la carpeta `app/Views/awards/` con los archivos `.php` necesarios.
5. **Rutas**: En `public/index.php`, registra las rutas:
   ```php
   $router->get('/awards', 'AwardController@index');
   $router->post('/awards/create', 'AwardController@store');
   ```
6. **Internacionalización**: Añade las etiquetas necesarias en `app/Lang/es/messages.php` y demás idiomas.

## Cómo añadir un nuevo campo a las Especies

1. Crea una migración para añadir la columna a las tablas `especies` y `especies_traducciones`.
2. Actualiza los formularios en `app/Views/especies/create.php` y `edit.php`.
3. Actualiza el método `Species::find()` y `Species::all()` para incluir el nuevo campo en la lógica de `COALESCE`.
4. Actualiza `AdminEspeciesController` para permitir la edición de ese nuevo campo desde el panel de traducción.

## Cómo modificar el diseño global

- Los estilos base están en `public/assets/css/style.css`. 
- Si usas Tailwind, recuerda que el proyecto pre-procesa las clases. Si añades clases nuevas de Tailwind, asegúrate de tener el compilador de Tailwind corriendo o usa las clases estándar que ya están incluidas en el bundle.

## Debugging

- **Logs de Error**: Revisa los logs de Docker con `docker logs antmaster_app`.
- **SQL**: El sistema lanza excepciones de PDO por defecto. Puedes usar `var_dump()` o `die()` en los controladores para inspeccionar variables rápidas.
- **Base de Datos**: Usa `http://localhost:8081` para acceder a phpMyAdmin en desarrollo.

---
> [!TIP]
> Mantén siempre el código limpio y sigue el estilo CamelCase para controladores y snake_case para variables y columnas de base de datos para mantener la consistencia con el resto del proyecto.
