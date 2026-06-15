<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>E-Kanisius - Login</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }

        body {
            font-family: 'Poppins', sans-serif;
            display: flex;
            height: 100vh;
            overflow: hidden;
        }

        /* ===== LEFT SECTION ===== */
        .left-section {
            width: 42%;
            position: relative;
            background-color: #1a2a4a;
            overflow: hidden;
            flex-shrink: 0;
        }

        .geo-canvas {
            position: absolute;
            inset: 0;
            width: 100%;
            height: 100%;
        }

        /* Animated tiles */
        .geo-canvas rect,
        .geo-canvas circle,
        .geo-canvas path {
            transition: opacity 0.6s ease;
        }

        /* Floating overlay particles */
        .particles-overlay {
            position: absolute;
            inset: 0;
            pointer-events: none;
            overflow: hidden;
        }

        .particle {
            position: absolute;
            border-radius: 50%;
            background: rgba(200, 180, 0, 0.25);
            animation: floatUp linear infinite;
        }

        @keyframes floatUp {
            0%   { transform: translateY(100vh) scale(0); opacity: 0; }
            10%  { opacity: 1; }
            90%  { opacity: 0.6; }
            100% { transform: translateY(-120px) scale(1.2); opacity: 0; }
        }

        /* Shimmer scan line on left panel */
        .shimmer-line {
            position: absolute;
            left: 0; right: 0;
            height: 3px;
            background: linear-gradient(90deg, transparent, rgba(200,180,0,0.6), transparent);
            animation: scanDown 4s ease-in-out infinite;
            pointer-events: none;
        }

        @keyframes scanDown {
            0%   { top: -4px; opacity: 0; }
            5%   { opacity: 1; }
            95%  { opacity: 1; }
            100% { top: 100%; opacity: 0; }
        }

        /* ===== RIGHT SECTION ===== */
        .right-section {
            flex: 1;
            background-color: #ffffff;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 40px 50px;
            overflow-y: auto;
        }

        .login-container {
            width: 100%;
            max-width: 480px;
            /* Initial state for page-in animation */
            opacity: 0;
            transform: translateY(28px);
        }

        .login-container.visible {
            animation: slideInUp 0.7s cubic-bezier(0.22, 1, 0.36, 1) forwards;
        }

        @keyframes slideInUp {
            to { opacity: 1; transform: translateY(0); }
        }

        /* Stagger children */
        .anim-child {
            opacity: 0;
            transform: translateY(20px);
        }

        /* ===== HEADER ===== */
        .header {
            display: flex;
            align-items: center;
            gap: 24px;
            margin-bottom: 48px;
            flex-wrap: wrap;
        }

        .brand-ekanisius {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .brand-ekanisius img {
            width: 45px;
            height: auto;
            transition: transform 0.3s ease;
        }

        .brand-ekanisius img:hover { transform: rotate(-6deg) scale(1.1); }

        .brand-ekanisius .brand-name {
            color: #1a2a6c;
            font-size: 22px;
            font-weight: 800;
            letter-spacing: -0.5px;
        }

        .header-divider {
            width: 1px;
            height: 48px;
            background-color: #ddd;
        }

        .brand-sakti { display: flex; align-items: center; gap: 10px; }
        .brand-sakti img { width: 150px; height: auto; transition: transform 0.3s ease; }
        .brand-sakti img:hover { transform: rotate(6deg) scale(1.1); }

        .sakti-text { display: flex; flex-direction: column; line-height: 1.1; }
        .sakti-title { color: #1a2a6c; font-size: 20px; font-weight: 800; letter-spacing: 1px; }
        .sakti-subtitle { color: #1a2a6c; font-size: 8px; font-weight: 500; letter-spacing: 0.2px; }

        /* ===== FORM ===== */
        .form-title {
            color: #111;
            font-size: 20px;
            font-weight: 500;
            margin-bottom: 32px;
        }

        .form-group { margin-bottom: 22px; position: relative; }

        .form-label {
            color: #111;
            font-size: 15px;
            font-weight: 500;
            display: block;
            margin-bottom: 8px;
            transition: color 0.2s;
        }

        .form-group:focus-within .form-label { color: #004AAD; }

        .form-input {
            width: 100%;
            height: 52px;
            background-color: #e8e8e8;
            border: 2px solid transparent;
            border-radius: 8px;
            padding: 12px 48px 12px 18px;
            font-size: 14px;
            font-family: 'Poppins', sans-serif;
            color: #333;
            transition: background 0.25s ease, border-color 0.25s ease, box-shadow 0.25s ease, transform 0.15s ease;
        }

        .form-input:focus {
            outline: none;
            background-color: #dde4f0;
            border-color: #004AAD;
            box-shadow: 0 0 0 4px rgba(0, 74, 173, 0.12);
            transform: translateY(-1px);
        }

        .form-input.is-invalid {
            border-color: #dc2626;
            box-shadow: 0 0 0 3px rgba(220, 38, 38, 0.15);
            animation: shake 0.4s ease;
        }

        @keyframes shake {
            0%, 100% { transform: translateX(0); }
            20%       { transform: translateX(-6px); }
            40%       { transform: translateX(6px); }
            60%       { transform: translateX(-4px); }
            80%       { transform: translateX(4px); }
        }

        .error-msg {
            color: #dc2626;
            font-size: 12px;
            margin-top: 5px;
            display: block;
            animation: fadeIn 0.3s ease;
        }

        /* Password toggle eye */
        .input-wrapper { position: relative; }

        .toggle-password {
            position: absolute;
            right: 14px;
            top: 50%;
            transform: translateY(-50%);
            cursor: pointer;
            color: #888;
            font-size: 18px;
            line-height: 1;
            transition: color 0.2s, transform 0.2s;
            user-select: none;
            background: none;
            border: none;
            padding: 4px;
        }

        .toggle-password:hover { color: #004AAD; transform: translateY(-50%) scale(1.15); }

        /* ===== Remember row ===== */
        .remember-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 28px;
        }

        .checkbox-container { display: flex; align-items: center; gap: 10px; }

        .checkbox-input {
            width: 20px;
            height: 20px;
            accent-color: #004AAD;
            cursor: pointer;
            transition: transform 0.2s;
        }

        .checkbox-input:checked { transform: scale(1.1); }

        .checkbox-label { color: #333; font-size: 14px; font-weight: 500; cursor: pointer; }

        .forgot-password a {
            color: #333;
            font-size: 14px;
            font-weight: 500;
            text-decoration: none;
            position: relative;
            transition: color 0.2s;
        }

        .forgot-password a::after {
            content: '';
            position: absolute;
            left: 0; right: 0; bottom: -2px;
            height: 1px;
            background: #004AAD;
            transform: scaleX(0);
            transform-origin: left;
            transition: transform 0.25s ease;
        }

        .forgot-password a:hover { color: #004AAD; }
        .forgot-password a:hover::after { transform: scaleX(1); }

        /* ===== Login Button ===== */
        .login-button {
            width: 100%;
            height: 56px;
            background-color: #004AAD;
            border: none;
            border-radius: 8px;
            color: white;
            font-size: 18px;
            font-weight: 600;
            font-family: 'Poppins', sans-serif;
            cursor: pointer;
            transition: background-color 0.25s, transform 0.15s, box-shadow 0.25s;
            margin-bottom: 24px;
            letter-spacing: 0.3px;
            position: relative;
            overflow: hidden;
        }

        /* Ripple on button */
        .login-button .ripple {
            position: absolute;
            border-radius: 50%;
            background: rgba(255,255,255,0.35);
            transform: scale(0);
            animation: rippleAnim 0.55s linear;
            pointer-events: none;
        }

        @keyframes rippleAnim {
            to { transform: scale(4); opacity: 0; }
        }

        .login-button:hover {
            background-color: #003a8c;
            box-shadow: 0 6px 24px rgba(0, 74, 173, 0.35);
            transform: translateY(-2px);
        }

        .login-button:active { transform: scale(0.98) translateY(0); }

        /* Loading spinner inside button */
        .login-button.loading .btn-text { opacity: 0; }
        .login-button.loading::after {
            content: '';
            position: absolute;
            inset: 0;
            margin: auto;
            width: 22px; height: 22px;
            border: 3px solid rgba(255,255,255,0.35);
            border-top-color: #fff;
            border-radius: 50%;
            animation: spin 0.7s linear infinite;
        }

        @keyframes spin { to { transform: rotate(360deg); } }

        .btn-text { transition: opacity 0.2s; }

        /* ===== Register ===== */
        .register-section { text-align: center; font-size: 14px; }
        .register-section span { color: #444; }

        .register-section a {
            color: #111;
            font-weight: 700;
            text-decoration: none;
            position: relative;
            transition: color 0.2s;
        }

        .register-section a::after {
            content: '';
            position: absolute;
            left: 0; right: 0; bottom: -2px;
            height: 2px;
            background: #004AAD;
            transform: scaleX(0);
            transform-origin: left;
            transition: transform 0.25s ease;
        }

        .register-section a:hover { color: #004AAD; }
        .register-section a:hover::after { transform: scaleX(1); }

        /* ===== Toast notification ===== */
        #toast {
            position: fixed;
            bottom: 28px;
            left: 50%;
            transform: translateX(-50%) translateY(80px);
            background: #1a2a6c;
            color: white;
            padding: 12px 28px;
            border-radius: 40px;
            font-size: 14px;
            font-weight: 500;
            opacity: 0;
            pointer-events: none;
            transition: transform 0.4s cubic-bezier(0.22,1,0.36,1), opacity 0.4s;
            z-index: 9999;
            white-space: nowrap;
            box-shadow: 0 8px 32px rgba(0,0,0,0.2);
        }

        #toast.show {
            opacity: 1;
            transform: translateX(-50%) translateY(0);
        }

        @keyframes fadeIn { from { opacity: 0; transform: translateY(-4px); } to { opacity: 1; transform: translateY(0); } }

        /* ===== Responsive ===== */
        @media (max-width: 768px) {
            body { flex-direction: column; height: auto; overflow: auto; }
            .left-section { width: 100%; height: 180px; }
            .right-section { padding: 32px 24px; }
        }
    </style>
</head>
<body>

    <!-- ===== LEFT: Geometric Pattern ===== -->
    <div class="left-section">
        <svg class="geo-canvas" id="geoSvg" viewBox="0 0 420 700" preserveAspectRatio="xMidYMid slice" xmlns="http://www.w3.org/2000/svg">
            <rect width="420" height="700" fill="#1c2d4f"/>
            <!-- Row 1 -->
            <rect x="0" y="0" width="105" height="105" fill="#c8b400" class="tile"/>
            <circle cx="52" cy="52" r="36" fill="#1c2d4f" class="tile"/>
            <rect x="105" y="0" width="105" height="105" fill="#1c2d4f" class="tile"/>
            <circle cx="157" cy="52" r="36" fill="#c8b400" fill-opacity="0.15" class="tile"/>
            <circle cx="157" cy="52" r="18" fill="#c8b400" fill-opacity="0.3" class="tile"/>
            <rect x="210" y="0" width="105" height="105" fill="#2e4a78" class="tile"/>
            <path d="M210,0 Q262,52 315,0 Q262,52 315,105 Q262,52 210,105 Q262,52 210,0" fill="#1c2d4f" fill-opacity="0.6" class="tile"/>
            <rect x="315" y="0" width="105" height="105" fill="#1c2d4f" class="tile"/>
            <circle cx="367" cy="52" r="36" fill="#2e4a78" class="tile"/>
            <circle cx="367" cy="52" r="18" fill="#1c2d4f" class="tile"/>
            <!-- Row 2 -->
            <rect x="0" y="105" width="105" height="105" fill="#2e4a78" class="tile"/>
            <path d="M0,105 L105,105 L105,210 Z" fill="#1c2d4f" fill-opacity="0.5" class="tile"/>
            <rect x="105" y="105" width="105" height="105" fill="#c8b400" fill-opacity="0.15" class="tile"/>
            <circle cx="157" cy="157" r="42" fill="#c8b400" fill-opacity="0.25" class="tile"/>
            <rect x="210" y="105" width="105" height="105" fill="#1c2d4f" class="tile"/>
            <path d="M210,157 Q262,105 315,157" stroke="#c8b400" stroke-width="3" fill="none" opacity="0.4" class="tile"/>
            <path d="M210,157 Q262,210 315,157" stroke="#c8b400" stroke-width="3" fill="none" opacity="0.4" class="tile"/>
            <rect x="315" y="105" width="105" height="105" fill="#c8b400" class="tile"/>
            <circle cx="367" cy="157" r="36" fill="#1c2d4f" class="tile"/>
            <circle cx="367" cy="157" r="18" fill="#c8b400" fill-opacity="0.3" class="tile"/>
            <!-- Row 3 -->
            <rect x="0" y="210" width="105" height="105" fill="#1c2d4f" class="tile"/>
            <circle cx="52" cy="262" r="36" fill="#2e4a78" class="tile"/>
            <rect x="105" y="210" width="105" height="105" fill="#c8b400" fill-opacity="0.8" class="tile"/>
            <path d="M105,210 L210,210 L210,315 Z" fill="#1c2d4f" fill-opacity="0.4" class="tile"/>
            <rect x="210" y="210" width="105" height="105" fill="#2e4a78" class="tile"/>
            <circle cx="262" cy="262" r="40" fill="#1c2d4f" class="tile"/>
            <circle cx="262" cy="262" r="20" fill="#2e4a78" class="tile"/>
            <rect x="315" y="210" width="105" height="105" fill="#1c2d4f" class="tile"/>
            <path d="M315,210 Q367,262 420,210 Q367,262 420,315 Q367,262 315,315 Q367,262 315,210" fill="#2e4a78" fill-opacity="0.5" class="tile"/>
            <!-- Row 4 -->
            <rect x="0" y="315" width="210" height="210" fill="#1c2d4f" class="tile"/>
            <circle cx="105" cy="420" r="95" fill="#2e4a78" class="tile"/>
            <circle cx="105" cy="420" r="55" fill="#1c2d4f" class="tile"/>
            <circle cx="105" cy="420" r="25" fill="#c8b400" fill-opacity="0.4" class="tile"/>
            <rect x="210" y="315" width="105" height="105" fill="#c8b400" class="tile"/>
            <circle cx="262" cy="367" r="36" fill="#1c2d4f" class="tile"/>
            <rect x="315" y="315" width="105" height="105" fill="#2e4a78" class="tile"/>
            <path d="M315,315 L420,315 L420,420 Z" fill="#c8b400" fill-opacity="0.3" class="tile"/>
            <rect x="210" y="420" width="105" height="105" fill="#1c2d4f" class="tile"/>
            <circle cx="262" cy="472" r="36" fill="#c8b400" fill-opacity="0.2" class="tile"/>
            <circle cx="262" cy="472" r="18" fill="#c8b400" fill-opacity="0.5" class="tile"/>
            <rect x="315" y="420" width="105" height="105" fill="#c8b400" fill-opacity="0.15" class="tile"/>
            <path d="M315,472 Q367,420 420,472 Q367,525 315,472" fill="#2e4a78" fill-opacity="0.7" class="tile"/>
            <!-- Row 5 -->
            <rect x="0" y="525" width="105" height="105" fill="#2e4a78" class="tile"/>
            <circle cx="52" cy="577" r="36" fill="#c8b400" fill-opacity="0.2" class="tile"/>
            <circle cx="52" cy="577" r="16" fill="#c8b400" fill-opacity="0.5" class="tile"/>
            <rect x="105" y="525" width="105" height="105" fill="#c8b400" class="tile"/>
            <path d="M105,525 L210,525 L210,630 Z" fill="#1c2d4f" fill-opacity="0.5" class="tile"/>
            <rect x="210" y="525" width="105" height="105" fill="#1c2d4f" class="tile"/>
            <circle cx="262" cy="577" r="36" fill="#2e4a78" class="tile"/>
            <rect x="315" y="525" width="105" height="105" fill="#2e4a78" class="tile"/>
            <circle cx="367" cy="577" r="36" fill="#1c2d4f" class="tile"/>
            <circle cx="367" cy="577" r="18" fill="#c8b400" fill-opacity="0.4" class="tile"/>
            <!-- Row 6 -->
            <rect x="0" y="630" width="105" height="70" fill="#c8b400" fill-opacity="0.5" class="tile"/>
            <rect x="105" y="630" width="105" height="70" fill="#1c2d4f" class="tile"/>
            <circle cx="157" cy="665" r="25" fill="#2e4a78" class="tile"/>
            <rect x="210" y="630" width="105" height="70" fill="#2e4a78" class="tile"/>
            <rect x="315" y="630" width="105" height="70" fill="#c8b400" fill-opacity="0.2" class="tile"/>
        </svg>

        <!-- Floating particles -->
        <div class="particles-overlay" id="particles"></div>

        <!-- Scan line -->
        <div class="shimmer-line"></div>
    </div>

    <!-- ===== RIGHT: Login Form ===== -->
    <div class="right-section">
        <div class="login-container" id="loginContainer">

            <div class="header anim-child">
                <div class="brand-ekanisius">
                    <img src="{{ asset('img/image 1 (1).png') }}" alt="E-Kanisius Logo">
                    <span class="brand-name">E-Kanisius</span>
                </div>
                <div class="header-divider"></div>
                <div class="brand-sakti">
                    <img src="{{ asset('img/E-Kanisius 1.png') }}" alt="SAKTI Logo">
                    <div class="sakti-text">
                        <!-- <span class="sakti-title">SAKTI</span>
                        <span class="sakti-subtitle">Sistem Admisi<br>Kanisius Terintegrasi</span> -->
                    </div>
                </div>
            </div>

            <form method="POST" action="{{ route('login') }}" id="loginForm">
                @csrf

                <h2 class="form-title anim-child">Masuk ke Akun Anda</h2>

                <!-- Email -->
                <div class="form-group anim-child">
                    <label for="email" class="form-label">Email</label>
                    <div class="input-wrapper">
                        <input
                            type="email"
                            id="email"
                            name="email"
                            class="form-input @error('email') is-invalid @enderror"
                            placeholder="Enter your email"
                            value="{{ old('email') }}"
                            required autofocus
                        >
                    </div>
                    @error('email')
                        <span class="error-msg">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Password -->
                <div class="form-group anim-child">
                    <label for="password" class="form-label">Kata Sandi</label>
                    <div class="input-wrapper">
                        <input
                            type="password"
                            id="password"
                            name="password"
                            class="form-input @error('password') is-invalid @enderror"
                            placeholder="Enter your password"
                            required
                        >
                        <button type="button" class="toggle-password" id="togglePwd" title="Show/hide password">
                            👁
                        </button>
                    </div>
                    @error('password')
                        <span class="error-msg">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Remember & Forgot -->
                <div class="remember-row anim-child">
                    <div class="checkbox-container">
                        <input type="checkbox" id="remember" name="remember" class="checkbox-input"
                            {{ old('remember') ? 'checked' : '' }}>
                        <label for="remember" class="checkbox-label">Ingat Saya</label>
                    </div>
                    <div class="forgot-password">
                        <a href="{{ route('password.request') }}">Lupa Kata Sandi?</a>
                    </div>
                </div>

                <!-- Login Button -->
                <button type="submit" class="login-button anim-child" id="loginBtn">
                    <span class="btn-text">Masuk</span>
                </button>

                <!-- Register -->
                <div class="register-section anim-child">
                    <span>Tidak Memiliki Akun? </span>
                    <a href="{{ route('register') }}">Daftar Disini</a>
                </div>
            </form>
        </div>
    </div>

    <!-- Toast -->
    <div id="toast"></div>

    <script>
        /* ============================================================
           1. PAGE-IN: staggered slide-up for each child element
        ============================================================ */
        const container = document.getElementById('loginContainer');
        const children  = document.querySelectorAll('.anim-child');

        // Trigger container animation
        requestAnimationFrame(() => {
            container.classList.add('visible');
        });

        // Stagger children
        children.forEach((el, i) => {
            el.style.animation = `slideInUp 0.55s cubic-bezier(0.22,1,0.36,1) ${0.15 + i * 0.08}s forwards`;
        });

        /* ============================================================
           2. FLOATING PARTICLES on left panel
        ============================================================ */
        const particleContainer = document.getElementById('particles');

        function createParticle() {
            const p = document.createElement('div');
            p.className = 'particle';

            const size  = Math.random() * 14 + 6;
            const left  = Math.random() * 100;
            const delay = Math.random() * 5;
            const dur   = Math.random() * 8 + 7;

            p.style.cssText = `
                width:${size}px; height:${size}px;
                left:${left}%; bottom:-20px;
                animation-duration:${dur}s;
                animation-delay:${delay}s;
                opacity:0;
            `;
            particleContainer.appendChild(p);

            // Remove after a few cycles to keep DOM clean
            setTimeout(() => p.remove(), (dur + delay + 2) * 1000);
        }

        // Create initial batch
        for (let i = 0; i < 14; i++) createParticle();
        // Keep spawning
        setInterval(createParticle, 1200);

        /* ============================================================
           3. SVG TILE PULSE — random tiles glow periodically
        ============================================================ */
        const tiles = document.querySelectorAll('.tile');

        function pulseTile() {
            const tile = tiles[Math.floor(Math.random() * tiles.length)];
            const orig = tile.getAttribute('fill-opacity') || '1';

            tile.style.transition = 'opacity 0.4s ease';
            tile.style.opacity    = '0.4';

            setTimeout(() => {
                tile.style.opacity = '1';
            }, 400);
        }

        setInterval(pulseTile, 600);

        /* ============================================================
           4. PASSWORD TOGGLE
        ============================================================ */
        const toggleBtn = document.getElementById('togglePwd');
        const pwdInput  = document.getElementById('password');

        toggleBtn.addEventListener('click', () => {
            const isPass = pwdInput.type === 'password';
            pwdInput.type      = isPass ? 'text' : 'password';
            toggleBtn.textContent = isPass ? '🙈' : '👁';
            toggleBtn.style.transform = 'translateY(-50%) scale(1.3)';
            setTimeout(() => toggleBtn.style.transform = 'translateY(-50%) scale(1)', 200);
        });

        /* ============================================================
           5. RIPPLE EFFECT on Login button
        ============================================================ */
        const loginBtn = document.getElementById('loginBtn');

        loginBtn.addEventListener('click', function(e) {
            const rect   = this.getBoundingClientRect();
            const x      = e.clientX - rect.left;
            const y      = e.clientY - rect.top;
            const ripple = document.createElement('span');
            ripple.className = 'ripple';
            ripple.style.cssText = `left:${x}px; top:${y}px; width:${rect.width}px; height:${rect.width}px; margin-left:-${rect.width/2}px; margin-top:-${rect.width/2}px;`;
            this.appendChild(ripple);
            setTimeout(() => ripple.remove(), 600);
        });

        /* ============================================================
           6. LOADING STATE on form submit
        ============================================================ */
        document.getElementById('loginForm').addEventListener('submit', function() {
            loginBtn.classList.add('loading');
            loginBtn.disabled = true;

            // Safety: re-enable after 6s (in case of server error / no redirect)
            setTimeout(() => {
                loginBtn.classList.remove('loading');
                loginBtn.disabled = false;
            }, 6000);
        });

        /* ============================================================
           7. INPUT SHAKE on empty submit attempt
        ============================================================ */
        document.getElementById('loginForm').addEventListener('submit', function(e) {
            const email = document.getElementById('email');
            const pass  = document.getElementById('password');
            let invalid = false;

            [email, pass].forEach(input => {
                if (!input.value.trim()) {
                    input.classList.add('is-invalid');
                    input.style.animation = 'none';
                    requestAnimationFrame(() => {
                        input.style.animation = '';
                        input.classList.add('is-invalid');
                    });
                    invalid = true;
                } else {
                    input.classList.remove('is-invalid');
                }
            });
        });

        /* ============================================================
           8. TOAST helper — called from Blade if needed
        ============================================================ */
        function showToast(msg, duration = 3000) {
            const toast = document.getElementById('toast');
            toast.textContent = msg;
            toast.classList.add('show');
            setTimeout(() => toast.classList.remove('show'), duration);
        }

        // Show toast for Laravel validation errors (optional)
        @if ($errors->any())
            showToast('⚠️ Periksa kembali email atau password kamu.');
        @endif
document.addEventListener("DOMContentLoaded", function () {
    // Cek apakah ada session flash 'success_logout' dari Laravel
    @if(session('success_logout'))
        // Panggil fungsi toast bawaan template kamu di sini
        toast('info', '<i class="fas fa-info-circle"></i> {{ session("success_logout") }}');
        
        // Atau kalau pakai alert bawaan browser buat testing:
        // alert('{{ session("success_logout") }}');
    @endif
});
        /* ============================================================
           9. INPUT FOCUS: remove invalid class when user starts typing
        ============================================================ */
        document.querySelectorAll('.form-input').forEach(input => {
            input.addEventListener('input', () => input.classList.remove('is-invalid'));
        });

        /* ============================================================
           10. CURSOR TRAIL on left panel (subtle sparkle)
        ============================================================ */
        const leftPanel = document.querySelector('.left-section');

        leftPanel.addEventListener('mousemove', (e) => {
            const dot = document.createElement('div');
            dot.style.cssText = `
                position:absolute;
                left:${e.offsetX}px; top:${e.offsetY}px;
                width:6px; height:6px;
                border-radius:50%;
                background:rgba(200,180,0,0.7);
                pointer-events:none;
                transform:translate(-50%,-50%) scale(1);
                transition: transform 0.4s ease, opacity 0.4s ease;
            `;
            leftPanel.appendChild(dot);

            requestAnimationFrame(() => {
                dot.style.transform = 'translate(-50%,-50%) scale(3)';
                dot.style.opacity   = '0';
            });

            setTimeout(() => dot.remove(), 450);
        });
    </script>

</body>
</html>