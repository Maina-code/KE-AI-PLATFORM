<style>
:root {
    /* Extract from your BOCLOGO1.png */
    --logo-navy: #0a2a44;      /* Deep navy from "BRIGHT ORBIT" text */
    --logo-teal: #CC5500;      /* Orange/amber from accent/styling */
    --logo-gray: #4a5568;      /* Charcoal gray for secondary elements */
}
   /* ===== NAVBAR ===== */

.navbar {
position: fixed;
top: 0;
left: 0;
width: 100%;
z-index: 1000;
transition: var(--transition-base);
}
.navbar .container {
    display: flex;
    justify-content: space-between;
    align-items: center;
    max-width: 1280px;
    margin: 0 auto;
    padding: 0 2rem;
}

/* Logo Styles */
.logo {
    display: flex;
    align-items: center;
    padding: 5px 0;
}

.logo-link {
    display: block;
    line-height: 0;
    transition: opacity 0.3s ease;
}

.logo-link:hover {
    opacity: 0.9;
}

.logo-image {
    height: 55px;
    width: auto;
    max-width: 220px;
    object-fit: contain;
}

/* Navigation Links - Using logo colors */
.nav-links {
    display: flex;
    gap: 2.2rem;
    list-style: none;
    align-items: center;
    margin: 0;
    padding: 0;
}

.nav-links li a {
    text-decoration: none;
    color: var(--logo-navy);
    font-weight: 500;
    font-size: 1rem;
    transition: color 0.3s ease;
    padding: 0.5rem 0;
    position: relative;
}

.nav-links li a:hover {
    color: var(--logo-teal);
}

/* Active link indicator */
.nav-links li a.active {
    color: var(--logo-teal);
    font-weight: 600;
}

.nav-links li a.active::after {
    content: '';
    position: absolute;
    bottom: 0;
    left: 0;
    width: 100%;
    height: 2px;
    background: var(--logo-teal);
    border-radius: 2px;
}

/* Consult Button - Using logo navy */
.btn-consult {
    background: var(--logo-navy) !important;
    color: white !important;
    padding: 0.6rem 1.6rem !important;
    border-radius: 50px;
    font-weight: 600;
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    border: 1px solid var(--logo-navy);
    transition: all 0.3s ease !important;
}

.btn-consult i {
    font-size: 0.9rem;
}

.btn-consult:hover {
    background: var(--logo-teal) !important;
    border-color: var(--logo-teal);
    transform: translateY(-2px);
    box-shadow: 0 8px 18px rgba(204,85,0,0.25);
    color: white !important;
}

.btn-consult:active {
    transform: translateY(0);
}

/* Mobile Menu Toggle - Add this for responsive menu */
.menu-toggle {
    display: none;
    flex-direction: column;
    cursor: pointer;
    gap: 6px;
}

.menu-toggle span {
    width: 30px;
    height: 3px;
    background: var(--logo-navy);
    transition: all 0.3s ease;
}

.menu-toggle.active span:nth-child(1) {
    transform: rotate(45deg) translate(6px, 6px);
}

.menu-toggle.active span:nth-child(2) {
    opacity: 0;
}

.menu-toggle.active span:nth-child(3) {
    transform: rotate(-45deg) translate(6px, -6px);
}

/* Responsive */
@media (max-width: 992px) {
    .nav-links {
        gap: 1.5rem;
    }
}

@media (max-width: 768px) {
    .navbar .container {
        flex-wrap: wrap;
        padding: 1rem;
    }
    
    .menu-toggle {
        display: flex;
    }
    
    .nav-links {
        display: none;
        width: 100%;
        flex-direction: column;
        gap: 1rem;
        padding: 1rem 0;
        margin-top: 1rem;
        border-top: 1px solid var(--gray-light);
    }
    
    .nav-links.active {
        display: flex;
    }
    
    .nav-links li {
        width: 100%;
        text-align: center;
    }
    
    .nav-links li a {
        display: block;
        padding: 0.8rem;
    }
    
    .nav-links li a.active::after {
        display: none;
    }
    
    .nav-links li a.active {
        background: rgba(204,85,0,0.08);
        border-radius: 50px;
    }
    
    .btn-consult {
        justify-content: center;
        width: 100%;
    }
    
    .logo-image {
        height: 45px;
    }
}

