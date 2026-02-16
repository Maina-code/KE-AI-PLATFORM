<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Set error logging to your specified file
ini_set('log_errors', 1);
ini_set('error_log', 'C:/xampp/htdocs/tsfreighters/error_log.txt');

// Function to log errors
function logError($message, $data = []) {
    $logMessage = "[" . date('Y-m-d H:i:s') . "] ERROR: " . $message;
    if (!empty($data)) {
        $logMessage .= " | Data: " . json_encode($data);
    }
    $logMessage .= PHP_EOL;
    error_log($logMessage);
}

// Generate CSRF token
if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}

// Simple math captcha
$num1 = rand(1, 9);
$num2 = rand(1, 9);
$_SESSION['math_answer'] = $num1 + $num2;
?>

<?php include __DIR__ . '/../layout/header.php'; ?>

<section class="py-5 bg-light min-vh-100 d-flex align-items-center">
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-lg-6 col-md-8" data-aos="fade-up">
        <div class="card shadow-lg border-0 rounded-4 overflow-hidden">
          <div class="card-body p-4 p-md-5 bg-white">
            <div class="text-center mb-4">
              <i class="fas fa-user-plus fa-3x text-warning mb-2"></i>
              <h3 class="fw-bold">Create Your Account</h3>
              <p class="text-muted small">Sign up to access your shipments and support.</p>
            </div>

            <form id="registerForm" novalidate>
              <input type="hidden" name="csrf_token" value="<?php echo htmlspecialchars($_SESSION['csrf_token']); ?>">

              <div class="mb-3">
                <label for="full_name" class="form-label fw-semibold">Full Name</label>
                <input type="text" id="full_name" name="full_name" class="form-control form-control-lg rounded-pill px-4" placeholder="Full name" required>
              </div>

              <div class="mb-3">
                <label for="email" class="form-label fw-semibold">Email Address</label>
                <input type="email" id="email" name="email" class="form-control form-control-lg rounded-pill px-4" placeholder="you@example.com" required>
              </div>

              <div class="mb-3">
                <label for="phone" class="form-label fw-semibold">Phone Number</label>
                <input type="text" id="phone" name="phone" class="form-control form-control-lg rounded-pill px-4" placeholder="+2547XXXXXXXX">
              </div>

              <!-- Enhanced Password Section -->
              <div class="mb-4">
                <label for="password" class="form-label fw-semibold">Password</label>
                <div class="input-group mb-3">
                  <input type="password" id="password" name="password" class="form-control form-control-lg rounded-start-pill px-4" placeholder="Create a strong password" minlength="8" required>
                  <button class="btn btn-outline-secondary rounded-end-pill" type="button" id="togglePassword" aria-label="Show password">
                    <i class="fas fa-eye"></i>
                  </button>
                </div>
                
                <!-- Password Strength Meter -->
                <div class="password-strength mb-3">
                  <div class="progress" style="height: 6px;">
                    <div id="passwordStrengthBar" class="progress-bar" role="progressbar" style="width: 0%;"></div>
                  </div>
                  <div class="d-flex justify-content-between mt-1">
                    <small id="passwordStrengthText" class="text-muted">Password strength</small>
                    <small id="passwordLength" class="text-muted">0/8 characters</small>
                  </div>
                </div>
                
                <!-- Password Requirements -->
                <div id="passwordRequirements" class="small text-muted">
                  <div class="form-text mb-1 fw-semibold">Password must contain:</div>
                  <div class="d-flex flex-wrap gap-3">
                    <div class="d-flex align-items-center">
                      <span id="reqLength" class="text-danger me-1"><i class="fas fa-times-circle"></i></span>
                      <span>At least 8 characters</span>
                    </div>
                    <div class="d-flex align-items-center">
                      <span id="reqLowercase" class="text-danger me-1"><i class="fas fa-times-circle"></i></span>
                      <span>Lowercase letter</span>
                    </div>
                    <div class="d-flex align-items-center">
                      <span id="reqUppercase" class="text-danger me-1"><i class="fas fa-times-circle"></i></span>
                      <span>Uppercase letter</span>
                    </div>
                    <div class="d-flex align-items-center">
                      <span id="reqNumber" class="text-danger me-1"><i class="fas fa-times-circle"></i></span>
                      <span>Number</span>
                    </div>
                    <div class="d-flex align-items-center">
                      <span id="reqSpecial" class="text-danger me-1"><i class="fas fa-times-circle"></i></span>
                      <span>Special character</span>
                    </div>
                  </div>
                </div>
              </div>

              <!-- Confirm Password with Toggle -->
              <div class="mb-4">
                <label for="confirm" class="form-label fw-semibold">Confirm Password</label>
                <div class="input-group mb-2">
                  <input type="password" id="confirm" name="confirm" class="form-control form-control-lg rounded-start-pill px-4" placeholder="Re-enter your password" required>
                  <button class="btn btn-outline-secondary rounded-end-pill" type="button" id="toggleConfirmPassword" aria-label="Show password">
                    <i class="fas fa-eye"></i>
                  </button>
                </div>
                
                <!-- Password Match Indicator -->
                <div id="passwordMatchIndicator" class="d-none">
                  <div class="d-flex align-items-center">
                    <span id="matchIcon" class="me-2"></span>
                    <small id="matchText"></small>
                  </div>
                </div>
              </div>

              <!-- Math Captcha -->
              <div class="mb-4">
                <label for="captcha" class="form-label fw-semibold">
                  Prove you're human: What is <strong><?php echo "$num1 + $num2"; ?></strong>?
                </label>
                <input type="number" id="captcha" name="captcha" class="form-control form-control-lg rounded-pill px-4" placeholder="Your answer" required>
              </div>

              <div class="d-grid">
                <button id="registerBtn" type="submit" class="btn btn-warning btn-lg rounded-pill shadow-sm py-3">
                  <span id="btnText"><i class="fas fa-user-plus me-2"></i> Create Account</span>
                  <span id="btnSpinner" class="spinner-border spinner-border-sm d-none" role="status" aria-hidden="true"></span>
                </button>
              </div>
            </form>

            <div id="registerAlert" class="alert mt-4 d-none" role="alert"></div>

            <div class="text-center mt-4">
              <p class="small text-muted mb-2">Already have an account?</p>
              <a href="/tsfreighters/public/index.php?controller=customer&action=login" class="btn btn-outline-warning rounded-pill px-4 py-2">
                <i class="fas fa-sign-in-alt me-2"></i> Login
              </a>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<?php include __DIR__ . '/../layout/footer.php'; ?>

