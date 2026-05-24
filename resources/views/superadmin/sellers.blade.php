@extends('superadmin.layouts.superadmin')
@section('page_title', 'Manage Sellers')
@section('content')

<div class="sa-alert-success" style="display:none; background:#f0fdf4; color:#27ae60; border-left:4px solid #27ae60; padding:12px 16px; margin-bottom:20px; font-size:13px; font-weight:600;"></div>
<div class="sa-alert-error" style="display:none; background:#fdf0f0; color:#e74c3c; border-left:4px solid #e74c3c; padding:12px 16px; margin-bottom:20px; font-size:13px; font-weight:600;"></div>

<!-- Pending Approvals Section -->
@php $pendingSellers = $sellers->where('is_approved', 'pending'); @endphp
@if($pendingSellers->count() > 0)
<div style="background:#fff8f0; border:2px solid #f39c12; padding:0; margin-bottom:25px;">
    <div style="background:#f39c12; padding:15px 20px;">
        <h5 style="color:#fff; font-size:12px; font-weight:800; letter-spacing:2px; text-transform:uppercase; margin:0;">
            <i class="fa fa-clock-o" style="margin-right:8px;"></i> Pending Seller Approvals ({{ $pendingSellers->count() }})
        </h5>
    </div>
    <table class="sa-table">
        <thead>
            <tr>
                <th>#</th>
                <th>Seller</th>
                <th>Shop Name</th>
                <th>Shop Description</th>
                <th>Applied</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($pendingSellers as $seller)
                <tr id="seller-row-{{ $seller->id }}">
                    <td style="color:#999; font-size:11px;">#{{ str_pad($seller->id, 4, '0', STR_PAD_LEFT) }}</td>
                    <td>
                        <div style="display:flex; align-items:center; gap:10px;">
                            <div style="width:35px; height:35px; background:#f39c12; border-radius:50%; display:flex; align-items:center; justify-content:center; font-size:14px; font-weight:700; color:#fff;">
                                {{ strtoupper(substr($seller->name, 0, 1)) }}
                            </div>
                            <div>
                                <div style="font-weight:700; font-size:13px;">{{ $seller->name }}</div>
                                <div style="font-size:11px; color:#999;">{{ $seller->email }}</div>
                            </div>
                        </div>
                    </td>
                    <td style="font-size:13px; font-weight:600;">{{ $seller->shop_name ?? '—' }}</td>
                    <td style="font-size:12px; color:#666;">{{ $seller->shop_description ?? '—' }}</td>
                    <td style="font-size:12px; color:#999;">{{ $seller->created_at->format('M d, Y') }}</td>
                    <td>
                        <div style="display:flex; gap:5px;">
                            <button class="sa-btn sa-btn-approve" onclick="approveSeller({{ $seller->id }})">
                                <i class="fa fa-check"></i> Approve
                            </button>
                            <button class="sa-btn" style="background:#fdf0f0; color:#e74c3c; border:1px solid #e74c3c;" onclick="openMessage({{ $seller->id }}, '{{ addslashes($seller->name) }}', '{{ $seller->email }}')">
                                <i class="fa fa-envelope"></i> Message
                            </button>
                            <button class="sa-btn sa-btn-delete" onclick="deleteSeller({{ $seller->id }}, '{{ addslashes($seller->name) }}')">
                                <i class="fa fa-trash"></i> Reject
                            </button>
                        </div>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endif

