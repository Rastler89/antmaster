<?php
require_once dirname(__DIR__) . '/config.php';
require_once dirname(__DIR__) . '/core/Database.php';

header("Content-Type: application/xml; charset=utf-8");
echo '<?xml version="1.0" encoding="UTF-8"?>' . PHP_EOL;
?>
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
    <!-- Static Routes -->
    <url>
        <loc><?= htmlspecialchars(BASE_URL) ?>/</loc>
        <changefreq>daily</changefreq>
        <priority>1.0</priority>
    </url>
    <url>
        <loc><?= htmlspecialchars(BASE_URL) ?>/acerca-de</loc>
        <changefreq>monthly</changefreq>
        <priority>0.8</priority>
    </url>
    <url>
        <loc><?= htmlspecialchars(BASE_URL) ?>/guia-de-uso</loc>
        <changefreq>monthly</changefreq>
        <priority>0.8</priority>
    </url>
    <url>
        <loc><?= htmlspecialchars(BASE_URL) ?>/changelog</loc>
        <changefreq>weekly</changefreq>
        <priority>0.8</priority>
    </url>
    <url>
        <loc><?= htmlspecialchars(BASE_URL) ?>/especies</loc>
        <changefreq>weekly</changefreq>
        <priority>0.9</priority>
    </url>

    <?php
    try {
        $db = Database::getConnection();

        // 1. Dynamic Species
        $stmtSpecies = $db->query("SELECT id FROM especies");
        while ($row = $stmtSpecies->fetch()) {
            echo "    <url>\n";
            echo "        <loc>" . htmlspecialchars(BASE_URL . "/especies/ver/" . $row['id']) . "</loc>\n";
            echo "        <changefreq>monthly</changefreq>\n";
            echo "        <priority>0.8</priority>\n";
            echo "    </url>\n";
        }

        // 2. Public Profiles
        $stmtUsers = $db->query("SELECT slug FROM usuarios WHERE is_public = 1");
        while ($row = $stmtUsers->fetch()) {
            if ($row['slug']) {
                echo "    <url>\n";
                echo "        <loc>" . htmlspecialchars(BASE_URL . "/u/" . $row['slug']) . "</loc>\n";
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
            echo "    <url>\n";
            echo "        <loc>" . htmlspecialchars(BASE_URL . "/log/" . $row['user_slug'] . "/" . $row['colony_slug']) . "</loc>\n";
            echo "        <changefreq>daily</changefreq>\n";
            echo "        <priority>0.9</priority>\n";
            echo "    </url>\n";
        }
    } catch (Exception $e) {
        // Silently fail on DB error for sitemap
    }
    ?>
</urlset>
