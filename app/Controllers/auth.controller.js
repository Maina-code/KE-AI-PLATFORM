// // Auth Controller
// const AuthController = {
//     // Current user state
//     currentUser: null,
//     isAuthenticated: false,
    
//     // Initialize auth
//     init: function() {
//         this.checkAuth();
//         this.bindEvents();
//     },
    
//     // Check if user is authenticated via PHP session
//     checkAuth: function() {
//         fetch('controllers/auth.controller.php?action=check')
//             .then(response => response.json())
//             .then(data => {
//                 if (data.authenticated) {
//                     this.currentUser = data.user;
//                     this.isAuthenticated = true;
//                     this.updateUI();
//                 }
//             });
//     },
    
//     // Login
//     login: async function(credentials) {
//         try {
//             const formData = new FormData();
//             formData.append('email', credentials.email);
//             formData.append('password', credentials.password);
//             formData.append('action', 'login');
            
//             const response = await fetch('controllers/auth.controller.php', {
//                 method: 'POST',
//                 body: formData
//             });
            
//             const data = await response.json();
            
//             if (data.success) {
//                 this.currentUser = data.user;
//                 this.isAuthenticated = true;
//                 this.updateUI();
//                 window.location.href = 'private/dashboard/index.php';
//             } else {
//                 alert(data.message || 'Login failed');
//             }
//         } catch (error) {
//             console.error('Login error:', error);
//             alert('Connection error');
//         }
//     },
    
//     // Logout
//     logout: function() {
//         fetch('controllers/auth.controller.php?action=logout')
//             .then(() => {
//                 this.currentUser = null;
//                 this.isAuthenticated = false;
//                 window.location.href = '/';
//             });
//     },
    
//     // Update UI based on auth state
//     updateUI: function() {
//         const navButtons = document.querySelector('.nav-buttons');
//         if (navButtons && this.isAuthenticated) {
//             navButtons.innerHTML = `
//                 <a href="private/dashboard/index.php" class="btn btn-primary">Dashboard</a>
//                 <a href="#" class="btn btn-text" onclick="AuthController.logout()">Logout</a>
//             `;
//         }
//     },
    
//     // Show login modal
//     showLoginModal: function() {
//         const modal = document.createElement('div');
//         modal.className = 'modal';
//         modal.innerHTML = `
//             <div class="modal-content">
//                 <h2>Sign In to Nuru AI</h2>
//                 <form id="loginForm">
//                     <div class="form-group">
//                         <label>Email</label>
//                         <input type="email" id="email" required placeholder="Enter your email">
//                     </div>
//                     <div class="form-group">
//                         <label>Password</label>
//                         <input type="password" id="password" required placeholder="Enter your password">
//                     </div>
//                     <button type="submit" class="btn btn-primary">Sign In</button>
//                 </form>
//                 <p class="demo-note">Demo: Use any email/password</p>
//             </div>
//         `;
        
//         document.body.appendChild(modal);
        
//         document.getElementById('loginForm').addEventListener('submit', (e) => {
//             e.preventDefault();
//             const email = document.getElementById('email').value;
//             const password = document.getElementById('password').value;
//             this.login({ email, password });
//             modal.remove();
//         });
        
//         modal.addEventListener('click', (e) => {
//             if (e.target === modal) modal.remove();
//         });
//     },
    
//     // Bind events
//     bindEvents: function() {
//         document.addEventListener('click', (e) => {
//             if (e.target.id === 'loginBtn') {
//                 e.preventDefault();
//                 this.showLoginModal();
//             }
//         });
//     }
// };

// // Initialize auth on page load
// document.addEventListener('DOMContentLoaded', () => {
//     AuthController.init();
// });

// window.AuthController = AuthController;