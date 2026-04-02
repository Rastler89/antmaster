<!-- Header Administrador -->
<div class="flex flex-col md:flex-row justify-between items-center mb-8 gap-4">
    <div>
        <h1 class="text-3xl font-black text-white">
            <span class="bg-clip-text text-transparent bg-gradient-to-r from-red-400 via-orange-500 to-yellow-500">Panel de Control</span> 🛡️
        </h1>
        <p class="text-zinc-500 text-sm mt-1">Visión general del estado del sistema y gestión de usuarios.</p>
    </div>
</div>

<!-- KPI Cards -->
<div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
    <div class="glass-card p-6 border-blue-500/10 overflow-hidden relative group hover:bg-blue-500/5 transition-all">
        <div class="absolute -right-4 -top-4 w-24 h-24 bg-blue-500/10 rounded-full blur-2xl group-hover:scale-150 transition-transform duration-700"></div>
        <p class="text-[10px] uppercase font-black text-zinc-500 tracking-widest mb-3">Total Usuarios</p>
        <div class="flex items-end justify-between">
            <h3 class="text-4xl font-black text-white"><?= number_format($stats['total_users']) ?></h3>
            <div class="p-3 bg-blue-500/10 rounded-2xl text-blue-400 border border-blue-500/10">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
            </div>
        </div>
    </div>

    <div class="glass-card p-6 border-emerald-500/10 overflow-hidden relative group hover:bg-emerald-500/5 transition-all">
        <div class="absolute -right-4 -top-4 w-24 h-24 bg-emerald-500/10 rounded-full blur-2xl group-hover:scale-150 transition-transform duration-700"></div>
        <p class="text-[10px] uppercase font-black text-zinc-500 tracking-widest mb-3">Usuarios Activos (30D)</p>
        <div class="flex items-end justify-between">
            <h3 class="text-4xl font-black text-white"><?= number_format($stats['active_users']) ?></h3>
            <div class="p-3 bg-emerald-500/10 rounded-2xl text-emerald-400 border border-emerald-500/10">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
            </div>
        </div>
    </div>

    <div class="glass-card p-6 border-purple-500/10 overflow-hidden relative group hover:bg-purple-500/5 transition-all">
        <div class="absolute -right-4 -top-4 w-24 h-24 bg-purple-500/10 rounded-full blur-2xl group-hover:scale-150 transition-transform duration-700"></div>
        <p class="text-[10px] uppercase font-black text-zinc-500 tracking-widest mb-3">Total Colonias</p>
        <div class="flex items-end justify-between">
            <h3 class="text-4xl font-black text-white"><?= number_format($stats['total_colonies']) ?></h3>
            <div class="p-3 bg-purple-500/10 rounded-2xl text-purple-400 border border-purple-500/10">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 002-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>
            </div>
        </div>
    </div>

    <div class="glass-card p-6 border-red-500/10 overflow-hidden relative group hover:bg-red-500/5 transition-all">
        <div class="absolute -right-4 -top-4 w-24 h-24 bg-red-500/10 rounded-full blur-2xl group-hover:scale-150 transition-transform duration-700"></div>
        <p class="text-[10px] uppercase font-black text-zinc-500 tracking-widest mb-3">Baneados</p>
        <div class="flex items-end justify-between">
            <h3 class="text-4xl font-black text-white"><?= number_format($stats['banned_users']) ?></h3>
            <div class="p-3 bg-red-500/10 rounded-2xl text-red-400 border border-red-500/10">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636"></path></svg>
            </div>
        </div>
    </div>
</div>

<div class="glass-card p-0 border-white/5 overflow-hidden">
    <div class="p-6 border-b border-white/5 flex items-center justify-between">
        <h3 class="text-lg font-bold text-white">Gestión de Usuarios</h3>
        <span class="text-[10px] font-black text-zinc-500 uppercase tracking-widest bg-white/5 px-3 py-1 rounded-full border border-white/5">Media: <?= $stats['avg_colonies_per_user'] ?> col/user</span>
    </div>
    <div class="overflow-x-auto">
        <table class="w-full text-left">
            <thead class="bg-white/[0.02] text-[10px] uppercase font-black tracking-widest text-zinc-500">
                <tr>
                    <th class="px-6 md:px-8 py-4">Usuario</th>
                    <th class="px-6 py-4">Rol</th>
                    <th class="px-6 py-4">Registro</th>
                    <th class="px-6 py-4">Última Conex.</th>
                    <th class="px-6 py-4 text-center">Estado</th>
                    <th class="px-6 py-4 text-right">Acciones</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-white/5">
                <?php foreach ($users as $u): ?>
                    <tr class="group hover:bg-white/[0.03] transition-colors <?= $u['is_banned'] ? 'opacity-50' : '' ?>">
                        <td class="px-6 md:px-8 py-5">
                            <div class="flex flex-col">
                                <span class="font-bold text-white text-sm md:text-base"><?= htmlspecialchars($u['nombre']) ?></span>
                                <span class="text-[10px] text-zinc-500"><?= htmlspecialchars($u['email']) ?></span>
                            </div>
                        </td>
                        <td class="px-6 py-5">
                            <span class="text-[10px] uppercase font-black tracking-wider <?= $u['rol'] == 'admin' ? 'text-red-400' : 'text-blue-400' ?>">
                                <?= htmlspecialchars($u['rol']) ?>
                            </span>
                        </td>
                        <td class="px-6 py-5">
                            <span class="text-sm text-white"><?= date('d M Y', strtotime($u['fecha_registro'])) ?></span>
                        </td>
                        <td class="px-6 py-5">
                            <span class="text-sm text-zinc-400">
                                <?= $u['last_login'] ? get_time_elapsed($u['last_login']) . ' ago' : 'Nunca' ?>
                            </span>
                        </td>
                        <td class="px-6 py-5 text-center">
                            <?php if ($u['is_banned']): ?>
                                <span class="px-3 py-1 rounded-full bg-red-500/10 text-red-500 text-[10px] uppercase font-black border border-red-500/20">Baneado</span>
                            <?php else: ?>
                                <span class="px-3 py-1 rounded-full bg-emerald-500/10 text-emerald-500 text-[10px] uppercase font-black border border-emerald-500/20">Activo</span>
                            <?php endif; ?>
                        </td>
                        <td class="px-6 py-5 text-right">
                            <?php if ($u['id'] != $_SESSION['user_id']): ?>
                                <form action="<?= BASE_URL ?>/admin/usuarios/ban/<?= $u['id'] ?>" method="POST" onsubmit="return confirm('¿Estás seguro de efectuar esta acción contra este usuario?');">
                                    <button type="submit" class="p-2 md:p-2.5 rounded-xl transition-all border inline-flex items-center text-[10px] font-black uppercase
                                        <?= $u['is_banned'] ? 'bg-emerald-500/10 text-emerald-500 border-emerald-500/20 hover:bg-emerald-500 hover:text-white' : 'bg-red-500/10 text-red-500 border-red-500/20 hover:bg-red-500 hover:text-white' ?>">
                                        <?= $u['is_banned'] ? 'Reactivar' : 'Banear' ?>
                                    </button>
                                </form>
                            <?php else: ?>
                                <span class="text-[10px] text-zinc-500 uppercase tracking-widest font-black">Tú</span>
                            <?php endif; ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>
