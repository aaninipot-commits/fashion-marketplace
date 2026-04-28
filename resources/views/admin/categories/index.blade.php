@extends('admin.layouts.admin')

@section('page_title', 'Categories')

@section('content')

<div class="admin__card">
    <div class="admin__card__header">
        <h5>All Categories</h5>
        <button class="btn-add" data-bs-toggle="modal" data-bs-target="#createCategoryModal">
            <i class="fa fa-plus"></i> Add Category
        </button>
    </div>
    <div class="admin__card__body" style="padding:0;">

        <div class="alert alert-success print-success-msg mx-3 mt-3" style="display:none;"></div>

        <table class="table mb-0">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Name</th>
                    <th>Gender</th>
                    <th>Slug</th>
                    <th>Products</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody id="categories-table">
                @forelse($categories as $key => $category)
                    <tr id="category-row-{{ $category->id }}">
                        <td>{{ $key + 1 }}</td>
                        <td>{{ $category->name }}</td>
                        <td>
                            <span class="badge-{{ $category->gender }}">{{ ucfirst($category->gender) }}</span>
                        </td>
                        <td>{{ $category->slug }}</td>
                        <td>{{ $category->products_count }}</td>
                        <td>
                            <button class="btn-admin btn-edit" onclick="editCategory({{ $category->id }})">
                                <i class="fa fa-edit"></i> Edit
                            </button>
                            <button class="btn-admin btn-delete ms-1" onclick="deleteCategory({{ $category->id }})">
                                <i class="fa fa-trash"></i> Delete
                            </button>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="text-center" style="color:#999;">No categories found</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<!-- Create Modal -->
<div class="modal fade" id="createCategoryModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Add Category</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form id="createCategoryForm">
                    @csrf
                    <div class="alert alert-danger print-error-msg" style="display:none;"><ul></ul></div>
                    <div class="mb-3">
                        <label class="form-label">Category Name</label>
                        <input type="text" name="name" class="form-control" placeholder="e.g. Tops" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Gender</label>
                        <select name="gender" class="form-select" required>
                            <option value="">Select Gender</option>
                            <option value="mens">Men's</option>
                            <option value="womens">Women's</option>
                            <option value="kids">Kids'</option>
                        </select>
                    </div>
                    <div class="text-end">
                        <button type="submit" class="btn-add">Save Category</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Edit Modal -->
<div class="modal fade" id="editCategoryModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Edit Category</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form id="editCategoryForm">
                    @csrf
                    <input type="hidden" id="edit_category_id">
                    <div class="alert alert-danger print-error-msg" style="display:none;"><ul></ul></div>
                    <div class="mb-3">
                        <label class="form-label">Category Name</label>
                        <input type="text" id="edit_name" name="name" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Gender</label>
                        <select id="edit_gender" name="gender" class="form-select" required>
                            <option value="">Select Gender</option>
                            <option value="mens">Men's</option>
                            <option value="womens">Women's</option>
                            <option value="kids">Kids'</option>
                        </select>
                    </div>
                    <div class="text-end">
                        <button type="submit" class="btn-add">Update Category</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
    // Add CSRF token to all AJAX requests
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    // Create Category
    $('#createCategoryForm').submit(function(e) {
        e.preventDefault();
        let formData = new FormData(this);
        $.ajax({
            type: 'POST',
            url: '{{ route("admin.categories.store") }}',
            data: formData,
            contentType: false,
            processData: false,
            success: function(response) {
                alert(response.success);
                $('#createCategoryModal').modal('hide');
                $('#createCategoryForm').trigger('reset');
                location.reload();
            },
            error: function(response) {
                if (response.status === 422) {
                    $('#createCategoryForm .print-error-msg ul').html('');
                    $('#createCategoryForm .print-error-msg').show();
                    $.each(response.responseJSON.errors, function(key, value) {
                        $('#createCategoryForm .print-error-msg ul').append('<li>' + value + '</li>');
                    });
                } else {
                    alert('Something went wrong. Error: ' + response.status);
                    console.error(response);
                }
            }
        });
    });

    // Edit Category - Load Data
    function editCategory(id) {
        $.get('/admin/categories/' + id, function(data) {
            $('#edit_category_id').val(data.id);
            $('#edit_name').val(data.name);
            $('#edit_gender').val(data.gender);
            $('#editCategoryModal').modal('show');
        }).fail(function(response) {
            alert('Failed to load category data.');
            console.error(response);
        });
    }

    // Update Category
    $('#editCategoryForm').submit(function(e) {
        e.preventDefault();
        let id = $('#edit_category_id').val();
        let formData = new FormData(this);

        $.ajax({
            type: 'POST',
            url: '/admin/categories/' + id,
            data: formData,
            contentType: false,
            processData: false,
            success: function(response) {
                alert(response.success);
                $('#editCategoryModal').modal('hide');
                location.reload();
            },
            error: function(response) {
                if (response.status === 422) {
                    $('#editCategoryForm .print-error-msg ul').html('');
                    $('#editCategoryForm .print-error-msg').show();
                    $.each(response.responseJSON.errors, function(key, value) {
                        $('#editCategoryForm .print-error-msg ul').append('<li>' + value + '</li>');
                    });
                } else {
                    alert('Something went wrong. Error: ' + response.status);
                    console.error(response);
                }
            }
        });
    });

    // Delete Category
    function deleteCategory(id) {
        if (confirm('Are you sure you want to delete this category?')) {
            $.ajax({
                type: 'DELETE',
                url: '/admin/categories/' + id,
                data: { _token: '{{ csrf_token() }}' },
                success: function(response) {
                    alert(response.success);
                    $('#category-row-' + id).remove();
                },
                error: function(response) {
                    alert('Something went wrong.');
                    console.error(response);
                }
            });
        }
    }
</script>
@endpush