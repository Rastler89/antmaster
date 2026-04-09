<div class="max-w-6xl mx-auto py-8 px-4">
    <!-- Header -->
    <div class="flex flex-col md:flex-row items-start md:items-center justify-between gap-6 mb-12">
        <div class="flex items-center gap-4">
            <a href="<?= BASE_URL ?>/" class="p-3 rounded-2xl bg-white/5 hover:bg-white/10 border border-white/10 transition-all text-zinc-400 hover:text-white shrink-0 group">
                <svg class="w-6 h-6 group-hover:-translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
            </a>
            <div>
                <h1 class="text-4xl md:text-5xl font-black bg-clip-text text-transparent bg-gradient-to-r from-purple-400 via-pink-500 to-orange-400 tracking-tighter italic">
                    <?= __('stock_title') ?>
                </h1>
                <p class="text-zinc-500 text-xs font-black uppercase tracking-[0.3em] mt-1 italic opacity-70"><?= __('stock_subtitle') ?></p>
            </div>
        </div>
        
        <button onclick="document.getElementById('add-stock-modal').classList.remove('hidden')" class="magic-btn px-8 py-4 text-xs font-black uppercase tracking-widest flex items-center gap-3">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path></svg>
            <?= __('stock_add_title') ?>
        </button>
    </div>

    <!-- Stats summary (Optional, but nice) -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-12">
        <?php 
            $lowStockCount = 0;
            $expiringSoon = 0;
            foreach ($stocks as $s) {
                $threshold = $s['punto_pedido'] ?? 10.00;
                if ($s['cantidad'] <= $threshold) $lowStockCount++;
                if ($s['fecha_caducidad'] && strtotime($s['fecha_caducidad']) < strtotime('+1 week')) $expiringSoon++;
            }
        ?>
        <div class="glass-card p-6 border-zinc-800/50 flex items-center gap-5">
            <div class="w-14 h-14 rounded-2xl bg-blue-500/10 flex items-center justify-center text-blue-400 border border-blue-500/10 shadow-lg shadow-blue-500/5">
                <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path></svg>
            </div>
            <div>
                <p class="text-[10px] font-black uppercase tracking-widest text-zinc-500 mb-1">Items en Stock</p>
                <p class="text-2xl font-black text-white"><?= count($stocks) ?></p>
            </div>
        </div>
        <div class="glass-card p-6 border-orange-500/20 flex items-center gap-5">
            <div class="w-14 h-14 rounded-2xl bg-orange-500/10 flex items-center justify-center text-orange-400 border border-orange-500/10 shadow-lg shadow-orange-500/5">
                <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
            </div>
            <div>
                <p class="text-[10px] font-black uppercase tracking-widest text-zinc-500 mb-1">Stock Crítico</p>
                <p class="text-2xl font-black text-orange-400"><?= $lowStockCount ?></p>
            </div>
        </div>
        <div class="glass-card p-6 border-red-500/20 flex items-center gap-5">
            <div class="w-14 h-14 rounded-2xl bg-red-500/10 flex items-center justify-center text-red-400 border border-red-500/10 shadow-lg shadow-red-500/5">
                <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
            </div>
            <div>
                <p class="text-[10px] font-black uppercase tracking-widest text-zinc-500 mb-1">Caducidad próxima</p>
                <p class="text-2xl font-black text-red-500"><?= $expiringSoon ?></p>
            </div>
        </div>
    </div>

    <!-- Inventory Grid -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
        <?php if (empty($stocks)): ?>
            <div class="lg:col-span-2 text-center py-24 glass-card border-dashed border-white/10 opacity-50">
                <svg class="w-16 h-16 text-zinc-600 mx-auto mb-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path></svg>
                <h3 class="text-2xl font-bold text-zinc-500"><?= __('stock_empty') ?></h3>
            </div>
        <?php else: ?>
            <?php foreach ($stocks as $s): ?>
                <?php $isLow = $s['cantidad'] <= ($s['punto_pedido'] ?? 10.00); ?>
                <div class="glass-card p-8 border-white/5 hover:border-white/20 transition-all group relative overflow-hidden">
                    <!-- Progress Decoration -->
                    <?php $threshold = $s['punto_pedido'] ?? 10.00; ?>
                    <div class="absolute bottom-0 left-0 h-1 bg-gradient-to-r from-purple-500 to-pink-600 transition-all duration-500" style="width: <?= min(100, ($s['cantidad'] / ($threshold * 2)) * 100) ?>%"></div>
                    
                    <div class="flex items-start justify-between mb-8 relative z-10">
                        <div class="flex items-center gap-4">
                            <div class="w-16 h-16 rounded-3xl bg-zinc-800/50 flex items-center justify-center text-3xl border border-white/10 shadow-inner group-hover:scale-110 transition-transform">
                                <?php 
                                    $icons = ['Vivo' => '🦗', 'Congelado' => '❄️', 'Seco' => '🍂', 'Jarabes/Líquidos' => '🍯', 'Semillas' => '🌾', 'Otros' => '📦'];
                                    echo $icons[$s['categoria']] ?? '📦';
                                ?>
                            </div>
                            <div>
                                <h4 class="text-2xl font-black text-white tracking-tight leading-none mb-2"><?= htmlspecialchars($s['nombre']) ?></h4>
                                <div class="flex items-center gap-2">
                                    <span class="px-2 py-0.5 rounded text-[8px] font-black bg-white/5 text-zinc-500 border border-white/5 uppercase tracking-widest italic">
                                        <?= htmlspecialchars($s['categoria']) ?>
                                    </span>
                                    <?php if ($s['fecha_caducidad']): ?>
                                        <span class="text-[9px] font-bold text-zinc-500 flex items-center gap-1">
                                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                            <?= $s['fecha_caducidad'] ?>
                                        </span>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                        <div class="text-right">
                            <p class="text-4xl font-black <?= $isLow ? 'text-orange-500' : 'text-white' ?> tracking-tighter">
                                <?= $s['cantidad'] ?><span class="text-sm font-bold text-zinc-500 lowercase ml-1"><?= htmlspecialchars($s['unidad']) ?></span>
                            </p>
                            <?php if ($isLow): ?>
                                <span class="text-[9px] font-black uppercase text-orange-500/80 animate-pulse">Stock Bajo</span>
                            <?php endif; ?>
                        </div>
                    </div>

                    <?php if ($s['notas']): ?>
                        <p class="text-sm text-zinc-500 italic mb-8 line-clamp-2"><?= htmlspecialchars($s['notas']) ?></p>
                    <?php endif; ?>

                    <div class="flex items-center gap-3 relative z-10">
                        <button onclick="openAdjustModal(<?= $s['id'] ?>, '<?= htmlspecialchars($s['nombre']) ?>', '<?= htmlspecialchars($s['unidad']) ?>')" class="flex-1 py-3 bg-white/5 hover:bg-white/10 text-white text-xs font-black uppercase tracking-widest rounded-xl transition-all border border-white/5 shadow-lg active:scale-95">
                            <?= __('stock_adjust_title') ?>
                        </button>
                        <button onclick="viewHistory(<?= $s['id'] ?>)" class="p-3 bg-white/5 hover:bg-white/10 text-blue-400 rounded-xl transition-all border border-white/5 shadow-lg active:scale-95" title="<?= __('stock_history_title') ?>">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        </button>
                        <form method="POST" action="<?= BASE_URL ?>/stock/<?= $s['id'] ?>" class="m-0" onsubmit="return confirm('<?= __('stock_confirm_delete') ?>');">
                            <input type="hidden" name="_method" value="DELETE">
                            <button type="submit" class="p-3 bg-white/5 hover:bg-red-500/10 text-red-400/50 hover:text-red-400 rounded-xl transition-all border border-white/5 shadow-lg active:scale-95" title="<?= __('stock_btn_delete') ?>">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                            </button>
                        </form>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>