<!-- JS: AOS + Behavior -->
<link href="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.js"></script>
<script>
AOS.init({ once:true, duration:800 });

// Password validation functions
function checkPasswordStrength(password) {
    let strength = 0;
    const requirements = {
        length: password.length >= 8,
        lowercase: /[a-z]/.test(password),
        uppercase: /[A-Z]/.test(password),
        number: /[0-9]/.test(password),
        special: /[^A-Za-z0-9]/.test(password)
    };
    
    // Calculate strength
    if (requirements.length) strength += 20;
    if (requirements.lowercase) strength += 20;
    if (requirements.uppercase) strength += 20;
    if (requirements.number) strength += 20;
    if (requirements.special) strength += 20;
    
    return { strength, requirements };
}

function updatePasswordStrength(password) {
    const result = checkPasswordStrength(password);
    const bar = document.getElementById('passwordStrengthBar');
    const text = document.getElementById('passwordStrengthText');
    const lengthText = document.getElementById('passwordLength');
    
    // Update progress bar
    bar.style.width = `${result.strength}%`;
    
    // Update colors and text based on strength
    if (result.strength < 40) {
        bar.className = 'progress-bar bg-danger';
        text.textContent = 'Weak';
        text.className = 'text-danger';
    } else if (result.strength < 80) {
        bar.className = 'progress-bar bg-warning';
        text.textContent = 'Medium';
        text.className = 'text-warning';
    } else {
        bar.className = 'progress-bar bg-success';
        text.textContent = 'Strong';
        text.className = 'text-success';
    }
    
    // Update length indicator
    lengthText.textContent = `${password.length}/8 characters`;
    lengthText.className = password.length >= 8 ? 'text-success' : 'text-danger';
    
    // Update requirement indicators
    const reqIds = ['Length', 'Lowercase', 'Uppercase', 'Number', 'Special'];
    reqIds.forEach(req => {
        const element = document.getElementById(`req${req}`);
        const isValid = result.requirements[req.toLowerCase()];
        element.className = isValid ? 'text-success me-1' : 'text-danger me-1';
        element.innerHTML = isValid ? '<i class="fas fa-check-circle"></i>' : '<i class="fas fa-times-circle"></i>';
    });
}

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
    
    if (password === confirm && password.length >= 8) {
        icon.className = 'text-success';
        icon.innerHTML = '<i class="fas fa-check-circle"></i>';
        text.textContent = 'Passwords match!';
        text.className = 'text-success';
    } else {
        icon.className = 'text-danger';
        icon.innerHTML = '<i class="fas fa-times-circle"></i>';
        text.textContent = password.length < 8 ? 'Create a valid password first' : 'Passwords do not match';
        text.className = 'text-danger';
    }
}

