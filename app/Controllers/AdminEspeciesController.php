<?php

require_once '../app/Models/Species.php';

class AdminEspeciesController extends Controller {

    /**
     * Lista de todas las especies con su estado de traducción
     */
    public function index() {
        require_admin();

        $species = Species::allWithTranslationStats();
        
        // Formatear los idiomas traducidos en un array para la vista
        foreach ($species as &$s) {
            $s['langs'] = $s['idiomas_traducidos'] ? explode(',', $s['idiomas_traducidos']) : [];
        }

        $this->view('admin/especies/index', [
            'species' => $species,
            'title'   => 'Gestión de Traducciones | AntMaster Pro',
            'success' => $_SESSION['success'] ?? '',
            'error'   => $_SESSION['error'] ?? ''
        ]);
        
        unset($_SESSION['success'], $_SESSION['error']);
    }

    /**
     * Formulario para traducir una especie específica
     */
    public function translate($id) {
        require_admin();

        $species = Species::find($id); // Esto trae la base (ES)
        if (!$species) {
            $this->redirect('/admin/especies');
        }

        $languages = ['en' => 'English', 'fr' => 'Français'];
        $translations = [];

        foreach ($languages as $code => $name) {
            $translations[$code] = Species::getTranslation($id, $code);
        }

        $this->view('admin/especies/translate', [
            'species'      => $species,
            'languages'    => $languages,
            'translations' => $translations,
            'title'        => 'Traducir: ' . $species['nombre_cientifico']
        ]);
    }

    /**
     * Guardar la traducción enviada
     */
    public function storeTranslation($id) {
        require_admin();

        $lang = $_POST['lang'] ?? '';
        if (!in_array($lang, ['en', 'fr'])) {
            $_SESSION['error'] = 'Idioma no soportado.';
            $this->redirect('/admin/especies');
        }

        $data = [
            'nombre'                => $_POST['nombre'] ?? '',
            'descripcion'           => $_POST['descripcion'] ?? '',
            'alimentacion'          => $_POST['alimentacion'] ?? '',
            'consejos_cria'         => $_POST['consejos_cria'] ?? '',
            'localizacion'          => $_POST['localizacion'] ?? '',
            'velocidad_crecimiento' => $_POST['velocidad_crecimiento'] ?? '',
            'tamano'                => $_POST['tamano'] ?? '',
            'castas'                => $_POST['castas'] ?? '',
            'reproduccion'          => $_POST['reproduccion'] ?? '',
            'vuelos'                => $_POST['vuelos'] ?? ''
        ];

        if (Species::updateOrCreateTranslation($id, $lang, $data)) {
            $_SESSION['success'] = "Traducción ($lang) guardada correctamente.";
        } else {
            $_SESSION['error'] = "Error al guardar la traducción.";
        }

        $this->redirect("/admin/especies/traducir/$id?lang=$lang");
    }

    /**
     * Publicar una especie (quitar estado draft)
     */
    public function publish($id) {
        require_admin();
        if (Species::publish($id)) {
            $_SESSION['success'] = "Especie publicada correctamente. Ahora es visible para todos.";
        } else {
            $_SESSION['error'] = "Error al publicar la especie.";
        }
        $this->redirect('/admin/especies');
    }

    /**
     * Formulario para editar los datos base de una especie
     */
    public function edit($id) {
        require_admin();
        $species = Species::find($id);
        if (!$species) {
            $this->redirect('/admin/especies');
        }

        $this->view('admin/especies/edit', [
            'species' => $species,
            'title'   => 'Editar Base: ' . $species['nombre_cientifico']
        ]);
    }

    /**
     * Actualizar los datos base de una especie
     */
    public function update($id) {
        require_admin();
        
        $data = [
            'nombre'                => $_POST['nombre'] ?? '',
            'nombre_cientifico'     => $_POST['nombre_cientifico'] ?? '',
            'dificultad'            => $_POST['dificultad'] ?? 'Principiante',
            'temperatura'           => $_POST['temperatura'] ?? '',
            'humedad'               => $_POST['humedad'] ?? '',
            'velocidad_crecimiento' => $_POST['velocidad_crecimiento'] ?? '',
            'tamano'                => $_POST['tamano'] ?? '',
            'castas'                => $_POST['castas'] ?? '',
            'reproduccion'          => $_POST['reproduccion'] ?? '',
            'vuelos'                => $_POST['vuelos'] ?? '',
            'is_draft'              => isset($_POST['is_draft']) ? (int)$_POST['is_draft'] : 0
        ];

        if (Species::update($id, $data)) {
            $_SESSION['success'] = "Datos base actualizados correctamente.";
            $this->redirect('/admin/especies');
        } else {
            $_SESSION['error'] = "Error al actualizar los datos base.";
            $this->redirect("/admin/especies/editar/$id");
        }
    }
}
