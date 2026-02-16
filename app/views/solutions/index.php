<?php
require_once __DIR__ . '/../layout/navbar.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($title ?? 'Bright Orbit Consultancy | Enterprise HR Solutions') ?></title>
    <meta name="description" content="<?= htmlspecialchars($meta_description ?? 'Discover Bright Orbit\'s comprehensive HR solutions: Global Recruitment, Talent Management, DEI Training, Career Development, Executive Coaching, and more.') ?>">
    
    <!-- Premium Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Space+Grotesk:wght@300;400;500;600;700&family=Clash+Display:wght@400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- Font Awesome 6 -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    
    <!-- AOS -->
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    
    <!-- GSAP -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.5/gsap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.5/ScrollTrigger.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.5/TextPlugin.min.js"></script>
    
    <style>
        /* ===== RESET ===== */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        /* ===== DESIGN TOKENS ===== */
        :root {
            /* 🎨 Color System - Refined */
            --primary-950: #0a0f1a;
            --primary-900: #0f1a2a;
            --primary-800: #1a2a3a;
            --primary-700: #2a3a4a;
            --accent-500: #ff6b2b;
            --accent-400: #ff8540;
            --accent-300: #ff9f60;
            --accent-glow: rgba(255, 107, 43, 0.15);
            --accent-soft: rgba(255, 107, 43, 0.03);
            --neutral-50: #fafbfc;
            --neutral-100: #f0f3f7;
            --neutral-200: #e5e9f0;
            --neutral-300: #d0d8e3;
            --neutral-400: #a0b0c2;
            --neutral-500: #7085a0;
            --neutral-600: #506080;
            --neutral-700: #354060;
            --neutral-800: #1a2540;
            --neutral-900: #0f1a2a;
            --white: #ffffff;
            
            /* 📐 Typography */
            --font-display: 'Clash Display', sans-serif;
            --font-body: 'Space Grotesk', sans-serif;
            
            /* 📏 Spacing - 8pt system */
            --space-1: 0.25rem;  /* 4px */
            --space-2: 0.5rem;    /* 8px */
            --space-3: 0.75rem;   /* 12px */
            --space-4: 1rem;      /* 16px */
            --space-5: 1.25rem;   /* 20px */
            --space-6: 1.5rem;    /* 24px */
            --space-8: 2rem;      /* 32px */
            --space-10: 2.5rem;    /* 40px */
            --space-12: 3rem;      /* 48px */
            --space-16: 4rem;      /* 64px */
            --space-20: 5rem;      /* 80px */
            --space-24: 6rem;      /* 96px */
            
            /* ✨ Effects */
            --shadow-xs: 0 1px 2px rgba(0, 0, 0, 0.02);
            --shadow-sm: 0 2px 4px rgba(0, 0, 0, 0.02);
            --shadow-md: 0 8px 16px -4px rgba(0, 0, 0, 0.04);
            --shadow-lg: 0 16px 24px -8px rgba(0, 0, 0, 0.04);
            --shadow-xl: 0 24px 48px -12px rgba(0, 0, 0, 0.08);
            --shadow-2xl: 0 32px 64px -16px rgba(0, 0, 0, 0.12);
            --shadow-accent: 0 20px 40px -15px var(--accent-500);
            
            /* 🎯 Border Radius */
            --radius-sm: 0.375rem;
            --radius-md: 0.75rem;
            --radius-lg: 1rem;
            --radius-xl: 1.5rem;
            --radius-2xl: 2rem;
            --radius-3xl: 2.5rem;
            --radius-full: 9999px;
            
            /* ⚡ Transitions */
            --transition-fast: 200ms cubic-bezier(0.2, 0, 0, 1);
            --transition-base: 400ms cubic-bezier(0.2, 0, 0, 1);
            --transition-slow: 600ms cubic-bezier(0.2, 0, 0, 1);
            --transition-bounce: 500ms cubic-bezier(0.34, 1.56, 0.64, 1);
            
            /* 📐 Grid */
            --grid-gap: var(--space-6);
            --container-padding: var(--space-6);
            --container-max-width: 1440px;
        }

        /* ===== GLOBAL STYLES ===== */
        body {
            font-family: var(--font-body);
            color: var(--neutral-700);
            line-height: 1.6;
            overflow-x: hidden;
            background: var(--white);
            -webkit-font-smoothing: antialiased;
            -moz-osx-font-smoothing: grayscale;
        }

        .container {
            max-width: var(--container-max-width);
            margin: 0 auto;
            padding: 0 var(--container-padding);
        }

        h1, h2, h3, h4, h5, h6 {
            font-family: var(--font-display);
            font-weight: 600;
            line-height: 1.2;
            letter-spacing: -0.02em;
            color: var(--neutral-900);
        }

        /* ===== LOADER ANIMATION ===== */
        .page-loader {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: var(--white);
            z-index: 9999;
            display: flex;
            align-items: center;
            justify-content: center;
            pointer-events: none;
        }

        .loader-logo {
            width: 80px;
            height: 80px;
            background: linear-gradient(135deg, var(--accent-500), var(--accent-300));
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 2rem;
            animation: pulse 1.5s ease-in-out infinite;
        }

        @keyframes pulse {
            0%, 100% { transform: scale(1); opacity: 1; }
            50% { transform: scale(1.1); opacity: 0.8; }
        }

        /* ===== CURSOR EFFECTS ===== */
        .cursor-dot {
            width: 8px;
            height: 8px;
            background: var(--accent-500);
            border-radius: 50%;
            position: fixed;
            pointer-events: none;
            z-index: 99999;
            transform: translate(-50%, -50%);
            transition: width 0.2s, height 0.2s, background 0.2s;
        }

        .cursor-outline {
            width: 40px;
            height: 40px;
            border: 2px solid var(--accent-500);
            border-radius: 50%;
            position: fixed;
            pointer-events: none;
            z-index: 99998;
            transform: translate(-50%, -50%);
            transition: all 0.1s;
        }

     
        /* ===== HERO SECTION - REIMAGINED ===== */
        .hero {
            position: relative;
            min-height: 100vh;
            display: flex;
            align-items: center;
            padding: var(--space-24) 0;
            overflow: hidden;
            background: var(--white);
        }

        .hero-background {
            position: absolute;
            inset: 0;
            z-index: 1;
        }

        .hero-gradient {
            position: absolute;
            inset: 0;
            background: radial-gradient(circle at 30% 50%, var(--accent-soft) 0%, transparent 50%),
                        radial-gradient(circle at 70% 80%, var(--accent-soft) 0%, transparent 50%);
        }

        .hero-particles {
            position: absolute;
            inset: 0;
        }

        .particle {
            position: absolute;
            width: 2px;
            height: 2px;
            background: var(--accent-500);
            border-radius: 50%;
            opacity: 0.3;
            animation: particle-float 20s linear infinite;
        }

        @keyframes particle-float {
            from {
                transform: translateY(100vh) translateX(-50%);
            }
            to {
                transform: translateY(-100vh) translateX(50%);
            }
        }

        .hero-grid {
            display: grid;
            grid-template-columns: 1.2fr 0.8fr;
            gap: var(--space-16);
            align-items: center;
            position: relative;
            z-index: 2;
        }

        .hero-badge {
            display: inline-flex;
            align-items: center;
            gap: var(--space-2);
            background: rgba(255, 255, 255, 0.8);
            backdrop-filter: blur(8px);
            color: var(--accent-500);
            padding: var(--space-2) var(--space-4);
            border-radius: var(--radius-full);
            font-size: 0.875rem;
            font-weight: 600;
            letter-spacing: 0.02em;
            border: 1px solid var(--neutral-200);
            margin-bottom: var(--space-6);
            transition: var(--transition-base);
        }

        .hero-badge:hover {
            border-color: var(--accent-500);
            transform: translateY(-2px);
            box-shadow: var(--shadow-accent);
        }

        .hero-title {
            font-size: clamp(3rem, 5vw, 5rem);
            font-weight: 700;
            line-height: 1.1;
            letter-spacing: -0.03em;
            margin-bottom: var(--space-6);
        }

        .hero-title-line {
            display: block;
            color: var(--neutral-900);
        }

        .hero-title-line-accent {
            display: block;
            color: var(--accent-500);
            position: relative;
        }

        .hero-title-line-accent::before {
            content: '';
            position: absolute;
            bottom: 0.1em;
            left: 0;
            width: 100%;
            height: 0.2em;
            background: linear-gradient(90deg, var(--accent-500), transparent);
            border-radius: var(--radius-full);
            opacity: 0.3;
        }

        .hero-subtitle {
            font-size: 1.25rem;
            color: var(--neutral-500);
            margin-bottom: var(--space-8);
            max-width: 600px;
            line-height: 1.7;
        }

        /* ===== STATS ===== */
        .hero-stats {
            display: flex;
            gap: var(--space-8);
            margin-bottom: var(--space-8);
        }

        .stat-card {
            background: rgba(255, 255, 255, 0.8);
            backdrop-filter: blur(8px);
            padding: var(--space-4) var(--space-6);
            border-radius: var(--radius-xl);
            border: 1px solid var(--neutral-200);
            transition: var(--transition-base);
        }

        .stat-card:hover {
            border-color: var(--accent-500);
            transform: translateY(-4px);
            box-shadow: var(--shadow-accent);
        }

        .stat-number-wrapper {
            display: flex;
            align-items: baseline;
            gap: var(--space-1);
            font-size: 2.5rem;
            font-weight: 700;
            color: var(--neutral-900);
            line-height: 1;
        }

        .stat-suffix {
            font-size: 1.5rem;
            color: var(--accent-500);
        }

        .stat-label {
            font-size: 0.875rem;
            color: var(--neutral-500);
            text-transform: uppercase;
            letter-spacing: 0.05em;
            margin-top: var(--space-1);
        }

        /* ===== HERO VISUAL ===== */
        .hero-visual {
            position: relative;
        }

        .visual-wrapper {
            position: relative;
            width: 100%;
            aspect-ratio: 4/5;
        }

        .visual-card {
            position: absolute;
            inset: 0;
            border-radius: var(--radius-3xl);
            overflow: hidden;
            transform: rotate(2deg) scale(0.98);
            transition: var(--transition-bounce);
            box-shadow: var(--shadow-2xl);
        }

        .visual-card:hover {
            transform: rotate(0deg) scale(1);
            box-shadow: var(--shadow-accent);
        }

        .visual-card img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: var(--transition-slow);
        }

        .visual-card:hover img {
            transform: scale(1.05);
        }

        .visual-card::after {
            content: '';
            position: absolute;
            inset: 0;
            background: linear-gradient(145deg, rgba(10, 42, 68, 0.3), rgba(255, 107, 43, 0.2));
            mix-blend-mode: multiply;
        }

        .visual-quote {
            position: absolute;
            bottom: -20px;
            left: -20px;
            background: var(--white);
            padding: var(--space-6);
            border-radius: var(--radius-xl);
            box-shadow: var(--shadow-2xl);
            max-width: 280px;
            border-left: 4px solid var(--accent-500);
            z-index: 10;
            backdrop-filter: blur(8px);
            background: rgba(255, 255, 255, 0.95);
        }

        .visual-quote i {
            color: var(--accent-500);
            font-size: 2rem;
            opacity: 0.3;
            margin-bottom: var(--space-2);
        }

        .visual-quote p {
            font-weight: 600;
            color: var(--neutral-900);
            line-height: 1.4;
            font-size: 1rem;
        }

        /* ===== SECTION HEADERS ===== */
        .section-header {
            text-align: center;
            max-width: 700px;
            margin: 0 auto var(--space-16);
        }

        .section-eyebrow {
            display: inline-flex;
            align-items: center;
            gap: var(--space-2);
            color: var(--accent-500);
            font-size: 0.875rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.2em;
            margin-bottom: var(--space-4);
            position: relative;
        }

        .section-eyebrow::before,
        .section-eyebrow::after {
            content: '';
            width: 2rem;
            height: 1px;
            background: linear-gradient(90deg, transparent, var(--accent-500));
        }

        .section-eyebrow::before {
            margin-right: var(--space-2);
        }

        .section-eyebrow::after {
            margin-left: var(--space-2);
        }

        .section-title {
            font-size: clamp(2.5rem, 4vw, 3.5rem);
            font-weight: 700;
            color: var(--neutral-900);
            margin-bottom: var(--space-4);
            line-height: 1.2;
        }

        .section-title .highlight {
            color: var(--accent-500);
            position: relative;
            display: inline-block;
        }

        .section-title .highlight::after {
            content: '';
            position: absolute;
            bottom: 0.1em;
            left: 0;
            width: 100%;
            height: 0.15em;
            background: linear-gradient(90deg, var(--accent-500), transparent);
            border-radius: var(--radius-full);
        }

        .section-desc {
            color: var(--neutral-500);
            font-size: 1.1rem;
            line-height: 1.7;
        }

        /* ===== CATEGORY CARDS - MODERN ===== */
        .category-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: var(--space-6);
            margin-top: var(--space-8);
        }

        .category-card {
            background: var(--white);
            border-radius: var(--radius-2xl);
            border: 1px solid var(--neutral-200);
            overflow: hidden;
            transition: var(--transition-bounce);
            position: relative;
            cursor: pointer;
        }

        .category-card::before {
            content: '';
            position: absolute;
            inset: 0;
            background: linear-gradient(145deg, var(--accent-soft), transparent);
            opacity: 0;
            transition: var(--transition-base);
        }

        .category-card:hover {
            transform: translateY(-12px) scale(1.02);
            border-color: var(--accent-500);
            box-shadow: var(--shadow-2xl);
        }

        .category-card:hover::before {
            opacity: 1;
        }

        .category-header {
            padding: var(--space-6) var(--space-6) var(--space-4);
            display: flex;
            align-items: center;
            gap: var(--space-4);
            border-bottom: 1px solid var(--neutral-200);
            position: relative;
            z-index: 2;
        }

        .category-icon {
            width: 60px;
            height: 60px;
            background: var(--neutral-100);
            border-radius: var(--radius-lg);
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--accent-500);
            font-size: 1.8rem;
            transition: var(--transition-bounce);
        }

        .category-card:hover .category-icon {
            background: linear-gradient(135deg, var(--accent-500), var(--accent-400));
            color: var(--white);
            transform: rotate(5deg) scale(1.1);
        }

        .category-title {
            font-size: 1.3rem;
            font-weight: 600;
            color: var(--neutral-900);
        }

        .category-services {
            padding: var(--space-4) var(--space-6) var(--space-6);
            position: relative;
            z-index: 2;
        }

        .category-service-item {
            display: flex;
            align-items: center;
            gap: var(--space-3);
            padding: var(--space-2) 0;
            color: var(--neutral-600);
            transition: var(--transition-base);
            border-bottom: 1px solid var(--neutral-200);
        }

        .category-service-item:last-child {
            border-bottom: none;
        }

        .category-service-item i {
            color: var(--accent-500);
            font-size: 0.8rem;
            width: 20px;
            transition: var(--transition-bounce);
        }

        .category-service-item:hover {
            color: var(--neutral-900);
            transform: translateX(8px);
        }

        .category-service-item:hover i {
            transform: scale(1.2);
            color: var(--accent-500);
        }

        /* ===== SERVICE CARDS - ULTRA MODERN ===== */
        .services-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: var(--space-6);
            margin-top: var(--space-8);
        }

        .service-card {
            background: var(--white);
            padding: var(--space-8) var(--space-6);
            border-radius: var(--radius-2xl);
            border: 1px solid var(--neutral-200);
            transition: var(--transition-bounce);
            position: relative;
            overflow: hidden;
            cursor: pointer;
        }

        .service-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 4px;
            background: linear-gradient(90deg, var(--accent-500), var(--accent-300));
            transform: translateX(-100%);
            transition: var(--transition-base);
        }

        .service-card::after {
            content: '';
            position: absolute;
            bottom: 0;
            right: 0;
            width: 150px;
            height: 150px;
            background: radial-gradient(circle, var(--accent-soft) 0%, transparent 70%);
            opacity: 0;
            transition: var(--transition-slow);
        }

        .service-card:hover {
            transform: translateY(-12px);
            border-color: var(--accent-500);
            box-shadow: var(--shadow-2xl);
        }

        .service-card:hover::before {
            transform: translateX(0);
        }

        .service-card:hover::after {
            opacity: 1;
        }

        .service-icon-wrapper {
            width: 80px;
            height: 80px;
            background: var(--neutral-100);
            border-radius: var(--radius-xl);
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: var(--space-6);
            transition: var(--transition-bounce);
            position: relative;
            z-index: 2;
        }

        .service-card:hover .service-icon-wrapper {
            background: linear-gradient(135deg, var(--accent-500), var(--accent-400));
            transform: rotate(5deg) scale(1.1);
        }

        .service-icon {
            font-size: 2.2rem;
            color: var(--accent-500);
            transition: var(--transition-base);
        }

        .service-card:hover .service-icon {
            color: var(--white);
        }

        .service-card h3 {
            font-size: 1.3rem;
            font-weight: 600;
            color: var(--neutral-900);
            margin-bottom: var(--space-3);
            position: relative;
            z-index: 2;
        }

        .service-card p {
            color: var(--neutral-500);
            font-size: 0.9rem;
            line-height: 1.7;
            margin-bottom: var(--space-4);
            position: relative;
            z-index: 2;
        }

        .service-features-list {
            list-style: none;
            position: relative;
            z-index: 2;
        }

        .service-features-list li {
            display: flex;
            align-items: center;
            gap: var(--space-2);
            padding: var(--space-1) 0;
            color: var(--neutral-600);
            font-size: 0.85rem;
            transition: var(--transition-base);
        }

        .service-features-list li i {
            color: var(--accent-500);
            font-size: 0.8rem;
            width: 18px;
        }

        .service-features-list li:hover {
            color: var(--neutral-900);
            transform: translateX(4px);
        }

        /* ===== PROCESS SECTION - REIMAGINED ===== */
        .process-section {
            padding: var(--space-20) 0;
            background: var(--neutral-50);
            position: relative;
            overflow: hidden;
        }

        .process-background {
            position: absolute;
            inset: 0;
            background: radial-gradient(circle at 20% 30%, var(--accent-soft) 0%, transparent 30%),
                        radial-gradient(circle at 80% 70%, var(--accent-soft) 0%, transparent 30%);
            opacity: 0.5;
        }

        .process-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: var(--space-6);
            position: relative;
            z-index: 2;
        }

        .process-timeline {
            position: relative;
        }

        .process-timeline::before {
            content: '';
            position: absolute;
            top: 60px;
            left: 60px;
            right: 60px;
            height: 2px;
            background: linear-gradient(90deg, transparent, var(--accent-500), var(--accent-300), var(--accent-500), transparent);
            opacity: 0.2;
        }

        .process-item {
            text-align: center;
            position: relative;
            padding: var(--space-6);
            background: var(--white);
            border-radius: var(--radius-2xl);
            border: 1px solid var(--neutral-200);
            transition: var(--transition-bounce);
        }

        .process-item:hover {
            transform: translateY(-12px);
            border-color: var(--accent-500);
            box-shadow: var(--shadow-2xl);
        }

        .process-number {
            width: 80px;
            height: 80px;
            background: linear-gradient(135deg, var(--neutral-100), var(--white));
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto var(--space-4);
            font-size: 2rem;
            font-weight: 700;
            color: var(--accent-500);
            border: 2px dashed var(--neutral-300);
            transition: var(--transition-bounce);
        }

        .process-item:hover .process-number {
            background: linear-gradient(135deg, var(--accent-500), var(--accent-400));
            color: var(--white);
            border-color: transparent;
            transform: scale(1.1) rotate(360deg);
        }

        .process-item h4 {
            font-size: 1.3rem;
            font-weight: 600;
            color: var(--neutral-900);
            margin-bottom: var(--space-2);
        }

        .process-item p {
            color: var(--neutral-500);
            font-size: 0.9rem;
            line-height: 1.7;
        }

        /* ===== CTA SECTION - CINEMATIC ===== */
        .cta-section {
            padding: var(--space-20) 0;
            background: linear-gradient(135deg, var(--primary-900), var(--primary-800));
            position: relative;
            overflow: hidden;
        }

        .cta-background {
            position: absolute;
            inset: 0;
        }

        .cta-grid {
            position: absolute;
            inset: 0;
            background-image: 
                linear-gradient(var(--accent-glow) 1px, transparent 1px),
                linear-gradient(90deg, var(--accent-glow) 1px, transparent 1px);
            background-size: 50px 50px;
            opacity: 0.1;
        }

        .cta-content {
            position: relative;
            z-index: 2;
            text-align: center;
            max-width: 800px;
            margin: 0 auto;
            color: var(--white);
        }

        .cta-badge {
            display: inline-flex;
            align-items: center;
            gap: var(--space-2);
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(8px);
            padding: var(--space-2) var(--space-6);
            border-radius: var(--radius-full);
            font-size: 0.875rem;
            font-weight: 600;
            letter-spacing: 0.1em;
            margin-bottom: var(--space-6);
            border: 1px solid rgba(255, 255, 255, 0.2);
        }

        .cta-title {
            font-size: clamp(2.5rem, 5vw, 4rem);
            font-weight: 700;
            margin-bottom: var(--space-4);
            line-height: 1.2;
        }

        .cta-title span {
            color: var(--accent-500);
            position: relative;
            display: inline-block;
        }

        .cta-title span::after {
            content: '';
            position: absolute;
            bottom: 0.1em;
            left: 0;
            width: 100%;
            height: 0.15em;
            background: linear-gradient(90deg, var(--accent-500), transparent);
        }

        .cta-text {
            font-size: 1.2rem;
            margin-bottom: var(--space-8);
            opacity: 0.9;
            line-height: 1.8;
        }

        .cta-button {
            display: inline-flex;
            align-items: center;
            gap: var(--space-3);
            background: var(--accent-500);
            color: var(--white);
            padding: var(--space-4) var(--space-10);
            border-radius: var(--radius-full);
            font-weight: 600;
            font-size: 1.1rem;
            text-decoration: none;
            transition: var(--transition-bounce);
            border: 2px solid transparent;
            box-shadow: var(--shadow-xl);
        }

        .cta-button:hover {
            background: transparent;
            border-color: var(--white);
            transform: translateY(-5px) scale(1.05);
            box-shadow: var(--shadow-2xl);
        }

        .cta-button i {
            transition: var(--transition-base);
        }

        .cta-button:hover i {
            transform: translateX(8px);
        }


        /* ===== RESPONSIVE ===== */
        @media (max-width: 1400px) {
            .services-grid {
                grid-template-columns: repeat(3, 1fr);
            }
        }

        @media (max-width: 1200px) {
            .hero-grid {
                grid-template-columns: 1fr;
                gap: var(--space-12);
            }
            
            .hero-visual {
                max-width: 600px;
                margin: 0 auto;
            }
            
            .services-grid {
                grid-template-columns: repeat(2, 1fr);
            }
            
            .process-grid {
                grid-template-columns: repeat(2, 1fr);
            }
        }

        @media (max-width: 1024px) {
            .category-grid,
            .footer-grid {
                grid-template-columns: repeat(2, 1fr);
            }
        }

        @media (max-width: 768px) {
            .container {
                padding: 0 var(--space-4);
            }
            
            .category-grid,
            .services-grid,
            .process-grid,
            .footer-grid {
                grid-template-columns: 1fr;
            }
            
            .hero-stats {
                flex-direction: column;
                gap: var(--space-4);
            }
            
            .visual-quote {
                position: relative;
                bottom: 0;
                left: 0;
                margin-top: var(--space-4);
                max-width: 100%;
            }
            
            .section-title {
                font-size: 2rem;
            }
            
            .cta-title {
                font-size: 2rem;
            }
            
            .cta-button {
                width: 100%;
                justify-content: center;
            }
            
            .footer-bottom {
                flex-direction: column;
                gap: var(--space-4);
                text-align: center;
            }
        }
    </style>
