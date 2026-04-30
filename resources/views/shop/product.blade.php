@extends('layouts.app')

@section('content')

<!-- Breadcrumb -->
<div class="breacrumb-section">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="breadcrumb-text">
                    <a href="{{ route('home') }}"><i class="fa fa-home"></i> Home</a>
                    <a href="{{ route('shop.index') }}">Shop</a>
                    <span>{{ $product->name }}</span>
                </div>
            </div>
        </div>
    </div>
</div>

<section class="product-details spad">
    <div class="container">
        <div class="row">

            <!-- Product Image -->
            <div class="col-lg-6">
                <div style="background:#f9f9f9; padding:30px; text-align:center; position:relative;">
                    @if($product->image)
                        <img src="{{ asset($product->image) }}"
                            alt="{{ $product->name }}"
                            style="max-width:100%; max-height:500px; object-fit:contain;">
                    @else
                        <div style="height:400px; display:flex; align-items:center; justify-content:center; color:#ddd; flex-direction:column; gap:15px;">
                            <i class="fa fa-image" style="font-size:64px;"></i>
                            <p style="font-size:14px;">No image available</p>
                        </div>
                    @endif

                    <!-- Stock Badge -->
                    @if($product->stock <= 0)
                        <div style="position:absolute; top:20px; left:20px; background:#e74c3c; color:#fff; padding:6px 16px; font-size:12px; font-weight:700; letter-spacing:1px;">
                            OUT OF STOCK
                        </div>
                    @elseif($product->stock <= 5)
                        <div style="position:absolute; top:20px; left:20px; background:#f39c12; color:#fff; padding:6px 16px; font-size:12px; font-weight:700; letter-spacing:1px;">
                            LOW STOCK
                        </div>
                    @endif
                </div>
            </div>

            <!-- Product Details -->
            <div class="col-lg-6">
                <div style="padding:20px 0;">

                    <!-- Category & Seller -->
                    <div style="display:flex; gap:10px; margin-bottom:15px; flex-wrap:wrap;">
                        <span style="background:#f0f0f0; color:#666; padding:4px 12px; font-size:11px; font-weight:700; letter-spacing:1px; text-transform:uppercase;">
                            {{ ucfirst($product->category->gender) }} — {{ $product->category->name }}
                        </span>
                        <span style="background:#f9f4ec; color:#c8a96e; padding:4px 12px; font-size:11px; font-weight:700; letter-spacing:1px; text-transform:uppercase;">
                            <i class="fa fa-store"></i> {{ $product->seller->shop_name ?? $product->seller->name }}
                        </span>
                    </div>

                    <!-- Product Name -->
                    <h2 style="font-size:32px; font-weight:800; color:#111; margin-bottom:15px; line-height:1.2;">
                        {{ $product->name }}
                    </h2>

                    <!-- Price -->
                    <div style="font-size:32px; font-weight:800; color:#c8a96e; margin-bottom:20px;">
                        ₱{{ number_format($product->price, 2) }}
                    </div>

                    <!-- Stock Status -->
                    <div style="margin-bottom:20px;">
                        @if($product->stock <= 0)
                            <span style="background:#fdf0f0; color:#e74c3c; padding:6px 16px; font-size:12px; font-weight:700; letter-spacing:1px;">
                                <i class="fa fa-times-circle"></i> Out of Stock
                            </span>
                        @elseif($product->stock <= 5)
                            <span style="background:#fff8f0; color:#f39c12; padding:6px 16px; font-size:12px; font-weight:700; letter-spacing:1px;">
                                <i class="fa fa-exclamation-circle"></i> Low Stock — Only {{ $product->stock }} left!
                            </span>
                        @else
                            <span style="background:#f0fdf4; color:#27ae60; padding:6px 16px; font-size:12px; font-weight:700; letter-spacing:1px;">
                                <i class="fa fa-check-circle"></i> In Stock ({{ $product->stock }} available)
                            </span>
                        @endif
                    </div>

                    <!-- Product Details -->
                    <div style="border-top:1px solid #f0f0f0; border-bottom:1px solid #f0f0f0; padding:20px 0; margin-bottom:20px;">
                        @if($product->description)
                            <p style="font-size:14px; color:#666; line-height:1.8; margin-bottom:15px;">
                                {{ $product->description }}
                            </p>
                        @endif
                        <div style="display:flex; flex-wrap:wrap; gap:15px;">
                            @if($product->size)
                                <div style="font-size:13px; color:#444;">
                                    <strong>Size:</strong> {{ $product->size }}
                                </div>
                            @endif
                            @if($product->color)
                                <div style="font-size:13px; color:#444;">
                                    <strong>Color:</strong> {{ $product->color }}
                                </div>
                            @endif
                        </div>
                    </div>

                    <!-- Seller Info -->
                    <div style="background:#f9f9f9; padding:20px; margin-bottom:20px; border-left:3px solid #c8a96e;">
                        <p style="font-size:11px; letter-spacing:2px; text-transform:uppercase; color:#999; margin-bottom:5px;">Sold by</p>
                        <p style="font-size:16px; font-weight:700; color:#111; margin-bottom:3px;">
                            {{ $product->seller->shop_name ?? $product->seller->name }}
                        </p>
                        @if($product->seller->shop_description)
                            <p style="font-size:13px; color:#666; margin:0;">{{ $product->seller->shop_description }}</p>
                        @endif
                    </div>

                    <!-- Inquiry Button -->
                    @if($product->stock > 0)
                        <button onclick="document.getElementById('inquiry-section').scrollIntoView({behavior:'smooth'})"
                            style="background:#111; color:#fff; border:none; padding:15px 40px; font-size:12px; font-weight:700; letter-spacing:3px; text-transform:uppercase; cursor:pointer; transition:background 0.3s; width:100%;"
                            onmouseover="this.style.background='#c8a96e'"
                            onmouseout="this.style.background='#111'">
                            <i class="fa fa-comments"></i> Send Inquiry to Seller
                        </button>
                    @else
                        <div style="background:#f5f5f5; padding:15px; text-align:center; color:#999; font-size:13px; font-weight:600; letter-spacing:1px; text-transform:uppercase;">
                            This product is currently out of stock
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Inquiry Section -->
        @if($product->stock > 0)
        <div class="row mt-5" id="inquiry-section">
            <div class="col-lg-8 offset-lg-2">
                <div style="background:#fff; padding:40px; box-shadow:0 2px 20px rgba(0,0,0,0.08);">

                    <h4 style="font-size:16px; font-weight:800; letter-spacing:2px; text-transform:uppercase; margin-bottom:5px; color:#111;">
                        <i class="fa fa-comments" style="color:#c8a96e; margin-right:8px;"></i>
                        Send Inquiry
                    </h4>
                    <p style="font-size:13px; color:#999; margin-bottom:25px;">
                        Ask the seller about this product. They will reply as soon as possible.
                    </p>

                    <!-- Success/Error -->
                    <div class="inquiry-success" style="display:none; background:#f0fdf4; color:#27ae60; padding:12px 16px; margin-bottom:20px; border-left:3px solid #27ae60; font-size:13px; font-weight:600;">
                        <i class="fa fa-check-circle"></i> <span></span>
                    </div>
                    <div class="inquiry-error" style="display:none; background:#fdf0f0; color:#e74c3c; padding:12px 16px; margin-bottom:20px; border-left:3px solid #e74c3c; font-size:13px;">
                        <i class="fa fa-exclamation-circle"></i> <span></span>
                    </div>

                    <!-- Inquiry Form -->
                    <form id="inquiryForm">
                        @csrf
                        <input type="hidden" name="product_id" value="{{ $product->id }}">
                        <div class="mb-3">
                            <label style="font-size:11px; font-weight:700; letter-spacing:1px; text-transform:uppercase; color:#111; display:block; margin-bottom:8px;">
                                Your Message <span style="color:#e74c3c;">*</span>
                            </label>
                            <textarea name="message" id="inquiry_message" rows="4"
                                placeholder="e.g. Is this available in size M? How long is delivery?"
                                style="width:100%; border:1px solid #e8e8e8; padding:12px 15px; font-size:14px; outline:none; resize:none; font-family:inherit; transition:border 0.3s;"
                                onfocus="this.style.borderColor='#111';"
                                onblur="this.style.borderColor='#e8e8e8';"
                                required></textarea>
                        </div>
                        <button type="submit" id="inquirySubmitBtn"
                            style="background:#111; color:#fff; border:none; padding:14px 40px; font-size:11px; font-weight:700; letter-spacing:3px; text-transform:uppercase; cursor:pointer; transition:background 0.3s;"
                            onmouseover="this.style.background='#c8a96e'"
                            onmouseout="this.style.background='#111'">
                            <i class="fa fa-paper-plane"></i> Send Message
                        </button>
                    </form>

                    <!-- Previous Conversation -->
                    <div id="conversation-section" style="margin-top:30px; display:none;">
                        <div style="border-top:1px solid #f0f0f0; padding-top:25px; margin-bottom:15px;">
                            <h5 style="font-size:12px; font-weight:800; letter-spacing:2px; text-transform:uppercase; color:#999; margin:0;">
                                Conversation History
                            </h5>
                        </div>
                        <div id="conversation-messages"></div>
                    </div>
                </div>
            </div>
        </div>
        @endif

        <!-- Related Products -->
        @if($relatedProducts->count() > 0)
        <div class="row mt-5">
            <div class="col-lg-12">
                <div style="margin-bottom:30px;">
                    <span style="font-size:12px; letter-spacing:3px; text-transform:uppercase; color:#c8a96e; font-weight:700;">More Like This</span>
                    <h3 style="font-size:24px; font-weight:800; color:#111; margin-top:5px;">Related Products</h3>
                </div>
            </div>
            @foreach($relatedProducts as $related)
                <div class="col-lg-3 col-md-6 col-sm-6 mb-4">
                    <div class="product__item">
                        <div class="product__item__pic set-bg"
                            data-setbg="{{ $related->image ? asset($related->image) : asset('img/product/product-1.jpg') }}">
                            <ul class="product__hover">
                                <li>
                                    <a href="{{ route('shop.product', $related->id) }}">
                                        <img src="{{ asset('img/icon/search.png') }}" alt="">
                                    </a>
                                </li>
                            </ul>
                        </div>
                        <div class="product__item__text">
                            <h6>{{ $related->name }}</h6>
                            <a href="{{ route('shop.product', $related->id) }}" class="add-cart">+ View Details</a>
                            <h5>₱{{ number_format($related->price, 2) }}</h5>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
        @endif

    </div>
