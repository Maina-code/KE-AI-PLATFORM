<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Set consistent error logging
ini_set('log_errors', 1);
ini_set('error_log', 'C:/xampp/htdocs/tsfreighters/error_log.txt');

if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}

$num1 = rand(1, 10);
$num2 = rand(1, 10);
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
              <i class="fas fa-lock fa-3x text-warning mb-2"></i>
              <h3 class="fw-bold">Secure Sign In</h3>
              <p class="text-muted small">Use your email and password to log in.</p>
            </div>

            <form id="loginForm" novalidate>
              <input type="hidden" name="csrf_token" value="<?php echo htmlspecialchars($_SESSION['csrf_token']); ?>">

              <div class="mb-3">
                <label for="email" class="form-label fw-semibold">Email address</label>
                <input type="email" id="email" name="email" class="form-control form-control-lg rounded-pill px-4" placeholder="you@example.com" required>
              </div>

              <div class="mb-3">
                <label for="password" class="form-label fw-semibold">Password</label>
                <div class="input-group">
                  <input type="password" id="password" name="password" class="form-control form-control-lg rounded-start-pill px-4" placeholder="********" required>
                  <button class="btn btn-outline-secondary rounded-end-pill" type="button" id="togglePassword" aria-label="Show password">
                    <i class="fas fa-eye"></i>
                  </button>
                </div>
              </div>

              <!-- Math Anti-bot -->
              <div class="mb-3">
                <label for="captcha" class="form-label fw-semibold">
                  Prove you're human: What is <strong><?php echo "$num1 + $num2"; ?></strong>?
                </label>
                <input type="number" id="captcha" name="captcha" class="form-control form-control-lg rounded-pill px-4" placeholder="Your answer" required>
              </div>

              <div class="d-flex justify-content-between align-items-center mb-3">
                <div class="form-check">
                  <input class="form-check-input" type="checkbox" id="remember" name="remember">
                  <label class="form-check-label small" for="remember">Remember me</label>
                </div>
                <a href="index.php?controller=customer&action=forgot_password" class="small text-decoration-none">Forgot password?</a>
              </div>

              <div class="d-grid">
                <button id="loginBtn" type="submit" class="btn btn-warning btn-lg rounded-pill shadow-sm">
                  <span id="btnText"><i class="fas fa-sign-in-alt me-2"></i> Login</span>
                  <span id="btnSpinner" class="spinner-border spinner-border-sm d-none" role="status" aria-hidden="true"></span>
                </button>
              </div>
            </form>

            <div id="loginAlert" class="alert mt-4 d-none" role="alert"></div>

            <!-- 🔹 NEW: Register Section -->
            <div class="text-center mt-4">
              <p class="small text-muted mb-2">Don't have an account?</p>
              <a href="index.php?controller=customer&action=register" class="btn btn-outline-warning rounded-pill px-4 py-2">
                <i class="fas fa-user-plus me-2"></i> Create Account
              </a>
            </div>
             <div class="text-center mt-4">
              <p class="small text-muted mb-2">Staff?</p>
              <a href=" index.php?controller=admin&action=login" class="btn btn-outline-warning rounded-pill px-4 py-2">
                <i class="fas fa-user-plus me-2"></i>Staff Login
              </a>
            </div>
           

            <hr class="my-4">

            <div class="text-center small text-muted">
              By logging in, you agree to our <a href="index.php?controller=customer&action=terms">Terms</a> and <a href="index.php?controller=customer&action=privacy">Privacy Policy</a>.
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

// Toggle password visibility
document.getElementById('togglePassword').addEventListener('click', function() {
  const input = document.getElementById('password');
  const icon = this.querySelector('i');
  if (input.type === 'password') { 
    input.type = 'text'; 
    icon.classList.replace('fa-eye','fa-eye-slash'); 
  } else { 
    input.type = 'password'; 
    icon.classList.replace('fa-eye-slash','fa-eye'); 
  }
});

// Handle form submission with anti-bot
document.getElementById('loginForm').addEventListener('submit', async function(e){
  e.preventDefault();
  
  const form = this;
  const btn = document.getElementById('loginBtn');
  const btnText = document.getElementById('btnText');
  const btnSpinner = document.getElementById('btnSpinner');
  const alertBox = document.getElementById('loginAlert');

  const email = form.email.value.trim();
  const password = form.password.value.trim();
  const captcha = form.captcha.value.trim();

  if (!email || !password || !captcha) {
    showAlert('Please fill in all fields.', 'danger');
    return;
  }

  btn.disabled = true;
  btnText.classList.add('d-none');
  btnSpinner.classList.remove('d-none');
  alertBox.classList.add('d-none');

  const fd = new FormData(form);

  try {
    // Use absolute URL to avoid path issues
    const res = await fetch('/tsfreighters/public/index.php?controller=customer&action=login_process', { 
      method: 'POST', 
      body: fd 
    });

    console.log('Response status:', res.status);
    
    if (!res.ok) {
      throw new Error(`HTTP error! status: ${res.status}`);
    }
    
    const text = await res.text();
    console.log('Raw response:', text);
    
    let json;
    try {
      json = JSON.parse(text);
    } catch (parseError) {
      console.error('Failed to parse JSON:', parseError);
      
      // Check if it's an HTML error page
      if (text.includes('<!DOCTYPE') || text.includes('<html')) {
        showAlert('Server error. Please try again later.', 'danger');
      } else {
        showAlert('Invalid server response. Please try again.', 'danger');
      }
      return;
    }

    if (json.status === 'success') {
      showAlert(json.message || 'Login successful! Redirecting...', 'success');
      setTimeout(() => {
        // Use the redirect URL from server or default
        const redirect = json.redirect || '/tsfreighters/public/index.php?controller=customer&action=dashboard';
        console.log('Redirecting to:', redirect);
        window.location.href = redirect;
      }, 1000);
    } else {
      showAlert(json.message || 'Authentication failed.', 'danger');
    }
  } catch (err) {
    console.error('Login error:', err);
    showAlert('Error: ' + err.message, 'danger');
  } finally {
    btn.disabled = false;
    btnText.classList.remove('d-none');
    btnSpinner.classList.add('d-none');
  }

  function showAlert(message, type) {
    alertBox.className = `alert alert-${type} mt-3`;
    alertBox.textContent = message;
    alertBox.classList.remove('d-none');
    
    // Scroll to alert
    alertBox.scrollIntoView({ behavior: 'smooth', block: 'center' });
  }
});
</script>