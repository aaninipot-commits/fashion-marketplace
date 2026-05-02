@extends('layouts.app')

@section('content')

<!-- Breadcrumb -->
<div class="breacrumb-section">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="breadcrumb-text">
                    <a href="{{ route('home') }}"><i class="fa fa-home"></i> Home</a>
                    <a href="{{ route('shop.index') }}">Shop</a>
                    <span>{{ $product->name }}</span>
                </div>
            </div>
        </div>
    </div>
</div>

<section class="product-details spad">
    <div class="container">
        <div class="row">

            <!-- Product Image -->
            <div class="col-lg-6">
                <div style="background:#f9f9f9; padding:30px; text-align:center; position:relative;">
                    @if($product->image)
                        <img src="{{ asset($product->image) }}"
                            alt="{{ $product->name }}"
                            style="max-width:100%; max-height:500px; object-fit:contain;">
                    @else
                        <div style="height:400px; display:flex; align-items:center; justify-content:center; color:#ddd; flex-direction:column; gap:15px;">
                            <i class="fa fa-image" style="font-size:64px;"></i>
                            <p style="font-size:14px;">No image available</p>
                        </div>
                    @endif

                    @if($product->stock <= 0)
                        <div style="position:absolute; top:20px; left:20px; background:#e74c3c; color:#fff; padding:6px 16px; font-size:12px; font-weight:700; letter-spacing:1px;">
                            OUT OF STOCK
                        </div>
                    @elseif($product->stock <= 5)
                        <div style="position:absolute; top:20px; left:20px; background:#f39c12; color:#fff; padding:6px 16px; font-size:12px; font-weight:700; letter-spacing:1px;">
                            LOW STOCK
                        </div>
                    @endif
                </div>
            </div>

            <!-- Product Details -->
            <div class="col-lg-6">
                <div style="padding:20px 0;">

                    <div style="display:flex; gap:10px; margin-bottom:15px; flex-wrap:wrap;">
                        <span style="background:#f0f0f0; color:#666; padding:4px 12px; font-size:11px; font-weight:700; letter-spacing:1px; text-transform:uppercase;">
                            {{ ucfirst($product->category->gender) }} — {{ $product->category->name }}
                        </span>
                        <span style="background:#f9f4ec; color:#c8a96e; padding:4px 12px; font-size:11px; font-weight:700; letter-spacing:1px; text-transform:uppercase;">
                            <i class="fa fa-store"></i> {{ $product->seller->shop_name ?? $product->seller->name }}
                        </span>
                    </div>

                    <h2 style="font-size:32px; font-weight:800; color:#111; margin-bottom:15px; line-height:1.2;">
                        {{ $product->name }}
                    </h2>

                    <div style="font-size:32px; font-weight:800; color:#c8a96e; margin-bottom:20px;">
                        ₱{{ number_format($product->price, 2) }}
                    </div>

                    <div style="margin-bottom:20px;">
                        @if($product->stock <= 0)
                            <span style="background:#fdf0f0; color:#e74c3c; padding:6px 16px; font-size:12px; font-weight:700; letter-spacing:1px;">
                                <i class="fa fa-times-circle"></i> Out of Stock
                            </span>
                        @elseif($product->stock <= 5)
                            <span style="background:#fff8f0; color:#f39c12; padding:6px 16px; font-size:12px; font-weight:700; letter-spacing:1px;">
                                <i class="fa fa-exclamation-circle"></i> Low Stock — Only {{ $product->stock }} left!
                            </span>
                        @else
                            <span style="background:#f0fdf4; color:#27ae60; padding:6px 16px; font-size:12px; font-weight:700; letter-spacing:1px;">
                                <i class="fa fa-check-circle"></i> In Stock ({{ $product->stock }} available)
                            </span>
                        @endif
                    </div>

                    <div style="border-top:1px solid #f0f0f0; border-bottom:1px solid #f0f0f0; padding:20px 0; margin-bottom:20px;">
                        @if($product->description)
                            <p style="font-size:14px; color:#666; line-height:1.8; margin-bottom:15px;">
                                {{ $product->description }}
                            </p>
                        @endif
                        <div style="display:flex; flex-wrap:wrap; gap:15px;">
                            @if($product->size)
                                <div style="font-size:13px; color:#444;">
                                    <strong>Size:</strong> {{ $product->size }}
                                </div>
                            @endif
                            @if($product->color)
                                <div style="font-size:13px; color:#444;">
                                    <strong>Color:</strong> {{ $product->color }}
                                </div>
                            @endif
                        </div>
                    </div>

                    <div style="background:#f9f9f9; padding:20px; margin-bottom:25px; border-left:3px solid #c8a96e;">
                        <p style="font-size:11px; letter-spacing:2px; text-transform:uppercase; color:#999; margin-bottom:5px;">Sold by</p>
                        <p style="font-size:16px; font-weight:700; color:#111; margin-bottom:3px;">
                            {{ $product->seller->shop_name ?? $product->seller->name }}
                        </p>
                        @if($product->seller->shop_description)
                            <p style="font-size:13px; color:#666; margin:0;">{{ $product->seller->shop_description }}</p>
                        @endif
                    </div>

                    @if($product->stock > 0)
                        <button onclick="openChat()"
                            style="background:#111; color:#fff; border:none; padding:16px 40px; font-size:12px; font-weight:700; letter-spacing:3px; text-transform:uppercase; cursor:pointer; transition:background 0.3s; width:100%; display:flex; align-items:center; justify-content:center; gap:10px;"
                            onmouseover="this.style.background='#c8a96e'"
                            onmouseout="this.style.background='#111'">
                            <i class="fa fa-comments"></i> Send Inquiry to Seller
                        </button>
                    @else
                        <div style="background:#f5f5f5; padding:15px; text-align:center; color:#999; font-size:13px; font-weight:600; letter-spacing:1px; text-transform:uppercase;">
                            This product is currently out of stock
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Related Products -->
        @if($relatedProducts->count() > 0)
        <div class="row mt-5">
            <div class="col-lg-12">
                <div style="margin-bottom:30px;">
                    <span style="font-size:12px; letter-spacing:3px; text-transform:uppercase; color:#c8a96e; font-weight:700;">More Like This</span>
                    <h3 style="font-size:24px; font-weight:800; color:#111; margin-top:5px;">Related Products</h3>
                </div>
            </div>
            @foreach($relatedProducts as $related)
                <div class="col-lg-3 col-md-6 col-sm-6 mb-4">
                    <div class="product__item">
                        <div class="product__item__pic set-bg"
                            data-setbg="{{ $related->image ? asset($related->image) : asset('img/product/product-1.jpg') }}">
                            <ul class="product__hover">
                                <li>
                                    <a href="{{ route('shop.product', $related->id) }}">
                                        <img src="{{ asset('img/icon/search.png') }}" alt="">
                                    </a>
                                </li>
                            </ul>
                        </div>
                        <div class="product__item__text">
                            <h6>{{ $related->name }}</h6>
                            <a href="{{ route('shop.product', $related->id) }}" class="add-cart">+ View Details</a>
                            <h5>₱{{ number_format($related->price, 2) }}</h5>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
        @endif

    </div>
