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
        <?php include 'styles/dashboard-theme.css'; ?>
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