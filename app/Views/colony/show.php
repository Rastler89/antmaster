    <div class="relative h-64 md:h-80 rounded-3xl overflow-hidden mb-8 group ring-1 ring-white/10 shadow-2xl">
        <?php 
        $icons = [
            'reina'   => '👑',
            'minor'   => '🐜',
            'media'   => '🛡️',
            'major'   => '🔨',
            'soldado' => '⚔️'
        ];
        if ($colony['imagen']): ?>
            <img src="<?= BASE_URL ?>/uploads/colonies/<?= $colony['imagen'] ?>" class="w-full h-full object-cover">
        <?php else: ?>
            <div class="w-full h-full bg-gradient-to-br from-blue-600/20 to-purple-600/20 flex items-center justify-center">
                <svg class="w-20 h-20 text-blue-500/20" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
            </div>
        <?php endif; ?>
        <div class="absolute inset-0 bg-gradient-to-t from-black/90 via-black/40 to-transparent"></div>
        
        <div class="absolute bottom-0 left-0 p-6 md:p-8 flex flex-col md:flex-row items-start md:items-end justify-between w-full gap-6">
            <div class="flex-1 w-full">
                <a href="<?= BASE_URL ?>/colonias" class="inline-flex items-center gap-2 text-white/70 hover:text-white mb-2 text-xs md:text-sm transition-colors">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                    Volver
                </a>
                <h1 class="text-3xl md:text-5xl font-black text-white drop-shadow-2xl leading-tight"><?= htmlspecialchars($colony['nombre']) ?></h1>
                <p class="text-blue-300 font-bold mt-1 drop-shadow-md italic opacity-95 text-sm md:text-base tracking-wide"><?= htmlspecialchars($colony['especie_nombre']) ?></p>
            </div>
            <div class="flex items-center gap-2 w-full md:w-auto overflow-x-auto pb-2 md:pb-0 no-scrollbar">
                <a href="<?= BASE_URL ?>/especies/ver/<?= $colony['especie_id'] ?>" class="p-3 bg-blue-500/10 hover:bg-blue-500/20 backdrop-blur-md rounded-xl text-blue-400 transition border border-blue-500/10 shrink-0" title="Ver Ficha de Cría">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.168.477 4 1.253m0-13C13.168 5.477 14.754 5 16.5 5S19.832 6.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4 1.253"></path></svg>
                </a>
                <a href="<?= BASE_URL ?>/colonias/galeria/<?= $colony['id'] ?>" class="p-3 bg-white/5 hover:bg-white/10 backdrop-blur-md rounded-xl text-white transition border border-white/10 flex items-center gap-2 px-4 shrink-0" title="Galería Multimedia">
                    <svg class="w-5 h-5 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                    <span class="text-[10px] font-black uppercase tracking-widest hidden sm:block">Galería</span>
                </a>
                <a href="<?= BASE_URL ?>/colonias/editar/<?= $colony['id'] ?>" class="p-3 bg-white/5 hover:bg-white/10 backdrop-blur-md rounded-xl text-white transition border border-white/10 flex items-center gap-2 px-4 shrink-0" title="Editar Colonia">
                    <svg class="w-5 h-5 text-zinc-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                    <span class="text-[10px] font-black uppercase tracking-widest hidden sm:block">Editar</span>
                </a>
                <form action="<?= BASE_URL ?>/colonias/borrar/<?= $colony['id'] ?>" method="POST" onsubmit="return confirm('¿Estás seguro de que quieres eliminar esta colonia?')" class="shrink-0">
                    <button type="submit" class="p-3 bg-red-500/10 hover:bg-red-500/20 backdrop-blur-md rounded-xl text-red-500 transition border border-red-500/10" title="Eliminar Colonia">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                    </button>
                </form>
            </div>
        </div>
    </div>

    <!-- Stats Grid -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
        <div class="glass-card p-6 flex flex-col justify-between relative">
            <div class="flex items-center justify-between mb-2">
                <p class="text-muted text-sm uppercase tracking-wider font-semibold">Población Total</p>
                <button onclick="togglePopForm()" class="p-1.5 rounded-lg bg-emerald-500/10 text-emerald-400 hover:bg-emerald-500/20 transition-colors border border-emerald-500/20" title="Nuevo recuento">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                </button>
            </div>
            
            <div class="flex items-end justify-between">
                <div>
                    <div class="text-3xl font-bold text-main"><?= number_format($colony['poblacion_actual']) ?></div>
                    <?php if ($trend != 0): ?>
                        <div class="text-[10px] font-bold mt-1 flex items-center gap-1 <?= $trend > 0 ? 'text-emerald-400' : 'text-red-400' ?>">
                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="<?= $trend > 0 ? 'M13 7h8m0 0v8m0-8l-8 8-4-4-6 6' : 'M13 17h8m0 0V9m0 8l-8-8-4 4-6-6' ?>"></path></svg>
                            <?= round(abs($trend), 1) ?>% vs anterior
                        </div>
                    <?php endif; ?>
                </div>
                <div class="w-10 h-10 rounded-xl bg-emerald-500/10 flex items-center justify-center border border-emerald-500/20">
                    <svg class="w-5 h-5 text-emerald-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                </div>
            </div>
        </div>
        
        <div class="glass-card p-6 flex items-center justify-between">
            <div>
                <p class="text-muted text-sm mb-1 uppercase tracking-wider font-semibold">Tipo Hormiguero</p>
                <div class="text-xl font-bold text-main"><?= htmlspecialchars($colony['tipo_hormiguero'] ?: 'No especificado') ?></div>
            </div>
            <div class="w-12 h-12 rounded-2xl bg-blue-500/10 flex items-center justify-center border border-blue-500/20">
                <svg class="w-6 h-6 text-blue-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path></svg>
            </div>
        </div>
        
        <div class="glass-card p-6 flex items-center justify-between">
            <div>
                <p class="text-muted text-sm mb-1 uppercase tracking-wider font-semibold">Tiempo Contigo</p>
                <div class="text-xl font-bold text-main"><?= get_time_elapsed($colony['fecha_adquisicion']) ?></div>
            </div>
            <div class="w-12 h-12 rounded-2xl bg-purple-500/10 flex items-center justify-center border border-purple-500/20">
                <svg class="w-6 h-6 text-purple-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2-2v12a2 2 0 002 2z"></path></svg>
            </div>
        </div>
    </div>

    <?php if ($colony['poblacion_detallada']): ?>
        <?php $castas = json_decode($colony['poblacion_detallada'], true); ?>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-8">
            <div class="glass-card p-6 border-blue-500/20">
                <h3 class="text-lg font-bold text-main mb-6 flex items-center gap-2">
                    <svg class="w-5 h-5 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 3.055A9.001 9.001 0 1020.945 13H11V3.055z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.488 9H15V3.512A9.025 9.025 0 0120.488 9z"></path></svg>
                    Distribución de Castas
                </h3>
                <div class="grid grid-cols-2 lg:grid-cols-3 gap-4">
                    <?php foreach ($castas as $casta => $cantidad): ?>
                        <div class="flex flex-col items-center p-3 rounded-xl bg-white/5 border border-white/5">
                            <span class="text-xl mb-1"><?= $icons[strtolower($casta)] ?? '🐜' ?></span>
                            <span class="text-[9px] uppercase font-bold text-muted"><?= htmlspecialchars($casta) ?></span>
                            <span class="text-xl font-bold text-main"><?= number_format($cantidad) ?></span>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>

            <!-- Gráfica de Evolución -->
            <div class="glass-card p-6 min-h-[300px] border-emerald-500/20">
                <h3 class="text-lg font-bold text-main mb-6 flex items-center gap-2">
                    <svg class="w-5 h-5 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 12l3-3 3 3 4-4M8 21l4-4 4 4M3 4h18M4 4h16v12a1 1 0 01-1 1H5a1 1 0 01-1-1V4z"></path></svg>
                    Evolución de la Población
                </h3>
                <div class="h-[200px]">
                    <canvas id="evolutionChart"></canvas>
                </div>
            </div>
        </div>
    <?php else: ?>
        <!-- Si no hay castas, mostrar la gráfica a pantalla completa o más grande -->
        <div class="glass-card p-8 mb-8 border-emerald-500/20">
            <h3 class="text-lg font-bold text-main mb-6 flex items-center gap-2">
                <svg class="w-5 h-5 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 12l3-3 3 3 4-4M8 21l4-4 4 4M3 4h18M4 4h16v12a1 1 0 01-1 1H5a1 1 0 01-1-1V4z"></path></svg>
                Evolución de la Población
            </h3>
            <div class="h-[300px]">
                <canvas id="evolutionChart"></canvas>
            </div>
        </div>
    <?php endif; ?>

    <!-- Description & Log -->
    <!-- Panel de Privacidad y Compartir -->
    <div class="glass-card mb-8 p-4 md:p-6 border-white/5 bg-blue-500/[0.02]">
        <div class="flex flex-col lg:flex-row items-start lg:items-center justify-between gap-4 md:gap-6">
            <div class="flex items-center gap-4">
                <div class="w-10 h-10 md:w-12 md:h-12 rounded-xl md:2xl bg-blue-500/10 flex items-center justify-center text-blue-400 border border-blue-500/20 shrink-0">
                    <svg class="w-5 h-5 md:w-6 md:h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.684 13.342C8.886 12.938 9 12.482 9 12c0-.482-.114-.938-.316-1.342m0 2.684a3 3 0 110-2.684m0 2.684l6.632 3.316m-6.632-6l6.632-3.316m0 0a3 3 0 105.367-2.684 3 3 0 00-5.367 2.684zm0 9.316a3 3 0 105.368 2.684 3 3 0 00-5.368-2.684z"></path></svg>
                </div>
                <div>
                    <h4 class="text-xs md:text-sm font-bold text-white uppercase tracking-wider">Log de Cría Público</h4>
                    <p class="text-[10px] md:text-xs text-zinc-500 italic">Comparte tu progreso</p>
                </div>
            </div>
            
            <div class="flex flex-col sm:flex-row items-stretch sm:items-center gap-3 w-full lg:w-auto">
                <?php if ($colony['is_public']): ?>
                    <div class="flex-1 relative group">
                        <input type="text" readonly value="<?= BASE_URL ?>/log/<?= $userSlug ?>/<?= $colony['public_slug'] ?>" 
                               class="bg-black/40 border border-white/10 rounded-xl px-4 py-2 text-[10px] font-mono text-blue-300 w-full lg:w-64 focus:ring-0 focus:border-blue-500/50 transition-all pr-12">
                        <div class="absolute right-2 top-1/2 -translate-y-1/2">
                            <button onclick="copyToClipboard(this, '<?= BASE_URL ?>/log/<?= $userSlug ?>/<?= $colony['public_slug'] ?>')" class="p-1.5 bg-blue-500 rounded-lg text-white shadow-lg shadow-blue-500/20 hover:bg-blue-400 transition-all">
                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 5H6a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2v-1M8 5a2 2 0 002 2h2a2 2 0 002-2M8 5a2 2 0 012-2h2a2 2 0 012 2m-3 8v3m-3-3h6"></path></svg>
                            </button>
                        </div>
                    </div>
                <?php endif; ?>

                <form action="<?= BASE_URL ?>/colonias/publico/<?= $colony['id'] ?>" method="POST" class="w-full sm:w-auto">
                    <input type="hidden" name="is_public" value="<?= $colony['is_public'] ? 0 : 1 ?>">
                    <button type="submit" class="w-full sm:w-auto px-6 py-2.5 rounded-xl text-[10px] font-black uppercase tracking-widest transition-all <?= $colony['is_public'] ? 'bg-red-500/10 text-red-500 border border-red-500/20 hover:bg-red-500/20' : 'bg-emerald-500 text-emerald-950 shadow-xl shadow-emerald-500/20 hover:bg-emerald-400' ?>">
                        <?= $colony['is_public'] ? 'Hacer Privado' : 'Hacer Público' ?>
                    </button>
                </form>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <div class="space-y-6 lg:col-span-1">
            <div class="glass-card p-6 border-white/5 bg-white/5">
                <h3 class="text-sm font-bold text-zinc-500 uppercase tracking-[0.2em] mb-4 border-b border-white/10 pb-2">Descripción</h3>
                <p class="text-zinc-300 text-sm leading-relaxed italic">
                    <?= nl2br(htmlspecialchars($colony['descripcion'] ?: 'Sin descripción.')) ?>
                </p>
            </div>

            <!-- Identificación Digital (QR) -->
            <div class="glass-card p-6 border-blue-500/20 bg-blue-500/5 relative overflow-hidden group">
                <div class="absolute -right-8 -bottom-8 w-24 h-24 bg-blue-500/10 rounded-full blur-2xl group-hover:scale-150 transition-transform duration-700"></div>
                <h3 class="text-sm font-bold text-blue-400 uppercase tracking-[0.2em] mb-4 border-b border-blue-500/10 pb-2 flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v1l-3 3h-6v-6h6l3 3v1m0 0l3-3h6v6h-6l-3-3m0 0v6M5 8h2m-2 2h2m2-2h2m-2 2h2m7-2h2m-2 2h2m2-2h2m-2 2h2"></path></svg>
                    ID Digital QR
                </h3>
                
                <div class="flex flex-col items-center gap-4 text-center">
                    <div class="p-3 bg-white rounded-2xl shadow-xl shadow-blue-500/20 group-hover:rotate-2 transition-transform">
                        <?php 
                        $quickUrl = (isset($_SERVER['HTTPS']) ? "https" : "http") . "://$_SERVER[HTTP_HOST]" . BASE_URL . "/colonias/ver/" . $colony['id'] . "?quick_entry=1";
                        $qrApi = "https://api.qrserver.com/v1/create-qr-code/?size=150x150&data=" . urlencode($quickUrl);
                        ?>
                        <img src="<?= $qrApi ?>" alt="QR Code" class="w-24 h-24">
                    </div>
                    <div>
                        <p class="text-[10px] text-zinc-500 uppercase font-black tracking-widest mb-3">Identificador Físico</p>
                        <button onclick="printLabel()" class="w-full bg-blue-500 hover:bg-blue-600 text-white px-4 py-2.5 rounded-xl text-[10px] font-black uppercase tracking-widest transition-all shadow-lg shadow-blue-500/20 flex items-center justify-center gap-2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path></svg>
                            Imprimir Etiqueta
                        </button>
                    </div>
                </div>
            </div>
        </div>
        <div class="glass-card p-4 md:p-6 lg:col-span-2 border-white/5">
            <div class="flex flex-col sm:flex-row items-center justify-between mb-6 border-b border-white/10 pb-4 gap-4">
                <h3 class="text-lg font-bold text-white flex items-center gap-2 w-full">
                    <svg class="w-6 h-6 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.168.477 4 1.253m0-13C13.168 5.477 14.754 5 16.5 5S19.832 5.477 21 6.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4 1.253"></path></svg>
                    Diario de Cría
                </h3>
                <button onclick="toggleDiaryForm()" class="w-full sm:w-auto bg-blue-500 hover:bg-blue-600 text-white px-6 py-3 rounded-xl text-xs font-black uppercase tracking-widest transition-all shadow-lg shadow-blue-500/20 active:scale-95 whitespace-nowrap">+ Nueva Entrada</button>
            </div>

            <?php if (empty($diary)): ?>
                <div class="text-center py-12">
                    <div class="w-16 h-16 bg-white/5 rounded-full flex items-center justify-center mx-auto mb-4 border border-white/10">
                        <svg class="w-8 h-8 text-white/20" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.168.477 4 1.253m0-13C13.168 5.477 14.754 5 16.5 5S19.832 5.477 21 6.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4 1.253"></path></svg>
                    </div>
                    <p class="text-muted text-sm">Tu colonia aún no tiene historias. <br>¡Cuéntanos qué ha pasado hoy!</p>
                </div>
            <?php else: ?>
                <div class="space-y-8 relative before:absolute before:inset-0 before:ml-5 before:-translate-x-px md:before:mx-auto md:before:translate-x-0 before:h-full before:w-0.5 before:bg-gradient-to-b before:from-transparent before:via-white/10 before:to-transparent">
                    <?php 
                    $eventIcons = [
                        'Alimentación' => '🍖',
                        'Limpieza'     => '✨',
                        'Mantenimiento'=> '🛠️',
                        'Observación'  => '🔍',
                        'Mudanza'      => '🏠',
                        'Nacimientos'  => '🥚'
                    ];
                    foreach ($diary as $entry): 
                    ?>
                        <div class="relative flex items-center justify-between md:justify-normal md:odd:flex-row-reverse group">
                            <!-- Icon/Dot -->
                            <div class="flex items-center justify-center w-10 h-10 rounded-full border border-white/20 bg-zinc-900 text-white z-10 shrink-0 md:order-1 md:group-odd:-translate-x-1/2 md:group-even:translate-x-1/2 shadow-xl">
                                <span class="text-lg"><?= $eventIcons[$entry['tipo_evento']] ?? '📝' ?></span>
                            </div>
                            <!-- Card -->
                            <div class="w-[calc(100%-4rem)] md:w-[calc(50%-2.5rem)] glass-card !p-5 group-hover:border-white/20 transition-all">
                                <div class="flex items-center justify-between mb-3">
                                    <div class="flex items-center gap-2">
                                        <span class="text-[10px] font-black uppercase text-blue-400 tracking-tighter bg-blue-400/10 px-2 py-0.5 rounded-md"><?= htmlspecialchars($entry['tipo_evento']) ?></span>
                                        <?php if ($entry['stock_id']): ?>
                                            <span class="text-[10px] font-bold text-zinc-500 flex items-center gap-1 bg-white/5 px-2 py-0.5 rounded-md border border-white/5">
                                                🍴 <?= htmlspecialchars($entry['stock_nombre']) ?>: <?= $entry['cantidad_usada'] ?><?= htmlspecialchars($entry['stock_unidad']) ?>
                                            </span>
                                        <?php endif; ?>
                                        <!-- Toggle de Visibilidad -->
                                        <form action="<?= BASE_URL ?>/diario/visibilidad/<?= $entry['id'] ?>" method="POST" class="inline-block ml-2">
                                            <input type="hidden" name="is_visible" value="<?= $entry['is_visible'] ? 0 : 1 ?>">
                                            <button type="submit" class="p-1 hover:bg-white/10 rounded transition-colors" title="<?= $entry['is_visible'] ? 'Ocultar en Log Público' : 'Mostrar en Log Público' ?>">
                                                <?php if ($entry['is_visible']): ?>
                                                    <svg class="w-3 h-3 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                                                <?php else: ?>
                                                    <svg class="w-3 h-3 text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.542-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l18 18"></path></svg>
                                                <?php endif; ?>
                                            </button>
                                        </form>
                                    </div>
                                    <time class="text-[10px] text-muted font-bold"><?= date('d M, Y', strtotime($entry['fecha_entrada'])) ?></time>
                                </div>
                                <p class="text-sm text-main leading-relaxed mb-4"><?= nl2br(htmlspecialchars($entry['entrada'])) ?></p>
                                <?php if ($entry['imagen_url']): ?>
                                    <div class="rounded-xl overflow-hidden border border-white/5 shadow-inner">
                                        <img src="<?= BASE_URL ?>/uploads/diary/<?= $entry['imagen_url'] ?>" class="w-full h-auto object-cover max-h-64 hover:scale-105 transition-transform duration-500 cursor-zoom-in" onclick="openLightbox(this.src)">
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<!-- Modal de Población (Punto de entrada global) -->
<div id="pop-form" class="hidden fixed inset-0 z-[100] flex items-center justify-center p-4">
    <!-- Backdrop -->
    <div class="absolute inset-0 bg-zinc-950/80 backdrop-blur-md" onclick="togglePopForm()"></div>
    
    <!-- Modal Content -->
    <div class="relative w-full max-w-lg bg-zinc-900 border border-white/10 rounded-[2.5rem] shadow-2xl p-8 overflow-hidden">
        <div class="absolute -top-24 -right-24 w-48 h-48 bg-emerald-500/10 rounded-full blur-3xl"></div>
        
        <form action="<?= BASE_URL ?>/colonias/poblacion/<?= $colony['id'] ?>" method="POST" class="relative z-10">
            <div class="text-center mb-8">
                <div class="inline-flex p-4 bg-emerald-500/10 rounded-2xl text-emerald-400 mb-4 border border-emerald-500/20">
                    <svg class="w-8 h-8" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                </div>
                <h3 class="text-2xl font-bold text-white tracking-tight">Nuevo Recuento</h3>
                <p class="text-sm text-zinc-400 mt-1">Registra el estado actual de tu colonia</p>
            </div>

            <div class="space-y-6">
                <?php if ($colony['poblacion_detallada']): ?>
                    <div class="grid grid-cols-2 gap-4 max-h-[40vh] overflow-y-auto pr-2 custom-scrollbar">
                        <?php 
                        $currentCastes = json_decode($colony['poblacion_detallada'], true);
                        foreach ($icons as $key => $icon): ?>
                            <div class="p-4 bg-white/5 rounded-2xl border border-white/5 focus-within:border-emerald-500/50 transition-all hover:bg-white/[0.07]">
                                <label class="flex items-center gap-2 text-[10px] uppercase font-black text-zinc-500 mb-2">
                                    <span><?= $icon ?></span>
                                    <span><?= $key ?></span>
                                </label>
                                <input type="number" name="casta[<?= $key ?>]" value="<?= $currentCastes[$key] ?? 0 ?>" min="0" required 
                                    class="w-full bg-transparent border-none p-0 text-2xl font-bold text-white focus:ring-0 placeholder:text-white/20">
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php else: ?>
                    <div class="p-8 bg-white/5 rounded-3xl border border-white/10 text-center">
                        <label class="block text-xs font-bold text-zinc-500 uppercase mb-4 tracking-widest text-center">Total de Obreras</label>
                        <input type="number" name="poblacion" value="<?= $colony['poblacion_actual'] ?>" min="0" required 
                            class="w-full bg-transparent border-none p-0 text-6xl font-black text-white text-center focus:ring-0">
                    </div>
                <?php endif; ?>

                <div class="flex gap-4 pt-4">
                    <button type="button" onclick="togglePopForm()" 
                        class="flex-1 px-6 py-4 text-sm bg-white/5 rounded-2xl hover:bg-white/10 text-white font-bold transition-all border border-white/5">
                        Cancelar
                    </button>
                    <button type="submit" 
                        class="flex-1 px-6 py-4 text-sm bg-emerald-500 rounded-2xl hover:bg-emerald-400 text-emerald-950 font-black transition-all shadow-xl shadow-emerald-500/20 active:scale-95">
                        Guardar Registro
                    </button>
                </div>
            </div>
        </form>
    </div>
                <p class="text-sm text-zinc-400 mt-1">Comparte lo que ha pasado con tus hormigas</p>
            </div>

            <div class="space-y-6">
                <div class="grid grid-cols-2 gap-4">
                    <div class="space-y-2">
                        <label class="text-[10px] uppercase font-bold text-zinc-500 ml-1 tracking-widest">Tipo de Evento</label>
                        <select name="tipo_evento" id="tipo_evento_select" onchange="toggleStockFields()" class="magic-input w-full bg-white/5 text-sm text-white">
                            <option value="Observación">🔍 Observación</option>
                            <option value="Alimentación">🍖 Alimentación</option>
                            <option value="Mantenimiento">🛠️ Mantenimiento</option>
                            <option value="Limpieza">✨ Limpieza</option>
                            <option value="Mudanza">🏠 Mudanza</option>
                            <option value="Nacimientos">🥚 Nacimientos</option>
                        </select>
                    </div>
                    <div class="space-y-2">
                        <label class="text-[10px] uppercase font-bold text-zinc-500 ml-1 tracking-widest">Fecha</label>
                        <input type="date" name="fecha_entrada" value="<?= date('Y-m-d') ?>" class="magic-input w-full bg-white/5 text-sm text-white [color-scheme:dark]">
                    </div>
                </div>

                <!-- Sección de Stock (Solo para Alimentación) -->
                <div id="stock-fields" class="hidden space-y-4 p-5 rounded-3xl bg-blue-500/5 border border-blue-500/20 animate-in fade-in slide-in-from-top-2">
                    <div class="flex items-center gap-2 mb-2">
                        <span class="text-blue-400">🍖</span>
                        <h4 class="text-xs font-black uppercase text-blue-400 tracking-widest">Detalles de Alimentación</h4>
                    </div>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div class="space-y-2">
                            <label class="text-[10px] uppercase font-bold text-zinc-500 ml-1">Seleccionar Alimento</label>
                            <select name="stock_id" id="stock_id_select" class="magic-input w-full bg-white/5 text-sm text-white">
                                <option value="">-- Seleccionar --</option>
                                <?php foreach ($stocks as $s): ?>
                                    <option value="<?= $s['id'] ?>" data-unidad="<?= htmlspecialchars($s['unidad']) ?>" data-cantidad="<?= $s['cantidad'] ?>">
                                        <?= htmlspecialchars($s['nombre']) ?> (<?= $s['cantidad'] ?><?= htmlspecialchars($s['unidad']) ?>)
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="space-y-2">
                            <label class="text-[10px] uppercase font-bold text-zinc-500 ml-1">Cantidad Gastada</label>
                            <div class="relative">
                                <input type="number" step="0.01" name="cantidad_usada" id="cantidad_usada_input" class="magic-input w-full bg-white/5 text-sm text-white pr-12" placeholder="0.00">
                                <span id="unidad-badge" class="absolute right-4 top-1/2 -translate-y-1/2 text-[10px] font-black text-zinc-500 uppercase">--</span>
                            </div>
                        </div>
                    </div>
                    <p id="stock-warning" class="hidden text-[10px] text-red-400 font-bold mt-2">⚠️ No tienes suficiente stock de este alimento.</p>
                </div>

                <div class="space-y-2">
                    <label class="text-[10px] uppercase font-bold text-zinc-500 ml-1 tracking-widest">Descripción</label>
                    <textarea name="entrada" rows="4" required class="magic-input w-full bg-white/5 text-sm text-white resize-none" placeholder="Hoy he visto a la reina poner sus primeros huevos..."></textarea>
                </div>

                <div class="space-y-2">
                    <label class="text-[10px] uppercase font-bold text-zinc-500 ml-1 tracking-widest">Imagen (Opcional)</label>
                    <div class="relative group">
                        <input type="file" name="imagen" id="diary-img-input" class="hidden" accept="image/*" onchange="previewDiaryImage(this)">
                        <label for="diary-img-input" class="flex flex-col items-center justify-center w-full h-32 border-2 border-dashed border-white/10 rounded-2xl cursor-pointer hover:bg-white/5 hover:border-blue-500/50 transition-all overflow-hidden relative">
                            <div id="diary-preview-placeholder" class="text-center">
                                <svg class="w-6 h-6 text-zinc-500 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                                <span class="text-[10px] text-zinc-500 font-bold">Subir Foto</span>
                            </div>
                            <img id="diary-image-render" src="" class="hidden absolute inset-0 w-full h-full object-cover">
                        </label>
                    </div>
                </div>

                <div class="flex gap-4 pt-4">
                    <button type="button" onclick="toggleDiaryForm()" class="flex-1 px-6 py-4 text-sm bg-white/5 rounded-2xl hover:bg-white/10 text-white font-bold transition-all border border-white/5">Cancelar</button>
                    <button type="submit" class="flex-1 px-6 py-4 text-sm bg-blue-500 rounded-2xl hover:bg-blue-400 text-white font-black transition-all shadow-xl shadow-blue-500/20 active:scale-95">Guardar Historia</button>
                </div>
            </div>
        </form>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
