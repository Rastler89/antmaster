    <div class="flex items-center justify-between mb-8">
        <div>
            <h1 class="text-3xl font-bold bg-clip-text text-transparent bg-gradient-to-r from-blue-400 to-purple-500"><?= __('colonies_title') ?></h1>
            <p class="text-muted text-sm mt-1"><?= __('colonies_tagline') ?></p>
        </div>
        <a href="<?= BASE_URL ?>/colonias/nueva" class="magic-btn shadow-lg shadow-blue-500/20">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
            <?= __('nav_new_colony') ?>
        </a>
    </div>

    <?php if (empty($colonies)): ?>
        <div class="glass-card p-12 text-center">
            <div class="text-blue-400/30 mb-4 flex justify-center">
                <svg class="w-16 h-16" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>
            </div>
            <h3 class="text-xl font-medium text-main mb-2"><?= __('colony_empty_title') ?></h3>
            <p class="text-muted mb-6"><?= __('colony_empty_desc') ?></p>
            <a href="<?= BASE_URL ?>/colonias/nueva" class="text-blue-400 hover:text-blue-300 font-medium transition flex items-center justify-center gap-2">
                <?= __('colony_create_now') ?> <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
            </a>
        </div>
    <?php else: ?>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            <?php foreach ($colonies as $c): ?>
                <div class="glass-card p-6 group cursor-pointer hover:border-blue-500/30 transition-all" onclick="window.location.href='<?= BASE_URL ?>/colonias/ver/<?= $c['id'] ?>'">
                    <div class="flex justify-between items-start mb-4">
                        <div class="flex items-center gap-4">
                            <?php if ($c['imagen']): ?>
                                <img src="<?= asset('uploads/colonies/' . $c['imagen']) ?>" class="w-12 h-12 rounded-full object-cover border-2 border-blue-500/30">
                            <?php else: ?>
                                <div class="w-12 h-12 rounded-full bg-blue-500/10 flex items-center justify-center text-blue-400 border-2 border-blue-500/20">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"></path></svg>
                                </div>
                            <?php endif; ?>
                            <div>
                                <h3 class="text-lg font-bold text-main group-hover:text-blue-400 transition-colors"><?= htmlspecialchars($c['nombre']) ?></h3>
                                <p class="text-muted text-sm italic"><?= htmlspecialchars($c['especie_nombre']) ?></p>
                            </div>
                        </div>
                        <span class="bg-blue-500/10 text-blue-400 text-[10px] uppercase tracking-wider font-bold px-2 py-1 rounded">
                            <?= htmlspecialchars($c['tipo_hormiguero']) ?>
                        </span>
                    </div>

                    <div class="space-y-3 mb-6">
                        <div class="flex items-center justify-between text-sm">
                            <span class="text-muted"><?= __('colony_card_population') ?></span>
                            <span class="text-main font-medium"><?= number_format($c['poblacion_actual']) ?> <?= __('colony_card_workers') ?></span>
                        </div>
                        <div class="flex items-center justify-between text-sm">
                            <span class="text-muted"><?= __('colony_card_age') ?></span>
                            <span class="text-main font-medium">
                                <?= get_time_elapsed($c['fecha_adquisicion']) ?>
                            </span>
                        </div>
                    </div>

                    <div class="flex justify-end pt-4 border-t border-white/5">
                        <span class="text-blue-400 text-xs font-medium flex items-center gap-1 group-hover:translate-x-1 transition-transform">
                            <?= __('colony_card_details') ?> <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                        </span>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</div>
