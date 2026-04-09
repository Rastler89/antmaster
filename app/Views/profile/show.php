<?php
// Iconos por categoría de logro (Como fallback si no hay imagen)
$categoryIcons = [
    'diarios' => '📖',
    'ciencias' => '🔬',
    'coleccion' => '🐜',
    'almacen' => '📦',
    'constancia' => '☀️',
    'comunidad' => '🌍'
];

$tierColors = [
    'bronce' => 'border-[#cd7f32] text-[#cd7f32] bg-[#cd7f32]/10',
    'plata' => 'border-[#c0c0c0] text-[#c0c0c0] bg-[#c0c0c0]/10',
    'oro' => 'border-[#ffd700] text-[#ffd700] bg-[#ffd700]/20 shadow-[0_0_15px_rgba(255,215,0,0.3)]',
    'platino' => 'border-[#e5e4e2] text-[#e5e4e2] bg-[#e5e4e2]/20 shadow-[0_0_20px_rgba(229,228,226,0.5)] animate-pulse-slow'
];
?>

<div class="profile-container animate-fade-in space-y-8">
    
    <!-- Profile Header Card -->
    <div class="glass-card overflow-hidden">
        <div class="h-32 bg-gradient-to-r from-blue-600/20 via-purple-600/20 to-blue-600/20"></div>
        <div class="px-8 pb-8 -mt-16">
            <div class="flex flex-col md:flex-row items-end gap-6 mb-6">
                <div class="relative group">
                    <img src="<?= $avatar ?>" class="w-32 h-32 rounded-3xl border-4 border-zinc-900 object-cover shadow-2xl">
                    <div class="absolute inset-0 rounded-3xl ring-1 ring-white/10"></div>
                </div>
                <div class="flex-1 pb-2">
                    <div class="flex items-center gap-3 mb-1">
                        <h1 class="text-4xl font-black text-white tracking-tighter"><?= htmlspecialchars($user['nombre']) ?></h1>
                        <?php if ($user['rol'] === 'admin'): ?>
                            <span class="px-3 py-1 bg-red-500/20 text-red-500 rounded-lg text-[8px] font-black uppercase tracking-widest border border-red-500/20">Staff</span>
                        <?php endif; ?>
                    </div>
                    <div class="flex items-center gap-2">
                        <span class="text-blue-400 font-black text-xs uppercase tracking-widest"><?= $rank ?></span>
                        <span class="text-zinc-500 text-xs">•</span>
                        <span class="text-zinc-500 font-bold text-xs"><?= $xp ?> XP Acumulados</span>
                    </div>
                </div>
                <?php if (isset($_SESSION['user_id']) && $_SESSION['user_id'] == $user['id']): ?>
                    <a href="<?= BASE_URL ?>/perfil/editar" class="mb-2 px-6 py-3 bg-white/5 hover:bg-white/10 border border-white/10 rounded-2xl text-[10px] font-black uppercase tracking-widest text-white transition-all">Editar Mi Perfil</a>
                <?php endif; ?>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-12 gap-8 pt-8 border-t border-white/5">
                <!-- Bio & Stats -->
                <div class="md:col-span-8 space-y-6">
                    <div>
                        <h3 class="text-[10px] uppercase font-black text-zinc-500 tracking-[0.2em] mb-3">Biografía</h3>
                        <p class="text-zinc-400 leading-relaxed italic">
                            <?= nl2br(htmlspecialchars($user['bio'] ?: 'Este mirmecólogo prefiere mantener el misterio sobre sus hormigas...')) ?>
                        </p>
                    </div>

                    <!-- XP Progress Bar Overlay -->
                    <div class="bg-black/20 p-6 rounded-[2rem] border border-white/5">
                        <div class="flex items-center justify-between mb-2">
                            <span class="text-[9px] font-black text-blue-400 uppercase tracking-widest">Progreso de Casta</span>
                            <span class="text-[9px] font-black text-zinc-500 uppercase tracking-widest">Siguiente Nivel</span>
                        </div>
                        <div class="h-3 w-full bg-white/5 rounded-full overflow-hidden">
                            <?php 
                                $progress = ($xp % 500) / 5; // Simulación simple de progreso visual
                            ?>
                            <div class="h-full bg-gradient-to-r from-blue-500 to-purple-600 transition-all duration-1000" style="width: <?= $progress ?>%"></div>
                        </div>
                    </div>
                </div>

                <!-- Fast Stats -->
                <div class="md:col-span-4 grid grid-cols-2 gap-4">
                    <div class="bg-white/5 p-4 rounded-3xl border border-white/5 text-center">
                        <span class="block text-2xl font-black text-white"><?= count($colonies) ?></span>
                        <span class="text-[8px] uppercase font-black text-zinc-500 tracking-widest">Colonias</span>
                    </div>
                    <div class="bg-white/5 p-4 rounded-3xl border border-white/5 text-center">
                        <span class="block text-2xl font-black text-white"><?= count($badges) ?></span>
                        <span class="text-[8px] uppercase font-black text-zinc-500 tracking-widest">Logros</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Achievements & Badges Grid -->
    <div class="space-y-4">
        <h2 class="text-2xl font-black text-white flex items-center gap-3">
            <svg class="w-6 h-6 text-yellow-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-7.714 2.143L11 21l-2.286-6.857L1 12l7.714-2.143L11 3z"></path></svg>
            Salón de Medallas
        </h2>
        
        <?php if (empty($badges)): ?>
            <div class="glass-card p-12 text-center opacity-50">
                <p class="text-zinc-500 font-bold uppercase tracking-widest text-xs">Aún no se han desbloqueado méritos</p>
            </div>
        <?php else: ?>
            <div class="grid grid-cols-2 sm:grid-cols-4 md:grid-cols-6 gap-4">
                <?php foreach ($badges as $badge): ?>
                    <div class="p-4 rounded-[2rem] border <?= $tierColors[$badge['nivel']] ?? 'border-white/5' ?> flex flex-col items-center justify-center text-center transition-all hover:scale-105 group relative overflow-hidden">
                        <div class="text-4xl mb-3 filter drop-shadow-md"><?= $categoryIcons[$badge['categoria']] ?? '🏅' ?></div>
                        <h4 class="text-[10px] font-black text-white uppercase leading-tight mb-1"><?= htmlspecialchars($badge['nombre']) ?></h4>
                        <span class="text-[8px] opacity-60 font-bold uppercase"><?= $badge['nivel'] ?></span>
                        
                        <!-- Tooltip simple -->
                        <div class="absolute inset-0 bg-black/90 opacity-0 group-hover:opacity-100 transition-opacity flex items-center justify-center p-4">
                            <p class="text-[9px] font-medium text-white leading-snug"><?= htmlspecialchars($badge['descripcion']) ?></p>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>

    <!-- Public Colonies Grid -->
    <div class="space-y-4">
        <h2 class="text-2xl font-black text-white flex items-center gap-3">
            <svg class="w-6 h-6 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
            Colección Pública
        </h2>

        <?php if (empty($colonies)): ?>
            <div class="glass-card p-12 text-center opacity-50">
                <p class="text-zinc-500 font-bold uppercase tracking-widest text-xs">No hay colonias marcadas como públicas</p>
            </div>
        <?php else: ?>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                <?php foreach ($colonies as $colony): ?>
                    <div class="glass-card group overflow-hidden border-white/5 hover:border-blue-500/30 transition-all">
                        <div class="relative h-48 overflow-hidden">
                            <?php if ($colony['imagen']): ?>
                                <img src="<?= asset('uploads/colonies/' . $colony['imagen']) ?>" class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-110">
                            <?php else: ?>
                                <div class="w-full h-full bg-zinc-800 flex items-center justify-center text-zinc-700">
                                    <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                                </div>
                            <?php endif; ?>
                            <div class="absolute inset-0 bg-gradient-to-t from-black/80 to-transparent"></div>
                            <div class="absolute bottom-4 left-6">
                                <h3 class="text-xl font-black text-white"><?= htmlspecialchars($colony['nombre']) ?></h3>
                                <p class="text-[10px] text-blue-400 font-black uppercase tracking-widest"><?= htmlspecialchars($colony['especie_nombre']) ?></p>
                            </div>
                        </div>
                        <div class="p-6 flex items-center justify-between">
                            <div class="flex items-center gap-2">
                                <span class="text-xs font-black text-white"><?= number_format($colony['poblacion_actual']) ?></span>
                                <span class="text-[8px] uppercase font-black text-zinc-500 tracking-widest">Hormigas</span>
                            </div>
                            <a href="<?= BASE_URL ?>/log/<?= $user['slug'] ?>/<?= $colony['public_slug'] ?>" class="text-[9px] font-black uppercase tracking-[0.2em] text-blue-400 hover:text-blue-300 transition-colors">Ver Diario →</a>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>

</div>

<style>
@keyframes pulse-slow {
    0%, 100% { opacity: 1; filter: drop-shadow(0 0 10px rgba(229,228,226,0.3)); }
    50% { opacity: 0.8; filter: drop-shadow(0 0 25px rgba(229,228,226,0.6)); }
}
.animate-pulse-slow {
    animation: pulse-slow 3s infinite ease-in-out;
}
</style>
