<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forgot Password | Fashion Marketplace</title>
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
        .auth__right { width: 500px; background: #fff; display: flex; flex-direction: column; justify-content: center; padding: 70px 55px; }
        .auth__brand { font-size: 11px; letter-spacing: 4px; text-transform: uppercase; color: #c8a96e; margin-bottom: 12px; font-weight: 700; }
        .auth__title { font-size: 30px; font-weight: 800; color: #111; margin-bottom: 8px; text-transform: uppercase; letter-spacing: 2px; }
        .auth__subtitle { font-size: 14px; color: #999; margin-bottom: 35px; line-height: 1.6; }
        .form-label { font-size: 11px; font-weight: 700; letter-spacing: 2px; text-transform: uppercase; color: #111; margin-bottom: 8px; }
        .form-control { border: 1px solid #e8e8e8; border-radius: 0; padding: 14px 16px; font-size: 14px; color: #111; background: #fafafa; transition: all 0.3s; }
        .form-control:focus { border-color: #111; background: #fff; box-shadow: none; }
        .btn-auth { background: #111; color: #fff; border: none; border-radius: 0; padding: 15px; font-size: 11px; font-weight: 700; letter-spacing: 3px; text-transform: uppercase; width: 100%; margin-top: 10px; transition: background 0.3s; cursor: pointer; }
        .btn-auth:hover { background: #c8a96e; }
        .auth__link { text-align: center; font-size: 13px; color: #999; margin-top: 25px; }
        .auth__link a { color: #111; font-weight: 700; text-decoration: none; }
        .auth__link a:hover { color: #c8a96e; }
        .alert { border-radius: 0; font-size: 13px; border: none; padding: 12px 16px; margin-bottom: 20px; }
        .alert-danger { background: #fdf0f0; color: #e74c3c; }
        .alert-success { background: #f0fdf4; color: #27ae60; }
        .alert p { margin: 0; }
        @media (max-width: 768px) { .auth__left { display: none; } .auth__right { width: 100%; padding: 40px 30px; } }
    </style>
</head>
<body>
    <div class="auth__left">
        <div class="auth__left__logo">Fashion Marketplace</div>
        <div class="auth__left__text">
            <h2>Reset <br> Your <br> <span>Password.</span></h2>
            <p>Enter your email and we'll send you a link to reset your password.</p>
        </div>
    </div>
    <div class="auth__right">
        <div class="auth__brand">Account Recovery</div>
        <h1 class="auth__title">Forgot Password</h1>
        <p class="auth__subtitle">Enter your registered email address and we'll send you a password reset link.</p>

        @if(session('success'))
            <div class="alert alert-success"><p>✓ {{ session('success') }}</p></div>
        @endif

        @if($errors->any())
            <div class="alert alert-danger">
                @foreach($errors->all() as $error)
                    <p>{{ $error }}</p>
                @endforeach
            </div>
        @endif

        <form method="POST" action="{{ route('password.email') }}">
            @csrf
            <div class="mb-3">
                <label class="form-label">Email Address</label>
                <input type="email" name="email"
                    class="form-control"
                    placeholder="Enter your registered email"
                    value="{{ old('email') }}" required>
            </div>
            <button type="submit" class="btn-auth">Send Reset Link</button>
        </form>

        <div class="auth__link">
            Remember your password? <a href="{{ route('login') }}">Sign in</a>
        </div>
    </div>
</body>
</html>