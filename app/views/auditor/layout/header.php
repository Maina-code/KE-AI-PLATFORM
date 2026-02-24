<?php
// Dashboard Navigation Bar
// This is included in all dashboard pages
?>
<style>
    /* ===== SIDEBAR STYLES ===== */
    .sidebar {
        width: 280px;
        background: var(--sidebar-bg, rgba(10, 15, 28, 0.95));
        backdrop-filter: blur(10px);
        border-right: 1px solid var(--border-light, rgba(255, 255, 255, 0.08));
        position: fixed;
        height: 100vh;
        overflow-y: auto;
        transition: all 0.3s ease;
        z-index: 100;
    }

    .sidebar.collapsed {
        width: 80px;
    }

    .sidebar.collapsed .sidebar-header h3,
    .sidebar.collapsed .user-info,
    .sidebar.collapsed .menu-text,
    .sidebar.collapsed .badge {
        display: none;
    }

    .sidebar-header {
        padding: var(--spacing-lg, 24px);
        display: flex;
        align-items: center;
        justify-content: space-between;
        border-bottom: 1px solid var(--border-light, rgba(255, 255, 255, 0.08));
    }

    .sidebar-header h3 {
        color: var(--gold, #FFB347);
        font-weight: 600;
        font-size: 1.2rem;
        white-space: nowrap;
    }

    .toggle-btn {
        background: transparent;
        border: 1px solid var(--border-light, rgba(255, 255, 255, 0.08));
        color: var(--gold, #FFB347);
        width: 32px;
        height: 32px;
        border-radius: var(--radius-sm, 6px);
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: all 0.2s ease;
    }

    .toggle-btn:hover {
        background: rgba(255, 179, 71, 0.1);
        border-color: var(--gold, #FFB347);
    }

    /* User Profile */
    .user-profile {
        padding: var(--spacing-lg, 24px);
        display: flex;
        align-items: center;
        gap: var(--spacing-md, 16px);
        border-bottom: 1px solid var(--border-light, rgba(255, 255, 255, 0.08));
    }

    .avatar {
        width: 50px;
        height: 50px;
        background: linear-gradient(135deg, var(--gold, #FFB347), #FF9500);
        border-radius: var(--radius-md, 10px);
        display: flex;
        align-items: center;
        justify-content: center;
        color: var(--primary, #0A1929);
        font-weight: 700;
        font-size: 1.2rem;
        box-shadow: var(--shadow-gold, 0 4px 20px rgba(255, 179, 71, 0.2));
    }

    .user-info h4 {
        font-size: 0.95rem;
        margin-bottom: 4px;
        color: var(--text-primary, #F0F4FA);
    }

    .user-info p {
        color: var(--gold, #FFB347);
        font-size: 0.8rem;
        display: flex;
        align-items: center;
        gap: 4px;
        margin: 0;
    }

    /* Navigation Menu */
    .nav-menu {
        padding: var(--spacing-md, 16px) 0;
    }

    .nav-item {
        padding: 12px var(--spacing-lg, 24px);
        display: flex;
        align-items: center;
        gap: var(--spacing-md, 16px);
        color: var(--text-secondary, #B0C4DE);
        text-decoration: none;
        transition: all 0.2s ease;
        border-left: 3px solid transparent;
        margin: 4px 0;
    }

    .nav-item:hover {
        background: rgba(255, 179, 71, 0.05);
        color: var(--gold, #FFB347);
    }

    .nav-item.active {
        background: linear-gradient(90deg, rgba(255, 179, 71, 0.1), transparent);
        color: var(--gold, #FFB347);
        border-left-color: var(--gold, #FFB347);
    }

    .nav-item i {
        width: 24px;
        font-size: 1.2rem;
    }

    .nav-item .badge {
        margin-left: auto;
        background: var(--danger, #FF6B6B);
        color: white;
        padding: 2px 8px;
        border-radius: 20px;
        font-size: 0.7rem;
        font-weight: 600;
    }

    /* ===== TOP NAVBAR STYLES ===== */
    .top-navbar {
        position: fixed;
        top: 0;
        right: 0;
        left: 280px;
        height: 70px;
        background: var(--header-bg, rgba(10, 25, 41, 0.95));
        backdrop-filter: blur(10px);
        border-bottom: 1px solid var(--border-light, rgba(255, 255, 255, 0.08));
        transition: all 0.3s ease;
        z-index: 99;
        display: flex;
        align-items: center;
        padding: 0 var(--spacing-xl, 32px);
    }

    .sidebar.collapsed ~ .top-navbar {
        left: 80px;
    }

    .top-navbar-content {
        display: flex;
        justify-content: space-between;
        align-items: center;
        width: 100%;
    }

    .page-title h2 {
        color: var(--gold, #FFB347);
        font-size: 1.3rem;
        font-weight: 600;
    }

    .page-title p {
        color: var(--text-secondary, #B0C4DE);
        font-size: 0.85rem;
        margin-top: 2px;
    }

    .top-nav-actions {
        display: flex;
        align-items: center;
        gap: var(--spacing-lg, 24px);
    }

    .search-box {
        background: rgba(255, 255, 255, 0.03);
        border: 1px solid var(--border-light, rgba(255, 255, 255, 0.08));
        border-radius: 30px;
        padding: 8px 16px;
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .search-box input {
        background: transparent;
        border: none;
        color: var(--text-primary, #F0F4FA);
        outline: none;
        width: 220px;
        font-size: 0.9rem;
    }

    .search-box input::placeholder {
        color: var(--text-muted, #8A9DB0);
    }

    .search-box i {
        color: var(--gold, #FFB347);
    }

    .notification {
        position: relative;
        cursor: pointer;
    }

    .notification i {
        font-size: 1.3rem;
        color: var(--text-secondary, #B0C4DE);
        transition: color 0.2s ease;
    }

    .notification:hover i {
        color: var(--gold, #FFB347);
    }

    .notification .badge {
        position: absolute;
        top: -5px;
        right: -5px;
        background: var(--danger, #FF6B6B);
        color: white;
        font-size: 0.7rem;
        padding: 2px 6px;
        border-radius: 10px;
        min-width: 18px;
        text-align: center;
    }

    .user-dropdown {
        display: flex;
        align-items: center;
        gap: 10px;
        cursor: pointer;
        padding: 5px 10px;
        border-radius: var(--radius-md, 10px);
        transition: background 0.2s ease;
    }

    .user-dropdown:hover {
        background: rgba(255, 179, 71, 0.1);
    }

    .user-dropdown .avatar-small {
        width: 40px;
        height: 40px;
        background: linear-gradient(135deg, var(--gold, #FFB347), #FF9500);
        border-radius: var(--radius-sm, 6px);
        display: flex;
        align-items: center;
        justify-content: center;
        color: var(--primary, #0A1929);
        font-weight: 700;
    }

    .user-dropdown .user-info-small {
        display: none;
    }

    @media (min-width: 768px) {
        .user-dropdown .user-info-small {
            display: block;
        }
        
        .user-dropdown .user-info-small h4 {
            font-size: 0.9rem;
            color: var(--text-primary, #F0F4FA);
        }
        
        .user-dropdown .user-info-small p {
            font-size: 0.75rem;
            color: var(--gold, #FFB347);
        }
    }

    .user-dropdown i {
        color: var(--gold, #FFB347);
        font-size: 0.8rem;
    }

    /* ===== MAIN CONTENT STYLES (CONTROLLED BY NAVBAR) ===== */
    .main-content {
          flex: 1;
        margin-top: 70px;
        margin-left: 280px;
        padding: var(--spacing-lg, 24px);
        transition: all 0.3s ease;
        min-height: calc(100vh - 70px);
    }

    .sidebar.collapsed ~ .main-content {
        margin-left: 80px;
    }

    /* Mobile Responsive */
    @media (max-width: 768px) {
        .sidebar {
            transform: translateX(-100%);
            position: fixed;
            z-index: 1001;
        }
        
        .sidebar.mobile-open {
            transform: translateX(0);
        }
        
        .top-navbar {
            left: 0 !important;
        }
        
        .main-content {
            margin-left: 0 !important;
        }
        
        .search-box input {
            width: 150px;
        }
        
        .user-dropdown .user-info-small {
            display: none;
        }
    }

    @media (max-width: 480px) {
        .top-navbar {
            padding: 0 var(--spacing-md, 16px);
        }
        
        .page-title h2 {
            font-size: 1rem;
        }
        
        .page-title p {
            display: none;
        }
        
        .search-box {
            display: none;
        }
    }
</style>

<!-- Sidebar -->
<aside class="sidebar" id="sidebar">
    <div class="sidebar-header">
        <h3>Auditor General</h3>
        <button class="toggle-btn" id="toggleSidebar">
            <i class="fas fa-bars"></i>
        </button>
    </div>

    <div class="user-profile">
        <div class="avatar"><?php echo $user_avatar ?? 'AG'; ?></div>
        <div class="user-info">
            <h4><?php echo htmlspecialchars($user_name ?? 'Auditor General'); ?></h4>
            <p><i class="fas fa-shield-alt"></i> <?php echo $user_role ?? 'Auditor General'; ?></p>
        </div>
    </div>

    <nav class="nav-menu">
        <a href="#" class="nav-item active" data-module="dashboard">
            <i class="fas fa-tachometer-alt"></i>
            <span class="menu-text">Dashboard</span>
        </a>
        <a href="#" class="nav-item" data-module="transactions">
            <i class="fas fa-exchange-alt"></i>
            <span class="menu-text">Transactions</span>
            <span class="badge">24</span>
        </a>
        <a href="#" class="nav-item" data-module="cases">
            <i class="fas fa-folder-open"></i>
            <span class="menu-text">Cases</span>
            <span class="badge">12</span>
        </a>
        <a href="#" class="nav-item" data-module="priority">
            <i class="fas fa-exclamation-triangle"></i>
            <span class="menu-text">Priority Review</span>
            <span class="badge" style="background: var(--priority-high, #FF5252);">3</span>
        </a>
        <a href="#" class="nav-item" data-module="reports">
            <i class="fas fa-chart-bar"></i>
            <span class="menu-text">Reports</span>
        </a>
        <a href="#" class="nav-item" data-module="audit">
            <i class="fas fa-history"></i>
            <span class="menu-text">Audit Trail</span>
        </a>
        <a href="#" class="nav-item" data-module="settings">
            <i class="fas fa-cog"></i>
            <span class="menu-text">Settings</span>
        </a>
        <a href="/KE-AI-PLATFORM/public/index.php?controller=auth&action=logout" class="nav-item">
            <i class="fas fa-sign-out-alt"></i>
            <span class="menu-text">Logout</span>
        </a>
    </nav>
</aside>

<!-- Top Navbar -->
<nav class="top-navbar" id="topNavbar">
    <div class="top-navbar-content">
            <header class="header">
                <div class="greeting">
                    <h1>Good <?php echo date('a') === 'am' ? 'Morning' : 'Afternoon'; ?>, <?php echo htmlspecialchars($user_name); ?></h1>
                    <p><i class="fas fa-calendar-alt"></i> <?php echo date('l, F j, Y'); ?></p>
                </div>
            </header>
        <div class="top-nav-actions">
            <div class="search-box">
                <i class="fas fa-search"></i>
                <input type="text" placeholder="Search transactions, cases...">
            </div>
            <div class="notification">
                <i class="fas fa-bell"></i>
                <span class="badge">5</span>
            </div>
            <div class="user-dropdown" id="userDropdown">
                <div class="avatar-small"><?php echo $user_avatar ?? 'AG'; ?></div>
                <div class="user-info-small">
                    <h4><?php echo htmlspecialchars($user_name ?? 'Auditor General'); ?></h4>
                    <p><?php echo $user_role ?? 'Auditor General'; ?></p>
                </div>
                <i class="fas fa-chevron-down"></i>
            </div>
        </div>
    </div>
</nav>

<script>
    // Sidebar Toggle functionality
    document.addEventListener('DOMContentLoaded', function() {
        const sidebar = document.getElementById('sidebar');
        const toggleBtn = document.getElementById('toggleSidebar');
        const topNavbar = document.getElementById('topNavbar');
        const mainContent = document.querySelector('.main-content');

        if (toggleBtn) {
            toggleBtn.addEventListener('click', function(e) {
                e.stopPropagation();
                sidebar.classList.toggle('collapsed');
                
                // For mobile
                if (window.innerWidth <= 768) {
                    sidebar.classList.toggle('mobile-open');
                }
            });
        }

        // Mobile menu handling - close when clicking outside
        if (window.innerWidth <= 768) {
            document.addEventListener('click', function(e) {
                if (!sidebar.contains(e.target) && !toggleBtn.contains(e.target)) {
                    sidebar.classList.remove('mobile-open');
                }
            });
        }

        // Handle window resize
        window.addEventListener('resize', function() {
            if (window.innerWidth > 768) {
                sidebar.classList.remove('mobile-open');
            }
        });

        // Navigation active state and page title update
        const navItems = document.querySelectorAll('.nav-item');
        const pageTitle = document.getElementById('pageTitle');
        const pageDescription = document.getElementById('pageDescription');
        
        const pageTitles = {
            dashboard: { title: 'Dashboard', description: 'Overview of your integrity platform' },
            transactions: { title: 'Transactions', description: 'Monitor and analyze financial transactions' },
            cases: { title: 'Cases', description: 'Manage investigation cases' },
            priority: { title: 'Priority Review', description: 'High, medium and low priority cases' },
            reports: { title: 'Reports', description: 'Generate and view audit reports' },
            audit: { title: 'Audit Trail', description: 'System activity and audit logs' },
            settings: { title: 'Settings', description: 'Configure your preferences' }
        };

        navItems.forEach(item => {
            item.addEventListener('click', function(e) {
                const href = this.getAttribute('href');
                
                // Don't prevent default for logout link
                if (href && href.includes('logout')) {
                    return;
                }
                
                e.preventDefault();
                
                // Remove active class from all nav items
                navItems.forEach(nav => nav.classList.remove('active'));
                
                // Add active class to clicked item
                this.classList.add('active');
                
                // Update page title based on module
                const moduleName = this.dataset.module;
                if (moduleName && pageTitles[moduleName]) {
                    pageTitle.textContent = pageTitles[moduleName].title;
                    pageDescription.textContent = pageTitles[moduleName].description;
                }
                
                // Trigger module change if function exists
                if (moduleName && typeof window.switchModule === 'function') {
                    window.switchModule(moduleName);
                }
                
                // Close mobile menu after selection
                if (window.innerWidth <= 768) {
                    sidebar.classList.remove('mobile-open');
                }
            });
        });

        // User dropdown click (you can expand this to show a dropdown menu)
        const userDropdown = document.getElementById('userDropdown');
        if (userDropdown) {
            userDropdown.addEventListener('click', function() {
                // Toggle user menu - you can implement a dropdown menu here
                console.log('User dropdown clicked');
            });
        }

        // Notification click
        const notification = document.querySelector('.notification');
        if (notification) {
            notification.addEventListener('click', function() {
                // Show notifications panel
                console.log('Notifications clicked');
            });
        }

        // Search functionality
        const searchInput = document.querySelector('.search-box input');
        if (searchInput) {
            searchInput.addEventListener('keyup', function(e) {
                const searchTerm = e.target.value.toLowerCase();
                // Implement search logic here
                console.log('Searching for:', searchTerm);
            });
        }
    });
</script>