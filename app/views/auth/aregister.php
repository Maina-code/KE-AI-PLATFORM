<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Set error logging
ini_set('log_errors', 1);
ini_set('error_log', __DIR__ . '/../../../error_log.txt');

// Generate admin-specific CSRF token
if (empty($_SESSION['admin_csrf_token'])) {
    $_SESSION['admin_csrf_token'] = bin2hex(random_bytes(32));
}

// Simple math captcha for admin registration
$admin_num1 = rand(10, 20);
$admin_num2 = rand(5, 15);
$_SESSION['admin_math_answer'] = $admin_num1 + $admin_num2;
?>

<?php include __DIR__ . '/../layout/header.php'; ?>

<section class="py-5 bg-light min-vh-100 d-flex align-items-center">
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-lg-6 col-md-8" data-aos="fade-up">
        <div class="card shadow-lg border-0 rounded-4 overflow-hidden">
          <div class="card-header bg-warning text-white py-4">
            <div class="text-center">
              <i class="fas fa-user-shield fa-3x mb-3"></i>
              <h3 class="fw-bold mb-0">Admin Registration</h3>
              <p class="mb-0">Register new administrative user</p>
            </div>
          </div>
          
          <div class="card-body p-4 p-md-5 bg-white">
            <!-- Admin Info Panel -->
            <div class="alert alert-info mb-4">
              <div class="d-flex">
                <i class="fas fa-info-circle fa-2x me-3"></i>
                <div>
                  <h6 class="alert-heading fw-bold">Registration Authority</h6>
                  <p class="mb-0 small">
                    <strong>Registered by:</strong> <?php echo htmlspecialchars($_SESSION['user_name'] ?? 'Administrator'); ?><br>
                    <strong>Role:</strong> <?php echo htmlspecialchars($_SESSION['user_role'] ?? 'Admin'); ?>
                  </p>
                </div>
              </div>
            </div>

            <form id="adminRegisterForm" novalidate>
              <input type="hidden" name="csrf_token" value="<?php echo htmlspecialchars($_SESSION['admin_csrf_token']); ?>">
              <input type="hidden" name="registered_by" value="<?php echo $_SESSION['user_id'] ?? 0; ?>">

              <!-- Personal Information Section -->
              <div class="mb-4">
                <h6 class="border-bottom pb-2 mb-3 fw-bold">
                  <i class="fas fa-user me-2"></i>Personal Information
                </h6>
                
                <div class="mb-3">
                  <label for="full_name" class="form-label fw-semibold">
                    <i class="fas fa-user-circle me-1"></i>Full Name *
                  </label>
                  <input type="text" id="full_name" name="full_name" class="form-control form-control-lg rounded-pill px-4" placeholder="Full name" required>
                </div>

                <div class="row">
                  <div class="col-md-6 mb-3">
                    <label for="email" class="form-label fw-semibold">
                      <i class="fas fa-envelope me-1"></i>Email Address *
                    </label>
                    <input type="email" id="email" name="email" class="form-control form-control-lg rounded-pill px-4" placeholder="admin@tsfreighters.com" required>
                    <div class="form-text">Use corporate email address</div>
                  </div>
                  
                  <div class="col-md-6 mb-3">
                    <label for="phone" class="form-label fw-semibold">
                      <i class="fas fa-phone me-1"></i>Phone Number *
                    </label>
                    <div class="input-group">
                      <span class="input-group-text rounded-start-pill">+254</span>
                      <input type="text" id="phone" name="phone" class="form-control form-control-lg" placeholder="7XXXXXXXX" pattern="7[0-9]{8}" required>
                    </div>
                  </div>
                </div>
              </div>

              <!-- Role Selection Section -->
              <div class="mb-4">
                <h6 class="border-bottom pb-2 mb-3 fw-bold">
                  <i class="fas fa-user-tag me-2"></i>Role Assignment
                </h6>
                
                <div class="mb-3">
                  <label class="form-label fw-semibold">Select Role *</label>
                  <div class="row g-3">
                    <?php 
                    $allowed_roles = ['staff', 'staff'];
                    if (($_SESSION['user_role'] ?? '') === 'admin') {
                      $allowed_roles[] = 'admin';
                    }
                    
                    foreach ($allowed_roles as $role): 
                      $role_info = [
                        'staff' => ['icon' => 'fa-user-cog', 'color' => 'primary', 'desc' => 'Basic administrative access'],
                        'manager' => ['icon' => 'fa-user-tie', 'color' => 'warning', 'desc' => 'Department management access'],
                        'admin' => ['icon' => 'fa-user-shield', 'color' => 'danger', 'desc' => 'Full system access']
                      ];
                    ?>
                    <div class="col-md-4">
                      <div class="form-check card h-100 border-<?php echo $role_info[$role]['color']; ?>">
                        <input class="form-check-input" type="radio" name="role" id="role_<?php echo $role; ?>" value="<?php echo $role; ?>" required 
                               <?php echo $role === 'staff' ? 'checked' : ''; ?>>
                        <label class="form-check-label card-body d-flex flex-column" for="role_<?php echo $role; ?>">
                          <div class="text-center mb-2">
                            <i class="fas <?php echo $role_info[$role]['icon']; ?> fa-2x text-<?php echo $role_info[$role]['color']; ?>"></i>
                          </div>
                          <h6 class="text-center fw-bold text-<?php echo $role_info[$role]['color']; ?> mb-1">
                            <?php echo ucfirst($role); ?>
                          </h6>
                          <p class="small text-muted text-center mb-0">
                            <?php echo $role_info[$role]['desc']; ?>
                          </p>
                        </label>
                      </div>
                    </div>
                    <?php endforeach; ?>
                  </div>
                </div>
              </div>

              <!-- Enhanced Password Section -->
              <div class="mb-4">
                <h6 class="border-bottom pb-2 mb-3 fw-bold">
                  <i class="fas fa-key me-2"></i>Security Credentials
                </h6>
                
                <div class="mb-3">
                  <label for="password" class="form-label fw-semibold">
                    <i class="fas fa-lock me-1"></i>Password *
                  </label>
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
                    <div class="form-text mb-1 fw-semibold">Admin password must contain:</div>
                    <div class="row g-2">
                      <div class="col-6 d-flex align-items-center">
                        <span id="reqLength" class="text-danger me-1"><i class="fas fa-times-circle"></i></span>
                        <span>At least 8 characters</span>
                      </div>
                      <div class="col-6 d-flex align-items-center">
                        <span id="reqLowercase" class="text-danger me-1"><i class="fas fa-times-circle"></i></span>
                        <span>Lowercase letter</span>
                      </div>
                      <div class="col-6 d-flex align-items-center">
                        <span id="reqUppercase" class="text-danger me-1"><i class="fas fa-times-circle"></i></span>
                        <span>Uppercase letter</span>
                      </div>
                      <div class="col-6 d-flex align-items-center">
                        <span id="reqNumber" class="text-danger me-1"><i class="fas fa-times-circle"></i></span>
                        <span>Number</span>
                      </div>
                      <div class="col-6 d-flex align-items-center">
                        <span id="reqSpecial" class="text-danger me-1"><i class="fas fa-times-circle"></i></span>
                        <span>Special character</span>
                      </div>
                      <div class="col-6 d-flex align-items-center">
                        <span id="reqAlphanumeric" class="text-danger me-1"><i class="fas fa-times-circle"></i></span>
                        <span>Letters + Numbers</span>
                      </div>
                    </div>
                  </div>
                </div>

                <!-- Confirm Password -->
                <div class="mb-3">
                  <label for="confirm_password" class="form-label fw-semibold">
                    <i class="fas fa-lock me-1"></i>Confirm Password *
                  </label>
                  <div class="input-group mb-2">
                    <input type="password" id="confirm_password" name="confirm_password" class="form-control form-control-lg rounded-start-pill px-4" placeholder="Re-enter password" required>
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
              </div>

              <!-- Admin Security Check -->
              <div class="mb-4">
                <h6 class="border-bottom pb-2 mb-3 fw-bold">
                  <i class="fas fa-shield-alt me-2"></i>Security Verification
                </h6>
                
                <div class="mb-3">
                  <label for="captcha" class="form-label fw-semibold">
                    <i class="fas fa-calculator me-1"></i>Admin Verification:
                    What is <strong><?php echo "$admin_num1 + $admin_num2"; ?></strong>?
                  </label>
                  <input type="number" id="captcha" name="captcha" class="form-control form-control-lg rounded-pill px-4" placeholder="Your answer" required>
                  <div class="form-text">This verifies you're authorized to create admin accounts</div>
                </div>
              </div>

              <!-- Terms Agreement -->
              <div class="mb-4">
                <div class="form-check">
                  <input class="form-check-input" type="checkbox" id="agree_terms" name="agree_terms" required>
                  <label class="form-check-label" for="agree_terms">
                    I confirm that I am authorized to create this administrative account and that the information provided is accurate. The user will receive login credentials via email.
                  </label>
                </div>
              </div>

              <!-- Action Buttons -->
              <div class="d-grid gap-2">
                <button id="registerBtn" type="submit" class="btn btn-success btn-lg rounded-pill shadow-sm py-3">
                  <span id="btnText"><i class="fas fa-user-plus me-2"></i> Create Admin Account</span>
                  <span id="btnSpinner" class="spinner-border spinner-border-sm d-none" role="status" aria-hidden="true"></span>
                </button>
                
                <a href="index.php?controller=customer&action=index" class="btn btn-outline-secondary btn-lg rounded-pill py-3">
                  <i class="fas fa-arrow-left me-2"></i> Back to Users List
                </a>
              </div>
            </form>

            <div id="registerAlert" class="alert mt-4 d-none" role="alert"></div>

            <!-- Success Result Template (Hidden) -->
            <div id="successTemplate" class="d-none">
              <div class="alert alert-success mt-4">
                <div class="d-flex">
                  <i class="fas fa-check-circle fa-2x me-3"></i>
                  <div>
                    <h5 class="alert-heading">Admin Account Created Successfully!</h5>
                    <p id="successMessage"></p>
                    <hr>
                    <div class="row mt-3">
                      <div class="col-md-6">
                        <h6>Account Details:</h6>
                        <ul class="list-unstyled small">
                          <li><strong>User ID:</strong> <span id="userId"></span></li>
                          <li><strong>Email:</strong> <span id="userEmail"></span></li>
                          <li><strong>Role:</strong> <span id="userRole"></span></li>
                        </ul>
                      </div>
                      <div class="col-md-6">
                        <h6>Next Steps:</h6>
                        <ul class="small">
                          <li>Credentials sent to user's email</li>
                          <li>User must change password on first login</li>
                          <li>Review account in Users Management</li>
                        </ul>
                      </div>
                    </div>
                    <div class="mt-3">
                      <a href="index.php?controller=customer&action=index" class="btn btn-success btn-sm me-2">
                        <i class="fas fa-users me-1"></i> View Users List
                      </a>
                      <button id="createAnotherBtn" class="btn btn-outline-success btn-sm">
                        <i class="fas fa-plus me-1"></i> Create Another Account
                      </button>
                    </div>
                  </div>
                </div>
              </div>
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

