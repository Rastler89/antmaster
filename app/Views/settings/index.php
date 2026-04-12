<div class="max-w-5xl mx-auto">
    <!-- Alertas -->
    <?php if (!empty($success)): ?>
        <div class="mb-6 p-4 rounded-xl bg-emerald-500/10 border border-emerald-500/20 text-emerald-400 flex items-center gap-3 animate-fade-in">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
            <?= htmlspecialchars($success) ?>
        </div>
    <?php endif; ?>

    <div class="mb-10">
        <h1 class="text-3xl font-bold bg-clip-text text-transparent bg-gradient-to-r from-blue-400 to-purple-500"><?= __('settings_title') ?></h1>
        <p class="text-muted mt-2"><?= __('settings_subtitle') ?></p>
    </div>

    <form action="<?= BASE_URL ?>/settings" method="POST">
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            
            <div class="lg:col-span-2 space-y-6">
                <h3 class="text-xl font-semibold text-main flex items-center gap-2">
                    <svg class="w-5 h-5 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21a4 4 0 01-4-4V5a2 2 0 012-2h4a2 2 0 012 2v12a4 4 0 01-4 4zm0 0h12a2 2 0 002-2v-4a2 2 0 00-2-2h-2.343M11 7.343l1.657-1.657a2 2 0 012.828 0l2.829 2.829a2 2 0 010 2.828l-8.486 8.485M7 17h.01"></path></svg>
                    <?= __('settings_themes_title') ?>
                </h3>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <?php foreach ($themes as $id => $theme): ?>
                        <label class="relative cursor-pointer group">
                            <input type="radio" name="theme" value="<?= $id ?>" class="peer sr-only" <?= ($settings['theme'] ?? 'messor') === $id ? 'checked' : '' ?>>
                            <div class="glass-card p-5 border-2 border-transparent peer-checked:border-blue-500 transition-all hover:bg-white/5">
                                <div class="flex items-center justify-between mb-2">
                                    <span class="font-bold text-main"><?= htmlspecialchars($theme['name']) ?></span>
                                    <div class="flex gap-1">
                                        <div class="w-3 h-3 rounded-full" style="background-color: <?= $theme['colors']['primary'] ?>"></div>
                                        <div class="w-3 h-3 rounded-full" style="background-color: <?= $theme['colors']['background'] ?>"></div>
                                    </div>
                                </div>
                                <p class="text-xs text-muted leading-relaxed"><?= htmlspecialchars($theme['description']) ?></p>
                            </div>
                        </label>
                    <?php endforeach; ?>
                </div>
            </div>

            <!-- Accesibilidad -->
            <div class="space-y-6">
                <h3 class="text-xl font-semibold text-main flex items-center gap-2">
                    <svg class="w-5 h-5 text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                    <?= __('settings_accessibility_title') ?>
                </h3>

                <div class="glass-card p-6 space-y-6">
                    <!-- Alto Contraste -->
                    <label class="flex items-center justify-between cursor-pointer group">
                        <span class="text-sm font-medium text-muted group-hover:text-main transition-colors"><?= __('settings_high_contrast') ?></span>
                        <div class="relative inline-flex items-center cursor-pointer">
                            <input type="checkbox" name="high_contrast" class="sr-only peer" <?= ($settings['high_contrast'] ?? false) ? 'checked' : '' ?>>
                            <div class="w-11 h-6 bg-zinc-800 rounded-full peer peer-checked:bg-[var(--theme-primary)] after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:after:translate-x-full border border-white/10"></div>
                        </div>
                    </label>

                    <!-- Reducir Movimiento -->
                    <label class="flex items-center justify-between cursor-pointer group">
                        <span class="text-sm font-medium text-muted group-hover:text-main transition-colors"><?= __('settings_reduced_motion') ?></span>
                        <div class="relative inline-flex items-center cursor-pointer">
                            <input type="checkbox" name="reduced_motion" class="sr-only peer" <?= ($settings['reduced_motion'] ?? false) ? 'checked' : '' ?>>
                            <div class="w-11 h-6 bg-zinc-800 rounded-full peer peer-checked:bg-[var(--theme-primary)] after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:after:translate-x-full border border-white/10"></div>
                        </div>
                    </label>

                    <!-- Daltonismo -->
                    <div class="pt-4 border-t border-white/5">
                        <label class="block text-sm font-medium text-muted mb-3"><?= __('settings_colorblind_mode') ?></label>
                        <select name="colorblind_mode" class="magic-input text-xs">
                            <option value="none" <?= ($settings['colorblind_mode'] ?? 'none') === 'none' ? 'selected' : '' ?>><?= __('settings_colorblind_none') ?></option>
                            <option value="protanopia" <?= ($settings['colorblind_mode'] ?? '') === 'protanopia' ? 'selected' : '' ?>><?= __('settings_colorblind_protanopia') ?></option>
                            <option value="deuteranopia" <?= ($settings['colorblind_mode'] ?? '') === 'deuteranopia' ? 'selected' : '' ?>><?= __('settings_colorblind_deuteranopia') ?></option>
                            <option value="tritanopia" <?= ($settings['colorblind_mode'] ?? '') === 'tritanopia' ? 'selected' : '' ?>><?= __('settings_colorblind_tritanopia') ?></option>
                        </select>
                        <p class="mt-2 text-[10px] text-zinc-500 leading-tight"><?= __('settings_colorblind_desc') ?></p>
                    </div>
                </div>

                <div class="pt-4">
                    <button type="submit" class="magic-btn w-full !from-blue-600 !to-purple-600 shadow-xl shadow-blue-500/20">
                        <?= __('settings_save') ?>
                    </button>
                </div>
            </div>
        </div>
    </form>
</div>
