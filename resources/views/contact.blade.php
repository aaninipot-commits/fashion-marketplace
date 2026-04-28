@extends('layouts.app')

@section('content')

<!-- Breadcrumb Begin -->
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
<!-- Breadcrumb End -->

<section class="contact spad">
    <div class="container">
        <div class="row">
            <div class="col-lg-4 col-md-4">
                <div class="contact__widget">
                    <div class="contact__widget__item">
                        <i class="fa fa-map-marker" style="font-size:24px; color:#c8a96e;"></i>
                        <h5>Address</h5>
                        <p>Davao City, Philippines</p>
                    </div>
                    <div class="contact__widget__item mt-4">
                        <i class="fa fa-phone" style="font-size:24px; color:#c8a96e;"></i>
                        <h5>Phone</h5>
                        <p>+63 912 345 6789</p>
                    </div>
                    <div class="contact__widget__item mt-4">
                        <i class="fa fa-envelope" style="font-size:24px; color:#c8a96e;"></i>
                        <h5>Email</h5>
                        <p>fashionmarketplace@gmail.com</p>
                    </div>
                </div>
            </div>
            <div class="col-lg-8 col-md-8">
                <div class="contact__form">
                    <h2 style="font-size:28px; font-weight:800; margin-bottom:30px; text-transform:uppercase;">Get In Touch</h2>

                    @if(session('success'))
                        <div class="alert alert-success" style="border-radius:0; margin-bottom:20px; background:#f0fdf4; color:#27ae60; border:none; padding:12px 16px;">
                            {{ session('success') }}
                        </div>
                    @endif

                    @if($errors->any())
                        <div class="alert alert-danger" style="border-radius:0; margin-bottom:20px; background:#fdf0f0; color:#e74c3c; border:none; padding:12px 16px;">
                            @foreach($errors->all() as $error)
                                <p class="mb-0">{{ $error }}</p>
                            @endforeach
                        </div>
                    @endif

                    <form action="{{ route('contact.send') }}" method="POST">
                        @csrf
                        <div class="row">
                            <div class="col-lg-6">
                                <input type="text" name="name"
                                    placeholder="Your Name"
                                    value="{{ old('name', Auth::user()->name) }}"
                                    style="width:100%; border:1px solid #ebebeb; padding:12px 15px; margin-bottom:20px; font-size:14px; outline:none;"
                                    required>
                            </div>
                            <div class="col-lg-6">
                                <input type="email" name="email"
                                    placeholder="Your Email"
                                    value="{{ old('email', Auth::user()->email) }}"
                                    style="width:100%; border:1px solid #ebebeb; padding:12px 15px; margin-bottom:20px; font-size:14px; outline:none;"
                                    required>
                            </div>
                            <div class="col-lg-12">
                                <input type="text" name="subject"
                                    placeholder="Subject"
                                    value="{{ old('subject') }}"
                                    style="width:100%; border:1px solid #ebebeb; padding:12px 15px; margin-bottom:20px; font-size:14px; outline:none;">
                            </div>
                            <div class="col-lg-12">
                                <textarea name="message"
                                    placeholder="Your Message" rows="6"
                                    style="width:100%; border:1px solid #ebebeb; padding:12px 15px; margin-bottom:20px; font-size:14px; outline:none; resize:none;"
                                    required>{{ old('message') }}</textarea>
                            </div>
                            <div class="col-lg-12">
                                <button type="submit"
                                    style="background:#111; color:#fff; border:none; padding:14px 40px; font-size:12px; font-weight:700; letter-spacing:3px; text-transform:uppercase; cursor:pointer; transition:background 0.3s;"
                                    onmouseover="this.style.background='#c8a96e'"
                                    onmouseout="this.style.background='#111'">
                                    Send Message
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>

@endsection