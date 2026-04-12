<div class="max-w-4xl mx-auto py-12 px-4">
    <div class="text-center mb-16">
        <h1 class="text-5xl font-black text-white mb-6 leading-tight">
            <?= __('about_title') ?>
        </h1>
        <p class="text-xl text-zinc-400 max-w-2xl mx-auto leading-relaxed">
            <?= __('about_subtitle') ?>
        </p>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-16">
        <div class="glass-card p-8 border-blue-500/10">
            <h3 class="text-2xl font-bold text-white mb-4"><?= __('about_mission_title') ?></h3>
            <p class="text-zinc-400 leading-relaxed">
                <?= __('about_mission_desc') ?>
            </p>
        </div>
        <div class="glass-card p-8 border-purple-500/10">
            <h3 class="text-2xl font-bold text-white mb-4"><?= __('about_dev_title') ?></h3>
            <p class="text-zinc-400 leading-relaxed">
                <?= __('about_dev_desc', ['link' => '<a href="https://rastler.dev" class="text-blue-400 hover:underline">rastler.dev</a>']) ?>
            </p>
        </div>
    </div>

    <div class="glass-card p-10 border-zinc-700/30 bg-zinc-900/40">
        <h2 class="text-3xl font-bold text-white mb-8 text-center"><?= __('about_tech_title') ?></h2>
        <div class="grid grid-cols-1 sm:grid-cols-3 gap-8 text-center">
            <div>
                <div class="text-blue-500 mb-4 flex justify-center">
                    <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path></svg>
                </div>
                <h4 class="text-white font-bold mb-2 uppercase text-xs tracking-widest"><?= __('about_tech_secure_title') ?></h4>
                <p class="text-[11px] text-zinc-500"><?= __('about_tech_secure_desc') ?></p>
            </div>
            <div>
                <div class="text-purple-500 mb-4 flex justify-center">
                    <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
                </div>
                <h4 class="text-white font-bold mb-2 uppercase text-xs tracking-widest"><?= __('about_tech_fast_title') ?></h4>
                <p class="text-[11px] text-zinc-500"><?= __('about_tech_fast_desc') ?></p>
            </div>
            <div>
                <div class="text-emerald-500 mb-4 flex justify-center">
                    <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                </div>
                <h4 class="text-white font-bold mb-2 uppercase text-xs tracking-widest"><?= __('about_tech_community_title') ?></h4>
                <p class="text-[11px] text-zinc-500"><?= __('about_tech_community_desc') ?></p>
            </div>
        </div>
    </div>
    
    <div class="mt-16 text-center">
        <a href="<?= BASE_URL ?>/" class="magic-btn px-8 py-3"><?= __('nav_dashboard') ?></a>
    </div>
</div>
