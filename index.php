<?php
// Root index.php - Entry point
session_start();
require_once 'app/config/config.php';

// Simple routing
$page = isset($_GET['page']) ? $_GET['page'] : 'home';

// Route to appropriate view
switch($page) {
    case 'home':
    default:
        include 'app/views/home/index.php';
        break;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nuru AI - Intelligence Grade Fraud Detection</title>
    <link rel="stylesheet" href="public/css/main.css">
    <link rel="stylesheet" href="public/css/components.css">
</head>
<body>
    <!-- Ambient Background -->
    <div class="ambient-bg">
        <div class="floating-shape shape-1"></div>
        <div class="floating-shape shape-2"></div>
        <div class="floating-shape shape-3"></div>
    </div>

    <!-- Navigation -->
    <nav class="navbar" id="navbar">
        <div class="container nav-content">
            <a href="/" class="nav-logo">Nuru AI</a>
            <ul class="nav-links">
                <li><a href="#home" class="nav-link">Home</a></li>
                <li><a href="#features" class="nav-link">Features</a></li>
                <li><a href="#roadmap" class="nav-link">Roadmap</a></li>
                <li><a href="#agencies" class="nav-link">Agencies</a></li>
            </ul>
            <div class="nav-buttons">
                <?php if(isset($_SESSION['user'])): ?>
                    <a href="private/dashboard/index.php" class="btn btn-primary">Dashboard</a>
                    <a href="controllers/auth.controller.php?logout=1" class="btn btn-text">Logout</a>
                <?php else: ?>
                    <a href="#" class="btn btn-text" onclick="AuthController.showLoginModal()">Sign In</a>
                    <a href="#" class="btn btn-primary" onclick="window.location.href='private/dashboard/index.php'">Launch Platform</a>
                <?php endif; ?>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <div id="app">
        <?php include 'app/views/home/index.php'; ?>
    </div>

    <!-- Scripts -->
    <script src="app/config/config.js"></script>
    <script src="app/core/utils/helpers.js"></script>
    <script src="app/core/utils/validators.js"></script>
    <script src="app/core/utils/formatters.js"></script>
    <script src="app/core/services/api.service.js"></script>
    <script src="app/core/services/auth.service.js"></script>
    <script src="app/core/services/storage.service.js"></script>
    <script src="app/core/models/user.model.js"></script>
    <script src="app/core/models/case.model.js"></script>
    <script src="app/core/models/document.model.js"></script>
    <script src="controllers/auth.controller.js"></script>
    <script src="controllers/dashboard.controller.js"></script>
    <script src="public/js/main.js"></script>
</body>
</html>