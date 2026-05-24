@extends('superadmin.layouts.superadmin')
@section('page_title', 'Manage Buyers')
@section('content')

<div class="sa-alert-success" style="display:none; background:#f0fdf4; color:#27ae60; border-left:4px solid #27ae60; padding:12px 16px; margin-bottom:20px; font-size:13px; font-weight:600;"></div>

<div class="sa-card">
    <div class="sa-card__header">
        <h5><i class="fa fa-users" style="color:#2980b9; margin-right:8px;"></i> All Buyers</h5>
        <span style="font-size:12px; color:#999;">{{ $buyers->count() }} total buyers</span>
    </div>
    <div style="padding:0;">
        <table class="sa-table">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Buyer</th>
                    <th>Phone</th>
                    <th>Address</th>
                    <th>Joined</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($buyers as $buyer)
                    <tr id="buyer-row-{{ $buyer->id }}">
                        <td style="color:#999; font-size:11px;">#{{ str_pad($buyer->id, 4, '0', STR_PAD_LEFT) }}</td>
                        <td>
                            <div style="display:flex; align-items:center; gap:10px;">
                                <div style="width:35px; height:35px; background:#2980b9; border-radius:50%; display:flex; align-items:center; justify-content:center; font-size:14px; font-weight:700; color:#fff;">
                                    {{ strtoupper(substr($buyer->name, 0, 1)) }}
                                </div>
                                <div>
                                    <div style="font-weight:700; font-size:13px;">{{ $buyer->name }}</div>
                                    <div style="font-size:11px; color:#999;">{{ $buyer->email }}</div>
                                </div>
                            </div>
                        </td>
                        <td style="font-size:12px;">{{ $buyer->phone ?? '—' }}</td>
                        <td style="font-size:12px;">{{ $buyer->address ?? '—' }}</td>
                        <td style="font-size:12px; color:#999;">{{ $buyer->created_at->format('M d, Y') }}</td>
                        <td id="buyer-status-{{ $buyer->id }}">
                            @if($buyer->is_banned)
                                <span class="badge-banned">Banned</span>
                            @else
                                <span class="badge-approved">Active</span>
                            @endif
                        </td>
                        <td>
                            <div style="display:flex; gap:5px; flex-wrap:wrap;">
                                <button class="sa-btn" style="background:#f0f8ff; color:#2980b9; border:1px solid #2980b9;" onclick="openMessage({{ $buyer->id }}, '{{ addslashes($buyer->name) }}', '{{ $buyer->email }}')">
                                    <i class="fa fa-envelope"></i> Message
                                </button>
                                <button class="sa-btn sa-btn-ban" onclick="banBuyer({{ $buyer->id }})" id="ban-buyer-btn-{{ $buyer->id }}">
                                    <i class="fa fa-ban"></i> {{ $buyer->is_banned ? 'Unban' : 'Ban' }}
                                </button>
                                <button class="sa-btn sa-btn-delete" onclick="deleteBuyer({{ $buyer->id }}, '{{ addslashes($buyer->name) }}')">
                                    <i class="fa fa-trash"></i>
                                </button>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" style="text-align:center; color:#999; padding:40px;">No buyers found</td>
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
                Sending to: <strong id="msg-user-email"></strong>
            </div>
            <div class="mb-3">
                <label style="font-size:11px; font-weight:700; letter-spacing:1px; text-transform:uppercase; color:#111; display:block; margin-bottom:8px;">Subject</label>
                <input type="text" id="msg-subject" class="form-control" placeholder="Subject..." style="border-radius:0;">
            </div>
            <div class="mb-3">
                <label style="font-size:11px; font-weight:700; letter-spacing:1px; text-transform:uppercase; color:#111; display:block; margin-bottom:8px;">Message</label>
                <textarea id="msg-body" rows="5" class="form-control" placeholder="Type your message..." style="border-radius:0; resize:none;"></textarea>
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
<div class="sa-modal" id="deleteBuyerModal">
    <div class="sa-modal__box" style="max-width:440px;">
        <div class="sa-modal__header" style="background:#e74c3c;">
            <h5>Confirm Delete</h5>
            <button onclick="$('#deleteBuyerModal').css('display','none')">&times;</button>
        </div>
        <div class="sa-modal__body">
            <p style="font-size:15px; color:#666; margin-bottom:8px;">Delete buyer:</p>
            <p id="delete-buyer-name" style="font-size:18px; font-weight:800; color:#111; margin-bottom:15px;"></p>
            <div style="display:flex; justify-content:flex-end;">
                <button class="sa-btn sa-btn-delete" onclick="confirmDeleteBuyer()">
                    <i class="fa fa-trash"></i> Yes, Delete
                </button>
            </div>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
    let buyerToDelete = null;

    function banBuyer(id) {
        $.post('/superadmin/buyers/' + id + '/ban', function(response) {
            if (response.is_banned) {
                $('#buyer-status-' + id).html('<span class="badge-banned">Banned</span>');
                $('#ban-buyer-btn-' + id).html('<i class="fa fa-check"></i> Unban');
            } else {
                $('#buyer-status-' + id).html('<span class="badge-approved">Active</span>');
                $('#ban-buyer-btn-' + id).html('<i class="fa fa-ban"></i> Ban');
            }
            showSuccess(response.success);
        });
    }

    function deleteBuyer(id, name) {
        buyerToDelete = id;
        $('#delete-buyer-name').text('"' + name + '"');
        $('#deleteBuyerModal').css('display', 'flex');
    }

    function confirmDeleteBuyer() {
        $.ajax({
            type: 'DELETE',
            url: '/superadmin/buyers/' + buyerToDelete,
            success: function(response) {
                $('#deleteBuyerModal').css('display', 'none');
                $('#buyer-row-' + buyerToDelete).fadeOut(400, function() { $(this).remove(); });
                showSuccess(response.success);
                buyerToDelete = null;
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
        });
    }

    function showSuccess(msg) {
        $('.sa-alert-success').text(msg).show();
        setTimeout(() => $('.sa-alert-success').fadeOut(), 3000);
    }
</script>
@endpush