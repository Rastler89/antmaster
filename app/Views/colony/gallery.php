<div class="mb-8">
    <nav class="flex items-center gap-2 text-[10px] md:text-xs font-bold uppercase tracking-widest text-zinc-500 mb-6 overflow-x-auto no-scrollbar whitespace-nowrap">
        <a href="<?= BASE_URL ?>/colonias" class="hover:text-blue-400 transition-colors">Colonias</a>
        <svg class="w-3 h-3 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
        <a href="<?= BASE_URL ?>/colonias/ver/<?= $colony['id'] ?>" class="hover:text-blue-400 transition-colors"><?= htmlspecialchars($colony['nombre']) ?></a>
        <svg class="w-3 h-3 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
        <span class="text-blue-400">Galería</span>
    </nav>
    
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-6">
        <div class="w-full">
            <h1 class="text-3xl md:text-4xl font-black text-white leading-tight">Galería de <span class="bg-clip-text text-transparent bg-gradient-to-r from-blue-400 to-purple-500"><?= htmlspecialchars($colony['nombre']) ?></span></h1>
            <p class="text-zinc-500 text-sm mt-2 font-medium italic opacity-80">Explora la historia visual de tu imperio.</p>
        </div>
        <a href="<?= BASE_URL ?>/colonias/ver/<?= $colony['id'] ?>" class="w-full md:w-auto p-4 bg-white/5 border border-white/10 hover:bg-white/10 text-white rounded-2xl flex items-center justify-center gap-2 text-xs font-black uppercase tracking-widest transition-all active:scale-95">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
            Volver
        </a>
    </div>
</div>

<?php if (empty($media)): ?>
    <div class="glass-card p-12 text-center border-dashed border-white/10">
        <div class="w-20 h-20 bg-white/5 rounded-full flex items-center justify-center mx-auto mb-6">
            <svg class="w-10 h-10 text-zinc-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
        </div>
        <h3 class="text-xl font-bold text-white mb-2">No hay imágenes todavía</h3>
        <p class="text-zinc-500 max-w-sm mx-auto">Sube una foto de perfil o añade imágenes a tus entradas del diario para verlas aquí.</p>
    </div>
<?php else: ?>
    <!-- Grid de Galería -->
    <div class="grid grid-cols-2 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-4 md:gap-6">
        <?php foreach ($media as $index => $item): ?>
            <div class="group relative aspect-square glass-card !p-0 overflow-hidden cursor-pointer active:scale-95 transition-all rounded-2xl" 
                 onclick="openLightbox(<?= $index ?>)">
                <!-- Imagen -->
                <img src="<?= $item['url'] ?>" 
                     alt="Foto de la colonia" 
                     class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-110">
                
                <!-- Overlay de Info (Solo desktop para no estorbar en móvil) -->
                <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-transparent to-transparent opacity-0 md:group-hover:opacity-100 transition-opacity duration-300 flex flex-col justify-end p-4">
                    <p class="text-[10px] font-bold text-zinc-300 uppercase tracking-tighter"><?= date('d M, Y', strtotime($item['fecha'])) ?></p>
                    <p class="text-xs text-white font-medium line-clamp-1 mt-1"><?= htmlspecialchars($item['descripcion']) ?></p>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
<?php endif; ?>

<!-- Lightbox Modal -->
<div id="lightbox" class="fixed inset-0 z-[100] bg-black/95 flex items-center justify-center p-4 md:p-10 hidden backdrop-blur-xl">
    <button onclick="closeLightbox()" class="absolute top-8 right-8 md:top-10 md:right-10 p-4 bg-white/10 hover:bg-white/20 rounded-full text-white transition-all border border-white/20 z-[110] shadow-2xl active:scale-90">
        <svg class="w-8 h-8 md:w-6 md:h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
    </button>
    
    <div class="relative max-w-5xl w-full h-full flex flex-col items-center justify-center pointer-events-none">
        <img id="lightbox-img" src="" class="max-w-full max-h-[80vh] object-contain rounded-2xl shadow-2xl shadow-blue-500/10 pointer-events-auto">
        <div class="mt-8 text-center pointer-events-auto">
            <span id="lightbox-tag" class="inline-block text-[10px] font-black uppercase tracking-widest bg-blue-500 px-3 py-1 rounded-full text-white mb-3"></span>
            <p id="lightbox-date" class="text-xs font-bold text-zinc-500 uppercase tracking-widest mb-2"></p>
            <h4 id="lightbox-desc" class="text-lg text-white font-medium max-w-2xl mx-auto"></h4>
        </div>
    </div>
</div>

<script>
const media = <?= json_encode($media) ?>;

function openLightbox(index) {
    const item = media[index];
    const lightbox = document.getElementById('lightbox');
    const img = document.getElementById('lightbox-img');
    const tag = document.getElementById('lightbox-tag');
    const date = document.getElementById('lightbox-date');
    const desc = document.getElementById('lightbox-desc');

    img.src = item.url;
    tag.innerText = item.tipo;
    date.innerText = new Date(item.fecha).toLocaleDateString('es-ES', { day: '2-digit', month: 'long', year: 'numeric' });
    desc.innerText = item.descripcion;

    lightbox.classList.remove('hidden');
    document.body.style.overflow = 'hidden';
}

function closeLightbox() {
    const lightbox = document.getElementById('lightbox');
    lightbox.classList.add('hidden');
    document.body.style.overflow = 'auto';
}

// Cerrar con Escape
document.addEventListener('keydown', (e) => {
    if (e.key === 'Escape') closeLightbox();
});
</script>
