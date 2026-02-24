<?php
// views/auditor/dashboard.php
// session_start();
// require_once '../../config/database.php';
require_once '../../includes/AIAnalyzer.php';
require_once '../../includes/BlockchainVerifier.php';

// Get AI-powered insights
$aiAnalyzer = new AIAnalyzer();
$highRiskTransactions = $aiAnalyzer->getHighRiskTransactions();
$anomalyScore = $aiAnalyzer->getOverallAnomalyScore();
$predictiveAlerts = $aiAnalyzer->getPredictiveAlerts();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>NuruAI - Auditor General Anti-Corruption System</title>
    
    <!-- Security Headers -->
    <meta http-equiv="Content-Security-Policy" content="default-src 'self'; script-src 'self' https://cdn.jsdelivr.net https://cdnjs.cloudflare.com 'unsafe-inline' 'unsafe-eval'; style-src 'self' https://fonts.googleapis.com https://cdn.jsdelivr.net 'unsafe-inline';">
    
    <!-- Styles -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css">
    
    <style>
        :root {
            --primary: #0A2351;
            --secondary: #C5A572;
            --accent: #D32F2F;
            --success: #2E7D32;
            --warning: #F57C00;
            --info: #1976D2;
            --bg-dark: #0F172A;
            --bg-card: rgba(255,255,255,0.05);
            --text-primary: #E2E8F0;
            --text-secondary: #94A3B8;
            --border-glow: rgba(197, 165, 114, 0.3);
        }
        
        body {
            background: linear-gradient(135deg, #0F172A 0%, #1E293B 100%);
            color: var(--text-primary);
            font-family: 'Inter', sans-serif;
            min-height: 100vh;
        }
        
        .navbar {
            background: rgba(10, 35, 81, 0.95);
            backdrop-filter: blur(10px);
            border-bottom: 1px solid var(--border-glow);
        }
        
        .navbar-brand {
            color: var(--secondary) !important;
            font-weight: 700;
            font-size: 1.5rem;
        }
        
        .stat-card {
            background: var(--bg-card);
            backdrop-filter: blur(10px);
            border: 1px solid var(--border-glow);
            border-radius: 15px;
            padding: 1.5rem;
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
        }
        
        .stat-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(197, 165, 114, 0.1), transparent);
            transition: left 0.5s;
        }
        
        .stat-card:hover::before {
            left: 100%;
        }
        
        .stat-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 30px rgba(197, 165, 114, 0.2);
            border-color: var(--secondary);
        }
        
        .ai-risk-meter {
            background: linear-gradient(90deg, #2E7D32, #F57C00, #D32F2F);
            height: 10px;
            border-radius: 5px;
            position: relative;
        }
        
        .ai-risk-pointer {
            position: absolute;
            width: 20px;
            height: 20px;
            background: white;
            border: 3px solid var(--secondary);
            border-radius: 50%;
            top: -5px;
            transform: translateX(-50%);
        }
        
        .transaction-row {
            background: rgba(255,255,255,0.02);
            border: 1px solid rgba(197, 165, 114, 0.1);
            border-radius: 10px;
            padding: 1rem;
            margin-bottom: 0.5rem;
            transition: all 0.3s;
        }
        
        .transaction-row:hover {
            background: rgba(197, 165, 114, 0.1);
            border-color: var(--secondary);
        }
        
        .high-risk {
            border-left: 5px solid #D32F2F;
        }
        
        .medium-risk {
            border-left: 5px solid #F57C00;
        }
        
        .low-risk {
            border-left: 5px solid #2E7D32;
        }
        
        .ai-badge {
            background: rgba(197, 165, 114, 0.2);
            color: var(--secondary);
            padding: 0.25rem 0.75rem;
            border-radius: 20px;
            font-size: 0.75rem;
            font-weight: 600;
            border: 1px solid var(--secondary);
        }
        
        .confidence-high {
            color: #2E7D32;
            font-weight: 600;
        }
        
        .confidence-medium {
            color: #F57C00;
            font-weight: 600;
        }
        
        .confidence-low {
            color: #D32F2F;
            font-weight: 600;
        }
        
        .blockchain-verified {
            color: #2E7D32;
            font-size: 0.8rem;
        }
        
        .blockchain-pending {
            color: #F57C00;
            font-size: 0.8rem;
        }
        
        .predictive-alert {
            background: linear-gradient(135deg, #D32F2F, #B71C1C);
            color: white;
            padding: 1rem;
            border-radius: 10px;
            margin-bottom: 1rem;
            animation: pulse 2s infinite;
        }
        
        @keyframes pulse {
            0% { opacity: 1; }
            50% { opacity: 0.9; box-shadow: 0 0 20px rgba(211, 47, 47, 0.5); }
            100% { opacity: 1; }
        }
        
        .chart-container {
            background: var(--bg-card);
            border-radius: 15px;
            padding: 1.5rem;
            border: 1px solid var(--border-glow);
        }
        
        .btn-primary-custom {
            background: linear-gradient(135deg, var(--secondary), #9E7B4A);
            border: none;
            color: var(--primary);
            font-weight: 600;
            padding: 0.75rem 1.5rem;
            border-radius: 10px;
            transition: all 0.3s;
        }
        
        .btn-primary-custom:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 20px rgba(197, 165, 114, 0.4);
        }
        
        .whistleblower-section {
            background: linear-gradient(135deg, #1A237E, #0D47A1);
            border-radius: 15px;
            padding: 2rem;
            position: relative;
            overflow: hidden;
        }
        
        .whistleblower-section::before {
            content: '🔒';
            font-size: 10rem;
            position: absolute;
            right: -20px;
            bottom: -40px;
            opacity: 0.1;
            transform: rotate(-15deg);
        }
    </style>
</head>
<body>
    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg navbar-dark sticky-top">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">
                <i class="fas fa-shield-alt me-2"></i>
                NuruAI Integrity Platform
            </a>
            <div class="navbar-nav ms-auto">
                <div class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
                        <i class="fas fa-user-circle me-2"></i>
                        Auditor General
                    </a>
                    <ul class="dropdown-menu dropdown-menu-dark">
                        <li><a class="dropdown-item" href="#"><i class="fas fa-id-card me-2"></i>Profile</a></li>
                        <li><a class="dropdown-item" href="#"><i class="fas fa-cog me-2"></i>Settings</a></li>
                        <li><hr class="dropdown-divider"></li>
                        <li><a class="dropdown-item text-danger" href="#"><i class="fas fa-sign-out-alt me-2"></i>Logout</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </nav>

    <div class="container-fluid py-4">
        <div class="row">
            <!-- Sidebar -->
            <div class="col-md-2 col-lg-2 d-md-block bg-dark sidebar">
                <div class="position-sticky pt-3">
                    <ul class="nav flex-column">
                        <li class="nav-item mb-2">
                            <a class="nav-link active text-white" href="#" data-module="dashboard">
                                <i class="fas fa-tachometer-alt me-2" style="color: var(--secondary);"></i>
                                AI Dashboard
                            </a>
                        </li>
                        <li class="nav-item mb-2">
                            <a class="nav-link text-white-50" href="#" data-module="transactions">
                                <i class="fas fa-exchange-alt me-2" style="color: var(--secondary);"></i>
                                AI Transactions
                            </a>
                        </li>
                        <li class="nav-item mb-2">
                            <a class="nav-link text-white-50" href="#" data-module="risk-analysis">
                                <i class="fas fa-chart-line me-2" style="color: var(--secondary);"></i>
                                Risk Analysis
                            </a>
                        </li>
                        <li class="nav-item mb-2">
                            <a class="nav-link text-white-50" href="#" data-module="predictive">
                                <i class="fas fa-robot me-2" style="color: var(--secondary);"></i>
                                Predictive AI
                            </a>
                        </li>
                        <li class="nav-item mb-2">
                            <a class="nav-link text-white-50" href="#" data-module="blockchain">
                                <i class="fas fa-link me-2" style="color: var(--secondary);"></i>
                                Blockchain Audit
                            </a>
                        </li>
                        <li class="nav-item mb-2">
                            <a class="nav-link text-white-50" href="#" data-module="whistleblower">
                                <i class="fas fa-user-secret me-2" style="color: var(--secondary);"></i>
                                Whistleblower
                            </a>
                        </li>
                    </ul>
                </div>
            </div>

            <!-- Main Content -->
            <main class="col-md-10 ms-sm-auto col-lg-10 px-md-4">
                <!-- AI Predictive Alerts -->
                <div class="predictive-alert">
                    <div class="d-flex align-items-center">
                        <i class="fas fa-exclamation-triangle fa-2x me-3"></i>
                        <div>
                            <h5 class="mb-1">AI PREDICTIVE ALERT: Potential Procurement Fraud Detected</h5>
                            <p class="mb-0 small">3 high-risk transactions identified in Ministry of Health with 94% confidence. Immediate review recommended.</p>
                        </div>
                        <div class="ms-auto">
                            <span class="ai-badge">AI Confidence: 94%</span>
                        </div>
                    </div>
                </div>

                <!-- Statistics Cards -->
                <div class="row g-4 mb-4">
                    <div class="col-md-3">
                        <div class="stat-card">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <p class="text-white-50 mb-1">Total Transactions</p>
                                    <h3 class="text-white mb-0">45,892</h3>
                                    <small class="text-white-50">Last 30 days</small>
                                </div>
                                <div class="ai-badge">
                                    <i class="fas fa-microchip me-1"></i>AI Analyzed
                                </div>
                            </div>
                            <div class="mt-2">
                                <span class="text-success"><i class="fas fa-arrow-up"></i> 12.5%</span>
                                <span class="text-white-50 ms-2">vs last month</span>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-md-3">
                        <div class="stat-card">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <p class="text-white-50 mb-1">High Risk</p>
                                    <h3 class="text-danger mb-0">156</h3>
                                    <small class="text-white-50">Needs immediate action</small>
                                </div>
                                <i class="fas fa-exclamation-triangle fa-2x" style="color: #D32F2F;"></i>
                            </div>
                            <div class="ai-risk-meter mt-3">
                                <div class="ai-risk-pointer" style="left: 25%;"></div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-md-3">
                        <div class="stat-card">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <p class="text-white-50 mb-1">Medium Risk</p>
                                    <h3 class="text-warning mb-0">423</h3>
                                    <small class="text-white-50">Under investigation</small>
                                </div>
                                <i class="fas fa-clock fa-2x" style="color: #F57C00;"></i>
                            </div>
                            <div class="ai-risk-meter mt-3">
                                <div class="ai-risk-pointer" style="left: 45%;"></div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-md-3">
                        <div class="stat-card">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <p class="text-white-50 mb-1">Recovered Funds</p>
                                    <h3 class="text-success mb-0">KES 45.2M</h3>
                                    <small class="text-white-50">This quarter</small>
                                </div>
                                <i class="fas fa-coins fa-2x" style="color: #2E7D32;"></i>
                            </div>
                            <div class="mt-2">
                                <span class="text-success"><i class="fas fa-check-circle"></i> +28% recovery rate</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- AI Analysis Dashboard -->
                <div class="row mb-4">
                    <div class="col-md-8">
                        <div class="chart-container">
                            <div class="d-flex justify-content-between align-items-center mb-4">
                                <h5 class="mb-0">AI Risk Analysis Over Time</h5>
                                <div>
                                    <span class="ai-badge me-2">Pattern Recognition</span>
                                    <span class="ai-badge">Anomaly Detection</span>
                                </div>
                            </div>
                            <canvas id="riskChart" height="300"></canvas>
                        </div>
                    </div>
                    
                    <div class="col-md-4">
                        <div class="chart-container">
                            <h5 class="mb-4">AI Confidence Scores</h5>
                            <div class="mb-3">
                                <div class="d-flex justify-content-between mb-1">
                                    <span>Procurement Fraud</span>
                                    <span class="confidence-high">92%</span>
                                </div>
                                <div class="progress" style="height: 8px;">
                                    <div class="progress-bar bg-success" style="width: 92%"></div>
                                </div>
                            </div>
                            <div class="mb-3">
                                <div class="d-flex justify-content-between mb-1">
                                    <span>Ghost Workers</span>
                                    <span class="confidence-high">88%</span>
                                </div>
                                <div class="progress" style="height: 8px;">
                                    <div class="progress-bar bg-success" style="width: 88%"></div>
                                </div>
                            </div>
                            <div class="mb-3">
                                <div class="d-flex justify-content-between mb-1">
                                    <span>Overpricing</span>
                                    <span class="confidence-medium">76%</span>
                                </div>
                                <div class="progress" style="height: 8px;">
                                    <div class="progress-bar bg-warning" style="width: 76%"></div>
                                </div>
                            </div>
                            <div class="mb-3">
                                <div class="d-flex justify-content-between mb-1">
                                    <span>Conflict of Interest</span>
                                    <span class="confidence-medium">71%</span>
                                </div>
                                <div class="progress" style="height: 8px;">
                                    <div class="progress-bar bg-warning" style="width: 71%"></div>
                                </div>
                            </div>
                            <div class="mb-3">
                                <div class="d-flex justify-content-between mb-1">
                                    <span>Bid Rigging</span>
                                    <span class="confidence-high">94%</span>
                                </div>
                                <div class="progress" style="height: 8px;">
                                    <div class="progress-bar bg-success" style="width: 94%"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- High Risk Transactions with AI Analysis -->
                <div class="chart-container mb-4">
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <h5 class="mb-0">AI-Powered High Risk Transactions</h5>
                        <div>
                            <span class="ai-badge me-2">Real-time Analysis</span>
                            <span class="ai-badge">Updated: 2 min ago</span>
                        </div>
                    </div>
                    
                    <div class="transaction-row high-risk">
                        <div class="row align-items-center">
                            <div class="col-md-5">
                                <div class="d-flex align-items-center">
                                    <div>
                                        <h6 class="mb-1">Ministry of Health - Medical Equipment Tender</h6>
                                        <small class="text-white-50">REF: KEMSA/2024/089</small>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <span class="text-warning">KES 45,000,000</span>
                            </div>
                            <div class="col-md-2">
                                <span class="badge bg-danger">94% Risk</span>
                            </div>
                            <div class="col-md-3">
                                <div class="d-flex align-items-center">
                                    <i class="fas fa-microchip me-2" style="color: var(--secondary);"></i>
                                    <small>Pattern: Bid Rigging (92% confidence)</small>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="transaction-row high-risk">
                        <div class="row align-items-center">
                            <div class="col-md-5">
                                <h6 class="mb-1">KRA - IT Infrastructure Upgrade</h6>
                                <small class="text-white-50">REF: KRA/2024/2345</small>
                            </div>
                            <div class="col-md-2">
                                <span class="text-warning">KES 128,000,000</span>
                            </div>
                            <div class="col-md-2">
                                <span class="badge bg-danger">96% Risk</span>
                            </div>
                            <div class="col-md-3">
                                <div class="d-flex align-items-center">
                                    <i class="fas fa-robot me-2" style="color: var(--secondary);"></i>
                                    <small>AI: Shell company detected</small>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="transaction-row medium-risk">
                        <div class="row align-items-center">
                            <div class="col-md-5">
                                <h6 class="mb-1">Ministry of Transport - Road Construction</h6>
                                <small class="text-white-50">REF: KENHA/2024/567</small>
                            </div>
                            <div class="col-md-2">
                                <span class="text-warning">KES 350,000,000</span>
                            </div>
                            <div class="col-md-2">
                                <span class="badge bg-warning">76% Risk</span>
                            </div>
                            <div class="col-md-3">
                                <div class="d-flex align-items-center">
                                    <i class="fas fa-link me-2" style="color: var(--secondary);"></i>
                                    <small>Blockchain: Verified ✓</small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Predictive AI and Blockchain -->
                <div class="row">
                    <div class="col-md-6">
                        <div class="chart-container">
                            <h5 class="mb-4">Predictive AI - Next 30 Days Forecast</h5>
                            <canvas id="predictiveChart" height="200"></canvas>
                            <div class="mt-3">
                                <div class="d-flex justify-content-between text-white-50">
                                    <span>Expected high-risk cases: 45-60</span>
                                    <span>Confidence: 87%</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-md-6">
                        <div class="chart-container">
                            <h5 class="mb-4">Blockchain Audit Trail</h5>
                            <div class="mb-2">
                                <div class="d-flex justify-content-between align-items-center">
                                    <span><i class="fas fa-check-circle text-success me-2"></i>Transaction #2345</span>
                                    <small class="blockchain-verified">Verified 12:34</small>
                                </div>
                            </div>
                            <div class="mb-2">
                                <div class="d-flex justify-content-between align-items-center">
                                    <span><i class="fas fa-check-circle text-success me-2"></i>Contract #876</span>
                                    <small class="blockchain-verified">Verified 11:20</small>
                                </div>
                            </div>
                            <div class="mb-2">
                                <div class="d-flex justify-content-between align-items-center">
                                    <span><i class="fas fa-clock text-warning me-2"></i>Payment #4532</span>
                                    <small class="blockchain-pending">Pending 15:45</small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Whistleblower Section -->
                <div class="whistleblower-section mt-4">
                    <div class="row align-items-center">
                        <div class="col-md-8">
                            <h4 class="text-white mb-3">Secure Whistleblower Portal</h4>
                            <p class="text-white-50 mb-4">Report corruption anonymously with end-to-end encryption. Your identity is protected by advanced cryptography and Kenyan law (Witness Protection Act).</p>
                            <button class="btn btn-primary-custom">
                                <i class="fas fa-lock me-2"></i>Submit Anonymous Report
                            </button>
                        </div>
                        <div class="col-md-4 text-end">
                            <i class="fas fa-shield-alt fa-5x" style="color: rgba(255,255,255,0.2);"></i>
                        </div>
                    </div>
                </div>
            </main>
        </div>
    </div>

    <!-- AI Analysis Modal -->
    <div class="modal fade" id="aiAnalysisModal" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content bg-dark text-white">
                <div class="modal-header border-secondary">
                    <h5 class="modal-title">
                        <i class="fas fa-microchip me-2" style="color: var(--secondary);"></i>
                        AI Deep Analysis
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <!-- AI Analysis content -->
                    <div class="mb-4">
                        <h6>Pattern Analysis</h6>
                        <p class="text-white-50">The system has detected unusual bidding patterns in the Ministry of Health procurement. Multiple bids show similar IP addresses and document metadata.</p>
                    </div>
                    <div class="mb-4">
                        <h6>Risk Factors</h6>
                        <ul class="list-unstyled">
                            <li class="mb-2"><i class="fas fa-times-circle text-danger me-2"></i> Unusually high pricing (45% above market rate)</li>
                            <li class="mb-2"><i class="fas fa-times-circle text-danger me-2"></i> Single bidder for multiple contracts</li>
                            <li class="mb-2"><i class="fas fa-times-circle text-danger me-2"></i> Company linked to government official</li>
                        </ul>
                    </div>
                    <div>
                        <h6>Recommendations</h6>
                        <div class="alert alert-info bg-info bg-opacity-10 border-info text-white">
                            <i class="fas fa-robot me-2"></i>
                            AI recommends immediate forensic audit and suspension of payments pending investigation.
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Scripts -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    
    <script>
        // Risk Chart
        const ctx = document.getElementById('riskChart').getContext('2d');
        new Chart(ctx, {
            type: 'line',
            data: {
                labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun'],
                datasets: [
                    {
                        label: 'High Risk',
                        data: [12, 19, 25, 18, 15, 22],
                        borderColor: '#D32F2F',
                        backgroundColor: 'rgba(211, 47, 47, 0.1)',
                        tension: 0.4
                    },
                    {
                        label: 'Medium Risk',
                        data: [25, 30, 28, 35, 40, 38],
                        borderColor: '#F57C00',
                        backgroundColor: 'rgba(245, 124, 0, 0.1)',
                        tension: 0.4
                    },
                    {
                        label: 'AI Detected',
                        data: [8, 15, 20, 25, 30, 35],
                        borderColor: '#C5A572',
                        backgroundColor: 'rgba(197, 165, 114, 0.1)',
                        borderDash: [5, 5],
                        tension: 0.4
                    }
                ]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        labels: { color: '#E2E8F0' }
                    }
                },
                scales: {
                    y: {
                        grid: { color: 'rgba(255,255,255,0.1)' },
                        ticks: { color: '#94A3B8' }
                    },
                    x: {
                        grid: { display: false },
                        ticks: { color: '#94A3B8' }
                    }
                }
            }
        });

        // Predictive Chart
        const predCtx = document.getElementById('predictiveChart').getContext('2d');
        new Chart(predCtx, {
            type: 'bar',
            data: {
                labels: ['Week 1', 'Week 2', 'Week 3', 'Week 4'],
                datasets: [{
                    label: 'Predicted High Risk',
                    data: [12, 18, 24, 30],
                    backgroundColor: '#C5A572',
                    borderRadius: 5
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { labels: { color: '#E2E8F0' } }
                },
                scales: {
                    y: {
                        grid: { color: 'rgba(255,255,255,0.1)' },
                        ticks: { color: '#94A3B8' }
                    },
                    x: {
                        grid: { display: false },
                        ticks: { color: '#94A3B8' }
                    }
                }
            }
        });

        // Real-time updates simulation
        setInterval(() => {
            // Simulate AI analysis updates
            console.log('AI Analysis running...');
        }, 30000); // Every 30 seconds
    </script>
</body>
</html>