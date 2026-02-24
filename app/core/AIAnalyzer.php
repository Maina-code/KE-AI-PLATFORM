<?php
/**
 * AI Analyzer Class - Core AI functionality
 */
class AIAnalyzer {
    
    private $pythonScript = __DIR__ . '/../../scripts/ai_analyzer.py';
    private $patterns = [];
    private $riskThresholds = [
        'critical' => 0.8,
        'high' => 0.6,
        'medium' => 0.4,
        'low' => 0.2
    ];
    
    public function __construct() {
        $this->loadPatterns();
    }
    
    /**
     * Load corruption patterns from database or config
     */
    private function loadPatterns() {
        $this->patterns = [
            'procurement_fraud' => [
                'name' => 'Procurement Fraud',
                'indicators' => ['single_source', 'above_market', 'new_supplier', 'emergency'],
                'weight' => 0.9,
                'color' => '#dc3545'
            ],
            'ghost_workers' => [
                'name' => 'Ghost Workers',
                'indicators' => ['duplicate_payments', 'no_attendance', 'same_bank'],
                'weight' => 0.85,
                'color' => '#ffc107'
            ],
            'bid_rigging' => [
                'name' => 'Bid Rigging',
                'indicators' => ['same_ip', 'similar_docs', 'rotating_winners'],
                'weight' => 0.88,
                'color' => '#17a2b8'
            ],
            'overpricing' => [
                'name' => 'Overpricing',
                'indicators' => ['above_market_50', 'no_competition', 'sole_source'],
                'weight' => 0.82,
                'color' => '#28a745'
            ],
            'conflict_of_interest' => [
                'name' => 'Conflict of Interest',
                'indicators' => ['family_connection', 'former_official', 'political_ties'],
                'weight' => 0.95,
                'color' => '#6c757d'
            ]
        ];
    }
    
    /**
     * Analyze a single transaction
     */
    public function analyzeTransaction($transaction) {
        // Extract features
        $features = $this->extractFeatures($transaction);
        
        // Calculate risk score
        $riskScore = $this->calculateRiskScore($features);
        
        // Detect patterns
        $detectedPatterns = $this->detectPatterns($features);
        
        // Calculate confidence
        $confidence = $this->calculateConfidence($features, $detectedPatterns);
        
        // Generate recommendations
        $recommendations = $this->generateRecommendations($detectedPatterns, $riskScore);
        
        return [
            'risk_score' => round($riskScore, 2),
            'risk_level' => $this->getRiskLevel($riskScore),
            'confidence' => round($confidence, 1),
            'patterns' => $detectedPatterns,
            'recommendations' => $recommendations,
            'flags' => $this->generateFlags($detectedPatterns),
            'timestamp' => date('Y-m-d H:i:s')
        ];
    }
    
    /**
     * Analyze multiple transactions
     */
    public function analyzeBatch($transactions) {
        $results = [];
        $totalRisk = 0;
        $patternCounts = [];
        
        foreach ($transactions as $transaction) {
            $analysis = $this->analyzeTransaction($transaction);
            $results[] = $analysis;
            $totalRisk += $analysis['risk_score'];
            
            foreach ($analysis['patterns'] as $pattern) {
                $patternName = $pattern['pattern'];
                if (!isset($patternCounts[$patternName])) {
                    $patternCounts[$patternName] = 0;
                }
                $patternCounts[$patternName]++;
            }
        }
        
        // Calculate aggregate insights
        $avgRisk = count($transactions) > 0 ? $totalRisk / count($transactions) : 0;
        
        // Get top patterns
        arsort($patternCounts);
        $topPatterns = array_slice($patternCounts, 0, 3, true);
        
        return [
            'total_analyzed' => count($transactions),
            'average_risk' => round($avgRisk, 2),
            'high_risk_count' => count(array_filter($results, fn($r) => $r['risk_level'] === 'HIGH' || $r['risk_level'] === 'CRITICAL')),
            'top_patterns' => $topPatterns,
            'results' => $results
        ];
    }
    
