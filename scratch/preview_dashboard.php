<?php
// Mock data to simulate the dashboard without a real session
$stats = [
    'pending_revisions' => 1,
    'db_size' => '0.64 MB',
    'retention_rate' => 25,
    'users_today' => 5,
    'total_colonies' => 120,
    'avg_colonies_per_user' => 2.4,
    'avg_session_duration' => 600,
    'active_users' => 150,
    'total_users' => 500,
    'users_week' => 45,
    'draft_species_count' => 3,
    'server' => ['php_version' => '8.2.30']
];

class SessionTracker {
    public static function formatDuration($s) { return $s . 's'; }
}

function get_time_elapsed($d) { return '1h'; }

$chart_user_growth = ['labels' => ['Jan','Feb'], 'data' => [10, 20]];
$chart_user_growth = ['labels' => ['Jan','Feb'], 'data' => [10, 20]];
$chart_species_dist = ['labels' => ['Test'], 'data' => [100]];
$heatmap_data = array_fill(0, 24, 5);
$recent_events = [['type'=>'user_reg', 'description'=>'Test User', 'date'=>'2026-04-17']];
$users = [['id'=>1, 'nombre'=>'Admin', 'email'=>'admin@test.com', 'rol'=>'admin', 'is_banned'=>0, 'colonies_count'=>10, 'diary_count'=>50, 'last_login'=>'2026-04-17', 'avg_session'=>300]];

function __($key) { return $key; }
function asset($p) { return $p; }
function BASE_URL() { return ''; }
define('BASE_URL', '');
define('APP_LANG', 'es');
define('APP_NAME', 'AntMaster PRO');
define('APP_VERSION', '1.0');

ob_start();
include 'app/Views/admin/dashboard.php';
$content = ob_get_clean();

include 'app/Views/layouts/app.php';
