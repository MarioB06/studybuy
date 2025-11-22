<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>StudyBuy - Kaufe und verkaufe deine Studienobjekte</title>
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

        .search-container {
            max-width: 1200px;
            margin: 30px auto;
            padding: 0 40px;
        }

        .search-box {
            display: flex;
            background: white;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
        }

        .search-input {
            flex: 1;
            padding: 15px 20px;
            border: none;
            font-size: 15px;
            outline: none;
        }

        .search-button {
            background: #1aa8ba;
            color: white;
            border: none;
            padding: 15px 30px;
            cursor: pointer;
            font-size: 18px;
        }

        .search-button:hover {
            background: #1aa8ba;
        }

        .main-content {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 40px 40px;
        }

        .title {
            font-size: 32px;
            font-weight: 600;
            margin-bottom: 40px;
            text-align: center;
        }

        .section-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 25px;
        }

        .section-title {
            font-size: 24px;
            font-weight: 600;
            color: #333;
        }

        .view-all-link {
            font-size: 15px;
            color: #1aa8ba;
            text-decoration: none;
            font-weight: 500;
            transition: color 0.2s;
        }

        .view-all-link:hover {
            color: #158a99;
            text-decoration: underline;
        }

        .categories {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 20px;
            margin-bottom: 50px;
        }

        .category-card {
            display: flex;
            flex-direction: column;
            align-items: center;
            text-align: center;
            cursor: pointer;
            transition: transform 0.2s;
            text-decoration: none;
            color: inherit;
        }

        .category-card:hover {
            transform: translateY(-5px);
        }

        .category-icon {
            width: 100px;
            height: 100px;
            background: #e0e0e0;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 48px;
            margin-bottom: 15px;
            transition: background 0.2s;
        }

        .category-card:hover .category-icon {
            background: #d0d0d0;
        }

        .category-name {
            font-size: 16px;
            font-weight: 500;
            color: #333;
        }

        .products-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 25px;
        }

        .product-card {
            background: white;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 2px 8px rgba(0,0,0,0.08);
            transition: transform 0.2s, box-shadow 0.2s;
            cursor: pointer;
        }

        .product-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 4px 12px rgba(0,0,0,0.15);
        }

        .product-image {
            width: 100%;
            height: 200px;
            object-fit: cover;
            background: #f0f0f0;
        }

        .product-info {
            padding: 20px;
        }

        .product-title {
            font-size: 15px;
            font-weight: 500;
            color: #333;
            margin-bottom: 8px;
        }

        .product-price {
            font-size: 18px;
            font-weight: 600;
            color: #000;
        }

        @media (max-width: 768px) {
            .categories {
                grid-template-columns: repeat(2, 1fr);
            }

            .products-grid {
                grid-template-columns: repeat(2, 1fr);
            }

            .header-container {
                flex-direction: column;
                gap: 15px;
            }
        }

        @media (max-width: 480px) {
            .categories {
                grid-template-columns: 1fr;
            }

            .products-grid {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>
<body>
    <header class="header">
        <div class="header-container">
            <a href="/" class="logo">
                <div class="logo-icon">🎒</div>
                <span>StudyBuy</span>
            </a>
            <nav class="nav-links">
                <a href="{{ route('login') }}">Anmelden</a>
                <a href="{{ route('register') }}">Registrieren</a>
            </nav>
        </div>
    </header>

    <div class="search-container">
        <form method="GET" action="{{ route('products.index') }}" class="search-box">
            <input type="text" name="search" class="search-input" placeholder="Suche nach „Laptop", „Buch, ...">
            <button type="submit" class="search-button">🔍</button>
        </form>
    </div>

    <main class="main-content">
        <h1 class="title">Kaufe und verkaufe deine Studienobjekte</h1>

        @if($categories->count() > 0)
        <div class="section-header">
            <h2 class="section-title">Top Kategorien</h2>
            <a href="{{ route('products.index') }}" class="view-all-link">Alle Kategorien anzeigen →</a>
        </div>
        <div class="categories">
            @foreach($categories as $category)
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
                $emoji = $iconMap[$category->icon] ?? '📦';
            @endphp
            <a href="{{ route('products.index', ['categories' => [$category->id]]) }}" class="category-card">
                <div class="category-icon">{{ $emoji }}</div>
                <div class="category-name">{{ $category->name }}</div>
            </a>
            @endforeach
        </div>
        @endif

        @if($products->count() > 0)
        <div class="products-grid">
            @foreach($products as $product)
            <a href="{{ route('products.show', $product) }}" class="product-card">
                @if($product->mainImage)
                    <img src="{{ asset('storage/' . $product->mainImage->file_path) }}" alt="{{ $product->title }}" class="product-image">
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
                    <div class="product-image" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); display: flex; align-items: center; justify-content: center; font-size: 80px;">
                        {{ $emoji }}
                    </div>
                @endif
                <div class="product-info">
                    <div class="product-title">{{ Str::limit($product->title, 40) }}</div>
                    <div class="product-price">{{ number_format($product->price, 2, '.', '\'') }} CHF</div>
                </div>
            </a>
            @endforeach
        </div>
        @else
        <div style="text-align: center; padding: 60px 20px; color: #666;">
            <div style="font-size: 48px; margin-bottom: 20px;">📦</div>
            <h3 style="font-size: 20px; margin-bottom: 10px;">Noch keine Produkte verfügbar</h3>
            <p>Schau später wieder vorbei oder melde dich an, um selbst ein Produkt zu inserieren.</p>
        </div>
        @endif
    </main>
</body>
</html>
