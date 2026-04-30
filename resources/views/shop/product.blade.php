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
                <div style="background:#f9f9f9; padding:30px; text-align:center;">
                    @if($product->image)
                        <img src="{{ asset($product->image) }}"
                            alt="{{ $product->name }}"
                            style="max-width:100%; max-height:500px; object-fit:contain;">
                    @else
                        <img src="{{ asset('img/product/product-1.jpg') }}"
                            alt="{{ $product->name }}"
                            style="max-width:100%; max-height:500px; object-fit:contain;">
                    @endif
                </div>
            </div>

            <!-- Product Details -->
            <div class="col-lg-6">
                <div style="padding:20px 0;">

                    <!-- Category & Seller -->
                    <div style="display:flex; gap:10px; margin-bottom:15px; flex-wrap:wrap;">
                        <span style="background:#f0f0f0; color:#666; padding:4px 12px; font-size:11px; font-weight:700; letter-spacing:1px; text-transform:uppercase;">
                            {{ ucfirst($product->category->gender) }} - {{ $product->category->name }}
                        </span>
                        <span style="background:#f9f4ec; color:#c8a96e; padding:4px 12px; font-size:11px; font-weight:700; letter-spacing:1px; text-transform:uppercase;">
                            {{ $product->seller->shop_name ?? $product->seller->name }}
                        </span>
                    </div>

                    <!-- Product Name -->
                    <h2 style="font-size:32px; font-weight:800; color:#111; margin-bottom:15px; line-height:1.2;">
                        {{ $product->name }}
                    </h2>

                    <!-- Price -->
                    <div style="font-size:28px; font-weight:800; color:#c8a96e; margin-bottom:20px;">
                        ₱{{ number_format($product->price, 2) }}
                    </div>

                    <!-- Stock Status -->
                    <div style="margin-bottom:20px;">
                        @if($product->stock <= 0)
                            <span style="background:#fdf0f0; color:#e74c3c; padding:6px 16px; font-size:12px; font-weight:700; letter-spacing:1px;">
                                Out of Stock
                            </span>
                        @elseif($product->stock <= 5)
                            <span style="background:#fff8f0; color:#f39c12; padding:6px 16px; font-size:12px; font-weight:700; letter-spacing:1px;">
                                Low Stock — Only {{ $product->stock }} left!
                            </span>
                        @else
                            <span style="background:#f0fdf4; color:#27ae60; padding:6px 16px; font-size:12px; font-weight:700; letter-spacing:1px;">
                                In Stock ({{ $product->stock }} available)
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
                        @if($product->size)
                            <p style="font-size:13px; color:#444; margin-bottom:8px;">
                                <strong>Size:</strong> {{ $product->size }}
                            </p>
                        @endif
                        @if($product->color)
                            <p style="font-size:13px; color:#444; margin-bottom:8px;">
                                <strong>Color:</strong> {{ $product->color }}
                            </p>
                        @endif
                    </div>

                    <!-- Inquiry Button -->
                    @if($product->stock > 0)
                        <button onclick="document.getElementById('inquiry-form').scrollIntoView({behavior:'smooth'})"
                            style="background:#111; color:#fff; border:none; padding:15px 40px; font-size:12px; font-weight:700; letter-spacing:3px; text-transform:uppercase; cursor:pointer; transition:background 0.3s; margin-bottom:10px;"
                            onmouseover="this.style.background='#c8a96e'"
                            onmouseout="this.style.background='#111'">
                            Send Inquiry
                        </button>
                    @endif

                    <!-- Seller Info -->
                    <div style="background:#f9f9f9; padding:20px; margin-top:20px;">
                        <p style="font-size:11px; letter-spacing:2px; text-transform:uppercase; color:#999; margin-bottom:8px;">Sold by</p>
                        <p style="font-size:15px; font-weight:700; color:#111; margin-bottom:5px;">
                            {{ $product->seller->shop_name ?? $product->seller->name }}
                        </p>
                        @if($product->seller->shop_description)
                            <p style="font-size:13px; color:#666;">{{ $product->seller->shop_description }}</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <!-- Inquiry Form -->
        @if($product->stock > 0)
        <div class="row mt-5" id="inquiry-form">
            <div class="col-lg-8 offset-lg-2">
                <div style="background:#fff; padding:40px; box-shadow:0 2px 20px rgba(0,0,0,0.08);">
                    <h4 style="font-size:16px; font-weight:800; letter-spacing:2px; text-transform:uppercase; margin-bottom:25px; color:#111;">
                        Send Inquiry to Seller
                    </h4>

                    <div class="alert alert-success print-success-msg" style="display:none; border-radius:0; background:#f0fdf4; color:#27ae60; border:none; padding:12px 16px;"></div>
                    <div class="alert alert-danger print-error-msg" style="display:none; border-radius:0; background:#fdf0f0; color:#e74c3c; border:none; padding:12px 16px;"></div>

                    <form id="inquiryForm">
                        @csrf
                        <input type="hidden" name="product_id" value="{{ $product->id }}">
                        <div class="mb-3">
                            <label style="font-size:11px; font-weight:700; letter-spacing:1px; text-transform:uppercase; color:#111; display:block; margin-bottom:8px;">
                                Your Message
                            </label>
                            <textarea name="message" id="inquiry_message" rows="4"
                                placeholder="Ask about this product e.g. 'Is this still available in size M?'"
                                style="width:100%; border:1px solid #e8e8e8; padding:12px 15px; font-size:14px; outline:none; resize:none; font-family:inherit;"
                                required></textarea>
                        </div>
                        <button type="submit"
                            style="background:#111; color:#fff; border:none; padding:14px 40px; font-size:11px; font-weight:700; letter-spacing:3px; text-transform:uppercase; cursor:pointer; transition:background 0.3s;"
                            onmouseover="this.style.background='#c8a96e'"
                            onmouseout="this.style.background='#111'">
                            Send Message
                        </button>
                    </form>
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
                            data-setbg="{{ $related->image ? asset('storage/' . $related->image) : asset('img/product/product-1.jpg') }}">
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
    $('#inquiryForm').submit(function(e) {
        e.preventDefault();
        let formData = new FormData(this);
        $.ajax({
            type: 'POST',
            url: '{{ route("inquiry.send") }}',
            data: formData,
            contentType: false,
            processData: false,
            success: function(response) {
                $('.print-success-msg').text(response.success).show();
                $('.print-error-msg').hide();
                $('#inquiry_message').val('');
                setTimeout(function() {
                    $('.print-success-msg').hide();
                }, 3000);
            },
            error: function(response) {
                if (response.status === 422) {
                    $('.print-error-msg').text('Please enter a message.').show();
                } else {
                    $('.print-error-msg').text('Something went wrong.').show();
                }
            }
        });
    });
</script>
@endpush

@endsection