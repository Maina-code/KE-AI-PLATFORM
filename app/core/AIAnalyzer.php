<?php
class AIAnalyzer {
    
    private $pythonScript = __DIR__ . '/../../scripts/ai_analyzer.py';
    
    public function analyzeTransaction($transactionId, $transactionData) {
        // Prepare data for AI
        $data = [
            'id' => $transactionId,
            'amount' => $transactionData['amount'],
            'procurement_type' => $transactionData['procurement_type'],
            'bidder_count' => $transactionData['bidder_count'],
            'department' => $transactionData['department'],
            'supplier_age_days' => $transactionData['supplier_age_days'] ?? 365
        ];
        
        // Save data to temp file
        $inputFile = tempnam(sys_get_temp_dir(), 'ai_input_');
        $outputFile = tempnam(sys_get_temp_dir(), 'ai_output_');
        
        file_put_contents($inputFile, json_encode($data));
        
        // Call Python script
        $command = sprintf(
            'python3 %s --input %s --output %s 2>&1',
            escapeshellarg($this->pythonScript),
            escapeshellarg($inputFile),
            escapeshellarg($outputFile)
        );
        
        exec($command, $output, $returnCode);
        
        // Read result
        if ($returnCode === 0 && file_exists($outputFile)) {
            $result = json_decode(file_get_contents($outputFile), true);
            unlink($inputFile);
            unlink($outputFile);
            return $result;
        }
        
        // Fallback to simple rules
        return $this->ruleBasedAnalysis($data);
    }
    
    private function ruleBasedAnalysis($data) {
        $riskScore = 0.3; // Base score
        $flags = [];
        
        // Single source procurement
        if ($data['procurement_type'] === 'single') {
            $riskScore += 0.3;
            $flags[] = 'Single source procurement';
        }
        
        // High amount (> 10M)
        if ($data['amount'] > 10000000) {
            $riskScore += 0.2;
            $flags[] = 'High value transaction';
        }
        
        // Few bidders
        if ($data['bidder_count'] < 3) {
            $riskScore += 0.2;
            $flags[] = 'Insufficient competition';
        }
        
        // New supplier
        if ($data['supplier_age_days'] < 90) {
            $riskScore += 0.15;
            $flags[] = 'New supplier';
        }
        
        // Cap at 1.0
        $riskScore = min(1.0, $riskScore);
        
        return [
            'risk_score' => round($riskScore, 2),
            'confidence' => 70,
            'flags' => $flags,
            'recommendations' => $this->getRecommendations($riskScore, $flags),
            'risk_level' => $this->getRiskLevel($riskScore)
        ];
    }
    
    private function getRecommendations($riskScore, $flags) {
        $recs = [];
        
        if ($riskScore > 0.7) {
            $recs[] = "Immediate audit required";
            $recs[] = "Suspend payment pending investigation";
        }
        
        if (in_array('Single source procurement', $flags)) {
            $recs[] = "Verify justification for single sourcing";
        }
        
        if (in_array('Insufficient competition', $flags)) {
            $recs[] = "Review bidding process";
        }
        
        if (in_array('New supplier', $flags)) {
            $recs[] = "Verify supplier registration and physical address";
        }
        
        return implode('. ', $recs);
    }
    
    private function getRiskLevel($score) {
        if ($score >= 0.7) return 'HIGH';
        if ($score >= 0.4) return 'MEDIUM';
        return 'LOW';
    }
}