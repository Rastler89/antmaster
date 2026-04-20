# 🌐 Sistema de Internacionalización (i18n)

AntMaster Pro está diseñado desde su arquitectura para ser compatible con múltiples idiomas (Español, Inglés y Francés por defecto).

## 1. Traducciones Estáticas (Interfaz UI)
Los textos fijos de la aplicación se gestionan mediante diccionarios PHP.
- **Ubicación**: `app/Lang/[es|en|fr]/messages.php`.
- **Formato**: Un array asociativo donde la clave es el identificador técnico y el valor es el texto traducido.
- **Uso**: Se invoca con la función global `__('clave')`. Ejemplo: `<?= __('species_form_title') ?>`.

## 2. Traducciones Dinámicas (Base de Datos)
El contenido de las fichas de cría (Base de Datos) se traduce de forma independiente.
- **Tabla**: `especies_traducciones`.
- **Funcionamiento**: El modelo `Species` detecta el idioma actual (`APP_LANG`) y realiza un `LEFT JOIN` con la tabla de traducciones.
- **Políticas de Fallback**: Si un campo de traducción está vacío, el sistema utiliza el valor de la tabla maestra (ES) para evitar que el usuario vea un campo en blanco.

## 3. Configuración y Detección (`config.php`)
El idioma se determina siguiendo este orden de prioridad:
1. Parámetro `?lang=` en la URL.
2. Idioma guardado en la sesión.
3. Idioma guardado en una Cookie (`lang`).
4. Detección automática del idioma del navegador (`HTTP_ACCEPT_LANGUAGE`).
5. Valor por defecto (`es`).

---
> [!NOTE]
> Para añadir un nuevo idioma (ej: Alemán):
> 1. Añade `'de'` al array `$available_langs` en `config.php`.
> 2. Crea la carpeta `app/Lang/de/` y añade el archivo `messages.php`.
> 3. Traduce las claves del diccionario.
> 4. El sistema detectará automáticamente el nuevo idioma en el selector de la UI.
