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
                    <span>Women's Clothing</span>
                </div>
            </div>
        </div>
    </div>
</div>

<section class="product spad">
    <div class="container">

        <!-- Search Bar -->
        <div class="row mb-4">
            <div class="col-lg-12">
                <form action="{{ route('shop.womens') }}" method="GET">
                    <div style="display:flex; gap:10px;">
                        <input type="text" name="search"
                            value="{{ $search ?? '' }}"
                            placeholder="Search women's products..."
                            style="flex:1; border:2px solid #111; padding:12px 20px; font-size:14px; outline:none;">
                        <button type="submit"
                            style="background:#111; color:#fff; border:none; padding:12px 30px; font-size:12px; font-weight:700; letter-spacing:2px; text-transform:uppercase; cursor:pointer;">
                            <i class="fa fa-search"></i> Search
                        </button>
                        @if($search)
                            <a href="{{ route('shop.womens') }}"
                                style="background:#f0f0f0; color:#111; border:none; padding:12px 20px; font-size:12px; font-weight:700; letter-spacing:2px; text-transform:uppercase; cursor:pointer; text-decoration:none; display:flex; align-items:center;">
                                Clear
                            </a>
                        @endif
                    </div>
                </form>
            </div>
        </div>

        <!-- Category Filter -->
<div class="row mb-4">
    <div class="col-lg-12">
        <div style="display:flex; gap:10px; flex-wrap:wrap;">
            <a href="{{ route('shop.index') }}" class="filter-btn {{ request()->routeIs('shop.index') ? 'active' : '' }}">All</a>
            <a href="{{ route('shop.mens') }}" class="filter-btn {{ request()->routeIs('shop.mens') ? 'active' : '' }}">Men's</a>
            <a href="{{ route('shop.womens') }}" class="filter-btn {{ request()->routeIs('shop.womens') ? 'active' : '' }}">Women's</a>
            <a href="{{ route('shop.kids') }}" class="filter-btn {{ request()->routeIs('shop.kids') ? 'active' : '' }}">Kids'</a>
        </div>
    </div>
</div>

        <!-- Products Grid -->
        <div class="row">
            @forelse($products as $product)
                <div class="col-lg-3 col-md-6 col-sm-6 mb-4">
                    <div class="product__item">
                        <div class="product__item__pic set-bg"
                            data-setbg="{{ $product->image ? asset('storage/' . $product->image) : asset('img/product/product-2.jpg') }}">
                            @if($product->stock <= 0)
                                <span class="label" style="background:#e74c3c;">Out of Stock</span>
                            @elseif($product->stock <= 5)
                                <span class="label" style="background:#f39c12;">Low Stock</span>
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
                            <div style="font-size:11px; color:#999;">
                                Stock: {{ $product->stock }}
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-lg-12 text-center" style="padding:60px 0;">
                    <i class="fa fa-shopping-bag" style="font-size:48px; color:#ddd; margin-bottom:20px; display:block;"></i>
                    <p style="font-size:16px; color:#999;">No women's products available yet.</p>
                </div>
            @endforelse
        </div>

    </div>
</section>

@endsection