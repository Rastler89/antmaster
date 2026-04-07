<div class="max-w-4xl mx-auto py-12 px-4">
    <div class="text-center mb-16">
        <h1 class="text-5xl font-black text-white mb-6 tracking-tight">
            Guía de <span class="bg-clip-text text-transparent bg-gradient-to-r from-emerald-400 to-emerald-600">Inicio Rápido</span> 🚀
        </h1>
        <p class="text-xl text-zinc-400 max-w-2xl mx-auto leading-relaxed">
            Aprende a dominar AntMaster Pro en minutos y lleva un control profesional de tus hormigueros.
        </p>
    </div>

    <!-- Step 1 -->
    <div class="flex flex-col md:flex-row gap-8 items-center mb-20 group">
        <div class="w-full md:w-1/2">
            <div class="text-emerald-500 font-black text-sm mb-2 uppercase tracking-[0.2em] group-hover:tracking-[0.4em] transition-all">Paso Uno</div>
            <h2 class="text-3xl font-bold text-white mb-4">Registra tu Primera Colonia</h2>
            <p class="text-zinc-400 leading-relaxed mb-6">
                El corazón de la app son tus colonias. Ve a la sección "Hormigueros" y crea uno nuevo. Necesitarás darle un nombre, elegir la especie (si no está, puedes proponerla) y la fecha de adquisición.
            </p>
            <ul class="space-y-3 text-sm text-zinc-500">
                <li class="flex items-center gap-2"><svg class="w-4 h-4 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg> Sube una foto de identificación.</li>
                <li class="flex items-center gap-2"><svg class="w-4 h-4 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg> Indica el tipo de hormiguero inicial.</li>
            </ul>
        </div>
        <div class="w-full md:w-1/2 glass-card p-4 border-emerald-500/10 hover:border-emerald-500/30 transition-all">
            <img src="<?= asset('assets/img/guide-1.png') ?>" alt="Registro de Colonia" class="rounded-lg shadow-2xl">
        </div>
    </div>

    <!-- Step 2 -->
    <div class="flex flex-col md:flex-row-reverse gap-8 items-center mb-20 group">
        <div class="w-full md:w-1/2">
            <div class="text-blue-500 font-black text-sm mb-2 uppercase tracking-[0.2em] group-hover:tracking-[0.4em] transition-all">Paso Dos</div>
            <h2 class="text-3xl font-bold text-white mb-4">Control de Población</h2>
            <p class="text-zinc-400 leading-relaxed mb-6">
                Dentro de cada colonia verás un botón para registrar crecimiento. Anota cualquier cambio notable (muertes de obreras, nacimiento de la primera major, etc.). Todo quedará guardado cronológicamente.
            </p>
            <ul class="space-y-3 text-sm text-zinc-500">
                <li class="flex items-center gap-2"><svg class="w-4 h-4 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg> Genera gráficas automáticas.</li>
                <li class="flex items-center gap-2"><svg class="w-4 h-4 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg> Haz fotos del progreso.</li>
            </ul>
        </div>
        <div class="w-full md:w-1/2 glass-card p-4 border-blue-500/10 hover:border-blue-500/30 transition-all">
            <img src="<?= asset('assets/img/guide-2.png') ?>" alt="Control de Población" class="rounded-lg shadow-2xl">
        </div>
    </div>

    <!-- Step 3 -->
    <div class="flex flex-col md:flex-row gap-8 items-center mb-20 group">
        <div class="w-full md:w-1/2">
            <div class="text-orange-500 font-black text-sm mb-2 uppercase tracking-[0.2em] group-hover:tracking-[0.4em] transition-all">Paso Tres</div>
            <h2 class="text-3xl font-bold text-white mb-4">Inventario de Alimento</h2>
            <p class="text-zinc-400 leading-relaxed mb-6">
                No permitas que tus hormigas pasen hambre. En la sección "Alimento" puedes llevar el stock de tus insectos alimentarios o néctar. Al añadir una entrada, sabrás exactamente qué tienes disponible.
            </p>
        </div>
        <div class="w-full md:w-1/2 glass-card p-4 border-orange-500/10 hover:border-orange-500/30 transition-all">
            <img src="<?= asset('assets/img/guide-3.png') ?>" alt="Inventario de Alimento" class="rounded-lg shadow-2xl">
        </div>
    </div>

    <!--<div class="text-center mt-12 bg-white/5 p-12 rounded-3xl border border-white/5">
        <h3 class="text-2xl font-bold text-white mb-4">¿Tienes dudas adicionales?</h3>
        <p class="text-zinc-400 mb-8">Estamos para ayudarte en cualquier paso del camino.</p>
        <a href="mailto:hola@rastler.dev" class="magic-btn px-12 py-3 rounded-full">Contactar con Soporte</a>
    </div>-->
</div>