function toggleDiaryForm() {
    const form = document.getElementById('diary-form');
    form.classList.toggle('hidden');
}

function previewDiaryImage(input) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();
        reader.onload = function(e) {
            document.getElementById('diary-image-render').src = e.target.result;
            document.getElementById('diary-image-render').classList.remove('hidden');
            document.getElementById('diary-preview-placeholder').classList.add('hidden');
        }
        reader.readAsDataURL(input.files[0]);
    }
}

function copyToClipboard(text) {
    navigator.clipboard.writeText(text).then(() => {
        alert('Enlace copiado al portapapeles');
    });
}

function toggleStockFields() {
    const select = document.getElementById('tipo_evento_select');
    const fields = document.getElementById('stock-fields');
    if (select.value === 'Alimentación') {
        fields.classList.remove('hidden');
    } else {
        fields.classList.add('hidden');
    }
}

// Actualizar unidad y validar cantidad
document.getElementById('stock_id_select').addEventListener('change', function() {
    const option = this.options[this.selectedIndex];
    const badge = document.getElementById('unidad-badge');
    if (option.value) {
        badge.innerText = option.getAttribute('data-unidad');
    } else {
        badge.innerText = '--';
    }
    validateStock();
});

document.getElementById('cantidad_usada_input').addEventListener('input', validateStock);

