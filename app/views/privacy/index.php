<?php
require_once __DIR__ . '/../layout/navbar.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($title ?? 'Privacy Policy - Bright Orbit Consultancy | GDPR Compliance') ?></title>
    <meta name="description" content="<?= htmlspecialchars($meta_description ?? 'Read our Privacy Policy to understand how Bright Orbit Consultancy collects, uses, and protects your personal information in compliance with GDPR.') ?>">
    
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
            text-align: center;
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

        .last-updated {
            color: var(--gray);
            font-size: 1rem;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
            margin-top: 1rem;
        }

        .last-updated i {
            color: var(--teal);
        }

        /* ===== PRIVACY CONTENT ===== */
        .privacy-section {
            padding: 3rem 0 6rem;
        }

        .privacy-container {
            max-width: 900px;
            margin: 0 auto;
        }

        .privacy-card {
            background: var(--white);
            border-radius: var(--border-radius);
            border: 1px solid var(--gray-light);
            overflow: hidden;
            box-shadow: var(--shadow-lg);
            margin-bottom: 2rem;
        }

        .privacy-header {
            padding: 2rem;
            background: linear-gradient(145deg, var(--navy), var(--navy-light));
            color: white;
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        .privacy-header i {
            font-size: 2.5rem;
            color: var(--teal);
        }

        .privacy-header h2 {
            font-size: 1.8rem;
            font-weight: 700;
        }

        .privacy-content {
            padding: 2.5rem;
        }

        /* ===== POLICY SECTIONS ===== */
        .policy-section {
            margin-bottom: 2.5rem;
            padding-bottom: 2.5rem;
            border-bottom: 1px dashed var(--gray-light);
        }

        .policy-section:last-child {
            border-bottom: none;
            margin-bottom: 0;
            padding-bottom: 0;
        }

        .section-heading {
            display: flex;
            align-items: center;
            gap: 1rem;
            margin-bottom: 1.5rem;
        }

        .section-icon {
            width: 50px;
            height: 50px;
            background: var(--teal-soft);
            border-radius: 15px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--teal);
            font-size: 1.3rem;
            transition: var(--transition);
        }

        .policy-section:hover .section-icon {
            background: var(--teal);
            color: white;
            transform: rotate(5deg);
        }

        .section-heading h3 {
            font-size: 1.5rem;
            font-weight: 700;
            color: var(--navy);
        }

        .policy-text {
            color: var(--gray);
            font-size: 1rem;
            line-height: 1.8;
            margin-bottom: 1rem;
        }

        .policy-text strong {
            color: var(--navy);
        }

        .policy-text a {
            color: var(--teal);
            text-decoration: none;
            font-weight: 600;
            transition: var(--transition);
        }

        .policy-text a:hover {
            color: var(--teal-dark);
            text-decoration: underline;
        }

        /* ===== BULLET POINTS ===== */
        .bullet-list {
            list-style: none;
            padding: 0;
            margin: 1.5rem 0;
        }

        .bullet-list li {
            display: flex;
            align-items: flex-start;
            gap: 1rem;
            padding: 0.8rem 0;
            border-bottom: 1px solid var(--gray-light);
            color: var(--gray);
        }

        .bullet-list li:last-child {
            border-bottom: none;
        }

        .bullet-list li i {
            color: var(--teal);
            font-size: 1rem;
            margin-top: 0.3rem;
            width: 20px;
        }

        .bullet-list li span {
            flex: 1;
        }

        /* ===== CONTACT INFO ===== */
        .contact-info-box {
            background: var(--sky-light);
            border-radius: var(--border-radius);
            padding: 2rem;
            margin-top: 2rem;
            border-left: 4px solid var(--teal);
        }

        .contact-info-box h4 {
            font-size: 1.2rem;
            font-weight: 700;
            color: var(--navy);
            margin-bottom: 1rem;
            display: flex;
            align-items: center;
            gap: 0.8rem;
        }

        .contact-info-box h4 i {
            color: var(--teal);
        }

        .contact-info-box p {
            color: var(--gray);
            margin-bottom: 0.5rem;
        }

        .contact-info-box a {
            color: var(--teal);
            text-decoration: none;
            font-weight: 600;
        }

        .contact-info-box a:hover {
            text-decoration: underline;
        }

        /* ===== GDPR BADGE ===== */
        .gdpr-badge {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            background: rgba(204,85,0,0.08);
            color: var(--teal);
            padding: 0.5rem 1.2rem;
            border-radius: var(--border-radius-full);
            font-weight: 600;
            font-size: 0.85rem;
            margin-bottom: 1.5rem;
            border: 1px solid rgba(204,85,0,0.15);
        }

        /* ===== DIVIDER ===== */
        .divider {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
            margin: 1.5rem 0;
            color: var(--gray-light);
        }

        .divider i {
            font-size: 0.8rem;
        }

        .divider span {
            color: var(--gray);
            font-weight: 500;
        }

        /* ===== RESPONSIVE ===== */
        @media (max-width: 768px) {
            .container {
                padding: 0 1.5rem;
            }
            
            .section-title {
                font-size: 2.5rem;
            }
            
            .privacy-content {
                padding: 1.5rem;
            }
            
            .section-heading {
                flex-direction: column;
                align-items: flex-start;
                gap: 0.8rem;
            }
            
            .section-heading h3 {
                font-size: 1.3rem;
            }
            
            .privacy-header {
                flex-direction: column;
                text-align: center;
            }
        }

        @media (max-width: 480px) {
            .section-title {
                font-size: 2rem;
            }
            
            .bullet-list li {
                flex-direction: column;
                gap: 0.3rem;
            }
        }

        /* ===== PRINT STYLES ===== */
        @media print {
            .navbar,
            .footer,
            .page-header::before {
                display: none;
            }
            
            .privacy-card {
                box-shadow: none;
                border: 1px solid #ccc;
            }
            
            .section-icon {
                background: none;
                color: black;
            }
        }
    </style>