</section>

<!-- ===== CHAT POPUP ===== -->
<div id="chatOverlay" style="display:none; position:fixed; top:0; left:0; width:100%; height:100%; background:rgba(0,0,0,0.5); z-index:99999; justify-content:center; align-items:center;">
    <div style="background:#fff; width:100%; max-width:520px; height:600px; display:flex; flex-direction:column; box-shadow:0 20px 60px rgba(0,0,0,0.3); border-radius:0;">

        <!-- Chat Header -->
        <div style="background:#111; padding:18px 20px; display:flex; align-items:center; gap:15px; flex-shrink:0;">
            <div style="width:42px; height:42px; background:#c8a96e; border-radius:50%; display:flex; align-items:center; justify-content:center; flex-shrink:0;">
                <i class="fa fa-store" style="color:#111; font-size:16px;"></i>
            </div>
            <div style="flex:1;">
                <div style="color:#fff; font-size:14px; font-weight:700;">{{ $product->seller->shop_name ?? $product->seller->name }}</div>
                <div style="color:#c8a96e; font-size:11px; letter-spacing:1px; text-transform:uppercase;">{{ $product->name }}</div>
            </div>
            <button onclick="closeChat()"
                style="background:none; border:none; color:#fff; font-size:22px; cursor:pointer; line-height:1; padding:0; width:30px; height:30px; display:flex; align-items:center; justify-content:center; flex-shrink:0;"
                onmouseover="this.style.color='#c8a96e';" onmouseout="this.style.color='#fff';">
                &times;
            </button>
        </div>

        <!-- Product Info Bar -->
        <div style="background:#f9f4ec; padding:10px 20px; display:flex; align-items:center; gap:12px; border-bottom:1px solid #ebebeb; flex-shrink:0;">
            @if($product->image)
                <img src="{{ asset($product->image) }}" style="width:36px; height:36px; object-fit:cover; border:1px solid #e8e8e8;" alt="">
            @endif
            <div style="flex:1; min-width:0;">
                <div style="font-size:12px; font-weight:700; color:#111; white-space:nowrap; overflow:hidden; text-overflow:ellipsis;">{{ $product->name }}</div>
                <div style="font-size:13px; color:#c8a96e; font-weight:700;">₱{{ number_format($product->price, 2) }}</div>
            </div>
        </div>

        <!-- Messages Area -->
        <div id="chat-messages" style="flex:1; overflow-y:auto; padding:20px; background:#f5f5f5;">
            <div style="text-align:center; padding:30px; color:#ccc;">
                <i class="fa fa-spinner fa-spin" style="font-size:20px;"></i>
                <p style="font-size:12px; margin-top:8px;">Loading conversation...</p>
            </div>
        </div>

        <!-- Message Input -->
        <div style="padding:15px 20px; background:#fff; border-top:1px solid #ebebeb; flex-shrink:0;">
            <form id="chatForm" style="display:flex; gap:10px; align-items:flex-end;">
                @csrf
                <input type="hidden" name="product_id" value="{{ $product->id }}">
                <textarea name="message" id="chat_input" rows="2"
                    placeholder="Type your message..."
                    style="flex:1; border:1px solid #e8e8e8; padding:10px 14px; font-size:13px; outline:none; resize:none; font-family:inherit; border-radius:0; transition:border 0.3s;"
                    onfocus="this.style.borderColor='#111';"
                    onblur="this.style.borderColor='#e8e8e8';"
                    required></textarea>
                <button type="submit" id="chatSendBtn"
                    style="background:#111; color:#fff; border:none; padding:10px 18px; font-size:13px; cursor:pointer; transition:background 0.3s; flex-shrink:0; height:60px; width:60px; display:flex; align-items:center; justify-content:center;"
                    onmouseover="this.style.background='#c8a96e';" onmouseout="this.style.background='#111';">
                    <i class="fa fa-paper-plane" style="font-size:16px;"></i>
                </button>
            </form>
        </div>
    </div>
