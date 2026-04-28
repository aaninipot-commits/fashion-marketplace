<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login | Fashion Marketplace</title>
    <link href="https://fonts.googleapis.com/css2?family=Nunito+Sans:wght@300;400;600;700;800;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body {
            font-family: 'Nunito Sans', sans-serif;
            min-height: 100vh;
            display: flex;
            background: #111;
        }
        .auth__left {
            flex: 1;
            background: #111;
            position: relative;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 50px;
            flex-direction: column;
        }
        .auth__left__logo {
            font-size: 13px;
            letter-spacing: 6px;
            text-transform: uppercase;
            color: rgba(255,255,255,0.5);
            margin-bottom: 40px;
        }
        .auth__left__text h2 {
            font-size: 52px;
            font-weight: 800;
            line-height: 1.1;
            margin-bottom: 20px;
            letter-spacing: 3px;
            text-transform: uppercase;
            color: #fff;
        }
        .auth__left__text h2 span {
            color: #c8a96e;
        }
        .auth__left__text p {
            font-size: 15px;
            color: rgba(255,255,255,0.5);
            max-width: 350px;
            line-height: 1.8;
        }
        .auth__left__dots {
            display: flex;
            gap: 8px;
            margin-top: 40px;
        }
        .auth__left__dots span {
            width: 8px;
            height: 8px;
            border-radius: 50%;
            background: rgba(255,255,255,0.2);
        }
        .auth__left__dots span.active {
            background: #c8a96e;
            width: 24px;
            border-radius: 4px;
        }
        .auth__right {
            width: 500px;
            background: #fff;
            display: flex;
            flex-direction: column;
            justify-content: center;
            padding: 70px 55px;
        }
        .auth__brand {
            font-size: 11px;
            letter-spacing: 4px;
            text-transform: uppercase;
            color: #c8a96e;
            margin-bottom: 12px;
            font-weight: 700;
        }
        .auth__title {
            font-size: 30px;
            font-weight: 800;
            color: #111;
            margin-bottom: 8px;
            text-transform: uppercase;
            letter-spacing: 2px;
        }
        .auth__subtitle {
            font-size: 14px;
            color: #999;
            margin-bottom: 35px;
        }
        .form-label {
            font-size: 11px;
            font-weight: 700;
            letter-spacing: 2px;
            text-transform: uppercase;
            color: #111;
            margin-bottom: 8px;
        }
        .form-control {
            border: 1px solid #e8e8e8;
            border-radius: 0;
            padding: 14px 16px;
            font-size: 14px;
            color: #111;
            background: #fafafa;
            transition: all 0.3s;
        }
        .form-control:focus {
            border-color: #111;
            background: #fff;
            box-shadow: none;
        }
        .form-control.is-invalid { border-color: #e74c3c; }
        .btn-auth {
            background: #111;
            color: #fff;
            border: none;
            border-radius: 0;
            padding: 15px;
            font-size: 11px;
            font-weight: 700;
            letter-spacing: 3px;
            text-transform: uppercase;
            width: 100%;
            margin-top: 10px;
            transition: background 0.3s;
            cursor: pointer;
        }
        .btn-auth:hover { background: #c8a96e; }
        .auth__link {
            text-align: center;
            font-size: 13px;
            color: #999;
            margin-top: 25px;
        }
        .auth__link a {
            color: #111;
            font-weight: 700;
            text-decoration: none;
            letter-spacing: 1px;
        }
        .auth__link a:hover { color: #c8a96e; }
        .alert {
            border-radius: 0;
            font-size: 13px;
            border: none;
            padding: 12px 16px;
            margin-bottom: 20px;
        }
        .alert-danger { background: #fdf0f0; color: #e74c3c; }
        .alert-success { background: #f0fdf4; color: #27ae60; }
        .alert p { margin: 0; line-height: 1.8; }
        @media (max-width: 768px) {
            .auth__left { display: none; }
            .auth__right { width: 100%; padding: 40px 30px; }
        }
    </style>
</head>
<body>
    <!-- Left Side -->
    <div class="auth__left">
        <div class="auth__left__logo">Fashion Marketplace</div>
        <div class="auth__left__text">
            <h2>Style <br> Starts <br> <span>Here.</span></h2>
            <p>Discover the latest trends in Men's, Women's and Kids' fashion. Shop the best collections at the best prices.</p>
        </div>
        <div class="auth__left__dots">
            <span class="active"></span>
            <span></span>
            <span></span>
        </div>
    </div>

    <!-- Right Side -->
    <div class="auth__right">
        <div class="auth__brand">Welcome Back</div>
        <h1 class="auth__title">Sign In</h1>
        <p class="auth__subtitle">Please enter your email and password to continue.</p>

        @if(session('success'))
            <div class="alert alert-success">
                <p>{{ session('success') }}</p>
            </div>
        @endif

        @if($errors->any())
            <div class="alert alert-danger">
                @foreach($errors->all() as $error)
                    <p>{{ $error }}</p>
                @endforeach
            </div>
        @endif

        <form method="POST" action="{{ route('login.post') }}">
            @csrf
            <div class="mb-3">
                <label class="form-label">Email Address</label>
                <input type="email" name="email"
                    class="form-control @error('email') is-invalid @enderror"
                    placeholder="Enter your email"
                    value="{{ old('email') }}" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Password</label>
                <input type="password" name="password"
                    class="form-control @error('password') is-invalid @enderror"
                    placeholder="Enter your password" required>
            </div>
            <button type="submit" class="btn-auth">Sign In</button>
        </form>

        <div class="auth__link">
            Don't have an account? <a href="{{ route('register') }}">Create one</a>
        </div>
    </div>
</body>
</html>