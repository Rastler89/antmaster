<?php

class Router {
    protected $routes = [];

    public function get($uri, $controller) {
        $this->routes['GET'][$uri] = $controller;
    }

    public function post($uri, $controller) {
        $this->routes['POST'][$uri] = $controller;
    }

    public function put($uri, $controller) {
        $this->routes['PUT'][$uri] = $controller;
    }

    public function patch($uri, $controller) {
        $this->routes['PATCH'][$uri] = $controller;
    }

    public function delete($uri, $controller) {
        $this->routes['DELETE'][$uri] = $controller;
    }

    public function dispatch($uri, $method) {
        // Interceptar método oculto para simular PUT, PATCH o DELETE
        if ($method === 'POST' && isset($_POST['_method'])) {
            $method = strtoupper($_POST['_method']);
        }

        $uri = strtok($uri, '?');
        if ($uri != '/' && substr($uri, -1) == '/') {
            $uri = substr($uri, 0, -1);
        }

        if (!isset($this->routes[$method])) {
            http_response_code(405);
            echo "405 Method Not Allowed";
            return;
        }

        foreach ($this->routes[$method] as $route => $controllerAction) {
            $pattern = preg_replace('/\{([a-zA-Z0-9_]+)\}/', '(?P<\1>[a-zA-Z0-9_-]+)', $route);
            $pattern = '#^' . $pattern . '$#';
            
            if (preg_match($pattern, $uri, $matches)) {
                $parts = explode('@', $controllerAction);
                $controllerName = $parts[0];
                $action = $parts[1];

                $params = array_filter($matches, 'is_string', ARRAY_FILTER_USE_KEY);

                require_once '../app/Controllers/' . $controllerName . '.php';
                $controller = new $controllerName();
                call_user_func_array([$controller, $action], $params);
                return;
            }
        }

        http_response_code(404);
        echo "404 Not Found: " . htmlspecialchars($uri);
    }
}
