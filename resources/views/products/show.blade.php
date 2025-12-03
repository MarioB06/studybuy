<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $product->title }} - StudyBuy</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, 'Helvetica Neue', Arial, sans-serif;
            background: #f8f9fa;
        }

        .header {
            background: white;
            border-bottom: 1px solid #e0e0e0;
            padding: 10px 40px;
        }

        .header-container {
            max-width: 1200px;
            margin: 0 auto;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .logo {
            display: flex;
            align-items: center;
            gap: 10px;
            font-size: 24px;
            font-weight: 600;
            text-decoration: none;
            color: #000;
        }

        .logo-icon {
            width: auto;
            height: 50px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .nav-links {
            display: flex;
            gap: 30px;
            align-items: center;
        }

        .nav-links a {
            text-decoration: none;
            color: #333;
            font-size: 15px;
        }

        .nav-links a:hover {
            color: #000;
        }

        .nav-links form {
            margin: 0;
        }

        .logout-button {
            background: none;
            border: none;
            color: #333;
            font-size: 15px;
            cursor: pointer;
            padding: 0;
            font-family: inherit;
        }

        .logout-button:hover {
            color: #000;
        }

        .breadcrumb {
            max-width: 1200px;
            margin: 20px auto 0;
            padding: 0 40px;
            font-size: 14px;
            color: #666;
        }

        .breadcrumb a {
            color: #1aa8ba;
            text-decoration: none;
        }

        .breadcrumb a:hover {
            text-decoration: underline;
        }

        .main-content {
            max-width: 1200px;
            margin: 30px auto;
            padding: 0 40px 40px;
        }

        .product-container {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 40px;
            background: white;
            border-radius: 16px;
            padding: 40px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.08);
        }

        .image-gallery {
            display: flex;
            flex-direction: column;
            gap: 15px;
        }

        .main-image-container {
            width: 100%;
            height: 400px;
            border-radius: 12px;
            overflow: hidden;
            background: #f0f0f0;
        }

        .main-image {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .placeholder-image {
            width: 100%;
            height: 100%;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 120px;
        }

        .thumbnail-container {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(80px, 1fr));
            gap: 10px;
        }

        .thumbnail {
            width: 100%;
            height: 80px;
            border-radius: 8px;
            overflow: hidden;
            cursor: pointer;
            border: 2px solid transparent;
            transition: border-color 0.2s;
        }

        .thumbnail:hover {
            border-color: #1aa8ba;
        }

        .thumbnail.active {
            border-color: #1aa8ba;
        }

        .thumbnail img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .product-info {
            display: flex;
            flex-direction: column;
            gap: 25px;
        }

        .product-title {
            font-size: 32px;
            font-weight: 600;
            color: #000;
            line-height: 1.3;
        }

        .product-price {
            font-size: 36px;
            font-weight: 700;
            color: #1aa8ba;
        }

        .product-meta {
            display: flex;
            flex-direction: column;
            gap: 12px;
            padding: 20px;
            background: #f8f9fa;
            border-radius: 12px;
        }

        .meta-item {
            display: flex;
            align-items: center;
            gap: 10px;
            font-size: 15px;
            color: #333;
        }

        .meta-label {
            font-weight: 600;
            min-width: 100px;
        }

        .meta-value {
            color: #666;
        }

        .category-badge {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 8px 16px;
            background: white;
            border-radius: 20px;
            font-size: 14px;
            font-weight: 500;
        }

        .product-description {
            padding: 25px 0;
            border-top: 1px solid #e0e0e0;
        }

        .description-title {
            font-size: 20px;
            font-weight: 600;
            margin-bottom: 15px;
            color: #000;
        }

        .description-text {
            font-size: 15px;
            line-height: 1.6;
            color: #333;
            white-space: pre-wrap;
        }

        .contact-section {
            padding: 25px;
            background: linear-gradient(135deg, #1aa8ba 0%, #158a99 100%);
            border-radius: 12px;
            color: white;
        }

        .contact-title {
            font-size: 20px;
            font-weight: 600;
            margin-bottom: 15px;
        }

        .contact-info {
            display: flex;
            flex-direction: column;
            gap: 10px;
            font-size: 15px;
        }

        .contact-button {
            background: white;
            color: #1aa8ba;
            border: none;
            padding: 14px 30px;
            border-radius: 8px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            text-decoration: none;
            display: inline-block;
            text-align: center;
            margin-top: 10px;
            transition: transform 0.2s;
        }

        .contact-button:hover {
            transform: translateY(-2px);
        }

        /* Forum Styles */
        .forum-section {
            max-width: 1200px;
            margin: 40px auto 0;
            background: white;
            border-radius: 16px;
            padding: 40px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.08);
        }

        .forum-title {
            font-size: 28px;
            font-weight: 600;
            margin-bottom: 30px;
            color: #000;
        }

        .forum-form {
            margin-bottom: 40px;
            padding: 25px;
            background: #f8f9fa;
            border-radius: 12px;
        }

        .forum-textarea {
            width: 100%;
            min-height: 100px;
            padding: 15px;
            border: 1px solid #e0e0e0;
            border-radius: 8px;
            font-size: 15px;
            font-family: inherit;
            resize: vertical;
            margin-bottom: 15px;
        }

        .forum-textarea:focus {
            outline: none;
            border-color: #1aa8ba;
        }

        .forum-submit {
            background: #1aa8ba;
            color: white;
            border: none;
            padding: 12px 30px;
            border-radius: 8px;
            font-size: 15px;
            font-weight: 600;
            cursor: pointer;
            transition: background 0.2s;
        }

        .forum-submit:hover {
            background: #158a99;
        }

        .forum-login {
            text-align: center;
            padding: 30px;
            background: #f8f9fa;
            border-radius: 12px;
            color: #666;
        }

        .forum-login a {
            color: #1aa8ba;
            text-decoration: none;
            font-weight: 600;
        }

        .forum-message {
            padding: 25px;
            border-bottom: 1px solid #e0e0e0;
        }

        .forum-message:last-child {
            border-bottom: none;
        }

        .message-header {
            display: flex;
            align-items: center;
            gap: 15px;
            margin-bottom: 15px;
        }

        .message-author {
            font-weight: 600;
            color: #333;
        }

        .message-badge {
            padding: 4px 12px;
            background: #1aa8ba;
            color: white;
            border-radius: 12px;
            font-size: 12px;
            font-weight: 600;
        }

        .message-time {
            color: #999;
            font-size: 14px;
            margin-left: auto;
        }

        .message-content {
            color: #333;
            line-height: 1.6;
            margin-bottom: 15px;
            white-space: pre-wrap;
        }

        .message-actions {
            display: flex;
            gap: 15px;
        }

        .reply-button {
            color: #1aa8ba;
            background: none;
            border: none;
            cursor: pointer;
            font-size: 14px;
            font-weight: 500;
            padding: 0;
        }

        .reply-button:hover {
            text-decoration: underline;
        }

        .reply-form {
            margin-top: 20px;
            padding: 20px;
            background: #f8f9fa;
            border-radius: 8px;
            display: none;
        }

        .reply-form.active {
            display: block;
        }

        .replies {
            margin-top: 20px;
            margin-left: 40px;
            padding-left: 20px;
            border-left: 3px solid #e0e0e0;
        }

        .reply {
            padding: 20px 0;
            border-bottom: 1px solid #f0f0f0;
        }

        .reply:last-child {
            border-bottom: none;
        }

        @media (max-width: 768px) {
            .product-container {
                grid-template-columns: 1fr;
            }

            .main-image-container {
                height: 300px;
            }

            .product-title {
                font-size: 24px;
            }

            .product-price {
                font-size: 28px;
            }

            .header-container {
                flex-direction: column;
                gap: 15px;
            }

            .forum-section {
                padding: 20px;
            }

            .replies {
                margin-left: 20px;
            }
        }
    </style>
</head>
<body>
    <header class="header">
        <div class="header-container">
            <a href="{{ auth()->check() ? route('dashboard') : '/' }}" class="logo">
                <x-application-logo class="logo-icon" />
            </a>
            <nav class="nav-links">
                @auth
                    <a href="{{ route('products.index') }}">Alle Produkte</a>
                    <a href="{{ route('my-products.index') }}">Käufe & Verkäufe</a>
                    @if(auth()->user()->isAdmin())
                        <a href="{{ route('admin.dashboard') }}">Admin</a>
                    @endif
                    <a href="{{ route('profile.edit') }}">Profil</a>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="logout-button">Abmelden</button>
                    </form>
                @else
                    <a href="{{ route('products.index') }}">Alle Produkte</a>
                    <a href="{{ route('login') }}">Anmelden</a>
                    <a href="{{ route('register') }}">Registrieren</a>
                @endauth
            </nav>
        </div>
    </header>

    <div class="breadcrumb">
        <a href="{{ auth()->check() ? route('dashboard') : '/' }}">Home</a> /
        <a href="{{ route('products.index') }}">Alle Produkte</a> /
        {{ $product->title }}
    </div>

    <main class="main-content">
        <div class="product-container">
            <!-- Image Gallery -->
            <div class="image-gallery">
                <div class="main-image-container" id="mainImageContainer">
                    @if($product->mainImage)
                        <img src="{{ asset('storage/' . $product->mainImage->file_path) }}"
                             alt="{{ $product->title }}"
                             class="main-image"
                             id="mainImage">
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
                            $emoji = $iconMap[$product->category->icon ?? ''] ?? '📦';
                        @endphp
                        <div class="placeholder-image">{{ $emoji }}</div>
                    @endif
                </div>

                @if($product->images && $product->images->count() > 1)
                <div class="thumbnail-container">
                    @foreach($product->images as $index => $image)
                    <div class="thumbnail {{ $index === 0 ? 'active' : '' }}"
                         onclick="changeImage('{{ asset('storage/' . $image->file_path) }}', this)">
                        <img src="{{ asset('storage/' . $image->file_path) }}" alt="Bild {{ $index + 1 }}">
                    </div>
                    @endforeach
                </div>
                @endif
            </div>

            <!-- Product Info -->
            <div class="product-info">
                <h1 class="product-title">{{ $product->title }}</h1>

                <div class="product-price">{{ number_format($product->price, 2, '.', '\'') }} CHF</div>

                <div class="product-meta">
                    <div class="meta-item">
                        <span class="meta-label">Kategorie:</span>
                        <span class="category-badge">
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
                                $emoji = $iconMap[$product->category->icon ?? ''] ?? '📦';
                            @endphp
                            {{ $emoji }} {{ $product->category->name }}
                        </span>
                    </div>

                    @if($product->school)
                    <div class="meta-item">
                        <span class="meta-label">Schule:</span>
                        <span class="meta-value">{{ $product->school->name }}</span>
                    </div>
                    @endif

                    @if($product->expires_at)
                    <div class="meta-item">
                        <span class="meta-label">Gültig bis:</span>
                        <span class="meta-value">{{ \Carbon\Carbon::parse($product->expires_at)->format('d.m.Y') }}</span>
                    </div>
                    @endif

                    <div class="meta-item">
                        <span class="meta-label">Inseriert:</span>
                        <span class="meta-value">{{ $product->created_at->diffForHumans() }}</span>
                    </div>
                </div>

                @if($product->description)
                <div class="product-description">
                    <h2 class="description-title">Beschreibung</h2>
                    <p class="description-text">{{ $product->description }}</p>
                </div>
                @endif

                <div class="contact-section">
                    <h3 class="contact-title">Interessiert?</h3>
                    <div class="contact-info">
                        <p>Verkäufer: {{ $product->user->name }}</p>
                        @auth
                            @if(auth()->id() !== $product->user_id)
                                @if($product->is_active)
                                    <p>Kaufe dieses Produkt sicher über Stripe.</p>
                                    <form method="POST" action="{{ route('products.checkout.create', $product) }}">
                                        @csrf
                                        <button type="submit" class="contact-button" style="border: none; width: 100%; cursor: pointer;">
                                            💳 Sofort kaufen ({{ number_format($product->price, 2, '.', '\'') }} CHF)
                                        </button>
                                    </form>
                                @else
                                    <p style="color: #999;">Dieses Produkt ist bereits verkauft.</p>
                                @endif
                            @else
                                <p>Das ist dein eigenes Inserat.</p>
                            @endif
                        @else
                            <p>Melde dich an, um dieses Produkt zu kaufen.</p>
                            <a href="{{ route('login') }}" class="contact-button">
                                Jetzt anmelden
                            </a>
                        @endauth
                    </div>
                </div>
            </div>
        </div>

        <!-- Forum Section -->
        <div class="forum-section">
            <h2 class="forum-title">Fragen & Diskussion ({{ $product->forumMessages->count() }})</h2>

            @auth
                <form method="POST" action="{{ route('products.forum.store', $product) }}" class="forum-form">
                    @csrf
                    <textarea
                        name="message"
                        class="forum-textarea"
                        placeholder="Stelle eine Frage oder hinterlasse einen Kommentar..."
                        required
                        maxlength="2000"></textarea>
                    <button type="submit" class="forum-submit">Nachricht senden</button>
                </form>
            @else
                <div class="forum-login">
                    <p>Du musst <a href="{{ route('login') }}">angemeldet</a> sein, um eine Nachricht zu schreiben.</p>
                </div>
            @endauth

            @if($product->forumMessages->count() > 0)
                @foreach($product->forumMessages as $message)
                <div class="forum-message">
                    <div class="message-header">
                        <span class="message-author">{{ $message->user->name }}</span>
                        @if($message->is_official)
                            <span class="message-badge">Verkäufer</span>
                        @endif
                        <span class="message-time">{{ $message->created_at->diffForHumans() }}</span>
                    </div>
                    <div class="message-content">{{ $message->message }}</div>
                    <div class="message-actions">
                        @auth
                            <button class="reply-button" onclick="toggleReply({{ $message->id }})">
                                Antworten
                            </button>
                        @endauth
                    </div>

                    @auth
                    <div class="reply-form" id="reply-form-{{ $message->id }}">
                        <form method="POST" action="{{ route('products.forum.store', $product) }}">
                            @csrf
                            <input type="hidden" name="parent_id" value="{{ $message->id }}">
                            <textarea
                                name="message"
                                class="forum-textarea"
                                placeholder="Deine Antwort..."
                                required
                                maxlength="2000"
                                style="min-height: 80px;"></textarea>
                            <button type="submit" class="forum-submit">Antwort senden</button>
                        </form>
                    </div>
                    @endauth

                    @if($message->replies->count() > 0)
                    <div class="replies">
                        @foreach($message->replies as $reply)
                        <div class="reply">
                            <div class="message-header">
                                <span class="message-author">{{ $reply->user->name }}</span>
                                @if($reply->is_official)
                                    <span class="message-badge">Verkäufer</span>
                                @endif
                                <span class="message-time">{{ $reply->created_at->diffForHumans() }}</span>
                            </div>
                            <div class="message-content">{{ $reply->message }}</div>
                        </div>
                        @endforeach
                    </div>
                    @endif
                </div>
                @endforeach
            @else
                <div style="text-align: center; padding: 40px; color: #666;">
                    <p>Noch keine Nachrichten. Sei der Erste und stelle eine Frage!</p>
                </div>
            @endif
        </div>
    </main>

    <script>
        function changeImage(imageSrc, thumbnail) {
            // Update main image
            const mainImage = document.getElementById('mainImage');
            if (mainImage) {
                mainImage.src = imageSrc;
            }

            // Update active thumbnail
            document.querySelectorAll('.thumbnail').forEach(t => t.classList.remove('active'));
            thumbnail.classList.add('active');
        }

        function toggleReply(messageId) {
            const replyForm = document.getElementById('reply-form-' + messageId);
            replyForm.classList.toggle('active');
        }
    </script>
</body>
</html>
