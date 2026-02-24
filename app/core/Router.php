<?php
class Router {
    protected $routes = [];
    
    public function add($route, $params) {
        $this->routes[$route] = $params;
    }
    
    public function dispatch($controllerName, $action, $id = null) {
        // Convert to proper controller class name
        $controllerClass = $controllerName . 'Controller';
        $controllerFile = __DIR__ . '/../controllers/' . $controllerClass . '.php';
        
        if (file_exists($controllerFile)) {
            require_once $controllerFile;
            $controller = new $controllerClass();
            
            if (method_exists($controller, $action)) {
                // Call controller action with or without ID
                if ($id) {
                    $controller->$action($id);
                } else {
                    $controller->$action();
                }
            } else {
                // Action not found
                $this->error404("Action '$action' not found");
            }
        } else {
            // Controller not found
            $this->error404("Controller '$controllerClass' not found");
        }
    }
    
    public function error404($message = 'Page not found') {
        http_response_code(404);
        echo "<h1>404 - $message</h1>";
        exit();
    }
}