<!-- Header Section Begin -->
<header class="header">
    <div class="header__top">
        <div class="container">
            <div class="row">
                <div class="col-lg-6 col-md-7">
                    <div class="header__top__left">
                        <p>Free shipping, 30-day return or refund guarantee.</p>
                    </div>
                </div>
                <div class="col-lg-6 col-md-5">
                    <div class="header__top__right">
                        <div class="header__top__links">
                            @auth
                                <div style="display:flex; align-items:center; gap:15px;">
                                    <!-- User Icon & Name -->
                                    <div style="display:flex; align-items:center; gap:8px;">
                                        <div style="width:28px; height:28px; background:#c8a96e; border-radius:50%; display:flex; align-items:center; justify-content:center;">
                                            <i class="fa fa-user" style="font-size:12px; color:#111;"></i>
                                        </div>
                                        <span style="color:#fff; font-size:13px; font-weight:600; letter-spacing:0.5px;">
                                            {{ Auth::user()->name }}
                                        </span>
                                    </div>

                                    <!-- Divider -->
                                    <span style="color:rgba(255,255,255,0.3);">|</span>

                                    <!-- Sign Out Button -->
                                    <form method="POST" action="{{ route('logout') }}" style="display:inline">
                                        @csrf
                                        <button type="submit"
                                            style="background:rgba(200,169,110,0.2); border:1px solid #c8a96e; color:#c8a96e; cursor:pointer; padding:5px 14px; font-size:11px; font-weight:700; letter-spacing:1px; text-transform:uppercase; transition:all 0.3s;"
                                            onmouseover="this.style.background='#c8a96e'; this.style.color='#111';"
                                            onmouseout="this.style.background='rgba(200,169,110,0.2)'; this.style.color='#c8a96e';">
                                            <i class="fa fa-sign-out" style="margin-right:5px;"></i> Sign Out
                                        </button>
                                    </form>
                                </div>
                            @else
                                <a href="{{ route('login') }}" style="color:#fff; font-size:13px; font-weight:600; letter-spacing:0.5px; text-decoration:none; transition:color 0.3s;"
                                    onmouseover="this.style.color='#c8a96e';"
                                    onmouseout="this.style.color='#fff';">
                                    <i class="fa fa-sign-in" style="margin-right:5px;"></i> Sign In
                                </a>
                                <span style="color:rgba(255,255,255,0.3); margin:0 5px;">|</span>
                                <a href="{{ route('register') }}" style="color:#c8a96e; font-size:13px; font-weight:700; letter-spacing:0.5px; text-decoration:none; transition:color 0.3s;"
                                    onmouseover="this.style.color='#fff';"
                                    onmouseout="this.style.color='#c8a96e';">
                                    <i class="fa fa-user-plus" style="margin-right:5px;"></i> Register
                                </a>
                            @endauth
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="container">
        <div class="row">
            <div class="col-lg-3 col-md-3">
                <div class="header__logo">
                    <a href="{{ route('home') }}" style="text-decoration:none; font-size:24px; font-weight:800; color:#111; letter-spacing:2px; text-transform:uppercase;">Fashion <span style="color:#c8a96e;">Marketplace</span></a>
                </div>
            </div>
            <div class="col-lg-9 col-md-9">
                <nav class="header__menu mobile-menu">
                    <ul>
                        <li class="{{ request()->routeIs('home') ? 'active' : '' }}">
                            <a href="{{ route('home') }}">Home</a>
                        </li>
                        <li class="{{ request()->routeIs('shop.*') ? 'active' : '' }}">
                            <a href="{{ route('shop.index') }}">Shop</a>
                            <ul class="dropdown">
                                <li class="{{ request()->routeIs('shop.mens') ? 'active' : '' }}">
                                    <a href="{{ route('shop.mens') }}"
                                        style="{{ request()->routeIs('shop.mens') ? 'background:#c8a96e; color:#fff;' : '' }}">
                                        <i class="fa fa-male" style="margin-right:8px;"></i> Men's Clothing
                                    </a>
                                </li>
                                <li class="{{ request()->routeIs('shop.womens') ? 'active' : '' }}">
                                    <a href="{{ route('shop.womens') }}"
                                        style="{{ request()->routeIs('shop.womens') ? 'background:#c8a96e; color:#fff;' : '' }}">
                                        <i class="fa fa-female" style="margin-right:8px;"></i> Women's Clothing
                                    </a>
                                </li>
                                <li class="{{ request()->routeIs('shop.kids') ? 'active' : '' }}">
                                    <a href="{{ route('shop.kids') }}"
                                        style="{{ request()->routeIs('shop.kids') ? 'background:#c8a96e; color:#fff;' : '' }}">
                                        <i class="fa fa-child" style="margin-right:8px;"></i> Kids' Clothing
                                    </a>
                                </li>
                            </ul>
                        </li>
                        <li class="{{ request()->routeIs('contact') ? 'active' : '' }}">
                            <a href="{{ route('contact') }}">Contact</a>
                        </li>
                    </ul>
                </nav>
            </div>
        </div>
        <div class="canvas__open"><i class="fa fa-bars"></i></div>
    </div>
</header>
<!-- Header Section End -->