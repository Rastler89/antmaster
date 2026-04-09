<?php
abstract class Controller {
    protected function view($view, $args = []) {
        View::render($view, $args);
    }

    protected function json($data) {
        header('Content-Type: application/json');
        echo json_encode($data);
        exit();
    }

    protected function redirect($url) {
        header("Location: " . BASE_URL . $url);
        exit();
    }
}