</div>

<!-- Modal: Añadir Nuevo -->
<div id="add-stock-modal" class="fixed inset-0 z-[100] hidden items-center justify-center p-4">
    <div class="absolute inset-0 bg-black/80 backdrop-blur-xl" onclick="this.parentElement.classList.add('hidden')"></div>
    <div class="relative w-full max-w-2xl bg-zinc-900 border border-white/10 shadow-2xl rounded-[3rem] overflow-hidden">
        <div class="px-10 py-12">
            <h3 class="text-4xl font-black text-white tracking-tighter italic mb-2"><?= __('stock_add_title') ?></h3>
            <p class="text-zinc-500 text-sm mb-10">Gestiona tus recursos con precisión militar.</p>
            
            <form method="POST" action="<?= BASE_URL ?>/stock" class="space-y-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="space-y-2">
                        <label class="text-[10px] uppercase font-black text-zinc-500 tracking-widest pl-1"><?= __('stock_label_food_type') ?></label>
                        <input type="text" name="nombre" required placeholder="<?= __('stock_placeholder_food') ?>" class="magic-input w-full">
                    </div>
                    <div class="space-y-2">
                        <label class="text-[10px] uppercase font-black text-zinc-500 tracking-widest pl-1"><?= __('stock_label_category') ?></label>
                        <select name="categoria" class="magic-input w-full">
                            <option value="Vivo">🦗 <?= __('stock_cat_live') ?></option>
                            <option value="Congelado">❄️ <?= __('stock_cat_frozen') ?></option>
                            <option value="Seco">🍂 <?= __('stock_cat_dry') ?></option>
                            <option value="Jarabes/Líquidos">🍯 <?= __('stock_cat_syrup') ?></option>
                            <option value="Semillas">🌾 <?= __('stock_cat_seeds') ?></option>
                            <option value="Otros" selected>📦 <?= __('stock_cat_others') ?></option>
                        </select>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <div class="space-y-2">
                        <label class="text-[10px] uppercase font-black text-zinc-500 tracking-widest pl-1">Cantidad Inicial</label>
                        <input type="number" step="0.01" name="cantidad" required placeholder="0.00" class="magic-input w-full">
                    </div>
                    <div class="space-y-2">
                        <label class="text-[10px] uppercase font-black text-zinc-500 tracking-widest pl-1">Unidad</label>
                        <select name="unidad" class="magic-input w-full">
                            <option value="g"><?= __('stock_unit_grams') ?></option>
                            <option value="ml"><?= __('stock_unit_ml') ?></option>
                            <option value="uds"><?= __('stock_unit_units') ?></option>
                        </select>
                    </div>
                    <div class="space-y-2">
                        <label class="text-[10px] uppercase font-black text-orange-500 tracking-widest pl-1">Aviso Crítico</label>
                        <input type="number" step="0.01" name="punto_pedido" required value="10.00" class="magic-input w-full border-orange-500/20">
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="space-y-2">
                        <label class="text-[10px] uppercase font-black text-zinc-500 tracking-widest pl-1"><?= __('stock_label_expiry') ?></label>
                        <input type="date" name="fecha_caducidad" class="magic-input w-full">
                    </div>
                    <div class="space-y-2">
                        <label class="text-[10px] uppercase font-black text-zinc-500 tracking-widest pl-1"><?= __('stock_label_notes') ?></label>
                        <input type="text" name="notas" placeholder="Ej: Comprado en tienda local" class="magic-input w-full">
                    </div>
                </div>

                <div class="flex gap-4 pt-6">
                    <button type="button" onclick="document.getElementById('add-stock-modal').classList.add('hidden')" class="flex-1 py-4 text-zinc-500 font-bold uppercase tracking-widest rounded-2xl border border-white/5 hover:bg-white/5 transition-colors">
                        <?= __('btn_cancel') ?>
                    </button>
                    <button type="submit" class="flex-[2] magic-btn py-4 text-xs font-black uppercase tracking-widest">
                        <?= __('stock_btn_add') ?>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal: Ajustar -->
