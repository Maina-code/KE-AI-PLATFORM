<?php
// app/views/layouts/navbar.php
?>
<!-- Top Navbar - Glass Morphism Design -->
<nav class="navbar navbar-expand-lg fixed-top" id="mainNavbar">
    <div class="container-fluid">
        <!-- Sidebar Toggle Button (Mobile) -->
        <button class="navbar-toggler sidebar-toggler" type="button" id="sidebarToggle">
            <span class="navbar-toggler-icon"></span>
        </button>
        
        <!-- Brand Logo -->
        <a class="navbar-brand" href="index.php?controller=auditor&action=dashboard">
            <div class="brand-icon">
                <i class="fas fa-shield-alt"></i>
            </div>
            <div class="brand-text-wrapper">
                <span class="brand-text">NURU<span class="brand-highlight">AI</span></span>
                <small class="brand-tagline">Integrity & Transparency</small>
            </div>
        </a>
        
        <!-- Mobile Top Bar Right -->
        <div class="navbar-nav ms-auto d-lg-none">
            <div class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" id="mobileUserDropdown" role="button" data-bs-toggle="dropdown">
                    <div class="user-avatar-small">
                        <?php echo strtoupper(substr($_SESSION['user_name'] ?? 'AG', 0, 2)); ?>
                    </div>
                </a>
                <ul class="dropdown-menu dropdown-menu-end glass-dropdown">
                    <li><a class="dropdown-item" href="#"><i class="fas fa-user-circle me-2"></i>Profile</a></li>
                    <li><a class="dropdown-item" href="#"><i class="fas fa-cog me-2"></i>Settings</a></li>
                    <li><hr class="dropdown-divider"></li>
                    <li><a class="dropdown-item text-danger" href="index.php?controller=auth&action=logout">
                        <i class="fas fa-sign-out-alt me-2"></i>Logout
                    </a></li>
                </ul>
            </div>
        </div>
        
        <!-- Desktop Top Nav Items -->
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto d-none d-lg-flex align-items-center">
                <!-- Search -->
                <li class="nav-item search-item">
                    <div class="search-wrapper">
                        <i class="fas fa-search search-icon"></i>
                        <input type="text" class="search-input" placeholder="Search transactions, cases...">
                    </div>
                </li>
                
                <!-- Notifications -->
                <li class="nav-item dropdown mx-2">
                    <a class="nav-link notification-link" href="#" id="notificationsDropdown" role="button" data-bs-toggle="dropdown">
                        <i class="fas fa-bell"></i>
                        <span class="notification-badge">3</span>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end glass-dropdown notification-dropdown">
                        <li class="dropdown-header">Notifications</li>
                        <li><a class="dropdown-item" href="#">
                            <div class="notification-item">
                                <div class="notification-icon bg-danger-subtle">
                                    <i class="fas fa-exclamation-triangle text-danger"></i>
                                </div>
                                <div class="notification-content">
                                    <span class="notification-title">High-risk case detected</span>
                                    <small class="notification-time">5 min ago</small>
                                </div>
                            </div>
                        </a></li>
                        <li><a class="dropdown-item" href="#">
                            <div class="notification-item">
                                <div class="notification-icon bg-warning-subtle">
                                    <i class="fas fa-robot text-warning"></i>
                                </div>
                                <div class="notification-content">
                                    <span class="notification-title">AI analysis completed</span>
                                    <small class="notification-time">1 hour ago</small>
                                </div>
                            </div>
                        </a></li>
                        <li><a class="dropdown-item" href="#">
                            <div class="notification-item">
                                <div class="notification-icon bg-success-subtle">
                                    <i class="fas fa-file-pdf text-success"></i>
                                </div>
                                <div class="notification-content">
                                    <span class="notification-title">Monthly report ready</span>
                                    <small class="notification-time">2 hours ago</small>
                                </div>
                            </div>
                        </a></li>
                        <li><hr class="dropdown-divider"></li>
                        <li><a class="dropdown-item text-center view-all" href="#">View All Notifications</a></li>
                    </ul>
                </li>
                
                <!-- User Dropdown -->
                <li class="nav-item dropdown ms-2">
                    <a class="nav-link dropdown-toggle user-dropdown-toggle" href="#" id="userDropdown" role="button" data-bs-toggle="dropdown">
                        <div class="user-info-wrapper">
                            <div class="user-avatar-small">
                                <?php echo strtoupper(substr($_SESSION['user_name'] ?? 'AG', 0, 2)); ?>
                            </div>
                            <div class="user-text">
                                <span class="user-name"><?php echo htmlspecialchars($_SESSION['user_name'] ?? 'Auditor General'); ?></span>
                                <small class="user-role">Auditor General</small>
                            </div>
                        </div>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end glass-dropdown user-dropdown">
                        <li class="user-dropdown-header">
                            <div class="user-avatar-large">
                                <?php echo strtoupper(substr($_SESSION['user_name'] ?? 'AG', 0, 2)); ?>
                            </div>
                            <div class="user-info">
                                <h6><?php echo htmlspecialchars($_SESSION['user_name'] ?? 'Auditor General'); ?></h6>
                                <small><?php echo htmlspecialchars($_SESSION['user_email'] ?? ''); ?></small>
                            </div>
                        </li>
                        <li><hr class="dropdown-divider"></li>
                        <li><a class="dropdown-item" href="#"><i class="fas fa-user-circle me-2"></i>My Profile</a></li>
                        <li><a class="dropdown-item" href="#"><i class="fas fa-cog me-2"></i>Settings</a></li>
                        <li><a class="dropdown-item" href="#"><i class="fas fa-history me-2"></i>Activity Log</a></li>
                        <li><hr class="dropdown-divider"></li>
                        <li><a class="dropdown-item text-danger" href="index.php?controller=auth&action=logout">
                            <i class="fas fa-sign-out-alt me-2"></i>Logout
                        </a></li>
                    </ul>
                </li>
            </ul>
        </div>
    </div>
