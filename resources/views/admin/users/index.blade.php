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
        <h5>Customers</h5>
    </div>
    <div class="admin__card__body" style="padding:0;">
        <table class="table mb-0">
            <thead>
                <tr>
                    <th>User ID</th>
                    <th>Customer</th>
                    <th>Email</th>
                    <th>Phone</th>
                    <th>Address</th>
                    <th>Inquiries</th>
                    <th>Joined</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($users as $user)
                    <tr id="user-row-{{ $user->id }}">
                        <td>
                            <span style="background:#111; color:#c8a96e; padding:4px 10px; font-size:11px; font-weight:700; letter-spacing:1px; font-family:monospace;">
                                #{{ str_pad($user->id, 4, '0', STR_PAD_LEFT) }}
                            </span>
                        </td>
                        <td>
                            <div style="display:flex; align-items:center; gap:12px;">
                                <div style="width:38px; height:38px; background:linear-gradient(135deg, #c8a96e, #111); border-radius:50%; display:flex; align-items:center; justify-content:center; font-size:15px; font-weight:700; color:#fff; flex-shrink:0;">
                                    {{ strtoupper(substr($user->name, 0, 1)) }}
                                </div>
                                <div>
                                    <div style="font-weight:700; color:#111; font-size:13px;">{{ $user->name }}</div>
                                    <div style="font-size:11px; color:#999; letter-spacing:0.5px;">Buyer</div>
                                </div>
                            </div>
                        </td>
                        <td style="font-size:13px; color:#444;">{{ $user->email }}</td>
                        <td style="font-size:13px; color:#444;">{{ $user->phone ?? '—' }}</td>
                        <td style="font-size:13px; color:#444;">{{ $user->address ?? '—' }}</td>
                        <td>
                            <span style="background:#f0f8ff; color:#2980b9; padding:5px 12px; font-size:12px; font-weight:700; display:inline-flex; align-items:center; gap:5px;">
                                <i class="fa fa-comments"></i> {{ $user->inquiry_count }}
                            </span>
                        </td>
                        <td style="font-size:12px; color:#999;">{{ $user->created_at->format('M d, Y') }}</td>
                        <td>
                            <div style="display:flex; gap:6px;">
                                <button onclick="viewUser({{ $user->id }})"
                                    style="background:#111; color:#fff; border:none; padding:7px 14px; font-size:11px; font-weight:700; letter-spacing:1px; text-transform:uppercase; cursor:pointer; transition:background 0.3s; display:inline-flex; align-items:center; gap:5px;"
                                    onmouseover="this.style.background='#c8a96e';" onmouseout="this.style.background='#111';">
                                    <i class="fa fa-eye"></i> View
                                </button>
                                <button onclick="deleteUser({{ $user->id }}, '{{ addslashes($user->name) }}')"
                                    style="background:#fdf0f0; color:#e74c3c; border:1px solid #e74c3c; padding:7px 14px; font-size:11px; font-weight:700; letter-spacing:1px; text-transform:uppercase; cursor:pointer; transition:all 0.3s; display:inline-flex; align-items:center; gap:5px;"
                                    onmouseover="this.style.background='#e74c3c'; this.style.color='#fff';" onmouseout="this.style.background='#fdf0f0'; this.style.color='#e74c3c';">
                                    <i class="fa fa-trash"></i> Delete
                                </button>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="8" class="text-center" style="color:#999; padding:60px;">
                            <i class="fa fa-users" style="font-size:40px; display:block; margin-bottom:15px; color:#ddd;"></i>
                            <p style="font-size:15px; font-weight:600; margin-bottom:5px;">No customers yet</p>
                            <p style="font-size:13px;">Customers who inquire about your products will appear here.</p>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<!-- ===== VIEW USER MODAL ===== -->
