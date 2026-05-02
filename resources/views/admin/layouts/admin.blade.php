<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Admin | Fashion Marketplace</title>
    <link href="https://fonts.googleapis.com/css2?family=Nunito+Sans:wght@300;400;600;700;800;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/font-awesome.min.css') }}">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'Nunito Sans', sans-serif; background: #f5f5f5; }

        /* Sidebar */
        .sidebar {
            width: 260px;
            background: #111;
            min-height: 100vh;
            position: fixed;
            top: 0; left: 0;
            z-index: 100;
            transition: all 0.3s;
        }
        .sidebar__brand {
            padding: 25px 20px;
            border-bottom: 1px solid rgba(255,255,255,0.1);
        }
        .sidebar__brand h2 {
            font-size: 16px;
            font-weight: 800;
            color: #fff;
            letter-spacing: 2px;
            text-transform: uppercase;
        }
        .sidebar__brand h2 span { color: #c8a96e; }
        .sidebar__brand p {
            font-size: 11px;
            color: rgba(255,255,255,0.4);
            margin-top: 3px;
            letter-spacing: 1px;
        }
        .sidebar__menu {
            padding: 20px 0;
        }
        .sidebar__menu__title {
            font-size: 10px;
            letter-spacing: 2px;
            text-transform: uppercase;
            color: rgba(255,255,255,0.3);
            padding: 10px 20px 5px;
            margin-top: 10px;
        }
        .sidebar__menu a {
            display: flex;
            align-items: center;
            padding: 12px 20px;
            color: rgba(255,255,255,0.6);
            text-decoration: none;
            font-size: 13px;
            font-weight: 600;
            letter-spacing: 0.5px;
            transition: all 0.3s;
            gap: 10px;
        }
        .sidebar__menu a:hover,
        .sidebar__menu a.active {
            color: #fff;
            background: rgba(200,169,110,0.15);
            border-left: 3px solid #c8a96e;
        }
        .sidebar__menu a i { width: 20px; font-size: 14px; }

        /* Main Content */
        .main__content {
            margin-left: 260px;
            min-height: 100vh;
        }

        /* Topbar */
        .topbar {
            background: #fff;
            padding: 15px 30px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            box-shadow: 0 2px 10px rgba(0,0,0,0.05);
        }
        .topbar__title {
            font-size: 18px;
            font-weight: 800;
            color: #111;
            letter-spacing: 1px;
            text-transform: uppercase;
        }
        .topbar__user {
            display: flex;
            align-items: center;
            gap: 15px;
        }
        .topbar__user span {
            font-size: 13px;
            color: #666;
        }
        .topbar__user strong { color: #111; }
        .btn-logout {
            background: #111;
            color: #fff;
            border: none;
            padding: 8px 20px;
            font-size: 11px;
            font-weight: 700;
            letter-spacing: 2px;
            text-transform: uppercase;
            cursor: pointer;
            transition: background 0.3s;
        }
        .btn-logout:hover { background: #c8a96e; }

        /* Content Area */
        .content__area {
            padding: 30px;
        }

        /* Cards */
        .stat__card {
            background: #fff;
            padding: 25px;
            border-radius: 0;
            box-shadow: 0 2px 10px rgba(0,0,0,0.05);
            border-left: 4px solid #c8a96e;
            margin-bottom: 20px;
        }
        .stat__card h3 {
            font-size: 32px;
            font-weight: 800;
            color: #111;
            margin-bottom: 5px;
        }
        .stat__card p {
            font-size: 12px;
            letter-spacing: 2px;
            text-transform: uppercase;
            color: #999;
            margin: 0;
        }
        .stat__card i {
            font-size: 28px;
            color: #c8a96e;
            opacity: 0.5;
        }

        /* Tables */
        .admin__card {
            background: #fff;
            box-shadow: 0 2px 10px rgba(0,0,0,0.05);
            margin-bottom: 30px;
        }
        .admin__card__header {
            padding: 20px 25px;
            border-bottom: 1px solid #f0f0f0;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }
        .admin__card__header h5 {
            font-size: 13px;
            font-weight: 800;
            letter-spacing: 2px;
            text-transform: uppercase;
            color: #111;
            margin: 0;
        }
        .admin__card__body { padding: 25px; }
        .table th {
            font-size: 11px;
            letter-spacing: 2px;
            text-transform: uppercase;
            color: #999;
            font-weight: 700;
            border-bottom: 2px solid #f0f0f0;
            padding: 12px 15px;
        }
        .table td {
            font-size: 13px;
            color: #444;
            padding: 12px 15px;
            vertical-align: middle;
            border-bottom: 1px solid #f8f8f8;
        }
        .btn-admin {
            padding: 6px 14px;
            font-size: 11px;
            font-weight: 700;
            letter-spacing: 1px;
            text-transform: uppercase;
            border: none;
            cursor: pointer;
            transition: all 0.3s;
        }
        .btn-add {
            background: #111;
            color: #fff;
            padding: 10px 20px;
            font-size: 11px;
            font-weight: 700;
            letter-spacing: 2px;
            text-transform: uppercase;
            border: none;
            cursor: pointer;
            transition: background 0.3s;
        }
        .btn-add:hover { background: #c8a96e; color: #fff; }
        .btn-edit { background: #f0f0f0; color: #111; }
        .btn-edit:hover { background: #c8a96e; color: #fff; }
        .btn-delete { background: #fff0f0; color: #e74c3c; }
        .btn-delete:hover { background: #e74c3c; color: #fff; }
        .btn-view { background: #f0f8ff; color: #3498db; }
        .btn-view:hover { background: #3498db; color: #fff; }

        /* Badge */
        .badge-available {
            background: #f0fdf4;
            color: #27ae60;
            padding: 4px 10px;
            font-size: 11px;
            font-weight: 700;
            letter-spacing: 1px;
        }
        .badge-unavailable {
            background: #fdf0f0;
            color: #e74c3c;
            padding: 4px 10px;
            font-size: 11px;
            font-weight: 700;
            letter-spacing: 1px;
        }
        .badge-mens { background: #e8f4fd; color: #2980b9; padding: 4px 10px; font-size: 11px; font-weight: 700; }
        .badge-womens { background: #fdf0f8; color: #e91e8c; padding: 4px 10px; font-size: 11px; font-weight: 700; }
        .badge-kids { background: #f0fdf4; color: #27ae60; padding: 4px 10px; font-size: 11px; font-weight: 700; }

        /* Modal */
        .modal-content { border-radius: 0; border: none; }
        .modal-header {
            background: #111;
            color: #fff;
            border-radius: 0;
            padding: 20px 25px;
        }
        .modal-header .btn-close { filter: invert(1); }
        .modal-title { font-size: 13px; font-weight: 800; letter-spacing: 2px; text-transform: uppercase; }
        .modal-body { padding: 25px; }
        .modal-footer { padding: 15px 25px; border-top: 1px solid #f0f0f0; }
        .form-label { font-size: 11px; font-weight: 700; letter-spacing: 1px; text-transform: uppercase; color: #111; }
        .form-control, .form-select {
            border: 1px solid #e8e8e8;
            border-radius: 0;
            padding: 10px 14px;
            font-size: 13px;
        }
        .form-control:focus, .form-select:focus {
            border-color: #111;
            box-shadow: none;
        }
        .alert { border-radius: 0; font-size: 13px; border: none; }
        .alert-danger { background: #fdf0f0; color: #e74c3c; }
        .alert-success { background: #f0fdf4; color: #27ae60; }

        /* Product Image */
        .product__img {
            width: 50px;
            height: 50px;
            object-fit: cover;
            border: 1px solid #f0f0f0;
        }
        .product__img__placeholder {
            width: 50px;
            height: 50px;
            background: #f5f5f5;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #ccc;
            font-size: 20px;
        }
    </style>
    @stack('styles')
</head>
<body>

    <!-- Sidebar -->
    <div class="sidebar">
        <div class="sidebar__brand">
            <h2>Fashion <span>Admin</span></h2>
            <p>Management Panel</p>
        </div>
        <div class="sidebar__menu">
            <div class="sidebar__menu__title">Main</div>
            <a href="{{ route('admin.dashboard') }}" class="{{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                <i class="fa fa-home"></i> Dashboard
            </a>

            <div class="sidebar__menu__title">Catalog</div>
            <a href="{{ route('admin.categories.index') }}" class="{{ request()->routeIs('admin.categories.*') ? 'active' : '' }}">
                <i class="fa fa-tags"></i> Categories
            </a>
            <a href="{{ route('admin.products.index') }}" class="{{ request()->routeIs('admin.products.*') ? 'active' : '' }}">
                <i class="fa fa-shopping-bag"></i> Products
            </a>

            <div class="sidebar__menu__title">Management</div>
            <a href="{{ route('admin.users.index') }}" class="{{ request()->routeIs('admin.users.*') ? 'active' : '' }}">
                <i class="fa fa-users"></i> Users
            </a>
            <a href="{{ route('admin.messages.index') }}" class="{{ request()->routeIs('admin.messages.*') ? 'active' : '' }}">
                <i class="fa fa-comments"></i> Product Inquiries
                @php $unread = \App\Models\Message::where('is_read', false)->where('sender', 'user')->count(); @endphp
                @if($unread > 0)
                    <span style="background:#e74c3c; color:#fff; border-radius:50%; width:18px; height:18px; font-size:10px; display:flex; align-items:center; justify-content:center; margin-left:auto;">{{ $unread }}</span>
                @endif
            </a>

            {{-- ← Contact Messages added here --}}
            <a href="{{ route('admin.contact_messages.index') }}" class="{{ request()->routeIs('admin.contact_messages.*') ? 'active' : '' }}">
                <i class="fa fa-headphones"></i> Customer Support
                @php $unreadContact = \App\Models\ContactMessage::where('is_read', false)->count(); @endphp
                @if($unreadContact > 0)
                    <span style="background:#e74c3c; color:#fff; border-radius:50%; width:18px; height:18px; font-size:10px; display:flex; align-items:center; justify-content:center; margin-left:auto;">{{ $unreadContact }}</span>
                @endif
            </a>

            <div class="sidebar__menu__title">Account</div>
            <a href="{{ route('home') }}">
                <i class="fa fa-eye"></i> View Site
            </a>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" style="width:100%; background:none; border:none; text-align:left; cursor:pointer;">
                    <a href="#" onclick="event.preventDefault(); this.closest('form').submit();" style="color:rgba(255,255,255,0.6);">
                        <i class="fa fa-sign-out"></i> Sign Out
                    </a>
                </button>
            </form>
        </div>
    </div>

    <!-- Main Content -->
    <div class="main__content">
        <!-- Topbar -->
        <div class="topbar">
            <div class="topbar__title">@yield('page_title', 'Dashboard')</div>
            <div class="topbar__user">
                <span>Welcome, <strong>{{ Auth::user()->name }}</strong></span>
            </div>
        </div>

        <!-- Content -->
        <div class="content__area">
            @yield('content')
        </div>
    </div>

    <script src="{{ asset('js/jquery-3.3.1.min.js') }}"></script>
    <script src="{{ asset('js/bootstrap.min.js') }}"></script>
    @stack('scripts')
</body>
</html>