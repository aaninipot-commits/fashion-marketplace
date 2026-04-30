@extends('admin.layouts.admin')

@section('page_title', 'Categories')

@section('content')

<!-- Success/Error Messages -->
<div class="alert alert-success print-success-msg" style="display:none; border-radius:0; background:#f0fdf4; color:#27ae60; border:none; padding:12px 16px; margin-bottom:20px;">
    <i class="fa fa-check-circle"></i> <span class="msg-text"></span>
</div>
<div class="alert alert-danger print-error-msg" style="display:none; border-radius:0; background:#fdf0f0; color:#e74c3c; border:none; padding:12px 16px; margin-bottom:20px;">
    <i class="fa fa-exclamation-circle"></i> <span class="msg-text"></span>
</div>

<div class="admin__card">
    <div class="admin__card__header">
        <h5>All Categories</h5>
        <button class="btn-add" id="openAddModal">
            <i class="fa fa-plus"></i> Add Category
        </button>
    </div>
    <div class="admin__card__body" style="padding:0;">
        <table class="table mb-0">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Name</th>
                    <th>Gender</th>
                    <th>Slug</th>
                    <th>Products</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody id="categories-table">
                @forelse($categories as $key => $category)
                    <tr id="category-row-{{ $category->id }}">
                        <td>{{ $key + 1 }}</td>
                        <td id="name-{{ $category->id }}">{{ $category->name }}</td>
                        <td id="gender-{{ $category->id }}">
                            <span class="badge-{{ $category->gender }}">{{ ucfirst($category->gender) }}</span>
                        </td>
                        <td id="slug-{{ $category->id }}">{{ $category->slug }}</td>
                        <td>{{ $category->products_count }}</td>
                        <td id="status-{{ $category->id }}"></td>
                        <td>
                            <button class="btn-admin btn-edit" onclick="editCategory({{ $category->id }})">
                                <i class="fa fa-edit"></i> Edit
                            </button>
                            <button class="btn-admin btn-delete ms-1" onclick="deleteCategory({{ $category->id }}, '{{ $category->name }}')">
                                <i class="fa fa-trash"></i> Delete
                            </button>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="text-center" style="color:#999; padding:30px;">
                            No categories found. Click "Add Category" to create one.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<!-- ===== ADD CATEGORY MODAL ===== -->
