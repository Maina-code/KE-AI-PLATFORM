<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>NuruAI - Login</title>
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
        .login-card {
            background: white;
            border-radius: 15px;
            box-shadow: 0 10px 40px rgba(0,0,0,0.3);
            padding: 40px;
            width: 100%;
            max-width: 400px;
        }
        .login-card h2 {
            color: #0A2351;
            margin-bottom: 10px;
            text-align: center;
        }
        .login-card .subtitle {
            color: #666;
            text-align: center;
            margin-bottom: 30px;
            font-size: 0.9rem;
        }
        .btn-primary {
            background: #0A2351;
            border: none;
            padding: 12px;
            font-weight: 600;
            width: 100%;
        }
        .btn-primary:hover {
            background: #1a3a6b;
        }
        .logo {
            text-align: center;
            margin-bottom: 20px;
        }
        .logo i {
            font-size: 50px;
            color: #C5A572;
        }
    </style>
</head>
<body>
    <div class="login-card">
        <div class="logo">
            <i class="fas fa-shield-alt"></i>
        </div>
        <h2>NuruAI Platform</h2>
        <div class="subtitle">Auditor General's Office - Kenya</div>
        
        <?php if (isset($error)): ?>
            <div class="alert alert-danger"><?php echo $error; ?></div>
        <?php endif; ?>
        
        <form method="POST" action="index.php?controller=Auth&action=login">
            <div class="mb-3">
                <label class="form-label">Username</label>
                <input type="text" name="username" class="form-control" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Password</label>
                <input type="password" name="password" class="form-control" required>
            </div>
            <button type="submit" class="btn btn-primary">Login to Dashboard</button>
        </form>
        <div class="text-center mt-3">
            <small class="text-muted">Demo: auditor_general / admin123</small>
        </div>
    </div>
    
    <script src="https://kit.fontawesome.com/your-code.js"></script>
</body>
</html>