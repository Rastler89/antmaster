<!-- Header con Saludo y Acción -->
<div class="flex flex-col md:flex-row justify-between items-center mb-8 gap-4">
    <div>
        <h1 class="text-3xl font-black text-white">
            <?= __('dashboard_welcome', ['name' => '<span class="bg-clip-text text-transparent bg-gradient-to-r from-blue-400 via-purple-500 to-pink-500">' . htmlspecialchars($userName) . '</span>']) ?> 👋
        </h1>
        <p class="text-zinc-500 text-sm mt-1"><?= __('dashboard_tagline') ?></p>
    </div>
    <div class="flex items-center gap-3">
        <a href="<?= BASE_URL ?>/colonias/nueva" class="magic-btn shadow-lg shadow-blue-500/20 active:scale-95 transition-all">
            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
            <?= __('nav_new_colony') ?>
        </a>
    </div>
</div>

<!-- KPI Cards -->
<div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
    <div class="glass-card p-6 border-blue-500/10 overflow-hidden relative group hover:bg-blue-500/5 transition-all">
        <div class="absolute -right-4 -top-4 w-24 h-24 bg-blue-500/10 rounded-full blur-2xl group-hover:scale-150 transition-transform duration-700"></div>
        <p class="text-[10px] uppercase font-black text-zinc-500 tracking-widest mb-3"><?= __('kpi_total_ants') ?></p>
        <div class="flex items-end justify-between">
            <h3 class="text-4xl font-black text-white"><?= number_format($totalAnts) ?></h3>
            <div class="p-3 bg-blue-500/10 rounded-2xl text-blue-400 border border-blue-500/10">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
            </div>
        </div>
    </div>

    <div class="glass-card p-6 border-purple-500/10 overflow-hidden relative group hover:bg-purple-500/5 transition-all">
        <div class="absolute -right-4 -top-4 w-24 h-24 bg-purple-500/10 rounded-full blur-2xl group-hover:scale-150 transition-transform duration-700"></div>
        <p class="text-[10px] uppercase font-black text-zinc-500 tracking-widest mb-3"><?= __('kpi_active_colonies') ?></p>
        <div class="flex items-end justify-between">
            <h3 class="text-4xl font-black text-white"><?= count($colonies) ?></h3>
            <div class="p-3 bg-purple-500/10 rounded-2xl text-purple-400 border border-purple-500/10">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 002-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>
            </div>
        </div>
    </div>

    <div class="glass-card p-6 border-pink-500/10 overflow-hidden relative group hover:bg-pink-500/5 transition-all">
        <div class="absolute -right-4 -top-4 w-24 h-24 bg-pink-500/10 rounded-full blur-2xl group-hover:scale-150 transition-transform duration-700"></div>
        <p class="text-[10px] uppercase font-black text-zinc-500 tracking-widest mb-3"><?= __('kpi_species') ?></p>
        <div class="flex items-end justify-between">
            <h3 class="text-4xl font-black text-white"><?= $totalSpecies ?></h3>
            <div class="p-3 bg-pink-500/10 rounded-2xl text-pink-400 border border-pink-500/10">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.168.477 4 1.253m0-13C13.168 5.477 14.754 5 16.5 5S19.832 6.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4 1.253"></path></svg>
            </div>
        </div>
    </div>