<div id="viewUserModal" style="display:none; position:fixed; top:0; left:0; width:100%; height:100%; background:rgba(0,0,0,0.6); z-index:99999; justify-content:center; align-items:center;">
    <div style="background:#fff; width:100%; max-width:460px; box-shadow:0 20px 60px rgba(0,0,0,0.3);">
        <!-- Header -->
        <div style="background:#111; padding:20px 25px; display:flex; align-items:center; justify-content:space-between;">
            <h5 style="color:#fff; font-size:13px; font-weight:800; letter-spacing:2px; text-transform:uppercase; margin:0;">
                <i class="fa fa-user" style="margin-right:8px; color:#c8a96e;"></i> Customer Profile
            </h5>
            <button onclick="closeViewModal()"
                style="background:none; border:none; color:#fff; font-size:22px; cursor:pointer; padding:0; width:30px; height:30px; display:flex; align-items:center; justify-content:center;"
                onmouseover="this.style.color='#c8a96e';" onmouseout="this.style.color='#fff';">
                &times;
            </button>
        </div>
        <!-- Profile Card -->
        <div style="padding:30px 25px;">
            <div style="display:flex; align-items:center; gap:20px; margin-bottom:25px; padding-bottom:25px; border-bottom:1px solid #f0f0f0;">
                <div id="view_avatar" style="width:64px; height:64px; background:linear-gradient(135deg, #c8a96e, #111); border-radius:50%; display:flex; align-items:center; justify-content:center; font-size:24px; font-weight:700; color:#fff; flex-shrink:0;"></div>
                <div>
                    <div style="font-size:11px; color:#c8a96e; font-weight:700; letter-spacing:2px; text-transform:uppercase; margin-bottom:4px;">
                        Customer <span id="view_user_id"></span>
                    </div>
                    <h4 id="view_user_name" style="font-size:20px; font-weight:800; color:#111; margin:0 0 4px;"></h4>
                    <div style="font-size:12px; color:#999;">Registered Buyer</div>
                </div>
            </div>

            <!-- Info Grid -->
            <div style="display:grid; gap:15px;">
                <div style="display:flex; align-items:flex-start; gap:15px;">
                    <div style="width:32px; height:32px; background:#f9f4ec; border-radius:50%; display:flex; align-items:center; justify-content:center; flex-shrink:0;">
                        <i class="fa fa-envelope" style="color:#c8a96e; font-size:12px;"></i>
                    </div>
                    <div>
                        <div style="font-size:10px; color:#999; letter-spacing:1px; text-transform:uppercase; margin-bottom:2px;">Email</div>
                        <div id="view_user_email" style="font-size:13px; color:#111; font-weight:600;"></div>
                    </div>
                </div>
                <div style="display:flex; align-items:flex-start; gap:15px;">
                    <div style="width:32px; height:32px; background:#f9f4ec; border-radius:50%; display:flex; align-items:center; justify-content:center; flex-shrink:0;">
                        <i class="fa fa-phone" style="color:#c8a96e; font-size:12px;"></i>
                    </div>
                    <div>
                        <div style="font-size:10px; color:#999; letter-spacing:1px; text-transform:uppercase; margin-bottom:2px;">Phone</div>
                        <div id="view_user_phone" style="font-size:13px; color:#111; font-weight:600;"></div>
                    </div>
                </div>
                <div style="display:flex; align-items:flex-start; gap:15px;">
                    <div style="width:32px; height:32px; background:#f9f4ec; border-radius:50%; display:flex; align-items:center; justify-content:center; flex-shrink:0;">
                        <i class="fa fa-map-marker" style="color:#c8a96e; font-size:12px;"></i>
                    </div>
                    <div>
                        <div style="font-size:10px; color:#999; letter-spacing:1px; text-transform:uppercase; margin-bottom:2px;">Address</div>
                        <div id="view_user_address" style="font-size:13px; color:#111; font-weight:600;"></div>
                    </div>
                </div>
                <div style="display:flex; align-items:flex-start; gap:15px;">
                    <div style="width:32px; height:32px; background:#f9f4ec; border-radius:50%; display:flex; align-items:center; justify-content:center; flex-shrink:0;">
                        <i class="fa fa-calendar" style="color:#c8a96e; font-size:12px;"></i>
                    </div>
                    <div>
                        <div style="font-size:10px; color:#999; letter-spacing:1px; text-transform:uppercase; margin-bottom:2px;">Member Since</div>
                        <div id="view_user_joined" style="font-size:13px; color:#111; font-weight:600;"></div>
                    </div>
                </div>
                <div style="display:flex; align-items:flex-start; gap:15px;">
                    <div style="width:32px; height:32px; background:#f0f8ff; border-radius:50%; display:flex; align-items:center; justify-content:center; flex-shrink:0;">
                        <i class="fa fa-comments" style="color:#2980b9; font-size:12px;"></i>
                    </div>
                    <div>
                        <div style="font-size:10px; color:#999; letter-spacing:1px; text-transform:uppercase; margin-bottom:2px;">Product Inquiries</div>
                        <div id="view_user_inquiries" style="font-size:13px; color:#2980b9; font-weight:700;"></div>
                    </div>
                </div>
            </div>
        </div>
        <div style="padding:15px 25px; border-top:1px solid #f0f0f0; display:flex; justify-content:flex-end;">
            <button onclick="closeViewModal()"
                style="background:#111; color:#fff; border:none; padding:10px 24px; font-size:11px; font-weight:700; letter-spacing:1px; text-transform:uppercase; cursor:pointer; transition:background 0.3s;"
                onmouseover="this.style.background='#c8a96e';" onmouseout="this.style.background='#111';">
                Close
            </button>
        </div>
    </div>
