@extends('admin.layouts.admin')

@section('page_title', 'Customer Support')

@section('content')

<div class="print-success-msg" style="display:none; background:#f0fdf4; color:#27ae60; border-left:4px solid #27ae60; padding:12px 16px; margin-bottom:20px; font-size:13px; font-weight:600;">
    <i class="fa fa-check-circle"></i> <span class="msg-text"></span>
</div>

<div class="admin__card">
    <div class="admin__card__header">
        <h5>Customer Support Messages</h5>
    </div>
    <div class="admin__card__body" style="padding:0;">
        <table class="table mb-0">
            <thead>
                <tr>
                    <th>#</th>
                    <th>User</th>
                    <th>Type</th>
                    <th>Subject</th>
                    <th>Message</th>
                    <th>Date</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($messages as $key => $message)
                    <tr id="msg-row-{{ $message->id }}" style="{{ !$message->is_read ? 'background:#fffbf0;' : '' }}">
                        <td>{{ $key + 1 }}</td>
                        <td>
                            <div style="font-weight:700; font-size:13px;">{{ $message->name }}</div>
                            <div style="font-size:11px; color:#999;">{{ $message->email }}</div>
                        </td>
                        <td>
                            @php
                                $typeColors = [
                                    'Bug Report'     => ['bg' => '#fdf0f0', 'color' => '#e74c3c', 'icon' => 'fa-bug'],
                                    'Feedback'       => ['bg' => '#fff8f0', 'color' => '#f39c12', 'icon' => 'fa-lightbulb-o'],
                                    'General Inquiry'=> ['bg' => '#f0f8ff', 'color' => '#3498db', 'icon' => 'fa-question-circle'],
                                    'Report a User'  => ['bg' => '#fdf0f0', 'color' => '#e74c3c', 'icon' => 'fa-flag'],
                                ];
                                $tc = $typeColors[$message->type] ?? ['bg' => '#f0f0f0', 'color' => '#666', 'icon' => 'fa-envelope'];
                            @endphp
                            <span style="background:{{ $tc['bg'] }}; color:{{ $tc['color'] }}; padding:4px 10px; font-size:11px; font-weight:700; display:inline-flex; align-items:center; gap:5px;">
                                <i class="fa {{ $tc['icon'] }}"></i>
                                {{ $message->type ?? 'General' }}
                            </span>
                        </td>
                        <td style="font-size:13px; font-weight:600; color:#111;">{{ $message->subject }}</td>
                        <td style="max-width:200px;">
                            <div style="white-space:nowrap; overflow:hidden; text-overflow:ellipsis; font-size:12px; color:#666;">
                                {{ Str::limit($message->message, 50) }}
                            </div>
                        </td>
                        <td style="font-size:12px; color:#999;">{{ $message->created_at->format('M d, Y') }}</td>
                        <td>
                            @if(!$message->is_read)
                                <span style="background:#fff8f0; color:#f39c12; padding:4px 10px; font-size:11px; font-weight:700;">
                                    <i class="fa fa-circle" style="font-size:8px;"></i> Unread
                                </span>
                            @else
                                <span style="background:#f0fdf4; color:#27ae60; padding:4px 10px; font-size:11px; font-weight:700;">
                                    <i class="fa fa-check"></i> Read
                                </span>
                            @endif
                        </td>
                        <td>
                            <button class="btn-admin btn-view" onclick="viewMessage({{ $message->id }}, '{{ addslashes($message->name) }}', '{{ addslashes($message->email) }}', '{{ addslashes($message->type ?? 'General') }}', '{{ addslashes($message->subject) }}', '{{ addslashes($message->message) }}', '{{ $message->created_at->format('M d, Y h:i A') }}')">
                                <i class="fa fa-eye"></i> View
                            </button>
                            <button class="btn-admin btn-delete ms-1" onclick="deleteMessage({{ $message->id }})">
                                <i class="fa fa-trash"></i> Delete
                            </button>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="8" class="text-center" style="color:#999; padding:40px;">
                            <i class="fa fa-envelope" style="font-size:32px; display:block; margin-bottom:10px; color:#ddd;"></i>
                            No support messages yet.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<!-- View Message Modal -->