</nav>

<!-- Sidebar - Glass Morphism Design -->
<div class="sidebar" id="sidebar">
    <!-- User Profile Section -->
    <div class="sidebar-user glass-effect">
        <div class="user-avatar-large">
            <?php echo strtoupper(substr($_SESSION['user_name'] ?? 'AG', 0, 2)); ?>
        </div>
        <div class="user-info-sidebar">
            <h6><?php echo htmlspecialchars($_SESSION['user_name'] ?? 'Auditor General'); ?></h6>
            <div class="user-status">
                <span class="status-indicator"></span>
                <small>Online</small>
            </div>
        </div>
    </div>
    
    <!-- Sidebar Menu -->
    <ul class="sidebar-menu">
        <li class="menu-header">MAIN</li>
        <li class="sidebar-item <?php echo ($_GET['controller'] ?? '') == 'auditor' && ($_GET['action'] ?? '') == 'dashboard' ? 'active' : ''; ?>">
            <a href="index.php?controller=auditor&action=dashboard">
                <i class="fas fa-tachometer-alt"></i>
                <span>Dashboard</span>
                <span class="menu-tooltip">Overview & Statistics</span>
            </a>
        </li>
        
        <li class="menu-header">AUDIT & INVESTIGATIONS</li>
        <li class="sidebar-item <?php echo ($_GET['controller'] ?? '') == 'transaction' ? 'active' : ''; ?>">
            <a href="index.php?controller=transaction&action=index">
                <i class="fas fa-exchange-alt"></i>
                <span>Transactions</span>
                <span class="badge risk-badge">47</span>
                <span class="menu-tooltip">Monitor suspicious transactions</span>
            </a>
        </li>
        <li class="sidebar-item has-submenu <?php echo in_array($_GET['controller'] ?? '', ['cases', 'investigations']) ? 'active' : ''; ?>">
            <a href="#" class="submenu-toggle">
                <i class="fas fa-folder-open"></i>
                <span>Cases</span>
                <i class="fas fa-chevron-right submenu-arrow"></i>
                <span class="menu-tooltip">Manage investigation cases</span>
            </a>
            <ul class="submenu">
                <li><a href="index.php?controller=cases&action=active">Active Cases <span class="badge">23</span></a></li>
                <li><a href="index.php?controller=cases&action=pending">Pending Review <span class="badge">12</span></a></li>
                <li><a href="index.php?controller=cases&action=closed">Closed Cases <span class="badge">156</span></a></li>
                <li><a href="index.php?controller=cases&action=new"><i class="fas fa-plus-circle"></i> Create New Case</a></li>
            </ul>
        </li>
        
        <li class="menu-header">AI INTELLIGENCE</li>
        <li class="sidebar-item <?php echo ($_GET['controller'] ?? '') == 'ai' ? 'active' : ''; ?>">
            <a href="index.php?controller=ai&action=analysis">
                <i class="fas fa-microchip"></i>
                <span>AI Analysis</span>
                <span class="badge ai-badge">New</span>
                <span class="menu-tooltip">AI-powered corruption detection</span>
            </a>
        </li>
        <li class="sidebar-item <?php echo ($_GET['controller'] ?? '') == 'reports' ? 'active' : ''; ?>">
            <a href="index.php?controller=reports&action=index">
                <i class="fas fa-chart-bar"></i>
                <span>Reports</span>
                <span class="menu-tooltip">Generate audit reports</span>
            </a>
        </li>
        <li class="sidebar-item <?php echo ($_GET['controller'] ?? '') == 'risk' ? 'active' : ''; ?>">
            <a href="index.php?controller=risk&action=assessment">
                <i class="fas fa-exclamation-triangle"></i>
                <span>Risk Assessment</span>
                <span class="menu-tooltip">Evaluate corruption risks</span>
            </a>
        </li>
        
        <li class="menu-header">TRANSPARENCY TOOLS</li>
        <li class="sidebar-item <?php echo ($_GET['controller'] ?? '') == 'whistleblower' ? 'active' : ''; ?>">
            <a href="index.php?controller=whistleblower&action=index">
                <i class="fas fa-user-secret"></i>
                <span>Whistleblower</span>
                <span class="badge whistleblower-badge">5</span>
                <span class="menu-tooltip">Anonymous reports</span>
            </a>
        </li>
        <li class="sidebar-item <?php echo ($_GET['controller'] ?? '') == 'audit' ? 'active' : ''; ?>">
            <a href="index.php?controller=audit&action=trail">
                <i class="fas fa-history"></i>
                <span>Audit Trail</span>
                <span class="menu-tooltip">Immutable record of actions</span>
            </a>
        </li>
        <li class="sidebar-item <?php echo ($_GET['controller'] ?? '') == 'blockchain' ? 'active' : ''; ?>">
            <a href="index.php?controller=blockchain&action=index">
                <i class="fas fa-link"></i>
                <span>Blockchain Verify</span>
                <span class="badge blockchain-badge">Verified</span>
                <span class="menu-tooltip">Blockchain audit trail</span>
            </a>
        </li>
        
        <li class="menu-header">ADMINISTRATION</li>
        <li class="sidebar-item <?php echo ($_GET['controller'] ?? '') == 'users' ? 'active' : ''; ?>">
            <a href="index.php?controller=users&action=index">
                <i class="fas fa-users"></i>
                <span>Users</span>
                <span class="menu-tooltip">Manage system users</span>
            </a>
        </li>
        <li class="sidebar-item <?php echo ($_GET['controller'] ?? '') == 'settings' ? 'active' : ''; ?>">
            <a href="index.php?controller=settings&action=index">
                <i class="fas fa-cog"></i>
                <span>Settings</span>
                <span class="menu-tooltip">System configuration</span>
            </a>
        </li>
    </ul>
    
    <!-- Sidebar Footer with Transparency Message -->
    <div class="sidebar-footer glass-effect">
        <div class="transparency-message">
            <i class="fas fa-eye"></i>
            <span>Transparency in Action</span>
        </div>
        <div class="system-info">
            <small>NuruAI v2.0</small>
            <small><i class="fas fa-shield-alt me-1"></i> 98% Uptime</small>
        </div>
    </div>
