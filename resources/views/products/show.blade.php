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
            padding: 20px 40px;
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
            width: 32px;
            height: 32px;
            background: #000;
            border-radius: 6px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 20px;
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
        }
    </style>
</head>
<body>
    <header class="header">
        <div class="header-container">
            <a href="{{ auth()->check() ? route('dashboard') : '/' }}" class="logo">
                <div class="logo-icon">🎒</div>
                <span>StudyBuy</span>
            </a>
            <nav class="nav-links">
                @auth
                    <a href="{{ route('products.index') }}">Alle Produkte</a>
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
                                <p>Kontaktiere den Verkäufer, um mehr zu erfahren.</p>
                                <a href="mailto:{{ $product->user->email }}" class="contact-button">
                                    Verkäufer kontaktieren
                                </a>
                            @else
                                <p>Das ist dein eigenes Inserat.</p>
                            @endif
                        @else
                            <p>Melde dich an, um den Verkäufer zu kontaktieren.</p>
                            <a href="{{ route('login') }}" class="contact-button">
                                Jetzt anmelden
                            </a>
                        @endauth
                    </div>
                </div>
            </div>
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
    </script>
</body>
</html>
