<?php
require_once __DIR__ . '/../layout/navbar.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($title ?? 'Consult with Bright Orbit - Employers & Employees | Expert HR Guidance') ?></title>
    <meta name="description" content="<?= htmlspecialchars($meta_description ?? 'Get expert consultation from Bright Orbit. For employers seeking top talent or employees looking to advance your career - we\'re here to help.') ?>">
    
    <!-- Fonts & Icons -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    
    <!-- AOS Animation Library -->
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    
    <style>
        /* ===== RESET & VARIABLES ===== */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        :root {
            /* Brand Colors */
            --logo-navy: #0a2a44;
            --logo-teal: #CC5500;
            --logo-gray: #4a5568;
            
            --navy: var(--logo-navy);
            --navy-light: #1e3a5a;
            --navy-dark: #051a2c;
            --teal: var(--logo-teal);
            --teal-light: #e68a2e;
            --teal-dark: #b34700;
            --teal-soft: rgba(204,85,0,0.08);
            --teal-glow: rgba(204,85,0,0.15);
            --teal-gradient: linear-gradient(135deg, #CC5500, #e68a2e);
            --navy-gradient: linear-gradient(135deg, #0a2a44, #1e3a5a);
            --sky: #fef2e6;
            --sky-light: #fff7ed;
            --white: #ffffff;
            --gray: #5a6b7a;
            --gray-light: #e5ecf0;
            --gray-bg: #f9fafc;
            
            --font-primary: 'Inter', sans-serif;
            --shadow-sm: 0 5px 15px rgba(10,42,68,0.05);
            --shadow-md: 0 10px 25px rgba(10,42,68,0.08);
            --shadow-lg: 0 20px 40px -10px rgba(10,42,68,0.1);
            --shadow-xl: 0 30px 60px -15px rgba(204,85,0,0.2);
            --shadow-hover: 0 30px 50px -15px rgba(204,85,0,0.25);
            --border-radius: 24px;
            --border-radius-lg: 32px;
            --border-radius-full: 50px;
            
            --transition: all 0.4s cubic-bezier(0.165, 0.84, 0.44, 1);
        }

        body {
            font-family: var(--font-primary);
            color: var(--navy);
            line-height: 1.7;
            overflow-x: hidden;
            background: var(--white);
        }

        .container {
            max-width: 1280px;
            margin: 0 auto;
            padding: 0 2rem;
        }

        /* ===== PAGE HEADER ===== */
        .page-header {
            padding: 5rem 0 3rem;
            background: linear-gradient(165deg, var(--white) 0%, var(--sky-light) 100%);
            position: relative;
            overflow: hidden;
            text-align: center;
        }

        .page-header::before {
            content: '';
            position: absolute;
            top: -30%;
            right: -10%;
            width: 60%;
            height: 150%;
            background: radial-gradient(circle, rgba(204,85,0,0.03) 0%, transparent 70%);
            border-radius: 50%;
            pointer-events: none;
        }

        .page-header::after {
            content: '';
            position: absolute;
            bottom: -30%;
            left: -10%;
            width: 60%;
            height: 150%;
            background: radial-gradient(circle, rgba(10,42,68,0.03) 0%, transparent 70%);
            border-radius: 50%;
            pointer-events: none;
        }

        .page-header .container {
            position: relative;
            z-index: 2;
        }

        .section-tag {
            display: inline-block;
            background: var(--teal-soft);
            color: var(--teal);
            padding: 0.6rem 1.8rem;
            border-radius: var(--border-radius-full);
            font-weight: 600;
            font-size: 0.9rem;
            text-transform: uppercase;
            letter-spacing: 2px;
            margin-bottom: 1.5rem;
            border: 1px solid var(--teal-glow);
            backdrop-filter: blur(10px);
        }

        .page-title {
            font-size: 4rem;
            font-weight: 800;
            color: var(--navy);
            line-height: 1.1;
            margin-bottom: 1.5rem;
            letter-spacing: -2px;
        }

        .page-title span {
            color: var(--teal);
            position: relative;
            display: inline-block;
        }

        .page-title span::after {
            content: '';
            position: absolute;
            bottom: 10px;
            left: 0;
            width: 100%;
            height: 8px;
            background: rgba(204,85,0,0.2);
            z-index: -1;
        }

        .page-desc {
            color: var(--gray);
            font-size: 1.3rem;
            max-width: 700px;
            line-height: 1.8;
            margin: 0 auto;
        }

        /* ===== PATHWAY SELECTOR ===== */
        .pathway-selector {
            padding: 2rem 0 3rem;
            position: relative;
            z-index: 10;
        }

        .selector-container {
            display: flex;
            justify-content: center;
            gap: 1.5rem;
            max-width: 600px;
            margin: 0 auto;
            background: var(--white);
            padding: 1rem;
            border-radius: var(--border-radius-full);
            box-shadow: var(--shadow-xl);
            border: 1px solid var(--gray-light);
        }

        .pathway-btn {
            flex: 1;
            padding: 1.2rem 2rem;
            border: none;
            background: transparent;
            border-radius: var(--border-radius-full);
            font-weight: 700;
            font-size: 1.2rem;
            cursor: pointer;
            transition: var(--transition);
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.8rem;
            color: var(--gray);
        }

        .pathway-btn i {
            font-size: 1.3rem;
        }

        .pathway-btn.active {
            background: var(--navy-gradient);
            color: white;
            box-shadow: var(--shadow-lg);
        }

        .pathway-btn.employer.active {
            background: linear-gradient(135deg, #0a2a44, #1e3a5a);
        }

        .pathway-btn.employee.active {
            background: var(--teal-gradient);
        }

        /* ===== CONSULTATION HERO ===== */
        .consult-hero {
            padding: 2rem 0 4rem;
        }

        .consult-hero .container {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 4rem;
            align-items: center;
        }

        .consult-content {
            padding-right: 2rem;
        }

        .consult-badge {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            background: var(--teal-soft);
            color: var(--teal);
            padding: 0.6rem 1.5rem;
            border-radius: var(--border-radius-full);
            font-weight: 600;
            font-size: 0.9rem;
            margin-bottom: 1.5rem;
            border: 1px solid var(--teal-glow);
        }

        .consult-title {
            font-size: 3rem;
            font-weight: 800;
            line-height: 1.2;
            letter-spacing: -1px;
            color: var(--navy);
            margin-bottom: 1.2rem;
        }

        .consult-title span {
            color: var(--teal);
        }

        .consult-text {
            color: var(--gray);
            font-size: 1.1rem;
            line-height: 1.8;
            margin-bottom: 2rem;
        }

        .consult-features {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 1rem;
            margin-bottom: 2rem;
        }

        .consult-feature {
            display: flex;
            align-items: center;
            gap: 0.8rem;
            color: var(--navy);
        }

        .consult-feature i {
            color: var(--teal);
            font-size: 1.1rem;
            width: 24px;
        }

        .consult-image {
            position: relative;
            border-radius: var(--border-radius-lg);
            overflow: hidden;
            box-shadow: var(--shadow-xl);
            height: 500px;
        }

        .consult-image img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: var(--transition);
        }

        .consult-image:hover img {
            transform: scale(1.05);
        }

        .consult-image::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: linear-gradient(145deg, rgba(10,42,68,0.3), rgba(204,85,0,0.2));
            z-index: 1;
        }

        .image-caption {
            position: absolute;
            bottom: 30px;
            left: 30px;
            background: rgba(255,255,255,0.95);
            padding: 1rem 2rem;
            border-radius: var(--border-radius-full);
            font-weight: 600;
            color: var(--navy);
            z-index: 2;
            box-shadow: var(--shadow-lg);
            border-left: 4px solid var(--teal);
        }

        /* ===== BENEFITS SECTION ===== */
        .benefits-section {
            padding: 6rem 0;
            background: var(--gray-bg);
            position: relative;
            overflow: hidden;
        }

        .benefits-section::before {
            content: '';
            position: absolute;
            top: -20%;
            right: -10%;
            width: 60%;
            height: 140%;
            background: radial-gradient(circle, rgba(204,85,0,0.03) 0%, transparent 70%);
            border-radius: 50%;
        }

        .section-header {
            text-align: center;
            max-width: 700px;
            margin: 0 auto 4rem;
        }

        .section-subtitle {
            color: var(--teal);
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 3px;
            font-size: 0.9rem;
            margin-bottom: 1rem;
        }

        .benefits-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 2rem;
            margin-top: 2rem;
        }

        .benefit-card {
            background: var(--white);
            padding: 2.5rem;
            border-radius: var(--border-radius);
            border: 1px solid var(--gray-light);
            transition: var(--transition);
            position: relative;
            overflow: hidden;
            box-shadow: var(--shadow-md);
        }

        .benefit-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 4px;
            height: 0;
            background: var(--teal);
            transition: var(--transition);
        }

        .benefit-card:hover {
            transform: translateY(-10px);
            border-color: var(--teal);
            box-shadow: var(--shadow-xl);
        }

        .benefit-card:hover::before {
            height: 100%;
        }

        .benefit-icon {
            width: 70px;
            height: 70px;
            background: var(--teal-soft);
            border-radius: 20px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--teal);
            font-size: 1.8rem;
            margin-bottom: 1.8rem;
            transition: var(--transition);
        }

        .benefit-card:hover .benefit-icon {
            background: var(--teal);
            color: white;
            transform: rotate(5deg);
        }

        .benefit-card h3 {
            font-size: 1.4rem;
            font-weight: 700;
            color: var(--navy);
            margin-bottom: 1rem;
        }

        .benefit-card p {
            color: var(--gray);
            font-size: 1rem;
            line-height: 1.7;
        }

        /* ===== PROCESS SECTION ===== */
        .process-section {
            padding: 6rem 0;
            background: var(--white);
        }

        .process-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 2rem;
            margin-top: 3rem;
        }

        .process-step {
            text-align: center;
            position: relative;
        }

        .process-step:not(:last-child)::after {
            content: '→';
            position: absolute;
            top: 40px;
            right: -20px;
            font-size: 2rem;
            color: var(--teal);
            opacity: 0.3;
            font-weight: 300;
        }

        .step-number {
            width: 80px;
            height: 80px;
            background: linear-gradient(145deg, var(--sky-light), var(--white));
            border-radius: 30px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 1.5rem;
            font-size: 2rem;
            font-weight: 700;
            color: var(--teal);
            border: 2px dashed var(--gray-light);
            transition: var(--transition);
        }

        .process-step:hover .step-number {
            background: var(--teal);
            color: white;
            border-color: var(--teal);
            transform: scale(1.1) rotate(5deg);
        }

        .process-step h4 {
            font-size: 1.3rem;
            font-weight: 700;
            color: var(--navy);
            margin-bottom: 0.8rem;
        }

        .process-step p {
            color: var(--gray);
            font-size: 0.95rem;
        }

        /* ===== CONSULTATION FORM ===== */
        .consultation-form {
            padding: 6rem 0;
            background: linear-gradient(145deg, var(--navy), var(--navy-dark));
            color: white;
            position: relative;
            overflow: hidden;
        }

        .consultation-form::before {
            content: '';
            position: absolute;
            top: -50%;
            right: -20%;
            width: 80%;
            height: 200%;
            background: radial-gradient(circle, rgba(204,85,0,0.1) 0%, transparent 70%);
            border-radius: 50%;
        }

        .form-container {
            max-width: 800px;
            margin: 0 auto;
            position: relative;
            z-index: 2;
        }

        .form-title {
            font-size: 2.8rem;
            font-weight: 800;
            text-align: center;
            margin-bottom: 1rem;
        }

        .form-title span {
            color: var(--teal);
        }

        .form-subtitle {
            text-align: center;
            font-size: 1.2rem;
            opacity: 0.9;
            margin-bottom: 3rem;
        }

        .consult-form {
            background: rgba(255,255,255,0.05);
            backdrop-filter: blur(10px);
            padding: 3rem;
            border-radius: var(--border-radius-lg);
            border: 1px solid rgba(255,255,255,0.1);
        }

        .form-row {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 1.5rem;
            margin-bottom: 1.5rem;
        }

        .form-group {
            margin-bottom: 1.5rem;
        }

        .form-group label {
            display: block;
            font-weight: 600;
            margin-bottom: 0.5rem;
            color: white;
        }

        .form-group label span {
            color: var(--teal);
        }

        .form-control {
            width: 100%;
            padding: 1rem 1.2rem;
            background: rgba(255,255,255,0.1);
            border: 1px solid rgba(255,255,255,0.2);
            border-radius: 15px;
            font-family: var(--font-primary);
            font-size: 1rem;
            color: white;
            transition: var(--transition);
        }

        .form-control:focus {
            outline: none;
            border-color: var(--teal);
            background: rgba(255,255,255,0.15);
        }

        .form-control::placeholder {
            color: rgba(255,255,255,0.5);
        }

        select.form-control option {
            background: var(--navy);
            color: white;
        }

        .radio-group {
            display: flex;
            gap: 2rem;
            margin-top: 0.5rem;
        }

        .radio-option {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            cursor: pointer;
        }

        .radio-option input[type="radio"] {
            width: 20px;
            height: 20px;
            accent-color: var(--teal);
            cursor: pointer;
        }

        .submit-btn {
            background: var(--teal-gradient);
            color: white;
            border: none;
            padding: 1.2rem 2.5rem;
            border-radius: var(--border-radius-full);
            font-weight: 700;
            font-size: 1.1rem;
            cursor: pointer;
            transition: var(--transition);
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 0.8rem;
            width: 100%;
            border: 1px solid transparent;
            margin-top: 1rem;
        }

        .submit-btn:hover {
            transform: translateY(-5px);
            box-shadow: 0 20px 30px rgba(204,85,0,0.3);
        }

        .submit-btn i {
            transition: var(--transition);
        }

        .submit-btn:hover i {
            transform: translateX(5px);
        }

        /* ===== FAQ SECTION ===== */
        .faq-section {
            padding: 6rem 0;
            background: var(--white);
        }

        .faq-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 2rem;
            margin-top: 3rem;
        }

        .faq-item {
            background: var(--sky-light);
            padding: 2rem;
            border-radius: var(--border-radius);
            border: 1px solid var(--gray-light);
            transition: var(--transition);
        }

        .faq-item:hover {
            border-color: var(--teal);
            box-shadow: var(--shadow-md);
        }

        .faq-question {
            display: flex;
            align-items: center;
            gap: 1rem;
            margin-bottom: 1rem;
        }

        .faq-question i {
            color: var(--teal);
            font-size: 1.3rem;
        }

        .faq-question h4 {
            font-size: 1.2rem;
            font-weight: 700;
            color: var(--navy);
        }

        .faq-answer {
            color: var(--gray);
            font-size: 0.95rem;
            line-height: 1.7;
            padding-left: 2.3rem;
        }

        /* ===== DYNAMIC PATHWAY STYLES ===== */
        .employer-content,
        .employee-content {
            display: none;
        }

        .employer-content.active,
        .employee-content.active {
            display: block;
        }

        /* Employer specific gradient */
        .employer-gradient {
            background: linear-gradient(145deg, var(--navy), var(--navy-light));
        }

        .employee-gradient {
            background: var(--teal-gradient);
        }

        /* ===== RESPONSIVE ===== */
        @media (max-width: 1024px) {
            .consult-hero .container {
                grid-template-columns: 1fr;
                gap: 3rem;
            }
            
            .consult-content {
                padding-right: 0;
            }
            
            .benefits-grid,
            .process-grid,
            .faq-grid {
                grid-template-columns: repeat(2, 1fr);
            }
            
            .process-step:not(:last-child)::after {
                display: none;
            }
            
            .page-title {
                font-size: 3rem;
            }
        }

        @media (max-width: 768px) {
            .container {
                padding: 0 1.5rem;
            }
            
            .page-title {
                font-size: 2.5rem;
            }
            
            .benefits-grid,
            .process-grid,
            .faq-grid,
            .form-row {
                grid-template-columns: 1fr;
            }
            
            .selector-container {
                flex-direction: column;
                border-radius: var(--border-radius);
            }
            
            .consult-features {
                grid-template-columns: 1fr;
            }
            
            .consult-image {
                height: 350px;
            }
            
            .form-container {
                padding: 0 1rem;
            }
            
            .consult-form {
                padding: 2rem;
            }
            
            .radio-group {
                flex-direction: column;
                gap: 1rem;
            }
        }

        @media (max-width: 480px) {
            .page-title {
                font-size: 2rem;
            }
            
            .consult-title {
                font-size: 2.2rem;
            }
            
            .process-step {
                padding: 0 1rem;
            }
            
            .step-number {
                width: 60px;
                height: 60px;
                font-size: 1.5rem;
            }
        }
    </style>
