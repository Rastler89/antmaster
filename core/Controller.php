<?php
abstract class Controller {
    protected function view($view, $args = []) {
        View::render($view, $args);
    }

    protected function redirect($url) {
        header("Location: " . BASE_URL . $url);
        exit();
    }
}
