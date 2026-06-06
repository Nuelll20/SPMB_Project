<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>E-Kanisius - Login</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Poppins', sans-serif;
            background-color: #f5f5f5;
            display: flex;
            height: 100vh;
        }

        .container {
            display: flex;
            width: 100%;
            height: 100vh;
        }

        .left-section {
            width: 50%;
            background-color: #D9D9D9;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-direction: column;
        }

        .left-section img {
            width: 200px;
            height: auto;
            margin-bottom: 30px;
        }

        .right-section {
            width: 50%;
            background-color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 40px;
        }

        .login-container {
            width: 100%;
            max-width: 500px;
        }

        .header {
            display: flex;
            align-items: center;
            gap: 20px;
            margin-bottom: 60px;
        }

        .logo-img {
            width: 80px;
            height: 128px;
        }

        .logo-text {
            color: #28166F;
            font-size: 32px;
            font-weight: 800;
        }

        .form-title {
            color: black;
            font-size: 24px;
            font-weight: 500;
            margin-bottom: 40px;
        }

        .form-group {
            margin-bottom: 30px;
        }

        .form-label {
            color: black;
            font-size: 24px;
            font-weight: 500;
            display: block;
            margin-bottom: 12px;
        }

        .form-input {
            width: 100%;
            height: 70px;
            background-color: #D9D9D9;
            border: none;
            border-radius: 9px;
            padding: 15px 20px;
            font-size: 16px;
            font-family: 'Poppins', sans-serif;
            transition: all 0.3s ease;
        }

        .form-input:focus {
            outline: none;
            background-color: #e8e8e8;
            box-shadow: 0 0 8px rgba(0, 74, 173, 0.2);
        }

        .checkbox-container {
            display: flex;
            align-items: center;
            gap: 12px;
            margin-bottom: 20px;
        }

        .checkbox-input {
            width: 34px;
            height: 34px;
            background-color: #D9D9D9;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        .checkbox-label {
            color: black;
            font-size: 20px;
            font-weight: 500;
            cursor: pointer;
        }

        .forgot-password {
            text-align: right;
            margin-bottom: 30px;
        }

        .forgot-password a {
            color: black;
            font-size: 20px;
            font-weight: 500;
            text-decoration: none;
            transition: color 0.3s ease;
        }

        .forgot-password a:hover {
            color: #004AAD;
        }

        .login-button {
            width: 100%;
            height: 76px;
            background-color: #004AAD;
            border: none;
            border-radius: 9px;
            color: white;
            font-size: 24px;
            font-weight: 500;
            font-family: 'Poppins', sans-serif;
            cursor: pointer;
            transition: background-color 0.3s ease;
            margin-bottom: 30px;
        }

        .login-button:hover {
            background-color: #003580;
        }

        .register-section {
            text-align: center;
            font-size: 20px;
            font-family: 'Poppins', sans-serif;
        }

        .register-section span {
            color: black;
            font-weight: 500;
        }

        .register-section a {
            color: black;
            font-weight: 700;
            text-decoration: none;
            transition: color 0.3s ease;
        }

        .register-section a:hover {
            color: #004AAD;
        }

        @media (max-width: 768px) {
            .container {
                flex-direction: column;
            }

            .left-section,
            .right-section {
                width: 100%;
                height: auto;
            }

            .left-section {
                padding: 40px 20px;
            }

            .right-section {
                padding: 40px 20px;
            }

            .header {
                flex-direction: column;
                text-align: center;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <!-- Left Section -->
        <div class="left-section">
            <img src="{{ asset('img/image 1 (1).png') }}" alt="E-Kanisius Logo" class="logo-img">
            <img src="{{ asset('img/Background 1.png') }}" alt="E-Kanisius" style="width: 299px; height: 160px;">
        </div>

        <!-- Right Section -->
        <div class="right-section">
            <div class="login-container">
                <!-- Header with Logo and Title -->
                <div class="header">
                    <img src="{{ asset('img/E-Kanisius 1.png') }}" alt="Logo" class="logo-img" style="width: 80px; height: 128px;">
                    <div class="logo-text">E-Kanisius</div>
                </div>

                <!-- Login Form -->
                <form method="POST" action="{{ route('login') }}">
                    @csrf

                    <h2 class="form-title">Sign In To Your Account</h2>

                    <!-- Email Field -->
                    <div class="form-group">
                        <label for="email" class="form-label">Email</label>
                        <input 
                            type="email" 
                            id="email" 
                            name="email" 
                            class="form-input @error('email') is-invalid @enderror" 
                            placeholder="Enter your email"
                            required
                            autofocus
                        >
                        @error('email')
                            <span style="color: red; font-size: 14px;">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Password Field -->
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
                            <span style="color: red; font-size: 14px;">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Remember Me & Forgot Password -->
                    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 30px;">
                        <div class="checkbox-container">
                            <input type="checkbox" id="remember" name="remember" class="checkbox-input">
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
    </div>
</body>
</html>
