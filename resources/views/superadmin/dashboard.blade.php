@extends('superadmin.layouts.superadmin')
@section('page_title', 'Dashboard')
@section('content')

<div class="row mb-4">
    <div class="col-lg-3 col-md-6 mb-3">
        <div class="sa-stat" style="border-color:#c8a96e;">
            <div class="sa-stat__icon" style="background:#f9f4ec;">
                <i class="fa fa-store" style="color:#c8a96e;"></i>
            </div>
            <div>
                <div class="sa-stat__number">{{ $stats['total_sellers'] }}</div>
                <div class="sa-stat__label">Total Sellers</div>
            </div>
        </div>
    </div>
    <div class="col-lg-3 col-md-6 mb-3">
        <div class="sa-stat" style="border-color:#2980b9;">
            <div class="sa-stat__icon" style="background:#f0f8ff;">
                <i class="fa fa-users" style="color:#2980b9;"></i>
            </div>
            <div>
                <div class="sa-stat__number">{{ $stats['total_buyers'] }}</div>
                <div class="sa-stat__label">Total Buyers</div>
            </div>
        </div>
    </div>
    <div class="col-lg-3 col-md-6 mb-3">
        <div class="sa-stat" style="border-color:#27ae60;">
            <div class="sa-stat__icon" style="background:#f0fdf4;">
                <i class="fa fa-shopping-bag" style="color:#27ae60;"></i>
            </div>
            <div>
                <div class="sa-stat__number">{{ $stats['total_products'] }}</div>
                <div class="sa-stat__label">Total Products</div>
            </div>
        </div>
    </div>
    <div class="col-lg-3 col-md-6 mb-3">
        <div class="sa-stat" style="border-color:#e74c3c;">
            <div class="sa-stat__icon" style="background:#fdf0f0;">
                <i class="fa fa-headphones" style="color:#e74c3c;"></i>
            </div>
            <div>
                <div class="sa-stat__number">{{ $stats['unread_support'] }}</div>
                <div class="sa-stat__label">Unread Support</div>
            </div>
        </div>
    </div>
</div>

