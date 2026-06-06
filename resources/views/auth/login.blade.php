<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>E-Kanisius - Login</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Poppins', sans-serif;
            display: flex;
            height: 100vh;
            overflow: hidden;
        }

        /* ===== LEFT SECTION: Geometric Pattern ===== */
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
        }

        /* ===== HEADER: Logo row ===== */
        .header {
            display: flex;
            align-items: center;
            gap: 24px;
            margin-bottom: 48px;
            flex-wrap: wrap;
        }

        /* E-Kanisius logo block */
        .brand-ekanisius {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .brand-ekanisius img {
            width: 48px;
            height: auto;
        }

        .brand-ekanisius .brand-name {
            color: #1a2a6c;
            font-size: 22px;
            font-weight: 800;
            letter-spacing: -0.5px;
            line-height: 1;
        }

        /* Divider between logos */
        .header-divider {
            width: 1px;
            height: 48px;
            background-color: #ddd;
        }

        /* SAKTI logo block */
        .brand-sakti {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .brand-sakti img {
            width: 150px;
            height: auto;
        }

        .brand-sakti .sakti-text {
            display: flex;
            flex-direction: column;
            line-height: 1.1;
        }

        .brand-sakti .sakti-title {
            color: #1a2a6c;
            font-size: 20px;
            font-weight: 800;
            letter-spacing: 1px;
        }

        .brand-sakti .sakti-subtitle {
            color: #1a2a6c;
            font-size: 8px;
            font-weight: 500;
            letter-spacing: 0.2px;
        }

        /* ===== FORM ===== */
        .form-title {
            color: #111;
            font-size: 20px;
            font-weight: 500;
            margin-bottom: 32px;
        }

        .form-group {
            margin-bottom: 22px;
        }

        .form-label {
            color: #111;
            font-size: 15px;
            font-weight: 500;
            display: block;
            margin-bottom: 8px;
        }

        .form-input {
            width: 100%;
            height: 52px;
            background-color: #e8e8e8;
            border: none;
            border-radius: 8px;
            padding: 12px 18px;
            font-size: 14px;
            font-family: 'Poppins', sans-serif;
            color: #333;
            transition: all 0.25s ease;
        }

        .form-input:focus {
            outline: none;
            background-color: #dde4f0;
            box-shadow: 0 0 0 3px rgba(0, 74, 173, 0.15);
        }

        .form-input.is-invalid {
            box-shadow: 0 0 0 2px rgba(220, 38, 38, 0.4);
        }

        .error-msg {
            color: #dc2626;
            font-size: 12px;
            margin-top: 4px;
            display: block;
        }

        /* ===== Remember + Forgot row ===== */
        .remember-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 28px;
        }

        .checkbox-container {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .checkbox-input {
            width: 22px;
            height: 22px;
            accent-color: #004AAD;
            cursor: pointer;
            border-radius: 4px;
        }

        .checkbox-label {
            color: #333;
            font-size: 14px;
            font-weight: 500;
            cursor: pointer;
        }

        .forgot-password a {
            color: #333;
            font-size: 14px;
            font-weight: 500;
            text-decoration: none;
            transition: color 0.2s;
        }

        .forgot-password a:hover {
            color: #004AAD;
        }

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
            transition: background-color 0.25s ease, transform 0.1s ease;
            margin-bottom: 24px;
            letter-spacing: 0.3px;
        }

        .login-button:hover {
            background-color: #003a8c;
        }

        .login-button:active {
            transform: scale(0.99);
        }

        /* ===== Register link ===== */
        .register-section {
            text-align: center;
            font-size: 14px;
        }

        .register-section span {
            color: #444;
            font-weight: 400;
        }

        .register-section a {
            color: #111;
            font-weight: 700;
            text-decoration: none;
            transition: color 0.2s;
        }

        .register-section a:hover {
            color: #004AAD;
        }

        /* ===== Responsive ===== */
        @media (max-width: 768px) {
            body { flex-direction: column; height: auto; overflow: auto; }
            .left-section { width: 100%; height: 200px; }
            .right-section { padding: 32px 24px; }
        }
    </style>
</head>
<body>

    <!-- ===== LEFT: Geometric Pattern (SVG canvas) ===== -->
    <div class="left-section">
        <svg class="geo-canvas" viewBox="0 0 420 700" preserveAspectRatio="xMidYMid slice" xmlns="http://www.w3.org/2000/svg">
            <!-- Background base -->
            <rect width="420" height="700" fill="#1c2d4f"/>

            <!-- Row 1 -->
            <rect x="0" y="0" width="105" height="105" fill="#c8b400"/>
            <circle cx="52" cy="52" r="36" fill="#1c2d4f"/>

            <rect x="105" y="0" width="105" height="105" fill="#1c2d4f"/>
            <circle cx="157" cy="52" r="36" fill="#c8b400" fill-opacity="0.15"/>
            <circle cx="157" cy="52" r="18" fill="#c8b400" fill-opacity="0.3"/>

            <rect x="210" y="0" width="105" height="105" fill="#2e4a78"/>
            <path d="M210,0 Q262,52 315,0 Q262,52 315,105 Q262,52 210,105 Q262,52 210,0" fill="#1c2d4f" fill-opacity="0.6"/>

            <rect x="315" y="0" width="105" height="105" fill="#1c2d4f"/>
            <circle cx="367" cy="52" r="36" fill="#2e4a78"/>
            <circle cx="367" cy="52" r="18" fill="#1c2d4f"/>

            <!-- Row 2 -->
            <rect x="0" y="105" width="105" height="105" fill="#2e4a78"/>
            <path d="M0,105 L105,105 L105,210 Z" fill="#1c2d4f" fill-opacity="0.5"/>

            <rect x="105" y="105" width="105" height="105" fill="#c8b400" fill-opacity="0.15"/>
            <circle cx="157" cy="157" r="42" fill="#c8b400" fill-opacity="0.25"/>

            <rect x="210" y="105" width="105" height="105" fill="#1c2d4f"/>
            <path d="M210,157 Q262,105 315,157" stroke="#c8b400" stroke-width="3" fill="none" opacity="0.4"/>
            <path d="M210,157 Q262,210 315,157" stroke="#c8b400" stroke-width="3" fill="none" opacity="0.4"/>

            <rect x="315" y="105" width="105" height="105" fill="#c8b400"/>
            <circle cx="367" cy="157" r="36" fill="#1c2d4f"/>
            <circle cx="367" cy="157" r="18" fill="#c8b400" fill-opacity="0.3"/>

            <!-- Row 3 -->
            <rect x="0" y="210" width="105" height="105" fill="#1c2d4f"/>
            <circle cx="52" cy="262" r="36" fill="#2e4a78"/>

            <rect x="105" y="210" width="105" height="105" fill="#c8b400" fill-opacity="0.8"/>
            <path d="M105,210 L210,210 L210,315 Z" fill="#1c2d4f" fill-opacity="0.4"/>

            <rect x="210" y="210" width="105" height="105" fill="#2e4a78"/>
            <circle cx="262" cy="262" r="40" fill="#1c2d4f"/>
            <circle cx="262" cy="262" r="20" fill="#2e4a78"/>

            <rect x="315" y="210" width="105" height="105" fill="#1c2d4f"/>
            <path d="M315,210 Q367,262 420,210 Q367,262 420,315 Q367,262 315,315 Q367,262 315,210" fill="#2e4a78" fill-opacity="0.5"/>

            <!-- Row 4 (big shapes) -->
            <rect x="0" y="315" width="210" height="210" fill="#1c2d4f"/>
            <circle cx="105" cy="420" r="95" fill="#2e4a78"/>
            <circle cx="105" cy="420" r="55" fill="#1c2d4f"/>
            <circle cx="105" cy="420" r="25" fill="#c8b400" fill-opacity="0.4"/>

            <rect x="210" y="315" width="105" height="105" fill="#c8b400"/>
            <circle cx="262" cy="367" r="36" fill="#1c2d4f"/>

            <rect x="315" y="315" width="105" height="105" fill="#2e4a78"/>
            <path d="M315,315 L420,315 L420,420 Z" fill="#c8b400" fill-opacity="0.3"/>

            <rect x="210" y="420" width="105" height="105" fill="#1c2d4f"/>
            <circle cx="262" cy="472" r="36" fill="#c8b400" fill-opacity="0.2"/>
            <circle cx="262" cy="472" r="18" fill="#c8b400" fill-opacity="0.5"/>

            <rect x="315" y="420" width="105" height="105" fill="#c8b400" fill-opacity="0.15"/>
            <path d="M315,472 Q367,420 420,472 Q367,525 315,472" fill="#2e4a78" fill-opacity="0.7"/>

            <!-- Row 5 -->
            <rect x="0" y="525" width="105" height="105" fill="#2e4a78"/>
            <circle cx="52" cy="577" r="36" fill="#c8b400" fill-opacity="0.2"/>
            <circle cx="52" cy="577" r="16" fill="#c8b400" fill-opacity="0.5"/>

            <rect x="105" y="525" width="105" height="105" fill="#c8b400"/>
            <path d="M105,525 L210,525 L210,630 Z" fill="#1c2d4f" fill-opacity="0.5"/>

            <rect x="210" y="525" width="105" height="105" fill="#1c2d4f"/>
            <circle cx="262" cy="577" r="36" fill="#2e4a78"/>
            <path d="M210,577 L315,577" stroke="#c8b400" stroke-width="2" opacity="0.3"/>

            <rect x="315" y="525" width="105" height="105" fill="#2e4a78"/>
            <circle cx="367" cy="577" r="36" fill="#1c2d4f"/>
            <circle cx="367" cy="577" r="18" fill="#c8b400" fill-opacity="0.4"/>

            <!-- Row 6 -->
            <rect x="0" y="630" width="105" height="70" fill="#c8b400" fill-opacity="0.5"/>
            <rect x="105" y="630" width="105" height="70" fill="#1c2d4f"/>
            <circle cx="157" cy="665" r="25" fill="#2e4a78"/>
            <rect x="210" y="630" width="105" height="70" fill="#2e4a78"/>
            <rect x="315" y="630" width="105" height="70" fill="#c8b400" fill-opacity="0.2"/>
            <path d="M315,630 Q367,665 420,630 Q367,665 420,700 Q367,665 315,700 Q367,665 315,630" fill="#1c2d4f" fill-opacity="0.5"/>
        </svg>
    </div>

    <!-- ===== RIGHT: Login Form ===== -->
    <div class="right-section">
        <div class="login-container">

            <!-- Header: E-Kanisius + SAKTI logos -->
            <div class="header">
                <!-- E-Kanisius -->
                <div class="brand-ekanisius">
                    <img src="{{ asset('img/image 1 (1).png') }}" alt="E-Kanisius Logo">
                    <span class="brand-name">E-Kanisius</span>
                </div>

                <div class="header-divider"></div>

                <!-- SAKTI -->
                <div class="brand-sakti">
                    <img src="{{ asset('img/E-Kanisius 1.png') }}" alt="SAKTI Logo">
                    <div class="sakti-text">
                        <!-- <span class="sakti-title">SAKTI</span> -->
                        <!-- <span class="sakti-subtitle">Sistem Admisi<br>Kanisius Terintegrasi</span> -->
                    </div>
                </div>
            </div>

            <!-- Login Form -->
            <form method="POST" action="{{ route('login') }}">
                @csrf

                <h2 class="form-title">Sign In To Your Account</h2>

                <!-- Email -->
                <div class="form-group">
                    <label for="email" class="form-label">Email</label>
                    <input
                        type="email"
                        id="email"
                        name="email"
                        class="form-input @error('email') is-invalid @enderror"
                        placeholder="Enter your email"
                        value="{{ old('email') }}"
                        required
                        autofocus
                    >
                    @error('email')
                        <span class="error-msg">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Password -->
                <div class="form-group">
                    <label for="password" class="form-label">Password</label>
                    <input
                        type="password"
                        id="password"
                        name="password"
                        class="form-input @error('password') is-invalid @enderror"
                        placeholder="Enter your password"
                        required
                    >
                    @error('password')
                        <span class="error-msg">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Remember Me & Forgot Password -->
                <div class="remember-row">
                    <div class="checkbox-container">
                        <input type="checkbox" id="remember" name="remember" class="checkbox-input"
                            {{ old('remember') ? 'checked' : '' }}>
                        <label for="remember" class="checkbox-label">Remember me</label>
                    </div>
                    <div class="forgot-password">
                        <a href="{{ route('password.request') }}">Forgot Password?</a>
                    </div>
                </div>

                <!-- Login Button -->
                <button type="submit" class="login-button">Login</button>

                <!-- Register Link -->
                <div class="register-section">
                    <span>Dont have an account ? </span>
                    <a href="{{ route('register') }}">Register Here</a>
                </div>

            </form>
        </div>
    </div>

</body>
</html>