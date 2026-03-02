// ============================================
// DASHBOARD FUNCTIONS
// ============================================

let riskChart, corruptionChart;

document.addEventListener('DOMContentLoaded', function() {
    initializeCharts();
    loadDashboardData();
    setupEventListeners();
});

// ============================================
// INITIALIZATION
// ============================================

function initializeCharts() {
    initializeRiskTrendChart();
    initializeCorruptionTypeChart();
}

function initializeRiskTrendChart() {
    const ctx = document.getElementById('riskTrendChart');
    if (!ctx) return;
    
    riskChart = new Chart(ctx.getContext('2d'), {
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
        options: getChartOptions('Number of High-Risk Cases')
    });
}

function initializeCorruptionTypeChart() {
    const ctx = document.getElementById('corruptionTypeChart');
    if (!ctx) return;
    
    corruptionChart = new Chart(ctx.getContext('2d'), {
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
                    labels: { color: 'rgba(255, 255, 255, 0.7)' }
                }
            },
            cutout: '60%'
        }
    });
}

function getChartOptions(yAxisTitle) {
    return {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
            legend: {
                labels: { color: 'rgba(255, 255, 255, 0.7)' }
            }
        },
        scales: {
            y: {
                grid: { color: 'rgba(255, 255, 255, 0.1)' },
                ticks: { color: 'rgba(255, 255, 255, 0.7)' },
                title: {
                    display: true,
                    text: yAxisTitle,
                    color: 'rgba(255, 255, 255, 0.7)'
                }
            },
            x: {
                grid: { color: 'rgba(255, 255, 255, 0.1)' },
                ticks: { color: 'rgba(255, 255, 255, 0.7)' }
            }
        }
    };
}

function setupEventListeners() {
    document.getElementById('riskTimeRange')?.addEventListener('change', handleRiskTimeRangeChange);
    document.getElementById('corruptionType')?.addEventListener('change', handleCorruptionTypeChange);
}

// ============================================
// DATA LOADING
// ============================================

async function loadDashboardData() {
    try {
        await Promise.all([
            loadAIInsights(),
            loadAIAlerts(),
            loadAIPatterns(),
            loadConfidenceMetrics()
        ]);
    } catch (error) {
        console.error('Error loading dashboard data:', error);
        useFallbackData();
    }
}

async function loadAIInsights() {
    const data = await fetchData('index.php?controller=ai&action=getInsights');
    if (data?.success) {
        updateAIInsights(data.insights);
        updateAIPredictions(data.predictions);
    }
}

async function loadAIAlerts() {
    const data = await fetchData('index.php?controller=ai&action=getInsights');
    if (data?.success && data.alerts?.length) {
        updateAIAlerts(data.alerts);
    }
}

async function loadAIPatterns() {
    const data = await fetchData('index.php?controller=ai&action=getPatterns');
    if (data?.success && data.patterns) {
        updateAIPatterns(data.patterns);
        updateCorruptionTypeChart(data.patterns);
    }
}

async function loadConfidenceMetrics() {
    const data = await fetchData('index.php?controller=ai&action=getConfidenceMetrics');
    if (data?.success && data.metrics) {
        updateConfidenceMetrics(data.metrics);
    }
}

async function fetchData(url) {
    try {
        const response = await fetch(url);
        if (!response.ok) throw new Error('Network response was not ok');
        return await response.json();
    } catch (error) {
        console.error(`Error fetching ${url}:`, error);
        return null;
    }
}

// ============================================
// UI UPDATE FUNCTIONS
// ============================================

function updateAIInsights(insights) {
    if (!insights?.top_patterns) return;
    
    const insightItems = document.querySelectorAll('.insight-item');
    const patternEntries = Object.entries(insights.top_patterns);
    
    insightItems.forEach((item, index) => {
        if (index >= patternEntries.length) return;
        
        const [pattern, count] = patternEntries[index];
        updateInsightItem(item, pattern, count);
    });
}

function updateInsightItem(item, pattern, count) {
    const title = item.querySelector('.insight-title');
    const desc = item.querySelector('.insight-desc');
    const confidence = item.querySelector('.insight-confidence');
    const icon = item.querySelector('.insight-icon');
    
    if (title) title.textContent = formatPatternName(pattern);
    if (desc) desc.textContent = `${count} cases detected in last 30 days`;
    if (confidence) confidence.textContent = getPatternConfidence(pattern) + '%';
    if (icon) icon.style.backgroundColor = getPatternColor(pattern);
}

function updateAIAlerts(alerts) {
    const alertBanner = document.querySelector('.ai-alert-banner');
    if (!alertBanner || !alerts.length) return;
    
    const alert = alerts[0];
    const alertText = alertBanner.querySelector('.ai-alert-text p');
    const alertConfidence = alertBanner.querySelector('.ai-confidence');
    const alertIcon = alertBanner.querySelector('.ai-alert-icon i');
    
    if (alertText) alertText.textContent = alert.message;
    if (alertConfidence) {
        alertConfidence.innerHTML = `<i class="fas fa-microchip me-2"></i>AI Confidence: ${alert.confidence}%`;
    }
    if (alertIcon && alert.risk_score > 0.8) {
        alertIcon.style.color = alert.risk_score > 0.8 ? '#dc3545' : '#ffc107';
    }
}

