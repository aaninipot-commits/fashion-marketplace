@extends('superadmin.layouts.superadmin')
@section('page_title', 'All Inquiries')
@section('content')

<div class="sa-alert-success" style="display:none; background:#f0fdf4; color:#27ae60; border-left:4px solid #27ae60; padding:12px 16px; margin-bottom:20px; font-size:13px; font-weight:600;"></div>

@php
    // Group messages by user_id and product_id (conversations)
    $conversations = $messages->groupBy(function($msg) {
        return $msg->user_id . '-' . $msg->product_id;
    });
@endphp

<div class="sa-card">
    <div class="sa-card__header">
        <h5><i class="fa fa-comments" style="color:#16a085; margin-right:8px;"></i> All Product Inquiries</h5>
        <span style="font-size:12px; color:#999;">{{ $conversations->count() }} conversations</span>
    </div>
    <div style="padding:0;">
        <table class="sa-table">
            <thead>
                <tr>
                    <th>Buyer</th>
                    <th>Product</th>
                    <th>Seller</th>
                    <th>Messages</th>
                    <th>Last Message</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($conversations as $key => $conv)
                    @php
                        $first = $conv->first();
                        $last  = $conv->last();
                    @endphp
                    <tr>
                        <td>
                            <div style="font-weight:700; font-size:13px;">{{ $first->user->name ?? 'Unknown' }}</div>
                            <div style="font-size:11px; color:#999;">{{ $first->user->email ?? '' }}</div>
                        </td>
                        <td>
                            <div style="font-size:13px; font-weight:600;">{{ $first->product->name ?? 'Deleted' }}</div>
                            @if($first->product)
                                <div style="font-size:11px; color:#c8a96e;">₱{{ number_format($first->product->price, 2) }}</div>
                            @endif
                        </td>
                        <td style="font-size:12px;">
                            {{ $first->product->seller->shop_name ?? ($first->product->seller->name ?? '—') }}
                        </td>
                        <td>
                            <span style="background:#f0f8ff; color:#2980b9; padding:3px 10px; font-size:12px; font-weight:700;">
                                {{ $conv->count() }} messages
                            </span>
                        </td>
                        <td style="font-size:12px;">
                            <div style="color:#666; max-width:150px; white-space:nowrap; overflow:hidden; text-overflow:ellipsis;">
                                {{ Str::limit($last->message, 40) }}
                            </div>
                            <div style="font-size:11px; color:#999;">{{ $last->created_at->diffForHumans() }}</div>
                        </td>
                        <td>
                            <button class="sa-btn sa-btn-reply" onclick="viewConversation('{{ $key }}')">
                                <i class="fa fa-eye"></i> View
                            </button>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" style="text-align:center; color:#999; padding:40px;">No inquiries yet</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<!-- Conversation Modal -->
<div class="sa-modal" id="convModal">
    <div class="sa-modal__box" style="max-width:600px; max-height:90vh;">
        <div class="sa-modal__header">
            <h5><i class="fa fa-comments" style="margin-right:8px; color:#c8a96e;"></i> Conversation</h5>
            <button onclick="$('#convModal').css('display','none')">&times;</button>
        </div>
        <div id="conv-content" style="padding:20px; overflow-y:auto; max-height:70vh; background:#f5f5f5;">
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
    // Store conversations data
    const conversations = @json($conversations->map(function($conv) {
        return $conv->map(function($msg) {
            return [
                'id'         => $msg->id,
                'message'    => $msg->message,
                'sender'     => $msg->sender,
                'created_at' => $msg->created_at->format('M d, Y h:i A'),
                'user_name'  => $msg->user ? $msg->user->name : 'Unknown',
                'product'    => $msg->product ? $msg->product->name : 'Deleted Product',
                'seller'     => $msg->product && $msg->product->seller ? ($msg->product->seller->shop_name ?? $msg->product->seller->name) : 'Unknown Seller',
            ];
        })->values();
    }));

    function viewConversation(key) {
        const conv = conversations[key];
        if (!conv || conv.length === 0) return;

        const first = conv[0];
        let html = `
            <div style="background:#111; padding:12px 15px; margin-bottom:15px; display:flex; justify-content:space-between; align-items:center;">
                <div>
                    <div style="color:#c8a96e; font-size:11px; font-weight:700; letter-spacing:1px; text-transform:uppercase;">Product</div>
                    <div style="color:#fff; font-size:13px; font-weight:600;">${first.product}</div>
                </div>
                <div style="text-align:right;">
                    <div style="color:#c8a96e; font-size:11px; font-weight:700; letter-spacing:1px; text-transform:uppercase;">Seller</div>
                    <div style="color:#fff; font-size:13px;">${first.seller}</div>
                </div>
            </div>
        `;

        conv.forEach(function(msg) {
            if (msg.sender === 'user') {
                html += `
                    <div style="margin-bottom:15px; display:flex; justify-content:flex-start; gap:10px;">
                        <div style="width:32px; height:32px; background:#2980b9; border-radius:50%; display:flex; align-items:center; justify-content:center; font-size:12px; font-weight:700; color:#fff; flex-shrink:0;">
                            ${msg.user_name.charAt(0).toUpperCase()}
                        </div>
                        <div style="max-width:75%;">
                            <div style="font-size:10px; color:#2980b9; font-weight:700; letter-spacing:1px; text-transform:uppercase; margin-bottom:4px;">
                                ${msg.user_name} (Buyer)
                            </div>
                            <div style="background:#fff; border:1px solid #e8e8e8; padding:10px 14px; font-size:13px; line-height:1.6; border-radius:0 12px 12px 12px; box-shadow:0 1px 3px rgba(0,0,0,0.05);">
                                ${msg.message}
                            </div>
                            <div style="font-size:10px; color:#ccc; margin-top:4px;">${msg.created_at}</div>
                        </div>
                    </div>`;
            } else {
                html += `
                    <div style="margin-bottom:15px; display:flex; justify-content:flex-end; gap:10px;">
                        <div style="max-width:75%;">
                            <div style="font-size:10px; color:#c8a96e; font-weight:700; letter-spacing:1px; text-transform:uppercase; margin-bottom:4px; text-align:right;">
                                ${first.seller} (Seller)
                            </div>
                            <div style="background:#111; color:#fff; padding:10px 14px; font-size:13px; line-height:1.6; border-radius:12px 0 12px 12px;">
                                ${msg.message}
                            </div>
                            <div style="font-size:10px; color:#ccc; margin-top:4px; text-align:right;">${msg.created_at}</div>
                        </div>
                        <div style="width:32px; height:32px; background:#c8a96e; border-radius:50%; display:flex; align-items:center; justify-content:center; font-size:12px; font-weight:700; color:#111; flex-shrink:0;">
                            S
                        </div>
                    </div>`;
            }
        });

        $('#conv-content').html(html);
        $('#convModal').css('display', 'flex');
    }

    function showSuccess(msg) {
        $('.sa-alert-success').text(msg).show();
        setTimeout(() => $('.sa-alert-success').fadeOut(), 3000);
    }
</script>
@endpush