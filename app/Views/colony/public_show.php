<div class="max-w-4xl mx-auto">
    <!-- Header de Perfil Público -->
    <div class="relative h-64 md:h-96 rounded-3xl overflow-hidden mb-12 shadow-2xl group">
        <?php if ($colony['imagen']): ?>
            <img src="<?= BASE_URL ?>/uploads/colonies/<?= $colony['imagen'] ?>" class="w-full h-full object-cover">
        <?php else: ?>
            <div class="w-full h-full bg-gradient-to-br from-blue-600/20 to-purple-600/20 flex items-center justify-center text-6xl">🐜</div>
        <?php endif; ?>
        <div class="absolute inset-0 bg-gradient-to-t from-black/90 via-black/40 to-transparent"></div>
        
        <div class="absolute bottom-0 left-0 p-8 md:p-12 w-full">
            <div class="flex items-center gap-3 mb-4">
                <span class="px-3 py-1 bg-blue-500 text-white text-[10px] font-black uppercase tracking-widest rounded-full shadow-lg shadow-blue-500/20">LOG PÚBLICO</span>
                <span class="text-zinc-400 text-xs font-bold uppercase tracking-tighter">Criador: <span class="text-white"><?= htmlspecialchars($colony['usuario_nombre']) ?></span></span>
            </div>
            <h1 class="text-4xl md:text-6xl font-black text-white drop-shadow-2xl mb-2"><?= htmlspecialchars($colony['nombre']) ?></h1>
            <p class="text-blue-300 text-lg font-medium italic opacity-90"><?= htmlspecialchars($colony['especie_nombre']) ?></p>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-12">
        <!-- Columna de Datos -->
        <div class="lg:col-span-2 space-y-12">
            <!-- Evolución de la Población -->
            <div class="glass-card p-8 border-white/5">
                <h3 class="text-xl font-bold text-white mb-8 flex items-center gap-3">
                    <svg class="w-6 h-6 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 12l3-3 3 3 4-4M8 21l4-4 4 4M3 4h18M4 4h16v12a1 1 0 01-1 1H5a1 1 0 01-1-1V4z"></path></svg>
                    Historial de Crecimiento
                </h3>
                <div class="h-80">
                    <canvas id="publicPopChart"></canvas>
                </div>
            </div>

            <!-- Diario Público -->
            <div class="space-y-8">
                <h3 class="text-xl font-bold text-white mb-2 flex items-center gap-3">
                    <svg class="w-6 h-6 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.168.477 4 1.253m0-13C13.168 5.477 14.754 5 16.5 5S19.832 6.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4 1.253"></path></svg>
                    Diario de Bitácora
                </h3>
                
                <?php if (empty($diary)): ?>
                    <p class="text-zinc-500 italic">El criador aún no ha compartido entradas públicas del diario.</p>
                <?php else: ?>
                    <div class="space-y-6 relative before:absolute before:left-4 before:top-4 before:bottom-4 before:w-px before:bg-white/5">
                        <?php foreach ($diary as $entry): ?>
                            <div class="relative pl-10">
                                <div class="absolute left-3 top-1.5 w-2 h-2 rounded-full bg-blue-500 shadow-[0_0_8px_rgba(59,130,246,0.6)]"></div>
                                <div class="glass-card p-6 border-white/5">
                                    <div class="flex items-center justify-between mb-4">
                                        <span class="text-[10px] font-black uppercase tracking-widest text-blue-400 py-1 px-2 bg-blue-400/10 rounded"><?= htmlspecialchars($entry['tipo_evento']) ?></span>
                                        <time class="text-[10px] font-bold text-zinc-500 uppercase tracking-widest"><?= date('d M, Y', strtotime($entry['fecha_entrada'])) ?></time>
                                    </div>
                                    <p class="text-sm text-zinc-300 leading-relaxed"><?= nl2br(htmlspecialchars($entry['entrada'])) ?></p>
                                    <?php if ($entry['imagen_url']): ?>
                                        <img src="<?= BASE_URL ?>/uploads/diary/<?= $entry['imagen_url'] ?>" class="mt-4 rounded-xl w-full h-48 object-cover border border-white/5">
                                    <?php endif; ?>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>
            </div>
        </div>

        <!-- Sidebar Informativa -->
        <div class="space-y-8">
            <div class="glass-card p-8 border-white/5">
                <h4 class="text-[10px] font-black text-zinc-500 uppercase tracking-[0.2em] mb-6">Información General</h4>
                <div class="space-y-6">
                    <div>
                        <p class="text-[10px] font-black text-zinc-600 uppercase mb-1">Adquirida en</p>
                        <p class="text-lg font-bold text-white"><?= date('d/m/Y', strtotime($colony['fecha_adquisicion'])) ?></p>
                    </div>
                    <div>
                        <p class="text-[10px] font-black text-zinc-600 uppercase mb-1">Nido Actual</p>
                        <p class="text-lg font-bold text-white"><?= htmlspecialchars($colony['tipo_hormiguero'] ?: 'No especificado') ?></p>
                    </div>
                    <div>
                        <p class="text-[10px] font-black text-zinc-600 uppercase mb-1">Población Actual</p>
                        <p class="text-3xl font-black text-emerald-400"><?= number_format($colony['poblacion_actual']) ?> <span class="text-xs text-zinc-500 font-bold uppercase tracking-widest ml-1">obreras</span></p>
                    </div>
                </div>
            </div>

            <div class="p-8 rounded-3xl bg-blue-500/[0.03] border border-blue-500/10">
                <h4 class="text-sm font-bold text-white mb-2">¿Te gusta este diario?</h4>
                <p class="text-xs text-zinc-500 leading-relaxed mb-4">Empieza hoy mismo a gestionar tus propias colonias y comparte tu pasión con el mundo.</p>
                <a href="<?= BASE_URL ?>/register" class="magic-btn w-full !rounded-xl !text-sm">Registrarse Gratis</a>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const ctx = document.getElementById('publicPopChart').getContext('2d');
    const historyData = <?= json_encode($history) ?>;
    
    new Chart(ctx, {
        type: 'line',
        data: {
            labels: historyData.map(h => new Date(h.fecha_registro).toLocaleDateString()),
            datasets: [{
                label: 'Crecimiento Real',
                data: historyData.map(h => h.poblacion),
                borderColor: '#10b981',
                backgroundColor: 'rgba(16, 185, 129, 0.1)',
                fill: true,
                tension: 0.4,
                borderWidth: 3,
                pointRadius: 4,
                pointBackgroundColor: '#10b981'
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: { legend: { display: false } },
            scales: {
                y: { grid: { color: 'rgba(255,255,255,0.05)' }, ticks: { color: '#71717a' } },
                x: { grid: { display: false }, ticks: { color: '#71717a' } }
            }
        }
    });
});
</script>
