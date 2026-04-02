<div class="max-w-3xl mx-auto">
    <div class="pb-6">
        <a href="<?= BASE_URL ?>/especies" class="text-sm text-zinc-400 hover:text-white flex items-center gap-1 w-fit mb-4">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
            Volver a la Galería
        </a>
    </div>

    <div class="glass-card p-8 border-emerald-500/20">
        <h2 class="text-2xl font-bold text-white mb-2 flex items-center gap-2">
            <span class="text-emerald-400">🌱</span> Proponer Nueva Especie
        </h2>
        <p class="text-zinc-400 text-sm mb-6">Completa esta ficha para sugerir una especie que aún no está en nuestra base de datos. Un administrador la revisará y la hará pública para toda la comunidad.</p>

        <?php if (isset($_SESSION['error'])): ?>
            <div class="bg-red-500/10 border border-red-500/20 text-red-400 p-4 rounded-xl mb-6 text-sm">
                <?= htmlspecialchars($_SESSION['error']) ?>
                <?php unset($_SESSION['error']); ?>
            </div>
        <?php endif; ?>

        <form action="<?= BASE_URL ?>/especies/proponer" method="POST" class="space-y-5">
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-bold text-white mb-1">Nombre Común <span class="text-red-500">*</span></label>
                    <input type="text" name="nombre" class="magic-input w-full" placeholder="Ej: Hormiga Argentina" required>
                </div>
                <div>
                    <label class="block text-sm font-bold text-white mb-1">Nombre Científico <span class="text-red-500">*</span></label>
                    <input type="text" name="nombre_cientifico" class="magic-input w-full italic" placeholder="Ej: Linepithema humile" required>
                </div>
            </div>

            <hr class="border-white/5 my-4">

            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <div>
                    <label class="block text-sm font-medium text-zinc-300 mb-1">Dificultad</label>
                    <select name="dificultad" class="magic-input w-full focus:ring-1 focus:ring-emerald-500 bg-zinc-900/50">
                        <option value="Principiante">Principiante</option>
                        <option value="Intermedio">Intermedio</option>
                        <option value="Avanzado">Avanzado</option>
                        <option value="Experto">Experto</option>
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-zinc-300 mb-1">Temperatura</label>
                    <input type="text" name="temperatura" class="magic-input w-full" placeholder="Ej: 22-28°C">
                </div>
                <div>
                    <label class="block text-sm font-medium text-zinc-300 mb-1">Humedad</label>
                    <input type="text" name="humedad" class="magic-input w-full" placeholder="Ej: 50-70%">
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-zinc-300 mb-1">Crecimiento</label>
                    <input type="text" name="velocidad_crecimiento" class="magic-input w-full" placeholder="Ej: Rápido / Moderado">
                </div>
                <div>
                    <label class="block text-sm font-medium text-zinc-300 mb-1">Tamaño (Reina/Obrera)</label>
                    <input type="text" name="tamano" class="magic-input w-full" placeholder="Ej: R: 15mm, O: 5-8mm">
                </div>
                <div>
                    <label class="block text-sm font-medium text-zinc-300 mb-1">Castas</label>
                    <input type="text" name="castas" class="magic-input w-full" placeholder="Ej: Monomórficas, Soldados...">
                </div>
                <div>
                    <label class="block text-sm font-medium text-zinc-300 mb-1">Reproducción</label>
                    <select name="reproduccion" class="magic-input w-full bg-zinc-900/50">
                        <option value="Monoginia">Monoginia (1 reina)</option>
                        <option value="Poliginia">Poliginia (múltiples reinas)</option>
                        <option value="Oligoginia">Oligoginia</option>
                    </select>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-zinc-300 mb-1">Vuelos Nupciales</label>
                    <input type="text" name="vuelos" class="magic-input w-full" placeholder="Ej: Mayo - Julio">
                </div>
                <div>
                    <label class="block text-sm font-medium text-zinc-300 mb-1">Localización</label>
                    <input type="text" name="localizacion" class="magic-input w-full" placeholder="Ej: Europa, Norte de África">
                </div>
            </div>

            <div>
                <label class="block text-sm font-medium text-zinc-300 mb-1">Descripción general</label>
                <textarea name="descripcion" class="magic-input w-full h-32" placeholder="Describe el comportamiento, historia o peculiaridades de esta especie." required></textarea>
            </div>
            
            <div>
                <label class="block text-sm font-medium text-zinc-300 mb-1 flex items-center gap-2"><span class="text-orange-400">🍽️</span> Alimentación</label>
                <textarea name="alimentacion" class="magic-input w-full h-24" placeholder="¿Qué comen en cautividad?" required></textarea>
            </div>

            <div>
                <label class="block text-sm font-medium text-zinc-300 mb-1 flex items-center gap-2"><span class="text-yellow-400">💡</span> Consejos de Cría</label>
                <textarea name="consejos_cria" class="magic-input w-full h-24" placeholder="¿Algún truco especial para su cría y supervivencia?" required></textarea>
            </div>

            <div class="flex gap-4 pt-4">
                <a href="<?= BASE_URL ?>/especies" class="w-full text-center px-4 py-3 bg-zinc-800/50 hover:bg-zinc-700/80 text-zinc-300 rounded-xl transition-colors font-medium border border-white/5">Cancelar</a>
                <button type="submit" class="w-full magic-btn shadow-lg shadow-emerald-500/25 !from-emerald-500 !to-teal-500">Enviar Nueva Especie</button>
            </div>
        </form>
    </div>
</div>
