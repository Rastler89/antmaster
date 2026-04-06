<div class="flex flex-col md:flex-row justify-between items-center mb-8 gap-4">
    <div>
        <h1 class="text-3xl font-black text-white">
            <span class="bg-clip-text text-transparent bg-gradient-to-r from-blue-400 to-indigo-500">Gestión de Traducciones</span> 🌍
        </h1>
        <p class="text-zinc-500 text-sm mt-1">Administra el contenido multi-idioma de las fichas de cría.</p>
    </div>
    <a href="<?= BASE_URL ?>/admin/dashboard" class="px-4 py-2 bg-white/5 border border-white/10 text-zinc-400 rounded-xl hover:bg-white/10 hover:text-white transition-all text-sm font-bold flex items-center gap-2">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
        Volver al Panel
    </a>
</div>

<?php if ($success): ?>
    <div class="mb-6 p-4 bg-emerald-500/10 border border-emerald-500/20 text-emerald-400 rounded-xl text-sm animate-fade-in">
        <?= htmlspecialchars($success) ?>
    </div>
<?php endif; ?>

<?php if ($error): ?>
    <div class="mb-6 p-4 bg-red-500/10 border border-red-500/20 text-red-400 rounded-xl text-sm animate-fade-in">
        <?= htmlspecialchars($error) ?>
    </div>
<?php endif; ?>

<div class="glass-card p-0 border-white/5 overflow-hidden">
    <div class="p-6 border-b border-white/5">
        <h3 class="text-lg font-bold text-white">Listado de Especies</h3>
    </div>
    <div class="overflow-x-auto">
        <table class="w-full text-left">
            <thead class="bg-white/[0.02] text-[10px] uppercase font-black tracking-widest text-zinc-500">
                <tr>
                    <th class="px-6 md:px-8 py-4">Especie</th>
                    <th class="px-6 py-4">Estado Traducción</th>
                    <th class="px-6 py-4 text-right">Acciones</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-white/5">
                <?php foreach ($species as $s): ?>
                    <tr class="group hover:bg-white/[0.03] transition-colors">
                        <td class="px-6 md:px-8 py-5">
                            <div class="flex flex-col">
                                <span class="font-bold text-white text-sm md:text-base italic"><?= htmlspecialchars($s['nombre_cientifico']) ?></span>
                                <span class="text-[10px] text-zinc-500"><?= htmlspecialchars($s['nombre_es']) ?></span>
                            </div>
                        </td>
                        <td class="px-6 py-5">
                            <div class="flex items-center gap-2">
                                <!-- Base ES siempre está -->
                                <span class="px-2 py-0.5 rounded-md bg-blue-500/20 text-blue-400 text-[10px] font-black border border-blue-500/20">ES</span>
                                
                                <!-- EN -->
                                <?php if (in_array('en', $s['langs'])): ?>
                                    <span class="px-2 py-0.5 rounded-md bg-emerald-500/20 text-emerald-400 text-[10px] font-black border border-emerald-500/20" title="Traducción completa">EN</span>
                                <?php else: ?>
                                    <span class="px-2 py-0.5 rounded-md bg-white/5 text-zinc-600 text-[10px] font-black border border-white/5" title="Falta traducción">EN</span>
                                <?php endif; ?>

                                <!-- FR -->
                                <?php if (in_array('fr', $s['langs'])): ?>
                                    <span class="px-2 py-0.5 rounded-md bg-emerald-500/20 text-emerald-400 text-[10px] font-black border border-emerald-500/20" title="Traducción completa">FR</span>
                                <?php else: ?>
                                    <span class="px-2 py-0.5 rounded-md bg-white/5 text-zinc-600 text-[10px] font-black border border-white/5" title="Falta traducción">FR</span>
                                <?php endif; ?>
                            </div>
                        </td>
                        <td class="px-6 py-5 text-right">
                            <a href="<?= BASE_URL ?>/admin/especies/traducir/<?= $s['id'] ?>" class="px-4 py-2 bg-indigo-500/10 text-indigo-400 border border-indigo-500/20 rounded-xl text-[10px] font-black uppercase hover:bg-indigo-500 hover:text-white transition-all">
                                Gestionar Traducciones
                            </a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>