// Enhanced password validation for admin accounts
function checkPasswordStrength(password) {
    let strength = 0;
    const requirements = {
        length: password.length >= 8,
        lowercase: /[a-z]/.test(password),
        uppercase: /[A-Z]/.test(password),
        number: /[0-9]/.test(password),
        special: /[^A-Za-z0-9]/.test(password),
        alphanumeric: /[a-zA-Z]/.test(password) && /[0-9]/.test(password)
    };
    
    // Calculate strength with higher weight for admin passwords
    if (requirements.length) strength += 15;
    if (requirements.lowercase) strength += 15;
    if (requirements.uppercase) strength += 15;
    if (requirements.number) strength += 15;
    if (requirements.special) strength += 20;
    if (requirements.alphanumeric) strength += 20;
    
    // Cap at 100
    strength = Math.min(strength, 100);
    
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
    if (result.strength < 50) {
        bar.className = 'progress-bar bg-danger';
        text.textContent = 'Weak - Not suitable for admin';
        text.className = 'text-danger';
    } else if (result.strength < 80) {
        bar.className = 'progress-bar bg-warning';
        text.textContent = 'Medium - Consider stronger';
        text.className = 'text-warning';
    } else {
        bar.className = 'progress-bar bg-success';
        text.textContent = 'Strong - Suitable for admin';
        text.className = 'text-success';
    }
    
    // Update length indicator
    lengthText.textContent = `${password.length}/8 characters`;
    lengthText.className = password.length >= 8 ? 'text-success' : 'text-danger';
    
    // Update requirement indicators
    const reqIds = ['Length', 'Lowercase', 'Uppercase', 'Number', 'Special', 'Alphanumeric'];
    reqIds.forEach(req => {
        const element = document.getElementById(`req${req}`);
        const isValid = result.requirements[req.toLowerCase()];
        element.className = isValid ? 'text-success me-1' : 'text-danger me-1';
        element.innerHTML = isValid ? '<i class="fas fa-check-circle"></i>' : '<i class="fas fa-times-circle"></i>';
    });
}

