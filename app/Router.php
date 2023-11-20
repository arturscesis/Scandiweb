<?php

namespace App;

class Router {
    private $routes = [];

    public function get($route, $callback) {
        $this->routes['GET'][$route] = $callback;
    }

    public function post($route, $callback) {
        $this->routes['POST'][$route] = $callback;
    }

    public function dispatch() {
        $method = $_SERVER['REQUEST_METHOD'];
        $uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

        if (isset($this->routes[$method])) {
            foreach ($this->routes[$method] as $route => $callback) {
                $pattern = '#^' . preg_quote($route, '#') . '$#';
                if (preg_match($pattern, $uri)) {
                    if (is_callable($callback)) {
                        call_user_func($callback);
                    } else {
                        list($controller, $action) = explode('@', $callback);
                        $controllerInstance = new $controller();
                        call_user_func([$controllerInstance, $action]);
                    }
                    return;
                }
            }
        }

        http_response_code(404);
        echo '404 - Not Found';
    }
}

?>