<div class="row mb-4">
    <div class="col-lg-3 col-md-6 mb-3">
        <div class="sa-stat" style="border-color:#f39c12;">
            <div class="sa-stat__icon" style="background:#fff8f0;">
                <i class="fa fa-clock-o" style="color:#f39c12;"></i>
            </div>
            <div>
                <div class="sa-stat__number">{{ $stats['pending_shops'] }}</div>
                <div class="sa-stat__label">Pending Shops</div>
            </div>
        </div>
    </div>
    <div class="col-lg-3 col-md-6 mb-3">
        <div class="sa-stat" style="border-color:#8e44ad;">
            <div class="sa-stat__icon" style="background:#f9f0ff;">
                <i class="fa fa-ban" style="color:#8e44ad;"></i>
            </div>
            <div>
                <div class="sa-stat__number">{{ $stats['banned_users'] }}</div>
                <div class="sa-stat__label">Banned Users</div>
            </div>
        </div>
    </div>
    <div class="col-lg-3 col-md-6 mb-3">
        <div class="sa-stat" style="border-color:#16a085;">
            <div class="sa-stat__icon" style="background:#f0fdf9;">
                <i class="fa fa-comments" style="color:#16a085;"></i>
            </div>
            <div>
                <div class="sa-stat__number">{{ $stats['total_messages'] }}</div>
                <div class="sa-stat__label">Total Inquiries</div>
            </div>
        </div>
    </div>
    <div class="col-lg-3 col-md-6 mb-3">
        <div class="sa-stat" style="border-color:#2c3e50;">
            <div class="sa-stat__icon" style="background:#f0f0f0;">
                <i class="fa fa-envelope" style="color:#2c3e50;"></i>
            </div>
            <div>
                <div class="sa-stat__number">{{ $stats['total_support'] }}</div>
                <div class="sa-stat__label">Support Messages</div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <!-- Recent Sellers -->
    <div class="col-lg-6 mb-4">
        <div class="sa-card">
            <div class="sa-card__header">
                <h5><i class="fa fa-store" style="color:#c8a96e; margin-right:8px;"></i> Recent Sellers</h5>
                <a href="{{ route('superadmin.sellers') }}" style="font-size:11px; color:#c8a96e; text-decoration:none; font-weight:700;">View All</a>
            </div>
            <div style="padding:0;">
                <table class="sa-table">
                    <thead>
                        <tr>
                            <th>Seller</th>
                            <th>Shop</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($recentSellers as $seller)
                            <tr>
                                <td>
                                    <div style="font-weight:700; font-size:13px;">{{ $seller->name }}</div>
                                    <div style="font-size:11px; color:#999;">{{ $seller->email }}</div>
                                </td>
                                <td style="font-size:12px;">{{ $seller->shop_name ?? '—' }}</td>
                                <td>
                                    @if($seller->is_banned)
                                        <span class="badge-banned">Banned</span>
                                    @elseif($seller->is_approved === 'pending')
                                        <span class="badge-pending">Pending</span>
                                    @else
                                        <span class="badge-approved">Active</span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr><td colspan="3" style="text-align:center; color:#999;">No sellers yet</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Recent Support -->
    <div class="col-lg-6 mb-4">
        <div class="sa-card">
            <div class="sa-card__header">
                <h5><i class="fa fa-headphones" style="color:#e74c3c; margin-right:8px;"></i> Recent Support Messages</h5>
                <a href="{{ route('superadmin.support') }}" style="font-size:11px; color:#c8a96e; text-decoration:none; font-weight:700;">View All</a>
            </div>
            <div style="padding:0;">
                <table class="sa-table">
                    <thead>
                        <tr>
                            <th>User</th>
                            <th>Subject</th>
                            <th>Type</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($recentSupport as $msg)
                            <tr>
                                <td style="font-size:12px; font-weight:600;">{{ $msg->name }}</td>
                                <td style="font-size:12px;">{{ Str::limit($msg->subject, 30) }}</td>
                                <td>
                                    <span style="background:#f0f0f0; color:#666; padding:2px 8px; font-size:10px; font-weight:700;">
                                        {{ $msg->type ?? 'General' }}
                                    </span>
                                </td>
                            </tr>
                        @empty
                            <tr><td colspan="3" style="text-align:center; color:#999;">No messages yet</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Recent Products -->
    <div class="col-lg-12">
        <div class="sa-card">
            <div class="sa-card__header">
                <h5><i class="fa fa-shopping-bag" style="color:#27ae60; margin-right:8px;"></i> Recent Products</h5>
                <a href="{{ route('superadmin.products') }}" style="font-size:11px; color:#c8a96e; text-decoration:none; font-weight:700;">View All</a>
            </div>
            <div style="padding:0;">
                <table class="sa-table">
                    <thead>
                        <tr>
                            <th>Product</th>
                            <th>Seller</th>
                            <th>Category</th>
                            <th>Price</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($recentProducts as $product)
                            <tr>
                                <td>
                                    <div style="display:flex; align-items:center; gap:10px;">
                                        @if($product->image)
                                            <img src="{{ asset($product->image) }}" style="width:35px; height:35px; object-fit:cover; border:1px solid #f0f0f0;">
                                        @endif
                                        <span style="font-weight:700; font-size:13px;">{{ $product->name }}</span>
                                    </div>
                                </td>
                                <td style="font-size:12px;">{{ $product->seller->shop_name ?? $product->seller->name }}</td>
                                <td style="font-size:12px;">{{ $product->category->name }}</td>
                                <td style="font-size:13px; font-weight:700; color:#c8a96e;">₱{{ number_format($product->price, 2) }}</td>
                                <td>
                                    <span style="background:{{ $product->status === 'available' ? '#f0fdf4' : '#fdf0f0' }}; color:{{ $product->status === 'available' ? '#27ae60' : '#e74c3c' }}; padding:3px 10px; font-size:10px; font-weight:700;">
                                        {{ ucfirst($product->status) }}
                                    </span>
                                </td>
                            </tr>
                        @empty
                            <tr><td colspan="5" style="text-align:center; color:#999;">No products yet</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

@endsection