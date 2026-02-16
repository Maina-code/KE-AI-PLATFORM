<?php
require_once __DIR__ . '/../layout/navbar.php';
require_once __DIR__ . '/../layout/loading.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($title ?? 'Contact Us - Bright Orbit Consultancy | Get in Touch') ?></title>
    <meta name="description" content="<?= htmlspecialchars($meta_description ?? 'Contact Bright Orbit Consultancy in Kikuyu, Kenya. Reach out for global recruitment, HR consulting, and talent management solutions.') ?>">
    
    <!-- Fonts & Icons -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    
    <!-- AOS Animation Library -->
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    
    <!-- Leaflet CSS for Map -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    
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

        .section-desc {
            color: var(--gray);
            font-size: 1.2rem;
            max-width: 700px;
            line-height: 1.8;
            margin: 0 auto;
        }

        /* ===== TAGLINE SECTION ===== */
        .tagline-section {
            padding: 2rem 0 3rem;
        }

        .tagline-container {
            max-width: 900px;
            margin: 0 auto;
            background: var(--white);
            border-radius: var(--border-radius);
            padding: 2.5rem;
            box-shadow: var(--shadow-lg);
            border: 1px solid var(--gray-light);
            position: relative;
            overflow: hidden;
            text-align: center;
        }

        .tagline-container::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 4px;
            height: 100%;
            background: var(--teal);
        }

        .tagline-text {
            font-size: 2.2rem;
            font-weight: 700;
            color: var(--navy);
            line-height: 1.3;
            margin-bottom: 0.5rem;
        }

        .tagline-text em {
            font-style: italic;
            color: var(--teal);
            font-weight: 800;
        }

        /* ===== CONTACT GRID ===== */
        .contact-section {
            padding: 3rem 0 6rem;
        }

        .contact-grid {
            display: grid;
            grid-template-columns: 1fr 1.5fr;
            gap: 3rem;
            margin-top: 2rem;
        }

        /* ===== OFFICE INFORMATION ===== */
        .office-info {
            background: var(--white);
            border-radius: var(--border-radius);
            border: 1px solid var(--gray-light);
            overflow: hidden;
            box-shadow: var(--shadow-lg);
        }

        .info-header {
            padding: 2rem;
            background: linear-gradient(145deg, var(--navy), var(--navy-light));
            color: white;
        }

        .info-header h3 {
            font-size: 1.8rem;
            font-weight: 700;
            margin-bottom: 0.5rem;
        }

        .info-header p {
            opacity: 0.9;
            font-size: 1rem;
        }

        .info-details {
            padding: 2rem;
        }

        .info-item {
            display: flex;
            gap: 1.2rem;
            padding: 1.2rem 0;
            border-bottom: 1px solid var(--gray-light);
        }

        .info-item:last-child {
            border-bottom: none;
        }

        .info-icon {
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
            flex-shrink: 0;
        }

        .info-item:hover .info-icon {
            background: var(--teal);
            color: white;
            transform: rotate(5deg);
        }

        .info-content h4 {
            font-size: 1.1rem;
            font-weight: 700;
            color: var(--navy);
            margin-bottom: 0.3rem;
        }

        .info-content p {
            color: var(--gray);
            font-size: 1rem;
            line-height: 1.5;
        }

        .info-content a {
            color: var(--teal);
            text-decoration: none;
            transition: var(--transition);
            font-weight: 500;
        }

        .info-content a:hover {
            color: var(--teal-dark);
            text-decoration: underline;
        }

        /* ===== MAP CONTAINER ===== */
        .map-container {
            margin-top: 2rem;
            border-radius: var(--border-radius);
            overflow: hidden;
            border: 1px solid var(--gray-light);
            height: 250px;
        }

        #map {
            height: 100%;
            width: 100%;
            z-index: 1;
        }

        /* ===== CONTACT FORM ===== */
        .contact-form-wrapper {
            background: var(--white);
            border-radius: var(--border-radius);
            border: 1px solid var(--gray-light);
            overflow: hidden;
            box-shadow: var(--shadow-xl);
        }

        .form-header {
            padding: 2rem;
            background: linear-gradient(145deg, var(--teal), var(--teal-dark));
            color: white;
        }

        .form-header h3 {
            font-size: 1.8rem;
            font-weight: 700;
            margin-bottom: 0.5rem;
        }

        .form-header p {
            opacity: 0.9;
            font-size: 1rem;
        }

        .contact-form {
            padding: 2rem;
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
            color: var(--navy);
            margin-bottom: 0.5rem;
            font-size: 0.95rem;
        }

        .form-group label span {
            color: var(--teal);
            font-size: 1.1rem;
        }

        .form-control {
            width: 100%;
            padding: 1rem 1.2rem;
            border: 1.5px solid var(--gray-light);
            border-radius: 15px;
            font-family: var(--font-primary);
            font-size: 1rem;
            transition: var(--transition);
            background: var(--white);
        }

        .form-control:focus {
            outline: none;
            border-color: var(--teal);
            box-shadow: 0 0 0 4px var(--teal-soft);
        }

        .form-control:hover {
            border-color: var(--teal-light);
        }

        textarea.form-control {
            resize: vertical;
            min-height: 120px;
        }

        /* ===== NEWSLETTER CHECKBOX ===== */
        .newsletter-group {
            background: var(--sky-light);
            padding: 1.2rem 1.5rem;
            border-radius: 15px;
            margin-bottom: 1.5rem;
            border: 1px solid var(--gray-light);
        }

        .checkbox-wrapper {
            display: flex;
            align-items: flex-start;
            gap: 1rem;
        }

        .checkbox-wrapper input[type="checkbox"] {
            width: 20px;
            height: 20px;
            margin-top: 0.2rem;
            accent-color: var(--teal);
            cursor: pointer;
        }

        .checkbox-wrapper label {
            font-size: 0.95rem;
            color: var(--gray);
            line-height: 1.5;
            cursor: pointer;
        }

        .checkbox-wrapper a {
            color: var(--teal);
            text-decoration: none;
            font-weight: 600;
        }

        .checkbox-wrapper a:hover {
            text-decoration: underline;
        }

        /* ===== CAPTCHA SECTION ===== */
        .captcha-group {
            margin-bottom: 2rem;
        }

        .captcha-label {
            font-weight: 600;
            color: var(--navy);
            margin-bottom: 0.8rem;
            display: block;
            font-size: 0.95rem;
        }

        .captcha-box {
            background: var(--sky-light);
            border: 1.5px dashed var(--teal);
            border-radius: 15px;
            padding: 1rem;
            display: flex;
            align-items: center;
            justify-content: space-between;
            flex-wrap: wrap;
            gap: 1rem;
        }

        .captcha-text {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            color: var(--navy);
            font-weight: 500;
        }

        .captcha-text i {
            color: var(--teal);
            font-size: 1.2rem;
        }

        .captcha-button {
            background: var(--teal);
            color: white;
            border: none;
            padding: 0.8rem 1.8rem;
            border-radius: var(--border-radius-full);
            font-weight: 600;
            font-size: 0.95rem;
            cursor: pointer;
            transition: var(--transition);
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            border: 1px solid var(--teal);
        }

        .captcha-button:hover {
            background: transparent;
            color: var(--teal);
        }

        .captcha-credit {
            text-align: right;
            margin-top: 0.5rem;
            font-size: 0.8rem;
            color: var(--gray);
        }

        .captcha-credit a {
            color: var(--teal);
            text-decoration: none;
        }

        /* ===== SUBMIT BUTTON ===== */
        .submit-btn {
            background: var(--navy);
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
            border: 1px solid var(--navy);
        }

        .submit-btn:hover {
            background: var(--teal);
            border-color: var(--teal);
            transform: translateY(-3px);
            box-shadow: var(--shadow-hover);
        }

        .submit-btn i {
            transition: var(--transition);
        }

        .submit-btn:hover i {
            transform: translateX(5px);
        }

        /* ===== WHATSAPP NOTIFICATION ===== */
        .whatsapp-notice {
            margin-top: 1.5rem;
            padding: 1rem;
            background: #dcf8c6;
            border-radius: 15px;
            display: flex;
            align-items: center;
            gap: 1rem;
            border-left: 4px solid #25D366;
        }

        .whatsapp-notice i {
            font-size: 2rem;
            color: #25D366;
        }

        .whatsapp-notice p {
            color: #075e54;
            font-size: 0.95rem;
        }

        .whatsapp-notice a {
            color: var(--navy);
            font-weight: 700;
            text-decoration: none;
        }

        .whatsapp-notice a:hover {
            text-decoration: underline;
        }

        /* ===== BUSINESS HOURS ===== */
        .hours-section {
            margin-top: 2rem;
            padding: 1.5rem;
            background: var(--sky-light);
            border-radius: var(--border-radius);
            border: 1px solid var(--gray-light);
        }

        .hours-title {
            display: flex;
            align-items: center;
            gap: 0.8rem;
            margin-bottom: 1rem;
            color: var(--navy);
            font-weight: 700;
        }

        .hours-title i {
            color: var(--teal);
        }

        .hours-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 0.8rem;
        }

        .hour-item {
            display: flex;
            justify-content: space-between;
            padding: 0.5rem;
            border-bottom: 1px dashed var(--gray-light);
        }

        .hour-day {
            font-weight: 600;
            color: var(--navy);
        }

        .hour-time {
            color: var(--teal);
            font-weight: 500;
        }

        /* ===== RESPONSIVE ===== */
        @media (max-width: 1024px) {
            .contact-grid {
                grid-template-columns: 1fr;
                gap: 2rem;
            }
            
            .section-title {
                font-size: 3rem;
            }
            
            .tagline-text {
                font-size: 2rem;
            }
        }

        @media (max-width: 768px) {
            .container {
                padding: 0 1.5rem;
            }
            
            .section-title {
                font-size: 2.5rem;
            }
            
            .form-row {
                grid-template-columns: 1fr;
                gap: 0;
            }
            
            .tagline-text {
                font-size: 1.8rem;
            }
            
            .captcha-box {
                flex-direction: column;
                align-items: flex-start;
            }
            
            .captcha-button {
                width: 100%;
                justify-content: center;
            }
            
            .hours-grid {
                grid-template-columns: 1fr;
            }
        }

        @media (max-width: 480px) {
            .section-title {
                font-size: 2rem;
            }
            
            .tagline-text {
                font-size: 1.5rem;
            }
            
            .info-item {
                flex-direction: column;
                gap: 0.8rem;
            }
            
            .whatsapp-notice {
                flex-direction: column;
                text-align: center;
            }
        }
    </style>
