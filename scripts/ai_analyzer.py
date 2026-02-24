import sys
import json
import argparse
import random
import math
from datetime import datetime

def analyze_transaction(transaction_data):
    """
    Analyze transaction for corruption indicators
    """
    # Extract features
    amount = transaction_data.get('amount', 0)
    proc_type = transaction_data.get('procurement_type', 'open')
    bidder_count = transaction_data.get('bidder_count', 1)
    supplier_age = transaction_data.get('supplier_age_days', 365)
    department = transaction_data.get('department', '')
    
    # Risk factors
    risk_factors = []
    
    # Factor 1: Procurement type
    if proc_type == 'single':
        risk_factors.append(('procurement_type', 0.8))
    elif proc_type == 'restricted':
        risk_factors.append(('procurement_type', 0.4))
    else:
        risk_factors.append(('procurement_type', 0.2))
    
    # Factor 2: Amount (higher = more risk)
    if amount > 50000000:  # > 50M
        risk_factors.append(('amount', 0.9))
    elif amount > 10000000:  # > 10M
        risk_factors.append(('amount', 0.6))
    elif amount > 1000000:  # > 1M
        risk_factors.append(('amount', 0.3))
    else:
        risk_factors.append(('amount', 0.1))
    
    # Factor 3: Competition
    if bidder_count == 1:
        risk_factors.append(('competition', 0.9))
    elif bidder_count < 3:
        risk_factors.append(('competition', 0.6))
    elif bidder_count < 5:
        risk_factors.append(('competition', 0.3))
    else:
        risk_factors.append(('competition', 0.1))
    
    # Factor 4: Supplier age
    if supplier_age < 30:  # Less than 1 month
        risk_factors.append(('supplier_age', 0.8))
    elif supplier_age < 90:  # Less than 3 months
        risk_factors.append(('supplier_age', 0.5))
    elif supplier_age < 365:  # Less than 1 year
        risk_factors.append(('supplier_age', 0.2))
    else:
        risk_factors.append(('supplier_age', 0.1))
    
    # Calculate weighted risk score
    weights = {
        'procurement_type': 0.35,
        'amount': 0.30,
        'competition': 0.25,
        'supplier_age': 0.10
    }
    
    risk_score = sum(score * weights[factor] for factor, score in risk_factors)
    
    # Determine flags
    flags = []
    if proc_type == 'single' and amount > 10000000:
        flags.append("High value single source procurement")
    if bidder_count == 1:
        flags.append("No competitive bidding")
    if supplier_age < 30:
        flags.append("Very new supplier")
    if amount > 50000000:
        flags.append("Exceptionally high amount")
    
    # Generate recommendations
    recommendations = []
    if risk_score > 0.7:
        recommendations.append("IMMEDIATE: Suspend payment and initiate forensic audit")
        recommendations.append("Verify all procurement documents and approvals")
        recommendations.append("Check supplier registration and directors")
    elif risk_score > 0.4:
        recommendations.append("Request additional documentation and justification")
        recommendations.append("Review bidding process and market rates")
        recommendations.append("Verify supplier credentials")
    else:
        recommendations.append("Routine monitoring recommended")
    
    # Calculate confidence (based on data completeness)
    confidence = 85  # Base confidence
    
    return {
        'risk_score': round(risk_score, 2),
        'confidence': confidence,
        'flags': flags,
        'recommendations': '. '.join(recommendations),
        'risk_level': 'HIGH' if risk_score > 0.7 else 'MEDIUM' if risk_score > 0.4 else 'LOW',
        'analyzed_at': datetime.now().isoformat()
    }

if __name__ == "__main__":
    parser = argparse.ArgumentParser()
    parser.add_argument('--input', required=True, help='Input JSON file')
    parser.add_argument('--output', required=True, help='Output JSON file')
    
    args = parser.parse_args()
    
    try:
        # Read input
        with open(args.input, 'r') as f:
            transaction = json.load(f)
        
        # Analyze
        result = analyze_transaction(transaction)
        
        # Write output
        with open(args.output, 'w') as f:
            json.dump(result, f)
            
    except Exception as e:
        # Write error
        with open(args.output, 'w') as f:
            json.dump({'error': str(e)}, f)
        sys.exit(1)