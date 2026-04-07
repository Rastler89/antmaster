<?php

class PageController extends Controller {
    public function about() {
        $data = [
            'title' => 'Acerca de AntMaster Pro - Nuestra Misión',
            'description' => 'Conoce más sobre AntMaster Pro, la plataforma definitiva para la gestión de colonias de hormigas creada por rastler.dev.'
        ];
        $this->view('pages/about', $data);
    }

    public function guide() {
        $data = [
            'title' => 'Guía de Inicio - Cómo usar AntMaster Pro',
            'description' => 'Aprende a gestionar tus colonias, registrar poblaciones y administrar el stock de alimento en AntMaster Pro.'
        ];
        $this->view('pages/guide', $data);
    }
}