</head>
<body>
    <!-- Loader -->
    <div class="page-loader" id="loader">
        <div class="loader-logo">
            <i class="fas fa-globe-africa"></i>
        </div>
    </div>

    <!-- Cursor Effects -->
    <div class="cursor-dot" id="cursorDot"></div>
    <div class="cursor-outline" id="cursorOutline"></div>

    <!-- Navbar -->


    <!-- Hero Section -->
    <section class="hero">
        <div class="hero-background">
            <div class="hero-gradient"></div>
            <div class="hero-particles">
                <?php for($i = 0; $i < 30; $i++): ?>
                <div class="particle" style="
                    left: <?= rand(0, 100) ?>%;
                    animation-duration: <?= rand(10, 30) ?>s;
                    animation-delay: -<?= rand(0, 20) ?>s;
                "></div>
                <?php endfor; ?>
            </div>
        </div>
        
        <div class="container">
            <div class="hero-grid">
                <div class="hero-content" data-aos="fade-up" data-aos-duration="1000">
                    <div class="hero-badge">
                        <i class="fas fa-bolt"></i>
                        <span>TRUSTED BY 50+ GLOBAL COMPANIES</span>
                    </div>
                    
                    <h1 class="hero-title">
                        <span class="hero-title-line">Elevate Your</span>
                        <span class="hero-title-line-accent">Workforce</span>
                        <span class="hero-title-line">with Premium HR</span>
                    </h1>
                    
                    <p class="hero-subtitle">
                        End-to-end talent and HR services designed to connect Kenyan excellence with global opportunities. 
                        We don't just fill positions — we build careers and transform organizations.
                    </p>
                    
                    <div class="hero-stats">
                        <div class="stat-card">
                            <div class="stat-number-wrapper">
                                500<span class="stat-suffix">+</span>
                            </div>
                            <div class="stat-label">Placements</div>
                        </div>
                        <div class="stat-card">
                            <div class="stat-number-wrapper">
                                92<span class="stat-suffix">%</span>
                            </div>
                            <div class="stat-label">Retention Rate</div>
                        </div>
                        <div class="stat-card">
                            <div class="stat-number-wrapper">
                                15<span class="stat-suffix">+</span>
                            </div>
                            <div class="stat-label">Global Partners</div>
                        </div>
                    </div>
                </div>
                
                <div class="hero-visual" data-aos="fade-left" data-aos-duration="1000">
                    <div class="visual-wrapper">
                        <div class="visual-card">
                            <img src="https://images.unsplash.com/photo-1552664730-d307ca884978?ixlib=rb-4.0.3&auto=format&fit=crop&w=1470&q=80" alt="Bright Orbit HR Solutions">
                        </div>
                        <div class="visual-quote">
                            <i class="fas fa-quote-left"></i>
                            <p>"Connecting Worlds, Nurturing Careers"</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Service Categories -->
    <section class="services-overview">
        <div class="container">
            <div class="section-header" data-aos="fade-up" data-aos-duration="1000">
                <div class="section-eyebrow">What We Offer</div>
                <h2 class="section-title">
                    Comprehensive <span class="highlight">HR Solutions</span>
                </h2>
                <p class="section-desc">
                    Tailored services designed to meet the unique needs of both employers and job seekers, 
                    bridging the gap between Kenyan talent and global opportunities.
                </p>
            </div>
            
            <div class="category-grid">
                <!-- Category 1 -->
                <div class="category-card" data-aos="fade-up" data-aos-duration="1000" data-aos-delay="100">
                    <div class="category-header">
                        <div class="category-icon">
                            <i class="fas fa-users"></i>
                        </div>
                        <h3 class="category-title">Recruitment & Talent</h3>
                    </div>
                    <div class="category-services">
                        <div class="category-service-item">
                            <i class="fas fa-check"></i>
                            <span>Global Recruitment</span>
                        </div>
                        <div class="category-service-item">
                            <i class="fas fa-check"></i>
                            <span>HR Recruitment</span>
                        </div>
                        <div class="category-service-item">
                            <i class="fas fa-check"></i>
                            <span>Talent Management</span>
                        </div>
                    </div>
                </div>
                
                <!-- Category 2 -->
                <div class="category-card" data-aos="fade-up" data-aos-duration="1000" data-aos-delay="200">
                    <div class="category-header">
                        <div class="category-icon">
                            <i class="fas fa-graduation-cap"></i>
                        </div>
                        <h3 class="category-title">Development & Coaching</h3>
                    </div>
                    <div class="category-services">
                        <div class="category-service-item">
                            <i class="fas fa-check"></i>
                            <span>Career Development</span>
                        </div>
                        <div class="category-service-item">
                            <i class="fas fa-check"></i>
                            <span>Executive Coaching</span>
                        </div>
                        <div class="category-service-item">
                            <i class="fas fa-check"></i>
                            <span>DEI Training</span>
                        </div>
                    </div>
                </div>
                
                <!-- Category 3 -->
                <div class="category-card" data-aos="fade-up" data-aos-duration="1000" data-aos-delay="300">
                    <div class="category-header">
                        <div class="category-icon">
                            <i class="fas fa-chart-line"></i>
                        </div>
                        <h3 class="category-title">Business Solutions</h3>
                    </div>
                    <div class="category-services">
                        <div class="category-service-item">
                            <i class="fas fa-check"></i>
                            <span>Marketing & Social Media</span>
                        </div>
                        <div class="category-service-item">
                            <i class="fas fa-check"></i>
                            <span>HR Consulting</span>
                        </div>
                        <div class="category-service-item">
                            <i class="fas fa-check"></i>
                            <span>Strategic Partnerships</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Detailed Services -->
    <section class="detailed-services">
        <div class="container">
            <div class="section-header" data-aos="fade-up" data-aos-duration="1000">
                <div class="section-eyebrow">Our Expertise</div>
                <h2 class="section-title">
                    Complete Service <span class="highlight">Portfolio</span>
                </h2>
                <p class="section-desc">
                    Discover how our specialized services can transform your workforce and accelerate your career.
                </p>
            </div>
            
            <div class="services-grid">
                <!-- Service Cards -->
                <?php
                $services = [
                    ['icon' => 'fas fa-globe-africa', 'title' => 'Global Recruitment', 'desc' => 'Connect Kenyan top talent with international opportunities across Africa, Europe, and North America.', 'features' => ['International placements', 'Cross-cultural integration', 'Visa & relocation support']],
                    ['icon' => 'fas fa-user-tie', 'title' => 'HR Recruitment', 'desc' => 'Specialized recruitment for human resources professionals across all industries and levels.', 'features' => ['HR generalists & specialists', 'Talent acquisition experts', 'HR leadership roles']],
                    ['icon' => 'fas fa-chart-pie', 'title' => 'Talent Management', 'desc' => 'End-to-end workforce solutions from sourcing and retention to succession planning.', 'features' => ['Workforce planning', 'Performance management', 'Employee retention']],
                    ['icon' => 'fas fa-hand-holding-heart', 'title' => 'Diversity, Equity & Inclusion', 'desc' => 'Transform your workplace culture with comprehensive DEI training and consulting.', 'features' => ['Unconscious bias training', 'Inclusive leadership', 'Cultural competence']],
                    ['icon' => 'fas fa-graduation-cap', 'title' => 'Career Development', 'desc' => 'Empower professionals with mentorship programs and skill enhancement opportunities.', 'features' => ['Professional mentoring', 'Skills assessment', 'Career pathing']],
                    ['icon' => 'fas fa-crown', 'title' => 'Executive Coaching', 'desc' => 'One-on-one coaching for leaders to unlock potential and drive organizational success.', 'features' => ['Leadership development', 'Strategic thinking', 'Executive presence']],
                    ['icon' => 'fas fa-bullhorn', 'title' => 'Marketing & Social Media', 'desc' => 'Strategic digital marketing solutions to enhance employer branding and recruitment.', 'features' => ['Employer branding', 'Social media strategy', 'Content marketing']],
                    ['icon' => 'fas fa-chart-line', 'title' => 'HR Consulting', 'desc' => 'Strategic HR advisory services for organizations seeking to optimize their human capital.', 'features' => ['HR strategy', 'Policy development', 'Compliance & audits']]
                ];
                
                foreach($services as $index => $service):
                    $delay = 50 + ($index * 50);
                ?>
                <div class="service-card" data-aos="fade-up" data-aos-duration="1000" data-aos-delay="<?= $delay ?>">
                    <div class="service-icon-wrapper">
                        <i class="<?= $service['icon'] ?> service-icon"></i>
                    </div>
                    <h3><?= $service['title'] ?></h3>
                    <p><?= $service['desc'] ?></p>
                    <ul class="service-features-list">
                        <?php foreach($service['features'] as $feature): ?>
                        <li><i class="fas fa-check-circle"></i> <?= $feature ?></li>
                        <?php endforeach; ?>
                    </ul>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
    </section>

    <!-- Process Section -->
    <section class="process-section">
        <div class="process-background"></div>
        <div class="container">
            <div class="section-header" data-aos="fade-up" data-aos-duration="1000">
                <div class="section-eyebrow">How We Work</div>
                <h2 class="section-title">
                    Our <span class="highlight">Process</span>
                </h2>
                <p class="section-desc">
                    A proven methodology that ensures successful outcomes for both employers and candidates.
                </p>
            </div>
            
            <div class="process-grid">
                <div class="process-item" data-aos="fade-up" data-aos-duration="1000" data-aos-delay="100">
                    <div class="process-number">01</div>
                    <h4>Discovery</h4>
                    <p>We listen to understand your unique needs, culture, and goals through in-depth consultation.</p>
                </div>
                <div class="process-item" data-aos="fade-up" data-aos-duration="1000" data-aos-delay="200">
                    <div class="process-number">02</div>
                    <h4>Strategy</h4>
                    <p>We develop a customized approach tailored to your objectives and timeline.</p>
                </div>
                <div class="process-item" data-aos="fade-up" data-aos-duration="1000" data-aos-delay="300">
                    <div class="process-number">03</div>
                    <h4>Execution</h4>
                    <p>We deliver exceptional talent and innovative HR solutions with precision.</p>
                </div>
                <div class="process-item" data-aos="fade-up" data-aos-duration="1000" data-aos-delay="400">
                    <div class="process-number">04</div>
                    <h4>Optimization</h4>
                    <p>We continuously evaluate and refine for lasting success and growth.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="cta-section">
        <div class="cta-background">
            <div class="cta-grid"></div>
        </div>
        <div class="container">
            <div class="cta-content" data-aos="zoom-in" data-aos-duration="1200">
                <div class="cta-badge">
                    <i class="fas fa-rocket"></i>
                    GET STARTED TODAY
                </div>
                <h2 class="cta-title">
                    Join Us on <span>Our Journey</span>
                </h2>
                <p class="cta-text">
                    Partner with us to empower careers, foster diversity, and make meaningful impact on the world. 
                    Together, let's explore new horizons and create a brighter future.
                </p>
                <a href="/brightorbit/consult" class="cta-button">
                    <span>Schedule Free Consultation</span>
                    <i class="fas fa-arrow-right"></i>
                </a>
            </div>
        </div>
    </section>

    <!-- Footer -->
 <?php require_once __DIR__ . '/../layout/footer.php'; ?>
    <!-- Scripts -->
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script>
        // Initialize AOS
        AOS.init({
            once: true,
            offset: 100,
            duration: 800,
            easing: 'ease-out-cubic'
        });

        // Hide loader
        window.addEventListener('load', () => {
            gsap.to('.page-loader', {
                opacity: 0,
                duration: 0.5,
                delay: 0.5,
                onComplete: () => {
                    document.querySelector('.page-loader').style.display = 'none';
                }
            });
        });

        // GSAP Animations
        gsap.registerPlugin(ScrollTrigger, TextPlugin);

        // Animate stats
        gsap.from('.stat-number-wrapper', {
            scrollTrigger: {
                trigger: '.hero-stats',
                start: 'top 80%',
                toggleActions: 'play none none reverse'
            },
            duration: 1.5,
            ease: 'power2.out',
            innerHTML: 0,
            snap: { innerHTML: 1 },
            stagger: 0.2
        });

        // Parallax effect
        gsap.to('.hero-visual', {
            scrollTrigger: {
                trigger: '.hero',
                start: 'top top',
                end: 'bottom top',
                scrub: true
            },
            y: 100,
            scale: 0.95
        });

        // Cursor effects
        const cursorDot = document.querySelector('.cursor-dot');
        const cursorOutline = document.querySelector('.cursor-outline');

        document.addEventListener('mousemove', (e) => {
            cursorDot.style.left = e.clientX + 'px';
            cursorDot.style.top = e.clientY + 'px';
            
            cursorOutline.style.left = e.clientX + 'px';
            cursorOutline.style.top = e.clientY + 'px';
        });

        // Navbar scroll effect
        const navbar = document.getElementById('navbar');
        window.addEventListener('scroll', () => {
            if (window.scrollY > 50) {
                navbar.classList.add('scrolled');
            } else {
                navbar.classList.remove('scrolled');
            }
        });

        // Smooth scroll
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
    </script>
</body>
</html>