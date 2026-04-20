<div class="max-w-3xl mx-auto">
    <div class="pb-6">
        <a href="<?= BASE_URL ?>/especies" class="text-sm text-zinc-400 hover:text-white flex items-center gap-1 w-fit mb-4">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
            <?= __('species_back_to_list') ?>
        </a>
    </div>

    <div class="glass-card p-8 border-emerald-500/20">
        <h2 class="text-2xl font-bold text-white mb-2 flex items-center gap-2">
            <span class="text-emerald-400">🌱</span> <?= __('species_form_title_new') ?>
        </h2>
        <p class="text-zinc-400 text-sm mb-6"><?= __('species_form_desc_new') ?></p>

        <?php if (isset($_SESSION['error'])): ?>
            <div class="bg-red-500/10 border border-red-500/20 text-red-400 p-4 rounded-xl mb-6 text-sm">
                <?= htmlspecialchars($_SESSION['error']) ?>
                <?php unset($_SESSION['error']); ?>
            </div>
        <?php endif; ?>

        <form action="<?= BASE_URL ?>/especies/proponer" method="POST" class="space-y-5">
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-bold text-white mb-1"><?= __('species_label_common_name') ?> <span class="text-red-500">*</span></label>
                    <input type="text" name="nombre" class="magic-input w-full" placeholder="<?= __('species_placeholder_common') ?>" required>
                </div>
                <div>
                    <label class="block text-sm font-bold text-white mb-1"><?= __('species_label_scientific_name') ?> <span class="text-red-500">*</span></label>
                    <input type="text" name="nombre_cientifico" class="magic-input w-full italic" placeholder="<?= __('species_placeholder_scientific') ?>" required>
                </div>
            </div>

            <hr class="border-white/5 my-4">

            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <div>
                    <label class="block text-sm font-medium text-zinc-300 mb-1"><?= __('species_label_difficulty') ?></label>
                    <select name="dificultad" class="magic-input w-full focus:ring-1 focus:ring-emerald-500 bg-zinc-900/50">
                        <option value="Principiante"><?= __('diff_beginner') ?></option>
                        <option value="Intermedio"><?= __('diff_intermediate') ?></option>
                        <option value="Avanzado"><?= __('diff_advanced') ?></option>
                        <option value="Experto"><?= __('diff_expert') ?></option>
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-zinc-300 mb-1"><?= __('species_label_temp') ?></label>
                    <input type="text" name="temperatura" class="magic-input w-full" placeholder="<?= __('species_placeholder_temp') ?>">
                </div>
                <div>
                    <label class="block text-sm font-medium text-zinc-300 mb-1"><?= __('species_label_hum') ?></label>
                    <input type="text" name="humedad" class="magic-input w-full" placeholder="<?= __('species_placeholder_hum') ?>">
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-zinc-300 mb-1"><?= __('species_label_growth') ?></label>
                    <input type="text" name="velocidad_crecimiento" class="magic-input w-full" placeholder="<?= __('species_placeholder_growth') ?>">
                </div>
                <div>
                    <label class="block text-sm font-medium text-zinc-300 mb-1"><?= __('species_label_size') ?></label>
                    <input type="text" name="tamano" class="magic-input w-full" placeholder="<?= __('species_placeholder_size') ?>">
                </div>
                <div>
                    <label class="block text-sm font-medium text-zinc-300 mb-1"><?= __('species_label_castes') ?></label>
                    <input type="text" name="castas" class="magic-input w-full" placeholder="<?= __('species_placeholder_castes') ?>">
                </div>
                <div>
                    <label class="block text-sm font-medium text-zinc-300 mb-1"><?= __('species_label_reproduction') ?></label>
                    <select name="reproduccion" class="magic-input w-full bg-zinc-900/50">
                        <option value="Monoginia"><?= __('species_repro_mono_desc') ?></option>
                        <option value="Poliginia"><?= __('species_repro_poly_desc') ?></option>
                        <option value="Oligoginia"><?= __('species_repro_oligo') ?></option>
                    </select>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-zinc-300 mb-1"><?= __('species_label_flights') ?></label>
                    <input type="text" name="vuelos" class="magic-input w-full" placeholder="<?= __('species_placeholder_flights') ?>">
                </div>
                <div>
                    <label class="block text-sm font-medium text-zinc-300 mb-1"><?= __('species_label_location') ?></label>
                    <input type="text" name="localizacion" class="magic-input w-full" placeholder="<?= __('species_placeholder_location') ?>">
                </div>
            </div>

            <div>
                <label class="block text-sm font-medium text-zinc-300 mb-1"><?= __('species_label_description') ?></label>
                <textarea name="descripcion" class="magic-input w-full h-32" placeholder="<?= __('species_placeholder_desc') ?>" required></textarea>
            </div>
            
            <div>
                <label class="block text-sm font-medium text-zinc-300 mb-1 flex items-center gap-2"><span class="text-orange-400">🍽️</span> <?= __('species_label_diet') ?></label>
                <textarea name="alimentacion" class="magic-input w-full h-24" placeholder="<?= __('species_placeholder_diet') ?>" required></textarea>
            </div>

            <div>
                <label class="block text-sm font-medium text-zinc-300 mb-1 flex items-center gap-2"><span class="text-yellow-400">💡</span> <?= __('species_label_tips') ?></label>
                <textarea name="consejos_cria" class="magic-input w-full h-24" placeholder="<?= __('species_placeholder_tips') ?>" required></textarea>
            </div>

            <div class="flex gap-4 pt-4">
                <a href="<?= BASE_URL ?>/especies" class="w-full text-center px-4 py-3 bg-zinc-800/50 hover:bg-zinc-700/80 text-zinc-300 rounded-xl transition-colors font-medium border border-white/5"><?= __('btn_cancel') ?></a>
                <button type="submit" class="w-full magic-btn shadow-lg shadow-emerald-500/25 !from-emerald-500 !to-teal-500"><?= __('species_btn_send_new') ?></button>
            </div>
        </form>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const scientificNameInput = document.querySelector('input[name="nombre_cientifico"]');
    const commonNameInput = document.querySelector('input[name="nombre"]');
    const form = document.querySelector('form');
    
    let timeout = null;
    
    scientificNameInput.addEventListener('input', function() {
        clearTimeout(timeout);
        const name = this.value.trim();
        
        if (name.length < 3) return;
        
        timeout = setTimeout(() => {
            fetch(`<?= BASE_URL ?>/api/especies/get?name=${encodeURIComponent(name)}`)
                .then(response => response.json())
                .then(data => {
                    if (data) {
                        // Mostrar pequeña notificación de que se han cargado datos
                        showAutofillNotification(data.nombre_cientifico);
                        
                        // Rellenar campos si están vacíos
                        if (!commonNameInput.value) commonNameInput.value = data.nombre;
                        
                        const fields = [
                            'dificultad', 'temperatura', 'humedad', 'velocidad_crecimiento', 
                            'tamano', 'castas', 'reproduce', 'vuelos', 'localizacion', 
                            'descripcion', 'alimentacion', 'consejos_cria'
                        ];
                        
                        fields.forEach(field => {
                            const input = form.querySelector(`[name="${field}"]`);
                            if (input && (!input.value || input.value === 'Principiante')) {
                                let val = data[field];
                                if (val) input.value = val;
                            }
                        });
                    }
                });
        }, 800);
    });
    
    function showAutofillNotification(name) {
        const existing = document.getElementById('autofill-notif');
        if (existing) existing.remove();
        
        const notif = document.createElement('div');
        notif.id = 'autofill-notif';
        notif.className = 'fixed bottom-6 right-6 bg-emerald-500 text-white px-6 py-3 rounded-2xl shadow-xl animate-bounce-in flex items-center gap-3 z-50';
        notif.innerHTML = `
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
            <span>Datos cargados para <strong>${name}</strong></span>
        `;
        document.body.appendChild(notif);
        
        setTimeout(() => {
            notif.classList.remove('animate-bounce-in');
            notif.classList.add('opacity-0', 'transition-opacity', 'duration-500');
            setTimeout(() => notif.remove(), 500);
        }, 4000);
    }
});
</script>

<style>
@keyframes bounce-in {
    0% { transform: scale(0.3); opacity: 0; }
    50% { transform: scale(1.05); opacity: 1; }
    70% { transform: scale(0.9); }
    100% { transform: scale(1); }
}
.animate-bounce-in {
    animation: bounce-in 0.5s cubic-bezier(0.175, 0.885, 0.32, 1.275);
}
</style>
