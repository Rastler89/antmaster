<div class="max-w-7xl mx-auto">
    <div class="flex items-center gap-4 mb-8">
        <a href="<?= BASE_URL ?>/admin/revisiones" class="p-2 rounded-full bg-white/5 hover:bg-white/10 border border-white/10 transition-colors text-zinc-400 hover:text-white">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
        </a>
        <div>
            <h1 class="text-3xl font-bold bg-clip-text text-transparent bg-gradient-to-r from-zinc-400 to-zinc-600"><?= __('admin_rev_hist_title') ?></h1>
            <p class="text-muted text-sm mt-1"><?= __('admin_rev_hist_desc') ?></p>
        </div>
    </div>

    <?php if (empty($revisiones)): ?>
        <div class="glass-card p-12 text-center">
            <p class="text-zinc-400"><?= __('admin_rev_hist_empty') ?></p>
        </div>
    <?php else: ?>
        <div class="glass-card overflow-hidden border-white/5">
            <div class="overflow-x-auto">
                <table class="w-full text-left">
                    <thead class="bg-white/5 text-[10px] uppercase font-black tracking-widest text-zinc-500">
                        <tr>
                            <th class="px-6 py-4"><?= __('admin_rev_table_date') ?></th>
                            <th class="px-6 py-4"><?= __('admin_rev_table_user') ?></th>
                            <th class="px-6 py-4"><?= __('admin_rev_table_specie') ?></th>
                            <th class="px-6 py-4 text-center"><?= __('admin_rev_table_status') ?></th>
                            <th class="px-6 py-4"><?= __('admin_rev_table_details') ?></th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-white/5">
                        <?php foreach ($revisiones as $rev): ?>
                            <?php 
                                $cambios = json_decode($rev['cambios_solicitados'], true);
                                $isNew = is_null($rev['especie_id']);
                                $name = $isNew ? ($cambios['nombre'] ?? '...') : $rev['especie_nombre'];
                            ?>
                            <tr class="hover:bg-white/[0.02] transition-colors">
                                <td class="px-6 py-4 text-xs text-zinc-500 whitespace-nowrap">
                                    <?= date('d/m/Y H:i', strtotime($rev['fecha_creacion'])) ?>
                                </td>
                                <td class="px-6 py-4">
                                    <span class="text-sm font-medium text-white"><?= htmlspecialchars($rev['usuario_nombre']) ?></span>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="flex flex-col">
                                        <span class="text-sm font-bold <?= $isNew ? 'text-emerald-400' : 'text-blue-400' ?>">
                                            <?= $isNew ? '[' . __('admin_rev_new_species') . '] ' : '' ?><?= htmlspecialchars($name) ?>
                                        </span>
                                        <span class="text-[10px] text-zinc-500 italic"><?= htmlspecialchars($cambios['nombre_cientifico'] ?? '') ?></span>
                                    </div>
                                </td>
                                <td class="px-6 py-4 text-center">
                                    <?php if ($rev['estado'] === 'aprobada'): ?>
                                        <span class="px-2 py-1 rounded-md bg-emerald-500/10 text-emerald-500 text-[10px] uppercase font-black border border-emerald-500/20"><?= __('admin_rev_status_approved') ?></span>
                                    <?php else: ?>
                                        <span class="px-2 py-1 rounded-md bg-red-500/10 text-red-500 text-[10px] uppercase font-black border border-red-500/20"><?= __('admin_rev_status_rejected') ?></span>
                                    <?php endif; ?>
                                </td>
                                <td class="px-6 py-4">
                                    <?php if ($rev['estado'] === 'rechazada' && !empty($rev['motivo_rechazo'])): ?>
                                        <div class="text-xs text-zinc-400 bg-red-500/5 p-2 rounded-lg border border-red-500/10 max-w-xs">
                                            <strong class="text-red-400/80"><?= __('admin_rev_motive') ?>:</strong> <?= htmlspecialchars($rev['motivo_rechazo']) ?>
                                        </div>
                                    <?php elseif ($rev['estado'] === 'aprobada'): ?>
                                        <span class="text-[10px] text-zinc-500 italic"><?= __('admin_rev_applied') ?></span>
                                    <?php else: ?>
                                        <span class="text-[10px] text-zinc-600">-</span>
                                    <?php endif; ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    <?php endif; ?>
</div>
