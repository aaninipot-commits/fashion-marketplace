@extends('admin.layouts.admin')

@section('page_title', 'Products')

@section('content')

<div class="admin__card">
    <div class="admin__card__header">
        <h5>All Products</h5>
        <button class="btn-add" data-bs-toggle="modal" data-bs-target="#createProductModal">
            <i class="fa fa-plus"></i> Add Product
        </button>
    </div>
    <div class="admin__card__body" style="padding:0;">
        <table class="table mb-0">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Image</th>
                    <th>Name</th>
                    <th>Category</th>
                    <th>Price</th>
                    <th>Stock</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($products as $key => $product)
                    <tr id="product-row-{{ $product->id }}">
                        <td>{{ $key + 1 }}</td>
                        <td>
                            @if($product->image)
                                <img src="{{ asset('storage/' . $product->image) }}" class="product__img" alt="">
                            @else
                                <div class="product__img__placeholder"><i class="fa fa-image"></i></div>
                            @endif
                        </td>
                        <td>{{ $product->name }}</td>
                        <td>{{ $product->category->name }} <br>
                            <span class="badge-{{ $product->category->gender }}">{{ ucfirst($product->category->gender) }}</span>
                        </td>
                        <td>₱{{ number_format($product->price, 2) }}</td>
                        <td>{{ $product->stock }}</td>
                        <td><span class="badge-{{ $product->status }}">{{ ucfirst($product->status) }}</span></td>
                        <td>
                            <button class="btn-admin btn-edit" onclick="editProduct({{ $product->id }})">
                                <i class="fa fa-edit"></i> Edit
                            </button>
                            <button class="btn-admin btn-delete ms-1" onclick="deleteProduct({{ $product->id }})">
                                <i class="fa fa-trash"></i> Delete
                            </button>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="8" class="text-center" style="color:#999;">No products found</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<!-- Create Modal -->
<div class="modal fade" id="createProductModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Add Product</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form id="createProductForm" enctype="multipart/form-data">
                    <div class="alert alert-danger print-error-msg" style="display:none;"><ul></ul></div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Product Name</label>
                            <input type="text" name="name" class="form-control" placeholder="Product name" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Category</label>
                            <select name="category_id" class="form-select" required>
                                <option value="">Select Category</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}">{{ ucfirst($category->gender) }} - {{ $category->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Price (₱)</label>
                            <input type="number" name="price" class="form-control" placeholder="0.00" step="0.01" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Stock</label>
                            <input type="number" name="stock" class="form-control" placeholder="0" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Size</label>
                            <input type="text" name="size" class="form-control" placeholder="e.g. S, M, L, XL">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Color</label>
                            <input type="text" name="color" class="form-control" placeholder="e.g. Red, Blue">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Status</label>
                            <select name="status" class="form-select" required>
                                <option value="available">Available</option>
                                <option value="unavailable">Unavailable</option>
                            </select>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Product Image</label>
                            <input type="file" name="image" class="form-control" accept="image/*">
                        </div>
                        <div class="col-md-12 mb-3">
                            <label class="form-label">Description</label>
                            <textarea name="description" class="form-control" rows="3" placeholder="Product description"></textarea>
                        </div>
                    </div>
                    <div class="text-end">
                        <button type="submit" class="btn-add">Save Product</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Edit Modal -->
<div class="modal fade" id="editProductModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Edit Product</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form id="editProductForm" enctype="multipart/form-data">
                    <input type="hidden" id="edit_product_id">
                    <div class="alert alert-danger print-error-msg" style="display:none;"><ul></ul></div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Product Name</label>
                            <input type="text" id="edit_product_name" name="name" class="form-control" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Category</label>
                            <select id="edit_product_category" name="category_id" class="form-select" required>
                                <option value="">Select Category</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}">{{ ucfirst($category->gender) }} - {{ $category->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Price (₱)</label>
                            <input type="number" id="edit_product_price" name="price" class="form-control" step="0.01" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Stock</label>
                            <input type="number" id="edit_product_stock" name="stock" class="form-control" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Size</label>
                            <input type="text" id="edit_product_size" name="size" class="form-control">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Color</label>
                            <input type="text" id="edit_product_color" name="color" class="form-control">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Status</label>
                            <select id="edit_product_status" name="status" class="form-select" required>
                                <option value="available">Available</option>
                                <option value="unavailable">Unavailable</option>
                            </select>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Product Image</label>
                            <input type="file" name="image" class="form-control" accept="image/*">
                            <small class="text-muted">Leave empty to keep current image</small>
                        </div>
                        <div class="col-md-12 mb-3">
                            <label class="form-label">Description</label>
                            <textarea id="edit_product_description" name="description" class="form-control" rows="3"></textarea>
                        </div>
                    </div>
                    <div class="text-end">
                        <button type="submit" class="btn-add">Update Product</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
    // Create Product
    $('#createProductForm').submit(function(e) {
        e.preventDefault();
        let formData = new FormData(this);
        $.ajax({
            type: 'POST',
            url: '{{ route("admin.products.store") }}',
            data: formData,
            contentType: false,
            processData: false,
            success: function(response) {
                alert(response.success);
                $('#createProductModal').modal('hide');
                $('#createProductForm').trigger('reset');
                location.reload();
            },
            error: function(response) {
                if (response.status === 422) {
                    $('#createProductForm .print-error-msg ul').html('');
                    $('#createProductForm .print-error-msg').show();
                    $.each(response.responseJSON.errors, function(key, value) {
                        $('#createProductForm .print-error-msg ul').append('<li>' + value + '</li>');
                    });
                } else {
                    alert('Something went wrong.');
                }
            }
        });
    });

    // Edit Product - Load Data
    function editProduct(id) {
        $.get('/admin/products/' + id, function(data) {
            $('#edit_product_id').val(data.id);
            $('#edit_product_name').val(data.name);
            $('#edit_product_category').val(data.category_id);
            $('#edit_product_price').val(data.price);
            $('#edit_product_stock').val(data.stock);
            $('#edit_product_size').val(data.size);
            $('#edit_product_color').val(data.color);
            $('#edit_product_status').val(data.status);
            $('#edit_product_description').val(data.description);
            $('#editProductModal').modal('show');
        });
    }

    // Update Product
    $('#editProductForm').submit(function(e) {
        e.preventDefault();
        let id = $('#edit_product_id').val();
        let formData = new FormData(this);
        $.ajax({
            type: 'POST',
            url: '/admin/products/' + id,
            data: formData,
            contentType: false,
            processData: false,
            success: function(response) {
                alert(response.success);
                $('#editProductModal').modal('hide');
                location.reload();
            },
            error: function(response) {
                if (response.status === 422) {
                    $('#editProductForm .print-error-msg ul').html('');
                    $('#editProductForm .print-error-msg').show();
                    $.each(response.responseJSON.errors, function(key, value) {
                        $('#editProductForm .print-error-msg ul').append('<li>' + value + '</li>');
                    });
                } else {
                    alert('Something went wrong.');
                }
            }
        });
    });

    // Delete Product
    function deleteProduct(id) {
        if (confirm('Are you sure you want to delete this product?')) {
            $.ajax({
                type: 'DELETE',
                url: '/admin/products/' + id,
                data: { _token: '{{ csrf_token() }}' },
                success: function(response) {
                    alert(response.success);
                    $('#product-row-' + id).remove();
                },
                error: function() {
                    alert('Something went wrong.');
                }
            });
        }
    }
</script>
@endpush