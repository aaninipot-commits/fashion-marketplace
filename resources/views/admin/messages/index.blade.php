@extends('admin.layouts.admin')

@section('page_title', 'Product Inquiries')

@section('content')

<!-- Success/Error -->
<div class="print-success-msg" style="display:none; background:#f0fdf4; color:#27ae60; border-left:4px solid #27ae60; padding:12px 16px; margin-bottom:20px; font-size:13px; font-weight:600;">
    <i class="fa fa-check-circle"></i> <span class="msg-text"></span>
</div>
<div class="print-error-msg" style="display:none; background:#fdf0f0; color:#e74c3c; border-left:4px solid #e74c3c; padding:12px 16px; margin-bottom:20px; font-size:13px; font-weight:600;">
    <i class="fa fa-exclamation-circle"></i> <span class="msg-text"></span>
</div>

<div class="admin__card">
    <div class="admin__card__header">
        <h5>Product Inquiries</h5>
    </div>
    <div class="admin__card__body" style="padding:0;">
        <table class="table mb-0">
            <thead>
                <tr>
                    <th>#</th>
                    <th>User</th>
                    <th>Product</th>
                    <th>Last Message</th>
                    <th>Status</th>
                    <th>Date</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($conversations as $key => $conv)
                    <tr id="message-row-{{ $conv['user']->id }}-{{ $conv['product']->id }}">
                        <td>{{ $key + 1 }}</td>
                        <td>
                            <div style="display:flex; align-items:center; gap:8px;">
                                <div style="width:32px; height:32px; background:#f0f0f0; border-radius:50%; display:flex; align-items:center; justify-content:center; font-size:13px; font-weight:700; color:#111;">
                                    {{ strtoupper(substr($conv['user']->name, 0, 1)) }}
                                </div>
                                <strong>{{ $conv['user']->name }}</strong>
                            </div>
                        </td>
                        <td>
                            <div style="font-weight:600;">{{ $conv['product']->name }}</div>
                            <div style="font-size:11px; color:#999;">₱{{ number_format($conv['product']->price, 2) }}</div>
                        </td>
                        <td style="max-width:200px;">
                            <div style="white-space:nowrap; overflow:hidden; text-overflow:ellipsis; font-size:13px; color:#666;">
                                @if($conv['lastMessage']->sender === 'admin')
                                    <span style="color:#c8a96e; font-weight:700; font-size:11px;">You:</span>
                                @else
                                    <span style="color:#999; font-size:11px;">{{ $conv['user']->name }}:</span>
                                @endif
                                {{ Str::limit($conv['lastMessage']->message, 50) }}
                            </div>
                        </td>
                        <td>
                            @if($conv['unreadCount'] > 0)
                                <span style="background:#fdf0f0; color:#e74c3c; padding:4px 10px; font-size:11px; font-weight:700;">
                                    {{ $conv['unreadCount'] }} Unread
                                </span>
                            @else
                                <span style="background:#f0fdf4; color:#27ae60; padding:4px 10px; font-size:11px; font-weight:700;">
                                    Read
                                </span>
                            @endif
                        </td>
                        <td style="font-size:12px; color:#999;">
                            {{ $conv['lastMessage']->created_at->format('M d, Y') }}
                        </td>
                        <td>
                            <button class="btn-admin btn-view"
                                onclick="openConversation({{ $conv['user']->id }}, {{ $conv['product']->id }}, '{{ addslashes($conv['user']->name) }}', '{{ addslashes($conv['product']->name) }}', {{ $conv['lastMessage']->id }})">
                                <i class="fa fa-comments"></i> Reply
                            </button>
                            <button class="btn-admin btn-delete ms-1"
                                onclick="deleteConversation({{ $conv['lastMessage']->id }}, '{{ addslashes($conv['user']->name) }}')">
                                <i class="fa fa-trash"></i> Delete
                            </button>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="text-center" style="color:#999; padding:40px;">
                            <i class="fa fa-comments" style="font-size:32px; display:block; margin-bottom:10px; color:#ddd;"></i>
                            No inquiries yet.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<!-- ===== CONVERSATION MODAL ===== -->
