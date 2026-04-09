<!-- Header Administrador -->
<div class="flex flex-col md:flex-row justify-between items-center mb-8 gap-4">
    <div>
        <h1 class="text-3xl font-black text-white">
            <span class="bg-clip-text text-transparent bg-gradient-to-r from-red-400 via-orange-500 to-yellow-500">Panel de Control</span> 🛡️
        </h1>
        <p class="text-zinc-500 text-sm mt-1">Visión general del estado del sistema y gestión de usuarios.</p>
    </div>
    <div class="flex items-center gap-3">
        <form action="<?= BASE_URL ?>/admin/run_migrations" method="POST" class="m-0" onsubmit="return confirm('¿Estás seguro de forzar la ejecución de migraciones en la base de datos?');">
            <button type="submit" class="px-5 py-2.5 bg-zinc-500/10 border border-zinc-500/20 text-zinc-400 rounded-2xl hover:bg-zinc-500 hover:text-white transition-all text-xs font-black uppercase flex items-center gap-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path></svg>
                Migraciones
            </button>
        </form>
        <a href="<?= BASE_URL ?>/admin/especies" class="px-5 py-2.5 bg-indigo-500/10 border border-indigo-500/20 text-indigo-400 rounded-2xl hover:bg-indigo-500 hover:text-white transition-all text-xs font-black uppercase flex items-center gap-2">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5h12M9 3v2m1.048 9.5A18.022 18.022 0 016.412 9m6.088 9h7M11 21l5-10 5 10M12.751 5C11.783 10.77 8.07 15.61 3 18.129"></path></svg>
            Gestionar Traducciones
        </a>
    </div>
</div>

<!-- KPI Cards -->
<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-6 gap-6 mb-8">
    <div class="glass-card p-6 border-blue-500/10 overflow-hidden relative group hover:bg-blue-500/5 transition-all">
        <div class="absolute -right-4 -top-4 w-24 h-24 bg-blue-500/10 rounded-full blur-2xl group-hover:scale-150 transition-transform duration-700"></div>
        <p class="text-[10px] uppercase font-black text-zinc-500 tracking-widest mb-3">Total Usuarios</p>
        <div class="flex items-end justify-between">
            <h3 class="text-4xl font-black text-white"><?= number_format($stats['total_users']) ?></h3>
            <div class="p-3 bg-blue-500/10 rounded-2xl text-blue-400 border border-blue-500/10">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
            </div>
        </div>
    </div>

    <div class="glass-card p-6 border-emerald-500/10 overflow-hidden relative group hover:bg-emerald-500/5 transition-all">
        <div class="absolute -right-4 -top-4 w-24 h-24 bg-emerald-500/10 rounded-full blur-2xl group-hover:scale-150 transition-transform duration-700"></div>
        <p class="text-[10px] uppercase font-black text-zinc-500 tracking-widest mb-3">Activos (30D)</p>
        <div class="flex items-end justify-between">
            <h3 class="text-4xl font-black text-white"><?= number_format($stats['active_users']) ?></h3>
            <div class="p-3 bg-emerald-500/10 rounded-2xl text-emerald-400 border border-emerald-500/10">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
            </div>
        </div>
    </div>

    <div class="glass-card p-6 border-purple-500/10 overflow-hidden relative group hover:bg-purple-500/5 transition-all">
        <div class="absolute -right-4 -top-4 w-24 h-24 bg-purple-500/10 rounded-full blur-2xl group-hover:scale-150 transition-transform duration-700"></div>
        <p class="text-[10px] uppercase font-black text-zinc-500 tracking-widest mb-3">Total Colonias</p>
        <div class="flex items-end justify-between">
            <h3 class="text-4xl font-black text-white"><?= number_format($stats['total_colonies']) ?></h3>
            <div class="p-3 bg-purple-500/10 rounded-2xl text-purple-400 border border-purple-500/10">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 002-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>
            </div>
        </div>
    </div>

    <div class="glass-card p-6 border-red-500/10 overflow-hidden relative group hover:bg-red-500/5 transition-all">
        <div class="absolute -right-4 -top-4 w-24 h-24 bg-red-500/10 rounded-full blur-2xl group-hover:scale-150 transition-transform duration-700"></div>
        <p class="text-[10px] uppercase font-black text-zinc-500 tracking-widest mb-3">Baneados</p>
        <div class="flex items-end justify-between">
            <h3 class="text-4xl font-black text-white"><?= number_format($stats['banned_users']) ?></h3>
            <div class="p-3 bg-red-500/10 rounded-2xl text-red-400 border border-red-500/10">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636"></path></svg>
            </div>
        </div>
    </div>

    <a href="<?= BASE_URL ?>/admin/revisiones" class="glass-card p-6 border-orange-500/20 overflow-hidden relative group hover:bg-orange-500/10 hover:border-orange-500/40 transition-all cursor-pointer">
        <div class="absolute -right-4 -top-4 w-24 h-24 bg-orange-500/10 rounded-full blur-2xl group-hover:scale-150 transition-transform duration-700"></div>
        <p class="text-[10px] uppercase font-black text-zinc-500 tracking-widest mb-3 group-hover:text-orange-400 transition-colors">Revisiones Guías</p>
        <div class="flex items-end justify-between">
            <h3 class="text-4xl font-black text-white"><?= number_format($stats['pending_revisions'] ?? 0) ?></h3>
            <div class="p-3 bg-orange-500/10 rounded-2xl text-orange-400 border border-orange-500/10 group-hover:bg-orange-500 group-hover:text-white transition-all">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
            </div>
        </div>
    </a>

    <a href="<?= BASE_URL ?>/admin/especies" class="glass-card p-6 border-amber-500/20 overflow-hidden relative group hover:bg-amber-500/10 hover:border-amber-500/40 transition-all cursor-pointer">
        <div class="absolute -right-4 -top-4 w-24 h-24 bg-amber-500/10 rounded-full blur-2xl group-hover:scale-150 transition-transform duration-700"></div>
        <p class="text-[10px] uppercase font-black text-zinc-500 tracking-widest mb-3 group-hover:text-amber-400 transition-colors">Especies Draft</p>
        <div class="flex items-end justify-between">
            <h3 class="text-4xl font-black text-white"><?= number_format($stats['draft_species_count'] ?? 0) ?></h3>
            <div class="p-3 bg-amber-500/10 rounded-2xl text-amber-400 border border-amber-500/10 group-hover:bg-amber-500 group-hover:text-white transition-all">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v3m0 0v3m0-3h3m-3 0H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
            </div>
        </div>
    </a>