<!-- All Sellers Table -->
<div class="sa-card">
    <div class="sa-card__header">
        <h5><i class="fa fa-store" style="color:#c8a96e; margin-right:8px;"></i> All Sellers</h5>
        <span style="font-size:12px; color:#999;">{{ $sellers->count() }} total</span>
    </div>
    <div style="padding:0;">
        <table class="sa-table">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Seller</th>
                    <th>Shop</th>
                    <th>Products</th>
                    <th>Joined</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($sellers->where('is_approved', '!=', 'pending') as $seller)
                    <tr id="seller-row-{{ $seller->id }}">
                        <td style="color:#999; font-size:11px;">#{{ str_pad($seller->id, 4, '0', STR_PAD_LEFT) }}</td>
                        <td>
                            <div style="display:flex; align-items:center; gap:10px;">
                                <div style="width:35px; height:35px; background:linear-gradient(135deg, #c8a96e, #8b6914); border-radius:50%; display:flex; align-items:center; justify-content:center; font-size:14px; font-weight:700; color:#fff;">
                                    {{ strtoupper(substr($seller->name, 0, 1)) }}
                                </div>
                                <div>
                                    <div style="font-weight:700; font-size:13px;">{{ $seller->name }}</div>
                                    <div style="font-size:11px; color:#999;">{{ $seller->email }}</div>
                                </div>
                            </div>
                        </td>
                        <td>
                            <div style="font-size:13px; font-weight:600;">{{ $seller->shop_name ?? '—' }}</div>
                            <div style="font-size:11px; color:#999;">{{ Str::limit($seller->shop_description, 30) }}</div>
                        </td>
                        <td>
                            <span style="background:#f0f8ff; color:#2980b9; padding:3px 10px; font-size:12px; font-weight:700;">
                                {{ $seller->products_count }}
                            </span>
                        </td>
                        <td style="font-size:12px; color:#999;">{{ $seller->created_at->format('M d, Y') }}</td>
                        <td id="seller-status-{{ $seller->id }}">
                            @if($seller->is_banned)
                                <span class="badge-banned">Banned</span>
                            @else
                                <span class="badge-approved">Active</span>
                            @endif
                        </td>
                        <td>
                            <div style="display:flex; gap:5px; flex-wrap:wrap;">
                                <button class="sa-btn" style="background:#f0f8ff; color:#2980b9; border:1px solid #2980b9;" onclick="openMessage({{ $seller->id }}, '{{ addslashes($seller->name) }}', '{{ $seller->email }}')">
                                    <i class="fa fa-envelope"></i> Message
                                </button>
                                <button class="sa-btn sa-btn-ban" onclick="banSeller({{ $seller->id }})" id="ban-btn-{{ $seller->id }}">
                                    <i class="fa fa-ban"></i> {{ $seller->is_banned ? 'Unban' : 'Ban' }}
                                </button>
                                <button class="sa-btn sa-btn-delete" onclick="deleteSeller({{ $seller->id }}, '{{ addslashes($seller->name) }}')">
                                    <i class="fa fa-trash"></i>
                                </button>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" style="text-align:center; color:#999; padding:40px;">No approved sellers yet</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<!-- Send Message Modal -->
