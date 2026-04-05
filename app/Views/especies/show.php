<div class="max-w-4xl mx-auto">
    <!-- Header / Especie -->
    <div class="flex flex-col md:flex-row items-start md:items-center justify-between mb-8 gap-6">
        <div>
            <a href="<?= BASE_URL ?>/especies" class="inline-flex items-center gap-2 text-zinc-500 hover:text-white mb-2 text-xs md:text-sm transition-colors">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                <?= __('species_back_to_list') ?>
            </a>
            <h1 class="text-3xl md:text-5xl font-black text-white leading-tight"><?= htmlspecialchars($especie['nombre_cientifico']) ?></h1>
            <p class="text-blue-400 text-lg md:text-xl font-bold tracking-tight italic opacity-90 mt-1"><?= htmlspecialchars($especie['nombre']) ?></p>
        </div>
        
        <?php 
        $diffColors = [
            'Principiante' => 'bg-emerald-500/10 text-emerald-400 border-emerald-500/20',
            'Intermedio'   => 'bg-blue-500/10 text-blue-400 border-blue-500/20',
            'Avanzado'     => 'bg-orange-500/10 text-orange-400 border-orange-500/20',
            'Experto'      => 'bg-red-500/10 text-red-400 border-red-500/20'
        ];
        $diff_map = [
            'Principiante' => 'diff_beginner',
            'Intermedio' => 'diff_intermediate',
            'Avanzado' => 'diff_advanced',
            'Experto' => 'diff_expert'
        ];
        $colorClass = $diffColors[$especie['dificultad']] ?? $diffColors['Principiante'];
        ?>
        <div class="w-full md:w-auto px-6 py-3 rounded-2xl border <?= $colorClass ?> flex flex-row md:flex-col items-center justify-between md:justify-center gap-2">
            <span class="text-[10px] uppercase font-black tracking-widest opacity-60"><?= __('species_label_difficulty') ?></span>
            <span class="text-base md:text-lg font-black"><?= __($diff_map[$especie['dificultad']] ?? 'diff_beginner') ?></span>
        </div>
    </div>

    <!-- Quick Info Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
        <!-- Temperatura -->
        <div class="glass-card p-6 flex items-center gap-4 border-orange-500/20 group hover:bg-orange-500/5 transition-all">
            <div class="w-14 h-14 rounded-2xl bg-orange-500/10 flex items-center justify-center text-orange-400 border border-orange-500/10 group-hover:scale-110 transition-transform">
                <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path></svg>
            </div>
            <div>
                <p class="text-[10px] uppercase font-black text-zinc-500 tracking-widest mb-0.5"><?= __('species_label_temp') ?></p>
                <p class="text-xl font-bold text-main"><?= htmlspecialchars($especie['temperatura']) ?></p>
            </div>
        </div>
        
        <!-- Humedad -->
        <div class="glass-card p-6 flex items-center gap-4 border-blue-500/20 group hover:bg-blue-500/5 transition-all">
            <div class="w-14 h-14 rounded-2xl bg-blue-500/10 flex items-center justify-center text-blue-400 border border-blue-500/10 group-hover:scale-110 transition-transform">
                <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86 1.406l-2.32 2.32c-1.21 1.21-3.18 1.21-4.39 0l-2.32-2.32a6 6 0 00-1.406-3.86l.477-2.387a2 2 0 00.547-1.022L12 3l9 9-1.572 3.428z"></path></svg>
            </div>
            <div>
                <p class="text-[10px] uppercase font-black text-zinc-500 tracking-widest mb-0.5"><?= __('species_label_hum') ?></p>
                <p class="text-xl font-bold text-main"><?= htmlspecialchars($especie['humedad']) ?></p>
            </div>
        </div>
    </div>

    <!-- Biological Details -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-8">
        <div class="glass-card p-4 border-white/5">
            <p class="text-[9px] uppercase font-black text-zinc-500 tracking-widest mb-1 italic"><?= __('species_label_growth') ?></p>
            <div class="flex items-center gap-2">
                <span class="text-emerald-400 text-lg">⚡</span>
                <p class="text-sm font-semibold text-main"><?= htmlspecialchars($especie['velocidad_crecimiento'] ?: __('species_no_data')) ?></p>
            </div>
        </div>
        <div class="glass-card p-4 border-white/5">
            <p class="text-[9px] uppercase font-black text-zinc-500 tracking-widest mb-1 italic"><?= __('species_label_size') ?></p>
            <div class="flex items-center gap-2">
                <span class="text-blue-400 text-lg">📏</span>
                <p class="text-sm font-semibold text-main"><?= htmlspecialchars($especie['tamano'] ?: __('species_no_data')) ?></p>
            </div>
        </div>
        <div class="glass-card p-4 border-white/5">
            <p class="text-[9px] uppercase font-black text-zinc-500 tracking-widest mb-1 italic"><?= __('species_label_castes') ?></p>
            <div class="flex items-center gap-2">
                <span class="text-purple-400 text-lg">👥</span>
                <p class="text-sm font-semibold text-main"><?= htmlspecialchars($especie['castas'] ?: __('species_no_data')) ?></p>
            </div>
        </div>
        <?php 
        $repro_map = [
            'Monoginia' => 'species_repro_mono',
            'Poliginia' => 'species_repro_poly',
            'Oligoginia' => 'species_repro_oligo'
        ];
        $repro_val = $repro_map[$especie['reproduccion']] ?? null;
        ?>
        <div class="glass-card p-4 border-white/5">
            <p class="text-[9px] uppercase font-black text-zinc-500 tracking-widest mb-1 italic"><?= __('species_label_reproduction') ?></p>
            <div class="flex items-center gap-2">
                <span class="text-pink-400 text-lg">👑</span>
                <p class="text-sm font-semibold text-main"><?= $repro_val ? __($repro_val) : htmlspecialchars($especie['reproduccion'] ?: __('species_no_data')) ?></p>
            </div>
        </div>
        <div class="glass-card p-4 border-white/5">
            <p class="text-[9px] uppercase font-black text-zinc-500 tracking-widest mb-1 italic"><?= __('species_label_location') ?></p>
            <div class="flex items-center gap-2">
                <span class="text-orange-400 text-lg">🌍</span>
                <p class="text-sm font-semibold text-main"><?= htmlspecialchars($especie['localizacion'] ?: __('species_no_data')) ?></p>
            </div>
        </div>
        <div class="glass-card p-4 border-white/5">
            <p class="text-[9px] uppercase font-black text-zinc-500 tracking-widest mb-1 italic"><?= __('species_label_flights') ?></p>
            <div class="flex items-center gap-2">
                <span class="text-yellow-400 text-lg">✈️</span>
                <p class="text-sm font-semibold text-main"><?= htmlspecialchars($especie['vuelos'] ?: __('species_no_data')) ?></p>
            </div>
        </div>
    </div>

    <!-- Info Sections -->
    <div class="space-y-8">
        <!-- Descripción General -->
        <section class="glass-card p-8 relative overflow-hidden">
            <div class="absolute -top-12 -right-12 w-48 h-48 bg-blue-500/5 rounded-full blur-3xl"></div>
            <h3 class="text-xl font-bold text-main mb-4 flex items-center gap-2 relative z-10">
                <span class="w-8 h-8 rounded-lg bg-white/5 flex items-center justify-center text-sm">📄</span>
                <?= __('species_label_description') ?>
            </h3>
            <div class="text-zinc-400 leading-relaxed relative z-10">
                <?= nl2br(htmlspecialchars($especie['descripcion'])) ?>
            </div>
        </section>

        <!-- Alimentación -->
        <section class="glass-card p-8">
            <h3 class="text-xl font-bold text-main mb-4 flex items-center gap-2">
                <span class="w-8 h-8 rounded-lg bg-orange-500/10 flex items-center justify-center text-sm">🍖</span>
                <?= __('species_label_diet') ?>
            </h3>
            <div class="bg-black/20 p-4 rounded-xl border border-white/5 text-zinc-400">
                <?= nl2br(htmlspecialchars($especie['alimentacion'])) ?>
            </div>
        </section>

        <!-- Consejos de Cría -->
        <section class="glass-card p-8 ring-1 ring-emerald-500/20">
            <h3 class="text-xl font-bold text-main mb-4 flex items-center gap-2">
                <span class="w-8 h-8 rounded-lg bg-emerald-500/10 flex items-center justify-center text-sm">💡</span>
                <?= __('species_label_tips') ?>
            </h3>
            <div class="prose prose-invert max-w-none text-zinc-400 leading-loose">
                <?= nl2br(htmlspecialchars($especie['consejos_cria'])) ?>
            </div>
        </section>
    </div>

    <!-- Footer Action -->
    <div class="mt-12 flex justify-center">
        <a href="<?= BASE_URL ?>/especies/editar/<?= $especie['id'] ?>" class="magic-btn px-10 py-4 flex items-center gap-3">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
            <?= __('species_btn_edit') ?>
        </a>
    </div>
</div>
