<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Choose Account Type | Fashion Marketplace</title>
    <link href="https://fonts.googleapis.com/css2?family=Nunito+Sans:wght@300;400;600;700;800;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'Nunito Sans', sans-serif; min-height: 100vh; display: flex; background: #111; }
        .auth__left {
            flex: 1; background: #111;
            display: flex; align-items: center; justify-content: center;
            padding: 50px; flex-direction: column;
        }
        .auth__left__logo { font-size: 13px; letter-spacing: 6px; text-transform: uppercase; color: rgba(255,255,255,0.5); margin-bottom: 40px; }
        .auth__left__text h2 { font-size: 52px; font-weight: 800; line-height: 1.1; margin-bottom: 20px; letter-spacing: 3px; text-transform: uppercase; color: #fff; }
        .auth__left__text h2 span { color: #c8a96e; }
        .auth__left__text p { font-size: 15px; color: rgba(255,255,255,0.5); max-width: 350px; line-height: 1.8; }
        .auth__right { width: 560px; background: #fff; display: flex; flex-direction: column; justify-content: center; padding: 60px 55px; overflow-y: auto; }
        .auth__brand { font-size: 11px; letter-spacing: 4px; text-transform: uppercase; color: #c8a96e; margin-bottom: 12px; font-weight: 700; }
        .auth__title { font-size: 28px; font-weight: 800; color: #111; margin-bottom: 8px; text-transform: uppercase; letter-spacing: 2px; }
        .auth__subtitle { font-size: 14px; color: #999; margin-bottom: 35px; line-height: 1.6; }

        /* Google User Info */
        .google__user { display: flex; align-items: center; gap: 15px; background: #f9f9f9; padding: 15px 20px; margin-bottom: 30px; border-left: 3px solid #c8a96e; }
        .google__user img { width: 45px; height: 45px; border-radius: 50%; object-fit: cover; }
        .google__user__info { flex: 1; }
        .google__user__name { font-size: 14px; font-weight: 700; color: #111; }
        .google__user__email { font-size: 12px; color: #999; }

        /* Role Cards */
        .role__cards { display: flex; gap: 15px; margin-bottom: 25px; }
        .role__card { flex: 1; border: 2px solid #e8e8e8; padding: 20px; cursor: pointer; transition: all 0.3s; text-align: center; }
        .role__card:hover { border-color: #c8a96e; }
        .role__card.selected { border-color: #111; background: #111; }
        .role__card.selected .role__card__title { color: #fff; }
        .role__card.selected .role__card__desc { color: rgba(255,255,255,0.6); }
        .role__card.selected .role__card__icon { color: #c8a96e; }
        .role__card input { display: none; }
        .role__card__icon { font-size: 32px; margin-bottom: 12px; display: block; }
        .role__card__title { font-size: 13px; font-weight: 800; letter-spacing: 1px; text-transform: uppercase; color: #111; margin-bottom: 5px; }
        .role__card__desc { font-size: 12px; color: #999; }

        /* Shop Fields */
        .shop__fields { display: none; background: #f9f9f9; padding: 20px; margin-bottom: 20px; border-left: 3px solid #c8a96e; }
        .form-label { font-size: 11px; font-weight: 700; letter-spacing: 2px; text-transform: uppercase; color: #111; margin-bottom: 8px; display: block; }
        .form-control { border: 1px solid #e8e8e8; border-radius: 0; padding: 12px 16px; font-size: 14px; color: #111; background: #fff; transition: all 0.3s; width: 100%; }
        .form-control:focus { border-color: #111; outline: none; }

        .btn-auth { background: #111; color: #fff; border: none; border-radius: 0; padding: 15px; font-size: 11px; font-weight: 700; letter-spacing: 3px; text-transform: uppercase; width: 100%; transition: background 0.3s; cursor: pointer; }
        .btn-auth:hover { background: #c8a96e; }
        .alert { border-radius: 0; font-size: 13px; border: none; padding: 12px 16px; margin-bottom: 20px; background: #fdf0f0; color: #e74c3c; }
        .alert p { margin: 0; }
        @media (max-width: 768px) { .auth__left { display: none; } .auth__right { width: 100%; padding: 40px 30px; } }
    </style>
</head>
<body>
    <!-- Left Side -->
    <div class="auth__left">
        <div class="auth__left__logo">Fashion Marketplace</div>
        <div class="auth__left__text">
            <h2>Almost <br> There <br> <span>!</span></h2>
            <p>Just one more step — tell us how you want to use Fashion Marketplace.</p>
        </div>
    </div>

    <!-- Right Side -->
    <div class="auth__right">
        <div class="auth__brand">One Last Step</div>
        <h1 class="auth__title">Choose Account Type</h1>
        <p class="auth__subtitle">How would you like to use Fashion Marketplace?</p>

        <!-- Google User Info -->
        <div class="google__user">
            @if(session('google_avatar'))
                <img src="{{ session('google_avatar') }}" alt="Profile">
            @endif
            <div class="google__user__info">
                <div class="google__user__name">{{ session('google_name') }}</div>
                <div class="google__user__email">{{ session('google_email') }}</div>
            </div>
            <svg width="18" height="18" viewBox="0 0 24 24">
                <path fill="#4285F4" d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z"/>
                <path fill="#34A853" d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z"/>
                <path fill="#FBBC05" d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.07H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.93l2.85-2.22.81-.62z"/>
                <path fill="#EA4335" d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.07l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z"/>
            </svg>
        </div>

        @if($errors->any())
            <div class="alert">
                @foreach($errors->all() as $error)
                    <p>{{ $error }}</p>
                @endforeach
            </div>
        @endif

        <form method="POST" action="{{ route('google.role.save') }}">
            @csrf

            <!-- Role Cards -->
            <div class="role__cards">
                <label class="role__card selected" id="card-buyer" onclick="selectRole('user', this)">
                    <input type="radio" name="role" value="user" checked>
                    <span class="role__card__icon">🛍️</span>
                    <div class="role__card__title">Buyer</div>
                    <div class="role__card__desc">Browse and inquire about products</div>
                </label>
                <label class="role__card" id="card-seller" onclick="selectRole('admin', this)">
                    <input type="radio" name="role" value="admin">
                    <span class="role__card__icon">🏪</span>
                    <div class="role__card__title">Seller</div>
                    <div class="role__card__desc">Open a shop and sell products</div>
                </label>
            </div>

            <!-- Shop Fields (only for sellers) -->
            <div class="shop__fields" id="shop-fields">
                <div class="mb-3">
                    <label class="form-label">Shop Name <span style="color:#e74c3c;">*</span></label>
                    <input type="text" name="shop_name" class="form-control"
                        placeholder="Enter your shop name"
                        value="{{ old('shop_name') }}">
                </div>
                <div class="mb-0">
                    <label class="form-label">Shop Description</label>
                    <input type="text" name="shop_description" class="form-control"
                        placeholder="Brief description of your shop"
                        value="{{ old('shop_description') }}">
                </div>
            </div>

            <button type="submit" class="btn-auth">
                Continue to Fashion Marketplace
            </button>
        </form>
    </div>

    <script>
        function selectRole(role, element) {
            document.querySelectorAll('.role__card').forEach(el => el.classList.remove('selected'));
            element.classList.add('selected');
            document.querySelector('input[name="role"][value="' + role + '"]').checked = true;

            if (role === 'admin') {
                document.getElementById('shop-fields').style.display = 'block';
            } else {
                document.getElementById('shop-fields').style.display = 'none';
            }
        }

        // Check on page load if seller was previously selected (validation error)
        document.addEventListener('DOMContentLoaded', function() {
            const selectedRole = document.querySelector('input[name="role"]:checked').value;
            if (selectedRole === 'admin') {
                document.getElementById('shop-fields').style.display = 'block';
                document.getElementById('card-seller').classList.add('selected');
                document.getElementById('card-buyer').classList.remove('selected');
            }
        });
    </script>
</body>
</html>