<div id="adjust-modal" class="fixed inset-0 z-[100] hidden items-center justify-center p-4">
    <div class="absolute inset-0 bg-black/80 backdrop-blur-xl" onclick="this.parentElement.classList.add('hidden')"></div>
    <div class="relative w-full max-w-lg bg-zinc-900 border border-white/10 shadow-2xl rounded-[3rem] p-10">
        <h3 id="adjust-title" class="text-3xl font-black text-white tracking-tighter italic mb-8">Ajustar Inventario</h3>
        <form id="adjust-form" method="POST" action="" class="space-y-6">
            <div class="flex gap-2 p-1 bg-black/40 rounded-2xl border border-white/5">
                <label class="flex-1 relative cursor-pointer group">
                    <input type="radio" name="tipo" value="ENTRADA" checked class="peer sr-only">
                    <div class="py-3 text-center rounded-xl text-[10px] font-black uppercase tracking-widest transition-all peer-checked:bg-emerald-500 peer-checked:text-white text-zinc-500 hover:text-zinc-300">
                        Entrada / Compra
                    </div>
                </label>
                <label class="flex-1 relative cursor-pointer group">
                    <input type="radio" name="tipo" value="SALIDA" class="peer sr-only">
                    <div class="py-3 text-center rounded-xl text-[10px] font-black uppercase tracking-widest transition-all peer-checked:bg-red-500 peer-checked:text-white text-zinc-500 hover:text-zinc-300">
                        Salida / Consumo
                    </div>
                </label>
            </div>

            <div class="space-y-2">
                <label class="text-[10px] uppercase font-black text-zinc-500 tracking-widest pl-1">Cantidad a cambiar</label>
                <div class="relative flex items-center">
                    <input type="text" inputmode="decimal" name="cantidad" required autocomplete="off" 
                           class="magic-input w-full text-2xl font-black text-white" 
                           style="padding-right: 5.5rem !important;"
                           placeholder="0.00" 
                           oninput="this.value = this.value.replace(/[^0-9.,]/g, '').replace(',', '.')">
                    <span id="adjust-unit" class="magic-indicator absolute right-6 top-1/2 -translate-y-1/2 text-zinc-500 font-bold uppercase text-[10px] tracking-widest bg-transparent pointer-events-none select-none">g</span>
                </div>
            </div>

            <div class="space-y-2">
                <label class="text-[10px] uppercase font-black text-zinc-500 tracking-widest pl-1"><?= __('stock_label_reason') ?></label>
                <input type="text" name="motivo" placeholder="<?= __('stock_placeholder_reason') ?>" required class="magic-input w-full">
            </div>

            <div class="flex gap-4 pt-4">
                <button type="submit" class="flex-1 magic-btn py-4 text-xs font-black uppercase tracking-widest">
                    <?= __('stock_btn_save_adjust') ?>
                </button>
            </div>
        </form>
    </div>