    /**
     * Get high priority alerts
     */
    public function getHighPriorityAlerts() {
        $db = Database::getInstance();
        
        // Get recent high-risk transactions
        $query = "SELECT t.*, d.name as department_name 
                  FROM transactions t
                  JOIN departments d ON t.department_id = d.id
                  WHERE t.risk_score >= 0.7 
                  AND t.created_at >= DATE_SUB(NOW(), INTERVAL 7 DAY)
                  ORDER BY t.risk_score DESC
                  LIMIT 5";
        
        $stmt = $db->query($query);
        $transactions = $stmt->fetchAll();
        
        $alerts = [];
        foreach ($transactions as $trans) {
            $alerts[] = [
                'id' => $trans['id'],
                'message' => "High-risk transaction detected in {$trans['department_name']}: {$trans['description']}",
                'confidence' => round($trans['risk_score'] * 100),
                'risk_score' => $trans['risk_score'],
                'amount' => $trans['amount'],
                'date' => $trans['created_at']
            ];
        }
        
        return $alerts;
    }
    
    /**
     * Predict future trends
     */
    public function predictTrends() {
        $db = Database::getInstance();
        
        // Get historical data
        $query = "SELECT DATE(created_at) as date, AVG(risk_score) as avg_risk
                  FROM transactions
                  WHERE created_at >= DATE_SUB(NOW(), INTERVAL 90 DAY)
                  GROUP BY DATE(created_at)
                  ORDER BY date";
        
        $stmt = $db->query($query);
        $history = $stmt->fetchAll();
        
        // Simple linear regression for prediction
        $dates = [];
        $risks = [];
        foreach ($history as $row) {
            $dates[] = strtotime($row['date']);
            $risks[] = $row['avg_risk'];
        }
        
        // Predict next 30 days
        $predictions = [];
        if (count($risks) > 0) {
            $lastDate = end($dates);
            $lastRisk = end($risks);
            $trend = $this->calculateTrend($risks);
            
            for ($i = 1; $i <= 30; $i++) {
                $predictedDate = date('Y-m-d', strtotime("+$i days", $lastDate));
                $predictedRisk = $lastRisk + ($trend * $i);
                $predictions[] = [
                    'date' => $predictedDate,
                    'predicted_risk' => round(min(1, max(0, $predictedRisk)), 2)
                ];
            }
        }
        
        return [
            'next_30_days' => $predictions,
            'trend_direction' => $trend > 0 ? 'increasing' : 'decreasing',
            'confidence' => 85 // confidence in prediction
        ];
    }
    
    /**
     * Get detected patterns summary
     */
    public function getDetectedPatterns() {
        $db = Database::getInstance();
        
        $query = "SELECT pattern_type, COUNT(*) as count, AVG(confidence) as avg_confidence
                  FROM ai_detections
                  WHERE created_at >= DATE_SUB(NOW(), INTERVAL 30 DAY)
                  GROUP BY pattern_type
                  ORDER BY count DESC";
        
        $stmt = $db->query($query);
        $results = $stmt->fetchAll();
        
        $patterns = [];
        foreach ($results as $row) {
            $patterns[] = [
                'type' => $row['pattern_type'],
                'count' => $row['count'],
                'confidence' => round($row['avg_confidence'], 1),
                'color' => $this->patterns[$row['pattern_type']]['color'] ?? '#C5A572'
            ];
        }
        
        return $patterns;
    }
    