// Enhanced password visibility toggles
document.getElementById('togglePassword').addEventListener('click', function() {
    const input = document.getElementById('password');
    const icon = this.querySelector('i');
    const isPassword = input.type === 'password';
    
    input.type = isPassword ? 'text' : 'password';
    icon.className = isPassword ? 'fas fa-eye-slash' : 'fas fa-eye';
    
    // Add visual feedback
    this.classList.toggle('active', isPassword);
    setTimeout(() => {
        this.blur();
    }, 300);
});

document.getElementById('toggleConfirmPassword').addEventListener('click', function() {
    const input = document.getElementById('confirm');
    const icon = this.querySelector('i');
    const isPassword = input.type === 'password';
    
    input.type = isPassword ? 'text' : 'password';
    icon.className = isPassword ? 'fas fa-eye-slash' : 'fas fa-eye';
    
    // Add visual feedback
    this.classList.toggle('active', isPassword);
    setTimeout(() => {
        this.blur();
    }, 300);
});

// Real-time password validation
document.getElementById('password').addEventListener('input', function(e) {
    updatePasswordStrength(this.value);
    checkPasswordMatch();
});

document.getElementById('confirm').addEventListener('input', checkPasswordMatch);

// Add keyboard shortcuts for password visibility
document.addEventListener('keydown', function(e) {
    // Ctrl + H to toggle password visibility
    if (e.ctrlKey && e.key === 'h') {
        e.preventDefault();
        const passwordInput = document.getElementById('password');
        const toggleBtn = document.getElementById('togglePassword');
        const isPassword = passwordInput.type === 'password';
        
        passwordInput.type = isPassword ? 'text' : 'password';
        toggleBtn.querySelector('i').className = isPassword ? 'fas fa-eye-slash' : 'fas fa-eye';
        toggleBtn.classList.toggle('active', isPassword);
    }
});

// Form validation before submission
document.getElementById('registerForm').addEventListener('submit', async function(e) {
    e.preventDefault();
    
    // Get password values
    const password = document.getElementById('password').value;
    const confirm = document.getElementById('confirm').value;
    const passwordResult = checkPasswordStrength(password);
    
    // Validate password strength
    let valid = true;
    let errorMessage = '';
    
    if (password.length < 8) {
        valid = false;
        errorMessage = 'Password must be at least 8 characters long.';
    } else if (!passwordResult.requirements.lowercase) {
        valid = false;
        errorMessage = 'Password must contain at least one lowercase letter.';
    } else if (!passwordResult.requirements.uppercase) {
        valid = false;
        errorMessage = 'Password must contain at least one uppercase letter.';
    } else if (!passwordResult.requirements.number) {
        valid = false;
        errorMessage = 'Password must contain at least one number.';
    } else if (password !== confirm) {
        valid = false;
        errorMessage = 'Passwords do not match.';
    }
    
    if (!valid) {
        const alertBox = document.getElementById('registerAlert');
        alertBox.className = 'alert alert-danger mt-3';
        alertBox.textContent = errorMessage;
        alertBox.classList.remove('d-none');
        
        // Highlight the problematic field
        if (password.length < 8 || !passwordResult.requirements.lowercase || 
            !passwordResult.requirements.uppercase || !passwordResult.requirements.number) {
            document.getElementById('password').classList.add('is-invalid');
            document.getElementById('password').focus();
        } else if (password !== confirm) {
            document.getElementById('confirm').classList.add('is-invalid');
            document.getElementById('confirm').focus();
        }
        
        // Scroll to error
        alertBox.scrollIntoView({ behavior: 'smooth', block: 'center' });
        return;
    }
    
    // If validation passed, proceed with submission
    const form = this;
    const btn = document.getElementById('registerBtn');
    const btnText = document.getElementById('btnText');
    const btnSpinner = document.getElementById('btnSpinner');
    const alertBox = document.getElementById('registerAlert');

    btn.disabled = true;
    btnText.classList.add('d-none');
    btnSpinner.classList.remove('d-none');
    alertBox.classList.add('d-none');
    
    // Clear any previous invalid states
    document.getElementById('password').classList.remove('is-invalid');
    document.getElementById('confirm').classList.remove('is-invalid');

    const fd = new FormData(form);
    const formData = Object.fromEntries(fd.entries());

    try {
        const res = await fetch('http://localhost/tsfreighters/public/index.php?controller=customer&action=register_process', {
            method: 'POST',
            body: fd
        });
        
        let responseText = await res.text();
        let json;
        
        try {
            json = JSON.parse(responseText);
        } catch (parseError) {
            // Server returned non-JSON response
            console.error('Non-JSON response:', responseText);
            
            let errorMessage = 'Server returned an invalid response';
            if (responseText.includes('error') || responseText.includes('Error') || responseText.includes('Exception')) {
                errorMessage = 'Server error: ' + responseText.substring(0, 200).replace(/<[^>]*>/g, '');
            }
            
            await logClientError('Server returned non-JSON response', {
                status: res.status,
                statusText: res.statusText,
                responsePreview: responseText.substring(0, 500),
                formData: formData
            });
            
            showAlert(errorMessage, 'danger');
            return;
        }

        if (json.status === 'success') {
            showAlert(json.message || 'Registration successful! Redirecting...', 'success');
            setTimeout(() => {
                window.location.href = 'http://localhost/tsfreighters/public/index.php?controller=customer&action=login';
            }, 1500);
        } else {
            showAlert(json.message || 'Registration failed.', 'danger');
        }
    } catch (err) {
        await logClientError('Network error: ' + err.message, {
            formData: formData,
            errorDetails: {
                name: err.name,
                message: err.message
            }
        });
        
        showAlert('Network error. Please check your connection and try again.', 'danger');
    } finally {
        btn.disabled = false;
        btnText.classList.remove('d-none');
        btnSpinner.classList.add('d-none');
    }

    function showAlert(message, type) {
        alertBox.className = `alert alert-${type} mt-3`;
        alertBox.innerHTML = message;
        alertBox.classList.remove('d-none');
        alertBox.scrollIntoView({ behavior: 'smooth', block: 'center' });
    }
    
    async function logClientError(errorMessage, data = {}) {
        try {
            const maskedData = { ...data };
            if (maskedData.formData) {
                maskedData.formData = { ...maskedData.formData };
                if (maskedData.formData.password) maskedData.formData.password = '***MASKED***';
                if (maskedData.formData.confirm) maskedData.formData.confirm = '***MASKED***';
                if (maskedData.formData.csrf_token) maskedData.formData.csrf_token = '***MASKED***';
            }
            
            const response = await fetch('http://localhost/tsfreighters/public/index.php?controller=customer&action=log_error', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify({
                    error: errorMessage,
                    ...maskedData,
                    timestamp: new Date().toISOString(),
                    userAgent: navigator.userAgent,
                    url: window.location.href,
                    referrer: document.referrer
                })
            });
            
            if (!response.ok) {
                console.warn('Failed to log error to server:', response.status);
            }
        } catch (logErr) {
            console.error('Failed to log error:', logErr);
        }
    }
});