</div>

<!-- Modal: Historial -->
<div id="history-modal" class="fixed inset-0 z-[100] hidden items-center justify-center p-4">
    <div class="absolute inset-0 bg-black/80 backdrop-blur-xl" onclick="this.parentElement.classList.add('hidden')"></div>
    <div class="relative w-full max-w-3xl bg-zinc-900 border border-white/10 shadow-2xl rounded-[3rem] overflow-hidden">
        <div class="p-10">
            <h3 id="history-title-ui" class="text-3xl font-black text-white tracking-tighter italic mb-8">Historial: Item</h3>
            <div id="history-content" class="space-y-4 max-h-[50vh] overflow-y-auto pr-2 custom-scrollbar">
                <!-- Data via JS -->
                <div class="flex items-center justify-center py-10">
                    <div class="w-8 h-8 border-4 border-blue-500 border-t-transparent rounded-full animate-spin"></div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    function openAdjustModal(id, name, unit) {
        const modal = document.getElementById('adjust-modal');
        const form = document.getElementById('adjust-form');
        const title = document.getElementById('adjust-title');
        const unitEl = document.getElementById('adjust-unit');
        
        title.innerText = 'Ajustar: ' + name;
        unitEl.innerText = unit;
        form.action = '<?= BASE_URL ?>/stock/adjust/' + id;
        
        modal.classList.remove('hidden');
        modal.classList.add('flex');
    }

    async function viewHistory(id) {
        const modal = document.getElementById('history-modal');
        const content = document.getElementById('history-content');
        const title = document.getElementById('history-title-ui');
        
        modal.classList.remove('hidden');
        modal.classList.add('flex');
        content.innerHTML = '<div class="flex items-center justify-center py-10"><div class="w-8 h-8 border-4 border-blue-500 border-t-transparent rounded-full animate-spin"></div></div>';

        try {
            const response = await fetch('<?= BASE_URL ?>/api/stock/history/' + id);
            const data = await response.json();
            
            if (data.length === 0) {
                content.innerHTML = '<p class="text-center py-10 text-zinc-500"><?= __('stock_empty_history') ?></p>';
                return;
            }

            content.innerHTML = data.map(m => `
                <div class="flex items-center justify-between p-4 bg-white/5 border border-white/5 rounded-2xl relative overflow-hidden group">
                    <div class="absolute left-0 top-0 h-full w-1 ${m.tipo === 'ENTRADA' ? 'bg-emerald-500' : (m.tipo === 'SALIDA' ? 'bg-red-500' : 'bg-blue-500')}"></div>
                    <div class="flex items-center gap-4 pl-2">
                        <div class="w-10 h-10 rounded-xl ${m.tipo === 'ENTRADA' ? 'bg-emerald-500/10 text-emerald-400' : (m.tipo === 'SALIDA' ? 'bg-red-500/10 text-red-400' : 'bg-blue-500/10 text-blue-400')} flex items-center justify-center text-xs font-black">
                            ${m.tipo === 'ENTRADA' ? '+' : (m.tipo === 'SALIDA' ? '-' : '•')}
                        </div>
                        <div>
                            <p class="text-white font-bold leading-none mb-1">${m.motivo}</p>
                            <p class="text-[10px] text-zinc-500 font-black uppercase tracking-widest">${m.fecha_registro}</p>
                        </div>
                    </div>
                    <div class="text-right pr-2">
                        <p class="text-xl font-black ${m.tipo === 'ENTRADA' ? 'text-emerald-500' : (m.tipo === 'SALIDA' ? 'text-red-500' : 'text-blue-400')}">
                            ${m.tipo === 'ENTRADA' ? '+' : (m.tipo === 'SALIDA' ? '-' : '')}${m.cantidad}
                        </p>
                    </div>
                </div>
            `).join('');
            
        } catch (error) {
            content.innerHTML = '<p class="text-center py-10 text-red-500">Error cargando el historial.</p>';
        }
    }
</script>

<style>
    .magic-input {
        background: rgba(255, 255, 255, 0.03) !important;
        border: 1px solid rgba(255, 255, 255, 0.08) !important;
        border-radius: 1rem !important;
        padding: 0.75rem 1rem;
        padding-right: 1rem !important; /* Base padding */
        color: white !important;
        transition: all 0.3s ease !important;
    }
    .magic-input:focus,
    .magic-input:focus-within {
        background: rgba(255, 255, 255, 0.05) !important;
        border-color: #3b82f6 !important;
        box-shadow: 0 0 20px rgba(59, 130, 246, 0.1) !important;
        outline: none !important;
    }
    .magic-input::-webkit-outer-spin-button,
    .magic-input::-webkit-inner-spin-button {
        -webkit-appearance: none;
        margin: 0;
    }
    .magic-indicator {
        pointer-events: none;
        user-select: none;
        background: transparent !important;
        background-color: transparent !important;
    }
    .custom-scrollbar::-webkit-scrollbar { width: 4px; }
    .custom-scrollbar::-webkit-scrollbar-track { background: transparent; }
    .custom-scrollbar::-webkit-scrollbar-thumb { background: rgba(255,255,255,0.1); border-radius: 10px; }
</style>
