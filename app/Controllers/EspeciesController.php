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
    
    // Un POST con _method=PUT para resolver
    public function resolveRevision($id) {
        require_admin();
        
        $action = $_POST['action'] ?? 'rechazar';
        $revision = SpeciesRevision::find($id);
        
        if (!$revision || $revision['estado'] !== 'pendiente') {
            $this->redirect('/admin/revisiones');
        }
        
        if ($action === 'aprobar') {
            $cambios = json_decode($revision['cambios_solicitados'], true);
            // Actualizar la especie matriz en vivo
            Species::update($revision['especie_id'], $cambios);
            SpeciesRevision::update($id, ['estado' => 'aprobada']);
            $_SESSION['success'] = 'Revisión aprobada y ficha actualizada permanentemente.';
        } else {
            SpeciesRevision::update($id, ['estado' => 'rechazada']);
            $_SESSION['success'] = 'Revisión rechazada exitosamente.';
        }
        
        $this->redirect('/admin/revisiones');
    }
}