function validateStock() {
    const select = document.getElementById('stock_id_select');
    const option = select.options[select.selectedIndex];
    const input = document.getElementById('cantidad_usada_input');
    const warning = document.getElementById('stock-warning');
    const submitBtn = document.querySelector('#diary-form button[type="submit"]');

    if (option.value && input.value) {
        const available = parseFloat(option.getAttribute('data-cantidad'));
        const requested = parseFloat(input.value);
        
        if (requested > available) {
            warning.classList.remove('hidden');
            submitBtn.disabled = true;
            submitBtn.classList.add('opacity-50', 'cursor-not-allowed');
        } else {
            warning.classList.add('hidden');
            submitBtn.disabled = false;
            submitBtn.classList.remove('opacity-50', 'cursor-not-allowed');
        }
    } else {
        warning.classList.add('hidden');
        submitBtn.disabled = false;
        submitBtn.classList.remove('opacity-50', 'cursor-not-allowed');
    }
}

function togglePopForm() {
    const form = document.getElementById('pop-form');
    form.classList.toggle('hidden');
}

document.addEventListener('DOMContentLoaded', function() {
    const ctx = document.getElementById('evolutionChart').getContext('2d');
    
    // Preparar datos del PHP
    const historyData = <?= json_encode($history) ?>;
    const labels = historyData.map(entry => {
        const date = new Date(entry.fecha_registro);
        return date.toLocaleDateString('es-ES', { day: '2-digit', month: 'short' });
    });

    const hasCastes = historyData.some(entry => entry.detalles_json !== null);
    let datasets = [];

    // Colores por casta
    const casteColors = {
        'reina': '#fbbf24',   // Amber 400
        'minor': '#60a5fa',   // Blue 400
        'media': '#34d399',   // Emerald 400
        'major': '#fb923c',   // Orange 400
        'soldado': '#f87171', // Red 400
        'default': 'var(--theme-primary)'
    };

    if (hasCastes) {
        // Extraer nombres de todas las castas presentes
        const casteNames = new Set();
        historyData.forEach(entry => {
            if (entry.detalles_json) {
                const details = JSON.parse(entry.detalles_json);
                Object.keys(details).forEach(name => casteNames.add(name));
            }
        });

        // Crear un dataset para cada casta
        datasets = Array.from(casteNames).map(name => {
            const color = casteColors[name.toLowerCase()] || casteColors['default'];
            return {
                label: name.charAt(0).toUpperCase() + name.slice(1),
                data: historyData.map(entry => {
                    if (!entry.detalles_json) return 0;
                    const details = JSON.parse(entry.detalles_json);
                    return parseInt(details[name] || 0);
                }),
                borderColor: color,
                backgroundColor: color + '33', // 20% opacidad
                fill: true,
                tension: 0.4,
                borderWidth: 2,
                pointRadius: 2
            };
        });
    } else {
        // Dataset simple si no hay castas
        datasets = [{
            label: 'Población Total',
            data: historyData.map(entry => entry.poblacion),
            borderColor: 'var(--theme-primary)',
            backgroundColor: 'rgba(59, 130, 246, 0.2)', // Azul por defecto
            fill: true,
            tension: 0.4,
            borderWidth: 3,
            pointRadius: 3
        }];
    }

    const textColor = getComputedStyle(document.documentElement).getPropertyValue('--theme-text-muted').trim() || '#9ca3af';

    // Preparar dataset de Benchmarking (Media de la Especie)
    const averageHistory = <?= json_encode($averageHistory) ?>;
    const acquisitionDate = new Date('<?= $colony['fecha_adquisicion'] ?>');
    
    // Mapear la media global a los puntos temporales de ESTA colonia
    const communityAverageData = historyData.map(entry => {
        const currentDate = new Date(entry.fecha_registro);
        const daysOffset = Math.floor((currentDate - acquisitionDate) / (1000 * 60 * 60 * 24));
        
        // Buscar el promedio más cercano para este offset de días
        const avgPoint = averageHistory.find(h => parseInt(h.days_offset) >= daysOffset);
        return avgPoint ? avgPoint.avg_poblacion : null;
    });

    if (communityAverageData.some(d => d !== null)) {
        datasets.push({
            label: 'Media Comunidad (<?= htmlspecialchars($colony['especie_nombre']) ?>)',
            data: communityAverageData,
            borderColor: '#94a3b8',
            borderDash: [5, 5],
            backgroundColor: 'transparent',
            fill: false,
            tension: 0.4,
            borderWidth: 2,
            pointRadius: 0,
            hoverRadius: 0
        });
    }

    new Chart(ctx, {
        type: 'line',
        data: {
            labels: labels,
            datasets: datasets
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            interaction: {
                mode: 'index',
                intersect: false,
            },
            plugins: {
                legend: { 
                    display: true,
                    position: 'top',
                    align: 'end',
                    labels: { 
                        color: textColor, 
                        boxWidth: 10, 
                        padding: 15,
                        font: { size: 10, weight: 'bold' } 
                    }
                },
                tooltip: {
                    usePointStyle: true,
                    callbacks: {
                        label: function(context) {
                            return ` ${context.dataset.label}: ${context.parsed.y}`;
                        }
                    }
                }
            },
            scales: {
                y: {
                    stacked: false, // Desactivar stack para ver la comparativa clara
                    beginAtZero: true,
                    grid: { color: 'rgba(255, 255, 255, 0.05)' },
                    ticks: { color: textColor, font: { size: 10 } }
                },
                x: {
                    grid: { display: false },
                    ticks: { color: textColor, font: { size: 10 } }
                }
            }
        }
    });
});

