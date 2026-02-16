<?php
// =====================================================
// LOADER & CURSOR COMPONENT
// Include this file in any page to add loader and cursor
// =====================================================
?>

<!-- Loader -->
<div class="page-loader" id="loader">
    <div class="loader-logo">
        <i class="fas fa-globe-africa"></i>
    </div>
</div>

<!-- Cursor Effects -->
<div class="cursor-dot" id="cursorDot"></div>
<div class="cursor-outline" id="cursorOutline"></div>

<style>
    /* ===== LOADER ANIMATION ===== */
    .page-loader {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: var(--white, #ffffff);
        z-index: 9999;
        display: flex;
        align-items: center;
        justify-content: center;
        pointer-events: none;
        transition: opacity 0.5s ease;
    }

    .loader-logo {
        width: 80px;
        height: 80px;
        background: linear-gradient(135deg, var(--accent-500, #ff6b2b), var(--accent-300, #ff9f60));
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
        background: var(--accent-500, #ff6b2b);
        border-radius: 50%;
        position: fixed;
        pointer-events: none;
        z-index: 99999;
        transform: translate(-50%, -50%);
        transition: width 0.2s, height 0.2s, background 0.2s, opacity 0.2s;
    }

    .cursor-outline {
        width: 40px;
        height: 40px;
        border: 2px solid var(--accent-500, #ff6b2b);
        border-radius: 50%;
        position: fixed;
        pointer-events: none;
        z-index: 99998;
        transform: translate(-50%, -50%);
        transition: all 0.1s, opacity 0.2s;
    }

    /* Hide cursor on touch devices */
    @media (hover: none) and (pointer: coarse) {
        .cursor-dot, .cursor-outline {
            display: none;
        }
    }
</style>

<script>
(function() {
    'use strict';

    // ===== LOADER HIDE ON PAGE LOAD =====
    function initLoader() {
        const loader = document.getElementById('loader');
        if (!loader) return;

        // Show loader initially
        loader.style.display = 'flex';
        loader.style.opacity = '1';

        // Hide loader after page is fully loaded
        window.addEventListener('load', function() {
            setTimeout(function() {
                loader.style.opacity = '0';
                setTimeout(function() {
                    loader.style.display = 'none';
                }, 500);
            }, 1000); // Shows loader for 1 second
        });

        // Fallback: hide loader after 3 seconds max
        setTimeout(function() {
            if (loader.style.display !== 'none') {
                loader.style.opacity = '0';
                setTimeout(function() {
                    loader.style.display = 'none';
                }, 500);
            }
        }, 3000);
    }

    // ===== CURSOR EFFECTS =====
    function initCursor() {
        const cursorDot = document.getElementById('cursorDot');
        const cursorOutline = document.getElementById('cursorOutline');

        if (!cursorDot || !cursorOutline) return;

        // Don't show cursor on mobile
        if (window.matchMedia('(hover: none) and (pointer: coarse)').matches) {
            return;
        }

        document.addEventListener('mousemove', function(e) {
            // Move cursor dot immediately
            cursorDot.style.left = e.clientX + 'px';
            cursorDot.style.top = e.clientY + 'px';
            
            // Move cursor outline with slight delay for smooth effect
            requestAnimationFrame(function() {
                cursorOutline.style.left = e.clientX + 'px';
                cursorOutline.style.top = e.clientY + 'px';
            });
        });

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
        const hoverElements = 'a, button, .category-card, .service-card, .process-item, .btn, [role="button"], input, select, textarea';
        
        document.addEventListener('mouseover', function(e) {
            if (e.target.matches(hoverElements)) {
                cursorDot.style.transform = 'translate(-50%, -50%) scale(1.5)';
                cursorOutline.style.transform = 'translate(-50%, -50%) scale(1.5)';
                cursorOutline.style.borderColor = 'var(--accent-400, #ff8540)';
                cursorOutline.style.backgroundColor = 'rgba(255, 107, 43, 0.05)';
            }
        });

        document.addEventListener('mouseout', function(e) {
            if (e.target.matches(hoverElements)) {
                cursorDot.style.transform = 'translate(-50%, -50%) scale(1)';
                cursorOutline.style.transform = 'translate(-50%, -50%) scale(1)';
                cursorOutline.style.borderColor = 'var(--accent-500, #ff6b2b)';
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
    }

    // ===== HERO PARTICLES (if needed) =====
    function initParticles() {
        // This function is optional - only needed if you use particles in hero
        const particles = document.querySelectorAll('.particle');
        if (particles.length === 0) return;

        // Particles are already animated with CSS
        // This just ensures they're visible
        console.log('Particles initialized: ' + particles.length);
    }

    // Initialize everything when DOM is ready
    document.addEventListener('DOMContentLoaded', function() {
        initLoader();
        initCursor();
        initParticles();
    });

})();
</script>

<!-- Optional: Hero Particles HTML Structure (include in your hero section) -->

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
    background: radial-gradient(circle at 30% 50%, var(--accent-soft, rgba(255,107,43,0.03)) 0%, transparent 50%),
                radial-gradient(circle at 70% 80%, var(--accent-soft, rgba(255,107,43,0.03)) 0%, transparent 50%);
}

.hero-particles {
    position: absolute;
    inset: 0;
}

.particle {
    position: absolute;
    width: 2px;
    height: 2px;
    background: var(--accent-500, #ff6b2b);
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
</style>
