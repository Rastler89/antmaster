<?php

class View {
    public static function render($view, $args = []) {
        extract($args, EXTR_SKIP);

        $file = "../app/Views/$view.php";

        if (is_readable($file)) {
            ob_start();
            require $file;
            $content = ob_get_clean();

            // Determinar el layout según el directorio de la vista
            if (strpos($view, 'auth/') === 0) {
                $layout = "../app/Views/layouts/auth.php";
            } else {
                $layout = "../app/Views/layouts/app.php";
            }

            if (is_readable($layout) && strpos($view, 'layouts/') !== 0) {
                require $layout;
            } else {
                echo $content;
            }
        } else {
            die("View $file not found");
        }
    }
}
