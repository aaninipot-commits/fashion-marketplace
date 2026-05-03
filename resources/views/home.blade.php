@extends('layouts.app')

@section('content')

    <!-- Hero Section Begin -->
    <section class="hero">
        <div class="hero__slider owl-carousel">
            <div class="hero__items set-bg" data-setbg="{{ asset('img/hero/hero-1.jpg') }}">
                <div class="container">
                    <div class="row">
                        <div class="col-xl-5 col-lg-7 col-md-8">
                            <div class="hero__text">
                                <h6>New Collection</h6>
                                <h2>Fashion Marketplace 2026</h2>
                                <p>Discover the latest trends in Men's, Women's and Kids' clothing.</p>
                                <a href="{{ route('shop.index') }}" class="primary-btn">Shop now <span class="arrow_right"></span></a>
                                <div class="hero__social">
                                    <a href="#"><i class="fa fa-facebook"></i></a>
                                    <a href="#"><i class="fa fa-twitter"></i></a>
                                    <a href="#"><i class="fa fa-pinterest"></i></a>
                                    <a href="#"><i class="fa fa-instagram"></i></a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="hero__items set-bg" data-setbg="{{ asset('img/hero/hero-2.jpg') }}">
                <div class="container">
                    <div class="row">
                        <div class="col-xl-5 col-lg-7 col-md-8">
                            <div class="hero__text">
                                <h6>Trending Now</h6>
                                <h2>Men's & Women's Collection</h2>
                                <p>Ethically crafted with an unwavering commitment to exceptional quality.</p>
                                <a href="{{ route('shop.index') }}" class="primary-btn">Shop now <span class="arrow_right"></span></a>
                                <div class="hero__social">
                                    <a href="#"><i class="fa fa-facebook"></i></a>
                                    <a href="#"><i class="fa fa-twitter"></i></a>
                                    <a href="#"><i class="fa fa-pinterest"></i></a>
                                    <a href="#"><i class="fa fa-instagram"></i></a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Hero Section End -->

    <!-- Banner Section Begin -->
