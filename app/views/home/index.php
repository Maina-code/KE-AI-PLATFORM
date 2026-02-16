<?php
require_once __DIR__ . '/../layout/navbar.php';
require_once __DIR__ . '/../layout/loading.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($title ?? 'Bright Orbit Consultancy - Connecting Worlds, Nurturing Careers') ?></title>
    <meta name="description" content="<?= htmlspecialchars($meta_description ?? 'Global HR consultancy bridging Kenya top talent with international businesses') ?>">
    
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
            /* Brand Colors - Extracted from BOCLOGO1.png */
            --logo-navy: #0a2a44;
            --logo-teal: #CC5500;
            --logo-gray: #4a5568;
            
            /* Extended Palette */
            --navy: var(--logo-navy);
            --navy-light: #1e3a5a;
            --navy-dark: #051a2c;
            --teal: var(--logo-teal);
            --teal-light: #e68a2e;
            --teal-dark: #b34700;
            --teal-soft: rgba(204,85,0,0.08);
            --teal-glow: rgba(204,85,0,0.15);
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

        /* ===== HERO SECTION - FULL WIDTH ===== */
        .hero {
            position: relative;
            width: 100%;
            height: 100vh;
            min-height: 700px;
            overflow: hidden;
        }

        /* Fullscreen Slider */
        .hero-slider {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
        }

        .slider-container {
            position: relative;
            width: 100%;
            height: 100%;
        }

        .slider-slide {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            opacity: 0;
            transition: opacity 1.5s ease-in-out;
            display: flex;
            align-items: center;
            justify-content: flex-start;
            padding: 0 5%;
            color: white;
        }

        .slider-slide.active {
            opacity: 1;
            z-index: 2;
        }

        /* Dark overlay for text readability */
        .slider-slide::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, rgba(10,42,68,0.85) 0%, rgba(10,42,68,0.4) 70%, rgba(0,0,0,0.2) 100%);
            z-index: 1;
        }

        .slide-content {
            position: relative;
            z-index: 3;
            max-width: 700px;
            transform: translateY(30px);
            opacity: 0;
            transition: all 0.8s ease-out 0.3s;
        }

        .slider-slide.active .slide-content {
            transform: translateY(0);
            opacity: 1;
        }

        .slide-tag {
            display: inline-block;
            background: var(--teal);
            color: white;
            padding: 0.6rem 1.8rem;
            border-radius: var(--border-radius-full);
            font-size: 0.9rem;
            font-weight: 600;
            letter-spacing: 2px;
            margin-bottom: 1.5rem;
            text-transform: uppercase;
            box-shadow: 0 10px 20px rgba(0,0,0,0.2);
            animation: fadeInUp 0.8s ease-out;
        }

        .slide-title {
            font-size: 4.5rem;
            font-weight: 800;
            line-height: 1.1;
            letter-spacing: -2px;
            margin-bottom: 1.2rem;
            text-shadow: 2px 2px 20px rgba(0,0,0,0.3);
            animation: fadeInUp 0.8s ease-out 0.1s both;
        }

        .slide-title span {
            color: var(--teal);
            border-bottom: 4px solid var(--teal);
            display: inline-block;
            padding-bottom: 5px;
        }

        .slide-desc {
            font-size: 1.3rem;
            opacity: 0.9;
            line-height: 1.8;
            margin-bottom: 2.5rem;
            max-width: 600px;
            animation: fadeInUp 0.8s ease-out 0.2s both;
        }

        .slide-btn {
            display: inline-flex;
            align-items: center;
            gap: 1rem;
            background: var(--teal);
            color: white;
            padding: 1.2rem 3rem;
            border-radius: var(--border-radius-full);
            font-weight: 700;
            font-size: 1.1rem;
            text-decoration: none;
            transition: var(--transition);
            border: 2px solid var(--teal);
            animation: fadeInUp 0.8s ease-out 0.3s both;
        }

        .slide-btn:hover {
            background: transparent;
            color: white;
            border-color: white;
            transform: translateY(-5px);
            box-shadow: 0 20px 30px rgba(0,0,0,0.3);
        }

        .slide-btn i {
            transition: var(--transition);
        }

        .slide-btn:hover i {
            transform: translateX(8px);
        }

        /* Slider Navigation */
        .slider-dots {
            position: absolute;
            bottom: 40px;
            left: 50%;
            transform: translateX(-50%);
            display: flex;
            gap: 15px;
            z-index: 10;
        }

        .dot {
            width: 14px;
            height: 14px;
            background: rgba(255,255,255,0.4);
            border-radius: 50%;
            cursor: pointer;
            transition: var(--transition);
            border: 2px solid transparent;
        }

        .dot.active {
            background: var(--teal);
            width: 40px;
            border-radius: 20px;
            border-color: white;
            box-shadow: 0 0 20px var(--teal);
        }

        .dot:hover {
            background: white;
            transform: scale(1.2);
        }

        .slider-arrow {
            position: absolute;
            top: 50%;
            transform: translateY(-50%);
            width: 60px;
            height: 60px;
            background: rgba(255,255,255,0.15);
            backdrop-filter: blur(8px);
            border: 2px solid rgba(255,255,255,0.3);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 1.5rem;
            cursor: pointer;
            transition: var(--transition);
            z-index: 20;
            box-shadow: 0 10px 30px rgba(0,0,0,0.2);
        }

        .slider-arrow:hover {
            background: var(--teal);
            border-color: white;
            transform: translateY(-50%) scale(1.1);
        }

        .slider-arrow.prev {
            left: 30px;
        }

        .slider-arrow.next {
            right: 30px;
        }

        /* Hero Overlay Content */
        .hero-overlay-content {
            position: absolute;
            bottom: 100px;
            left: 5%;
            right: 5%;
            z-index: 15;
            display: flex;
            justify-content: space-between;
            align-items: flex-end;
            color: white;
            pointer-events: none;
        }

        .hero-badge {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            background: rgba(255,255,255,0.15);
            backdrop-filter: blur(10px);
            color: white;
            padding: 0.8rem 2rem;
            border-radius: var(--border-radius-full);
            font-weight: 600;
            font-size: 1rem;
            border: 1px solid rgba(255,255,255,0.3);
            pointer-events: auto;
        }

        .hero-stats-mini {
            display: flex;
            gap: 2.5rem;
            background: rgba(10,42,68,0.8);
            backdrop-filter: blur(10px);
            padding: 1.5rem 2.5rem;
            border-radius: var(--border-radius);
            border: 1px solid rgba(255,255,255,0.1);
            pointer-events: auto;
        }

        .hero-stat-item {
            text-align: center;
        }

        .hero-stat-number {
            font-size: 1.8rem;
            font-weight: 800;
            color: var(--teal);
            line-height: 1;
        }

        .hero-stat-label {
            font-size: 0.8rem;
            text-transform: uppercase;
            letter-spacing: 1px;
            opacity: 0.8;
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

        /* ===== WHY CHOOSE US SECTION ===== */
        .why-choose-us {
            padding: 8rem 0;
            background: var(--white);
            position: relative;
            overflow: hidden;
        }

        .why-choose-us::before {
            content: '';
            position: absolute;
            top: -20%;
            right: -10%;
            width: 60%;
            height: 140%;
            background: radial-gradient(circle, rgba(204,85,0,0.03) 0%, transparent 70%);
            border-radius: 50%;
            pointer-events: none;
        }

        .why-header {
            text-align: center;
            max-width: 700px;
            margin: 0 auto 5rem;
        }

        .why-tag {
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
        }

        .why-title {
            font-size: 3.2rem;
            font-weight: 800;
            color: var(--navy);
            line-height: 1.2;
            margin-bottom: 1.5rem;
            letter-spacing: -1px;
        }

        .why-title span {
            color: var(--teal);
            position: relative;
            display: inline-block;
        }

        .why-title span::after {
            content: '';
            position: absolute;
            bottom: 10px;
            left: 0;
            width: 100%;
            height: 8px;
            background: rgba(204,85,0,0.2);
            z-index: -1;
        }

        .why-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 2.5rem;
            margin-top: 3rem;
        }

        .why-card {
            background: var(--white);
            padding: 3rem 2.5rem;
            border-radius: var(--border-radius);
            border: 1px solid var(--gray-light);
            transition: var(--transition);
            position: relative;
            overflow: hidden;
            box-shadow: var(--shadow-md);
            text-align: center;
        }

        .why-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: linear-gradient(145deg, var(--teal-soft), transparent);
            opacity: 0;
            transition: var(--transition);
        }

        .why-card:hover {
            transform: translateY(-20px);
            border-color: var(--teal);
            box-shadow: var(--shadow-xl);
        }

        .why-card:hover::before {
            opacity: 1;
        }

        .why-icon-wrapper {
            width: 100px;
            height: 100px;
            background: linear-gradient(145deg, var(--sky-light), var(--white));
            border-radius: 30px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 2rem;
            border: 1px solid var(--gray-light);
            transition: var(--transition);
            position: relative;
            z-index: 2;
        }

        .why-card:hover .why-icon-wrapper {
            background: var(--teal);
            border-color: var(--teal);
            transform: rotate(5deg) scale(1.1);
        }

        .why-icon {
            font-size: 3rem;
            color: var(--teal);
            transition: var(--transition);
        }

        .why-card:hover .why-icon {
            color: white;
        }

        .why-card h3 {
            font-size: 1.6rem;
            font-weight: 700;
            color: var(--navy);
            margin-bottom: 1.2rem;
            position: relative;
            z-index: 2;
        }

        .why-card p {
            color: var(--gray);
            font-size: 1rem;
            line-height: 1.8;
            margin-bottom: 1.5rem;
            position: relative;
            z-index: 2;
        }

        .why-features {
            list-style: none;
            padding: 0;
            text-align: left;
            margin-top: 1.5rem;
            position: relative;
            z-index: 2;
        }

        .why-features li {
            display: flex;
            align-items: center;
            gap: 0.8rem;
            padding: 0.5rem 0;
            color: var(--gray);
            border-bottom: 1px dashed var(--gray-light);
        }

        .why-features li:last-child {
            border-bottom: none;
        }

        .why-features li i {
            color: var(--teal);
            font-size: 1rem;
            width: 20px;
        }

        .why-features li span {
            flex: 1;
            font-size: 0.95rem;
        }

        /* ===== STATS BANNER ===== */
        .stats-banner {
            padding: 4rem 0;
            background: linear-gradient(145deg, var(--navy), var(--navy-dark));
            color: white;
            margin-top:-5rem;
        }

        .stats-banner-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 2rem;
            text-align: center;
        }

        .stats-banner-item {
            padding: 1.5rem;
            border-right: 1px solid rgba(255,255,255,0.1);
        }

        .stats-banner-item:last-child {
            border-right: none;
        }

        .stats-banner-number {
            font-size: 3rem;
            font-weight: 800;
            color: var(--teal);
            line-height: 1;
            margin-bottom: 0.5rem;
        }

        .stats-banner-label {
            font-size: 1rem;
            text-transform: uppercase;
            letter-spacing: 2px;
            opacity: 0.9;
        }

        /* ===== EXISTING STYLES (maintained) ===== */
        .mission { padding: 6rem 0; background: var(--white); }
        .mission-grid { display: grid; grid-template-columns: repeat(2, 1fr); gap: 2.5rem; margin-bottom: 3rem; }
        .mission-card { background: linear-gradient(145deg, var(--sky-light), var(--white)); padding: 3rem; border-radius: var(--border-radius); border: 1px solid var(--gray-light); transition: var(--transition); position: relative; overflow: hidden; }
        .mission-card::before { content: ''; position: absolute; top: 0; left: 0; width: 4px; height: 0; background: var(--teal); transition: var(--transition); }
        .mission-card:hover { transform: translateY(-10px); box-shadow: var(--shadow-xl); border-color: var(--teal); }
        .mission-card:hover::before { height: 100%; }
        .mission-icon { width: 70px; height: 70px; background: linear-gradient(145deg, var(--sky-light), var(--white)); border-radius: 20px; display: flex; align-items: center; justify-content: center; color: var(--teal); font-size: 2rem; margin-bottom: 1.8rem; border: 1px solid var(--gray-light); transition: var(--transition); }
        .mission-card:hover .mission-icon { background: var(--teal); color: white; border-color: var(--teal); transform: rotate(5deg); }
        .mission-card h2 { font-size: 1.8rem; font-weight: 700; margin-bottom: 1.2rem; color: var(--navy); }
        .mission-card p { color: var(--gray); font-size: 1.1rem; line-height: 1.8; }
        .tagline { text-align: center; font-size: 2rem; font-weight: 600; color: var(--teal); font-style: italic; padding: 2.5rem 0 0; border-top: 2px dashed var(--gray-light); position: relative; }
        .tagline i { color: var(--teal); opacity: 0.3; font-size: 2.5rem; position: absolute; left: 50%; top: -20px; transform: translateX(-50%); background: white; padding: 0 1rem; }

        .services { padding: 6rem 0; background: var(--gray-bg); }
        .section-header { text-align: center; max-width: 700px; margin: 0 auto 4rem; }
        .section-tag { display: inline-block; background: rgba(204,85,0,0.08); color: var(--teal); padding: 0.5rem 1.5rem; border-radius: var(--border-radius-full); font-weight: 600; font-size: 0.9rem; text-transform: uppercase; letter-spacing: 2px; margin-bottom: 1rem; }
        .section-title { font-size: 2.8rem; font-weight: 800; color: var(--navy); line-height: 1.2; margin-bottom: 1rem; }
        .section-title span { color: var(--teal); }
        .section-desc { color: var(--gray); font-size: 1.1rem; line-height: 1.8; }

        .services-grid { display: grid; grid-template-columns: repeat(4, 1fr); gap: 2rem; margin-top: 2rem; }
        .service-card { background: var(--white); padding: 2.5rem; border-radius: var(--border-radius); border: 1px solid var(--gray-light); transition: var(--transition); text-align: center; position: relative; overflow: hidden; }
        .service-card::before { content: ''; position: absolute; top: 0; left: 0; width: 100%; height: 4px; background: var(--teal); transform: scaleX(0); transition: var(--transition); }
        .service-card:hover { transform: translateY(-10px); box-shadow: var(--shadow-xl); border-color: var(--teal); }
        .service-card:hover::before { transform: scaleX(1); }
        .service-icon { width: 80px; height: 80px; background: linear-gradient(145deg, var(--sky-light), var(--white)); border-radius: 30px; display: flex; align-items: center; justify-content: center; color: var(--teal); font-size: 2.2rem; margin: 0 auto 1.8rem; border: 1px solid var(--gray-light); transition: var(--transition); }
        .service-card:hover .service-icon { background: var(--teal); color: white; border-color: var(--teal); transform: rotate(5deg) scale(1.1); }
        .service-card h3 { font-size: 1.3rem; font-weight: 700; margin-bottom: 1rem; color: var(--navy); }
        .service-card p { color: var(--gray); font-size: 0.95rem; line-height: 1.7; margin-bottom: 1.5rem; }
        .service-link { color: var(--teal); font-weight: 600; text-decoration: none; display: inline-flex; align-items: center; gap: 0.5rem; transition: var(--transition); }
        .service-link:hover { gap: 1rem; color: var(--teal-dark); }

        .team { padding: 6rem 0; background: var(--white); }
        .team-grid { display: grid; grid-template-columns: repeat(4, 1fr); gap: 2rem; margin-top: 3rem; }
        .team-card { background: var(--white); border-radius: var(--border-radius); overflow: hidden; border: 1px solid var(--gray-light); transition: var(--transition); }
        .team-card:hover { transform: translateY(-10px); border-color: var(--teal); box-shadow: var(--shadow-xl); }
        .team-image { position: relative; height: 280px; overflow: hidden; }
        .team-image-bg { width: 100%; height: 100%; background: linear-gradient(145deg, var(--navy), var(--teal)); display: flex; align-items: center; justify-content: center; transition: var(--transition); }
        .team-card:hover .team-image-bg { transform: scale(1.1); }
        .team-avatar { font-size: 4rem; color: white; opacity: 0.9; }
        .team-social { position: absolute; bottom: -50px; left: 0; width: 100%; display: flex; justify-content: center; gap: 1rem; padding: 1rem; background: linear-gradient(to top, rgba(0,0,0,0.8), transparent); transition: var(--transition); }
        .team-card:hover .team-social { bottom: 0; }
        .team-social a { width: 40px; height: 40px; background: white; border-radius: 50%; display: flex; align-items: center; justify-content: center; color: var(--navy); transition: var(--transition); }
        .team-social a:hover { background: var(--teal); color: white; transform: translateY(-5px); }
        .team-info { padding: 1.8rem; text-align: center; }
        .team-name { font-size: 1.3rem; font-weight: 700; color: var(--navy); margin-bottom: 0.3rem; }
        .team-position { display: inline-block; color: var(--teal); font-weight: 600; font-size: 0.85rem; text-transform: uppercase; letter-spacing: 1px; margin-bottom: 0.8rem; }
        .team-bio { color: var(--gray); font-size: 0.9rem; line-height: 1.6; }

        .testimonials { padding: 6rem 0; background: linear-gradient(145deg, var(--navy), var(--navy-dark)); color: white; position: relative; overflow: hidden; }
        .testimonials::before { content: ''; position: absolute; top: -50%; right: -20%; width: 80%; height: 200%; background: radial-gradient(circle, rgba(204,85,0,0.1) 0%, transparent 70%); border-radius: 50%; }
        .testimonials .section-title { color: white; }
        .testimonials-grid { display: grid; grid-template-columns: repeat(2, 1fr); gap: 2rem; margin-top: 3rem; position: relative; z-index: 2; }
        .testimonial-card { background: rgba(255,255,255,0.08); padding: 2.5rem; border-radius: var(--border-radius); border: 1px solid rgba(255,255,255,0.1); backdrop-filter: blur(10px); transition: var(--transition); }
        .testimonial-card:hover { transform: translateY(-10px); border-color: var(--teal); background: rgba(255,255,255,0.12); }
        .testimonial-content { font-size: 1.1rem; line-height: 1.8; margin-bottom: 1.5rem; font-style: italic; position: relative; }
        .testimonial-content i { color: var(--teal); opacity: 0.3; font-size: 2rem; margin-right: 0.5rem; }
        .testimonial-author { display: flex; flex-direction: column; }
        .testimonial-name { font-weight: 700; font-size: 1.1rem; }
        .testimonial-company { color: rgba(255,255,255,0.7); font-size: 0.9rem; }
        .rating { color: #ffc107; margin-top: 0.5rem; }

        .cta { padding: 6rem 0; background: linear-gradient(145deg, var(--teal), var(--navy)); color: white; text-align: center; position: relative; overflow: hidden; }
        .cta::before { content: ''; position: absolute; top: -50%; left: -20%; width: 80%; height: 200%; background: radial-gradient(circle, rgba(255,255,255,0.1) 0%, transparent 70%); border-radius: 50%; }
        .cta .container { position: relative; z-index: 2; }
        .cta h2 { font-size: 3rem; font-weight: 800; margin-bottom: 1rem; }
        .cta p { font-size: 1.2rem; margin-bottom: 2.5rem; opacity: 0.9; }
        .cta .btn-primary { background: white; color: var(--navy); border: none; padding: 1.2rem 3rem; font-size: 1.1rem; border-radius: var(--border-radius-full); text-decoration: none; display: inline-flex; align-items: center; gap: 0.75rem; transition: var(--transition); }
        .cta .btn-primary:hover { background: var(--sky-light); transform: translateY(-5px); box-shadow: 0 20px 30px rgba(0,0,0,0.2); }

        /* ===== RESPONSIVE ===== */
        @media (max-width: 1200px) {
            .why-grid,
            .services-grid,
            .team-grid {
                grid-template-columns: repeat(3, 1fr);
            }
            .stats-banner-grid {
                grid-template-columns: repeat(2, 1fr);
            }
        }

        @media (max-width: 1024px) {
            .hero .container {
                grid-template-columns: 1fr;
                gap: 3rem;
            }
            .slide-title {
                font-size: 3.5rem;
            }
            .services-grid {
                grid-template-columns: repeat(2, 1fr);
            }
            .team-grid {
                grid-template-columns: repeat(2, 1fr);
            }
            .hero-overlay-content {
                flex-direction: column;
                align-items: flex-start;
                gap: 1.5rem;
                bottom: 50px;
            }
            .slider-arrow {
                width: 50px;
                height: 50px;
            }
        }

        @media (max-width: 768px) {
            .container {
                padding: 0 1.5rem;
            }
            .slide-title {
                font-size: 2.5rem;
            }
            .slide-desc {
                font-size: 1.1rem;
            }
            .why-grid,
            .services-grid,
            .team-grid,
            .testimonials-grid,
            .stats-banner-grid {
                grid-template-columns: 1fr;
            }
            .mission-grid {
                grid-template-columns: 1fr;
            }
            .hero-stats-mini {
                flex-wrap: wrap;
                gap: 1rem;
                padding: 1rem;
            }
            .slider-arrow {
                width: 40px;
                height: 40px;
                font-size: 1rem;
            }
            .slider-arrow.prev {
                left: 10px;
            }
            .slider-arrow.next {
                right: 10px;
            }
            .why-card {
                padding: 2rem;
            }
            .section-title {
                font-size: 2.2rem;
            }
            .cta h2 {
                font-size: 2rem;
            }
        }

        @media (max-width: 480px) {
            .slide-title {
                font-size: 2rem;
            }
            .slide-tag {
                font-size: 0.8rem;
                padding: 0.4rem 1.2rem;
            }
            .slide-btn {
                padding: 1rem 2rem;
                font-size: 1rem;
            }
            .dot {
                width: 10px;
                height: 10px;
            }
            .dot.active {
                width: 30px;
            }
            .hero-overlay-content {
                bottom: 30px;
            }
            .hero-badge {
                padding: 0.6rem 1.2rem;
                font-size: 0.8rem;
            }
        }
    </style>
</head>
<body>
    <!-- Hero Section - Full Width Slider -->
    <section class="hero" id="home">
        <div class="hero-slider">
            <div class="slider-container" id="heroSlider">
                <!-- Slide 1: Global Recruitment -->
                <div class="slider-slide active" style="background-image: url('https://images.unsplash.com/photo-1521791136064-7986c2920216?ixlib=rb-4.0.3&auto=format&fit=crop&w=1469&q=80');">
                    <div class="slide-content">
                        <span class="slide-tag">Global Recruitment</span>
                        <h1 class="slide-title">Connecting <span>Kenya</span> to the World</h1>
                        <p class="slide-desc">Bridging exceptional Kenyan talent with leading global organizations across Africa, Europe, and North America.</p>
                        <a href="/brightorbit/solutions" class="slide-btn">
                            Explore Opportunities <i class="fas fa-arrow-right"></i>
                        </a>
                    </div>
                </div>
                
                <!-- Slide 2: HR Consulting -->
                <div class="slider-slide" style="background-image: url('https://images.unsplash.com/photo-1552664730-d307ca884978?ixlib=rb-4.0.3&auto=format&fit=crop&w=1470&q=80');">
                    <div class="slide-content">
                        <span class="slide-tag">HR Consulting</span>
                        <h1 class="slide-title">Strategic <span>Workforce</span> Solutions</h1>
                        <p class="slide-desc">Building inclusive, high-performing teams through expert HR strategy and organizational development.</p>
                        <a href="/brightorbit/solutions" class="slide-btn">
                            Learn More <i class="fas fa-arrow-right"></i>
                        </a>
                    </div>
                </div>
                
                <!-- Slide 3: Career Development -->
                <div class="slider-slide" style="background-image: url('https://images.unsplash.com/photo-1524178232363-1fb2b075b655?ixlib=rb-4.0.3&auto=format&fit=crop&w=1470&q=80');">
                    <div class="slide-content">
                        <span class="slide-tag">Career Development</span>
                        <h1 class="slide-title">Nurturing <span>Future</span> Leaders</h1>
                        <p class="slide-desc">Mentorship programs and professional development for career advancement and skill enhancement.</p>
                        <a href="/brightorbit/solutions" class="slide-btn">
                            Start Your Journey <i class="fas fa-arrow-right"></i>
                        </a>
                    </div>
                </div>
                
                <!-- Slide 4: Talent Management -->
                <div class="slider-slide" style="background-image: url('https://images.unsplash.com/photo-1600880292203-757bb62b4baf?ixlib=rb-4.0.3&auto=format&fit=crop&w=1470&q=80');">
                    <div class="slide-content">
                        <span class="slide-tag">Talent Management</span>
                        <h1 class="slide-title">End-to-End <span>Workforce</span> Solutions</h1>
                        <p class="slide-desc">From sourcing to retention, we optimize your most valuable asset – your people.</p>
                        <a href="/brightorbit/solutions" class="slide-btn">
                            Discover More <i class="fas fa-arrow-right"></i>
                        </a>
                    </div>
                </div>
                
                <!-- Slide 5: DEI Training -->
                <div class="slider-slide" style="background-image: url('https://images.unsplash.com/photo-1551836022-d5d88e9218df?ixlib=rb-4.0.3&auto=format&fit=crop&w=1470&q=80');">
                    <div class="slide-content">
                        <span class="slide-tag">Diversity & Inclusion</span>
                        <h1 class="slide-title">Building <span>Inclusive</span> Workplaces</h1>
                        <p class="slide-desc">Transform your organizational culture through comprehensive DEI training and consulting.</p>
                        <a href="/brightorbit/solutions" class="slide-btn">
                            Learn About DEI <i class="fas fa-arrow-right"></i>
                        </a>
                    </div>
                </div>
            </div>

            <!-- Slider Navigation Dots -->
            <div class="slider-dots" id="sliderDots">
                <span class="dot active" data-slide="0"></span>
                <span class="dot" data-slide="1"></span>
                <span class="dot" data-slide="2"></span>
                <span class="dot" data-slide="3"></span>
                <span class="dot" data-slide="4"></span>
            </div>

            <!-- Slider Arrows -->
            <div class="slider-arrow prev" id="prevSlide">
                <i class="fas fa-chevron-left"></i>
            </div>
            <div class="slider-arrow next" id="nextSlide">
                <i class="fas fa-chevron-right"></i>
            </div>

            <!-- Overlay Content -->
            <div class="hero-overlay-content">
                <div class="hero-badge">
                    <i class="fas fa-bolt"></i>
                    <span>Proudly Kenyan · Global Reach</span>
                </div>
                <div class="hero-stats-mini">
                    <div class="hero-stat-item">
                        <div class="hero-stat-number">500+</div>
                        <div class="hero-stat-label">Talent Placed</div>
                    </div>
                    <div class="hero-stat-item">
                        <div class="hero-stat-number">15+</div>
                        <div class="hero-stat-label">Global Partners</div>
                    </div>
                    <div class="hero-stat-item">
                        <div class="hero-stat-number">92%</div>
                        <div class="hero-stat-label">Retention Rate</div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Stats Banner -->
    <section class="stats-banner">
        <div class="container">
            <div class="stats-banner-grid">
                <div class="stats-banner-item" data-aos="fade-up" data-aos-duration="1000">
                    <div class="stats-banner-number">10+</div>
                    <div class="stats-banner-label">Years Excellence</div>
                </div>
                <div class="stats-banner-item" data-aos="fade-up" data-aos-duration="1000" data-aos-delay="100">
                    <div class="stats-banner-number">500+</div>
                    <div class="stats-banner-label">Careers Advanced</div>
                </div>
                <div class="stats-banner-item" data-aos="fade-up" data-aos-duration="1000" data-aos-delay="200">
                    <div class="stats-banner-number">15+</div>
                    <div class="stats-banner-label">Global Partners</div>
                </div>
                <div class="stats-banner-item" data-aos="fade-up" data-aos-duration="1000" data-aos-delay="300">
                    <div class="stats-banner-number">50+</div>
                    <div class="stats-banner-label">Companies Served</div>
                </div>
            </div>
        </div>
    </section>

    <!-- Why Choose Us Section - NEW -->
    <section class="why-choose-us">
        <div class="container">
            <div class="why-header" data-aos="fade-up" data-aos-duration="1000">
                <span class="why-tag">Why Choose Us</span>
                <h2 class="why-title">The Bright Orbit <span>Difference</span></h2>
                <p class="section-desc">What sets us apart in connecting Kenyan talent with global opportunities</p>
            </div>

            <div class="why-grid">
                <!-- Card 1: Global Expertise -->
                <div class="why-card" data-aos="fade-up" data-aos-duration="1000" data-aos-delay="100">
                    <div class="why-icon-wrapper">
                        <i class="fas fa-globe-africa why-icon"></i>
                    </div>
                    <h3>Global Expertise</h3>
                    <p>Decades of experience bridging Kenyan talent with international markets across Africa, Europe, and North America.</p>
                    <ul class="why-features">
                        <li><i class="fas fa-check-circle"></i> <span>International recruitment networks</span></li>
                        <li><i class="fas fa-check-circle"></i> <span>Cross-cultural integration</span></li>
                        <li><i class="fas fa-check-circle"></i> <span>Global compliance expertise</span></li>
                    </ul>
                </div>

                <!-- Card 2: Personalized Approach -->
                <div class="why-card" data-aos="fade-up" data-aos-duration="1000" data-aos-delay="200">
                    <div class="why-icon-wrapper">
                        <i class="fas fa-hand-holding-heart why-icon"></i>
                    </div>
                    <h3>Personalized Approach</h3>
                    <p>We treat every client and candidate as unique, crafting tailored solutions that match specific needs and aspirations.</p>
                    <ul class="why-features">
                        <li><i class="fas fa-check-circle"></i> <span>One-on-one career coaching</span></li>
                        <li><i class="fas fa-check-circle"></i> <span>Customized HR strategies</span></li>
                        <li><i class="fas fa-check-circle"></i> <span>Dedicated account managers</span></li>
                    </ul>
                </div>

                <!-- Card 3: Proven Track Record -->
                <div class="why-card" data-aos="fade-up" data-aos-duration="1000" data-aos-delay="300">
                    <div class="why-icon-wrapper">
                        <i class="fas fa-trophy why-icon"></i>
                    </div>
                    <h3>Proven Track Record</h3>
                    <p>Over 500 successful placements with 92% retention rate – our results speak for themselves.</p>
                    <ul class="why-features">
                        <li><i class="fas fa-check-circle"></i> <span>500+ careers advanced</span></li>
                        <li><i class="fas fa-check-circle"></i> <span>92% client satisfaction</span></li>
                        <li><i class="fas fa-check-circle"></i> <span>50+ corporate partners</span></li>
                    </ul>
                </div>

                <!-- Card 4: Comprehensive Services -->
                <div class="why-card" data-aos="fade-up" data-aos-duration="1000" data-aos-delay="400">
                    <div class="why-icon-wrapper">
                        <i class="fas fa-briefcase why-icon"></i>
                    </div>
                    <h3>Comprehensive Services</h3>
                    <p>From recruitment to coaching, we offer end-to-end HR solutions under one roof.</p>
                    <ul class="why-features">
                        <li><i class="fas fa-check-circle"></i> <span>Global recruitment</span></li>
                        <li><i class="fas fa-check-circle"></i> <span>HR consulting & DEI training</span></li>
                        <li><i class="fas fa-check-circle"></i> <span>Career development & coaching</span></li>
                    </ul>
                </div>

                <!-- Card 5: Technology-Driven -->
                <div class="why-card" data-aos="fade-up" data-aos-duration="1000" data-aos-delay="500">
                    <div class="why-icon-wrapper">
                        <i class="fas fa-laptop-code why-icon"></i>
                    </div>
                    <h3>Technology-Driven</h3>
                    <p>Leveraging cutting-edge HR tech and AI to streamline processes and deliver faster, smarter results.</p>
                    <ul class="why-features">
                        <li><i class="fas fa-check-circle"></i> <span>AI-powered talent matching</span></li>
                        <li><i class="fas fa-check-circle"></i> <span>Digital assessment tools</span></li>
                        <li><i class="fas fa-check-circle"></i> <span>Data-driven insights</span></li>
                    </ul>
                </div>

                <!-- Card 6: Kenyan Pride, Global Reach -->
                <div class="why-card" data-aos="fade-up" data-aos-duration="1000" data-aos-delay="600">
                    <div class="why-icon-wrapper">
                        <i class="fas fa-heart why-icon"></i>
                    </div>
                    <h3>Kenyan Pride, Global Reach</h3>
                    <p>We celebrate Kenyan talent while connecting it to the world – proudly local, globally focused.</p>
                    <ul class="why-features">
                        <li><i class="fas fa-check-circle"></i> <span>Deep local expertise</span></li>
                        <li><i class="fas fa-check-circle"></i> <span>International partnerships</span></li>
                        <li><i class="fas fa-check-circle"></i> <span>Cultural ambassadors</span></li>
                    </ul>
                </div>
            </div>
        </div>
    </section>

    <!-- Mission & Vision Section -->
    <section class="mission" id="mission">
        <div class="container">
            <div class="section-header" data-aos="fade-up" data-aos-duration="1000">
                <span class="section-tag">Our Purpose</span>
                <h2 class="section-title">Mission & <span>Vision</span></h2>
                <p class="section-desc">Guided by a clear purpose to connect worlds and nurture careers.</p>
            </div>
            
            <div class="mission-grid" data-aos="fade-up" data-aos-duration="1000">
                <div class="mission-card">
                    <div class="mission-icon">
                        <i class="fas fa-bullseye"></i>
                    </div>
                    <h2>OUR MISSION</h2>
                    <p><?= htmlspecialchars($mission ?? 'Empowering careers worldwide through tailored HR solutions and global recruitment. We connect exceptional Kenyan talent with international opportunities while fostering inclusive workplaces that celebrate diversity.') ?></p>
                </div>
                
                <div class="mission-card">
                    <div class="mission-icon">
                        <i class="fas fa-eye"></i>
                    </div>
                    <h2>OUR VISION</h2>
                    <p><?= htmlspecialchars($vision ?? 'Pioneering diverse workforce integration for sustainable global growth. Building a future where borders don\'t limit potential and every professional can thrive internationally.') ?></p>
                </div>
            </div>
            <div class="tagline" data-aos="fade-up" data-aos-duration="1000">
                <i class="fas fa-quote-left"></i>
                "<?= htmlspecialchars($tagline ?? 'Connecting Worlds & Nurturing Careers') ?>"
            </div>
        </div>
    </section>

    <!-- Services Section -->
    <section class="services" id="solutions">
        <div class="container">
            <div class="section-header" data-aos="fade-up" data-aos-duration="1000">
                <span class="section-tag">What We Offer</span>
                <h2 class="section-title">Our <span>Solutions</span></h2>
                <p class="section-desc">Comprehensive HR and talent solutions designed for global success</p>
            </div>
            
            <div class="services-grid">
                <?php if (isset($services) && is_array($services)): ?>
                    <?php foreach (array_slice($services, 0, 4) as $index => $service): ?>
                    <div class="service-card" data-aos="fade-up" data-aos-duration="1000" data-aos-delay="<?= ($index + 1) * 100 ?>">
                        <div class="service-icon">
                            <i class="<?= htmlspecialchars($service['icon']) ?>"></i>
                        </div>
                        <h3><?= htmlspecialchars($service['title']) ?></h3>
                        <p><?= htmlspecialchars($service['description']) ?></p>
                        <a href="/brightorbit/solutions" class="service-link">
                            Learn more <i class="fas fa-arrow-right"></i>
                        </a>
                    </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <div class="service-card" data-aos="fade-up" data-aos-duration="1000" data-aos-delay="100">
                        <div class="service-icon"><i class="fas fa-globe-africa"></i></div>
                        <h3>Global Recruitment</h3>
                        <p>Connecting Kenyan top talent with international opportunities across Africa, Europe, and North America.</p>
                        <a href="/brightorbit/solutions" class="service-link">Learn more <i class="fas fa-arrow-right"></i></a>
                    </div>
                    <div class="service-card" data-aos="fade-up" data-aos-duration="1000" data-aos-delay="200">
                        <div class="service-icon"><i class="fas fa-chart-line"></i></div>
                        <h3>HR Consulting</h3>
                        <p>Strategic HR solutions for businesses seeking to build diverse, inclusive, and high-performing teams.</p>
                        <a href="/brightorbit/solutions" class="service-link">Learn more <i class="fas fa-arrow-right"></i></a>
                    </div>
                    <div class="service-card" data-aos="fade-up" data-aos-duration="1000" data-aos-delay="300">
                        <div class="service-icon"><i class="fas fa-graduation-cap"></i></div>
                        <h3>Career Development</h3>
                        <p>Mentorship programs and professional development for career advancement and skill enhancement.</p>
                        <a href="/brightorbit/solutions" class="service-link">Learn more <i class="fas fa-arrow-right"></i></a>
                    </div>
                    <div class="service-card" data-aos="fade-up" data-aos-duration="1000" data-aos-delay="400">
                        <div class="service-icon"><i class="fas fa-handshake"></i></div>
                        <h3>Talent Management</h3>
                        <p>End-to-end talent solutions from sourcing to retention and workforce planning.</p>
                        <a href="/brightorbit/solutions" class="service-link">Learn more <i class="fas fa-arrow-right"></i></a>
                    </div>
                <?php endif; ?>
            </div>
            
            <div style="text-align: center; margin-top: 3rem;" data-aos="fade-up" data-aos-duration="1000">
                <a href="/brightorbit/solutions" class="btn btn-outline" style="padding: 1rem 2.5rem; display: inline-flex; align-items: center; gap: 0.8rem; border: 1.5px solid var(--gray-light); border-radius: var(--border-radius-full); text-decoration: none; color: var(--navy); transition: var(--transition);">
                    View All Services <i class="fas fa-arrow-right"></i>
                </a>
            </div>
        </div>
    </section>

    <!-- Leadership Team -->
    <section class="team" id="team">
        <div class="container">
            <div class="section-header" data-aos="fade-up" data-aos-duration="1000">
                <span class="section-tag">Our Leadership</span>
                <h2 class="section-title">Meet the <span>Experts</span></h2>
                <p class="section-desc">Experienced professionals committed to your success</p>
            </div>
            
            <div class="team-grid">
                <?php if (isset($team) && is_array($team)): ?>
                    <?php foreach (array_slice($team, 0, 4) as $index => $member): ?>
                    <div class="team-card" data-aos="fade-up" data-aos-duration="1000" data-aos-delay="<?= ($index + 1) * 100 ?>">
                        <div class="team-image">
                            <div class="team-image-bg">
                                <i class="fas fa-user-tie team-avatar"></i>
                            </div>
                            <div class="team-social">
                                <a href="#"><i class="fab fa-linkedin-in"></i></a>
                                <a href="#"><i class="fab fa-twitter"></i></a>
                                <a href="#"><i class="fas fa-envelope"></i></a>
                            </div>
                        </div>
                        <div class="team-info">
                            <h3 class="team-name"><?= htmlspecialchars($member['name']) ?></h3>
                            <span class="team-position"><?= htmlspecialchars($member['position']) ?></span>
                            <p class="team-bio"><?= htmlspecialchars($member['bio']) ?></p>
                        </div>
                    </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <div class="team-card" data-aos="fade-up" data-aos-duration="1000" data-aos-delay="100">
                        <div class="team-image">
                            <div class="team-image-bg">
                                <i class="fas fa-user-tie team-avatar"></i>
                            </div>
                            <div class="team-social">
                                <a href="#"><i class="fab fa-linkedin-in"></i></a>
                                <a href="#"><i class="fab fa-twitter"></i></a>
                                <a href="#"><i class="fas fa-envelope"></i></a>
                            </div>
                        </div>
                        <div class="team-info">
                            <h3 class="team-name">Dr. Sarah Wanjiku</h3>
                            <span class="team-position">Founder & CEO</span>
                            <p class="team-bio">15+ years in global HR strategy, former UN talent advisor</p>
                        </div>
                    </div>
                    <div class="team-card" data-aos="fade-up" data-aos-duration="1000" data-aos-delay="200">
                        <div class="team-image">
                            <div class="team-image-bg">
                                <i class="fas fa-user-tie team-avatar"></i>
                            </div>
                            <div class="team-social">
                                <a href="#"><i class="fab fa-linkedin-in"></i></a>
                                <a href="#"><i class="fab fa-twitter"></i></a>
                                <a href="#"><i class="fas fa-envelope"></i></a>
                            </div>
                        </div>
                        <div class="team-info">
                            <h3 class="team-name">James Omondi</h3>
                            <span class="team-position">Director of Operations</span>
                            <p class="team-bio">Expert in cross-border talent placement and workforce integration</p>
                        </div>
                    </div>
                    <div class="team-card" data-aos="fade-up" data-aos-duration="1000" data-aos-delay="300">
                        <div class="team-image">
                            <div class="team-image-bg">
                                <i class="fas fa-user-tie team-avatar"></i>
                            </div>
                            <div class="team-social">
                                <a href="#"><i class="fab fa-linkedin-in"></i></a>
                                <a href="#"><i class="fab fa-twitter"></i></a>
                                <a href="#"><i class="fas fa-envelope"></i></a>
                            </div>
                        </div>
                        <div class="team-info">
                            <h3 class="team-name">Consolata Ndegwa</h3>
                            <span class="team-position">Human Resource Leader</span>
                            <p class="team-bio">Accomplished strategic leader in human capital management</p>
                        </div>
                    </div>
                    <div class="team-card" data-aos="fade-up" data-aos-duration="1000" data-aos-delay="400">
                        <div class="team-image">
                            <div class="team-image-bg">
                                <i class="fas fa-user-cog team-avatar"></i>
                            </div>
                            <div class="team-social">
                                <a href="#"><i class="fab fa-linkedin-in"></i></a>
                                <a href="#"><i class="fab fa-twitter"></i></a>
                                <a href="#"><i class="fas fa-envelope"></i></a>
                            </div>
                        </div>
                        <div class="team-info">
                            <h3 class="team-name">Peter Tariko</h3>
                            <span class="team-position">Operations Manager</span>
                            <p class="team-bio">Dedicated to easing the journey for candidates into thriving roles</p>
                        </div>
                    </div>
                <?php endif; ?>
            </div>
            
            <div style="text-align: center; margin-top: 3rem;" data-aos="fade-up" data-aos-duration="1000">
                <a href="/brightorbit/team" class="btn btn-outline" style="padding: 1rem 2.5rem; display: inline-flex; align-items: center; gap: 0.8rem; border: 1.5px solid var(--gray-light); border-radius: var(--border-radius-full); text-decoration: none; color: var(--navy); transition: var(--transition);">
                    Meet Our Full Team <i class="fas fa-arrow-right"></i>
                </a>
            </div>
        </div>
    </section>

    <!-- Testimonials -->
    <section class="testimonials">
        <div class="container">
            <div class="section-header" data-aos="fade-up" data-aos-duration="1000">
                <span class="section-tag" style="background: rgba(255,255,255,0.1); color: white;">Client Stories</span>
                <h2 class="section-title" style="color: white;">Success <span style="color: var(--teal);">Stories</span></h2>
                <p class="section-desc" style="color: rgba(255,255,255,0.9);">
                    Trusted by organizations across the globe
                </p>
            </div>
            
            <div class="testimonials-grid">
                <?php if (isset($testimonials) && is_array($testimonials)): ?>
                    <?php foreach (array_slice($testimonials, 0, 2) as $index => $testimonial): ?>
                    <div class="testimonial-card" data-aos="fade-up" data-aos-duration="1000" data-aos-delay="<?= ($index + 1) * 100 ?>">
                        <div class="testimonial-content">
                            <i class="fas fa-quote-left"></i>
                            "<?= htmlspecialchars($testimonial['content']) ?>"
                        </div>
                        <div class="testimonial-author">
                            <span class="testimonial-name"><?= htmlspecialchars($testimonial['name']) ?></span>
                            <span class="testimonial-company"><?= htmlspecialchars($testimonial['client']) ?></span>
                            <div class="rating">
                                <?php for($i = 0; $i < ($testimonial['rating'] ?? 5); $i++): ?>
                                    <i class="fas fa-star"></i>
                                <?php endfor; ?>
                            </div>
                        </div>
                    </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <div class="testimonial-card" data-aos="fade-up" data-aos-duration="1000" data-aos-delay="100">
                        <div class="testimonial-content">
                            <i class="fas fa-quote-left"></i>
                            "Bright Orbit delivered exceptional Kenyan tech talent. Their screening process is thorough and culturally sensitive."
                        </div>
                        <div class="testimonial-author">
                            <span class="testimonial-name">TechCorp UK</span>
                            <span class="testimonial-company">Michael Chen, HR Director</span>
                            <div class="rating">
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                            </div>
                        </div>
                    </div>
                    <div class="testimonial-card" data-aos="fade-up" data-aos-duration="1000" data-aos-delay="200">
                        <div class="testimonial-content">
                            <i class="fas fa-quote-left"></i>
                            "They understood our needs perfectly and provided healthcare professionals who have become invaluable team members."
                        </div>
                        <div class="testimonial-author">
                            <span class="testimonial-name">AfriHealth Initiative</span>
                            <span class="testimonial-company">Dr. Amina Yusuf</span>
                            <div class="rating">
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                            </div>
                        </div>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </section>

    <!-- Call to Action -->
    <section class="cta" id="consult">
        <div class="container">
            <div data-aos="zoom-in" data-aos-duration="1000">
                <h2>Ready to bridge your talent gap?</h2>
                <p>Partner with Bright Orbit and access Kenya's finest professionals</p>
                <a href="/brightorbit/contact" class="btn btn-primary">
                    <i class="fas fa-calendar-check"></i>
                    Schedule a consultation
                </a>
            </div>
        </div>
    </section>

    <?php require_once __DIR__ . '/../layout/footer.php'; ?>
    
    <!-- AOS Animation Script -->
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    
    <!-- JavaScript -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Initialize AOS
            AOS.init({
                once: true,
                offset: 100,
                duration: 1000,
                easing: 'ease-out-cubic'
            });

            // ===== HERO SLIDER FUNCTIONALITY =====
            const slides = document.querySelectorAll('.slider-slide');
            const dots = document.querySelectorAll('.dot');
            const prevBtn = document.getElementById('prevSlide');
            const nextBtn = document.getElementById('nextSlide');
            let currentSlide = 0;
            let slideInterval;

            function showSlide(index) {
                slides.forEach(slide => slide.classList.remove('active'));
                dots.forEach(dot => dot.classList.remove('active'));
                
                slides[index].classList.add('active');
                dots[index].classList.add('active');
                currentSlide = index;
            }

            function nextSlide() {
                let next = currentSlide + 1;
                if (next >= slides.length) {
                    next = 0;
                }
                showSlide(next);
            }

            function prevSlide() {
                let prev = currentSlide - 1;
                if (prev < 0) {
                    prev = slides.length - 1;
                }
                showSlide(prev);
            }

            if (nextBtn) {
                nextBtn.addEventListener('click', () => {
                    nextSlide();
                    resetTimer();
                });
            }

            if (prevBtn) {
                prevBtn.addEventListener('click', () => {
                    prevSlide();
                    resetTimer();
                });
            }

            dots.forEach((dot, index) => {
                dot.addEventListener('click', () => {
                    showSlide(index);
                    resetTimer();
                });
            });

            function startSliderTimer() {
                slideInterval = setInterval(nextSlide, 7000);
            }

            function resetTimer() {
                clearInterval(slideInterval);
                startSliderTimer();
            }

            if (slides.length > 0) {
                startSliderTimer();
            }

            const slider = document.querySelector('.hero-slider');
            if (slider) {
                slider.addEventListener('mouseenter', () => {
                    clearInterval(slideInterval);
                });
                
                slider.addEventListener('mouseleave', () => {
                    startSliderTimer();
                });
            }

            // ===== SMOOTH SCROLLING =====
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
            
            // ===== NAVBAR SCROLL EFFECT =====
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