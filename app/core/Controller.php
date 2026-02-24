<?php
class Controller {
    
    protected function view($view, $data = []) {
        // Extract data array to variables
        extract($data);
        
        // Build view path
        $viewFile = __DIR__ . '/../views/' . $view . '.php';
        
        if (file_exists($viewFile)) {
            require_once __DIR__ . '/../views/layout/header.php';
            require_once $viewFile;
            require_once __DIR__ . '/../views/layout/header.php';
        } else {
            die("View '$view' not found");
        }
    }
    
    protected function model($model) {
        $modelClass = $model;
        $modelFile = __DIR__ . '/../models/' . $modelClass . '.php';
        
        if (file_exists($modelFile)) {
            require_once $modelFile;
            return new $modelClass();
        } else {
            die("Model '$model' not found");
        }
    }
    
    protected function json($data) {
        header('Content-Type: application/json');
        echo json_encode($data);
        exit();
    }
    
    protected function redirect($url) {
        header("Location: $url");
        exit();
    }
    
    protected function isPost() {
        return $_SERVER['REQUEST_METHOD'] === 'POST';
    }
    
    protected function getPost($key = null) {
        if ($key === null) {
            return $_POST;
        }
        return $_POST[$key] ?? null;
    }
    
    protected function getQuery($key = null) {
        if ($key === null) {
            return $_GET;
        }
        return $_GET[$key] ?? null;
    }
}