    /**
     * Get confidence metrics
     */
    public function getConfidenceMetrics() {
        $db = Database::getInstance();
        
        $query = "SELECT 
                    AVG(confidence) as overall_confidence,
                    COUNT(CASE WHEN confidence >= 90 THEN 1 END) as high_confidence_count,
                    COUNT(CASE WHEN confidence BETWEEN 70 AND 89 THEN 1 END) as medium_confidence_count,
                    COUNT(CASE WHEN confidence < 70 THEN 1 END) as low_confidence_count
                  FROM ai_detections
                  WHERE created_at >= DATE_SUB(NOW(), INTERVAL 30 DAY)";
        
        $stmt = $db->query($query);
        $metrics = $stmt->fetch();
        
        return [
            'overall' => round($metrics['overall_confidence'] ?? 85, 1),
            'high_confidence' => $metrics['high_confidence_count'] ?? 0,
            'medium_confidence' => $metrics['medium_confidence_count'] ?? 0,
            'low_confidence' => $metrics['low_confidence_count'] ?? 0,
            'last_updated' => date('Y-m-d H:i:s')
        ];
    }
    
    /**
     * Extract features from transaction
     */
    private function extractFeatures($transaction) {
        return [
            'amount' => $transaction['amount'] ?? 0,
            'procurement_type' => $transaction['procurement_type'] ?? 'open',
            'bidder_count' => $transaction['bidder_count'] ?? 1,
            'supplier_age' => $this->calculateSupplierAge($transaction['supplier_created_at'] ?? null),
            'is_emergency' => $transaction['is_emergency'] ?? false,
            'department_risk' => $transaction['department_risk'] ?? 0.5,
            'supplier_risk' => $transaction['supplier_risk'] ?? 0.5,
            'previous_violations' => $transaction['previous_violations'] ?? 0
        ];
    }
    
    /**
     * Calculate supplier age in days
     */
    private function calculateSupplierAge($createdAt) {
        if (!$createdAt) return 365; // Default to 1 year
        
        $created = new DateTime($createdAt);
        $now = new DateTime();
        return $now->diff($created)->days;
    }
    
    /**
     * Calculate risk score based on features
     */
    private function calculateRiskScore($features) {
        $score = 0.3; // Base score
        
        // Single source procurement
        if ($features['procurement_type'] === 'single') {
            $score += 0.25;
        } elseif ($features['procurement_type'] === 'restricted') {
            $score += 0.15;
        }
        
        // High amount
        if ($features['amount'] > 50000000) {
            $score += 0.2;
        } elseif ($features['amount'] > 10000000) {
            $score += 0.1;
        }
        
        // Low competition
        if ($features['bidder_count'] == 1) {
            $score += 0.2;
        } elseif ($features['bidder_count'] < 3) {
            $score += 0.1;
        }
        
        // New supplier
        if ($features['supplier_age'] < 30) {
            $score += 0.15;
        } elseif ($features['supplier_age'] < 90) {
            $score += 0.1;
        }
        
        // Emergency procurement
        if ($features['is_emergency']) {
            $score += 0.1;
        }
        
        // Department and supplier risk
        $score += $features['department_risk'] * 0.1;
        $score += $features['supplier_risk'] * 0.1;
        
        // Previous violations
        $score += min(0.2, $features['previous_violations'] * 0.05);
        
        return min(1.0, $score);
    }
    
    /**
     * Detect specific corruption patterns
     */
    private function detectPatterns($features) {
        $detected = [];
        
        // Check each pattern type
        foreach ($this->patterns as $key => $pattern) {
            $matchCount = 0;
            $indicatorsFound = [];
            
            foreach ($pattern['indicators'] as $indicator) {
                if ($this->checkIndicator($indicator, $features)) {
                    $matchCount++;
                    $indicatorsFound[] = $indicator;
                }
            }
            
            if ($matchCount > 0) {
                $matchPercentage = ($matchCount / count($pattern['indicators'])) * 100;
                $confidence = min(100, $matchPercentage * $pattern['weight']);
                
                if ($confidence > 30) { // Threshold
                    $detected[] = [
                        'pattern' => $pattern['name'],
                        'key' => $key,
                        'confidence' => round($confidence, 1),
                        'indicators' => $indicatorsFound,
                        'match_percentage' => round($matchPercentage, 1),
                        'color' => $pattern['color']
                    ];
                }
            }
        }
        
        return $detected;
    }
    
