@extends('admin.layouts.admin')

@section('page_title', 'Dashboard')

@section('content')

<!-- Stats -->
<div class="row mb-4">
    <div class="col-lg-3 col-md-6">
        <div class="stat__card">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h3>{{ $totalUsers }}</h3>
                    <p>Total Users</p>
                </div>
                <i class="fa fa-users"></i>
            </div>
        </div>
    </div>
    <div class="col-lg-3 col-md-6">
        <div class="stat__card">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h3>{{ $totalCategories }}</h3>
                    <p>Categories</p>
                </div>
                <i class="fa fa-tags"></i>
            </div>
        </div>
    </div>
    <div class="col-lg-3 col-md-6">
        <div class="stat__card">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h3>{{ $totalProducts }}</h3>
                    <p>Products</p>
                </div>
                <i class="fa fa-shopping-bag"></i>
            </div>
        </div>
    </div>
    <div class="col-lg-3 col-md-6">
        <div class="stat__card">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h3>{{ $unreadMessages }}</h3>
                    <p>Unread Messages</p>
                </div>
                <i class="fa fa-comments"></i>
            </div>
        </div>
    </div>
</div>

<!-- Recent Messages & Products -->
<div class="row">
    <div class="col-lg-6">
        <div class="admin__card">
            <div class="admin__card__header">
                <h5>Recent Inquiries</h5>
                <a href="{{ route('admin.messages.index') }}" style="font-size:11px; color:#c8a96e; text-decoration:none; font-weight:700; letter-spacing:1px;">View All</a>
            </div>
            <div class="admin__card__body" style="padding:0;">
                <table class="table mb-0">
                    <thead>
                        <tr>
                            <th>User</th>
                            <th>Product</th>
                            <th>Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($recentMessages as $message)
                            <tr>
                                <td>{{ $message->user->name }}</td>
                                <td>{{ $message->product->name }}</td>
                                <td>{{ $message->created_at->diffForHumans() }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3" class="text-center" style="color:#999;">No messages yet</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div class="col-lg-6">
        <div class="admin__card">
            <div class="admin__card__header">
                <h5>Recent Products</h5>
                <a href="{{ route('admin.products.index') }}" style="font-size:11px; color:#c8a96e; text-decoration:none; font-weight:700; letter-spacing:1px;">View All</a>
            </div>
            <div class="admin__card__body" style="padding:0;">
                <table class="table mb-0">
                    <thead>
                        <tr>
                            <th>Product</th>
                            <th>Category</th>
                            <th>Price</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($recentProducts as $product)
                            <tr>
                                <td>{{ $product->name }}</td>
                                <td>{{ $product->category->name }}</td>
                                <td>₱{{ number_format($product->price, 2) }}</td>
                                <td>
                                    <span class="badge-{{ $product->status }}">{{ ucfirst($product->status) }}</span>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="text-center" style="color:#999;">No products yet</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

@endsection