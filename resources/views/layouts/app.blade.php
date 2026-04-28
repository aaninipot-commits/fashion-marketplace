<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="description" content="Fashion Marketplace">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Fashion Marketplace</title>

    <link href="https://fonts.googleapis.com/css2?family=Nunito+Sans:wght@300;400;600;700;800;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}" type="text/css">
    <link rel="stylesheet" href="{{ asset('css/font-awesome.min.css') }}" type="text/css">
    <link rel="stylesheet" href="{{ asset('css/elegant-icons.css') }}" type="text/css">
    <link rel="stylesheet" href="{{ asset('css/magnific-popup.css') }}" type="text/css">
    <link rel="stylesheet" href="{{ asset('css/nice-select.css') }}" type="text/css">
    <link rel="stylesheet" href="{{ asset('css/owl.carousel.min.css') }}" type="text/css">
    <link rel="stylesheet" href="{{ asset('css/slicknav.min.css') }}" type="text/css">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}" type="text/css">

    <style>
        /* Improved Dropdown */
        .header__menu ul .dropdown {
            background: #1a1a1a !important;
            border-top: 3px solid #c8a96e !important;
            border-radius: 0 !important;
            box-shadow: 0 10px 30px rgba(0,0,0,0.2) !important;
            min-width: 200px !important;
            padding: 8px 0 !important;
        }
        .header__menu ul .dropdown li a {
            padding: 12px 20px !important;
            font-size: 13px !important;
            font-weight: 600 !important;
            letter-spacing: 0.5px !important;
            color: rgba(255,255,255,0.7) !important;
            transition: all 0.2s !important;
            border-left: 3px solid transparent !important;
        }
        .header__menu ul .dropdown li a:hover {
            background: rgba(200,169,110,0.15) !important;
            color: #c8a96e !important;
            border-left: 3px solid #c8a96e !important;
            padding-left: 25px !important;
        }
        .header__menu ul .dropdown li.active a {
            background: #c8a96e !important;
            color: #111 !important;
            border-left: 3px solid #111 !important;
        }
        .header__menu ul .dropdown li.active a:hover {
            background: #c8a96e !important;
            color: #111 !important;
            padding-left: 20px !important;
        }

        /* Breadcrumb Design */
        .breacrumb-section {
            background: #f9f6f0;
            padding: 20px 0;
            margin-bottom: 10px;
            border-bottom: 1px solid #ebebeb;
        }
        .breadcrumb-text {
            display: flex;
            align-items: center;
            gap: 8px;
            flex-wrap: wrap;
        }
        .breadcrumb-text a {
            color: #c8a96e;
            text-decoration: none;
            font-size: 12px;
            font-weight: 700;
            letter-spacing: 1px;
            text-transform: uppercase;
            transition: color 0.3s;
        }
        .breadcrumb-text a:hover { color: #111; }
        .breadcrumb-text a::after {
            content: '›';
            margin-left: 8px;
            color: #ccc;
            font-weight: 400;
        }
        .breadcrumb-text span {
            font-size: 12px;
            font-weight: 700;
            letter-spacing: 1px;
            text-transform: uppercase;
            background: #111;
            color: #fff;
            padding: 4px 12px;
        }

        /* Category Filter Buttons */
        .filter-btn {
            background: #f0f0f0;
            color: #111;
            padding: 10px 24px;
            font-size: 11px;
            font-weight: 700;
            letter-spacing: 2px;
            text-transform: uppercase;
            text-decoration: none;
            border: 2px solid transparent;
            transition: all 0.3s;
            display: inline-block;
        }
        .filter-btn:hover {
            border-color: #c8a96e;
            color: #c8a96e;
        }
        .filter-btn.active {
            background: #111;
            color: #fff !important;
            border-color: #111;
        }
    </style>

    @stack('styles')

    @auth
        @if(Auth::user()->role === 'admin')
        <style>
            .admin__sidebar__overlay {
                position: fixed;
                top: 0;
                left: 0;
                width: 220px;
                height: 100vh;
                background: #111;
                z-index: 9999;
                display: flex;
                flex-direction: column;
                box-shadow: 3px 0 15px rgba(0,0,0,0.3);
                overflow-y: auto;
            }
            .admin__sidebar__brand {
                padding: 20px 15px;
                border-bottom: 1px solid rgba(255,255,255,0.1);
            }
            .admin__sidebar__brand h4 {
                font-size: 13px;
                font-weight: 800;
                color: #fff;
                letter-spacing: 2px;
                text-transform: uppercase;
                margin: 0;
            }
            .admin__sidebar__brand h4 span { color: #c8a96e; }
            .admin__sidebar__brand p {
                font-size: 10px;
                color: rgba(255,255,255,0.4);
                margin: 3px 0 0;
                letter-spacing: 1px;
            }
            .admin__sidebar__menu {
                padding: 15px 0;
                flex: 1;
            }
            .admin__sidebar__title {
                font-size: 9px;
                letter-spacing: 2px;
                text-transform: uppercase;
                color: rgba(255,255,255,0.3);
                padding: 8px 15px 4px;
                margin-top: 8px;
            }
            .admin__sidebar__menu a {
                display: flex;
                align-items: center;
                padding: 10px 15px;
                color: rgba(255,255,255,0.6);
                text-decoration: none;
                font-size: 12px;
                font-weight: 600;
                letter-spacing: 0.5px;
                transition: all 0.3s;
                gap: 8px;
            }
            .admin__sidebar__menu a:hover,
            .admin__sidebar__menu a.active-site {
                color: #fff;
                background: rgba(200,169,110,0.15);
                border-left: 3px solid #c8a96e;
            }
            .admin__sidebar__menu a i { width: 16px; font-size: 12px; }
            .admin__sidebar__logout {
                padding: 15px;
                border-top: 1px solid rgba(255,255,255,0.1);
            }
            .admin__sidebar__logout form button {
                width: 100%;
                background: rgba(255,255,255,0.1);
                border: none;
                color: rgba(255,255,255,0.6);
                padding: 8px;
                font-size: 11px;
                font-weight: 700;
                letter-spacing: 1px;
                text-transform: uppercase;
                cursor: pointer;
                transition: all 0.3s;
            }
            .admin__sidebar__logout form button:hover {
                background: #c8a96e;
                color: #111;
            }
            body { padding-left: 220px; }
        </style>
        @endif
    @endauth
</head>
<body>

    @auth
        @if(Auth::user()->role === 'admin')
        <div class="admin__sidebar__overlay">
            <div class="admin__sidebar__brand">
                <h4>Fashion <span>Admin</span></h4>
                <p>{{ Auth::user()->shop_name ?? 'Management Panel' }}</p>
            </div>
            <div class="admin__sidebar__menu">
                <div class="admin__sidebar__title">Admin Panel</div>
                <a href="{{ route('admin.dashboard') }}">
                    <i class="fa fa-tachometer"></i> Dashboard
                </a>
                <a href="{{ route('admin.products.index') }}">
                    <i class="fa fa-shopping-bag"></i> My Products
                </a>
                <a href="{{ route('admin.categories.index') }}">
                    <i class="fa fa-tags"></i> Categories
                </a>
                <a href="{{ route('admin.messages.index') }}">
                    <i class="fa fa-comments"></i> Messages
                    @php $unread = \App\Models\Message::whereIn('product_id', \App\Models\Product::where('seller_id', Auth::id())->pluck('id'))->where('is_read', false)->where('sender', 'user')->count(); @endphp
                    @if($unread > 0)
                        <span style="background:#e74c3c; color:#fff; border-radius:50%; width:16px; height:16px; font-size:9px; display:flex; align-items:center; justify-content:center; margin-left:auto;">{{ $unread }}</span>
                    @endif
                </a>
                <a href="{{ route('admin.users.index') }}">
                    <i class="fa fa-users"></i> Users
                </a>
                <a href="{{ route('admin.contact_messages.index') }}">
                    <i class="fa fa-envelope"></i> Contact Messages
                </a>

                <div class="admin__sidebar__title">Browsing</div>
                <a href="{{ route('home') }}" class="{{ request()->routeIs('home') ? 'active-site' : '' }}">
                    <i class="fa fa-home"></i> Home
                </a>
                <a href="{{ route('shop.index') }}" class="{{ request()->routeIs('shop.*') ? 'active-site' : '' }}">
                    <i class="fa fa-shopping-bag"></i> Shop
                </a>
                <a href="{{ route('contact') }}" class="{{ request()->routeIs('contact') ? 'active-site' : '' }}">
                    <i class="fa fa-envelope-o"></i> Contact
                </a>
            </div>
            <div class="admin__sidebar__logout">
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit">
                        <i class="fa fa-sign-out"></i> Sign Out
                    </button>
                </form>
            </div>
        </div>
        @endif
    @endauth

    <!-- Page Preloader -->
    <div id="preloder">
        <div class="loader"></div>
    </div>

    @include('partials.offcanvas')
    @include('partials.header')

    @yield('content')

    @include('partials.footer')

    <!-- Search Begin -->
    <div class="search-model">
        <div class="h-100 d-flex align-items-center justify-content-center">
            <div class="search-close-switch">+</div>
            <form class="search-model-form">
                <input type="text" id="search-input" placeholder="Search here.....">
            </form>
        </div>
    </div>
    <!-- Search End -->

    <script src="{{ asset('js/jquery-3.3.1.min.js') }}"></script>
    <script src="{{ asset('js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('js/jquery.nice-select.min.js') }}"></script>
    <script src="{{ asset('js/jquery.nicescroll.min.js') }}"></script>
    <script src="{{ asset('js/jquery.magnific-popup.min.js') }}"></script>
    <script src="{{ asset('js/jquery.countdown.min.js') }}"></script>
    <script src="{{ asset('js/jquery.slicknav.js') }}"></script>
    <script src="{{ asset('js/mixitup.min.js') }}"></script>
    <script src="{{ asset('js/owl.carousel.min.js') }}"></script>
    <script src="{{ asset('js/main.js') }}"></script>
    @stack('scripts')
</body>
</html>