</section>

@push('scripts')
<script>
    // Load existing conversation on page load
    loadConversation();

    function loadConversation() {
        $.get('{{ route("inquiry.conversation", $product->id) }}', function(data) {
            if (data.length > 0) {
                $('#conversation-section').show();
                let html = '';
                $.each(data, function(index, msg) {
                    if (msg.sender === 'user') {
                        html += `
                            <div style="margin-bottom:15px; display:flex; justify-content:flex-end;">
                                <div style="max-width:75%;">
                                    <div style="font-size:11px; color:#999; letter-spacing:1px; text-transform:uppercase; margin-bottom:5px; text-align:right;">
                                        You
                                    </div>
                                    <div style="background:#111; color:#fff; padding:12px 16px; font-size:13px; line-height:1.6;">
                                        ${msg.message}
                                    </div>
                                    <div style="font-size:11px; color:#ccc; margin-top:4px; text-align:right;">
                                        ${msg.created_at}
                                    </div>
                                </div>
                            </div>`;
                    } else {
                        html += `
                            <div style="margin-bottom:15px; display:flex; justify-content:flex-start;">
                                <div style="max-width:75%;">
                                    <div style="font-size:11px; color:#c8a96e; letter-spacing:1px; text-transform:uppercase; margin-bottom:5px; font-weight:700;">
                                        <i class="fa fa-store"></i> {{ $product->seller->shop_name ?? $product->seller->name }}
                                    </div>
                                    <div style="background:#f9f9f9; border:1px solid #f0f0f0; color:#333; padding:12px 16px; font-size:13px; line-height:1.6;">
                                        ${msg.message}
                                    </div>
                                    <div style="font-size:11px; color:#ccc; margin-top:4px;">
                                        ${msg.created_at}
                                    </div>
                                </div>
                            </div>`;
                    }
                });
                $('#conversation-messages').html(html);
            }
        });
    }

    // Send Inquiry
    $('#inquiryForm').submit(function(e) {
        e.preventDefault();
        let btn = $('#inquirySubmitBtn');
        btn.html('<i class="fa fa-spinner fa-spin"></i> Sending...').prop('disabled', true);

        let formData = new FormData(this);
        $.ajax({
            type: 'POST',
            url: '{{ route("inquiry.send") }}',
            data: formData,
            contentType: false,
            processData: false,
            success: function(response) {
                btn.html('<i class="fa fa-paper-plane"></i> Send Message').prop('disabled', false);
                $('.inquiry-success span').text(response.success);
                $('.inquiry-success').show();
                $('.inquiry-error').hide();
                $('#inquiry_message').val('');

                // Reload conversation
                setTimeout(function() {
                    loadConversation();
                    $('.inquiry-success').fadeOut();
                }, 2000);
            },
            error: function(response) {
                btn.html('<i class="fa fa-paper-plane"></i> Send Message').prop('disabled', false);
                if (response.status === 422) {
                    $('.inquiry-error span').text('Please enter a message.');
                } else {
                    $('.inquiry-error span').text('Something went wrong. Please try again.');
                }
                $('.inquiry-error').show();
                $('.inquiry-success').hide();
            }
        });
    });
</script>
@endpush

@endsection