<div id="viewMsgModal" style="display:none; position:fixed; top:0; left:0; width:100%; height:100%; background:rgba(0,0,0,0.6); z-index:99999; justify-content:center; align-items:center;">
    <div style="background:#fff; width:100%; max-width:560px; box-shadow:0 20px 60px rgba(0,0,0,0.3);">
        <div style="background:#111; padding:20px 25px; display:flex; align-items:center; justify-content:space-between;">
            <h5 style="color:#fff; font-size:13px; font-weight:800; letter-spacing:2px; text-transform:uppercase; margin:0;">
                <i class="fa fa-envelope" style="margin-right:8px; color:#c8a96e;"></i> Message Details
            </h5>
            <button onclick="closeViewMsg()"
                style="background:none; border:none; color:#fff; font-size:22px; cursor:pointer; padding:0; width:30px; height:30px; display:flex; align-items:center; justify-content:center;"
                onmouseover="this.style.color='#c8a96e';" onmouseout="this.style.color='#fff';">
                &times;
            </button>
        </div>
        <div style="padding:25px;">
            <div style="display:grid; gap:15px; margin-bottom:20px;">
                <div style="display:flex; gap:15px; align-items:flex-start;">
                    <span style="font-size:11px; color:#999; text-transform:uppercase; letter-spacing:1px; width:70px; flex-shrink:0; padding-top:2px;">From</span>
                    <div>
                        <div style="font-weight:700; color:#111;" id="msg-name"></div>
                        <div style="font-size:12px; color:#999;" id="msg-email"></div>
                    </div>
                </div>
                <div style="display:flex; gap:15px; align-items:center;">
                    <span style="font-size:11px; color:#999; text-transform:uppercase; letter-spacing:1px; width:70px; flex-shrink:0;">Type</span>
                    <span id="msg-type" style="padding:4px 12px; font-size:11px; font-weight:700;"></span>
                </div>
                <div style="display:flex; gap:15px; align-items:center;">
                    <span style="font-size:11px; color:#999; text-transform:uppercase; letter-spacing:1px; width:70px; flex-shrink:0;">Subject</span>
                    <span id="msg-subject" style="font-weight:700; color:#111; font-size:13px;"></span>
                </div>
                <div style="display:flex; gap:15px; align-items:center;">
                    <span style="font-size:11px; color:#999; text-transform:uppercase; letter-spacing:1px; width:70px; flex-shrink:0;">Date</span>
                    <span id="msg-date" style="font-size:12px; color:#666;"></span>
                </div>
            </div>
            <div style="border-top:1px solid #f0f0f0; padding-top:20px;">
                <div style="font-size:11px; color:#999; text-transform:uppercase; letter-spacing:1px; margin-bottom:10px;">Message</div>
                <div id="msg-body" style="font-size:13px; color:#333; line-height:1.8; background:#f9f9f9; padding:15px; border-left:3px solid #c8a96e;"></div>
            </div>
        </div>
        <div style="padding:15px 25px; border-top:1px solid #f0f0f0; display:flex; justify-content:flex-end;">
            <button onclick="closeViewMsg()"
                style="background:#111; color:#fff; border:none; padding:10px 24px; font-size:11px; font-weight:700; letter-spacing:1px; text-transform:uppercase; cursor:pointer; transition:background 0.3s;"
                onmouseover="this.style.background='#c8a96e';" onmouseout="this.style.background='#111';">
                Close
            </button>
        </div>
    </div>
</div>

