@extends('layouts.app')

@section('content')

<!-- Breadcrumb -->
<div class="breacrumb-section">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="breadcrumb-text">
                    <a href="{{ route('home') }}"><i class="fa fa-home"></i> Home</a>
                    <span>My Profile</span>
                </div>
            </div>
        </div>
    </div>
</div>

<section class="spad">
    <div class="container">

        @if(session('success'))
            <div style="background:#f0fdf4; color:#27ae60; padding:14px 20px; margin-bottom:25px; border-left:4px solid #27ae60; font-size:13px; font-weight:600;">
                <i class="fa fa-check-circle"></i> {{ session('success') }}
            </div>
        @endif
        @if(session('error'))
            <div style="background:#fdf0f0; color:#e74c3c; padding:14px 20px; margin-bottom:25px; border-left:4px solid #e74c3c; font-size:13px; font-weight:600;">
                <i class="fa fa-exclamation-circle"></i> {{ session('error') }}
            </div>
        @endif

        <div class="row">

            <!-- Left Sidebar -->
            <div class="col-lg-3 col-md-4 mb-4">

                <!-- Profile Card -->
                <div style="background:#111; padding:30px 20px; text-align:center; margin-bottom:15px;">

                    <!-- Profile Photo -->
                    <div style="position:relative; display:inline-block; margin-bottom:15px;">
                        @if($user->profile_photo)
                            <img src="{{ asset($user->profile_photo) }}"
                                style="width:90px; height:90px; border-radius:50%; object-fit:cover; border:3px solid #c8a96e;"
                                alt="{{ $user->name }}">
                        @elseif($user->profile_photo_url)
                            <img src="{{ $user->profile_photo_url }}"
                                style="width:90px; height:90px; border-radius:50%; object-fit:cover; border:3px solid #c8a96e;"
                                alt="{{ $user->name }}">
                        @else
                            <div style="width:90px; height:90px; background:linear-gradient(135deg, #c8a96e, #8b6914); border-radius:50%; display:flex; align-items:center; justify-content:center; font-size:36px; font-weight:800; color:#fff; margin:0 auto;">
                                {{ strtoupper(substr($user->name, 0, 1)) }}
                            </div>
                        @endif

                        <!-- Upload Photo Button -->
                        <label for="quick_photo" title="Change photo"
                            style="position:absolute; bottom:0; right:0; width:28px; height:28px; background:#c8a96e; border-radius:50%; display:flex; align-items:center; justify-content:center; cursor:pointer; border:2px solid #111;">
                            <i class="fa fa-camera" style="color:#111; font-size:11px;"></i>
                        </label>
                    </div>

                    <div style="color:#fff; font-size:15px; font-weight:700; margin-bottom:4px;">{{ $user->name }}</div>
                    <div style="color:rgba(255,255,255,0.4); font-size:12px; margin-bottom:12px;">{{ $user->email }}</div>

                    @if($user->role === 'admin')
                        <span style="background:#c8a96e; color:#111; padding:3px 14px; font-size:10px; font-weight:700; letter-spacing:2px; text-transform:uppercase;">
                            SELLER
                        </span>
                    @else
                        <span style="background:rgba(255,255,255,0.1); color:rgba(255,255,255,0.6); padding:3px 14px; font-size:10px; font-weight:700; letter-spacing:2px; text-transform:uppercase;">
                            BUYER
                        </span>
                    @endif

                    <div style="margin-top:15px; padding-top:15px; border-top:1px solid rgba(255,255,255,0.1); font-size:11px; color:rgba(255,255,255,0.3); letter-spacing:1px;">
                        ID: #{{ str_pad($user->id, 4, '0', STR_PAD_LEFT) }}
                    </div>
                </div>

                <!-- Sidebar Menu -->
                <div style="background:#fff; box-shadow:0 2px 15px rgba(0,0,0,0.06);">
                    <button onclick="showTab('personal')" id="tab-personal"
                        style="width:100%; text-align:left; padding:14px 20px; border:none; border-left:3px solid #111; background:#f9f9f9; font-size:12px; font-weight:700; letter-spacing:1px; text-transform:uppercase; color:#111; cursor:pointer; display:flex; align-items:center; gap:10px;">
                        <i class="fa fa-user" style="color:#c8a96e; width:16px;"></i> Personal Info
                    </button>

                    @if($user->role === 'user')
                    <button onclick="showTab('upgrade')" id="tab-upgrade"
                        style="width:100%; text-align:left; padding:14px 20px; border:none; border-left:3px solid transparent; background:#fff; font-size:12px; font-weight:700; letter-spacing:1px; text-transform:uppercase; color:#666; cursor:pointer; display:flex; align-items:center; gap:10px; border-top:1px solid #f0f0f0;">
                        <i class="fa fa-store" style="color:#c8a96e; width:16px;"></i> Become a Seller
                    </button>
                    @endif

                    @if($user->role === 'admin')
                    <button onclick="showTab('shop')" id="tab-shop"
                        style="width:100%; text-align:left; padding:14px 20px; border:none; border-left:3px solid transparent; background:#fff; font-size:12px; font-weight:700; letter-spacing:1px; text-transform:uppercase; color:#666; cursor:pointer; display:flex; align-items:center; gap:10px; border-top:1px solid #f0f0f0;">
                        <i class="fa fa-store" style="color:#c8a96e; width:16px;"></i> My Shop
                    </button>
                    <a href="{{ route('admin.dashboard') }}"
                        style="width:100%; text-align:left; padding:14px 20px; border:none; border-left:3px solid transparent; background:#fff; font-size:12px; font-weight:700; letter-spacing:1px; text-transform:uppercase; color:#666; cursor:pointer; display:flex; align-items:center; gap:10px; border-top:1px solid #f0f0f0; text-decoration:none;">
                        <i class="fa fa-tachometer" style="color:#c8a96e; width:16px;"></i> Admin Panel
                    </a>
                    @endif
                </div>
            </div>

            <!-- Right Content -->
            <div class="col-lg-9 col-md-8">

                <!-- Personal Info Tab -->
                <div id="section-personal">
                    <div style="background:#fff; box-shadow:0 2px 15px rgba(0,0,0,0.06);">
                        <div style="padding:20px 30px; border-bottom:1px solid #f0f0f0;">
                            <h5 style="font-size:13px; font-weight:800; letter-spacing:2px; text-transform:uppercase; color:#111; margin:0;">
                                <i class="fa fa-user" style="color:#c8a96e; margin-right:8px;"></i> Personal Information
                            </h5>
                            <p style="font-size:12px; color:#999; margin:5px 0 0;">Update your personal details and profile photo</p>
                        </div>

                        <form method="POST" action="{{ route('profile.update') }}" enctype="multipart/form-data" style="padding:30px;">
                            @csrf

                            @if($errors->any())
                                <div style="background:#fdf0f0; color:#e74c3c; padding:14px 20px; margin-bottom:20px; border-left:4px solid #e74c3c; font-size:13px;">
                                    @foreach($errors->all() as $error)
                                        <div><i class="fa fa-exclamation-circle"></i> {{ $error }}</div>
                                    @endforeach
                                </div>
                            @endif

                            <!-- Profile Photo Upload -->
                            <div style="margin-bottom:25px; padding-bottom:25px; border-bottom:1px solid #f0f0f0;">
                                <label style="font-size:11px; font-weight:700; letter-spacing:1px; text-transform:uppercase; color:#111; display:block; margin-bottom:12px;">
                                    Profile Photo <span style="font-style:italic; color:#999; font-weight:400; letter-spacing:0; text-transform:none;">(optional)</span>
                                </label>
                                <div style="display:flex; align-items:center; gap:20px; flex-wrap:wrap;">
                                    <!-- Current Photo Preview -->
                                    <div id="photo-preview-container">
                                        @if($user->profile_photo)
                                            <img id="photo-preview" src="{{ asset($user->profile_photo) }}"
                                                style="width:80px; height:80px; border-radius:50%; object-fit:cover; border:3px solid #c8a96e;">
                                        @elseif($user->profile_photo_url)
                                            <img id="photo-preview" src="{{ $user->profile_photo_url }}"
                                                style="width:80px; height:80px; border-radius:50%; object-fit:cover; border:3px solid #c8a96e;">
                                        @else
                                            <div id="photo-preview-placeholder" style="width:80px; height:80px; background:linear-gradient(135deg, #c8a96e, #8b6914); border-radius:50%; display:flex; align-items:center; justify-content:center; font-size:28px; font-weight:800; color:#fff;">
                                                {{ strtoupper(substr($user->name, 0, 1)) }}
                                            </div>
                                            <img id="photo-preview" src="" style="width:80px; height:80px; border-radius:50%; object-fit:cover; border:3px solid #c8a96e; display:none;">
                                        @endif
                                    </div>
                                    <div>
                                        <label for="quick_photo"
                                            style="background:#f0f0f0; color:#111; border:none; padding:10px 20px; font-size:11px; font-weight:700; letter-spacing:1px; text-transform:uppercase; cursor:pointer; display:inline-flex; align-items:center; gap:8px; transition:background 0.3s;"
                                            onmouseover="this.style.background='#ddd';" onmouseout="this.style.background='#f0f0f0';">
                                            <i class="fa fa-camera"></i> Choose Photo
                                        </label>
                                        <input type="file" name="profile_photo" id="quick_photo" accept="image/*"
                                            style="display:none;" onchange="previewPhoto(this)">
                                        <p style="font-size:11px; color:#999; margin-top:8px; margin-bottom:0;">
                                            JPG, PNG, GIF (max 2MB). Leave empty to keep current photo.
                                        </p>
                                    </div>
                                </div>
                            </div>

                            <!-- Fields -->
                            <div class="row">
                                <div class="col-md-6 mb-4">
                                    <label style="font-size:11px; font-weight:700; letter-spacing:1px; text-transform:uppercase; color:#111; display:block; margin-bottom:8px;">
                                        Full Name <span style="color:#e74c3c;">*</span>
                                    </label>
                                    <input type="text" name="name" value="{{ old('name', $user->name) }}"
                                        style="width:100%; border:1px solid #e8e8e8; padding:12px 15px; font-size:13px; outline:none; transition:border 0.3s; font-family:inherit;"
                                        onfocus="this.style.borderColor='#111';" onblur="this.style.borderColor='#e8e8e8';"
                                        required>
                                </div>
                                <div class="col-md-6 mb-4">
                                    <label style="font-size:11px; font-weight:700; letter-spacing:1px; text-transform:uppercase; color:#111; display:block; margin-bottom:8px;">
                                        Email Address <span style="color:#e74c3c;">*</span>
                                    </label>
                                    <input type="email" name="email" value="{{ old('email', $user->email) }}"
                                        style="width:100%; border:1px solid #e8e8e8; padding:12px 15px; font-size:13px; outline:none; transition:border 0.3s; font-family:inherit;"
                                        onfocus="this.style.borderColor='#111';" onblur="this.style.borderColor='#e8e8e8';"
                                        required>
                                </div>
                                <div class="col-md-6 mb-4">
                                    <label style="font-size:11px; font-weight:700; letter-spacing:1px; text-transform:uppercase; color:#111; display:block; margin-bottom:8px;">
                                        Phone Number
                                    </label>
                                    <input type="text" name="phone" value="{{ old('phone', $user->phone) }}"
                                        placeholder="e.g. 09123456789"
                                        style="width:100%; border:1px solid #e8e8e8; padding:12px 15px; font-size:13px; outline:none; transition:border 0.3s; font-family:inherit;"
                                        onfocus="this.style.borderColor='#111';" onblur="this.style.borderColor='#e8e8e8';">
                                </div>
                                <div class="col-md-6 mb-4">
                                    <label style="font-size:11px; font-weight:700; letter-spacing:1px; text-transform:uppercase; color:#111; display:block; margin-bottom:8px;">
                                        Address
                                    </label>
                                    <input type="text" name="address" value="{{ old('address', $user->address) }}"
                                        placeholder="e.g. Davao City, Philippines"
                                        style="width:100%; border:1px solid #e8e8e8; padding:12px 15px; font-size:13px; outline:none; transition:border 0.3s; font-family:inherit;"
                                        onfocus="this.style.borderColor='#111';" onblur="this.style.borderColor='#e8e8e8';">
                                </div>
                            </div>

                            <div style="background:#f9f9f9; padding:12px 18px; margin-bottom:20px; font-size:12px; color:#999; border-left:3px solid #e8e8e8;">
                                <i class="fa fa-info-circle" style="color:#c8a96e;"></i>
                                Your information is private. You can stay anonymous if you prefer.
                            </div>

                            <div style="display:flex; justify-content:flex-end;">
                                <button type="submit"
                                    style="background:#111; color:#fff; border:none; padding:14px 40px; font-size:11px; font-weight:700; letter-spacing:3px; text-transform:uppercase; cursor:pointer; transition:background 0.3s;"
                                    onmouseover="this.style.background='#c8a96e';" onmouseout="this.style.background='#111';">
                                    <i class="fa fa-save"></i> Save Changes
                                </button>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Become a Seller Tab (buyers only) -->
                @if($user->role === 'user')
                <div id="section-upgrade" style="display:none;">
                    <div style="background:#fff; box-shadow:0 2px 15px rgba(0,0,0,0.06);">
                        <div style="padding:20px 30px; border-bottom:1px solid #f0f0f0;">
                            <h5 style="font-size:13px; font-weight:800; letter-spacing:2px; text-transform:uppercase; color:#111; margin:0;">
                                <i class="fa fa-store" style="color:#c8a96e; margin-right:8px;"></i> Become a Seller
                            </h5>
                            <p style="font-size:12px; color:#999; margin:5px 0 0;">Upgrade your account to start selling products</p>
                        </div>
                        <div style="padding:30px;">
                            <div style="background:#f9f4ec; padding:20px 25px; margin-bottom:25px; border-left:3px solid #c8a96e; display:flex; gap:15px; align-items:flex-start;">
                                <i class="fa fa-store" style="color:#c8a96e; font-size:24px; flex-shrink:0; margin-top:3px;"></i>
                                <div>
                                    <p style="font-size:14px; font-weight:700; color:#111; margin-bottom:5px;">Want to sell on Fashion Marketplace?</p>
                                    <p style="font-size:13px; color:#666; margin:0; line-height:1.6;">Upgrade your account to a Seller account and start listing your products. Enter your shop details below to get started.</p>
                                </div>
                            </div>
                            <form method="POST" action="{{ route('profile.upgrade') }}">
                                @csrf
                                <div class="mb-4">
                                    <label style="font-size:11px; font-weight:700; letter-spacing:1px; text-transform:uppercase; color:#111; display:block; margin-bottom:8px;">
                                        Shop Name <span style="color:#e74c3c;">*</span>
                                    </label>
                                    <input type="text" name="shop_name"
                                        placeholder="Enter your shop name"
                                        value="{{ old('shop_name') }}"
                                        style="width:100%; border:1px solid #e8e8e8; padding:12px 15px; font-size:13px; outline:none; transition:border 0.3s; font-family:inherit;"
                                        onfocus="this.style.borderColor='#111';" onblur="this.style.borderColor='#e8e8e8';"
                                        required>
                                </div>
                                <div class="mb-4">
                                    <label style="font-size:11px; font-weight:700; letter-spacing:1px; text-transform:uppercase; color:#111; display:block; margin-bottom:8px;">
                                        Shop Description
                                    </label>
                                    <input type="text" name="shop_description"
                                        placeholder="Brief description of your shop"
                                        value="{{ old('shop_description') }}"
                                        style="width:100%; border:1px solid #e8e8e8; padding:12px 15px; font-size:13px; outline:none; transition:border 0.3s; font-family:inherit;"
                                        onfocus="this.style.borderColor='#111';" onblur="this.style.borderColor='#e8e8e8';">
                                </div>
                                <div style="display:flex; justify-content:flex-end;">
                                    <button type="submit"
                                        style="background:#c8a96e; color:#111; border:none; padding:14px 40px; font-size:11px; font-weight:700; letter-spacing:3px; text-transform:uppercase; cursor:pointer; transition:all 0.3s;"
                                        onmouseover="this.style.background='#111'; this.style.color='#fff';"
                                        onmouseout="this.style.background='#c8a96e'; this.style.color='#111';">
                                        <i class="fa fa-store"></i> Upgrade to Seller
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                @endif

                <!-- My Shop Tab (sellers only) -->
                @if($user->role === 'admin')
                <div id="section-shop" style="display:none;">
                    <div style="background:#fff; box-shadow:0 2px 15px rgba(0,0,0,0.06);">
                        <div style="padding:20px 30px; border-bottom:1px solid #f0f0f0;">
                            <h5 style="font-size:13px; font-weight:800; letter-spacing:2px; text-transform:uppercase; color:#111; margin:0;">
                                <i class="fa fa-store" style="color:#c8a96e; margin-right:8px;"></i> My Shop
                            </h5>
                            <p style="font-size:12px; color:#999; margin:5px 0 0;">Update your shop information</p>
                        </div>
                        <form method="POST" action="{{ route('profile.update') }}" style="padding:30px;">
                            @csrf
                            <input type="hidden" name="name" value="{{ $user->name }}">
                            <input type="hidden" name="email" value="{{ $user->email }}">
                            <div class="mb-4">
                                <label style="font-size:11px; font-weight:700; letter-spacing:1px; text-transform:uppercase; color:#111; display:block; margin-bottom:8px;">
                                    Shop Name
                                </label>
                                <input type="text" name="shop_name"
                                    value="{{ old('shop_name', $user->shop_name) }}"
                                    placeholder="Enter your shop name"
                                    style="width:100%; border:1px solid #e8e8e8; padding:12px 15px; font-size:13px; outline:none; transition:border 0.3s; font-family:inherit;"
                                    onfocus="this.style.borderColor='#111';" onblur="this.style.borderColor='#e8e8e8';">
                            </div>
                            <div class="mb-4">
                                <label style="font-size:11px; font-weight:700; letter-spacing:1px; text-transform:uppercase; color:#111; display:block; margin-bottom:8px;">
                                    Shop Description
                                </label>
                                <input type="text" name="shop_description"
                                    value="{{ old('shop_description', $user->shop_description) }}"
                                    placeholder="Brief description of your shop"
                                    style="width:100%; border:1px solid #e8e8e8; padding:12px 15px; font-size:13px; outline:none; transition:border 0.3s; font-family:inherit;"
                                    onfocus="this.style.borderColor='#111';" onblur="this.style.borderColor='#e8e8e8';">
                            </div>
                            <div style="display:flex; justify-content:flex-end;">
                                <button type="submit"
                                    style="background:#111; color:#fff; border:none; padding:14px 40px; font-size:11px; font-weight:700; letter-spacing:3px; text-transform:uppercase; cursor:pointer; transition:background 0.3s;"
                                    onmouseover="this.style.background='#c8a96e';" onmouseout="this.style.background='#111';">
                                    <i class="fa fa-save"></i> Update Shop
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
                @endif

            </div>
        </div>
    </div>
