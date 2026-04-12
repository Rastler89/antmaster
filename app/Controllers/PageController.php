<?php

class PageController extends Controller {
    public function about() {
        $json_ld = json_encode([
            "@context" => "https://schema.org",
            "@type" => "AboutPage",
            "name" => "Acerca de AntMaster Pro",
            "description" => 'Conoce más sobre AntMaster Pro, la plataforma definitiva para la gestión de colonias de hormigas creada por rastler.dev.'
        ], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);

        $data = [
            'title' => 'Acerca de AntMaster Pro - Nuestra Misión',
            'description' => 'Conoce más sobre AntMaster Pro, la plataforma definitiva para la gestión de colonias de hormigas creada por rastler.dev.',
            'og_type' => 'website',
            'json_ld' => $json_ld
        ];
        $this->view('pages/about', $data);
    }

    public function guide() {
        $json_ld = json_encode([
            "@context" => "https://schema.org",
            "@type" => "Article",
            "headline" => "Guía de Inicio - Cómo usar AntMaster Pro",
            "description" => 'Aprende a gestionar tus colonias, registrar poblaciones y administrar el stock de alimento en AntMaster Pro.'
        ], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);

        $data = [
            'title' => 'Guía de Inicio - Cómo usar AntMaster Pro',
            'description' => 'Aprende a gestionar tus colonias, registrar poblaciones y administrar el stock de alimento en AntMaster Pro.',
            'og_type' => 'article',
            'json_ld' => $json_ld
        ];
        $this->view('pages/guide', $data);
    }

    public function changelog() {
        $json_ld = json_encode([
            "@context" => "https://schema.org",
            "@type" => "Article",
            "headline" => "Registro de Cambios (Changelog) - AntMaster Pro",
            "description" => 'Explora la evolución de AntMaster Pro. Registro detallado de nuevas funcionalidades, mejoras y correcciones en cada versión.'
        ], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);

        $data = [
            'title' => 'Changelog - Historial de Versiones',
            'description' => 'Explora la evolución de AntMaster Pro. Registro detallado de nuevas funcionalidades, mejoras y correcciones en cada versión.',
            'og_type' => 'article',
            'json_ld' => $json_ld
        ];
        $this->view('pages/changelog', $data);
    }
}