// Add some CSS for better visual feedback
const style = document.createElement('style');
style.textContent = `
    .btn-outline-secondary.active {
        background-color: var(--bs-secondary);
        color: white;
    }
    
    .btn-outline-secondary:hover {
        background-color: var(--bs-secondary-bg-subtle);
    }
    
    .input-group .form-control:focus {
        z-index: 3;
    }
    
    .password-strength .progress {
        border-radius: 3px;
    }
    
    #passwordRequirements {
        background-color: #f8f9fa;
        border-radius: 8px;
        padding: 12px;
        margin-top: 10px;
        border-left: 4px solid #ffc107;
    }
    
    #passwordMatchIndicator {
        background-color: #f8f9fa;
        border-radius: 6px;
        padding: 8px 12px;
        margin-top: 8px;
        border-left: 3px solid #6c757d;
        transition: all 0.3s ease;
    }
    
    #passwordMatchIndicator .text-success {
        border-left-color: #198754;
    }
    
    #passwordMatchIndicator .text-danger {
        border-left-color: #dc3545;
    }
    
    .is-invalid {
        border-color: #dc3545 !important;
        background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 12 12' width='12' height='12' fill='none' stroke='%23dc3545'%3e%3ccircle cx='6' cy='6' r='4.5'/%3e%3cpath stroke-linejoin='round' d='M5.8 3.6h.4L6 6.5z'/%3e%3ccircle cx='6' cy='8.2' r='.6' fill='%23dc3545' stroke='none'/%3e%3c/svg%3e") !important;
        background-repeat: no-repeat;
        background-position: right calc(0.375em + 0.1875rem) center;
        background-size: calc(0.75em + 0.375rem) calc(0.75em + 0.375rem);
    }
    
    @keyframes shake {
        0%, 100% { transform: translateX(0); }
        10%, 30%, 50%, 70%, 90% { transform: translateX(-5px); }
        20%, 40%, 60%, 80% { transform: translateX(5px); }
    }
    
    .shake {
        animation: shake 0.5s ease-in-out;
    }
`;
document.head.appendChild(style);
</script>