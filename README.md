# AntMaster Pro - Gestor de Colonias de Hormigas 🐜

AntMaster Pro es una aplicación web integral (CMS/Panel de Control) diseñada para entusiastas de la mirmecología. Permite a los usuarios gestionar sus colonias de hormigas, llevar un registro del progreso, administrar su stock de alimentos e interactuar con una base de datos global de fichas de cría de diferentes especies.

## 📋 Características Principales

- **Gestión de Colonias**: Añade, edita y realiza un seguimiento de tus colonias. Registra el tamaño de la población, el tipo de hormiguero y la fecha de adquisición.
- **Diario de Observación**: Lleva un diario detallado para cada colonia. Añade fotos, anota cambios de comportamiento y registra nacimientos.
- **Control de Alimentación y Stock**: Administra tu inventario de alimento (agua miel, insectos, semillas). Registra en el diario cuándo y cuánto has alimentado a cada colonia descontándolo del stock automáticamente.
- **Módulo de Especies (Wiki)**: Fichas de cría detalladas para diversas especies con información de humedad, temperatura, dificultad, etc.
- **Sistema Multi-Idioma (i18n)**: Soporte completo para Español, Inglés y Francés, tanto en la interfaz (UI) como en el contenido dinámico de la base de datos (traducción de especies).
- **Panel de Administración Avanzado**: Supervisión total de usuarios, roles y datos. Permite a los administradores gestionar directamente las colonias y el stock de cualquier usuario para soporte técnico o moderación.
- **Módulo de Especies (Wiki)**: Fichas de cría detalladas para diversas especies con información de humedad, temperatura, dificultad, etc. Incluye un flujo de revisiones para propuestas comunitarias.
- **Sistema de Ayuda Contextual**: Secciones de ayuda "dismissible" (cerrables) en cada módulo principal que utilizan `localStorage` para recordar la preferencia del usuario.
- **Páginas de Información y Guía**: Secciones dedicadas de "Acerca de" y "Guía de Inicio" con capturas de pantalla reales del sistema para facilitar el onboarding.
- **Gestión de Errores Tematizada**: Páginas personalizadas para errores 404 y 403 con temática de mirmecología.
- **Sistema Multi-Idioma (i18n)**: Soporte completo para Español, Inglés y Francés.
- **Donaciones**: Integración del widget Ko-fi para soporte al desarrollador.

## 🛠 Arquitectura y Stack Tecnológico

El proyecto está diseñado de forma modular utilizando un patrón MVC (Modelo-Vista-Controlador) personalizado en PHP desde cero, sin frameworks pesados, para máxima velocidad y control.

### Frontend
- **HTML5 / CSS3 / JavaScript**
- **Tailwind CSS**: Utilizado extensamente para el diseño UI/UX (Botones, Grids, Formularios).
- **Glassmorphism & Animaciones**: Diseño moderno ("premium") con fondos desenfocados y micro-animaciones fluidas.
- **Chart.js**: Utilizado para métricas de población y distribución de especies en el dashboard.
- **LocalStorage**: Gestión del estado de la interfaz (como el cierre de secciones de ayuda) sin necesidad de peticiones al servidor.

### Backend
- **PHP 8+**: Core del sistema. Enrutamiento, Controladores y Helpers (`core/Router.php`, `core/Controller.php`).
- **MySQL 8.0**: Base de datos relacional para guardar todo el estado. (Conexiones vía PDO).

### Entorno y Despliegue
- **Docker & Docker Compose**: Contenerización completa. El entorno incluye:
  1. Contenedor de la Aplicación (`antmaster_app` - Servidor Web / PHP).
  2. Contenedor de Base de Datos (`antmaster_db` - MySQL 8.0).
  3. Contenedor opcional para gestión (`phpmyadmin`).

## 📁 Estructura de Directorios

```text
antmaster/
├── app/
│   ├── Controllers/   # Lógica de negocio (Admin, Auth, Colony, Especies, etc.)
│   ├── Helpers/       # Utilidades (ImageHelper, etc.)
│   ├── Lang/          # Diccionarios de idioma (es, en, fr) en array PHP.
│   ├── Models/        # Representación de tablas BD (Colony, Species, User, Stock...)
│   └── Views/         # Vistas HTML divididas por módulo (auth, dashboard, colony, layouts...)
├── core/              # Motor MVC (Router.php, Model.php, Database.php, ThemeManager)
├── database/          # Archivos de la base de datos y migraciones
├── database.sql       # Esquema inicial para Docker
├── public/            # Document Root (Accesible desde web)
│   ├── assets/        # CSS, JS, Imágenes del sistema
│   ├── uploads/       # Imágenes subidas por usuarios (Voluta persistente en Docker)
│   └── index.php      # Entry point y Front Controller
├── docker-compose.yml # Orquestación de contenedores
├── Dockerfile         # Construcción de la imagen PHP (Apache mod_rewrite, exts PDO)
└── config.php         # Variables de entorno y configuración general (DB_HOST, etc.)
```

## ⚙️ Instalación y Entorno Local

Puedes arrancar todo el proyecto fácilmente usando Docker.

### 1. Requisitos Previos
- [Docker](https://www.docker.com/) instalado.
- [Docker Compose](https://docs.docker.com/compose/) instalado.

### 2. Pasos para la instalación
1. Clona temporalmente el repositorio o navega a la carpeta del proyecto.
   ```bash
   cd antmaster
   ```
2. Levanta los contenedores:
   ```bash
   docker-compose up -d --build
   ```
3. La base de datos (`gestor_hormigas`) se creará y se importará automáticamente el esquema desde `database.sql` durante el primer arranque local en el volumen `db_data`.

### 3. Migraciones y Datos Especiales
Si necesitas cargar o debugear las traducciones o la base de datos por primera vez:
- Ejecuta los scripts de configuración provistos (ej. `php seed_translations.php` o visita por la URL `migrate_i18n.php` según corresponda si está en pruebas).

### 4. Accesos por defecto
- **Web App**: [http://localhost:8080](http://localhost:8080)
- **phpMyAdmin**: [http://localhost:8081](http://localhost:8081)
- Credenciales BBDD: Usuario: `root` | Password: `544728` (Configurado en `docker-compose.yml`)

## 🔐 Modelos de Datos Relevantes (Resumen)

- `usuarios`: Administra el acceso, roles (`admin`, `usuario`), emails y passwords encriptados (bcrypt).
- `colonias`: Relaciona a un usuario con una especie, registrando su población, fechas y configuraciones de privacidad para slugs públicos.
- `especies` & `especies_traducciones`: Fichas base y sus idiomas. Relacionadas 1:N por i18n (`en`, `es`, `fr`).
- `diario`: Logs de actividad para una colonia que opcionalmente descuentan elementos de `stock_alimento`.
- `revisiones_especies`: Aportaciones comunitarias, esperando a ser aprobadas/rechazadas por un administrador.

## 🔒 Seguridad y Entorno
- **HTTPS Forzado Condicional**: El sistema detecta automáticamente si el entorno es local (`localhost` o `127.0.0.1`) para permitir `http`. En producción, fuerza automáticamente el uso de `https`.
- **Control de Acceso Administrativo**: Funciones centralizadas (`require_admin`, `is_admin`) para validar permisos antes de realizar acciones críticas.

---
*Documentación actualizada para AntMaster Pro v1.1.5.*

