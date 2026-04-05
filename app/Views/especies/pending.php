<div class="max-w-7xl mx-auto">
    
    <!-- Alertas Globales -->
    <?php if (!empty($success)): ?>
        <div class="mb-6 p-4 rounded-lg bg-emerald-500/10 border border-emerald-500/20 text-emerald-400">
            <?= htmlspecialchars($success) ?>
        </div>
    <?php endif; ?>
    <?php if (!empty($error)): ?>
        <div class="mb-6 p-4 rounded-lg bg-red-500/10 border border-red-500/20 text-red-400">
            <?= htmlspecialchars($error) ?>
        </div>
    <?php endif; ?>

    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-8">
        <div>
            <h1 class="text-3xl font-bold bg-clip-text text-transparent bg-gradient-to-r from-emerald-400 to-blue-500"><?= __('admin_rev_center') ?></h1>
            <p class="text-zinc-400 text-sm mt-1"><?= __('admin_rev_desc') ?></p>
        </div>
        <div class="flex items-center gap-3">
            <a href="<?= BASE_URL ?>/admin/revisiones/historial" class="px-3 py-1.5 rounded-lg bg-white/5 hover:bg-white/10 border border-white/10 text-sm font-medium text-zinc-300 transition-colors flex items-center gap-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                <?= __('admin_rev_history') ?>
            </a>
            <div class="bg-indigo-500/10 text-indigo-400 border border-indigo-500/20 px-3 py-1.5 rounded-lg text-sm font-medium flex items-center gap-2 max-w-fit">
                <?= __('admin_rev_mode') ?>
                <span class="relative flex h-2.5 w-2.5">
                  <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-indigo-400 opacity-75"></span>
                  <span class="relative inline-flex rounded-full h-2.5 w-2.5 bg-indigo-500"></span>
                </span>
            </div>
        </div>
    </div>
    
    <?php if (empty($revisiones)): ?>
        <div class="glass-card p-12 text-center">
            <div class="text-emerald-400/50 mb-3 flex justify-center">
                <svg class="w-16 h-16" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
            </div>
            <h3 class="text-xl font-medium text-white"><?= __('admin_rev_empty') ?></h3>
        </div>
    <?php else: ?>
        <div class="grid grid-cols-1 gap-6">
            <?php foreach ($revisiones as $rev): ?>
            <?php 
                $cambios = json_decode($rev['cambios_solicitados'], true);
                $isNew = is_null($rev['especie_id']);
                $titleText = $isNew ? __('admin_rev_new_species') . ": " . ($cambios['nombre'] ?? '...') : __('species_form_title_edit') . ": " . $rev['especie_nombre'];
                $borderColor = $isNew ? "border-l-emerald-500" : "border-l-blue-500";
                $titleColor = $isNew ? "text-emerald-400" : "text-blue-400";
            ?>
                <div class="glass-card p-6 border-l-4 <?= $borderColor ?> overflow-hidden">
                    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-4">
                        <div>
                            <h2 class="text-lg font-bold text-white flex items-center gap-2">
                                <span class="<?= $titleColor ?>"><?= htmlspecialchars($titleText) ?></span>
                            </h2>
                            <p class="text-sm text-zinc-400 flex items-center gap-1 mt-1">
                                <svg class="w-4 h-4 text-zinc-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                                <?= __('admin_rev_written_by') ?> <strong class="text-zinc-300"><?= htmlspecialchars($rev['usuario_nombre']) ?></strong>
                            </p>
                        </div>
                        <div class="text-xs text-zinc-500 bg-black/20 px-3 py-1.5 rounded-full border border-white/5 max-w-fit">
                            <?= date('d/m/Y, H:i', strtotime($rev['fecha_creacion'])) ?>
                        </div>
                    </div>
                    
                    <div class="bg-black/30 rounded-xl p-5 mb-5 border border-white/5 font-mono text-sm max-h-80 overflow-y-auto custom-scrollbar">
                        <div class="grid grid-cols-1 gap-4">
                            <?php foreach($cambios as $key => $val): ?>
                                <div>
                                    <strong class="text-blue-400 capitalize block mb-1 opacity-80"><?= str_replace('_', ' ', $key) ?>:</strong>
                                    <span class="text-zinc-300 break-words leading-relaxed"><?= nl2br(htmlspecialchars($val)) ?></span>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                    
                    <div class="flex flex-col sm:flex-row gap-3 pt-4 border-t border-white/5">
                        <form method="POST" action="<?= BASE_URL ?>/admin/revisiones/<?= $rev['id'] ?>" class="m-0 sm:ml-auto w-full sm:w-auto on-reject-form">
                            <input type="hidden" name="_method" value="PUT">
                            <input type="hidden" name="action" value="rechazar">
                            <input type="hidden" name="motivo_rechazo" class="motivo_input" value="">
                            <button type="submit" class="w-full sm:w-auto px-5 py-2.5 bg-red-500/10 text-red-500 hover:bg-red-500/20 border border-red-500/20 rounded-xl transition-colors font-medium text-sm flex items-center justify-center gap-2 btn-reject">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                                <?= __('admin_rev_reject') ?>
                            </button>
                        </form>
                        
                        <form method="POST" action="<?= BASE_URL ?>/admin/revisiones/<?= $rev['id'] ?>" class="m-0 w-full sm:w-auto">
                            <input type="hidden" name="_method" value="PUT">
                            <input type="hidden" name="action" value="aprobar">
                            <button type="submit" class="w-full sm:w-auto px-5 py-2.5 bg-emerald-500/10 text-emerald-400 hover:bg-emerald-500/20 border border-emerald-500/30 shadow-[0_0_15px_rgba(16,185,129,0.1)] rounded-xl transition-colors font-medium text-sm flex items-center justify-center gap-2">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                <?= __('admin_rev_approve') ?>
                            </button>
                        </form>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</div>

<script>
document.querySelectorAll('.on-reject-form').forEach(form => {
    form.addEventListener('submit', function(e) {
        e.preventDefault();
        const motivo = prompt('<?= __('admin_rev_reject_motive') ?>');
        if (motivo !== null) {
            this.querySelector('.motivo_input').value = motivo;
            this.submit();
        }
    });
});
</script>
