<?php
require_once '../app/Models/Colony.php';
require_once '../app/Models/Species.php';
require_once '../app/Models/Stock.php';

class ColonyController extends Controller {
    public function index() {
        require_login();
        
        $data = [
            'colonies' => Colony::getUserColonies($_SESSION['user_id']),
            'title'    => 'Mis Colonias | AntMaster Pro'
        ];
        
        $this->view('colony/index', $data);
    }
    
    public function create() {
        require_login();
        
        $data = [
            'species' => Species::all(),
            'title'   => 'Nueva Colonia | AntMaster Pro'
        ];
        
        $this->view('colony/create', $data);
    }
    
    public function store() {
        require_login();
        
        $imagePath = null;
        if (isset($_FILES['imagen']) && $_FILES['imagen']['error'] === UPLOAD_ERR_OK) {
            $uploadDir = 'uploads/colonies/';
            $extension = pathinfo($_FILES['imagen']['name'], PATHINFO_EXTENSION);
            $filename = uniqid() . '.' . $extension;
            if (move_uploaded_file($_FILES['imagen']['tmp_name'], $uploadDir . $filename)) {
                $imagePath = $filename;
            }
        }

        $poblacionDetallada = null;
        $totalPoblacion = (int)($_POST['poblacion_actual'] ?? 0);

        if (isset($_POST['usar_castas']) && $_POST['usar_castas'] == '1') {
            $castas = $_POST['casta'] ?? [];
            $totalPoblacion = array_sum(array_map('intval', $castas));
            $poblacionDetallada = json_encode($castas);
        }

        $data = [
            'usuario_id'         => $_SESSION['user_id'],
            'nombre'             => $_POST['nombre'] ?? '',
            'especie_id'         => $_POST['especie_id'] ?? '',
            'fecha_adquisicion'  => $_POST['fecha_adquisicion'] ?? date('Y-m-d'),
            'tipo_hormiguero'    => $_POST['tipo_hormiguero'] ?? '',
            'descripcion'        => $_POST['descripcion'] ?? '',
            'poblacion_actual'   => $totalPoblacion,
            'imagen'             => $imagePath,
            'poblacion_detallada'=> $poblacionDetallada
        ];
        
        if (Colony::create($data)) {
            $this->redirect('/colonias');
        } else {
            $this->redirect('/colonias/nueva');
        }
    }
    
    public function show($id) {
        require_login();
        
        $colony = Colony::findWithSpecies($id, $_SESSION['user_id']);
        
        if (!$colony) {
            $this->redirect('/');
        }
        
        $history = Colony::getHistory($id);
        $diary = Colony::getDiary($id);
        
        // Obtener media de la especie para Benchmarking
        $averageHistory = Colony::getSpeciesAverageHistory($colony['especie_id']);
        
        // Calcular tendencia
        $trend = 0;
        if (count($history) >= 2) {
            $last = $history[count($history)-1]['poblacion'];
            $prev = $history[count($history)-2]['poblacion'];
            if ($prev > 0) {
                $trend = (($last - $prev) / $prev) * 100;
            }
        }
        
        // Obtener slug del usuario para el enlace público
        $user = Colony::query("SELECT slug FROM usuarios WHERE id = ?", [$_SESSION['user_id']]);
        $userSlug = $user[0]['slug'];

        $data = [
            'colony'  => $colony,
            'history' => $history,
            'diary'   => $diary,
            'stocks'  => Stock::where('usuario_id', '=', $_SESSION['user_id']),
            'trend'   => $trend,
            'userSlug'=> $userSlug,
            'averageHistory' => $averageHistory,
            'title'   => $colony['nombre'] . ' | AntMaster Pro'
        ];
        
        $this->view('colony/show', $data);
    }

    public function togglePublic($id) {
        require_login();
        $colony = Colony::find($id);
        if ($colony && $colony['usuario_id'] == $_SESSION['user_id']) {
            $isPublic = (int)($_POST['is_public'] ?? 0);
            Colony::togglePublic($id, $isPublic);
        }
        $this->redirect('/colonias/ver/' . $id);
    }

