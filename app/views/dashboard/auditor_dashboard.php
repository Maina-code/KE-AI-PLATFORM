<?php
// Start session if not already started
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// TEMPORARY: Comment out session check for development
// if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] !== 'auditor') {
//     header('Location: /KE-AI-PLATFORM/public/index.php?controller=auth&action=login');
//     exit();
// }

// Get user info from session (temporary dummy data for development)
$user_name = $_SESSION['user_name'] ?? 'Auditor General';
$user_email = $_SESSION['user_email'] ?? 'auditor@gov.ke';
$user_role = 'Auditor General';
$user_avatar = strtoupper(substr($user_name, 0, 2));

// Include the external navbar
require_once __DIR__ . '/../layout/dashboardnavbar.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Auditor General Dashboard | NuruAI Integrity Platform</title>
    
    <!-- Security Headers -->
    <meta http-equiv="Content-Security-Policy" content="default-src 'self'; script-src 'self' https://cdn.jsdelivr.net https://code.jquery.com https://cdn.datatables.net https://cdn.jsdelivr.net 'unsafe-inline'; style-src 'self' https://fonts.googleapis.com https://cdn.jsdelivr.net https://cdn.datatables.net 'unsafe-inline'; font-src 'self' https://fonts.gstatic.com; connect-src 'self' http://localhost; img-src 'self' data:;">
    
    <!-- Fonts & Icons -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- DataTables -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.5.0/css/responsive.dataTables.min.css">
    
    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
    
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        :root {
            --primary: #0A1929;
            --primary-light: #1A2C3E;
            --primary-dark: #051020;
            --accent: #00B8A9;
            --accent-glow: #00D4C0;
            --gold: #FFB347;
            --gold-light: #FFD966;
            --danger: #FF6B6B;
            --success: #4CAF50;
            --warning: #FFA726;
            --info: #42A5F5;
            --text-primary: #F0F4FA;
            --text-secondary: #B0C4DE;
            --text-muted: #8A9DB0;
            --border-light: rgba(255, 255, 255, 0.08);
            --card-bg: rgba(18, 28, 45, 0.85);
            --card-bg-hover: rgba(25, 38, 58, 0.95);
            --header-bg: rgba(10, 25, 41, 0.9);
            
            /* Priority colors */
            --priority-high: #FF5252;
            --priority-medium: #FFB74D;
            --priority-low: #66BB6A;
            
            /* Status colors */
            --status-pending: #FFA726;
            --status-investigating: #42A5F5;
            --status-resolved: #66BB6A;
            --status-archived: #8A9DB0;
            
            /* Chart sizes - reduced */
            --chart-height: 200px;
            --chart-width: 100%;
            
            /* Spacing */
            --spacing-xs: 4px;
            --spacing-sm: 8px;
            --spacing-md: 16px;
            --spacing-lg: 24px;
            --spacing-xl: 32px;
            
            /* Border radius */
            --radius-sm: 6px;
            --radius-md: 10px;
            --radius-lg: 16px;
            --radius-xl: 24px;
            
            /* Shadows */
            --shadow-sm: 0 2px 4px rgba(0, 0, 0, 0.1);
            --shadow-md: 0 4px 12px rgba(0, 0, 0, 0.15);
            --shadow-lg: 0 8px 24px rgba(0, 0, 0, 0.2);
            --shadow-gold: 0 4px 20px rgba(255, 179, 71, 0.2);
        }

        body {
            font-family: 'Inter', sans-serif;
            background: linear-gradient(135deg, var(--primary-dark), var(--primary));
            color: var(--text-primary);
            min-height: 100vh;
            overflow-x: hidden;
        }

        /* Scrollbar Styling */
        ::-webkit-scrollbar {
            width: 6px;
            height: 6px;
        }

        ::-webkit-scrollbar-track {
            background: var(--primary-dark);
        }

        ::-webkit-scrollbar-thumb {
            background: var(--gold);
            border-radius: 10px;
        }

        ::-webkit-scrollbar-thumb:hover {
            background: var(--gold-light);
        }

        /* Dashboard Layout */
        .dashboard {
            display: flex;
            min-height: 100vh;
        }

        /* Quick Actions */
        .quick-actions {
            display: flex;
            gap: var(--spacing-sm);
            flex-wrap: wrap;
            margin-bottom: var(--spacing-xl);
        }

        .quick-action {
            background: var(--card-bg);
            border: 1px solid var(--border-light);
            border-radius: 30px;
            padding: 10px 20px;
            color: var(--text-primary);
            cursor: pointer;
            transition: all 0.2s ease;
            display: flex;
            align-items: center;
            gap: 8px;
            font-size: 0.9rem;
        }

        .quick-action:hover {
            border-color: var(--gold);
            color: var(--gold);
            transform: translateY(-2px);
            box-shadow: var(--shadow-gold);
        }

        .quick-action i {
            color: var(--gold);
        }

        /* Stats Grid */
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));
            gap: var(--spacing-lg);
            margin-bottom: var(--spacing-xl);
        }

        .stat-card {
            background: var(--card-bg);
            backdrop-filter: blur(10px);
            border: 1px solid var(--border-light);
            border-radius: var(--radius-lg);
            padding: var(--spacing-lg);
            display: flex;
            align-items: center;
            gap: var(--spacing-md);
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
        }

        .stat-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 2px;
            background: linear-gradient(90deg, var(--gold), var(--accent));
            opacity: 0;
            transition: opacity 0.3s ease;
        }

        .stat-card:hover {
            transform: translateY(-4px);
            box-shadow: var(--shadow-lg);
            background: var(--card-bg-hover);
        }

        .stat-card:hover::before {
            opacity: 1;
        }

        .stat-icon {
            width: 60px;
            height: 60px;
            background: rgba(255, 179, 71, 0.1);
            border-radius: var(--radius-md);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.8rem;
            color: var(--gold);
        }

        .stat-details h3 {
            color: var(--text-secondary);
            font-size: 0.9rem;
            font-weight: 500;
            margin-bottom: 6px;
        }

        .stat-number {
            font-size: 2rem;
            font-weight: 700;
            color: var(--gold);
            margin-bottom: 4px;
            line-height: 1;
        }

        .stat-trend {
            display: flex;
            align-items: center;
            gap: 6px;
            font-size: 0.8rem;
        }

        .trend-up { color: var(--success); }
        .trend-down { color: var(--danger); }

        /* Charts Row - Fixed sizing */
        .charts-row {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(350px, 1fr));
            gap: var(--spacing-lg);
            margin-bottom: var(--spacing-xl);
        }

        .chart-card {
            background: var(--card-bg);
            border: 1px solid var(--border-light);
            border-radius: var(--radius-lg);
            padding: var(--spacing-lg);
        }

        .chart-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: var(--spacing-md);
        }

        .chart-header h3 {
            color: var(--gold);
            font-size: 1rem;
            font-weight: 600;
        }

        .chart-header select {
            background: rgba(255, 255, 255, 0.05);
            border: 1px solid var(--border-light);
            color: var(--text-primary);
            padding: 6px 12px;
            border-radius: 20px;
            font-size: 0.8rem;
            outline: none;
            cursor: pointer;
        }

        .chart-container {
            position: relative;
            height: var(--chart-height);
            width: var(--chart-width);
        }

        /* Priority Section */
        .priority-section {
            margin-bottom: var(--spacing-xl);
        }

        .section-title {
            display: flex;
            align-items: center;
            gap: 10px;
            margin-bottom: var(--spacing-lg);
        }

        .section-title h2 {
            color: var(--gold);
            font-size: 1.2rem;
            font-weight: 600;
        }

        .priority-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: var(--spacing-lg);
        }

        .priority-card {
            background: var(--card-bg);
            border: 1px solid var(--border-light);
            border-radius: var(--radius-lg);
            padding: var(--spacing-lg);
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
        }

        .priority-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 4px;
        }

        .priority-card.high::before { background: linear-gradient(90deg, var(--priority-high), #FF8A80); }
        .priority-card.medium::before { background: linear-gradient(90deg, var(--priority-medium), #FFB74D); }
        .priority-card.low::before { background: linear-gradient(90deg, var(--priority-low), #81C784); }

        .priority-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: var(--spacing-md);
        }

        .priority-header h4 {
            font-size: 1rem;
            color: var(--text-primary);
        }

        .priority-count {
            font-size: 1.8rem;
            font-weight: 700;
        }

        .priority-card.high .priority-count { color: var(--priority-high); }
        .priority-card.medium .priority-count { color: var(--priority-medium); }
        .priority-card.low .priority-count { color: var(--priority-low); }

        .case-list {
            margin-top: var(--spacing-md);
        }

        .case-item {
            padding: 10px 0;
            border-bottom: 1px solid var(--border-light);
        }

        .case-item:last-child {
            border-bottom: none;
        }

        .case-title {
            font-weight: 500;
            font-size: 0.9rem;
            margin-bottom: 4px;
        }

        .case-meta {
            display: flex;
            gap: 10px;
            font-size: 0.75rem;
            color: var(--text-muted);
        }

        /* Module Sections */
        .module-section {
            display: none;
            animation: fadeIn 0.3s ease;
        }

        .module-section.active {
            display: block;
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(10px); }
            to { opacity: 1; transform: translateY(0); }
        }

        /* Tables */
        .table-container {
            background: var(--card-bg);
            border: 1px solid var(--border-light);
            border-radius: var(--radius-lg);
            padding: var(--spacing-lg);
            overflow-x: auto;
        }

        .table-container h3 {
            color: var(--gold);
            margin-bottom: var(--spacing-lg);
            font-size: 1.1rem;
        }

        .dataTables_wrapper {
            color: var(--text-primary);
            font-size: 0.9rem;
        }

        .dataTables_length select,
        .dataTables_filter input {
            background: rgba(255, 255, 255, 0.05) !important;
            border: 1px solid var(--border-light) !important;
            color: var(--text-primary) !important;
            border-radius: var(--radius-sm) !important;
            padding: 6px !important;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th {
            background: rgba(255, 179, 71, 0.1);
            color: var(--gold);
            padding: 12px;
            text-align: left;
            font-weight: 600;
            font-size: 0.85rem;
        }

        td {
            padding: 12px;
            border-bottom: 1px solid var(--border-light);
            color: var(--text-secondary);
            font-size: 0.85rem;
        }

        tr:hover td {
            background: rgba(255, 179, 71, 0.05);
        }

        /* Badges */
        .status-badge {
            padding: 4px 12px;
            border-radius: 20px;
            font-size: 0.7rem;
            font-weight: 600;
            display: inline-block;
            text-transform: uppercase;
        }

        .status-pending { background: rgba(255, 167, 38, 0.15); color: var(--status-pending); }
        .status-investigating { background: rgba(66, 165, 245, 0.15); color: var(--status-investigating); }
        .status-resolved { background: rgba(102, 187, 106, 0.15); color: var(--status-resolved); }
        .status-archived { background: rgba(138, 157, 176, 0.15); color: var(--status-archived); }

        .priority-badge {
            padding: 4px 12px;
            border-radius: 20px;
            font-size: 0.7rem;
            font-weight: 600;
            display: inline-block;
        }

        .priority-high { background: rgba(255, 82, 82, 0.15); color: var(--priority-high); }
        .priority-medium { background: rgba(255, 183, 77, 0.15); color: var(--priority-medium); }
        .priority-low { background: rgba(102, 187, 106, 0.15); color: var(--priority-low); }

        .action-btn {
            background: transparent;
            border: 1px solid var(--border-light);
            color: var(--text-secondary);
            padding: 6px 12px;
            border-radius: var(--radius-sm);
            cursor: pointer;
            transition: all 0.2s ease;
            font-size: 0.75rem;
            margin: 0 3px;
        }

        .action-btn:hover {
            border-color: var(--gold);
            color: var(--gold);
        }

        /* Cases Grid */
        .cases-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(350px, 1fr));
            gap: var(--spacing-lg);
            margin-top: var(--spacing-lg);
        }

        .case-card {
            background: var(--card-bg);
            border: 1px solid var(--border-light);
            border-radius: var(--radius-lg);
            padding: var(--spacing-lg);
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
        }

        .case-card:hover {
            transform: translateY(-4px);
            box-shadow: var(--shadow-lg);
        }

        .case-card.high { border-left: 4px solid var(--priority-high); }
        .case-card.medium { border-left: 4px solid var(--priority-medium); }
        .case-card.low { border-left: 4px solid var(--priority-low); }

        .case-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: var(--spacing-md);
        }

        .case-id {
            color: var(--gold);
            font-weight: 600;
            font-size: 0.85rem;
        }

        .case-body h4 {
            font-size: 1rem;
            margin-bottom: 8px;
            color: var(--text-primary);
        }

        .case-body p {
            color: var(--text-muted);
            font-size: 0.85rem;
            margin-bottom: var(--spacing-md);
        }

        .case-details {
            display: flex;
            flex-wrap: wrap;
            gap: var(--spacing-md);
            margin: var(--spacing-md) 0;
            font-size: 0.8rem;
            color: var(--text-muted);
        }

        .case-details span {
            display: flex;
            align-items: center;
            gap: 4px;
        }

        .case-footer {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-top: var(--spacing-md);
            padding-top: var(--spacing-md);
            border-top: 1px solid var(--border-light);
        }

        /* Settings Grid */
        .settings-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: var(--spacing-lg);
        }

        .settings-card {
            background: var(--card-bg);
            border: 1px solid var(--border-light);
            border-radius: var(--radius-lg);
            padding: var(--spacing-lg);
        }

        .settings-card h3 {
            color: var(--gold);
            font-size: 1rem;
            margin-bottom: var(--spacing-lg);
            padding-bottom: var(--spacing-sm);
            border-bottom: 1px solid var(--border-light);
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .setting-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 12px 0;
            border-bottom: 1px solid var(--border-light);
        }

        .setting-item:last-child {
            border-bottom: none;
        }

        .setting-label {
            color: var(--text-secondary);
            font-size: 0.9rem;
        }

        .setting-value {
            color: var(--gold);
            font-weight: 600;
            font-size: 0.9rem;
        }

        /* Toggle Switch */
        .switch {
            position: relative;
            display: inline-block;
            width: 46px;
            height: 24px;
        }

        .switch input {
            opacity: 0;
            width: 0;
            height: 0;
        }

        .slider {
            position: absolute;
            cursor: pointer;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-color: var(--text-muted);
            transition: .3s;
            border-radius: 24px;
        }

        .slider:before {
            position: absolute;
            content: "";
            height: 18px;
            width: 18px;
            left: 3px;
            bottom: 3px;
            background-color: white;
            transition: .3s;
            border-radius: 50%;
        }

        input:checked + .slider {
            background-color: var(--gold);
        }

        input:checked + .slider:before {
            transform: translateX(22px);
        }

        /* Modal */
        .modal {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.8);
            backdrop-filter: blur(5px);
            z-index: 1000;
            align-items: center;
            justify-content: center;
        }

        .modal-content {
            background: var(--card-bg);
            border: 1px solid var(--border-light);
            border-radius: var(--radius-xl);
            width: 90%;
            max-width: 600px;
            padding: var(--spacing-xl);
            position: relative;
            animation: modalSlideIn 0.3s ease;
        }

        @keyframes modalSlideIn {
            from { transform: translateY(-50px); opacity: 0; }
            to { transform: translateY(0); opacity: 1; }
        }

        .modal-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: var(--spacing-lg);
        }

        .modal-header h3 {
            color: var(--gold);
            font-size: 1.2rem;
        }

        .modal-close {
            background: transparent;
            border: none;
            color: var(--text-muted);
            font-size: 1.5rem;
            cursor: pointer;
            transition: color 0.2s ease;
        }

        .modal-close:hover {
            color: var(--danger);
        }

        .modal-body {
            margin-bottom: var(--spacing-lg);
        }

        .modal-footer {
            display: flex;
            gap: var(--spacing-md);
        }

        .modal-footer button {
            flex: 1;
        }

        /* Button Styles */
        .btn-primary {
            background: linear-gradient(135deg, var(--gold), #FF9500);
            border: none;
            color: var(--primary);
            padding: 12px 24px;
            border-radius: 30px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: var(--shadow-gold);
        }

        .btn-danger {
            background: var(--danger);
            border: none;
            color: white;
            padding: 12px 24px;
            border-radius: 30px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .btn-danger:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(255, 107, 107, 0.3);
        }

        /* Loading Spinner */
        .spinner {
            border: 3px solid rgba(255, 179, 71, 0.1);
            border-top-color: var(--gold);
            border-radius: 50%;
            width: 40px;
            height: 40px;
            animation: spin 1s linear infinite;
            margin: 20px auto;
        }

        @keyframes spin {
            to { transform: rotate(360deg); }
        }

        /* Mobile Responsive */
        @media (max-width: 1024px) {
            .priority-grid {
                grid-template-columns: repeat(2, 1fr);
            }
        }

        @media (max-width: 768px) {
            .priority-grid {
                grid-template-columns: 1fr;
            }
            
            .stats-grid {
                grid-template-columns: 1fr;
            }
            
            .charts-row {
                grid-template-columns: 1fr;
            }
            
            .search-box input {
                width: 150px;
            }
            
            .greeting h1 {
                font-size: 1.2rem;
            }
        }

        @media (max-width: 480px) {
            .header {
                flex-direction: column;
                align-items: stretch;
            }
            
            .header-actions {
                justify-content: space-between;
            }
            
            .search-box {
                flex: 1;
            }
            
            .search-box input {
                width: 100%;
            }
            
            .cases-grid {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>
<body>
    <div class="dashboard">
        <!-- Sidebar is imported from dashboardnavbar.php -->
        
        <!-- Main Content -->
        <main class="main-content" id="mainContent">
            <!-- Header -->
            <header class="header">
                <div class="greeting">
                    <h1>Good <?php echo date('a') === 'am' ? 'Morning' : 'Afternoon'; ?>, <?php echo htmlspecialchars($user_name); ?></h1>
                    <p><i class="fas fa-calendar-alt"></i> <?php echo date('l, F j, Y'); ?></p>
                </div>
                <div class="header-actions">
                    <div class="search-box">
                        <i class="fas fa-search"></i>
                        <input type="text" placeholder="Search transactions, cases...">
                    </div>
                    <div class="notification">
                        <i class="fas fa-bell"></i>
                        <span class="badge">5</span>
                    </div>
                </div>
            </header>

            <!-- Quick Actions -->
            <div class="quick-actions">
                <button class="quick-action">
                    <i class="fas fa-plus-circle"></i> New Case
                </button>
                <button class="quick-action">
                    <i class="fas fa-file-export"></i> Export Report
                </button>
                <button class="quick-action">
                    <i class="fas fa-filter"></i> Filter Transactions
                </button>
                <button class="quick-action">
                    <i class="fas fa-flag"></i> Flag Irregularity
                </button>
                <button class="quick-action">
                    <i class="fas fa-chart-line"></i> Analytics
                </button>
            </div>

            <!-- DASHBOARD MODULE -->
            <div id="dashboard-module" class="module-section active">
                <!-- Stats Cards -->
                <div class="stats-grid">
                    <div class="stat-card">
                        <div class="stat-icon"><i class="fas fa-exchange-alt"></i></div>
                        <div class="stat-details">
                            <h3>Total Transactions</h3>
                            <div class="stat-number">1,284</div>
                            <div class="stat-trend">
                                <span class="trend-up"><i class="fas fa-arrow-up"></i> +12%</span>
                                <span>vs last month</span>
                            </div>
                        </div>
                    </div>
                    <div class="stat-card">
                        <div class="stat-icon"><i class="fas fa-exclamation-triangle"></i></div>
                        <div class="stat-details">
                            <h3>Suspicious Cases</h3>
                            <div class="stat-number">47</div>
                            <div class="stat-trend">
                                <span class="trend-up"><i class="fas fa-arrow-up"></i> +5%</span>
                                <span>vs last month</span>
                            </div>
                        </div>
                    </div>
                    <div class="stat-card">
                        <div class="stat-icon"><i class="fas fa-clock"></i></div>
                        <div class="stat-details">
                            <h3>Pending Review</h3>
                            <div class="stat-number">23</div>
                            <div class="stat-trend">
                                <span class="trend-down"><i class="fas fa-arrow-down"></i> -8%</span>
                                <span>vs last month</span>
                            </div>
                        </div>
                    </div>
                    <div class="stat-card">
                        <div class="stat-icon"><i class="fas fa-check-circle"></i></div>
                        <div class="stat-details">
                            <h3>Resolved Cases</h3>
                            <div class="stat-number">156</div>
                            <div class="stat-trend">
                                <span class="trend-up"><i class="fas fa-arrow-up"></i> +23%</span>
                                <span>vs last month</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Charts Row -->
                <div class="charts-row">
                    <div class="chart-card">
                        <div class="chart-header">
                            <h3>Transaction Analysis</h3>
                            <select>
                                <option>Last 7 days</option>
                                <option>Last 30 days</option>
                                <option>Last 3 months</option>
                            </select>
                        </div>
                        <div class="chart-container">
                            <canvas id="transactionChart"></canvas>
                        </div>
                    </div>
                    <div class="chart-card">
                        <div class="chart-header">
                            <h3>Cases by Priority</h3>
                            <select>
                                <option>This Month</option>
                                <option>This Quarter</option>
                                <option>This Year</option>
                            </select>
                        </div>
                        <div class="chart-container">
                            <canvas id="priorityChart"></canvas>
                        </div>
                    </div>
                </div>

                <!-- Priority Overview -->
                <div class="priority-section">
                    <div class="section-title">
                        <i class="fas fa-exclamation-triangle" style="color: var(--gold);"></i>
                        <h2>Priority Cases Overview</h2>
                    </div>
                    <div class="priority-grid">
                        <div class="priority-card high">
                            <div class="priority-header">
                                <h4>High Priority</h4>
                                <span class="priority-count">12</span>
                            </div>
                            <div class="case-list">
                                <div class="case-item">
                                    <div class="case-title">Tender KRA/2024/56</div>
                                    <div class="case-meta">
                                        <span>KES 4.5M</span>
                                        <span>•</span>
                                        <span>2 days ago</span>
                                    </div>
                                </div>
                                <div class="case-item">
                                    <div class="case-title">Procurement MC/2024/123</div>
                                    <div class="case-meta">
                                        <span>KES 2.8M</span>
                                        <span>•</span>
                                        <span>3 days ago</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="priority-card medium">
                            <div class="priority-header">
                                <h4>Medium Priority</h4>
                                <span class="priority-count">24</span>
                            </div>
                            <div class="case-list">
                                <div class="case-item">
                                    <div class="case-title">Contract KPA/2024/89</div>
                                    <div class="case-meta">
                                        <span>KES 1.2M</span>
                                        <span>•</span>
                                        <span>5 days ago</span>
                                    </div>
                                </div>
                                <div class="case-item">
                                    <div class="case-title">Supply KN/2024/45</div>
                                    <div class="case-meta">
                                        <span>KES 890K</span>
                                        <span>•</span>
                                        <span>1 week ago</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="priority-card low">
                            <div class="priority-header">
                                <h4>Low Priority</h4>
                                <span class="priority-count">11</span>
                            </div>
                            <div class="case-list">
                                <div class="case-item">
                                    <div class="case-title">Service KFS/2024/67</div>
                                    <div class="case-meta">
                                        <span>KES 450K</span>
                                        <span>•</span>
                                        <span>2 weeks ago</span>
                                    </div>
                                </div>
                                <div class="case-item">
                                    <div class="case-title">Maintenance KWS/24</div>
                                    <div class="case-meta">
                                        <span>KES 230K</span>
                                        <span>•</span>
                                        <span>2 weeks ago</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- TRANSACTIONS MODULE -->
            <div id="transactions-module" class="module-section">
                <div class="table-container">
                    <h3><i class="fas fa-exchange-alt"></i> Recent Transactions</h3>
                    <table id="transactionsTable" class="display responsive nowrap" style="width:100%">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Date</th>
                                <th>Description</th>
                                <th>Amount</th>
                                <th>Department</th>
                                <th>Status</th>
                                <th>Priority</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>TR-2024-001</td>
                                <td>2024-02-15</td>
                                <td>Tender for Office Supplies</td>
                                <td>KES 1,250,000</td>
                                <td>Procurement</td>
                                <td><span class="status-badge status-pending">Pending</span></td>
                                <td><span class="priority-badge priority-high">High</span></td>
                                <td>
                                    <button class="action-btn" onclick="showCaseModal('CASE-2024-001')"><i class="fas fa-eye"></i></button>
                                    <button class="action-btn"><i class="fas fa-flag"></i></button>
                                </td>
                            </tr>
                            <tr>
                                <td>TR-2024-002</td>
                                <td>2024-02-14</td>
                                <td>Consultancy Services</td>
                                <td>KES 3,750,000</td>
                                <td>Finance</td>
                                <td><span class="status-badge status-investigating">Investigating</span></td>
                                <td><span class="priority-badge priority-high">High</span></td>
                                <td>
                                    <button class="action-btn" onclick="showCaseModal('CASE-2024-002')"><i class="fas fa-eye"></i></button>
                                    <button class="action-btn"><i class="fas fa-flag"></i></button>
                                </td>
                            </tr>
                            <tr>
                                <td>TR-2024-003</td>
                                <td>2024-02-13</td>
                                <td>Infrastructure Project</td>
                                <td>KES 12,500,000</td>
                                <td>Infrastructure</td>
                                <td><span class="status-badge status-resolved">Resolved</span></td>
                                <td><span class="priority-badge priority-medium">Medium</span></td>
                                <td>
                                    <button class="action-btn" onclick="showCaseModal('CASE-2024-003')"><i class="fas fa-eye"></i></button>
                                    <button class="action-btn"><i class="fas fa-flag"></i></button>
                                </td>
                            </tr>
                            <tr>
                                <td>TR-2024-004</td>
                                <td>2024-02-12</td>
                                <td>IT Equipment Supply</td>
                                <td>KES 890,000</td>
                                <td>ICT</td>
                                <td><span class="status-badge status-pending">Pending</span></td>
                                <td><span class="priority-badge priority-low">Low</span></td>
                                <td>
                                    <button class="action-btn" onclick="showCaseModal('CASE-2024-004')"><i class="fas fa-eye"></i></button>
                                    <button class="action-btn"><i class="fas fa-flag"></i></button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- CASES MODULE -->
            <div id="cases-module" class="module-section">
                <div class="cases-grid">
                    <div class="case-card high">
                        <div class="case-header">
                            <span class="case-id">#CASE-2024-001</span>
                            <span class="priority-badge priority-high">HIGH</span>
                        </div>
                        <div class="case-body">
                            <h4>Irregular Tender Award - Ministry of Health</h4>
                            <p>Suspected bid rigging in medical equipment procurement worth KES 45M</p>
                            <div class="case-details">
                                <span><i class="fas fa-calendar"></i> Feb 15, 2024</span>
                                <span><i class="fas fa-building"></i> Health</span>
                                <span><i class="fas fa-tag"></i> Procurement</span>
                            </div>
                        </div>
                        <div class="case-footer">
                            <span>Status: <span class="status-badge status-investigating">Investigating</span></span>
                            <button class="action-btn" onclick="showCaseModal('CASE-2024-001')">View</button>
                        </div>
                    </div>
                    <div class="case-card medium">
                        <div class="case-header">
                            <span class="case-id">#CASE-2024-002</span>
                            <span class="priority-badge priority-medium">MEDIUM</span>
                        </div>
                        <div class="case-body">
                            <h4>Overpriced Consultancy Contract</h4>
                            <p>Consultancy fees 40% above market rate at KRA</p>
                            <div class="case-details">
                                <span><i class="fas fa-calendar"></i> Feb 12, 2024</span>
                                <span><i class="fas fa-building"></i> KRA</span>
                                <span><i class="fas fa-tag"></i> Consultancy</span>
                            </div>
                        </div>
                        <div class="case-footer">
                            <span>Status: <span class="status-badge status-pending">Pending</span></span>
                            <button class="action-btn" onclick="showCaseModal('CASE-2024-002')">View</button>
                        </div>
                    </div>
                    <div class="case-card low">
                        <div class="case-header">
                            <span class="case-id">#CASE-2024-003</span>
                            <span class="priority-badge priority-low">LOW</span>
                        </div>
                        <div class="case-body">
                            <h4>Duplicate Payment - Ministry of Education</h4>
                            <p>Double payment for same invoice worth KES 230K</p>
                            <div class="case-details">
                                <span><i class="fas fa-calendar"></i> Feb 10, 2024</span>
                                <span><i class="fas fa-building"></i> Education</span>
                                <span><i class="fas fa-tag"></i> Finance</span>
                            </div>
                        </div>
                        <div class="case-footer">
                            <span>Status: <span class="status-badge status-resolved">Resolved</span></span>
                            <button class="action-btn" onclick="showCaseModal('CASE-2024-003')">View</button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- PRIORITY REVIEW MODULE -->
            <div id="priority-module" class="module-section">
                <div class="stats-grid">
                    <div class="stat-card">
                        <div class="stat-icon" style="background: rgba(255,82,82,0.1); color: var(--priority-high);">
                            <i class="fas fa-exclamation"></i>
                        </div>
                        <div class="stat-details">
                            <h3>High Priority</h3>
                            <div class="stat-number">12</div>
                            <div class="stat-trend">Requires immediate attention</div>
                        </div>
                    </div>
                    <div class="stat-card">
                        <div class="stat-icon" style="background: rgba(255,183,77,0.1); color: var(--priority-medium);">
                            <i class="fas fa-clock"></i>
                        </div>
                        <div class="stat-details">
                            <h3>Medium Priority</h3>
                            <div class="stat-number">24</div>
                            <div class="stat-trend">Review within 7 days</div>
                        </div>
                    </div>
                    <div class="stat-card">
                        <div class="stat-icon" style="background: rgba(102,187,106,0.1); color: var(--priority-low);">
                            <i class="fas fa-check"></i>
                        </div>
                        <div class="stat-details">
                            <h3>Low Priority</h3>
                            <div class="stat-number">11</div>
                            <div class="stat-trend">Routine review</div>
                        </div>
                    </div>
                </div>

                <div class="table-container">
                    <h3><i class="fas fa-exclamation-triangle"></i> Priority Cases</h3>
                    <table id="priorityTable" class="display responsive nowrap" style="width:100%">
                        <thead>
                            <tr>
                                <th>Case ID</th>
                                <th>Title</th>
                                <th>Department</th>
                                <th>Amount</th>
                                <th>Priority</th>
                                <th>Deadline</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>#CASE-2024-001</td>
                                <td>Medical Equipment Tender</td>
                                <td>Health</td>
                                <td>KES 45,000,000</td>
                                <td><span class="priority-badge priority-high">High</span></td>
                                <td>2024-02-20</td>
                                <td><button class="action-btn" onclick="showCaseModal('CASE-2024-001')">Review</button></td>
                            </tr>
                            <tr>
                                <td>#CASE-2024-004</td>
                                <td>Road Construction Contract</td>
                                <td>Infrastructure</td>
                                <td>KES 120,000,000</td>
                                <td><span class="priority-badge priority-high">High</span></td>
                                <td>2024-02-22</td>
                                <td><button class="action-btn" onclick="showCaseModal('CASE-2024-004')">Review</button></td>
                            </tr>
                            <tr>
                                <td>#CASE-2024-002</td>
                                <td>Consultancy Fees</td>
                                <td>KRA</td>
                                <td>KES 3,750,000</td>
                                <td><span class="priority-badge priority-medium">Medium</span></td>
                                <td>2024-02-25</td>
                                <td><button class="action-btn" onclick="showCaseModal('CASE-2024-002')">Review</button></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- REPORTS MODULE -->
            <div id="reports-module" class="module-section">
                <div class="charts-row">
                    <div class="chart-card">
                        <div class="chart-header">
                            <h3>Monthly Report</h3>
                            <button class="action-btn"><i class="fas fa-download"></i> Download</button>
                        </div>
                        <div class="chart-container">
                            <canvas id="monthlyReportChart"></canvas>
                        </div>
                    </div>
                    <div class="chart-card">
                        <div class="chart-header">
                            <h3>Department Analysis</h3>
                            <button class="action-btn"><i class="fas fa-download"></i> Download</button>
                        </div>
                        <div class="chart-container">
                            <canvas id="departmentChart"></canvas>
                        </div>
                    </div>
                </div>

                <div class="table-container">
                    <h3><i class="fas fa-file-alt"></i> Generated Reports</h3>
                    <table class="display responsive nowrap" style="width:100%">
                        <thead>
                            <tr>
                                <th>Report Name</th>
                                <th>Date Generated</th>
                                <th>Period</th>
                                <th>Type</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>Monthly Procurement Audit</td>
                                <td>2024-02-15</td>
                                <td>January 2024</td>
                                <td>Audit Report</td>
                                <td>
                                    <button class="action-btn"><i class="fas fa-download"></i></button>
                                    <button class="action-btn"><i class="fas fa-eye"></i></button>
                                </td>
                            </tr>
                            <tr>
                                <td>Suspicious Transactions Q1</td>
                                <td>2024-02-10</td>
                                <td>Q1 2024</td>
                                <td>Analysis</td>
                                <td>
                                    <button class="action-btn"><i class="fas fa-download"></i></button>
                                    <button class="action-btn"><i class="fas fa-eye"></i></button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- AUDIT TRAIL MODULE -->
            <div id="audit-module" class="module-section">
                <div class="table-container">
                    <h3><i class="fas fa-history"></i> System Audit Trail</h3>
                    <table class="display responsive nowrap" style="width:100%">
                        <thead>
                            <tr>
                                <th>Timestamp</th>
                                <th>User</th>
                                <th>Action</th>
                                <th>Resource</th>
                                <th>IP Address</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>2024-02-15 09:23:45</td>
                                <td>auditor@gov.ke</td>
                                <td>Case Review</td>
                                <td>CASE-2024-001</td>
                                <td>192.168.1.45</td>
                                <td><span class="status-badge status-resolved">Success</span></td>
                            </tr>
                            <tr>
                                <td>2024-02-15 08:45:12</td>
                                <td>auditor@gov.ke</td>
                                <td>Login</td>
                                <td>System</td>
                                <td>192.168.1.45</td>
                                <td><span class="status-badge status-resolved">Success</span></td>
                            </tr>
                            <tr>
                                <td>2024-02-14 16:30:22</td>
                                <td>auditor@gov.ke</td>
                                <td>Export Report</td>
                                <td>Monthly Audit</td>
                                <td>192.168.1.45</td>
                                <td><span class="status-badge status-resolved">Success</span></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- SETTINGS MODULE -->
            <div id="settings-module" class="module-section">
                <div class="settings-grid">
                    <!-- Profile Settings -->
                    <div class="settings-card">
                        <h3><i class="fas fa-user"></i> Profile Settings</h3>
                        <div class="setting-item">
                            <span class="setting-label">Name</span>
                            <span class="setting-value"><?php echo htmlspecialchars($user_name); ?></span>
                        </div>
                        <div class="setting-item">
                            <span class="setting-label">Email</span>
                            <span class="setting-value"><?php echo htmlspecialchars($user_email); ?></span>
                        </div>
                        <div class="setting-item">
                            <span class="setting-label">Role</span>
                            <span class="setting-value">Auditor General</span>
                        </div>
                        <div class="setting-item">
                            <span class="setting-label">Department</span>
                            <span class="setting-value">Office of the Auditor General</span>
                        </div>
                        <button class="btn-primary" style="margin-top: 20px; width: 100%;">Update Profile</button>
                    </div>

                    <!-- Notification Settings -->
                    <div class="settings-card">
                        <h3><i class="fas fa-bell"></i> Notifications</h3>
                        <div class="setting-item">
                            <span class="setting-label">Email Alerts</span>
                            <label class="switch">
                                <input type="checkbox" checked>
                                <span class="slider"></span>
                            </label>
                        </div>
                        <div class="setting-item">
                            <span class="setting-label">SMS Alerts</span>
                            <label class="switch">
                                <input type="checkbox">
                                <span class="slider"></span>
                            </label>
                        </div>
                        <div class="setting-item">
                            <span class="setting-label">Daily Digest</span>
                            <label class="switch">
                                <input type="checkbox" checked>
                                <span class="slider"></span>
                            </label>
                        </div>
                    </div>

                    <!-- Security Settings -->
                    <div class="settings-card">
                        <h3><i class="fas fa-shield-alt"></i> Security</h3>
                        <div class="setting-item">
                            <span class="setting-label">Two-Factor Auth</span>
                            <label class="switch">
                                <input type="checkbox" checked>
                                <span class="slider"></span>
                            </label>
                        </div>
                        <div class="setting-item">
                            <span class="setting-label">Session Timeout</span>
                            <span class="setting-value">30 minutes</span>
                        </div>
                        <div class="setting-item">
                            <span class="setting-label">Last Login</span>
                            <span class="setting-value"><?php echo date('Y-m-d H:i:s'); ?></span>
                        </div>
                        <button class="btn-danger" style="margin-top: 20px; width: 100%;">Change Password</button>
                    </div>

                    <!-- System Settings -->
                    <div class="settings-card">
                        <h3><i class="fas fa-cog"></i> System</h3>
                        <div class="setting-item">
                            <span class="setting-label">Language</span>
                            <select class="setting-value" style="background: rgba(255,255,255,0.05); border: 1px solid var(--border-light); color: var(--text-primary); padding: 5px; border-radius: var(--radius-sm);">
                                <option>English</option>
                                <option>Swahili</option>
                            </select>
                        </div>
                        <div class="setting-item">
                            <span class="setting-label">Timezone</span>
                            <select class="setting-value" style="background: rgba(255,255,255,0.05); border: 1px solid var(--border-light); color: var(--text-primary); padding: 5px; border-radius: var(--radius-sm);">
                                <option>Nairobi (GMT+3)</option>
                                <option>Mombasa (GMT+3)</option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>

    <!-- Case Details Modal -->
    <div class="modal" id="caseModal">
        <div class="modal-content">
            <div class="modal-header">
                <h3>Case Details</h3>
                <button class="modal-close" onclick="closeCaseModal()">&times;</button>
            </div>
            <div class="modal-body" id="caseDetailsContent">
                <!-- Case details will be loaded here -->
            </div>
            <div class="modal-footer">
                <button class="action-btn" style="flex: 1;">Assign</button>
                <button class="action-btn" style="flex: 1;">Update Status</button>
                <button class="action-btn" style="flex: 1;">Add Note</button>
            </div>
        </div>
    </div>

    <!-- Scripts -->
    <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.5.0/js/dataTables.responsive.min.js"></script>
    
    <script>
        // Initialize DataTables
        $(document).ready(function() {
            $('#transactionsTable').DataTable({
                responsive: true,
                pageLength: 10,
                language: {
                    search: "Search:",
                    lengthMenu: "Show _MENU_ entries",
                    info: "Showing _START_ to _END_ of _TOTAL_ entries"
                }
            });
            
            $('#priorityTable').DataTable({
                responsive: true,
                pageLength: 10
            });
        });

        // Module Navigation
        const navItems = document.querySelectorAll('.nav-item[data-module]');
        const modules = {
            dashboard: document.getElementById('dashboard-module'),
            transactions: document.getElementById('transactions-module'),
            cases: document.getElementById('cases-module'),
            priority: document.getElementById('priority-module'),
            reports: document.getElementById('reports-module'),
            audit: document.getElementById('audit-module'),
            settings: document.getElementById('settings-module')
        };

        // This function will be called from the navbar
        window.switchModule = function(moduleName) {
            Object.values(modules).forEach(module => {
                if (module) module.classList.remove('active');
            });
            
            if (modules[moduleName]) {
                modules[moduleName].classList.add('active');
            }
        };

        // Chart Initialization
        function initCharts() {
            // Transaction Chart - Line
            const ctx1 = document.getElementById('transactionChart')?.getContext('2d');
            if (ctx1) {
                new Chart(ctx1, {
                    type: 'line',
                    data: {
                        labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun'],
                        datasets: [{
                            label: 'Transactions',
                            data: [65, 59, 80, 81, 56, 55],
                            borderColor: '#FFB347',
                            backgroundColor: 'rgba(255, 179, 71, 0.1)',
                            tension: 0.4,
                            fill: true,
                            pointBackgroundColor: '#FFB347',
                            pointBorderColor: '#fff',
                            pointBorderWidth: 2,
                            pointRadius: 4
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: true,
                        plugins: {
                            legend: { display: false }
                        },
                        scales: {
                            y: {
                                grid: { color: 'rgba(255,255,255,0.05)' },
                                ticks: { color: '#B0C4DE' }
                            },
                            x: {
                                grid: { display: false },
                                ticks: { color: '#B0C4DE' }
                            }
                        }
                    }
                });
            }

            // Priority Chart - Doughnut
            const ctx2 = document.getElementById('priorityChart')?.getContext('2d');
            if (ctx2) {
                new Chart(ctx2, {
                    type: 'doughnut',
                    data: {
                        labels: ['High (12)', 'Medium (24)', 'Low (11)'],
                        datasets: [{
                            data: [12, 24, 11],
                            backgroundColor: ['#FF5252', '#FFB74D', '#66BB6A'],
                            borderWidth: 0,
                            hoverOffset: 4
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: true,
                        cutout: '65%',
                        plugins: {
                            legend: {
                                position: 'bottom',
                                labels: { color: '#B0C4DE', padding: 10 }
                            }
                        }
                    }
                });
            }

            // Monthly Report Chart - Bar
            const ctx3 = document.getElementById('monthlyReportChart')?.getContext('2d');
            if (ctx3) {
                new Chart(ctx3, {
                    type: 'bar',
                    data: {
                        labels: ['Week 1', 'Week 2', 'Week 3', 'Week 4'],
                        datasets: [{
                            label: 'Cases Opened',
                            data: [12, 19, 15, 17],
                            backgroundColor: '#FFB347',
                            borderRadius: 4
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: true,
                        plugins: {
                            legend: { display: false }
                        },
                        scales: {
                            y: {
                                grid: { color: 'rgba(255,255,255,0.05)' },
                                ticks: { color: '#B0C4DE' }
                            },
                            x: {
                                grid: { display: false },
                                ticks: { color: '#B0C4DE' }
                            }
                        }
                    }
                });
            }

            // Department Chart - Pie
            const ctx4 = document.getElementById('departmentChart')?.getContext('2d');
            if (ctx4) {
                new Chart(ctx4, {
                    type: 'pie',
                    data: {
                        labels: ['Health', 'Education', 'Infrastructure', 'Finance', 'Others'],
                        datasets: [{
                            data: [30, 25, 20, 15, 10],
                            backgroundColor: ['#FF5252', '#FFB74D', '#66BB6A', '#42A5F5', '#8A9DB0'],
                            borderWidth: 0
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: true,
                        plugins: {
                            legend: {
                                position: 'bottom',
                                labels: { color: '#B0C4DE' }
                            }
                        }
                    }
                });
            }
        }

        // Modal Functions
        function showCaseModal(caseId) {
            const modal = document.getElementById('caseModal');
            const content = document.getElementById('caseDetailsContent');
            
            // Sample data - replace with actual AJAX call
            const caseData = {
                id: caseId,
                title: 'Medical Equipment Tender Irregularity',
                description: 'Suspected bid rigging in medical equipment procurement at Ministry of Health',
                department: 'Health',
                amount: 45000000,
                status: 'investigating',
                deadline: '2024-02-20',
                assignedTo: 'Senior Auditor Jane',
                createdDate: '2024-02-15',
                lastUpdated: '2024-02-16'
            };
            
            content.innerHTML = `
                <div style="margin-bottom: 15px;">
                    <label style="color: var(--text-muted); font-size: 0.85rem;">Case ID</label>
                    <p style="color: var(--gold); font-weight: 600;">${caseData.id}</p>
                </div>
                <div style="margin-bottom: 15px;">
                    <label style="color: var(--text-muted); font-size: 0.85rem;">Title</label>
                    <p style="color: white;">${caseData.title}</p>
                </div>
                <div style="margin-bottom: 15px;">
                    <label style="color: var(--text-muted); font-size: 0.85rem;">Description</label>
                    <p style="color: var(--text-secondary);">${caseData.description}</p>
                </div>
                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 15px;">
                    <div>
                        <label style="color: var(--text-muted); font-size: 0.85rem;">Department</label>
                        <p style="color: white;">${caseData.department}</p>
                    </div>
                    <div>
                        <label style="color: var(--text-muted); font-size: 0.85rem;">Amount</label>
                        <p style="color: var(--gold);">KES ${caseData.amount.toLocaleString()}</p>
                    </div>
                    <div>
                        <label style="color: var(--text-muted); font-size: 0.85rem;">Status</label>
                        <p><span class="status-badge status-${caseData.status}">${caseData.status}</span></p>
                    </div>
                    <div>
                        <label style="color: var(--text-muted); font-size: 0.85rem;">Deadline</label>
                        <p style="color: white;">${caseData.deadline}</p>
                    </div>
                </div>
            `;
            
            modal.style.display = 'flex';
        }

        function closeCaseModal() {
            document.getElementById('caseModal').style.display = 'none';
        }

        // Initialize charts
        document.addEventListener('DOMContentLoaded', initCharts);

        // Notification click
        document.querySelector('.notification')?.addEventListener('click', () => {
            alert('Notifications panel would open here');
        });

        // Close modal on outside click
        window.addEventListener('click', (e) => {
            const modal = document.getElementById('caseModal');
            if (e.target === modal) {
                closeCaseModal();
            }
        });
    </script>
</body>
</html>