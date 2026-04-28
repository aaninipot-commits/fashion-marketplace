@extends('admin.layouts.admin')

@section('page_title', 'Users')

@section('content')

<div class="admin__card">
    <div class="admin__card__header">
        <h5>All Users</h5>
        <button class="btn-add" data-bs-toggle="modal" data-bs-target="#createUserModal">
            <i class="fa fa-plus"></i> Add User
        </button>
    </div>
    <div class="admin__card__body" style="padding:0;">
        <table class="table mb-0">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Phone</th>
                    <th>Address</th>
                    <th>Joined</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($users as $key => $user)
                    <tr id="user-row-{{ $user->id }}">
                        <td>{{ $key + 1 }}</td>
                        <td>{{ $user->name }}</td>
                        <td>{{ $user->email }}</td>
                        <td>{{ $user->phone ?? 'N/A' }}</td>
                        <td>{{ $user->address ?? 'N/A' }}</td>
                        <td>{{ $user->created_at->format('M d, Y') }}</td>
                        <td>
                            <button class="btn-admin btn-edit" onclick="editUser({{ $user->id }})">
                                <i class="fa fa-edit"></i> Edit
                            </button>
                            <button class="btn-admin btn-delete ms-1" onclick="deleteUser({{ $user->id }})">
                                <i class="fa fa-trash"></i> Delete
                            </button>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="text-center" style="color:#999;">No users found</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<!-- Create Modal -->
<div class="modal fade" id="createUserModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Add User</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form id="createUserForm">
                    <div class="alert alert-danger print-error-msg" style="display:none;"><ul></ul></div>
                    <div class="mb-3">
                        <label class="form-label">Full Name</label>
                        <input type="text" name="name" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Email</label>
                        <input type="email" name="email" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Password</label>
                        <input type="password" name="password" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Phone</label>
                        <input type="text" name="phone" class="form-control">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Address</label>
                        <input type="text" name="address" class="form-control">
                    </div>
                    <div class="text-end">
                        <button type="submit" class="btn-add">Save User</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Edit Modal -->
<div class="modal fade" id="editUserModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Edit User</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form id="editUserForm">
                    <input type="hidden" id="edit_user_id">
                    <div class="alert alert-danger print-error-msg" style="display:none;"><ul></ul></div>
                    <div class="mb-3">
                        <label class="form-label">Full Name</label>
                        <input type="text" id="edit_user_name" name="name" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Email</label>
                        <input type="email" id="edit_user_email" name="email" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Phone</label>
                        <input type="text" id="edit_user_phone" name="phone" class="form-control">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Address</label>
                        <input type="text" id="edit_user_address" name="address" class="form-control">
                    </div>
                    <div class="text-end">
                        <button type="submit" class="btn-add">Update User</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
    // Create User
    $('#createUserForm').submit(function(e) {
        e.preventDefault();
        let formData = new FormData(this);
        $.ajax({
            type: 'POST',
            url: '{{ route("admin.users.store") }}',
            data: formData,
            contentType: false,
            processData: false,
            success: function(response) {
                alert(response.success);
                $('#createUserModal').modal('hide');
                $('#createUserForm').trigger('reset');
                location.reload();
            },
            error: function(response) {
                if (response.status === 422) {
                    $('#createUserForm .print-error-msg ul').html('');
                    $('#createUserForm .print-error-msg').show();
                    $.each(response.responseJSON.errors, function(key, value) {
                        $('#createUserForm .print-error-msg ul').append('<li>' + value + '</li>');
                    });
                } else {
                    alert('Something went wrong.');
                }
            }
        });
    });

    // Edit User - Load Data
    function editUser(id) {
        $.get('/admin/users/' + id, function(data) {
            $('#edit_user_id').val(data.id);
            $('#edit_user_name').val(data.name);
            $('#edit_user_email').val(data.email);
            $('#edit_user_phone').val(data.phone);
            $('#edit_user_address').val(data.address);
            $('#editUserModal').modal('show');
        });
    }

    // Update User
    $('#editUserForm').submit(function(e) {
        e.preventDefault();
        let id = $('#edit_user_id').val();
        let formData = new FormData(this);
        $.ajax({
            type: 'POST',
            url: '/admin/users/' + id,
            data: formData,
            contentType: false,
            processData: false,
            success: function(response) {
                alert(response.success);
                $('#editUserModal').modal('hide');
                location.reload();
            },
            error: function(response) {
                if (response.status === 422) {
                    $('#editUserForm .print-error-msg ul').html('');
                    $('#editUserForm .print-error-msg').show();
                    $.each(response.responseJSON.errors, function(key, value) {
                        $('#editUserForm .print-error-msg ul').append('<li>' + value + '</li>');
                    });
                } else {
                    alert('Something went wrong.');
                }
            }
        });
    });

    // Delete User
    function deleteUser(id) {
        if (confirm('Are you sure you want to delete this user?')) {
            $.ajax({
                type: 'DELETE',
                url: '/admin/users/' + id,
                data: { _token: '{{ csrf_token() }}' },
                success: function(response) {
                    alert(response.success);
                    $('#user-row-' + id).remove();
                },
                error: function() {
                    alert('Something went wrong.');
                }
            });
        }
    }
</script>
@endpush