</div>

<!-- Scripts de Chart.js (Solo en esta vista) -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<!-- Gráficos del Sistema -->
<div class="grid grid-cols-1 lg:grid-cols-12 gap-8 mb-8">
    
    <!-- Crecimiento de Usuarios (60% del ancho en desktop) -->
    <div class="lg:col-span-8 glass-card p-6 border-blue-500/10 flex flex-col">
        <div class="flex items-center justify-between mb-6">
            <div>
                <h3 class="text-white font-bold text-lg">Crecimiento de Usuarios</h3>
                <p class="text-[10px] text-zinc-500 uppercase tracking-widest font-black">Registros mensuales (Últimos 12 meses)</p>
            </div>
            <div class="p-2 bg-blue-500/10 rounded-lg text-blue-400">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 12l3-3 3 3 4-4M8 21l4-4 4 4M3 4h18M4 4h16v12a1 1 0 01-1 1H5a1 1 0 01-1-1V4z"></path></svg>
            </div>
        </div>
        <div class="flex-grow min-h-[300px]">
            <canvas id="userGrowthChart"></canvas>
        </div>
    </div>

    <!-- Distribución de Especies (40% del ancho en desktop) -->
    <div class="lg:col-span-4 glass-card p-6 border-purple-500/10 flex flex-col">
        <div class="flex items-center justify-between mb-6">
            <div>
                <h3 class="text-white font-bold text-lg">Especies Comunes</h3>
                <p class="text-[10px] text-zinc-500 uppercase tracking-widest font-black">Top 10 especies criadas</p>
            </div>
            <div class="p-2 bg-purple-500/10 rounded-lg text-purple-400">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 3.055A9.001 9.001 0 1020.945 13H11V3.055z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.488 9H15V3.512A9.025 9.025 0 0120.488 9z"></path></svg>
            </div>
        </div>
        <div class="flex-grow flex items-center justify-center min-h-[300px]">
            <canvas id="speciesDistChart"></canvas>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // 1. Gráfico de Crecimiento de Usuarios
    const growthCtx = document.getElementById('userGrowthChart').getContext('2d');
    new Chart(growthCtx, {
        type: 'line',
        data: {
            labels: <?= json_encode($chart_user_growth['labels']) ?>,
            datasets: [{
                label: 'Usuarios Registrados',
                data: <?= json_encode($chart_user_growth['data']) ?>,
                borderColor: '#3b82f6',
                backgroundColor: 'rgba(59, 130, 246, 0.1)',
                borderWidth: 3,
                tension: 0.4,
                fill: true,
                pointBackgroundColor: '#09090b',
                pointBorderColor: '#3b82f6',
                pointBorderWidth: 2,
                pointRadius: 4,
                pointHoverRadius: 6
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: { display: false }
            },
            scales: {
                y: { 
                    beginAtZero: true, 
                    grid: { color: 'rgba(255, 255, 255, 0.05)' },
                    ticks: { color: '#71717a', font: { size: 10 } }
                },
                x: { 
                    grid: { display: false },
                    ticks: { color: '#71717a', font: { size: 10 } }
                }
            }
        }
    });

    // 2. Gráfico de Distribución de Especies
    const speciesCtx = document.getElementById('speciesDistChart').getContext('2d');
    new Chart(speciesCtx, {
        type: 'doughnut',
        data: {
            labels: <?= json_encode($chart_species_dist['labels']) ?>,
            datasets: [{
                data: <?= json_encode($chart_species_dist['data']) ?>,
                backgroundColor: [
                    '#3b82f6', '#8b5cf6', '#ec4899', '#f43f5e', 
                    '#f59e0b', '#10b981', '#06b6d4', '#6366f1',
                    '#a855f7', '#64748b'
                ],
                borderWidth: 0,
                hoverOffset: 15
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            cutout: '75%',
            plugins: {
                legend: { display: false }
            }
        }
    });
});
</script>

<!-- Modificaciones de Guías Pendientes -->
<div class="grid grid-cols-1 gap-8 mb-8">
    <div class="glass-card p-0 border-orange-500/10 overflow-hidden">
        <div class="p-6 border-b border-white/5 flex items-center justify-between bg-orange-500/5">
            <div>
                <h3 class="text-lg font-bold text-white">Revisiones de Guías Pendientes</h3>
                <p class="text-[10px] text-zinc-500 uppercase tracking-widest font-black">Sugerencias de la comunidad esperando aprobación</p>
            </div>
            <a href="<?= BASE_URL ?>/admin/revisiones" class="px-4 py-2 bg-orange-500/10 border border-orange-500/20 text-orange-400 rounded-xl hover:bg-orange-500 hover:text-white transition-all text-[10px] font-black uppercase">
                Ver Todas
            </a>
        </div>
        
        <?php if (empty($pending_revisions)): ?>
            <div class="p-12 text-center">
                <div class="w-16 h-16 bg-zinc-500/10 rounded-full flex items-center justify-center mx-auto mb-4 border border-white/5">
                    <svg class="w-8 h-8 text-zinc-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                </div>
                <p class="text-zinc-500 text-sm italic">No hay revisiones pendientes. ¡Todo al día!</p>
            </div>
        <?php else: ?>
            <div class="overflow-x-auto">
                <table class="w-full text-left">
                    <thead class="bg-white/[0.02] text-[10px] uppercase font-black tracking-widest text-zinc-500">
                        <tr>
                            <th class="px-6 md:px-8 py-4">Usuario</th>
                            <th class="px-6 py-4">Especie</th>
                            <th class="px-6 py-4">Tipo</th>
                            <th class="px-6 py-4">Fecha</th>
                            <th class="px-6 py-4 text-right">Acciones</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-white/5">
                        <?php foreach ($pending_revisions as $rev): ?>
                            <tr class="group hover:bg-white/[0.03] transition-colors">
                                <td class="px-6 md:px-8 py-5">
                                    <span class="font-bold text-white text-sm"><?= htmlspecialchars($rev['usuario_nombre']) ?></span>
                                </td>
                                <td class="px-6 py-5">
                                    <span class="text-sm text-zinc-300"><?= htmlspecialchars($rev['especie_nombre'] ?? 'Nueva Especie') ?></span>
                                </td>
                                <td class="px-6 py-5">
                                    <?php if (is_null($rev['especie_id'])): ?>
                                        <span class="px-2 py-0.5 rounded-md bg-emerald-500/10 text-emerald-500 text-[10px] font-black border border-emerald-500/20">NUEVA</span>
                                    <?php else: ?>
                                        <span class="px-2 py-0.5 rounded-md bg-blue-500/10 text-blue-500 text-[10px] font-black border border-blue-500/20">EDICIÓN</span>
                                    <?php endif; ?>
                                </td>
                                <td class="px-6 py-5">
                                    <span class="text-xs text-zinc-500"><?= date('d/m/Y H:i', strtotime($rev['fecha_creacion'])) ?></span>
                                </td>
                                <td class="px-6 py-5 text-right">
                                    <a href="<?= BASE_URL ?>/admin/revisiones" class="p-2 bg-white/5 border border-white/10 text-zinc-400 rounded-lg hover:bg-white/10 hover:text-white transition-all inline-flex items-center gap-2 text-[10px] font-black uppercase">
                                        Revisar
                                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                                    </a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php endif; ?>
    </div>
</div>

<div class="glass-card p-0 border-white/5 overflow-hidden">

    <div class="p-6 border-b border-white/5 flex items-center justify-between">
        <h3 class="text-lg font-bold text-white">Gestión de Usuarios</h3>
        <span class="text-[10px] font-black text-zinc-500 uppercase tracking-widest bg-white/5 px-3 py-1 rounded-full border border-white/5">Media: <?= $stats['avg_colonies_per_user'] ?> col/user</span>
    </div>
    <div class="overflow-x-auto">
        <table class="w-full text-left">
            <thead class="bg-white/[0.02] text-[10px] uppercase font-black tracking-widest text-zinc-500">
                <tr>
                    <th class="px-6 md:px-8 py-4">Usuario</th>
                    <th class="px-6 py-4">Rol</th>
                    <th class="px-6 py-4 text-center">Colonias</th>
                    <th class="px-6 py-4 text-center">Diario</th>
                    <th class="px-6 py-4">Registro / Conex.</th>
                    <th class="px-6 py-4 text-center">Estado</th>
                    <th class="px-6 py-4 text-right">Acciones</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-white/5">
                <?php foreach ($users as $u): ?>
                    <tr class="group hover:bg-white/[0.03] transition-colors <?= $u['is_banned'] ? 'opacity-50' : '' ?>">
                        <td class="px-6 md:px-8 py-5">
                            <div class="flex flex-col">
                                <span class="font-bold text-white text-sm md:text-base"><?= htmlspecialchars($u['nombre']) ?></span>
                                <span class="text-[10px] text-zinc-500"><?= htmlspecialchars($u['email']) ?></span>
                            </div>
                        </td>
                        <td class="px-6 py-5">
                            <span class="text-[10px] uppercase font-black tracking-wider <?= $u['rol'] == 'admin' ? 'text-red-400' : 'text-blue-400' ?>">
                                <?= htmlspecialchars($u['rol']) ?>
                            </span>
                        </td>
                        <td class="px-6 py-5 text-center">
                            <span class="text-sm font-black text-blue-400 bg-blue-500/10 px-2 py-0.5 rounded-lg border border-blue-500/20">
                                <?= $u['colonies_count'] ?>
                            </span>
                        </td>
                        <td class="px-6 py-5 text-center">
                            <span class="text-sm font-black text-purple-400 bg-purple-500/10 px-2 py-0.5 rounded-lg border border-purple-500/20">
                                <?= $u['diary_count'] ?>
                            </span>
                        </td>
                        <td class="px-6 py-5">
                            <div class="flex flex-col">
                                <span class="text-xs text-white"><?= date('d M Y', strtotime($u['fecha_registro'])) ?></span>
                                <span class="text-[10px] text-zinc-500 italic lowercase"><?= $u['last_login'] ? get_time_elapsed($u['last_login']) . ' ago' : 'Nunca' ?></span>
                            </div>
                        </td>
                        <td class="px-6 py-5 text-center">
                            <?php if ($u['is_banned']): ?>
                                <span class="px-3 py-1 rounded-full bg-red-500/10 text-red-500 text-[10px] uppercase font-black border border-red-500/20">Baneado</span>
                            <?php else: ?>
                                <span class="px-3 py-1 rounded-full bg-emerald-500/10 text-emerald-500 text-[10px] uppercase font-black border border-emerald-500/20">Activo</span>
                            <?php endif; ?>
                        </td>
                        <td class="px-6 py-5 text-right">
                            <div class="grid grid-flow-col items-center justify-end gap-2">
                                <a href="<?= BASE_URL ?>/admin/usuarios/ver/<?= $u['id'] ?>" 
                                   class="flex items-center justify-center h-9 w-9 rounded-xl transition-all border bg-blue-500/10 text-blue-500 border-blue-500/20 hover:bg-blue-500 hover:text-white" title="Ver Detalles">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                                </a>
                                <?php if ($u['id'] != $_SESSION['user_id']): ?>
                                    <form action="<?= BASE_URL ?>/admin/usuarios/ban/<?= $u['id'] ?>" method="POST" class="m-0 flex items-center h-9" onsubmit="return confirm('¿Estás seguro de efectuar esta acción contra este usuario?');">
                                        <button type="submit" class="flex items-center justify-center h-9 px-4 rounded-xl transition-all border text-[10px] font-black uppercase leading-none <?= $u['is_banned'] ? 'bg-emerald-500/10 text-emerald-500 border-emerald-500/20 hover:bg-emerald-500 hover:text-white' : 'bg-red-500/10 text-red-500 border-red-500/20 hover:bg-red-500 hover:text-white' ?>">
                                            <?= $u['is_banned'] ? 'Reactivar' : 'Banear' ?>
                                        </button>
                                    </form>
                                <?php else: ?>
                                    <span class="flex items-center h-9 px-4 text-[10px] text-zinc-500 uppercase tracking-widest font-black leading-none">Tú</span>
                                <?php endif; ?>
                            </div>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>
