<?php
require_once __DIR__ . '/../layout/navbar.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($title ?? 'About Us - Bright Orbit Consultancy | Connecting Worlds, Nurturing Careers') ?></title>
    <meta name="description" content="<?= htmlspecialchars($meta_description ?? 'Learn about Bright Orbit Consultancy - Our expertise, leadership team, and commitment to bridging Kenyan talent with global opportunities.') ?>">
    
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

        /* ===== HERO SECTION ===== */
        .about-hero {
            position: relative;
            padding: 6rem 0 8rem;
            background: linear-gradient(165deg, var(--white) 0%, var(--sky-light) 100%);
            overflow: hidden;
        }

        .about-hero::before {
            content: '';
            position: absolute;
            top: -50%;
            right: -20%;
            width: 80%;
            height: 200%;
            background: radial-gradient(circle, rgba(204,85,0,0.03) 0%, transparent 70%);
            border-radius: 50%;
            pointer-events: none;
        }

        .about-hero::after {
            content: '';
            position: absolute;
            bottom: -50%;
            left: -20%;
            width: 80%;
            height: 200%;
            background: radial-gradient(circle, rgba(10,42,68,0.03) 0%, transparent 70%);
            border-radius: 50%;
            pointer-events: none;
        }

        .about-hero .container {
            display: grid;
            grid-template-columns: 1.1fr 0.9fr;
            gap: 4rem;
            align-items: center;
            position: relative;
            z-index: 2;
        }
        .hero-content{
            margin-top:-15rem;
        }

        .hero-badge {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            background: rgba(204,85,0,0.08);
            color: var(--teal);
            padding: 0.6rem 1.5rem;
            border-radius: var(--border-radius-full);
            font-weight: 600;
            font-size: 0.9rem;
            margin-bottom: 1.5rem;
            border: 1px solid rgba(204,85,0,0.15);
            backdrop-filter: blur(10px);
        }

        .hero-title {
            font-size: 3.8rem;
            font-weight: 800;
            line-height: 1.1;
            letter-spacing: -2px;
            color: var(--navy);
            margin-bottom: 1.5rem;
        }

        .hero-title span {
            color: var(--teal);
            position: relative;
            display: inline-block;
        }

        .hero-title span::after {
            content: '';
            position: absolute;
            bottom: 10px;
            left: 0;
            width: 100%;
            height: 8px;
            background: rgba(204,85,0,0.2);
            z-index: -1;
        }

        .hero-subtitle {
            font-size: 1.2rem;
            color: var(--gray);
            margin-bottom: 2rem;
            line-height: 1.8;
        }

        .hero-stats {
            display: flex;
            gap: 3rem;
            margin-top: 2.5rem;
        }

        .hero-stat-item {
            display: flex;
            flex-direction: column;
        }

        .hero-stat-number {
            font-size: 2.5rem;
            font-weight: 800;
            color: var(--navy);
            line-height: 1;
        }

        .hero-stat-label {
            font-size: 0.9rem;
            color: var(--gray);
            text-transform: uppercase;
            letter-spacing: 1px;
            margin-top: 0.3rem;
        }

        .hero-visual {
            position: relative;
        }

        .hero-image-card {
            position: relative;
            border-radius: var(--border-radius-lg);
            overflow: hidden;
            box-shadow: var(--shadow-xl);
            aspect-ratio: 4/5;
        }

        .hero-image-card img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: var(--transition);
        }

        .hero-image-card:hover img {
            transform: scale(1.05);
        }

        .hero-image-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: linear-gradient(145deg, rgba(10,42,68,0.3), rgba(204,85,0,0.2));
            z-index: 1;
        }

        .hero-quote {
            position: absolute;
            bottom: -20px;
            left: -20px;
            background: white;
            padding: 1.8rem;
            border-radius: var(--border-radius);
            box-shadow: var(--shadow-xl);
            max-width: 250px;
            border-left: 4px solid var(--teal);
            z-index: 3;
        }

        .hero-quote i {
            color: var(--teal);
            font-size: 1.5rem;
            opacity: 0.5;
            margin-bottom: 0.5rem;
        }

        .hero-quote p {
            font-weight: 600;
            color: var(--navy);
            line-height: 1.5;
        }

        /* ===== MISSION VISION SECTION ===== */
        .mission-vision {
            padding: 6rem 0;
            background: var(--white);
        }

        .mv-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 2.5rem;
        }

        .mv-card {
            background: var(--white);
            padding: 3rem;
            border-radius: var(--border-radius);
            border: 1px solid var(--gray-light);
            transition: var(--transition);
            position: relative;
            overflow: hidden;
        }

        .mv-card:hover {
            transform: translateY(-10px);
            border-color: var(--teal);
            box-shadow: var(--shadow-xl);
        }

        .mv-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 4px;
            height: 0;
            background: var(--teal);
            transition: var(--transition);
        }

        .mv-card:hover::before {
            height: 100%;
        }

        .mv-icon {
            width: 80px;
            height: 80px;
            background: linear-gradient(145deg, var(--sky-light), var(--white));
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--teal);
            font-size: 2.2rem;
            margin-bottom: 2rem;
            border: 1px solid var(--gray-light);
            transition: var(--transition);
        }

        .mv-card:hover .mv-icon {
            background: var(--teal);
            color: white;
            border-color: var(--teal);
        }

        .mv-card h3 {
            font-size: 1.8rem;
            font-weight: 700;
            color: var(--navy);
            margin-bottom: 1.2rem;
        }

        .mv-card p {
            color: var(--gray);
            font-size: 1.1rem;
            line-height: 1.8;
        }

        /* ===== EXPERTISE SECTION ===== */
        .expertise {
            padding: 6rem 0;
            background: var(--gray-bg);
            position: relative;
        }

        .section-header {
            text-align: center;
            max-width: 700px;
            margin: 0 auto 4rem;
        }

        .section-tag {
            display: inline-block;
            background: rgba(204,85,0,0.08);
            color: var(--teal);
            padding: 0.5rem 1.5rem;
            border-radius: var(--border-radius-full);
            font-weight: 600;
            font-size: 0.9rem;
            text-transform: uppercase;
            letter-spacing: 2px;
            margin-bottom: 1rem;
        }

        .section-title {
            font-size: 2.8rem;
            font-weight: 800;
            color: var(--navy);
            line-height: 1.2;
            margin-bottom: 1rem;
        }

        .section-title span {
            color: var(--teal);
        }

        .section-desc {
            color: var(--gray);
            font-size: 1.1rem;
            line-height: 1.8;
        }

        .expertise-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 2rem;
            margin-top: 3rem;
        }

        .expertise-card {
            background: var(--white);
            padding: 2.5rem;
            border-radius: var(--border-radius);
            border: 1px solid var(--gray-light);
            transition: var(--transition);
            position: relative;
            overflow: hidden;
        }

        .expertise-card:hover {
            transform: translateY(-10px);
            border-color: var(--teal);
            box-shadow: var(--shadow-xl);
        }

        .expertise-icon {
            width: 70px;
            height: 70px;
            background: linear-gradient(145deg, var(--sky-light), var(--white));
            border-radius: 20px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--teal);
            font-size: 1.8rem;
            margin-bottom: 1.8rem;
            border: 1px solid var(--gray-light);
            transition: var(--transition);
        }

        .expertise-card:hover .expertise-icon {
            background: var(--teal);
            color: white;
            border-color: var(--teal);
            transform: rotate(5deg);
        }

        .expertise-card h4 {
            font-size: 1.3rem;
            font-weight: 700;
            color: var(--navy);
            margin-bottom: 1rem;
        }

        .expertise-card p {
            color: var(--gray);
            font-size: 0.95rem;
            line-height: 1.7;
            margin-bottom: 1.5rem;
        }

        .expertise-link {
            color: var(--teal);
            font-weight: 600;
            text-decoration: none;
            display: flex;
            align-items: center;
            gap: 0.5rem;
            transition: var(--transition);
        }

        .expertise-link:hover {
            gap: 1rem;
            color: var(--teal-dark);
        }

        /* ===== TEAM SECTION ===== */
        .team {
            padding: 6rem 0;
            background: var(--white);
        }

        .team-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 2rem;
            margin-top: 3rem;
        }

        .team-card {
            background: var(--white);
            border-radius: var(--border-radius);
            overflow: hidden;
            border: 1px solid var(--gray-light);
            transition: var(--transition);
        }

        .team-card:hover {
            transform: translateY(-10px);
            border-color: var(--teal);
            box-shadow: var(--shadow-xl);
        }

        .team-image {
            position: relative;
            height: 280px;
            overflow: hidden;
        }

        .team-image-bg {
            width: 100%;
            height: 100%;
            background: linear-gradient(145deg, var(--navy), var(--teal));
            display: flex;
            align-items: center;
            justify-content: center;
            transition: var(--transition);
        }

        .team-card:hover .team-image-bg {
            transform: scale(1.1);
        }

        .team-avatar {
            font-size: 4rem;
            color: white;
            opacity: 0.9;
        }

        .team-social {
            position: absolute;
            bottom: -50px;
            left: 0;
            width: 100%;
            display: flex;
            justify-content: center;
            gap: 1rem;
            padding: 1rem;
            background: linear-gradient(to top, rgba(0,0,0,0.8), transparent);
            transition: var(--transition);
        }

        .team-card:hover .team-social {
            bottom: 0;
        }

        .team-social a {
            width: 40px;
            height: 40px;
            background: white;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--navy);
            transition: var(--transition);
        }

        .team-social a:hover {
            background: var(--teal);
            color: white;
            transform: translateY(-5px);
        }

        .team-info {
            padding: 1.8rem;
            text-align: center;
        }

        .team-name {
            font-size: 1.3rem;
            font-weight: 700;
            color: var(--navy);
            margin-bottom: 0.3rem;
        }

        .team-position {
            display: inline-block;
            color: var(--teal);
            font-weight: 600;
            font-size: 0.85rem;
            text-transform: uppercase;
            letter-spacing: 1px;
            margin-bottom: 0.8rem;
        }

        .team-bio {
            color: var(--gray);
            font-size: 0.9rem;
            line-height: 1.6;
        }

        /* ===== VALUES SECTION ===== */
        .values {
            padding: 6rem 0;
            background: linear-gradient(145deg, var(--navy), var(--navy-dark));
            color: white;
        }

        .values-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 2rem;
            margin-top: 3rem;
        }

        .value-card {
            text-align: center;
            padding: 2rem;
            background: rgba(255,255,255,0.05);
            border-radius: var(--border-radius);
            border: 1px solid rgba(255,255,255,0.1);
            transition: var(--transition);
            backdrop-filter: blur(10px);
        }

        .value-card:hover {
            transform: translateY(-10px);
            background: rgba(255,255,255,0.1);
            border-color: var(--teal);
        }

        .value-icon {
            width: 70px;
            height: 70px;
            background: rgba(204,85,0,0.2);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--teal);
            font-size: 1.8rem;
            margin: 0 auto 1.5rem;
            transition: var(--transition);
        }

        .value-card:hover .value-icon {
            background: var(--teal);
            color: white;
        }

        .value-card h4 {
            font-size: 1.2rem;
            font-weight: 700;
            margin-bottom: 0.8rem;
        }

        .value-card p {
            color: rgba(255,255,255,0.8);
            font-size: 0.95rem;
            line-height: 1.6;
        }

        /* ===== REGULATED SECTION ===== */
        .regulated {
            padding: 5rem 0;
            background: var(--white);
        }

        .regulated-wrapper {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 4rem;
            background: linear-gradient(145deg, var(--sky-light), var(--white));
            padding: 3rem;
            border-radius: var(--border-radius-lg);
            border: 1px solid var(--gray-light);
        }

        .regulated-content {
            flex: 1;
        }

        .regulated-badge {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            background: rgba(204,85,0,0.08);
            color: var(--teal);
            padding: 0.5rem 1.2rem;
            border-radius: var(--border-radius-full);
            font-weight: 600;
            font-size: 0.85rem;
            margin-bottom: 1rem;
        }

        .regulated-title {
            font-size: 2rem;
            font-weight: 700;
            color: var(--navy);
            margin-bottom: 0.8rem;
        }

        .regulated-text {
            color: var(--gray);
            font-size: 1.1rem;
            line-height: 1.7;
        }

        .regulated-logos {
            display: flex;
            gap: 2rem;
            flex-wrap: wrap;
        }

        .regulated-logo-item {
            display: flex;
            align-items: center;
            gap: 1rem;
            padding: 1rem 2rem;
            background: var(--white);
            border-radius: var(--border-radius);
            border: 1px solid var(--gray-light);
            transition: var(--transition);
        }

        .regulated-logo-item:hover {
            border-color: var(--teal);
            box-shadow: var(--shadow-md);
            transform: translateY(-5px);
        }

        .regulated-logo-item i {
            font-size: 2.2rem;
            color: var(--teal);
        }

        .regulated-logo-text {
            font-weight: 700;
            color: var(--navy);
        }

        .regulated-logo-sub {
            font-size: 0.85rem;
            color: var(--gray);
        }

        /* ===== RESPONSIVE ===== */
        @media (max-width: 1200px) {
            .team-grid {
                grid-template-columns: repeat(3, 1fr);
            }
            
            .values-grid {
                grid-template-columns: repeat(2, 1fr);
            }
        }

        @media (max-width: 1024px) {
            .about-hero .container {
                grid-template-columns: 1fr;
                gap: 3rem;
            }
            
            .hero-title {
                font-size: 3rem;
            }
            
            .expertise-grid {
                grid-template-columns: repeat(2, 1fr);
            }
            
            .team-grid {
                grid-template-columns: repeat(2, 1fr);
            }
        }

        @media (max-width: 768px) {
            .container {
                padding: 0 1.5rem;
            }
            
            .hero-title {
                font-size: 2.5rem;
            }
            
            .mv-grid {
                grid-template-columns: 1fr;
            }
            
            .expertise-grid {
                grid-template-columns: 1fr;
            }
            
            .team-grid {
                grid-template-columns: 1fr;
            }
            
            .values-grid {
                grid-template-columns: 1fr;
            }
            
            .regulated-wrapper {
                flex-direction: column;
                padding: 2rem;
            }
            
            .regulated-logos {
                justify-content: center;
            }
            
            .section-title {
                font-size: 2.2rem;
            }
        }

        @media (max-width: 480px) {
            .hero-title {
                font-size: 2rem;
            }
            
            .hero-stats {
                flex-direction: column;
                gap: 1.5rem;
            }
            
            .hero-quote {
                position: relative;
                bottom: 0;
                left: 0;
                margin-top: 1.5rem;
            }
            
            .regulated-logos {
                flex-direction: column;
                width: 100%;
            }
            
            .regulated-logo-item {
                width: 100%;
            }
        }
    </style>