// Detectar Entrada Rápida desde QR
document.addEventListener('DOMContentLoaded', function() {
    const urlParams = new URLSearchParams(window.location.search);
    if (urlParams.get('quick_entry') === '1') {
        setTimeout(() => {
            if (typeof toggleDiaryForm === 'function') {
                toggleDiaryForm();
                document.getElementById('diaryForm')?.scrollIntoView({ behavior: 'smooth' });
            }
        }, 500);
    }
});

function printLabel() {
    const printWindow = window.open('', '_blank', 'width=600,height=600');
    const qrUrl = "<?= (isset($_SERVER['HTTPS']) ? "https" : "http") . "://$_SERVER[HTTP_HOST]" . BASE_URL . "/colonias/ver/" . $colony['id'] . "?quick_entry=1" ?>";
    const qrApiUrl = "https://api.qrserver.com/v1/create-qr-code/?size=300x300&data=" + encodeURIComponent(qrUrl);
    const colonyName = "<?= htmlspecialchars($colony['nombre']) ?>";
    const speciesName = "<?= htmlspecialchars($colony['especie_nombre']) ?>";
    
    printWindow.document.write(`
        <!DOCTYPE html>
        <html>
        <head>
            <title>Etiqueta ID - ${colonyName}</title>
            <script src="https://cdn.tailwindcss.com"></script>
            <style>
                @media print {
                    body { margin: 0; padding: 0; background: white !important; }
                    .no-print { display: none; }
                }
                body {
                    font-family: 'Inter', sans-serif;
                    background: #f4f4f5;
                    display: flex;
                    flex-direction: column;
                    align-items: center;
                    justify-content: center;
                    min-height: 100vh;
                }
                .label-card {
                    width: 7cm;
                    height: 9cm;
                    background: white;
                    border: 2px solid #e4e4e7;
                    border-radius: 12px;
                    padding: 24px;
                    display: flex;
                    flex-direction: column;
                    align-items: center;
                    justify-content: space-between;
                    box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1);
                    position: relative;
                }
                .label-card::before {
                    content: '';
                    position: absolute;
                    top: 0; left: 0; right: 0; height: 6px;
                    background: linear-gradient(90deg, #3b82f6, #8b5cf6);
                    border-radius: 12px 12px 0 0;
                }
            </style>
        </head>
        <body>
            <div class="no-print mb-8 sticky top-4">
                <button onclick="window.print()" class="bg-blue-600 hover:bg-blue-700 text-white px-8 py-3 rounded-xl font-bold shadow-lg transition-all active:scale-95">Imprimir Etiqueta (7x9 cm)</button>
                <p class="text-zinc-500 text-[10px] mt-2 text-center uppercase font-black tracking-widest">Activa "Gráficos de fondo" al imprimir</p>
            </div>
            
            <div class="label-card">
                <div class="text-center w-full">
                    <p class="text-[8px] font-black uppercase tracking-[0.3em] text-blue-600 mb-1">AntMaster Pro</p>
                    <h1 class="text-xl font-black text-zinc-900 leading-tight mb-1 truncate">${colonyName}</h1>
                    <p class="text-[10px] font-bold text-zinc-500 italic truncate">${speciesName}</p>
                </div>
                
                <div class="my-4 border-2 border-zinc-100 p-2 rounded-xl bg-white">
                    <img src="${qrApiUrl}" class="w-40 h-40">
                </div>
                
                <div class="text-center w-full border-t border-zinc-50 pt-3">
                    <p class="text-[7px] font-black text-zinc-400 uppercase tracking-widest">Escanea para añadir observación</p>
                </div>
            </div>
        </body>
        </html>
    `);
    printWindow.document.close();
}
</script>
