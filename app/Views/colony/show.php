<?php 
$icons = [
    'reina'   => '👑',
    'minor'   => '🐜',
    'media'   => '🛡️',
    'major'   => '🔨',
    'soldado' => '⚔️'
];
// Filtrar castas que tienen cantidad > 0
if ($colony['poblacion_detallada']) {
    $castasRaw = json_decode($colony['poblacion_detallada'], true);
    $castas = array_filter($castasRaw, function($v) { return $v > 0; });
} else {
    $castas = [];
}
?>

<div class="colony-profile-container animate-fade-in">
    <!-- Header Hero -->
    <div class="relative h-64 md:h-[450px] rounded-[3.5rem] overflow-hidden mb-10 group shadow-2xl ring-1 ring-white/10">
        <?php if ($colony['imagen']): ?>
            <img src="<?= BASE_URL ?>/uploads/colonies/<?= $colony['imagen'] ?>" class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-105">
        <?php else: ?>
            <div class="w-full h-full bg-gradient-to-br from-zinc-900 via-blue-950 to-zinc-900 flex flex-col items-center justify-center relative overflow-hidden">
                <div class="absolute inset-0 opacity-20 pointer-events-none">
                    <svg class="w-full h-full" viewBox="0 0 100 100" preserveAspectRatio="none"><path d="M0 100 C 20 0 50 0 100 100" fill="none" stroke="currentColor" stroke-width="0.1" class="text-blue-500"></path></svg>
                </div>
                <div class="p-8 bg-blue-500/10 rounded-full border border-blue-500/20 mb-4 animate-pulse">
                    <svg class="w-16 h-16 text-blue-400/40" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                </div>
                <a href="<?= BASE_URL ?>/colonias/editar/<?= $colony['id'] ?>" class="px-5 py-2.5 bg-blue-500/20 hover:bg-blue-500 text-blue-300 hover:text-white rounded-full text-[10px] font-black uppercase tracking-widest transition-all border border-blue-500/30">Añadir Foto de Perfil</a>
            </div>
        <?php endif; ?>
        <div class="absolute inset-0 bg-gradient-to-t from-black via-black/20 to-transparent"></div>
        
        <!-- Top Navigation (Back & Actions Unified) -->
        <div class="absolute top-0 left-0 right-0 p-8 flex items-center justify-between z-20">
            <a href="<?= BASE_URL ?>/colonias" class="group flex items-center gap-3 px-5 py-3 bg-black/40 backdrop-blur-xl rounded-2xl border border-white/10 text-white/80 hover:text-white transition-all hover:bg-black/60 shadow-2xl">
                <svg class="w-5 h-5 transition-transform group-hover:-translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                <span class="text-xs font-black uppercase tracking-widest">Volver</span>
            </a>

            <div class="flex items-center h-12 bg-black/40 backdrop-blur-xl rounded-2xl border border-white/10 p-0.5 shadow-2xl overflow-hidden">
                <a href="<?= BASE_URL ?>/colonias/editar/<?= $colony['id'] ?>" class="flex items-center justify-center w-11 h-11 text-white/70 hover:text-white hover:bg-white/10 rounded-xl transition-all" title="Editar">
                    <div class="flex items-center justify-center w-5 h-5 mb-0">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                    </div>
                </a>
                <div class="w-[1px] h-4 bg-white/10 shrink-0"></div>
                <form action="<?= BASE_URL ?>/colonias/borrar/<?= $colony['id'] ?>" method="POST" onsubmit="return confirm('¿Estás seguro de eliminar esta colonia? Este proceso es irreversible.')" class="m-0 p-0 flex items-center">
                    <button type="submit" class="flex items-center justify-center w-11 h-11 text-red-500/70 hover:text-red-500 hover:bg-red-500/10 rounded-xl transition-all border-none bg-transparent cursor-pointer p-0 m-0" title="Eliminar">
                        <div class="flex items-center justify-center w-5 h-5 mb-0">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                        </div>
                    </button>
                </form>
            </div>
        </div>

        <div class="absolute bottom-0 left-0 p-8 md:p-12 w-full">
            <h1 class="text-5xl md:text-8xl font-black text-white drop-shadow-2xl tracking-tighter leading-none mb-4">
                <?= htmlspecialchars($colony['nombre']) ?>
            </h1>
            <div class="flex items-center gap-3">
                <span class="px-5 py-2 bg-blue-500 text-white backdrop-blur-md rounded-xl text-[10px] font-black uppercase tracking-[0.2em] shadow-xl shadow-blue-500/40 border border-white/20">
                    <?= htmlspecialchars($colony['especie_nombre']) ?> 
                    <span class="opacity-70 font-light ml-1 italic">(<?= htmlspecialchars($colony['especie_nombre_cientifico']) ?>)</span>
                </span>
                <?php if ($colony['is_public']): ?>
                    <span class="px-5 py-2 bg-emerald-500/20 backdrop-blur-md rounded-xl text-emerald-400 text-[10px] font-black uppercase tracking-[0.2em] border border-emerald-500/40">🌍 Público</span>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <!-- Main Grid Layout -->
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-start">
        
        <!-- Center/Left Content (Tabs & Actions) -->
        <div class="lg:col-span-8 space-y-8">
            
            <!-- Quick Stats Bar -->
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                <div class="glass-card p-6 flex flex-col justify-between group">
                    <div class="flex items-center justify-between mb-4">
                        <span class="text-[10px] uppercase font-black text-zinc-500 tracking-[0.2em]">Población</span>
                        <div class="w-8 h-8 rounded-lg bg-emerald-500/10 flex items-center justify-center text-emerald-400">
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                        </div>
                    </div>
                    <div class="flex items-end justify-between">
                        <span class="text-4xl font-black text-white"><?= number_format($colony['poblacion_actual']) ?></span>
                        <button onclick="togglePopForm()" class="px-3 py-1.5 bg-emerald-500/20 hover:bg-emerald-500/30 rounded-lg text-emerald-400 text-[10px] font-black uppercase tracking-widest transition-all border border-emerald-500/10">+ Recuento</button>
                    </div>
                </div>

                <div class="glass-card p-6 flex flex-col justify-between">
                    <span class="text-[10px] uppercase font-black text-zinc-500 tracking-[0.2em] mb-4">Hormiguero</span>
                    <div class="flex items-center gap-4">
                        <div class="w-10 h-10 rounded-xl bg-blue-500/10 flex items-center justify-center text-blue-400">
                            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path></svg>
                        </div>
                        <span class="text-xl font-bold text-white"><?= htmlspecialchars($colony['tipo_hormiguero'] ?: 'No definido') ?></span>
                    </div>
                </div>

                <div class="glass-card p-6 flex flex-col justify-between">
                    <span class="text-[10px] uppercase font-black text-zinc-500 tracking-[0.2em] mb-4">Tiempo Contigo</span>
                    <div class="flex items-center gap-4">
                        <div class="w-10 h-10 rounded-xl bg-purple-500/10 flex items-center justify-center text-purple-400">
                            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        </div>
                        <span class="text-xl font-bold text-white"><?= get_time_elapsed($colony['fecha_adquisicion']) ?></span>
                    </div>
                </div>
            </div>

            <!-- Tab Switcher -->
            <div class="flex items-center gap-2 p-1.5 bg-white/5 rounded-[1.5rem] w-full sm:w-fit border border-white/5 backdrop-blur-xl">
                <button onclick="showTab('diario')" id="btn-tab-diario" class="tab-btn px-6 py-3 rounded-[1.2rem] text-xs font-black uppercase tracking-widest transition-all bg-blue-500 text-white shadow-xl shadow-blue-500/20 active">
                    📓 Diario
                </button>
                <button onclick="showTab('galeria')" id="btn-tab-galeria" class="tab-btn px-6 py-3 rounded-[1.2rem] text-xs font-black uppercase tracking-widest transition-all text-zinc-500 hover:text-white hover:bg-white/5">
                    🖼️ Galería
                </button>
                <button onclick="showTab('extras')" id="btn-tab-extras" class="tab-btn px-6 py-3 rounded-[1.2rem] text-xs font-black uppercase tracking-widest transition-all text-zinc-500 hover:text-white hover:bg-white/5">
                    ⚙️ Extras
                </button>
            </div>

            <!-- Tab Contents -->
            <div id="tab-content" class="min-h-[500px]">
                
                <!-- Diario Tab -->
                <div id="section-diario" class="tab-section">
                    <div class="flex items-center justify-between mb-8">
                        <h2 class="text-2xl font-black text-white">Cronología de Cría</h2>
                        <button onclick="toggleDiaryForm()" class="bg-blue-500 hover:bg-blue-400 text-white px-6 py-3 rounded-xl text-[10px] font-black uppercase tracking-widest transition-all shadow-xl shadow-blue-500/20">+ Nueva Entrada</button>
                    </div>

                    <?php if (empty($diary)): ?>
                        <div class="glass-card p-12 text-center">
                            <div class="w-20 h-20 bg-white/5 rounded-full flex items-center justify-center mx-auto mb-6 border border-white/10">
                                <svg class="w-10 h-10 text-white/20" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.168.477 4 1.253m0-13C13.168 5.477 14.754 5 16.5 5S19.832 6.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4 1.253"></path></svg>
                            </div>
                            <h3 class="text-xl font-bold text-white mb-2">Sin registros</h3>
                            <p class="text-zinc-500 max-w-xs mx-auto">Cuéntanos cómo van tus hormigas hoy para empezar tu diario personalizado.</p>
                        </div>
                    <?php else: ?>
                        <div class="space-y-6">
                            <?php 
                            $eventIcons = [
                                'Alimentación' => '🍖',
                                'Limpieza'     => '✨',
                                'Mantenimiento'=> '🛠️',
                                'Observación'  => '🔍',
                                'Mudanza'      => '🏠',
                                'Nacimientos'  => '🥚'
                            ];
                            foreach ($diary as $entry): ?>
                                <div class="glass-card p-6 sm:p-8 hover:border-blue-500/30 transition-all group">
                                    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-6">
                                        <div class="flex items-center gap-4">
                                            <div class="w-12 h-12 rounded-2xl bg-zinc-800/50 flex items-center justify-center text-xl shadow-inner border border-white/5">
                                                <?= $eventIcons[$entry['tipo_evento']] ?? '📝' ?>
                                            </div>
                                            <div>
                                                <h4 class="text-white font-bold tracking-tight"><?= htmlspecialchars($entry['tipo_evento']) ?></h4>
                                                <time class="text-[10px] text-zinc-500 font-bold uppercase tracking-widest"><?= date('d M, Y', strtotime($entry['fecha_entrada'])) ?></time>
                                            </div>
                                        </div>
                                        <div class="flex items-center gap-3">
                                            <?php if ($entry['stock_id']): ?>
                                                <span class="px-3 py-1.5 bg-blue-500/10 rounded-lg text-[10px] font-bold text-blue-300 border border-blue-500/10">
                                                    🍴 <?= htmlspecialchars($entry['stock_nombre']) ?>: <?= $entry['cantidad_usada'] ?><?= htmlspecialchars($entry['stock_unidad']) ?>
                                                </span>
                                            <?php endif; ?>
                                            <form action="<?= BASE_URL ?>/diario/visibilidad/<?= $entry['id'] ?>" method="POST" class="inline">
                                                <input type="hidden" name="is_visible" value="<?= $entry['is_visible'] ? 0 : 1 ?>">
                                                <button type="submit" class="p-2 hover:bg-white/5 rounded-lg transition-colors border border-transparent hover:border-white/5" title="<?= $entry['is_visible'] ? 'Visible públicamente' : 'Privado' ?>">
                                                    <?php if ($entry['is_visible']): ?>
                                                        <svg class="w-4 h-4 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                                                    <?php else: ?>
                                                        <svg class="w-4 h-4 text-zinc-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.542-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l18 18"></path></svg>
                                                    <?php endif; ?>
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                    <p class="text-zinc-300 leading-relaxed mb-6 italic"><?= nl2br(htmlspecialchars($entry['entrada'])) ?></p>
                                    <?php if ($entry['imagen_url']): ?>
                                        <div class="rounded-3xl overflow-hidden border border-white/5 bg-zinc-900/50">
                                            <img src="<?= BASE_URL ?>/uploads/diary/<?= $entry['imagen_url'] ?>" class="w-full h-auto object-cover max-h-[500px] hover:scale-[1.02] transition-transform duration-700 cursor-zoom-in" onclick="openLightbox(this.src)">
                                        </div>
                                    <?php endif; ?>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    <?php endif; ?>
                </div>

                <!-- Galeria Tab -->
                <div id="section-galeria" class="tab-section hidden">
                    <div class="flex items-center justify-between mb-8">
                        <h2 class="text-2xl font-black text-white">Álbum de Recuerdos</h2>
                    </div>
                    <?php if (empty($media)): ?>
                        <div class="glass-card p-12 text-center">
                            <p class="text-zinc-500">Aún no hay fotos en esta colonia.</p>
                        </div>
                    <?php else: ?>
                        <div class="grid grid-cols-2 md:grid-cols-3 gap-4">
                            <?php foreach ($media as $item): ?>
                                <div class="relative aspect-square rounded-2xl overflow-hidden border border-white/5 group bg-zinc-900 cursor-zoom-in" onclick="openLightbox('<?= BASE_URL ?>/<?= $item['url'] ?>')">
                                    <img src="<?= BASE_URL ?>/<?= $item['url'] ?>" class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-110">
                                    <div class="absolute inset-0 bg-black/40 opacity-0 group-hover:opacity-100 transition-opacity flex flex-col justify-end p-4">
                                        <span class="text-[8px] font-black uppercase text-white tracking-widest"><?= date('d/m/Y', strtotime($item['fecha'])) ?></span>
                                        <span class="text-[10px] text-blue-300 font-bold truncate"><?= htmlspecialchars($item['tipo']) ?></span>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    <?php endif; ?>
                </div>

                <!-- Extras Tab -->
                <div id="section-extras" class="tab-section hidden space-y-8">
                    <!-- Configuración Pública -->
                    <div class="glass-card p-8 border-blue-500/20">
                        <h3 class="text-lg font-black text-white mb-6 flex items-center gap-3">
                            <svg class="w-6 h-6 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.684 13.342C8.886 12.938 9 12.482 9 12c0-.482-.114-.938-.316-1.342m0 2.684a3 3 0 110-2.684m0 2.684l6.632 3.316m-6.632-6l6.632-3.316m0 0a3 3 0 105.367-2.684 3 3 0 00-5.367 2.684zm0 9.316a3 3 0 105.368 2.684 3 3 0 00-5.368-2.684z"></path></svg>
                            Log de Cría Público
                        </h3>
                        
                        <div class="flex flex-col md:flex-row items-center gap-8">
                            <div class="flex-1 space-y-4">
                                <p class="text-zinc-400 text-sm">Al activar esta opción, cualquier persona con el enlace podrá ver tu diario de cría (solo las fotos y textos marcados como visibles).</p>
                                <?php if ($colony['is_public']): ?>
                                    <div class="relative group">
                                        <input type="text" readonly value="<?= BASE_URL ?>/log/<?= $userSlug ?>/<?= $colony['public_slug'] ?>" 
                                            class="w-full bg-black/40 border border-white/10 rounded-xl px-4 py-3 text-xs font-mono text-blue-300 focus:ring-0 pr-12">
                                        <button onclick="copyToClipboard('<?= BASE_URL ?>/log/<?= $userSlug ?>/<?= $colony['public_slug'] ?>')" class="absolute right-2 top-1/2 -translate-y-1/2 p-2 bg-blue-500 rounded-lg text-white">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 5H6a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2v-1M8 5a2 2 0 002 2h2a2 2 0 002-2M8 5a2 2 0 012-2h2a2 2 0 012 2m-3 8v3m-3-3h6"></path></svg>
                                        </button>
                                    </div>
                                <?php endif; ?>
                            </div>
                            <form action="<?= BASE_URL ?>/colonias/publico/<?= $colony['id'] ?>" method="POST" class="shrink-0">
                                <input type="hidden" name="is_public" value="<?= $colony['is_public'] ? 0 : 1 ?>">
                                <button type="submit" class="px-8 py-4 rounded-2xl text-[10px] font-black uppercase tracking-[0.2em] transition-all <?= $colony['is_public'] ? 'bg-red-500/10 text-red-500 border border-red-500/10 hover:bg-red-500/20' : 'bg-emerald-500 text-emerald-950 hover:bg-emerald-400' ?>">
                                    <?= $colony['is_public'] ? 'Desactivar Enlace' : 'Activar Enlace Público' ?>
                                </button>
                            </form>
                        </div>
                    </div>

                    <!-- Identificación QR -->
                    <div class="glass-card p-8 border-purple-500/20">
                        <h3 class="text-lg font-black text-white mb-6 flex items-center gap-3">
                            <svg class="w-6 h-6 text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v1l-3 3h-6v-6h6l3 3v1m0 0l3-3h6v6h-6l-3-3m0 0v6M5 8h2m-2 2h2m2-2h2m-2 2h2m7-2h2m-2 2h2m2-2h2m-2 2h2"></path></svg>
                            ID Digital QR
                        </h3>
                        <div class="flex flex-col md:flex-row items-center gap-8">
                            <div class="p-4 bg-white rounded-3xl shadow-2xl">
                                <?php 
                                $quickUrl = (isset($_SERVER['HTTPS']) ? "https" : "http") . "://$_SERVER[HTTP_HOST]" . BASE_URL . "/colonias/ver/" . $colony['id'] . "?quick_entry=1";
                                $qrApi = "https://api.qrserver.com/v1/create-qr-code/?size=150x150&data=" . urlencode($quickUrl);
                                ?>
                                <img src="<?= $qrApi ?>" class="w-32 h-32">
                            </div>
                            <div class="flex-1 space-y-4 text-center md:text-left">
                                <p class="text-zinc-400 text-sm">Imprime esta etiqueta y colócala en tu hormiguero. Al escanearla, entrarás directamente a añadir una entrada en el diario.</p>
                                <button onclick="printLabel()" class="bg-purple-500 hover:bg-purple-400 text-white px-8 py-4 rounded-2xl text-[10px] font-black uppercase tracking-widest transition-all">Imprimir Etiqueta</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Right Sidebar (Stats & Info) -->
        <div class="lg:col-span-4 space-y-8">
            
            <!-- Descripcion -->
            <div class="glass-card p-8">
                <h3 class="text-xs uppercase font-black text-zinc-500 tracking-[0.3em] mb-6 border-b border-white/5 pb-2">Sobre la colonia</h3>
                <p class="text-zinc-400 text-sm leading-relaxed italic">
                    <?= nl2br(htmlspecialchars($colony['descripcion'] ?: 'Sin descripción personalizada.')) ?>
                </p>
            </div>

            <!-- Castas -->
            <div class="glass-card p-8 border-blue-500/10">
                <h3 class="text-xs uppercase font-black text-blue-400 tracking-[0.3em] mb-8 flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                    Distribución Detallada
                </h3>
                <div class="grid grid-cols-1 gap-3">
                    <?php if (empty($castas)): ?>
                        <p class="text-zinc-600 text-[10px] text-center italic uppercase font-bold tracking-widest">Sin detalle de castas</p>
                    <?php else: ?>
                        <?php foreach ($castas as $casta => $cantidad): ?>
                            <div class="flex items-center justify-between p-4 bg-white/[0.02] border border-white/5 rounded-2xl">
                                <div class="flex items-center gap-3">
                                    <span class="text-xl"><?= $icons[strtolower($casta)] ?? '🐜' ?></span>
                                    <span class="text-[10px] uppercase font-black text-zinc-500 tracking-widest"><?= htmlspecialchars($casta) ?></span>
                                </div>
                                <span class="text-xl font-black text-white"><?= number_format($cantidad) ?></span>
                            </div>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </div>
            </div>

            <!-- Evolution Chart -->
            <div class="glass-card p-8 border-emerald-500/10">
                <h3 class="text-xs uppercase font-black text-emerald-400 tracking-[0.3em] mb-8 flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 12l3-3 3 3 4-4M8 21l4-4 4 4M3 4h18M4 4h16v12a1 1 0 01-1 1H5a1 1 0 01-1-1V4z"></path></svg>
                    Crecimiento
                </h3>
                <div class="h-[250px] relative">
                    <canvas id="evolutionChart"></canvas>
                    <?php if (count($history) <= 1): ?>
                        <div class="absolute inset-0 flex items-center justify-center text-center">
                            <span class="text-[8px] uppercase font-bold text-zinc-600 tracking-tighter">Esperando más datos<br>para trazar línea</span>
                        </div>
                    <?php endif; ?>
                </div>
            </div>

        </div>
    </div>
