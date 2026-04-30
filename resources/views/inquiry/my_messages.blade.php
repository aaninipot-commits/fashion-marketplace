@extends('layouts.app')

@section('content')

<!-- Breadcrumb -->
<div class="breacrumb-section">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="breadcrumb-text">
                    <a href="{{ route('home') }}"><i class="fa fa-home"></i> Home</a>
                    <span>My Messages</span>
                </div>
            </div>
        </div>
    </div>
</div>

<section class="spad">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div style="margin-bottom:30px;">
                    <h2 style="font-size:28px; font-weight:800; color:#111; text-transform:uppercase; letter-spacing:2px;">
                        <i class="fa fa-comments" style="color:#c8a96e; margin-right:10px;"></i>
                        My Messages
                    </h2>
                    <p style="font-size:14px; color:#999;">Your product inquiries and seller replies</p>
                </div>

                @if(count($conversations) > 0)
                    @foreach($conversations as $conv)
                        <div style="background:#fff; box-shadow:0 2px 15px rgba(0,0,0,0.06); margin-bottom:15px; cursor:pointer; transition:all 0.3s;"
                            onclick="window.location='{{ route('shop.product', $conv['product']->id) }}#inquiry-section'"
                            onmouseover="this.style.boxShadow='0 5px 25px rgba(0,0,0,0.12)';"
                            onmouseout="this.style.boxShadow='0 2px 15px rgba(0,0,0,0.06)';">
                            <div style="padding:20px 25px; display:flex; align-items:center; gap:20px;">

                                <!-- Product Image -->
                                <div style="width:70px; height:70px; flex-shrink:0;">
                                    @if($conv['product']->image)
                                        <img src="{{ asset($conv['product']->image) }}"
                                            style="width:70px; height:70px; object-fit:cover; border:1px solid #f0f0f0;"
                                            alt="{{ $conv['product']->name }}">
                                    @else
                                        <div style="width:70px; height:70px; background:#f5f5f5; display:flex; align-items:center; justify-content:center; color:#ccc;">
                                            <i class="fa fa-image" style="font-size:24px;"></i>
                                        </div>
                                    @endif
                                </div>

                                <!-- Conversation Info -->
                                <div style="flex:1; min-width:0;">
                                    <div style="display:flex; align-items:center; gap:10px; margin-bottom:5px; flex-wrap:wrap;">
                                        <h5 style="font-size:15px; font-weight:700; color:#111; margin:0;">
                                            {{ $conv['product']->name }}
                                        </h5>
                                        @if($conv['unreadCount'] > 0)
                                            <span style="background:#e74c3c; color:#fff; border-radius:50px; padding:2px 10px; font-size:11px; font-weight:700;">
                                                {{ $conv['unreadCount'] }} new reply
                                            </span>
                                        @endif
                                    </div>
                                    <p style="font-size:12px; color:#c8a96e; margin-bottom:5px; font-weight:600; text-transform:uppercase; letter-spacing:1px;">
                                        <i class="fa fa-store"></i>
                                        {{ $conv['product']->seller->shop_name ?? $conv['product']->seller->name }}
                                    </p>
                                    <p style="font-size:13px; color:#666; margin:0; white-space:nowrap; overflow:hidden; text-overflow:ellipsis;">
                                        @if($conv['lastMessage']->sender === 'user')
                                            <span style="color:#999;">You:</span>
                                        @else
                                            <span style="color:#c8a96e; font-weight:700;">Seller:</span>
                                        @endif
                                        {{ Str::limit($conv['lastMessage']->message, 80) }}
                                    </p>
                                </div>

                                <!-- Price & Arrow -->
                                <div style="text-align:right; flex-shrink:0;">
                                    <div style="font-size:16px; font-weight:800; color:#c8a96e; margin-bottom:5px;">
                                        ₱{{ number_format($conv['product']->price, 2) }}
                                    </div>
                                    <div style="font-size:11px; color:#ccc;">
                                        {{ $conv['lastMessage']->created_at->diffForHumans() }}
                                    </div>
                                    <i class="fa fa-chevron-right" style="color:#ccc; margin-top:8px; display:block;"></i>
                                </div>
                            </div>
                        </div>
                    @endforeach
                @else
                    <div style="text-align:center; padding:80px 20px; background:#fff; box-shadow:0 2px 15px rgba(0,0,0,0.06);">
                        <i class="fa fa-comments" style="font-size:56px; color:#ddd; display:block; margin-bottom:20px;"></i>
                        <h4 style="font-size:20px; font-weight:700; color:#444; margin-bottom:10px;">No Messages Yet</h4>
                        <p style="font-size:14px; color:#999; margin-bottom:25px;">
                            You haven't sent any product inquiries yet. Browse our shop and ask sellers about products!
                        </p>
                        <a href="{{ route('shop.index') }}"
                            style="background:#111; color:#fff; padding:14px 40px; font-size:12px; font-weight:700; letter-spacing:3px; text-transform:uppercase; text-decoration:none; display:inline-block; transition:background 0.3s;"
                            onmouseover="this.style.background='#c8a96e';"
                            onmouseout="this.style.background='#111';">
                            Browse Shop
                        </a>
                    </div>
                @endif
            </div>
        </div>
    </div>
</section>

@endsection