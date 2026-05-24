<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Super Admin | Fashion Marketplace</title>
    <link href="https://fonts.googleapis.com/css2?family=Nunito+Sans:wght@300;400;600;700;800;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <style>
        * { margin:0; padding:0; box-sizing:border-box; }
        body { font-family:'Nunito Sans', sans-serif; background:#f5f5f5; display:flex; min-height:100vh; }

        /* Sidebar */
        .sa-sidebar { width:260px; background:#0a0a0a; min-height:100vh; position:fixed; left:0; top:0; z-index:100; display:flex; flex-direction:column; }
        .sa-sidebar__brand { padding:25px 20px; border-bottom:1px solid rgba(255,255,255,0.05); }
        .sa-sidebar__brand h2 { color:#fff; font-size:16px; font-weight:800; letter-spacing:2px; text-transform:uppercase; margin:0; }
        .sa-sidebar__brand h2 span { color:#e74c3c; }
        .sa-sidebar__brand p { color:rgba(255,255,255,0.3); font-size:10px; letter-spacing:3px; text-transform:uppercase; margin:4px 0 0; }

        .sa-sidebar__menu { padding:20px 0; flex:1; overflow-y:auto; }
        .sa-sidebar__menu__title { font-size:9px; letter-spacing:3px; text-transform:uppercase; color:rgba(255,255,255,0.2); padding:10px 20px 5px; font-weight:700; }

        .sa-sidebar__menu a { display:flex; align-items:center; gap:12px; padding:12px 20px; color:rgba(255,255,255,0.5); text-decoration:none; font-size:12px; font-weight:600; letter-spacing:1px; text-transform:uppercase; transition:all 0.3s; border-left:3px solid transparent; }
        .sa-sidebar__menu a:hover { color:#fff; background:rgba(255,255,255,0.05); border-left-color:rgba(231,76,60,0.5); }
        .sa-sidebar__menu a.active { color:#fff; background:rgba(231,76,60,0.1); border-left-color:#e74c3c; }
        .sa-sidebar__menu a i { width:16px; color:#e74c3c; }

        .sa-badge { background:#e74c3c; color:#fff; border-radius:50px; padding:1px 8px; font-size:9px; font-weight:700; margin-left:auto; }

        .sa-sidebar__footer { padding:20px; border-top:1px solid rgba(255,255,255,0.05); }
        .sa-sidebar__footer a { display:flex; align-items:center; gap:10px; color:rgba(255,255,255,0.3); text-decoration:none; font-size:11px; font-weight:600; letter-spacing:1px; text-transform:uppercase; transition:color 0.3s; }
        .sa-sidebar__footer a:hover { color:#e74c3c; }

        /* Main Content */
        .sa-main { margin-left:260px; flex:1; display:flex; flex-direction:column; }

        /* Top Bar */
        .sa-topbar { background:#fff; padding:15px 30px; display:flex; align-items:center; justify-content:space-between; box-shadow:0 1px 3px rgba(0,0,0,0.08); position:sticky; top:0; z-index:99; }
        .sa-topbar__title { font-size:20px; font-weight:800; color:#111; text-transform:uppercase; letter-spacing:2px; }
        .sa-topbar__user { display:flex; align-items:center; gap:10px; }
        .sa-topbar__user__avatar { width:35px; height:35px; background:#e74c3c; border-radius:50%; display:flex; align-items:center; justify-content:center; font-size:14px; font-weight:700; color:#fff; }
        .sa-topbar__user__info { font-size:12px; color:#111; font-weight:600; }
        .sa-topbar__user__role { font-size:10px; color:#e74c3c; font-weight:700; letter-spacing:1px; text-transform:uppercase; }

        /* Content Area */
        .sa-content { padding:30px; flex:1; }

        /* Cards */
        .sa-card { background:#fff; box-shadow:0 2px 15px rgba(0,0,0,0.06); margin-bottom:25px; }
        .sa-card__header { padding:18px 25px; border-bottom:1px solid #f0f0f0; display:flex; align-items:center; justify-content:space-between; }
        .sa-card__header h5 { font-size:12px; font-weight:800; letter-spacing:2px; text-transform:uppercase; color:#111; margin:0; }
        .sa-card__body { padding:25px; }

        /* Stat Cards */
        .sa-stat { background:#fff; padding:20px 25px; box-shadow:0 2px 15px rgba(0,0,0,0.06); border-left:4px solid; display:flex; align-items:center; gap:20px; }
        .sa-stat__icon { width:50px; height:50px; border-radius:50%; display:flex; align-items:center; justify-content:center; font-size:20px; flex-shrink:0; }
        .sa-stat__number { font-size:28px; font-weight:800; color:#111; line-height:1; }
        .sa-stat__label { font-size:11px; color:#999; font-weight:600; letter-spacing:1px; text-transform:uppercase; margin-top:4px; }

        /* Table */
        .sa-table { width:100%; border-collapse:collapse; }
        .sa-table th { font-size:10px; font-weight:700; letter-spacing:2px; text-transform:uppercase; color:#999; padding:12px 15px; text-align:left; border-bottom:2px solid #f0f0f0; }
        .sa-table td { padding:14px 15px; font-size:13px; color:#444; border-bottom:1px solid #f8f8f8; vertical-align:middle; }
        .sa-table tr:hover td { background:#fafafa; }

        /* Buttons */
        .sa-btn { padding:6px 14px; font-size:10px; font-weight:700; letter-spacing:1px; text-transform:uppercase; border:none; cursor:pointer; transition:all 0.3s; display:inline-flex; align-items:center; gap:5px; }
        .sa-btn-approve { background:#f0fdf4; color:#27ae60; border:1px solid #27ae60; }
        .sa-btn-approve:hover { background:#27ae60; color:#fff; }
        .sa-btn-ban { background:#fff8f0; color:#f39c12; border:1px solid #f39c12; }
        .sa-btn-ban:hover { background:#f39c12; color:#fff; }
        .sa-btn-delete { background:#fdf0f0; color:#e74c3c; border:1px solid #e74c3c; }
        .sa-btn-delete:hover { background:#e74c3c; color:#fff; }
        .sa-btn-reply { background:#f0f8ff; color:#2980b9; border:1px solid #2980b9; }
        .sa-btn-reply:hover { background:#2980b9; color:#fff; }
        .sa-btn-primary { background:#111; color:#fff; border:1px solid #111; }
        .sa-btn-primary:hover { background:#e74c3c; border-color:#e74c3c; }

        /* Badges */
        .badge-approved { background:#f0fdf4; color:#27ae60; padding:3px 10px; font-size:10px; font-weight:700; letter-spacing:1px; }
        .badge-pending { background:#fff8f0; color:#f39c12; padding:3px 10px; font-size:10px; font-weight:700; letter-spacing:1px; }
        .badge-banned { background:#fdf0f0; color:#e74c3c; padding:3px 10px; font-size:10px; font-weight:700; letter-spacing:1px; }
        .badge-seller { background:#f9f4ec; color:#c8a96e; padding:3px 10px; font-size:10px; font-weight:700; letter-spacing:1px; }
        .badge-buyer { background:#f0f0f0; color:#666; padding:3px 10px; font-size:10px; font-weight:700; letter-spacing:1px; }

        /* Modal */
        .sa-modal { display:none; position:fixed; top:0; left:0; width:100%; height:100%; background:rgba(0,0,0,0.6); z-index:9999; justify-content:center; align-items:center; }
        .sa-modal__box { background:#fff; width:100%; max-width:500px; max-height:90vh; overflow-y:auto; box-shadow:0 20px 60px rgba(0,0,0,0.3); }
        .sa-modal__header { background:#111; padding:20px 25px; display:flex; align-items:center; justify-content:space-between; position:sticky; top:0; }
        .sa-modal__header h5 { color:#fff; font-size:12px; font-weight:800; letter-spacing:2px; text-transform:uppercase; margin:0; }
        .sa-modal__header button { background:none; border:none; color:#fff; font-size:22px; cursor:pointer; padding:0; line-height:1; }
        .sa-modal__header button:hover { color:#e74c3c; }
        .sa-modal__body { padding:25px; }

        /* Success/Error alerts */
        .sa-alert-success { background:#f0fdf4; color:#27ae60; border-left:4px solid #27ae60; padding:12px 16px; margin-bottom:20px; font-size:13px; font-weight:600; display:none; }
        .sa-alert-error { background:#fdf0f0; color:#e74c3c; border-left:4px solid #e74c3c; padding:12px 16px; margin-bottom:20px; font-size:13px; display:none; }
    </style>
</head>
<body>

<!-- Sidebar -->
<div class="sa-sidebar">
    <div class="sa-sidebar__brand">
        <h2>Fashion <span>SA</span></h2>
        <p>Super Admin Panel</p>
    </div>

    <div class="sa-sidebar__menu">
        <div class="sa-sidebar__menu__title">Main</div>
        <a href="{{ route('superadmin.dashboard') }}" class="{{ request()->routeIs('superadmin.dashboard') ? 'active' : '' }}">
            <i class="fa fa-tachometer"></i> Dashboard
        </a>

        <div class="sa-sidebar__menu__title">Users</div>
        <a href="{{ route('superadmin.sellers') }}" class="{{ request()->routeIs('superadmin.sellers') ? 'active' : '' }}">
            <i class="fa fa-store"></i> Manage Sellers
            @php $pendingSellers = \App\Models\User::where('role','admin')->where('is_approved','pending')->count(); @endphp
            @if($pendingSellers > 0)
                <span class="sa-badge">{{ $pendingSellers }}</span>
            @endif
        </a>
        <a href="{{ route('superadmin.buyers') }}" class="{{ request()->routeIs('superadmin.buyers') ? 'active' : '' }}">
            <i class="fa fa-users"></i> Manage Buyers
        </a>

        <div class="sa-sidebar__menu__title">Catalog</div>
        <a href="{{ route('superadmin.products') }}" class="{{ request()->routeIs('superadmin.products') ? 'active' : '' }}">
            <i class="fa fa-shopping-bag"></i> All Products
        </a>
        <a href="{{ route('superadmin.categories') }}" class="{{ request()->routeIs('superadmin.categories') ? 'active' : '' }}">
            <i class="fa fa-tags"></i> All Categories
        </a>

        <div class="sa-sidebar__menu__title">Communications</div>
        <a href="{{ route('superadmin.messages') }}" class="{{ request()->routeIs('superadmin.messages') ? 'active' : '' }}">
            <i class="fa fa-comments"></i> All Inquiries
        </a>
        <a href="{{ route('superadmin.support') }}" class="{{ request()->routeIs('superadmin.support') ? 'active' : '' }}">
            <i class="fa fa-headphones"></i> Support Messages
            @php $unreadSupport = \App\Models\ContactMessage::where('is_read', false)->count(); @endphp
            @if($unreadSupport > 0)
                <span class="sa-badge">{{ $unreadSupport }}</span>
            @endif
        </a>
    </div>

    <div class="sa-sidebar__footer">
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" style="background:none; border:none; color:rgba(255,255,255,0.3); cursor:pointer; font-size:11px; font-weight:600; letter-spacing:1px; text-transform:uppercase; display:flex; align-items:center; gap:10px; padding:0; width:100%;"
                onmouseover="this.style.color='#e74c3c';" onmouseout="this.style.color='rgba(255,255,255,0.3)';">
                <i class="fa fa-sign-out"></i> Sign Out
            </button>
        </form>
    </div>
</div>

<!-- Main -->
<div class="sa-main">
    <!-- Top Bar -->
    <div class="sa-topbar">
        <div class="sa-topbar__title">@yield('page_title', 'Dashboard')</div>
        <div class="sa-topbar__user">
            <div class="sa-topbar__user__avatar">S</div>
            <div>
                <div class="sa-topbar__user__info">{{ Auth::user()->name }}</div>
                <div class="sa-topbar__user__role">Super Admin</div>
            </div>
        </div>
    </div>

    <!-- Content -->
    <div class="sa-content">
        @yield('content')
    </div>
</div>

<script src="{{ asset('js/jquery-3.3.1.min.js') }}"></script>
<script>
    $.ajaxSetup({
        headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') }
    });

    function showSuccess(msg) {
        $('.sa-alert-success').text(msg).show();
        setTimeout(() => $('.sa-alert-success').fadeOut(), 3000);
    }

    function showError(msg) {
        $('.sa-alert-error').text(msg).show();
        setTimeout(() => $('.sa-alert-error').fadeOut(), 3000);
    }

    // Close modals when clicking outside
    $(document).on('click', '.sa-modal', function(e) {
        if ($(e.target).is(this)) $(this).css('display', 'none');
    });
</script>
@stack('scripts')
</body>
</html>