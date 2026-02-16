<?php
require_once __DIR__ . '/../layout/navbar.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($title ?? 'Our Team - Bright Orbit Consultancy | Meet the Experts') ?></title>
    <meta name="description" content="<?= htmlspecialchars($meta_description ?? 'Meet the leadership team at Bright Orbit Consultancy - Experienced HR, technology, and business strategy professionals committed to your success.') ?>">
    
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
            padding: 4rem 0 2rem;
            background: linear-gradient(165deg, var(--white) 0%, var(--sky-light) 100%);
            position: relative;
            overflow: hidden;
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

        .page-header .container {
            position: relative;
            z-index: 2;
        }

        .section-tag {
            display: inline-block;
            background: var(--teal-soft);
            color: var(--teal);
            padding: 0.5rem 1.5rem;
            border-radius: var(--border-radius-full);
            font-weight: 600;
            font-size: 0.9rem;
            text-transform: uppercase;
            letter-spacing: 2px;
            margin-bottom: 1rem;
            border: 1px solid var(--teal-glow);
            backdrop-filter: blur(10px);
        }

        .section-title {
            font-size: 3.5rem;
            font-weight: 800;
            color: var(--navy);
            line-height: 1.2;
            margin-bottom: 1rem;
            letter-spacing: -2px;
        }

        .section-title span {
            color: var(--teal);
            position: relative;
            display: inline-block;
        }

        .section-title span::after {
            content: '';
            position: absolute;
            bottom: 10px;
            left: 0;
            width: 100%;
            height: 8px;
            background: rgba(204,85,0,0.2);
            z-index: -1;
        }

        .section-desc {
            color: var(--gray);
            font-size: 1.2rem;
            max-width: 700px;
            line-height: 1.8;
        }

        /* ===== TEAM GRID SECTION ===== */
        .team-section {
            padding: 3rem 0 6rem;
            background: var(--white);
        }

        .team-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 2.5rem;
            margin-top: 3rem;
        }

        .team-card {
            background: var(--white);
            border-radius: var(--border-radius);
            overflow: hidden;
            border: 1px solid var(--gray-light);
            transition: var(--transition);
            position: relative;
            box-shadow: var(--shadow-sm);
        }

        .team-card:hover {
            transform: translateY(-15px);
            border-color: var(--teal);
            box-shadow: var(--shadow-xl);
        }

        .team-image {
            position: relative;
            height: 320px;
            overflow: hidden;
        }

        .team-image-bg {
            width: 100%;
            height: 100%;
            background: linear-gradient(145deg, var(--navy), var(--navy-light));
            display: flex;
            align-items: center;
            justify-content: center;
            transition: var(--transition);
            position: relative;
        }

        .team-image-bg::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: linear-gradient(145deg, var(--teal), transparent);
            opacity: 0;
            transition: var(--transition);
        }

        .team-card:hover .team-image-bg::before {
            opacity: 0.3;
        }

        .team-card:hover .team-image-bg {
            transform: scale(1.1);
        }

        .team-avatar {
            font-size: 6rem;
            color: white;
            opacity: 0.9;
            filter: drop-shadow(0 10px 20px rgba(0,0,0,0.2));
            transition: var(--transition);
        }

        .team-card:hover .team-avatar {
            transform: scale(1.1) rotate(5deg);
            color: var(--teal);
        }

        .team-social {
            position: absolute;
            bottom: 0;
            left: 0;
            width: 100%;
            display: flex;
            justify-content: center;
            gap: 1rem;
            padding: 1.5rem;
            background: linear-gradient(to top, rgba(0,0,0,0.9), transparent);
            transform: translateY(100%);
            transition: var(--transition);
            z-index: 10;
        }

        .team-card:hover .team-social {
            transform: translateY(0);
        }

        .team-social a {
            width: 45px;
            height: 45px;
            background: white;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--navy);
            transition: var(--transition);
            font-size: 1.2rem;
            box-shadow: 0 5px 15px rgba(0,0,0,0.2);
            transform: translateY(20px);
            opacity: 0;
        }

        .team-card:hover .team-social a {
            transform: translateY(0);
            opacity: 1;
        }

        .team-social a:nth-child(1) {
            transition-delay: 0.1s;
        }

        .team-social a:nth-child(2) {
            transition-delay: 0.2s;
        }

        .team-social a:nth-child(3) {
            transition-delay: 0.3s;
        }

        .team-social a:hover {
            background: var(--teal);
            color: white;
            transform: translateY(-5px) scale(1.1);
        }

        .team-info {
            padding: 2rem;
            text-align: center;
            position: relative;
            background: var(--white);
        }

        .team-info::before {
            content: '';
            position: absolute;
            top: 0;
            left: 50%;
            transform: translateX(-50%);
            width: 50px;
            height: 3px;
            background: var(--teal);
            border-radius: 3px;
            opacity: 0;
            transition: var(--transition);
        }

        .team-card:hover .team-info::before {
            opacity: 1;
            width: 80px;
        }

        .team-name {
            font-size: 1.5rem;
            font-weight: 700;
            color: var(--navy);
            margin-bottom: 0.5rem;
            transition: var(--transition);
        }

        .team-card:hover .team-name {
            color: var(--teal);
        }

        .team-position {
            display: inline-block;
            color: var(--teal);
            font-weight: 600;
            font-size: 0.9rem;
            text-transform: uppercase;
            letter-spacing: 1px;
            margin-bottom: 1rem;
            background: var(--teal-soft);
            padding: 0.3rem 1.2rem;
            border-radius: 50px;
            border: 1px solid var(--teal-glow);
        }

        .team-bio {
            color: var(--gray);
            font-size: 0.95rem;
            line-height: 1.7;
            margin-bottom: 1rem;
        }

        .team-expertise {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            gap: 0.5rem;
            margin-top: 1rem;
        }

        .expertise-tag {
            background: var(--gray-bg);
            color: var(--gray);
            padding: 0.2rem 0.8rem;
            border-radius: 50px;
            font-size: 0.75rem;
            font-weight: 500;
            transition: var(--transition);
        }

        .team-card:hover .expertise-tag {
            background: var(--teal-soft);
            color: var(--teal);
        }

        /* ===== VALUES SECTION ===== */
        .values-section {
            padding: 6rem 0;
            background: linear-gradient(145deg, var(--navy), var(--navy-dark));
            color: white;
            position: relative;
            overflow: hidden;
        }

        .values-section::before {
            content: '';
            position: absolute;
            top: -50%;
            right: -20%;
            width: 80%;
            height: 200%;
            background: radial-gradient(circle, rgba(204,85,0,0.1) 0%, transparent 70%);
            border-radius: 50%;
        }

        .values-section .section-title {
            color: white;
        }

        .values-section .section-tag {
            background: rgba(255,255,255,0.1);
            color: white;
            border-color: rgba(255,255,255,0.2);
        }

        .values-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 2rem;
            margin-top: 4rem;
            position: relative;
            z-index: 2;
        }

        .value-card {
            text-align: center;
            padding: 3rem 2rem;
            background: rgba(255,255,255,0.05);
            border-radius: var(--border-radius);
            border: 1px solid rgba(255,255,255,0.1);
            transition: var(--transition);
            backdrop-filter: blur(10px);
            position: relative;
            overflow: hidden;
        }

        .value-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: linear-gradient(145deg, var(--teal), transparent);
            opacity: 0;
            transition: var(--transition);
        }

        .value-card:hover {
            transform: translateY(-15px);
            border-color: var(--teal);
            box-shadow: 0 30px 40px -20px rgba(204,85,0,0.4);
        }

        .value-card:hover::before {
            opacity: 0.1;
        }

        .value-icon {
            width: 90px;
            height: 90px;
            background: rgba(204,85,0,0.2);
            border-radius: 30px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--teal);
            font-size: 2.2rem;
            margin: 0 auto 2rem;
            transition: var(--transition);
            position: relative;
            z-index: 2;
            border: 1px solid rgba(204,85,0,0.3);
        }

        .value-card:hover .value-icon {
            background: var(--teal);
            color: white;
            transform: rotate(5deg) scale(1.1);
            border-color: transparent;
        }

        .value-card h4 {
            font-size: 1.3rem;
            font-weight: 700;
            margin-bottom: 1rem;
            position: relative;
            z-index: 2;
        }

        .value-card p {
            color: rgba(255,255,255,0.8);
            font-size: 0.95rem;
            line-height: 1.7;
            position: relative;
            z-index: 2;
        }

        /* ===== CULTURE SECTION ===== */
        .culture-section {
            padding: 6rem 0;
            background: var(--gray-bg);
        }

        .culture-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 2rem;
            margin-top: 3rem;
        }

        .culture-card {
            background: var(--white);
            padding: 2.5rem;
            border-radius: var(--border-radius);
            border: 1px solid var(--gray-light);
            transition: var(--transition);
            text-align: center;
        }

        .culture-card:hover {
            transform: translateY(-10px);
            border-color: var(--teal);
            box-shadow: var(--shadow-xl);
        }

        .culture-icon {
            width: 70px;
            height: 70px;
            background: var(--teal-soft);
            border-radius: 20px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--teal);
            font-size: 1.8rem;
            margin: 0 auto 1.5rem;
            transition: var(--transition);
        }

        .culture-card:hover .culture-icon {
            background: var(--teal);
            color: white;
            transform: rotate(5deg);
        }

        .culture-card h4 {
            font-size: 1.2rem;
            font-weight: 700;
            color: var(--navy);
            margin-bottom: 0.8rem;
        }

        .culture-card p {
            color: var(--gray);
            font-size: 0.95rem;
            line-height: 1.7;
        }

        /* ===== JOIN TEAM CTA ===== */
        .join-cta {
            padding: 5rem 0;
            background: linear-gradient(145deg, var(--teal), var(--navy));
            color: white;
            text-align: center;
            position: relative;
            overflow: hidden;
        }

        .join-cta::before {
            content: '';
            position: absolute;
            top: -50%;
            left: -20%;
            width: 80%;
            height: 200%;
            background: radial-gradient(circle, rgba(255,255,255,0.1) 0%, transparent 70%);
            border-radius: 50%;
        }

        .join-cta .container {
            position: relative;
            z-index: 2;
        }

        .join-cta h2 {
            font-size: 2.8rem;
            font-weight: 800;
            margin-bottom: 1rem;
        }

        .join-cta p {
            font-size: 1.2rem;
            margin-bottom: 2.5rem;
            opacity: 0.9;
            max-width: 700px;
            margin-left: auto;
            margin-right: auto;
        }

        .join-btn {
            display: inline-flex;
            align-items: center;
            gap: 1rem;
            background: white;
            color: var(--navy);
            padding: 1.2rem 3rem;
            border-radius: var(--border-radius-full);
            font-weight: 700;
            font-size: 1.1rem;
            text-decoration: none;
            transition: var(--transition);
            border: 1px solid transparent;
        }

        .join-btn:hover {
            background: transparent;
            color: white;
            border-color: white;
            transform: translateY(-5px);
            box-shadow: 0 20px 30px rgba(0,0,0,0.2);
        }

        .join-btn:hover i {
            transform: translateX(5px);
        }

        .join-btn i {
            transition: var(--transition);
        }

        /* ===== RESPONSIVE ===== */
        @media (max-width: 1200px) {
            .team-grid,
            .values-grid,
            .culture-grid {
                grid-template-columns: repeat(2, 1fr);
            }
        }

        @media (max-width: 768px) {
            .container {
                padding: 0 1.5rem;
            }
            
            .section-title {
                font-size: 2.5rem;
            }
            
            .team-grid,
            .values-grid,
            .culture-grid {
                grid-template-columns: 1fr;
            }
            
            .team-image {
                height: 280px;
            }
            
            .join-cta h2 {
                font-size: 2rem;
            }
        }

        @media (max-width: 480px) {
            .section-title {
                font-size: 2rem;
            }
            
            .value-card {
                padding: 2rem;
            }
            
            .join-btn {
                width: 100%;
                justify-content: center;
            }
        }

        /* ===== ANIMATIONS ===== */
        @keyframes float {
            0% { transform: translateY(0px); }
            50% { transform: translateY(-10px); }
            100% { transform: translateY(0px); }
        }

        .team-card:nth-child(odd) {
            animation: float 6s ease-in-out infinite;
        }

        .team-card:nth-child(even) {
            animation: float 8s ease-in-out infinite;
        }
    </style>
