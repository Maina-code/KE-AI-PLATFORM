# ai_service/app.py
from flask import Flask, request, jsonify
from flask_cors import CORS
import numpy as np
import pandas as pd
from sklearn.ensemble import IsolationForest, RandomForestClassifier
import joblib
import logging
from datetime import datetime
import json

app = Flask(__name__)
CORS(app, origins=['https://auditor.gok.ke'])

# Configure logging
logging.basicConfig(level=logging.INFO)
logger = logging.getLogger(__name__)

# Load models
try:
    model = joblib.load('models/corruption_model.pkl')
    scaler = joblib.load('models/scaler.pkl')
    logger.info("Models loaded successfully")
except:
    logger.warning("No pre-trained models found, using fallback")
    model = None
    scaler = None

class CorruptionAnalyzer:
    def __init__(self):
        self.patterns = self.load_patterns()
        
    def load_patterns(self):
        return {
            'bid_rigging': {
                'indicators': ['single_bidder', 'identical_docs', 'similar_ips', 'price_fixing'],
                'weight': 0.9
            },
            'ghost_workers': {
                'indicators': ['duplicate_ids', 'no_attendance', 'bank_mismatch', 'same_account'],
                'weight': 0.85
            },
            'overpricing': {
                'indicators': ['above_market', 'no_competition', 'sole_source', 'emergency'],
                'weight': 0.8
            },
            'conflict_of_interest': {
                'indicators': ['family_connection', 'political_ties', 'former_official'],
                'weight': 0.95
            },
            'shell_company': {
                'indicators': ['new_registration', 'no_address', 'nominee_director', 'offshore'],
                'weight': 0.88
            }
        }
    
    def analyze(self, transaction):
        """Main analysis function"""
        features = self.extract_features(transaction)
        
        # Get ML prediction if model exists
        if model and scaler:
            features_scaled = scaler.transform([features])
            risk_score = model.predict_proba(features_scaled)[0][1]
            confidence = float(np.max(model.predict_proba(features_scaled)[0]))
        else:
            # Rule-based fallback
            risk_score = self.rule_based_score(transaction)
            confidence = 0.7
        
        # Detect patterns
        patterns = self.detect_patterns(transaction)
        
        # Generate recommendations
        recommendations = self.generate_recommendations(patterns, risk_score)
        
        return {
            'risk_score': float(risk_score),
            'confidence': float(confidence),
            'patterns_detected': patterns,
            'recommendations': recommendations,
            'risk_level': self.get_risk_level(risk_score),
            'timestamp': datetime.now().isoformat()
        }
    
    def extract_features(self, transaction):
        """Extract numerical features"""
        features = [
            transaction.get('amount', 0) / 1e6,  # Normalize
            transaction.get('supplier_age_days', 0) / 365,  # Years
            transaction.get('num_bidders', 0) / 10,  # Normalize
            transaction.get('price_variance', 0),
            float(transaction.get('single_source', False)),
            float(transaction.get('emergency', False)),
            transaction.get('department_risk', 0.5),
            transaction.get('supplier_risk', 0.5)
        ]
        return features
    
    def detect_patterns(self, transaction):
        """Detect specific corruption patterns"""
        detected = []
        
        for pattern_name, pattern_info in self.patterns.items():
            match_score = 0
            indicators_found = []
            
            for indicator in pattern_info['indicators']:
                if indicator in transaction and transaction[indicator]:
                    match_score += 1
                    indicators_found.append(indicator)
            
            if match_score > 0:
                match_percentage = (match_score / len(pattern_info['indicators'])) * 100
                confidence = min(100, match_percentage * pattern_info['weight'])
                
                if confidence > 30:  # Threshold
                    detected.append({
                        'pattern': pattern_name,
                        'confidence': round(confidence, 1),
                        'indicators': indicators_found,
                        'match_percentage': round(match_percentage, 1)
                    })
        
        return detected
    
    def rule_based_score(self, transaction):
        """Fallback rule-based scoring"""
        score = 0.5  # Base score
        
        # High amount
        if transaction.get('amount', 0) > 10000000:
            score += 0.1
        
        # Single source
        if transaction.get('single_source', False):
            score += 0.15
        
        # New supplier
        if transaction.get('supplier_age_days', 365) < 90:
            score += 0.1
        
        # Emergency procurement
        if transaction.get('emergency', False):
            score += 0.1
        
        # No competition
        if transaction.get('num_bidders', 3) < 2:
            score += 0.15
        
        return min(1.0, score)
    
    def get_risk_level(self, score):
        if score >= 0.8:
            return 'CRITICAL'
        elif score >= 0.6:
            return 'HIGH'
        elif score >= 0.4:
            return 'MEDIUM'
        elif score >= 0.2:
            return 'LOW'
        return 'MINIMAL'
    
    def generate_recommendations(self, patterns, risk_score):
        """Generate actionable recommendations"""
        recommendations = []
        
        if risk_score >= 0.8:
            recommendations.append("IMMEDIATE ACTION: Suspend transaction and initiate forensic audit")
        
        for pattern in patterns:
            if pattern['pattern'] == 'bid_rigging':
                recommendations.append("Review all bidding documents for collusion indicators")
                recommendations.append("Check relationships between bidders")
                recommendations.append("Verify bid bond authenticity")
            
            elif pattern['pattern'] == 'ghost_workers':
                recommendations.append("Conduct physical headcount of staff")
                recommendations.append("Cross-reference with attendance records")
                recommendations.append("Verify bank accounts for duplicate payroll")
            
            elif pattern['pattern'] == 'overpricing':
                recommendations.append("Compare with market rates from 3 independent sources")
                recommendations.append("Review justification for premium pricing")
                recommendations.append("Check if competitive bidding was bypassed")
            
            elif pattern['pattern'] == 'conflict_of_interest':
                recommendations.append("Verify declarations of interest from all officers")
                recommendations.append("Check family relationships with supplier")
                recommendations.append("Review approval chain for independence")
            
            elif pattern['pattern'] == 'shell_company':
                recommendations.append("Verify physical address and operations")
                recommendations.append("Check company registration history")
                recommendations.append("Identify beneficial owners")
        
        return list(set(recommendations))[:5]  # Return top 5 unique

analyzer = CorruptionAnalyzer()

@app.route('/api/predict', methods=['POST'])
def predict():
    """Main prediction endpoint"""
    try:
        data = request.json
        transaction = data.get('transaction', {})
        
        result = analyzer.analyze(transaction)
        
        logger.info(f"Analysis completed for transaction: {transaction.get('id', 'unknown')}")
        
        return jsonify({
            'success': True,
            'data': result
        })
        
    except Exception as e:
        logger.error(f"Analysis failed: {str(e)}")
        return jsonify({
            'success': False,
            'error': str(e)
        }), 500

@app.route('/api/batch', methods=['POST'])
def batch_analyze():
    """Batch analysis endpoint"""
    try:
        data = request.json
        transactions = data.get('transactions', [])
        
        results = []
        for trans in transactions:
            results.append(analyzer.analyze(trans))
        
        return jsonify({
            'success': True,
            'data': results
        })
        
    except Exception as e:
        return jsonify({
            'success': False,
            'error': str(e)
        }), 500

@app.route('/api/health', methods=['GET'])
def health():
    """Health check endpoint"""
    return jsonify({
        'status': 'healthy',
        'timestamp': datetime.now().isoformat(),
        'model_loaded': model is not None
    })

if __name__ == '__main__':
    app.run(host='0.0.0.0', port=5000, ssl_context=('cert.pem', 'key.pem'))