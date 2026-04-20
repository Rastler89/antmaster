# 🔧 Operaciones y Panel de Administración

AntMaster Pro incluye un panel de administración robusto para gestionar el contenido y la salud del sistema.

## 1. El Módulo de Revisiones (Wiki)
El sistema permite a los usuarios proponer ediciones a las fichas de cría existentes.
- **Flujo**:
    1. El usuario envía una "Sugerencia de Edición".
    2. Se crea un registro en `revisiones_especies` con estado `pendiente` y los cambios en formato JSON.
    3. El administrador revisa la propuesta en el panel de Administración.
    4. Al aprobar, los cambios JSON se inyectan directamente en la tabla `especies` o `especies_traducciones` mediante el método `Species::update()`.
    5. Al rechazar, se guarda el motivo y la revisión queda archivada.

## 2. Gestión de Borradores (Drafts)
Cuando un usuario registra una colonia de una especie que no existe, el sistema crea un "Borrador" (`is_draft = 1`).
- Los borradores son visibles para el usuario que los creó pero no para el resto del público.
- El administrador debe revisar el borrador, completar los datos técnicos y hacer clic en **"Publicar"** para que sea oficial.

## 3. Despliegue con Docker
El proyecto está completamente contenedorizado.
- **`Dockerfile`**: Configura Apache, instala extensiones de PHP (pdo_mysql) y habilita `mod_rewrite`.
- **`docker-compose.yml`**: Orquesta tres servicios:
    - `app`: Servidor web (Apache + PHP 8.1).
    - `db`: Base de datos MySQL 8.0.
    - `phpmyadmin`: Herramientas de gestión visual de BD.
- **Persistencia**: Se utilizan volúmenes para `/var/lib/mysql` y `/public/uploads` para asegurar que las fotos y los datos no se pierdan al reiniciar contenedores.

## 4. Gestión de Archivos y Subidas
Las imágenes se procesan mediante `App\Helpers\ImageHelper`. 
- Se guardan en `public/uploads/{tipo}/{id}/`.
- El sistema utiliza slugs únicos para evitar colisiones de nombres de archivos.

---
> [!CAUTION]
> Asegúrate de que la carpeta `public/uploads` tenga permisos de escritura (`chmod 775`) si realizas un despliegue manual fuera de Docker.
