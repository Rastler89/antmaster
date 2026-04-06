<?php
$current_lang = $_GET['lang'] ?? 'en';
$trans = $translations[$current_lang] ?? [];
?>

<div class="flex flex-col md:flex-row justify-between items-center mb-8 gap-4">
    <div class="flex flex-col">
        <div class="flex items-center gap-2 text-zinc-500 text-xs mb-2">
            <a href="<?= BASE_URL ?>/admin/especies" class="hover:text-white transition-colors">Gestión de Traducciones</a>
            <span>/</span>
            <span class="text-white italic"><?= htmlspecialchars($species['nombre_cientifico']) ?></span>
        </div>
        <h1 class="text-3xl font-black text-white">
            Traducir <span class="text-indigo-400"><?= htmlspecialchars($species['nombre_cientifico']) ?></span> 🐜
        </h1>
    </div>
    <a href="<?= BASE_URL ?>/admin/especies" class="px-4 py-2 bg-white/5 border border-white/10 text-zinc-400 rounded-xl hover:bg-white/10 hover:text-white transition-all text-sm font-bold flex items-center gap-2">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
        Volver al Listado
    </a>
</div>

<div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
    <!-- Sidebar: Selector de Idioma -->
    <div class="lg:col-span-3 space-y-4">
        <div class="glass-card p-4 border-white/5">
            <h3 class="text-[10px] uppercase font-black text-zinc-500 tracking-widest mb-4">Idiomas Disponibles</h3>
            <div class="flex flex-col gap-2">
                <?php foreach ($languages as $code => $name): ?>
                    <a href="?lang=<?= $code ?>" class="flex items-center justify-between p-3 rounded-xl border transition-all <?= $current_lang == $code ? 'bg-indigo-500/20 border-indigo-500/40 text-white' : 'bg-white/5 border-white/5 text-zinc-400 hover:bg-white/10' ?>">
                        <span class="font-bold text-sm"><?= $name ?></span>
                        <span class="text-[10px] uppercase font-black px-2 py-0.5 rounded-lg bg-zinc-800 border border-white/5"><?= strtoupper($code) ?></span>
                    </a>
                <?php endforeach; ?>
            </div>
        </div>

        <!-- Info Card -->
        <div class="glass-card p-6 border-amber-500/10 bg-amber-500/[0.02]">
            <div class="flex items-center gap-2 text-amber-500 mb-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                <span class="text-[10px] uppercase font-black tracking-widest">Importante</span>
            </div>
            <p class="text-xs text-zinc-400 leading-relaxed">
                El texto base (ES) se muestra a la izquierda como referencia. Si dejas una traducción vacía, el sistema mostrará automáticamente el texto en español al usuario final.
            </p>
        </div>
    </div>

    <!-- Main Content: Editor de Traducción -->
    <div class="lg:col-span-9">
        <form action="<?= BASE_URL ?>/admin/especies/traducir/<?= $species['id'] ?>" method="POST" class="space-y-6">
            <input type="hidden" name="lang" value="<?= $current_lang ?>">

            <div class="glass-card p-0 border-white/5 overflow-hidden">
                <div class="p-4 bg-white/[0.02] border-b border-white/5 flex items-center justify-between">
                    <span class="text-[10px] uppercase font-black tracking-widest text-zinc-500">Editor de Contenido (Editable)</span>
                    <span class="text-[10px] uppercase font-black tracking-widest text-indigo-400">Traduciendo al <?= $languages[$current_lang] ?></span>
                </div>

                <div class="p-8 space-y-8">
                    <!-- Nombre Común -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                        <div>
                            <label class="block text-[10px] uppercase font-black text-zinc-500 tracking-widest mb-2">Nombre Común (ES)</label>
                            <div class="p-3 bg-zinc-900 border border-white/5 rounded-xl text-zinc-400 text-sm font-medium">
                                <?= htmlspecialchars($species['nombre']) ?>
                            </div>
                        </div>
                        <div>
                            <label for="nombre" class="block text-[10px] uppercase font-black text-indigo-400 tracking-widest mb-2">Nombre en <?= strtoupper($current_lang) ?></label>
                            <input type="text" id="nombre" name="nombre" value="<?= htmlspecialchars($trans['nombre'] ?? '') ?>" placeholder="Ej: Harvester Ant"
                                class="w-full bg-indigo-500/5 border border-indigo-500/20 rounded-xl p-3 text-white text-sm focus:outline-none focus:border-indigo-500 transition-all">
                        </div>
                    </div>

                    <div class="border-t border-white/5 pt-8">
                        <!-- Descripción -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                            <div>
                                <label class="block text-[10px] uppercase font-black text-zinc-500 tracking-widest mb-2">Descripción (ES)</label>
                                <div class="p-4 bg-zinc-900 border border-white/5 rounded-xl text-zinc-400 text-sm leading-relaxed whitespace-pre-wrap"><?= htmlspecialchars($species['descripcion'] ?? 'Sin datos.') ?></div>
                            </div>
                            <div>
                                <label for="descripcion" class="block text-[10px] uppercase font-black text-indigo-400 tracking-widest mb-2">Descripción en <?= strtoupper($current_lang) ?></label>
                                <textarea id="descripcion" name="descripcion" rows="5" class="w-full bg-indigo-500/5 border border-indigo-500/20 rounded-xl p-4 text-white text-sm focus:outline-none focus:border-indigo-500 transition-all"><?= htmlspecialchars($trans['descripcion'] ?? '') ?></textarea>
                            </div>
                        </div>
                    </div>

                    <div class="border-t border-white/5 pt-8">
                        <!-- Alimentación -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                            <div>
                                <label class="block text-[10px] uppercase font-black text-zinc-500 tracking-widest mb-2">Alimentación (ES)</label>
                                <div class="p-4 bg-zinc-900 border border-white/5 rounded-xl text-zinc-400 text-sm leading-relaxed whitespace-pre-wrap"><?= htmlspecialchars($species['alimentacion'] ?? 'Sin datos.') ?></div>
                            </div>
                            <div>
                                <label for="alimentacion" class="block text-[10px] uppercase font-black text-indigo-400 tracking-widest mb-2">Alimentación en <?= strtoupper($current_lang) ?></label>
                                <textarea id="alimentacion" name="alimentacion" rows="4" class="w-full bg-indigo-500/5 border border-indigo-500/20 rounded-xl p-4 text-white text-sm focus:outline-none focus:border-indigo-500 transition-all"><?= htmlspecialchars($trans['alimentacion'] ?? '') ?></textarea>
                            </div>
                        </div>
                    </div>

                    <div class="border-t border-white/5 pt-8">
                        <!-- Consejos de Cría -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                            <div>
                                <label class="block text-[10px] uppercase font-black text-zinc-500 tracking-widest mb-2">Consejos de Cría (ES)</label>
                                <div class="p-4 bg-zinc-900 border border-white/5 rounded-xl text-zinc-400 text-sm leading-relaxed whitespace-pre-wrap"><?= htmlspecialchars($species['consejos_cria'] ?? 'Sin datos.') ?></div>
                            </div>
                            <div>
                                <label for="consejos_cria" class="block text-[10px] uppercase font-black text-indigo-400 tracking-widest mb-2">Consejos de Cría en <?= strtoupper($current_lang) ?></label>
                                <textarea id="consejos_cria" name="consejos_cria" rows="4" class="w-full bg-indigo-500/5 border border-indigo-500/20 rounded-xl p-4 text-white text-sm focus:outline-none focus:border-indigo-500 transition-all"><?= htmlspecialchars($trans['consejos_cria'] ?? '') ?></textarea>
                            </div>
                        </div>
                    </div>

                    <div class="border-t border-white/5 pt-8">
                        <!-- Localización -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                            <div>
                                <label class="block text-[10px] uppercase font-black text-zinc-500 tracking-widest mb-2">Localización (ES)</label>
                                <div class="p-4 bg-zinc-900 border border-white/5 rounded-xl text-zinc-400 text-sm leading-relaxed whitespace-pre-wrap"><?= htmlspecialchars($species['localizacion'] ?? 'Sin datos.') ?></div>
                            </div>
                            <div>
                                <label for="localizacion" class="block text-[10px] uppercase font-black text-indigo-400 tracking-widest mb-2">Localización en <?= strtoupper($current_lang) ?></label>
                                <textarea id="localizacion" name="localizacion" rows="3" class="w-full bg-indigo-500/5 border border-indigo-500/20 rounded-xl p-4 text-white text-sm focus:outline-none focus:border-indigo-500 transition-all"><?= htmlspecialchars($trans['localizacion'] ?? '') ?></textarea>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="p-6 bg-white/[0.02] border-t border-white/5 flex justify-end">
                    <button type="submit" class="magic-btn group px-8">
                        Guardar Traducción <?= strtoupper($current_lang) ?>
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>