</head>
<body>
    <!-- Page Header -->
    <div class="page-header">
        <div class="container" data-aos="fade-up" data-aos-duration="1000">
            <span class="section-tag">Get in Touch</span>
            <h1 class="section-title">Contact <span>Us</span></h1>
            <p class="section-desc">
                Reach out to us today and let's start a conversation about your talent needs
            </p>
        </div>
    </div>
    <!-- Contact Section -->
    <section class="contact-section">
        <div class="container">
            <div class="contact-grid">
                <!-- Left Column: Office Information -->
                <div class="office-info" data-aos="fade-right" data-aos-duration="1000">
                    <div class="info-header">
                        <h3>Office Information</h3>
                        <p>Visit us or get in touch through any channel</p>
                    </div>
                    
                    <div class="info-details">
                        <!-- Location -->
                        <div class="info-item">
                            <div class="info-icon">
                                <i class="fas fa-map-marker-alt"></i>
                            </div>
                            <div class="info-content">
                                <h4>Visit Us</h4>
                                <p>
                                    <strong>Bright Orbit Consultancy Limited</strong><br>
                                    Thogoto Road, Kikuyu<br>
                                    Kiambu County, Kenya
                                </p>
                            </div>
                        </div>
                        
                        <!-- Phone -->
                        <div class="info-item">
                            <div class="info-icon">
                                <i class="fas fa-phone-alt"></i>
                            </div>
                            <div class="info-content">
                                <h4>Call Us</h4>
                                <p>
                                    <a href="tel:+254740421873">+254 740 421873</a><br>
                                    <span style="color: var(--gray); font-size: 0.9rem;">Available during business hours</span>
                                </p>
                            </div>
                        </div>
                        
                        <!-- Email -->
                        <div class="info-item">
                            <div class="info-icon">
                                <i class="fas fa-envelope"></i>
                            </div>
                            <div class="info-content">
                                <h4>Email Us</h4>
                                <p>
                                    <a href="mailto:info@brightorbitconsultancy.com">info@brightorbitconsultancy.com</a><br>
                                    <span style="color: var(--gray); font-size: 0.9rem;">We reply within 24 hours</span>
                                </p>
                            </div>
                        </div>
                        
                        <!-- WhatsApp -->
                        <div class="info-item">
                            <div class="info-icon" style="background: rgba(37, 211, 102, 0.1); color: #25D366;">
                                <i class="fab fa-whatsapp"></i>
                            </div>
                            <div class="info-content">
                                <h4>WhatsApp</h4>
                                <p>
                                    <a href="https://wa.me/254740421873" target="_blank">+254 740 421873</a><br>
                                    <span style="color: var(--gray); font-size: 0.9rem;">Click to chat instantly</span>
                                </p>
                            </div>
                        </div>
                        
                        <!-- Map -->
                        <div class="map-container" id="mapContainer">
                            <div id="map"></div>
                        </div>
                        
                        <!-- Business Hours -->
                        <div class="hours-section">
                            <div class="hours-title">
                                <i class="fas fa-clock"></i>
                                <span>Business Hours</span>
                            </div>
                            <div class="hours-grid">
                                <div class="hour-item">
                                    <span class="hour-day">Monday - Friday</span>
                                    <span class="hour-time">8:00 - 17:00</span>
                                </div>
                                <div class="hour-item">
                                    <span class="hour-day">Saturday</span>
                                    <span class="hour-time">9:00 - 13:00</span>
                                </div>
                                <div class="hour-item">
                                    <span class="hour-day">Sunday</span>
                                    <span class="hour-time">Closed</span>
                                </div>
                                <div class="hour-item">
                                    <span class="hour-day">Public Holidays</span>
                                    <span class="hour-time">Closed</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Right Column: Contact Form -->
                <div class="contact-form-wrapper" data-aos="fade-left" data-aos-duration="1000">
                    <div class="form-header">
                        <h3>Send a Message</h3>
                        <p>We'll get back to you within 24 hours</p>
                    </div>
                    
                    <div class="contact-form">
                        <form id="contactForm" action="#" method="POST">
                            <div class="form-row">
                                <div class="form-group">
                                    <label>Name <span>*</span></label>
                                    <input type="text" class="form-control" id="name" name="name" required placeholder="Your full name">
                                </div>
                                <div class="form-group">
                                    <label>Email <span>*</span></label>
                                    <input type="email" class="form-control" id="email" name="email" required placeholder="you@example.com">
                                </div>
                            </div>
                            
                            <div class="form-group">
                                <label>Subject <span>*</span></label>
                                <input type="text" class="form-control" id="subject" name="subject" required placeholder="What is this regarding?">
                            </div>
                            
                            <div class="form-group">
                                <label>Message <span>*</span></label>
                                <textarea class="form-control" id="message" name="message" required placeholder="Tell us about your inquiry..."></textarea>
                            </div>
                            
                            <!-- Newsletter Opt-in -->
                            <div class="newsletter-group">
                                <div class="checkbox-wrapper">
                                    <input type="checkbox" id="newsletter" name="newsletter">
                                    <label for="newsletter">
                                        Yes, I want to receive news about promotions and updates from Bright Orbit Consultancy. 
                                        Read our <a href="/brightorbit/privacy">Privacy Policy</a>
                                    </label>
                                </div>
                            </div>
                            
                            <!-- Anti-Robot Verification -->
                            <div class="captcha-group">
                                <div class="captcha-label">Anti-Robot Verification</div>
                                <div class="captcha-box" id="captchaBox">
                                    <div class="captcha-text">
                                        <span id="captchaStatus">Click to start verification</span>
                                    </div>
                                    <button type="button" class="captcha-button" id="verifyButton">
                                        <i class="fas fa-check-circle"></i>
                                        Start Verification
                                    </button>
                                </div>
                                <div class="captcha-credit">
                                    Powered by <a href="https://friendlycaptcha.com" target="_blank">FriendlyCaptcha</a> ⇗
                                </div>
                            </div>
                            
                            <!-- WhatsApp Notice -->
                            <!-- <div class="whatsapp-notice">
                                <i class="fab fa-whatsapp"></i>
                                <p>
                                    For now, messages will be sent to our WhatsApp. <strong>+254 740 421873</strong><br>
                                    <small>Email integration coming soon.</small>
                                </p>
                            </div> -->
                            
                            <!-- Hidden field for WhatsApp redirect -->
                            <input type="hidden" id="whatsappNumber" value="254740421873">
                            
                            <!-- Submit Button -->
                            <button type="submit" class="submit-btn" id="submitBtn">
                                <span>Send Message</span>
                                <i class="fas fa-paper-plane"></i>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <?php require_once __DIR__ . '/../layout/footer.php'; ?>
    
    <!-- Leaflet JavaScript for Map -->
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
    
    <!-- AOS Animation Script -->
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    
    <script>
        // Initialize AOS
        AOS.init({
            once: true,
            offset: 100,
            duration: 1000,
            easing: 'ease-out-cubic'
        });
        
        // Initialize Map
        document.addEventListener('DOMContentLoaded', function() {
            // Kikuyu, Kenya coordinates
            const latitude = -1.2467;
            const longitude = 36.6633;
            
            const map = L.map('map').setView([latitude, longitude], 15);
            
            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                attribution: '© OpenStreetMap contributors'
            }).addTo(map);
            
            // Custom marker with teal color
            const customIcon = L.divIcon({
                className: 'custom-marker',
                html: '<i class="fas fa-map-marker-alt" style="color: #CC5500; font-size: 2rem; text-shadow: 2px 2px 4px rgba(0,0,0,0.2);"></i>',
                iconSize: [30, 30],
                iconAnchor: [15, 30]
            });
            
            const marker = L.marker([latitude, longitude], { icon: customIcon }).addTo(map);
            marker.bindPopup(`
                <b>Bright Orbit Consultancy</b><br>
                Thogoto Road, Kikuyu<br>
                Kenya
            `).openPopup();
        });
        
        // Captcha Verification
        document.getElementById('verifyButton').addEventListener('click', function() {
            const statusEl = document.getElementById('captchaStatus');
            const button = this;
            
            // Simulate verification process
            statusEl.textContent = 'Verifying...';
            button.disabled = true;
            button.style.opacity = '0.7';
            
            setTimeout(function() {
                statusEl.textContent = '✓ Verification successful';
                button.style.display = 'none';
                
                // Show success message in captcha box
                const captchaBox = document.getElementById('captchaBox');
                captchaBox.style.background = '#dcf8c6';
                captchaBox.style.borderColor = '#25D366';
                
                // Store verification state
                sessionStorage.setItem('captchaVerified', 'true');
            }, 2000);
        });
        
        // Form Submission to WhatsApp
        document.getElementById('contactForm').addEventListener('submit', function(e) {
            e.preventDefault();
            
            // Check if captcha is verified
            if (!sessionStorage.getItem('captchaVerified')) {
                alert('Please complete the anti-robot verification first.');
                return;
            }
            
            // Get form values
            const name = document.getElementById('name').value;
            const email = document.getElementById('email').value;
            const subject = document.getElementById('subject').value;
            const message = document.getElementById('message').value;
            const newsletter = document.getElementById('newsletter').checked ? 'Yes' : 'No';
            const phoneNumber = document.getElementById('whatsappNumber').value;
            
            // Format WhatsApp message
            const whatsappMessage = `*Bright Orbit Consultancy Contact Form*\n\n` +
                `*Name:* ${name}\n` +
                `*Email:* ${email}\n` +
                `*Subject:* ${subject}\n` +
                `*Message:* ${message}\n` +
                `*Newsletter:* ${newsletter}\n\n` +
                `_Sent from website contact form_`;
            
            // Encode message for URL
            const encodedMessage = encodeURIComponent(whatsappMessage);
            
            // Create WhatsApp URL
            const whatsappURL = `https://wa.me/${phoneNumber}?text=${encodedMessage}`;
            
            // Show loading state
            const submitBtn = document.getElementById('submitBtn');
            submitBtn.innerHTML = '<span>Sending...</span> <i class="fas fa-spinner fa-spin"></i>';
            submitBtn.disabled = true;
            
            // Open WhatsApp in new tab
            setTimeout(function() {
                window.open(whatsappURL, '_blank');
                
                // Reset form
                document.getElementById('contactForm').reset();
                sessionStorage.removeItem('captchaVerified');
                
                // Reset captcha
                document.getElementById('captchaStatus').textContent = 'Click to start verification';
                document.getElementById('verifyButton').style.display = 'inline-flex';
                document.getElementById('verifyButton').disabled = false;
                document.getElementById('verifyButton').style.opacity = '1';
                document.getElementById('captchaBox').style.background = '';
                document.getElementById('captchaBox').style.borderColor = '';
                
                // Reset button
                submitBtn.innerHTML = '<span>Send Message</span> <i class="fas fa-paper-plane"></i>';
                submitBtn.disabled = false;
                
                alert('Thank you for contacting us! WhatsApp has been opened to send your message.');
            }, 1500);
        });
        
        // Smooth scrolling for anchor links
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