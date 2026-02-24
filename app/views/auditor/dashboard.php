<?php
require_once __DIR__ . '/layout/header.php';
require_once __DIR__ . '/../layout/loading.php';

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Auditor General Dashboard - Anti-Corruption Monitor</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
    
    <style>
        :root {
            /* Transparent color scheme */
            --glass-bg: rgba(255, 255, 255, 0.1);
            --glass-border: rgba(255, 255, 255, 0.2);
            --glass-shadow: 0 8px 32px 0 rgba(31, 38, 135, 0.15);
            --primary-glass: rgba(10, 35, 81, 0.3);
            --accent-glass: rgba(197, 165, 114, 0.3);
            
            /* Transparency theme */
            --transparency-primary: rgba(255, 255, 255, 0.15);
            --transparency-secondary: rgba(255, 255, 255, 0.05);
            --transparency-accent: rgba(197, 165, 114, 0.25);
            
            /* Core colors */
            --primary: #0A2351;
            --primary-light: #1a3a6b;
            --accent: #C5A572;
            --accent-dark: #9e814d;
            --danger: #dc3545;
            --warning: #ffc107;
            --success: #28a745;
            --info: #17a2b8;
            
            /* Text colors */
            --text-primary: rgba(255, 255, 255, 0.95);
            --text-secondary: rgba(255, 255, 255, 0.7);
            --text-muted: rgba(255, 255, 255, 0.5);
            
            /* Background */
            --bg-gradient-start: #0a2342;
            --bg-gradient-end: #1b3a5c;
        }
        
        body {
            background: linear-gradient(135deg, var(--bg-gradient-start), var(--bg-gradient-end));
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            min-height: 100vh;
            color: var(--text-primary);
        }
        
        /* Main Content */
        .main-content {
            margin-left: 300px;
            margin-top: 80px;
            padding: 30px;
            transition: margin-left 0.3s ease;
        }
        
        /* Welcome Banner - Glass Effect */
        .welcome-banner {
            background: var(--glass-bg);
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
            border: 1px solid var(--glass-border);
            color: var(--text-primary);
            padding: 30px;
            border-radius: 20px;
            margin-bottom: 30px;
            position: relative;
            overflow: hidden;
            box-shadow: var(--glass-shadow);
        }
        
        .welcome-banner::after {
            content: '\f0e8';
            font-family: 'Font Awesome 6 Free';
            font-weight: 900;
            position: absolute;
            right: 20px;
            bottom: 20px;
            font-size: 100px;
            opacity: 0.1;
            color: var(--accent);
        }
        
        .welcome-banner h2 {
            font-weight: 700;
            margin-bottom: 10px;
        }
        
        .welcome-banner p {
            margin-bottom: 5px;
            opacity: 0.9;
        }
        
        .welcome-banner .date-badge {
            background: var(--transparency-primary);
            border: 1px solid var(--glass-border);
            padding: 8px 15px;
            border-radius: 50px;
            display: inline-block;
            margin-top: 15px;
        }
        
        /* Stats Cards - Glass Effect */
        .stats-row {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 20px;
            margin-bottom: 30px;
        }
        
        .stat-card {
            background: var(--glass-bg);
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
            border: 1px solid var(--glass-border);
            border-radius: 20px;
            padding: 25px;
            box-shadow: var(--glass-shadow);
            transition: all 0.3s;
            position: relative;
            overflow: hidden;
        }
        
        .stat-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 40px rgba(0,0,0,0.2);
            border-color: var(--accent);
        }
        
        .stat-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 4px;
        }
        
        .stat-card.total::before { background: var(--primary); }
        .stat-card.high-risk::before { background: var(--danger); }
        .stat-card.flagged::before { background: var(--warning); }
        .stat-card.recovered::before { background: var(--success); }
        
        .stat-icon {
            position: absolute;
            right: 20px;
            top: 20px;
            font-size: 40px;
            opacity: 0.3;
            color: var(--accent);
        }
        
        .stat-label {
            color: var(--text-secondary);
            font-size: 0.9rem;
            text-transform: uppercase;
            letter-spacing: 1px;
            margin-bottom: 10px;
        }
        
        .stat-value {
            font-size: 2.5rem;
            font-weight: 700;
            margin-bottom: 5px;
            color: var(--text-primary);
        }
        
        .stat-trend {
            font-size: 0.85rem;
            display: flex;
            align-items: center;
            gap: 5px;
            color: var(--text-muted);
        }
        
        .trend-up { color: var(--danger); }
        .trend-down { color: var(--success); }
        
        /* AI Alert Banner - Pulsing Glass */
        .ai-alert-banner {
            background: rgba(220, 53, 69, 0.2);
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
            border: 1px solid rgba(220, 53, 69, 0.3);
            color: white;
            padding: 20px;
            border-radius: 15px;
            margin-bottom: 30px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            animation: pulse 2s infinite;
            box-shadow: 0 0 20px rgba(220, 53, 69, 0.3);
        }
        
        @keyframes pulse {
            0% { opacity: 1; }
            50% { opacity: 0.95; box-shadow: 0 0 30px rgba(220, 53, 69, 0.5); }
            100% { opacity: 1; }
        }
        
        .ai-alert-content {
            display: flex;
            align-items: center;
            gap: 20px;
        }
        
        .ai-alert-icon {
            font-size: 40px;
        }
        
        .ai-alert-text h4 {
            margin-bottom: 5px;
            font-weight: 600;
        }
        
        .ai-alert-text p {
            margin-bottom: 0;
            opacity: 0.9;
        }
        
        .ai-confidence {
            background: rgba(255,255,255,0.1);
            backdrop-filter: blur(5px);
            border: 1px solid rgba(255,255,255,0.2);
            padding: 8px 15px;
            border-radius: 50px;
            font-weight: 600;
        }
        
        /* Chart Cards - Glass Effect */
        .charts-row {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(400px, 1fr));
            gap: 20px;
            margin-bottom: 30px;
        }
        
        .chart-card {
            background: var(--glass-bg);
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
            border: 1px solid var(--glass-border);
            border-radius: 20px;
            padding: 20px;
            box-shadow: var(--glass-shadow);
        }
        
        .chart-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
        }
        
        .chart-header h5 {
            margin: 0;
            font-weight: 600;
            color: var(--text-primary);
        }
        
        .chart-header h5 i {
            color: var(--accent);
        }
        
        .chart-header select {
            background: var(--transparency-primary);
            border: 1px solid var(--glass-border);
            border-radius: 8px;
            padding: 5px 10px;
            color: var(--text-primary);
            cursor: pointer;
        }
        
        .chart-header select option {
            background: var(--primary);
            color: white;
        }
        
        .chart-container {
            height: 300px;
            position: relative;
        }
        
        /* Section Titles */
        .section-title {
            display: flex;
            align-items: center;
            gap: 10px;
            margin: 30px 0 20px;
        }
        
        .section-title i {
            font-size: 24px;
            color: var(--accent);
        }
        
        .section-title h3 {
            margin: 0;
            font-weight: 600;
            color: var(--text-primary);
        }
        
        .section-title .badge {
            background: var(--transparency-accent);
            color: var(--accent);
            padding: 5px 15px;
            border-radius: 50px;
            font-size: 0.9rem;
            border: 1px solid var(--accent);
        }
        
        /* Risk Cards Grid - Glass Effect */
        .risk-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(350px, 1fr));
            gap: 20px;
            margin-bottom: 30px;
        }
        
        .risk-card {
            background: var(--glass-bg);
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
            border: 1px solid var(--glass-border);
            border-radius: 20px;
            overflow: hidden;
            box-shadow: var(--glass-shadow);
            transition: all 0.3s;
            border-left: 5px solid;
        }
        
        .risk-card.high { border-left-color: var(--danger); }
        .risk-card.medium { border-left-color: var(--warning); }
        .risk-card.low { border-left-color: var(--success); }
        
        .risk-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 40px rgba(0,0,0,0.2);
            border-color: var(--accent);
        }
        
        .risk-header {
            padding: 20px;
            border-bottom: 1px solid var(--glass-border);
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        
        .risk-ref {
            font-weight: 600;
            color: var(--text-primary);
        }
        
        .risk-badge {
            padding: 5px 12px;
            border-radius: 50px;
            font-size: 0.8rem;
            font-weight: 600;
        }
        
        .risk-badge.high { background: rgba(220, 53, 69, 0.2); color: #ff6b6b; border: 1px solid rgba(220, 53, 69, 0.3); }
        .risk-badge.medium { background: rgba(255, 193, 7, 0.2); color: #ffc107; border: 1px solid rgba(255, 193, 7, 0.3); }
        .risk-badge.low { background: rgba(40, 167, 69, 0.2); color: #2ecc71; border: 1px solid rgba(40, 167, 69, 0.3); }
        
        .risk-body {
            padding: 20px;
        }
        
        .risk-body h5 {
            font-weight: 600;
            margin-bottom: 10px;
            color: var(--text-primary);
        }
        
        .risk-details {
            display: flex;
            flex-wrap: wrap;
            gap: 15px;
            margin: 15px 0;
            color: var(--text-secondary);
            font-size: 0.9rem;
        }
        
        .risk-details span {
            display: flex;
            align-items: center;
            gap: 5px;
        }
        
        .risk-indicators {
            background: var(--transparency-secondary);
            backdrop-filter: blur(5px);
            border: 1px solid var(--glass-border);
            padding: 15px;
            border-radius: 12px;
            margin: 15px 0;
        }
        
        .risk-indicators h6 {
            font-weight: 600;
            margin-bottom: 10px;
            color: var(--accent);
        }
        
        .indicator-list {
            display: flex;
            flex-wrap: wrap;
            gap: 8px;
        }
        
        .indicator-tag {
            background: var(--transparency-primary);
            padding: 4px 10px;
            border-radius: 50px;
            font-size: 0.8rem;
            border: 1px solid var(--glass-border);
            color: var(--text-secondary);
        }
        
        .indicator-tag.high-risk-indicator {
            background: rgba(220, 53, 69, 0.2);
            border-color: rgba(220, 53, 69, 0.3);
            color: #ff6b6b;
        }
        
        .risk-footer {
            padding: 20px;
            border-top: 1px solid var(--glass-border);
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        
        .risk-amount {
            font-weight: 700;
            color: var(--accent);
            font-size: 1.2rem;
        }
        
        .btn-action {
            padding: 8px 20px;
            border-radius: 8px;
            font-weight: 500;
            transition: all 0.3s;
            border: none;
            cursor: pointer;
        }
        
        .btn-action:hover {
            transform: translateY(-2px);
        }
        
        .btn-investigate {
            background: var(--accent);
            color: var(--primary);
        }
        
        .btn-investigate:hover {
            background: var(--accent-dark);
            box-shadow: 0 5px 15px rgba(197, 165, 114, 0.3);
        }
        
        /* Department Risk Table - Glass Effect */
        .dept-risk-table {
            background: var(--glass-bg);
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
            border: 1px solid var(--glass-border);
            border-radius: 20px;
            overflow: hidden;
            box-shadow: var(--glass-shadow);
            margin-bottom: 30px;
        }
        
        .dept-risk-header {
            padding: 20px;
            background: var(--transparency-primary);
            border-bottom: 1px solid var(--glass-border);
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        
        .dept-risk-header h5 {
            margin: 0;
            font-weight: 600;
            color: var(--text-primary);
        }
        
        .dept-risk-header h5 i {
            color: var(--accent);
        }
        
        .dept-risk-header button {
            background: var(--transparency-accent);
            border: 1px solid var(--accent);
            color: var(--accent);
            padding: 8px 15px;
            border-radius: 8px;
            transition: all 0.3s;
        }
        
        .dept-risk-header button:hover {
            background: var(--accent);
            color: var(--primary);
        }
        
        .dept-risk-body {
            padding: 20px;
        }
        
        .dept-risk-row {
            display: flex;
            align-items: center;
            padding: 15px 0;
            border-bottom: 1px solid var(--glass-border);
        }
        
        .dept-risk-row:last-child {
            border-bottom: none;
        }
        
        .dept-name {
            flex: 2;
            font-weight: 500;
            color: var(--text-primary);
        }
        
        .dept-name i {
            color: var(--accent);
        }
        
        .dept-stats {
            flex: 1;
            text-align: center;
            color: var(--text-secondary);
        }
        
        .dept-risk-bar {
            flex: 2;
            height: 8px;
            background: var(--transparency-primary);
            border-radius: 4px;
            overflow: hidden;
            margin: 0 15px;
        }
        
        .risk-bar-fill {
            height: 100%;
            border-radius: 4px;
        }
        
        .risk-bar-fill.high { background: linear-gradient(90deg, var(--danger), #ff6b6b); }
        .risk-bar-fill.medium { background: linear-gradient(90deg, var(--warning), #ffc107); }
        .risk-bar-fill.low { background: linear-gradient(90deg, var(--success), #2ecc71); }
        
        .dept-risk-value {
            flex: 0.5;
            text-align: right;
            font-weight: 600;
            color: var(--text-primary);
        }
        
        .dept-risk-value small {
            color: var(--text-muted);
            font-size: 0.7rem;
        }
        
        /* AI Insights Panel - Gradient Glass */
        .ai-panel {
            background: linear-gradient(135deg, rgba(102, 126, 234, 0.2), rgba(118, 75, 162, 0.2));
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
            border: 1px solid var(--glass-border);
            color: var(--text-primary);
            border-radius: 20px;
            padding: 25px;
            margin-bottom: 30px;
            box-shadow: var(--glass-shadow);
        }
        
        .ai-panel h4 {
            font-weight: 600;
            margin-bottom: 20px;
        }
        
        .ai-panel h4 i {
            color: var(--accent);
        }
        
        .insight-item {
            display: flex;
            align-items: center;
            gap: 15px;
            padding: 15px;
            background: var(--transparency-primary);
            border: 1px solid var(--glass-border);
            border-radius: 12px;
            margin-bottom: 10px;
            transition: all 0.3s;
        }
        
        .insight-item:hover {
            background: var(--transparency-accent);
            transform: translateX(5px);
        }
        
        .insight-icon {
            width: 40px;
            height: 40px;
            background: var(--transparency-accent);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.2rem;
            color: var(--accent);
        }
        
        .insight-content {
            flex: 1;
        }
        
        .insight-title {
            font-weight: 600;
            margin-bottom: 5px;
            color: var(--text-primary);
        }
        
        .insight-desc {
            font-size: 0.9rem;
            color: var(--text-secondary);
        }
        
        .insight-confidence {
            font-size: 0.8rem;
            background: var(--transparency-accent);
            border: 1px solid var(--accent);
            padding: 3px 10px;
            border-radius: 50px;
            color: var(--accent);
        }
        
        /* Quick Actions - Glass Effect */
        .quick-actions {
            display: flex;
            gap: 10px;
            flex-wrap: wrap;
            margin-bottom: 30px;
        }
        
        .quick-action-btn {
            background: var(--glass-bg);
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
            border: 1px solid var(--glass-border);
            border-radius: 12px;
            padding: 15px 25px;
            display: flex;
            align-items: center;
            gap: 10px;
            transition: all 0.3s;
            cursor: pointer;
            color: var(--text-primary);
        }
        
        .quick-action-btn:hover {
            background: var(--transparency-accent);
            border-color: var(--accent);
            transform: translateY(-2px);
            box-shadow: 0 5px 20px rgba(197, 165, 114, 0.2);
        }
        
        .quick-action-btn i {
            font-size: 1.2rem;
            color: var(--accent);
        }
        
        /* Investigation Modal - Glass Effect */
        .modal-content {
            background: rgba(10, 35, 81, 0.4);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border: 1px solid var(--glass-border);
            border-radius: 20px;
            color: var(--text-primary);
        }
        
        .modal-header {
            border-bottom: 1px solid var(--glass-border);
            padding: 20px;
        }
        
        .modal-header .btn-close {
            filter: invert(1) grayscale(100%) brightness(200%);
        }
        
        .modal-body {
            padding: 20px;
        }
        
        .modal-footer {
            border-top: 1px solid var(--glass-border);
            padding: 20px;
        }
        
        .modal-footer .btn-secondary {
            background: var(--transparency-secondary);
            border: 1px solid var(--glass-border);
            color: var(--text-primary);
        }
        
        .modal-footer .btn-primary {
            background: var(--accent);
            border: none;
            color: var(--primary);
        }
        
        .modal-footer .btn-danger {
            background: rgba(220, 53, 69, 0.2);
            border: 1px solid rgba(220, 53, 69, 0.3);
            color: #ff6b6b;
        }
        
        .modal-footer .btn-danger:hover {
            background: rgba(220, 53, 69, 0.3);
        }
        
        /* Tables */
        .dataTables_wrapper {
            color: var(--text-primary);
        }
        
        .dataTables_length select,
        .dataTables_filter input {
            background: var(--transparency-primary) !important;
            border: 1px solid var(--glass-border) !important;
            color: var(--text-primary) !important;
            border-radius: 8px !important;
        }
        
        table {
            color: var(--text-primary) !important;
        }
        
        table thead th {
            color: var(--accent) !important;
            border-bottom: 1px solid var(--glass-border) !important;
        }
        
        table tbody td {
            color: var(--text-secondary) !important;
            border-bottom: 1px solid var(--glass-border) !important;
        }
        
        /* Mobile Responsive */
        @media (max-width: 991.98px) {
            .main-content {
                margin-left: 0;
            }
        }
        
        @media (max-width: 768px) {
            .main-content {
                padding: 20px 15px;
            }
            
            .stats-row {
                grid-template-columns: 1fr;
            }
            
            .charts-row {
                grid-template-columns: 1fr;
            }
            
            .risk-grid {
                grid-template-columns: 1fr;
            }
            
            .welcome-banner {
                padding: 20px;
            }
            
            .quick-actions {
                flex-direction: column;
            }
            
            .ai-alert-banner {
                flex-direction: column;
                text-align: center;
                gap: 15px;
            }
            
            .ai-alert-content {
                flex-direction: column;
                text-align: center;
            }
            
            .dept-risk-row {
                flex-wrap: wrap;
                gap: 10px;
            }
            
            .dept-name {
                flex: 100%;
            }
            
            .dept-risk-bar {
                flex: 1;
            }
        }
        
        /* Loading Spinner */
        .spinner-border {
            color: var(--accent) !important;
        }
        
        /* Custom Scrollbar */
        ::-webkit-scrollbar {
            width: 8px;
            height: 8px;
        }
        
        ::-webkit-scrollbar-track {
            background: var(--transparency-primary);
            border-radius: 4px;
        }
        
        ::-webkit-scrollbar-thumb {
            background: var(--accent);
            border-radius: 4px;
        }
        
        ::-webkit-scrollbar-thumb:hover {
            background: var(--accent-dark);
        }
        
        /* Glass effect for all cards */
        .glass-effect {
            background: var(--glass-bg);
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
            border: 1px solid var(--glass-border);
            border-radius: 15px;
            box-shadow: var(--glass-shadow);
        }
        
        /* Animation for transparency theme */
        @keyframes glow {
            0% { text-shadow: 0 0 5px var(--accent); }
            50% { text-shadow: 0 0 20px var(--accent); }
            100% { text-shadow: 0 0 5px var(--accent); }
        }
        
        .transparency-icon {
            animation: glow 2s infinite;
        }
    </style>
</head>
<body>
    <!-- Navbar is already included at the top -->
    
    <!-- Main Content -->
    <div class="main-content">
        <!-- Welcome Banner -->
        <div class="welcome-banner">
            <div class="row align-items-center">
                <div class="col-md-8">
                    <h2>Welcome back, <?php echo htmlspecialchars($_SESSION['user_name'] ?? 'Auditor General'); ?>!</h2>
                    <p>The AI system has analyzed <strong><?php echo number_format($stats['total_transactions'] ?? 0); ?></strong> transactions in the last 24 hours.</p>
                    <p><i class="fas fa-exclamation-triangle me-2" style="color: var(--accent);"></i> <strong><?php echo $stats['high_risk'] ?? 0; ?></strong> high-risk cases require your immediate attention.</p>
                    <div class="date-badge">
                        <i class="fas fa-calendar me-2" style="color: var(--accent);"></i><?php echo date('l, F j, Y'); ?>
                    </div>
                </div>
                <div class="col-md-4 text-end">
                    <i class="fas fa-robot transparency-icon" style="font-size: 80px; opacity: 0.5;"></i>
                </div>
            </div>
        </div>

        <!-- AI Alert Banner (if high-priority alerts) -->
        <?php if (!empty($aiAlerts) && count($aiAlerts) > 0): ?>
        <div class="ai-alert-banner">
            <div class="ai-alert-content">
                <div class="ai-alert-icon">
                    <i class="fas fa-exclamation-triangle"></i>
                </div>
                <div class="ai-alert-text">
                    <h4>🚨 HIGH PRIORITY AI ALERT</h4>
                    <p><?php echo $aiAlerts[0]['message'] ?? 'Suspicious pattern detected in Ministry of Health procurement'; ?></p>
                </div>
            </div>
            <div class="ai-confidence">
                <i class="fas fa-microchip me-2"></i>AI Confidence: <?php echo $aiAlerts[0]['confidence'] ?? 94; ?>%
            </div>
        </div>
        <?php endif; ?>

        <!-- Statistics Cards -->
        <div class="stats-row">
            <div class="stat-card total">
                <div class="stat-icon">
                    <i class="fas fa-exchange-alt"></i>
                </div>
                <div class="stat-label">Total Transactions</div>
                <div class="stat-value"><?php echo number_format($stats['total_transactions'] ?? 1248); ?></div>
                <div class="stat-trend">
                    <span class="trend-up"><i class="fas fa-arrow-up"></i> +12%</span>
                    <span>vs last month</span>
                </div>
            </div>
            
            <div class="stat-card high-risk">
                <div class="stat-icon">
                    <i class="fas fa-exclamation-triangle"></i>
                </div>
                <div class="stat-label">High Risk Cases</div>
                <div class="stat-value"><?php echo number_format($stats['high_risk'] ?? 47); ?></div>
                <div class="stat-trend">
                    <span class="trend-up"><i class="fas fa-arrow-up"></i> +5%</span>
                    <span>from last week</span>
                </div>
            </div>
            
            <div class="stat-card flagged">
                <div class="stat-icon">
                    <i class="fas fa-flag"></i>
                </div>
                <div class="stat-label">AI Flagged</div>
                <div class="stat-value"><?php echo number_format($stats['ai_flagged'] ?? 23); ?></div>
                <div class="stat-trend">
                    <span><i class="fas fa-clock"></i> Pending review</span>
                </div>
            </div>
            
            <div class="stat-card recovered">
                <div class="stat-icon">
                    <i class="fas fa-coins"></i>
                </div>
                <div class="stat-label">Recovered Funds</div>
                <div class="stat-value">KES <?php echo number_format($stats['recovered_funds'] ?? 45200000); ?></div>
                <div class="stat-trend">
                    <span class="trend-down"><i class="fas fa-arrow-down"></i> -8%</span>
                    <span>vs target</span>
                </div>
            </div>
        </div>

        <!-- Charts Row -->
        <div class="charts-row">
            <div class="chart-card">
                <div class="chart-header">
                    <h5><i class="fas fa-chart-line me-2"></i>Risk Trends by Department</h5>
                    <select id="riskTimeRange">
                        <option value="7">Last 7 days</option>
                        <option value="30" selected>Last 30 days</option>
                        <option value="90">Last 90 days</option>
                    </select>
                </div>
                <div class="chart-container">
                    <canvas id="riskTrendChart"></canvas>
                </div>
            </div>
            
            <div class="chart-card">
                <div class="chart-header">
                    <h5><i class="fas fa-chart-pie me-2"></i>Corruption Types</h5>
                    <select id="corruptionType">
                        <option value="all">All Departments</option>
                        <option value="health">Health</option>
                        <option value="education">Education</option>
                        <option value="roads">Roads</option>
                    </select>
                </div>
                <div class="chart-container">
                    <canvas id="corruptionTypeChart"></canvas>
                </div>
            </div>
        </div>

        <!-- AI Insights Panel -->
        <div class="ai-panel">
            <h4><i class="fas fa-microchip me-2"></i>AI-Powered Insights</h4>
            <div class="row">
                <div class="col-md-4">
                    <div class="insight-item">
                        <div class="insight-icon">
                            <i class="fas fa-hand-holding-usd"></i>
                        </div>
                        <div class="insight-content">
                            <div class="insight-title">Procurement Fraud Pattern</div>
                            <div class="insight-desc">Single-source contracts 40% above market rate</div>
                        </div>
                        <div class="insight-confidence">92%</div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="insight-item">
                        <div class="insight-icon">
                            <i class="fas fa-users"></i>
                        </div>
                        <div class="insight-content">
                            <div class="insight-title">Ghost Workers Detected</div>
                            <div class="insight-desc">23 suspicious payroll entries in Ministry of Health</div>
                        </div>
                        <div class="insight-confidence">88%</div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="insight-item">
                        <div class="insight-icon">
                            <i class="fas fa-file-signature"></i>
                        </div>
                        <div class="insight-content">
                            <div class="insight-title">Bid Rigging Indicators</div>
                            <div class="insight-desc">Multiple bids from same IP address</div>
                        </div>
                        <div class="insight-confidence">95%</div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Section Title -->
        <div class="section-title">
            <i class="fas fa-exclamation-triangle"></i>
            <h3>High-Risk Transactions Requiring Immediate Review</h3>
            <span class="badge"><?php echo count($highRiskTransactions ?? []); ?> Cases</span>
        </div>

        <!-- High Risk Cards Grid -->
        <div class="risk-grid">
            <?php if (!empty($highRiskTransactions)): ?>
                <?php foreach ($highRiskTransactions as $transaction): ?>
                <div class="risk-card <?php echo $transaction['risk_level'] ?? 'high'; ?>">
                    <div class="risk-header">
                        <span class="risk-ref">#<?php echo htmlspecialchars($transaction['ref_no'] ?? 'N/A'); ?></span>
                        <span class="risk-badge <?php echo $transaction['risk_level'] ?? 'high'; ?>">
                            <?php echo strtoupper($transaction['risk_level'] ?? 'HIGH'); ?> RISK
                        </span>
                    </div>
                    <div class="risk-body">
                        <h5><?php echo htmlspecialchars($transaction['description'] ?? 'Procurement Irregularity'); ?></h5>
                        <div class="risk-details">
                            <span><i class="fas fa-building"></i> <?php echo htmlspecialchars($transaction['department'] ?? 'Ministry of Health'); ?></span>
                            <span><i class="fas fa-tag"></i> <?php echo htmlspecialchars($transaction['procurement_type'] ?? 'Single Source'); ?></span>
                            <span><i class="fas fa-calendar"></i> <?php echo date('d M Y', strtotime($transaction['transaction_date'] ?? 'now')); ?></span>
                        </div>
                        
                        <div class="risk-indicators">
                            <h6>AI Detected Indicators:</h6>
                            <div class="indicator-list">
                                <?php 
                                $indicators = $transaction['indicators'] ?? ['Single source procurement', 'Price 45% above market', 'Supplier registered 15 days ago'];
                                foreach ($indicators as $indicator): 
                                ?>
                                <span class="indicator-tag <?php echo strpos($indicator, 'Single source') !== false ? 'high-risk-indicator' : ''; ?>">
                                    <i class="fas fa-exclamation-circle me-1"></i><?php echo htmlspecialchars($indicator); ?>
                                </span>
                                <?php endforeach; ?>
                            </div>
                        </div>
                    </div>
                    <div class="risk-footer">
                        <div class="risk-amount">KES <?php echo number_format($transaction['amount'] ?? 0); ?></div>
                        <div>
                            <button class="btn-action btn-investigate" onclick="investigateCase(<?php echo $transaction['id'] ?? 0; ?>)">
                                <i class="fas fa-search me-2"></i>Investigate
                            </button>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
            <?php else: ?>
                <!-- Sample data for demonstration -->
                <div class="risk-card high">
                    <div class="risk-header">
                        <span class="risk-ref">#T001/2024</span>
                        <span class="risk-badge high">HIGH RISK</span>
                    </div>
                    <div class="risk-body">
                        <h5>Medical Equipment Supply - KEMSA Tender</h5>
                        <div class="risk-details">
                            <span><i class="fas fa-building"></i> Ministry of Health</span>
                            <span><i class="fas fa-tag"></i> Single Source</span>
                            <span><i class="fas fa-calendar"></i> 15 Jan 2024</span>
                        </div>
                        
                        <div class="risk-indicators">
                            <h6>AI Detected Indicators:</h6>
                            <div class="indicator-list">
                                <span class="indicator-tag high-risk-indicator"><i class="fas fa-exclamation-circle me-1"></i>Single source procurement</span>
                                <span class="indicator-tag"><i class="fas fa-exclamation-circle me-1"></i>Price 45% above market</span>
                                <span class="indicator-tag"><i class="fas fa-exclamation-circle me-1"></i>Supplier registered 15 days ago</span>
                            </div>
                        </div>
                    </div>
                    <div class="risk-footer">
                        <div class="risk-amount">KES 45,000,000</div>
                        <div>
                            <button class="btn-action btn-investigate" onclick="investigateCase(1)">
                                <i class="fas fa-search me-2"></i>Investigate
                            </button>
                        </div>
                    </div>
                </div>
                
                <div class="risk-card high">
                    <div class="risk-header">
                        <span class="risk-ref">#T002/2024</span>
                        <span class="risk-badge high">HIGH RISK</span>
                    </div>
                    <div class="risk-body">
                        <h5>IT Infrastructure Upgrade - KRA</h5>
                        <div class="risk-details">
                            <span><i class="fas fa-building"></i> KRA</span>
                            <span><i class="fas fa-tag"></i> Restricted</span>
                            <span><i class="fas fa-calendar"></i> 20 Jan 2024</span>
                        </div>
                        
                        <div class="risk-indicators">
                            <h6>AI Detected Indicators:</h6>
                            <div class="indicator-list">
                                <span class="indicator-tag high-risk-indicator"><i class="fas fa-exclamation-circle me-1"></i>Only 2 bidders</span>
                                <span class="indicator-tag"><i class="fas fa-exclamation-circle me-1"></i>Directors linked to officials</span>
                                <span class="indicator-tag"><i class="fas fa-exclamation-circle me-1"></i>Insufficient documentation</span>
                            </div>
                        </div>
                    </div>
                    <div class="risk-footer">
                        <div class="risk-amount">KES 128,000,000</div>
                        <div>
                            <button class="btn-action btn-investigate" onclick="investigateCase(2)">
                                <i class="fas fa-search me-2"></i>Investigate
                            </button>
                        </div>
                    </div>
                </div>
                
                <div class="risk-card medium">
                    <div class="risk-header">
                        <span class="risk-ref">#T003/2024</span>
                        <span class="risk-badge medium">MEDIUM RISK</span>
                    </div>
                    <div class="risk-body">
                        <h5>Road Construction - KENHA</h5>
                        <div class="risk-details">
                            <span><i class="fas fa-building"></i> Ministry of Roads</span>
                            <span><i class="fas fa-tag"></i> Open</span>
                            <span><i class="fas fa-calendar"></i> 25 Jan 2024</span>
                        </div>
                        
                        <div class="risk-indicators">
                            <h6>AI Detected Indicators:</h6>
                            <div class="indicator-list">
                                <span class="indicator-tag"><i class="fas fa-exclamation-circle me-1"></i>Cost overrun potential</span>
                                <span class="indicator-tag"><i class="fas fa-exclamation-circle me-1"></i>Previous contractor issues</span>
                            </div>
                        </div>
                    </div>
                    <div class="risk-footer">
                        <div class="risk-amount">KES 350,000,000</div>
                        <div>
                            <button class="btn-action btn-investigate" onclick="investigateCase(3)">
                                <i class="fas fa-search me-2"></i>Investigate
                            </button>
                        </div>
                    </div>
                </div>
            <?php endif; ?>
        </div>

        <!-- Department Risk Table -->
        <div class="section-title">
            <i class="fas fa-building"></i>
            <h3>Department Risk Assessment</h3>
            <span class="badge">Q1 2024</span>
        </div>

        <div class="dept-risk-table">
            <div class="dept-risk-header">
                <h5><i class="fas fa-chart-bar me-2"></i>Risk Scores by Department</h5>
                <button class="btn btn-sm" onclick="exportRiskReport()">
                    <i class="fas fa-download me-2"></i>Export Report
                </button>
            </div>
            <div class="dept-risk-body">
                <?php 
                $departments = $departmentRisks ?? [
                    ['name' => 'Ministry of Health', 'transactions' => 342, 'high_risk' => 12, 'risk_score' => 78],
                    ['name' => 'Ministry of Education', 'transactions' => 287, 'high_risk' => 8, 'risk_score' => 65],
                    ['name' => 'Ministry of Roads', 'transactions' => 156, 'high_risk' => 5, 'risk_score' => 52],
                    ['name' => 'KRA', 'transactions' => 423, 'high_risk' => 15, 'risk_score' => 82],
                    ['name' => 'Ministry of Interior', 'transactions' => 198, 'high_risk' => 4, 'risk_score' => 45],
                    ['name' => 'Ministry of Defense', 'transactions' => 234, 'high_risk' => 3, 'risk_score' => 38],
                ];
                ?>
                
                <?php foreach ($departments as $dept): ?>
                <div class="dept-risk-row">
                    <div class="dept-name">
                        <i class="fas fa-building me-2"></i>
                        <?php echo htmlspecialchars($dept['name']); ?>
                    </div>
                    <div class="dept-stats">
                        <?php echo $dept['transactions']; ?> transactions
                    </div>
                    <div class="dept-risk-bar">
                        <?php 
                        $riskClass = 'low';
                        if ($dept['risk_score'] >= 70) $riskClass = 'high';
                        elseif ($dept['risk_score'] >= 50) $riskClass = 'medium';
                        ?>
                        <div class="risk-bar-fill <?php echo $riskClass; ?>" style="width: <?php echo $dept['risk_score']; ?>%;"></div>
                    </div>
                    <div class="dept-risk-value">
                        <?php echo $dept['risk_score']; ?>%
                        <small>(<?php echo $dept['high_risk']; ?> high risk)</small>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
        </div>

        <!-- Quick Actions -->
        <div class="section-title">
            <i class="fas fa-bolt"></i>
            <h3>Quick Actions</h3>
        </div>

        <div class="quick-actions">
            <div class="quick-action-btn" onclick="location.href='index.php?controller=transaction&action=index'">
                <i class="fas fa-list"></i>
                <span>View All Transactions</span>
            </div>
            <div class="quick-action-btn" onclick="generateReport()">
                <i class="fas fa-file-pdf"></i>
                <span>Generate Audit Report</span>
            </div>
            <div class="quick-action-btn" onclick="runAIAnalysis()">
                <i class="fas fa-microchip"></i>
                <span>Run Full AI Scan</span>
            </div>
            <div class="quick-action-btn" onclick="location.href='index.php?controller=whistleblower&action=index'">
                <i class="fas fa-user-secret"></i>
                <span>View Whistleblower Reports</span>
            </div>
            <div class="quick-action-btn" onclick="exportData()">
                <i class="fas fa-download"></i>
                <span>Export Data</span>
            </div>
        </div>
    </div>

    <!-- Investigation Modal -->
    <div class="modal fade" id="investigationModal" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">
                        <i class="fas fa-search me-2"></i>
                        Case Investigation
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body" id="investigationDetails">
                    <!-- Will be filled by JavaScript -->
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" onclick="assignInvestigation()">
                        <i class="fas fa-user-plus me-2"></i>Assign Investigator
                    </button>
                    <button type="button" class="btn btn-danger" onclick="flagUrgent()">
                        <i class="fas fa-flag me-2"></i>Flag as Urgent
                    </button>
                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>
  <script>

document.addEventListener('DOMContentLoaded', function() {
    loadAIInsights();
    loadAIAlerts();
    loadAIPatterns();
    loadConfidenceMetrics();
    initializeCharts();});

// ============================================
// AI DATA FETCHING FUNCTIONS
// ============================================

/**
 * Load AI insights from server
 */
function loadAIInsights() {
    fetch('index.php?controller=ai&action=getInsights')
        .then(response => {
            if (!response.ok) {
                throw new Error('Network response was not ok');
            }
            return response.json();
        })
        .then(data => {
            if (data.success) {
                updateAIInsights(data.insights);
                updateAIPredictions(data.predictions);
            } else {
                console.warn('AI insights not available:', data.error);
                useFallbackAIInsights();
            }
        })
        .catch(error => {
            console.error('Error loading AI insights:', error);
            useFallbackAIInsights();
        });
}

/**
 * Load AI alerts from server
 */
function loadAIAlerts() {
    fetch('index.php?controller=ai&action=getInsights')
        .then(response => response.json())
        .then(data => {
            if (data.success && data.alerts && data.alerts.length > 0) {
                updateAIAlerts(data.alerts);
            } else {
                useFallbackAIAlerts();
            }
        })
        .catch(error => {
            console.error('Error loading AI alerts:', error);
            useFallbackAIAlerts();
        });
}

/**
 * Load AI patterns from server
 */
function loadAIPatterns() {
    fetch('index.php?controller=ai&action=getPatterns')
        .then(response => response.json())
        .then(data => {
            if (data.success && data.patterns) {
                updateAIPatterns(data.patterns);
                updateCorruptionTypeChart(data.patterns);
            } else {
                useFallbackPatterns();
            }
        })
        .catch(error => {
            console.error('Error loading AI patterns:', error);
            useFallbackPatterns();
        });
}

/**
 * Load confidence metrics from server
 */
function loadConfidenceMetrics() {
    fetch('index.php?controller=ai&action=getConfidenceMetrics')
        .then(response => response.json())
        .then(data => {
            if (data.success && data.metrics) {
                updateConfidenceMetrics(data.metrics);
            }
        })
        .catch(error => console.error('Error loading confidence metrics:', error));
}

// ============================================
// UI UPDATE FUNCTIONS
// ============================================

/**
 * Update AI insights in the UI
 */
function updateAIInsights(insights) {
    if (!insights) return;
    
    // Update AI Insight Panel
    const insightItems = document.querySelectorAll('.insight-item');
    if (insightItems.length > 0 && insights.top_patterns) {
        let i = 0;
        const patternEntries = Object.entries(insights.top_patterns);
        
        for (const [pattern, count] of patternEntries) {
            if (i < insightItems.length) {
                const item = insightItems[i];
                const title = item.querySelector('.insight-title');
                const desc = item.querySelector('.insight-desc');
                const confidenceEl = item.querySelector('.insight-confidence');
                
                if (title) title.textContent = formatPatternName(pattern);
                if (desc) desc.textContent = `${count} cases detected in last 30 days`;
                if (confidenceEl) confidenceEl.textContent = getPatternConfidence(pattern) + '%';
                
                // Add color coding based on pattern
                const icon = item.querySelector('.insight-icon');
                if (icon) {
                    const colors = {
                        'procurement_fraud': '#dc3545',
                        'ghost_workers': '#ffc107',
                        'bid_rigging': '#17a2b8',
                        'overpricing': '#28a745',
                        'conflict_of_interest': '#6c757d'
                    };
                    icon.style.backgroundColor = colors[pattern] || '#C5A572';
                }
            }
            i++;
        }
    }
    
    // Update average risk if available
    if (insights.average_risk) {
        const riskElements = document.querySelectorAll('.stat-value');
        if (riskElements.length > 1) {
            // This assumes the second stat card is high risk
            // You might want to be more specific with IDs/classes
            console.log('Average risk:', insights.average_risk);
        }
    }
}

/**
 * Update AI predictions in the UI
 */
function updateAIPredictions(predictions) {
    if (!predictions || !predictions.next_30_days) return;
    
    // You could create a mini chart or display predictions
    console.log('AI Predictions for next 30 days:', predictions.next_30_days);
    
    // Update trend direction indicator if exists
    const trendElement = document.querySelector('.trend-direction');
    if (trendElement) {
        const direction = predictions.trend_direction;
        const icon = direction === 'increasing' ? '↑' : '↓';
        const color = direction === 'increasing' ? '#dc3545' : '#28a745';
        trendElement.innerHTML = `${icon} ${direction.charAt(0).toUpperCase() + direction.slice(1)} (${predictions.confidence}% confidence)`;
        trendElement.style.color = color;
    }
}

/**
 * Update AI alerts banner
 */
function updateAIAlerts(alerts) {
    const alertBanner = document.querySelector('.ai-alert-banner');
    if (!alertBanner || !alerts || alerts.length === 0) return;
    
    const alert = alerts[0];
    const alertText = alertBanner.querySelector('.ai-alert-text p');
    const alertConfidence = alertBanner.querySelector('.ai-confidence');
    const alertIcon = alertBanner.querySelector('.ai-alert-icon i');
    
    if (alertText) alertText.textContent = alert.message;
    if (alertConfidence) {
        alertConfidence.innerHTML = `<i class="fas fa-microchip me-2"></i>AI Confidence: ${alert.confidence}%`;
    }
    if (alertIcon) {
        if (alert.risk_score > 0.8) {
            alertIcon.style.color = '#dc3545';
        } else if (alert.risk_score > 0.6) {
            alertIcon.style.color = '#ffc107';
        }
    }
}

/**
 * Update AI patterns display
 */
function updateAIPatterns(patterns) {
    if (!patterns || patterns.length === 0) return;
    
    // Update any pattern-specific displays
    console.log('AI Patterns detected:', patterns);
    
    // Could update a patterns list if exists
    const patternsContainer = document.getElementById('patterns-container');
    if (patternsContainer) {
        let html = '';
        patterns.forEach(pattern => {
            html += `
                <div class="pattern-item mb-2">
                    <span class="pattern-color" style="background-color: ${pattern.color || '#C5A572'}"></span>
                    <span class="pattern-name">${pattern.type}:</span>
                    <span class="pattern-count">${pattern.count} cases</span>
                    <span class="pattern-confidence">(${pattern.confidence}% confidence)</span>
                </div>
            `;
        });
        patternsContainer.innerHTML = html;
    }
}

/**
 * Update confidence metrics
 */
function updateConfidenceMetrics(metrics) {
    if (!metrics) return;
    
    // Update overall confidence
    const confidenceElements = document.querySelectorAll('.confidence-value');
    confidenceElements.forEach(el => {
        if (el.classList.contains('overall-confidence')) {
            el.textContent = metrics.overall + '%';
        }
    });
    
    // Update confidence distribution
    const distributionEl = document.getElementById('confidence-distribution');
    if (distributionEl) {
        distributionEl.innerHTML = `
            <div class="progress mb-2">
                <div class="progress-bar bg-success" style="width: ${metrics.high_confidence}%">High: ${metrics.high_confidence}%</div>
            </div>
            <div class="progress mb-2">
                <div class="progress-bar bg-warning" style="width: ${metrics.medium_confidence}%">Medium: ${metrics.medium_confidence}%</div>
            </div>
            <div class="progress mb-2">
                <div class="progress-bar bg-secondary" style="width: ${metrics.low_confidence}%">Low: ${metrics.low_confidence}%</div>
            </div>
        `;
    }
}

// ============================================
// FALLBACK FUNCTIONS (when server data unavailable)
// ============================================

function useFallbackAIInsights() {
    console.log('Using fallback AI insights data');
    const insightItems = document.querySelectorAll('.insight-item');
    
    const fallbackData = [
        { pattern: 'procurement_fraud', count: 45, confidence: 92 },
        { pattern: 'ghost_workers', count: 23, confidence: 88 },
        { pattern: 'bid_rigging', count: 18, confidence: 95 }
    ];
    
    insightItems.forEach((item, index) => {
        if (index < fallbackData.length) {
            const data = fallbackData[index];
            const title = item.querySelector('.insight-title');
            const desc = item.querySelector('.insight-desc');
            const confidence = item.querySelector('.insight-confidence');
            
            if (title) title.textContent = formatPatternName(data.pattern);
            if (desc) desc.textContent = `${data.count} cases detected in last 30 days`;
            if (confidence) confidence.textContent = data.confidence + '%';
        }
    });
}

function useFallbackAIAlerts() {
    const alertBanner = document.querySelector('.ai-alert-banner');
    if (!alertBanner) return;
    
    const alertText = alertBanner.querySelector('.ai-alert-text p');
    const alertConfidence = alertBanner.querySelector('.ai-confidence');
    
    if (alertText) {
        alertText.textContent = 'Suspicious pattern detected in Ministry of Health procurement';
    }
    if (alertConfidence) {
        alertConfidence.innerHTML = '<i class="fas fa-microchip me-2"></i>AI Confidence: 94%';
    }
}

function useFallbackPatterns() {
    console.log('Using fallback pattern data');
    // Update chart with fallback data
    updateCorruptionTypeChart([
        { type: 'Procurement Fraud', count: 45, color: '#dc3545' },
        { type: 'Ghost Workers', count: 23, color: '#ffc107' },
        { type: 'Bid Rigging', count: 18, color: '#17a2b8' },
        { type: 'Overpricing', count: 12, color: '#28a745' },
        { type: 'Conflict of Interest', count: 8, color: '#6c757d' }
    ]);
}

// ============================================
// HELPER FUNCTIONS
// ============================================

function formatPatternName(pattern) {
    return pattern.split('_').map(word => 
        word.charAt(0).toUpperCase() + word.slice(1)
    ).join(' ');
}

function getPatternConfidence(pattern) {
    const confidences = {
        'procurement_fraud': 92,
        'ghost_workers': 88,
        'bid_rigging': 95,
        'overpricing': 82,
        'conflict_of_interest': 78
    };
    return confidences[pattern] || 85;
}

// ============================================
// AI ANALYSIS FUNCTIONS
// ============================================

/**
 * Run AI analysis on a transaction
 */
function analyzeWithAI(transactionId) {
    // Show loading state
    const button = event.target;
    const originalText = button.innerHTML;
    button.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Analyzing...';
    button.disabled = true;
    
    fetch('index.php?controller=ai&action=analyzeTransaction', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
        },
        body: 'transaction_id=' + encodeURIComponent(transactionId)
    })
    .then(response => response.json())
    .then(data => {
        // Restore button
        button.innerHTML = originalText;
        button.disabled = false;
        
        if (data.success) {
            showAIAnalysis(data.analysis);
            // Update transaction risk badge if exists
            updateTransactionRiskBadge(transactionId, data.analysis);
        } else {
            alert('AI analysis failed: ' + (data.error || 'Unknown error'));
        }
    })
    .catch(error => {
        button.innerHTML = originalText;
        button.disabled = false;
        console.error('Error:', error);
        alert('Failed to connect to AI service');
    });
}

/**
 * Show AI analysis in modal
 */
function showAIAnalysis(analysis) {
    const modalElement = document.getElementById('investigationModal');
    if (!modalElement) {
        console.error('Investigation modal not found');
        return;
    }
    
    const modal = new bootstrap.Modal(modalElement);
    const modalBody = document.getElementById('investigationDetails');
    
    if (!modalBody) return;
    
    // Build patterns HTML
    let patternsHtml = '';
    if (analysis.patterns && analysis.patterns.length > 0) {
        analysis.patterns.forEach(pattern => {
            const color = pattern.color || getPatternColor(pattern.key || pattern.pattern);
            patternsHtml += `<li><span style="color: ${color}; margin-right: 8px;">●</span> ${pattern.pattern || pattern.type} (${pattern.confidence}% confidence)</li>`;
        });
    } else {
        patternsHtml = '<li class="text-muted">No specific patterns detected</li>';
    }
    
    // Build recommendations HTML
    let recommendationsHtml = '';
    if (analysis.recommendations && analysis.recommendations.length > 0) {
        analysis.recommendations.forEach(rec => {
            recommendationsHtml += `<li><i class="fas fa-check-circle me-2" style="color: #28a745;"></i>${rec}</li>`;
        });
    } else {
        recommendationsHtml = '<li class="text-muted">No specific recommendations</li>';
    }
    
    // Determine risk color
    let riskColor = '#ffc107'; // default yellow
    if (analysis.risk_level === 'CRITICAL' || analysis.risk_level === 'HIGH') {
        riskColor = '#dc3545';
    } else if (analysis.risk_level === 'LOW') {
        riskColor = '#28a745';
    }
    
    modalBody.innerHTML = `
        <div class="row">
            <div class="col-md-6">
                <div class="glass-card p-3 mb-3">
                    <h6 class="fw-bold mb-3"><i class="fas fa-chart-line me-2" style="color: var(--accent);"></i>AI Analysis Results</h6>
                    <p><strong>Risk Score:</strong> <span style="color: ${riskColor}; font-weight: bold;">${analysis.risk_score}% (${analysis.risk_level})</span></p>
                    <p><strong>Confidence:</strong> <span class="badge" style="background: var(--accent); color: var(--primary);">${analysis.confidence}%</span></p>
                    <p><strong>Analyzed:</strong> ${analysis.timestamp || new Date().toLocaleString()}</p>
                </div>
            </div>
            <div class="col-md-6">
                <div class="glass-card p-3 mb-3">
                    <h6 class="fw-bold mb-3"><i class="fas fa-exclamation-triangle me-2" style="color: var(--accent);"></i>Detected Patterns</h6>
                    <ul class="list-unstyled">
                        ${patternsHtml}
                    </ul>
                </div>
            </div>
        </div>
        <div class="row mt-2">
            <div class="col-12">
                <div class="glass-card p-3">
                    <h6 class="fw-bold mb-3"><i class="fas fa-lightbulb me-2" style="color: var(--accent);"></i>AI Recommendations</h6>
                    <ul class="list-unstyled">
                        ${recommendationsHtml}
                    </ul>
                </div>
            </div>
        </div>
    `;
    
    modal.show();
}

/**
 * Update transaction risk badge after AI analysis
 */
function updateTransactionRiskBadge(transactionId, analysis) {
    const riskBadge = document.querySelector(`.risk-badge[data-transaction-id="${transactionId}"]`);
    if (riskBadge) {
        riskBadge.className = `risk-badge ${analysis.risk_level.toLowerCase()}`;
        riskBadge.textContent = analysis.risk_level + ' RISK';
    }
    
    const riskScore = document.querySelector(`.risk-score[data-transaction-id="${transactionId}"]`);
    if (riskScore) {
        riskScore.textContent = analysis.risk_score + '%';
    }
}

/**
 * Get color for pattern type
 */
function getPatternColor(pattern) {
    const colors = {
        'procurement_fraud': '#dc3545',
        'ghost_workers': '#ffc107',
        'bid_rigging': '#17a2b8',
        'overpricing': '#28a745',
        'conflict_of_interest': '#6c757d',
        'Procurement Fraud': '#dc3545',
        'Ghost Workers': '#ffc107',
        'Bid Rigging': '#17a2b8',
        'Overpricing': '#28a745',
        'Conflict of Interest': '#6c757d'
    };
    return colors[pattern] || '#C5A572';
}

let riskChart, corruptionChart;

function initializeCharts() {
    // Risk Trend Chart
    const ctx1 = document.getElementById('riskTrendChart');
    if (ctx1) {
        riskChart = new Chart(ctx1.getContext('2d'), {
            type: 'line',
            data: {
                labels: ['Week 1', 'Week 2', 'Week 3', 'Week 4', 'Week 5', 'Week 6', 'Week 7', 'Week 8'],
                datasets: [
                    {
                        label: 'Ministry of Health',
                        data: [12, 19, 25, 22, 28, 32, 35, 38],
                        borderColor: '#dc3545',
                        backgroundColor: 'rgba(220, 53, 69, 0.1)',
                        tension: 0.4,
                        fill: true
                    },
                    {
                        label: 'Ministry of Education',
                        data: [8, 12, 15, 18, 20, 22, 25, 24],
                        borderColor: '#ffc107',
                        backgroundColor: 'rgba(255, 193, 7, 0.1)',
                        tension: 0.4,
                        fill: true
                    },
                    {
                        label: 'KRA',
                        data: [15, 18, 22, 25, 30, 35, 42, 45],
                        borderColor: '#17a2b8',
                        backgroundColor: 'rgba(23, 162, 184, 0.1)',
                        tension: 0.4,
                        fill: true
                    }
                ]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        labels: {
                            color: 'rgba(255, 255, 255, 0.7)'
                        }
                    }
                },
                scales: {
                    y: {
                        grid: {
                            color: 'rgba(255, 255, 255, 0.1)'
                        },
                        ticks: {
                            color: 'rgba(255, 255, 255, 0.7)'
                        },
                        title: {
                            display: true,
                            text: 'Number of High-Risk Cases',
                            color: 'rgba(255, 255, 255, 0.7)'
                        }
                    },
                    x: {
                        grid: {
                            color: 'rgba(255, 255, 255, 0.1)'
                        },
                        ticks: {
                            color: 'rgba(255, 255, 255, 0.7)'
                        }
                    }
                }
            }
        });
    }

    // Corruption Type Chart
    const ctx2 = document.getElementById('corruptionTypeChart');
    if (ctx2) {
        corruptionChart = new Chart(ctx2.getContext('2d'), {
            type: 'doughnut',
            data: {
                labels: ['Procurement Fraud', 'Ghost Workers', 'Bid Rigging', 'Overpricing', 'Conflict of Interest'],
                datasets: [{
                    data: [45, 23, 18, 12, 8],
                    backgroundColor: [
                        'rgba(220, 53, 69, 0.8)',
                        'rgba(255, 193, 7, 0.8)',
                        'rgba(23, 162, 184, 0.8)',
                        'rgba(40, 167, 69, 0.8)',
                        'rgba(108, 117, 125, 0.8)'
                    ],
                    borderWidth: 0
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        labels: {
                            color: 'rgba(255, 255, 255, 0.7)'
                        }
                    }
                },
                cutout: '60%'
            }
        });
    }
}

/**
 * Update corruption type chart with real data
 */
function updateCorruptionTypeChart(patterns) {
    if (!corruptionChart) return;
    
    const labels = [];
    const data = [];
    const colors = [];
    
    patterns.forEach(pattern => {
        labels.push(pattern.type || pattern.pattern);
        data.push(pattern.count || pattern.value || 0);
        colors.push(pattern.color || getPatternColor(pattern.type || pattern.pattern));
    });
    
    corruptionChart.data.labels = labels;
    corruptionChart.data.datasets[0].data = data;
    corruptionChart.data.datasets[0].backgroundColor = colors.map(c => c.includes('rgba') ? c : c.replace(')', ', 0.8)').replace('rgb', 'rgba'));
    corruptionChart.update();
}

/**
 * Update risk trend chart with new data
 */
function updateRiskTrendChart(departmentData) {
    if (!riskChart) return;
    
    // Update with real data from server
    if (departmentData) {
        riskChart.data.datasets = departmentData;
        riskChart.update();
    }
}

// ============================================
// DASHBOARD ACTION FUNCTIONS
// ============================================

/**
 * Investigate a case
 */
function investigateCase(caseId) {
    // First try to get AI analysis
    analyzeWithAI(caseId);
}

/**
 * Generate audit report
 */
function generateReport() {
    const reportTypes = ['Monthly Audit Report', 'Risk Assessment Report', 'Transaction Analysis', 'Corruption Pattern Report'];
    const type = prompt('Select report type:\n1. Monthly Audit Report\n2. Risk Assessment Report\n3. Transaction Analysis\n4. Corruption Pattern Report', '1');
    
    if (type) {
        const reportType = reportTypes[parseInt(type) - 1] || 'Monthly Audit Report';
        alert(`Generating ${reportType}... This may take a few moments.`);
        
        // In production, this would trigger a download
        window.location.href = `index.php?controller=report&action=generate&type=${encodeURIComponent(reportType)}`;
    }
}

/**
 * Run batch AI analysis
 */
function runAIAnalysis() {
    if (!confirm('Run full AI analysis on all pending transactions? This may take several minutes.')) {
        return;
    }
    
    const button = event.target;
    const originalText = button.innerHTML;
    button.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Analyzing...';
    button.disabled = true;
    
    fetch('index.php?controller=ai&action=runBatchAnalysis', {
        method: 'POST'
    })
    .then(response => response.json())
    .then(data => {
        button.innerHTML = originalText;
        button.disabled = false;
        
        if (data.success) {
            alert(`AI analysis complete!\nProcessed: ${data.analyzed} transactions`);
            location.reload(); // Refresh to show new data
        } else {
            alert('Batch analysis failed: ' + (data.error || 'Unknown error'));
        }
    })
    .catch(error => {
        button.innerHTML = originalText;
        button.disabled = false;
        alert('Failed to connect to AI service');
    });
}

/**
 * Export data
 */
function exportData() {
    const format = prompt('Export format:\n1. PDF\n2. Excel\n3. CSV', '1');
    const formats = ['pdf', 'excel', 'csv'];
    const selectedFormat = formats[parseInt(format) - 1] || 'pdf';
    
    window.location.href = `index.php?controller=export&action=data&format=${selectedFormat}`;
}

/**
 * Export risk report
 */
function exportRiskReport() {
    window.location.href = 'index.php?controller=export&action=riskReport';
}

/**
 * Assign investigation
 */
function assignInvestigation() {
    const investigators = ['Senior Auditor Jane', 'Investigator John', 'Forensic Team A', 'Anti-Corruption Unit'];
    
    let options = '';
    investigators.forEach((inv, index) => {
        options += `${index + 1}. ${inv}\n`;
    });
    
    const choice = prompt(`Assign to:\n${options}`, '1');
    if (choice) {
        const investigator = investigators[parseInt(choice) - 1] || investigators[0];
        alert(`Case assigned to ${investigator}. They have been notified.`);
    }
}

/**
 * Flag as urgent
 */
function flagUrgent() {
    if (confirm('Flag this case as URGENT? This will notify all senior investigators immediately.')) {
        alert('Case flagged as urgent. Investigators notified.');
        
        // In production, this would make an API call
        const modal = bootstrap.Modal.getInstance(document.getElementById('investigationModal'));
        if (modal) modal.hide();
    }
}

// ============================================
// EVENT LISTENERS
// ============================================

// Handle chart time range changes
document.getElementById('riskTimeRange')?.addEventListener('change', function(e) {
    const days = e.target.value;
    console.log(`Loading risk data for last ${days} days`);
    // In production, fetch new data based on selected range
});

// Handle corruption type filter changes
document.getElementById('corruptionType')?.addEventListener('change', function(e) {
    const dept = e.target.value;
    console.log(`Filtering corruption types for: ${dept}`);
    // In production, update chart based on selected department
});

// Auto-refresh data every 5 minutes (only on dashboard)
if (window.location.href.includes('dashboard')) {
    setTimeout(() => {
        console.log('Auto-refreshing dashboard data...');
        location.reload();
    }, 600000); // 5 minutes
}

// Debug info
console.log('AI Integration Scripts Loaded Successfully');
</script>
</body>
</html>