function checkPasswordMatch() {
    const password = document.getElementById('password').value;
    const confirm = document.getElementById('confirm_password').value;
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

// Password visibility toggles
document.getElementById('togglePassword').addEventListener('click', function() {
    const input = document.getElementById('password');
    const icon = this.querySelector('i');
    const isPassword = input.type === 'password';
    
    input.type = isPassword ? 'text' : 'password';
    icon.className = isPassword ? 'fas fa-eye-slash' : 'fas fa-eye';
    
    this.classList.toggle('active', isPassword);
    setTimeout(() => this.blur(), 300);
});

document.getElementById('toggleConfirmPassword').addEventListener('click', function() {
    const input = document.getElementById('confirm_password');
    const icon = this.querySelector('i');
    const isPassword = input.type === 'password';
    
    input.type = isPassword ? 'text' : 'password';
    icon.className = isPassword ? 'fas fa-eye-slash' : 'fas fa-eye';
    
    this.classList.toggle('active', isPassword);
    setTimeout(() => this.blur(), 300);
});

// Real-time password validation
document.getElementById('password').addEventListener('input', function(e) {
    updatePasswordStrength(this.value);
    checkPasswordMatch();
});

document.getElementById('confirm_password').addEventListener('input', checkPasswordMatch);

// Form submission
document.getElementById('adminRegisterForm').addEventListener('submit', async function(e) {
    e.preventDefault();
    
    // Get password values
    const password = document.getElementById('password').value;
    const confirm = document.getElementById('confirm_password').value;
    const passwordResult = checkPasswordStrength(password);
    
    // Enhanced validation for admin passwords
    let valid = true;
    let errorMessage = '';
    let errorField = null;
    
    if (password.length < 8) {
        valid = false;
        errorMessage = 'Admin password must be at least 8 characters long.';
        errorField = 'password';
    } else if (!passwordResult.requirements.lowercase) {
        valid = false;
        errorMessage = 'Admin password must contain at least one lowercase letter.';
        errorField = 'password';
    } else if (!passwordResult.requirements.uppercase) {
        valid = false;
        errorMessage = 'Admin password must contain at least one uppercase letter.';
        errorField = 'password';
    } else if (!passwordResult.requirements.number) {
        valid = false;
        errorMessage = 'Admin password must contain at least one number.';
        errorField = 'password';
    } else if (!passwordResult.requirements.special) {
        valid = false;
        errorMessage = 'Admin password must contain at least one special character.';
        errorField = 'password';
    } else if (!passwordResult.requirements.alphanumeric) {
        valid = false;
        errorMessage = 'Admin password must contain both letters and numbers.';
        errorField = 'password';
    } else if (password !== confirm) {
        valid = false;
        errorMessage = 'Passwords do not match.';
        errorField = 'confirm_password';
    }
    
    // Validate role
    const selectedRole = document.querySelector('input[name="role"]:checked');
    if (!selectedRole) {
        valid = false;
        errorMessage = 'Please select a role for the user.';
    }
    
    // Validate terms agreement
    if (!document.getElementById('agree_terms').checked) {
        valid = false;
        errorMessage = 'You must agree to create this administrative account.';
    }
    
    if (!valid) {
        const alertBox = document.getElementById('registerAlert');
        alertBox.className = 'alert alert-danger mt-3';
        alertBox.innerHTML = '<i class="fas fa-exclamation-circle me-2"></i>' + errorMessage;
        alertBox.classList.remove('d-none');
        
        // Highlight the problematic field
        if (errorField) {
            document.getElementById(errorField).classList.add('is-invalid');
            document.getElementById(errorField).focus();
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
    const inputs = form.querySelectorAll('.is-invalid');
    inputs.forEach(input => input.classList.remove('is-invalid'));

    const fd = new FormData(form);
    const formData = Object.fromEntries(fd.entries());

    try {
        const res = await fetch('index.php?controller=admin&action=registerProcess', {method: 'POST',
            body: fd
        });
        
        let responseText = await res.text();
        let json;
        
        try {
            json = JSON.parse(responseText);
        } catch (parseError) {
            console.error('Non-JSON response:', responseText);
            
            let errorMessage = 'Server returned an invalid response';
            if (responseText.includes('error') || responseText.includes('Error') || responseText.includes('Exception')) {
                errorMessage = 'Server error: ' + responseText.substring(0, 200).replace(/<[^>]*>/g, '');
            }
            
            showAlert(errorMessage, 'danger');
            return;
        }

        if (json.status === 'success') {
            // Show success template
            const successTemplate = document.getElementById('successTemplate');
            const clone = successTemplate.cloneNode(true);
            clone.classList.remove('d-none');
            clone.id = 'successResult';
            
            // Update success message
            clone.querySelector('#successMessage').innerHTML = json.message;
            if (json.user_id) {
                clone.querySelector('#userId').textContent = json.user_id;
            }
            if (json.email) {
                clone.querySelector('#userEmail').textContent = formData.email;
            }
            if (json.role) {
                clone.querySelector('#userRole').textContent = formData.role;
            }
            
            // Add create another button functionality
            clone.querySelector('#createAnotherBtn').addEventListener('click', function() {
                location.reload();
            });
            
            // Replace form with success message
            form.style.display = 'none';
            alertBox.style.display = 'none';
            document.getElementById('registerAlert').before(clone);
            
        } else {
            showAlert(json.message || 'Registration failed.', 'danger');
            
            // Refresh captcha if needed
            if (json.refresh_captcha) {
                setTimeout(() => {
                    location.reload();
                }, 2000);
            }
        }
    } catch (err) {
        showAlert('Network error. Please check your connection and try again.', 'danger');
    } finally {
        btn.disabled = false;
        btnText.classList.remove('d-none');
        btnSpinner.classList.add('d-none');
    }

    function showAlert(message, type) {
        alertBox.className = `alert alert-${type} mt-3`;
        alertBox.innerHTML = '<i class="fas fa-exclamation-circle me-2"></i>' + message;
        alertBox.classList.remove('d-none');
        alertBox.scrollIntoView({ behavior: 'smooth', block: 'center' });
    }
});

// Add keyboard shortcuts
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
        border-left: 4px solid #0d6efd;
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
    
    .form-check.card {
        cursor: pointer;
        transition: all 0.2s ease;
    }
    
    .form-check.card:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(0,0,0,0.1);
    }
    
    .form-check-input:checked + .form-check-label.card {
        background-color: rgba(13, 110, 253, 0.05);
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