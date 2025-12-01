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

        .products-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
            gap: 25px;
            margin-bottom: 40px;
        }

        .product-card {
            background: white;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 2px 8px rgba(0,0,0,0.08);
            transition: transform 0.2s, box-shadow 0.2s;
            text-decoration: none;
            color: inherit;
            display: block;
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
            font-size: 16px;
            font-weight: 600;
            color: #333;
            margin-bottom: 8px;
        }

        .product-price {
            font-size: 20px;
            font-weight: 700;
            color: #1aa8ba;
            margin-bottom: 12px;
        }

        .product-meta {
            display: flex;
            flex-direction: column;
            gap: 6px;
            font-size: 14px;
            color: #666;
        }

        .product-buyer,
        .product-date {
            display: flex;
            align-items: center;
            gap: 6px;
        }

        .status-badge {
            display: inline-block;
            padding: 4px 12px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 600;
            margin-top: 8px;
        }

        .status-sold {
            background: #e8f5e9;
            color: #2e7d32;
        }

        .status-active {
            background: #e3f2fd;
            color: #1565c0;
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
            margin-bottom: 30px;
        }

        .btn-primary {
            display: inline-block;
            background: #1aa8ba;
            color: white;
            padding: 12px 30px;
            border-radius: 8px;
            text-decoration: none;
            font-weight: 600;
            transition: background 0.2s;
        }

        .btn-primary:hover {
            background: #158a99;
        }

        .pagination {
            display: flex;
            justify-content: center;
            gap: 10px;
            margin-top: 40px;
        }

        .pagination a,
        .pagination span {
            padding: 8px 16px;
            border: 1px solid #e0e0e0;
            border-radius: 6px;
            text-decoration: none;
            color: #333;
            transition: all 0.2s;
        }

        .pagination a:hover {
            background: #f5f5f5;
        }

        .pagination .active {
            background: #1aa8ba;
            color: white;
            border-color: #1aa8ba;
        }
    </style>

    <div class="container">
        <div class="page-header">
            <h1 class="page-title">Meine Verkäufe</h1>
            <p class="page-subtitle">Hier findest du alle Produkte, die du zum Verkauf angeboten hast</p>
        </div>

        @if($sales->count() > 0)
            <div class="products-grid">
                @foreach($sales as $product)
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
                            <div class="product-title">{{ $product->title }}</div>
                            <div class="product-price">{{ number_format($product->price, 2, '.', '\'') }} CHF</div>
                            <div class="product-meta">
                                @if($product->buyer_id)
                                    <div class="product-buyer">
                                        <span>👤</span>
                                        <span>Käufer: {{ $product->buyer->name }}</span>
                                    </div>
                                    @if($product->sold_at)
                                        <div class="product-date">
                                            <span>📅</span>
                                            <span>Verkauft am: {{ $product->sold_at->format('d.m.Y') }}</span>
                                        </div>
                                    @endif
                                @else
                                    <div class="product-date">
                                        <span>📅</span>
                                        <span>Erstellt am: {{ $product->created_at->format('d.m.Y') }}</span>
                                    </div>
                                @endif
                            </div>
                            @if($product->buyer_id)
                                <span class="status-badge status-sold">Verkauft</span>
                            @else
                                <span class="status-badge status-active">Aktiv</span>
                            @endif
                        </div>
                    </a>
                @endforeach
            </div>

            <div class="pagination">
                {{ $sales->links() }}
            </div>
        @else
            <div class="empty-state">
                <div class="empty-icon">📦</div>
                <h2 class="empty-title">Noch keine Verkäufe</h2>
                <p class="empty-text">Du hast noch keine Produkte zum Verkauf angeboten. Erstelle jetzt dein erstes Inserat!</p>
                <a href="{{ route('products.create') }}" class="btn-primary">Produkt inserieren</a>
            </div>
        @endif
    </div>
</x-app-layout>