</div>

<!-- Modal Diary Form (Refined) -->
<div id="diary-form" class="hidden fixed inset-0 z-[100] flex items-center justify-center p-4">
    <div class="absolute inset-0 bg-black/80 backdrop-blur-xl" onclick="toggleDiaryForm()"></div>
    <div class="relative w-full max-w-2xl bg-zinc-900 border border-white/10 rounded-[2.5rem] shadow-2xl p-8 overflow-y-auto max-h-[90vh]">
        <h3 class="text-2xl font-black text-white mb-8">Añadir a la historia</h3>
        <form action="<?= BASE_URL ?>/colonias/diario/<?= $colony['id'] ?>" method="POST" enctype="multipart/form-data" class="space-y-6">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="text-[10px] uppercase font-black text-zinc-500 mb-2 block tracking-widest pl-1">Tipo de Evento</label>
                    <select name="tipo_evento" id="tipo_evento_select" onchange="toggleStockFields()" class="magic-input">
                        <option value="Observación">🔍 Observación</option>
                        <option value="Alimentación">🍖 Alimentación</option>
                        <option value="Mantenimiento">🛠️ Mantenimiento</option>
                        <option value="Limpieza">✨ Limpieza</option>
                        <option value="Mudanza">🏠 Mudanza</option>
                        <option value="Nacimientos">🥚 Nacimientos</option>
                    </select>
                </div>
                <div>
                    <label class="text-[10px] uppercase font-black text-zinc-500 mb-2 block tracking-widest pl-1">Fecha</label>
                    <input type="date" name="fecha_entrada" value="<?= date('Y-m-d') ?>" class="magic-input [color-scheme:dark]">
                </div>
            </div>

            <!-- Stock Fields -->
            <div id="stock-fields" class="hidden p-6 bg-blue-500/5 border border-blue-500/20 rounded-3xl space-y-4">
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="text-[10px] font-black uppercase text-blue-400 mb-2 block">Alimento</label>
                        <select name="stock_id" id="stock_id_select" class="magic-input">
                            <option value="">-- Seleccionar --</option>
                            <?php foreach ($stocks as $s): ?>
                                <option value="<?= $s['id'] ?>" data-unidad="<?= htmlspecialchars($s['unidad']) ?>" data-cantidad="<?= $s['cantidad'] ?>">
                                    <?= htmlspecialchars($s['nombre']) ?> (<?= $s['cantidad'] ?><?= htmlspecialchars($s['unidad']) ?>)
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div>
                        <label class="text-[10px] font-black uppercase text-blue-400 mb-2 block">Cantidad</label>
                        <div class="relative">
                            <input type="number" step="0.01" name="cantidad_usada" id="cantidad_usada_input" class="magic-input pr-12">
                            <span id="unidad-badge" class="absolute right-4 top-1/2 -translate-y-1/2 text-[10px] font-black text-zinc-500">--</span>
                        </div>
                    </div>
                </div>
                <p id="stock-warning" class="hidden text-red-400 text-[10px] font-black uppercase">⚠️ Stock insuficiente</p>
            </div>

            <div>
                <label class="text-[10px] uppercase font-black text-zinc-500 mb-2 block tracking-widest pl-1">Relato</label>
                <textarea name="entrada" rows="4" required class="magic-input leading-relaxed" placeholder="Hoy he notado que..."></textarea>
            </div>

            <div>
                <label class="text-[10px] uppercase font-black text-zinc-500 mb-2 block tracking-widest pl-1">Evidencia Visual</label>
                <input type="file" name="imagen" class="hidden" id="diary-img" onchange="previewDiaryImage(this)">
                <label for="diary-img" class="flex flex-col items-center justify-center h-48 border-2 border-dashed border-white/5 rounded-3xl cursor-pointer hover:border-blue-500/40 hover:bg-white/5 transition-all overflow-hidden relative">
                    <div id="diary-label-content">
                        <svg class="w-8 h-8 text-zinc-500 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                        <span class="text-xs font-bold text-zinc-500">Cargar Imagen</span>
                    </div>
                    <img id="diary-preview" src="" class="hidden absolute inset-0 w-full h-full object-cover">
                </label>
            </div>

            <div class="flex gap-4 pt-4">
                <button type="button" onclick="toggleDiaryForm()" class="flex-1 py-4 bg-white/5 rounded-2xl text-white font-bold">Cancelar</button>
                <button type="submit" class="flex-1 py-4 bg-blue-500 rounded-2xl text-white font-black uppercase tracking-widest shadow-xl shadow-blue-500/20">Registrar en Historia</button>
            </div>
        </form>
    </div>
