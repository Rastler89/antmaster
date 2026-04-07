<div class="flex flex-col md:flex-row justify-between items-center mb-8 gap-4">
    <div class="flex flex-col">
        <div class="flex items-center gap-2 text-zinc-500 text-xs mb-2">
            <a href="<?= BASE_URL ?>/admin/especies" class="hover:text-white transition-colors">Gestión de Especies</a>
            <span>/</span>
            <span class="text-white italic">Editar Base</span>
        </div>
        <h1 class="text-3xl font-black text-white">
            Editar Datos Base: <span class="text-amber-400"><?= htmlspecialchars($species['nombre_cientifico']) ?></span> 🐜
        </h1>
    </div>
    <a href="<?= BASE_URL ?>/admin/especies" class="px-4 py-2 bg-white/5 border border-white/10 text-zinc-400 rounded-xl hover:bg-white/10 hover:text-white transition-all text-sm font-bold flex items-center gap-2">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
        Volver al Listado
    </a>
</div>

<div class="glass-card border-white/5 overflow-hidden">
    <form action="<?= BASE_URL ?>/admin/especies/editar/<?= $species['id'] ?>" method="POST" class="divide-y divide-white/5">
        
        <!-- Sección 1: Identificación -->
        <div class="p-8 space-y-6">
            <div class="flex items-center gap-3 mb-2">
                <div class="p-2 bg-blue-500/10 rounded-lg text-blue-400">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V8a2 2 0 00-2-2h-5m-4 0V5a2 2 0 114 0v1m-4 0a2 2 0 104 0m-5 8a2 2 0 100-4 2 2 0 000 4zm5 3a2 2 0 100-4 2 2 0 000 4z"></path></svg>
                </div>
                <h3 class="text-lg font-bold text-white">Identificación Principal</h3>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="space-y-2">
                    <label class="text-[10px] uppercase font-black text-zinc-500 tracking-widest ml-1">Nombre Científico</label>
                    <input type="text" name="nombre_cientifico" value="<?= htmlspecialchars($species['nombre_cientifico']) ?>" required
                        class="w-full bg-white/5 border border-white/10 rounded-xl p-3 text-white text-sm focus:outline-none focus:border-blue-500 transition-all font-italic">
                </div>
                <div class="space-y-2">
                    <label class="text-[10px] uppercase font-black text-zinc-500 tracking-widest ml-1">Nombre Común (Base ES)</label>
                    <input type="text" name="nombre" value="<?= htmlspecialchars($species['nombre']) ?>" required
                        class="w-full bg-white/5 border border-white/10 rounded-xl p-3 text-white text-sm focus:outline-none focus:border-blue-500 transition-all">
                </div>
            </div>
        </div>

        <!-- Sección 2: Parámetros de Cría -->
        <div class="p-8 space-y-6 bg-white/[0.01]">
            <div class="flex items-center gap-3 mb-2">
                <div class="p-2 bg-emerald-500/10 rounded-lg text-emerald-400">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path></svg>
                </div>
                <h3 class="text-lg font-bold text-white">Parámetros de Cría</h3>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <!-- Dificultad -->
                <div class="space-y-2">
                    <label class="text-[10px] uppercase font-black text-zinc-500 tracking-widest ml-1">Dificultad</label>
                    <select name="dificultad" class="w-full bg-white/5 border border-white/10 rounded-xl p-3 text-white text-sm focus:outline-none focus:border-emerald-500 transition-all">
                        <?php foreach (['Principiante', 'Intermedio', 'Experto', 'Avanzado'] as $diff): ?>
                            <option value="<?= $diff ?>" class="bg-zinc-900" <?= $species['dificultad'] == $diff ? 'selected' : '' ?>><?= $diff ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <!-- Temperatura -->
                <div class="space-y-2">
                    <label class="text-[10px] uppercase font-black text-zinc-500 tracking-widest ml-1">Temperatura</label>
                    <input type="text" name="temperatura" value="<?= htmlspecialchars($species['temperatura'] ?? '') ?>" placeholder="Ej: 22-28°C"
                        class="w-full bg-white/5 border border-white/10 rounded-xl p-3 text-white text-sm focus:outline-none focus:border-emerald-500 transition-all">
                </div>
                <!-- Humedad -->
                <div class="space-y-2">
                    <label class="text-[10px] uppercase font-black text-zinc-500 tracking-widest ml-1">Humedad</label>
                    <input type="text" name="humedad" value="<?= htmlspecialchars($species['humedad'] ?? '') ?>" placeholder="Ej: 50-70%"
                        class="w-full bg-white/5 border border-white/10 rounded-xl p-3 text-white text-sm focus:outline-none focus:border-emerald-500 transition-all">
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <!-- Crecimiento -->
                <div class="space-y-2">
                    <label class="text-[10px] uppercase font-black text-zinc-500 tracking-widest ml-1">Velocidad Crecimiento</label>
                    <input type="text" name="velocidad_crecimiento" value="<?= htmlspecialchars($species['velocidad_crecimiento'] ?? '') ?>" placeholder="Ej: Rápida"
                        class="w-full bg-white/5 border border-white/10 rounded-xl p-3 text-white text-sm focus:outline-none focus:border-emerald-500 transition-all">
                </div>
                <!-- Tamaño -->
                <div class="space-y-2">
                    <label class="text-[10px] uppercase font-black text-zinc-500 tracking-widest ml-1">Tamaño</label>
                    <input type="text" name="tamano" value="<?= htmlspecialchars($species['tamano'] ?? '') ?>" placeholder="Ej: 6-12mm"
                        class="w-full bg-white/5 border border-white/10 rounded-xl p-3 text-white text-sm focus:outline-none focus:border-emerald-500 transition-all">
                </div>
                <!-- Vuelos -->
                <div class="space-y-2">
                    <label class="text-[10px] uppercase font-black text-zinc-500 tracking-widest ml-1">Época de Vuelos</label>
                    <input type="text" name="vuelos" value="<?= htmlspecialchars($species['vuelos'] ?? '') ?>" placeholder="Ej: Septiembre - Octubre"
                        class="w-full bg-white/5 border border-white/10 rounded-xl p-3 text-white text-sm focus:outline-none focus:border-emerald-500 transition-all">
                </div>
            </div>
        </div>

        <!-- Sección 3: Biología -->
        <div class="p-8 space-y-6">
            <div class="flex items-center gap-3 mb-2">
                <div class="p-2 bg-purple-500/10 rounded-lg text-purple-400">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.691.31a2 2 0 01-1.666 0l-.69-.31a6 6 0 00-3.86-.517l-2.388.477a2 2 0 00-1.022.547l-1.162 1.162a2 2 0 000 2.828l1.162 1.162a2 2 0 001.022.547l2.387.477a6 6 0 003.86-.517l.691-.31a2 2 0 011.666 0l.69.31a6 6 0 003.86.517l2.388-.477a2 2 0 001.022-.547l1.162-1.162a2 2 0 000-2.828l-1.162-1.162z"></path></svg>
                </div>
                <h3 class="text-lg font-bold text-white">Biología y Reproducción</h3>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Castas -->
                <div class="space-y-2">
                    <label class="text-[10px] uppercase font-black text-zinc-500 tracking-widest ml-1">Castas</label>
                    <input type="text" name="castas" value="<?= htmlspecialchars($species['castas'] ?? '') ?>" placeholder="Ej: Polimórfica, con majors"
                        class="w-full bg-white/5 border border-white/10 rounded-xl p-3 text-white text-sm focus:outline-none focus:border-purple-500 transition-all">
                </div>
                <!-- Reproducción -->
                <div class="space-y-2">
                    <label class="text-[10px] uppercase font-black text-zinc-500 tracking-widest ml-1">Reproducción</label>
                    <input type="text" name="reproduccion" value="<?= htmlspecialchars($species['reproduccion'] ?? '') ?>" placeholder="Ej: Monogínica / Poligínica"
                        class="w-full bg-white/5 border border-white/10 rounded-xl p-3 text-white text-sm focus:outline-none focus:border-purple-500 transition-all">
                </div>
            </div>
        </div>

        <!-- Estado de Publicación -->
        <div class="p-8 bg-amber-500/5 border-t border-amber-500/10">
            <div class="flex items-center justify-between">
                <div class="flex items-center gap-4">
                    <div class="p-3 bg-amber-500/10 rounded-2xl text-amber-500 border border-amber-500/10">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                    </div>
                    <div>
                        <h4 class="font-bold text-white">Estado de la Ficha</h4>
                        <p class="text-xs text-zinc-400">Si está en modo "Draft", no será visible en el buscador público ni en la Wiki.</p>
                    </div>
                </div>
                <label class="flex items-center gap-3 cursor-pointer group">
                    <span class="text-xs font-bold <?= $species['is_draft'] ? 'text-amber-500' : 'text-emerald-500' ?>">
                        <?= $species['is_draft'] ? 'MODO BORRADOR' : 'PUBLICADA' ?>
                    </span>
                    <div class="relative inline-flex items-center cursor-pointer">
                        <input type="checkbox" name="is_draft" value="1" class="sr-only peer" <?= $species['is_draft'] ? 'checked' : '' ?>>
                        <div class="w-11 h-6 bg-zinc-800 rounded-full peer peer-checked:after:translate-x-full after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-amber-500 border border-white/10"></div>
                    </div>
                </label>
            </div>
        </div>

        <!-- Botones de Acción -->
        <div class="p-8 bg-zinc-900 flex justify-end gap-4">
            <a href="<?= BASE_URL ?>/admin/especies" class="px-8 py-3 rounded-xl border border-white/10 text-zinc-400 hover:bg-white/5 transition-all text-sm font-bold">
                Cancelar
            </a>
            <button type="submit" class="magic-btn px-12 py-3 shadow-xl shadow-blue-500/20">
                Guardar Datos Base
            </button>
        </div>
    </form>
</div>
