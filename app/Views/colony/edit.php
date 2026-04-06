<div class="max-w-3xl mx-auto">
    <div class="flex items-center gap-4 mb-8">
        <a href="<?= BASE_URL ?>/colonias/ver/<?= $colony['id'] ?>" class="p-2 rounded-full bg-white/5 hover:bg-white/10 border border-white/10 transition-colors text-zinc-400 hover:text-white">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
        </a>
        <h1 class="text-3xl font-bold bg-clip-text text-transparent bg-gradient-to-r from-blue-400 to-emerald-400">Editar Colonia</h1>
    </div>

    <div class="glass-card p-6 md:p-8 relative overflow-hidden">
        <div class="absolute -inset-20 bg-gradient-to-r from-blue-500/10 to-emerald-500/10 rounded-full blur-3xl z-0 pointer-events-none"></div>
        
        <form method="POST" action="<?= BASE_URL ?>/colonias/editar/<?= $colony['id'] ?>" enctype="multipart/form-data" class="space-y-6 relative z-10">
            <!-- Foto de Portada -->
            <div class="mb-8">
                <label class="block text-sm font-medium text-muted mb-3">Foto de Portada</label>
                <div class="relative group">
                    <input type="file" name="imagen" id="imagen-input" class="hidden" accept="image/*" onchange="previewImage(this)">
                    <label for="imagen-input" id="image-preview" class="flex flex-col items-center justify-center w-full h-48 border-2 border-dashed border-white/10 rounded-2xl cursor-pointer hover:bg-white/5 hover:border-blue-500/50 transition-all overflow-hidden relative">
                        <div id="preview-placeholder" class="flex flex-col items-center <?= $colony['imagen'] ? 'hidden' : '' ?>">
                            <div class="p-4 bg-blue-500/10 rounded-full text-blue-400 mb-2 group-hover:scale-110 transition-transform">
                                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                            </div>
                            <span class="text-xs text-muted">Clic para cambiar la foto</span>
                        </div>
                        <img id="image-render" src="<?= $colony['imagen'] ? asset('uploads/colonies/' . $colony['imagen']) : '' ?>" class="<?= $colony['imagen'] ? '' : 'hidden' ?> absolute inset-0 w-full h-full object-cover">
                    </label>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Nombre -->
                <div class="space-y-1.5">
                    <label class="block text-sm font-medium text-main">Nombre de la Colonia</label>
                    <input type="text" name="nombre" required value="<?= htmlspecialchars($colony['nombre']) ?>" class="magic-input text-main">
                </div>
                
                <!-- Especie con Buscador en Vivo -->
                <div class="space-y-1.5 relative" id="species-search-container">
                    <label class="block text-sm font-medium text-muted">Especie</label>
                    <div class="relative group">
                        <div class="absolute left-4 top-1/2 -translate-y-1/2 text-zinc-500 group-focus-within:text-blue-400 transition-colors">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                        </div>
                        <input type="text" id="species-search-input" 
                               value="<?= htmlspecialchars(($colony['especie_nombre_cientifico'] ?? ($colony['nombre_cientifico'] ?? ''))) ?> (<?= htmlspecialchars(($colony['especie_nombre'] ?? ($colony['nombre'] ?? ''))) ?>)"
                               placeholder="Buscar especie..." class="magic-input !pl-11 w-full text-main" autocomplete="off">
                        <input type="hidden" name="especie_id" id="especie_id_hidden" value="<?= $colony['especie_id'] ?>" required>
                    </div>
                    
                    <!-- Dropdown de Resultados -->
                    <div id="species-results" class="hidden absolute left-0 right-0 top-full mt-2 bg-zinc-900/95 backdrop-blur-xl border border-white/10 rounded-2xl shadow-2xl z-50 max-h-60 overflow-y-auto custom-scrollbar">
                        <?php foreach ($species as $s): ?>
                            <div class="species-option px-4 py-3 hover:bg-blue-500/10 cursor-pointer border-b border-white/5 last:border-none transition-colors" 
                                 data-id="<?= $s['id'] ?>" 
                                 data-name="<?= htmlspecialchars($s['nombre']) ?>" 
                                 data-scientific="<?= htmlspecialchars($s['nombre_cientifico']) ?>">
                                <p class="text-sm font-bold text-white"><?= htmlspecialchars($s['nombre_cientifico']) ?></p>
                                <p class="text-[10px] text-zinc-500 uppercase font-black tracking-widest"><?= htmlspecialchars($s['nombre']) ?></p>
                            </div>
                        <?php endforeach; ?>
                        <div id="no-results" class="hidden px-4 py-8 text-center text-zinc-500 text-xs italic">No se encontraron especies</div>
                    </div>
                </div>
                
                <!-- Fecha Adquisición -->
                <div class="space-y-1.5">
                    <label class="block text-sm font-medium text-main">Fecha de Adquisición</label>
                    <input type="date" name="fecha_adquisicion" value="<?= $colony['fecha_adquisicion'] ?>" required class="magic-input w-full [color-scheme:dark] text-main">
                </div>
                
                <!-- Tipo Hormiguero -->
                <div class="space-y-1.5">
                    <label class="block text-sm font-medium text-main">Tipo de Hormiguero</label>
                    <input type="text" name="tipo_hormiguero" value="<?= htmlspecialchars($colony['tipo_hormiguero']) ?>" class="magic-input text-main">
                </div>
            </div>

            <!-- Población -->
            <?php 
            $poblacionDetallada = json_decode($colony['poblacion_detallada'] ?? '{}', true);
            $usaCastas = !empty($poblacionDetallada);
            ?>
            <div class="bg-black/20 p-5 rounded-2xl border border-white/5">
                <div class="flex items-center justify-between mb-4">
                    <div class="flex items-center gap-2">
                        <svg class="w-5 h-5 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                        <label class="text-sm font-bold text-main">Control de Población</label>
                    </div>
                    <label class="flex items-center gap-3 cursor-pointer group">
                        <span class="text-xs text-muted group-hover:text-main transition-colors">Desglose por castas</span>
                        <div class="relative inline-flex items-center cursor-pointer">
                            <input type="checkbox" id="toggle-castas" name="usar_castas" value="1" class="sr-only peer" onchange="toggleCastasSection(this)" <?= $usaCastas ? 'checked' : '' ?>>
                            <div class="w-9 h-5 bg-zinc-800 rounded-full peer peer-checked:bg-[var(--theme-primary)] after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:rounded-full after:h-4 after:w-4 after:transition-all peer-checked:after:translate-x-full border border-white/10"></div>
                        </div>
                    </label>
                </div>

                <!-- Población Simple -->
                <div id="poblacion-simple" class="space-y-1.5 transition-all <?= $usaCastas ? 'hidden' : '' ?>">
                    <input type="number" name="poblacion_actual" min="0" value="<?= $colony['poblacion_actual'] ?>" class="magic-input text-main" placeholder="Total obreras">
                </div>

                <!-- Población Detallada -->
                <div id="poblacion-detallada" class="transition-all <?= $usaCastas ? '' : 'hidden' ?>">
                    <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-5 gap-4 mt-2">
                        <?php 
                        $castas_label = ['reina' => 'Reinas', 'minor' => 'Minors', 'media' => 'Medias', 'major' => 'Majors', 'soldado' => 'Soldados'];
                        foreach($castas_label as $key => $label): ?>
                        <div class="space-y-1">
                            <label class="text-[10px] uppercase font-bold text-muted ml-1"><?= $label ?></label>
                            <input type="number" name="casta[<?= $key ?>]" value="<?= $poblacionDetallada[$key] ?? 0 ?>" min="0" class="magic-input !p-2 text-center text-main">
                        </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>

            <div class="space-y-1.5">
                <label class="block text-sm font-medium text-main">Descripción / Notas</label>
                <textarea name="descripcion" rows="3" class="magic-input resize-none text-main" placeholder="Estado de la reina..."><?= htmlspecialchars($colony['descripcion']) ?></textarea>
            </div>

            <div class="pt-6 border-t border-white/10 flex justify-end">
                <button type="submit" class="magic-btn w-full md:w-auto px-8 py-3 shadow-xl shadow-blue-500/20">Guardar Cambios</button>
            </div>
        </form>
    </div>