<section class="banner spad">
    <div class="container">
        <div class="row">
            <div class="col-lg-4 col-md-6 mb-4">
                <div style="position:relative; overflow:hidden; height:400px; background:#f5f5f5;">
                    <img src="{{ asset('img/banner/banner-1.jpg') }}" alt="Men's Collection"
                        style="width:100%; height:100%; object-fit:cover; transition:transform 0.5s;"
                        onmouseover="this.style.transform='scale(1.05)';"
                        onmouseout="this.style.transform='scale(1)';">
                    <div style="position:absolute; bottom:0; left:0; right:0; background:linear-gradient(transparent, rgba(0,0,0,0.7)); padding:30px 25px;">
                        <h2 style="color:#fff; font-size:20px; font-weight:800; margin-bottom:10px; letter-spacing:1px;">Men's Collections 2026</h2>
                        <a href="{{ route('shop.mens') }}"
                            style="color:#c8a96e; font-size:11px; font-weight:700; letter-spacing:3px; text-transform:uppercase; text-decoration:none; display:inline-flex; align-items:center; gap:8px; transition:gap 0.3s;"
                            onmouseover="this.style.gap='12px';" onmouseout="this.style.gap='8px';">
                            Shop Now <i class="fa fa-arrow-right"></i>
                        </a>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-6 mb-4">
                <div style="position:relative; overflow:hidden; height:400px; background:#f5f5f5;">
                    <img src="{{ asset('img/banner/banner-2.jpg') }}" alt="Women's Collection"
                        style="width:100%; height:100%; object-fit:cover; transition:transform 0.5s;"
                        onmouseover="this.style.transform='scale(1.05)';"
                        onmouseout="this.style.transform='scale(1)';">
                    <div style="position:absolute; bottom:0; left:0; right:0; background:linear-gradient(transparent, rgba(0,0,0,0.7)); padding:30px 25px;">
                        <h2 style="color:#fff; font-size:20px; font-weight:800; margin-bottom:10px; letter-spacing:1px;">Women's Collection</h2>
                        <a href="{{ route('shop.womens') }}"
                            style="color:#c8a96e; font-size:11px; font-weight:700; letter-spacing:3px; text-transform:uppercase; text-decoration:none; display:inline-flex; align-items:center; gap:8px; transition:gap 0.3s;"
                            onmouseover="this.style.gap='12px';" onmouseout="this.style.gap='8px';">
                            Shop Now <i class="fa fa-arrow-right"></i>
                        </a>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-6 mb-4">
                <div style="position:relative; overflow:hidden; height:400px; background:#f5f5f5;">
                    <img src="{{ asset('img/banner/banner-3.jpg') }}" alt="Kids' Collection"
                        style="width:100%; height:100%; object-fit:cover; transition:transform 0.5s;"
                        onmouseover="this.style.transform='scale(1.05)';"
                        onmouseout="this.style.transform='scale(1)';">
                    <div style="position:absolute; bottom:0; left:0; right:0; background:linear-gradient(transparent, rgba(0,0,0,0.7)); padding:30px 25px;">
                        <h2 style="color:#fff; font-size:20px; font-weight:800; margin-bottom:10px; letter-spacing:1px;">Kids' Collection 2026</h2>
                        <a href="{{ route('shop.kids') }}"
                            style="color:#c8a96e; font-size:11px; font-weight:700; letter-spacing:3px; text-transform:uppercase; text-decoration:none; display:inline-flex; align-items:center; gap:8px; transition:gap 0.3s;"
                            onmouseover="this.style.gap='12px';" onmouseout="this.style.gap='8px';">
                            Shop Now <i class="fa fa-arrow-right"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- Banner Section End -->

    <!-- Product Section Begin -->
    <section class="product spad">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="section-title">
                        <span>What's New</span>
                        <h2>Featured Products</h2>
                    </div>
                    <ul class="filter__controls">
                        <li class="active" data-filter="*">All</li>
                        <li data-filter=".mens">Men's</li>
                        <li data-filter=".womens">Women's</li>
                        <li data-filter=".kids">Kids'</li>
                    </ul>
                </div>
            </div>
            <div class="row product__filter">
                @forelse($featuredProducts as $product)
                    @php
                        $gender = $product->category->gender ?? 'mens';
                    @endphp
                    <div class="col-lg-3 col-md-6 col-sm-6 mix {{ $gender }}">
                        <div class="product__item">
                            <div class="product__item__pic set-bg"
                                data-setbg="{{ $product->image ? asset($product->image) : asset('img/product/product-1.jpg') }}">
                                @if($product->stock <= 0)
                                    <span class="label" style="background:#e74c3c;">Out of Stock</span>
                                @elseif($product->stock <= 5)
                                    <span class="label" style="background:#f39c12;">Low Stock</span>
                                @else
                                    <span class="label">New</span>
                                @endif
                                <ul class="product__hover">
                                    <li>
                                        <a href="{{ route('shop.product', $product->id) }}">
                                            <img src="{{ asset('img/icon/search.png') }}" alt="">
                                        </a>
                                    </li>
                                </ul>
                            </div>
                            <div class="product__item__text">
                                <h6>{{ $product->name }}</h6>
                                <a href="{{ route('shop.product', $product->id) }}" class="add-cart">+ View Details</a>
                                <div style="font-size:11px; color:#999; margin:5px 0; letter-spacing:1px; text-transform:uppercase;">
                                    {{ $product->seller->shop_name ?? $product->seller->name }}
                                </div>
                                <h5>₱{{ number_format($product->price, 2) }}</h5>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-lg-12 text-center" style="padding:60px 0;">
                        <i class="fa fa-shopping-bag" style="font-size:48px; color:#ddd; margin-bottom:20px; display:block;"></i>
                        <p style="font-size:16px; color:#999;">No products available yet. Check back soon!</p>
                        <a href="{{ route('shop.index') }}"
                            style="background:#111; color:#fff; padding:12px 30px; font-size:11px; font-weight:700; letter-spacing:2px; text-transform:uppercase; text-decoration:none; display:inline-block; margin-top:15px;">
                            Browse Shop
                        </a>
                    </div>
                @endforelse
            </div>

            <!-- View All Button -->
            @if($featuredProducts->count() > 0)
            <div class="row">
                <div class="col-lg-12 text-center" style="margin-top:30px;">
                    <a href="{{ route('shop.index') }}"
                        style="background:#111; color:#fff; padding:14px 40px; font-size:11px; font-weight:700; letter-spacing:3px; text-transform:uppercase; text-decoration:none; display:inline-block; transition:background 0.3s;"
                        onmouseover="this.style.background='#c8a96e'"
                        onmouseout="this.style.background='#111'">
                        View All Products
                    </a>
                </div>
            </div>
            @endif

        </div>
    </section>
    <!-- Product Section End -->

@endsection