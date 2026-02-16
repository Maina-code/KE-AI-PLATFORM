<?php
// app/Core/Controller.php

class Controller
{
    protected $viewPath = __DIR__ . '/../Views/';
    
    public function __construct()
    {
        // Base controller constructor
    }
    
    /**
     * Render a view
     */
    protected function view($viewFile, $data = [])
    {
        // Extract data to variables
        extract($data);
        
        // Build the full view path
        $viewFile = str_replace('.', '/', $viewFile);
        $fullPath = $this->viewPath . $viewFile . '.php';
        
        // Check if view exists
        if (file_exists($fullPath)) {
            require_once $fullPath;
        } else {
            // Try with .php extension
            $fullPath = $this->viewPath . $viewFile;
            if (file_exists($fullPath)) {
                require_once $fullPath;
            } else {
                echo "View not found: {$viewFile}";
            }
        }
    }
    
    /**
     * Redirect to another page
     */
    protected function redirect($url)
    {
        header('Location: ' . $url);
        exit;
    }
}