</div>

<!-- Sidebar Overlay (Mobile) -->
<div class="sidebar-overlay" id="sidebarOverlay"></div>

<style>
:root {
    /* Transparent color scheme */
    --glass-bg: rgba(255, 255, 255, 0.8);
    --glass-border: rgba(255, 255, 255, 0.2);
    --glass-shadow: 0 8px 32px 0 rgba(31, 38, 135, 0.15);
    --primary-glass: rgba(10, 35, 81, 0.3);
    --accent-glass: rgba(197, 165, 114, 0.3);
    --text-light: rgba(255, 255, 255, 0.95);
    --text-muted-glass: rgba(255, 255, 255, 0.6);
    
    /* Transparency theme colors */
    --transparency-primary: rgba(255, 255, 255, 0.15);
    --transparency-secondary: rgba(255, 255, 255, 0.05);
    --transparency-accent: rgba(197, 165, 114, 0.25);
    
    /* Accent colors */
    --pure-white: #ffffff;
    --soft-gold: #C5A572;
    --deep-blue: #0A2351;
}

/* Navbar Styles - Glass Morphism */
.navbar {
    background: var(--glass-bg);
    backdrop-filter: blur(10px);
    -webkit-backdrop-filter: blur(10px);
    border-bottom: 1px solid var(--glass-border);
    height: 80px;
    padding: 0 25px;
    z-index: 1030;
    transition: all 0.3s ease;
}

