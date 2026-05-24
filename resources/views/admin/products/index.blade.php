@extends('admin.layouts.admin')

@section('page_title', 'Products')

@section('content')

<!-- Success/Error Messages -->
<div class="print-success-msg" style="display:none; background:#f0fdf4; color:#27ae60; border-left:4px solid #27ae60; padding:12px 16px; margin-bottom:20px; font-size:13px; font-weight:600;">
    <i class="fa fa-check-circle"></i> <span class="msg-text"></span>
</div>
<div class="print-error-msg" style="display:none; background:#fdf0f0; color:#e74c3c; border-left:4px solid #e74c3c; padding:12px 16px; margin-bottom:20px; font-size:13px; font-weight:600;">
    <i class="fa fa-exclamation-circle"></i> <span class="msg-text"></span>
</div>

<div class="admin__card">
    <div class="admin__card__header">
        <h5>All Products</h5>
        <button class="btn-add" id="openAddProductModal">
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
            <tbody id="products-table">
                @forelse($products as $key => $product)
                    <tr id="product-row-{{ $product->id }}">
                        <td>{{ $key + 1 }}</td>
                        <td>
                            @if($product->image)
                                <img src="{{ asset($product->image) }}" class="product__img" alt="">
                            @else
                                <div class="product__img__placeholder"><i class="fa fa-image"></i></div>
                            @endif
                        </td>
                        <td><strong>{{ $product->name }}</strong></td>
                        <td>
                            {{ $product->category->name }}
                            <br>
                            <span class="badge-{{ $product->category->gender }}">{{ ucfirst($product->category->gender) }}</span>
                        </td>
                        <td>₱{{ number_format($product->price, 2) }}</td>
                        <td>
                            <span style="font-weight:700; color:{{ $product->stock <= 0 ? '#e74c3c' : ($product->stock <= 5 ? '#f39c12' : '#27ae60') }};">
                                {{ $product->stock }}
                            </span>
                        </td>
                        <td>
                            <span class="badge-{{ $product->status }}">{{ ucfirst($product->status) }}</span>
                        </td>
                        <td>
                            <button class="btn-admin btn-edit" onclick="editProduct({{ $product->id }})">
                                <i class="fa fa-edit"></i> Edit
                            </button>
                            <button class="btn-admin btn-delete ms-1" onclick="deleteProduct({{ $product->id }}, '{{ addslashes($product->name) }}')">
                                <i class="fa fa-trash"></i> Delete
                            </button>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="8" class="text-center" style="color:#999; padding:40px;">
                            <i class="fa fa-shopping-bag" style="font-size:32px; display:block; margin-bottom:10px; color:#ddd;"></i>
                            No products found. Click "Add Product" to create one.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<!-- ===== ADD PRODUCT MODAL ===== -->
