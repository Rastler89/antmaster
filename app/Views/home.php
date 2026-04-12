<?php
// Vista de la Landing Page (Home)
?>

<style>
    @keyframes drawLine {
        from { stroke-dashoffset: 600; }
        to { stroke-dashoffset: 0; }
    }
    .chart-line {
        stroke-dasharray: 600;
        stroke-dashoffset: 600;
    }
    .group:hover .chart-line {
        animation: drawLine 2.5s cubic-bezier(0.4, 0, 0.2, 1) forwards;
        animation-delay: 0.8s;
    }
    .chart-path {
        opacity: 0;
        transform: translateY(10px);
        transition: all 1.5s ease-out;
        transition-delay: 1.2s;
    }
    .group:hover .chart-path {
        opacity: 0.2;
        transform: translateY(0);
    }
</style>

<div class="space-y-24 pb-20">
    <!-- Hero Section -->
    <section class="relative pt-12 md:pt-20 text-center px-4">
        <div class="absolute inset-0 -z-10 flex items-center justify-center opacity-30 blur-3xl overflow-hidden pointer-events-none" aria-hidden="true">
            <div class="w-[500px] h-[500px] bg-blue-600/20 rounded-full animate-blob"></div>
            <div class="w-[400px] h-[400px] bg-purple-600/20 rounded-full animate-blob animation-delay-2000"></div>
        </div>

        <div class="mb-6 flex justify-center">
            <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-white/5 border border-white/10 text-xs font-medium text-blue-400">
                <span class="relative flex h-2 w-2">
                  <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-blue-400 opacity-75"></span>
                  <span class="relative inline-flex rounded-full h-2 w-2 bg-blue-500"></span>
                </span>
                <?= __('version_info', ['version' => APP_VERSION]) ?>
            </div>
        </div>

        <h1 class="text-5xl md:text-7xl font-black tracking-tight mb-6 leading-[1.1]">
            <?= __('hero_title') ?> <br>
            <span class="bg-clip-text text-transparent bg-gradient-to-r from-blue-400 via-purple-500 to-indigo-500"><?= __('hero_subtitle') ?></span>
        </h1>
        
        <p class="text-zinc-400 text-lg md:text-xl max-w-2xl mx-auto mb-10 leading-relaxed">
            <?= __('hero_description') ?>
        </p>

        <div class="flex flex-col sm:flex-row items-center justify-center gap-4">
            <a href="<?= BASE_URL ?>/register" class="magic-btn text-lg px-8 py-4 w-full sm:w-auto" aria-label="Empezar a usar AntMaster Pro">
                <?= __('btn_get_started') ?>
                <svg class="w-5 h-5 ml-2 pointer-events-none" aria-hidden="true" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"></path></svg>
            </a>
            <a href="<?= BASE_URL ?>/login" class="px-8 py-4 rounded-full bg-white/5 border border-white/10 text-zinc-200 font-medium hover:bg-white/10 transition w-full sm:w-auto">
                <?= __('btn_login') ?>
            </a>
        </div>

        <!-- App Preview / Simulation Dashboard -->
        <div class="mt-16 relative max-w-5xl mx-auto group">
            <!-- Glaseado y Contenedor Principal -->
            <div class="glass-card overflow-hidden border-white/10 shadow-2xl relative z-10 aspect-video bg-zinc-950">
                <!-- Browser Header -->
                <div class="h-8 bg-white/5 border-b border-white/10 flex items-center px-4 gap-1.5 shrink-0">
                    <div class="w-2.5 h-2.5 rounded-full bg-red-500/50"></div>
                    <div class="w-2.5 h-2.5 rounded-full bg-yellow-500/50"></div>
                    <div class="w-2.5 h-2.5 rounded-full bg-green-500/50"></div>
                    <div class="ml-4 h-4 w-32 bg-white/5 rounded-full"></div>
                </div>

                <div class="relative h-full flex overflow-hidden">
                    <!-- Dashboard Sidebar Simulation -->
                    <div class="w-12 h-full bg-white/5 border-r border-white/10 flex flex-col items-center py-4 gap-4 transition-all duration-700 group-hover:w-16">
                        <div class="w-6 h-6 rounded-lg bg-blue-500/20 border border-blue-500/30"></div>
                        <div class="w-6 h-6 rounded-lg bg-white/5 border border-white/10"></div>
                        <div class="w-6 h-6 rounded-lg bg-white/5 border border-white/10"></div>
                        <div class="mt-auto w-6 h-6 rounded-full bg-zinc-700"></div>
                    </div>

                    <!-- Dashboard Content Simulation -->
                    <div class="flex-1 p-4 md:p-6 text-left relative overflow-hidden h-full">
                        <!-- Transition Overlay (Normal View) -->
                        <div class="absolute inset-0 z-20 flex flex-col items-center justify-center text-center p-6 bg-black/60 backdrop-blur-md transition-all duration-700 group-hover:opacity-0 group-hover:pointer-events-none group-hover:scale-110">
                            <div class="w-20 h-20 rounded-full bg-blue-500/20 flex items-center justify-center mb-6 border border-blue-500/40 relative">
                                <div class="absolute inset-0 rounded-full animate-ping bg-blue-500/20"></div>
                                <svg class="w-10 h-10 text-blue-400 pointer-events-none" aria-hidden="true" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                            </div>
                            <h3 class="text-2xl font-black text-white mb-2"><?= __('home_analytics_title') ?></h3>
                            <p class="text-zinc-400 text-sm max-w-sm mb-0"><?= __('home_analytics_desc') ?></p>
                        </div>

                        <!-- Real Dashboard Content Simulation (Always there, visible on hover) -->
                        <div class="space-y-6 opacity-0 translate-y-4 transition-all duration-700 delay-100 group-hover:opacity-100 group-hover:translate-y-0 group-hover:blur-0 blur-sm pointer-events-none h-full overflow-hidden">
                            <div class="flex justify-between items-center mb-2">
                                <h4 class="text-lg font-bold text-white"><?= __('dashboard_welcome', ['name' => '<span class="bg-clip-text text-transparent bg-gradient-to-r from-blue-400 to-purple-400">Marabunta</span>']) ?> 👋</h4>
                                <div class="w-24 h-4 bg-white/5 rounded-full"></div>
                            </div>
                            
                            <!-- KPI Cards -->
                            <div class="grid grid-cols-3 gap-3">
                                <div class="bg-white/5 border border-white/10 rounded-xl p-3">
                                    <div class="text-[8px] uppercase font-black text-zinc-500 tracking-widest mb-1 leading-tight"><?= __('home_total_ants') ?></div>
                                    <div class="text-lg font-black text-white leading-none">1,240</div>
                                </div>
                                <div class="bg-white/5 border border-white/10 rounded-xl p-3">
                                    <div class="text-[8px] uppercase font-black text-zinc-500 tracking-widest mb-1 leading-tight"><?= __('home_colonies') ?></div>
                                    <div class="text-lg font-black text-white leading-none">5</div>
                                </div>
                                <div class="bg-white/5 border border-white/10 rounded-xl p-3">
                                    <div class="text-[8px] uppercase font-black text-zinc-500 tracking-widest mb-1 leading-tight"><?= __('home_success_rate') ?></div>
                                    <div class="text-lg font-black text-emerald-400 leading-none">94%</div>
                                </div>
                            </div>

                            <!-- Simulado de Gráfico Global -->
                            <div class="bg-white/5 border border-white/10 rounded-xl p-4 overflow-hidden relative h-[100px] md:h-[180px]">
                                <div class="mb-4 flex items-center justify-between relative z-10 shrink-0">
                                    <div class="text-[10px] font-bold text-zinc-400"><?= __('home_empire_growth') ?></div>
                                    <div class="flex gap-1">
                                        <div class="w-8 h-3 bg-blue-500/50 rounded-full"></div>
                                        <div class="w-8 h-3 bg-white/5 rounded-full"></div>
                                    </div>
                                </div>
                                
                                <!-- Stylized SVG Charts -->
                                <div class="absolute bottom-0 left-0 right-0 h-[60%] md:h-[70%]">
                                    <svg viewBox="0 0 400 100" class="w-full h-full preserve-3d" aria-hidden="true" focusable="false">
                                        <path d="M0,100 L0,80 C40,75 60,95 100,70 C140,45 160,85 200,50 C240,15 260,60 300,30 C340,0 360,40 400,10 L400,100 Z" 
                                              fill="url(#gradient-chart)" fill-opacity="0.2" class="chart-path"></path>
                                        <path d="M0,80 C40,75 60,95 100,70 C140,45 160,85 200,50 C240,15 260,60 300,30 C340,0 360,40 400,10" 
                                              fill="none" stroke="#3b82f6" stroke-width="2.5" class="chart-line"></path>
                                        
                                        <defs>
                                            <linearGradient id="gradient-chart" x1="0" y1="0" x2="0" y2="1">
                                                <stop offset="0%" stop-color="#3b82f6" />
                                                <stop offset="100%" stop-color="transparent" />
                                            </linearGradient>
                                        </defs>
                                    </svg>
                                </div>
                            </div>

                            <!-- Simulado de Tabla / Listado -->
                            <div class="hidden md:block bg-white/5 border border-white/10 rounded-xl overflow-hidden shrink-0">
                                <div class="px-4 py-2 bg-white/5 text-[8px] font-black uppercase text-zinc-500 tracking-widest border-b border-white/5"><?= __('home_recent_colonies') ?></div>
                                <div class="divide-y divide-white/5">
                                    <div class="px-4 py-2 flex items-center justify-between">
                                        <div class="flex items-center gap-2">
                                            <div class="w-5 h-5 rounded bg-zinc-800 text-[10px] flex items-center justify-center">🐜</div>
                                            <span class="text-[10px] font-bold text-white">Messor Barbarus</span>
                                        </div>
                                        <div class="w-16 h-1 bg-white/10 rounded-full"><div class="w-[85%] h-full bg-emerald-500"></div></div>
                                    </div>
                                    <div class="px-4 py-2 flex items-center justify-between">
                                        <div class="flex items-center gap-2">
                                            <div class="w-5 h-5 rounded bg-zinc-800 text-[10px] flex items-center justify-center">🐜</div>
                                            <span class="text-[10px] font-bold text-white">Camponotus Cruentatus</span>
                                        </div>
                                        <div class="w-16 h-1 bg-white/10 rounded-full"><div class="w-[40%] h-full bg-blue-500"></div></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Decorative elements behind browser -->
            <div class="absolute -top-6 -right-6 w-24 h-24 bg-blue-500/20 rounded-full blur-2xl animate-pulse"></div>
            <div class="absolute -bottom-10 -left-10 w-32 h-32 bg-purple-500/20 rounded-full blur-2xl animate-pulse style='animation-delay: 1s'"></div>
        </div>
    </section>

    <!-- Features Grid -->
    <section class="max-w-6xl mx-auto px-4 grid md:grid-cols-3 gap-8">
        <div class="glass-card p-8 group">
            <div class="w-12 h-12 rounded-2xl bg-blue-500/10 border border-blue-500/20 flex items-center justify-center mb-6 group-hover:bg-blue-500 group-hover:text-white transition-all">
                <svg class="w-6 h-6 pointer-events-none" aria-hidden="true" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path></svg>
            </div>
            <h3 class="text-xl font-bold mb-3"><?= __('feature_metrics_title') ?></h3>
            <p class="text-zinc-400 text-sm leading-relaxed"><?= __('feature_metrics_desc') ?></p>
        </div>

        <div class="glass-card p-8 group">
            <div class="w-12 h-12 rounded-2xl bg-purple-500/10 border border-purple-500/20 flex items-center justify-center mb-6 group-hover:bg-purple-500 group-hover:text-white transition-all">
                <svg class="w-6 h-6 pointer-events-none" aria-hidden="true" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.168.477 4 1.253m0-13C13.168 5.477 14.754 5 16.5 5S19.832 6.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4 1.253"></path></svg>
            </div>
            <h3 class="text-xl font-bold mb-3"><?= __('feature_sheets_title') ?></h3>
            <p class="text-zinc-400 text-sm leading-relaxed"><?= __('feature_sheets_desc') ?></p>
        </div>

        <div class="glass-card p-8 group">
            <div class="w-12 h-12 rounded-2xl bg-emerald-500/10 border border-emerald-500/20 flex items-center justify-center mb-6 group-hover:bg-emerald-500 group-hover:text-white transition-all">
                <svg class="w-6 h-6 pointer-events-none" aria-hidden="true" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.684 13.342C8.886 12.938 9 12.482 9 12c0-.482-.114-.938-.316-1.342m0 2.684a3 3 0 110-2.684m0 2.684l6.632 3.316m-6.632-6l6.632-3.316m0 0a3 3 0 105.367-2.684 3 3 0 00-5.367 2.684zm0 9.316a3 3 0 105.368 2.684 3 3 0 00-5.368-2.684z"></path></svg>
            </div>
            <h3 class="text-xl font-bold mb-3"><?= __('feature_diary_title') ?></h3>
            <p class="text-zinc-400 text-sm leading-relaxed"><?= __('feature_diary_desc') ?></p>
        </div>
    </section>

    <!-- Stock / Ecosystem -->
    <section class="max-w-6xl mx-auto px-4">
        <div class="glass-card p-1 md:p-12 overflow-hidden relative">
            <div class="grid md:grid-cols-2 items-center gap-12">
                <div class="p-8 md:p-0">
                    <h2 class="text-3xl md:text-4xl font-bold mb-6"><?= __('home_stock_title') ?></h2>
                    <p class="text-zinc-400 mb-8"><?= __('home_stock_desc') ?></p>
                    <ul class="space-y-4">
                        <li class="flex items-center gap-3 text-zinc-300">
                            <div class="w-5 h-5 rounded-full bg-blue-500/20 flex items-center justify-center border border-blue-500/30">
                                <svg class="w-3 h-3 text-blue-400" aria-hidden="true" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                            </div>
                            <?= __('home_stock_li1') ?>
                        </li>
                        <li class="flex items-center gap-3 text-zinc-300">
                            <div class="w-5 h-5 rounded-full bg-blue-500/20 flex items-center justify-center border border-blue-500/30">
                                <svg class="w-3 h-3 text-blue-400" aria-hidden="true" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                            </div>
                            <?= __('home_stock_li2') ?>
                        </li>
                        <li class="flex items-center gap-3 text-zinc-300">
                            <div class="w-5 h-5 rounded-full bg-blue-500/20 flex items-center justify-center border border-blue-500/30">
                                <svg class="w-3 h-3 text-blue-400" aria-hidden="true" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                            </div>
                            <?= __('home_stock_li3') ?>
                        </li>
                    </ul>
                </div>
                <div class="relative group">
                    <div class="absolute inset-0 bg-blue-600/20 blur-3xl rounded-full opacity-50 group-hover:opacity-75 transition-opacity"></div>
                    <div class="relative glass-card p-6 border-white/5 bg-white/[0.02]">
                        <div class="flex items-center justify-between mb-4 border-b border-white/5 pb-2">
                             <span class="text-xs font-black uppercase tracking-widest text-zinc-500"><?= __('home_stock_status') ?></span>
                             <span class="text-[10px] text-blue-400 font-bold bg-blue-500/10 px-2 py-0.5 rounded"><?= __('home_stock_optimized') ?></span>
                        </div>
                        <div class="space-y-4">
                            <div class="flex items-center justify-between text-sm">
                                <span class="text-zinc-300">Semillas de chía</span>
                                <span class="text-blue-400">850g</span>
                            </div>
                            <div class="w-full h-1.5 bg-white/5 rounded-full overflow-hidden">
                                <div class="w-full h-full bg-gradient-to-r from-blue-500 to-purple-500"></div>
                            </div>
                            <div class="flex items-center justify-between text-sm">
                                <span class="text-zinc-300">Tenebrios (vivos)</span>
                                <span class="text-red-400">¡Bajo! (12 uds)</span>
                            </div>
                            <div class="w-full h-1.5 bg-white/5 rounded-full overflow-hidden">
                                <div class="w-[15%] h-full bg-red-500"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Final CTA -->
    <section class="text-center py-20 px-4">
        <h2 class="text-4xl font-bold mb-6 leading-tight"><?= __('home_cta_title') ?></h2>
        <p class="text-zinc-400 mb-10 max-w-lg mx-auto"><?= __('home_cta_desc') ?></p>
        <a href="<?= BASE_URL ?>/register" class="magic-btn text-lg px-12 py-5">
            <?= __('home_cta_btn') ?>
        </a>
    </section>
</div>
