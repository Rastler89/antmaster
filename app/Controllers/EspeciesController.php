<?php
require_once '../app/Models/Species.php';
require_once '../app/Models/SpeciesRevision.php';

class EspeciesController extends Controller {
    public function index() {
        $json_ld = json_encode([
            "@context" => "https://schema.org",
            "@type" => "CollectionPage",
            "name" => "Fichas de Cría de Hormigas | AntMaster Pro",
            "description" => "Explora nuestra enciclopedia completa de especies de hormigas con cuidados, parámetros y consejos de cría."
        ], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);

        $data = [
            'especies' => Species::all(),
            'title'    => 'Fichas de Cría | AntMaster Pro',
            'description' => 'Explora nuestra enciclopedia completa de especies de hormigas con cuidados, parámetros y consejos de cría.',
            'og_type' => 'website',
            'json_ld' => $json_ld,
            'success'  => $_SESSION['success'] ?? '',
            'error'    => $_SESSION['error'] ?? ''
        ];
        
        unset($_SESSION['success'], $_SESSION['error']);
        $this->view('especies/index', $data);
    }

    public function show($id) {
        $species = Species::find($id);
        if (!$species) {
            $this->redirect('/especies');
        }
        
        $json_ld = json_encode([
            "@context" => "https://schema.org",
            "@type" => "Article",
            "headline" => "Guía de cría de " . $species['nombre_cientifico'],
            "description" => "Aprende todo sobre " . $species['nombre_cientifico'] . ": alimentación, temperatura, y biología.",
            "author" => [
                "@type" => "Organization",
                "name" => "AntMaster Pro"
            ]
        ], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);

        $data = [
            'especie' => $species,
            'title'   => $species['nombre_cientifico'] . ' (' . $species['nombre'] . ') | AntMaster Pro',
            'description' => 'Guía de cría completa para ' . $species['nombre_cientifico'] . '. Aprende sobre su alimentación, temperatura, humedad y cuidados específicos.',
            'og_type' => 'article',
            'json_ld' => $json_ld
        ];
        
        $this->view('especies/show', $data);
    }
    
    // User edits
    public function edit($id) {
        require_login();
        $species = Species::find($id);
        if (!$species) $this->redirect('/especies');
        
        $this->view('especies/edit', ['especie' => $species, 'title' => 'Sugerir Edición | AntMaster Pro']);
    }
    
    public function proposeEdit($id) {
        require_login();
        
        $campos = [
            'dificultad' => $_POST['dificultad'] ?? '',
            'temperatura' => $_POST['temperatura'] ?? '',
            'humedad' => $_POST['humedad'] ?? '',
            'velocidad_crecimiento' => $_POST['velocidad_crecimiento'] ?? '',
            'tamano' => $_POST['tamano'] ?? '',
            'castas' => $_POST['castas'] ?? '',
            'reproduccion' => $_POST['reproduccion'] ?? '',
            'localizacion' => $_POST['localizacion'] ?? '',
            'vuelos' => $_POST['vuelos'] ?? '',
            'descripcion' => $_POST['descripcion'] ?? '',
            'alimentacion' => $_POST['alimentacion'] ?? '',
            'consejos_cria' => $_POST['consejos_cria'] ?? ''
        ];
        
        $revision = [
            'usuario_id' => $_SESSION['user_id'],
            'especie_id' => $id,
            'cambios_solicitados' => json_encode($campos),
            'estado' => 'pendiente'
        ];
        
        if (SpeciesRevision::create($revision)) {
            $_SESSION['success'] = '¡Tu sugerencia ha sido enviada! Un administrador la revisará pronto.';
        } else {
            $_SESSION['error'] = 'Error al enviar la sugerencia.';
        }
        
        $this->redirect('/especies');
    }
    
    // Nueva especie logic
    public function proposeNew() {
        require_login();
        $this->view('especies/create', ['title' => 'Proponer Especie | AntMaster Pro']);
    }

    public function storeNewProposal() {
        require_login();

        $campos = [
            'nombre' => $_POST['nombre'] ?? '',
            'nombre_cientifico' => $_POST['nombre_cientifico'] ?? '',
            'dificultad' => $_POST['dificultad'] ?? '',
            'temperatura' => $_POST['temperatura'] ?? '',
            'humedad' => $_POST['humedad'] ?? '',
            'velocidad_crecimiento' => $_POST['velocidad_crecimiento'] ?? '',
            'tamano' => $_POST['tamano'] ?? '',
            'castas' => $_POST['castas'] ?? '',
            'reproduccion' => $_POST['reproduccion'] ?? '',
            'localizacion' => $_POST['localizacion'] ?? '',
            'vuelos' => $_POST['vuelos'] ?? '',
            'descripcion' => $_POST['descripcion'] ?? '',
            'alimentacion' => $_POST['alimentacion'] ?? '',
            'consejos_cria' => $_POST['consejos_cria'] ?? ''
        ];

        // Validar mínimos
        if (empty($campos['nombre']) || empty($campos['nombre_cientifico'])) {
            $_SESSION['error'] = 'El nombre común y científico son obligatorios.';
            $this->redirect('/especies/proponer');
        }

        // --- DETECCIÓN DE ESPECIE EXISTENTE ---
        // Si ya existe una especie con ese nombre científico, la tratamos como edición
        $existing = Species::whereOne('nombre_cientifico', $campos['nombre_cientifico']);
        $especie_id = $existing ? $existing['id'] : null;

        $revision = [
            'usuario_id' => $_SESSION['user_id'],
            'especie_id' => $especie_id, // NULL indica "especie nueva", ID indica "edición"
            'cambios_solicitados' => json_encode($campos),
            'estado' => 'pendiente'
        ];

        if (SpeciesRevision::create($revision)) {
            if ($especie_id) {
                $_SESSION['success'] = '¡Tu sugerencia de mejora para ' . $campos['nombre_cientifico'] . ' ha sido enviada!';
            } else {
                $_SESSION['success'] = '¡Tu propuesta de nueva especie ha sido enviada a revisión!';
            }
        } else {
            $_SESSION['error'] = 'Hubo un error al guardar tu propuesta.';
        }

        $this->redirect('/especies');
    }

