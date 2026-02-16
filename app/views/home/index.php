<?php
 require_once '../layout/landingnavbar.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nuru AI - Intelligence Grade Fraud Detection Platform</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Poppins:wght@500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }


        body {
            font-family: 'Inter', sans-serif;
            background: linear-gradient(135deg, #0A0F1C 0%, #0A1929 50%, #0D2135 100%);
            color: var(--text-primary);
            line-height: 1.6;
            overflow-x: hidden;
            position: relative;
        }

        /* Ambient Background */
        .ambient-bg {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            z-index: -1;
            overflow: hidden;
        }

        .floating-shape {
            position: absolute;
            border-radius: 50%;
            filter: blur(80px);
            opacity: 0.15;
        }

        .shape-1 {
            width: 500px;
            height: 500px;
            background: var(--accent);
            top: -200px;
            right: -200px;
        }

        .shape-2 {
            width: 600px;
            height: 600px;
            background: var(--gold);
            bottom: -300px;
            left: -200px;
        }

        .shape-3 {
            width: 400px;
            height: 400px;
            background: #4A90E2;
            top: 50%;
            left: 30%;
        }


        /* Hero Section */
        .hero {
            padding: 160px 0 80px;
            min-height: 100vh;
            display: flex;
            align-items: center;
        }

        .hero-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 60px;
            align-items: center;
        }

        .hero-content {
            animation: fadeInUp 1s ease;
        }

        .hero-label {
            display: inline-block;
            padding: 8px 16px;
            background: rgba(0, 184, 169, 0.1);
            border: 1px solid rgba(0, 184, 169, 0.3);
            border-radius: 50px;
            color: var(--accent);
            font-size: 0.9rem;
            font-weight: 600;
            margin-bottom: 30px;
            backdrop-filter: blur(5px);
        }

        .hero-title {
            font-family: 'Poppins', sans-serif;
            font-size: 4rem;
            font-weight: 800;
            line-height: 1.2;
            margin-bottom: 30px;
            background: linear-gradient(135deg, #fff, #B0C4DE);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .hero-subtitle {
            font-size: 1.2rem;
            color: var(--text-secondary);
            margin-bottom: 40px;
            max-width: 600px;
        }

        .hero-cta {
            display: flex;
            gap: 20px;
        }

        .hero-visual {
            position: relative;
        }

        .mockup-container {
            position: relative;
            height: 500px;
        }

        .glass-card {
            background: rgba(30, 47, 74, 0.6);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 20px;
            padding: 30px;
            width: 100%;
            height: 100%;
            box-shadow: 0 20px 40px rgba(0,0,0,0.4);
        }

        .mockup-header {
            display: flex;
            gap: 10px;
            margin-bottom: 30px;
        }

        .dummy-bar {
            height: 12px;
            background: rgba(255,255,255,0.1);
            border-radius: 6px;
            margin-bottom: 15px;
        }

        .dummy-bar.sm { width: 60px; }
        .dummy-bar.md { width: 120px; }
        .dummy-bar.lg { width: 100%; }
        .dummy-bar.accent { background: var(--accent); }
        .dummy-bar.gold { background: var(--gold); }
        .dummy-bar.danger { background: var(--danger); }

        .mockup-float {
            position: absolute;
            bottom: 50px;
            right: -30px;
            background: var(--card-bg);
            backdrop-filter: blur(10px);
            border: 1px solid var(--glass-border);
            border-radius: 15px;
            padding: 20px;
            width: 200px;
            animation: float 6s ease-in-out infinite;
            box-shadow: 0 10px 30px rgba(0,0,0,0.3);
        }

        .stat-label {
            font-size: 0.9rem;
            color: var(--text-secondary);
        }

        .stat-val {
            font-size: 2rem;
            font-weight: 700;
            color: var(--danger);
        }

        /* Stats Strip */
        .stats-strip {
            padding: 40px 0;
            border-top: 1px solid rgba(255,255,255,0.05);
            border-bottom: 1px solid rgba(255,255,255,0.05);
            margin-bottom: 60px;
        }

        .stats-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 30px;
        }

        .stat-item {
            text-align: center;
        }

        .stat-number {
            font-size: 2.5rem;
            font-weight: 800;
            color: var(--accent);
            margin-bottom: 10px;
        }

        .stat-desc {
            color: var(--text-secondary);
            font-size: 0.9rem;
        }

        /* Section Styles */
        .section {
            padding: 80px 0;
        }

        .section-header {
            text-align: center;
            margin-bottom: 60px;
        }

        .section-title {
            font-family: 'Poppins', sans-serif;
            font-size: 2.5rem;
            font-weight: 700;
            margin-bottom: 20px;
            background: linear-gradient(135deg, #fff, var(--accent));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .section-desc {
            color: var(--text-secondary);
            font-size: 1.1rem;
            max-width: 800px;
            margin: 0 auto;
        }

        /* Agency Grid */
        .agency-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 30px;
            margin-top: 40px;
        }

        .agency-card {
            background: var(--card-bg);
            border: 1px solid var(--glass-border);
            border-radius: 15px;
            padding: 30px;
            text-align: center;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            backdrop-filter: blur(10px);
        }

        .agency-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 20px 40px rgba(0, 184, 169, 0.2);
            border-color: var(--accent);
        }

        .agency-icon {
            width: 80px;
            height: 80px;
            margin: 0 auto 20px;
            background: linear-gradient(135deg, var(--accent), #008B7A);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 2rem;
        }

        .agency-name {
            font-size: 1.2rem;
            font-weight: 600;
            margin-bottom: 10px;
        }

        .agency-desc {
            color: var(--text-secondary);
            font-size: 0.9rem;
        }

        /* Features Grid */
        .features-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 30px;
        }

        .feature-card {
            background: var(--card-bg);
            border: 1px solid var(--glass-border);
            border-radius: 15px;
            padding: 40px 30px;
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
        }

        .feature-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 4px;
            background: linear-gradient(90deg, var(--accent), var(--gold));
            transform: translateX(-100%);
            transition: transform 0.3s ease;
        }

        .feature-card:hover::before {
            transform: translateX(0);
        }

        .feature-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 30px rgba(0,0,0,0.3);
        }

        .feature-icon {
            font-size: 2.5rem;
            margin-bottom: 20px;
        }

        .feature-title {
            font-size: 1.3rem;
            font-weight: 600;
            margin-bottom: 15px;
        }

        .feature-desc {
            color: var(--text-secondary);
            font-size: 0.95rem;
        }

        /* Roadmap Timeline */
        .roadmap-timeline {
            position: relative;
            padding: 40px 0;
        }

        .roadmap-timeline::before {
            content: '';
            position: absolute;
            left: 50%;
            top: 0;
            width: 2px;
            height: 100%;
            background: linear-gradient(to bottom, transparent, var(--accent), transparent);
            transform: translateX(-50%);
        }

        .timeline-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 60px;
            position: relative;
        }

        .timeline-item:nth-child(even) {
            flex-direction: row-reverse;
        }

        .timeline-content {
            width: 45%;
            background: var(--card-bg);
            border: 1px solid var(--glass-border);
            border-radius: 15px;
            padding: 30px;
            backdrop-filter: blur(10px);
        }

        .timeline-week {
            display: inline-block;
            padding: 5px 15px;
            background: linear-gradient(135deg, var(--accent), #008B7A);
            border-radius: 50px;
            font-size: 0.9rem;
            font-weight: 600;
            margin-bottom: 15px;
        }

        .timeline-title {
            font-size: 1.3rem;
            font-weight: 600;
            margin-bottom: 15px;
        }

        .timeline-desc {
            color: var(--text-secondary);
            margin-bottom: 20px;
        }

        .timeline-deliverables {
            list-style: none;
        }

        .timeline-deliverables li {
            margin-bottom: 10px;
            display: flex;
            align-items: center;
            gap: 10px;
            color: var(--text-secondary);
        }

        .timeline-deliverables i {
            color: var(--accent);
        }

        .timeline-dot {
            width: 20px;
            height: 20px;
            background: var(--accent);
            border-radius: 50%;
            position: absolute;
            left: 50%;
            top: 50%;
            transform: translate(-50%, -50%);
            box-shadow: 0 0 30px var(--accent);
        }

        /* Impact Stats */
        .impact-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 30px;
            text-align: center;
        }

        .impact-number {
            font-size: 3rem;
            font-weight: 800;
            color: var(--gold);
            margin-bottom: 10px;
        }

        .impact-label {
            color: var(--text-secondary);
            font-size: 1rem;
        }

        /* CTA Section */
        .cta-section {
            padding: 120px 0;
            background: linear-gradient(135deg, rgba(0,184,169,0.1), rgba(255,179,71,0.1));
            text-align: center;
            border-radius: 30px;
            margin: 40px 20px;
        }

        .cta-title {
            font-size: 3rem;
            font-weight: 800;
            margin-bottom: 30px;
            background: linear-gradient(135deg, #fff, var(--gold));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .cta-buttons {
            display: flex;
            gap: 20px;
            justify-content: center;
        }

       /* Animations */
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes float {
            0%, 100% {
                transform: translateY(0);
            }
            50% {
                transform: translateY(-20px);
            }
        }

        .reveal {
            opacity: 0;
            transform: translateY(30px);
            transition: all 0.8s ease;
        }

        .reveal.active {
            opacity: 1;
            transform: translateY(0);
        }

        /* Mobile Responsive */
        @media (max-width: 1024px) {
            .hero-title {
                font-size: 3rem;
            }
            
            .features-grid {
                grid-template-columns: repeat(2, 1fr);
            }
        }

        @media (max-width: 768px) {
            
            .nav-links {
                display: none;
            }
            
            .hero-grid {
                grid-template-columns: 1fr;
            }
            
            .features-grid {
                grid-template-columns: 1fr;
            }
            
            .impact-grid {
                grid-template-columns: repeat(2, 1fr);
            }
            

            
            .timeline-item {
                flex-direction: column !important;
                gap: 20px;
            }
            
            .timeline-content {
                width: 100%;
            }
            
            .timeline-dot {
                display: none;
            }
            
            .roadmap-timeline::before {
                display: none;
            }
        }
    </style>
</head>
<body>
    <!-- Ambient Background -->
    <div class="ambient-bg">
        <div class="floating-shape shape-1"></div>
        <div class="floating-shape shape-2"></div>
        <div class="floating-shape shape-3"></div>
    </div>

    <!-- Navigation -->
    <nav class="navbar" id="navbar">
        <div class="container nav-content">
            <a href="#" class="nav-logo">Nuru AI</a>
            <ul class="nav-links">
                <li><a href="#home" class="nav-link">Home</a></li>
                <li><a href="#agencies" class="nav-link">Agencies</a></li>
                <li><a href="#features" class="nav-link">Features</a></li>
                <li><a href="#roadmap" class="nav-link">Roadmap</a></li>
                <li><a href="#impact" class="nav-link">Impact</a></li>
            </ul>
            <div style="display:flex; gap:15px; align-items:center;">
                <a href="#" class="btn btn-text">Sign In</a>
                <a href="#" class="btn btn-primary">Request Demo</a>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="hero" id="home">
        <div class="container hero-grid">
            <div class="hero-content reveal">
                <span class="hero-label">Intelligence Grade Platform</span>
                <h1 class="hero-title">Detect Procurement Fraud with AI-Powered Intelligence</h1>
                <p class="hero-subtitle">Real-time fraud detection, document forgery identification, and suspicious transaction tracking across all Kenyan governmental institutions.</p>
                <div class="hero-cta">
                    <a href="#" class="btn btn-primary">Launch Platform</a>
                    <a href="#" class="btn btn-secondary">Watch Demo</a>
                </div>
            </div>
            <div class="hero-visual reveal">
                <div class="mockup-container">
                    <div class="glass-card">
                        <div class="mockup-header">
                            <div class="dummy-bar sm" style="background: rgba(255,255,255,0.2);"></div>
                            <div class="dummy-bar md" style="background: rgba(255,255,255,0.2);"></div>
                            <div style="margin-left: auto; display: flex; gap: 8px;">
                                <div style="width: 12px; height: 12px; border-radius: 50%; background: #ff5f56;"></div>
                                <div style="width: 12px; height: 12px; border-radius: 50%; background: #ffbd2e;"></div>
                                <div style="width: 12px; height: 12px; border-radius: 50%; background: #27c93f;"></div>
                            </div>
                        </div>
                        
                        <!-- Dashboard Preview -->
                        <div style="margin-top: 20px;">
                            <div style="display: flex; justify-content: space-between; margin-bottom: 20px;">
                                <span style="color: var(--accent); font-weight: 600;">Fraud Detection Dashboard</span>
                                <span style="color: var(--text-secondary); font-size: 0.9rem;">Live</span>
                            </div>
                            
                            <!-- Risk Meter -->
                            <div style="margin-bottom: 30px;">
                                <div style="display: flex; justify-content: space-between; margin-bottom: 10px;">
                                    <span>Risk Score</span>
                                    <span style="color: var(--danger); font-weight: 600;">HIGH</span>
                                </div>
                                <div style="height: 8px; background: rgba(255,255,255,0.1); border-radius: 4px; overflow: hidden;">
                                    <div style="width: 75%; height: 100%; background: linear-gradient(90deg, var(--gold), var(--danger));"></div>
                                </div>
                            </div>
                            
                            <!-- Alerts -->
                            <div style="margin-bottom: 20px;">
                                <div style="display: flex; align-items: center; gap: 10px; margin-bottom: 15px; padding: 10px; background: rgba(255,107,107,0.1); border-radius: 8px;">
                                    <i class="fas fa-exclamation-triangle" style="color: var(--danger);"></i>
                                    <span style="flex: 1;">Suspicious tender pattern detected</span>
                                    <span style="color: var(--text-secondary); font-size: 0.8rem;">2m ago</span>
                                </div>
                                <div style="display: flex; align-items: center; gap: 10px; margin-bottom: 15px; padding: 10px; background: rgba(255,179,71,0.1); border-radius: 8px;">
                                    <i class="fas fa-file-invoice" style="color: var(--gold);"></i>
                                    <span style="flex: 1;">Document forgery alert</span>
                                    <span style="color: var(--text-secondary); font-size: 0.8rem;">5m ago</span>
                                </div>
                                <div style="display: flex; align-items: center; gap: 10px; padding: 10px; background: rgba(0,184,169,0.1); border-radius: 8px;">
                                    <i class="fas fa-chart-line" style="color: var(--accent);"></i>
                                    <span style="flex: 1;">Unusual transaction pattern</span>
                                    <span style="color: var(--text-secondary); font-size: 0.8rem;">12m ago</span>
                                </div>
                            </div>
                            
                            <!-- Quick Stats -->
                            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 15px;">
                                <div>
                                    <div style="color: var(--text-secondary); font-size: 0.8rem;">Cases Active</div>
                                    <div style="font-size: 1.5rem; font-weight: 700;">1,247</div>
                                </div>
                                <div>
                                    <div style="color: var(--text-secondary); font-size: 0.8rem;">Risk Value</div>
                                    <div style="font-size: 1.5rem; font-weight: 700; color: var(--gold);">KES 2.3B</div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Floating Stats -->
                    <div class="mockup-float">
                        <div class="stat-label">Irregularities Detected</div>
                        <div class="stat-val">1,240</div>
                        <div style="display: flex; justify-content: space-between; margin-top: 10px;">
                            <span style="color: var(--text-secondary);">This month</span>
                            <span style="color: var(--danger);">▲ 12%</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Stats Strip -->
    <div class="stats-strip">
        <div class="container">
            <div class="stats-grid">
                <div class="stat-item reveal">
                    <div class="stat-number">KES 10M+</div>
                    <div class="stat-desc">Total Prizes</div>
                </div>
                <div class="stat-item reveal">
                    <div class="stat-number">500+</div>
                    <div class="stat-desc">Participants</div>
                </div>
                <div class="stat-item reveal">
                    <div class="stat-number">80+</div>
                    <div class="stat-desc">AI Projects</div>
                </div>
                <div class="stat-item reveal">
                    <div class="stat-number">25</div>
                    <div class="stat-desc">Winners</div>
                </div>
            </div>
        </div>
    </div>

    <!-- Agencies Section -->
    <section class="section" id="agencies">
        <div class="container">
            <div class="section-header reveal">
                <h2 class="section-title">Trusted by Key Institutions</h2>
                <p class="section-desc">Empowering Kenya's top oversight bodies with unified investigative dashboards</p>
            </div>
            
            <div class="agency-grid">
                <div class="agency-card reveal">
                    <div class="agency-icon">⚖️</div>
                    <h3 class="agency-name">EACC</h3>
                    <p class="agency-desc">Ethics and Anti-Corruption Commission</p>
                </div>
                <div class="agency-card reveal">
                    <div class="agency-icon">📊</div>
                    <h3 class="agency-name">Auditor General</h3>
                    <p class="agency-desc">Office of the Auditor General</p>
                </div>
                <div class="agency-card reveal">
                    <div class="agency-icon">💰</div>
                    <h3 class="agency-name">KRA</h3>
                    <p class="agency-desc">Kenya Revenue Authority</p>
                </div>
                <div class="agency-card reveal">
                    <div class="agency-icon">🕵️</div>
                    <h3 class="agency-name">NIS</h3>
                    <p class="agency-desc">National Intelligence Service</p>
                </div>
                <div class="agency-card reveal">
                    <div class="agency-icon">📋</div>
                    <h3 class="agency-name">Procurement Units</h3>
                    <p class="agency-desc">Internal Government Agencies</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Features Section -->
    <section class="section" id="features">
        <div class="container">
            <div class="section-header reveal">
                <h2 class="section-title">Intelligence Grade Features</h2>
                <p class="section-desc">Advanced AI capabilities designed for fraud detection and investigative workflows</p>
            </div>
            
            <div class="features-grid">
                <div class="feature-card reveal">
                    <div class="feature-icon">🔍</div>
                    <h3 class="feature-title">Real-time Fraud Detection</h3>
                    <p class="feature-desc">AI-powered engine that analyzes procurement patterns and flags suspicious activities instantly.</p>
                </div>
                <div class="feature-card reveal">
                    <div class="feature-icon">📄</div>
                    <h3 class="feature-title">Document Forgery Detection</h3>
                    <p class="feature-desc">Advanced OCR and pattern recognition to identify altered or forged documents.</p>
                </div>
                <div class="feature-card reveal">
                    <div class="feature-icon">💰</div>
                    <h3 class="feature-title">Financial Irregularities</h3>
                    <p class="feature-desc">Detect unusual transaction patterns and financial discrepancies across systems.</p>
                </div>
                <div class="feature-card reveal">
                    <div class="feature-icon">📊</div>
                    <h3 class="feature-title">Unified Dashboard</h3>
                    <p class="feature-desc">Single interface for all investigative agencies to track cases and intelligence.</p>
                </div>
                <div class="feature-card reveal">
                    <div class="feature-icon">🤖</div>
                    <h3 class="feature-title">Explainable AI</h3>
                    <p class="feature-desc">Transparent decision-making process that officers can trust and verify.</p>
                </div>
                <div class="feature-card reveal">
                    <div class="feature-icon">📈</div>
                    <h3 class="feature-title">Predictive Analytics</h3>
                    <p class="feature-desc">ML models that predict potential fraud risks before they occur.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Roadmap Section -->
    <section class="section" id="roadmap">
        <div class="container">
            <div class="section-header reveal">
                <h2 class="section-title">Development Roadmap</h2>
                <p class="section-desc">6-Week journey to build Kenya's premier fraud detection platform</p>
            </div>
            
            <div class="roadmap-timeline">
                <!-- Week 1 -->
                <div class="timeline-item reveal">
                    <div class="timeline-content">
                        <span class="timeline-week">Week 1</span>
                        <h3 class="timeline-title">Research & System Scoping</h3>
                        <p class="timeline-desc">Understanding government procurement workflows and fraud patterns</p>
                        <ul class="timeline-deliverables">
                            <li><i class="fas fa-check-circle"></i> AI Fraud Model Blueprint</li>
                            <li><i class="fas fa-check-circle"></i> Workflow Diagrams</li>
                            <li><i class="fas fa-check-circle"></i> Requirements Specification</li>
                        </ul>
                    </div>
                    <div class="timeline-dot"></div>
                </div>
                
                <!-- Week 2 -->
                <div class="timeline-item reveal">
                    <div class="timeline-content">
                        <span class="timeline-week">Week 2</span>
                        <h3 class="timeline-title">System Architecture</h3>
                        <p class="timeline-desc">Django microservices, PostgreSQL schema, and security baseline</p>
                        <ul class="timeline-deliverables">
                            <li><i class="fas fa-check-circle"></i> Architecture Document</li>
                            <li><i class="fas fa-check-circle"></i> Entity Relation Diagram</li>
                            <li><i class="fas fa-check-circle"></i> API Specification</li>
                        </ul>
                    </div>
                    <div class="timeline-dot"></div>
                </div>
                
                <!-- Week 3 -->
                <div class="timeline-item reveal">
                    <div class="timeline-content">
                        <span class="timeline-week">Week 3</span>
                        <h3 class="timeline-title">Frontend Development</h3>
                        <p class="timeline-desc">React dashboard with protected routes and UI components</p>
                        <ul class="timeline-deliverables">
                            <li><i class="fas fa-check-circle"></i> Clickable Navigation</li>
                            <li><i class="fas fa-check-circle"></i> Page Skeletons</li>
                            <li><i class="fas fa-check-circle"></i> Unified Dashboard UI/UX</li>
                        </ul>
                    </div>
                    <div class="timeline-dot"></div>
                </div>
                
                <!-- Week 4 -->
                <div class="timeline-item reveal">
                    <div class="timeline-content">
                        <span class="timeline-week">Week 4</span>
                        <h3 class="timeline-title">AI Integration</h3>
                        <p class="timeline-desc">OCR implementation and fraud detection engine</p>
                        <ul class="timeline-deliverables">
                            <li><i class="fas fa-check-circle"></i> Working Backend</li>
                            <li><i class="fas fa-check-circle"></i> Live AI Responses</li>
                            <li><i class="fas fa-check-circle"></i> Risk Scoring System</li>
                        </ul>
                    </div>
                    <div class="timeline-dot"></div>
                </div>
                
                <!-- Week 5 -->
                <div class="timeline-item reveal">
                    <div class="timeline-content">
                        <span class="timeline-week">Week 5</span>
                        <h3 class="timeline-title">System Integration</h3>
                        <p class="timeline-desc">Full end-to-end functionality with explainability</p>
                        <ul class="timeline-deliverables">
                            <li><i class="fas fa-check-circle"></i> Fully Functional Dashboard</li>
                            <li><i class="fas fa-check-circle"></i> Explainable AI Interface</li>
                            <li><i class="fas fa-check-circle"></i> Case Management System</li>
                        </ul>
                    </div>
                    <div class="timeline-dot"></div>
                </div>
                
                <!-- Week 6 -->
                <div class="timeline-item reveal">
                    <div class="timeline-content">
                        <span class="timeline-week">Week 6</span>
                        <h3 class="timeline-title">Hardening & Deployment</h3>
                        <p class="timeline-desc">Security testing, optimization, and demo preparation</p>
                        <ul class="timeline-deliverables">
                            <li><i class="fas fa-check-circle"></i> Polished UI</li>
                            <li><i class="fas fa-check-circle"></i> Complete Documentation</li>
                            <li><i class="fas fa-check-circle"></i> Deployed Prototype</li>
                        </ul>
                    </div>
                    <div class="timeline-dot"></div>
                </div>
            </div>
        </div>
    </section>

    <!-- Impact Section -->
    <section class="section" id="impact">
        <div class="container">
            <div class="section-header reveal">
                <h2 class="section-title">Projected Impact</h2>
                <p class="section-desc">Transforming public procurement integrity through AI</p>
            </div>
            
            <div class="impact-grid">
                <div class="reveal">
                    <div class="impact-number">KES 50B+</div>
                    <div class="impact-label">Potential Savings</div>
                </div>
                <div class="reveal">
                    <div class="impact-number">100%</div>
                    <div class="impact-label">Audit Transparency</div>
                </div>
                <div class="reveal">
                    <div class="impact-number">10K+</div>
                    <div class="impact-label">Documents Analyzed</div>
                </div>
                <div class="reveal">
                    <div class="impact-number">24/7</div>
                    <div class="impact-label">Real-time Monitoring</div>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="cta-section">
        <div class="container">
            <div class="reveal">
                <h2 class="cta-title">Ready to Transform Public Procurement Integrity?</h2>
                <div class="cta-buttons">
                    <a href="#" class="btn btn-primary" style="font-size: 1.1rem; padding: 16px 32px;">Request Demo</a>
                    <a href="#" class="btn btn-gold" style="font-size: 1.1rem; padding: 16px 32px;">Join Hackathon</a>
                </div>
            </div>
        </div>
    </section>



    <script>
        // Scroll reveal animation
        function reveal() {
            const reveals = document.querySelectorAll('.reveal');
            
            for (let i = 0; i < reveals.length; i++) {
                const windowHeight = window.innerHeight;
                const revealTop = reveals[i].getBoundingClientRect().top;
                const revealPoint = 150;
                
                if (revealTop < windowHeight - revealPoint) {
                    reveals[i].classList.add('active');
                }
            }
        }
        
        // Navbar scroll effect
        function navbarScroll() {
            const navbar = document.getElementById('navbar');
            if (window.scrollY > 50) {
                navbar.classList.add('scrolled');
            } else {
                navbar.classList.remove('scrolled');
            }
        }
        
        // Smooth scroll for navigation links
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                e.preventDefault();
                const target = document.querySelector(this.getAttribute('href'));
                if (target) {
                    target.scrollIntoView({
                        behavior: 'smooth',
                        block: 'start'
                    });
                }
            });
        });
        
        // Initialize animations
        window.addEventListener('load', () => {
            reveal();
            navbarScroll();
        });
        
        window.addEventListener('scroll', () => {
            reveal();
            navbarScroll();
        });
        
        // Counter animation for stats
        function animateValue(obj, start, end, duration) {
            let startTimestamp = null;
            const step = (timestamp) => {
                if (!startTimestamp) startTimestamp = timestamp;
                const progress = Math.min((timestamp - startTimestamp) / duration, 1);
                obj.innerHTML = Math.floor(progress * (end - start) + start);
                if (progress < 1) {
                    window.requestAnimationFrame(step);
                }
            };
            window.requestAnimationFrame(step);
        }
        
        // Animate stats when they come into view
        const observerOptions = {
            threshold: 0.5
        };
        
        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    const statNumbers = entry.target.querySelectorAll('.stat-number');
                    statNumbers.forEach(stat => {
                        const value = stat.innerHTML.replace(/[^0-9]/g, '');
                        if (value) {
                            animateValue(stat, 0, parseInt(value), 2000);
                        }
                    });
                }
            });
        }, observerOptions);
        
        document.querySelectorAll('.stats-strip').forEach(section => {
            observer.observe(section);
        });
    </script>
</body>
</html>