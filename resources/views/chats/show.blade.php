<x-app-layout>
    <style>
        .chat-container {
            max-width: 1000px;
            margin: 0 auto;
            padding: 20px;
            height: calc(100vh - 120px);
            display: flex;
            flex-direction: column;
        }

        .chat-header {
            background: white;
            border-radius: 12px 12px 0 0;
            padding: 20px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.08);
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .chat-product-image {
            width: 60px;
            height: 60px;
            object-fit: cover;
            border-radius: 8px;
            background: #f0f0f0;
        }

        .chat-header-info {
            flex: 1;
        }

        .chat-header-title {
            font-size: 20px;
            font-weight: 600;
            color: #333;
            margin-bottom: 4px;
        }

        .chat-header-subtitle {
            font-size: 14px;
            color: #666;
        }

        .back-button {
            padding: 8px 20px;
            background: #f0f0f0;
            border-radius: 8px;
            text-decoration: none;
            color: #333;
            font-weight: 500;
            transition: background 0.2s;
        }

        .back-button:hover {
            background: #e0e0e0;
        }

        .messages-container {
            flex: 1;
            background: white;
            overflow-y: auto;
            padding: 20px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.08);
        }

        .message {
            display: flex;
            margin-bottom: 20px;
            gap: 12px;
        }

        .message.own {
            flex-direction: row-reverse;
        }

        .message-avatar {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: 600;
            flex-shrink: 0;
        }

        .message-content {
            max-width: 60%;
        }

        .message-bubble {
            background: #f0f0f0;
            padding: 12px 16px;
            border-radius: 16px;
            word-wrap: break-word;
        }

        .message.own .message-bubble {
            background: #1aa8ba;
            color: white;
        }

        .message-info {
            display: flex;
            align-items: center;
            gap: 8px;
            margin-top: 4px;
            font-size: 12px;
            color: #999;
        }

        .message.own .message-info {
            flex-direction: row-reverse;
        }

        .message-form {
            background: white;
            border-radius: 0 0 12px 12px;
            padding: 20px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.08);
            display: flex;
            gap: 12px;
        }

        .message-input {
            flex: 1;
            padding: 12px 16px;
            border: 1px solid #e0e0e0;
            border-radius: 24px;
            font-size: 15px;
            outline: none;
            resize: none;
            font-family: inherit;
        }

        .message-input:focus {
            border-color: #1aa8ba;
        }

        .send-button {
            padding: 12px 30px;
            background: #1aa8ba;
            color: white;
            border: none;
            border-radius: 24px;
            font-size: 15px;
            font-weight: 600;
            cursor: pointer;
            transition: background 0.2s;
        }

        .send-button:hover {
            background: #158a99;
        }

        .empty-messages {
            text-align: center;
            padding: 60px 20px;
            color: #999;
        }

        .empty-messages-icon {
            font-size: 48px;
            margin-bottom: 16px;
        }

        .chat-closed-message {
            background: #f5f5f5;
            padding: 20px;
            border-radius: 12px;
            text-align: center;
            color: #666;
            font-weight: 500;
        }

        .chat-closed-icon {
            font-size: 32px;
            margin-bottom: 10px;
        }
    </style>

    <div class="chat-container">
        @php
            $otherUser = $chat->getOtherUser(auth()->id());
        @endphp

        <div class="chat-header">
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
                <div class="chat-product-image" style="display: flex; align-items: center; justify-content: center; font-size: 32px; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
                    {{ $emoji }}
                </div>
            @endif

            <div class="chat-header-info">
                <div class="chat-header-title">{{ $otherUser->name }}</div>
                <div class="chat-header-subtitle">{{ $chat->product->title }}</div>
            </div>

            <a href="{{ route('my-products.index') }}" class="back-button">← Zurück</a>
        </div>

        <div class="messages-container" id="messagesContainer">
            @if($chat->messages->count() > 0)
                @foreach($chat->messages as $message)
                    <div class="message {{ $message->user_id === auth()->id() ? 'own' : '' }}">
                        <div class="message-avatar">
                            {{ substr($message->user->name, 0, 1) }}
                        </div>
                        <div class="message-content">
                            <div class="message-bubble">
                                {{ $message->message }}
                            </div>
                            <div class="message-info">
                                <span>{{ $message->user->name }}</span>
                                <span>•</span>
                                <span>{{ $message->created_at->diffForHumans() }}</span>
                            </div>
                        </div>
                    </div>
                @endforeach
            @else
                <div class="empty-messages">
                    <div class="empty-messages-icon">💬</div>
                    <p>Noch keine Nachrichten. Starte die Unterhaltung!</p>
                </div>
            @endif
        </div>

        @if($chat->product->abgeschlossen)
            <div class="chat-closed-message">
                <div class="chat-closed-icon">✓</div>
                <div>Dieser Chat wurde beendet. Die Transaktion ist abgeschlossen.</div>
            </div>
        @else
            <form action="{{ route('chats.messages.store', $chat) }}" method="POST" class="message-form">
                @csrf
                <textarea
                    name="message"
                    class="message-input"
                    placeholder="Nachricht schreiben..."
                    rows="1"
                    required
                ></textarea>
                <button type="submit" class="send-button">Senden</button>
            </form>
        @endif
    </div>

    <script>
        // Auto-scroll to bottom on load
        const messagesContainer = document.getElementById('messagesContainer');
        messagesContainer.scrollTop = messagesContainer.scrollHeight;

        // Auto-resize textarea
        const textarea = document.querySelector('.message-input');
        textarea.addEventListener('input', function() {
            this.style.height = 'auto';
            this.style.height = this.scrollHeight + 'px';
        });
    </script>
</x-app-layout>
