# 📚 Centro de Documentación Técnica - AntMaster Pro

Bienvenido a la documentación oficial de AntMaster Pro. Este repositorio ha sido diseñado para ser fácilmente extensible y mantenible por cualquier desarrollador PHP.

## 📖 Índice de Contenidos

Para una comprensión profunda del sistema, revisa los siguientes manuales técnicos:

1.  [**Arquitectura y Motor Core (MVC)**](docs/01_arquitectura_core.md): Entiende cómo funciona el router, el controlador base y el sistema de renderizado de vistas.
2.  [**Base de Datos y Modelos**](docs/02_modelos_datos.md): Aprende sobre la capa de abstracción de datos, el sistema de migraciones automáticas y la estructura bilingüe.
3.  [**Frontend y Diseño UI/UX**](docs/03_frontend_diseno.md): Guía sobre el uso de Tailwind CSS, el diseño *Glassmorphism* y los componentes JavaScript dinámicos.
4.  [**Sistema de Internacionalización (i18n)**](docs/04_internacionalizacion.md): Cómo se gestionan los idiomas, diccionarios estáticos y contenido dinámico traducido.
5.  [**Panel de Administración y Despliegue**](docs/05_admin_mantenimiento.md): Detalles sobre el flujo de revisiones de la comunidad y la orquestación con Docker.
6.  [**Guía Práctica para el Desarrollador**](docs/06_guia_extension.md): Instrucciones paso a paso para añadir nuevas funcionalidades o modificar las existentes.

---

## ⚡ Inicio Rápido para Programadores

Si acabas de clonar el proyecto:

1.  Asegúrate de tener **Docker** y **Docker Compose** instalados.
2.  Ejecuta `docker-compose up -d --build`.
3.  El sistema ejecutará automáticamente las migraciones. No necesitas importar SQL manualmente.
4.  Accede a la app en `http://localhost:8080`.
5.  Las credenciales de acceso a la base de datos se encuentran en `config.php` y `docker-compose.yml`.

---
*Manual técnico v1.3.1 - Última actualización: Abril 2026*
