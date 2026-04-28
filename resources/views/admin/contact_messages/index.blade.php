@extends('admin.layouts.admin')

@section('page_title', 'Contact Messages')

@section('content')

<div class="admin__card">
    <div class="admin__card__header">
        <h5>Contact Messages</h5>
    </div>
    <div class="admin__card__body" style="padding:0;">
        <table class="table mb-0">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Subject</th>
                    <th>Message</th>
                    <th>Status</th>
                    <th>Date</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($messages as $key => $message)
                    <tr id="contact-row-{{ $message->id }}">
                        <td>{{ $key + 1 }}</td>
                        <td>{{ $message->name }}</td>
                        <td>{{ $message->email }}</td>
                        <td>{{ $message->subject ?? 'N/A' }}</td>
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
                            <button class="btn-admin btn-view" onclick="viewMessage({{ $message->id }})">
                                <i class="fa fa-eye"></i> View
                            </button>
                            <button class="btn-admin btn-delete ms-1" onclick="deleteMessage({{ $message->id }})">
                                <i class="fa fa-trash"></i> Delete
                            </button>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="8" class="text-center" style="color:#999;">No messages found</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<!-- View Modal -->
<div class="modal fade" id="viewMessageModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Contact Message</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <p><strong>Name:</strong> <span id="view_name"></span></p>
                <p><strong>Email:</strong> <span id="view_email"></span></p>
                <p><strong>Subject:</strong> <span id="view_subject"></span></p>
                <p><strong>Message:</strong></p>
                <div id="view_message" style="background:#f9f9f9; padding:15px; font-size:13px; line-height:1.8;"></div>
            </div>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
    function viewMessage(id) {
        $.get('/admin/contact-messages/' + id, function(data) {
            $('#view_name').text(data.name);
            $('#view_email').text(data.email);
            $('#view_subject').text(data.subject ?? 'N/A');
            $('#view_message').text(data.message);
            $('#viewMessageModal').modal('show');

            // Update status to read in the table
            $('#contact-row-' + id).find('.badge-unavailable')
                .removeClass('badge-unavailable')
                .addClass('badge-available')
                .text('Read');
        });
    }

    function deleteMessage(id) {
        if (confirm('Are you sure you want to delete this message?')) {
            $.ajax({
                type: 'DELETE',
                url: '/admin/contact-messages/' + id,
                data: { _token: '{{ csrf_token() }}' },
                success: function(response) {
                    alert(response.success);
                    $('#contact-row-' + id).remove();
                },
                error: function() {
                    alert('Something went wrong.');
                }
            });
        }
    }
</script>
@endpush