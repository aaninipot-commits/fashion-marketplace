@extends('admin.layouts.admin')

@section('page_title', 'Users')

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
        <h5>All Users</h5>
        <button class="btn-add" id="openAddUserModal">
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
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($users as $key => $user)
                    <tr id="user-row-{{ $user->id }}">
                        <td>{{ $key + 1 }}</td>
                        <td>
                            <div style="display:flex; align-items:center; gap:10px;">
                                <div style="width:35px; height:35px; background:#f0f0f0; border-radius:50%; display:flex; align-items:center; justify-content:center; font-size:14px; font-weight:700; color:#111;">
                                    {{ strtoupper(substr($user->name, 0, 1)) }}
                                </div>
                                <span id="user-name-{{ $user->id }}"><strong>{{ $user->name }}</strong></span>
                            </div>
                        </td>
                        <td id="user-email-{{ $user->id }}">{{ $user->email }}</td>
                        <td id="user-phone-{{ $user->id }}">{{ $user->phone ?? 'N/A' }}</td>
                        <td id="user-address-{{ $user->id }}">{{ $user->address ?? 'N/A' }}</td>
                        <td>{{ $user->created_at->format('M d, Y') }}</td>
                        <td id="user-status-{{ $user->id }}"></td>
                        <td>
                            <button class="btn-admin btn-edit" onclick="editUser({{ $user->id }})">
                                <i class="fa fa-edit"></i> Edit
                            </button>
                            <button class="btn-admin btn-delete ms-1" onclick="deleteUser({{ $user->id }}, '{{ addslashes($user->name) }}')">
                                <i class="fa fa-trash"></i> Delete
                            </button>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="8" class="text-center" style="color:#999; padding:40px;">
                            <i class="fa fa-users" style="font-size:32px; display:block; margin-bottom:10px; color:#ddd;"></i>
                            No users found. Click "Add User" to create one.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<!-- ===== ADD USER MODAL ===== -->
