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
        body { font-family: 'Nunito Sans', sans-serif; min-height: 100vh; display: flex; background: #111; }
        .auth__left { flex: 1; background: #111; display: flex; align-items: center; justify-content: center; padding: 50px; flex-direction: column; }
        .auth__left__logo { font-size: 13px; letter-spacing: 6px; text-transform: uppercase; color: rgba(255,255,255,0.5); margin-bottom: 40px; }
        .auth__left__text h2 { font-size: 52px; font-weight: 800; line-height: 1.1; margin-bottom: 20px; letter-spacing: 3px; text-transform: uppercase; color: #fff; }
        .auth__left__text h2 span { color: #c8a96e; }
        .auth__left__text p { font-size: 15px; color: rgba(255,255,255,0.5); max-width: 350px; line-height: 1.8; }
        .auth__left__dots { display: flex; gap: 8px; margin-top: 40px; }
        .auth__left__dots span { width: 8px; height: 8px; border-radius: 50%; background: rgba(255,255,255,0.2); }
        .auth__left__dots span.active { background: #c8a96e; width: 24px; border-radius: 4px; }
        .auth__right { width: 500px; background: #fff; display: flex; flex-direction: column; justify-content: center; padding: 70px 55px; overflow-y: auto; }
        .auth__brand { font-size: 11px; letter-spacing: 4px; text-transform: uppercase; color: #c8a96e; margin-bottom: 12px; font-weight: 700; }
        .auth__title { font-size: 30px; font-weight: 800; color: #111; margin-bottom: 8px; text-transform: uppercase; letter-spacing: 2px; }
        .auth__subtitle { font-size: 14px; color: #999; margin-bottom: 30px; }
        .form-label { font-size: 11px; font-weight: 700; letter-spacing: 2px; text-transform: uppercase; color: #111; margin-bottom: 8px; }
        .form-control { border: 1px solid #e8e8e8; border-radius: 0; padding: 14px 16px; font-size: 14px; color: #111; background: #fafafa; transition: all 0.3s; }
        .form-control:focus { border-color: #111; background: #fff; box-shadow: none; }
        .form-control.is-invalid { border-color: #e74c3c; }
        .btn-auth { background: #111; color: #fff; border: none; border-radius: 0; padding: 15px; font-size: 11px; font-weight: 700; letter-spacing: 3px; text-transform: uppercase; width: 100%; margin-top: 10px; transition: background 0.3s; cursor: pointer; }
        .btn-auth:hover { background: #c8a96e; }
        .btn-google { background: #fff; color: #444; border: 1px solid #dadce0; border-radius: 0; padding: 13px 15px; font-size: 14px; font-weight: 600; width: 100%; transition: all 0.3s; cursor: pointer; display: flex; align-items: center; justify-content: center; gap: 12px; text-decoration: none; }
        .btn-google:hover { background: #f8f8f8; border-color: #bbb; color: #111; box-shadow: 0 2px 8px rgba(0,0,0,0.1); }
        .divider { display: flex; align-items: center; gap: 15px; margin: 20px 0; }
        .divider::before, .divider::after { content: ''; flex: 1; height: 1px; background: #e8e8e8; }
        .divider span { font-size: 11px; color: #ccc; letter-spacing: 2px; text-transform: uppercase; }
        .forgot-link { text-align: right; margin-top: 6px; }
        .forgot-link a { font-size: 12px; color: #999; text-decoration: none; transition: color 0.3s; }
        .forgot-link a:hover { color: #c8a96e; }
        .auth__link { text-align: center; font-size: 13px; color: #999; margin-top: 25px; }
        .auth__link a { color: #111; font-weight: 700; text-decoration: none; }
        .auth__link a:hover { color: #c8a96e; }
        .alert { border-radius: 0; font-size: 13px; border: none; padding: 12px 16px; margin-bottom: 20px; }
        .alert-danger { background: #fdf0f0; color: #e74c3c; }
        .alert-success { background: #f0fdf4; color: #27ae60; }
        .alert p { margin: 0; line-height: 1.8; }
        @media (max-width: 768px) { .auth__left { display: none; } .auth__right { width: 100%; padding: 40px 30px; } }
    </style>
</head>
<body>
    <div class="auth__left">
        <div class="auth__left__logo">Fashion Marketplace</div>
        <div class="auth__left__text">
            <h2>Style <br> Starts <br> <span>Here.</span></h2>
            <p>Discover the latest trends in Men's, Women's and Kids' fashion.</p>
        </div>
        <div class="auth__left__dots">
            <span class="active"></span><span></span><span></span>
        </div>
    </div>

    <div class="auth__right">
        <div class="auth__brand">Welcome Back</div>
        <h1 class="auth__title">Sign In</h1>
        <p class="auth__subtitle">Please sign in to continue.</p>

        @if(session('success'))
            <div class="alert alert-success"><p>{{ session('success') }}</p></div>
        @endif

        @if($errors->any())
            <div class="alert alert-danger">
                @foreach($errors->all() as $error)
                    <p>{{ $error }}</p>
                @endforeach
            </div>
        @endif

        <!-- Google Sign In -->
        <a href="{{ route('auth.google') }}" class="btn-google">
            <svg width="20" height="20" viewBox="0 0 24 24">
                <path fill="#4285F4" d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z"/>
                <path fill="#34A853" d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z"/>
                <path fill="#FBBC05" d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.07H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.93l2.85-2.22.81-.62z"/>
                <path fill="#EA4335" d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.07l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z"/>
            </svg>
            Continue with Google
        </a>

        <div class="divider"><span>or sign in with email</span></div>

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
                <div class="forgot-link">
                    <a href="{{ route('password.request') }}">Forgot your password?</a>
                </div>
            </div>
            <button type="submit" class="btn-auth">Sign In</button>
        </form>

        <div class="auth__link">
            Don't have an account? <a href="{{ route('register') }}">Create one</a>
        </div>
    </div>
</body>
</html>