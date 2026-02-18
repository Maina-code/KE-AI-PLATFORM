<?php
// debug_auth.php
echo "<h1>Auth Class Debug</h1>";

// Show all loaded files
echo "<h2>Loaded Files:</h2>";
echo "<pre>";
print_r(get_included_files());
echo "</pre>";

// Check if class exists
echo "<h2>Class Check:</h2>";
if (class_exists('Auth')) {
    echo "Auth class exists!<br>";
    
    try {
        $reflection = new ReflectionClass('Auth');
        echo "Declared in: " . $reflection->getFileName() . "<br>";
        echo "Started on line: " . $reflection->getStartLine() . "<br>";
    } catch (Exception $e) {
        echo "Error: " . $e->getMessage();
    }
} else {
    echo "Auth class does NOT exist yet.<br>";
}

// Search for auth files
echo "<h2>Search for auth.php files:</h2>";
$files = glob(__DIR__ . '/**/*auth.php', GLOB_BRACE);
echo "<pre>";
print_r($files);
echo "</pre>";

// Show current file
echo "<h2>Current File:</h2>";
echo __FILE__;