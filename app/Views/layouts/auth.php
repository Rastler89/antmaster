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
    <!-- Meta Tags -->
    <title><?= htmlspecialchars(($title ?? '') . ' - ' . APP_NAME) ?></title>
    <meta name="description" content="<?= htmlspecialchars($description ?? APP_DESCRIPTION) ?>">
    <meta name="keywords" content="<?= htmlspecialchars($keywords ?? APP_KEYWORDS) ?>">
    <meta name="author" content="AntMaster Team">
    <link rel="canonical" href="<?= (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]" ?>">

    <!-- Open Graph / Facebook -->
    <meta property="og:type" content="website">
    <meta property="og:url" content="<?= (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]" ?>">
    <meta property="og:title" content="<?= htmlspecialchars(($title ?? '') . ' - ' . APP_NAME) ?>">
    <meta property="og:description" content="<?= htmlspecialchars($description ?? APP_DESCRIPTION) ?>">
    <meta property="og:image" content="<?= asset(APP_IMAGE) ?>">

    <!-- Twitter -->
    <meta property="twitter:card" content="summary_large_image">
    <meta property="twitter:url" content="<?= (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]" ?>">
    <meta property="twitter:title" content="<?= htmlspecialchars(($title ?? '') . ' - ' . APP_NAME) ?>">
    <meta property="twitter:description" content="<?= htmlspecialchars($description ?? APP_DESCRIPTION) ?>">
    <meta property="twitter:image" content="<?= asset(APP_IMAGE) ?>">

    <!-- Tipografía: Outfit -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style><?= $themeVariables ?></style>
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            darkMode: 'class',
            theme: {
                extend: {
                    colors: {
                        background: '#09090b',
                        foreground: '#fafafa',
                        card: '#18181b',
                        border: '#27272a',
                        primary: '#3b82f6',
                    },
                    animation: {
                        'blob': 'blob 7s infinite',
                    },
                    keyframes: {
                        blob: {
                            '0%': { transform: 'translate(0px, 0px) scale(1)' },
                            '33%': { transform: 'translate(30px, -50px) scale(1.1)' },
                            '66%': { transform: 'translate(-20px, 20px) scale(0.9)' },
                            '100%': { transform: 'translate(0px, 0px) scale(1)' }
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
            font-family: 'Outfit', sans-serif;
            margin: 0;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: hidden;
            transition: background-color 0.3s ease, color 0.3s ease;
        }

        .glass-card {
            background: var(--theme-card);
            backdrop-filter: blur(16px);
            -webkit-backdrop-filter: blur(16px);
            border: 1px solid var(--theme-border);
            border-radius: 1.5rem;
            box-shadow: 0 4px 60px rgba(0, 0, 0, 0.8);
            position: relative;
            z-index: 10;
        }

        .magic-btn {
            position: relative;
            background: linear-gradient(90deg, var(--theme-primary), var(--theme-accent));
            color: white;
            border-radius: 9999px;
            padding: 0.75rem 1.5rem;
            font-weight: 500;
            width: 100%;
            overflow: hidden;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            border: none;
            cursor: pointer;
            transition: transform 0.2s ease;
        }
        
        .magic-btn:active {
            transform: scale(0.98);
        }

        .magic-input {
            width: 100%;
            background: rgba(0,0,0,0.1);
            border: 1px solid var(--theme-border);
            color: var(--theme-foreground);
            padding: 0.75rem 1rem;
            border-radius: 0.5rem;
            outline: none;
            transition: border-color 0.3s, box-shadow 0.3s;
        }
        
        .magic-input:focus {
            border-color: var(--theme-primary);
            box-shadow: 0 0 0 2px rgba(59, 130, 246, 0.2);
        }

        .magic-input option {
            background-color: var(--theme-background);
            color: var(--theme-foreground);
        }

        .blobs-container {
            position: fixed;
            top: 0; left: 0; width: 100%; height: 100%;
            z-index: 0;
            pointer-events: none;
        }
        
        .blob-center {
            position: absolute; top: 50%; left: 50%;
            width: 80vw; height: 80vw;
            box-shadow: inset 0 0 100px 100px rgba(59,130,246,0.1);
            background: radial-gradient(circle, var(--theme-primary) 15%, var(--theme-accent) 40%, transparent 60%);
            opacity: 0.15;
            transform: translate(-50%, -50%);
            border-radius: 50%;
        }

        /* Accesibilidad */
        .cb-protanopia { filter: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg"><filter id="f"><feColorMatrix type="matrix" values="0.567, 0.433, 0, 0, 0, 0.558, 0.442, 0, 0, 0, 0, 0.242, 0.758, 0, 0, 0, 0, 0, 1, 0"/></filter></svg>#f'); }
        .cb-deuteranopia { filter: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg"><filter id="f"><feColorMatrix type="matrix" values="0.625, 0.375, 0, 0, 0, 0.7, 0.3, 0, 0, 0, 0, 0.3, 0.7, 0, 0, 0, 0, 0, 1, 0"/></filter></svg>#f'); }
        .cb-tritanopia { filter: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg"><filter id="f"><feColorMatrix type="matrix" values="0.95, 0.05, 0, 0, 0, 0, 0.433, 0.567, 0, 0, 0, 0, 0.475, 0.525, 0, 0, 0, 0, 1, 0"/></filter></svg>#f'); }

        .reduce-motion .animate-blob { animation: none !important; }
    </style>
</head>
<body class="antialiased selection:bg-primary/30 selection:text-white relative transition-colors duration-500 <?= $colorblindClass ?> <?= $reducedMotionClass ?>">
    
    <div class="blobs-container">
        <div class="blob-center animate-blob duration-[15000ms]"></div>
    </div>

    <!-- Main Content -->
    <main class="w-full max-w-md px-4">
        <?= isset($content) ? $content : '' ?>
    </main>

</body>
</html>
