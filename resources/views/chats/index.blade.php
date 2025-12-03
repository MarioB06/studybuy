<x-app-layout>
    <style>
        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 40px;
        }

        .page-header {
            margin-bottom: 40px;
        }

        .page-title {
            font-size: 32px;
            font-weight: 600;
            color: #333;
            margin-bottom: 10px;
        }

        .page-subtitle {
            font-size: 16px;
            color: #666;
        }

        .chats-list {
            background: white;
            border-radius: 12px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.08);
            overflow: hidden;
        }

        .chat-item {
            display: flex;
            align-items: center;
            padding: 20px;
            border-bottom: 1px solid #e0e0e0;
            text-decoration: none;
            color: inherit;
            transition: background 0.2s;
        }

        .chat-item:hover {
            background: #f8f9fa;
        }

        .chat-item:last-child {
            border-bottom: none;
        }

        .chat-product-image {
            width: 80px;
            height: 80px;
            object-fit: cover;
            border-radius: 8px;
            background: #f0f0f0;
            margin-right: 20px;
        }

        .chat-info {
            flex: 1;
        }

        .chat-header {
            display: flex;
            justify-content: space-between;
            align-items: start;
            margin-bottom: 8px;
        }

        .chat-user-name {
            font-size: 18px;
            font-weight: 600;
            color: #333;
        }

        .chat-time {
            font-size: 13px;
            color: #999;
        }

        .chat-product-title {
            font-size: 14px;
            color: #666;
            margin-bottom: 8px;
        }

        .chat-last-message {
            font-size: 14px;
            color: #999;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .unread-badge {
            background: #1aa8ba;
            color: white;
            padding: 4px 10px;
            border-radius: 12px;
            font-size: 12px;
            font-weight: 600;
        }

        .empty-state {
            text-align: center;
            padding: 80px 20px;
            color: #666;
        }

        .empty-icon {
            font-size: 64px;
            margin-bottom: 20px;
        }

        .empty-title {
            font-size: 24px;
            font-weight: 600;
            color: #333;
            margin-bottom: 10px;
        }

        .empty-text {
            font-size: 16px;
        }
    </style>

    <div class="container">
        <div class="page-header">
            <h1 class="page-title">Meine Chats</h1>
            <p class="page-subtitle">Kommunikation mit Käufern und Verkäufern</p>
        </div>

        @if($chats->count() > 0)
            <div class="chats-list">
                @foreach($chats as $chat)
                    @php
                        $otherUser = $chat->getOtherUser(auth()->id());
                        $unreadCount = $chat->getUnreadCount(auth()->id());
                    @endphp
                    <a href="{{ route('chats.show', $chat) }}" class="chat-item">
                        @if($chat->product->mainImage)
                            <img src="{{ asset('storage/' . $chat->product->mainImage->file_path) }}"
                                 alt="{{ $chat->product->title }}"
                                 class="chat-product-image">
                        @else
                            @php
                                $iconMap = [
                                    'fas fa-book' => '📚',
                                    'fas fa-laptop' => '💻',
                                    'fas fa-calculator' => '🖩',
                                    'fas fa-backpack' => '🎒',
                                    'fas fa-couch' => '🛋️',
                                    'fas fa-shirt' => '👕',
                                    'fas fa-dumbbell' => '🏋️',
                                    'fas fa-box' => '📦',
                                ];
                                $emoji = $iconMap[$chat->product->category->icon ?? ''] ?? '📦';
                            @endphp
                            <div class="chat-product-image" style="display: flex; align-items: center; justify-content: center; font-size: 40px; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
                                {{ $emoji }}
                            </div>
                        @endif

                        <div class="chat-info">
                            <div class="chat-header">
                                <div class="chat-user-name">{{ $otherUser->name }}</div>
                                @if($chat->last_message_at)
                                    <div class="chat-time">{{ $chat->last_message_at->diffForHumans() }}</div>
                                @endif
                            </div>
                            <div class="chat-product-title">📦 {{ $chat->product->title }}</div>
                            @if($chat->latestMessage)
                                <div class="chat-last-message">
                                    <span>{{ Str::limit($chat->latestMessage->message, 50) }}</span>
                                    @if($unreadCount > 0)
                                        <span class="unread-badge">{{ $unreadCount }}</span>
                                    @endif
                                </div>
                            @endif
                        </div>
                    </a>
                @endforeach
            </div>
        @else
            <div class="empty-state">
                <div class="empty-icon">💬</div>
                <h2 class="empty-title">Noch keine Chats</h2>
                <p class="empty-text">Chats werden automatisch erstellt, wenn du ein Produkt kaufst.</p>
            </div>
        @endif
    </div>
</x-app-layout>