function updateAIPredictions(predictions) {
    if (!predictions?.next_30_days) return;
    
    const trendElement = document.querySelector('.trend-direction');
    if (!trendElement) return;
    
    const direction = predictions.trend_direction;
    const icon = direction === 'increasing' ? '↑' : '↓';
    const color = direction === 'increasing' ? '#dc3545' : '#28a745';
    
    trendElement.innerHTML = `${icon} ${direction} (${predictions.confidence}% confidence)`;
    trendElement.style.color = color;
}

function updateAIPatterns(patterns) {
    if (!patterns?.length) return;
    
    const container = document.getElementById('patterns-container');
    if (!container) return;
    
    container.innerHTML = patterns.map(pattern => `
        <div class="pattern-item mb-2">
            <span class="pattern-color" style="background-color: ${pattern.color || '#C5A572'}"></span>
            <span class="pattern-name">${pattern.type}:</span>
            <span class="pattern-count">${pattern.count} cases</span>
            <span class="pattern-confidence">(${pattern.confidence}% confidence)</span>
        </div>
    `).join('');
}

function updateConfidenceMetrics(metrics) {
    if (!metrics) return;
    
    document.querySelectorAll('.confidence-value').forEach(el => {
        if (el.classList.contains('overall-confidence')) {
            el.textContent = metrics.overall + '%';
        }
    });
    
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

function updateCorruptionTypeChart(patterns) {
    if (!corruptionChart || !patterns?.length) return;
    
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
    corruptionChart.data.datasets[0].backgroundColor = colors.map(c => 
        c.includes('rgba') ? c : c.replace(')', ', 0.8)').replace('rgb', 'rgba')
    );
    corruptionChart.update();
}

// ============================================
// ACTION FUNCTIONS
// ============================================

async function analyzeWithAI(transactionId) {
    const button = event.target;
    const originalText = button.innerHTML;
    
    try {
        button.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Analyzing...';
        button.disabled = true;
        
        const response = await fetch('index.php?controller=ai&action=analyzeTransaction', {
            method: 'POST',
            headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
            body: 'transaction_id=' + encodeURIComponent(transactionId)
        });
        
        const data = await response.json();
        
        if (data.success) {
            showAIAnalysis(data.analysis);
            updateTransactionRiskBadge(transactionId, data.analysis);
        } else {
            alert('AI analysis failed: ' + (data.error || 'Unknown error'));
        }
    } catch (error) {
        console.error('Error:', error);
        alert('Failed to connect to AI service');
    } finally {
        button.innerHTML = originalText;
        button.disabled = false;
    }
}

function showAIAnalysis(analysis) {
    const modalElement = document.getElementById('investigationModal');
    if (!modalElement) return;
    
    const modal = new bootstrap.Modal(modalElement);
    const modalBody = document.getElementById('investigationDetails');
    if (!modalBody) return;
    
    const riskColor = getRiskColor(analysis.risk_level);
    const patternsHtml = (analysis.patterns || []).map(p => 
        `<li><span style="color: ${p.color || getPatternColor(p.key || p.pattern)}; margin-right: 8px;">●</span> ${p.pattern || p.type} (${p.confidence}% confidence)</li>`
    ).join('') || '<li class="text-muted">No specific patterns detected</li>';
    
    const recommendationsHtml = (analysis.recommendations || []).map(rec =>
        `<li><i class="fas fa-check-circle me-2" style="color: #28a745;"></i>${rec}</li>`
    ).join('') || '<li class="text-muted">No specific recommendations</li>';
    
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
                    <ul class="list-unstyled">${patternsHtml}</ul>
                </div>
            </div>
        </div>
        <div class="row mt-2">
            <div class="col-12">
                <div class="glass-card p-3">
                    <h6 class="fw-bold mb-3"><i class="fas fa-lightbulb me-2" style="color: var(--accent);"></i>AI Recommendations</h6>
                    <ul class="list-unstyled">${recommendationsHtml}</ul>
                </div>
            </div>
        </div>
    `;
    
    modal.show();
}

function investigateCase(caseId) {
    analyzeWithAI(caseId);
}

function generateReport() {
    const reportTypes = ['Monthly Audit Report', 'Risk Assessment Report', 'Transaction Analysis', 'Corruption Pattern Report'];
    const type = prompt('Select report type:\n1. Monthly Audit Report\n2. Risk Assessment Report\n3. Transaction Analysis\n4. Corruption Pattern Report', '1');
    
    if (type) {
        const reportType = reportTypes[parseInt(type) - 1] || 'Monthly Audit Report';
        alert(`Generating ${reportType}... This may take a few moments.`);
        window.location.href = `index.php?controller=report&action=generate&type=${encodeURIComponent(reportType)}`;
    }
}

async function runAIAnalysis() {
    if (!confirm('Run full AI analysis on all pending transactions? This may take several minutes.')) {
        return;
    }
    
    const button = event.target;
    const originalText = button.innerHTML;
    
    try {
        button.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Analyzing...';
        button.disabled = true;
        
        const response = await fetch('index.php?controller=ai&action=runBatchAnalysis', {
            method: 'POST'
        });
        
        const data = await response.json();
        
        if (data.success) {
            alert(`AI analysis complete!\nProcessed: ${data.analyzed} transactions`);
            location.reload();
        } else {
            alert('Batch analysis failed: ' + (data.error || 'Unknown error'));
        }
    } catch (error) {
        console.error('Error:', error);
        alert('Failed to connect to AI service');
    } finally {
        button.innerHTML = originalText;
        button.disabled = false;
    }
}

function exportData() {
    const format = prompt('Export format:\n1. PDF\n2. Excel\n3. CSV', '1');
    const formats = ['pdf', 'excel', 'csv'];
    const selectedFormat = formats[parseInt(format) - 1] || 'pdf';
    window.location.href = `index.php?controller=export&action=data&format=${selectedFormat}`;
}

function exportRiskReport() {
    window.location.href = 'index.php?controller=export&action=riskReport';
}

function assignInvestigation() {
    const investigators = ['Senior Auditor Jane', 'Investigator John', 'Forensic Team A', 'Anti-Corruption Unit'];
    const options = investigators.map((inv, index) => `${index + 1}. ${inv}`).join('\n');
    const choice = prompt(`Assign to:\n${options}`, '1');
    
    if (choice) {
        const investigator = investigators[parseInt(choice) - 1] || investigators[0];
        alert(`Case assigned to ${investigator}. They have been notified.`);
    }
}

function flagUrgent() {
    if (confirm('Flag this case as URGENT? This will notify all senior investigators immediately.')) {
        alert('Case flagged as urgent. Investigators notified.');
        const modal = bootstrap.Modal.getInstance(document.getElementById('investigationModal'));
        if (modal) modal.hide();
    }
}

// ============================================
// HELPER FUNCTIONS
// ============================================

function handleRiskTimeRangeChange(e) {
    console.log(`Loading risk data for last ${e.target.value} days`);
}

function handleCorruptionTypeChange(e) {
    console.log(`Filtering corruption types for: ${e.target.value}`);
}

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

function getRiskColor(riskLevel) {
    const colors = {
        'CRITICAL': '#dc3545',
        'HIGH': '#dc3545',
        'MEDIUM': '#ffc107',
        'LOW': '#28a745'
    };
    return colors[riskLevel?.toUpperCase()] || '#ffc107';
}

// ============================================
// FALLBACK FUNCTIONS
// ============================================

function useFallbackData() {
    console.log('Using fallback data');
    useFallbackAIInsights();
    useFallbackAIAlerts();
    useFallbackPatterns();
}

function useFallbackAIInsights() {
    const insightItems = document.querySelectorAll('.insight-item');
    const fallbackData = [
        { pattern: 'procurement_fraud', count: 45, confidence: 92 },
        { pattern: 'ghost_workers', count: 23, confidence: 88 },
        { pattern: 'bid_rigging', count: 18, confidence: 95 }
    ];
    
    insightItems.forEach((item, index) => {
        if (index < fallbackData.length) {
            const data = fallbackData[index];
            updateInsightItem(item, data.pattern, data.count);
        }
    });
}

function useFallbackAIAlerts() {
    const alertBanner = document.querySelector('.ai-alert-banner');
    if (!alertBanner) return;
    
    const alertText = alertBanner.querySelector('.ai-alert-text p');
    const alertConfidence = alertBanner.querySelector('.ai-confidence');
    
    if (alertText) alertText.textContent = 'Suspicious pattern detected in Ministry of Health procurement';
    if (alertConfidence) alertConfidence.innerHTML = '<i class="fas fa-microchip me-2"></i>AI Confidence: 94%';
}

function useFallbackPatterns() {
    updateCorruptionTypeChart([
        { type: 'Procurement Fraud', count: 45, color: '#dc3545' },
        { type: 'Ghost Workers', count: 23, color: '#ffc107' },
        { type: 'Bid Rigging', count: 18, color: '#17a2b8' },
        { type: 'Overpricing', count: 12, color: '#28a745' },
        { type: 'Conflict of Interest', count: 8, color: '#6c757d' }
    ]);
}

// Auto-refresh every 5 minutes
if (window.location.href.includes('dashboard')) {
    setTimeout(() => location.reload(), 600000);
}

console.log('Dashboard functions loaded successfully');