</head>
<body>
    <!-- Page Header -->
    <div class="page-header">
        <div class="container" data-aos="fade-up" data-aos-duration="1000">
            <span class="section-tag">Expert Guidance</span>
            <h1 class="page-title">Let's <span>Talk</span></h1>
            <p class="page-desc">Whether you're an employer seeking talent or a professional looking for your next opportunity</p>
        </div>
    </div>

    <!-- Pathway Selector -->
    <div class="pathway-selector">
        <div class="container">
            <div class="selector-container" data-aos="fade-up" data-aos-duration="1000">
                <button class="pathway-btn employer active" id="employerBtn">
                    <i class="fas fa-building"></i>
                    I'm an Employer
                </button>
                <button class="pathway-btn employee" id="employeeBtn">
                    <i class="fas fa-user-tie"></i>
                    I'm an Employee
                </button>
            </div>
        </div>
    </div>

    <!-- Employer Content -->
    <div class="employer-content active" id="employerContent">
        <!-- Hero Section - Employer -->
        <section class="consult-hero">
            <div class="container">
                <div class="consult-content" data-aos="fade-right" data-aos-duration="1000">
                    <div class="consult-badge">
                        <i class="fas fa-building"></i>
                        For Employers
                    </div>
                    <h2 class="consult-title">Find <span>Exceptional Talent</span> for Your Organization</h2>
                    <p class="consult-text">
                        Partner with us to access Kenya's finest professionals. We take the time to understand your company culture, values, and specific needs to deliver candidates who not only have the right skills but also the right fit.
                    </p>
                    
                    <div class="consult-features">
                        <div class="consult-feature">
                            <i class="fas fa-check-circle"></i>
                            <span>Pre-screened candidates</span>
                        </div>
                        <div class="consult-feature">
                            <i class="fas fa-check-circle"></i>
                            <span>Industry-specific expertise</span>
                        </div>
                        <div class="consult-feature">
                            <i class="fas fa-check-circle"></i>
                            <span>Cultural fit assessment</span>
                        </div>
                        <div class="consult-feature">
                            <i class="fas fa-check-circle"></i>
                            <span>Fast turnaround times</span>
                        </div>
                        <div class="consult-feature">
                            <i class="fas fa-check-circle"></i>
                            <span>Retention guarantee</span>
                        </div>
                        <div class="consult-feature">
                            <i class="fas fa-check-circle"></i>
                            <span>Ongoing support</span>
                        </div>
                    </div>
                </div>
                
                <div class="consult-image" data-aos="fade-left" data-aos-duration="1000">
                    <img src="https://images.unsplash.com/photo-1552664730-d307ca884978?ixlib=rb-4.0.3&auto=format&fit=crop&w=1470&q=80" alt="Employer Consultation">
                    <div class="image-caption">
                        <i class="fas fa-briefcase" style="color: var(--teal); margin-right: 0.5rem;"></i>
                        Trusted by 50+ Companies
                    </div>
                </div>
            </div>
        </section>

        <!-- Benefits for Employers -->
        <section class="benefits-section">
            <div class="container">
                <div class="section-header" data-aos="fade-up" data-aos-duration="1000">
                    <div class="section-subtitle">Why Partner With Us</div>
                    <h2 class="section-title">Benefits for <span>Employers</span></h2>
                    <p class="section-desc">We go beyond traditional recruitment to become your strategic HR partner</p>
                </div>

                <div class="benefits-grid">
                    <div class="benefit-card" data-aos="fade-up" data-aos-duration="1000" data-aos-delay="100">
                        <div class="benefit-icon">
                            <i class="fas fa-clock"></i>
                        </div>
                        <h3>Save Time & Resources</h3>
                        <p>We handle the entire recruitment process - from sourcing to screening - so you can focus on your core business.</p>
                    </div>
                    
                    <div class="benefit-card" data-aos="fade-up" data-aos-duration="1000" data-aos-delay="200">
                        <div class="benefit-icon">
                            <i class="fas fa-users"></i>
                        </div>
                        <h3>Access Top Talent</h3>
                        <p>Tap into our extensive network of pre-vetted, high-quality professionals across various industries.</p>
                    </div>
                    
                    <div class="benefit-card" data-aos="fade-up" data-aos-duration="1000" data-aos-delay="300">
                        <div class="benefit-icon">
                            <i class="fas fa-chart-line"></i>
                        </div>
                        <h3>Reduce Turnover</h3>
                        <p>Our cultural fit assessment ensures candidates align with your values, leading to 92% retention rate.</p>
                    </div>
                    
                    <div class="benefit-card" data-aos="fade-up" data-aos-duration="1000" data-aos-delay="400">
                        <div class="benefit-icon">
                            <i class="fas fa-globe-africa"></i>
                        </div>
                        <h3>Global Reach</h3>
                        <p>Connect with talent ready for international opportunities across Africa, Europe, and North America.</p>
                    </div>
                    
                    <div class="benefit-card" data-aos="fade-up" data-aos-duration="1000" data-aos-delay="500">
                        <div class="benefit-icon">
                            <i class="fas fa-handshake"></i>
                        </div>
                        <h3>HR Consulting</h3>
                        <p>Get expert advice on HR strategy, DEI initiatives, and organizational development.</p>
                    </div>
                    
                    <div class="benefit-card" data-aos="fade-up" data-aos-duration="1000" data-aos-delay="600">
                        <div class="benefit-icon">
                            <i class="fas fa-shield-alt"></i>
                        </div>
                        <h3>Compliance Assurance</h3>
                        <p>We ensure all placements meet local and international employment regulations.</p>
                    </div>
                </div>
            </div>
        </section>
    </div>

    <!-- Employee Content -->
    <div class="employee-content" id="employeeContent">
        <!-- Hero Section - Employee -->
        <section class="consult-hero">
            <div class="container">
                <div class="consult-content" data-aos="fade-right" data-aos-duration="1000">
                    <div class="consult-badge">
                        <i class="fas fa-user-tie"></i>
                        For Employees
                    </div>
                    <h2 class="consult-title">Advance Your <span>Career</span> Globally</h2>
                    <p class="consult-text">
                        Whether you're seeking international opportunities or looking to grow locally, we provide personalized career coaching, mentorship, and access to top employers who value your unique skills.
                    </p>
                    
                    <div class="consult-features">
                        <div class="consult-feature">
                            <i class="fas fa-check-circle"></i>
                            <span>Career coaching & mentorship</span>
                        </div>
                        <div class="consult-feature">
                            <i class="fas fa-check-circle"></i>
                            <span>CV optimization</span>
                        </div>
                        <div class="consult-feature">
                            <i class="fas fa-check-circle"></i>
                            <span>Interview preparation</span>
                        </div>
                        <div class="consult-feature">
                            <i class="fas fa-check-circle"></i>
                            <span>Global job opportunities</span>
                        </div>
                        <div class="consult-feature">
                            <i class="fas fa-check-circle"></i>
                            <span>Skills assessment</span>
                        </div>
                        <div class="consult-feature">
                            <i class="fas fa-check-circle"></i>
                            <span>Relocation support</span>
                        </div>
                    </div>
                </div>
                
                <div class="consult-image" data-aos="fade-left" data-aos-duration="1000">
                    <img src="https://images.unsplash.com/photo-1524178232363-1fb2b075b655?ixlib=rb-4.0.3&auto=format&fit=crop&w=1470&q=80" alt="Employee Consultation">
                    <div class="image-caption">
                        <i class="fas fa-graduation-cap" style="color: var(--teal); margin-right: 0.5rem;"></i>
                        500+ Careers Advanced
                    </div>
                </div>
            </div>
        </section>

        <!-- Benefits for Employees -->
        <section class="benefits-section">
            <div class="container">
                <div class="section-header" data-aos="fade-up" data-aos-duration="1000">
                    <div class="section-subtitle">Your Success Partner</div>
                    <h2 class="section-title">Benefits for <span>Employees</span></h2>
                    <p class="section-desc">We're invested in your long-term career growth and success</p>
                </div>

                <div class="benefits-grid">
                    <div class="benefit-card" data-aos="fade-up" data-aos-duration="1000" data-aos-delay="100">
                        <div class="benefit-icon">
                            <i class="fas fa-bullseye"></i>
                        </div>
                        <h3>Personalized Career Coaching</h3>
                        <p>One-on-one guidance to identify your strengths, goals, and the perfect career path.</p>
                    </div>
                    
                    <div class="benefit-card" data-aos="fade-up" data-aos-duration="1000" data-aos-delay="200">
                        <div class="benefit-icon">
                            <i class="fas fa-file-alt"></i>
                        </div>
                        <h3>CV & Interview Support</h3>
                        <p>Professional CV optimization and interview preparation to help you stand out.</p>
                    </div>
                    
                    <div class="benefit-card" data-aos="fade-up" data-aos-duration="1000" data-aos-delay="300">
                        <div class="benefit-icon">
                            <i class="fas fa-globe"></i>
                        </div>
                        <h3>International Opportunities</h3>
                        <p>Access to global job openings across Africa, Europe, and North America.</p>
                    </div>
                    
                    <div class="benefit-card" data-aos="fade-up" data-aos-duration="1000" data-aos-delay="400">
                        <div class="benefit-icon">
                            <i class="fas fa-chart-pie"></i>
                        </div>
                        <h3>Skills Development</h3>
                        <p>Identify skill gaps and access training programs to enhance your employability.</p>
                    </div>
                    
                    <div class="benefit-card" data-aos="fade-up" data-aos-duration="1000" data-aos-delay="500">
                        <div class="benefit-icon">
                            <i class="fas fa-hand-holding-heart"></i>
                        </div>
                        <h3>Mentorship Programs</h3>
                        <p>Connect with industry leaders who can guide your professional journey.</p>
                    </div>
                    
                    <div class="benefit-card" data-aos="fade-up" data-aos-duration="1000" data-aos-delay="600">
                        <div class="benefit-icon">
                            <i class="fas fa-plane"></i>
                        </div>
                        <h3>Relocation Assistance</h3>
                        <p>Support with visas, housing, and settling into new roles abroad.</p>
                    </div>
                </div>
            </div>
        </section>
    </div>

    <!-- Our Process (Same for Both) -->
    <section class="process-section">
        <div class="container">
            <div class="section-header" data-aos="fade-up" data-aos-duration="1000">
                <div class="section-subtitle">Simple & Transparent</div>
                <h2 class="section-title">Our <span>Consultation</span> Process</h2>
                <p class="section-desc">A proven approach that delivers results for both employers and employees</p>
            </div>

            <div class="process-grid">
                <div class="process-step" data-aos="fade-up" data-aos-duration="1000" data-aos-delay="100">
                    <div class="step-number">01</div>
                    <h4>Discovery Call</h4>
                    <p>We listen to understand your unique needs, goals, and expectations.</p>
                </div>
                
                <div class="process-step" data-aos="fade-up" data-aos-duration="1000" data-aos-delay="200">
                    <div class="step-number">02</div>
                    <h4>Needs Assessment</h4>
                    <p>In-depth analysis to identify the best strategy for your situation.</p>
                </div>
                
                <div class="process-step" data-aos="fade-up" data-aos-duration="1000" data-aos-delay="300">
                    <div class="step-number">03</div>
                    <h4>Customized Plan</h4>
                    <p>We develop a tailored roadmap to achieve your objectives.</p>
                </div>
                
                <div class="process-step" data-aos="fade-up" data-aos-duration="1000" data-aos-delay="400">
                    <div class="step-number">04</div>
                    <h4>Execution & Support</h4>
                    <p>We implement the plan with ongoing guidance and follow-up.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Consultation Form -->
    <section class="consultation-form">
        <div class="container">
            <div class="form-container" data-aos="fade-up" data-aos-duration="1000">
                <h2 class="form-title">Ready to Get <span>Started?</span></h2>
                <p class="form-subtitle">Fill out the form below and we'll contact you within 24 hours</p>
                
                <form class="consult-form" id="consultForm" action="#" method="POST">
                    <div class="form-row">
                        <div class="form-group">
                            <label>Full Name <span>*</span></label>
                            <input type="text" class="form-control" required placeholder="John Doe">
                        </div>
                        <div class="form-group">
                            <label>Email Address <span>*</span></label>
                            <input type="email" class="form-control" required placeholder="john@example.com">
                        </div>
                    </div>
                    
                    <div class="form-row">
                        <div class="form-group">
                            <label>Phone Number</label>
                            <input type="tel" class="form-control" placeholder="+254 712 345 678">
                        </div>
                        <div class="form-group">
                            <label>Company/Organization</label>
                            <input type="text" class="form-control" placeholder="Your company name (if applicable)">
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label>I am a: <span>*</span></label>
                        <div class="radio-group">
                            <label class="radio-option">
                                <input type="radio" name="consultType" value="employer" checked>
                                <span>Employer looking for talent</span>
                            </label>
                            <label class="radio-option">
                                <input type="radio" name="consultType" value="employee">
                                <span>Professional seeking opportunities</span>
                            </label>
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label>Subject <span>*</span></label>
                        <input type="text" class="form-control" required placeholder="Brief description of your inquiry">
                    </div>
                    
                    <div class="form-group">
                        <label>Message <span>*</span></label>
                        <textarea class="form-control" rows="5" required placeholder="Tell us more about your needs..."></textarea>
                    </div>
                    
                    <div class="form-group">
                        <label>Preferred Consultation Method</label>
                        <select class="form-control">
                            <option value="video">Video Call (Zoom/Teams)</option>
                            <option value="phone">Phone Call</option>
                            <option value="email">Email Exchange</option>
                            <option value="inperson">In-Person (Kikuyu Office)</option>
                        </select>
                    </div>
                    
                    <button type="submit" class="submit-btn">
                        <span>Schedule Free Consultation</span>
                        <i class="fas fa-calendar-check"></i>
                    </button>
                    
                    <p style="text-align: center; margin-top: 1.5rem; font-size: 0.9rem; opacity: 0.7;">
                        <i class="fas fa-lock" style="margin-right: 0.3rem;"></i>
                        Your information is secure and will never be shared
                    </p>
                </form>
            </div>
        </div>
    </section>

    <!-- FAQ Section -->
    <section class="faq-section">
        <div class="container">
            <div class="section-header" data-aos="fade-up" data-aos-duration="1000">
                <div class="section-subtitle">Common Questions</div>
                <h2 class="section-title">Frequently Asked <span>Questions</span></h2>
                <p class="section-desc">Everything you need to know about our consultation services</p>
            </div>

            <div class="faq-grid">
                <div class="faq-item" data-aos="fade-up" data-aos-duration="1000" data-aos-delay="100">
                    <div class="faq-question">
                        <i class="fas fa-question-circle"></i>
                        <h4>How long is a consultation?</h4>
                    </div>
                    <div class="faq-answer">
                        Initial consultations typically last 45-60 minutes. This gives us enough time to understand your needs and discuss potential solutions.
                    </div>
                </div>
                
                <div class="faq-item" data-aos="fade-up" data-aos-duration="1000" data-aos-delay="200">
                    <div class="faq-question">
                        <i class="fas fa-question-circle"></i>
                        <h4>Is the consultation free?</h4>
                    </div>
                    <div class="faq-answer">
                        Yes, the first consultation is completely free with no obligation. We believe in providing value before asking for any commitment.
                    </div>
                </div>
                
                <div class="faq-item" data-aos="fade-up" data-aos-duration="1000" data-aos-delay="300">
                    <div class="faq-question">
                        <i class="fas fa-question-circle"></i>
                        <h4>What happens after the consultation?</h4>
                    </div>
                    <div class="faq-answer">
                        We'll send you a summary of our discussion and proposed next steps. You're free to decide how you'd like to proceed.
                    </div>
                </div>
                
                <div class="faq-item" data-aos="fade-up" data-aos-duration="1000" data-aos-delay="400">
                    <div class="faq-question">
                        <i class="fas fa-question-circle"></i>
                        <h4>Do you work with international clients?</h4>
                    </div>
                    <div class="faq-answer">
                        Absolutely! We work with employers and employees across Africa, Europe, and North America. Consultations can be conducted via video call.
                    </div>
                </div>
                
                <div class="faq-item" data-aos="fade-up" data-aos-duration="1000" data-aos-delay="500">
                    <div class="faq-question">
                        <i class="fas fa-question-circle"></i>
                        <h4>What industries do you specialize in?</h4>
                    </div>
                    <div class="faq-answer">
                        We have expertise across HR, technology, healthcare, finance, and more. Our network spans multiple sectors.
                    </div>
                </div>
                
                <div class="faq-item" data-aos="fade-up" data-aos-duration="1000" data-aos-delay="600">
                    <div class="faq-question">
                        <i class="fas fa-question-circle"></i>
                        <h4>Can I change my consultation type later?</h4>
                    </div>
                    <div class="faq-answer">
                        Yes, simply let us know and we'll adjust our approach. We're flexible and adapt to your evolving needs.
                    </div>
                </div>
            </div>
        </div>
    </section>

    <?php require_once __DIR__ . '/../layout/footer.php'; ?>
    
    <!-- AOS Animation Script -->
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Initialize AOS
            AOS.init({
                once: true,
                offset: 100,
                duration: 1000,
                easing: 'ease-out-cubic'
            });

            // Pathway Toggle Functionality
            const employerBtn = document.getElementById('employerBtn');
            const employeeBtn = document.getElementById('employeeBtn');
            const employerContent = document.getElementById('employerContent');
            const employeeContent = document.getElementById('employeeContent');
            
            function activateEmployer() {
                employerBtn.classList.add('active');
                employeeBtn.classList.remove('active');
                employerContent.classList.add('active');
                employeeContent.classList.remove('active');
                
                // Update form radio if exists
                const employerRadio = document.querySelector('input[value="employer"]');
                if (employerRadio) employerRadio.checked = true;
            }
            
            function activateEmployee() {
                employeeBtn.classList.add('active');
                employerBtn.classList.remove('active');
                employeeContent.classList.add('active');
                employerContent.classList.remove('active');
                
                // Update form radio if exists
                const employeeRadio = document.querySelector('input[value="employee"]');
                if (employeeRadio) employeeRadio.checked = true;
            }
            
            employerBtn.addEventListener('click', activateEmployer);
            employeeBtn.addEventListener('click', activateEmployee);
            
            // Form Submission (WhatsApp for now)
            const consultForm = document.getElementById('consultForm');
            if (consultForm) {
                consultForm.addEventListener('submit', function(e) {
                    e.preventDefault();
                    
                    // Get form values
                    const name = this.querySelector('input[type="text"]').value;
                    const email = this.querySelector('input[type="email"]').value;
                    const consultType = document.querySelector('input[name="consultType"]:checked').value;
                    const consultTypeText = consultType === 'employer' ? 'Employer (seeking talent)' : 'Employee (seeking opportunities)';
                    
                    // Format WhatsApp message
                    const message = `*Bright Orbit Consultation Request*\n\n` +
                        `*Name:* ${name}\n` +
                        `*Email:* ${email}\n` +
                        `*Type:* ${consultTypeText}\n` +
                        `*I am interested in a consultation*`;
                    
                    // Encode for URL
                    const encodedMessage = encodeURIComponent(message);
                    const phoneNumber = '254740421873'; // Your WhatsApp number
                    
                    // Open WhatsApp
                    window.open(`https://wa.me/${phoneNumber}?text=${encodedMessage}`, '_blank');
                    
                    // Show success message
                    alert('Thank you for your interest! WhatsApp has been opened to send your consultation request.');
                });
            }

            // Smooth scrolling
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
            
            // Navbar scroll effect
            const navbar = document.querySelector('.navbar');
            window.addEventListener('scroll', () => {
                if (window.scrollY > 50) {
                    navbar.style.boxShadow = '0 2px 20px rgba(10,42,68,0.08)';
                    navbar.style.backdropFilter = 'blur(10px)';
                    navbar.style.background = 'rgba(255,255,255,0.98)';
                } else {
                    navbar.style.boxShadow = '0 2px 15px rgba(10,42,68,0.05)';
                    navbar.style.backdropFilter = 'none';
                    navbar.style.background = 'white';
                }
            });
        });
    </script>
</body>
</html>