    public function toggleDiaryVisibility($id) {
        require_login();
        // Verificar que la entrada pertenezca a una colonia del usuario
        $result = Colony::query("
            SELECT d.id FROM diario d 
            JOIN colonias c ON d.colonia_id = c.id 
            WHERE d.id = ? AND c.usuario_id = ?
        ", [$id, $_SESSION['user_id']]);

        if ($result) {
            $isVisible = (int)($_POST['is_visible'] ?? 1);
            Colony::toggleDiaryVisibility($id, $isVisible);
        }
        // Redirigir de vuelta a la colonia (necesitamos el ID de la colonia)
        $res = Colony::query("SELECT colonia_id FROM diario WHERE id = ?", [$id]);
        $colonyId = $res[0]['colony_id'] ?? $res[0]['colonia_id'];
        $this->redirect('/colonias/ver/' . $colonyId);
    }

    public function addDiary($id) {
        require_login();
        
        $colony = Colony::find($id);
        if (!$colony || $colony['usuario_id'] != $_SESSION['user_id']) {
            $this->redirect('/colonias');
        }

        $imagePath = null;
        if (isset($_FILES['imagen']) && $_FILES['imagen']['error'] === UPLOAD_ERR_OK) {
            $uploadDir = 'uploads/diary/';
            $extension = pathinfo($_FILES['imagen']['name'], PATHINFO_EXTENSION);
            $filename = uniqid() . '.' . $extension;
            if (move_uploaded_file($_FILES['imagen']['tmp_name'], $uploadDir . $filename)) {
                $imagePath = $filename;
            }
        }

        $tipoEvento = $_POST['tipo_evento'] ?? 'Observación';
        $stockId = $_POST['stock_id'] ?? null;
        $cantidadUsada = $_POST['cantidad_usada'] ?? 0;

        // Lógica de Stock para Alimentación
        if ($tipoEvento === 'Alimentación' && !empty($stockId)) {
            $stock = Stock::whereOne('id', '=', $stockId);
            if ($stock && $stock['usuario_id'] == $_SESSION['user_id']) {
                if ($stock['cantidad'] >= $cantidadUsada) {
                    $nuevaCantidad = $stock['cantidad'] - $cantidadUsada;
                    Stock::update($stockId, ['cantidad' => $nuevaCantidad]);
                } else {
                    // Si llega aquí es un bypass de la JS, pero mejor prevenir
                    $_SESSION['error'] = 'No hay suficiente stock para esta alimentación.';
                    $this->redirect('/colonias/ver/' . $id);
                    return;
                }
            }
        }

        $data = [
            'tipo_evento'   => $tipoEvento,
            'stock_id'      => $stockId,
            'cantidad_usada'=> $cantidadUsada > 0 ? $cantidadUsada : null,
            'entrada'       => $_POST['entrada'] ?? '',
            'fecha_entrada' => $_POST['fecha_entrada'] ?? date('Y-m-d'),
            'imagen_url'    => $imagePath
        ];
        
        Colony::addDiaryEntry($id, $data);
        
        $this->redirect('/colonias/ver/' . $id);
    }

    public function addPopulation($id) {
        require_login();
        
        $colony = Colony::find($id);
        if (!$colony || $colony['usuario_id'] != $_SESSION['user_id']) {
            $this->redirect('/colonias');
        }

        $poblacionDetallada = null;
        $totalPoblacion = (int)($_POST['poblacion'] ?? 0);

        // Si la colonia ya tenía castas, esperamos castas en el POST
        if ($colony['poblacion_detallada']) {
            $castas = $_POST['casta'] ?? [];
            $totalPoblacion = array_sum(array_map('intval', $castas));
            $poblacionDetallada = json_encode($castas);
        }
        
        if ($totalPoblacion >= 0) {
            // Guardar en historial (ahora con detalles)
            Colony::addHistory($id, $totalPoblacion, $poblacionDetallada);
            
            // Actualizar tabla principal
            $updateData = ['poblacion_actual' => $totalPoblacion];
            if ($poblacionDetallada) {
                $updateData['poblacion_detallada'] = $poblacionDetallada;
            }
            Colony::update($id, $updateData);
        }
        
        $this->redirect('/colonias/ver/' . $id);
    }

    public function edit($id) {
        require_login();
        
        $colony = Colony::find($id);
        
        // Verificar dueño
        if (!$colony || $colony['usuario_id'] != $_SESSION['user_id']) {
            $this->redirect('/colonias');
        }
        
        $data = [
            'colony'  => $colony,
            'species' => Species::all(),
            'title'   => 'Editar ' . $colony['nombre'] . ' | AntMaster Pro'
        ];
        
        $this->view('colony/edit', $data);
    }

    public function update($id) {
        require_login();
        
        $colony = Colony::find($id);
        if (!$colony || $colony['usuario_id'] != $_SESSION['user_id']) {
            $this->redirect('/colonias');
        }

        $imagePath = $colony['imagen'];
        if (isset($_FILES['imagen']) && $_FILES['imagen']['error'] === UPLOAD_ERR_OK) {
            $uploadDir = 'uploads/colonies/';
            $extension = pathinfo($_FILES['imagen']['name'], PATHINFO_EXTENSION);
            $filename = uniqid() . '.' . $extension;
            if (move_uploaded_file($_FILES['imagen']['tmp_name'], $uploadDir . $filename)) {
                // Opcional: Borrar imagen vieja si existe
                /*
                if ($colony['imagen'] && file_exists($uploadDir . $colony['imagen'])) {
                    @unlink($uploadDir . $colony['imagen']);
                }
                */
                $imagePath = $filename;
            }
        }

        $poblacionDetallada = null;
        $totalPoblacion = (int)($_POST['poblacion_actual'] ?? 0);

        if (isset($_POST['usar_castas']) && $_POST['usar_castas'] == '1') {
            $castas = $_POST['casta'] ?? [];
            $totalPoblacion = array_sum(array_map('intval', $castas));
            $poblacionDetallada = json_encode($castas);
        }

        $data = [
            'nombre'             => $_POST['nombre'] ?? '',
            'especie_id'         => $_POST['especie_id'] ?? '',
            'fecha_adquisicion'  => $_POST['fecha_adquisicion'] ?? date('Y-m-d'),
            'tipo_hormiguero'    => $_POST['tipo_hormiguero'] ?? '',
            'descripcion'        => $_POST['descripcion'] ?? '',
            'poblacion_actual'   => $totalPoblacion,
            'imagen'             => $imagePath,
            'poblacion_detallada'=> $poblacionDetallada
        ];
        
        if (Colony::update($id, $data)) {
            $this->redirect('/colonias/ver/' . $id);
        } else {
            $this->redirect('/colonias/editar/' . $id);
        }
    }

    public function destroy($id) {
        require_login();
        
        $colony = Colony::find($id);
        if ($colony && $colony['usuario_id'] == $_SESSION['user_id']) {
            // Borrar imagen si existe
            if ($colony['imagen']) {
                @unlink('uploads/colonies/' . $colony['imagen']);
            }
            Colony::delete($id);
        }
        
        $this->redirect('/colonias');
    }

    public function gallery($id) {
        require_login();
        
        $colony = Colony::find($id);
        if (!$colony || $colony['usuario_id'] != $_SESSION['user_id']) {
            $this->redirect('/colonias');
        }

        $diary = Colony::getDiary($id);
        
        $media = [];
        
        // Imagen principal de la colonia
        if ($colony['imagen']) {
            $media[] = [
                'url' => 'uploads/colonies/' . $colony['imagen'],
                'fecha' => $colony['fecha_adquisicion'],
                'tipo' => 'Foto de Perfil',
                'descripcion' => 'Imagen principal de la colonia.'
            ];
        }

        // Imágenes del diario
        foreach ($diary as $entry) {
            if ($entry['imagen_url']) {
                $media[] = [
                    'url' => 'uploads/diary/' . $entry['imagen_url'],
                    'fecha' => $entry['fecha_entrada'],
                    'tipo' => $entry['tipo_evento'],
                    'descripcion' => $entry['entrada']
                ];
            }
        }

        // Ordenar por fecha descendente
        usort($media, function($a, $b) {
            return strcmp($b['fecha'], $a['fecha']);
        });

        $data = [
            'colony' => $colony,
            'media'  => $media,
            'title'  => 'Galería Multimedia - ' . $colony['nombre'] . ' | AntMaster Pro'
        ];

        $this->view('colony/gallery', $data);
    }
}
