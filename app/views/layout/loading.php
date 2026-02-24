<?php
// =====================================================
// LAZY LOADER & CURSOR COMPONENT
// Include this file in any page to add loader and cursor
// This loader waits for ALL content to load before disappearing
// =====================================================
?>

<!-- Loader -->
<div class="page-loader" id="pageLoader">
    <div class="loader-container">
        <div class="loader-logo">
            <i class="fas fa-globe-africa"></i>
        </div>
        <div class="loader-text">
            <span class="loader-title">NuruAI Platform</span>
            <span class="loader-subtitle" id="loaderStatus">Loading resources...</span>
        </div>
        <div class="loader-progress">
            <div class="loader-progress-bar" id="loaderProgressBar"></div>
        </div>
        <div class="loader-percentage" id="loaderPercentage">0%</div>
    </div>
</div>

<style>
    /* ===== LOADER ANIMATION ===== */
    .page-loader {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: linear-gradient(135deg, #0A2351, #1a3a6b);
        z-index: 99999;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: opacity 0.8s cubic-bezier(0.4, 0, 0.2, 1);
        backdrop-filter: blur(10px);
    }

    .loader-container {
        text-align: center;
        max-width: 400px;
        padding: 30px;
    }

    .loader-logo {
        width: 120px;
        height: 120px;
        margin: 0 auto 30px;
        background: linear-gradient(135deg, #C5A572, #9e814d);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #0A2351;
        font-size: 3rem;
        animation: logoPulse 1.5s ease-in-out infinite;
        box-shadow: 0 0 30px rgba(197, 165, 114, 0.3);
    }

    .loader-text {
        margin-bottom: 25px;
    }

    .loader-title {
        display: block;
        font-size: 1.5rem;
        font-weight: 600;
        color: white;
        margin-bottom: 8px;
        letter-spacing: 1px;
    }

    .loader-subtitle {
        display: block;
        font-size: 0.9rem;
        color: rgba(255, 255, 255, 0.7);
        text-transform: uppercase;
        letter-spacing: 2px;
    }

    .loader-progress {
        width: 100%;
        height: 4px;
        background: rgba(255, 255, 255, 0.1);
        border-radius: 4px;
        overflow: hidden;
        margin-bottom: 15px;
    }

    .loader-progress-bar {
        height: 100%;
        background: linear-gradient(90deg, #C5A572, #ffd700);
        width: 0%;
        transition: width 0.3s ease;
        border-radius: 4px;
    }

    .loader-percentage {
        font-size: 1.2rem;
        font-weight: 600;
        color: #C5A572;
        text-shadow: 0 0 10px rgba(197, 165, 114, 0.5);
    }

    @keyframes logoPulse {
        0%, 100% { 
            transform: scale(1);
            box-shadow: 0 0 30px rgba(197, 165, 114, 0.3);
        }
        50% { 
            transform: scale(1.05);
            box-shadow: 0 0 50px rgba(197, 165, 114, 0.6);
        }
    }

    /* Hide loader when hidden class is added */
    .page-loader.hidden {
        opacity: 0;
        pointer-events: none;
    }

    /* ===== CURSOR EFFECTS ===== */
    .cursor-dot {
        width: 8px;
        height: 8px;
        background: #C5A572;
        border-radius: 50%;
        position: fixed;
        pointer-events: none;
        z-index: 99999;
        transform: translate(-50%, -50%);
        transition: width 0.2s, height 0.2s, background 0.2s, opacity 0.2s;
        box-shadow: 0 0 15px #C5A572;
    }

    .cursor-outline {
        width: 40px;
        height: 40px;
        border: 2px solid rgba(197, 165, 114, 0.5);
        border-radius: 50%;
        position: fixed;
        pointer-events: none;
        z-index: 99998;
        transform: translate(-50%, -50%);
        transition: all 0.15s ease, opacity 0.2s;
        box-shadow: 0 0 20px rgba(197, 165, 114, 0.2);
    }

    /* Hide cursor on touch devices */
    @media (hover: none) and (pointer: coarse) {
        .cursor-dot, .cursor-outline {
            display: none;
        }
    }

    /* Content fade-in after loader */
    body.loaded .main-content,
    body.loaded .navbar,
    body.loaded .sidebar {
        animation: contentFadeIn 0.8s ease;
    }

    @keyframes contentFadeIn {
        from {
            opacity: 0;
            transform: translateY(20px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }
</style>

<script>
(function() {
    'use strict';

    // ===== LAZY LOADER WITH PROGRESS TRACKING =====
    function initLoader() {
        const loader = document.getElementById('pageLoader');
        const loaderStatus = document.getElementById('loaderStatus');
        const loaderProgressBar = document.getElementById('loaderProgressBar');
        const loaderPercentage = document.getElementById('loaderPercentage');
        
        if (!loader) return;

        // Track loading progress
        let progress = 0;
        let resourcesLoaded = 0;
        let totalResources = 0;
        let aiDataLoaded = false;
        let chartsLoaded = false;
        let imagesLoaded = false;

        // Function to update loader progress
        function updateProgress(message, increment = 0) {
            if (increment > 0) {
                progress = Math.min(progress + increment, 100);
            }
            
            // Update UI
            if (loaderProgressBar) {
                loaderProgressBar.style.width = progress + '%';
            }
            if (loaderPercentage) {
                loaderPercentage.textContent = Math.round(progress) + '%';
            }
            if (loaderStatus && message) {
                loaderStatus.textContent = message;
            }

            // If progress is 100%, hide loader
            if (progress >= 100) {
                setTimeout(() => {
                    loader.classList.add('hidden');
                    document.body.classList.add('loaded');
                    
                    // Trigger any post-load animations
                    document.dispatchEvent(new CustomEvent('pageFullyLoaded'));
                }, 500);
            }
        }

        // Count total resources
        function countResources() {
            // Count images
            const images = document.querySelectorAll('img');
            totalResources += images.length;
            
            // Count scripts (excluding this script)
            const scripts = document.querySelectorAll('script[src]');
            totalResources += scripts.length;
            
            // Count stylesheets
            const styles = document.querySelectorAll('link[rel="stylesheet"]');
            totalResources += styles.length;
            
            // Count iframes
            const iframes = document.querySelectorAll('iframe');
            totalResources += iframes.length;
            
            // Add 2 for AI data and charts
            totalResources += 2;
            
            // If no resources, set minimum
            if (totalResources === 0) totalResources = 1;
        }

        // Track image loading
        function trackImages() {
            const images = document.querySelectorAll('img');
            images.forEach(img => {
                if (img.complete) {
                    resourcesLoaded++;
                    updateProgress('Loading images...', (100 / totalResources));
                } else {
                    img.addEventListener('load', () => {
                        resourcesLoaded++;
                        updateProgress('Loading images...', (100 / totalResources));
                    });
                    img.addEventListener('error', () => {
                        resourcesLoaded++;
                        updateProgress('Loading images...', (100 / totalResources));
                    });
                }
            });
        }

        // Track script loading
        function trackScripts() {
            const scripts = document.querySelectorAll('script[src]');
            scripts.forEach(script => {
                if (script.readyState === 'loaded' || script.readyState === 'complete') {
                    resourcesLoaded++;
                    updateProgress('Loading scripts...', (100 / totalResources));
                } else {
                    script.addEventListener('load', () => {
                        resourcesLoaded++;
                        updateProgress('Loading scripts...', (100 / totalResources));
                    });
                    script.addEventListener('error', () => {
                        resourcesLoaded++;
                        updateProgress('Loading scripts...', (100 / totalResources));
                    });
                }
            });
        }

        // Track stylesheet loading
        function trackStylesheets() {
            const styles = document.querySelectorAll('link[rel="stylesheet"]');
            styles.forEach(style => {
                if (style.sheet) {
                    resourcesLoaded++;
                    updateProgress('Loading styles...', (100 / totalResources));
                } else {
                    style.addEventListener('load', () => {
                        resourcesLoaded++;
                        updateProgress('Loading styles...', (100 / totalResources));
                    });
                    style.addEventListener('error', () => {
                        resourcesLoaded++;
                        updateProgress('Loading styles...', (100 / totalResources));
                    });
                }
            });
        }

        // Track iframe loading
        function trackIframes() {
            const iframes = document.querySelectorAll('iframe');
            iframes.forEach(iframe => {
                if (iframe.contentDocument.readyState === 'complete') {
                    resourcesLoaded++;
                    updateProgress('Loading iframes...', (100 / totalResources));
                } else {
                    iframe.addEventListener('load', () => {
                        resourcesLoaded++;
                        updateProgress('Loading iframes...', (100 / totalResources));
                    });
                }
            });
        }

        // Wait for AI data
        function waitForAIData() {
            // Check if AI data is already loaded
            if (window.aiDataLoaded) {
                resourcesLoaded++;
                aiDataLoaded = true;
                updateProgress('AI data loaded...', (100 / totalResources));
                return;
            }

            // Listen for AI data load event
            document.addEventListener('aiDataLoaded', () => {
                resourcesLoaded++;
                aiDataLoaded = true;
                updateProgress('AI data loaded...', (100 / totalResources));
            });

            // Fallback timeout
            setTimeout(() => {
                if (!aiDataLoaded) {
                    resourcesLoaded++;
                    aiDataLoaded = true;
                    updateProgress('AI data loaded...', (100 / totalResources));
                }
            }, 5000);
        }

        // Wait for charts
        function waitForCharts() {
            // Check if charts are already loaded
            if (window.chartsLoaded) {
                resourcesLoaded++;
                chartsLoaded = true;
                updateProgress('Loading charts...', (100 / totalResources));
                return;
            }

            // Listen for charts load event
            document.addEventListener('chartsLoaded', () => {
                resourcesLoaded++;
                chartsLoaded = true;
                updateProgress('Loading charts...', (100 / totalResources));
            });

            // Fallback timeout
            setTimeout(() => {
                if (!chartsLoaded) {
                    resourcesLoaded++;
                    chartsLoaded = true;
                    updateProgress('Loading charts...', (100 / totalResources));
                }
            }, 5000);
        }

        // Initialize loader
        function startLoading() {
            countResources();
            trackImages();
            trackScripts();
            trackStylesheets();
            trackIframes();
            waitForAIData();
            waitForCharts();

            // Initial progress
            updateProgress('Initializing...', 5);

            // Window load event
            window.addEventListener('load', () => {
                // Mark any remaining resources as loaded
                const remaining = totalResources - resourcesLoaded;
                if (remaining > 0) {
                    resourcesLoaded = totalResources - 2; // Leave AI and charts
                    updateProgress('Finalizing...', remaining - 2);
                }
            });

            // Maximum wait time - 10 seconds
            setTimeout(() => {
                if (progress < 100) {
                    resourcesLoaded = totalResources;
                    updateProgress('Ready!', 100);
                }
            }, 10000);
        }

        // Start the loading process
        startLoading();
    }

    // ===== CURSOR EFFECTS =====
    function initCursor() {
        const cursorDot = document.getElementById('cursorDot');
        const cursorOutline = document.getElementById('cursorOutline');

        if (!cursorDot || !cursorOutline) return;

        // Don't show cursor on mobile
        if (window.matchMedia('(hover: none) and (pointer: coarse)').matches) {
            cursorDot.style.display = 'none';
            cursorOutline.style.display = 'none';
            return;
        }

        let mouseX = 0, mouseY = 0;
        let outlineX = 0, outlineY = 0;
        
        document.addEventListener('mousemove', function(e) {
            mouseX = e.clientX;
            mouseY = e.clientY;
            
            // Move cursor dot immediately
            cursorDot.style.left = mouseX + 'px';
            cursorDot.style.top = mouseY + 'px';
        });

        // Smooth outline animation
        function animateOutline() {
            outlineX += (mouseX - outlineX) * 0.2;
            outlineY += (mouseY - outlineY) * 0.2;
            
            cursorOutline.style.left = outlineX + 'px';
            cursorOutline.style.top = outlineY + 'px';
            
            requestAnimationFrame(animateOutline);
        }
        animateOutline();

        // Hide cursor when leaving window
        document.addEventListener('mouseleave', function() {
            cursorDot.style.opacity = '0';
            cursorOutline.style.opacity = '0';
        });

        document.addEventListener('mouseenter', function() {
            cursorDot.style.opacity = '1';
            cursorOutline.style.opacity = '1';
        });

        // Enlarge cursor on hoverable elements
        const hoverElements = 'a, button, .category-card, .service-card, .process-item, .btn, [role="button"], input, select, textarea, .risk-card, .stat-card, .quick-action-btn';
        
        document.addEventListener('mouseover', function(e) {
            if (e.target.matches(hoverElements) || e.target.closest(hoverElements)) {
                cursorDot.style.transform = 'translate(-50%, -50%) scale(1.5)';
                cursorDot.style.background = '#ffd700';
                cursorOutline.style.transform = 'translate(-50%, -50%) scale(1.8)';
                cursorOutline.style.borderColor = '#ffd700';
                cursorOutline.style.borderWidth = '3px';
                cursorOutline.style.backgroundColor = 'rgba(255, 215, 0, 0.1)';
            }
        });

        document.addEventListener('mouseout', function(e) {
            if (e.target.matches(hoverElements) || e.target.closest(hoverElements)) {
                cursorDot.style.transform = 'translate(-50%, -50%) scale(1)';
                cursorDot.style.background = '#C5A572';
                cursorOutline.style.transform = 'translate(-50%, -50%) scale(1)';
                cursorOutline.style.borderColor = '#C5A572';
                cursorOutline.style.borderWidth = '2px';
                cursorOutline.style.backgroundColor = 'transparent';
            }
        });

        // Handle cursor when clicking
        document.addEventListener('mousedown', function() {
            cursorDot.style.transform = 'translate(-50%, -50%) scale(0.8)';
            cursorOutline.style.transform = 'translate(-50%, -50%) scale(0.8)';
        });

        document.addEventListener('mouseup', function() {
            cursorDot.style.transform = 'translate(-50%, -50%) scale(1)';
            cursorOutline.style.transform = 'translate(-50%, -50%) scale(1)';
        });

        // Hide cursor on scroll
        let scrollTimeout;
        document.addEventListener('scroll', function() {
            cursorDot.style.opacity = '0.5';
            cursorOutline.style.opacity = '0.5';
            
            clearTimeout(scrollTimeout);
            scrollTimeout = setTimeout(function() {
                cursorDot.style.opacity = '1';
                cursorOutline.style.opacity = '1';
            }, 100);
        });
    }

    // ===== SIGNAL AI DATA LOADED =====
    function signalAILoaded() {
        // Mark AI data as loaded
        window.aiDataLoaded = true;
        document.dispatchEvent(new CustomEvent('aiDataLoaded'));
    }

    // ===== SIGNAL CHARTS LOADED =====
    function signalChartsLoaded() {
        window.chartsLoaded = true;
        document.dispatchEvent(new CustomEvent('chartsLoaded'));
    }

    // ===== HERO PARTICLES =====
    function initParticles() {
        const particles = document.querySelectorAll('.particle');
        if (particles.length === 0) return;

        // Add random animation delays and durations
        particles.forEach(particle => {
            particle.style.animationDelay = Math.random() * -20 + 's';
            particle.style.animationDuration = (Math.random() * 20 + 20) + 's';
        });
    }

    // Initialize everything when DOM is ready
    document.addEventListener('DOMContentLoaded', function() {
        initLoader();
        initCursor();
        initParticles();
        
        // Signal that charts are loaded (override when charts are actually ready)
        setTimeout(signalChartsLoaded, 2000);
        
        // Signal AI data loaded (override when AI data is actually ready)
        setTimeout(signalAILoaded, 2500);
    });

})();
</script>

<!-- Optional: Hero Particles HTML Structure (include in your hero section) -->
<?php if (isset($showParticles) && $showParticles): ?>
<div class="hero-background">
    <div class="hero-gradient"></div>
    <div class="hero-particles">
        <?php for($i = 0; $i < 50; $i++): ?>
        <div class="particle" style="
            left: <?= rand(0, 100) ?>%;
            top: <?= rand(0, 100) ?>%;
            width: <?= rand(1, 4) ?>px;
            height: <?= rand(1, 4) ?>px;
            animation: particle-float <?= rand(15, 40) ?>s linear infinite;
            animation-delay: -<?= rand(0, 20) ?>s;
            opacity: <?= rand(1, 5) / 10 ?>;
        "></div>
        <?php endfor; ?>
    </div>
</div>

<style>
.hero-background {
    position: absolute;
    inset: 0;
    z-index: 1;
    overflow: hidden;
    pointer-events: none;
}

.hero-gradient {
    position: absolute;
    inset: 0;
    background: radial-gradient(circle at 30% 50%, rgba(197, 165, 114, 0.05) 0%, transparent 50%),
                radial-gradient(circle at 70% 80%, rgba(197, 165, 114, 0.05) 0%, transparent 50%);
}

.hero-particles {
    position: absolute;
    inset: 0;
}

.particle {
    position: absolute;
    width: 2px;
    height: 2px;
    background: #C5A572;
    border-radius: 50%;
    opacity: 0.2;
    animation: particle-float linear infinite;
}

@keyframes particle-float {
    0% {
        transform: translateY(100vh) translateX(0);
    }
    100% {
        transform: translateY(-100vh) translateX(100px);
    }
}
</style>
<?php endif; ?>