    // Admin only
    public function pendingRevisions() {
        require_admin();
        
        $revisiones = SpeciesRevision::getPendingWithDetails();
        SpeciesRevision::enrichWithOriginalData($revisiones);

        $data = [
            'revisiones' => $revisiones,
            'title' => 'Panel de Revisiones | AntMaster Pro',
            'success'  => $_SESSION['success'] ?? '',
            'error'    => $_SESSION['error'] ?? ''
        ];
        
        unset($_SESSION['success'], $_SESSION['error']);
        $this->view('especies/pending', $data);
    }
    
    public function historyRevisions() {
        require_admin();
        
        $data = [
            'revisiones' => SpeciesRevision::getHistoryWithDetails(),
            'title' => 'Historial de Revisiones | AntMaster Pro',
        ];
        
        $this->view('especies/history', $data);
    }

    // Un POST con _method=PUT para resolver
    public function resolveRevision($id) {
        require_admin();
        
        $action = $_POST['action'] ?? 'rechazar';
        $motivo_rechazo = trim($_POST['motivo_rechazo'] ?? '');
        $revision = SpeciesRevision::find($id);
        
        if (!$revision || $revision['estado'] !== 'pendiente') {
            $this->redirect('/admin/revisiones');
        }
        
        if ($action === 'aprobar') {
            $cambios = json_decode($revision['cambios_solicitados'], true);
            
            if (is_null($revision['especie_id'])) {
                // Es una especie nueva
                Species::create($cambios);
                SpeciesRevision::update($id, ['estado' => 'aprobada']);
                $_SESSION['success'] = '¡Nueva especie aprobada y añadida al compendio!';
            } else {
                // Actualizar la especie matriz en vivo
                Species::update($revision['especie_id'], $cambios);
                SpeciesRevision::update($id, ['estado' => 'aprobada']);
                $_SESSION['success'] = 'Revisión aprobada y ficha actualizada permanentemente.';
            }

            // Gamificación: Otorgar XP al autor de la sugerencia
            require_once '../app/Helpers/GamificationHelper.php';
            GamificationHelper::addXP($revision['usuario_id'], 250);
            GamificationHelper::checkAndAwardBadges($revision['usuario_id']);
        } else {
            SpeciesRevision::update($id, [
                'estado' => 'rechazada',
                'motivo_rechazo' => $motivo_rechazo ?: null
            ]);
            $_SESSION['success'] = 'Revisión rechazada exitosamente.';
        }
        
        $this->redirect('/admin/revisiones');
    }
    public static function search() {
        require_login();
        $q = $_GET['q'] ?? '';
        $results = Species::search($q);
        header('Content-Type: application/json');
        echo json_encode($results);
        exit;
    }

    public function apiGetByScientificName() {
        require_login();
        $name = $_GET['name'] ?? '';
        
        $sql = "SELECT e.*, 
                       COALESCE(NULLIF(t.nombre, ''), e.nombre) as nombre,
                       COALESCE(NULLIF(t.descripcion, ''), e.descripcion) as descripcion,
                       COALESCE(NULLIF(t.alimentacion, ''), e.alimentacion) as alimentacion,
                       COALESCE(NULLIF(t.consejos_cria, ''), e.consejos_cria) as consejos_cria,
                       COALESCE(NULLIF(t.localizacion, ''), e.localizacion) as localizacion,
                       COALESCE(NULLIF(t.velocidad_crecimiento, ''), e.velocidad_crecimiento) as velocidad_crecimiento,
                       COALESCE(NULLIF(t.tamano, ''), e.tamano) as tamano,
                       COALESCE(NULLIF(t.castas, ''), e.castas) as castas,
                       COALESCE(NULLIF(t.reproduccion, ''), e.reproduccion) as reproduccion,
                       COALESCE(NULLIF(t.vuelos, ''), e.vuelos) as vuelos
                FROM especies e
                LEFT JOIN especies_traducciones t ON e.id = t.especie_id AND t.idioma = ?
                WHERE e.nombre_cientifico = ?
                LIMIT 1";
        
        $stmt = Database::getConnection()->prepare($sql);
        $stmt->execute([APP_LANG, $name]);
        $species = $stmt->fetch();

        header('Content-Type: application/json');
        echo json_encode($species ?: null);
        exit;
    }
}
