<div class="max-w-4xl mx-auto animate-fade-in-up">
    
    <div class="flex items-center justify-between mb-8">
        <div>
            <h1 class="text-3xl font-black text-white tracking-tighter">Personalizar Perfil</h1>
            <p class="text-zinc-500 text-sm">Gestiona tu identidad en la comunidad AntMaster</p>
        </div>
        <a href="<?= BASE_URL ?>/u/<?= $user['slug'] ?>" class="px-6 py-3 bg-blue-500 hover:bg-blue-400 text-white rounded-2xl text-[10px] font-black uppercase tracking-widest transition-all shadow-xl shadow-blue-500/20">
            Ver Mi Perfil Público
        </a>
    </div>

    <?php if (isset($_SESSION['success'])): ?>
        <div class="mb-6 p-4 bg-emerald-500/10 border border-emerald-500/20 rounded-2xl text-emerald-400 text-xs font-bold">
            <?= $_SESSION['success'] ?>
            <?php unset($_SESSION['success']); ?>
        </div>
    <?php endif; ?>

    <div class="grid grid-cols-1 md:grid-cols-12 gap-8">
        
        <!-- Main Edit Form -->
        <div class="md:col-span-8">
            <div class="glass-card p-8">
                <form action="<?= BASE_URL ?>/perfil/actualizar" method="POST" class="space-y-6">
                    
                    <div>
                        <label class="text-[10px] uppercase font-black text-zinc-500 mb-2 block tracking-widest pl-1">Nombre de Usuario</label>
                        <input type="text" value="<?= htmlspecialchars($user['nombre']) ?>" disabled 
                            class="magic-input opacity-50 cursor-not-allowed" title="El nombre no se puede cambiar por ahora.">
                        <p class="mt-2 text-[9px] text-zinc-600 italic">Tu URL es: <?= BASE_URL ?>/u/<?= $user['slug'] ?></p>
                    </div>

                    <div>
                        <label class="text-[10px] uppercase font-black text-zinc-500 mb-2 block tracking-widest pl-1">Biografía</label>
                        <textarea name="bio" rows="5" class="magic-input" placeholder="Cuéntale al mundo sobre tu pasión por las hormigas..."><?= htmlspecialchars($user['bio'] ?? '') ?></textarea>
                    </div>

                    <div class="p-6 bg-white/5 rounded-3xl border border-white/5 flex items-center justify-between">
                        <div>
                            <h4 class="text-sm font-black text-white mb-1">Perfil Público</h4>
                            <p class="text-[10px] text-zinc-500 leading-tight">Permite que otros usuarios vean tus logros y colonias públicas.</p>
                        </div>
                        <label class="relative inline-flex items-center cursor-pointer">
                            <input type="checkbox" name="is_public" value="1" class="sr-only peer" <?= $user['is_public'] ? 'checked' : '' ?>>
                            <div class="w-14 h-7 bg-zinc-800 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-zinc-400 after:border-zinc-300 after:border after:rounded-full after:h-6 after:w-6 after:transition-all peer-checked:bg-blue-600 peer-checked:after:bg-white"></div>
                        </label>
                    </div>

                    <div class="pt-4">
                        <button type="submit" class="w-full py-5 bg-blue-500 hover:bg-blue-400 text-white rounded-3xl text-[12px] font-black uppercase tracking-widest transition-all shadow-2xl shadow-blue-500/20">
                            Guardar Cambios
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Sidebar Stats -->
        <div class="md:col-span-4 space-y-6">
            <div class="glass-card p-8 text-center">
                <div class="relative w-24 h-24 mx-auto mb-6">
                    <?php 
                        $emailHash = md5(strtolower(trim($user['email'])));
                        $gravatarUrl = "https://www.gravatar.com/avatar/{$emailHash}?s=200&d=mp";
                    ?>
                    <img src="<?= $user['profile_image'] ?: $gravatarUrl ?>" class="w-full h-full rounded-3xl object-cover border-2 border-white/10">
                </div>
                <h3 class="text-xl font-black text-white tracking-tight mb-1"><?= htmlspecialchars($user['nombre']) ?></h3>
                <p class="text-[10px] text-blue-400 font-black uppercase tracking-widest mb-4"><?= $user['xp'] ?> XP acumulados</p>
                <div class="px-4 py-2 bg-blue-500/10 border border-blue-500/20 rounded-xl text-blue-300 text-[10px] font-black uppercase tracking-widest">
                    <?= (new User($user))->getRank() ?>
                </div>
            </div>

            <div class="glass-card p-6">
                <h4 class="text-[10px] uppercase font-black text-zinc-500 tracking-widest mb-4">¿Sabías que?</h4>
                <p class="text-xs text-zinc-400 leading-relaxed italic">Puedes usar **Gravatar** para cambiar tu foto de perfil automáticamente vinculándola a tu email.</p>
            </div>
        </div>

    </div>

</div>

<style>
.glass-card {
    background: rgba(24, 24, 27, 0.4);
    backdrop-filter: blur(20px);
    -webkit-backdrop-filter: blur(20px);
    border: 1px solid rgba(255, 255, 255, 0.05);
    border-radius: 2.5rem;
    box-shadow: 0 10px 40px rgba(0, 0, 0, 0.3);
}
</style>
