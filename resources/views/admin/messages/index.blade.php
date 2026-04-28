@extends('admin.layouts.admin')

@section('page_title', 'Messages')

@section('content')

<div class="admin__card">
    <div class="admin__card__header">
        <h5>All Inquiries</h5>
    </div>
    <div class="admin__card__body" style="padding:0;">
        <table class="table mb-0">
            <thead>
                <tr>
                    <th>#</th>
                    <th>User</th>
                    <th>Product</th>
                    <th>Message</th>
                    <th>Status</th>
                    <th>Date</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($messages as $key => $message)
                    <tr id="message-row-{{ $message->id }}">
                        <td>{{ $key + 1 }}</td>
                        <td>{{ $message->user->name }}</td>
                        <td>{{ $message->product->name }}</td>
                        <td>{{ Str::limit($message->message, 50) }}</td>
                        <td>
                            @if($message->is_read)
                                <span class="badge-available">Read</span>
                            @else
                                <span class="badge-unavailable">Unread</span>
                            @endif
                        </td>
                        <td>{{ $message->created_at->format('M d, Y') }}</td>
                        <td>
                            <button class="btn-admin btn-view" onclick="viewConversation({{ $message->id }})">
                                <i class="fa fa-comments"></i> Reply
                            </button>
                            <button class="btn-admin btn-delete ms-1" onclick="deleteMessage({{ $message->id }})">
                                <i class="fa fa-trash"></i> Delete
                            </button>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="text-center" style="color:#999;">No messages found</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<!-- Conversation Modal -->
<div class="modal fade" id="conversationModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Conversation</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div id="conversation-messages" style="max-height:400px; overflow-y:auto; padding:10px; background:#f9f9f9; margin-bottom:20px;"></div>
                <form id="replyForm">
                    <input type="hidden" id="reply_message_id">
                    <div class="mb-3">
                        <label class="form-label">Your Reply</label>
                        <textarea name="message" id="reply_text" class="form-control" rows="3" placeholder="Type your reply here..." required></textarea>
                    </div>
                    <div class="text-end">
                        <button type="submit" class="btn-add">Send Reply</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
    // View Conversation
    function viewConversation(id) {
        $('#reply_message_id').val(id);
        $.get('/admin/messages/' + id, function(data) {
            let html = '';
            $.each(data, function(index, msg) {
                if (msg.sender === 'user') {
                    html += '<div style="margin-bottom:15px;">';
                    html += '<strong style="font-size:12px; color:#999; letter-spacing:1px; text-transform:uppercase;">' + msg.user.name + '</strong>';
                    html += '<div style="background:#fff; border:1px solid #eee; padding:12px 15px; margin-top:5px; font-size:13px;">' + msg.message + '</div>';
                    html += '<small style="color:#ccc; font-size:11px;">' + msg.created_at + '</small>';
                    html += '</div>';
                } else {
                    html += '<div style="margin-bottom:15px; text-align:right;">';
                    html += '<strong style="font-size:12px; color:#c8a96e; letter-spacing:1px; text-transform:uppercase;">Admin</strong>';
                    html += '<div style="background:#111; color:#fff; padding:12px 15px; margin-top:5px; font-size:13px;">' + msg.message + '</div>';
                    html += '<small style="color:#ccc; font-size:11px;">' + msg.created_at + '</small>';
                    html += '</div>';
                }
            });
            $('#conversation-messages').html(html);
            $('#conversationModal').modal('show');
        });
    }

    // Send Reply
    $('#replyForm').submit(function(e) {
        e.preventDefault();
        let id = $('#reply_message_id').val();
        let formData = new FormData(this);
        $.ajax({
            type: 'POST',
            url: '/admin/messages/' + id + '/reply',
            data: formData,
            contentType: false,
            processData: false,
            success: function(response) {
                alert(response.success);
                $('#reply_text').val('');
                viewConversation(id);
            },
            error: function() {
                alert('Something went wrong.');
            }
        });
    });

    // Delete Message
    function deleteMessage(id) {
        if (confirm('Are you sure you want to delete this message?')) {
            $.ajax({
                type: 'DELETE',
                url: '/admin/messages/' + id,
                data: { _token: '{{ csrf_token() }}' },
                success: function(response) {
                    alert(response.success);
                    $('#message-row-' + id).remove();
                },
                error: function() {
                    alert('Something went wrong.');
                }
            });
        }
    }
</script>
@endpush