</head>
<body>

    <!-- Hero Section -->
    <section class="about-hero">
        <div class="container">
            <div class="hero-content" data-aos="fade-right" data-aos-duration="1000">
                <div class="hero-badge">
                    <i class="fas fa-flag"></i>
                    Proudly Kenyan · Global Impact
                </div>
                <h1 class="hero-title">
                    We Are <span>Bright Orbit</span>
                </h1>
                <p class="hero-subtitle">
                    A premier HR consultancy bridging Kenya's exceptional talent with global opportunities. 
                    With over a decade of expertise, we're reshaping how the world works—one career at a time.
                </p>
                
                <div class="hero-stats">
                    <div class="hero-stat-item">
                        <span class="hero-stat-number">10+</span>
                        <span class="hero-stat-label">Years Excellence</span>
                    </div>
                    <div class="hero-stat-item">
                        <span class="hero-stat-number">500+</span>
                        <span class="hero-stat-label">Careers Advanced</span>
                    </div>
                    <div class="hero-stat-item">
                        <span class="hero-stat-number">15+</span>
                        <span class="hero-stat-label">Global Partners</span>
                    </div>
                </div>
            </div>
            
            <div class="hero-visual" data-aos="fade-left" data-aos-duration="1000">
                <div class="hero-image-card">
                    <img src="https://images.unsplash.com/photo-1522071820081-009f0129c71c?ixlib=rb-4.0.3&auto=format&fit=crop&w=1470&q=80" alt="Bright Orbit Team">
                </div>
                <div class="hero-quote">
                    <i class="fas fa-quote-left"></i>
                    <p>"Connecting Worlds, Nurturing Careers"</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Mission & Vision Section -->
    <section class="mission-vision">
        <div class="container">
            <div class="mv-grid">
                <div class="mv-card" data-aos="fade-up" data-aos-duration="1000">
                    <div class="mv-icon">
                        <i class="fas fa-bullseye"></i>
                    </div>
                    <h3>Our Mission</h3>
                    <p>Empowering careers worldwide through tailored HR solutions and global recruitment. We connect exceptional Kenyan talent with international opportunities while fostering inclusive workplaces that celebrate diversity.</p>
                </div>
                
                <div class="mv-card" data-aos="fade-up" data-aos-duration="1000" data-aos-delay="200">
                    <div class="mv-icon">
                        <i class="fas fa-eye"></i>
                    </div>
                    <h3>Our Vision</h3>
                    <p>To pioneer diverse workforce integration for sustainable global growth. Building a future where borders don't limit potential and every professional can thrive internationally.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Expertise Section -->
    <section class="expertise">
        <div class="container">
            <div class="section-header" data-aos="fade-up" data-aos-duration="1000">
                <span class="section-tag">Our Expertise</span>
                <h2 class="section-title">Decades of Excellence in <span>HR & Technology</span></h2>
                <p class="section-desc">
                    At Bright Orbit Consultancy Limited, our team boasts a wealth of expertise in both human resources and technology. 
                    With over a decade of experience, we excel in global recruitment and tailored HR solutions.
                </p>
            </div>
            
            <div class="expertise-grid">
                <div class="expertise-card" data-aos="fade-up" data-aos-duration="1000" data-aos-delay="100">
                    <div class="expertise-icon">
                        <i class="fas fa-users"></i>
                    </div>
                    <h4>Global Recruitment</h4>
                    <p>Connecting Kenyan top talent with international opportunities across Africa, Europe, and North America.</p>
                    <a href="#" class="expertise-link">
                        Learn more <i class="fas fa-arrow-right"></i>
                    </a>
                </div>
                
                <div class="expertise-card" data-aos="fade-up" data-aos-duration="1000" data-aos-delay="200">
                    <div class="expertise-icon">
                        <i class="fas fa-chart-line"></i>
                    </div>
                    <h4>HR Consulting</h4>
                    <p>Strategic HR solutions for businesses seeking to build diverse, inclusive, and high-performing teams.</p>
                    <a href="#" class="expertise-link">
                        Learn more <i class="fas fa-arrow-right"></i>
                    </a>
                </div>
                
                <div class="expertise-card" data-aos="fade-up" data-aos-duration="1000" data-aos-delay="300">
                    <div class="expertise-icon">
                        <i class="fas fa-graduation-cap"></i>
                    </div>
                    <h4>Career Development</h4>
                    <p>Mentorship programs and professional development for career advancement and skill enhancement.</p>
                    <a href="#" class="expertise-link">
                        Learn more <i class="fas fa-arrow-right"></i>
                    </a>
                </div>
                
                <div class="expertise-card" data-aos="fade-up" data-aos-duration="1000" data-aos-delay="400">
                    <div class="expertise-icon">
                        <i class="fas fa-handshake"></i>
                    </div>
                    <h4>Talent Management</h4>
                    <p>End-to-end talent solutions from sourcing to retention and workforce planning.</p>
                    <a href="#" class="expertise-link">
                        Learn more <i class="fas fa-arrow-right"></i>
                    </a>
                </div>
                
                <div class="expertise-card" data-aos="fade-up" data-aos-duration="1000" data-aos-delay="500">
                    <div class="expertise-icon">
                        <i class="fas fa-laptop-code"></i>
                    </div>
                    <h4>IT Project Management</h4>
                    <p>Leveraging our tech-savvy members' extensive background to streamline processes and deliver innovative solutions.</p>
                    <a href="#" class="expertise-link">
                        Learn more <i class="fas fa-arrow-right"></i>
                    </a>
                </div>
                
                <div class="expertise-card" data-aos="fade-up" data-aos-duration="1000" data-aos-delay="600">
                    <div class="expertise-icon">
                        <i class="fas fa-briefcase"></i>
                    </div>
                    <h4>Strategic Partnerships</h4>
                    <p>Collaborations with professional coaches and accounting experts to ensure comprehensive client support.</p>
                    <a href="#" class="expertise-link">
                        Learn more <i class="fas fa-arrow-right"></i>
                    </a>
                </div>
            </div>
        </div>
    </section>

    <!-- Team Section -->
    <section class="team">
        <div class="container">
            <div class="section-header" data-aos="fade-up" data-aos-duration="1000">
                <span class="section-tag">Our Leadership</span>
                <h2 class="section-title">Meet the <span>Experts</span></h2>
                <p class="section-desc">
                    Experienced professionals committed to your success, bringing diverse expertise from HR, technology, and business strategy.
                </p>
            </div>
            
            <div class="team-grid">
                <!-- John Ndegwa -->
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
                        <h3 class="team-name">John Ndegwa</h3>
                        <span class="team-position">Head of Strategy</span>
                        <p class="team-bio">Crafting strategies that lead directly to meaningful job placements with focus on sustainable growth.</p>
                    </div>
                </div>
                
                <!-- Consolata Ndegwa -->
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
                        <h3 class="team-name">Consolata Ndegwa</h3>
                        <span class="team-position">Human Resource Leader</span>
                        <p class="team-bio">Accomplished strategic leader with extensive expertise in human capital management and talent acquisition.</p>
                    </div>
                </div>
                
                <!-- Peter Tariko -->
                <div class="team-card" data-aos="fade-up" data-aos-duration="1000" data-aos-delay="300">
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
                        <p class="team-bio">Motivated by easing the journey for candidates into roles where they can truly thrive.</p>
                    </div>
                </div>
                
                <!-- Elijah Nderitu -->
                <div class="team-card" data-aos="fade-up" data-aos-duration="1000" data-aos-delay="400">
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
                        <h3 class="team-name">Elijah Nderitu</h3>
                        <span class="team-position">Head of Business Operations</span>
                        <p class="team-bio">Social scientist and community development facilitator offering dynamic leadership in our fast-changing world.</p>
                    </div>
                </div>
                
                <!-- Mark Njoroge -->
                <div class="team-card" data-aos="fade-up" data-aos-duration="1000" data-aos-delay="500">
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
                        <h3 class="team-name">Mark Njoroge</h3>
                        <span class="team-position">ICT Consultant</span>
                        <p class="team-bio">Passionate about implementing solutions that empower our team and drive our organization forward.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Core Values Section -->
    <section class="values">
        <div class="container">
            <div class="section-header" data-aos="fade-up" data-aos-duration="1000">
                <span class="section-tag" style="background: rgba(255,255,255,0.1); color: white;">Our Core Values</span>
                <h2 class="section-title" style="color: white;">What Drives <span style="color: var(--teal);">Us</span></h2>
                <p class="section-desc" style="color: rgba(255,255,255,0.9);">
                    Principles that guide our mission to connect worlds and nurture careers.
                </p>
            </div>
            
            <div class="values-grid">
                <div class="value-card" data-aos="fade-up" data-aos-duration="1000" data-aos-delay="100">
                    <div class="value-icon">
                        <i class="fas fa-hand-holding-heart"></i>
                    </div>
                    <h4>Integrity</h4>
                    <p>We uphold the highest ethical standards in every interaction and decision.</p>
                </div>
                
                <div class="value-card" data-aos="fade-up" data-aos-duration="1000" data-aos-delay="200">
                    <div class="value-icon">
                        <i class="fas fa-globe-africa"></i>
                    </div>
                    <h4>Global Mindset</h4>
                    <p>We embrace diversity and think beyond borders to create international opportunities.</p>
                </div>
                
                <div class="value-card" data-aos="fade-up" data-aos-duration="1000" data-aos-delay="300">
                    <div class="value-icon">
                        <i class="fas fa-lightbulb"></i>
                    </div>
                    <h4>Innovation</h4>
                    <p>We continuously evolve our solutions to meet changing workforce needs.</p>
                </div>
                
                <div class="value-card" data-aos="fade-up" data-aos-duration="1000" data-aos-delay="400">
                    <div class="value-icon">
                        <i class="fas fa-users"></i>
                    </div>
                    <h4>Excellence</h4>
                    <p>We strive for nothing less than exceptional outcomes for our clients and candidates.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Regulated By Section -->
    <section class="regulated">
        <div class="container">
            <div class="regulated-wrapper" data-aos="fade-up" data-aos-duration="1000">
                <div class="regulated-content">
                    <div class="regulated-badge">
                        <i class="fas fa-shield-alt"></i>
                        Certified & Regulated
                    </div>
                    <h2 class="regulated-title">Regulated by</h2>
                    <p class="regulated-text">
                        We operate under the highest standards of professional conduct and regulatory compliance, 
                        ensuring trust and credibility in everything we do.
                    </p>
                </div>
                
                <div class="regulated-logos">
                    <div class="regulated-logo-item">
                        <i class="fas fa-certificate"></i>
                        <div>
                            <div class="regulated-logo-text">Government of Kenya</div>
                            <div class="regulated-logo-sub">Ministry of Labour</div>
                        </div>
                    </div>
                    <div class="regulated-logo-item">
                        <i class="fas fa-shield-alt"></i>
                        <div>
                            <div class="regulated-logo-text">IHRM</div>
                            <div class="regulated-logo-sub">Institute of HR Management</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <?php require_once __DIR__ . '/../layout/footer.php'; ?>
    
    <!-- AOS Animation Script -->
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script>
        AOS.init({
            once: true,
            offset: 100,
            duration: 1000,
            easing: 'ease-out-cubic'
        });
    </script>
</body>
</html>