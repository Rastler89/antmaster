<div class="max-w-4xl mx-auto py-12 px-4 animate-fade-in">
    <!-- Header -->
    <div class="text-center mb-20">
        <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-blue-500/10 border border-blue-500/20 text-blue-400 text-[10px] font-black uppercase tracking-widest mb-6">
            <span class="relative flex h-2 w-2">
                <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-blue-400 opacity-75"></span>
                <span class="relative inline-flex rounded-full h-2 w-2 bg-blue-500"></span>
            </span>
            Evolución del Proyecto
        </div>
        <h1 class="text-5xl md:text-7xl font-black text-white mb-6 tracking-tighter">Changelog</h1>
        <p class="text-zinc-500 text-lg max-w-2xl mx-auto">
            Sigue de cerca cada actualización, mejora y corrección que implementamos para hacer de AntMaster Pro la mejor herramienta para mirmecólogos.
        </p>
    </div>

    <!-- Timeline Container -->
    <div class="relative space-y-16 before:absolute before:inset-0 before:ml-5 before:-translate-x-px md:before:mx-auto md:before:translate-x-0 before:h-full before:w-0.5 before:bg-gradient-to-b before:from-transparent before:via-zinc-800 before:to-transparent">

        <!-- Version 1.1.7 -->
        <div class="relative flex items-center justify-between md:justify-normal md:odd:flex-row-reverse group is-active">
            <!-- Icon -->
            <div class="flex items-center justify-center w-10 h-10 rounded-full border border-zinc-800 bg-zinc-950 text-blue-500 shadow shrink-0 md:order-1 md:group-odd:-translate-x-1/2 md:group-even:translate-x-1/2 transition-all group-hover:scale-120 group-hover:border-blue-500/50">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"></path></svg>
            </div>
            <!-- Content -->
            <div class="w-[calc(100%-4rem)] md:w-[calc(50%-2.5rem)] glass-card p-6 md:p-8 hover:border-blue-500/30 transition-all">
                <div class="flex items-center justify-between mb-4">
                    <time class="text-[10px] font-black text-blue-400 uppercase tracking-widest">9 Abril, 2026</time>
                    <span class="px-3 py-1 rounded-full bg-blue-500/10 text-blue-400 text-[10px] font-black border border-blue-500/20">v1.1.7</span>
                </div>
                <h3 class="text-xl font-bold text-white mb-4">Hotfix Producción</h3>
                <ul class="space-y-3">
                    <li class="flex gap-3 text-sm text-zinc-400">
                        <span class="text-red-500 font-bold">!</span>
                        <span>**Migraciones**: Forzar el disparador de migraciones en producción para añadir el campo `is_draft` al registro de especies.</span>
                    </li>
                </ul>
            </div>
        </div>

        <!-- Version 1.1.6 -->
        <div class="relative flex items-center justify-between md:justify-normal md:odd:flex-row-reverse group">
            <!-- Icon -->
            <div class="flex items-center justify-center w-10 h-10 rounded-full border border-zinc-800 bg-zinc-950 text-zinc-500 shadow shrink-0 md:order-1 md:group-odd:-translate-x-1/2 md:group-even:translate-x-1/2 transition-all group-hover:scale-120">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path></svg>
            </div>
            <!-- Content -->
            <div class="w-[calc(100%-4rem)] md:w-[calc(50%-2.5rem)] glass-card p-6 md:p-8">
                <div class="flex items-center justify-between mb-4">
                    <time class="text-[10px] font-black text-zinc-500 uppercase tracking-widest">7 Abril, 2026</time>
                    <span class="px-3 py-1 rounded-full bg-zinc-500/10 text-zinc-500 text-[10px] font-black border border-white/5">v1.1.6</span>
                </div>
                <h3 class="text-xl font-bold text-white mb-4">Módulo de Especies y Estabilidad</h3>
                <ul class="space-y-3">
                    <li class="flex gap-3 text-sm text-zinc-400">
                        <span class="text-blue-500 font-bold">+</span>
                        <span>**Soporte Off-database**: Ahora puedes registrar especies nuevas "on-the-fly" si no existen en la Wiki.</span>
                    </li>
                    <li class="flex gap-3 text-sm text-zinc-400">
                        <span class="text-blue-500 font-bold">+</span>
                        <span>**Panel Admin Pro**: Nuevo flujo de aprobación para especies sugeridas por usuarios.</span>
                    </li>
                    <li class="flex gap-3 text-sm text-zinc-400">
                        <span class="text-emerald-500 font-bold">#</span>
                        <span>**QR Smart-Entry**: Corregido el enlace QR y añadida apertura automática del formulario.</span>
                    </li>
                    <li class="flex gap-3 text-sm text-zinc-400">
                        <span class="text-red-500 font-bold">!</span>
                        <span>**Schema Fix**: Resuelto error fatal en la persistencia de temas/ajustes de usuario.</span>
                    </li>
                </ul>
            </div>
        </div>

        <!-- Version 1.1.5 -->
        <div class="relative flex items-center justify-between md:justify-normal md:odd:flex-row-reverse group">
            <!-- Icon -->
            <div class="flex items-center justify-center w-10 h-10 rounded-full border border-zinc-800 bg-zinc-950 text-zinc-500 shadow shrink-0 md:order-1 md:group-odd:-translate-x-1/2 md:group-even:translate-x-1/2 transition-all group-hover:scale-120">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path></svg>
            </div>
            <!-- Content -->
            <div class="w-[calc(100%-4rem)] md:w-[calc(50%-2.5rem)] glass-card p-6 md:p-8">
                <div class="flex items-center justify-between mb-4">
                    <time class="text-[10px] font-black text-zinc-500 uppercase tracking-widest">6 Abril, 2026</time>
                    <span class="px-3 py-1 rounded-full bg-zinc-500/10 text-zinc-500 text-[10px] font-black border border-white/5">v1.1.5</span>
                </div>
                <h3 class="text-xl font-bold text-white mb-4">Experiencia de Usuario</h3>
                <ul class="space-y-3">
                    <li class="flex gap-3 text-sm text-zinc-400">
                        <span class="text-blue-500 font-bold">+</span>
                        <span>**Guía de Inicio**: Nueva sección interactiva con capturas reales del sistema.</span>
                    </li>
                    <li class="flex gap-3 text-sm text-zinc-400">
                        <span class="text-blue-500 font-bold">+</span>
                        <span>**Ayuda Contextual**: Tarjetas de ayuda cerrables en cada panel con recordatorio local.</span>
                    </li>
                    <li class="flex gap-3 text-sm text-zinc-400">
                        <span class="text-blue-500 font-bold">+</span>
                        <span>**Footer Premium**: Integración de enlaces sociales y créditos de desarrollo.</span>
                    </li>
                </ul>
            </div>
        </div>

        <!-- Version 1.1.2 -->
        <div class="relative flex items-center justify-between md:justify-normal md:odd:flex-row-reverse group">
            <!-- Icon -->
            <div class="flex items-center justify-center w-10 h-10 rounded-full border border-zinc-800 bg-zinc-950 text-zinc-500 shadow shrink-0 md:order-1 md:group-odd:-translate-x-1/2 md:group-even:translate-x-1/2 transition-all group-hover:scale-120">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
            </div>
            <!-- Content -->
            <div class="w-[calc(100%-4rem)] md:w-[calc(50%-2.5rem)] glass-card p-6 md:p-8">
                <div class="flex items-center justify-between mb-4">
                    <time class="text-[10px] font-black text-zinc-500 uppercase tracking-widest">1 Abril, 2026</time>
                    <span class="px-3 py-1 rounded-full bg-zinc-500/10 text-zinc-500 text-[10px] font-black border border-white/5">v1.1.2</span>
                </div>
                <h3 class="text-xl font-bold text-white mb-4">Internacionalización</h3>
                <ul class="space-y-3">
                    <li class="flex gap-3 text-sm text-zinc-400">
                        <span class="text-blue-500 font-bold">+</span>
                        <span>**Multi-Idioma Core**: Soporte completo para Español, Inglés y Francés.</span>
                    </li>
                    <li class="flex gap-3 text-sm text-zinc-400">
                        <span class="text-blue-500 font-bold">+</span>
                        <span>**Wiki Dinámica**: Traducción de fichas de cría según el idioma seleccionado.</span>
                    </li>
                    <li class="flex gap-3 text-sm text-zinc-400">
                        <span class="text-blue-500 font-bold">+</span>
                        <span>**Sistema de Temas**: Primeras implementaciones de personalización visual.</span>
                    </li>
                </ul>
            </div>
        </div>

    </div>

    <!-- CTA -->
    <div class="mt-24 text-center">
        <p class="text-zinc-500 text-sm mb-8 italic">¿Tienes una sugerencia para la próxima versión?</p>
        <a href="https://rastler.dev" target="_blank" class="magic-btn px-10 py-4 text-xs font-black uppercase tracking-widest">Contactar con Desarrollo</a>
    </div>
</div>

<style>
.glass-card {
    background: rgba(24, 24, 27, 0.4);
    backdrop-filter: blur(20px);
    -webkit-backdrop-filter: blur(20px);
    border: 1px solid rgba(255, 255, 255, 0.05);
    border-radius: 2rem;
    box-shadow: 0 10px 40px rgba(0, 0, 0, 0.3);
}
</style>
