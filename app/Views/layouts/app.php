<html lang="<?= APP_LANG ?>" class="dark">
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
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <meta name="theme-color" content="#3b82f6">
    <link rel="manifest" href="/manifest.json">
    
    <!-- PWA iOS Support -->
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
    <meta name="apple-mobile-web-app-title" content="AntMaster">
    <link rel="apple-touch-icon" href="/assets/img/icon-192.png">

    <!-- Meta Tags -->
    <title><?= htmlspecialchars(($title ?? '') . ' - ' . APP_NAME) ?></title>
    <meta name="description" content="<?= htmlspecialchars($description ?? APP_DESCRIPTION) ?>">
    <meta name="keywords" content="<?= htmlspecialchars($keywords ?? APP_KEYWORDS) ?>">
    <meta name="author" content="AntMaster Team">
    <link rel="canonical" href="<?= (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]" ?>">

    <!-- Open Graph / Facebook -->
    <meta property="og:type" content="<?= htmlspecialchars($og_type ?? 'website') ?>">
    <meta property="og:url" content="<?= htmlspecialchars($og_url ?? (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]") ?>">
    <meta property="og:title" content="<?= htmlspecialchars(($title ?? '') . ' - ' . APP_NAME) ?>">
    <meta property="og:description" content="<?= htmlspecialchars($description ?? APP_DESCRIPTION) ?>">
    <meta property="og:image" content="<?= htmlspecialchars($og_image ?? asset(APP_IMAGE)) ?>">

    <!-- Twitter -->
    <meta property="twitter:card" content="summary_large_image">
    <meta property="twitter:url" content="<?= htmlspecialchars($og_url ?? (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]") ?>">
    <meta property="twitter:title" content="<?= htmlspecialchars(($title ?? '') . ' - ' . APP_NAME) ?>">
    <meta property="twitter:description" content="<?= htmlspecialchars($description ?? APP_DESCRIPTION) ?>">
    <meta property="twitter:image" content="<?= htmlspecialchars($og_image ?? asset(APP_IMAGE)) ?>">

    <!-- Localización y SEO -->
    <link rel="alternate" hreflang="es" href="<?= htmlspecialchars(BASE_URL . parse_url($_SERVER["REQUEST_URI"], PHP_URL_PATH) . '?lang=es') ?>" />
    <link rel="alternate" hreflang="en" href="<?= htmlspecialchars(BASE_URL . parse_url($_SERVER["REQUEST_URI"], PHP_URL_PATH) . '?lang=en') ?>" />
    <link rel="alternate" hreflang="fr" href="<?= htmlspecialchars(BASE_URL . parse_url($_SERVER["REQUEST_URI"], PHP_URL_PATH) . '?lang=fr') ?>" />
    <link rel="alternate" hreflang="x-default" href="<?= htmlspecialchars(BASE_URL . parse_url($_SERVER["REQUEST_URI"], PHP_URL_PATH)) ?>" />

    <!-- Tipografía: Outfit -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="preload" as="style" href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700&display=swap">
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style><?= $themeVariables ?></style>
    <!-- Tailwind CSS Precompilado y Optimizado (Lighthouse) -->
    <link rel="preload" href="<?= asset('assets/css/tailwind.css') . '?v=' . APP_VERSION ?>" as="style">
    <link rel="stylesheet" href="<?= asset('assets/css/tailwind.css') . '?v=' . APP_VERSION ?>" media="print" onload="this.media='all'">
    <noscript><link rel="stylesheet" href="<?= asset('assets/css/tailwind.css') . '?v=' . APP_VERSION ?>"></noscript>
    
    <?php if (isset($json_ld)): ?>
    <!-- Structured Data -->
    <script type="application/ld+json">
        <?= $json_ld ?>
    </script>
    <?php endif; ?>
    <script>
        window.VAPID_PUBLIC_KEY = "<?= defined('VAPID_PUBLIC_KEY') ? VAPID_PUBLIC_KEY : '' ?>";
    </script>
    <style>
        body {
            background-color: var(--theme-background);
            color: var(--theme-foreground);
            font-family: 'Outfit', sans-serif;
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
            top: 0; left: 0; width: 100%; height: 100%;
            transform: translateX(-100%);
            background: linear-gradient(90deg, transparent, rgba(255,255,255,0.2), transparent);
            transition: transform 0.5s;
        }

        .magic-btn:hover::before {
            transform: translateX(100%);
        }

        .magic-input {
            width: 100%;
            background: rgba(255, 255, 255, 0.03) !important;
            border: 1px solid rgba(255, 255, 255, 0.08) !important;
            color: white !important;
            padding: 0.85rem 1.25rem;
            padding-right: 2.5rem !important;
            border-radius: 1.25rem !important;
            outline: none !important;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            appearance: none !important;
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 24 24' stroke='rgba(255,255,255,0.4)' stroke-width='3'%3E%3Cpath stroke-linecap='round' stroke-linejoin='round' d='M19 9l-7 7-7-7'/%3E%3C/svg%3E") !important;
            background-repeat: no-repeat !important;
            background-position: right 1.25rem center !important;
            background-size: 0.75rem !important;
            cursor: pointer;
        }
        
        .magic-input:focus {
            border-color: var(--theme-primary) !important;
            box-shadow: 0 0 0 4px rgba(59, 130, 246, 0.15) !important;
            background-color: rgba(255, 255, 255, 0.05) !important;
            transform: translateY(-1px);
        }

        .magic-input option {
            background-color: #18181b; /* Zinc 900 */
            color: white;
            padding: 1rem;
            border: none;
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
    <!-- Background Magic blobs (Decorativo) -->
    <div class="blobs-container" aria-hidden="true">
        <div class="blob1 animate-blob duration-[10000ms]"></div>
        <div class="blob2 animate-blob duration-[12000ms]" style="animation-delay: 2s;"></div>
    </div>

    <!-- Navigation -->
    <nav class="sticky top-0 z-50 border-b border-border bg-background/70 backdrop-blur-xl">
        <div class="max-w-[90rem] mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-16">
                <div class="flex items-center gap-3">
                    <a href="<?= BASE_URL ?>/" class="flex items-center gap-2 group">
                        <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-blue-500 to-purple-600 p-0.5 shadow-lg shadow-blue-500/20 group-hover:scale-110 transition-transform">
                            <div class="w-full h-full bg-background rounded-[10px] flex items-center justify-center overflow-hidden">
                                <img src="<?= asset('assets/img/logo.webp') ?>" alt="AntMaster" class="w-8 h-8 object-contain" width="32" height="32" decoding="async">
                            </div>
                        </div>
                        <span class="text-xl font-bold bg-clip-text text-transparent bg-gradient-to-r from-blue-400 to-purple-500 tracking-tight">
                            <?= APP_NAME ?>
                        </span>
                    </a>
                </div>
                <!-- Desktop Menu -->
                <div class="hidden md:flex items-center gap-6">
                    <!-- Language Switcher -->
                    <div class="flex items-center gap-1 bg-white/5 p-1 rounded-lg border border-white/10 mr-2" aria-label="<?= __('nav_lang_selector') ?>">
                        <a href="?lang=es" aria-label="Español" class="px-2 py-0.5 text-[10px] font-black rounded <?= APP_LANG == 'es' ? 'bg-blue-500 text-white' : 'text-zinc-400 hover:text-white' ?>">ES</a>
                        <a href="?lang=en" aria-label="English" class="px-2 py-0.5 text-[10px] font-black rounded <?= APP_LANG == 'en' ? 'bg-blue-500 text-white' : 'text-zinc-400 hover:text-white' ?>">EN</a>
                        <a href="?lang=fr" aria-label="Français" class="px-2 py-0.5 text-[10px] font-black rounded <?= APP_LANG == 'fr' ? 'bg-blue-500 text-white' : 'text-zinc-400 hover:text-white' ?>">FR</a>
                    </div>

                    <!-- PWA Status Indicator -->
                    <div id="pwa-status-indicator" class="mr-2"></div>

                    <?php if (is_logged_in()): ?>
                        <?php 
                            // Obtener datos frescos del usuario para la navegación
                            require_once '../app/Models/User.php';
                            $navUser = User::find($_SESSION['user_id']);
                            $navRank = $navUser ? (new User($navUser))->getRank() : 'Hormiga';
                        ?>
                        <div class="hidden lg:flex flex-col items-end mr-2">
                            <span class="text-[9px] font-black uppercase tracking-widest text-blue-400 leading-none mb-0.5"><?= $navRank ?></span>
                            <span class="text-[8px] font-bold text-zinc-600 leading-none"><?= $navUser['xp'] ?? 0 ?> XP</span>
                        </div>

                        <a href="<?= BASE_URL ?>/" class="text-sm text-muted hover:text-main transition"><?= __('nav_dashboard') ?></a>
                        <a href="<?= BASE_URL ?>/colonias" class="text-sm text-muted hover:text-main transition"><?= __('nav_colonies') ?></a>
                        <a href="<?= BASE_URL ?>/especies" class="text-sm text-muted hover:text-main transition"><?= __('nav_species') ?></a>
                        <a href="<?= BASE_URL ?>/stock" class="text-sm text-muted hover:text-main transition"><?= __('nav_stock') ?></a>
                        <?php if (is_admin()): ?>
                            <a href="<?= BASE_URL ?>/admin/dashboard" aria-label="<?= __('nav_admin_panel') ?>" class="px-3 py-2 text-muted hover:text-red-400 transition-colors flex items-center gap-1.5" title="<?= __('nav_admin_panel') ?>">
                                <svg class="w-5 h-5 pointer-events-none" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path></svg>
                            </a>
                        <?php endif; ?>
                        
                        <a href="<?= BASE_URL ?>/perfil/editar" aria-label="<?= __('nav_profile') ?>" class="p-2 bg-white/5 border border-white/10 text-muted rounded-lg hover:text-main hover:bg-white/10 transition" title="<?= __('nav_profile') ?>">
                            <svg class="w-5 h-5 pointer-events-none" aria-hidden="true" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                        </a>

                        <a href="<?= BASE_URL ?>/settings" aria-label="<?= __('nav_settings') ?>" class="p-2 bg-white/5 border border-white/10 text-muted rounded-lg hover:text-main hover:bg-white/10 transition" title="<?= __('nav_settings') ?>">
                            <svg class="w-5 h-5 pointer-events-none" aria-hidden="true" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                        </a>

                        <a href="<?= BASE_URL ?>/logout" aria-label="<?= __('nav_logout') ?>" class="px-3 py-2 text-muted hover:text-red-400 transition-colors" title="<?= __('nav_logout') ?>">
                            <svg class="w-5 h-5 pointer-events-none" aria-hidden="true" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path></svg>
                        </a>
                    <?php else: ?>
                        <a href="<?= BASE_URL ?>/login" class="text-sm font-medium text-muted hover:text-main transition"><?= __('nav_login') ?></a>
                        <a href="<?= BASE_URL ?>/register" class="magic-btn text-sm"><?= __('nav_register') ?></a>
                    <?php endif; ?>
                </div>

                <!-- Mobile Header Icons -->
                <div class="flex md:hidden items-center gap-4">
                    <?php if (is_logged_in()): ?>
                        <a href="<?= BASE_URL ?>/logout" aria-label="<?= __('nav_logout') ?>" class="p-2 text-muted hover:text-red-400">
                            <svg class="w-5 h-5" aria-hidden="true" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path></svg>
                        </a>
                        <a href="<?= BASE_URL ?>/settings" aria-label="<?= __('nav_settings') ?>" class="p-2 text-muted hover:text-main">
                            <svg class="w-5 h-5" aria-hidden="true" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                        </a>
                    <?php else: ?>
                        <a href="<?= BASE_URL ?>/login" class="text-xs font-bold text-muted uppercase tracking-widest"><?= __('nav_login') ?></a>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </nav>

    <!-- Bottom Navigation Bar (Mobile Only) -->
    <?php if (is_logged_in()): ?>
    <div class="fixed bottom-0 left-0 right-0 z-[60] md:hidden">
        <!-- Blur Background -->
        <div class="absolute inset-x-0 bottom-0 h-24 bg-background/60 backdrop-blur-2xl border-t border-white/5 shadow-[0_-10px_30px_rgba(0,0,0,0.5)]"></div>
        
        <div class="relative flex items-center justify-around h-20 px-6 pb-2">
            <a href="<?= BASE_URL ?>/" class="group flex flex-col items-center gap-1">
                <div class="<?= current_url() == '/' ? 'text-blue-400 bg-blue-500/10' : 'text-zinc-500' ?> p-2 rounded-xl transition-all active:scale-90">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path></svg>
                </div>
                <span class="text-[9px] font-black uppercase tracking-widest <?= current_url() == '/' ? 'text-blue-400' : 'text-zinc-600' ?>"><?= __('nav_home') ?></span>
            </a>

            <a href="<?= BASE_URL ?>/colonias" class="group flex flex-col items-center gap-1">
                <div class="<?= str_contains(current_url(), '/colonias') ? 'text-emerald-400 bg-emerald-500/10' : 'text-zinc-500' ?> p-2 rounded-xl transition-all active:scale-90">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>
                </div>
                <span class="text-[9px] font-black uppercase tracking-widest <?= str_contains(current_url(), '/colonias') ? 'text-emerald-400' : 'text-zinc-600' ?>"><?= __('nav_colonies') ?></span>
            </a>

            <a href="<?= BASE_URL ?>/especies" class="group flex flex-col items-center gap-1">
                <div class="<?= str_contains(current_url(), '/especies') ? 'text-purple-400 bg-purple-500/10' : 'text-zinc-500' ?> p-2 rounded-xl transition-all active:scale-90">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.168.477 4 1.253m0-13C13.168 5.477 14.754 5 16.5 5S19.832 5.477 21 6.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4 1.253"></path></svg>
                </div>
                <span class="text-[9px] font-black uppercase tracking-widest <?= str_contains(current_url(), '/especies') ? 'text-purple-400' : 'text-zinc-600' ?>"><?= __('nav_species') ?></span>
            </a>

            <a href="<?= BASE_URL ?>/stock" class="group flex flex-col items-center gap-1">
                <div class="<?= str_contains(current_url(), '/stock') ? 'text-orange-400 bg-orange-500/10' : 'text-zinc-500' ?> p-2 rounded-xl transition-all active:scale-90">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path></svg>
                </div>
                <span class="text-[9px] font-black uppercase tracking-widest <?= str_contains(current_url(), '/stock') ? 'text-orange-400' : 'text-zinc-600' ?>"><?= __('nav_stock') ?></span>
            </a>
        </div>
    </div>
    <?php endif; ?>

    <!-- Main Content -->
    <main class="max-w-[90rem] mx-auto px-4 sm:px-6 lg:px-8 py-8 md:py-12 pb-32 md:pb-12 animate-fade-in relative z-10 min-h-[calc(100vh-4rem)]">
        <?php if (isset($_SESSION['error'])): ?>
            <div class="mb-6 p-4 bg-red-500/10 border border-red-500/20 rounded-2xl flex items-center gap-3 animate-fade-in">
                <span class="p-2 bg-red-500/20 rounded-lg text-red-400">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                </span>
                <p class="text-sm font-medium text-red-200"><?= $_SESSION['error']; unset($_SESSION['error']); ?></p>
            </div>
        <?php endif; ?>

        <?php if (isset($_SESSION['success'])): ?>
            <div class="mb-6 p-4 bg-emerald-500/10 border border-emerald-500/20 rounded-2xl flex items-center gap-3 animate-fade-in">
                <span class="p-2 bg-emerald-500/20 rounded-lg text-emerald-400">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                </span>
                <p class="text-sm font-medium text-emerald-200"><?= $_SESSION['success']; unset($_SESSION['success']); ?></p>
            </div>
        <?php endif; ?>

        <?= isset($content) ? $content : '' ?>
    </main>



    <!-- Footer -->
    <footer class="mt-auto py-12 border-t border-white/5 bg-zinc-950/20 backdrop-blur-md relative z-10">
        <div class="max-w-[90rem] mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-12">
                <div class="col-span-1 md:col-span-2">
                    <div class="flex items-center gap-3 mb-6">
                        <div class="w-8 h-8 rounded-lg bg-gradient-to-br from-blue-500 to-purple-600 p-0.5">
                            <div class="w-full h-full bg-background rounded-[7px] flex items-center justify-center overflow-hidden">
                                <img src="<?= asset('assets/img/logo.webp') ?>" alt="AntMaster" class="w-6 h-6 object-contain" width="24" height="24" loading="lazy" decoding="async">
                            </div>
                        </div>
                        <span class="text-xl font-bold bg-clip-text text-transparent bg-gradient-to-r from-blue-400 to-purple-500">
                            <?= APP_NAME ?>
                        </span>
                    </div>
                    <p class="text-sm text-zinc-500 max-w-sm mb-6 leading-relaxed">
                        <?= __('footer_desc') ?>
                    </p>
                    <div class="flex items-center gap-4">
                        <a href="https://rastler.dev" target="_blank" class="text-zinc-500 hover:text-blue-400 transition-colors">
                            <span class="text-xs font-black uppercase tracking-widest">rastler.dev</span>
                        </a>
                        <span class="text-zinc-800">|</span>
                        <span class="text-xs text-zinc-600">v<?= APP_VERSION ?></span>
                    </div>
                </div>
                
                <div>
                    <h4 class="text-xs font-black uppercase tracking-widest text-white mb-6"><?= __('footer_explore') ?></h4>
                    <ul class="space-y-4">
                        <li><a href="<?= BASE_URL ?>/acerca-de" class="text-sm text-zinc-500 hover:text-white transition-colors"><?= __('footer_about') ?></a></li>
                        <li><a href="<?= BASE_URL ?>/guia-de-uso" class="text-sm text-zinc-500 hover:text-white transition-colors"><?= __('footer_usage') ?></a></li>
                        <li><a href="<?= BASE_URL ?>/changelog" class="text-sm text-zinc-500 hover:text-white transition-colors"><?= __('footer_changelog') ?></a></li>
                    </ul>
                </div>

                <div>
                    <h4 class="text-xs font-black uppercase tracking-widest text-white mb-6"><?= __('footer_community') ?></h4>
                    <div class="space-y-4">
                        <p class="text-xs text-zinc-600 leading-relaxed italic">
                            "<?= __('footer_passion') ?>"
                        </p>
                        <div class="pt-2">
                             <a href="https://ko-fi.com/rastler" target="_blank" class="inline-flex items-center gap-3 px-5 py-3 bg-[#00b9fe] hover:bg-[#00a2e0] text-white rounded-[1.2rem] text-[10px] font-black uppercase tracking-widest transition-all shadow-xl shadow-blue-500/10 active:scale-95">
                                <img src="https://ko-fi.com/img/cup-border.png" alt="Ko-fi" class="w-4 h-4 brightness-0 invert" width="16" height="16" loading="lazy" decoding="async">
                                <?= __('footer_support') ?>
                             </a>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="mt-12 pt-8 border-t border-white/5 flex flex-col md:flex-row justify-between items-center gap-4">
                <p class="text-[10px] text-zinc-600 uppercase font-black tracking-widest">
                    <?= __('footer_rights', ['year' => date('Y'), 'name' => 'Rastler']) ?>
                </p>
                <div class="flex items-center gap-6">
                    <span class="text-[10px] text-emerald-500 bg-emerald-500/10 px-2 py-0.5 rounded border border-emerald-500/20 font-black"><?= __('footer_online') ?></span>
                </div>
            </div>
        </div>
    </footer>

    <!-- Global JS for Dismissible Help Sections -->
    <script>
    document.addEventListener('DOMContentLoaded', function() {
        const helpSections = document.querySelectorAll('[data-help-id]');
        
        helpSections.forEach(section => {
            const helpId = section.getAttribute('data-help-id');
            if (localStorage.getItem('help_dismissed_' + helpId)) {
                section.style.display = 'none';
            }
        });

        window.dismissHelp = function(helpId) {
            const section = document.querySelector(`[data-help-id="${helpId}"]`);
            if (section) {
                section.classList.add('opacity-0', 'scale-95');
                setTimeout(() => {
                    section.style.display = 'none';
                    localStorage.setItem('help_dismissed_' + helpId, 'true');
                }, 300);
            }
        };
    });
    </script>
    <!-- PWA Scripts -->
    <script src="<?= asset('assets/js/pwa-db.js') ?>" defer></script>
    <script src="<?= asset('assets/js/pwa-main.js') ?>" defer></script>
    <script>
        if ('serviceWorker' in navigator) {
            window.addEventListener('load', () => {
                navigator.serviceWorker.register('/sw.js')
                    .then(reg => console.log('AntMaster Pro SW: Registrado.', reg.scope))
                    .catch(err => console.error('AntMaster Pro SW: Error.', err));
            });
        }
    </script>
</body>
</html>
