<html lang="es" class="dark">
<?php
require_once '../core/ThemeManager.php';
$defaults = ['theme' => 'messor', 'high_contrast' => false, 'reduced_motion' => false, 'colorblind_mode' => 'none'];
$userSettings = array_merge($defaults, $_SESSION['user_settings'] ?? []);

$themeVariables = ThemeManager::injectVariables($userSettings['theme'], $userSettings['high_contrast']);
$colorblindClass = $userSettings['colorblind_mode'] !== 'none' ? 'cb-' . $userSettings['colorblind_mode'] : '';
$reducedMotionClass = $userSettings['reduced_motion'] ? 'reduce-motion' : '';
?>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($title ?? (defined('APP_NAME') ? APP_NAME : 'AntMaster Pro')) ?></title>
    <style><?= $themeVariables ?></style>
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            darkMode: 'class',
            theme: {
                extend: {
                    colors: {
                        background: '#09090b', // Zinc 950
                        foreground: '#fafafa',
                        card: '#18181b',
                        border: '#27272a',
                        primary: '#3b82f6', // Blue 500
                    },
                    animation: {
                        'blob': 'blob 7s infinite',
                        'fade-in': 'fadeIn 0.5s ease-out',
                        'pulse-slow': 'pulse 4s cubic-bezier(0.4, 0, 0.6, 1) infinite'
                    },
                    keyframes: {
                        blob: {
                            '0%': { transform: 'translate(0px, 0px) scale(1)' },
                            '33%': { transform: 'translate(30px, -50px) scale(1.1)' },
                            '66%': { transform: 'translate(-20px, 20px) scale(0.9)' },
                            '100%': { transform: 'translate(0px, 0px) scale(1)' }
                        },
                        fadeIn: {
                            '0%': { opacity: '0', transform: 'translateY(10px)' },
                            '100%': { opacity: '1', transform: 'translateY(0)' }
                        }
                    }
                }
            }
        }
    </script>
    <style>
        body {
            background-color: var(--theme-background);
            color: var(--theme-foreground);
            font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif;
            margin: 0;
            min-height: 100vh;
            overflow-x: hidden;
            transition: background-color 0.3s ease, color 0.3s ease;
        }

        .glass-card {
            background: var(--theme-card);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
            border: 1px solid var(--theme-border);
            border-radius: 1rem;
            box-shadow: 0 4px 30px rgba(0, 0, 0, 0.5);
            transition: transform 0.3s ease, border-color 0.3s ease;
        }

        .glass-card:hover {
            border-color: var(--theme-primary);
            transform: translateY(-2px);
        }

        .magic-btn {
            position: relative;
            background: linear-gradient(90deg, var(--theme-primary), var(--theme-accent));
            color: white;
            border-radius: 9999px;
            padding: 0.5rem 1.5rem;
            font-weight: 500;
            overflow: hidden;
            transition: opacity 0.3s ease, transform 0.2s ease;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            border: none;
            cursor: pointer;
        }
        
        .magic-btn:active {
            transform: scale(0.95);
        }

        .magic-btn::before {
            content: '';
            position: absolute;
            top: 0; left: -100%; width: 100%; height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255,255,255,0.2), transparent);
            transition: left 0.5s;
        }

        .magic-btn:hover::before {
            left: 100%;
        }

        .magic-input {
            width: 100%;
            background: rgba(0,0,0,0.05); /* Más suave para ver el fondo */
            border: 1px solid var(--theme-border);
            color: var(--theme-text-main);
            padding: 0.75rem 1rem;
            border-radius: 0.75rem;
            outline: none;
            transition: all 0.3s ease;
            appearance: none;
            /* Flecha dinámica */
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 24 24' stroke='rgba(128,128,128,0.8)'%3E%3Cpath stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='M19 9l-7 7-7-7'%3E%3C/path%3E%3C/svg%3E");
            background-repeat: no-repeat;
            background-position: right 1rem center;
            background-size: 1rem;
        }
        
        .magic-input:focus {
            border-color: var(--theme-primary);
            box-shadow: 0 0 0 4px rgba(59, 130, 246, 0.1);
            background-color: var(--theme-card);
        }

        .magic-input option {
            background-color: var(--theme-background);
            color: var(--theme-text-main);
            padding: 10px;
        }

        .blobs-container {
            position: fixed;
            top: 0; left: 0; width: 100%; height: 100%;
            z-index: -1;
            overflow: hidden;
            pointer-events: none;
        }
        .blob1 {
            position: absolute; top: -10%; left: -10%;
            width: 50vw; height: 50vw;
            background: radial-gradient(circle, var(--theme-primary) 0%, transparent 60%);
            opacity: 0.2;
        }
        .blob2 {
            position: absolute; bottom: -10%; right: -10%;
            width: 50vw; height: 50vw;
            background: radial-gradient(circle, var(--theme-accent) 0%, transparent 60%);
            opacity: 0.2;
        }

        /* Accesibilidad - Daltonismo */
        .cb-protanopia { filter: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg"><filter id="f"><feColorMatrix type="matrix" values="0.567, 0.433, 0, 0, 0, 0.558, 0.442, 0, 0, 0, 0, 0.242, 0.758, 0, 0, 0, 0, 0, 1, 0"/></filter></svg>#f'); }
        .cb-deuteranopia { filter: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg"><filter id="f"><feColorMatrix type="matrix" values="0.625, 0.375, 0, 0, 0, 0.7, 0.3, 0, 0, 0, 0, 0.3, 0.7, 0, 0, 0, 0, 0, 1, 0"/></filter></svg>#f'); }
        .cb-tritanopia { filter: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg"><filter id="f"><feColorMatrix type="matrix" values="0.95, 0.05, 0, 0, 0, 0, 0.433, 0.567, 0, 0, 0, 0, 0.475, 0.525, 0, 0, 0, 0, 1, 0"/></filter></svg>#f'); }

        .reduce-motion .animate-blob, 
        .reduce-motion .animate-fade-in,
        .reduce-motion .animate-pulse-slow {
            animation: none !important;
            transition: none !important;
        }

        /* Clases de utilidad dinámicas */
        .text-main { color: var(--theme-text-main) !important; }
        .text-muted { color: var(--theme-text-muted) !important; }
    </style>
</head>
<body class="antialiased selection:bg-blue-500/30 selection:text-white transition-colors duration-500 <?= $colorblindClass ?> <?= $reducedMotionClass ?>">
    <!-- Background Magic blobs -->
    <div class="blobs-container">
        <div class="blob1 animate-blob duration-[10000ms]"></div>
        <div class="blob2 animate-blob duration-[12000ms]" style="animation-delay: 2s;"></div>
    </div>

    <!-- Navigation -->
    <nav class="sticky top-0 z-50 border-b border-border bg-background/70 backdrop-blur-xl">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-16">
                <div class="flex items-center gap-2">
                    <span class="text-xl font-bold bg-clip-text text-transparent bg-gradient-to-r from-blue-400 to-purple-500 cursor-default">
                        <?= defined('APP_NAME') ? APP_NAME : 'AntMaster Pro' ?>
                    </span>
                </div>
                <!-- Desktop Menu -->
                <div class="hidden md:flex items-center gap-6">
                    <a href="<?= BASE_URL ?>/" class="text-sm text-muted hover:text-main transition">Dashboard</a>
                    <a href="<?= BASE_URL ?>/colonias" class="text-sm text-muted hover:text-main transition">Colonias</a>
                    <a href="<?= BASE_URL ?>/especies" class="text-sm text-muted hover:text-main transition">Fichas de Cría</a>
                    <a href="<?= BASE_URL ?>/stock" class="text-sm text-muted hover:text-main transition">Stock</a>
                    <?php if (is_admin()): ?>
                        <a href="<?= BASE_URL ?>/admin/dashboard" class="px-3 py-2 text-muted hover:text-red-400 transition-colors flex items-center gap-1.5" title="Panel de Administración">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path></svg>
                        </a>
                        <a href="<?= BASE_URL ?>/admin/revisiones" class="px-3 py-2 text-muted hover:text-main transition-colors flex items-center gap-1.5" title="Revisiones Pendientes">
                            <svg class="w-5 h-5 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        </a>
                    <?php endif; ?>
                    
                    <a href="<?= BASE_URL ?>/logout" class="px-3 py-2 text-muted hover:text-main transition-colors" title="Cerrar Sesión">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path></svg>
                    </a>
                    
                    <a href="<?= BASE_URL ?>/settings" class="p-2 bg-white/5 border border-white/10 text-muted rounded-lg hover:text-main hover:bg-white/10 transition" title="Ajustes de Accesibilidad">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                    </a>
                </div>

                <!-- Mobile Header Icons -->
                <div class="flex md:hidden items-center gap-4">
                    <a href="<?= BASE_URL ?>/logout" class="p-2 text-muted hover:text-red-400">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path></svg>
                    </a>
                    <a href="<?= BASE_URL ?>/settings" class="p-2 text-muted hover:text-main">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                    </a>
                </div>
            </div>
        </div>
    </nav>

    <!-- Bottom Navigation Bar (Mobile Only) -->
    <div class="fixed bottom-0 left-0 right-0 z-[60] md:hidden">
        <!-- Blur Background -->
        <div class="absolute inset-x-0 bottom-0 h-24 bg-background/60 backdrop-blur-2xl border-t border-white/5 shadow-[0_-10px_30px_rgba(0,0,0,0.5)]"></div>
        
        <div class="relative flex items-center justify-around h-20 px-6 pb-2">
            <a href="<?= BASE_URL ?>/" class="group flex flex-col items-center gap-1">
                <div class="<?= current_url() == '/' ? 'text-blue-400 bg-blue-500/10' : 'text-zinc-500' ?> p-2 rounded-xl transition-all active:scale-90">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path></svg>
                </div>
                <span class="text-[9px] font-black uppercase tracking-widest <?= current_url() == '/' ? 'text-blue-400' : 'text-zinc-600' ?>">Inicio</span>
            </a>

            <a href="<?= BASE_URL ?>/colonias" class="group flex flex-col items-center gap-1">
                <div class="<?= str_contains(current_url(), '/colonias') ? 'text-emerald-400 bg-emerald-500/10' : 'text-zinc-500' ?> p-2 rounded-xl transition-all active:scale-90">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>
                </div>
                <span class="text-[9px] font-black uppercase tracking-widest <?= str_contains(current_url(), '/colonias') ? 'text-emerald-400' : 'text-zinc-600' ?>">Colonias</span>
            </a>

            <a href="<?= BASE_URL ?>/especies" class="group flex flex-col items-center gap-1">
                <div class="<?= str_contains(current_url(), '/especies') ? 'text-purple-400 bg-purple-500/10' : 'text-zinc-500' ?> p-2 rounded-xl transition-all active:scale-90">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.168.477 4 1.253m0-13C13.168 5.477 14.754 5 16.5 5S19.832 5.477 21 6.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4 1.253"></path></svg>
                </div>
                <span class="text-[9px] font-black uppercase tracking-widest <?= str_contains(current_url(), '/especies') ? 'text-purple-400' : 'text-zinc-600' ?>">Guías</span>
            </a>

            <a href="<?= BASE_URL ?>/stock" class="group flex flex-col items-center gap-1">
                <div class="<?= str_contains(current_url(), '/stock') ? 'text-orange-400 bg-orange-500/10' : 'text-zinc-500' ?> p-2 rounded-xl transition-all active:scale-90">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path></svg>
                </div>
                <span class="text-[9px] font-black uppercase tracking-widest <?= str_contains(current_url(), '/stock') ? 'text-orange-400' : 'text-zinc-600' ?>">Stock</span>
            </a>
        </div>
    </div>

    <!-- Main Content -->
    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 md:py-12 pb-32 md:pb-12 animate-fade-in relative z-10 min-h-[calc(100vh-4rem)]">
        <?= isset($content) ? $content : '' ?>
    </main>

</body>
</html>