<div class="sa-modal" id="messageModal">
    <div class="sa-modal__box">
        <div class="sa-modal__header">
            <h5><i class="fa fa-envelope" style="margin-right:8px; color:#c8a96e;"></i> Send Message to <span id="msg-user-name"></span></h5>
            <button onclick="$('#messageModal').css('display','none')">&times;</button>
        </div>
        <div class="sa-modal__body">
            <input type="hidden" id="msg-user-id">
            <div style="background:#f9f9f9; padding:12px 15px; margin-bottom:20px; font-size:12px; color:#666; border-left:3px solid #c8a96e;">
                <i class="fa fa-info-circle" style="color:#c8a96e;"></i>
                This message will be sent to: <strong id="msg-user-email"></strong>
            </div>
            <div class="mb-3">
                <label style="font-size:11px; font-weight:700; letter-spacing:1px; text-transform:uppercase; color:#111; display:block; margin-bottom:8px;">Subject</label>
                <input type="text" id="msg-subject" class="form-control"
                    placeholder="e.g. Account Approval, Warning, etc."
                    style="border-radius:0;">
            </div>
            <div class="mb-3">
                <label style="font-size:11px; font-weight:700; letter-spacing:1px; text-transform:uppercase; color:#111; display:block; margin-bottom:8px;">Message</label>
                <textarea id="msg-body" rows="5" class="form-control"
                    placeholder="Type your message here..."
                    style="border-radius:0; resize:none;"></textarea>
            </div>
            <div style="display:flex; justify-content:flex-end;">
                <button class="sa-btn sa-btn-primary" onclick="sendAdminMessage()" style="padding:10px 25px;">
                    <i class="fa fa-paper-plane"></i> Send Message
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Delete Modal -->
<div class="sa-modal" id="deleteSellerModal">
    <div class="sa-modal__box" style="max-width:440px;">
        <div class="sa-modal__header" style="background:#e74c3c;">
            <h5><i class="fa fa-exclamation-triangle" style="margin-right:8px;"></i> Confirm Delete</h5>
            <button onclick="$('#deleteSellerModal').css('display','none')">&times;</button>
        </div>
        <div class="sa-modal__body">
            <p style="font-size:15px; color:#666; margin-bottom:8px;">Delete seller:</p>
            <p id="delete-seller-name" style="font-size:18px; font-weight:800; color:#111; margin-bottom:15px;"></p>
            <div style="background:#fdf0f0; color:#e74c3c; padding:12px 15px; font-size:13px; border-left:3px solid #e74c3c; margin-bottom:20px;">
                This will permanently delete the seller and all their data.
            </div>
            <div style="display:flex; justify-content:flex-end;">
                <button class="sa-btn sa-btn-delete" onclick="confirmDeleteSeller()">
                    <i class="fa fa-trash"></i> Yes, Delete
                </button>
            </div>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
    let sellerToDelete = null;

    function approveSeller(id) {
        $.post('/superadmin/sellers/' + id + '/approve', function(response) {
            showSuccess(response.success);
            setTimeout(() => location.reload(), 1000);
        });
    }

    function banSeller(id) {
        $.post('/superadmin/sellers/' + id + '/ban', function(response) {
            if (response.is_banned) {
                $('#seller-status-' + id).html('<span class="badge-banned">Banned</span>');
                $('#ban-btn-' + id).html('<i class="fa fa-check"></i> Unban');
            } else {
                $('#seller-status-' + id).html('<span class="badge-approved">Active</span>');
                $('#ban-btn-' + id).html('<i class="fa fa-ban"></i> Ban');
            }
            showSuccess(response.success);
        });
    }

    function deleteSeller(id, name) {
        sellerToDelete = id;
        $('#delete-seller-name').text('"' + name + '"');
        $('#deleteSellerModal').css('display', 'flex');
    }

    function confirmDeleteSeller() {
        $.ajax({
            type: 'DELETE',
            url: '/superadmin/sellers/' + sellerToDelete,
            success: function(response) {
                $('#deleteSellerModal').css('display', 'none');
                $('#seller-row-' + sellerToDelete).fadeOut(400, function() { $(this).remove(); });
                showSuccess(response.success);
                sellerToDelete = null;
            }
        });
    }

    function openMessage(id, name, email) {
        $('#msg-user-id').val(id);
        $('#msg-user-name').text(name);
        $('#msg-user-email').text(email);
        $('#msg-subject').val('');
        $('#msg-body').val('');
        $('#messageModal').css('display', 'flex');
    }

    function sendAdminMessage() {
        let userId  = $('#msg-user-id').val();
        let subject = $('#msg-subject').val().trim();
        let body    = $('#msg-body').val().trim();

        if (!subject || !body) {
            alert('Please fill in both subject and message.');
            return;
        }

        $.post('/superadmin/send-message', {
            user_id: userId,
            subject: subject,
            message: body,
        }, function(response) {
            $('#messageModal').css('display', 'none');
            showSuccess(response.success);
        }).fail(function() {
            alert('Failed to send message. Please try again.');
        });
    }

    function showSuccess(msg) {
        $('.sa-alert-success').text(msg).show();
        setTimeout(() => $('.sa-alert-success').fadeOut(), 3000);
    }
</script>
@endpush