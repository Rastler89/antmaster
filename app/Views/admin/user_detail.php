<!-- Header Administrador -->
<div class="flex flex-col md:flex-row justify-between items-center mb-8 gap-4">
    <div>
        <h1 class="text-3xl font-black text-white">
            Detalle del Usuario: <span class="bg-clip-text text-transparent bg-gradient-to-r from-blue-400 to-indigo-500"><?= htmlspecialchars($user['nombre']) ?></span>
        </h1>
        <p class="text-zinc-500 text-sm mt-1">Inspección y gestión de stock y colonias</p>
    </div>
    <div class="flex items-center gap-3">
        <a href="<?= BASE_URL ?>/admin/dashboard" class="px-5 py-2.5 bg-zinc-800/50 border border-zinc-700/50 text-zinc-300 rounded-2xl hover:bg-zinc-700 hover:text-white transition-all text-xs font-black uppercase flex items-center gap-2">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
            Volver al Panel
        </a>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
    <!-- Info del Usuario -->
    <div class="glass-card p-6 border-blue-500/10">
        <h3 class="text-lg font-bold text-white mb-4">Información General</h3>
        <ul class="space-y-4">
            <li class="flex justify-between items-center pb-2 border-b border-white/5">
                <span class="text-xs text-zinc-500 uppercase font-black">Email</span>
                <span class="text-sm text-zinc-300"><?= htmlspecialchars($user['email']) ?></span>
            </li>
            <li class="flex justify-between items-center pb-2 border-b border-white/5">
                <span class="text-xs text-zinc-500 uppercase font-black">Rol</span>
                <span class="text-xs px-2 py-1 bg-white/5 rounded-md text-white uppercase font-bold"><?= htmlspecialchars($user['rol']) ?></span>
            </li>
            <li class="flex justify-between items-center pb-2 border-b border-white/5">
                <span class="text-xs text-zinc-500 uppercase font-black">Registro</span>
                <span class="text-sm text-zinc-300"><?= date('d M Y', strtotime($user['fecha_registro'])) ?></span>
            </li>
            <li class="flex justify-between items-center pb-2 border-b border-white/5">
                <span class="text-xs text-zinc-500 uppercase font-black">Última Sesión</span>
                <span class="text-sm text-zinc-300"><?= $user['last_login'] ? date('d M Y H:i', strtotime($user['last_login'])) : 'Nunca' ?></span>
            </li>
            <li class="flex justify-between items-center">
                <span class="text-xs text-zinc-500 uppercase font-black">Estado</span>
                <?php if ($user['is_banned']): ?>
                    <span class="px-2 py-1 bg-red-500/10 text-red-500 text-[10px] rounded uppercase font-black">Baneado</span>
                <?php else: ?>
                    <span class="px-2 py-1 bg-emerald-500/10 text-emerald-500 text-[10px] rounded uppercase font-black">Activo</span>
                <?php endif; ?>
            </li>
        </ul>
    </div>

    <!-- Stock del Usuario -->
    <div class="lg:col-span-2 glass-card p-0 border-emerald-500/10 overflow-hidden">
        <div class="p-6 border-b border-white/5">
            <h3 class="text-lg font-bold text-white">Stock de Alimento</h3>
            <p class="text-[10px] text-zinc-500 uppercase tracking-widest font-black">Inventario actual del usuario</p>
        </div>
        
        <?php if (empty($stock)): ?>
            <div class="p-8 text-center text-zinc-500 italic text-sm">Este usuario no tiene stock registrado.</div>
        <?php else: ?>
            <div class="overflow-x-auto">
                <table class="w-full text-left">
                    <thead class="bg-white/[0.02] text-[10px] uppercase font-black tracking-widest text-zinc-500">
                        <tr>
                            <th class="px-6 py-4">Ítem</th>
                            <th class="px-6 py-4">Cantidad</th>
                            <th class="px-6 py-4 text-right">Acciones (Admin)</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-white/5">
                        <?php foreach ($stock as $s): ?>
                            <tr class="hover:bg-white/[0.03] transition-colors">
                                <td class="px-6 py-4">
                                    <span class="font-bold text-white text-sm"><?= htmlspecialchars($s['nombre']) ?></span>
                                    <span class="block text-[10px] font-black text-emerald-400 uppercase"><?= htmlspecialchars($s['categoria']) ?></span>
                                </td>
                                <td class="px-6 py-4">
                                    <form action="<?= BASE_URL ?>/admin/usuarios/stock/editar/<?= $s['id'] ?>" method="POST" class="flex gap-2 items-center">
                                        <input type="number" step="0.01" name="cantidad" value="<?= $s['cantidad'] ?>" class="w-20 bg-zinc-900 border border-zinc-700 text-white rounded px-2 py-1 text-sm focus:border-blue-500 outline-none">
                                        <span class="text-zinc-500 text-xs"><?= htmlspecialchars($s['unidad']) ?></span>
                                        <button type="submit" class="p-1 px-2 bg-blue-500/20 text-blue-400 rounded hover:bg-blue-500 hover:text-white transition text-xs">Guardar</button>
                                    </form>
                                </td>
                                <td class="px-6 py-4 text-right">
                                    <form action="<?= BASE_URL ?>/admin/usuarios/stock/borrar/<?= $s['id'] ?>" method="POST" onsubmit="return confirm('¿Seguro que deseas eliminar este stock del usuario?');">
                                        <button type="submit" class="p-1.5 px-3 bg-red-500/10 text-red-500 rounded hover:bg-red-500 hover:text-white transition-all text-xs font-bold border border-red-500/20">Borrar</button>
                                    </form>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php endif; ?>
    </div>
