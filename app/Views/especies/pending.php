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
            <h1 class="text-3xl font-bold bg-clip-text text-transparent bg-gradient-to-r from-emerald-400 to-blue-500">Centro de Revisiones</h1>
            <p class="text-zinc-400 text-sm mt-1">Evalúa moderadamente las modificaciones propuestas por la comunidad.</p>
        </div>
        <div class="bg-indigo-500/10 text-indigo-400 border border-indigo-500/20 px-3 py-1.5 rounded-lg text-sm font-medium flex items-center gap-2 max-w-fit">
            Modo Administrador
            <span class="relative flex h-2.5 w-2.5">
              <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-indigo-400 opacity-75"></span>
              <span class="relative inline-flex rounded-full h-2.5 w-2.5 bg-indigo-500"></span>
            </span>
        </div>
    </div>
    
    <?php if (empty($revisiones)): ?>
        <div class="glass-card p-12 text-center">
            <div class="text-emerald-400/50 mb-3 flex justify-center">
                <svg class="w-16 h-16" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
            </div>
            <h3 class="text-xl font-medium text-white">Todo limpio y al día</h3>
            <p class="text-zinc-400 mt-2">No hay sugerencias de edición pendientes de revisar. Descansa.</p>
        </div>
    <?php else: ?>
        <div class="grid grid-cols-1 gap-6">
            <?php foreach ($revisiones as $rev): ?>
            <?php $cambios = json_decode($rev['cambios_solicitados'], true); ?>
                <div class="glass-card p-6 border-l-4 border-l-blue-500 overflow-hidden">
                    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-4">
                        <div>
                            <h2 class="text-lg font-bold text-white flex items-center gap-2">
                                Propuesta para: <span class="text-emerald-400"><?= htmlspecialchars($rev['especie_nombre']) ?></span>
                            </h2>
                            <p class="text-sm text-zinc-400 flex items-center gap-1 mt-1">
                                <svg class="w-4 h-4 text-zinc-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                                Escrito por <strong class="text-zinc-300"><?= htmlspecialchars($rev['usuario_nombre']) ?></strong>
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
                        <form method="POST" action="<?= BASE_URL ?>/admin/revisiones/<?= $rev['id'] ?>" class="m-0 sm:ml-auto w-full sm:w-auto">
                            <input type="hidden" name="_method" value="PUT">
                            <input type="hidden" name="action" value="rechazar">
                            <button type="submit" class="w-full sm:w-auto px-5 py-2.5 bg-red-500/10 text-red-500 hover:bg-red-500/20 border border-red-500/20 rounded-xl transition-colors font-medium text-sm flex items-center justify-center gap-2">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                                Rechazar y Borrar
                            </button>
                        </form>
                        
                        <form method="POST" action="<?= BASE_URL ?>/admin/revisiones/<?= $rev['id'] ?>" class="m-0 w-full sm:w-auto">
                            <input type="hidden" name="_method" value="PUT">
                            <input type="hidden" name="action" value="aprobar">
                            <button type="submit" class="w-full sm:w-auto px-5 py-2.5 bg-emerald-500/10 text-emerald-400 hover:bg-emerald-500/20 border border-emerald-500/30 shadow-[0_0_15px_rgba(16,185,129,0.1)] rounded-xl transition-colors font-medium text-sm flex items-center justify-center gap-2">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                Aprobar en Guía Pública
                            </button>
                        </form>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</div>