.navbar.scrolled {
    background: rgba(10, 35, 81, 0.4);
    backdrop-filter: blur(15px);
    box-shadow: var(--glass-shadow);
}

/* Brand Styles */
.navbar-brand {
    display: flex;
    align-items: center;
    gap: 15px;
    text-decoration: none;
    padding: 0;
}

.brand-icon {
    width: 45px;
    height: 45px;
    background: var(--transparency-accent);
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    border: 1px solid var(--glass-border);
}

.brand-icon i {
    font-size: 1.8rem;
    color: var(--pure-white);
    filter: drop-shadow(0 2px 4px rgba(0,0,0,0.2));
}

.brand-text-wrapper {
    display: flex;
    flex-direction: column;
}

.brand-text {
    font-size: 1.6rem;
    font-weight: 700;
    color: var(--pure-white);
    letter-spacing: 1px;
    line-height: 1.2;
}

.brand-highlight {
    color: var(--soft-gold);
    font-weight: 800;
}

.brand-tagline {
    font-size: 0.7rem;
    color: var(--text-muted-glass);
    letter-spacing: 1px;
    text-transform: uppercase;
}

/* Search Bar */
.search-item {
    margin-right: 15px;
}

.search-wrapper {
    position: relative;
    width: 280px;
}

.search-icon {
    position: absolute;
    left: 15px;
    top: 50%;
    transform: translateY(-50%);
    color: var(--text-muted-glass);
    font-size: 0.9rem;
    z-index: 1;
}

.search-input {
    width: 100%;
    height: 45px;
    background: var(--transparency-primary);
    border: 1px solid var(--glass-border);
    border-radius: 30px;
    padding: 0 20px 0 45px;
    color: var(--pure-white);
    font-size: 0.95rem;
    transition: all 0.3s ease;
}

.search-input::placeholder {
    color: var(--text-muted-glass);
    font-weight: 300;
}

.search-input:focus {
    outline: none;
    background: rgba(255, 255, 255, 0.2);
    border-color: var(--soft-gold);
    box-shadow: 0 0 15px rgba(197, 165, 114, 0.3);
}