</div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
    <!-- Gráfica de Crecimiento Global -->
    <div class="lg:col-span-2 space-y-8">
        <div class="glass-card p-8 border-white/5 relative overflow-hidden">
            <div class="flex items-center justify-between mb-8 relative z-10">
                <div>
                    <h3 class="text-xl font-bold text-white flex items-center gap-2">
                        <svg class="w-5 h-5 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 12l3-3 3 3 4-4M8 21l4-4 4 4M3 4h18M4 4h16v12a1 1 0 01-1 1H5a1 1 0 01-1-1V4z"></path></svg>
                        <?= __('chart_empire_growth') ?>
                    </h3>
                    <p class="text-xs text-zinc-500 mt-1"><?= __('chart_empire_tagline') ?></p>
                </div>
                <div class="flex p-1 bg-black/40 rounded-xl border border-white/5">
                    <?php $ranges = [30 => __('range_30d'), 90 => __('range_90d'), 180 => __('range_180d'), 'all' => __('range_all')]; ?>
                    <?php foreach ($ranges as $val => $label): ?>
                        <a href="?range=<?= $val ?>" 
                           class="px-3 py-1.5 text-[10px] font-black rounded-lg transition-all <?= ($range == $val) ? 'bg-blue-500 text-white shadow-lg shadow-blue-500/20' : 'text-zinc-500 hover:text-white' ?>">
                            <?= $label ?>
                        </a>
                    <?php endforeach; ?>
                </div>
            </div>
            
            <div class="h-[250px] md:h-[350px] relative z-10">
                <canvas id="empireChart"></canvas>
            </div>
        </div>

        <!-- Tabla de Colonias Estilizada -->
        <div class="glass-card p-0 border-white/5 overflow-hidden">
            <div class="p-6 border-b border-white/5 flex items-center justify-between">
                <h3 class="text-lg font-bold text-white"><?= __('inventory_title') ?></h3>
                <span class="text-[10px] font-black text-zinc-500 uppercase tracking-widest bg-white/5 px-3 py-1 rounded-full border border-white/5"><?= count($colonies) ?> <span class="hidden sm:inline"><?= __('inventory_colonies') ?></span></span>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full text-left">
                    <thead class="bg-white/[0.02] text-[10px] uppercase font-black tracking-widest text-zinc-500">
                        <tr>
                            <th class="px-6 md:px-8 py-4"><?= __('table_colony') ?></th>
                            <th class="hidden sm:table-cell px-8 py-4"><?= __('table_species') ?></th>
                            <th class="px-6 md:px-8 py-4 text-center"><?= __('table_population') ?></th>
                            <th class="px-6 md:px-8 py-4 text-right"></th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-white/5">
                        <?php foreach ($colonies as $c): ?>
                            <tr class="group hover:bg-white/[0.03] transition-colors">
                                <td class="px-6 md:px-8 py-5">
                                    <div class="flex items-center gap-3">
                                        <div class="w-8 h-8 md:w-10 md:h-10 rounded-lg md:xl bg-white/5 flex items-center justify-center border border-white/10 group-hover:border-blue-500/30 transition-colors">
                                            <span class="text-base md:text-lg">🐜</span>
                                        </div>
                                        <div class="flex flex-col">
                                            <span class="font-bold text-white text-sm md:text-base"><?= htmlspecialchars($c['nombre']) ?></span>
                                            <span class="sm:hidden text-[10px] text-blue-400 italic"><?= htmlspecialchars($c['especie_nombre']) ?></span>
                                        </div>
                                    </div>
                                </td>
                                <td class="hidden sm:table-cell px-8 py-5">
                                    <span class="text-sm font-medium text-blue-400/80 italic"><?= htmlspecialchars($c['especie_nombre']) ?></span>
                                </td>
                                <td class="px-6 md:px-8 py-5">
                                    <div class="flex flex-col items-center">
                                        <span class="text-sm font-black text-white"><?= number_format($c['poblacion_actual']) ?></span>
                                        <div class="w-12 md:w-20 h-1 bg-white/10 rounded-full mt-1.5 overflow-hidden">
                                            <div class="h-full bg-emerald-500 shadow-[0_0_8px_rgba(16,185,129,0.5)]" style="width: min(<?= $c['poblacion_actual']/10 ?>%, 100%)"></div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 md:px-8 py-5 text-right">
                                    <a href="<?= BASE_URL ?>/colonias/ver/<?= $c['id'] ?>" class="p-2 md:p-2.5 rounded-xl bg-white/5 text-zinc-400 hover:text-white hover:bg-blue-500 transition-all border border-white/10 inline-flex items-center">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                                    </a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Widgets Laterales -->
    <div class="space-y-8 pb-12 lg:pb-0">
        <!-- Distribución de Especies -->
        <div class="glass-card p-6 md:p-8 border-white/5">
            <h3 class="text-lg font-bold text-white mb-6 flex items-center gap-2">
                <svg class="w-5 h-5 text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 3.055A9.001 9.001 0 1020.945 13H11V3.055z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.488 9H15V3.512A9.025 9.025 0 0120.488 9z"></path></svg>
                <?= __('diversity_title') ?>
            </h3>
            <div class="h-[180px] md:h-[200px] mb-6">
                <canvas id="speciesChart"></canvas>
            </div>
            <div class="space-y-3">
                <?php foreach ($distribution as $d): ?>
                    <div class="flex items-center justify-between text-xs">
                        <span class="text-zinc-500 font-bold"><?= htmlspecialchars($d['especie']) ?></span>
                        <span class="text-white font-black"><?= $d['total'] ?></span>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>

        <!-- Alertas de Stock Crítico -->
        <div class="glass-card p-8 border-red-500/10">
            <div class="flex items-center justify-between mb-6">
                <h3 class="text-lg font-bold text-white flex items-center gap-2">
                    <span class="relative flex h-3 w-3">
                        <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-red-400 opacity-75"></span>
                        <span class="relative inline-flex rounded-full h-3 w-3 bg-red-500"></span>
                    </span>
                    <?= __('stock_critical_title') ?>
                </h3>
            </div>
            
            <?php if (empty($lowStock)): ?>
                <div class="text-center py-6 bg-white/5 rounded-2xl border border-white/5">
                    <p class="text-[10px] uppercase font-black text-emerald-400 tracking-widest"><?= __('stock_ok') ?></p>
                </div>
            <?php else: ?>
                <div class="space-y-4">
                    <?php foreach ($lowStock as $s): ?>
                        <div class="relative group p-4 rounded-2xl bg-red-500/5 hover:bg-red-500/10 border border-red-500/10 transition-all flex items-center justify-between">
                            <div>
                                <h4 class="text-sm font-bold text-white"><?= htmlspecialchars($s['nombre']) ?></h4>
                                <p class="text-[10px] font-bold text-red-400/80 uppercase tracking-tighter"><?= __('stock_low') ?></p>
                            </div>
                            <div class="flex flex-col items-end">
                                <span class="text-lg font-black text-white"><?= $s['cantidad'] ?></span>
                                <span class="text-[9px] font-black text-zinc-500 uppercase"><?= htmlspecialchars($s['unidad']) ?></span>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
            <a href="<?= BASE_URL ?>/stock" class="block w-full text-center py-4 mt-6 rounded-2xl bg-white/5 border border-white/5 text-[10px] font-black uppercase text-zinc-400 hover:text-white transition-all"><?= __('stock_view_all') ?></a>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const ctxEmpire = document.getElementById('empireChart').getContext('2d');
    const ctxSpecies = document.getElementById('speciesChart').getContext('2d');

    // Datos del PHP (Simulados para el ejemplo, pero integrados con las variables reales)
    const historyRaw = <?= json_encode($globalHistory) ?>;
    
    // Agrupar historia global por fecha para el gráfico de línea
    const aggregated = {};
    historyRaw.forEach(item => {
        const date = item.fecha_registro.split(' ')[0];
        if (!aggregated[date]) aggregated[date] = 0;
        aggregated[date] += parseInt(item.poblacion);
    });

    const labels = Object.keys(aggregated);
    const data = Object.values(aggregated);

    // Gradiente azul para la gráfica de línea
    const blueGradient = ctxEmpire.createLinearGradient(0, 0, 0, 400);
    blueGradient.addColorStop(0, 'rgba(59, 130, 246, 0.4)');
    blueGradient.addColorStop(1, 'rgba(59, 130, 246, 0)');

    new Chart(ctxEmpire, {
        type: 'line',
        data: {
            labels: labels.map(d => new Date(d).toLocaleDateString('<?= APP_LANG ?>-<?= strtoupper(APP_LANG) ?>', {day:'2-digit', month:'short'})),
            datasets: [{
                label: '<?= __('chart_ants_label') ?>',
                data: data,
                borderColor: '#3b82f6',
                borderWidth: 3,
                fill: true,
                backgroundColor: blueGradient,
                tension: 0.4,
                pointRadius: 4,
                pointBackgroundColor: '#3b82f6',
                pointBorderWidth: 0,
                pointHoverRadius: 6,
                pointHoverBackgroundColor: '#fff'
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: { display: false },
                tooltip: {
                    mode: 'index',
                    intersect: false,
                    backgroundColor: '#18181b',
                    titleColor: '#fff',
                    bodyColor: '#3b82f6',
                    borderColor: '#27272a',
                    borderWidth: 1,
                    padding: 12,
                    displayColors: false
                }
            },
            scales: {
                y: {
                    grid: { color: 'rgba(255,255,255,0.05)' },
                    ticks: { color: '#71717a', font: { size: 10 } }
                },
                x: {
                    grid: { display: false },
                    ticks: { color: '#71717a', font: { size: 10 } }
                }
            }
        }
    });

    // Gráfico de Especies
    const speciesData = <?= json_encode($distribution) ?>;
    new Chart(ctxSpecies, {
        type: 'doughnut',
        data: {
            labels: speciesData.map(d => d.especie),
            datasets: [{
                data: speciesData.map(d => d.total),
                backgroundColor: [
                    '#3b82f6', '#8b5cf6', '#ec4899', '#f97316', '#10b981'
                ],
                borderWidth: 0,
                spacing: 10,
                cutout: '75%'
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: { display: false }
            }
        }
    });
});
</script>
