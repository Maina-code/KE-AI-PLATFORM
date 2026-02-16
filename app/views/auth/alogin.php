<?php
// Views/admin/login.php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Redirect if already logged in as admin
if (isset($_SESSION['logged_in']) && $_SESSION['logged_in'] && 
    isset($_SESSION['user_role']) && in_array($_SESSION['user_role'], ['admin', 'manager', 'staff'])) {
    header('Location: index.php?controller=admin&action=dashboard');
    exit;
}

// Set error logging
ini_set('log_errors', 1);
ini_set('error_log', __DIR__ . '/../../../error_log.txt');

// Generate CSRF token
if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}

// Generate math captcha
$num1 = rand(11, 20);
$num2 = rand(1, 10);
$_SESSION['admin_math_answer'] = $num1 + $num2;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TS Freighters - Admin Login</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        :root {
            --admin-primary: #4f46e5;
            --admin-secondary: #7c3aed;
            --admin-dark: #1e293b;
            --admin-light: #f8fafc;
            --admin-danger: #ef4444;
            --admin-success: #10b981;
            --admin-warning: #f59e0b;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, var(--admin-dark) 0%, #0f172a 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }

        .login-container {
            width: 100%;
            max-width: 420px;
            margin: 0 auto;
        }

        .login-card {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            border-radius: 20px;
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.5);
            overflow: hidden;
            border: 1px solid rgba(255, 255, 255, 0.2);
        }

        .login-header {
            background: linear-gradient(135deg, var(--admin-primary), var(--admin-secondary));
            padding: 40px 30px;
            text-align: center;
            position: relative;
            overflow: hidden;
        }

        .login-header::before {
            content: '';
            position: absolute;
            top: -50%;
            left: -50%;
            width: 200%;
            height: 200%;
            background: radial-gradient(circle, rgba(255,255,255,0.1) 1px, transparent 1px);
            background-size: 30px 30px;
            opacity: 0.3;
        }

        .logo-wrapper {
            position: relative;
            z-index: 1;
        }

        .admin-logo {
            width: 80px;
            height: 80px;
            background: rgba(255, 255, 255, 0.9);
            border-radius: 20px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 20px;
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.2);
        }

        .admin-logo i {
            font-size: 2.5rem;
            color: var(--admin-primary);
        }

        .login-title {
            color: white;
            font-weight: 700;
            font-size: 1.8rem;
            margin-bottom: 10px;
        }

        .login-subtitle {
            color: rgba(255, 255, 255, 0.9);
            font-size: 0.95rem;
            font-weight: 400;
        }

        .login-body {
            padding: 40px 30px 30px;
        }

        .form-label {
            font-weight: 600;
            color: var(--admin-dark);
            margin-bottom: 8px;
            font-size: 0.9rem;
        }

        .input-group {
            margin-bottom: 20px;
        }

        .input-icon {
            background: var(--admin-light);
            border: 2px solid #e2e8f0;
            border-right: none;
            border-radius: 12px 0 0 12px;
            color: var(--admin-primary);
            padding: 0 20px;
        }

        .form-control {
            border: 2px solid #e2e8f0;
            border-radius: 0 12px 12px 0;
            padding: 14px 20px;
            font-size: 1rem;
            transition: all 0.3s ease;
            background: white;
        }

        .form-control:focus {
            border-color: var(--admin-primary);
            box-shadow: 0 0 0 3px rgba(79, 70, 229, 0.1);
            background: white;
        }

        .form-control.error {
            border-color: var(--admin-danger);
            background-color: rgba(239, 68, 68, 0.05);
        }

        .captcha-box {
            background: linear-gradient(135deg, #f1f5f9, #e2e8f0);
            border-radius: 12px;
            padding: 15px;
            margin-bottom: 20px;
            text-align: center;
            border: 2px dashed #cbd5e1;
        }

        .captcha-text {
            font-size: 1.1rem;
            font-weight: 700;
            color: var(--admin-dark);
            margin: 0;
        }

        .captcha-num {
            color: var(--admin-primary);
            font-weight: 800;
            font-size: 1.3rem;
        }

        .btn-login {
            background: linear-gradient(135deg, var(--admin-primary), var(--admin-secondary));
            color: white;
            border: none;
            border-radius: 12px;
            padding: 16px;
            font-weight: 600;
            font-size: 1rem;
            width: 100%;
            transition: all 0.3s ease;
            margin-top: 10px;
            box-shadow: 0 4px 15px rgba(79, 70, 229, 0.3);
        }

        .btn-login:hover:not(:disabled) {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(79, 70, 229, 0.4);
        }

        .btn-login:disabled {
            opacity: 0.7;
            cursor: not-allowed;
        }

        /* Registration Link Button Styles */
        .registration-section {
            margin: 20px 0;
            text-align: center;
            padding-top: 20px;
            border-top: 1px solid #e2e8f0;
        }

        .registration-label {
            color: #64748b;
            font-size: 0.9rem;
            margin-bottom: 10px;
            display: block;
        }

        .btn-register {
            background: linear-gradient(135deg, var(--admin-warning), #fbbf24);
            color: white;
            border: none;
            border-radius: 12px;
            padding: 14px 24px;
            font-weight: 600;
            font-size: 0.95rem;
            width: 100%;
            transition: all 0.3s ease;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            box-shadow: 0 4px 12px rgba(245, 158, 11, 0.3);
        }

        .btn-register:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 16px rgba(245, 158, 11, 0.4);
            color: white;
        }

        .btn-register:active {
            transform: translateY(0);
        }

        .btn-register i {
            font-size: 1.1rem;
        }

        .alert-box {
            border-radius: 12px;
            padding: 15px;
            margin-top: 20px;
            display: none;
            animation: fadeIn 0.3s ease;
            border: 2px solid;
        }

        .alert-success {
            background-color: rgba(16, 185, 129, 0.1);
            border-color: var(--admin-success);
            color: var(--admin-success);
        }

        .alert-danger {
            background-color: rgba(239, 68, 68, 0.1);
            border-color: var(--admin-danger);
            color: var(--admin-danger);
        }

        .alert-warning {
            background-color: rgba(245, 158, 11, 0.1);
            border-color: #f59e0b;
            color: #d97706;
        }

        .login-footer {
            padding: 20px 30px;
            text-align: center;
            background: var(--admin-light);
            border-top: 1px solid #e2e8f0;
            font-size: 0.85rem;
            color: #64748b;
        }

        .login-footer a {
            color: var(--admin-primary);
            text-decoration: none;
            font-weight: 600;
        }

        .login-footer a:hover {
            text-decoration: underline;
        }

        .security-badge {
            display: inline-flex;
            align-items: center;
            gap: 5px;
            background: rgba(16, 185, 129, 0.1);
            color: var(--admin-success);
            padding: 5px 10px;
            border-radius: 20px;
            font-size: 0.8rem;
            font-weight: 600;
            margin-top: 10px;
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(-10px); }
            to { opacity: 1; transform: translateY(0); }
        }

        @keyframes shake {
            0%, 100% { transform: translateX(0); }
            25% { transform: translateX(-5px); }
            75% { transform: translateX(5px); }
        }

        .shake {
            animation: shake 0.3s ease;
        }

        @media (max-width: 480px) {
            .login-card {
                border-radius: 15px;
            }
            
            .login-header {
                padding: 30px 20px;
            }
            
            .login-body {
                padding: 30px 20px 20px;
            }
            
            .btn-register {
                padding: 12px 20px;
                font-size: 0.9rem;
            }
        }
    </style>