<div id="addUserModal" style="display:none; position:fixed; top:0; left:0; width:100%; height:100%; background:rgba(0,0,0,0.6); z-index:99999; justify-content:center; align-items:center;">
    <div style="background:#fff; width:100%; max-width:520px; max-height:90vh; overflow-y:auto; position:relative; box-shadow:0 20px 60px rgba(0,0,0,0.3);">
        <!-- Header -->
        <div style="background:#111; padding:20px 25px; display:flex; align-items:center; justify-content:space-between; position:sticky; top:0; z-index:1;">
            <h5 style="color:#fff; font-size:13px; font-weight:800; letter-spacing:2px; text-transform:uppercase; margin:0;">
                <i class="fa fa-user-plus" style="margin-right:8px; color:#c8a96e;"></i> Add New User
            </h5>
            <button onclick="closeAddUserModal()" title="Close"
                style="background:none; border:none; color:#fff; font-size:22px; cursor:pointer; line-height:1; padding:0; width:30px; height:30px; display:flex; align-items:center; justify-content:center;"
                onmouseover="this.style.color='#c8a96e';" onmouseout="this.style.color='#fff';">
                &times;
            </button>
        </div>
        <!-- Body -->
        <div style="padding:30px 25px;">
            <form id="createUserForm">
                @csrf
                <div class="add-user-error" style="display:none; background:#fdf0f0; color:#e74c3c; padding:10px 15px; margin-bottom:15px; font-size:13px;">
                    <ul style="margin:0; padding-left:20px;"></ul>
                </div>
                <div class="row">
                    <div class="col-md-12 mb-3">
                        <label class="form-label">Full Name <span style="color:#e74c3c;">*</span></label>
                        <input type="text" name="name" class="form-control" placeholder="Enter full name" required>
                    </div>
                    <div class="col-md-12 mb-3">
                        <label class="form-label">Email Address <span style="color:#e74c3c;">*</span></label>
                        <input type="email" name="email" class="form-control" placeholder="Enter email address" required>
                    </div>
                    <div class="col-md-12 mb-3">
                        <label class="form-label">Password <span style="color:#e74c3c;">*</span></label>
                        <input type="password" name="password" class="form-control" placeholder="Enter password (min 6 characters)" required>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Phone</label>
                        <input type="text" name="phone" class="form-control" placeholder="e.g. 09123456789">
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Address</label>
                        <input type="text" name="address" class="form-control" placeholder="e.g. Davao City">
                    </div>
                </div>
                <div style="display:flex; justify-content:flex-end; margin-top:20px; padding-top:20px; border-top:1px solid #f0f0f0;">
                    <button type="submit" id="addUserBtn"
                        style="background:#111; color:#fff; border:none; padding:12px 24px; font-size:11px; font-weight:700; letter-spacing:1px; text-transform:uppercase; cursor:pointer; transition:background 0.3s;"
                        onmouseover="this.style.background='#c8a96e';" onmouseout="this.style.background='#111';">
                        <i class="fa fa-save"></i> Save User
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- ===== EDIT USER MODAL ===== -->
<div id="editUserModal" style="display:none; position:fixed; top:0; left:0; width:100%; height:100%; background:rgba(0,0,0,0.6); z-index:99999; justify-content:center; align-items:center;">
    <div style="background:#fff; width:100%; max-width:520px; max-height:90vh; overflow-y:auto; position:relative; box-shadow:0 20px 60px rgba(0,0,0,0.3);">
        <!-- Header -->
        <div style="background:#111; padding:20px 25px; display:flex; align-items:center; justify-content:space-between; position:sticky; top:0; z-index:1;">
            <h5 style="color:#fff; font-size:13px; font-weight:800; letter-spacing:2px; text-transform:uppercase; margin:0;">
                <i class="fa fa-edit" style="margin-right:8px; color:#c8a96e;"></i> Edit User
            </h5>
            <button onclick="closeEditUserModal()" title="Close without saving"
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
            <form id="editUserForm">
                @csrf
                <input type="hidden" id="edit_user_id">
                <div class="edit-user-error" style="display:none; background:#fdf0f0; color:#e74c3c; padding:10px 15px; margin-bottom:15px; font-size:13px;">
                    <ul style="margin:0; padding-left:20px;"></ul>
                </div>
                <div class="row">
                    <div class="col-md-12 mb-3">
                        <label class="form-label">Full Name <span style="color:#e74c3c;">*</span></label>
                        <input type="text" id="edit_user_name" name="name" class="form-control" required>
                    </div>
                    <div class="col-md-12 mb-3">
                        <label class="form-label">Email Address <span style="color:#e74c3c;">*</span></label>
                        <input type="email" id="edit_user_email" name="email" class="form-control" required>
                    </div>
                    <div class="col-md-12 mb-3">
                        <label class="form-label">New Password</label>
                        <input type="password" name="password" class="form-control" placeholder="Leave blank to keep current password">
                        <small style="color:#999; font-size:11px;">Leave empty to keep current password</small>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Phone</label>
                        <input type="text" id="edit_user_phone" name="phone" class="form-control">
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Address</label>
                        <input type="text" id="edit_user_address" name="address" class="form-control">
                    </div>
                </div>
                <div style="display:flex; justify-content:flex-end; margin-top:20px; padding-top:20px; border-top:1px solid #f0f0f0;">
                    <button type="submit" id="editUserBtn"
                        style="background:#111; color:#fff; border:none; padding:12px 24px; font-size:11px; font-weight:700; letter-spacing:1px; text-transform:uppercase; cursor:pointer; transition:background 0.3s;"
                        onmouseover="this.style.background='#c8a96e';" onmouseout="this.style.background='#111';">
                        <i class="fa fa-save"></i> Update User
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- ===== DELETE CONFIRMATION MODAL ===== -->
<div id="deleteUserModal" style="display:none; position:fixed; top:0; left:0; width:100%; height:100%; background:rgba(0,0,0,0.6); z-index:99999; justify-content:center; align-items:center;">
    <div style="background:#fff; width:100%; max-width:440px; position:relative; box-shadow:0 20px 60px rgba(0,0,0,0.3);">
        <!-- Header -->
        <div style="background:#e74c3c; padding:20px 25px; display:flex; align-items:center; justify-content:space-between;">
            <h5 style="color:#fff; font-size:13px; font-weight:800; letter-spacing:2px; text-transform:uppercase; margin:0;">
                <i class="fa fa-exclamation-triangle" style="margin-right:8px;"></i> Confirm Delete
            </h5>
            <button onclick="closeDeleteUserModal()"
                style="background:none; border:none; color:#fff; font-size:22px; cursor:pointer; line-height:1; padding:0; width:30px; height:30px; display:flex; align-items:center; justify-content:center;">
                &times;
            </button>
        </div>
        <!-- Body -->
        <div style="padding:30px 25px;">
            <p style="font-size:15px; color:#666; margin-bottom:8px;">Are you sure you want to delete:</p>
            <p style="font-size:20px; font-weight:800; color:#111; margin-bottom:15px;" id="delete_user_name"></p>
            <div style="background:#fdf0f0; color:#e74c3c; padding:12px 15px; font-size:13px; border-left:3px solid #e74c3c;">
                <i class="fa fa-exclamation-triangle"></i>
                This action <strong>cannot be undone</strong>. All messages from this user will also be deleted.
            </div>
        </div>
        <!-- Footer -->
        <div style="padding:15px 25px; border-top:1px solid #f0f0f0; display:flex; gap:10px; justify-content:flex-end;">
            <button onclick="closeDeleteUserModal()"
                style="background:#f0f0f0; color:#111; border:none; padding:12px 24px; font-size:11px; font-weight:700; letter-spacing:1px; text-transform:uppercase; cursor:pointer;">
                <i class="fa fa-times"></i> Cancel
            </button>
            <button onclick="confirmDeleteUser()"
                style="background:#e74c3c; color:#fff; border:none; padding:12px 24px; font-size:11px; font-weight:700; letter-spacing:1px; text-transform:uppercase; cursor:pointer;"
                onmouseover="this.style.background='#c0392b';" onmouseout="this.style.background='#e74c3c';">
                <i class="fa fa-trash"></i> Yes, Delete
            </button>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
    let userToDelete = null;

    $.ajaxSetup({
        headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') }
    });

    // ── MODAL CONTROLS ──────────────────────────────────
    $('#openAddUserModal').click(function() {
        $('#createUserForm').trigger('reset');
        $('.add-user-error').hide();
        $('#addUserModal').css('display', 'flex');
    });

    function closeAddUserModal() {
        $('#addUserModal').css('display', 'none');
        $('#createUserForm').trigger('reset');
        $('.add-user-error').hide();
    }

    function closeEditUserModal() {
        $('#editUserModal').css('display', 'none');
        $('.edit-user-error').hide();
    }

    function closeDeleteUserModal() {
        $('#deleteUserModal').css('display', 'none');
        userToDelete = null;
    }

    // Close modals when clicking outside
    $('#addUserModal, #editUserModal, #deleteUserModal').click(function(e) {
        if ($(e.target).is(this)) {
            $(this).css('display', 'none');
        }
    });

    // ── CREATE USER ─────────────────────────────────────
    $('#createUserForm').submit(function(e) {
        e.preventDefault();
        let btn = $('#addUserBtn');
        btn.html('<i class="fa fa-spinner fa-spin"></i> Saving...').prop('disabled', true);

        let formData = new FormData(this);
        $.ajax({
            type: 'POST',
            url: '{{ route("admin.users.store") }}',
            data: formData,
            contentType: false,
            processData: false,
            success: function(response) {
                closeAddUserModal();
                showSuccess(response.success);
                setTimeout(() => location.reload(), 1000);
            },
            error: function(response) {
                btn.html('<i class="fa fa-save"></i> Save User').prop('disabled', false);
                if (response.status === 422) {
                    $('.add-user-error ul').html('');
                    $('.add-user-error').show();
                    $.each(response.responseJSON.errors, function(key, value) {
                        $('.add-user-error ul').append('<li>' + value + '</li>');
                    });
                } else {
                    showError('Something went wrong. Please try again.');
                }
            }
        });
    });

    // ── EDIT USER - Load Data ───────────────────────────
    function editUser(id) {
        $.get('/admin/users/' + id, function(data) {
            $('#edit_user_id').val(data.id);
            $('#edit_user_name').val(data.name);
            $('#edit_user_email').val(data.email);
            $('#edit_user_phone').val(data.phone ?? '');
            $('#edit_user_address').val(data.address ?? '');
            $('.edit-user-error').hide();
            $('#editUserModal').css('display', 'flex');
        }).fail(function() {
            showError('Failed to load user data. Please try again.');
        });
    }

    // ── UPDATE USER ─────────────────────────────────────
    $('#editUserForm').submit(function(e) {
        e.preventDefault();
        let id = $('#edit_user_id').val();
        let btn = $('#editUserBtn');
        btn.html('<i class="fa fa-spinner fa-spin"></i> Updating...').prop('disabled', true);

        let formData = new FormData(this);
        $.ajax({
            type: 'POST',
            url: '/admin/users/' + id,
            data: formData,
            contentType: false,
            processData: false,
            success: function(response) {
                closeEditUserModal();
                btn.html('<i class="fa fa-save"></i> Update User').prop('disabled', false);

                // Update row
                $('#user-name-' + id).html('<strong>' + response.user.name + '</strong>');
                $('#user-email-' + id).text(response.user.email);
                $('#user-phone-' + id).text(response.user.phone ?? 'N/A');
                $('#user-address-' + id).text(response.user.address ?? 'N/A');
                $('#user-status-' + id).html(
                    '<span style="background:#f0fdf4; color:#27ae60; padding:3px 10px; font-size:11px; font-weight:700;">' +
                    '<i class="fa fa-check"></i> Edited</span>'
                );

                showSuccess(response.success);
            },
            error: function(response) {
                btn.html('<i class="fa fa-save"></i> Update User').prop('disabled', false);
                if (response.status === 422) {
                    $('.edit-user-error ul').html('');
                    $('.edit-user-error').show();
                    $.each(response.responseJSON.errors, function(key, value) {
                        $('.edit-user-error ul').append('<li>' + value + '</li>');
                    });
                } else {
                    showError('Something went wrong. Please try again.');
                }
            }
        });
    });

    // ── DELETE USER ─────────────────────────────────────
    function deleteUser(id, name) {
        userToDelete = id;
        $('#delete_user_name').text('"' + name + '"');
        $('#deleteUserModal').css('display', 'flex');
    }

    function confirmDeleteUser() {
        if (!userToDelete) return;
        $.ajax({
            type: 'DELETE',
            url: '/admin/users/' + userToDelete,
            data: { _token: '{{ csrf_token() }}' },
            success: function(response) {
                closeDeleteUserModal();
                $('#user-row-' + userToDelete).fadeOut(400, function() {
                    $(this).remove();
                });
                showSuccess(response.success);
                userToDelete = null;
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