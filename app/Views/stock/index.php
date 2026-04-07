<div class="max-w-4xl mx-auto">
    <div class="flex flex-col sm:flex-row items-start sm:items-center gap-4 mb-8">
        <div class="flex items-center gap-3">
            <a href="<?= BASE_URL ?>/" class="p-2 rounded-xl bg-white/5 hover:bg-white/10 border border-white/10 transition-colors text-zinc-400 hover:text-white shrink-0">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
            </a>
            <h1 class="text-3xl md:text-4xl font-black bg-clip-text text-transparent bg-gradient-to-r from-purple-400 via-pink-500 to-orange-400 tracking-tight"><?= __('stock_title') ?></h1>
        </div>
        <p class="text-zinc-500 text-xs font-medium uppercase tracking-[0.2em] sm:ml-auto"><?= __('stock_subtitle') ?></p>
    </div>

    <!-- Sección de Ayuda (Cerrable) -->
    <div class="glass-card p-6 border-orange-500/20 mb-8 relative overflow-hidden group transition-all duration-300" data-help-id="stock_index">
        <button onclick="dismissHelp('stock_index')" class="absolute top-4 right-4 p-2 text-zinc-500 hover:text-white transition-colors" title="Cerrar Ayuda">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
        </button>
        <div class="flex items-start gap-4">
            <div class="p-3 bg-orange-500/10 rounded-2xl text-orange-400 border border-orange-500/10">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path></svg>
            </div>
            <div>
                <h3 class="text-lg font-bold text-white mb-1">Gestión de Despensa</h3>
                <p class="text-sm text-zinc-400 leading-relaxed max-w-2xl">
                    Mantén un registro de tus insectos alimentarios, jarabes y semillas. Al añadir stock aquí, recibirás alertas en tu Dashboard cuando las cantidades sean críticas (< 10 unidades/gramos), asegurando que tus colonias nunca se queden sin recursos.
                </p>
            </div>
        </div>
    </div>

    <!-- Mensajes de éxito o error -->
    <div class="mb-4">
        <?php if (!empty($success)): ?>
            <div class="bg-emerald-500/10 border border-emerald-500/50 text-emerald-400 px-4 py-3 rounded-xl text-sm mb-4">
                <?= htmlspecialchars($success) ?>
            </div>
        <?php endif; ?>
        <?php if (!empty($error)): ?>
            <div class="bg-red-500/10 border border-red-500/50 text-red-500 px-4 py-3 rounded-xl text-sm mb-4">
                <?= htmlspecialchars($error) ?>
            </div>
        <?php endif; ?>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
        <!-- Formulario -->
        <div class="glass-card p-6 h-fit relative overflow-hidden">
            <div class="absolute -inset-10 bg-gradient-to-br from-purple-500/10 to-transparent blur-2xl z-0 pointer-events-none"></div>
            <h3 class="text-xl font-semibold text-white mb-6 relative z-10"><?= __('stock_add_title') ?></h3>
            
            <form method="POST" action="<?= BASE_URL ?>/stock" class="space-y-4 relative z-10">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-zinc-300 mb-1"><?= __('stock_label_food_type') ?></label>
                        <input type="text" name="nombre" required placeholder="<?= __('stock_placeholder_food') ?>" class="magic-input">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-zinc-300 mb-1"><?= __('stock_label_category') ?></label>
                        <select name="categoria" class="magic-input">
                            <option value="Vivo">🦗 <?= __('stock_cat_live') ?></option>
                            <option value="Congelado">❄️ <?= __('stock_cat_frozen') ?></option>
                            <option value="Seco">🍂 <?= __('stock_cat_dry') ?></option>
                            <option value="Jarabes/Líquidos">Honey <?= __('stock_cat_syrup') ?></option>
                            <option value="Semillas">🌾 <?= __('stock_cat_seeds') ?></option>
                            <option value="Otros" selected>📦 <?= __('stock_cat_others') ?></option>
                        </select>
                    </div>
                </div>
                <div class="flex gap-4">
                    <div style="flex: 2;">
                        <label class="block text-sm font-medium text-zinc-300 mb-1"><?= __('stock_label_initial_qty') ?></label>
                        <input type="number" step="0.01" name="cantidad" required placeholder="0.00" class="magic-input">
                    </div>
                    <div style="flex: 1;">
                        <label class="block text-sm font-medium text-zinc-300 mb-1"><?= __('stock_label_unit') ?></label>
                        <select name="unidad" class="magic-input">
                            <option value="g"><?= __('stock_unit_grams') ?></option>
                            <option value="ml"><?= __('stock_unit_ml') ?></option>
                            <option value="uds"><?= __('stock_unit_units') ?></option>
                        </select>
                    </div>
                </div>
                <button type="submit" class="magic-btn w-full mt-4 !py-3"><?= __('stock_btn_add') ?></button>
            </form>
        </div>

        <!-- Inventario -->
        <div class="glass-card p-6 relative overflow-hidden flex flex-col">
            <div class="absolute -inset-10 bg-gradient-to-bl from-pink-500/10 to-transparent blur-2xl z-0 pointer-events-none"></div>
            <h3 class="text-xl font-semibold text-white mb-6 relative z-10"><?= __('stock_inventory_title') ?></h3>
            
            <div class="relative z-10 flex-1">
                <?php if (empty($stocks)): ?>
                    <div class="text-center py-10 border border-dashed border-white/10 rounded-xl bg-white/5">
                        <svg class="w-8 h-8 text-zinc-500 mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 002-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>
                        <p class="text-zinc-400 text-sm"><?= __('stock_empty') ?></p>
                    </div>
                <?php else: ?>
                    <div class="space-y-3 max-h-[400px] overflow-y-auto pr-2" style="scrollbar-width: thin; scrollbar-color: rgba(255,255,255,0.1) transparent;">
                        <?php foreach ($stocks as $s): ?>
                            <div class="group flex items-center justify-between p-4 rounded-xl bg-black/30 border border-white/5 hover:border-white/20 transition-all">
                                <div>
                                    <h4 class="font-medium text-white"><?= htmlspecialchars($s['nombre']) ?></h4>
                                    <div class="flex items-center gap-2 mt-1">
                                        <span class="px-2 py-0.5 rounded text-[10px] font-bold bg-white/5 text-zinc-400 border border-white/5 italic">
                                            <?php 
                                            // Mapping categories stored in Spanish to translation keys
                                            $cat_map = [
                                                'Vivo' => 'stock_cat_live',
                                                'Congelado' => 'stock_cat_frozen',
                                                'Seco' => 'stock_cat_dry',
                                                'Jarabes/Líquidos' => 'stock_cat_syrup',
                                                'Semillas' => 'stock_cat_seeds',
                                                'Otros' => 'stock_cat_others'
                                            ];
                                            echo __($cat_map[$s['categoria']] ?? 'stock_cat_others');
                                            ?>
                                        </span>
                                        <p class="text-sm text-zinc-300 font-bold"><?= $s['cantidad'] ?> <span class="text-zinc-500 font-normal"><?= htmlspecialchars($s['unidad']) ?></span></p>
                                    </div>
                                </div>
                                <form method="POST" action="<?= BASE_URL ?>/stock/<?= $s['id'] ?>" class="m-0 p-0" onsubmit="return confirm('<?= __('stock_confirm_delete') ?>');">
                                    <input type="hidden" name="_method" value="DELETE">
                                    <button type="submit" class="text-red-400/50 hover:text-red-400 transition-colors p-2 bg-transparent border-0 cursor-pointer" title="<?= __('stock_btn_delete') ?>">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                    </button>
                                </form>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>
