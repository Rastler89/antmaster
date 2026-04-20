# 🏗️ Arquitectura y Motor Core (MVC)

AntMaster Pro utiliza un motor MVC (Modelo-Vista-Controlador) personalizado, diseñado para ser ligero, rápido y sin dependencias externas pesadas.

## 1. El Front Controller (`public/index.php`)
Todas las peticiones web se dirigen a este archivo mediante `.htaccess`. Es el punto de entrada que:
- Inicia la sesión.
- Carga la configuración (`config.php`).
- Ejecuta el `Migrator` para asegurar que la BD esté al día.
- Inicializa el `Router` y despacha la petición.

## 2. El Sistema de Rutas (`core/Router.php`)
El router mapea URIs a métodos de controladores.
- **Definición**: Se encuentran en `public/index.php`.
- **Sintaxis**: `$router->get('/ruta/{id}', 'Controlador@metodo');`
- **Parámetros**: Los valores entre llaves `{}` se pasan como argumentos al método del controlador.
- **Simulación de métodos**: El router soporta `PUT`, `PATCH` y `DELETE` mediante un campo oculto `_method` en los formularios POST.

## 3. Controladores (`app/Controllers/`)
Los controladores extienden de `core/Controller.php`. Su responsabilidad es:
- Procesar la lógica de negocio.
- Interactuar con los Modelos.
- Llamar a la Vista.
- **Helpers**: Disponibles globalmente (ej: `require_login()`, `require_admin()`).

## 4. El Motor de Vistas (`core/View.php`)
El renderizado se realiza mediante `View::render($nombre, $datos)`.
- **Layouts**: El sistema detecta automáticamente si usar `layouts/app.php` o `layouts/auth.php` basándose en el directorio de la vista.
- **Extracción**: Los datos pasados en el array `$datos` se extraen mediante `extract()`, convirtiéndose en variables locales dentro de la vista.

---
> [!TIP]
> Para añadir una nueva página:
> 1. Crea el método en un controlador.
> 2. Crea la vista en `app/Views/` .
> 3. Registra la ruta en `public/index.php`.
