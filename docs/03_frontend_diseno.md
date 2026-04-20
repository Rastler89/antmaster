# 🎨 Frontend, Diseño y Experiencia de Usuario

La interfaz de AntMaster Pro se basa en una estética "Premium" denominada *Glassmorphism*, caracterizada por transparencias, desenfoques y contrastes vivos sobre fondos oscuros.

## 1. Stack Tecnológico
- **Tailwind CSS**: Utilizado para el layout, espaciados, tipografía y utilidades rápidas.
- **Vanilla CSS (`public/assets/css/style.css`)**: Contiene las definiciones de diseño personalizadas:
    - `.glass-card`: Efecto de cristal translúcido.
    - `.magic-btn`: Gradientes animados con efectos hover.
    - `.magic-input`: Estilos de formulario personalizados.
    - **Variables CSS**: Definición de paleta de colores (HSL) para un mantenimiento sencillo del tema.

## 2. Interactividad y JavaScript
Se prioriza el uso de JavaScript nativo (ES6+) sin frameworks como React o Vue para maximizar la velocidad de carga.
- **Componentes Dinámicos**: Ubicados en `public/assets/js/`.
- **Chart.js**: Se utiliza para los gráficos de evolución de población en las colonias y el dashboard.
- **LocalStorage**: Se usa para guardar estados menores (ej: si el usuario cerró el banner de bienvenida) sin necesidad de interactuar con la base de datos.
- **Debouncing**: Implementado en el buscador de especies y en el autocompletado del formulario de creación para evitar sobrecarga del servidor.

## 3. Sistema de Iconos
Se utilizan mayoritariamente **SVGs embebidos** para:
- Evitar peticiones HTTP adicionales.
- Permitir el escalado sin pérdida de calidad.
- Controlar los colores mediante CSS (`currentColor`).

## 4. Diseño Adaptativo (Responsive)
El diseño es *Mobile-First*. Se utilizan los prefijos de Tailwind (`sm:`, `md:`, `lg:`) para ajustar las tarjetas y cuadrículas a dispositivos móviles y tablets.

---
> [!TIP]
> Si deseas cambiar el color principal de la marca, modifica la variable `--primary` en `public/assets/css/style.css`. Todos los componentes con color sólido o gradientes se actualizarán automáticamente.
