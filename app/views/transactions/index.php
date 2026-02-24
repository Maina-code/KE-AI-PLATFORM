<?php
require_once __DIR__ . '/../auditor/layout/header.php';
require_once __DIR__ . '/../layout/loading.php';

// Get filter parameters
$filterStatus = $_GET['status'] ?? 'all';
$filterDepartment = $_GET['department'] ?? 'all';
$filterRisk = $_GET['risk'] ?? 'all';
$searchQuery = $_GET['search'] ?? '';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Transactions - Anti-Corruption Monitor</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.4.1/css/buttons.bootstrap5.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
    
    <style>
        :root {
            --glass-bg: rgba(255, 255, 255, 0.1);
            --glass-border: rgba(255, 255, 255, 0.2);
            --glass-shadow: 0 8px 32px 0 rgba(31, 38, 135, 0.15);
            --primary: #0A2351;
            --primary-light: #1a3a6b;
            --accent: #C5A572;
            --accent-dark: #9e814d;
            --danger: #dc3545;
            --warning: #ffc107;
            --success: #28a745;
            --info: #17a2b8;
            --text-primary: rgba(255, 255, 255, 0.95);
            --text-secondary: rgba(255, 255, 255, 0.7);
            --text-muted: rgba(255, 255, 255, 0.5);
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
        
        /* Page Header */
        .page-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 30px;
        }
        
        .page-header h1 {
            font-size: 2rem;
            font-weight: 600;
            margin: 0;
        }
        
        .page-header h1 i {
            color: var(--accent);
            margin-right: 15px;
        }
        
        .header-actions {
            display: flex;
            gap: 15px;
        }
        
        .btn-primary-custom {
            background: var(--accent);
            color: var(--primary);
            border: none;
            padding: 10px 20px;
            border-radius: 10px;
            font-weight: 600;
            transition: all 0.3s;
        }
        
        .btn-primary-custom:hover {
            background: var(--accent-dark);
            transform: translateY(-2px);
            box-shadow: 0 5px 20px rgba(197, 165, 114, 0.3);
        }
        
        .btn-outline-custom {
            background: transparent;
            border: 1px solid var(--glass-border);
            color: var(--text-primary);
            padding: 10px 20px;
            border-radius: 10px;
            font-weight: 500;
            transition: all 0.3s;
        }
        
        .btn-outline-custom:hover {
            background: var(--glass-bg);
            border-color: var(--accent);
        }
        
        /* Filter Bar */
        .filter-bar {
            background: var(--glass-bg);
            backdrop-filter: blur(10px);
            border: 1px solid var(--glass-border);
            border-radius: 15px;
            padding: 20px;
            margin-bottom: 30px;
            display: flex;
            flex-wrap: wrap;
            gap: 15px;
            align-items: center;
        }
        
        .filter-group {
            display: flex;
            align-items: center;
            gap: 10px;
            flex: 1;
            min-width: 200px;
        }
        
        .filter-group label {
            color: var(--text-secondary);
            font-weight: 500;
            min-width: 80px;
        }
        
        .filter-group select, .filter-group input {
            background: var(--transparency-primary);
            border: 1px solid var(--glass-border);
            border-radius: 8px;
            padding: 8px 15px;
            color: var(--text-primary);
            width: 100%;
        }
        
        .filter-group select option {
            background: var(--primary);
        }
        
        .search-box {
            flex: 2;
            position: relative;
        }
        
        .search-box i {
            position: absolute;
            left: 15px;
            top: 50%;
            transform: translateY(-50%);
            color: var(--text-muted);
        }
        
        .search-box input {
            width: 100%;
            padding: 10px 15px 10px 45px;
            background: var(--transparency-primary);
            border: 1px solid var(--glass-border);
            border-radius: 8px;
            color: var(--text-primary);
        }
        
        .filter-actions {
            display: flex;
            gap: 10px;
        }
        
        /* Stats Summary */
        .stats-summary {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 20px;
            margin-bottom: 30px;
        }
        
        .stat-summary-card {
            background: var(--glass-bg);
            backdrop-filter: blur(10px);
            border: 1px solid var(--glass-border);
            border-radius: 12px;
            padding: 20px;
            text-align: center;
        }
        
        .stat-summary-value {
            font-size: 2rem;
            font-weight: 700;
            color: var(--accent);
        }
        
        .stat-summary-label {
            color: var(--text-secondary);
            font-size: 0.9rem;
        }
        
        /* Transactions Table */
        .table-container {
            background: var(--glass-bg);
            backdrop-filter: blur(10px);
            border: 1px solid var(--glass-border);
            border-radius: 20px;
            padding: 20px;
            overflow-x: auto;
        }
        
        .table {
            width: 100%;
            color: var(--text-primary);
        }
        
        .table thead th {
            color: var(--accent);
            border-bottom: 2px solid var(--glass-border);
            font-weight: 600;
            padding: 15px 10px;
        }
        
        .table tbody td {
            padding: 15px 10px;
            border-bottom: 1px solid var(--glass-border);
            vertical-align: middle;
        }
        
        .table tbody tr:hover {
            background: var(--transparency-primary);
        }
        
        .risk-badge {
            padding: 5px 12px;
            border-radius: 50px;
            font-size: 0.8rem;
            font-weight: 600;
            display: inline-block;
        }
        
        .risk-critical { background: rgba(220, 53, 69, 0.2); color: #ff6b6b; border: 1px solid rgba(220, 53, 69, 0.3); }
        .risk-high { background: rgba(220, 53, 69, 0.15); color: #ff8a8a; border: 1px solid rgba(220, 53, 69, 0.25); }
        .risk-medium { background: rgba(255, 193, 7, 0.2); color: #ffc107; border: 1px solid rgba(255, 193, 7, 0.3); }
        .risk-low { background: rgba(40, 167, 69, 0.2); color: #2ecc71; border: 1px solid rgba(40, 167, 69, 0.3); }
        
        .status-badge {
            padding: 5px 12px;
            border-radius: 50px;
            font-size: 0.8rem;
            font-weight: 600;
        }
        
        .status-pending { background: rgba(255, 193, 7, 0.2); color: #ffc107; }
        .status-approved { background: rgba(40, 167, 69, 0.2); color: #2ecc71; }
        .status-flagged { background: rgba(220, 53, 69, 0.2); color: #ff6b6b; }
        .status-investigating { background: rgba(23, 162, 184, 0.2); color: #17a2b8; }
        .status-recovered { background: rgba(40, 167, 69, 0.2); color: #2ecc71; }
        
        .action-buttons {
            display: flex;
            gap: 8px;
        }
        
        .btn-icon {
            width: 35px;
            height: 35px;
            border-radius: 8px;
            border: 1px solid var(--glass-border);
            background: transparent;
            color: var(--text-secondary);
            transition: all 0.3s;
            cursor: pointer;
        }
        
        .btn-icon:hover {
            background: var(--accent);
            color: var(--primary);
            border-color: var(--accent);
        }
        
        .btn-icon.ai-analyze:hover {
            background: var(--info);
            color: white;
        }
        
        /* AI Indicator */
        .ai-indicator {
            display: inline-flex;
            align-items: center;
            gap: 5px;
            font-size: 0.75rem;
            color: var(--accent);
            background: rgba(197, 165, 114, 0.1);
            padding: 3px 8px;
            border-radius: 50px;
        }
        
        .ai-indicator i {
            font-size: 0.7rem;
        }
        
        /* Pagination */
        .pagination {
            margin-top: 20px;
            display: flex;
            justify-content: flex-end;
            gap: 5px;
        }
        
        .page-item .page-link {
            background: var(--glass-bg);
            border: 1px solid var(--glass-border);
            color: var(--text-primary);
            border-radius: 8px;
            padding: 8px 15px;
        }
        
        .page-item.active .page-link {
            background: var(--accent);
            color: var(--primary);
            border-color: var(--accent);
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
            
            .filter-bar {
                flex-direction: column;
            }
            
            .filter-group {
                width: 100%;
            }
            
            .header-actions {
                flex-direction: column;
            }
            
            .table-container {
                padding: 10px;
            }
            
            .action-buttons {
                flex-direction: column;
            }
        }
        
        /* DataTables Customization */
        .dataTables_wrapper .dataTables_length,
        .dataTables_wrapper .dataTables_filter,
        .dataTables_wrapper .dataTables_info,
        .dataTables_wrapper .dataTables_paginate {
            color: var(--text-primary) !important;
            margin: 10px 0;
        }
        
        .dataTables_wrapper .dataTables_filter input {
            background: var(--transparency-primary) !important;
            border: 1px solid var(--glass-border) !important;
            color: var(--text-primary) !important;
            border-radius: 8px !important;
            padding: 5px 10px !important;
        }
        
        .dataTables_wrapper .dataTables_length select {
            background: var(--transparency-primary) !important;
            border: 1px solid var(--glass-border) !important;
            color: var(--text-primary) !important;
            border-radius: 8px !important;
        }
    </style>
</head>
<body>
    <!-- Navbar is already included at the top -->
    
    <!-- Main Content -->
    <div class="main-content">
        <!-- Page Header -->
        <div class="page-header">
            <h1>
                <i class="fas fa-exchange-alt"></i>
                Transaction Monitor
            </h1>
            <div class="header-actions">
                <button class="btn-outline-custom" onclick="exportTransactions()">
                    <i class="fas fa-download me-2"></i>Export
                </button>
                <button class="btn-primary-custom" onclick="showAddTransactionModal()">
                    <i class="fas fa-plus-circle me-2"></i>New Transaction
                </button>
            </div>
        </div>

        <!-- Filter Bar -->
        <div class="filter-bar">
            <div class="search-box">
                <i class="fas fa-search"></i>
                <input type="text" id="searchInput" placeholder="Search by reference, description, supplier..." value="<?php echo htmlspecialchars($searchQuery); ?>">
            </div>
            
            <div class="filter-group">
                <label>Status</label>
                <select id="statusFilter">
                    <option value="all" <?php echo $filterStatus == 'all' ? 'selected' : ''; ?>>All Status</option>
                    <option value="pending" <?php echo $filterStatus == 'pending' ? 'selected' : ''; ?>>Pending</option>
                    <option value="approved" <?php echo $filterStatus == 'approved' ? 'selected' : ''; ?>>Approved</option>
                    <option value="flagged" <?php echo $filterStatus == 'flagged' ? 'selected' : ''; ?>>Flagged</option>
                    <option value="investigating" <?php echo $filterStatus == 'investigating' ? 'selected' : ''; ?>>Investigating</option>
                    <option value="recovered" <?php echo $filterStatus == 'recovered' ? 'selected' : ''; ?>>Recovered</option>
                </select>
            </div>
            
            <div class="filter-group">
                <label>Risk Level</label>
                <select id="riskFilter">
                    <option value="all" <?php echo $filterRisk == 'all' ? 'selected' : ''; ?>>All Risks</option>
                    <option value="critical" <?php echo $filterRisk == 'critical' ? 'selected' : ''; ?>>Critical (80%+)</option>
                    <option value="high" <?php echo $filterRisk == 'high' ? 'selected' : ''; ?>>High (60-79%)</option>
                    <option value="medium" <?php echo $filterRisk == 'medium' ? 'selected' : ''; ?>>Medium (40-59%)</option>
                    <option value="low" <?php echo $filterRisk == 'low' ? 'selected' : ''; ?>>Low (Below 40%)</option>
                </select>
            </div>
            
            <div class="filter-actions">
                <button class="btn-outline-custom" onclick="applyFilters()">
                    <i class="fas fa-filter me-2"></i>Apply
                </button>
                <button class="btn-outline-custom" onclick="resetFilters()">
                    <i class="fas fa-undo me-2"></i>Reset
                </button>
            </div>
        </div>

        <!-- Stats Summary -->
        <div class="stats-summary">
            <div class="stat-summary-card">
                <div class="stat-summary-value"><?php echo number_format($stats['total_transactions'] ?? 1248); ?></div>
                <div class="stat-summary-label">Total Transactions</div>
            </div>
            <div class="stat-summary-card">
                <div class="stat-summary-value" style="color: var(--danger);"><?php echo number_format($stats['high_risk'] ?? 47); ?></div>
                <div class="stat-summary-label">High Risk</div>
            </div>
            <div class="stat-summary-card">
                <div class="stat-summary-value" style="color: var(--warning);"><?php echo number_format($stats['ai_flagged'] ?? 23); ?></div>
                <div class="stat-summary-label">AI Flagged</div>
            </div>
            <div class="stat-summary-card">
                <div class="stat-summary-value" style="color: var(--success);">KES <?php echo number_format($stats['recovered_funds'] ?? 45200000); ?></div>
                <div class="stat-summary-label">Recovered Funds</div>
            </div>
        </div>

        <!-- Transactions Table -->
        <div class="table-container">
            <table class="table" id="transactionsTable">
                <thead>
                    <tr>
                        <th>Ref No</th>
                        <th>Description</th>
                        <th>Department</th>
                        <th>Supplier</th>
                        <th>Amount (KES)</th>
                        <th>Date</th>
                        <th>Procurement</th>
                        <th>Risk Score</th>
                        <th>Status</th>
                        <th>AI</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($transactions)): ?>
                        <?php foreach ($transactions as $transaction): ?>
                            <tr>
                                <td><strong><?php echo htmlspecialchars($transaction['ref_no']); ?></strong></td>
                                <td><?php echo htmlspecialchars(substr($transaction['description'], 0, 50)) . '...'; ?></td>
                                <td><?php echo htmlspecialchars($transaction['department_name'] ?? 'N/A'); ?></td>
                                <td><?php echo htmlspecialchars($transaction['supplier'] ?? 'N/A'); ?></td>
                                <td><?php echo number_format($transaction['amount']); ?></td>
                                <td><?php echo date('d/m/Y', strtotime($transaction['transaction_date'] ?? $transaction['created_at'])); ?></td>
                                <td>
                                    <span class="badge" style="background: <?php echo $transaction['procurement_type'] == 'single' ? 'rgba(220, 53, 69, 0.2)' : 'rgba(23, 162, 184, 0.2)'; ?>; color: <?php echo $transaction['procurement_type'] == 'single' ? '#ff6b6b' : '#17a2b8'; ?>;">
                                        <?php echo ucfirst($transaction['procurement_type']); ?>
                                    </span>
                                </td>
                                <td>
                                    <?php 
                                    $riskScore = $transaction['risk_score'] * 100;
                                    $riskClass = 'risk-low';
                                    if ($riskScore >= 80) $riskClass = 'risk-critical';
                                    elseif ($riskScore >= 60) $riskClass = 'risk-high';
                                    elseif ($riskScore >= 40) $riskClass = 'risk-medium';
                                    ?>
                                    <span class="risk-badge <?php echo $riskClass; ?>">
                                        <?php echo number_format($riskScore, 1); ?>%
                                    </span>
                                </td>
                                <td>
                                    <span class="status-badge status-<?php echo $transaction['status']; ?>">
                                        <?php echo ucfirst($transaction['status']); ?>
                                    </span>
                                </td>
                                <td>
                                    <?php if ($transaction['ai_flagged']): ?>
                                        <span class="ai-indicator">
                                            <i class="fas fa-microchip"></i>
                                            <span>AI: <?php echo number_format($transaction['risk_score'] * 100, 1); ?>%</span>
                                        </span>
                                    <?php else: ?>
                                        <span class="ai-indicator" style="opacity: 0.5;">
                                            <i class="fas fa-microchip"></i>
                                            <span>Pending</span>
                                        </span>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <div class="action-buttons">
                                        <button class="btn-icon" onclick="viewTransaction(<?php echo $transaction['id']; ?>)" title="View Details">
                                            <i class="fas fa-eye"></i>
                                        </button>
                                        <button class="btn-icon ai-analyze" onclick="analyzeWithAI(<?php echo $transaction['id']; ?>)" title="Run AI Analysis">
                                            <i class="fas fa-microchip"></i>
                                        </button>
                                        <?php if ($_SESSION['user_role'] === 'auditor_general'): ?>
                                            <button class="btn-icon" onclick="editTransaction(<?php echo $transaction['id']; ?>)" title="Edit">
                                                <i class="fas fa-edit"></i>
                                            </button>
                                            <button class="btn-icon" onclick="deleteTransaction(<?php echo $transaction['id']; ?>)" title="Delete" style="color: var(--danger);">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        <?php endif; ?>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <!-- Sample data for demonstration -->
                        <tr>
                            <td><strong>T001/2024</strong></td>
                            <td>Medical Equipment Supply - KEMSA Tender...</td>
                            <td>Ministry of Health</td>
                            <td>MediTech Ltd</td>
                            <td>45,000,000</td>
                            <td>15/01/2024</td>
                            <td><span class="badge" style="background: rgba(220,53,69,0.2); color: #ff6b6b;">Single</span></td>
                            <td><span class="risk-badge risk-critical">94.0%</span></td>
                            <td><span class="status-badge status-flagged">Flagged</span></td>
                            <td><span class="ai-indicator"><i class="fas fa-microchip"></i> AI: 94%</span></td>
                            <td>
                                <div class="action-buttons">
                                    <button class="btn-icon" onclick="viewTransaction(1)"><i class="fas fa-eye"></i></button>
                                    <button class="btn-icon ai-analyze" onclick="analyzeWithAI(1)"><i class="fas fa-microchip"></i></button>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td><strong>T002/2024</strong></td>
                            <td>Office Stationery and Supplies...</td>
                            <td>Ministry of Education</td>
                            <td>Office Masters</td>
                            <td>250,000</td>
                            <td>20/01/2024</td>
                            <td><span class="badge" style="background: rgba(23,162,184,0.2); color: #17a2b8;">Open</span></td>
                            <td><span class="risk-badge risk-low">15.0%</span></td>
                            <td><span class="status-badge status-approved">Approved</span></td>
                            <td><span class="ai-indicator" style="opacity:0.5"><i class="fas fa-microchip"></i> Pending</span></td>
                            <td>
                                <div class="action-buttons">
                                    <button class="btn-icon" onclick="viewTransaction(2)"><i class="fas fa-eye"></i></button>
                                    <button class="btn-icon ai-analyze" onclick="analyzeWithAI(2)"><i class="fas fa-microchip"></i></button>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td><strong>T003/2024</strong></td>
                            <td>IT Infrastructure Upgrade - KRA...</td>
                            <td>KRA</td>
                            <td>Tech Solutions</td>
                            <td>128,000,000</td>
                            <td>20/01/2024</td>
                            <td><span class="badge" style="background: rgba(255,193,7,0.2); color: #ffc107;">Restricted</span></td>
                            <td><span class="risk-badge risk-high">88.0%</span></td>
                            <td><span class="status-badge status-investigating">Investigating</span></td>
                            <td><span class="ai-indicator"><i class="fas fa-microchip"></i> AI: 88%</span></td>
                            <td>
                                <div class="action-buttons">
                                    <button class="btn-icon" onclick="viewTransaction(3)"><i class="fas fa-eye"></i></button>
                                    <button class="btn-icon ai-analyze" onclick="analyzeWithAI(3)"><i class="fas fa-microchip"></i></button>
                                </div>
                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <div class="pagination">
            <nav>
                <ul class="pagination">
                    <li class="page-item disabled"><span class="page-link">Previous</span></li>
                    <li class="page-item active"><span class="page-link">1</span></li>
                    <li class="page-item"><span class="page-link">2</span></li>
                    <li class="page-item"><span class="page-link">3</span></li>
                    <li class="page-item"><span class="page-link">Next</span></li>
                </ul>
            </nav>
        </div>
    </div>

    <!-- Add Transaction Modal -->
    <div class="modal fade" id="addTransactionModal" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">
                        <i class="fas fa-plus-circle me-2" style="color: var(--accent);"></i>
                        Add New Transaction
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <form id="addTransactionForm" onsubmit="saveTransaction(event)">
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Reference Number</label>
                                <input type="text" name="ref_no" class="form-control" required placeholder="e.g., T001/2024">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Amount (KES)</label>
                                <input type="number" name="amount" class="form-control" required min="0">
                            </div>
                        </div>
                        
                        <div class="mb-3">
                            <label class="form-label">Description</label>
                            <textarea name="description" class="form-control" rows="2" required placeholder="Enter transaction description..."></textarea>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Department</label>
                                <select name="department_id" class="form-control" required>
                                    <option value="">Select Department</option>
                                    <option value="1">Ministry of Health</option>
                                    <option value="2">Ministry of Education</option>
                                    <option value="3">Ministry of Roads</option>
                                    <option value="4">KRA</option>
                                    <option value="5">Ministry of Interior</option>
                                </select>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Supplier</label>
                                <input type="text" name="supplier" class="form-control" required placeholder="Supplier name">
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-4 mb-3">
                                <label class="form-label">Procurement Type</label>
                                <select name="procurement_type" class="form-control" required>
                                    <option value="open">Open Tender</option>
                                    <option value="restricted">Restricted</option>
                                    <option value="single">Single Source</option>
                                    <option value="framework">Framework</option>
                                </select>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label class="form-label">Transaction Date</label>
                                <input type="date" name="transaction_date" class="form-control" required value="<?php echo date('Y-m-d'); ?>">
                            </div>
                            <div class="col-md-4 mb-3">
                                <label class="form-label">Bidder Count</label>
                                <input type="number" name="bidder_count" class="form-control" min="1" value="1">
                            </div>
                        </div>
                        
                        <div class="mb-3">
                            <div class="form-check">
                                <input type="checkbox" name="is_emergency" class="form-check-input" id="emergencyCheck">
                                <label class="form-check-label" for="emergencyCheck">Emergency Procurement</label>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn-primary-custom">Save Transaction</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Investigation Modal (reuse from dashboard) -->
    <div class="modal fade" id="investigationModal" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">
                        <i class="fas fa-search me-2" style="color: var(--accent);"></i>
                        AI Analysis Results
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
    <script src="https://cdn.datatables.net/buttons/2.4.1/js/dataTables.buttons.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.bootstrap5.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.print.min.js"></script>

    <script>
        // Initialize DataTable
        $(document).ready(function() {
            $('#transactionsTable').DataTable({
                responsive: true,
                pageLength: 25,
                lengthMenu: [[10, 25, 50, -1], [10, 25, 50, "All"]],
                order: [[5, 'desc']], // Sort by date descending
                dom: 'Bfrtip',
                buttons: [
                    {
                        extend: 'copy',
                        text: '<i class="fas fa-copy"></i> Copy',
                        className: 'btn-outline-custom btn-sm'
                    },
                    {
                        extend: 'csv',
                        text: '<i class="fas fa-file-csv"></i> CSV',
                        className: 'btn-outline-custom btn-sm'
                    },
                    {
                        extend: 'excel',
                        text: '<i class="fas fa-file-excel"></i> Excel',
                        className: 'btn-outline-custom btn-sm'
                    },
                    {
                        extend: 'pdf',
                        text: '<i class="fas fa-file-pdf"></i> PDF',
                        className: 'btn-outline-custom btn-sm'
                    },
                    {
                        extend: 'print',
                        text: '<i class="fas fa-print"></i> Print',
                        className: 'btn-outline-custom btn-sm'
                    }
                ],
                language: {
                    search: "",
                    searchPlaceholder: "Search transactions...",
                    lengthMenu: "Show _MENU_ entries",
                    info: "Showing _START_ to _END_ of _TOTAL_ entries",
                    paginate: {
                        first: '<i class="fas fa-angle-double-left"></i>',
                        previous: '<i class="fas fa-angle-left"></i>',
                        next: '<i class="fas fa-angle-right"></i>',
                        last: '<i class="fas fa-angle-double-right"></i>'
                    }
                }
            });
        });

        // Filter functions
        function applyFilters() {
            const status = document.getElementById('statusFilter').value;
            const risk = document.getElementById('riskFilter').value;
            const search = document.getElementById('searchInput').value;
            
            let url = 'index.php?controller=transaction&action=index';
            let params = [];
            
            if (status !== 'all') params.push('status=' + status);
            if (risk !== 'all') params.push('risk=' + risk);
            if (search) params.push('search=' + encodeURIComponent(search));
            
            if (params.length > 0) {
                url += '&' + params.join('&');
            }
            
            window.location.href = url;
        }

        function resetFilters() {
            window.location.href = 'index.php?controller=transaction&action=index';
        }

        // Transaction CRUD functions
        function showAddTransactionModal() {
            const modal = new bootstrap.Modal(document.getElementById('addTransactionModal'));
            modal.show();
        }

        function saveTransaction(event) {
            event.preventDefault();
            
            const form = document.getElementById('addTransactionForm');
            const formData = new FormData(form);
            
            fetch('index.php?controller=transaction&action=add', {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    alert('Transaction added successfully!');
                    location.reload();
                } else {
                    alert('Error: ' + data.error);
                }
            })
            .catch(error => {
                alert('Failed to save transaction');
                console.error(error);
            });
        }

        function viewTransaction(id) {
            window.location.href = 'index.php?controller=transaction&action=view&id=' + id;
        }

        function editTransaction(id) {
            window.location.href = 'index.php?controller=transaction&action=edit&id=' + id;
        }

        function deleteTransaction(id) {
            if (confirm('Are you sure you want to delete this transaction?')) {
                fetch('index.php?controller=transaction&action=delete&id=' + id, {
                    method: 'POST'
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        alert('Transaction deleted');
                        location.reload();
                    } else {
                        alert('Error: ' + data.error);
                    }
                });
            }
        }

        // AI Analysis function (reuse from dashboard)
        function analyzeWithAI(transactionId) {
            const button = event.target.closest('button');
            const originalText = button.innerHTML;
            button.innerHTML = '<i class="fas fa-spinner fa-spin"></i>';
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
                button.innerHTML = originalText;
                button.disabled = false;
                
                if (data.success) {
                    showAIAnalysis(data.analysis);
                } else {
                    alert('AI analysis failed: ' + (data.error || 'Unknown error'));
                }
            })
            .catch(error => {
                button.innerHTML = originalText;
                button.disabled = false;
                alert('Failed to connect to AI service');
            });
        }

        // Show AI analysis in modal (reuse from dashboard)
        function showAIAnalysis(analysis) {
            const modal = new bootstrap.Modal(document.getElementById('investigationModal'));
            const modalBody = document.getElementById('investigationDetails');
            
            let patternsHtml = '';
            if (analysis.patterns && analysis.patterns.length > 0) {
                analysis.patterns.forEach(pattern => {
                    patternsHtml += `<li><span style="color: #C5A572;">●</span> ${pattern.pattern} (${pattern.confidence}% confidence)</li>`;
                });
            }
            
            let recommendationsHtml = '';
            if (analysis.recommendations && analysis.recommendations.length > 0) {
                analysis.recommendations.forEach(rec => {
                    recommendationsHtml += `<li><i class="fas fa-check-circle me-2" style="color: #28a745;"></i>${rec}</li>`;
                });
            }
            
            modalBody.innerHTML = `
                <div class="row">
                    <div class="col-md-6">
                        <h6>AI Analysis Results</h6>
                        <p><strong>Risk Score:</strong> <span style="color: ${analysis.risk_level === 'CRITICAL' ? '#dc3545' : '#ffc107'}">${analysis.risk_score}% (${analysis.risk_level})</span></p>
                        <p><strong>Confidence:</strong> ${analysis.confidence}%</p>
                        <p><strong>Analyzed:</strong> ${analysis.timestamp || new Date().toLocaleString()}</p>
                    </div>
                    <div class="col-md-6">
                        <h6>Detected Patterns</h6>
                        <ul>
                            ${patternsHtml || '<li>No specific patterns detected</li>'}
                        </ul>
                    </div>
                </div>
                <div class="row mt-3">
                    <div class="col-12">
                        <h6>AI Recommendations</h6>
                        <ul>
                            ${recommendationsHtml || '<li>No specific recommendations</li>'}
                        </ul>
                    </div>
                </div>
            `;
            
            modal.show();
        }

        // Export functions
        function exportTransactions() {
            window.location.href = 'index.php?controller=export&action=transactions';
        }

        function assignInvestigation() {
            alert('Assignment interface would open here');
        }

        function flagUrgent() {
            alert('Case flagged as urgent. Investigators notified.');
        }

        // Search on enter key
        document.getElementById('searchInput').addEventListener('keypress', function(e) {
            if (e.key === 'Enter') {
                applyFilters();
            }
        });
    </script>
</body>
</html>