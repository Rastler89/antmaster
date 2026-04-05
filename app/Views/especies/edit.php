<div class="max-w-3xl mx-auto">
    <div class="pb-6">
        <a href="<?= BASE_URL ?>/especies" class="text-sm text-zinc-400 hover:text-white flex items-center gap-1 w-fit mb-4">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
            <?= __('species_back_to_list') ?>
        </a>
    </div>

    <div class="glass-card p-8">
        <h2 class="text-2xl font-bold text-emerald-400 mb-2"><?= __('species_form_title_edit') ?>: <?= htmlspecialchars($especie['nombre']) ?></h2>
        <p class="text-zinc-400 text-sm mb-6"><?= __('species_form_desc_edit') ?></p>

        <form action="<?= BASE_URL ?>/especies/editar/<?= $especie['id'] ?>" method="POST" class="space-y-5">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <div>
                    <label class="block text-sm font-medium text-zinc-300 mb-1"><?= __('species_label_difficulty') ?></label>
                    <select name="dificultad" class="magic-input w-full focus:ring-1 focus:ring-emerald-500 bg-zinc-900/50">
                        <?php 
                        $diffs = [
                            'Principiante' => 'diff_beginner',
                            'Intermedio' => 'diff_intermediate',
                            'Avanzado' => 'diff_advanced',
                            'Experto' => 'diff_expert'
                        ];
                        foreach($diffs as $val => $key): ?>
                            <option value="<?= $val ?>" <?= $especie['dificultad'] == $val ? 'selected' : '' ?>><?= __($key) ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-zinc-300 mb-1"><?= __('species_label_temp') ?></label>
                    <input type="text" name="temperatura" value="<?= htmlspecialchars($especie['temperatura']) ?>" class="magic-input w-full" placeholder="<?= __('species_placeholder_temp') ?>">
                </div>
                <div>
                    <label class="block text-sm font-medium text-zinc-300 mb-1"><?= __('species_label_hum') ?></label>
                    <input type="text" name="humedad" value="<?= htmlspecialchars($especie['humedad']) ?>" class="magic-input w-full" placeholder="<?= __('species_placeholder_hum') ?>">
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-zinc-300 mb-1"><?= __('species_label_growth') ?></label>
                    <input type="text" name="velocidad_crecimiento" value="<?= htmlspecialchars($especie['velocidad_crecimiento'] ?? '') ?>" class="magic-input w-full" placeholder="<?= __('species_placeholder_growth') ?>">
                </div>
                <div>
                    <label class="block text-sm font-medium text-zinc-300 mb-1"><?= __('species_label_size') ?></label>
                    <input type="text" name="tamano" value="<?= htmlspecialchars($especie['tamano'] ?? '') ?>" class="magic-input w-full" placeholder="<?= __('species_placeholder_size') ?>">
                </div>
                <div>
                    <label class="block text-sm font-medium text-zinc-300 mb-1"><?= __('species_label_castes') ?></label>
                    <input type="text" name="castas" value="<?= htmlspecialchars($especie['castas'] ?? '') ?>" class="magic-input w-full" placeholder="<?= __('species_placeholder_castes') ?>">
                </div>
                <div>
                    <label class="block text-sm font-medium text-zinc-300 mb-1"><?= __('species_label_reproduction') ?></label>
                    <select name="reproduccion" class="magic-input w-full bg-zinc-900/50">
                        <option value="Monoginia" <?= ($especie['reproduccion'] ?? '') == 'Monoginia' ? 'selected' : '' ?>><?= __('species_repro_mono_desc') ?></option>
                        <option value="Poliginia" <?= ($especie['reproduccion'] ?? '') == 'Poliginia' ? 'selected' : '' ?>><?= __('species_repro_poly_desc') ?></option>
                        <option value="Oligoginia" <?= ($especie['reproduccion'] ?? '') == 'Oligoginia' ? 'selected' : '' ?>><?= __('species_repro_oligo') ?></option>
                    </select>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-zinc-300 mb-1"><?= __('species_label_flights') ?></label>
                    <input type="text" name="vuelos" value="<?= htmlspecialchars($especie['vuelos'] ?? '') ?>" class="magic-input w-full" placeholder="<?= __('species_placeholder_flights') ?>">
                </div>
                <div>
                    <label class="block text-sm font-medium text-zinc-300 mb-1"><?= __('species_label_location') ?></label>
                    <input type="text" name="localizacion" value="<?= htmlspecialchars($especie['localizacion'] ?? '') ?>" class="magic-input w-full" placeholder="<?= __('species_placeholder_location') ?>">
                </div>
            </div>

            <div>
                <label class="block text-sm font-medium text-zinc-300 mb-1"><?= __('species_label_description') ?></label>
                <textarea name="descripcion" class="magic-input w-full h-32" placeholder="<?= __('species_placeholder_desc') ?>" required><?= htmlspecialchars($especie['descripcion']) ?></textarea>
            </div>
            
            <div>
                <label class="block text-sm font-medium text-zinc-300 mb-1 flex items-center gap-2"><span class="text-orange-400">🍽️</span> <?= __('species_label_diet') ?></label>
                <textarea name="alimentacion" class="magic-input w-full h-24" placeholder="<?= __('species_placeholder_diet') ?>" required><?= htmlspecialchars($especie['alimentacion']) ?></textarea>
            </div>

            <div>
                <label class="block text-sm font-medium text-zinc-300 mb-1 flex items-center gap-2"><span class="text-yellow-400">💡</span> <?= __('species_label_tips') ?></label>
                <textarea name="consejos_cria" class="magic-input w-full h-24" placeholder="<?= __('species_placeholder_tips') ?>" required><?= htmlspecialchars($especie['consejos_cria']) ?></textarea>
            </div>

            <div class="flex gap-4 pt-4">
                <a href="<?= BASE_URL ?>/especies" class="w-full text-center px-4 py-3 bg-zinc-800/50 hover:bg-zinc-700/80 text-zinc-300 rounded-xl transition-colors font-medium border border-white/5"><?= __('btn_cancel') ?></a>
                <button type="submit" class="w-full magic-btn shadow-lg shadow-emerald-500/25 !from-emerald-500 !to-teal-500"><?= __('species_btn_send_edit') ?></button>
            </div>
        </form>
    </div>
</div>