<div id="conversationModal" style="display:none; position:fixed; top:0; left:0; width:100%; height:100%; background:rgba(0,0,0,0.6); z-index:99999; justify-content:center; align-items:center;">
    <div style="background:#fff; width:100%; max-width:600px; max-height:90vh; display:flex; flex-direction:column; box-shadow:0 20px 60px rgba(0,0,0,0.3);">

        <!-- Header -->
        <div style="background:#111; padding:20px 25px; display:flex; align-items:center; justify-content:space-between; flex-shrink:0;">
            <div>
                <h5 style="color:#fff; font-size:13px; font-weight:800; letter-spacing:2px; text-transform:uppercase; margin:0;">
                    <i class="fa fa-comments" style="margin-right:8px; color:#c8a96e;"></i>
                    Conversation
                </h5>
                <p id="conv-subtitle" style="color:rgba(255,255,255,0.5); font-size:11px; margin:4px 0 0; letter-spacing:1px;"></p>
            </div>
            <button onclick="closeConversation()" title="Close"
                style="background:none; border:none; color:#fff; font-size:22px; cursor:pointer; line-height:1; padding:0; width:30px; height:30px; display:flex; align-items:center; justify-content:center;"
                onmouseover="this.style.color='#c8a96e';" onmouseout="this.style.color='#fff';">
                &times;
            </button>
        </div>

        <!-- Messages Area -->
        <div id="conv-messages" style="flex:1; overflow-y:auto; padding:20px; background:#f9f9f9; min-height:300px; max-height:400px;">
            <div style="text-align:center; padding:40px; color:#ccc;">
                <i class="fa fa-spinner fa-spin" style="font-size:24px;"></i>
                <p style="margin-top:10px; font-size:13px;">Loading conversation...</p>
            </div>
        </div>

        <!-- Reply Form -->
        <div style="padding:20px 25px; border-top:1px solid #f0f0f0; background:#fff; flex-shrink:0;">
            <form id="replyForm">
                <input type="hidden" id="reply_message_id">
                <label style="font-size:11px; font-weight:700; letter-spacing:1px; text-transform:uppercase; color:#111; display:block; margin-bottom:8px;">
                    Your Reply
                </label>
                <div style="display:flex; gap:10px;">
                    <textarea id="reply_text" name="message" rows="3"
                        placeholder="Type your reply here..."
                        style="flex:1; border:1px solid #e8e8e8; padding:10px 14px; font-size:13px; outline:none; resize:none; font-family:inherit; transition:border 0.3s;"
                        onfocus="this.style.borderColor='#111';"
                        onblur="this.style.borderColor='#e8e8e8';"
                        required></textarea>
                    <button type="submit" id="replyBtn"
                        style="background:#111; color:#fff; border:none; padding:10px 20px; font-size:11px; font-weight:700; letter-spacing:1px; text-transform:uppercase; cursor:pointer; transition:background 0.3s; align-self:flex-end;"
                        onmouseover="this.style.background='#c8a96e';" onmouseout="this.style.background='#111';">
                        <i class="fa fa-paper-plane"></i><br>Send
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- ===== DELETE CONFIRMATION MODAL ===== -->
<div id="deleteConvModal" style="display:none; position:fixed; top:0; left:0; width:100%; height:100%; background:rgba(0,0,0,0.6); z-index:99999; justify-content:center; align-items:center;">
    <div style="background:#fff; width:100%; max-width:440px; box-shadow:0 20px 60px rgba(0,0,0,0.3);">
        <div style="background:#e74c3c; padding:20px 25px; display:flex; align-items:center; justify-content:space-between;">
            <h5 style="color:#fff; font-size:13px; font-weight:800; letter-spacing:2px; text-transform:uppercase; margin:0;">
                <i class="fa fa-exclamation-triangle" style="margin-right:8px;"></i> Confirm Delete
            </h5>
            <button onclick="closeDeleteConvModal()"
                style="background:none; border:none; color:#fff; font-size:22px; cursor:pointer; line-height:1; padding:0; width:30px; height:30px; display:flex; align-items:center; justify-content:center;">
                &times;
            </button>
        </div>
        <div style="padding:30px 25px;">
            <p style="font-size:15px; color:#666; margin-bottom:8px;">Delete entire conversation with:</p>
            <p style="font-size:20px; font-weight:800; color:#111; margin-bottom:15px;" id="delete_conv_name"></p>
            <div style="background:#fdf0f0; color:#e74c3c; padding:12px 15px; font-size:13px; border-left:3px solid #e74c3c;">
                <i class="fa fa-exclamation-triangle"></i>
                All messages in this conversation will be <strong>permanently deleted</strong>.
            </div>
        </div>
        <div style="padding:15px 25px; border-top:1px solid #f0f0f0; display:flex; justify-content:flex-end;">
            <button onclick="confirmDeleteConv()"
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
    let currentMessageId = null;
    let currentUserId = null;
    let currentProductId = null;
    let convToDelete = null;

    $.ajaxSetup({
        headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') }
    });

    // ── OPEN CONVERSATION ───────────────────────────────
    function openConversation(userId, productId, userName, productName, messageId) {
        currentMessageId = messageId;
        currentUserId = userId;
        currentProductId = productId;

        $('#conv-subtitle').text(userName + ' — ' + productName);
        $('#reply_message_id').val(messageId);
        $('#reply_text').val('');
        $('#conversationModal').css('display', 'flex');

        loadMessages(messageId);
    }

    function closeConversation() {
        $('#conversationModal').css('display', 'none');
        location.reload(); // Refresh to update unread counts
    }

    // ── LOAD MESSAGES ───────────────────────────────────
    function loadMessages(messageId) {
        $('#conv-messages').html(`
            <div style="text-align:center; padding:40px; color:#ccc;">
                <i class="fa fa-spinner fa-spin" style="font-size:24px;"></i>
                <p style="margin-top:10px; font-size:13px;">Loading...</p>
            </div>
        `);

        $.get('/admin/messages/' + messageId, function(data) {
            if (data.length === 0) {
                $('#conv-messages').html(`
                    <div style="text-align:center; padding:40px; color:#ccc;">
                        <p style="font-size:13px;">No messages yet.</p>
                    </div>
                `);
                return;
            }

            let html = '';
            $.each(data, function(index, msg) {
                if (msg.sender === 'user') {
                    html += `
                        <div style="margin-bottom:15px; display:flex; justify-content:flex-start;">
                            <div style="max-width:80%;">
                                <div style="font-size:11px; color:#999; letter-spacing:1px; text-transform:uppercase; margin-bottom:5px; font-weight:600;">
                                    <i class="fa fa-user"></i> ${msg.user ? msg.user.name : 'User'}
                                </div>
                                <div style="background:#fff; border:1px solid #e8e8e8; color:#333; padding:12px 16px; font-size:13px; line-height:1.6;">
                                    ${msg.message}
                                </div>
                                <div style="font-size:11px; color:#ccc; margin-top:4px;">
                                    ${msg.created_at}
                                </div>
                            </div>
                        </div>`;
                } else {
                    html += `
                        <div style="margin-bottom:15px; display:flex; justify-content:flex-end;">
                            <div style="max-width:80%;">
                                <div style="font-size:11px; color:#c8a96e; letter-spacing:1px; text-transform:uppercase; margin-bottom:5px; font-weight:700; text-align:right;">
                                    <i class="fa fa-store"></i> You (Admin)
                                </div>
                                <div style="background:#111; color:#fff; padding:12px 16px; font-size:13px; line-height:1.6;">
                                    ${msg.message}
                                </div>
                                <div style="font-size:11px; color:#ccc; margin-top:4px; text-align:right;">
                                    ${msg.created_at}
                                </div>
                            </div>
                        </div>`;
                }
            });

            $('#conv-messages').html(html);
            // Scroll to bottom
            $('#conv-messages').scrollTop($('#conv-messages')[0].scrollHeight);
        }).fail(function() {
            $('#conv-messages').html(`
                <div style="text-align:center; padding:40px; color:#e74c3c;">
                    <p>Failed to load messages. Please try again.</p>
                </div>
            `);
        });
    }

    // ── SEND REPLY ──────────────────────────────────────
    $('#replyForm').submit(function(e) {
        e.preventDefault();
        let messageId = $('#reply_message_id').val();
        let message = $('#reply_text').val().trim();
        let btn = $('#replyBtn');

        if (!message) return;

        btn.html('<i class="fa fa-spinner fa-spin"></i>').prop('disabled', true);

        $.ajax({
            type: 'POST',
            url: '/admin/messages/' + messageId + '/reply',
            data: {
                message: message,
                _token: '{{ csrf_token() }}'
            },
            success: function(response) {
                btn.html('<i class="fa fa-paper-plane"></i><br>Send').prop('disabled', false);
                $('#reply_text').val('');

                // Add reply to conversation immediately
                let newMsg = `
                    <div style="margin-bottom:15px; display:flex; justify-content:flex-end;">
                        <div style="max-width:80%;">
                            <div style="font-size:11px; color:#c8a96e; letter-spacing:1px; text-transform:uppercase; margin-bottom:5px; font-weight:700; text-align:right;">
                                <i class="fa fa-store"></i> You (Admin)
                            </div>
                            <div style="background:#111; color:#fff; padding:12px 16px; font-size:13px; line-height:1.6;">
                                ${message}
                            </div>
                            <div style="font-size:11px; color:#ccc; margin-top:4px; text-align:right;">
                                Just now
                            </div>
                        </div>
                    </div>`;
                $('#conv-messages').append(newMsg);
                $('#conv-messages').scrollTop($('#conv-messages')[0].scrollHeight);

                showSuccess(response.success);
            },
            error: function(response) {
                btn.html('<i class="fa fa-paper-plane"></i><br>Send').prop('disabled', false);
                showError('Failed to send reply. Please try again.');
            }
        });
    });

    // ── DELETE CONVERSATION ─────────────────────────────
    function deleteConversation(messageId, userName) {
        convToDelete = messageId;
        $('#delete_conv_name').text('"' + userName + '"');
        $('#deleteConvModal').css('display', 'flex');
    }

    function closeDeleteConvModal() {
        $('#deleteConvModal').css('display', 'none');
        convToDelete = null;
    }

    function confirmDeleteConv() {
        if (!convToDelete) return;
        $.ajax({
            type: 'DELETE',
            url: '/admin/messages/' + convToDelete,
            data: { _token: '{{ csrf_token() }}' },
            success: function(response) {
                closeDeleteConvModal();
                showSuccess(response.success);
                setTimeout(() => location.reload(), 1000);
            },
            error: function() {
                showError('Something went wrong. Please try again.');
            }
        });
    }

    // Close modals when clicking outside
    $('#conversationModal, #deleteConvModal').click(function(e) {
        if ($(e.target).is(this)) {
            if ($(this).attr('id') === 'conversationModal') {
                closeConversation();
            } else {
                closeDeleteConvModal();
            }
        }
    });

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