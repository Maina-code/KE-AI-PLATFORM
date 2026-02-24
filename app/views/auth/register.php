<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - NuruAI Platform</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body {
            background: linear-gradient(135deg, #0A2351, #1a3a6b);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: 'Segoe UI', sans-serif;
            padding: 20px;
        }
        .register-container {
            max-width: 500px;
            width: 100%;
        }
        .register-card {
            background: white;
            border-radius: 15px;
            box-shadow: 0 10px 40px rgba(0,0,0,0.3);
            padding: 40px;
        }
        .register-card h2 {
            color: #0A2351;
            margin-bottom: 10px;
            text-align: center;
            font-weight: 600;
        }
        .register-card .subtitle {
            color: #666;
            text-align: center;
            margin-bottom: 30px;
            font-size: 0.9rem;
        }
        .form-control, .form-select {
            height: 45px;
            border-radius: 8px;
            border: 1px solid #ddd;
            padding: 10px 15px;
        }
        .form-control:focus, .form-select:focus {
            border-color: #C5A572;
            box-shadow: 0 0 0 0.2rem rgba(197, 165, 114, 0.25);
        }
        .btn-register {
            background: #0A2351;
            color: white;
            border: none;
            padding: 12px;
            font-weight: 600;
            border-radius: 8px;
            width: 100%;
            transition: all 0.3s;
            margin-top: 10px;
        }
        .btn-register:hover {
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
        .alert {
            border-radius: 8px;
            padding: 12px 15px;
            margin-bottom: 20px;
        }
        .alert-danger {
            background: #fee;
            color: #c33;
            border: 1px solid #fcc;
        }
        .alert-success {
            background: #e8f5e9;
            color: #2e7d32;
            border: 1px solid #a5d6a7;
        }
        .password-strength {
            height: 5px;
            margin-top: 5px;
            border-radius: 5px;
            transition: all 0.3s;
        }
        .strength-weak {
            background: #dc3545;
            width: 25%;
        }
        .strength-medium {
            background: #ffc107;
            width: 50%;
        }
        .strength-strong {
            background: #28a745;
            width: 75%;
        }
        .strength-very-strong {
            background: #20c997;
            width: 100%;
        }
        .login-link {
            text-align: center;
            margin-top: 20px;
        }
        .login-link a {
            color: #0A2351;
            text-decoration: none;
            font-weight: 600;
        }
        .login-link a:hover {
            color: #C5A572;
        }
        .input-group-text {
            background: #f8f9fa;
            border: 1px solid #ddd;
            border-radius: 8px 0 0 8px;
        }
    </style>
</head>
<body>
    <div class="register-container">
        <div class="register-card">
            <div class="logo">
                <i class="fas fa-shield-alt"></i>
            </div>
            <h2>NuruAI Platform</h2>
            <div class="subtitle">Create New Account - Office of the Auditor General</div>
            
            <?php if (!empty($errors)): ?>
                <div class="alert alert-danger">
                    <i class="fas fa-exclamation-circle me-2"></i>
                    <ul class="mb-0">
                        <?php foreach ($errors as $error): ?>
                            <li><?php echo htmlspecialchars($error); ?></li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            <?php endif; ?>
            
            <?php if (!empty($success)): ?>
                <div class="alert alert-success">
                    <i class="fas fa-check-circle me-2"></i>
                    <?php echo htmlspecialchars($success); ?>
                </div>
            <?php endif; ?>
            
            <form method="POST" action="index.php?controller=auth&action=register" id="registerForm">
                <div class="mb-3">
                    <label class="form-label">Username</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="fas fa-user"></i></span>
                        <input type="text" name="username" class="form-control" 
                               value="<?php echo isset($_POST['username']) ? htmlspecialchars($_POST['username']) : ''; ?>" 
                               required maxlength="50" pattern="[a-zA-Z0-9_]+" 
                               title="Username can only contain letters, numbers, and underscores">
                    </div>
                    <small class="text-muted">3-50 characters, letters, numbers, and underscores only</small>
                </div>
                
                <div class="mb-3">
                    <label class="form-label">Full Name</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="fas fa-id-card"></i></span>
                        <input type="text" name="full_name" class="form-control" 
                               value="<?php echo isset($_POST['full_name']) ? htmlspecialchars($_POST['full_name']) : ''; ?>" 
                               required>
                    </div>
                </div>
                
                <div class="mb-3">
                    <label class="form-label">Email Address</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="fas fa-envelope"></i></span>
                        <input type="email" name="email" class="form-control" 
                               value="<?php echo isset($_POST['email']) ? htmlspecialchars($_POST['email']) : ''; ?>" 
                               required>
                    </div>
                </div>
                
                <div class="mb-3">
                    <label class="form-label">Phone Number</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="fas fa-phone"></i></span>
                        <input type="tel" name="phone" class="form-control" 
                               value="<?php echo isset($_POST['phone']) ? htmlspecialchars($_POST['phone']) : ''; ?>" 
                               required placeholder="+254700000000">
                    </div>
                    <small class="text-muted">Format: +254700000000</small>
                </div>
                
                <div class="mb-3">
                    <label class="form-label">Role</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="fas fa-user-tag"></i></span>
                        <select name="role" class="form-select" required>
                            <option value="auditor" <?php echo (isset($_POST['role']) && $_POST['role'] == 'auditor') ? 'selected' : ''; ?>>Auditor</option>
                            <option value="auditor_general" <?php echo (isset($_POST['role']) && $_POST['role'] == 'auditor_general') ? 'selected' : ''; ?>>Auditor General</option>
                            <option value="admin" <?php echo (isset($_POST['role']) && $_POST['role'] == 'admin') ? 'selected' : ''; ?>>Administrator</option>
                        </select>
                    </div>
                </div>
                
                <div class="mb-3">
                    <label class="form-label">Password</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="fas fa-lock"></i></span>
                        <input type="password" name="password" id="password" class="form-control" 
                               required minlength="8" 
                               pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" 
                               title="Must contain at least one number, one uppercase and lowercase letter, and at least 8 characters">
                        <button class="btn btn-outline-secondary" type="button" id="togglePassword">
                            <i class="fas fa-eye"></i>
                        </button>
                    </div>
                    <div class="password-strength" id="passwordStrength"></div>
                    <small class="text-muted">Minimum 8 characters with at least 1 uppercase, 1 lowercase, and 1 number</small>
                </div>
                
                <div class="mb-4">
                    <label class="form-label">Confirm Password</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="fas fa-lock"></i></span>
                        <input type="password" name="confirm_password" id="confirm_password" class="form-control" required>
                        <button class="btn btn-outline-secondary" type="button" id="toggleConfirmPassword">
                            <i class="fas fa-eye"></i>
                        </button>
                    </div>
                    <div id="passwordMatch" class="small mt-1"></div>
                </div>
                
                <button type="submit" class="btn-register" id="submitBtn">
                    <i class="fas fa-user-plus me-2"></i>Register
                </button>
            </form>
            
            <div class="login-link">
                <p>Already have an account? <a href="index.php?controller=auth&action=login">Login here</a></p>
            </div>
        </div>
    </div>
    
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Toggle password visibility
        document.getElementById('togglePassword').addEventListener('click', function() {
            const password = document.getElementById('password');
            const icon = this.querySelector('i');
            if (password.type === 'password') {
                password.type = 'text';
                icon.classList.remove('fa-eye');
                icon.classList.add('fa-eye-slash');
            } else {
                password.type = 'password';
                icon.classList.remove('fa-eye-slash');
                icon.classList.add('fa-eye');
            }
        });
        
        document.getElementById('toggleConfirmPassword').addEventListener('click', function() {
            const password = document.getElementById('confirm_password');
            const icon = this.querySelector('i');
            if (password.type === 'password') {
                password.type = 'text';
                icon.classList.remove('fa-eye');
                icon.classList.add('fa-eye-slash');
            } else {
                password.type = 'password';
                icon.classList.remove('fa-eye-slash');
                icon.classList.add('fa-eye');
            }
        });
        
        // Password strength meter
        document.getElementById('password').addEventListener('input', function() {
            const password = this.value;
            const strengthMeter = document.getElementById('passwordStrength');
            
            // Remove all classes
            strengthMeter.className = 'password-strength';
            
            if (password.length === 0) {
                strengthMeter.style.width = '0';
                return;
            }
            
            let strength = 0;
            
            // Check length
            if (password.length >= 8) strength += 1;
            if (password.length >= 12) strength += 1;
            
            // Check for uppercase
            if (/[A-Z]/.test(password)) strength += 1;
            
            // Check for lowercase
            if (/[a-z]/.test(password)) strength += 1;
            
            // Check for numbers
            if (/[0-9]/.test(password)) strength += 1;
            
            // Check for special characters
            if (/[^A-Za-z0-9]/.test(password)) strength += 1;
            
            // Set class based on strength
            if (strength <= 2) {
                strengthMeter.classList.add('strength-weak');
            } else if (strength <= 3) {
                strengthMeter.classList.add('strength-medium');
            } else if (strength <= 4) {
                strengthMeter.classList.add('strength-strong');
            } else {
                strengthMeter.classList.add('strength-very-strong');
            }
        });
        
        // Password match validation
        document.getElementById('confirm_password').addEventListener('input', function() {
            const password = document.getElementById('password').value;
            const confirm = this.value;
            const matchDiv = document.getElementById('passwordMatch');
            
            if (confirm.length === 0) {
                matchDiv.innerHTML = '';
                return;
            }
            
            if (password === confirm) {
                matchDiv.innerHTML = '<span class="text-success"><i class="fas fa-check-circle"></i> Passwords match</span>';
            } else {
                matchDiv.innerHTML = '<span class="text-danger"><i class="fas fa-exclamation-circle"></i> Passwords do not match</span>';
            }
        });
        
        // Form validation before submit
        document.getElementById('registerForm').addEventListener('submit', function(e) {
            const password = document.getElementById('password').value;
            const confirm = document.getElementById('confirm_password').value;
            
            if (password !== confirm) {
                e.preventDefault();
                alert('Passwords do not match!');
                return;
            }
            
            // Password strength validation
            if (password.length < 8) {
                e.preventDefault();
                alert('Password must be at least 8 characters long!');
                return;
            }
            
            if (!/[A-Z]/.test(password)) {
                e.preventDefault();
                alert('Password must contain at least one uppercase letter!');
                return;
            }
            
            if (!/[a-z]/.test(password)) {
                e.preventDefault();
                alert('Password must contain at least one lowercase letter!');
                return;
            }
            
            if (!/[0-9]/.test(password)) {
                e.preventDefault();
                alert('Password must contain at least one number!');
                return;
            }
        });
        
        // Username availability check (AJAX)
        let usernameTimeout;
        document.querySelector('input[name="username"]').addEventListener('input', function() {
            clearTimeout(usernameTimeout);
            const username = this.value;
            
            if (username.length < 3) return;
            
            usernameTimeout = setTimeout(function() {
                fetch('index.php?controller=auth&action=checkUsername&username=' + encodeURIComponent(username))
                    .then(response => response.json())
                    .then(data => {
                        if (data.exists) {
                            // Show username taken warning
                            const input = document.querySelector('input[name="username"]');
                            if (!input.nextElementSibling?.classList.contains('username-warning')) {
                                const warning = document.createElement('small');
                                warning.className = 'text-danger username-warning';
                                warning.innerHTML = '<i class="fas fa-times-circle"></i> Username already taken';
                                input.parentNode.after(warning);
                            }
                        } else {
                            // Remove warning if exists
                            const warning = document.querySelector('.username-warning');
                            if (warning) warning.remove();
                        }
                    });
            }, 500);
        });
    </script>
</body>
</html>