</div>

<style>
.custom-scrollbar::-webkit-scrollbar { width: 6px; }
.custom-scrollbar::-webkit-scrollbar-track { background: transparent; }
.custom-scrollbar::-webkit-scrollbar-thumb { background: rgba(59, 130, 246, 0.2); border-radius: 10px; }
.custom-scrollbar::-webkit-scrollbar-thumb:hover { background: rgba(59, 130, 246, 0.4); }
</style>

<script>
// Lógica del Buscador de Especies (Igual que en Create)
const searchInput = document.getElementById('species-search-input');
const resultsDiv = document.getElementById('species-results');
const hiddenInput = document.getElementById('especie_id_hidden');
const options = document.querySelectorAll('.species-option');
const noResults = document.getElementById('no-results');

searchInput.addEventListener('focus', () => {
    resultsDiv.classList.remove('hidden');
});

document.addEventListener('click', (e) => {
    if (!document.getElementById('species-search-container').contains(e.target)) {
        resultsDiv.classList.add('hidden');
    }
});

searchInput.addEventListener('input', (e) => {
    const term = e.target.value.toLowerCase().normalize("NFD").replace(/[\u0300-\u036f]/g, "");
    let count = 0;
    
    options.forEach(opt => {
        const name = opt.getAttribute('data-name').toLowerCase().normalize("NFD").replace(/[\u0300-\u036f]/g, "");
        const scientific = opt.getAttribute('data-scientific').toLowerCase().normalize("NFD").replace(/[\u0300-\u036f]/g, "");
        
        if (name.includes(term) || scientific.includes(term)) {
            opt.classList.remove('hidden');
            count++;
        } else {
            opt.classList.add('hidden');
        }
    });

    noResults.classList.toggle('hidden', count > 0);
    resultsDiv.classList.remove('hidden');
});

options.forEach(opt => {
    opt.addEventListener('click', () => {
        const id = opt.getAttribute('data-id');
        const scientific = opt.getAttribute('data-scientific');
        const name = opt.getAttribute('data-name');
        
        searchInput.value = `${scientific} (${name})`;
        hiddenInput.value = id;
        resultsDiv.classList.add('hidden');
        
        // Efecto visual de seleccionado
        searchInput.classList.add('border-blue-500/50', 'bg-blue-500/5');
    });
});

function previewImage(input) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();
        reader.onload = function(e) {
            document.getElementById('image-render').src = e.target.result;
            document.getElementById('image-render').classList.remove('hidden');
            document.getElementById('preview-placeholder').classList.add('hidden');
        }
        reader.readAsDataURL(input.files[0]);
    }
}

function toggleCastasSection(checkbox) {
    const simple = document.getElementById('poblacion-simple');
    const detallada = document.getElementById('poblacion-detallada');
    if (checkbox.checked) {
        simple.classList.add('hidden');
        detallada.classList.remove('hidden');
    } else {
        simple.classList.remove('hidden');
        detallada.classList.add('hidden');
    }
}
</script>