</div>

<!-- Modal Pop Form (Población) -->
<div id="pop-form-modal" class="hidden fixed inset-0 z-[100] flex items-center justify-center p-4">
    <div class="absolute inset-0 bg-black/80 backdrop-blur-xl" onclick="togglePopForm()"></div>
    <div class="relative w-full max-w-lg bg-zinc-900 border border-white/10 rounded-[2.5rem] shadow-2xl p-10">
        <h3 class="text-3xl font-black text-white mb-2 text-center">Nuevo Recuento</h3>
        <p class="text-zinc-500 text-sm text-center mb-10">Censo detallado de la colonia</p>
        
        <form action="<?= BASE_URL ?>/colonias/poblacion/<?= $colony['id'] ?>" method="POST" class="space-y-8">
            <div class="grid grid-cols-2 gap-4">
                <?php if ($colony['poblacion_detallada']): ?>
                    <?php 
                    $currentDetails = json_decode($colony['poblacion_detallada'], true);
                    foreach ($icons as $label => $icon): ?>
                        <div class="p-5 bg-white/5 rounded-3xl border border-white/5 focus-within:border-emerald-500/50 transition-all">
                            <label class="flex items-center gap-2 text-[10px] uppercase font-black text-zinc-500 mb-2">
                                <span><?= $icon ?></span>
                                <span><?= $label ?></span>
                            </label>
                            <input type="number" name="casta[<?= $label ?>]" value="<?= $currentDetails[$label] ?? 0 ?>" min="0" required 
                                class="w-full bg-transparent border-none p-0 text-3xl font-black text-white focus:ring-0">
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <div class="col-span-full p-10 bg-white/5 rounded-3xl border border-white/5 text-center">
                        <label class="text-xs font-black uppercase text-zinc-500 block mb-4">Total Obreras</label>
                        <input type="number" name="poblacion" value="<?= $colony['poblacion_actual'] ?>" min="0" required 
                            class="w-full bg-transparent border-none p-0 text-7xl font-black text-white text-center focus:ring-0">
                    </div>
                <?php endif; ?>
            </div>

            <div class="flex gap-4">
                <button type="button" onclick="togglePopForm()" class="flex-1 py-4 text-zinc-500 font-bold">Cancelar</button>
                <button type="submit" class="flex-1 py-5 bg-emerald-500 rounded-3xl text-emerald-950 font-black uppercase tracking-widest shadow-2xl shadow-emerald-500/20">Guardar Censo</button>
            </div>
        </form>
    </div>
