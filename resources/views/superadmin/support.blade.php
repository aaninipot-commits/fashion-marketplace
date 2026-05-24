@extends('superadmin.layouts.superadmin')
@section('page_title', 'Support Messages')
@section('content')

<div class="sa-alert-success"></div>

<div class="sa-card">
    <div class="sa-card__header">
        <h5><i class="fa fa-headphones" style="color:#e74c3c; margin-right:8px;"></i> Support Messages</h5>
        <span style="font-size:12px; color:#999;">{{ $messages->count() }} total messages</span>
    </div>
    <div style="padding:0;">
        <table class="sa-table">
            <thead>
                <tr>
                    <th>User</th>
                    <th>Type</th>
                    <th>Subject</th>
                    <th>Date</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($messages as $msg)
                    <tr id="support-row-{{ $msg->id }}">
                        <td>
                            <div style="font-weight:700; font-size:13px;">{{ $msg->name }}</div>
                            <div style="font-size:11px; color:#999;">{{ $msg->email }}</div>
                        </td>
                        <td>
                            <span style="background:#f0f0f0; color:#666; padding:3px 10px; font-size:10px; font-weight:700;">
                                {{ $msg->type ?? 'General' }}
                            </span>
                        </td>
                        <td style="font-size:13px;">{{ Str::limit($msg->subject, 35) }}</td>
                        <td style="font-size:12px; color:#999;">{{ $msg->created_at->format('M d, Y') }}</td>
                        <td>
                            @if($msg->reply)
                                <span class="badge-approved">Replied</span>
                            @elseif($msg->is_read)
                                <span class="badge-pending">Read</span>
                            @else
                                <span class="badge-banned">Unread</span>
                            @endif
                        </td>
                        <td>
                            <div style="display:flex; gap:5px;">
                                <button class="sa-btn sa-btn-reply" onclick="openReply({{ $msg->id }}, '{{ addslashes($msg->name) }}', '{{ addslashes($msg->subject) }}', '{{ addslashes($msg->message) }}', '{{ addslashes($msg->reply) }}')">
                                    <i class="fa fa-reply"></i> Reply
                                </button>
                                <button class="sa-btn sa-btn-delete" onclick="deleteSupport({{ $msg->id }})">
                                    <i class="fa fa-trash"></i>
                                </button>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" style="text-align:center; color:#999; padding:40px;">No support messages yet</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<!-- Reply Modal -->
<div class="sa-modal" id="replyModal">
    <div class="sa-modal__box">
        <div class="sa-modal__header">
            <h5><i class="fa fa-reply" style="margin-right:8px; color:#c8a96e;"></i> Reply to Message</h5>
            <button onclick="$('#replyModal').css('display','none')">&times;</button>
        </div>
        <div class="sa-modal__body">
            <input type="hidden" id="reply-msg-id">

            <!-- Original Message -->
            <div style="background:#f9f9f9; padding:15px 20px; margin-bottom:20px; border-left:3px solid #c8a96e;">
                <div style="font-size:11px; font-weight:700; color:#999; letter-spacing:1px; text-transform:uppercase; margin-bottom:8px;">Original Message</div>
                <div style="font-size:13px; font-weight:700; color:#111; margin-bottom:5px;" id="reply-subject"></div>
                <div style="font-size:13px; color:#666; line-height:1.6;" id="reply-message"></div>
                <div style="font-size:11px; color:#999; margin-top:8px;">From: <span id="reply-from"></span></div>
            </div>

            <!-- Previous Reply -->
            <div id="previous-reply-section" style="display:none; background:#f0fdf4; padding:15px 20px; margin-bottom:20px; border-left:3px solid #27ae60;">
                <div style="font-size:11px; font-weight:700; color:#27ae60; letter-spacing:1px; text-transform:uppercase; margin-bottom:8px;">Previous Reply</div>
                <div style="font-size:13px; color:#444; line-height:1.6;" id="previous-reply-text"></div>
            </div>

            <!-- Reply Form -->
            <div>
                <label style="font-size:11px; font-weight:700; letter-spacing:1px; text-transform:uppercase; color:#111; display:block; margin-bottom:8px;">
                    Your Reply <span style="color:#e74c3c;">*</span>
                </label>
                <textarea id="reply-text" rows="5"
                    placeholder="Type your reply here..."
                    style="width:100%; border:1px solid #e8e8e8; padding:12px 15px; font-size:13px; outline:none; resize:none; font-family:inherit; transition:border 0.3s;"
                    onfocus="this.style.borderColor='#111';"
                    onblur="this.style.borderColor='#e8e8e8';"></textarea>
            </div>

            <div style="display:flex; justify-content:flex-end; margin-top:20px;">
                <button class="sa-btn sa-btn-reply" onclick="sendReply()">
                    <i class="fa fa-paper-plane"></i> Send Reply
                </button>
            </div>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
    function openReply(id, name, subject, message, reply) {
        $('#reply-msg-id').val(id);
        $('#reply-from').text(name);
        $('#reply-subject').text(subject);
        $('#reply-message').text(message);
        $('#reply-text').val('');

        if (reply && reply !== 'null' && reply !== '') {
            $('#previous-reply-text').text(reply);
            $('#previous-reply-section').show();
        } else {
            $('#previous-reply-section').hide();
        }

        $('#replyModal').css('display', 'flex');
    }

    function sendReply() {
        let id    = $('#reply-msg-id').val();
        let reply = $('#reply-text').val().trim();

        if (!reply) {
            alert('Please type a reply first.');
            return;
        }

        $.post('/superadmin/support/' + id + '/reply', { reply: reply }, function(response) {
            $('#replyModal').css('display', 'none');
            showSuccess(response.success);
            setTimeout(() => location.reload(), 1000);
        });
    }

    function deleteSupport(id) {
        if (confirm('Delete this message?')) {
            $.ajax({
                type: 'DELETE',
                url: '/superadmin/support/' + id,
                success: function(response) {
                    $('#support-row-' + id).fadeOut(400, function() { $(this).remove(); });
                    showSuccess(response.success);
                }
            });
        }
    }
</script>
@endpush