</div>

<!-- Colonias del Usuario -->
<div class="mt-8 glass-card p-0 border-purple-500/10 overflow-hidden">
    <div class="p-6 border-b border-white/5">
        <h3 class="text-lg font-bold text-white">Colonias Registradas</h3>
        <p class="text-[10px] text-zinc-500 uppercase tracking-widest font-black">Mantenimiento de colonias</p>
    </div>
    
    <?php if (empty($colonies)): ?>
        <div class="p-8 text-center text-zinc-500 italic text-sm">Este usuario no ha registrado ninguna colonia aún.</div>
    <?php else: ?>
        <div class="overflow-x-auto">
            <table class="w-full text-left">
                <thead class="bg-white/[0.02] text-[10px] uppercase font-black tracking-widest text-zinc-500">
                    <tr>
                        <th class="px-6 py-4">Colonia</th>
                        <th class="px-6 py-4">Especie</th>
                        <th class="px-6 py-4">Adquisición</th>
                        <th class="px-6 py-4 text-center">Población</th>
                        <th class="px-6 py-4 text-right">Acciones</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-white/5">
                    <?php foreach ($colonies as $colony): ?>
                        <tr class="hover:bg-white/[0.03] transition-colors">
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-3">
                                    <?php if ($colony['imagen']): ?>
                                        <img src="<?= asset('uploads/colonies/' . $colony['imagen']) ?>" class="w-10 h-10 rounded-xl object-cover border border-white/10 shadow-lg">
                                    <?php else: ?>
                                        <div class="w-10 h-10 rounded-xl bg-purple-500/10 flex items-center justify-center border border-purple-500/20 shadow-[0_0_15px_rgba(168,85,247,0.15)]">
                                            <span class="text-purple-400 font-bold text-lg"><?= strtoupper(substr($colony['nombre'], 0, 1)) ?></span>
                                        </div>
                                    <?php endif; ?>
                                    <div>
                                        <span class="font-bold text-white block text-sm"><?= htmlspecialchars($colony['nombre']) ?></span>
                                        <span class="text-[10px] text-zinc-500"><?= htmlspecialchars($colony['tipo_hormiguero']) ?: 'Sin especificar' ?></span>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <span class="text-sm text-zinc-300 block"><?= htmlspecialchars($colony['especie_nombre']) ?></span>
                                <span class="text-[10px] text-zinc-500 italic"><?= htmlspecialchars($colony['especie_nombre_cientifico']) ?></span>
                            </td>
                            <td class="px-6 py-4">
                                <span class="text-sm text-white"><?= date('d M Y', strtotime($colony['fecha_adquisicion'])) ?></span>
                            </td>
                            <td class="px-6 py-4 text-center">
                                <span class="px-3 py-1 bg-white/5 rounded-full text-white text-xs font-bold border border-white/5">
                                    <?= number_format($colony['poblacion_actual']) ?>
                                </span>
                            </td>
                            <td class="px-6 py-4 text-right">
                                <div class="flex items-center justify-end gap-2">
                                    <a href="<?= BASE_URL ?>/colonias/ver/<?= $colony['id'] ?>" class="p-2 border border-blue-500/20 bg-blue-500/10 text-blue-400 rounded-xl hover:bg-blue-500 hover:text-white transition" title="Ver Diario">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                                    </a>
                                    <a href="<?= BASE_URL ?>/colonias/editar/<?= $colony['id'] ?>" class="p-2 border border-orange-500/20 bg-orange-500/10 text-orange-400 rounded-xl hover:bg-orange-500 hover:text-white transition" title="Editar">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                                    </a>
                                    <form action="<?= BASE_URL ?>/admin/usuarios/colonia/borrar/<?= $colony['id'] ?>" method="POST" class="inline" onsubmit="return confirm('ATENCIÓN ADMINISTRADOR:\n¿Seguro que deseas eliminar definitivamente esta colonia, sus diarios y fotos?');">
                                        <button type="submit" class="p-2 border border-red-500/20 bg-red-500/10 text-red-500 rounded-xl hover:bg-red-500 hover:text-white transition border" title="Eliminar Definitivamente">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    <?php endif; ?>
</div>