</head>
<body>
    <!-- Page Header -->
    <div class="page-header">
        <div class="container" data-aos="fade-up" data-aos-duration="1000">
            <span class="section-tag">Legal</span>
            <h1 class="section-title">Privacy <span>Policy</span></h1>
            <div class="last-updated">
                <i class="fas fa-calendar-alt"></i>
                <span>Last Updated: <?= date('F j, Y') ?></span>
            </div>
        </div>
    </div>

    <!-- Privacy Content Section -->
    <section class="privacy-section">
        <div class="container">
            <div class="privacy-container">
                <!-- GDPR Compliance Badge -->
                <div class="gdpr-badge" data-aos="fade-up" data-aos-duration="1000">
                    <i class="fas fa-shield-alt"></i>
                    <span>GDPR Compliant</span>
                </div>

                <!-- Main Privacy Card -->
                <div class="privacy-card" data-aos="fade-up" data-aos-duration="1000">
                    <div class="privacy-header">
                        <i class="fas fa-file-shield"></i>
                        <h2>Bright Orbit Consultancy Limited</h2>
                    </div>
                    
                    <div class="privacy-content">
                        <!-- Introduction -->
                        <div class="policy-section">
                            <p class="policy-text">
                                This Privacy Policy outlines how Bright Orbit Consultancy Limited ("we," "our," or "us") collects, uses, and protects the information you provide when you visit our website and subscribe to our email marketing services. We are committed to ensuring the privacy and security of your personal data in compliance with the General Data Protection Regulation (GDPR).
                            </p>
                            <div class="divider">
                                <i class="fas fa-circle"></i>
                                <i class="fas fa-circle"></i>
                                <i class="fas fa-circle"></i>
                                <span>Data Protection</span>
                                <i class="fas fa-circle"></i>
                                <i class="fas fa-circle"></i>
                                <i class="fas fa-circle"></i>
                            </div>
                        </div>

                        <!-- DATA CONTROLLER -->
                        <div class="policy-section">
                            <div class="section-heading">
                                <div class="section-icon">
                                    <i class="fas fa-building"></i>
                                </div>
                                <h3>DATA CONTROLLER</h3>
                            </div>
                            <p class="policy-text">
                                Bright Orbit Consultancy Limited with registered office in Kikuyu Thogoto Road, Kenya is ensuring compliance with the rules on personal data processing by providing the following information on the processing of data that is received, or in any case collected, while browsing this site.
                            </p>
                        </div>

                        <!-- CONSENT -->
                        <div class="policy-section">
                            <div class="section-heading">
                                <div class="section-icon">
                                    <i class="fas fa-check-circle"></i>
                                </div>
                                <h3>CONSENT</h3>
                            </div>
                            <p class="policy-text">
                                When you provide us with personal information to complete a transaction, verify your credit card, place an order, arrange for a delivery or return a purchase, we imply that you consent to our collecting it and using it for that specific reason only.
                            </p>
                            <p class="policy-text">
                                If we ask for your personal information for a secondary reason, like marketing, we will either ask you directly for your expressed consent, or provide you with an opportunity to say no.
                            </p>
                            <p class="policy-text">
                                By checking the consent box, you agree to receive marketing communications from us. You can withdraw your consent at any time by following the instructions provided in our emails or contacting us directly. If after you consent, you change your mind, you may withdraw your consent for us to contact you, for the continued collection, use or disclosure of your information, at anytime, by contacting us at <a href="mailto:info@brightorbitconsultancy.com">info@brightorbitconsultancy.com</a>.
                            </p>
                        </div>

                        <!-- INFORMATION WE COLLECT -->
                        <div class="policy-section">
                            <div class="section-heading">
                                <div class="section-icon">
                                    <i class="fas fa-database"></i>
                                </div>
                                <h3>INFORMATION WE COLLECT</h3>
                            </div>
                            <p class="policy-text">
                                We collect the following information when you subscribe to our email marketing services:
                            </p>
                            <ul class="bullet-list">
                                <li>
                                    <i class="fas fa-user"></i>
                                    <span><strong>Name:</strong> We collect your first and last name, if given</span>
                                </li>
                                <li>
                                    <i class="fas fa-envelope"></i>
                                    <span><strong>Email Address:</strong> We collect your email address to send you newsletters, updates, and promotional materials.</span>
                                </li>
                            </ul>
                        </div>

                        <!-- HOW WE USE YOUR INFORMATION -->
                        <div class="policy-section">
                            <div class="section-heading">
                                <div class="section-icon">
                                    <i class="fas fa-chart-line"></i>
                                </div>
                                <h3>HOW WE USE YOUR INFORMATION</h3>
                            </div>
                            <p class="policy-text">
                                We use your email address to:
                            </p>
                            <ul class="bullet-list">
                                <li>
                                    <i class="fas fa-paper-plane"></i>
                                    <span>Send you newsletters, updates, and promotional materials related to our products and services.</span>
                                </li>
                                <li>
                                    <i class="fas fa-chart-bar"></i>
                                    <span>Improve our website and email marketing strategies based on user preferences and behavior.</span>
                                </li>
                            </ul>
                        </div>

                        <!-- DATA SECURITY -->
                        <div class="policy-section">
                            <div class="section-heading">
                                <div class="section-icon">
                                    <i class="fas fa-lock"></i>
                                </div>
                                <h3>DATA SECURITY</h3>
                            </div>
                            <p class="policy-text">
                                We are committed to ensuring the security of your information. We implement appropriate technical and organizational measures to protect your data against unauthorized access, disclosure, alteration, and destruction.
                            </p>
                        </div>

                        <!-- DATA SHARING AND THIRD PARTIES -->
                        <div class="policy-section">
                            <div class="section-heading">
                                <div class="section-icon">
                                    <i class="fas fa-share-alt"></i>
                                </div>
                                <h3>DATA SHARING AND THIRD PARTIES</h3>
                            </div>
                            <p class="policy-text">
                                We do not sell, trade, or transfer your personal information to third parties without your explicit consent. Your information may be shared with service providers who assist us in operating our website and conducting our business, as long as they agree to keep the information confidential.
                            </p>
                        </div>

                        <!-- YOUR RIGHTS -->
                        <div class="policy-section">
                            <div class="section-heading">
                                <div class="section-icon">
                                    <i class="fas fa-gavel"></i>
                                </div>
                                <h3>YOUR RIGHTS</h3>
                            </div>
                            <p class="policy-text">
                                You have the right to:
                            </p>
                            <ul class="bullet-list">
                                <li>
                                    <i class="fas fa-eye"></i>
                                    <span>Access the personal information we hold about you.</span>
                                </li>
                                <li>
                                    <i class="fas fa-pencil-alt"></i>
                                    <span>Correct any inaccuracies in your information.</span>
                                </li>
                                <li>
                                    <i class="fas fa-trash"></i>
                                    <span>Request the erasure of your personal data.</span>
                                </li>
                                <li>
                                    <i class="fas fa-ban"></i>
                                    <span>Object to the processing of your personal data.</span>
                                </li>
                            </ul>
                            <p class="policy-text">
                                To exercise these rights, please contact us at <a href="mailto:info@brightorbitconsultancy.com">info@brightorbitconsultancy.com</a>
                            </p>
                        </div>

                        <!-- COOKIES -->
                        <div class="policy-section">
                            <div class="section-heading">
                                <div class="section-icon">
                                    <i class="fas fa-cookie-bite"></i>
                                </div>
                                <h3>COOKIES</h3>
                            </div>
                            <p class="policy-text">
                                We use cookies to enhance your browsing experience. You can manage your cookie preferences through your browser settings.
                            </p>
                        </div>

                        <!-- CHANGES TO THIS PRIVACY POLICY -->
                        <div class="policy-section">
                            <div class="section-heading">
                                <div class="section-icon">
                                    <i class="fas fa-sync-alt"></i>
                                </div>
                                <h3>CHANGES TO THIS PRIVACY POLICY</h3>
                            </div>
                            <p class="policy-text">
                                We reserve the right to update this Privacy Policy to reflect changes in our practices. We encourage you to review this policy periodically for any updates.
                            </p>
                        </div>

                        <!-- CONTACT US -->
                        <div class="policy-section">
                            <div class="section-heading">
                                <div class="section-icon">
                                    <i class="fas fa-headset"></i>
                                </div>
                                <h3>CONTACT US</h3>
                            </div>
                            <p class="policy-text">
                                If you have any questions or concerns regarding this Privacy Policy, please contact us at <a href="mailto:info@brightorbitconsultancy.com">info@brightorbitconsultancy.com</a>
                            </p>
                            
                            <div class="contact-info-box">
                                <h4>
                                    <i class="fas fa-building"></i>
                                    Bright Orbit Consultancy Limited
                                </h4>
                                <p><i class="fas fa-map-marker-alt" style="color: var(--teal); width: 20px;"></i> Kikuyu Thogoto Road, Kenya</p>
                                <p><i class="fas fa-phone" style="color: var(--teal); width: 20px;"></i> <a href="tel:+254740421873">+254 740 421873</a></p>
                                <p><i class="fas fa-envelope" style="color: var(--teal); width: 20px;"></i> <a href="mailto:info@brightorbitconsultancy.com">info@brightorbitconsultancy.com</a></p>
                                <p><i class="fas fa-globe" style="color: var(--teal); width: 20px;"></i> www.brightorbitconsultancy.com</p>
                            </div>
                        </div>

                        <!-- Footer Note -->
                        <div class="divider" style="margin-top: 2rem;">
                            <i class="fas fa-circle"></i>
                            <i class="fas fa-circle"></i>
                            <i class="fas fa-circle"></i>
                            <span>Your privacy matters to us</span>
                            <i class="fas fa-circle"></i>
                            <i class="fas fa-circle"></i>
                            <i class="fas fa-circle"></i>
                        </div>
                    </div>
                </div>

                <!-- Download/Print Option -->
                <div style="text-align: center; margin-top: 2rem;" data-aos="fade-up" data-aos-duration="1000">
                    <a href="#" onclick="window.print(); return false;" class="btn btn-outline" style="padding: 1rem 2.5rem; display: inline-flex; align-items: center; gap: 0.8rem; border: 1.5px solid var(--gray-light); border-radius: var(--border-radius-full); text-decoration: none; color: var(--navy); transition: var(--transition);">
                        <i class="fas fa-print"></i>
                        <span>Print or Save as PDF</span>
                    </a>
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