<!-- Delete Confirmation Modal -->
<div id="deleteMsgModal" style="display:none; position:fixed; top:0; left:0; width:100%; height:100%; background:rgba(0,0,0,0.6); z-index:99999; justify-content:center; align-items:center;">
    <div style="background:#fff; width:100%; max-width:420px; box-shadow:0 20px 60px rgba(0,0,0,0.3);">
        <div style="background:#e74c3c; padding:20px 25px; display:flex; align-items:center; justify-content:space-between;">
            <h5 style="color:#fff; font-size:13px; font-weight:800; letter-spacing:2px; text-transform:uppercase; margin:0;">
                <i class="fa fa-exclamation-triangle" style="margin-right:8px;"></i> Confirm Delete
            </h5>
            <button onclick="closeDeleteMsg()"
                style="background:none; border:none; color:#fff; font-size:22px; cursor:pointer; padding:0; width:30px; height:30px; display:flex; align-items:center; justify-content:center;">
                &times;
            </button>
        </div>
        <div style="padding:25px;">
            <p style="font-size:14px; color:#666; margin-bottom:15px;">Are you sure you want to delete this message?</p>
            <div style="background:#fdf0f0; color:#e74c3c; padding:12px 15px; font-size:13px; border-left:3px solid #e74c3c;">
                <i class="fa fa-exclamation-triangle"></i> This action <strong>cannot be undone</strong>.
            </div>
        </div>
        <div style="padding:15px 25px; border-top:1px solid #f0f0f0; display:flex; justify-content:flex-end;">
            <button onclick="confirmDeleteMsg()"
                style="background:#e74c3c; color:#fff; border:none; padding:10px 24px; font-size:11px; font-weight:700; letter-spacing:1px; text-transform:uppercase; cursor:pointer;"
                onmouseover="this.style.background='#c0392b';" onmouseout="this.style.background='#e74c3c';">
                <i class="fa fa-trash"></i> Yes, Delete
            </button>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
    let msgToDelete = null;

    $.ajaxSetup({
        headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') }
    });

    function viewMessage(id, name, email, type, subject, message, date) {
        $('#msg-name').text(name);
        $('#msg-email').text(email);
        $('#msg-type').text(type).css({
            'background': type === 'Bug Report' || type === 'Report a User' ? '#fdf0f0' : type === 'Feedback' ? '#fff8f0' : '#f0f8ff',
            'color': type === 'Bug Report' || type === 'Report a User' ? '#e74c3c' : type === 'Feedback' ? '#f39c12' : '#3498db'
        });
        $('#msg-subject').text(subject);
        $('#msg-body').text(message);
        $('#msg-date').text(date);
        $('#viewMsgModal').css('display', 'flex');

        // Mark as read
        $.post('/admin/contact-messages/' + id + '/read', { _token: '{{ csrf_token() }}' });
        $('#msg-row-' + id).css('background', '#fff');
        $('#msg-row-' + id).find('span:contains("Unread")').html('<i class="fa fa-check"></i> Read')
            .css({'background': '#f0fdf4', 'color': '#27ae60'});
    }

    function closeViewMsg() {
        $('#viewMsgModal').css('display', 'none');
    }

    function deleteMessage(id) {
        msgToDelete = id;
        $('#deleteMsgModal').css('display', 'flex');
    }

    function closeDeleteMsg() {
        $('#deleteMsgModal').css('display', 'none');
        msgToDelete = null;
    }

    function confirmDeleteMsg() {
        if (!msgToDelete) return;
        $.ajax({
            type: 'DELETE',
            url: '/admin/contact-messages/' + msgToDelete,
            data: { _token: '{{ csrf_token() }}' },
            success: function(response) {
                closeDeleteMsg();
                $('#msg-row-' + msgToDelete).fadeOut(400, function() { $(this).remove(); });
                showSuccess(response.success);
                msgToDelete = null;
            }
        });
    }

    $('#viewMsgModal, #deleteMsgModal').click(function(e) {
        if ($(e.target).is(this)) $(this).css('display', 'none');
    });

    function showSuccess(msg) {
        $('.print-success-msg .msg-text').text(msg);
        $('.print-success-msg').show();
        setTimeout(() => $('.print-success-msg').fadeOut(), 3000);
    }
</script>
@endpush