<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Set error logging
ini_set('log_errors', 1);
ini_set('error_log', 'C:/xampp/htdocs/KE-AI-PLATFORM/private/logs/login_errors.log');

// Generate CSRF token with expiration
if (empty($_SESSION['csrf_token']) || empty($_SESSION['csrf_token_expiry']) || $_SESSION['csrf_token_expiry'] < time()) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
    $_SESSION['csrf_token_expiry'] = time() + 3600; // 1 hour expiry
}

// Generate simple math captcha for login (optional but adds security)
$num1 = rand(5, 15);
$num2 = rand(5, 15);
$_SESSION['login_math_answer'] = $num1 + $num2;
?>

<?php include __DIR__ . '/../layout/landingnavbar.php'; ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=yes">
    <title>Secure Login - NuruAI Integrity Platform</title>
    
    <!-- Security Headers -->
    <meta http-equiv="Content-Security-Policy" content="default-src 'self'; script-src 'self' https://cdn.jsdelivr.net https://code.jquery.com 'unsafe-inline' 'unsafe-eval'; style-src 'self' https://fonts.googleapis.com https://cdn.jsdelivr.net 'unsafe-inline'; font-src 'self' https://fonts.gstatic.com https://cdnjs.cloudflare.com; connect-src 'self' http://localhost; img-src 'self' data:; frame-ancestors 'none'; base-uri 'self'; form-action 'self'">
    <meta http-equiv="X-Content-Type-Options" content="nosniff">
    <meta http-equiv="X-Frame-Options" content="DENY">
    <meta http-equiv="Referrer-Policy" content="strict-origin-when-cross-origin">
    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Poppins:wght@500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.css" rel="stylesheet">
    
    <style>
        /* Import the same variables and base styles from registration page */
        :root {
            --gov-blue: #003366;
            --gov-red: #990000;
            --gov-gold: #FFD700;
            --gov-gray: #4A5568;
            --gov-light: #F7FAFC;
            --integrity-teal: #0D9488;
            --audit-purple: #6B46C1;
            --alert-orange: #DD6B20;
            
            /* Responsive spacing */
            --spacing-xs: 0.25rem;
            --spacing-sm: 0.5rem;
            --spacing-md: 1rem;
            --spacing-lg: 1.5rem;
            --spacing-xl: 2rem;
            --spacing-xxl: 3rem;
        }
        
        body {
            background: linear-gradient(135deg, #0a192f 0%, #0a1a2f 100%);
            font-family: 'Inter', sans-serif;
            min-height: 100vh;
            position: relative;
            overflow-x: hidden;
        }
        
        /* Security pattern background */
        body::before {
            content: '';
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-image: 
                linear-gradient(rgba(0, 51, 102, 0.05) 1px, transparent 1px),
                linear-gradient(90deg, rgba(0, 51, 102, 0.05) 1px, transparent 1px);
            background-size: 50px 50px;
            pointer-events: none;
            z-index: 0;
        }
        
        /* Container - Fixed from previous issue */
        .container {
            width: 100%;
            max-width: 500px;
            margin: 0 auto;
            padding: 0 var(--spacing-md);
            position: relative;
            z-index: 2;
        }
        
        @media (min-width: 768px) {
            .container {
                padding: 0 var(--spacing-lg);
            }
        }
        
        /* Security Header */
        .security-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: var(--spacing-lg);
            flex-wrap: wrap;
            gap: var(--spacing-md);
        }
        
        .security-badge {
            background: rgba(255, 215, 0, 0.1);
            border: 1px solid var(--gov-gold);
            color: var(--gov-gold);
            padding: var(--spacing-sm) var(--spacing-md);
            border-radius: 50px;
            display: inline-flex;
            align-items: center;
            gap: var(--spacing-sm);
            font-size: 0.75rem;
            font-weight: 600;
            backdrop-filter: blur(5px);
        }
        
        @media (min-width: 480px) {
            .security-badge {
                font-size: 0.875rem;
                padding: var(--spacing-sm) var(--spacing-lg);
            }
        }
        
        .session-timer {
            background: rgba(0, 0, 0, 0.3);
            padding: var(--spacing-sm) var(--spacing-md);
            border-radius: 50px;
            font-size: 0.75rem;
            color: #a0aec0;
            display: inline-flex;
            align-items: center;
            gap: var(--spacing-sm);
            border: 1px solid rgba(255, 215, 0, 0.2);
        }
        
        /* Main Card - Matching registration page */
        .glass-card {
            background: rgba(10, 25, 47, 0.98);
            backdrop-filter: blur(20px);
            border: 1px solid rgba(100, 255, 218, 0.2);
            border-radius: 24px;
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.5);
            position: relative;
            z-index: 1;
            padding: var(--spacing-xl) var(--spacing-lg);
        }
        
        .glass-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            border-radius: 24px;
            padding: 2px;
            background: linear-gradient(45deg, var(--gov-gold), transparent, var(--integrity-teal));
            -webkit-mask: linear-gradient(#fff 0 0) content-box, linear-gradient(#fff 0 0);
            mask: linear-gradient(#fff 0 0) content-box, linear-gradient(#fff 0 0);
            -webkit-mask-composite: xor;
            mask-composite: exclude;
            pointer-events: none;
        }
        
        @media (min-width: 768px) {
            .glass-card {
                padding: var(--spacing-xxl);
            }
        }
        
        /* Input Groups */
        .input-group-gov {
            position: relative;
            margin-bottom: var(--spacing-lg);
        }
        
        .input-group-gov input {
            background: rgba(255, 255, 255, 0.03);
            border: 1px solid rgba(255, 215, 0, 0.2);
            border-radius: 12px;
            padding: 16px 20px 16px 50px;
            color: #fff;
            font-size: 16px;
            width: 100%;
            transition: all 0.3s ease;
        }
        
        .input-group-gov input:focus {
            border-color: var(--gov-gold);
            background: rgba(255, 255, 255, 0.05);
            box-shadow: 0 0 0 3px rgba(255, 215, 0, 0.1);
            outline: none;
        }
        
        .input-group-gov input.is-invalid {
            border-color: var(--gov-red);
            background: rgba(153, 0, 0, 0.05);
        }
        
        .input-icon {
            position: absolute;
            left: 16px;
            top: 50%;
            transform: translateY(-50%);
            color: var(--gov-gold);
            font-size: 1.2rem;
            z-index: 2;
        }
        
        .password-toggle {
            position: absolute;
            right: 16px;
            top: 50%;
            transform: translateY(-50%);
            background: transparent;
            border: none;
            color: rgba(255, 255, 255, 0.5);
            cursor: pointer;
            z-index: 2;
            padding: 8px;
        }
        
        .password-toggle:hover {
            color: var(--gov-gold);
        }
        
        /* Security Notice */
        .login-notice {
            background: rgba(107, 70, 193, 0.1);
            border: 1px solid var(--audit-purple);
            border-radius: 8px;
            padding: var(--spacing-md);
            margin: var(--spacing-lg) 0;
            font-size: 0.8rem;
            color: #cbd5e0;
            display: flex;
            align-items: center;
            gap: var(--spacing-md);
        }
        
        .login-notice i {
            color: var(--audit-purple);
            font-size: 1.2rem;
        }
        
        /* Failed Attempts Alert */
        .failed-attempts {
            background: rgba(153, 0, 0, 0.1);
            border-left: 4px solid var(--gov-red);
            padding: var(--spacing-md);
            border-radius: 8px;
            margin: var(--spacing-lg) 0;
            display: none;
            align-items: center;
            gap: var(--spacing-md);
        }
        
        .failed-attempts i {
            color: var(--gov-red);
            font-size: 1.2rem;
        }
        
        .failed-attempts p {
            color: #e53e3e;
            font-size: 0.85rem;
            margin: 0;
        }
        
        /* Button */
        .btn-gov-primary {
            background: linear-gradient(135deg, var(--gov-gold), #e6b800);
            color: var(--gov-blue);
            font-weight: 700;
            padding: var(--spacing-md) var(--spacing-lg);
            border-radius: 12px;
            border: none;
            width: 100%;
            font-size: 1rem;
            text-transform: uppercase;
            letter-spacing: 1px;
            cursor: pointer;
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
        }
        
        .btn-gov-primary:hover:not(:disabled) {
            transform: translateY(-2px);
            box-shadow: 0 10px 25px -5px rgba(255, 215, 0, 0.3);
        }
        
        .btn-gov-primary:disabled {
            opacity: 0.5;
            cursor: not-allowed;
        }
        
        /* Links */
        .gov-link {
            color: var(--gov-gold);
            text-decoration: none;
            font-size: 0.9rem;
            transition: all 0.3s ease;
            position: relative;
        }
        
        .gov-link:hover {
            color: #e6b800;
            text-decoration: underline;
        }
        
        .gov-link::after {
            content: '';
            position: absolute;
            bottom: -2px;
            left: 0;
            width: 0;
            height: 1px;
            background: var(--gov-gold);
            transition: width 0.3s ease;
        }
        
        .gov-link:hover::after {
            width: 100%;
        }
        
        /* Divider */
        .divider {
            display: flex;
            align-items: center;
            text-align: center;
            margin: var(--spacing-lg) 0;
            color: #4a5568;
        }
        
        .divider::before,
        .divider::after {
            content: '';
            flex: 1;
            border-bottom: 1px solid rgba(255, 215, 0, 0.2);
        }
        
        .divider span {
            padding: 0 var(--spacing-md);
            font-size: 0.85rem;
        }
        
        /* Device Fingerprint */
        .device-fingerprint {
            font-size: 0.7rem;
            color: #718096;
            text-align: center;
            margin-top: var(--spacing-md);
            padding: var(--spacing-sm);
            border-top: 1px solid rgba(255, 255, 255, 0.1);
        }
        
        /* Alert */
        .alert {
            padding: var(--spacing-md);
            border-radius: 12px;
            margin-bottom: var(--spacing-md);
            font-size: 0.9rem;
        }
        
        .alert-success {
            background: rgba(13, 148, 136, 0.1);
            border: 1px solid var(--integrity-teal);
            color: #14b8a6;
        }
        
        .alert-danger {
            background: rgba(153, 0, 0, 0.1);
            border: 1px solid var(--gov-red);
            color: #e53e3e;
        }
        
        /* Remember me checkbox */
        .form-check {
            display: flex;
            align-items: center;
            gap: var(--spacing-sm);
            margin-bottom: var(--spacing-lg);
        }
        
        .form-check-input {
            width: 18px;
            height: 18px;
            background: rgba(255, 255, 255, 0.05);
            border: 1px solid rgba(255, 215, 0, 0.3);
            border-radius: 4px;
            cursor: pointer;
            accent-color: var(--gov-gold);
        }
        
        .form-check-label {
            color: #a0aec0;
            font-size: 0.9rem;
            cursor: pointer;
        }
        
        /* Loading State */
        .btn-loading {
            position: relative;
            pointer-events: none;
            opacity: 0.7;
        }
        
        .btn-loading .btn-text {
            visibility: hidden;
        }
        
        .btn-loading::after {
            content: '';
            position: absolute;
            width: 20px;
            height: 20px;
            top: 50%;
            left: 50%;
            margin-left: -10px;
            margin-top: -10px;
            border: 2px solid transparent;
            border-top-color: var(--gov-blue);
            border-radius: 50%;
            animation: spin 0.6s linear infinite;
        }
        
        @keyframes spin {
            to { transform: rotate(360deg); }
        }
        
        /* Mobile Optimizations */
        @media (max-width: 480px) {
            .glass-card {
                padding: var(--spacing-lg);
            }
            
            .security-badge span {
                font-size: 0.7rem;
            }
            
            .btn-gov-primary {
                font-size: 0.9rem;
                padding: var(--spacing-md);
            }
        }
        
        /* Touch-friendly inputs */
        input, button {
            touch-action: manipulation;
        }
        
        /* Prevent zoom on focus for iOS */
        @supports (-webkit-touch-callout: none) {
            input {
                font-size: 16px !important;
            }
        }
    </style>
</head>
<body>

    <!-- Ambient Security Background -->
    <div class="ambient-bg">
        <div class="floating-shape shape-1" style="background: rgba(255,215,0,0.05);"></div>
        <div class="floating-shape shape-2" style="background: rgba(13,148,136,0.05);"></div>
        <div class="floating-shape shape-3" style="background: rgba(107,70,193,0.05);"></div>
    </div>

    <!-- Login Section -->
    <section class="min-vh-100 d-flex align-items-center py-5" style="position: relative; z-index: 1;">
        <div class="container">
            
            <!-- Security Header -->
            <div class="security-header">
                <div class="security-badge" data-aos="fade-right">
                    <i class="fas fa-shield-alt"></i>
                    <span>SECURE GOVERNMENT PORTAL • LEVEL 3 AUTHENTICATION</span>
                </div>
                <div class="session-timer" data-aos="fade-left">
                    <i class="fas fa-clock"></i>
                    <span>Secure Session</span>
                </div>
            </div>

            <!-- Main Login Card -->
            <div class="glass-card" data-aos="fade-up" data-aos-duration="1000">
                
                <!-- Header -->
                <div class="text-center mb-4">
                    <div class="mb-3">
                        <i class="fas fa-gavel fa-2x" style="color: var(--gov-gold);"></i>
                    </div>
                    <h2 class="fw-bold" style="color: #fff; font-family: 'Poppins', sans-serif;">
                        Integrity Portal Access
                    </h2>
                    <p style="color: #a0aec0;">
                        Secure authentication required for government systems
                    </p>
                </div>

                <!-- Failed Attempts Alert (hidden by default) -->
                <div class="failed-attempts" id="failedAttempts">
                    <i class="fas fa-exclamation-triangle"></i>
                    <p id="failedAttemptsMessage"></p>
                </div>

                <!-- Login Form -->
                <form id="loginForm" novalidate autocomplete="off">
                    <!-- CSRF Token -->
                    <input type="hidden" name="csrf_token" value="<?php echo htmlspecialchars($_SESSION['csrf_token']); ?>">
                    
                    <!-- Honeypot field (anti-bot) -->
                    <div style="position: absolute; left: -9999px; top: -9999px; opacity: 0;">
                        <label for="username">Username</label>
                        <input type="text" id="username" name="username" tabindex="-1" autocomplete="off">
                    </div>

                    <!-- Email Field -->
                    <div class="input-group-gov">
                        <i class="fas fa-envelope input-icon"></i>
                        <input type="email" 
                               id="email" 
                               name="email" 
                               placeholder="Official Email Address" 
                               required
                               autofocus>
                    </div>

                    <!-- Password Field with Toggle -->
                    <div class="input-group-gov">
                        <i class="fas fa-lock input-icon"></i>
                        <input type="password" 
                               id="password" 
                               name="password" 
                               placeholder="Password" 
                               required>
                        <button type="button" class="password-toggle" id="togglePassword">
                            <i class="fas fa-eye"></i>
                        </button>
                    </div>

                    <!-- Simple Math Captcha (optional but recommended) -->
                    <div class="input-group-gov">
                        <i class="fas fa-calculator input-icon"></i>
                        <input type="number" 
                               id="captcha" 
                               name="captcha" 
                               placeholder="What is <?php echo $num1; ?> + <?php echo $num2; ?>?" 
                               required
                               min="10"
                               max="30">
                    </div>

                    <!-- Remember Me Checkbox -->
                    <div class="form-check">
                        <input type="checkbox" class="form-check-input" id="remember" name="remember">
                        <label class="form-check-label" for="remember">
                            <i class="fas fa-laptop me-1"></i> Trust this device for 30 days
                        </label>
                    </div>

                    <!-- Login Button -->
                    <div class="d-grid">
                        <button id="loginBtn" type="submit" class="btn-gov-primary">
                            <span class="btn-text"><i class="fas fa-sign-in-alt me-2"></i> ACCESS SECURE PORTAL</span>
                            <span id="btnSpinner" class="spinner-border spinner-border-sm d-none"></span>
                        </button>
                    </div>
                </form>

                <!-- Alert Box -->
                <div id="loginAlert" class="alert mt-4 d-none" role="alert"></div>

                <!-- Links -->
                <div class="text-center mt-4">
                    <a href="#" class="gov-link me-3">
                        <i class="fas fa-key me-1"></i> Forgot Password?
                    </a>
                    <a href="/KE-AI-PLATFORM/public/index.php?controller=auth&action=register" class="gov-link">
                        <i class="fas fa-user-plus me-1"></i> Request Access
                    </a>
                </div>

                <!-- Divider -->
                <div class="divider">
                    <span>OFFICIAL USE ONLY</span>
                </div>

                <!-- Security Notice -->
                <div class="login-notice">
                    <i class="fas fa-fingerprint"></i>
                    <div>
                        <strong>Authentication Notice:</strong> This is a restricted government system. 
                        All access attempts are logged and monitored. Unauthorized access is prohibited by law.
                    </div>
                </div>

                <!-- Device Fingerprint -->
                <div class="device-fingerprint" id="deviceFingerprint">
                    <i class="fas fa-microchip me-1"></i>
                    <span>Device fingerprint: <span id="fpValue">Calculating...</span></span>
                </div>
            </div>
        </div>
    </section>

    <?php include __DIR__ . '/../layout/footer.php'; ?>

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/crypto-js@4.1.1/crypto-js.min.js"></script>
    
    <script>
    AOS.init({ once: true, duration: 800 });

    // Track failed login attempts
    let failedAttempts = 0;
    const MAX_ATTEMPTS = 5;

    // Generate device fingerprint
    function generateFingerprint() {
        const components = [
            navigator.userAgent,
            navigator.language,
            screen.colorDepth,
            screen.width + 'x' + screen.height,
            new Date().getTimezoneOffset(),
            navigator.hardwareConcurrency || 'unknown',
            navigator.deviceMemory || 'unknown'
        ];
        
        const fingerprint = CryptoJS.SHA256(components.join('###')).toString();
        document.getElementById('fpValue').textContent = fingerprint.substring(0, 8) + '...';
        
        const fpInput = document.createElement('input');
        fpInput.type = 'hidden';
        fpInput.name = 'device_fingerprint';
        fpInput.value = fingerprint;
        document.getElementById('loginForm').appendChild(fpInput);
    }
    generateFingerprint();

    // Password visibility toggle
    document.getElementById('togglePassword').addEventListener('click', function() {
        const input = document.getElementById('password');
        const icon = this.querySelector('i');
        input.type = input.type === 'password' ? 'text' : 'password';
        icon.className = input.type === 'password' ? 'fas fa-eye' : 'fas fa-eye-slash';
    });

    // Show failed attempts warning
    function updateFailedAttempts(count) {
        const attemptsDiv = document.getElementById('failedAttempts');
        const attemptsMsg = document.getElementById('failedAttemptsMessage');
        
        if (count > 0) {
            attemptsDiv.style.display = 'flex';
            const remaining = MAX_ATTEMPTS - count;
            if (remaining <= 0) {
                attemptsMsg.textContent = 'Account locked due to too many failed attempts. Please contact support.';
                document.getElementById('loginBtn').disabled = true;
            } else {
                attemptsMsg.textContent = `Failed attempts: ${count}/${MAX_ATTEMPTS}. ${remaining} attempts remaining.`;
            }
        } else {
            attemptsDiv.style.display = 'none';
        }
    }

    // Form validation
    function validateForm() {
        const email = document.getElementById('email').value;
        const password = document.getElementById('password').value;
        const captcha = document.getElementById('captcha').value;
        
        if (!email) {
            showAlert('Please enter your email address', 'danger');
            return false;
        }
        
        if (!/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email)) {
            showAlert('Please enter a valid email address', 'danger');
            return false;
        }
        
        if (!password) {
            showAlert('Please enter your password', 'danger');
            return false;
        }
        
        if (!captcha) {
            showAlert('Please complete the security check', 'danger');
            return false;
        }
        
        return true;
    }

    function showAlert(message, type) {
        const alertBox = document.getElementById('loginAlert');
        alertBox.className = `alert alert-${type}`;
        alertBox.textContent = message;
        alertBox.classList.remove('d-none');
        
        // Auto-hide after 5 seconds
        setTimeout(() => {
            alertBox.classList.add('d-none');
        }, 5000);
    }

    // Form submission
    document.getElementById('loginForm').addEventListener('submit', async function(e) {
        e.preventDefault();
        
        if (!validateForm()) {
            return;
        }
        
        const btn = document.getElementById('loginBtn');
        const btnText = btn.querySelector('.btn-text');
        const btnSpinner = document.getElementById('btnSpinner');
        const alertBox = document.getElementById('loginAlert');

        btn.disabled = true;
        btnText.style.visibility = 'hidden';
        btnSpinner.classList.remove('d-none');
        alertBox.classList.add('d-none');

        const fd = new FormData(this);

        try {
            const res = await fetch('/KE-AI-PLATFORM/public/index.php?controller=auth&action=login_process', {
                method: 'POST',
                body: fd
            });
            
            const json = await res.json();

            if (json.status === 'success') {
                // Reset failed attempts on success
                failedAttempts = 0;
                updateFailedAttempts(0);
                
                alertBox.className = 'alert alert-success';
                alertBox.innerHTML = '<i class="fas fa-check-circle me-2"></i>' + json.message;
                alertBox.classList.remove('d-none');
                
                // Redirect to dashboard
                setTimeout(() => {
                    window.location.href = json.redirect || '/KE-AI-PLATFORM/public/index.php?controller=dashboard&action=index';
                }, 1500);
            } else {
                // Increment failed attempts
                failedAttempts++;
                updateFailedAttempts(failedAttempts);
                
                alertBox.className = 'alert alert-danger';
                alertBox.innerHTML = '<i class="fas fa-exclamation-circle me-2"></i>' + (json.message || 'Login failed');
                alertBox.classList.remove('d-none');
                
                // Clear password field for security
                document.getElementById('password').value = '';
                document.getElementById('password').focus();
            }
        } catch (err) {
            alertBox.className = 'alert alert-danger';
            alertBox.innerHTML = '<i class="fas fa-exclamation-triangle me-2"></i>Network error. Please try again.';
            alertBox.classList.remove('d-none');
        } finally {
            btn.disabled = false;
            btnText.style.visibility = 'visible';
            btnSpinner.classList.add('d-none');
        }
    });

    // Auto-focus email field
    document.getElementById('email').focus();

    // Add keyboard shortcut (Ctrl+Alt+L to clear form)
    document.addEventListener('keydown', function(e) {
        if (e.ctrlKey && e.altKey && e.key === 'l') {
            e.preventDefault();
            document.getElementById('email').value = '';
            document.getElementById('password').value = '';
            document.getElementById('captcha').value = '';
            document.getElementById('remember').checked = false;
            document.getElementById('email').focus();
        }
    });

    // Touch optimization
    if ('ontouchstart' in window) {
        document.documentElement.classList.add('touch');
    }
    </script>
</body>
</html>