<?php
require_once __DIR__ . '/layout/header.php';
require_once __DIR__ . '/../layout/loading.php';

// Initialize default data if not set
$stats = $stats ?? [
    'total_transactions' => 1248,
    'high_risk' => 47,
    'ai_flagged' => 23,
    'recovered_funds' => 45200000
];

$aiAlerts = $aiAlerts ?? [];
$highRiskTransactions = $highRiskTransactions ?? [];
$departmentRisks = $departmentRisks ?? [];

$userName = $_SESSION['user_name'] ?? 'Auditor General';
$currentDate = date('l, F j, Y');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Auditor General Dashboard - Anti-Corruption Monitor</title>
    
    <!-- Stylesheets -->
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

/* Welcome Banner */
.welcome-banner {
    background: var(--glass-bg);
    backdrop-filter: blur(10px);
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

.welcome-banner .date-badge {
    background: var(--transparency-primary);
    border: 1px solid var(--glass-border);
    padding: 8px 15px;
    border-radius: 50px;
    display: inline-block;
    margin-top: 15px;
}

/* Stats Cards */
.stats-row {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
    gap: 20px;
    margin-bottom: 30px;
}

.stat-card {
    background: var(--glass-bg);
    backdrop-filter: blur(10px);
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

/* AI Alert Banner */
.ai-alert-banner {
    background: rgba(220, 53, 69, 0.2);
    backdrop-filter: blur(10px);
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

.ai-confidence {
    background: rgba(255,255,255,0.1);
    backdrop-filter: blur(5px);
    border: 1px solid rgba(255,255,255,0.2);
    padding: 8px 15px;
    border-radius: 50px;
    font-weight: 600;
}

/* Chart Cards */
.charts-row {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(400px, 1fr));
    gap: 20px;
    margin-bottom: 30px;
}

.chart-card {
    background: var(--glass-bg);
    backdrop-filter: blur(10px);
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

.chart-header select {
    background: var(--transparency-primary);
    border: 1px solid var(--glass-border);
    border-radius: 8px;
    padding: 5px 10px;
    color: var(--text-primary);
    cursor: pointer;
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

/* Risk Cards */
.risk-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(350px, 1fr));
    gap: 20px;
    margin-bottom: 30px;
}

.risk-card {
    background: var(--glass-bg);
    backdrop-filter: blur(10px);
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

.risk-details {
    display: flex;
    flex-wrap: wrap;
    gap: 15px;
    margin: 15px 0;
    color: var(--text-secondary);
    font-size: 0.9rem;
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

.btn-investigate {
    background: var(--accent);
    color: var(--primary);
}

.btn-investigate:hover {
    background: var(--accent-dark);
    box-shadow: 0 5px 15px rgba(197, 165, 114, 0.3);
}

/* Department Risk Table */
.dept-risk-table {
    background: var(--glass-bg);
    backdrop-filter: blur(10px);
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

/* AI Insights Panel */
.ai-panel {
    background: linear-gradient(135deg, rgba(102, 126, 234, 0.2), rgba(118, 75, 162, 0.2));
    backdrop-filter: blur(10px);
    border: 1px solid var(--glass-border);
    color: var(--text-primary);
    border-radius: 20px;
    padding: 25px;
    margin-bottom: 30px;
    box-shadow: var(--glass-shadow);
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

.insight-confidence {
    font-size: 0.8rem;
    background: var(--transparency-accent);
    border: 1px solid var(--accent);
    padding: 3px 10px;
    border-radius: 50px;
    color: var(--accent);
}

/* Quick Actions */
.quick-actions {
    display: flex;
    gap: 10px;
    flex-wrap: wrap;
    margin-bottom: 30px;
}

.quick-action-btn {
    background: var(--glass-bg);
    backdrop-filter: blur(10px);
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

/* Modal */
.modal-content {
    background: rgba(10, 35, 81, 0.4);
    backdrop-filter: blur(20px);
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

/* Animation */
@keyframes glow {
    0% { text-shadow: 0 0 5px var(--accent); }
    50% { text-shadow: 0 0 20px var(--accent); }
    100% { text-shadow: 0 0 5px var(--accent); }
}

.transparency-icon {
    animation: glow 2s infinite;
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
    
    .stats-row,
    .charts-row,
    .risk-grid {
        grid-template-columns: 1fr;
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
    </style>
</head>
<body>
    <!-- Navbar is already included at the top -->
    
    <!-- Main Content -->
    <div class="main-content">
        <!-- Welcome Banner -->
        <?php renderWelcomeBanner($userName, $stats, $currentDate); ?>

        <!-- AI Alert Banner -->
        <?php renderAIAlertBanner($aiAlerts); ?>

        <!-- Statistics Cards -->
        <?php renderStatisticsCards($stats); ?>

        <!-- Charts Row -->
        <?php renderCharts(); ?>

        <!-- AI Insights Panel -->
        <?php renderAIInsightsPanel(); ?>

        <!-- High Risk Transactions Section -->
        <?php renderHighRiskTransactions($highRiskTransactions); ?>

        <!-- Department Risk Assessment -->
        <?php renderDepartmentRiskAssessment($departmentRisks); ?>

        <!-- Quick Actions -->
        <?php renderQuickActions(); ?>
    </div>

    <!-- Investigation Modal -->
    <?php renderInvestigationModal(); ?>

    <!-- Scripts -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>
    
    <!-- Dashboard JavaScript -->
    <script>
        <?php include 'scripts/dashboard-functions.js'; ?>
    </script>
</body>
</html>

<?php
// ============================================
// RENDERING FUNCTIONS
// ============================================

function renderWelcomeBanner($userName, $stats, $currentDate) {
    ?>
    <div class="welcome-banner">
        <div class="row align-items-center">
            <div class="col-md-8">
                <h2>Welcome back, <?php echo htmlspecialchars($userName); ?>!</h2>
                <p>The AI system has analyzed <strong><?php echo number_format($stats['total_transactions']); ?></strong> transactions in the last 24 hours.</p>
                <p><i class="fas fa-exclamation-triangle me-2" style="color: var(--accent);"></i> 
                   <strong><?php echo $stats['high_risk']; ?></strong> high-risk cases require your immediate attention.</p>
                <div class="date-badge">
                    <i class="fas fa-calendar me-2" style="color: var(--accent);"></i><?php echo $currentDate; ?>
                </div>
            </div>
            <div class="col-md-4 text-end">
                <i class="fas fa-robot transparency-icon" style="font-size: 80px; opacity: 0.5;"></i>
            </div>
        </div>
    </div>
    <?php
}

function renderAIAlertBanner($aiAlerts) {
    if (empty($aiAlerts)) return;
    $alert = $aiAlerts[0] ?? ['message' => 'Suspicious pattern detected', 'confidence' => 94];
    ?>
    <div class="ai-alert-banner">
        <div class="ai-alert-content">
            <div class="ai-alert-icon">
                <i class="fas fa-exclamation-triangle"></i>
            </div>
            <div class="ai-alert-text">
                <h4>🚨 HIGH PRIORITY AI ALERT</h4>
                <p><?php echo htmlspecialchars($alert['message']); ?></p>
            </div>
        </div>
        <div class="ai-confidence">
            <i class="fas fa-microchip me-2"></i>AI Confidence: <?php echo $alert['confidence']; ?>%
        </div>
    </div>
    <?php
}

function renderStatisticsCards($stats) {
    $cards = [
        ['class' => 'total', 'icon' => 'fa-exchange-alt', 'label' => 'Total Transactions', 
         'value' => number_format($stats['total_transactions']), 'trend' => '+12% vs last month', 'trendClass' => 'trend-up'],
        ['class' => 'high-risk', 'icon' => 'fa-exclamation-triangle', 'label' => 'High Risk Cases', 
         'value' => number_format($stats['high_risk']), 'trend' => '+5% from last week', 'trendClass' => 'trend-up'],
        ['class' => 'flagged', 'icon' => 'fa-flag', 'label' => 'AI Flagged', 
         'value' => number_format($stats['ai_flagged']), 'trend' => 'Pending review', 'trendClass' => ''],
        ['class' => 'recovered', 'icon' => 'fa-coins', 'label' => 'Recovered Funds', 
         'value' => 'KES ' . number_format($stats['recovered_funds']), 'trend' => '-8% vs target', 'trendClass' => 'trend-down']
    ];
    
    echo '<div class="stats-row">';
    foreach ($cards as $card) {
        ?>
        <div class="stat-card <?php echo $card['class']; ?>">
            <div class="stat-icon"><i class="fas <?php echo $card['icon']; ?>"></i></div>
            <div class="stat-label"><?php echo $card['label']; ?></div>
            <div class="stat-value"><?php echo $card['value']; ?></div>
            <div class="stat-trend">
                <span class="<?php echo $card['trendClass']; ?>"><i class="fas fa-arrow-<?php echo $card['trendClass'] === 'trend-up' ? 'up' : 'down'; ?>"></i> <?php echo $card['trend']; ?></span>
            </div>
        </div>
        <?php
    }
    echo '</div>';
}

function renderCharts() {
    ?>
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
    <?php
}

function renderAIInsightsPanel() {
    $insights = [
        ['icon' => 'fa-hand-holding-usd', 'title' => 'Procurement Fraud Pattern', 
         'desc' => 'Single-source contracts 40% above market rate', 'confidence' => 92],
        ['icon' => 'fa-users', 'title' => 'Ghost Workers Detected', 
         'desc' => '23 suspicious payroll entries in Ministry of Health', 'confidence' => 88],
        ['icon' => 'fa-file-signature', 'title' => 'Bid Rigging Indicators', 
         'desc' => 'Multiple bids from same IP address', 'confidence' => 95]
    ];
    ?>
    <div class="ai-panel">
        <h4><i class="fas fa-microchip me-2"></i>AI-Powered Insights</h4>
        <div class="row">
            <?php foreach ($insights as $insight): ?>
            <div class="col-md-4">
                <div class="insight-item">
                    <div class="insight-icon"><i class="fas <?php echo $insight['icon']; ?>"></i></div>
                    <div class="insight-content">
                        <div class="insight-title"><?php echo $insight['title']; ?></div>
                        <div class="insight-desc"><?php echo $insight['desc']; ?></div>
                    </div>
                    <div class="insight-confidence"><?php echo $insight['confidence']; ?>%</div>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
    <?php
}

function renderHighRiskTransactions($transactions) {
    $sampleTransactions = [
        ['ref' => '#T001/2024', 'description' => 'Medical Equipment Supply - KEMSA Tender', 
         'dept' => 'Ministry of Health', 'type' => 'Single Source', 'date' => '15 Jan 2024', 
         'amount' => 45000000, 'indicators' => ['Single source procurement', 'Price 45% above market', 'Supplier registered 15 days ago']],
        ['ref' => '#T002/2024', 'description' => 'IT Infrastructure Upgrade - KRA', 
         'dept' => 'KRA', 'type' => 'Restricted', 'date' => '20 Jan 2024', 
         'amount' => 128000000, 'indicators' => ['Only 2 bidders', 'Directors linked to officials', 'Insufficient documentation']],
        ['ref' => '#T003/2024', 'description' => 'Road Construction - KENHA', 
         'dept' => 'Ministry of Roads', 'type' => 'Open', 'date' => '25 Jan 2024', 
         'amount' => 350000000, 'indicators' => ['Cost overrun potential', 'Previous contractor issues']]
    ];
    
    $displayTransactions = !empty($transactions) ? $transactions : $sampleTransactions;
    ?>
    <div class="section-title">
        <i class="fas fa-exclamation-triangle"></i>
        <h3>High-Risk Transactions Requiring Immediate Review</h3>
        <span class="badge"><?php echo count($displayTransactions); ?> Cases</span>
    </div>

    <div class="risk-grid">
        <?php foreach ($displayTransactions as $index => $transaction): ?>
        <?php $riskLevel = $transaction['risk_level'] ?? ($index === 2 ? 'medium' : 'high'); ?>
        <div class="risk-card <?php echo $riskLevel; ?>" data-id="<?php echo $index + 1; ?>">
            <div class="risk-header">
                <span class="risk-ref"><?php echo $transaction['ref'] ?? $transaction['ref_no'] ?? '#' . ($index + 1); ?></span>
                <span class="risk-badge <?php echo $riskLevel; ?>"><?php echo strtoupper($riskLevel); ?> RISK</span>
            </div>
            <div class="risk-body">
                <h5><?php echo htmlspecialchars($transaction['description'] ?? 'Procurement Irregularity'); ?></h5>
                <div class="risk-details">
                    <span><i class="fas fa-building"></i> <?php echo htmlspecialchars($transaction['dept'] ?? $transaction['department'] ?? 'Ministry of Health'); ?></span>
                    <span><i class="fas fa-tag"></i> <?php echo htmlspecialchars($transaction['type'] ?? $transaction['procurement_type'] ?? 'Single Source'); ?></span>
                    <span><i class="fas fa-calendar"></i> <?php echo htmlspecialchars($transaction['date'] ?? $transaction['transaction_date'] ?? '15 Jan 2024'); ?></span>
                </div>
                
                <div class="risk-indicators">
                    <h6>AI Detected Indicators:</h6>
                    <div class="indicator-list">
                        <?php foreach (($transaction['indicators'] ?? []) as $indicator): ?>
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
                    <button class="btn-action btn-investigate" onclick="investigateCase(<?php echo $index + 1; ?>)">
                        <i class="fas fa-search me-2"></i>Investigate
                    </button>
                </div>
            </div>
        </div>
        <?php endforeach; ?>
    </div>
    <?php
}

function renderDepartmentRiskAssessment($departments) {
    $sampleDepartments = [
        ['name' => 'Ministry of Health', 'transactions' => 342, 'high_risk' => 12, 'risk_score' => 78],
        ['name' => 'Ministry of Education', 'transactions' => 287, 'high_risk' => 8, 'risk_score' => 65],
        ['name' => 'Ministry of Roads', 'transactions' => 156, 'high_risk' => 5, 'risk_score' => 52],
        ['name' => 'KRA', 'transactions' => 423, 'high_risk' => 15, 'risk_score' => 82],
        ['name' => 'Ministry of Interior', 'transactions' => 198, 'high_risk' => 4, 'risk_score' => 45],
        ['name' => 'Ministry of Defense', 'transactions' => 234, 'high_risk' => 3, 'risk_score' => 38]
    ];
    
    $displayDepartments = !empty($departments) ? $departments : $sampleDepartments;
    ?>
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
            <?php foreach ($displayDepartments as $dept): ?>
            <?php 
            $riskClass = 'low';
            if ($dept['risk_score'] >= 70) $riskClass = 'high';
            elseif ($dept['risk_score'] >= 50) $riskClass = 'medium';
            ?>
            <div class="dept-risk-row">
                <div class="dept-name">
                    <i class="fas fa-building me-2"></i><?php echo htmlspecialchars($dept['name']); ?>
                </div>
                <div class="dept-stats"><?php echo $dept['transactions']; ?> transactions</div>
                <div class="dept-risk-bar">
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
    <?php
}

function renderQuickActions() {
    $actions = [
        ['icon' => 'fa-list', 'text' => 'View All Transactions', 'action' => "location.href='index.php?controller=transaction&action=index'"],
        ['icon' => 'fa-file-pdf', 'text' => 'Generate Audit Report', 'action' => 'generateReport()'],
        ['icon' => 'fa-microchip', 'text' => 'Run Full AI Scan', 'action' => 'runAIAnalysis()'],
        ['icon' => 'fa-user-secret', 'text' => 'View Whistleblower Reports', 'action' => "location.href='index.php?controller=whistleblower&action=index'"],
        ['icon' => 'fa-download', 'text' => 'Export Data', 'action' => 'exportData()']
    ];
    ?>
    <div class="section-title">
        <i class="fas fa-bolt"></i>
        <h3>Quick Actions</h3>
    </div>

    <div class="quick-actions">
        <?php foreach ($actions as $action): ?>
        <div class="quick-action-btn" onclick="<?php echo $action['action']; ?>">
            <i class="fas <?php echo $action['icon']; ?>"></i>
            <span><?php echo $action['text']; ?></span>
        </div>
        <?php endforeach; ?>
    </div>
    <?php
}

function renderInvestigationModal() {
    ?>
    <div class="modal fade" id="investigationModal" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">
                        <i class="fas fa-search me-2"></i>Case Investigation
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body" id="investigationDetails"></div>
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
    <?php
}
?>