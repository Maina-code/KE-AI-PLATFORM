<div class="container-fluid">
    <!-- Welcome Banner -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card bg-primary text-white">
                <div class="card-body">
                    <h4>Welcome back, <?php echo htmlspecialchars($user['name']); ?>!</h4>
                    <p class="mb-0">NuruAI is monitoring government transactions for corruption indicators.</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Statistics Cards -->
    <div class="row mb-4">
        <div class="col-md-3">
            <div class="card">
                <div class="card-body">
                    <h6 class="text-muted">Total Transactions</h6>
                    <h3><?php echo number_format($stats['total']); ?></h3>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card border-danger">
                <div class="card-body">
                    <h6 class="text-danger">High Risk</h6>
                    <h3 class="text-danger"><?php echo $stats['high_risk']; ?></h3>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card border-warning">
                <div class="card-body">
                    <h6 class="text-warning">Single Source</h6>
                    <h3><?php echo $stats['single_source']; ?></h3>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card">
                <div class="card-body">
                    <h6 class="text-muted">Total Value</h6>
                    <h3>KES <?php echo number_format($stats['total_amount'] ?? 0); ?></h3>
                </div>
            </div>
        </div>
    </div>

    <!-- High Risk Transactions -->
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Transactions Needing Review</h5>
                </div>
                <div class="card-body">
                    <table class="table table-hover" id="transactionsTable">
                        <thead>
                            <tr>
                                <th>Ref No</th>
                                <th>Description</th>
                                <th>Amount</th>
                                <th>Department</th>
                                <th>Supplier</th>
                                <th>Type</th>
                                <th>Risk</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($transactions as $t): ?>
                            <tr class="<?php echo $t['risk_score'] > 0.7 ? 'table-danger' : ($t['risk_score'] > 0.4 ? 'table-warning' : ''); ?>">
                                <td><?php echo htmlspecialchars($t['ref_no']); ?></td>
                                <td><?php echo htmlspecialchars($t['description']); ?></td>
                                <td>KES <?php echo number_format($t['amount']); ?></td>
                                <td><?php echo htmlspecialchars($t['department']); ?></td>
                                <td><?php echo htmlspecialchars($t['supplier']); ?></td>
                                <td>
                                    <span class="badge bg-<?php echo $t['procurement_type'] == 'single' ? 'warning' : 'info'; ?>">
                                        <?php echo $t['procurement_type']; ?>
                                    </span>
                                </td>
                                <td>
                                    <?php if ($t['risk_score'] > 0.7): ?>
                                        <span class="badge bg-danger">HIGH</span>
                                    <?php elseif ($t['risk_score'] > 0.4): ?>
                                        <span class="badge bg-warning">MEDIUM</span>
                                    <?php else: ?>
                                        <span class="badge bg-success">LOW</span>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <a href="index.php?controller=Transaction&action=analyze&id=<?php echo $t['id']; ?>" 
                                       class="btn btn-sm btn-primary">
                                        <i class="fas fa-robot"></i> Analyze
                                    </a>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="row mt-4">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <h5 class="mb-3">Quick Actions</h5>
                    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addTransactionModal">
                        <i class="fas fa-plus"></i> Add Transaction
                    </button>
                    <a href="index.php?controller=Transaction&action=index" class="btn btn-outline-primary">
                        <i class="fas fa-list"></i> View All
                    </a>
                    <button class="btn btn-outline-warning" onclick="runBatchAI()">
                        <i class="fas fa-microchip"></i> Run AI Batch
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Add Transaction Modal -->
<div class="modal fade" id="addTransactionModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Add New Transaction</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form method="POST" action="index.php?controller=Transaction&action=add">
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Reference Number</label>
                        <input type="text" name="ref_no" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Description</label>
                        <textarea name="description" class="form-control" rows="2" required></textarea>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Amount (KES)</label>
                        <input type="number" name="amount" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Department</label>
                        <input type="text" name="department" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Supplier</label>
                        <input type="text" name="supplier" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Procurement Type</label>
                        <select name="procurement_type" class="form-control">
                            <option value="open">Open Tender</option>
                            <option value="restricted">Restricted</option>
                            <option value="single">Single Source</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Save</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
function runBatchAI() {
    if (!confirm('Run AI analysis on all pending transactions?')) return;
    
    fetch('index.php?controller=AI&action=batch', {
        method: 'POST'
    })
    .then(response => response.json())
    .then(data => {
        alert(`Processed ${data.processed} transactions`);
        location.reload();
    });
}
</script>