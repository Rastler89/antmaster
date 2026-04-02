<div class="max-w-3xl mx-auto">
    <div class="pb-6">
        <a href="<?= BASE_URL ?>/especies" class="text-sm text-zinc-400 hover:text-white flex items-center gap-1 w-fit mb-4">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
            Volver a la Galería
        </a>
    </div>

    <div class="glass-card p-8">
        <h2 class="text-2xl font-bold text-emerald-400 mb-2">Sugerir Edición: <?= htmlspecialchars($especie['nombre']) ?></h2>
        <p class="text-zinc-400 text-sm mb-6">Tus cambios serán revisados ​​por un Administrador antes de publicarse definitivamente en la guía.</p>

        <form action="<?= BASE_URL ?>/especies/editar/<?= $especie['id'] ?>" method="POST" class="space-y-5">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <div>
                    <label class="block text-sm font-medium text-zinc-300 mb-1">Dificultad</label>
                    <select name="dificultad" class="magic-input w-full focus:ring-1 focus:ring-emerald-500 bg-zinc-900/50">
                        <?php foreach(['Principiante', 'Intermedio', 'Experto', 'Avanzado'] as $d): ?>
                            <option value="<?= $d ?>" <?= $especie['dificultad'] == $d ? 'selected' : '' ?>><?= $d ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-zinc-300 mb-1">Temperatura</label>
                    <input type="text" name="temperatura" value="<?= htmlspecialchars($especie['temperatura']) ?>" class="magic-input w-full" placeholder="Ej: 22-28°C">
                </div>
                <div>
                    <label class="block text-sm font-medium text-zinc-300 mb-1">Humedad</label>
                    <input type="text" name="humedad" value="<?= htmlspecialchars($especie['humedad']) ?>" class="magic-input w-full" placeholder="Ej: 50-70%">
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-zinc-300 mb-1">Crecimiento</label>
                    <input type="text" name="velocidad_crecimiento" value="<?= htmlspecialchars($especie['velocidad_crecimiento'] ?? '') ?>" class="magic-input w-full" placeholder="Ej: Rápido / Moderado">
                </div>
                <div>
                    <label class="block text-sm font-medium text-zinc-300 mb-1">Tamaño (Reina/Obrera)</label>
                    <input type="text" name="tamano" value="<?= htmlspecialchars($especie['tamano'] ?? '') ?>" class="magic-input w-full" placeholder="Ej: R: 15mm, O: 5-8mm">
                </div>
                <div>
                    <label class="block text-sm font-medium text-zinc-300 mb-1">Castas</label>
                    <input type="text" name="castas" value="<?= htmlspecialchars($especie['castas'] ?? '') ?>" class="magic-input w-full" placeholder="Ej: Monomórficas, Soldados...">
                </div>
                <div>
                    <label class="block text-sm font-medium text-zinc-300 mb-1">Reproducción</label>
                    <select name="reproduccion" class="magic-input w-full bg-zinc-900/50">
                        <option value="Monoginia" <?= ($especie['reproduccion'] ?? '') == 'Monoginia' ? 'selected' : '' ?>>Monoginia (1 reina)</option>
                        <option value="Poliginia" <?= ($especie['reproduccion'] ?? '') == 'Poliginia' ? 'selected' : '' ?>>Poliginia (múltiples reinas)</option>
                        <option value="Oligoginia" <?= ($especie['reproduccion'] ?? '') == 'Oligoginia' ? 'selected' : '' ?>>Oligoginia</option>
                    </select>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-zinc-300 mb-1">Vuelos Nupciales</label>
                    <input type="text" name="vuelos" value="<?= htmlspecialchars($especie['vuelos'] ?? '') ?>" class="magic-input w-full" placeholder="Ej: Mayo - Julio">
                </div>
                <div>
                    <label class="block text-sm font-medium text-zinc-300 mb-1">Localización</label>
                    <input type="text" name="localizacion" value="<?= htmlspecialchars($especie['localizacion'] ?? '') ?>" class="magic-input w-full" placeholder="Ej: Europa, Norte de África">
                </div>
            </div>

            <div>
                <label class="block text-sm font-medium text-zinc-300 mb-1">Descripción</label>
                <textarea name="descripcion" class="magic-input w-full h-32" required><?= htmlspecialchars($especie['descripcion']) ?></textarea>
            </div>
            
            <div>
                <label class="block text-sm font-medium text-zinc-300 mb-1 flex items-center gap-2"><span class="text-orange-400">🍽️</span> Alimentación</label>
                <textarea name="alimentacion" class="magic-input w-full h-24" required><?= htmlspecialchars($especie['alimentacion']) ?></textarea>
            </div>

            <div>
                <label class="block text-sm font-medium text-zinc-300 mb-1 flex items-center gap-2"><span class="text-yellow-400">💡</span> Consejos de Cría</label>
                <textarea name="consejos_cria" class="magic-input w-full h-24" required><?= htmlspecialchars($especie['consejos_cria']) ?></textarea>
            </div>

            <div class="flex gap-4 pt-4">
                <a href="<?= BASE_URL ?>/especies" class="w-full text-center px-4 py-3 bg-zinc-800/50 hover:bg-zinc-700/80 text-zinc-300 rounded-xl transition-colors font-medium border border-white/5">Cancelar</a>
                <button type="submit" class="w-full magic-btn shadow-lg shadow-emerald-500/25 !from-emerald-500 !to-teal-500">Enviar Propuesta</button>
            </div>
        </form>
    </div>
</div>
