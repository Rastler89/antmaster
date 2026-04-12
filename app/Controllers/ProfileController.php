<?php
require_once '../app/Models/User.php';
require_once '../app/Models/Colony.php';
require_once '../app/Helpers/GamificationHelper.php';

class ProfileController extends Controller {
    
    /**
     * Ver perfil público
     */
    public function show($slug) {
        $user = User::findBySlug($slug);
        
        if (!$user) {
            $this->redirect('/');
        }

        // Obtener colonias públicas
        $colonies = Colony::query("
            SELECT c.*, e.nombre as especie_nombre 
            FROM colonias c
            LEFT JOIN especies e ON c.especie_id = e.id
            WHERE c.usuario_id = ? AND c.is_public = 1
        ", [$user->attributes['id']]);

        // Obtener logros conseguidos
        $badges = Database::getConnection()->prepare("
            SELECT l.*, lu.fecha_conseguido 
            FROM logros_usuarios lu
            JOIN logros l ON lu.logro_id = l.id
            WHERE lu.usuario_id = ?
            ORDER BY lu.fecha_conseguido DESC
        ");
        $badges->execute([$user->attributes['id']]);
        $userBadges = $badges->fetchAll();

        // Gravatar
        $emailHash = md5(strtolower(trim($user->attributes['email'])));
        $gravatarUrl = "https://www.gravatar.com/avatar/{$emailHash}?s=200&d=mp";

        $title = $user->attributes['nombre'] . ' | Perfil de Criador';
        $desc = "Perfil público de " . $user->attributes['nombre'] . ". Rango: " . $user->getRank() . " con " . $user->attributes['xp'] . " XP. Explorar colonias y logros en AntMaster Pro.";

        $json_ld = json_encode([
            "@context" => "https://schema.org",
            "@type" => "ProfilePage",
            "mainEntity" => [
                "@type" => "Person",
                "name" => $user->attributes['nombre'],
                "description" => $user->attributes['bio'] ?? '',
                "image" => $user->attributes['profile_image'] ?: $gravatarUrl,
                "interactionStatistic" => [
                    "@type" => "InteractionCounter",
                    "interactionType" => "https://schema.org/FollowAction",
                    "userInteractionCount" => $user->attributes['xp']
                ]
            ]
        ], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);

        $data = [
            'user' => $user->attributes,
            'rank' => $user->getRank(),
            'colonies' => $colonies,
            'badges' => $userBadges,
            'avatar' => $user->attributes['profile_image'] ?: $gravatarUrl,
            'title' => $title,
            'description' => $desc,
            'og_image' => $user->attributes['profile_image'] ?: $gravatarUrl,
            'og_type' => 'profile',
            'json_ld' => $json_ld,
            'xp' => $user->attributes['xp']
        ];

        $this->view('profile/show', $data);
    }

    /**
     * Editar perfil propio
     */
    public function edit() {
        require_login();
        
        $db = Database::getConnection();
        $stmt = $db->prepare("SELECT * FROM usuarios WHERE id = ?");
        $stmt->execute([$_SESSION['user_id']]);
        $user = $stmt->fetch();

        $data = [
            'user' => $user,
            'title' => 'Editar Perfil | AntMaster Pro'
        ];

        $this->view('profile/edit', $data);
    }

    /**
     * Guardar cambios del perfil
     */
    public function update() {
        require_login();
        
        $bio = $_POST['bio'] ?? '';
        $isPublic = isset($_POST['is_public']) ? 1 : 0;
        
        $db = Database::getConnection();
        $stmt = $db->prepare("UPDATE usuarios SET bio = ?, is_public = ? WHERE id = ?");
        
        if ($stmt->execute([$bio, $isPublic, $_SESSION['user_id']])) {
            $_SESSION['success'] = "Perfil actualizado correctamente.";
        } else {
            $_SESSION['error'] = "Error al actualizar el perfil.";
        }

        $this->redirect('/perfil/editar');
    }
}
