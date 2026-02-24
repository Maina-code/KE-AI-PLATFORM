<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - NuruAI Platform</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(135deg, #0A2351, #1a3a6b);
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: 'Segoe UI', sans-serif;
        }
        .login-container {
            max-width: 400px;
            width: 90%;
        }
        .login-card {
            background: white;
            border-radius: 15px;
            box-shadow: 0 10px 40px rgba(0,0,0,0.3);
            padding: 40px;
        }
        .login-card h2 {
            color: #0A2351;
            margin-bottom: 10px;
            text-align: center;
            font-weight: 600;
        }
        .login-card .subtitle {
            color: #666;
            text-align: center;
            margin-bottom: 30px;
            font-size: 0.9rem;
        }
        .form-control {
            height: 45px;
            border-radius: 8px;
        }
        .btn-login {
            background: #0A2351;
            color: white;
            border: none;
            padding: 12px;
            font-weight: 600;
            border-radius: 8px;
            width: 100%;
            transition: all 0.3s;
        }
        .btn-login:hover {
            background: #C5A572;
            color: #0A2351;
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(197, 165, 114, 0.4);
        }
        .logo {
            text-align: center;
            margin-bottom: 20px;
        }
        .logo i {
            font-size: 50px;
            color: #C5A572;
        }
        .error-alert {
            background: #fee;
            color: #c33;
            padding: 10px;
            border-radius: 8px;
            margin-bottom: 20px;
            text-align: center;
        }
    </style>
</head>
<body>
    <div class="login-container">
        <div class="login-card">
            <div class="logo">
                <i class="fas fa-shield-alt"></i>
            </div>
            <h2>NuruAI Platform</h2>
            <div class="subtitle">Office of the Auditor General - Kenya</div>
            
            <?php if (!empty($error)): ?>
                <div class="error-alert">
                    <i class="fas fa-exclamation-circle"></i>
                    <?php echo htmlspecialchars($error); ?>
                </div>
            <?php endif; ?>
            
            <form method="POST" action="index.php?controller=auth&action=login">
                <div class="mb-3">
                    <label class="form-label">Email Address</label>
                    <input type="email" name="email" class="form-control" 
                           value="<?php echo isset($_POST['email']) ? htmlspecialchars($_POST['email']) : ''; ?>" 
                           required autofocus>
                </div>
                <div class="mb-4">
                    <label class="form-label">Password</label>
                    <input type="password" name="password" class="form-control" required>
                </div>
                <button type="submit" class="btn-login">
                    <i class="fas fa-sign-in-alt me-2"></i>Login to Dashboard
                </button>
            </form>
            
<div class="text-center mt-3">
    <p>Don't have an account? <a href="index.php?controller=auth&action=register">Register here</a></p>
</div>
        </div>
    </div>
    
    <script src="https://kit.fontawesome.com/your-code.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>