@extends('layouts.app')

@section('content')

<!-- Breadcrumb -->
<div class="breacrumb-section">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="breadcrumb-text">
                    <a href="{{ route('home') }}"><i class="fa fa-home"></i> Home</a>
                    <span>Contact</span>
                </div>
            </div>
        </div>
    </div>
</div>

<section class="spad">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-10">

                <!-- Page Header -->
                <div style="text-align:center; margin-bottom:50px;">
                    <span style="font-size:11px; letter-spacing:4px; text-transform:uppercase; color:#c8a96e; font-weight:700; display:block; margin-bottom:10px;">
                        We're Here to Help
                    </span>
                    <h2 style="font-size:36px; font-weight:800; color:#111; text-transform:uppercase; letter-spacing:2px; margin-bottom:15px;">
                        Contact Us
                    </h2>
                    <p style="font-size:14px; color:#999; max-width:500px; margin:0 auto; line-height:1.8;">
                        Have a question, feedback, or found a bug? Fill in the form below and our team will get back to you as soon as possible.
                    </p>
                </div>

                <div class="row">

                    <!-- Left: Info Cards -->
                    <div class="col-lg-4 mb-4">

                        <!-- Info Cards -->
                        <div style="background:#111; padding:25px; margin-bottom:15px;">
                            <div style="width:40px; height:40px; background:#c8a96e; border-radius:50%; display:flex; align-items:center; justify-content:center; margin-bottom:15px;">
                                <i class="fa fa-bug" style="color:#111; font-size:16px;"></i>
                            </div>
                            <h5 style="color:#fff; font-size:13px; font-weight:800; letter-spacing:2px; text-transform:uppercase; margin-bottom:8px;">Bug Report</h5>
                            <p style="color:rgba(255,255,255,0.5); font-size:12px; line-height:1.6; margin:0;">Found something broken? Let us know and we'll fix it right away.</p>
                        </div>

                        <div style="background:#111; padding:25px; margin-bottom:15px;">
                            <div style="width:40px; height:40px; background:#c8a96e; border-radius:50%; display:flex; align-items:center; justify-content:center; margin-bottom:15px;">
                                <i class="fa fa-lightbulb-o" style="color:#111; font-size:16px;"></i>
                            </div>
                            <h5 style="color:#fff; font-size:13px; font-weight:800; letter-spacing:2px; text-transform:uppercase; margin-bottom:8px;">Feedback</h5>
                            <p style="color:rgba(255,255,255,0.5); font-size:12px; line-height:1.6; margin:0;">Share your thoughts to help us improve Fashion Marketplace.</p>
                        </div>

                        <div style="background:#111; padding:25px; margin-bottom:15px;">
                            <div style="width:40px; height:40px; background:#c8a96e; border-radius:50%; display:flex; align-items:center; justify-content:center; margin-bottom:15px;">
                                <i class="fa fa-question-circle" style="color:#111; font-size:16px;"></i>
                            </div>
                            <h5 style="color:#fff; font-size:13px; font-weight:800; letter-spacing:2px; text-transform:uppercase; margin-bottom:8px;">General Inquiry</h5>
                            <p style="color:rgba(255,255,255,0.5); font-size:12px; line-height:1.6; margin:0;">Have a question about how the system works? Ask us anything.</p>
                        </div>

                        <div style="background:#111; padding:25px;">
                            <div style="width:40px; height:40px; background:#c8a96e; border-radius:50%; display:flex; align-items:center; justify-content:center; margin-bottom:15px;">
                                <i class="fa fa-flag" style="color:#111; font-size:16px;"></i>
                            </div>
                            <h5 style="color:#fff; font-size:13px; font-weight:800; letter-spacing:2px; text-transform:uppercase; margin-bottom:8px;">Report a User</h5>
                            <p style="color:rgba(255,255,255,0.5); font-size:12px; line-height:1.6; margin:0;">Report suspicious or inappropriate behavior from another user.</p>
                        </div>

                    </div>

                    <!-- Right: Contact Form -->
                    <div class="col-lg-8">
                        <div style="background:#fff; box-shadow:0 2px 20px rgba(0,0,0,0.07);">

                            <div style="background:#111; padding:20px 30px;">
                                <h5 style="color:#fff; font-size:13px; font-weight:800; letter-spacing:2px; text-transform:uppercase; margin:0;">
                                    <i class="fa fa-envelope" style="color:#c8a96e; margin-right:8px;"></i>
                                    Send us a Message
                                </h5>
                            </div>

                            <div style="padding:35px 30px;">

                                @if(session('success'))
                                    <div style="background:#f0fdf4; color:#27ae60; padding:16px 20px; margin-bottom:25px; border-left:4px solid #27ae60; font-size:13px; font-weight:600;">
                                        <i class="fa fa-check-circle"></i> {{ session('success') }}
                                    </div>
                                @endif

                                @if($errors->any())
                                    <div style="background:#fdf0f0; color:#e74c3c; padding:16px 20px; margin-bottom:25px; border-left:4px solid #e74c3c; font-size:13px;">
                                        @foreach($errors->all() as $error)
                                            <div><i class="fa fa-exclamation-circle"></i> {{ $error }}</div>
                                        @endforeach
                                    </div>
                                @endif

                                <!-- User Info (auto-filled) -->
                                <div style="background:#f9f9f9; padding:15px 20px; margin-bottom:25px; border-left:3px solid #c8a96e; display:flex; align-items:center; gap:15px;">
                                    <div style="width:40px; height:40px; background:#c8a96e; border-radius:50%; display:flex; align-items:center; justify-content:center; font-size:16px; font-weight:700; color:#111; flex-shrink:0;">
                                        {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                                    </div>
                                    <div>
                                        <div style="font-size:13px; font-weight:700; color:#111;">{{ Auth::user()->name }}</div>
                                        <div style="font-size:12px; color:#999;">{{ Auth::user()->email }}</div>
                                    </div>
                                    <div style="margin-left:auto;">
                                        <span style="background:#111; color:#c8a96e; padding:3px 12px; font-size:10px; font-weight:700; letter-spacing:1px; text-transform:uppercase;">
                                            {{ Auth::user()->role === 'admin' ? 'Seller' : 'Buyer' }}
                                        </span>
                                    </div>
                                </div>

                                <form method="POST" action="{{ route('contact.send') }}">
                                    @csrf

                                    <!-- Message Type -->
                                    <div style="margin-bottom:20px;">
                                        <label style="font-size:11px; font-weight:700; letter-spacing:1px; text-transform:uppercase; color:#111; display:block; margin-bottom:10px;">
                                            Message Type <span style="color:#e74c3c;">*</span>
                                        </label>
                                        <div style="display:grid; grid-template-columns:1fr 1fr; gap:10px;">
                                            <label class="type-option" onclick="selectType(this, 'Bug Report')"
                                                style="display:flex; align-items:center; gap:10px; padding:12px 15px; border:2px solid #e8e8e8; cursor:pointer; transition:all 0.3s;">
                                                <input type="radio" name="type" value="Bug Report" style="display:none;">
                                                <i class="fa fa-bug" style="color:#e74c3c; font-size:16px; width:20px;"></i>
                                                <div>
                                                    <div style="font-size:12px; font-weight:700; color:#111;">Bug Report</div>
                                                    <div style="font-size:11px; color:#999;">Something is broken</div>
                                                </div>
                                            </label>
                                            <label class="type-option" onclick="selectType(this, 'Feedback')"
                                                style="display:flex; align-items:center; gap:10px; padding:12px 15px; border:2px solid #e8e8e8; cursor:pointer; transition:all 0.3s;">
                                                <input type="radio" name="type" value="Feedback" style="display:none;">
                                                <i class="fa fa-lightbulb-o" style="color:#f39c12; font-size:16px; width:20px;"></i>
                                                <div>
                                                    <div style="font-size:12px; font-weight:700; color:#111;">Feedback</div>
                                                    <div style="font-size:11px; color:#999;">Share your thoughts</div>
                                                </div>
                                            </label>
                                            <label class="type-option" onclick="selectType(this, 'General Inquiry')"
                                                style="display:flex; align-items:center; gap:10px; padding:12px 15px; border:2px solid #e8e8e8; cursor:pointer; transition:all 0.3s;">
                                                <input type="radio" name="type" value="General Inquiry" style="display:none;">
                                                <i class="fa fa-question-circle" style="color:#3498db; font-size:16px; width:20px;"></i>
                                                <div>
                                                    <div style="font-size:12px; font-weight:700; color:#111;">General Inquiry</div>
                                                    <div style="font-size:11px; color:#999;">Ask us anything</div>
                                                </div>
                                            </label>
                                            <label class="type-option" onclick="selectType(this, 'Report a User')"
                                                style="display:flex; align-items:center; gap:10px; padding:12px 15px; border:2px solid #e8e8e8; cursor:pointer; transition:all 0.3s;">
                                                <input type="radio" name="type" value="Report a User" style="display:none;">
                                                <i class="fa fa-flag" style="color:#e74c3c; font-size:16px; width:20px;"></i>
                                                <div>
                                                    <div style="font-size:12px; font-weight:700; color:#111;">Report a User</div>
                                                    <div style="font-size:11px; color:#999;">Suspicious behavior</div>
                                                </div>
                                            </label>
                                        </div>
                                        <div id="type-error" style="display:none; color:#e74c3c; font-size:12px; margin-top:8px;">
                                            <i class="fa fa-exclamation-circle"></i> Please select a message type
                                        </div>
                                    </div>

                                    <!-- Subject -->
                                    <div style="margin-bottom:20px;">
                                        <label style="font-size:11px; font-weight:700; letter-spacing:1px; text-transform:uppercase; color:#111; display:block; margin-bottom:8px;">
                                            Subject <span style="color:#e74c3c;">*</span>
                                        </label>
                                        <input type="text" name="subject"
                                            value="{{ old('subject') }}"
                                            placeholder="Brief description of your concern"
                                            style="width:100%; border:1px solid #e8e8e8; padding:12px 15px; font-size:13px; outline:none; transition:border 0.3s; font-family:inherit;"
                                            onfocus="this.style.borderColor='#111';"
                                            onblur="this.style.borderColor='#e8e8e8';"
                                            required>
                                    </div>

                                    <!-- Message -->
                                    <div style="margin-bottom:25px;">
                                        <label style="font-size:11px; font-weight:700; letter-spacing:1px; text-transform:uppercase; color:#111; display:block; margin-bottom:8px;">
                                            Message <span style="color:#e74c3c;">*</span>
                                        </label>
                                        <textarea name="message" rows="6"
                                            placeholder="Describe your concern in detail. The more specific you are, the faster we can help you."
                                            style="width:100%; border:1px solid #e8e8e8; padding:12px 15px; font-size:13px; outline:none; transition:border 0.3s; font-family:inherit; resize:vertical;"
                                            onfocus="this.style.borderColor='#111';"
                                            onblur="this.style.borderColor='#e8e8e8';"
                                            required>{{ old('message') }}</textarea>
                                        <div style="font-size:11px; color:#999; margin-top:6px;">
                                            <i class="fa fa-info-circle" style="color:#c8a96e;"></i>
                                            Maximum 2000 characters. Be as specific as possible.
                                        </div>
                                    </div>

                                    <!-- Submit -->
                                    <button type="submit" id="submitBtn"
                                        onclick="return validateForm()"
                                        style="background:#111; color:#fff; border:none; padding:15px 40px; font-size:11px; font-weight:700; letter-spacing:3px; text-transform:uppercase; cursor:pointer; transition:background 0.3s; width:100%;"
                                        onmouseover="this.style.background='#c8a96e';"
                                        onmouseout="this.style.background='#111';">
                                        <i class="fa fa-paper-plane"></i> Send Message
                                    </button>

                                </form>

                                <!-- Show Previous Messages and Replies -->
                                @php
                                $myMessages = \App\Models\ContactMessage::where('user_id', Auth::id())
                                    ->latest()
                                    ->get();
                            @endphp

@if($myMessages->count() > 0)
<div class="container" style="padding-bottom:60px;">
<div style="max-width:800px; margin:0 auto;">
    <div style="margin-bottom:25px; padding-top:20px; border-top:2px solid #f0f0f0;">
        <h4 style="font-size:14px; font-weight:800; letter-spacing:2px; text-transform:uppercase; color:#111; margin-bottom:20px;">
            <i class="fa fa-history" style="color:#c8a96e; margin-right:8px;"></i> My Previous Messages
        </h4>

        @foreach($myMessages as $msg)
            <div style="background:#fff; box-shadow:0 2px 15px rgba(0,0,0,0.06); margin-bottom:20px; overflow:hidden;">
                <!-- Message Header -->
                <div style="background:#f9f9f9; padding:15px 20px; border-bottom:1px solid #f0f0f0; display:flex; align-items:center; justify-content:space-between; flex-wrap:wrap; gap:10px;">
                    <div>
                        <span style="font-size:12px; font-weight:700; color:#111;">{{ $msg->subject }}</span>
                        <span style="background:#f0f0f0; color:#666; padding:2px 10px; font-size:10px; font-weight:700; margin-left:10px;">{{ $msg->type ?? 'General' }}</span>
                    </div>
                    <div style="font-size:11px; color:#999;">{{ $msg->created_at->format('M d, Y h:i A') }}</div>
                </div>

                <!-- Original Message -->
                <div style="padding:20px; border-bottom:1px solid #f0f0f0;">
                    <div style="font-size:11px; font-weight:700; letter-spacing:1px; text-transform:uppercase; color:#999; margin-bottom:8px;">
                        <i class="fa fa-user"></i> Your Message
                    </div>
                    <p style="font-size:13px; color:#444; line-height:1.8; margin:0;">{{ $msg->message }}</p>
                </div>

                <!-- Reply from Super Admin -->
                @if($msg->reply)
                    <div style="padding:20px; background:#f9f4ec; border-left:3px solid #c8a96e;">
                        <div style="font-size:11px; font-weight:700; letter-spacing:1px; text-transform:uppercase; color:#c8a96e; margin-bottom:8px;">
                            <i class="fa fa-reply"></i> Reply from Support Team
                        </div>
                        <p style="font-size:13px; color:#444; line-height:1.8; margin:0;">{{ $msg->reply }}</p>
                    </div>
                @else
                    <div style="padding:15px 20px; background:#f9f9f9; display:flex; align-items:center; gap:10px;">
                        <i class="fa fa-clock-o" style="color:#f39c12;"></i>
                        <span style="font-size:12px; color:#999; font-style:italic;">Waiting for reply from support team...</span>
                    </div>
                @endif
            </div>
        @endforeach
    </div>
</div>
</div>
@endif

                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</section>

<script>
    let selectedType = '';

    function selectType(element, type) {
        // Remove selected from all
        document.querySelectorAll('.type-option').forEach(function(el) {
            el.style.borderColor = '#e8e8e8';
            el.style.background = '#fff';
        });

        // Select this one
        element.style.borderColor = '#111';
        element.style.background = '#f9f9f9';
        element.querySelector('input[type="radio"]').checked = true;
        selectedType = type;

        // Hide error
        document.getElementById('type-error').style.display = 'none';
    }

    function validateForm() {
        if (!selectedType) {
            document.getElementById('type-error').style.display = 'block';
            return false;
        }
        return true;
    }

    // Restore selected type on validation error
    document.addEventListener('DOMContentLoaded', function() {
        const oldType = '{{ old("type") }}';
        if (oldType) {
            document.querySelectorAll('.type-option').forEach(function(el) {
                const radio = el.querySelector('input[type="radio"]');
                if (radio && radio.value === oldType) {
                    selectType(el, oldType);
                }
            });
        }
    });
</script>

@endsection