<div id="addCategoryModal" style="display:none; position:fixed; top:0; left:0; width:100%; height:100%; background:rgba(0,0,0,0.6); z-index:99999; justify-content:center; align-items:center;">
    <div style="background:#fff; width:100%; max-width:480px; position:relative; box-shadow:0 20px 60px rgba(0,0,0,0.3);">
        <!-- Header -->
        <div style="background:#111; padding:20px 25px; display:flex; align-items:center; justify-content:space-between;">
            <h5 style="color:#fff; font-size:13px; font-weight:800; letter-spacing:2px; text-transform:uppercase; margin:0;">
                <i class="fa fa-plus" style="margin-right:8px; color:#c8a96e;"></i> Add New Category
            </h5>
            <button onclick="closeAddModal()" title="Close"
                style="background:none; border:none; color:#fff; font-size:22px; cursor:pointer; line-height:1; padding:0; width:30px; height:30px; display:flex; align-items:center; justify-content:center; transition:color 0.3s;"
                onmouseover="this.style.color='#c8a96e';" onmouseout="this.style.color='#fff';">
                &times;
            </button>
        </div>
        <!-- Body -->
        <div style="padding:30px 25px;">
            <form id="createCategoryForm">
                @csrf
                <div class="add-error-msg" style="display:none; background:#fdf0f0; color:#e74c3c; padding:10px 15px; margin-bottom:15px; font-size:13px;">
                    <ul style="margin:0; padding-left:20px;"></ul>
                </div>

                <!-- Category Name Dropdown -->
                <div class="mb-4">
                    <label class="form-label">Category Name <span style="color:#e74c3c;">*</span></label>
                    <select name="name" id="add_name" class="form-select" required>
                        <option value="">-- Select Category --</option>
                        <option value="Tops">Tops</option>
                        <option value="Bottoms">Bottoms</option>
                        <option value="Dresses">Dresses</option>
                    </select>
                    <small style="color:#999; font-size:11px; margin-top:5px; display:block;">
                        Select the type of clothing
                    </small>
                </div>

                <!-- Gender Dropdown -->
                <div class="mb-4">
                    <label class="form-label">Gender <span style="color:#e74c3c;">*</span></label>
                    <select name="gender" id="add_gender" class="form-select" required>
                        <option value="">-- Select Gender --</option>
                        <option value="mens">Men's</option>
                        <option value="womens">Women's</option>
                        <option value="kids">Kids'</option>
                    </select>
                    <small style="color:#999; font-size:11px; margin-top:5px; display:block;">
                        Select who this category is for
                    </small>
                </div>

                <!-- Buttons -->
                <div style="display:flex; gap:10px; justify-content:flex-end; margin-top:25px; padding-top:20px; border-top:1px solid #f0f0f0;">
                    <button type="submit" id="addSubmitBtn"
                        style="background:#111; color:#fff; border:none; padding:12px 24px; font-size:11px; font-weight:700; letter-spacing:1px; text-transform:uppercase; cursor:pointer; transition:background 0.3s;"
                        onmouseover="this.style.background='#c8a96e';" onmouseout="this.style.background='#111';">
                        <i class="fa fa-save"></i> Save Category
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- ===== EDIT CATEGORY MODAL ===== -->
<div id="editCategoryModal" style="display:none; position:fixed; top:0; left:0; width:100%; height:100%; background:rgba(0,0,0,0.6); z-index:99999; justify-content:center; align-items:center;">
    <div style="background:#fff; width:100%; max-width:480px; position:relative; box-shadow:0 20px 60px rgba(0,0,0,0.3);">
        <!-- Header -->
        <div style="background:#111; padding:20px 25px; display:flex; align-items:center; justify-content:space-between;">
            <h5 style="color:#fff; font-size:13px; font-weight:800; letter-spacing:2px; text-transform:uppercase; margin:0;">
                <i class="fa fa-edit" style="margin-right:8px; color:#c8a96e;"></i> Edit Category
            </h5>
            <button onclick="closeEditModal()" title="Close without saving"
                style="background:none; border:none; color:#fff; font-size:22px; cursor:pointer; line-height:1; padding:0; width:30px; height:30px; display:flex; align-items:center; justify-content:center; transition:color 0.3s;"
                onmouseover="this.style.color='#c8a96e';" onmouseout="this.style.color='#fff';">
                &times;
            </button>
        </div>
        <!-- Body -->
        <div style="padding:30px 25px;">
            <div style="background:#f0f8ff; color:#2980b9; padding:10px 15px; font-size:12px; margin-bottom:20px; display:flex; align-items:center; gap:8px; border-left:3px solid #2980b9;">
                <i class="fa fa-info-circle"></i>
                Click the <strong style="margin:0 3px;">✕</strong> at the top right to cancel without saving.
            </div>
            <form id="editCategoryForm">
                @csrf
                <input type="hidden" id="edit_category_id">
                <div class="edit-error-msg" style="display:none; background:#fdf0f0; color:#e74c3c; padding:10px 15px; margin-bottom:15px; font-size:13px;">
                    <ul style="margin:0; padding-left:20px;"></ul>
                </div>

                <!-- Category Name Dropdown -->
                <div class="mb-4">
                    <label class="form-label">Category Name <span style="color:#e74c3c;">*</span></label>
                    <select id="edit_name" name="name" class="form-select" required>
                        <option value="">-- Select Category --</option>
                        <option value="Tops">Tops</option>
                        <option value="Bottoms">Bottoms</option>
                        <option value="Dresses">Dresses</option>
                    </select>
                </div>

                <!-- Gender Dropdown -->
                <div class="mb-4">
                    <label class="form-label">Gender <span style="color:#e74c3c;">*</span></label>
                    <select id="edit_gender" name="gender" class="form-select" required>
                        <option value="">-- Select Gender --</option>
                        <option value="mens">Men's</option>
                        <option value="womens">Women's</option>
                        <option value="kids">Kids'</option>
                    </select>
                </div>

                <!-- Buttons -->
                <div style="display:flex; gap:10px; justify-content:flex-end; margin-top:25px; padding-top:20px; border-top:1px solid #f0f0f0;">
                    <button type="submit" id="editSubmitBtn"
                        style="background:#111; color:#fff; border:none; padding:12px 24px; font-size:11px; font-weight:700; letter-spacing:1px; text-transform:uppercase; cursor:pointer; transition:background 0.3s;"
                        onmouseover="this.style.background='#c8a96e';" onmouseout="this.style.background='#111';">
                        <i class="fa fa-save"></i> Update Category
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- ===== DELETE CONFIRMATION MODAL ===== -->
<div id="deleteCategoryModal" style="display:none; position:fixed; top:0; left:0; width:100%; height:100%; background:rgba(0,0,0,0.6); z-index:99999; justify-content:center; align-items:center;">
    <div style="background:#fff; width:100%; max-width:440px; position:relative; box-shadow:0 20px 60px rgba(0,0,0,0.3);">
        <!-- Header -->
        <div style="background:#e74c3c; padding:20px 25px; display:flex; align-items:center; justify-content:space-between;">
            <h5 style="color:#fff; font-size:13px; font-weight:800; letter-spacing:2px; text-transform:uppercase; margin:0;">
                <i class="fa fa-exclamation-triangle" style="margin-right:8px;"></i> Confirm Delete
            </h5>
            <button onclick="closeDeleteModal()"
                style="background:none; border:none; color:#fff; font-size:22px; cursor:pointer; line-height:1; padding:0; width:30px; height:30px; display:flex; align-items:center; justify-content:center;">
                &times;
            </button>
        </div>
        <!-- Body -->
        <div style="padding:30px 25px;">
            <p style="font-size:15px; color:#666; margin-bottom:8px;">Are you sure you want to delete:</p>
            <p style="font-size:20px; font-weight:800; color:#111; margin-bottom:15px;" id="delete_category_name"></p>
            <div style="background:#fdf0f0; color:#e74c3c; padding:12px 15px; font-size:13px; border-left:3px solid #e74c3c;">
                <i class="fa fa-exclamation-triangle"></i>
                This action <strong>cannot be undone</strong>. Products in this category may be affected.
            </div>
        </div>
        <!-- Footer -->
        <div style="padding:15px 25px; border-top:1px solid #f0f0f0; display:flex; gap:10px; justify-content:flex-end;">
            <button onclick="confirmDelete()"
                style="background:#e74c3c; color:#fff; border:none; padding:12px 24px; font-size:11px; font-weight:700; letter-spacing:1px; text-transform:uppercase; cursor:pointer; transition:background 0.3s;"
                onmouseover="this.style.background='#c0392b';" onmouseout="this.style.background='#e74c3c';">
                <i class="fa fa-trash"></i> Yes, Delete It
            </button>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
    let categoryToDelete = null;

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    // ── MODAL CONTROLS ──────────────────────────────────
    $('#openAddModal').click(function() {
        $('#createCategoryForm').trigger('reset');
        $('.add-error-msg').hide();
        $('#addCategoryModal').css('display', 'flex');
    });

    function closeAddModal() {
        $('#addCategoryModal').css('display', 'none');
        $('#createCategoryForm').trigger('reset');
        $('.add-error-msg').hide();
    }

    function closeEditModal() {
        $('#editCategoryModal').css('display', 'none');
        $('.edit-error-msg').hide();
    }

    function closeDeleteModal() {
        $('#deleteCategoryModal').css('display', 'none');
        categoryToDelete = null;
    }

    // Close modals when clicking outside
    $('#addCategoryModal, #editCategoryModal, #deleteCategoryModal').click(function(e) {
        if ($(e.target).is(this)) {
            $(this).css('display', 'none');
        }
    });

    // ── CREATE ──────────────────────────────────────────
    $('#createCategoryForm').submit(function(e) {
        e.preventDefault();
        let submitBtn = $('#addSubmitBtn');
        submitBtn.html('<i class="fa fa-spinner fa-spin"></i> Saving...').prop('disabled', true);

        let formData = new FormData(this);
        $.ajax({
            type: 'POST',
            url: '{{ route("admin.categories.store") }}',
            data: formData,
            contentType: false,
            processData: false,
            success: function(response) {
                closeAddModal();
                showSuccess(response.success);
                setTimeout(() => location.reload(), 1000);
            },
            error: function(response) {
                submitBtn.html('<i class="fa fa-save"></i> Save Category').prop('disabled', false);
                if (response.status === 422) {
                    $('.add-error-msg ul').html('');
                    $('.add-error-msg').show();
                    $.each(response.responseJSON.errors, function(key, value) {
                        $('.add-error-msg ul').append('<li>' + value + '</li>');
                    });
                } else {
                    showError('Something went wrong. Please try again.');
                }
            }
        });
    });

    // ── EDIT - Load Data ────────────────────────────────
    function editCategory(id) {
        $.get('/admin/categories/' + id, function(data) {
            $('#edit_category_id').val(data.id);
            $('#edit_name').val(data.name);
            $('#edit_gender').val(data.gender);
            $('.edit-error-msg').hide();
            $('#editCategoryModal').css('display', 'flex');
        }).fail(function() {
            showError('Failed to load category. Please try again.');
        });
    }

    // ── UPDATE ──────────────────────────────────────────
    $('#editCategoryForm').submit(function(e) {
        e.preventDefault();
        let id = $('#edit_category_id').val();
        let submitBtn = $('#editSubmitBtn');
        submitBtn.html('<i class="fa fa-spinner fa-spin"></i> Updating...').prop('disabled', true);

        let formData = new FormData(this);
        $.ajax({
            type: 'POST',
            url: '/admin/categories/' + id,
            data: formData,
            contentType: false,
            processData: false,
            success: function(response) {
                closeEditModal();
                submitBtn.html('<i class="fa fa-save"></i> Update Category').prop('disabled', false);

                let gender = response.category.gender;
                let badgeClass = 'badge-' + gender;
                let genderLabel = gender.charAt(0).toUpperCase() + gender.slice(1);

                $('#name-' + id).text(response.category.name);
                $('#gender-' + id).html('<span class="' + badgeClass + '">' + genderLabel + '</span>');
                $('#slug-' + id).text(response.category.slug);
                $('#status-' + id).html(
                    '<span style="background:#f0fdf4; color:#27ae60; padding:3px 10px; font-size:11px; font-weight:700; letter-spacing:1px;">' +
                    '<i class="fa fa-check"></i> Edited</span>'
                );

                showSuccess(response.success);
            },
            error: function(response) {
                submitBtn.html('<i class="fa fa-save"></i> Update Category').prop('disabled', false);
                if (response.status === 422) {
                    $('.edit-error-msg ul').html('');
                    $('.edit-error-msg').show();
                    $.each(response.responseJSON.errors, function(key, value) {
                        $('.edit-error-msg ul').append('<li>' + value + '</li>');
                    });
                } else {
                    showError('Something went wrong. Please try again.');
                }
            }
        });
    });

    // ── DELETE ──────────────────────────────────────────
    function deleteCategory(id, name) {
        categoryToDelete = id;
        $('#delete_category_name').text('"' + name + '"');
        $('#deleteCategoryModal').css('display', 'flex');
    }

    function confirmDelete() {
        if (!categoryToDelete) return;
        $.ajax({
            type: 'DELETE',
            url: '/admin/categories/' + categoryToDelete,
            data: { _token: '{{ csrf_token() }}' },
            success: function(response) {
                closeDeleteModal();
                $('#category-row-' + categoryToDelete).fadeOut(400, function() {
                    $(this).remove();
                });
                showSuccess(response.success);
                categoryToDelete = null;
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