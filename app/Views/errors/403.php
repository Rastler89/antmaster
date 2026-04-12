<div class="glass-card p-10 flex flex-col items-center justify-center text-center">
    <div class="w-32 h-32 mb-6 bg-red-500/10 rounded-full flex items-center justify-center border-4 border-red-500/20 shadow-[0_0_50px_rgba(239,68,68,0.2)]">
        <svg class="w-16 h-16 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
    </div>
    
    <h1 class="text-8xl font-black text-transparent bg-clip-text bg-gradient-to-br from-red-400 to-red-600 mb-2">403</h1>
    <h2 class="text-2xl font-bold text-white mb-4"><?= __('error_403_title') ?></h2>
    
    <p class="text-zinc-400 mb-8 max-w-sm">
        <?= __('error_403_desc') ?>
    </p>

    <a href="<?= defined('BASE_URL') ? BASE_URL : '/' ?>" class="magic-btn group !bg-gradient-to-r !from-red-500 !to-orange-500 border-none">
        <span class="flex items-center gap-2">
            <svg class="w-5 h-5 group-hover:-translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
            <?= __('error_back_retreat') ?>
        </span>
    </a>
</div>