@media (max-width: 480px) {
    .logo-image {
        height: 40px;
    }
}
</style>

<nav class="navbar">
    <div class="container">
        <!-- Logo with actual image -->
        <div class="logo">
            <a href="/brightorbit/" class="logo-link">
                <img src="/brightorbit/public/img/BOCLOGO1.png" 
                     alt="Bright Orbit Consultancy" 
                     class="logo-image"
                     onerror="this.onerror=null; this.style.display='none'; this.nextElementSibling.style.display='block';">
                <span class="logo-text-fallback" style="display: none; color: var(--logo-navy); font-weight: 800; font-size: 1.5rem;">
                    BRIGHT <span style="color: var(--logo-teal); font-weight: 300;">ORBIT</span>
                </span>
            </a>
        </div>

        <!-- Mobile Menu Toggle -->
        <div class="menu-toggle" id="menuToggle">
            <span></span>
            <span></span>
            <span></span>
        </div>
        
        <!-- Navigation Links with Dynamic Active States -->
        <ul class="nav-links" id="navLinks">
            <li><a href="/brightorbit/" class="nav-link" data-route="/brightorbit/">Home</a></li>
            <li><a href="/brightorbit/solutions" class="nav-link" data-route="/brightorbit/solutions">Solutions</a></li>
            <li><a href="/brightorbit/team" class="nav-link" data-route="/brightorbit/team">Team</a></li>
            <li><a href="/brightorbit/about" class="nav-link" data-route="/brightorbit/about">About</a></li>
            <li><a href="/brightorbit/contact" class="nav-link" data-route="/brightorbit/contact">Contact</a></li>
            <li><a href="/brightorbit/consult" class="btn-consult" data-route="/brightorbit/consult"><i class="fas fa-handshake"></i> Consult</a></li>
        </ul>
    </div>
</nav>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // ===== DYNAMIC ACTIVE LINK DETECTION =====
    const currentPath = window.location.pathname;
    const navLinks = document.querySelectorAll('.nav-link, .btn-consult');
    
    // Remove trailing slash for comparison except for homepage
    let normalizedPath = currentPath;
    if (normalizedPath !== '/brightorbit/' && normalizedPath.endsWith('/')) {
        normalizedPath = normalizedPath.slice(0, -1);
    }
    
    navLinks.forEach(link => {
        const linkPath = link.getAttribute('href');
        
        // Special case for homepage
        if (normalizedPath === '/brightorbit/' || normalizedPath === '/brightorbit') {
            if (linkPath === '/brightorbit/') {
                link.classList.add('active');
            }
        } 
        // Exact match
        else if (linkPath === normalizedPath) {
            link.classList.add('active');
        }
        // Partial match for nested routes (e.g., /brightorbit/solutions/global-recruitment)
        else if (linkPath !== '/brightorbit/' && normalizedPath.startsWith(linkPath + '/')) {
            link.classList.add('active');
        }
    });

    // ===== MOBILE MENU TOGGLE =====
    const menuToggle = document.getElementById('menuToggle');
    const navMenu = document.getElementById('navLinks');
    
    if (menuToggle && navMenu) {
        menuToggle.addEventListener('click', function() {
            this.classList.toggle('active');
            navMenu.classList.toggle('active');
        });
        
        // Close menu when clicking a link
        navMenu.querySelectorAll('a').forEach(link => {
            link.addEventListener('click', function() {
                menuToggle.classList.remove('active');
                navMenu.classList.remove('active');
            });
        });
    }

    // ===== NAVBAR SCROLL EFFECT =====
    const navbar = document.querySelector('.navbar');
    window.addEventListener('scroll', function() {
        if (window.scrollY > 50) {
            navbar.style.boxShadow = '0 2px 20px rgba(10,42,68,0.08)';
        } else {
            navbar.style.boxShadow = '0 2px 15px rgba(10,42,68,0.05)';
        }
    });
});
</script>