</div>

<!-- ===== DELETE CONFIRMATION MODAL ===== -->
<div id="deleteUserModal" style="display:none; position:fixed; top:0; left:0; width:100%; height:100%; background:rgba(0,0,0,0.6); z-index:99999; justify-content:center; align-items:center;">
    <div style="background:#fff; width:100%; max-width:440px; box-shadow:0 20px 60px rgba(0,0,0,0.3);">
        <div style="background:#e74c3c; padding:20px 25px; display:flex; align-items:center; justify-content:space-between;">
            <h5 style="color:#fff; font-size:13px; font-weight:800; letter-spacing:2px; text-transform:uppercase; margin:0;">
                <i class="fa fa-exclamation-triangle" style="margin-right:8px;"></i> Confirm Delete
            </h5>
            <button onclick="closeDeleteUserModal()"
                style="background:none; border:none; color:#fff; font-size:22px; cursor:pointer; padding:0; width:30px; height:30px; display:flex; align-items:center; justify-content:center;">
                &times;
            </button>
        </div>
        <div style="padding:30px 25px;">
            <p style="font-size:15px; color:#666; margin-bottom:8px;">Are you sure you want to remove:</p>
            <p style="font-size:20px; font-weight:800; color:#111; margin-bottom:15px;" id="delete_user_name"></p>
            <div style="background:#fdf0f0; color:#e74c3c; padding:12px 15px; font-size:13px; border-left:3px solid #e74c3c;">
                <i class="fa fa-exclamation-triangle"></i>
                This action <strong>cannot be undone</strong>.
            </div>
        </div>
        <div style="padding:15px 25px; border-top:1px solid #f0f0f0; display:flex; justify-content:flex-end;">
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

    $('#viewUserModal, #deleteUserModal').click(function(e) {
        if ($(e.target).is(this)) $(this).css('display', 'none');
    });

    function viewUser(id) {
        $.get('/admin/users/' + id, function(data) {
            $('#view_avatar').text(data.name.charAt(0).toUpperCase());
            $('#view_user_id').text('#' + String(data.id).padStart(4, '0'));
            $('#view_user_name').text(data.name);
            $('#view_user_email').text(data.email);
            $('#view_user_phone').text(data.phone ?? 'Not provided');
            $('#view_user_address').text(data.address ?? 'Not provided');
            $('#view_user_joined').text(new Date(data.created_at).toLocaleDateString('en-US', {year:'numeric', month:'long', day:'numeric'}));
            $('#view_user_inquiries').text((data.inquiry_count ?? 0) + ' inquiries sent to your store');
            $('#viewUserModal').css('display', 'flex');
        });
    }

    function closeViewModal() {
        $('#viewUserModal').css('display', 'none');
    }

    function deleteUser(id, name) {
        userToDelete = id;
        $('#delete_user_name').text('"' + name + '"');
        $('#deleteUserModal').css('display', 'flex');
    }

    function closeDeleteUserModal() {
        $('#deleteUserModal').css('display', 'none');
        userToDelete = null;
    }

    function confirmDeleteUser() {
        if (!userToDelete) return;
        $.ajax({
            type: 'DELETE',
            url: '/admin/users/' + userToDelete,
            data: { _token: '{{ csrf_token() }}' },
            success: function(response) {
                closeDeleteUserModal();
                $('#user-row-' + userToDelete).fadeOut(400, function() { $(this).remove(); });
                showSuccess(response.success);
                userToDelete = null;
            },
            error: function() {
                showError('Something went wrong.');
            }
        });
    }

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