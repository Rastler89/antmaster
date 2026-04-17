<!-- Admin Dashboard: Master Command Center 2.0 -->
<div class="space-y-8 pb-12">
    
    <!-- Unified Header -->
    <header class="flex flex-col lg:flex-row justify-between items-start lg:items-center gap-6">
        <div>
            <div class="flex items-center gap-3 mb-1">
                <div class="w-10 h-10 bg-gradient-to-tr from-red-600 to-orange-500 rounded-2xl flex items-center justify-center shadow-lg shadow-red-600/20">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
                </div>
                <h1 class="text-3xl font-black text-white tracking-tight uppercase">Command <span class="text-red-500">Center</span></h1>
            </div>
            <p class="text-[10px] text-zinc-500 flex items-center gap-2 uppercase font-black tracking-widest pl-1">
                <span class="inline-block w-1.5 h-1.5 bg-emerald-500 rounded-full animate-pulse shadow-[0_0_8px_rgba(16,185,129,0.5)]"></span>
                v<?= APP_VERSION ?> • Plataforma Operativa • <?= count($users) ?> agentes
            </p>
        </div>
        
        <!-- Admin Sub-nav -->
        <nav class="flex items-center gap-2 bg-zinc-900/50 p-1.5 rounded-2xl border border-white/5">
            <a href="<?= BASE_URL ?>/admin/dashboard" class="px-5 py-2.5 bg-red-500 text-white rounded-xl font-bold text-xs shadow-lg shadow-red-500/20 transition-all">Panel Maestro</a>
            <a href="<?= BASE_URL ?>/admin/especies" class="px-5 py-2.5 text-zinc-400 hover:text-white hover:bg-white/5 rounded-xl font-bold text-xs transition-all">Catálogo</a>
            <a href="<?= BASE_URL ?>/admin/revisiones" class="px-5 py-2.5 text-zinc-400 hover:text-white hover:bg-white/5 rounded-xl font-bold text-xs transition-all flex items-center gap-2">
                Validaciones
                <?php if ($stats['pending_revisions'] > 0): ?>
                    <span class="bg-orange-500 text-white text-[8px] font-black px-1.5 py-0.5 rounded-full"><?= $stats['pending_revisions'] ?></span>
                <?php endif; ?>
            </a>
        </nav>
    </header>

    <!-- Global Alert Broadcaster (Compact) -->
    <div class="glass-card p-4 border-orange-500/20 bg-orange-500/[0.03] shadow-lg shadow-orange-500/5">
        <div class="flex flex-col md:flex-row items-center gap-5">
            <div class="shrink-0 w-10 h-10 bg-orange-500/20 rounded-xl flex items-center justify-center text-orange-500 border border-orange-500/30">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5.882V19.24a1.76 1.76 0 01-3.417.592l-2.147-6.15M18 13a3 3 0 100-6M5.436 13.683A4.001 4.001 0 017 6h1.832c4.1 0 7.625-1.234 9.168-3v14c-1.543-1.766-5.067-3-9.168-3H7a3.988 3.988 0 01-1.564-.317z"></path></svg>
            </div>
            <div class="flex-grow">
                <h3 class="text-white font-black text-xs uppercase tracking-widest">Comunicado Global</h3>
                <p class="text-[9px] text-zinc-500 font-bold mt-0.5">Visibilidad inmediata para todos los usuarios activos.</p>
            </div>
            <form action="<?= BASE_URL ?>/admin/update_broadcast" method="POST" class="flex-grow md:flex-grow-0 flex items-center gap-2 m-0 mt-2 md:mt-0">
                <input type="text" name="message" value="<?= htmlspecialchars($stats['system_alert'] ?? '') ?>" placeholder="Ej: Mantenimiento programado..." 
                    class="w-full md:w-96 bg-black/60 border border-white/10 rounded-xl py-2.5 px-4 text-xs text-white focus:outline-none focus:border-orange-500/50 transition-all font-medium">
                <button type="submit" class="px-6 py-2.5 bg-orange-500 text-white rounded-xl text-[10px] font-black uppercase tracking-widest hover:bg-orange-600 transition-all shadow-lg shadow-orange-500/20">Emitir</button>
                <?php if (!empty($stats['system_alert'])): ?>
                    <button type="submit" name="message" value="" class="p-2.5 bg-zinc-900 border border-white/5 text-zinc-500 rounded-xl hover:text-red-400 transition-all" title="Retirar comunicado">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                    </button>
                <?php endif; ?>
            </form>
        </div>
    </div>

    <!-- Tier 1 Metrics: Platform Engagement -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 items-start">
        <div class="glass-card p-5 min-h-[110px] items-start flex flex-col justify-between">
             <div class="flex items-start justify-between w-full">
                <div>
                    <p class="text-[10px] text-zinc-500 uppercase font-black tracking-widest mb-1">Engagement (DAU/MAU)</p>
                    <h3 class="text-2xl font-black text-white"><?= $stats['retention_rate'] ?>%</h3>
                </div>
                <div class="p-2.5 bg-blue-500/10 rounded-xl text-blue-400 border border-blue-500/10 shadow-lg shadow-blue-500/5">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path></svg>
                </div>
            </div>
            <p class="text-[9px] text-zinc-400 font-bold mt-2">Usuarios hoy: <?= number_format($stats['users_today']) ?></p>
        </div>

        <div class="glass-card p-5 min-h-[110px] items-start flex flex-col justify-between">
             <div class="flex items-start justify-between w-full">
                <div>
                    <p class="text-[10px] text-zinc-500 uppercase font-black tracking-widest mb-1">Densidad Colonias</p>
                    <h3 class="text-2xl font-black text-white"><?= number_format($stats['total_colonies']) ?></h3>
                </div>
                <div class="p-2.5 bg-purple-500/10 rounded-xl text-purple-400 border border-purple-500/10 shadow-lg shadow-purple-500/5">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 002-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>
                </div>
            </div>
            <p class="text-[9px] text-zinc-400 font-bold mt-2">Media: <?= $stats['avg_colonies_per_user'] ?>/agente</p>
        </div>

        <!-- NEW: Community Health KPI -->
        <div class="glass-card p-5 min-h-[110px] items-start flex flex-col justify-between bg-emerald-500/[0.02]">
             <div class="flex items-start justify-between w-full">
                <div>
                    <p class="text-[10px] text-zinc-500 uppercase font-black tracking-widest mb-1">Índice de Cuidado (24h)</p>
                    <h3 class="text-2xl font-black text-white"><?= $stats['care_index'] ?>%</h3>
                </div>
                <div class="p-2.5 bg-emerald-500/10 rounded-xl text-emerald-400 border border-emerald-500/10 shadow-lg shadow-emerald-500/5">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                </div>
            </div>
            <div class="w-full h-1 bg-white/5 rounded-full mt-2 overflow-hidden">
                <div class="h-full bg-emerald-400" style="width: <?= $stats['care_index'] ?>%"></div>
            </div>
        </div>

        <!-- NEW: Push & Reach KPI -->
        <div class="glass-card p-5 min-h-[110px] items-start flex flex-col justify-between">
             <div class="flex items-start justify-between w-full">
                <div>
                    <p class="text-[10px] text-zinc-500 uppercase font-black tracking-widest mb-1">Alcance Web Push</p>
                    <h3 class="text-2xl font-black text-white"><?= $stats['push_subscriptions'] ?></h3>
                </div>
                <div class="p-2.5 bg-amber-500/10 rounded-xl text-amber-400 border border-amber-500/10 shadow-lg shadow-amber-500/5">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path></svg>
                </div>
            </div>
            <p class="text-[9px] text-zinc-400 font-bold mt-2">Agentes suscritos a alertas</p>
        </div>
    </div>

    <!-- Analytics & Operation Queue Row (NEW) -->
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-start">
        <!-- Gráfico Crecimiento Lineal -->
        <div class="lg:col-span-8 glass-card p-8">
            <h3 class="text-white font-bold text-xl mb-6">Tendencia de Alistamiento</h3>
            <div class="h-[300px]">
                <canvas id="userGrowthChart"></canvas>
            </div>
        </div>

        <!-- NEW: Guide Approval Queue Widget -->
        <div class="lg:col-span-4 glass-card p-0 overflow-hidden flex flex-col border-orange-500/10">
            <div class="p-6 border-b border-white/5 bg-white/[0.02] flex items-center justify-between">
                <h3 class="text-white font-bold text-lg italic">Approval Inbox</h3>
                <span class="bg-orange-500 text-white text-[10px] font-black px-2 py-1 rounded-lg"><?= $stats['pending_revisions'] ?> Ptes</span>
            </div>
            <div class="flex-grow overflow-y-auto max-h-[300px]">
                <?php if (empty($pending_revisions)): ?>
                    <div class="p-12 text-center">
                        <svg class="w-12 h-12 text-zinc-800 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                        <p class="text-zinc-600 font-bold text-sm italic">Queue Clear</p>
                    </div>
                <?php else: ?>
                    <?php foreach ($pending_revisions as $rev): ?>
                        <div class="p-5 border-b border-white/5 hover:bg-white/[0.02] transition-colors group">
                            <div class="flex items-center justify-between mb-2">
                                <span class="text-[10px] font-black text-orange-400 uppercase tracking-widest italic"><?= $rev['especie_nombre'] ?></span>
                                <span class="text-[8px] text-zinc-500 uppercase"><?= get_time_elapsed($rev['fecha_creacion']) ?> ago</span>
                            </div>
                            <p class="text-xs text-zinc-300 font-bold mb-3">Propuesto por: <span class="text-white"><?= $rev['usuario_nombre'] ?></span></p>
                            <a href="<?= BASE_URL ?>/admin/revisiones" class="inline-flex items-center text-[9px] font-black text-white hover:text-orange-400 transition-colors uppercase tracking-widest gap-2">
                                Revisar Propuesta
                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                            </a>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <!-- User Analysis & Activity Metrics -->
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-start">
        <!-- Activity Heatmap -->
        <div class="lg:col-span-8 glass-card p-8">
            <h3 class="text-white font-bold text-xl mb-6 italic">Tactical Activity Graph</h3>
            <div class="h-[180px]">
                <canvas id="activityHeatmapChart"></canvas>
            </div>
        </div>

        <!-- Species Intel Distrib -->
        <div class="lg:col-span-4 glass-card p-8 bg-purple-500/[0.02]">
            <div class="flex items-center justify-between mb-6">
                <h3 class="text-white font-bold text-xl italic">Species Intel</h3>
                <span class="text-[10px] font-black <?= $stats['knowledge_coverage'] > 80 ? 'text-emerald-400' : 'text-amber-400' ?>"><?= $stats['knowledge_coverage'] ?>% verificado</span>
            </div>
            <div class="h-[180px] relative flex items-center justify-center">
                <canvas id="speciesDistChart"></canvas>
                <div class="absolute flex flex-col items-center">
                    <span class="text-2xl font-black text-white"><?= array_sum($chart_species_dist['data']) ?></span>
                </div>
            </div>
        </div>
    </div>

    <!-- Heavy Admin: User Management -->
    <div class="glass-card p-0 overflow-hidden shadow-2xl shadow-black/50">
        <div class="p-8 border-b border-white/5 flex flex-col md:flex-row justify-between items-center gap-6 bg-white/[0.01]">
            <div>
                <h2 class="text-2xl font-black text-white italic tracking-tighter">AGENTS REGISTRY</h2>
                <p class="text-zinc-500 text-[10px] uppercase font-black tracking-widest">Base de Datos de Usuarios Registrados</p>
            </div>
            <div class="relative w-full md:w-96">
                <input type="text" id="userSearch" placeholder="Filtro de búsqueda avanzada..." class="w-full bg-black/40 border border-white/10 rounded-2xl py-3 px-12 text-sm text-white focus:outline-none focus:border-red-500/50 transition-all font-mono">
                <svg class="w-5 h-5 text-zinc-500 absolute left-4 top-1/2 -translate-y-1/2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
            </div>
        </div>
        
        <div class="overflow-x-auto">
            <table class="w-full text-left" id="usersTable">
                <thead class="bg-white/[0.02] text-[9px] uppercase font-black tracking-widest text-zinc-500 border-b border-white/5">
                    <tr>
                        <th class="px-8 py-5">Sinc. Identificador</th>
                        <th class="px-6 py-5">Privilegios</th>
                        <th class="px-6 py-5 text-center">Datos Campo</th>
                        <th class="px-6 py-5 text-center">Compromiso</th>
                        <th class="px-8 py-5 text-right">Acciones</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-white/[0.03]">
                    <?php foreach ($users as $u): ?>
                        <tr class="user-row group hover:bg-white/[0.03] transition-colors <?= $u['is_banned'] ? 'opacity-40 grayscale-[0.8]' : '' ?>">
                            <td class="px-8 py-6">
                                <div class="flex flex-col">
                                    <span class="search-name font-black tracking-tight text-white"><?= htmlspecialchars($u['nombre']) ?></span>
                                    <span class="search-email text-[10px] text-zinc-500 font-mono"><?= htmlspecialchars($u['email']) ?></span>
                                </div>
                            </td>
                            <td class="px-6 py-6">
                                <span class="text-[9px] font-black uppercase tracking-wider px-2 py-1 rounded-lg bg-zinc-900 border border-white/5 <?= $u['rol'] == 'admin' ? 'text-red-400 border-red-500/10' : 'text-blue-400 border-blue-500/10' ?>">
                                    <?= $u['rol'] ?>
                                </span>
                            </td>
                            <td class="px-6 py-6 text-center">
                                <div class="flex items-center justify-center gap-4">
                                    <div class="text-center">
                                        <p class="text-[8px] text-zinc-600 font-bold mb-0.5 uppercase tracking-tighter">Colonies</p>
                                        <p class="text-sm font-black text-white"><?= $u['colonies_count'] ?></p>
                                    </div>
                                    <div class="text-center">
                                        <p class="text-[8px] text-zinc-600 font-bold mb-0.5 uppercase tracking-tighter">Logs</p>
                                        <p class="text-sm font-black text-white"><?= $u['diary_count'] ?></p>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-6 text-center">
                                <div class="flex flex-col items-center">
                                    <span class="text-xs font-black text-zinc-300"><?= SessionTracker::formatDuration($u['avg_session']) ?></span>
                                    <span class="text-[8px] text-zinc-600 uppercase font-bold"><?= SessionTracker::formatDuration($u['total_time']) ?> totales</span>
                                </div>
                            </td>
                            <td class="px-8 py-6 text-right">
                                <div class="flex items-center justify-end gap-3">
                                    <a href="<?= BASE_URL ?>/admin/usuarios/ver/<?= $u['id'] ?>" class="p-2.5 bg-zinc-900/50 border border-white/10 rounded-xl text-zinc-400 hover:text-white hover:bg-zinc-800 transition-all">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                                    </a>
                                     <?php if ($u['id'] != $_SESSION['user_id']): ?>
                                        <form action="<?= BASE_URL ?>/admin/usuarios/ban/<?= $u['id'] ?>" method="POST" class="m-0" onsubmit="return confirm('¿Confirmar protocolo de suspensión para este agente?');">
                                            <button type="submit" class="p-2.5 rounded-xl border border-white/5 transition-all text-[9px] font-black uppercase tracking-widest
                                                <?= $u['is_banned'] ? 'bg-emerald-500/10 text-emerald-400 hover:bg-emerald-500 hover:text-white' : 'bg-red-500/10 text-red-400 hover:bg-red-500 hover:text-white shadow-lg shadow-red-500/10' ?>">
                                                <?= $u['is_banned'] ? 'REINTEGRAR' : 'SUSPENDER' ?>
                                            </button>
                                        </form>
                                    <?php endif; ?>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Final Guard: Action History & Maintenance (NEW) -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8 items-stretch">
        <!-- Events Feed v2 -->
        <div class="glass-card p-0 flex flex-col border-blue-500/10">
            <div class="p-6 border-b border-white/5 bg-white/[0.02]">
                <h3 class="text-white font-bold text-lg italic">Activity Feed</h3>
            </div>
            <div class="overflow-y-auto h-[250px] scrollbar-hide">
                <?php foreach ($recent_events as $event): ?>
                    <div class="px-6 py-4 border-b border-white/5 flex items-center gap-4 hover:bg-white/[0.02] transition-colors relative">
                        <?php if ($event['type'] == 'login'): ?>
                            <div class="absolute left-0 w-1 h-full bg-blue-500/40"></div>
                        <?php endif; ?>
                        <div class="w-2 h-2 rounded-full shrink-0 <?= $event['type'] == 'user_reg' ? 'bg-blue-400 shadow-[0_0_8px_rgba(59,130,246,0.6)]' : ($event['type'] == 'colony_new' ? 'bg-purple-400 shadow-[0_0_8px_rgba(139,92,246,0.6)]' : 'bg-zinc-600') ?>"></div>
                        <div class="flex-grow">
                            <p class="text-xs font-bold text-zinc-300"><?= $event['description'] ?></p>
                            <p class="text-[9px] text-zinc-500 mt-1 uppercase font-black tracking-widest"><?= $event['type'] ?> • <?= get_time_elapsed($event['date']) ?> ago</p>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>

        <!-- System Diagnostics (Improved) -->
        <div class="glass-card p-8 flex flex-col justify-between border-emerald-500/10">
            <div>
                <h4 class="text-zinc-500 text-[10px] font-black uppercase tracking-widest mb-6 italic">System Core Status</h4>
                <div class="space-y-4">
                    <div class="flex items-center justify-between p-4 bg-black/40 rounded-2xl border border-white/5 hover:border-emerald-500/20 transition-all">
                        <span class="text-zinc-500 text-[10px] font-black uppercase tracking-widest">Base de Datos</span>
                        <span class="text-xl font-black text-white italic tracking-tighter"><?= $stats['db_size'] ?></span>
                    </div>
                    <div class="flex items-center justify-between p-4 bg-black/40 rounded-2xl border border-white/5 hover:border-emerald-500/20 transition-all">
                        <span class="text-zinc-500 text-[10px] font-black uppercase tracking-widest">PHP Engine</span>
                        <span class="text-xl font-black text-white italic tracking-tighter">v<?= $stats['server']['php_version'] ?></span>
                    </div>
                </div>
            </div>
            <p class="text-[10px] text-zinc-600 font-bold bg-white/5 p-3 rounded-xl mt-4 italic">Sistema operando bajo parámetros normales.</p>
        </div>

        <!-- NEW: Super Admin Maintenance Toolbox -->
        <div class="glass-card p-8 flex flex-col justify-between border-red-500/10 bg-red-500/[0.01]">
            <div>
                <h4 class="text-red-500/50 text-[10px] font-black uppercase tracking-widest mb-6 italic">Security & Maintenance</h4>
                <div class="space-y-3">
                    <form action="<?= BASE_URL ?>/admin/run_migrations" method="POST" class="m-0" onsubmit="return confirm('¿Forzar sincronización de esquemas?');">
                        <button type="submit" class="w-full px-5 py-4 bg-zinc-900 border border-white/10 rounded-2xl text-white font-black uppercase text-[10px] tracking-widest hover:bg-white hover:text-black transition-all flex items-center justify-between">
                            Sincronizar Arquitectura
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path></svg>
                        </button>
                    </form>
                    <form action="<?= BASE_URL ?>/admin/cleanup_logs" method="POST" class="m-0" onsubmit="return confirm('¿Eliminar todos los logs de sesión antiguos (>30 días)?');">
                        <button type="submit" class="w-full px-5 py-4 bg-zinc-900 border border-red-500/20 rounded-2xl text-red-400 font-black uppercase text-[10px] tracking-widest hover:bg-red-500 hover:text-white transition-all flex items-center justify-between">
                            Log Rotation & Purge
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                        </button>
                    </form>
                </div>
            </div>
            <p class="text-[9px] text-zinc-500 mt-6 leading-relaxed italic">Atención: Las acciones en esta caja son destructivas e irreversibles.</p>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const chartSettings = {
        responsive: true,
        maintainAspectRatio: false,
        plugins: { legend: { display: false } },
        scales: {
            y: { beginAtZero: true, grid: { color: 'rgba(255, 255, 255, 0.03)' }, ticks: { color: '#71717a', font: { size: 10, weight: '900' } } },
            x: { grid: { display: false }, ticks: { color: '#71717a', font: { size: 10, weight: '900' } } }
        }
    };

    // Chart Growth
    new Chart(document.getElementById('userGrowthChart').getContext('2d'), {
        type: 'line',
        data: {
            labels: <?= json_encode($chart_user_growth['labels']) ?>,
            datasets: [{
                data: <?= json_encode($chart_user_growth['data']) ?>,
                borderColor: '#ef4444',
                backgroundColor: 'rgba(239, 68, 68, 0.05)',
                borderWidth: 4, tension: 0.4, fill: true, pointRadius: 0
            }]
        },
        options: chartSettings
    });

    // Chart Species
    new Chart(document.getElementById('speciesDistChart').getContext('2d'), {
        type: 'doughnut',
        data: {
            labels: <?= json_encode($chart_species_dist['labels']) ?>,
            datasets: [{
                data: <?= json_encode($chart_species_dist['data']) ?>,
                backgroundColor: ['#3b82f6', '#8b5cf6', '#ec4899', '#f43f5e', '#f59e0b', '#10b981'],
                borderWidth: 8, borderColor: '#09090b', hoverOffset: 20
            }]
        },
        options: { responsive: true, maintainAspectRatio: false, cutout: '80%', plugins: { legend: { display: false } } }
    });

    // Heatmap
    new Chart(document.getElementById('activityHeatmapChart').getContext('2d'), {
        type: 'bar',
        data: {
            labels: Array.from({length: 24}, (_, i) => `${i}h`),
            datasets: [{
                data: <?= json_encode($heatmap_data) ?>,
                backgroundColor: 'rgba(59, 130, 246, 0.4)', borderRadius: 20, hoverBackgroundColor: '#3b82f6'
            }]
        },
        options: { ...chartSettings, scales: { ...chartSettings.scales, y: { display: false } } }
    });

    // User Search
    const searchInput = document.getElementById('userSearch');
    const userRows = document.querySelectorAll('.user-row');
    searchInput.addEventListener('input', function() {
        const query = this.value.toLowerCase().trim();
        userRows.forEach(row => {
            const name = row.querySelector('.search-name').textContent.toLowerCase();
            const email = row.querySelector('.search-email').textContent.toLowerCase();
            row.style.display = (name.includes(query) || email.includes(query)) ? '' : 'none';
        });
    });
});
</script>
