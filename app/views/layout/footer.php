<style>
           /* ===== FOOTER ===== */
        .footer {
            background: var(--logo-navy);
            color: white;
            padding: 4rem 0 2rem;
            border-top: 1px solid rgba(255,255,255,0.1);
        }

        .footer-content {
            display: grid;
            grid-template-columns: 1.5fr 2fr;
            gap: 3rem;
            margin-bottom: 3rem;
        }

        .footer-brand i {
            font-size: 2.5rem;
            color: var(--logo-teal);
            margin-bottom: 1rem;
        }

        .footer-brand h3 {
            font-size: 1.5rem;
            margin-bottom: 0.5rem;
        }

        .footer-brand p {
            color: rgba(255,255,255,0.7);
        }

        .footer-links {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 2rem;
        }

        .footer-section h4 {
            margin-bottom: 1.5rem;
            color: white;
        }

        .footer-section ul {
            list-style: none;
        }

        .footer-section ul li {
            margin-bottom: 0.75rem;
        }

        .footer-section a {
            color: rgba(255,255,255,0.7);
            text-decoration: none;
            transition: color 0.3s;
        }

        .footer-section a:hover {
            color: var(--logo-teal);
        }

        .footer-bottom {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding-top: 2rem;
            border-top: 1px solid rgba(255,255,255,0.1);
            color: rgba(255,255,255,0.6);
            font-size: 0.9rem;
        }

        .privacy-link a {
            color: rgba(255,255,255,0.6);
            text-decoration: none;
        }

        .privacy-link a:hover {
            color: var(--logo-teal);
        }
</style>
    <!-- Footer -->
    <footer class="footer">
        <div class="container">
            <div class="footer-content">
                <div class="footer-brand">
                    <i class="fas fa-globe-africa"></i>
                    <h3>BRIGHT ORBIT CONSULTANCY LTD</h3>
                    <p>Connecting Worlds, Nurturing Careers</p>
                    <p style="margin-top: 1rem; font-size: 0.9rem;">
                        <i class="fas fa-map-marker-alt"></i> Nairobi, Kenya<br>
                        <i class="fas fa-globe"></i> Global Operations<br>
                        <i class="fas fa-envelope"></i> info@brightorbit.co.ke
                    </p>
                </div>
                
                <div class="footer-links">
                    <div class="footer-section">
                        <h4>Quick Links</h4>
                        <ul>
                            <li><a href="/brightorbit/">Home</a></li>
                            <li><a href="/brightorbit/solutions">Solutions</a></li>
                            <li><a href="/brightorbit/team">Leadership</a></li>
                            <li><a href="/brightorbit/mission">Mission</a></li>
                            <li><a href="/brightorbit/contact">Contact</a></li>
                        </ul>
                    </div>
                    
                    <div class="footer-section">
                        <h4>Our Services</h4>
                        <ul>
                            <li><a href="/brightorbit/services/global-recruitment">Global Recruitment</a></li>
                            <li><a href="/brightorbit/services/hr-consulting">HR Consulting</a></li>
                            <li><a href="/brightorbit/services/career-development">Career Development</a></li>
                            <li><a href="/brightorbit/services/talent-management">Talent Management</a></li>
                            <li><a href="/brightorbit/services/mentorship">Mentorship Programs</a></li>
                        </ul>
                    </div>
                </div>
            </div>
            
            <div class="footer-bottom">
                <div class="copyright">
                    © <?= date('Y'); ?> Bright Orbit Consultancy Ltd. All rights reserved.
                </div>
                <div class="privacy-link">
                    <a href="/brightorbit/privacy">Privacy policy</a> | 
                    <a href="/brightorbit/terms">Terms of use</a>
                </div>
            </div>
        </div>
    </footer>