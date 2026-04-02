<div class="glass-card p-8 text-center animate-fade-in w-full" style="animation-delay: 0.1s">
    <div class="mb-8">
        <h2 class="text-3xl font-bold bg-clip-text text-transparent bg-gradient-to-r from-blue-400 to-purple-500 inline-block mb-2">Crear Cuenta</h2>
        <p class="text-zinc-400 text-sm">Únete a la mejor comunidad mirmecológica</p>
    </div>

    <?php if (!empty($error)): ?>
        <div class="bg-red-500/10 border border-red-500/50 text-red-500 px-4 py-3 rounded-xl mb-6 text-sm">
            <?= htmlspecialchars($error) ?>
        </div>
    <?php endif; ?>

    <form method="POST" action="<?= BASE_URL ?>/register" class="space-y-4 text-left">
        <div>
            <label class="block text-sm font-medium text-zinc-300 mb-1">Nombre</label>
            <input type="text" name="nombre" value="<?= htmlspecialchars($nombre ?? '') ?>" required placeholder="Tu nombre" class="magic-input">
        </div>
        <div>
            <label class="block text-sm font-medium text-zinc-300 mb-1">Email</label>
            <input type="email" name="email" value="<?= htmlspecialchars($email ?? '') ?>" required placeholder="tu@email.com" class="magic-input">
        </div>
        <div>
            <label class="block text-sm font-medium text-zinc-300 mb-1">Contraseña</label>
            <input type="password" name="password" required placeholder="••••••••" minlength="6" class="magic-input">
        </div>
        <button type="submit" class="magic-btn w-full mt-4">Registrarse</button>
    </form>

    <p class="mt-8 text-sm text-zinc-500">
        ¿Ya tienes cuenta? <a href="<?= BASE_URL ?>/login" class="text-blue-400 hover:text-blue-300 transition font-medium">Inicia sesión</a>
    </p>
</div>
