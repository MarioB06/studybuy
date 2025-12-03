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

        .filter-tabs {
            display: flex;
            gap: 15px;
            margin-bottom: 30px;
            border-bottom: 2px solid #e0e0e0;
        }

        .filter-tab {
            padding: 12px 24px;
            background: none;
            border: none;
            font-size: 16px;
            font-weight: 500;
            color: #666;
            cursor: pointer;
            border-bottom: 3px solid transparent;
            margin-bottom: -2px;
            text-decoration: none;
            transition: all 0.2s;
        }

        .filter-tab:hover {
            color: #1aa8ba;
        }

        .filter-tab.active {
            color: #1aa8ba;
            border-bottom-color: #1aa8ba;
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
            display: flex;
            flex-direction: column;
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
            flex: 1;
            display: flex;
            flex-direction: column;
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
            margin-bottom: 12px;
        }

        .product-type {
            display: inline-block;
            padding: 4px 12px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 600;
            margin-bottom: 8px;
        }

        .type-purchase {
            background: #e3f2fd;
            color: #1565c0;
        }

        .type-sale {
            background: #e8f5e9;
            color: #2e7d32;
        }

        .type-sold {
            background: #fff3e0;
            color: #ef6c00;
        }

        .chat-button {
            display: block;
            width: 100%;
            padding: 10px;
            background: #1aa8ba;
            color: white;
            text-align: center;
            border-radius: 8px;
            text-decoration: none;
            font-weight: 600;
            margin-top: auto;
            transition: background 0.2s;
        }

        .chat-button:hover {
            background: #158a99;
        }

        .no-chat {
            text-align: center;
            padding: 10px;
            color: #999;
            font-size: 13px;
            margin-top: auto;
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

        .status-buttons {
            display: flex;
            flex-direction: column;
            gap: 8px;
            margin-top: 12px;
            margin-bottom: 12px;
            padding-bottom: 12px;
            border-bottom: 1px solid #e0e0e0;
        }

        .status-button {
            padding: 8px 12px;
            border: none;
            border-radius: 6px;
            font-size: 13px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.2s;
            width: 100%;
        }

        .status-button.erhalten {
            background: #e3f2fd;
            color: #1565c0;
        }

        .status-button.erhalten:hover:not(:disabled) {
            background: #bbdefb;
        }

        .status-button.uebergeben {
            background: #e8f5e9;
            color: #2e7d32;
        }

        .status-button.uebergeben:hover:not(:disabled) {
            background: #c8e6c9;
        }

        .status-button:disabled {
            opacity: 0.5;
            cursor: not-allowed;
            background: #f0f0f0;
            color: #999;
        }

        .abgeschlossen-message {
            text-align: center;
            padding: 12px;
            background: #e8f5e9;
            color: #2e7d32;
            border-radius: 8px;
            font-weight: 600;
            margin-top: 12px;
        }

        .chat-disabled-message {
            text-align: center;
            padding: 10px;
            color: #999;
            font-size: 13px;
            margin-top: auto;
            background: #f5f5f5;
            border-radius: 8px;
        }
    </style>

    <div class="container">
        <div class="page-header">
            <h1 class="page-title">Käufe & Verkäufe</h1>
            <p class="page-subtitle">Übersicht über deine gekauften und verkauften Produkte</p>
        </div>

        <div class="filter-tabs">
            <a href="{{ route('my-products.index', ['filter' => 'all']) }}"
               class="filter-tab {{ $filter === 'all' ? 'active' : '' }}">
                Alle
            </a>
            <a href="{{ route('my-products.index', ['filter' => 'purchases']) }}"
               class="filter-tab {{ $filter === 'purchases' ? 'active' : '' }}">
                Käufe
            </a>
            <a href="{{ route('my-products.index', ['filter' => 'sales']) }}"
               class="filter-tab {{ $filter === 'sales' ? 'active' : '' }}">
                Verkäufe
            </a>
        </div>

        @if($products->count() > 0)
            <div class="products-grid">
                @foreach($products as $product)
                    <div class="product-card">
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
                            @if($product->buyer_id === auth()->id())
                                <span class="product-type type-purchase">Gekauft</span>
                            @elseif($product->buyer_id)
                                <span class="product-type type-sold">Verkauft</span>
                            @else
                                <span class="product-type type-sale">Zum Verkauf</span>
                            @endif

                            <div class="product-title">{{ $product->title }}</div>
                            <div class="product-price">{{ number_format($product->price, 2, '.', '\'') }} CHF</div>

                            <div class="product-meta">
                                @if($product->buyer_id === auth()->id())
                                    <span>👤 Verkäufer: {{ $product->user->name }}</span>
                                    @if($product->sold_at)
                                        <span>📅 Gekauft am: {{ $product->sold_at->format('d.m.Y') }}</span>
                                    @endif
                                @else
                                    @if($product->buyer_id)
                                        <span>👤 Käufer: {{ $product->buyer->name }}</span>
                                        @if($product->sold_at)
                                            <span>📅 Verkauft am: {{ $product->sold_at->format('d.m.Y') }}</span>
                                        @endif
                                    @else
                                        <span>📅 Erstellt am: {{ $product->created_at->format('d.m.Y') }}</span>
                                    @endif
                                @endif
                            </div>

                            @if($product->buyer_id)
                                @if(!$product->abgeschlossen)
                                    <div class="status-buttons">
                                        @if($product->buyer_id === auth()->id())
                                            {{-- Käufer kann "Erhalten" markieren --}}
                                            <form method="POST" action="{{ route('my-products.update-status', $product) }}">
                                                @csrf
                                                <input type="hidden" name="status" value="erhalten">
                                                <button type="submit" class="status-button erhalten" {{ $product->erhalten ? 'disabled' : '' }}>
                                                    {{ $product->erhalten ? '✓ Erhalten' : 'Als erhalten markieren' }}
                                                </button>
                                            </form>
                                        @else
                                            {{-- Verkäufer kann "Übergeben" markieren --}}
                                            <form method="POST" action="{{ route('my-products.update-status', $product) }}">
                                                @csrf
                                                <input type="hidden" name="status" value="uebergeben">
                                                <button type="submit" class="status-button uebergeben" {{ $product->uebergeben ? 'disabled' : '' }}>
                                                    {{ $product->uebergeben ? '✓ Übergeben' : 'Als übergeben markieren' }}
                                                </button>
                                            </form>
                                        @endif
                                    </div>
                                @endif
                            @endif

                            @if($product->abgeschlossen)
                                <div class="chat-disabled-message">
                                    Chat beendet - Transaktion abgeschlossen
                                </div>
                            @elseif(isset($chats[$product->id]))
                                <a href="{{ route('chats.show', $chats[$product->id]) }}" class="chat-button">
                                    💬 Zum Chat
                                </a>
                            @else
                                <div class="no-chat">Noch kein Chat vorhanden</div>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="pagination">
                {{ $products->appends(['filter' => $filter])->links() }}
            </div>
        @else
            <div class="empty-state">
                <div class="empty-icon">📦</div>
                <h2 class="empty-title">
                    @if($filter === 'purchases')
                        Noch keine Käufe
                    @elseif($filter === 'sales')
                        Noch keine Verkäufe
                    @else
                        Noch keine Aktivitäten
                    @endif
                </h2>
                <p class="empty-text">
                    @if($filter === 'purchases')
                        Du hast noch keine Produkte gekauft.
                    @elseif($filter === 'sales')
                        Du hast noch keine Produkte zum Verkauf angeboten.
                    @else
                        Du hast noch keine Käufe oder Verkäufe getätigt.
                    @endif
                </p>
                <a href="{{ route('products.index') }}" class="btn-primary">Produkte entdecken</a>
            </div>
        @endif
    </div>
</x-app-layout>