</div>

<!-- Scripts -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
function showTab(tabName) {
    // Buttons
    document.querySelectorAll('.tab-btn').forEach(btn => {
        btn.classList.remove('bg-blue-500', 'text-white', 'shadow-xl', 'shadow-blue-500/20', 'active');
        btn.classList.add('text-zinc-500', 'hover:text-white', 'hover:bg-white/5');
    });
    const activeBtn = document.getElementById('btn-tab-' + tabName);
    activeBtn.classList.remove('text-zinc-500', 'hover:text-white', 'hover:bg-white/5');
    activeBtn.classList.add('bg-blue-500', 'text-white', 'shadow-xl', 'shadow-blue-500/20', 'active');

    // Sections
    document.querySelectorAll('.tab-section').forEach(sec => sec.classList.add('hidden'));
    document.getElementById('section-' + tabName).classList.remove('hidden');
}

function toggleDiaryForm() {
    document.getElementById('diary-form').classList.toggle('hidden');
}

function togglePopForm() {
    document.getElementById('pop-form-modal').classList.toggle('hidden');
}

function previewDiaryImage(input) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();
        reader.onload = function(e) {
            document.getElementById('diary-preview').src = e.target.result;
            document.getElementById('diary-preview').classList.remove('hidden');
            document.getElementById('diary-label-content').classList.add('hidden');
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
    const s = document.getElementById('tipo_evento_select').value;
    document.getElementById('stock-fields').classList.toggle('hidden', s !== 'Alimentación');
}

