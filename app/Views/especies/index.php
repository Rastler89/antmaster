<div class="max-w-7xl mx-auto">
    <div class="flex items-center gap-4 mb-8">
        <a href="<?= BASE_URL ?>/" class="p-2 rounded-full bg-white/5 hover:bg-white/10 border border-white/10 transition-colors text-zinc-400 hover:text-white">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
        </a>
        <div class="flex-1">
            <h1 class="text-3xl font-bold bg-clip-text text-transparent bg-gradient-to-r from-emerald-400 to-blue-500"><?= __('species_title') ?></h1>
            <p class="text-muted text-sm mt-1"><?= __('species_tagline') ?></p>
        </div>
        
        <!-- Live Search Bar -->
        <div class="hidden sm:flex items-center bg-white/5 border border-white/10 rounded-2xl px-4 py-2 focus-within:border-emerald-500/50 transition-all max-w-sm w-full mx-4">
            <svg class="w-4 h-4 text-zinc-500 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
            <input type="text" id="species-search-input" placeholder="Buscar especie..." class="bg-transparent border-none focus:ring-0 text-sm text-white w-full placeholder:text-zinc-600">
        </div>

        <a href="<?= BASE_URL ?>/especies/proponer" class="magic-btn shadow-lg shadow-emerald-500/20 !from-emerald-500 !to-teal-500 active:scale-95 transition-all flex items-center gap-2 whitespace-nowrap">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
            <span class="hidden sm:inline"><?= __('species_btn_new') ?></span>
        </a>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        <?php foreach ($especies as $e): ?>
            <div class="glass-card p-6 relative overflow-hidden group">
                <div class="absolute -inset-1 bg-gradient-to-br from-emerald-500/10 to-blue-500/10 rounded-xl blur-2xl opacity-0 group-hover:opacity-100 transition duration-700 z-0 pointer-events-none"></div>
                
                <div class="relative z-10 flex flex-col h-full">
                    <h2 class="text-xl font-bold text-emerald-400 mb-1"><?= htmlspecialchars($e['nombre']) ?></h2>
                    <p class="italic text-muted text-sm mb-4"><?= htmlspecialchars($e['nombre_cientifico']) ?></p>
                    
                    <div class="flex flex-wrap gap-2 mb-4">
                        <span class="bg-indigo-500/10 text-indigo-400 border border-indigo-500/20 px-2.5 py-1 rounded-md text-xs font-medium">
                            <?php 
                            $diff_map = [
                                'Principiante' => 'diff_beginner',
                                'Intermedio' => 'diff_intermediate',
                                'Avanzado' => 'diff_advanced',
                                'Experto' => 'diff_expert'
                            ];
                            echo __($diff_map[$e['dificultad']] ?? 'diff_beginner');
                            ?>
                        </span>
                        <span class="bg-emerald-500/10 text-emerald-400 border border-emerald-500/20 px-2.5 py-1 rounded-md text-xs font-medium flex items-center gap-1" title="<?= __('species_label_temp') ?>">
                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path></svg>
                            <?= htmlspecialchars($e['temperatura']) ?>
                        </span>
                        <span class="bg-blue-500/10 text-blue-400 border border-blue-500/20 px-2.5 py-1 rounded-md text-xs font-medium flex items-center gap-1" title="<?= __('species_label_hum') ?>">
                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"></path></svg>
                            <?= htmlspecialchars($e['humedad']) ?>
                        </span>
                    </div>

                    <p class="text-sm text-main opacity-80 leading-relaxed mb-6 flex-1">
                        <?= nl2br(htmlspecialchars($e['descripcion'])) ?>
                    </p>

                    <div class="space-y-4 border-t border-white/5 pt-4 mt-auto">
                        <div>
                            <h4 class="text-sm font-semibold text-main mb-1 flex items-center gap-1.5">
                                <span class="bg-orange-500/20 text-orange-400 p-1 rounded">🍽️</span> <?= __('species_label_diet') ?>
                            </h4>
                            <p class="text-xs text-muted leading-relaxed">
                                <?= htmlspecialchars($e['alimentacion']) ?>
                            </p>
                        </div>

                        <div>
                            <h4 class="text-sm font-semibold text-main mb-1 flex items-center gap-1.5">
                                <span class="bg-yellow-500/20 text-yellow-400 p-1 rounded">💡</span> <?= __('species_label_tips') ?>
                            </h4>
                            <p class="text-xs text-muted leading-relaxed">
                                <?= htmlspecialchars($e['consejos_cria']) ?>
                            </p>
                        </div>
                    </div>
                    
                    <div class="mt-4 pt-4 border-t border-white/5 flex justify-end">
                        <a href="<?= BASE_URL ?>/especies/editar/<?= $e['id'] ?>" class="text-xs font-medium bg-blue-500/10 text-blue-400 hover:bg-blue-500/20 px-3 py-1.5 rounded-lg transition-colors flex items-center gap-1.5">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path></svg>
                            <?= __('species_btn_edit_short') ?>
                        </a>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>

<script>
document.getElementById('species-search-input')?.addEventListener('input', function(e) {
    const term = e.target.value.toLowerCase().normalize("NFD").replace(/[\u0300-\u036f]/g, "");
    const cards = document.querySelectorAll('.glass-card');
    
    cards.forEach(card => {
        const h2 = card.querySelector('h2').textContent.toLowerCase();
        const p = card.querySelector('p.italic').textContent.toLowerCase();
        const content = card.textContent.toLowerCase();
        
        if (h2.includes(term) || p.includes(term) || content.includes(term)) {
            card.style.display = 'block';
        } else {
            card.style.display = 'none';
        }
    });
});
</script>