</head>
<body>
    <!-- Page Header -->
    <div class="page-header">
        <div class="container" data-aos="fade-up" data-aos-duration="1000">
            <span class="section-tag">Our Leadership</span>
            <h1 class="section-title">Meet the <span>Experts</span></h1>
            <p class="section-desc">
                Experienced professionals committed to your success, bringing diverse expertise from HR, technology, and business strategy.
            </p>
        </div>
    </div>

    <!-- Team Grid Section -->
    <section class="team-section">
        <div class="container">
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
                        <p class="team-bio">Crafting strategies that lead directly to meaningful job placements with focus on sustainable growth and long-term success.</p>
                        <div class="team-expertise">
                            <span class="expertise-tag">Strategy</span>
                            <span class="expertise-tag">Planning</span>
                            <span class="expertise-tag">Growth</span>
                        </div>
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
                        <p class="team-bio">Accomplished strategic leader with extensive expertise in human capital management, talent acquisition, and organizational development.</p>
                        <div class="team-expertise">
                            <span class="expertise-tag">HR Strategy</span>
                            <span class="expertise-tag">Talent</span>
                            <span class="expertise-tag">Leadership</span>
                        </div>
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
                        <p class="team-bio">Motivated by easing the journey for candidates into roles where they can truly thrive and make meaningful contributions.</p>
                        <div class="team-expertise">
                            <span class="expertise-tag">Operations</span>
                            <span class="expertise-tag">Process</span>
                            <span class="expertise-tag">Efficiency</span>
                        </div>
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
                        <p class="team-bio">Social scientist and community development facilitator offering dynamic leadership in our fast-changing socio-economic world.</p>
                        <div class="team-expertise">
                            <span class="expertise-tag">Development</span>
                            <span class="expertise-tag">Leadership</span>
                            <span class="expertise-tag">Community</span>
                        </div>
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
                        <p class="team-bio">Passionate about implementing innovative solutions that empower our team and drive our organization forward through technology.</p>
                        <div class="team-expertise">
                            <span class="expertise-tag">ICT</span>
                            <span class="expertise-tag">Innovation</span>
                            <span class="expertise-tag">Solutions</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Core Values Section -->
    <section class="values-section">
        <div class="container">
            <div class="section-header" data-aos="fade-up" data-aos-duration="1000" style="text-align: center;">
                <span class="section-tag">Our Core Values</span>
                <h2 class="section-title">What Drives <span>Us</span></h2>
                <p class="section-desc" style="color: rgba(255,255,255,0.9); margin: 0 auto;">
                    Principles that guide our mission to connect worlds and nurture careers.
                </p>
            </div>
            
            <div class="values-grid">
                <div class="value-card" data-aos="fade-up" data-aos-duration="1000" data-aos-delay="100">
                    <div class="value-icon">
                        <i class="fas fa-hand-holding-heart"></i>
                    </div>
                    <h4>Integrity</h4>
                    <p>We uphold the highest ethical standards in every interaction and decision, building trust with clients and candidates alike.</p>
                </div>
                
                <div class="value-card" data-aos="fade-up" data-aos-duration="1000" data-aos-delay="200">
                    <div class="value-icon">
                        <i class="fas fa-globe-africa"></i>
                    </div>
                    <h4>Global Mindset</h4>
                    <p>We embrace diversity and think beyond borders to create international opportunities that transcend cultural boundaries.</p>
                </div>
                
                <div class="value-card" data-aos="fade-up" data-aos-duration="1000" data-aos-delay="300">
                    <div class="value-icon">
                        <i class="fas fa-lightbulb"></i>
                    </div>
                    <h4>Innovation</h4>
                    <p>We continuously evolve our solutions to meet changing workforce needs and embrace new ways of working.</p>
                </div>
                
                <div class="value-card" data-aos="fade-up" data-aos-duration="1000" data-aos-delay="400">
                    <div class="value-icon">
                        <i class="fas fa-users"></i>
                    </div>
                    <h4>Excellence</h4>
                    <p>We strive for nothing less than exceptional outcomes for our clients and candidates, delivering quality in everything we do.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Team Culture Section -->
    <section class="culture-section">
        <div class="container">
            <div class="section-header" data-aos="fade-up" data-aos-duration="1000" style="text-align: center;">
                <span class="section-tag">Our Culture</span>
                <h2 class="section-title">How We <span>Work</span></h2>
                <p class="section-desc" style="margin: 0 auto;">
                    A collaborative environment where expertise meets passion.
                </p>
            </div>
            
            <div class="culture-grid">
                <div class="culture-card" data-aos="fade-up" data-aos-duration="1000" data-aos-delay="100">
                    <div class="culture-icon">
                        <i class="fas fa-handshake"></i>
                    </div>
                    <h4>Collaborative</h4>
                    <p>We believe the best solutions come from diverse perspectives working together toward common goals.</p>
                </div>
                
                <div class="culture-card" data-aos="fade-up" data-aos-duration="1000" data-aos-delay="200">
                    <div class="culture-icon">
                        <i class="fas fa-chart-line"></i>
                    </div>
                    <h4>Growth-Oriented</h4>
                    <p>Continuous learning and development are at the heart of how we support our team and clients.</p>
                </div>
                
                <div class="culture-card" data-aos="fade-up" data-aos-duration="1000" data-aos-delay="300">
                    <div class="culture-icon">
                        <i class="fas fa-heart"></i>
                    </div>
                    <h4>People-First</h4>
                    <p>We prioritize human connection and genuine care in every relationship we build.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Join Team CTA -->
    <section class="join-cta">
        <div class="container">
            <div data-aos="zoom-in" data-aos-duration="1000">
                <h2>Join Our Team</h2>
                <p>We're always looking for passionate individuals who share our vision of connecting worlds and nurturing careers.</p>
                <a href="/brightorbit/contact" class="join-btn">
                    Explore Opportunities <i class="fas fa-arrow-right"></i>
                </a>
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