</head>
<body>
    <div class="login-container">
        <div class="login-card">
            <div class="login-header">
                <div class="logo-wrapper">
                    <div class="admin-logo">
                        <i class="fas fa-shield-alt"></i>
                    </div>
                    <h1 class="login-title">Admin Portal</h1>
                    <p class="login-subtitle">TS Freighters Management System</p>
                </div>
            </div>
            
            <div class="login-body">
                <form id="adminLoginForm" novalidate>
                    <input type="hidden" name="csrf_token" value="<?php echo htmlspecialchars($_SESSION['csrf_token']); ?>">

                    <div class="mb-3">
                        <label for="admin_email" class="form-label">
                            <i class="fas fa-envelope me-2"></i>Email Address
                        </label>
                        <div class="input-group">
                            <span class="input-icon">
                                <i class="fas fa-user-tie"></i>
                            </span>
                            <input type="email" id="admin_email" name="email" class="form-control" 
                                   placeholder="admin@tsfreighters.com" required>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="admin_password" class="form-label">
                            <i class="fas fa-key me-2"></i>Password
                        </label>
                        <div class="input-group">
                            <span class="input-icon">
                                <i class="fas fa-lock"></i>
                            </span>
                            <input type="password" id="admin_password" name="password" class="form-control" 
                                   placeholder="••••••••" required>
                            <button class="btn btn-outline-secondary" type="button" id="togglePassword">
                                <i class="fas fa-eye"></i>
                            </button>
                        </div>
                    </div>

                    <div class="captcha-box">
                        <p class="captcha-text">
                            Security Check: <span class="captcha-num"><?php echo $num1; ?></span> + 
                            <span class="captcha-num"><?php echo $num2; ?></span> = ?
                        </p>
                        <input type="number" id="admin_captcha" name="captcha" class="form-control mt-2" 
                               placeholder="Enter sum" required>
                    </div>

                    <div class="mb-3">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="remember_admin" name="remember">
                            <label class="form-check-label" for="remember_admin">
                                <i class="fas fa-check-circle me-2"></i>Remember this device
                            </label>
                        </div>
                    </div>

                    <button type="submit" id="adminLoginBtn" class="btn btn-login">
                        <span id="btnText">
                            <i class="fas fa-sign-in-alt me-2"></i>Secure Login
                        </span>
                        <span id="btnSpinner" class="spinner-border spinner-border-sm d-none" role="status"></span>
                    </button>
                </form>

                <div id="loginAlert" class="alert-box" role="alert"></div>
                
                <!-- Add Forgot Password Link -->
                <div class="text-center mt-3">
                    <a href="index.php?controller=admin&action=forgotPassword" class="text-decoration-none small">
                        <i class="fas fa-key me-1"></i>Forgot Password?
                    </a>
                </div>
                
                <!-- Registration Section -->
                <div class="registration-section">
                    <span class="registration-label">
                        <i class="fas fa-user-plus me-1"></i>Need an admin account?
                    </span>
                    <a href="index.php?controller=admin&action=register" class="btn-register">
                        <i class="fas fa-user-shield"></i>
                        Register New Admin User
                    </a>
                </div>
            </div>

            <div class="login-footer">
                <p class="small mb-0">
                    Need help? <a href="mailto:it-support@tsfreighters.com">Contact IT Support</a>
                </p>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
    document.addEventListener('DOMContentLoaded', function() {
        const form = document.getElementById('adminLoginForm');
        const loginBtn = document.getElementById('adminLoginBtn');
        const btnText = document.getElementById('btnText');
        const btnSpinner = document.getElementById('btnSpinner');
        const alertBox = document.getElementById('loginAlert');
        const toggleBtn = document.getElementById('togglePassword');
        const passwordInput = document.getElementById('admin_password');

        // Toggle password visibility
        toggleBtn.addEventListener('click', function() {
            const type = passwordInput.type === 'password' ? 'text' : 'password';
            passwordInput.type = type;
            this.querySelector('i').classList.toggle('fa-eye');
            this.querySelector('i').classList.toggle('fa-eye-slash');
        });

        // Handle form submission
        form.addEventListener('submit', async function(e) {
            e.preventDefault();
            
            // Validate inputs
            const email = document.getElementById('admin_email').value.trim();
            const password = document.getElementById('admin_password').value.trim();
            const captcha = document.getElementById('admin_captcha').value.trim();
            
            if (!email || !password || !captcha) {
                showAlert('All fields are required', 'danger');
                form.classList.add('shake');
                setTimeout(() => form.classList.remove('shake'), 300);
                return;
            }

            // Email validation
            const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            if (!emailRegex.test(email)) {
                showAlert('Please enter a valid email address', 'danger');
                return;
            }

            // Captcha validation (basic)
            const captchaNum = parseInt(captcha);
            if (isNaN(captchaNum) || captchaNum < 0) {
                showAlert('Please enter a valid number for the security check', 'danger');
                return;
            }

            // Show loading state
            loginBtn.disabled = true;
            btnText.classList.add('d-none');
            btnSpinner.classList.remove('d-none');
            alertBox.classList.add('d-none');

            try {
                const formData = new FormData(form);
                
                // Add timestamp to prevent replay attacks
                formData.append('timestamp', Date.now());
                
                // Add user agent for logging
                formData.append('user_agent', navigator.userAgent);
                
const response = await fetch('index.php?controller=admin&action=loginProcess', {
    method: 'POST',
    body: formData,
    headers: {
        'X-Requested-With': 'XMLHttpRequest'
        // Don't set Content-Type when using FormData - let the browser set it
    }
});

                // Handle non-JSON responses
                const responseText = await response.text();
                let result;
                
                try {
                    result = JSON.parse(responseText);
                } catch (parseError) {
                    console.error('Non-JSON response:', responseText);
                    showAlert('Server returned an invalid response. Please try again.', 'danger');
                    return;
                }

                if (result.success) {
                    showAlert(result.message || 'Login successful!', 'success');
                    
                    // Clear sensitive data from form
                    form.reset();
                    
                    // FIXED: Redirect to admin dashboard, not customer dashboard
                    setTimeout(() => {
                        window.location.href = result.redirect || 'index.php?controller=admin&action=dashboard';
                    }, 1500);
                } else {
                    showAlert(result.message || 'Login failed. Please check your credentials.', 'danger');
                    
                    // If too many attempts, disable form temporarily
                    if (result.locked) {
                        loginBtn.disabled = true;
                        loginBtn.innerHTML = '<i class="fas fa-lock me-2"></i>Account Locked';
                        showAlert(result.lock_message, 'warning');
                    }
                    
                    // Clear password field on error
                    passwordInput.value = '';
                    
                    // Clear captcha field on error
                    document.getElementById('admin_captcha').value = '';
                }
            } catch (error) {
                console.error('Login error:', error);
                showAlert('Network error. Please check your connection and try again.', 'danger');
            } finally {
                // Reset button state
                loginBtn.disabled = false;
                btnText.classList.remove('d-none');
                btnSpinner.classList.add('d-none');
            }
        });

        // Show alert message
        function showAlert(message, type) {
            alertBox.textContent = message;
            alertBox.className = `alert-box alert-${type}`;
            alertBox.style.display = 'block';
            
            // Auto-hide success messages
            if (type === 'success') {
                setTimeout(() => {
                    alertBox.style.display = 'none';
                }, 5000);
            }
        }

        // Input validation on blur
        const inputs = form.querySelectorAll('input[required]');
        inputs.forEach(input => {
            input.addEventListener('blur', function() {
                if (!this.value.trim()) {
                    this.classList.add('error');
                } else {
                    this.classList.remove('error');
                }
            });
        });

        // Real-time captcha validation
        const captchaInput = document.getElementById('admin_captcha');
        captchaInput.addEventListener('input', function() {
            const value = parseInt(this.value);
            if (isNaN(value) || value < 0) {
                this.value = '';
            }
        });

        // Prevent form submission on Enter in captcha field
        captchaInput.addEventListener('keypress', function(e) {
            if (e.key === 'Enter') {
                e.preventDefault();
                form.dispatchEvent(new Event('submit'));
            }
        });

        // Clear alert on input
        form.addEventListener('input', function() {
            if (alertBox.style.display !== 'none') {
                alertBox.style.display = 'none';
            }
        });

        // Enter key submits form
        form.addEventListener('keypress', function(e) {
            if (e.key === 'Enter' && e.target.type !== 'textarea') {
                if (!loginBtn.disabled) {
                    e.preventDefault();
                    form.dispatchEvent(new Event('submit'));
                }
            }
        });
    });
    </script>
</body>
</html>