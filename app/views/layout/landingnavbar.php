<style>
    :root {
        --primary: #0A1929;
        --secondary: #1E2F4A;
        --accent: #00B8A9;
        --accent-glow: #00D4C0;
        --gold: #FFB347;
        --danger: #FF6B6B;
        --success: #4CAF50;
        --text-primary: #F0F4FA;
        --text-secondary: #B0C4DE;
        --bg-dark: #0A0F1C;
        --card-bg: rgba(18, 28, 45, 0.8);
        --glass-border: rgba(255, 255, 255, 0.05);
    }

    /* Base Styles */
    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
    }

    body {
        font-family: 'Inter', sans-serif;
        background: linear-gradient(135deg, #0A0F1C 0%, #0A1929 50%, #0D2135 100%);
        color: var(--text-primary);
        line-height: 1.6;
        overflow-x: hidden;
    }

    .container {
        max-width: 1400px;
        margin: 0 auto;
        padding: 0 40px;
    }

    /* ===== NAVBAR STYLES ===== */
    .navbar {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        z-index: 1000;
        background: rgba(10, 25, 41, 0.85);
        backdrop-filter: blur(10px);
        border-bottom: 1px solid var(--glass-border);
        transition: all 0.3s ease;
    }

    .navbar.scrolled {
        background: rgba(10, 15, 28, 0.95);
        box-shadow: 0 4px 20px rgba(0,0,0,0.3);
    }

    .nav-content {
        display: flex;
        justify-content: space-between;
        align-items: center;
        height: 80px;
        position: relative;
    }

    /* Logo */
    .nav-logo {
        font-family: 'Poppins', sans-serif;
        font-size: 1.8rem;
        font-weight: 800;
        background: linear-gradient(135deg, #fff, var(--accent));
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        text-decoration: none;
        letter-spacing: -0.5px;
        transition: all 0.3s ease;
        z-index: 1001;
    }

    .nav-logo:hover {
        transform: scale(1.05);
    }

    /* Desktop Navigation Links */
    .nav-links {
        display: flex;
        gap: 40px;
        list-style: none;
        margin: 0;
        padding: 0;
    }

    .nav-link {
        color: var(--text-primary);
        text-decoration: none;
        font-weight: 500;
        transition: color 0.3s ease;
        position: relative;
        font-size: 1rem;
        padding: 5px 0;
    }

    .nav-link:hover {
        color: var(--accent);
    }

    .nav-link::after {
        content: '';
        position: absolute;
        bottom: -5px;
        left: 0;
        width: 0;
        height: 2px;
        background: var(--accent);
        transition: width 0.3s ease;
    }

    .nav-link:hover::after {
        width: 100%;
    }

    /* Desktop Action Buttons */
    .nav-buttons {
        display: flex;
        gap: 15px;
        align-items: center;
    }

    .btn {
        padding: 10px 24px;
        border-radius: 8px;
        text-decoration: none;
        font-weight: 600;
        transition: all 0.3s ease;
        display: inline-block;
        font-size: 0.95rem;
        cursor: pointer;
        border: none;
    }

    .btn-text {
        color: var(--text-primary);
        background: transparent;
    }

    .btn-text:hover {
        color: var(--accent);
        transform: translateY(-2px);
    }

    .btn-primary {
        background: linear-gradient(135deg, var(--accent), #008B7A);
        color: white;
        box-shadow: 0 4px 15px rgba(0, 184, 169, 0.3);
    }

    .btn-primary:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 25px rgba(0, 184, 169, 0.5);
    }

    .btn-secondary {
        background: transparent;
        color: var(--accent);
        border: 2px solid var(--accent);
    }

    .btn-secondary:hover {
        background: var(--accent);
        color: white;
        transform: translateY(-2px);
    }

    .btn-gold {
        background: linear-gradient(135deg, var(--gold), #FF9500);
        color: white;
        box-shadow: 0 4px 15px rgba(255, 179, 71, 0.3);
    }

    .btn-gold:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 25px rgba(255, 179, 71, 0.5);
    }

    /* ===== MOBILE MENU STYLES ===== */
    .mobile-menu-toggle {
        display: none;
        flex-direction: column;
        justify-content: space-between;
        width: 30px;
        height: 21px;
        cursor: pointer;
        z-index: 1001;
        position: relative;
    }

    .mobile-menu-toggle span {
        display: block;
        width: 100%;
        height: 3px;
        background: linear-gradient(90deg, var(--accent), var(--gold));
        border-radius: 3px;
        transition: all 0.3s ease;
    }

    .mobile-menu-toggle.active span:nth-child(1) {
        transform: translateY(9px) rotate(45deg);
    }

    .mobile-menu-toggle.active span:nth-child(2) {
        opacity: 0;
        transform: translateX(-10px);
    }

    .mobile-menu-toggle.active span:nth-child(3) {
        transform: translateY(-9px) rotate(-45deg);
    }

    .mobile-menu {
        position: fixed;
        top: 0;
        right: -100%;
        width: 100%;
        height: 100vh;
        background: rgba(10, 15, 28, 0.98);
        backdrop-filter: blur(10px);
        z-index: 1000;
        transition: right 0.3s ease;
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: center;
        padding: 80px 20px 40px;
    }

    .mobile-menu.active {
        right: 0;
    }

    .mobile-nav-links {
        list-style: none;
        text-align: center;
        margin-bottom: 40px;
        width: 100%;
    }

    .mobile-nav-links li {
        margin-bottom: 25px;
        opacity: 0;
        transform: translateY(20px);
        transition: all 0.3s ease;
    }

    .mobile-menu.active .mobile-nav-links li {
        opacity: 1;
        transform: translateY(0);
    }

    .mobile-menu.active .mobile-nav-links li:nth-child(1) { transition-delay: 0.1s; }
    .mobile-menu.active .mobile-nav-links li:nth-child(2) { transition-delay: 0.2s; }
    .mobile-menu.active .mobile-nav-links li:nth-child(3) { transition-delay: 0.3s; }
    .mobile-menu.active .mobile-nav-links li:nth-child(4) { transition-delay: 0.4s; }
    .mobile-menu.active .mobile-nav-links li:nth-child(5) { transition-delay: 0.5s; }

    .mobile-nav-link {
        color: var(--text-primary);
        text-decoration: none;
        font-size: 1.5rem;
        font-weight: 600;
        transition: color 0.3s ease;
        position: relative;
        display: inline-block;
    }

    .mobile-nav-link:hover {
        color: var(--accent);
    }

    .mobile-nav-link::after {
        content: '';
        position: absolute;
        bottom: -5px;
        left: 50%;
        transform: translateX(-50%);
        width: 0;
        height: 2px;
        background: var(--accent);
        transition: width 0.3s ease;
    }

    .mobile-nav-link:hover::after {
        width: 50%;
    }

    .mobile-buttons {
        display: flex;
        flex-direction: column;
        gap: 15px;
        width: 100%;
        max-width: 300px;
        margin: 0 auto;
        opacity: 0;
        transform: translateY(20px);
        transition: all 0.3s ease 0.6s;
    }

    .mobile-menu.active .mobile-buttons {
        opacity: 1;
        transform: translateY(0);
    }

    .mobile-buttons .btn {
        width: 100%;
        text-align: center;
        padding: 15px;
        font-size: 1.1rem;
    }

    /* Mobile Menu Overlay */
    .menu-overlay {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(0,0,0,0.5);
        backdrop-filter: blur(3px);
        z-index: 999;
        opacity: 0;
        visibility: hidden;
        transition: all 0.3s ease;
    }

    .menu-overlay.active {
        opacity: 1;
        visibility: visible;
    }

    /* ===== RESPONSIVE BREAKPOINTS ===== */

    /* Large Desktop */
    @media (min-width: 1400px) {
        .container {
            max-width: 1600px;
        }
    }

    /* Desktop */
    @media (max-width: 1200px) {
        .nav-links {
            gap: 30px;
        }
        
        .nav-links li a {
            font-size: 0.95rem;
        }
    }

    /* Small Desktop / Large Tablet */
    @media (max-width: 1024px) {
        .nav-links {
            gap: 20px;
        }
        
        .btn {
            padding: 8px 20px;
            font-size: 0.9rem;
        }
    }

    /* Tablet - Show Mobile Menu */
    @media (max-width: 992px) {
        .nav-links {
            display: none;
        }
        
        .nav-buttons .btn-text,
        .nav-buttons .btn-primary {
            display: none;
        }
        
        .mobile-menu-toggle {
            display: flex;
        }
        
        .nav-buttons {
            gap: 10px;
        }
        
        /* Keep only the mobile menu toggle visible */
        .nav-content {
            justify-content: space-between;
        }
    }

    /* Mobile Landscape */
    @media (max-width: 768px) and (orientation: landscape) {
        .mobile-nav-link {
            font-size: 1.2rem;
        }
        
        .mobile-nav-links li {
            margin-bottom: 15px;
        }
        
        .mobile-buttons {
            max-width: 250px;
        }
    }

    /* Mobile Portrait */
    @media (max-width: 576px) {
        .container {
            padding: 0 20px;
        }
        
        .nav-logo {
            font-size: 1.5rem;
        }
        
        .mobile-nav-link {
            font-size: 1.3rem;
        }
        
        .mobile-buttons .btn {
            padding: 12px;
            font-size: 1rem;
        }
    }

    /* Small Mobile */
    @media (max-width: 375px) {
        .nav-logo {
            font-size: 1.3rem;
        }
        
        .mobile-nav-link {
            font-size: 1.2rem;
        }
    }

    /* Animation for navbar on scroll */
    @keyframes slideDown {
        from {
            transform: translateY(-100%);
        }
        to {
            transform: translateY(0);
        }
    }

    .navbar.hide {
        transform: translateY(-100%);
    }

    .navbar.show {
        transform: translateY(0);
        animation: slideDown 0.3s ease;
    }

    /* Active link indicator */
    .nav-link.active {
        color: var(--accent);
    }

    .nav-link.active::after {
        width: 100%;
    }

    .mobile-nav-link.active {
        color: var(--accent);
    }

    .mobile-nav-link.active::after {
        width: 50%;
    }
</style>
<!-- Navigation -->
<nav class="navbar" id="navbar">
    <div class="container nav-content">
        <!-- Logo -->
        <a href="#hero" class="nav-logo">NuruAI</a>
        
        <!-- Desktop Navigation Links -->
        <ul class="nav-links">
            <li><a href="#hero" class="nav-link">Home</a></li>
            <li><a href="#problem" class="nav-link">Simulation</a></li>
            <li><a href="#oversight" class="nav-link">Oversight</a></li>
            <li><a href="#impact" class="nav-link">Impact</a></li>
            <li><a href="#about" class="nav-link">About</a></li>
        </ul>
        
        <!-- Desktop Action Buttons -->
        <div class="nav-buttons">
            <a href="#" class="btn btn-text">Login</a>
            <a href="#" class="btn btn-primary">Launch</a>
            
            <!-- Mobile Menu Toggle (Hidden on Desktop) -->
            <div class="mobile-menu-toggle" id="mobileMenuToggle">
                <span></span>
                <span></span>
                <span></span>
            </div>
        </div>
    </div>
    
    <!-- Mobile Menu -->
    <div class="mobile-menu" id="mobileMenu">
        <ul class="mobile-nav-links">
            <li><a href="#hero" class="mobile-nav-link">Home</a></li>
            <li><a href="#problem" class="mobile-nav-link">Simulation</a></li>
            <li><a href="#oversight" class="mobile-nav-link">Oversight</a></li>
            <li><a href="#impact" class="mobile-nav-link">Impact</a></li>
            <li><a href="#about" class="mobile-nav-link">About</a></li>
        </ul>
        
        <div class="mobile-buttons">
            <a href="#" class="btn btn-text">Login</a>
            <a href="#" class="btn btn-primary">Launch Platform</a>
            <a href="#" class="btn btn-secondary">Watch Demo</a>
        </div>
    </div>
    
    <!-- Overlay -->
    <div class="menu-overlay" id="menuOverlay"></div>
</nav>
