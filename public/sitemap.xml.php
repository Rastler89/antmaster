<?php
require_once dirname(__DIR__) . '/config.php';
require_once dirname(__DIR__) . '/core/Database.php';

header("Content-Type: application/xml; charset=utf-8");
echo '<?xml version="1.0" encoding="UTF-8"?>' . PHP_EOL;

$available_langs = ['es', 'en', 'fr'];

/**
 * Helper to generate hreflang links for a given path
 */
function echo_hreflang($path) {
    global $available_langs;
    $full_path = rtrim(BASE_URL, '/') . '/' . ltrim($path, '/');
    
    // Original as x-default
    echo "        <xhtml:link rel=\"alternate\" hreflang=\"x-default\" href=\"" . htmlspecialchars($full_path) . "\" />\n";
    
    foreach ($available_langs as $lang) {
        $connector = (strpos($full_path, '?') === false) ? '?' : '&';
        $lang_url = $full_path . $connector . "lang=" . $lang;
        echo "        <xhtml:link rel=\"alternate\" hreflang=\"" . $lang . "\" href=\"" . htmlspecialchars($lang_url) . "\" />\n";
    }
}
?>
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9" xmlns:xhtml="http://www.w3.org/1999/xhtml">
    <!-- Static Routes -->
    <url>
        <loc><?= htmlspecialchars(BASE_URL) ?>/</loc>
        <?php echo_hreflang('/'); ?>
        <changefreq>daily</changefreq>
        <priority>1.0</priority>
    </url>
    <url>
        <loc><?= htmlspecialchars(BASE_URL) ?>/acerca-de</loc>
        <?php echo_hreflang('/acerca-de'); ?>
        <changefreq>monthly</changefreq>
        <priority>0.8</priority>
    </url>
    <url>
        <loc><?= htmlspecialchars(BASE_URL) ?>/guia-de-uso</loc>
        <?php echo_hreflang('/guia-de-uso'); ?>
        <changefreq>monthly</changefreq>
        <priority>0.8</priority>
    </url>
    <url>
        <loc><?= htmlspecialchars(BASE_URL) ?>/changelog</loc>
        <?php echo_hreflang('/changelog'); ?>
        <changefreq>weekly</changefreq>
        <priority>0.8</priority>
    </url>
    <url>
        <loc><?= htmlspecialchars(BASE_URL) ?>/especies</loc>
        <?php echo_hreflang('/especies'); ?>
        <changefreq>weekly</changefreq>
        <priority>0.9</priority>
    </url>

    <?php
    try {
        $db = Database::getConnection();

        // 1. Dynamic Species
        $stmtSpecies = $db->query("SELECT id FROM especies");
        while ($row = $stmtSpecies->fetch()) {
            $path = "/especies/ver/" . $row['id'];
            echo "    <url>\n";
            echo "        <loc>" . htmlspecialchars(BASE_URL . $path) . "</loc>\n";
            echo_hreflang($path);
            echo "        <changefreq>monthly</changefreq>\n";
            echo "        <priority>0.8</priority>\n";
            echo "    </url>\n";
        }

        // 2. Public Profiles
        $stmtUsers = $db->query("SELECT slug FROM usuarios WHERE is_public = 1");
        while ($row = $stmtUsers->fetch()) {
            if ($row['slug']) {
                $path = "/u/" . $row['slug'];
                echo "    <url>\n";
                echo "        <loc>" . htmlspecialchars(BASE_URL . $path) . "</loc>\n";
                echo_hreflang($path);
                echo "        <changefreq>weekly</changefreq>\n";
                echo "        <priority>0.7</priority>\n";
                echo "    </url>\n";
            }
        }

        // 3. Public Colonies
        $stmtColonies = $db->query("
            SELECT c.slug as colony_slug, u.slug as user_slug 
            FROM colonias c
            JOIN usuarios u ON c.usuario_id = u.id
            WHERE c.is_public = 1 AND c.slug IS NOT NULL AND u.slug IS NOT NULL
        ");
        while ($row = $stmtColonies->fetch()) {
            $path = "/log/" . $row['user_slug'] . "/" . $row['colony_slug'];
            echo "    <url>\n";
            echo "        <loc>" . htmlspecialchars(BASE_URL . $path) . "</loc>\n";
            echo_hreflang($path);
            echo "        <changefreq>daily</changefreq>\n";
            echo "        <priority>0.9</priority>\n";
            echo "    </url>\n";
        }
    } catch (Exception $e) {
        // Silently fail on DB error for sitemap
    }
    ?>
</urlset>
