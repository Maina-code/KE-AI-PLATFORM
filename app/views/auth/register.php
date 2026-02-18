<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Set error logging
ini_set('log_errors', 1);
ini_set('error_log', 'C:/xampp/htdocs/KE-AI-PLATFORM/private/logs/registration_errors.log');

// Generate CSRF token with expiration
if (empty($_SESSION['csrf_token']) || empty($_SESSION['csrf_token_expiry']) || $_SESSION['csrf_token_expiry'] < time()) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
    $_SESSION['csrf_token_expiry'] = time() + 3600; // 1 hour expiry
}

// Generate multiple captcha with timer
$num1 = rand(10, 99);
$num2 = rand(10, 99);
$_SESSION['math_answer'] = $num1 + $num2;
$_SESSION['captcha_generated'] = time();
?>

<?php include __DIR__ . '/../layout/landingnavbar.php'; ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=yes">
    <title>Secure Registration - NuruAI Integrity Platform</title>
    
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
        /* Reset and Base Styles */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

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
            
            /* Font sizes */
            --text-xs: 0.75rem;
            --text-sm: 0.875rem;
            --text-base: 1rem;
            --text-lg: 1.125rem;
            --text-xl: 1.25rem;
            --text-2xl: 1.5rem;
            --text-3xl: 1.875rem;
        }
        
        body {
            background: linear-gradient(135deg, #0a192f 0%, #0a1a2f 100%);
            font-family: 'Inter', sans-serif;
            min-height: 100vh;
            position: relative;
            overflow-x: hidden;
            -webkit-font-smoothing: antialiased;
            -moz-osx-font-smoothing: grayscale;
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
        
        /* Mobile-first container */
        .container-fluid {
            width: 50%;
            padding-right: var(--spacing-md);
            padding-left: var(--spacing-md);
            margin-right: auto;
            margin-left: auto;
            margin-top: -10rem;
        }
        
        @media (min-width: 640px) {
            .container-fluid {
                padding-right: var(--spacing-lg);
                padding-left: var(--spacing-lg);
            }
        }
        
        @media (min-width: 768px) {
            .container-fluid {
                max-width: 720px;
                margin: 0 auto;
            }
        }
        
        @media (min-width: 1024px) {
            .container-fluid {
                max-width: 960px;
            }
        }
        
        @media (min-width: 1280px) {
            .container-fluid {
                max-width: 1140px;
            }
        }
        
        /* Security Badge - Responsive */
        .security-header {
            display: flex;
            flex-direction: column;
            gap: var(--spacing-md);
            margin-bottom: var(--spacing-lg);
        }
        
        @media (min-width: 768px) {
            .security-header {
                flex-direction: row;
                justify-content: space-between;
                align-items: center;
            }
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
            font-size: var(--text-xs);
            font-weight: 600;
            backdrop-filter: blur(5px);
            width: fit-content;
        }
        
        @media (min-width: 480px) {
            .security-badge {
                font-size: var(--text-sm);
                padding: var(--spacing-sm) var(--spacing-lg);
            }
        }
        
        .session-timer {
            background: rgba(0, 0, 0, 0.3);
            padding: var(--spacing-sm) var(--spacing-md);
            border-radius: 50px;
            font-size: var(--text-xs);
            color: #a0aec0;
            display: inline-flex;
            align-items: center;
            gap: var(--spacing-sm);
            border: 1px solid rgba(255, 215, 0, 0.2);
            width: fit-content;
        }
        
        @media (min-width: 480px) {
            .session-timer {
                font-size: var(--text-sm);
                padding: var(--spacing-sm) var(--spacing-lg);
            }
        }
        
        /* Main Card */
        .glass-card {
            background: rgba(10, 25, 47, 0.98);
            backdrop-filter: blur(20px);
            border: 1px solid rgba(100, 255, 218, 0.2);
            border-radius: 24px;
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.5);
            position: relative;
            z-index: 1;
            padding: var(--spacing-lg);
        }
        
        @media (min-width: 768px) {
            .glass-card {
                padding: var(--spacing-xxl);
            }
        }
        
        /* Step Wizard */
        .step-wizard {
            display: flex;
            justify-content: space-between;
            margin-bottom: var(--spacing-xl);
            position: relative;
            flex-wrap: wrap;
            gap: var(--spacing-sm);
        }
        
        .step-wizard::before {
            content: '';
            position: absolute;
            top: 15px;
            left: 0;
            right: 0;
            height: 2px;
            background: rgba(255, 215, 0, 0.1);
            z-index: 1;
        }
        
        @media (max-width: 480px) {
            .step-wizard::before {
                top: 12px;
            }
        }
        
        .step-item {
            position: relative;
            z-index: 2;
            background: rgba(10, 25, 47, 0.95);
            padding: 0 var(--spacing-xs);
            text-align: center;
            flex: 1;
            min-width: 60px;
        }
        
        @media (max-width: 480px) {
            .step-item {
                min-width: 45px;
                padding: 0 2px;
            }
        }
        
        .step-number {
            width: 32px;
            height: 32px;
            background: rgba(255, 255, 255, 0.1);
            border: 2px solid rgba(255, 215, 0, 0.3);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto var(--spacing-xs);
            color: #a0aec0;
            font-weight: 600;
            transition: all 0.3s ease;
        }
        
        @media (max-width: 480px) {
            .step-number {
                width: 24px;
                height: 24px;
                font-size: var(--text-xs);
            }
        }
        
        .step-item.active .step-number {
            background: var(--gov-gold);
            border-color: var(--gov-gold);
            color: var(--gov-blue);
            transform: scale(1.1);
            box-shadow: 0 0 15px rgba(255, 215, 0, 0.3);
        }
        
        .step-item.completed .step-number {
            background: var(--integrity-teal);
            border-color: var(--integrity-teal);
            color: white;
        }
        
        .step-label {
            font-size: var(--text-xs);
            color: #a0aec0;
            font-weight: 500;
            white-space: nowrap;
        }
        
        @media (max-width: 480px) {
            .step-label {
                font-size: 0.6rem;
            }
        }
        
        .step-item.active .step-label {
            color: var(--gov-gold);
        }
        
        .step-item.completed .step-label {
            color: var(--integrity-teal);
        }
        
        /* Form Steps */
        .form-step {
            display: none;
            animation: fadeIn 0.5s ease;
        }
        
        .form-step.active {
            display: block;
        }
        
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(10px); }
            to { opacity: 1; transform: translateY(0); }
        }
        
        /* Input Groups - Mobile Optimized */
        .input-group-gov {
            position: relative;
            margin-bottom: var(--spacing-lg);
        }
        
        .input-group-gov input,
        .input-group-gov select {
            background: rgba(255, 255, 255, 0.03);
            border: 1px solid rgba(255, 215, 0, 0.2);
            border-radius: 12px;
            padding: 16px 20px 16px 50px;
            color: #fff;
            font-size: 16px; /* Prevents zoom on mobile */
            width: 100%;
            transition: all 0.3s ease;
            -webkit-appearance: none;
            appearance: none;
        }
        
        @media (max-width: 480px) {
            .input-group-gov input,
            .input-group-gov select {
                padding: 14px 16px 14px 45px;
                font-size: 15px;
            }
        }
        
        .input-group-gov input:focus,
        .input-group-gov select:focus {
            border-color: var(--gov-gold);
            background: rgba(255, 255, 255, 0.05);
            box-shadow: 0 0 0 3px rgba(255, 215, 0, 0.1);
            outline: none;
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
        
        @media (max-width: 480px) {
            .input-icon {
                left: 12px;
                font-size: 1rem;
            }
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
        
        @media (max-width: 480px) {
            .password-toggle {
                right: 12px;
                padding: 6px;
            }
        }
        
        /* Requirement Badges - Responsive Grid */
        .requirements-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: var(--spacing-sm);
            margin-top: var(--spacing-md);
        }
        
        @media (min-width: 768px) {
            .requirements-grid {
                grid-template-columns: repeat(3, 1fr);
            }
        }
        
        .requirement-badge {
            background: rgba(255, 255, 255, 0.05);
            border: 1px solid rgba(255, 215, 0, 0.2);
            border-radius: 20px;
            padding: var(--spacing-sm);
            font-size: var(--text-xs);
            color: #a0aec0;
            transition: all 0.3s ease;
            text-align: center;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }
        
        @media (min-width: 640px) {
            .requirement-badge {
                padding: var(--spacing-sm) var(--spacing-md);
                font-size: var(--text-sm);
            }
        }
        
        .requirement-badge.valid {
            background: rgba(13, 148, 136, 0.1);
            border-color: var(--integrity-teal);
            color: var(--integrity-teal);
        }
        
        /* Navigation Buttons */
        .step-navigation {
            display: flex;
            gap: var(--spacing-md);
            margin-top: var(--spacing-xl);
            flex-direction: column;
        }
        
        @media (min-width: 480px) {
            .step-navigation {
                flex-direction: row;
                justify-content: space-between;
            }
        }
        
        .btn-nav {
            background: rgba(255, 255, 255, 0.05);
            border: 1px solid rgba(255, 215, 0, 0.3);
            color: #fff;
            padding: var(--spacing-md) var(--spacing-lg);
            border-radius: 12px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            flex: 1;
            font-size: var(--text-sm);
        }
        
        @media (max-width: 480px) {
            .btn-nav {
                padding: var(--spacing-md);
            }
        }
        
        .btn-nav:hover:not(:disabled) {
            background: rgba(255, 215, 0, 0.1);
            border-color: var(--gov-gold);
        }
        
        .btn-nav:disabled {
            opacity: 0.3;
            cursor: not-allowed;
        }
        
        .btn-gov-primary {
            background: linear-gradient(135deg, var(--gov-gold), #e6b800);
            color: var(--gov-blue);
            font-weight: 700;
            padding: var(--spacing-md) var(--spacing-lg);
            border-radius: 12px;
            border: none;
            width: 100%;
            font-size: var(--text-base);
            text-transform: uppercase;
            letter-spacing: 1px;
            cursor: pointer;
            transition: all 0.3s ease;
        }
        
        @media (min-width: 768px) {
            .btn-gov-primary {
                padding: var(--spacing-lg) var(--spacing-xl);
                font-size: var(--text-lg);
            }
        }
        
        /* Fraud Alert - Responsive */
        .fraud-alert {
            background: rgba(153, 0, 0, 0.1);
            border-left: 4px solid var(--gov-red);
            padding: var(--spacing-md);
            border-radius: 8px;
            margin: var(--spacing-lg) 0;
            display: flex;
            align-items: flex-start;
            gap: var(--spacing-md);
        }
        
        @media (max-width: 480px) {
            .fraud-alert {
                flex-direction: column;
                align-items: flex-start;
                gap: var(--spacing-sm);
            }
        }
        
        .fraud-alert i {
            color: var(--gov-red);
            font-size: 1.5rem;
            flex-shrink: 0;
        }
        
        .fraud-alert p {
            color: #e53e3e;
            font-size: var(--text-sm);
            margin: 0;
            line-height: 1.5;
        }
        
        /* Progress Bar */
        .form-progress {
            height: 4px;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 2px;
            margin: var(--spacing-lg) 0;
            overflow: hidden;
        }
        
        .form-progress-bar {
            height: 100%;
            background: linear-gradient(90deg, var(--gov-gold), var(--integrity-teal));
            transition: width 0.3s ease;
        }
        
        /* Mobile Optimizations */
        @media (max-width: 380px) {
            .step-label {
                display: none;
            }
            
            .step-number {
                margin-bottom: 0;
            }
        }
        
        /* Touch-friendly inputs */
        input, select, button {
            touch-action: manipulation;
        }
        
        /* Prevent zoom on focus for iOS */
        @supports (-webkit-touch-callout: none) {
            input, select, textarea {
                font-size: 16px !important;
            }
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
            border-top-color: currentColor;
            border-radius: 50%;
            animation: spin 0.6s linear infinite;
        }
        
        @keyframes spin {
            to { transform: rotate(360deg); }
        }
        
        /* Responsive Typography */
        h2 {
            font-size: clamp(1.25rem, 5vw, 1.875rem);
        }
        
        p {
            font-size: clamp(0.875rem, 3vw, 1rem);
        }
        
        /* Integrity Meter */
        .integrity-meter {
            height: 8px;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 4px;
            overflow: hidden;
            margin: 10px 0;
        }
        
        .integrity-meter-fill {
            height: 100%;
            transition: width 0.3s ease;
        }
        
        .meter-low { background: linear-gradient(90deg, #dc2626, #ef4444); }
        .meter-medium { background: linear-gradient(90deg, #d97706, #f59e0b); }
        .meter-high { background: linear-gradient(90deg, #059669, #10b981); }
        .meter-very-high { background: linear-gradient(90deg, var(--integrity-teal), #14b8a6); }
        
        /* Security Note */
        .security-note {
            background: rgba(107, 70, 193, 0.1);
            border: 1px solid var(--audit-purple);
            border-radius: 8px;
            padding: var(--spacing-md);
            margin-top: var(--spacing-lg);
            font-size: var(--text-xs);
            color: #cbd5e0;
            line-height: 1.5;
        }
        
        @media (min-width: 768px) {
            .security-note {
                font-size: var(--text-sm);
            }
        }
        
        /* Device Fingerprint */
        .device-fingerprint {
            font-size: var(--text-xs);
            color: #718096;
            text-align: center;
            margin-top: var(--spacing-md);
            padding: var(--spacing-sm);
            border-top: 1px solid rgba(255, 255, 255, 0.1);
            word-break: break-all;
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

    <!-- Registration Section -->
    <section class="min-vh-100 d-flex align-items-center py-4 py-md-5" style="position: relative; z-index: 1;">
        <div class="container-fluid">
            
            <!-- Security Header -->
            <div class="security-header">
                <div class="security-badge" data-aos="fade-right">
                    <i class="fas fa-shield-alt"></i>
                    <span>GOVERNMENT INTEGRITY PLATFORM</span>
                </div>
                <div class="session-timer" data-aos="fade-left" id="sessionTimer">
                    <i class="fas fa-clock"></i>
                    <span>Session: <span id="timer">60:00</span></span>
                </div>
            </div>

            <!-- Main Registration Card -->
            <div class="glass-card" data-aos="fade-up" data-aos-duration="1000">
                
                <!-- Header -->
                <div class="text-center mb-4">
                    <div class="mb-3">
                        <i class="fas fa-gavel fa-2x fa-md-3x" style="color: var(--gov-gold);"></i>
                    </div>
                    <h2 class="fw-bold" style="color: #fff; font-family: 'Poppins', sans-serif;">
                        Integrity Officer Registration
                    </h2>
                    <p style="color: #a0aec0;">
                        Join the fight against procurement corruption
                    </p>
                </div>

                <!-- Step Wizard -->
                <div class="step-wizard">
                    <div class="step-item active" data-step="1">
                        <div class="step-number">1</div>
                        <div class="step-label">Identity</div>
                    </div>
                    <div class="step-item" data-step="2">
                        <div class="step-number">2</div>
                        <div class="step-label">Credentials</div>
                    </div>
                    <div class="step-item" data-step="3">
                        <div class="step-number">3</div>
                        <div class="step-label">Verification</div>
                    </div>
                    <div class="step-item" data-step="4">
                        <div class="step-number">4</div>
                        <div class="step-label">Review</div>
                    </div>
                </div>

                <!-- Progress Bar -->
                <div class="form-progress">
                    <div class="form-progress-bar" style="width: 25%;"></div>
                </div>

                <!-- Fraud Alert -->
                <div class="fraud-alert">
                    <i class="fas fa-exclamation-triangle"></i>
                    <p>
                        <strong>FRAUD PREVENTION:</strong> All attempts are logged. False information is a criminal offense under the Anti-Corruption Act.
                    </p>
                </div>

                <!-- Registration Form -->
                <form id="registerForm" novalidate autocomplete="off">
                    <!-- Security Tokens -->
                    <input type="hidden" name="csrf_token" value="<?php echo htmlspecialchars($_SESSION['csrf_token']); ?>">
                    <input type="hidden" name="csrf_token_expiry" value="<?php echo $_SESSION['csrf_token_expiry']; ?>">
                    <input type="hidden" name="form_timestamp" value="<?php echo time(); ?>" id="formTimestamp">
                    
                    <!-- Honeypot -->
                    <div style="position: absolute; left: -9999px; top: -9999px; opacity: 0;">
                        <label for="website">Website</label>
                        <input type="text" id="website" name="website" tabindex="-1" autocomplete="off">
                    </div>

                    <!-- Step 1: Identity -->
                    <div class="form-step active" id="step1">
                        <div class="input-group-gov">
                            <i class="fas fa-id-card input-icon"></i>
                            <input type="text" id="full_name" name="full_name" placeholder="Full Legal Name" required>
                        </div>

                        <div class="input-group-gov">
                            <i class="fas fa-envelope input-icon"></i>
                            <input type="email" id="email" name="email" placeholder="Official Email Address" required>
                        </div>

                        <div class="input-group-gov">
                            <i class="fas fa-phone-alt input-icon"></i>
                            <input type="tel" id="phone" name="phone" placeholder="Phone Number (+254...)" required>
                        </div>

                        <div class="input-group-gov">
                            <i class="fas fa-passport input-icon"></i>
                            <input type="text" id="gov_id" name="gov_id" placeholder="National ID / Passport Number" required>
                        </div>

                        <div class="input-group-gov">
                            <i class="fas fa-building input-icon"></i>
                            <select id="department" name="department" required>
                                <option value="" disabled selected>Select Department</option>
                                <option value="procurement">Procurement</option>
                                <option value="audit">Audit</option>
                                <option value="finance">Finance</option>
                                <option value="integrity">Integrity & Anti-Corruption</option>
                                <option value="legal">Legal Affairs</option>
                            </select>
                        </div>
                    </div>

                    <!-- Step 2: Credentials -->
                    <div class="form-step" id="step2">
                        <div class="mb-4">
                            <label class="form-label fw-semibold" style="color: #fff;">
                                <i class="fas fa-lock me-2" style="color: var(--gov-gold);"></i>
                                Create Password
                            </label>
                            
                            <div class="input-group-gov">
                                <i class="fas fa-key input-icon"></i>
                                <input type="password" id="password" name="password" placeholder="Enter password" required minlength="12">
                                <button type="button" class="password-toggle" id="togglePassword">
                                    <i class="fas fa-eye"></i>
                                </button>
                            </div>
                            
                            <!-- Integrity Meter -->
                            <div class="mt-3">
                                <div class="d-flex justify-content-between align-items-center mb-2">
                                    <span style="color: #a0aec0; font-size: var(--text-sm);">
                                        <i class="fas fa-shield-alt me-1"></i>Password Strength
                                    </span>
                                    <span id="passwordStrengthText" style="color: #a0aec0; font-size: var(--text-sm);">Very Weak</span>
                                </div>
                                <div class="integrity-meter">
                                    <div id="passwordStrengthBar" class="integrity-meter-fill meter-low" style="width: 0%;"></div>
                                </div>
                            </div>
                            
                            <!-- Requirements Grid -->
                            <div class="requirements-grid mt-3">
                                <span id="reqLength" class="requirement-badge">
                                    <i class="fas fa-times-circle me-1"></i> 12+ chars
                                </span>
                                <span id="reqLowercase" class="requirement-badge">
                                    <i class="fas fa-times-circle me-1"></i> Lowercase
                                </span>
                                <span id="reqUppercase" class="requirement-badge">
                                    <i class="fas fa-times-circle me-1"></i> Uppercase
                                </span>
                                <span id="reqNumber" class="requirement-badge">
                                    <i class="fas fa-times-circle me-1"></i> Number
                                </span>
                                <span id="reqSpecial" class="requirement-badge">
                                    <i class="fas fa-times-circle me-1"></i> Special
                                </span>
                                <span id="reqNoSequence" class="requirement-badge">
                                    <i class="fas fa-times-circle me-1"></i> No sequences
                                </span>
                            </div>
                        </div>

                        <div class="mb-4">
                            <div class="input-group-gov">
                                <i class="fas fa-lock input-icon"></i>
                                <input type="password" id="confirm" name="confirm" placeholder="Confirm password" required>
                                <button type="button" class="password-toggle" id="toggleConfirmPassword">
                                    <i class="fas fa-eye"></i>
                                </button>
                            </div>
                            
                            <div id="passwordMatchIndicator" class="mt-2 d-none">
                                <div class="d-flex align-items-center">
                                    <span id="matchIcon" class="me-2"></span>
                                    <small id="matchText" style="color: #a0aec0;"></small>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Step 3: Verification -->
                    <div class="form-step" id="step3">
                        <div class="mb-4">
                            <label class="form-label fw-semibold" style="color: #fff;">
                                <i class="fas fa-calculator me-2" style="color: var(--gov-gold);"></i>
                                Human Verification
                            </label>
                            <div class="input-group-gov">
                                <i class="fas fa-question input-icon"></i>
                                <input type="number" id="captcha" name="captcha" 
                                       placeholder="What is <?php echo $num1; ?> + <?php echo $num2; ?>?" 
                                       required min="0" max="198">
                            </div>
                            <small style="color: #718096; display: block; margin-top: 5px;">
                                <i class="fas fa-hourglass-half"></i> Expires in: <span id="captchaTimer">60s</span>
                            </small>
                        </div>

                        <div class="mb-4">
                            <div class="form-check">
                                <input type="checkbox" class="form-check-input" id="terms" name="terms" required>
                                <label class="form-check-label" for="terms" style="color: #a0aec0; font-size: var(--text-sm);">
                                    I confirm all information is true and accurate
                                </label>
                            </div>
                        </div>
                    </div>

                    <!-- Step 4: Review -->
                    <div class="form-step" id="step4">
                        <div style="background: rgba(255,255,255,0.03); border-radius: 12px; padding: var(--spacing-lg);">
                            <h5 style="color: var(--gov-gold); margin-bottom: var(--spacing-lg);">Review Your Information</h5>
                            
                            <div style="margin-bottom: var(--spacing-md);">
                                <small style="color: #718096; display: block;">Full Name</small>
                                <span style="color: #fff;" id="review_name"></span>
                            </div>
                            
                            <div style="margin-bottom: var(--spacing-md);">
                                <small style="color: #718096; display: block;">Email</small>
                                <span style="color: #fff;" id="review_email"></span>
                            </div>
                            
                            <div style="margin-bottom: var(--spacing-md);">
                                <small style="color: #718096; display: block;">Phone</small>
                                <span style="color: #fff;" id="review_phone"></span>
                            </div>
                            
                            <div style="margin-bottom: var(--spacing-md);">
                                <small style="color: #718096; display: block;">ID Number</small>
                                <span style="color: #fff;" id="review_gov_id"></span>
                            </div>
                            
                            <div style="margin-bottom: var(--spacing-md);">
                                <small style="color: #718096; display: block;">Department</small>
                                <span style="color: #fff;" id="review_department"></span>
                            </div>
                            
                            <div style="background: rgba(255,215,0,0.1); border-radius: 8px; padding: var(--spacing-md); margin-top: var(--spacing-lg);">
                                <i class="fas fa-info-circle" style="color: var(--gov-gold); margin-right: var(--spacing-sm);"></i>
                                <span style="color: #a0aec0; font-size: var(--text-sm);">Please verify all information before submitting</span>
                            </div>
                        </div>
                    </div>

                    <!-- Navigation Buttons -->
                    <div class="step-navigation">
                        <button type="button" class="btn-nav" id="prevBtn" disabled>
                            <i class="fas fa-arrow-left me-2"></i> Previous
                        </button>
                        <button type="button" class="btn-nav" id="nextBtn">
                            Next <i class="fas fa-arrow-right ms-2"></i>
                        </button>
                    </div>

                    <!-- Submit Button (hidden initially) -->
                    <div class="d-grid" id="submitBtnContainer" style="display: none !important;">
                        <button id="registerBtn" type="submit" class="btn-gov-primary">
                            <span id="btnText"><i class="fas fa-user-shield me-2"></i> COMPLETE REGISTRATION</span>
                            <span id="btnSpinner" class="spinner-border spinner-border-sm d-none"></span>
                        </button>
                    </div>
                </form>

                <!-- Alert Box -->
                <div id="registerAlert" class="alert mt-4 d-none" role="alert"></div>

                <!-- Login Link -->
                <div class="text-center mt-4">
                    <p class="mb-2" style="color: #a0aec0; font-size: var(--text-sm);">Already registered?</p>
                    <a href="/KE-AI-PLATFORM/public/index.php?controller=auth&action=login" class="btn btn-outline-warning rounded-pill px-4 py-2" style="border-color: var(--gov-gold); color: var(--gov-gold); font-size: var(--text-sm);">
                        <i class="fas fa-sign-in-alt me-2"></i> Access Portal
                    </a>
                </div>

                <!-- Security Notes -->
                <div class="security-note">
                    <i class="fas fa-fingerprint"></i>
                    <strong>AES-256 Encrypted:</strong> All data is encrypted. Registration attempts are logged with IP and device fingerprint.
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
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/crypto-js@4.1.1/crypto-js.min.js"></script>
    
    <script>
    AOS.init({ once: true, duration: 800 });

    // Session Timer
    let sessionTime = 3600;
    const timerElement = document.getElementById('timer');
    
    function updateTimer() {
        const minutes = Math.floor(sessionTime / 60);
        const seconds = sessionTime % 60;
        timerElement.textContent = `${minutes.toString().padStart(2, '0')}:${seconds.toString().padStart(2, '0')}`;
        
        if (sessionTime > 0) {
            sessionTime--;
        } else {
            alert('Session expired. Please refresh the page.');
            window.location.href = '/KE-AI-PLATFORM/public/index.php?controller=auth&action=login';
        }
    }
    setInterval(updateTimer, 1000);

    // Captcha Timer
    let captchaTime = 600;
    const captchaTimerElement = document.getElementById('captchaTimer');
    
    function updateCaptchaTimer() {
        captchaTimerElement.textContent = `${captchaTime}s`;
        if (captchaTime > 0) {
            captchaTime--;
        } else {
            alert('Captcha expired. Please refresh the page.');
            location.reload();
        }
    }
    setInterval(updateCaptchaTimer, 1000);

    // Device Fingerprint
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
        document.getElementById('registerForm').appendChild(fpInput);
    }
    generateFingerprint();

    // Step Navigation
    let currentStep = 1;
    const totalSteps = 4;
    
    const steps = document.querySelectorAll('.form-step');
    const stepItems = document.querySelectorAll('.step-item');
    const prevBtn = document.getElementById('prevBtn');
    const nextBtn = document.getElementById('nextBtn');
    const progressBar = document.querySelector('.form-progress-bar');
    const submitContainer = document.getElementById('submitBtnContainer');
    
    function updateStep() {
        // Update steps visibility
        steps.forEach((step, index) => {
            step.classList.toggle('active', index + 1 === currentStep);
        });
        
        // Update step indicators
        stepItems.forEach((item, index) => {
            const stepNum = index + 1;
            item.classList.toggle('active', stepNum === currentStep);
            item.classList.toggle('completed', stepNum < currentStep);
        });
        
        // Update buttons
        prevBtn.disabled = currentStep === 1;
        
        if (currentStep === totalSteps) {
            nextBtn.style.display = 'none';
            submitContainer.style.display = 'block';
        } else {
            nextBtn.style.display = 'block';
            submitContainer.style.display = 'none';
        }
        
        // Update progress bar
        const progress = (currentStep / totalSteps) * 100;
        progressBar.style.width = progress + '%';
        
        // Update review step
        if (currentStep === 4) {
            updateReview();
        }
        
        // Scroll to top of form
        document.querySelector('.glass-card').scrollIntoView({ behavior: 'smooth', block: 'start' });
    }
    
    function updateReview() {
        document.getElementById('review_name').textContent = document.getElementById('full_name').value || 'Not provided';
        document.getElementById('review_email').textContent = document.getElementById('email').value || 'Not provided';
        document.getElementById('review_phone').textContent = document.getElementById('phone').value || 'Not provided';
        document.getElementById('review_gov_id').textContent = document.getElementById('gov_id').value || 'Not provided';
        
        const dept = document.getElementById('department');
        document.getElementById('review_department').textContent = dept.options[dept.selectedIndex]?.text || 'Not selected';
    }
    
    function validateStep(step) {
        switch(step) {
            case 1:
                const name = document.getElementById('full_name').value;
                const email = document.getElementById('email').value;
                const phone = document.getElementById('phone').value;
                const govId = document.getElementById('gov_id').value;
                const dept = document.getElementById('department').value;
                
                if (!name || !email || !phone || !govId || !dept) {
                    showAlert('Please fill in all fields', 'danger');
                    return false;
                }
                
                if (!/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email)) {
                    showAlert('Please enter a valid email address', 'danger');
                    return false;
                }
                
                if (!/^\+?[0-9]{10,15}$/.test(phone.replace(/\s/g, ''))) {
                    showAlert('Please enter a valid phone number', 'danger');
                    return false;
                }
                break;
                
            case 2:
                const password = document.getElementById('password').value;
                const confirm = document.getElementById('confirm').value;
                const strength = checkPasswordStrength(password);
                
                if (password.length < 12) {
                    showAlert('Password must be at least 12 characters', 'danger');
                    return false;
                }
                
                if (!strength.checks.lowercase || !strength.checks.uppercase || 
                    !strength.checks.number || !strength.checks.special || !strength.checks.noSequence) {
                    showAlert('Please meet all password requirements', 'danger');
                    return false;
                }
                
                if (password !== confirm) {
                    showAlert('Passwords do not match', 'danger');
                    return false;
                }
                break;
                
            case 3:
                const captcha = document.getElementById('captcha').value;
                if (!captcha) {
                    showAlert('Please complete the captcha', 'danger');
                    return false;
                }
                
                if (!document.getElementById('terms').checked) {
                    showAlert('You must accept the terms', 'danger');
                    return false;
                }
                break;
        }
        
        return true;
    }
    
    function showAlert(message, type) {
        const alertBox = document.getElementById('registerAlert');
        alertBox.className = `alert alert-${type} mt-4`;
        alertBox.textContent = message;
        alertBox.classList.remove('d-none');
        
        setTimeout(() => {
            alertBox.classList.add('d-none');
        }, 3000);
    }
    
    prevBtn.addEventListener('click', () => {
        if (currentStep > 1) {
            currentStep--;
            updateStep();
        }
    });
    
    nextBtn.addEventListener('click', () => {
        if (validateStep(currentStep)) {
            if (currentStep < totalSteps) {
                currentStep++;
                updateStep();
            }
        }
    });

    // Password strength checker
    function checkPasswordStrength(password) {
        const checks = {
            length: password.length >= 12,
            lowercase: /[a-z]/.test(password),
            uppercase: /[A-Z]/.test(password),
            number: /[0-9]/.test(password),
            special: /[^A-Za-z0-9]/.test(password),
            noSequence: !/(.)\1{2,}/.test(password) && !/(012|123|234|345|456|567|678|789|890|abc|bcd|cde|def|efg|fgh|ghi|hij|ijk|jkl|klm|lmn|mno|nop|opq|pqr|qrs|rst|stu|tuv|uvw|vwx|wxy|xyz)/i.test(password)
        };
        
        let strength = 0;
        Object.values(checks).forEach(valid => {
            if (valid) strength += 16.66;
        });
        
        return { strength, checks };
    }

    // Update password strength
    function updatePasswordStrength(password) {
        const result = checkPasswordStrength(password);
        const bar = document.getElementById('passwordStrengthBar');
        const text = document.getElementById('passwordStrengthText');
        
        bar.style.width = result.strength + '%';
        
        bar.className = 'integrity-meter-fill';
        if (result.strength < 33) {
            bar.classList.add('meter-low');
            text.textContent = 'Very Weak';
            text.style.color = '#ef4444';
        } else if (result.strength < 50) {
            bar.classList.add('meter-low');
            text.textContent = 'Weak';
            text.style.color = '#f59e0b';
        } else if (result.strength < 75) {
            bar.classList.add('meter-medium');
            text.textContent = 'Medium';
            text.style.color = '#fbbf24';
        } else if (result.strength < 90) {
            bar.classList.add('meter-high');
            text.textContent = 'Strong';
            text.style.color = '#10b981';
        } else {
            bar.classList.add('meter-very-high');
            text.textContent = 'Very Strong';
            text.style.color = '#14b8a6';
        }
        
        const badges = {
            length: document.getElementById('reqLength'),
            lowercase: document.getElementById('reqLowercase'),
            uppercase: document.getElementById('reqUppercase'),
            number: document.getElementById('reqNumber'),
            special: document.getElementById('reqSpecial'),
            noSequence: document.getElementById('reqNoSequence')
        };
        
        Object.keys(badges).forEach(key => {
            const badge = badges[key];
            const isValid = result.checks[key];
            badge.className = `requirement-badge ${isValid ? 'valid' : ''}`;
            badge.innerHTML = isValid ? 
                '<i class="fas fa-check-circle me-1"></i> ' + badge.textContent.split(' ').slice(1).join(' ') :
                '<i class="fas fa-times-circle me-1"></i> ' + badge.textContent.split(' ').slice(1).join(' ');
        });
    }

    // Password match checker
    function checkPasswordMatch() {
        const password = document.getElementById('password').value;
        const confirm = document.getElementById('confirm').value;
        const indicator = document.getElementById('passwordMatchIndicator');
        const icon = document.getElementById('matchIcon');
        const text = document.getElementById('matchText');
        
        if (confirm.length === 0) {
            indicator.classList.add('d-none');
            return;
        }
        
        indicator.classList.remove('d-none');
        
        if (password === confirm && password.length >= 12) {
            icon.className = 'text-success';
            icon.innerHTML = '<i class="fas fa-check-circle"></i>';
            text.textContent = 'Passwords match';
            text.className = 'text-success';
        } else if (password !== confirm) {
            icon.className = 'text-danger';
            icon.innerHTML = '<i class="fas fa-times-circle"></i>';
            text.textContent = 'Passwords do not match';
            text.className = 'text-danger';
        }
    }

    // Event Listeners
    document.getElementById('togglePassword').addEventListener('click', function() {
        const input = document.getElementById('password');
        const icon = this.querySelector('i');
        input.type = input.type === 'password' ? 'text' : 'password';
        icon.className = input.type === 'password' ? 'fas fa-eye' : 'fas fa-eye-slash';
    });

    document.getElementById('toggleConfirmPassword').addEventListener('click', function() {
        const input = document.getElementById('confirm');
        const icon = this.querySelector('i');
        input.type = input.type === 'password' ? 'text' : 'password';
        icon.className = input.type === 'password' ? 'fas fa-eye' : 'fas fa-eye-slash';
    });

    document.getElementById('password').addEventListener('input', function() {
        updatePasswordStrength(this.value);
        checkPasswordMatch();
    });

    document.getElementById('confirm').addEventListener('input', checkPasswordMatch);

    // Form submission
    document.getElementById('registerForm').addEventListener('submit', async function(e) {
        e.preventDefault();
        
        if (!validateStep(currentStep)) {
            return;
        }
        
        const btn = document.getElementById('registerBtn');
        const btnText = document.getElementById('btnText');
        const btnSpinner = document.getElementById('btnSpinner');
        const alertBox = document.getElementById('registerAlert');

        btn.disabled = true;
        btnText.classList.add('d-none');
        btnSpinner.classList.remove('d-none');
        alertBox.classList.add('d-none');

        const fd = new FormData(this);
        fd.append('form_completion_time', Date.now() - (document.getElementById('formTimestamp').value * 1000));

        try {
            const res = await fetch('/KE-AI-PLATFORM/public/index.php?controller=auth&action=register_process', {
                method: 'POST',
                body: fd
            });
            
            const json = await res.json();

            if (json.status === 'success') {
                alertBox.className = 'alert alert-success mt-4';
                alertBox.innerHTML = '<i class="fas fa-check-circle me-2"></i>' + json.message;
                alertBox.classList.remove('d-none');
                
                setTimeout(() => {
                    window.location.href = '/KE-AI-PLATFORM/public/index.php?controller=auth&action=login';
                }, 2000);
            } else {
                alertBox.className = 'alert alert-danger mt-4';
                alertBox.innerHTML = '<i class="fas fa-exclamation-circle me-2"></i>' + json.message;
                alertBox.classList.remove('d-none');
            }
        } catch (err) {
            alertBox.className = 'alert alert-danger mt-4';
            alertBox.innerHTML = '<i class="fas fa-exclamation-triangle me-2"></i>Network error';
            alertBox.classList.remove('d-none');
        } finally {
            btn.disabled = false;
            btnText.classList.remove('d-none');
            btnSpinner.classList.add('d-none');
        }
    });

    // Touch optimization
    if ('ontouchstart' in window) {
        document.documentElement.classList.add('touch');
    }
    </script>
</body>
</html>