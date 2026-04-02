<?php
require_once '../app/Models/Species.php';
require_once '../app/Models/SpeciesRevision.php';

class EspeciesController extends Controller {
    public function index() {
        require_login();
        
        $data = [
            'especies' => Species::all(),
            'title'    => 'Fichas de Cría | AntMaster Pro',
            'success'  => $_SESSION['success'] ?? '',
            'error'    => $_SESSION['error'] ?? ''
        ];
        
        unset($_SESSION['success'], $_SESSION['error']);
        $this->view('especies/index', $data);
    }

    public function show($id) {
        require_login();
        
        $species = Species::find($id);
        if (!$species) {
            $this->redirect('/especies');
        }
        
        $data = [
            'especie' => $species,
            'title'   => $species['nombre_cientifico'] . ' | AntMaster Pro'
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

        $revision = [
            'usuario_id' => $_SESSION['user_id'],
            'especie_id' => null, // NULL indica "especie nueva"
            'cambios_solicitados' => json_encode($campos),
            'estado' => 'pendiente'
        ];

        if (SpeciesRevision::create($revision)) {
            $_SESSION['success'] = '¡Tu propuesta de nueva especie ha sido enviada a revisión!';
        } else {
            $_SESSION['error'] = 'Hubo un error al guardar tu propuesta.';
        }

        $this->redirect('/especies');
    }

    // Admin only
    public function pendingRevisions() {
        require_admin();
        
        $data = [
            'revisiones' => SpeciesRevision::getPendingWithDetails(),
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
        } else {
            SpeciesRevision::update($id, [
                'estado' => 'rechazada',
                'motivo_rechazo' => $motivo_rechazo ?: null
            ]);
            $_SESSION['success'] = 'Revisión rechazada exitosamente.';
        }
        
        $this->redirect('/admin/revisiones');
    }
}
