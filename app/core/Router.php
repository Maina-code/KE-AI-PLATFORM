<?php

class Router {
    protected $routes = [];
    
    // THIS METHOD WAS MISSING - ADD IT
    public function add($route, $params = []) {
        $this->routes[$route] = $params;
    }
    
    public function dispatch($controllerName, $action, $id = null) {
        // Convert to proper controller class name
        $controllerClass = ucfirst($controllerName) . 'Controller';
        
        // Special case for 'auditor' controller
        if ($controllerName === 'auditor') {
            $controllerClass = 'AuditorController';
        }
        
        $controllerFile = __DIR__ . '/../Controllers/' . $controllerClass . '.php';
        
        if (file_exists($controllerFile)) {
            require_once $controllerFile;
            $controller = new $controllerClass();
            
            if (method_exists($controller, $action)) {
                if ($id) {
                    $controller->$action($id);
                } else {
                    $controller->$action();
                }
            } else {
                die("Action '$action' not found in controller '$controllerClass'");
            }
        } else {
            die("Controller file not found: $controllerFile");
        }
    }
    
    // Optional: Add a method to get all routes
    public function getRoutes() {
        return $this->routes;
    }
}