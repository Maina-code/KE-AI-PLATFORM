<style>
    
        :root {
            --primary: #0A1929;
            --secondary: #1E2F4A;
            --accent: #00B8A9;
            --accent-glow: #00D4C0;
            --gold: #FFB347;
            --danger: #FF6B6B;
            --success: #4CAF50;
            --text-primary: #F0F4FA;
            --text-secondary: #B0C4DE;
            --bg-dark: #0A0F1C;
            --card-bg: rgba(18, 28, 45, 0.8);
            --glass-border: rgba(255, 255, 255, 0.05);
        }
        .navbar {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            z-index: 1000;
            background: rgba(10, 25, 41, 0.85);
            backdrop-filter: blur(10px);
            border-bottom: 1px solid var(--glass-border);
            transition: all 0.3s ease;
        }

        .navbar.scrolled {
            background: rgba(10, 15, 28, 0.95);
            box-shadow: 0 4px 20px rgba(0,0,0,0.3);
        }

        .container {
            max-width: 1400px;
            margin: 0 auto;
            padding: 0 40px;
        }

        .nav-content {
            display: flex;
            justify-content: space-between;
            align-items: center;
            height: 80px;
        }

        .nav-logo {
            font-family: 'Poppins', sans-serif;
            font-size: 1.8rem;
            font-weight: 800;
            background: linear-gradient(135deg, #fff, var(--accent));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            text-decoration: none;
        }

        .nav-links {
            display: flex;
            gap: 40px;
            list-style: none;
        }

        .nav-link {
            color: var(--text-primary);
            text-decoration: none;
            font-weight: 500;
            transition: color 0.3s ease;
            position: relative;
        }

        .nav-link:hover {
            color: var(--accent);
        }

        .nav-link::after {
            content: '';
            position: absolute;
            bottom: -5px;
            left: 0;
            width: 0;
            height: 2px;
            background: var(--accent);
            transition: width 0.3s ease;
        }

        .nav-link:hover::after {
            width: 100%;
        }

        .btn {
            padding: 10px 24px;
            border-radius: 8px;
            text-decoration: none;
            font-weight: 600;
            transition: all 0.3s ease;
            display: inline-block;
        }

        .btn-text {
            color: var(--text-primary);
        }

        .btn-primary {
            background: linear-gradient(135deg, var(--accent), #008B7A);
            color: white;
            box-shadow: 0 4px 15px rgba(0, 184, 169, 0.3);
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(0, 184, 169, 0.5);
        }

        .btn-secondary {
            background: transparent;
            color: var(--accent);
            border: 2px solid var(--accent);
        }

        .btn-secondary:hover {
            background: var(--accent);
            color: white;
            transform: translateY(-2px);
        }

        .btn-gold {
            background: linear-gradient(135deg, var(--gold), #FF9500);
            color: white;
            box-shadow: 0 4px 15px rgba(255, 179, 71, 0.3);
        }
    </style>
        <!-- Navigation -->
    <nav class="navbar" id="navbar">
        <div class="container nav-content">
            <a href="#" class="nav-logo">NuruAI</a>
            <ul class="nav-links">
                <li><a href="#hero" class="nav-link">Home</a></li>
                <li><a href="#problem" class="nav-link">Simulation</a></li>
                <li><a href="#oversight" class="nav-link">Oversight</a></li>
                <li><a href="#impact" class="nav-link">Impact</a></li>
                <li><a href="#" class="nav-link">About</a></li>
            </ul>
            <div style="display:flex; gap:15px; align-items:center;">
                <a href="#" class="btn btn-text">Login</a>
                <a href="#" class="btn btn-primary">Launch</a>
            </div>
        </div>
    </nav>