</div>

@push('scripts')
<script>
    let autoRefreshInterval = null;
    let chatOpen = false;

    // ── OPEN / CLOSE CHAT ───────────────────────────────
    function openChat() {
        chatOpen = true;
        $('#chatOverlay').css('display', 'flex');
        loadChatMessages();
        // Auto-refresh every 5 seconds
        autoRefreshInterval = setInterval(function() {
            if (chatOpen) loadChatMessages(false);
        }, 5000);
    }

    function closeChat() {
        chatOpen = false;
        $('#chatOverlay').css('display', 'none');
        clearInterval(autoRefreshInterval);
    }

    // Close when clicking outside
    $('#chatOverlay').click(function(e) {
        if ($(e.target).is(this)) closeChat();
    });

    // ── LOAD MESSAGES ───────────────────────────────────
    function loadChatMessages(showLoading = true) {
        if (showLoading) {
            $('#chat-messages').html(`
                <div style="text-align:center; padding:30px; color:#ccc;">
                    <i class="fa fa-spinner fa-spin" style="font-size:20px;"></i>
                    <p style="font-size:12px; margin-top:8px;">Loading...</p>
                </div>
            `);
        }

        $.get('{{ route("inquiry.conversation", $product->id) }}', function(data) {
            renderMessages(data);
        });
    }

    // ── RENDER MESSAGES ─────────────────────────────────
    function renderMessages(messages) {
        if (messages.length === 0) {
            $('#chat-messages').html(`
                <div style="text-align:center; padding:40px 20px;">
                    <i class="fa fa-comments" style="font-size:40px; color:#ddd; display:block; margin-bottom:15px;"></i>
                    <p style="font-size:13px; color:#999;">No messages yet.</p>
                    <p style="font-size:12px; color:#ccc;">Send a message to start the conversation!</p>
                </div>
            `);
            return;
        }

        let html = '';
        let today = new Date().toDateString();

        messages.forEach(function(msg) {
            let date = new Date(msg.created_at);
            let timeStr = date.toLocaleTimeString([], {hour: '2-digit', minute:'2-digit'});
            let dateStr = date.toDateString() === today ? 'Today' : date.toLocaleDateString();

            if (msg.sender === 'user') {
                html += `
                    <div style="margin-bottom:16px; display:flex; justify-content:flex-end;">
                        <div style="max-width:75%;">
                            <div style="background:#111; color:#fff; padding:10px 14px; font-size:13px; line-height:1.6; border-radius:12px 12px 0 12px;">
                                ${msg.message}
                            </div>
                            <div style="font-size:10px; color:#999; margin-top:4px; text-align:right; letter-spacing:0.5px;">
                                ${dateStr} · ${timeStr}
                            </div>
                        </div>
                    </div>`;
            } else {
                html += `
                    <div style="margin-bottom:16px; display:flex; justify-content:flex-start; gap:8px;">
                        <div style="width:30px; height:30px; background:#c8a96e; border-radius:50%; display:flex; align-items:center; justify-content:center; flex-shrink:0; margin-top:2px;">
                            <i class="fa fa-store" style="color:#111; font-size:11px;"></i>
                        </div>
                        <div style="max-width:75%;">
                            <div style="font-size:10px; color:#c8a96e; font-weight:700; letter-spacing:1px; text-transform:uppercase; margin-bottom:4px;">
                                {{ $product->seller->shop_name ?? $product->seller->name }}
                            </div>
                            <div style="background:#fff; border:1px solid #e8e8e8; color:#333; padding:10px 14px; font-size:13px; line-height:1.6; border-radius:12px 12px 12px 0; box-shadow:0 1px 3px rgba(0,0,0,0.05);">
                                ${msg.message}
                            </div>
                            <div style="font-size:10px; color:#999; margin-top:4px; letter-spacing:0.5px;">
                                ${dateStr} · ${timeStr}
                            </div>
                        </div>
                    </div>`;
            }
        });

        let scrollPos = $('#chat-messages').scrollTop();
        let scrollHeight = $('#chat-messages')[0].scrollHeight;
        let isAtBottom = scrollPos + $('#chat-messages').height() >= scrollHeight - 50;

        $('#chat-messages').html(html);

        // Auto scroll to bottom if user is near bottom
        if (isAtBottom || scrollPos === 0) {
            $('#chat-messages').scrollTop($('#chat-messages')[0].scrollHeight);
        }
    }

    // ── SEND MESSAGE ────────────────────────────────────
    $('#chatForm').submit(function(e) {
        e.preventDefault();
        let message = $('#chat_input').val().trim();
        let btn = $('#chatSendBtn');

        if (!message) return;

        btn.html('<i class="fa fa-spinner fa-spin"></i>').prop('disabled', true);

        let formData = new FormData(this);
        $.ajax({
            type: 'POST',
            url: '{{ route("inquiry.send") }}',
            data: formData,
            contentType: false,
            processData: false,
            success: function(response) {
                btn.html('<i class="fa fa-paper-plane" style="font-size:16px;"></i>').prop('disabled', false);
                $('#chat_input').val('');
                // Reload messages immediately after sending
                loadChatMessages(false);
            },
            error: function(response) {
                btn.html('<i class="fa fa-paper-plane" style="font-size:16px;"></i>').prop('disabled', false);
                alert('Failed to send message. Please try again.');
            }
        });
    });

    // Send on Enter (Shift+Enter for new line)
    $('#chat_input').keydown(function(e) {
        if (e.key === 'Enter' && !e.shiftKey) {
            e.preventDefault();
            $('#chatForm').submit();
        }
    });
</script>
@endpush

@endsection