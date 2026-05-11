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
        <div class="row justify-content-center">
            <div class="col-lg-8">

                <!-- Profile Header Card -->
                <div style="background:#111; padding:40px; margin-bottom:30px; display:flex; align-items:center; gap:25px;">
                    <div style="width:80px; height:80px; background:linear-gradient(135deg, #c8a96e, #8b6914); border-radius:50%; display:flex; align-items:center; justify-content:center; font-size:32px; font-weight:800; color:#fff; flex-shrink:0;">
                        {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                    </div>
                    <div>
                        <div style="font-size:11px; color:#c8a96e; letter-spacing:3px; text-transform:uppercase; margin-bottom:6px; font-weight:700;">
                            My Account · #{{ str_pad(Auth::user()->id, 4, '0', STR_PAD_LEFT) }}
                        </div>
                        <h2 style="color:#fff; font-size:24px; font-weight:800; margin:0 0 4px;">{{ Auth::user()->name }}</h2>
                        <div style="color:rgba(255,255,255,0.5); font-size:13px;">{{ Auth::user()->email }}</div>
                    </div>
                </div>

                <!-- Success Message -->
                @if(session('success'))
                    <div style="background:#f0fdf4; color:#27ae60; padding:14px 20px; margin-bottom:25px; border-left:4px solid #27ae60; font-size:13px; font-weight:600;">
                        <i class="fa fa-check-circle"></i> {{ session('success') }}
                    </div>
                @endif

                <!-- Profile Form -->
                <div style="background:#fff; box-shadow:0 2px 20px rgba(0,0,0,0.07);">
                    <!-- Form Header -->
                    <div style="padding:20px 30px; border-bottom:1px solid #f0f0f0; display:flex; align-items:center; gap:10px;">
                        <i class="fa fa-user-circle" style="color:#c8a96e; font-size:18px;"></i>
                        <h5 style="font-size:13px; font-weight:800; letter-spacing:2px; text-transform:uppercase; color:#111; margin:0;">
                            Personal Information
                        </h5>
                    </div>

                    <form method="POST" action="{{ route('profile.update') }}" style="padding:30px;">
                        @csrf

                        @if($errors->any())
                            <div style="background:#fdf0f0; color:#e74c3c; padding:14px 20px; margin-bottom:25px; border-left:4px solid #e74c3c; font-size:13px;">
                                @foreach($errors->all() as $error)
                                    <div><i class="fa fa-exclamation-circle"></i> {{ $error }}</div>
                                @endforeach
                            </div>
                        @endif

                        <div class="row">
                            <!-- Full Name -->
                            <div class="col-md-6 mb-4">
                                <label style="font-size:11px; font-weight:700; letter-spacing:1px; text-transform:uppercase; color:#111; display:block; margin-bottom:8px;">
                                    Full Name <span style="color:#e74c3c;">*</span>
                                </label>
                                <input type="text" name="name" value="{{ old('name', $user->name) }}"
                                    style="width:100%; border:1px solid #e8e8e8; padding:12px 15px; font-size:13px; outline:none; transition:border 0.3s; font-family:inherit;"
                                    onfocus="this.style.borderColor='#111';"
                                    onblur="this.style.borderColor='#e8e8e8';"
                                    required>
                            </div>

                            <!-- Email -->
                            <div class="col-md-6 mb-4">
                                <label style="font-size:11px; font-weight:700; letter-spacing:1px; text-transform:uppercase; color:#111; display:block; margin-bottom:8px;">
                                    Email Address <span style="color:#e74c3c;">*</span>
                                </label>
                                <input type="email" name="email" value="{{ old('email', $user->email) }}"
                                    style="width:100%; border:1px solid #e8e8e8; padding:12px 15px; font-size:13px; outline:none; transition:border 0.3s; font-family:inherit;"
                                    onfocus="this.style.borderColor='#111';"
                                    onblur="this.style.borderColor='#e8e8e8';"
                                    required>
                            </div>

                            <!-- Phone -->
                            <div class="col-md-6 mb-4">
                                <label style="font-size:11px; font-weight:700; letter-spacing:1px; text-transform:uppercase; color:#111; display:block; margin-bottom:8px;">
                                    Phone Number
                                </label>
                                <input type="text" name="phone" value="{{ old('phone', $user->phone) }}"
                                    placeholder="e.g. 09123456789"
                                    style="width:100%; border:1px solid #e8e8e8; padding:12px 15px; font-size:13px; outline:none; transition:border 0.3s; font-family:inherit;"
                                    onfocus="this.style.borderColor='#111';"
                                    onblur="this.style.borderColor='#e8e8e8';">
                            </div>

                            <!-- Address -->
                            <div class="col-md-6 mb-4">
                                <label style="font-size:11px; font-weight:700; letter-spacing:1px; text-transform:uppercase; color:#111; display:block; margin-bottom:8px;">
                                    Address
                                </label>
                                <input type="text" name="address" value="{{ old('address', $user->address) }}"
                                    placeholder="e.g. Davao City, Philippines"
                                    style="width:100%; border:1px solid #e8e8e8; padding:12px 15px; font-size:13px; outline:none; transition:border 0.3s; font-family:inherit;"
                                    onfocus="this.style.borderColor='#111';"
                                    onblur="this.style.borderColor='#e8e8e8';">
                            </div>
                        </div>

                        <!-- Password Section -->
                        <div style="border-top:1px solid #f0f0f0; padding-top:25px; margin-top:10px; margin-bottom:25px;">
                            <div style="display:flex; align-items:center; gap:10px; margin-bottom:20px;">
                                <i class="fa fa-lock" style="color:#c8a96e; font-size:16px;"></i>
                                <h5 style="font-size:13px; font-weight:800; letter-spacing:2px; text-transform:uppercase; color:#111; margin:0;">
                                    Change Password
                                </h5>
                                <span style="font-size:11px; color:#999; font-style:italic;">(optional)</span>
                            </div>
                            <div class="row">
                                <div class="col-md-6 mb-4">
                                    <label style="font-size:11px; font-weight:700; letter-spacing:1px; text-transform:uppercase; color:#111; display:block; margin-bottom:8px;">
                                        New Password
                                    </label>
                                    <input type="password" name="password"
                                        placeholder="Leave blank to keep current"
                                        style="width:100%; border:1px solid #e8e8e8; padding:12px 15px; font-size:13px; outline:none; transition:border 0.3s; font-family:inherit;"
                                        onfocus="this.style.borderColor='#111';"
                                        onblur="this.style.borderColor='#e8e8e8';">
                                </div>
                                <div class="col-md-6 mb-4">
                                    <label style="font-size:11px; font-weight:700; letter-spacing:1px; text-transform:uppercase; color:#111; display:block; margin-bottom:8px;">
                                        Confirm New Password
                                    </label>
                                    <input type="password" name="password_confirmation"
                                        placeholder="Confirm new password"
                                        style="width:100%; border:1px solid #e8e8e8; padding:12px 15px; font-size:13px; outline:none; transition:border 0.3s; font-family:inherit;"
                                        onfocus="this.style.borderColor='#111';"
                                        onblur="this.style.borderColor='#e8e8e8';">
                                </div>
                            </div>
                        </div>

                        <!-- Notice -->
                        <div style="background:#f9f9f9; padding:14px 18px; margin-bottom:25px; font-size:12px; color:#999; border-left:3px solid #e8e8e8;">
                            <i class="fa fa-info-circle" style="color:#c8a96e;"></i>
                            Your information is private. You can choose to fill in your details or stay anonymous. Only your name is required.
                        </div>

                        <!-- Submit -->
                        <div style="display:flex; justify-content:flex-end;">
                            <button type="submit"
                                style="background:#111; color:#fff; border:none; padding:14px 40px; font-size:12px; font-weight:700; letter-spacing:3px; text-transform:uppercase; cursor:pointer; transition:background 0.3s;"
                                onmouseover="this.style.background='#c8a96e';"
                                onmouseout="this.style.background='#111';">
                                <i class="fa fa-save"></i> Save Changes
                            </button>
                        </div>
                    </form>
                </div>

            </div>
        </div>
    </div>
</section>

@endsection