/* User Avatar */
.user-avatar-small {
    width: 40px;
    height: 40px;
    background: linear-gradient(135deg, var(--soft-gold), #9e814d);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    color: var(--deep-blue);
    font-weight: bold;
    font-size: 1rem;
    border: 2px solid rgba(255, 255, 255, 0.3);
}

.user-info-wrapper {
    display: flex;
    align-items: center;
    gap: 12px;
    padding: 5px;
}

.user-text {
    display: flex;
    flex-direction: column;
}

.user-name {
    color: var(--pure-white);
    font-weight: 600;
    font-size: 0.95rem;
    line-height: 1.2;
}

.user-role {
    color: var(--text-muted-glass);
    font-size: 0.75rem;
}

/* Notification Badge */
.notification-link {
    position: relative;
    padding: 10px !important;
}

.notification-badge {
    position: absolute;
    top: 5px;
    right: 5px;
    background: #ff4757;
    color: white;
    border-radius: 50%;
    padding: 3px 6px;
    font-size: 0.65rem;
    min-width: 18px;
    text-align: center;
    border: 2px solid rgba(255, 255, 255, 0.3);
    animation: pulse 2s infinite;
}

@keyframes pulse {
    0% { transform: scale(1); }
    50% { transform: scale(1.1); }
    100% { transform: scale(1); }
}

/* Glass Dropdown */
.glass-dropdown {
    background: rgba(10, 35, 81, 0.4);
    backdrop-filter: blur(15px);
    -webkit-backdrop-filter: blur(15px);
    border: 1px solid var(--glass-border);
    border-radius: 15px;
    box-shadow: var(--glass-shadow);
    padding: 10px 0;
    margin-top: 10px;
}

.glass-dropdown .dropdown-item {
    color: var(--pure-white);
    padding: 10px 20px;
    transition: all 0.3s;
    font-size: 0.95rem;
}

.glass-dropdown .dropdown-item:hover {
    background: var(--transparency-accent);
    color: var(--pure-white);
}

.glass-dropdown .dropdown-divider {
    border-top-color: var(--glass-border);
    margin: 5px 0;
}

.glass-dropdown .dropdown-header {
    color: var(--soft-gold);
    font-weight: 600;
    text-transform: uppercase;
    font-size: 0.8rem;
    letter-spacing: 1px;
}

/* Notification Dropdown */
.notification-dropdown {
    width: 350px;
}

.notification-item {
    display: flex;
    align-items: center;
    gap: 12px;
}

.notification-icon {
    width: 35px;
    height: 35px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
}

.notification-icon i {
    font-size: 1rem;
}

.notification-content {
    flex: 1;
    display: flex;
    flex-direction: column;
}

.notification-title {
    font-size: 0.9rem;
    font-weight: 500;
}

.notification-time {
    font-size: 0.7rem;
    color: var(--text-muted-glass);
}

.view-all {
    color: var(--soft-gold) !important;
    font-weight: 600;
}

/* User Dropdown */
.user-dropdown {
    width: 280px;
}

.user-dropdown-header {
    display: flex;
    align-items: center;
    gap: 15px;
    padding: 15px 20px;
}

.user-avatar-large {
    width: 50px;
    height: 50px;
    background: linear-gradient(135deg, var(--soft-gold), #9e814d);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    color: var(--deep-blue);
    font-weight: bold;
    font-size: 1.2rem;
    border: 2px solid rgba(255, 255, 255, 0.3);
}

.user-dropdown-header .user-info h6 {
    margin: 0;
    color: var(--pure-white);
    font-weight: 600;
}

.user-dropdown-header .user-info small {
    color: var(--text-muted-glass);
}

/* Sidebar Styles - Glass Morphism */
.sidebar {
    position: fixed;
    top: 80px;
    left: 0;
    width: 300px;
    height: calc(100vh - 80px);
    background: rgba(10, 35, 51, 0.3);
    backdrop-filter: blur(15px);
    -webkit-backdrop-filter: blur(15px);
    border-right: 1px solid var(--glass-border);
    box-shadow: 4px 0 20px rgba(0,0,0,0.2);
    z-index: 1020;
    transition: all 0.3s ease;
    overflow-y: auto;
}

/* Custom Scrollbar */
.sidebar::-webkit-scrollbar {
    width: 5px;
}

.sidebar::-webkit-scrollbar-track {
    background: var(--transparency-primary);
}

.sidebar::-webkit-scrollbar-thumb {
    background: var(--soft-gold);
    border-radius: 5px;
}

.sidebar::-webkit-scrollbar-thumb:hover {
    background: #9e814d;
}

/* Sidebar User Section */
.sidebar-user {
    padding: 25px 20px;
    background: var(--transparency-primary);
    border-bottom: 1px solid var(--glass-border);
    display: flex;
    align-items: center;
    gap: 15px;
}

.user-info-sidebar h6 {
    margin: 0;
    color: var(--pure-white);
    font-weight: 600;
}

.user-status {
    display: flex;
    align-items: center;
    gap: 5px;
    margin-top: 3px;
}

.status-indicator {
    width: 8px;
    height: 8px;
    background: #2ecc71;
    border-radius: 50%;
    animation: blink 2s infinite;
}

@keyframes blink {
    0% { opacity: 1; }
    50% { opacity: 0.5; }
    100% { opacity: 1; }
}

.user-status small {
    color: var(--text-muted-glass);
}

/* Sidebar Menu */
.sidebar-menu {
    list-style: none;
    padding: 15px 0;
    margin: 0;
}

.menu-header {
    padding: 15px 20px 5px;
    font-size: 0.7rem;
    text-transform: uppercase;
    letter-spacing: 1.5px;
    color: var(--soft-gold);
    font-weight: 600;
}

.sidebar-item {
    position: relative;
    margin: 2px 0;
}

.sidebar-item a {
    display: flex;
    align-items: center;
    padding: 12px 20px;
    color: var(--text-muted-glass);
    text-decoration: none;
    transition: all 0.3s;
    gap: 12px;
    position: relative;
    overflow: hidden;
}

.sidebar-item a::before {
    content: '';
    position: absolute;
    left: 0;
    top: 0;
    height: 100%;
    width: 3px;
    background: var(--soft-gold);
    transform: scaleY(0);
    transition: transform 0.3s;
}

.sidebar-item a i:first-child {
    width: 22px;
    font-size: 1.1rem;
    color: var(--soft-gold);
    transition: all 0.3s;
}

.sidebar-item a span {
    flex: 1;
    font-weight: 500;
}

.sidebar-item a .badge {
    padding: 4px 8px;
    border-radius: 20px;
    font-size: 0.65rem;
    font-weight: 600;
    letter-spacing: 0.5px;
}

.risk-badge {
    background: rgba(255, 71, 87, 0.2);
    color: #ff4757;
    border: 1px solid rgba(255, 71, 87, 0.3);
}

.ai-badge {
    background: rgba(255, 193, 7, 0.2);
    color: #ffc107;
    border: 1px solid rgba(255, 193, 7, 0.3);
}

.whistleblower-badge {
    background: rgba(23, 162, 184, 0.2);
    color: #17a2b8;
    border: 1px solid rgba(23, 162, 184, 0.3);
}

.blockchain-badge {
    background: rgba(40, 167, 69, 0.2);
    color: #28a745;
    border: 1px solid rgba(40, 167, 69, 0.3);
}

/* Menu Tooltip */
.menu-tooltip {
    position: absolute;
    left: 100%;
    top: 50%;
    transform: translateY(-50%);
    background: var(--deep-blue);
    color: white;
    padding: 5px 10px;
    border-radius: 5px;
    font-size: 0.75rem;
    white-space: nowrap;
    opacity: 0;
    visibility: hidden;
    transition: all 0.3s;
    margin-left: 10px;
    z-index: 1000;
    border: 1px solid var(--soft-gold);
}

.sidebar-item a:hover .menu-tooltip {
    opacity: 1;
    visibility: visible;
    margin-left: 15px;
}

/* Hover Effects */
.sidebar-item:hover a {
    background: var(--transparency-primary);
    color: var(--pure-white);
}

.sidebar-item:hover a::before {
    transform: scaleY(1);
}

.sidebar-item:hover a i:first-child {
    transform: translateX(3px);
}

.sidebar-item.active a {
    background: var(--transparency-accent);
    color: var(--pure-white);
}

.sidebar-item.active a::before {
    transform: scaleY(1);
}

.sidebar-item.active a i {
    color: var(--pure-white);
}

/* Submenu */
.sidebar-item.has-submenu .submenu-toggle .submenu-arrow {
    transition: transform 0.3s;
    font-size: 0.8rem;
}

.sidebar-item.has-submenu.open .submenu-toggle .submenu-arrow {
    transform: rotate(90deg);
}

.submenu {
    list-style: none;
    padding: 0;
    margin: 0;
    max-height: 0;
    overflow: hidden;
    transition: max-height 0.4s ease;
    background: var(--transparency-secondary);
}

.sidebar-item.has-submenu.open .submenu {
    max-height: 300px;
}

.submenu li a {
    padding: 10px 20px 10px 54px;
    font-size: 0.9rem;
}

.submenu li a .badge {
    background: var(--soft-gold);
    color: var(--deep-blue);
    padding: 2px 6px;
    border-radius: 12px;
    font-size: 0.65rem;
}

.submenu li a i {
    width: 18px;
    font-size: 0.9rem;
}

/* Sidebar Footer */
.sidebar-footer {
    padding: 20px;
    border-top: 1px solid var(--glass-border);
    margin-top: 20px;
}

.transparency-message {
    display: flex;
    align-items: center;
    gap: 8px;
    color: var(--soft-gold);
    font-size: 0.85rem;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 1px;
    margin-bottom: 15px;
}

.transparency-message i {
    animation: glow 2s infinite;
}

@keyframes glow {
    0% { text-shadow: 0 0 5px var(--soft-gold); }
    50% { text-shadow: 0 0 20px var(--soft-gold); }
    100% { text-shadow: 0 0 5px var(--soft-gold); }
}

.system-info {
    display: flex;
    justify-content: space-between;
    color: var(--text-muted-glass);
    font-size: 0.75rem;
}

/* Sidebar Overlay */
.sidebar-overlay {
    position: fixed;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: rgba(0, 0, 0, 0.5);
    backdrop-filter: blur(3px);
    z-index: 1015;
    display: none;
}

/* Main Content Adjustment */
.main-content {
    margin-left: 300px;
    margin-top: 80px;
    padding: 30px;
    transition: margin-left 0.3s ease;
}

/* Mobile Responsive */
@media (max-width: 991.98px) {
    .sidebar {
        left: -300px;
    }
    
    .sidebar.show {
        left: 0;
        box-shadow: 4px 0 30px rgba(0,0,0,0.3);
    }
    
    .sidebar-overlay.show {
        display: block;
    }
    
    .main-content {
        margin-left: 0;
    }
    
    .brand-text {
        font-size: 1.3rem;
    }
    
    .brand-tagline {
        display: none;
    }
    
    .navbar-brand {
        gap: 8px;
    }
}

@media (max-width: 576px) {
    .navbar {
        padding: 0 15px;
    }
    
    .main-content {
        padding: 20px 15px;
    }
    
    .brand-icon {
        width: 35px;
        height: 35px;
    }
    
    .brand-icon i {
        font-size: 1.4rem;
    }
}

/* Loading Animation for Transparency Theme */
.glass-effect {
    animation: fadeIn 0.5s ease;
}

@keyframes fadeIn {
    from {
        opacity: 0;
        transform: translateY(-10px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Navbar scroll effect
    const navbar = document.getElementById('mainNavbar');
    
    window.addEventListener('scroll', function() {
        if (window.scrollY > 50) {
            navbar.classList.add('scrolled');
        } else {
            navbar.classList.remove('scrolled');
        }
    });
    
    // Sidebar Toggle
    const sidebarToggle = document.getElementById('sidebarToggle');
    const sidebar = document.getElementById('sidebar');
    const sidebarOverlay = document.getElementById('sidebarOverlay');
    
    if (sidebarToggle) {
        sidebarToggle.addEventListener('click', function(e) {
            e.preventDefault();
            sidebar.classList.toggle('show');
            sidebarOverlay.classList.toggle('show');
            document.body.classList.toggle('sidebar-open');
        });
    }
    
    if (sidebarOverlay) {
        sidebarOverlay.addEventListener('click', function() {
            sidebar.classList.remove('show');
            sidebarOverlay.classList.remove('show');
            document.body.classList.remove('sidebar-open');
        });
    }
    
    // Submenu Toggle
    const submenuToggles = document.querySelectorAll('.submenu-toggle');
    
    submenuToggles.forEach(toggle => {
        toggle.addEventListener('click', function(e) {
            e.preventDefault();
            const parent = this.closest('.has-submenu');
            parent.classList.toggle('open');
        });
    });
    
    // Active submenu based on current page
    const currentPath = window.location.pathname + window.location.search;
    
    document.querySelectorAll('.submenu a').forEach(link => {
        if (link.getAttribute('href') === currentPath.split('/').pop()) {
            const parentSubmenu = link.closest('.submenu');
            const parentItem = parentSubmenu.closest('.has-submenu');
            if (parentItem) {
                parentItem.classList.add('open');
            }
        }
    });
    
    // Handle window resize
    window.addEventListener('resize', function() {
        if (window.innerWidth > 991.98) {
            sidebar.classList.remove('show');
            if (sidebarOverlay) {
                sidebarOverlay.classList.remove('show');
            }
            document.body.classList.remove('sidebar-open');
        }
    });
    const searchInput = document.querySelector('.search-input');
    if (searchInput) {
        searchInput.addEventListener('keypress', function(e) {
            if (e.key === 'Enter') {
                const query = this.value.trim();
                if (query) {
                    window.location.href = `index.php?controller=search&action=results&q=${encodeURIComponent(query)}`;
                }
            }
        });
    }
});
</script>