</section>

<script>
    function showTab(tab) {
        const sections = ['personal', 'upgrade', 'shop'];
        const tabs = ['personal', 'upgrade', 'shop'];

        sections.forEach(function(s) {
            const section = document.getElementById('section-' + s);
            const tabBtn  = document.getElementById('tab-' + s);
            if (section) section.style.display = 'none';
            if (tabBtn) {
                tabBtn.style.borderLeft  = '3px solid transparent';
                tabBtn.style.background  = '#fff';
                tabBtn.style.color       = '#666';
            }
        });

        const activeSection = document.getElementById('section-' + tab);
        const activeTab     = document.getElementById('tab-' + tab);
        if (activeSection) activeSection.style.display = 'block';
        if (activeTab) {
            activeTab.style.borderLeft = '3px solid #111';
            activeTab.style.background = '#f9f9f9';
            activeTab.style.color      = '#111';
        }
    }

    function previewPhoto(input) {
        if (input.files && input.files[0]) {
            const reader = new FileReader();
            reader.onload = function(e) {
                // Update sidebar preview
                const placeholder = document.getElementById('photo-preview-placeholder');
                const preview     = document.getElementById('photo-preview');

                if (placeholder) placeholder.style.display = 'none';
                if (preview) {
                    preview.src           = e.target.result;
                    preview.style.display = 'block';
                }
            };
            reader.readAsDataURL(input.files[0]);
        }
    }
</script>

@endsection