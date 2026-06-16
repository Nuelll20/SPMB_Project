<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>E-Kanisius - Register</title>
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
            padding: 32px 50px;
            overflow-y: auto;
        }

        .register-container {
            width: 100%;
            max-width: 480px;
            opacity: 0;
            transform: translateY(28px);
        }

        .register-container.visible {
            animation: slideInUp 0.7s cubic-bezier(0.22, 1, 0.36, 1) forwards;
        }

        @keyframes slideInUp {
            to { opacity: 1; transform: translateY(0); }
        }

        .anim-child {
            opacity: 0;
            transform: translateY(20px);
        }

        /* ===== HEADER ===== */
        .header {
            display: flex;
            align-items: center;
            gap: 24px;
            margin-bottom: 36px;
            flex-wrap: wrap;
        }

        .brand-ekanisius { display: flex; align-items: center; gap: 10px; }
        .brand-ekanisius img { width: 48px; height: auto; transition: transform 0.3s ease; }
        .brand-ekanisius img:hover { transform: rotate(-6deg) scale(1.1); }
        .brand-ekanisius .brand-name { color: #1a2a6c; font-size: 22px; font-weight: 800; letter-spacing: -0.5px; }

        .header-divider { width: 1px; height: 48px; background-color: #ddd; }

        .brand-sakti { display: flex; align-items: center; gap: 10px; }
        .brand-sakti img { width: 150px; height: auto; transition: transform 0.3s ease; }
        .brand-sakti img:hover { transform: rotate(6deg) scale(1.1); }
        .sakti-text { display: flex; flex-direction: column; line-height: 1.1; }
        .sakti-title { color: #1a2a6c; font-size: 20px; font-weight: 800; letter-spacing: 1px; }
        .sakti-subtitle { color: #1a2a6c; font-size: 8px; font-weight: 500; }

        /* ===== FORM ===== */
        .form-title {
            color: #111;
            font-size: 20px;
            font-weight: 500;
            margin-bottom: 28px;
        }

        .form-group { margin-bottom: 18px; position: relative; }

        .form-label {
            color: #111;
            font-size: 15px;
            font-weight: 500;
            display: block;
            margin-bottom: 7px;
            transition: color 0.2s;
        }

        .form-group:focus-within .form-label { color: #004AAD; }

        .input-wrapper { position: relative; }

        .form-input {
            width: 100%;
            height: 50px;
            background-color: #e8e8e8;
            border: 2px solid transparent;
            border-radius: 8px;
            padding: 12px 46px 12px 18px;
            font-size: 14px;
            font-family: 'Poppins', sans-serif;
            color: #333;
            transition: background 0.25s, border-color 0.25s, box-shadow 0.25s, transform 0.15s;
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

        .form-input.is-valid {
            border-color: #16a34a;
            box-shadow: 0 0 0 3px rgba(22, 163, 74, 0.12);
        }

        @keyframes shake {
            0%, 100% { transform: translateX(0); }
            20%       { transform: translateX(-6px); }
            40%       { transform: translateX(6px); }
            60%       { transform: translateX(-4px); }
            80%       { transform: translateX(4px); }
        }

        /* Icon inside input */
        .input-icon {
            position: absolute;
            right: 14px;
            top: 50%;
            transform: translateY(-50%);
            font-size: 16px;
            pointer-events: none;
            opacity: 0;
            transition: opacity 0.25s;
        }

        .form-input.is-valid   ~ .input-icon.valid-icon   { opacity: 1; }
        .form-input.is-invalid ~ .input-icon.invalid-icon { opacity: 1; }

        /* Toggle password */
        .toggle-password {
            position: absolute;
            right: 14px;
            top: 50%;
            transform: translateY(-50%);
            cursor: pointer;
            color: #888;
            font-size: 17px;
            background: none;
            border: none;
            padding: 4px;
            transition: color 0.2s, transform 0.2s;
            user-select: none;
            line-height: 1;
        }

        .toggle-password:hover { color: #004AAD; transform: translateY(-50%) scale(1.15); }

        .error-msg {
            color: #dc2626;
            font-size: 12px;
            margin-top: 5px;
            display: block;
            animation: fadeIn 0.3s ease;
        }

        .hint-msg {
            color: #888;
            font-size: 11px;
            margin-top: 4px;
            display: block;
        }

        /* Password strength bar */
        .strength-bar-wrap {
            margin-top: 8px;
            height: 4px;
            background: #e0e0e0;
            border-radius: 99px;
            overflow: hidden;
            display: none;
        }

        .strength-bar {
            height: 100%;
            border-radius: 99px;
            width: 0%;
            transition: width 0.4s ease, background-color 0.4s ease;
        }

        .strength-label {
            font-size: 11px;
            margin-top: 4px;
            font-weight: 500;
            display: none;
        }

        /* ===== Register Button ===== */
        .register-button {
            width: 100%;
            height: 54px;
            background-color: #004AAD;
            border: none;
            border-radius: 8px;
            color: white;
            font-size: 17px;
            font-weight: 600;
            font-family: 'Poppins', sans-serif;
            cursor: pointer;
            transition: background-color 0.25s, transform 0.15s, box-shadow 0.25s;
            margin-top: 8px;
            margin-bottom: 22px;
            letter-spacing: 0.3px;
            position: relative;
            overflow: hidden;
        }

        .register-button .ripple {
            position: absolute;
            border-radius: 50%;
            background: rgba(255,255,255,0.35);
            transform: scale(0);
            animation: rippleAnim 0.55s linear;
            pointer-events: none;
        }

        @keyframes rippleAnim { to { transform: scale(4); opacity: 0; } }

        .register-button:hover {
            background-color: #003a8c;
            box-shadow: 0 6px 24px rgba(0, 74, 173, 0.35);
            transform: translateY(-2px);
        }

        .register-button:active { transform: scale(0.98) translateY(0); }

        .register-button.loading .btn-text { opacity: 0; }
        .register-button.loading::after {
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

        /* ===== Login link ===== */
        .login-section { text-align: center; font-size: 14px; }
        .login-section span { color: #444; }

        .login-section a {
            color: #111;
            font-weight: 700;
            text-decoration: none;
            position: relative;
            transition: color 0.2s;
        }

        .login-section a::after {
            content: '';
            position: absolute;
            left: 0; right: 0; bottom: -2px;
            height: 2px;
            background: #004AAD;
            transform: scaleX(0);
            transform-origin: left;
            transition: transform 0.25s ease;
        }

        .login-section a:hover { color: #004AAD; }
        .login-section a:hover::after { transform: scaleX(1); }

        /* ===== Toast ===== */
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

        #toast.show { opacity: 1; transform: translateX(-50%) translateY(0); }

        @keyframes fadeIn { from { opacity: 0; transform: translateY(-4px); } to { opacity: 1; transform: translateY(0); } }

        /* ===== Responsive ===== */
        @media (max-width: 1024px) {
            .left-section { width: 38%; }
            .right-section { padding: 28px 36px; }
        }

        @media (max-width: 768px) {
            body { flex-direction: column; height: auto; min-height: 100vh; overflow: auto; }
            .left-section { width: 100%; height: 160px; }
            .right-section { padding: 28px 24px; align-items: flex-start; }
        }

        @media (max-width: 480px) {
            .header { gap: 14px; margin-bottom: 24px; }
            .brand-ekanisius .brand-name { font-size: 18px; }
            .sakti-title { font-size: 16px; }
            .form-title { font-size: 17px; }
            .form-input { height: 46px; font-size: 13px; }
            .register-button { height: 50px; font-size: 15px; }
        }

        @media (orientation: landscape) and (max-height: 500px) {
            body { height: auto; overflow: auto; }
            .left-section { width: 30%; height: 100vh; position: sticky; top: 0; }
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
        <div class="particles-overlay" id="particles"></div>
        <div class="shimmer-line"></div>
    </div>

    <!-- ===== RIGHT: Register Form ===== -->
    <div class="right-section">
        <div class="register-container" id="registerContainer">

            <!-- Header -->
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

            <!-- Form -->
            <form method="POST" action="{{ route('register') }}" id="registerForm" novalidate>
                @csrf

                <h2 class="form-title anim-child">Register to your account</h2>

                <!-- Full Name -->
                <div class="form-group anim-child">
                    <label for="name" class="form-label">Full Name</label>
                    <div class="input-wrapper">
                        <input
                            type="text"
                            id="name"
                            name="name"
                            class="form-input @error('name') is-invalid @enderror"
                            placeholder="Enter your full name"
                            value="{{ old('name') }}"
                            required autofocus autocomplete="name"
                        >
                        <span class="input-icon valid-icon">✅</span>
                        <span class="input-icon invalid-icon">❌</span>
                    </div>
                    @error('name')
                        <span class="error-msg">{{ $message }}</span>
                    @enderror
                </div>

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
                            required autocomplete="email"
                        >
                        <span class="input-icon valid-icon">✅</span>
                        <span class="input-icon invalid-icon">❌</span>
                    </div>
                    @error('email')
                        <span class="error-msg">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Password -->
                <div class="form-group anim-child">
                    <label for="password" class="form-label">Password</label>
                    <div class="input-wrapper">
                        <input
                            type="password"
                            id="password"
                            name="password"
                            class="form-input @error('password') is-invalid @enderror"
                            placeholder="Create a password"
                            required autocomplete="new-password"
                        >
                        <button type="button" class="toggle-password" id="togglePwd" title="Show/hide password">👁</button>
                    </div>
                    @error('password')
                        <span class="error-msg">{{ $message }}</span>
                    @enderror
                    <!-- Strength bar -->
                    <div class="strength-bar-wrap" id="strengthWrap">
                        <div class="strength-bar" id="strengthBar"></div>
                    </div>
                    <span class="strength-label" id="strengthLabel"></span>
                    <span class="hint-msg">Min. 8 karakter</span>
                </div>

                <!-- Confirm Password -->
                <div class="form-group anim-child">
                    <label for="password_confirmation" class="form-label">Confirm Password</label>
                    <div class="input-wrapper">
                        <input
                            type="password"
                            id="password_confirmation"
                            name="password_confirmation"
                            class="form-input"
                            placeholder="Repeat your password"
                            required autocomplete="new-password"
                        >
                        <button type="button" class="toggle-password" id="togglePwdConfirm" title="Show/hide password">👁</button>
                    </div>
                    <span class="error-msg" id="confirmError" style="display:none;">Password tidak cocok</span>
                </div>

                <!-- Register Button -->
                <button type="submit" class="register-button anim-child" id="registerBtn">
                    <span class="btn-text">Register</span>
                </button>

                <!-- Login Link -->
                <div class="login-section anim-child">
                    <span>have an account ? </span>
                    <a href="{{ route('login') }}">Login Here</a>
                </div>

            </form>
        </div>
    </div>

    <!-- Toast -->
    <div id="toast"></div>

    <script>
        /* ============================================================
           1. PAGE-IN: staggered slide-up
        ============================================================ */
        const container = document.getElementById('registerContainer');
        const children  = document.querySelectorAll('.anim-child');

        requestAnimationFrame(() => container.classList.add('visible'));

        children.forEach((el, i) => {
            el.style.animation = `slideInUp 0.55s cubic-bezier(0.22,1,0.36,1) ${0.1 + i * 0.07}s forwards`;
        });

        /* ============================================================
           2. FLOATING PARTICLES
        ============================================================ */
        const particleContainer = document.getElementById('particles');

        function createParticle() {
            const p    = document.createElement('div');
            p.className = 'particle';
            const size = Math.random() * 14 + 6;
            const left = Math.random() * 100;
            const dur  = Math.random() * 8 + 7;
            const del  = Math.random() * 5;
            p.style.cssText = `width:${size}px;height:${size}px;left:${left}%;bottom:-20px;animation-duration:${dur}s;animation-delay:${del}s;opacity:0;`;
            particleContainer.appendChild(p);
            setTimeout(() => p.remove(), (dur + del + 2) * 1000);
        }

        for (let i = 0; i < 14; i++) createParticle();
        setInterval(createParticle, 1200);

        /* ============================================================
           3. SVG TILE PULSE
        ============================================================ */
        const tiles = document.querySelectorAll('.tile');

        function pulseTile() {
            const tile = tiles[Math.floor(Math.random() * tiles.length)];
            tile.style.transition = 'opacity 0.4s ease';
            tile.style.opacity    = '0.4';
            setTimeout(() => tile.style.opacity = '1', 400);
        }

        setInterval(pulseTile, 600);

        /* ============================================================
           4. PASSWORD TOGGLE (main)
        ============================================================ */
        const togglePwd  = document.getElementById('togglePwd');
        const pwdInput   = document.getElementById('password');

        togglePwd.addEventListener('click', () => {
            const show = pwdInput.type === 'password';
            pwdInput.type         = show ? 'text' : 'password';
            togglePwd.textContent = show ? '🙈' : '👁';
            togglePwd.style.transform = 'translateY(-50%) scale(1.3)';
            setTimeout(() => togglePwd.style.transform = 'translateY(-50%) scale(1)', 200);
        });

        /* ============================================================
           5. PASSWORD TOGGLE (confirm)
        ============================================================ */
        const togglePwdConfirm  = document.getElementById('togglePwdConfirm');
        const pwdConfirmInput   = document.getElementById('password_confirmation');

        togglePwdConfirm.addEventListener('click', () => {
            const show = pwdConfirmInput.type === 'password';
            pwdConfirmInput.type         = show ? 'text' : 'password';
            togglePwdConfirm.textContent = show ? '🙈' : '👁';
            togglePwdConfirm.style.transform = 'translateY(-50%) scale(1.3)';
            setTimeout(() => togglePwdConfirm.style.transform = 'translateY(-50%) scale(1)', 200);
        });

        /* ============================================================
           6. PASSWORD STRENGTH METER
        ============================================================ */
        const strengthWrap  = document.getElementById('strengthWrap');
        const strengthBar   = document.getElementById('strengthBar');
        const strengthLabel = document.getElementById('strengthLabel');

        const levels = [
            { label: 'Sangat Lemah', color: '#ef4444', width: '20%' },
            { label: 'Lemah',        color: '#f97316', width: '40%' },
            { label: 'Cukup',        color: '#eab308', width: '60%' },
            { label: 'Kuat',         color: '#22c55e', width: '80%' },
            { label: 'Sangat Kuat',  color: '#16a34a', width: '100%' },
        ];

        function getStrength(pwd) {
            let score = 0;
            if (pwd.length >= 8)  score++;
            if (pwd.length >= 12) score++;
            if (/[A-Z]/.test(pwd)) score++;
            if (/[0-9]/.test(pwd)) score++;
            if (/[^A-Za-z0-9]/.test(pwd)) score++;
            return Math.min(score, 4);
        }

        pwdInput.addEventListener('input', () => {
            const val = pwdInput.value;

            if (val.length === 0) {
                strengthWrap.style.display  = 'none';
                strengthLabel.style.display = 'none';
                return;
            }

            strengthWrap.style.display  = 'block';
            strengthLabel.style.display = 'block';

            const idx  = getStrength(val);
            const lvl  = levels[idx];
            strengthBar.style.width           = lvl.width;
            strengthBar.style.backgroundColor = lvl.color;
            strengthLabel.textContent          = lvl.label;
            strengthLabel.style.color          = lvl.color;
        });

        /* ============================================================
           7. CONFIRM PASSWORD MATCH CHECK
        ============================================================ */
        const confirmError = document.getElementById('confirmError');

        function checkMatch() {
            if (pwdConfirmInput.value.length === 0) {
                confirmError.style.display = 'none';
                pwdConfirmInput.classList.remove('is-invalid', 'is-valid');
                return;
            }
            const match = pwdInput.value === pwdConfirmInput.value;
            confirmError.style.display = match ? 'none' : 'block';
            pwdConfirmInput.classList.toggle('is-valid', match);
            pwdConfirmInput.classList.toggle('is-invalid', !match);
        }

        pwdConfirmInput.addEventListener('input', checkMatch);
        pwdInput.addEventListener('input', checkMatch);

        /* ============================================================
           8. REAL-TIME VALIDATION (name & email)
        ============================================================ */
        const nameInput  = document.getElementById('name');
        const emailInput = document.getElementById('email');

        function validateName() {
            const ok = nameInput.value.trim().length >= 2;
            nameInput.classList.toggle('is-valid',   ok && nameInput.value.length > 0);
            nameInput.classList.toggle('is-invalid', !ok && nameInput.value.length > 0);
        }

        function validateEmail() {
            const ok = /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(emailInput.value);
            emailInput.classList.toggle('is-valid',   ok);
            emailInput.classList.toggle('is-invalid', !ok && emailInput.value.length > 0);
        }

        nameInput.addEventListener('input',  validateName);
        emailInput.addEventListener('input', validateEmail);

        /* Remove invalid on focus */
        document.querySelectorAll('.form-input').forEach(input => {
            input.addEventListener('focus', () => input.classList.remove('is-invalid'));
        });

        /* ============================================================
           9. RIPPLE on Register button
        ============================================================ */
        const registerBtn = document.getElementById('registerBtn');

        registerBtn.addEventListener('click', function(e) {
            const rect   = this.getBoundingClientRect();
            const x      = e.clientX - rect.left;
            const y      = e.clientY - rect.top;
            const ripple = document.createElement('span');
            ripple.className = 'ripple';
            ripple.style.cssText = `left:${x}px;top:${y}px;width:${rect.width}px;height:${rect.width}px;margin-left:-${rect.width/2}px;margin-top:-${rect.width/2}px;`;
            this.appendChild(ripple);
            setTimeout(() => ripple.remove(), 600);
        });

        /* ============================================================
           10. LOADING STATE + CLIENT VALIDATION on submit
        ============================================================ */
        document.getElementById('registerForm').addEventListener('submit', function(e) {
            const fields  = [nameInput, emailInput, pwdInput, pwdConfirmInput];
            let   hasErr  = false;

            fields.forEach(f => {
                if (!f.value.trim()) {
                    f.classList.add('is-invalid');
                    f.style.animation = 'none';
                    requestAnimationFrame(() => { f.style.animation = ''; });
                    hasErr = true;
                }
            });

            // Check password match
            if (pwdInput.value !== pwdConfirmInput.value) {
                pwdConfirmInput.classList.add('is-invalid');
                confirmError.style.display = 'block';
                hasErr = true;
            }

            // Check strength min
            if (pwdInput.value.length > 0 && getStrength(pwdInput.value) < 1) {
                pwdInput.classList.add('is-invalid');
                hasErr = true;
            }

            if (hasErr) {
                e.preventDefault();
                showToast('⚠️ Lengkapi semua field dengan benar.');
                return;
            }

            // Show loading
            registerBtn.classList.add('loading');
            registerBtn.disabled = true;
            setTimeout(() => {
                registerBtn.classList.remove('loading');
                registerBtn.disabled = false;
            }, 6000);
        });

        /* ============================================================
           11. CURSOR TRAIL on left panel
        ============================================================ */
        const leftPanel = document.querySelector('.left-section');

        leftPanel.addEventListener('mousemove', (e) => {
            const dot = document.createElement('div');
            dot.style.cssText = `
                position:absolute;
                left:${e.offsetX}px;top:${e.offsetY}px;
                width:6px;height:6px;
                border-radius:50%;
                background:rgba(200,180,0,0.7);
                pointer-events:none;
                transform:translate(-50%,-50%) scale(1);
                transition:transform 0.4s ease, opacity 0.4s ease;
            `;
            leftPanel.appendChild(dot);
            requestAnimationFrame(() => {
                dot.style.transform = 'translate(-50%,-50%) scale(3)';
                dot.style.opacity   = '0';
            });
            setTimeout(() => dot.remove(), 450);
        });

        /* ============================================================
           12. TOAST
        ============================================================ */
        function showToast(msg, duration = 3000) {
            const toast = document.getElementById('toast');
            toast.textContent = msg;
            toast.classList.add('show');
            setTimeout(() => toast.classList.remove('show'), duration);
        }

        @if ($errors->any())
            showToast('⚠️ Periksa kembali data registrasi kamu.');
        @endif
    </script>

</body>
</html>