<div class="glass-card p-10 flex flex-col items-center justify-center text-center">
    <div class="w-32 h-32 mb-6 bg-yellow-500/10 rounded-full flex items-center justify-center border-4 border-yellow-500/20 shadow-[0_0_50px_rgba(234,179,8,0.2)]">
        <span class="text-6xl">🐜</span>
    </div>
    
    <h1 class="text-8xl font-black text-transparent bg-clip-text bg-gradient-to-br from-yellow-400 to-orange-600 mb-2">404</h1>
    <h2 class="text-2xl font-bold text-white mb-4"><?= __('error_404_title') ?></h2>
    
    <p class="text-zinc-400 mb-8 max-w-sm">
        <?= __('error_404_desc') ?>
    </p>

    <a href="<?= defined('BASE_URL') ? BASE_URL : '/' ?>" class="magic-btn group">
        <span class="flex items-center gap-2">
            <svg class="w-5 h-5 group-hover:-translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
            <?= __('error_back_home') ?>
        </span>
    </a>
</div>
