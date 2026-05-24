@extends('superadmin.layouts.superadmin')
@section('page_title', 'All Products')
@section('content')

<div class="sa-alert-success"></div>

<div class="sa-card">
    <div class="sa-card__header">
        <h5><i class="fa fa-shopping-bag" style="color:#27ae60; margin-right:8px;"></i> All Products</h5>
        <span style="font-size:12px; color:#999;">{{ $products->count() }} total products</span>
    </div>
    <div style="padding:0;">
        <table class="sa-table">
            <thead>
                <tr>
                    <th>Product</th>
                    <th>Seller</th>
                    <th>Category</th>
                    <th>Price</th>
                    <th>Stock</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($products as $product)
                    <tr id="product-row-{{ $product->id }}">
                        <td>
                            <div style="display:flex; align-items:center; gap:10px;">
                                @if($product->image)
                                    <img src="{{ asset($product->image) }}" style="width:40px; height:40px; object-fit:cover; border:1px solid #f0f0f0; flex-shrink:0;">
                                @else
                                    <div style="width:40px; height:40px; background:#f0f0f0; display:flex; align-items:center; justify-content:center; flex-shrink:0;">
                                        <i class="fa fa-image" style="color:#ccc;"></i>
                                    </div>
                                @endif
                                <div>
                                    <div style="font-weight:700; font-size:13px;">{{ $product->name }}</div>
                                    <div style="font-size:11px; color:#999;">{{ Str::limit($product->description, 40) }}</div>
                                </div>
                            </div>
                        </td>
                        <td>
                            <div style="font-size:12px; font-weight:600;">{{ $product->seller->shop_name ?? $product->seller->name }}</div>
                            <div style="font-size:11px; color:#999;">{{ $product->seller->email }}</div>
                        </td>
                        <td>
                            <div style="font-size:12px;">{{ $product->category->name }}</div>
                            <span style="background:#f0f0f0; color:#666; padding:2px 8px; font-size:10px; font-weight:700;">{{ ucfirst($product->category->gender) }}</span>
                        </td>
                        <td style="font-weight:700; color:#c8a96e;">₱{{ number_format($product->price, 2) }}</td>
                        <td style="font-weight:700; color:{{ $product->stock <= 0 ? '#e74c3c' : ($product->stock <= 5 ? '#f39c12' : '#27ae60') }};">
                            {{ $product->stock }}
                        </td>
                        <td>
                            <span style="background:{{ $product->status === 'available' ? '#f0fdf4' : '#fdf0f0' }}; color:{{ $product->status === 'available' ? '#27ae60' : '#e74c3c' }}; padding:3px 10px; font-size:10px; font-weight:700;">
                                {{ ucfirst($product->status) }}
                            </span>
                        </td>
                        <td>
                            <button class="sa-btn sa-btn-delete" onclick="deleteProduct({{ $product->id }}, '{{ addslashes($product->name) }}')">
                                <i class="fa fa-trash"></i> Delete
                            </button>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" style="text-align:center; color:#999; padding:40px;">No products found</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<!-- Delete Modal -->
<div class="sa-modal" id="deleteProductModal">
    <div class="sa-modal__box" style="max-width:440px;">
        <div class="sa-modal__header" style="background:#e74c3c;">
            <h5>Confirm Delete</h5>
            <button onclick="$('#deleteProductModal').css('display','none')">&times;</button>
        </div>
        <div class="sa-modal__body">
            <p style="font-size:15px; color:#666; margin-bottom:8px;">Delete product:</p>
            <p id="delete-product-name" style="font-size:18px; font-weight:800; color:#111; margin-bottom:15px;"></p>
            <div style="display:flex; gap:10px; justify-content:flex-end;">
                <button class="sa-btn sa-btn-primary" onclick="$('#deleteProductModal').css('display','none')">Cancel</button>
                <button class="sa-btn sa-btn-delete" onclick="confirmDeleteProduct()">
                    <i class="fa fa-trash"></i> Yes, Delete
                </button>
            </div>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
    let productToDelete = null;

    function deleteProduct(id, name) {
        productToDelete = id;
        $('#delete-product-name').text('"' + name + '"');
        $('#deleteProductModal').css('display', 'flex');
    }

    function confirmDeleteProduct() {
        $.ajax({
            type: 'DELETE',
            url: '/superadmin/products/' + productToDelete,
            success: function(response) {
                $('#deleteProductModal').css('display', 'none');
                $('#product-row-' + productToDelete).fadeOut(400, function() { $(this).remove(); });
                showSuccess(response.success);
                productToDelete = null;
            }
        });
    }
</script>
@endpush