<div id="addProductModal" style="display:none; position:fixed; top:0; left:0; width:100%; height:100%; background:rgba(0,0,0,0.6); z-index:99999; justify-content:center; align-items:center;">
    <div style="background:#fff; width:100%; max-width:640px; max-height:90vh; overflow-y:auto; position:relative; box-shadow:0 20px 60px rgba(0,0,0,0.3);">
        <!-- Header -->
        <div style="background:#111; padding:20px 25px; display:flex; align-items:center; justify-content:space-between; position:sticky; top:0; z-index:1;">
            <h5 style="color:#fff; font-size:13px; font-weight:800; letter-spacing:2px; text-transform:uppercase; margin:0;">
                <i class="fa fa-plus" style="margin-right:8px; color:#c8a96e;"></i> Add New Product
            </h5>
            <button onclick="closeAddProductModal()" title="Close"
                style="background:none; border:none; color:#fff; font-size:22px; cursor:pointer; line-height:1; padding:0; width:30px; height:30px; display:flex; align-items:center; justify-content:center;"
                onmouseover="this.style.color='#c8a96e';" onmouseout="this.style.color='#fff';">
                &times;
            </button>
        </div>
        <!-- Body -->
        <div style="padding:30px 25px;">
            <form id="createProductForm" enctype="multipart/form-data">
                @csrf
                <div class="add-product-error" style="display:none; background:#fdf0f0; color:#e74c3c; padding:10px 15px; margin-bottom:15px; font-size:13px;">
                    <ul style="margin:0; padding-left:20px;"></ul>
                </div>
                <div class="row">
                    <!-- Product Name -->
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Product Name <span style="color:#e74c3c;">*</span></label>
                        <input type="text" name="name" class="form-control" placeholder="e.g. Floral Summer Dress" required>
                    </div>
                    <!-- Category -->
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Category <span style="color:#e74c3c;">*</span></label>
                        <select name="category_id" class="form-select" required>
                            <option value="">-- Select Category --</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}">
                                    {{ ucfirst($category->gender) }} - {{ $category->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <!-- Price -->
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Price (₱) <span style="color:#e74c3c;">*</span></label>
                        <input type="number" name="price" class="form-control" placeholder="0.00" step="0.01" min="0" required>
                    </div>
                    <!-- Stock -->
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Stock <span style="color:#e74c3c;">*</span></label>
                        <input type="number" name="stock" class="form-control" placeholder="0" min="0" required>
                    </div>
                    <!-- Sizes (multiple) -->
<div class="col-md-6 mb-3">
    <label class="form-label">Available Sizes</label>
    <div style="display:flex; flex-wrap:wrap; gap:8px; padding:10px; border:1px solid #e8e8e8; background:#fafafa;">
        @foreach(['XS','S','M','L','XL','XXL','Free Size'] as $size)
            <label style="display:flex; align-items:center; gap:5px; font-size:12px; cursor:pointer; padding:5px 10px; border:1px solid #e8e8e8; background:#fff; transition:all 0.2s;"
                onmouseover="this.style.borderColor='#111';" onmouseout="this.style.borderColor='#e8e8e8';">
                <input type="checkbox" name="sizes[]" value="{{ $size }}"
                    style="accent-color:#111;">
                {{ $size }}
            </label>
        @endforeach
    </div>
    <small style="color:#999; font-size:11px; margin-top:4px; display:block;">Select all available sizes</small>
</div>
                    <!-- Color -->
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Color</label>
                        <input type="text" name="color" class="form-control" placeholder="e.g. Red, Blue, White">
                    </div>
                    <!-- Status -->
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Status <span style="color:#e74c3c;">*</span></label>
                        <select name="status" class="form-select" required>
                            <option value="available">Available</option>
                            <option value="unavailable">Unavailable</option>
                        </select>
                    </div>
                    <!-- Image -->
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Product Image</label>
                        <input type="file" name="image" class="form-control" accept="image/*">
                        <small style="color:#999; font-size:11px;">JPG, PNG, GIF (max 2MB)</small>
                    </div>
                    <!-- Description -->
                    <div class="col-md-12 mb-3">
                        <label class="form-label">Description</label>
                        <textarea name="description" class="form-control" rows="3" placeholder="Describe your product..."></textarea>
                    </div>
                </div>
                <!-- Buttons -->
                <div style="display:flex; gap:10px; justify-content:flex-end; margin-top:20px; padding-top:20px; border-top:1px solid #f0f0f0;">
                    <button type="submit" id="addProductBtn"
                        style="background:#111; color:#fff; border:none; padding:12px 24px; font-size:11px; font-weight:700; letter-spacing:1px; text-transform:uppercase; cursor:pointer; transition:background 0.3s;"
                        onmouseover="this.style.background='#c8a96e';" onmouseout="this.style.background='#111';">
                        <i class="fa fa-save"></i> Save Product
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- ===== EDIT PRODUCT MODAL ===== -->
<div id="editProductModal" style="display:none; position:fixed; top:0; left:0; width:100%; height:100%; background:rgba(0,0,0,0.6); z-index:99999; justify-content:center; align-items:center;">
    <div style="background:#fff; width:100%; max-width:640px; max-height:90vh; overflow-y:auto; position:relative; box-shadow:0 20px 60px rgba(0,0,0,0.3);">
        <!-- Header -->
        <div style="background:#111; padding:20px 25px; display:flex; align-items:center; justify-content:space-between; position:sticky; top:0; z-index:1;">
            <h5 style="color:#fff; font-size:13px; font-weight:800; letter-spacing:2px; text-transform:uppercase; margin:0;">
                <i class="fa fa-edit" style="margin-right:8px; color:#c8a96e;"></i> Edit Product
            </h5>
            <button onclick="closeEditProductModal()" title="Close without saving"
                style="background:none; border:none; color:#fff; font-size:22px; cursor:pointer; line-height:1; padding:0; width:30px; height:30px; display:flex; align-items:center; justify-content:center;"
                onmouseover="this.style.color='#c8a96e';" onmouseout="this.style.color='#fff';">
                &times;
            </button>
        </div>
        <!-- Body -->
        <div style="padding:30px 25px;">
            <div style="background:#f0f8ff; color:#2980b9; padding:10px 15px; font-size:12px; margin-bottom:20px; border-left:3px solid #2980b9;">
                <i class="fa fa-info-circle"></i>
                Click <strong>✕</strong> at the top right to cancel without saving changes.
            </div>
            <form id="editProductForm" enctype="multipart/form-data">
                @csrf
                <input type="hidden" id="edit_product_id">
                <div class="edit-product-error" style="display:none; background:#fdf0f0; color:#e74c3c; padding:10px 15px; margin-bottom:15px; font-size:13px;">
                    <ul style="margin:0; padding-left:20px;"></ul>
                </div>
                <div class="row">
                    <!-- Product Name -->
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Product Name <span style="color:#e74c3c;">*</span></label>
                        <input type="text" id="edit_product_name" name="name" class="form-control" required>
                    </div>
                    <!-- Category -->
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Category <span style="color:#e74c3c;">*</span></label>
                        <select id="edit_product_category" name="category_id" class="form-select" required>
                            <option value="">-- Select Category --</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}">
                                    {{ ucfirst($category->gender) }} - {{ $category->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <!-- Price -->
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Price (₱) <span style="color:#e74c3c;">*</span></label>
                        <input type="number" id="edit_product_price" name="price" class="form-control" step="0.01" min="0" required>
                    </div>
                    <!-- Stock -->
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Stock <span style="color:#e74c3c;">*</span></label>
                        <input type="number" id="edit_product_stock" name="stock" class="form-control" min="0" required>
                    </div>
                    <!-- Sizes (multiple) -->
<div class="col-md-6 mb-3">
    <label class="form-label">Available Sizes</label>
    <div id="edit_sizes_container" style="display:flex; flex-wrap:wrap; gap:8px; padding:10px; border:1px solid #e8e8e8; background:#fafafa;">
        @foreach(['XS','S','M','L','XL','XXL','Free Size'] as $size)
            <label style="display:flex; align-items:center; gap:5px; font-size:12px; cursor:pointer; padding:5px 10px; border:1px solid #e8e8e8; background:#fff; transition:all 0.2s;"
                onmouseover="this.style.borderColor='#111';" onmouseout="this.style.borderColor='#e8e8e8';">
                <input type="checkbox" name="sizes[]" value="{{ $size }}" class="edit-size-checkbox"
                    style="accent-color:#111;">
                {{ $size }}
            </label>
        @endforeach
    </div>
    <small style="color:#999; font-size:11px; margin-top:4px; display:block;">Select all available sizes</small>
</div>
                    <!-- Color -->
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Color</label>
                        <input type="text" id="edit_product_color" name="color" class="form-control" placeholder="e.g. Red, Blue, White">
                    </div>
                    <!-- Status -->
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Status <span style="color:#e74c3c;">*</span></label>
                        <select id="edit_product_status" name="status" class="form-select" required>
                            <option value="available">Available</option>
                            <option value="unavailable">Unavailable</option>
                        </select>
                    </div>
                    <!-- Image -->
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Product Image</label>
                        <div id="current_image_preview" style="margin-bottom:8px;"></div>
                        <input type="file" name="image" class="form-control" accept="image/*">
                        <small style="color:#999; font-size:11px;">Leave empty to keep current image</small>
                    </div>
                    <!-- Description -->
                    <div class="col-md-12 mb-3">
                        <label class="form-label">Description</label>
                        <textarea id="edit_product_description" name="description" class="form-control" rows="3"></textarea>
                    </div>
                </div>
                <!-- Buttons -->
                <div style="display:flex; gap:10px; justify-content:flex-end; margin-top:20px; padding-top:20px; border-top:1px solid #f0f0f0;">
                    <button type="submit" id="editProductBtn"
                        style="background:#111; color:#fff; border:none; padding:12px 24px; font-size:11px; font-weight:700; letter-spacing:1px; text-transform:uppercase; cursor:pointer; transition:background 0.3s;"
                        onmouseover="this.style.background='#c8a96e';" onmouseout="this.style.background='#111';">
                        <i class="fa fa-save"></i> Update Product
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- ===== DELETE CONFIRMATION MODAL ===== -->
<div id="deleteProductModal" style="display:none; position:fixed; top:0; left:0; width:100%; height:100%; background:rgba(0,0,0,0.6); z-index:99999; justify-content:center; align-items:center;">
    <div style="background:#fff; width:100%; max-width:440px; position:relative; box-shadow:0 20px 60px rgba(0,0,0,0.3);">
        <!-- Header -->
        <div style="background:#e74c3c; padding:20px 25px; display:flex; align-items:center; justify-content:space-between;">
            <h5 style="color:#fff; font-size:13px; font-weight:800; letter-spacing:2px; text-transform:uppercase; margin:0;">
                <i class="fa fa-exclamation-triangle" style="margin-right:8px;"></i> Confirm Delete
            </h5>
            <button onclick="closeDeleteProductModal()"
                style="background:none; border:none; color:#fff; font-size:22px; cursor:pointer; line-height:1; padding:0; width:30px; height:30px; display:flex; align-items:center; justify-content:center;">
                &times;
            </button>
        </div>
        <!-- Body -->
        <div style="padding:30px 25px;">
            <p style="font-size:15px; color:#666; margin-bottom:8px;">Are you sure you want to delete:</p>
            <p style="font-size:20px; font-weight:800; color:#111; margin-bottom:15px;" id="delete_product_name"></p>
            <div style="background:#fdf0f0; color:#e74c3c; padding:12px 15px; font-size:13px; border-left:3px solid #e74c3c;">
                <i class="fa fa-exclamation-triangle"></i>
                This action <strong>cannot be undone</strong>.
            </div>
        </div>
        <!-- Footer -->
        <div style="padding:15px 25px; border-top:1px solid #f0f0f0; display:flex; gap:10px; justify-content:flex-end;">
            <button onclick="closeDeleteProductModal()"
                style="background:#f0f0f0; color:#111; border:none; padding:12px 24px; font-size:11px; font-weight:700; letter-spacing:1px; text-transform:uppercase; cursor:pointer;">
                <i class="fa fa-times"></i> Cancel
            </button>
            <button onclick="confirmDeleteProduct()"
                style="background:#e74c3c; color:#fff; border:none; padding:12px 24px; font-size:11px; font-weight:700; letter-spacing:1px; text-transform:uppercase; cursor:pointer;"
                onmouseover="this.style.background='#c0392b';" onmouseout="this.style.background='#e74c3c';">
                <i class="fa fa-trash"></i> Yes, Delete It
            </button>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
    let productToDelete = null;

    $.ajaxSetup({
        headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') }
    });

    // ── MODAL CONTROLS ──────────────────────────────────
    $('#openAddProductModal').click(function() {
        $('#createProductForm').trigger('reset');
        $('.add-product-error').hide();
        $('#current_image_preview').html('');
        $('#addProductModal').css('display', 'flex');
    });

    function closeAddProductModal() {
        $('#addProductModal').css('display', 'none');
        $('#createProductForm').trigger('reset');
        $('.add-product-error').hide();
    }

    function closeEditProductModal() {
        $('#editProductModal').css('display', 'none');
        $('.edit-product-error').hide();
    }

    function closeDeleteProductModal() {
        $('#deleteProductModal').css('display', 'none');
        productToDelete = null;
    }

    // Close modals when clicking outside
    $('#addProductModal, #editProductModal, #deleteProductModal').click(function(e) {
        if ($(e.target).is(this)) {
            $(this).css('display', 'none');
        }
    });

    // ── CREATE PRODUCT ──────────────────────────────────
    $('#createProductForm').submit(function(e) {
        e.preventDefault();
        let btn = $('#addProductBtn');
        btn.html('<i class="fa fa-spinner fa-spin"></i> Saving...').prop('disabled', true);

        let formData = new FormData(this);
        $.ajax({
            type: 'POST',
            url: '{{ route("admin.products.store") }}',
            data: formData,
            contentType: false,
            processData: false,
            success: function(response) {
                closeAddProductModal();
                showSuccess(response.success);
                setTimeout(() => location.reload(), 1000);
            },
            error: function(response) {
                btn.html('<i class="fa fa-save"></i> Save Product').prop('disabled', false);
                if (response.status === 422) {
                    $('.add-product-error ul').html('');
                    $('.add-product-error').show();
                    $.each(response.responseJSON.errors, function(key, value) {
                        $('.add-product-error ul').append('<li>' + value + '</li>');
                    });
                } else {
                    showError('Something went wrong. Please try again.');
                }
            }
        });
    });

    // ── EDIT PRODUCT - Load Data ────────────────────────
    function editProduct(id) {
    $.get('/admin/products/' + id, function(data) {
        $('#edit_product_id').val(data.id);
        $('#edit_product_name').val(data.name);
        $('#edit_product_category').val(data.category_id);
        $('#edit_product_price').val(data.price);
        $('#edit_product_stock').val(data.stock);
        $('#edit_product_color').val(data.color);
        $('#edit_product_status').val(data.status);
        $('#edit_product_description').val(data.description);

        // Uncheck all sizes first
        $('.edit-size-checkbox').prop('checked', false);

        // Check the sizes that the product has
        if (data.sizes_array && data.sizes_array.length > 0) {
            data.sizes_array.forEach(function(size) {
                $('.edit-size-checkbox[value="' + size.trim() + '"]').prop('checked', true);
            });
        }

        // Show current image preview
        if (data.image) {
            $('#current_image_preview').html(
                '<img src="/' + data.image + '" style="width:60px; height:60px; object-fit:cover; border:1px solid #f0f0f0; margin-bottom:5px;" alt="Current Image">' +
                '<br><small style="color:#999; font-size:11px;">Current image</small>'
            );
        } else {
            $('#current_image_preview').html('<small style="color:#999; font-size:11px;">No current image</small>');
        }

        $('.edit-product-error').hide();
        $('#editProductModal').css('display', 'flex');
    }).fail(function() {
        showError('Failed to load product data. Please try again.');
    });
}

    // ── UPDATE PRODUCT ──────────────────────────────────
    $('#editProductForm').submit(function(e) {
        e.preventDefault();
        let id = $('#edit_product_id').val();
        let btn = $('#editProductBtn');
        btn.html('<i class="fa fa-spinner fa-spin"></i> Updating...').prop('disabled', true);

        let formData = new FormData(this);
        $.ajax({
            type: 'POST',
            url: '/admin/products/' + id,
            data: formData,
            contentType: false,
            processData: false,
            success: function(response) {
                closeEditProductModal();
                btn.html('<i class="fa fa-save"></i> Update Product').prop('disabled', false);
                showSuccess(response.success);
                setTimeout(() => location.reload(), 1000);
            },
            error: function(response) {
                btn.html('<i class="fa fa-save"></i> Update Product').prop('disabled', false);
                if (response.status === 422) {
                    $('.edit-product-error ul').html('');
                    $('.edit-product-error').show();
                    $.each(response.responseJSON.errors, function(key, value) {
                        $('.edit-product-error ul').append('<li>' + value + '</li>');
                    });
                } else {
                    showError('Something went wrong. Please try again.');
                }
            }
        });
    });

    // ── DELETE PRODUCT ──────────────────────────────────
    function deleteProduct(id, name) {
        productToDelete = id;
        $('#delete_product_name').text('"' + name + '"');
        $('#deleteProductModal').css('display', 'flex');
    }

    function confirmDeleteProduct() {
        if (!productToDelete) return;
        $.ajax({
            type: 'DELETE',
            url: '/admin/products/' + productToDelete,
            data: { _token: '{{ csrf_token() }}' },
            success: function(response) {
                closeDeleteProductModal();
                $('#product-row-' + productToDelete).fadeOut(400, function() {
                    $(this).remove();
                });
                showSuccess(response.success);
                productToDelete = null;
            },
            error: function() {
                showError('Something went wrong. Please try again.');
            }
        });
    }

    // ── HELPERS ─────────────────────────────────────────
    function showSuccess(msg) {
        $('.print-success-msg .msg-text').text(msg);
        $('.print-success-msg').show();
        setTimeout(() => $('.print-success-msg').fadeOut(), 3000);
    }

    function showError(msg) {
        $('.print-error-msg .msg-text').text(msg);
        $('.print-error-msg').show();
        setTimeout(() => $('.print-error-msg').fadeOut(), 3000);
    }
</script>
@endpush