    /**
     * Check individual indicator
     */
    private function checkIndicator($indicator, $features) {
        switch ($indicator) {
            case 'single_source':
                return $features['procurement_type'] === 'single';
            case 'above_market':
                return $features['amount'] > 10000000; // Simplified
            case 'new_supplier':
                return $features['supplier_age'] < 30;
            case 'emergency':
                return $features['is_emergency'];
            case 'no_competition':
                return $features['bidder_count'] < 3;
            case 'above_market_50':
                return $features['amount'] > 50000000;
            default:
                return false;
        }
    }
    
    /**
     * Calculate confidence in analysis
     */
    private function calculateConfidence($features, $patterns) {
        $baseConfidence = 70; // Base confidence
        
        // More data = higher confidence
        if ($features['amount'] > 0) $baseConfidence += 5;
        if ($features['bidder_count'] > 0) $baseConfidence += 5;
        if ($features['supplier_age'] > 0) $baseConfidence += 5;
        
        // Patterns increase confidence
        $baseConfidence += count($patterns) * 5;
        
        // Cap at 98%
        return min(98, $baseConfidence);
    }
    
    /**
     * Generate recommendations based on patterns
     */
    private function generateRecommendations($patterns, $riskScore) {
        $recommendations = [];
        
        if ($riskScore >= 0.8) {
            $recommendations[] = "🚨 IMMEDIATE ACTION: Suspend payment and initiate forensic audit";
        }
        
        foreach ($patterns as $pattern) {
            switch ($pattern['key']) {
                case 'procurement_fraud':
                    $recommendations[] = "Review procurement documents and verify supplier registration";
                    $recommendations[] = "Check for collusion between procurement officers and supplier";
                    break;
                case 'ghost_workers':
                    $recommendations[] = "Conduct physical verification of employees";
                    $recommendations[] = "Cross-reference payroll with attendance records";
                    break;
                case 'bid_rigging':
                    $recommendations[] = "Investigate relationship between bidders";
                    $recommendations[] = "Check IP addresses and document metadata";
                    break;
                case 'overpricing':
                    $recommendations[] = "Compare with market rates from 3 independent sources";
                    $recommendations[] = "Review justification for premium pricing";
                    break;
                case 'conflict_of_interest':
                    $recommendations[] = "Verify declarations of interest from all officers";
                    $recommendations[] = "Check family relationships with supplier directors";
                    break;
            }
        }
        
        if (empty($recommendations)) {
            $recommendations[] = "Routine monitoring recommended";
        }
        
        return array_slice(array_unique($recommendations), 0, 3);
    }
    
    /**
     * Generate flags from patterns
     */
    private function generateFlags($patterns) {
        $flags = [];
        foreach ($patterns as $pattern) {
            $flags[] = $pattern['pattern'] . ' (' . $pattern['confidence'] . '% confidence)';
        }
        return implode('; ', $flags);
    }
    
    /**
     * Get risk level from score
     */
    private function getRiskLevel($score) {
        if ($score >= 0.8) return 'CRITICAL';
        if ($score >= 0.6) return 'HIGH';
        if ($score >= 0.4) return 'MEDIUM';
        if ($score >= 0.2) return 'LOW';
        return 'MINIMAL';
    }
    
    /**
     * Calculate trend from historical data
     */
    private function calculateTrend($data) {
        if (count($data) < 2) return 0;
        
        $n = count($data);
        $x = range(1, $n);
        $xMean = array_sum($x) / $n;
        $yMean = array_sum($data) / $n;
        
        $numerator = 0;
        $denominator = 0;
        
        for ($i = 0; $i < $n; $i++) {
            $numerator += ($x[$i] - $xMean) * ($data[$i] - $yMean);
            $denominator += pow($x[$i] - $xMean, 2);
        }
        
        return $denominator != 0 ? $numerator / $denominator : 0;
    }
}