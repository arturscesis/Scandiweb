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
                    // Route matches, call the callback
                    if (is_callable($callback)) {
                        call_user_func($callback);
                    } else {
                        // You can handle other types of callbacks here, e.g., "Controller@action"
                        list($controller, $action) = explode('@', $callback);
                        $controllerInstance = new $controller();
                        call_user_func([$controllerInstance, $action]);
                    }
                    return;
                }
            }
        }

        // Route not found, handle 404
        http_response_code(404);
        echo '404 - Not Found';
    }
}

?>