document.getElementById('stock_id_select')?.addEventListener('change', function() {
    const opt = this.options[this.selectedIndex];
    document.getElementById('unidad-badge').innerText = opt.getAttribute('data-unidad') || '--';
});

// Chart.js implementation
document.addEventListener('DOMContentLoaded', () => {
    const ctx = document.getElementById('evolutionChart').getContext('2d');
    const historyData = <?= json_encode($history) ?>;
    const labels = historyData.map(h => {
        const d = new Date(h.fecha_registro);
        return d.toLocaleDateString('es-ES', { day: '2-digit', month: 'short' });
    });

    const datasets = [{
        label: 'Población',
        data: historyData.map(h => h.poblacion),
        borderColor: '#10b981',
        backgroundColor: 'rgba(16, 185, 129, 0.1)',
        fill: true,
        tension: 0.4,
        borderWidth: 3,
        pointRadius: historyData.length === 1 ? 8 : 4,
        pointBackgroundColor: '#fff'
    }];

    new Chart(ctx, {
        type: 'line',
        data: { labels, datasets },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: { legend: { display: false } },
            scales: {
                y: { beginAtZero: true, grid: { color: 'rgba(255,255,255,0.05)' }, ticks: { color: '#71717a' } },
                x: { grid: { display: false }, ticks: { color: '#71717a' } }
            }
        }
    });

    // Lightbox minimal
    window.openLightbox = (src) => {
        const div = document.createElement('div');
        div.className = 'fixed inset-0 z-[200] bg-black/95 flex items-center justify-center p-8 cursor-zoom-out';
        div.innerHTML = `<img src="${src}" class="max-w-full max-h-full rounded-2xl shadow-2xl">`;
        div.onclick = () => div.remove();
        document.body.appendChild(div);
    };
});

function printLabel() {
    // Implementación similar a la anterior pero adaptada
    const qrUrl = "<?= (isset($_SERVER['HTTPS']) ? "https" : "http") . "://$_SERVER[HTTP_HOST]" . BASE_URL . "/colonias/ver/" . $colony['id'] . "?quick_entry=1" ?>";
    window.open("https://api.qrserver.com/v1/create-qr-code/?size=300x300&data=" + encodeURIComponent(qrUrl), "_blank");
}
</script>

<style>
.glass-card {
    background: rgba(24, 24, 27, 0.4);
    backdrop-filter: blur(20px);
    -webkit-backdrop-filter: blur(20px);
    border: 1px solid rgba(255, 255, 255, 0.05);
    border-radius: 2rem;
    box-shadow: 0 10px 40px rgba(0, 0, 0, 0.3);
}
.tab-btn.active {
    box-shadow: 0 10px 40px rgba(59, 130, 246, 0.2);
}
.tab-section {
    animation: fadeIn 0.4s ease-out;
}
@keyframes fadeIn {
    from { opacity: 0; transform: translateY(10px); }
    to { opacity: 1; transform: translateY(0); }
}
</style>
