<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Alle Produkte - StudyBuy</title>
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
            background: #158a99;
        }

        .main-content {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 40px 40px;
        }

        .content-wrapper {
            display: grid;
            grid-template-columns: 280px 1fr;
            gap: 30px;
        }

        .sidebar {
            position: sticky;
            top: 20px;
            height: fit-content;
        }

        .filter-section {
            background: white;
            border-radius: 12px;
            padding: 25px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.08);
            margin-bottom: 20px;
        }

        .filter-title {
            font-size: 18px;
            font-weight: 600;
            margin-bottom: 20px;
            color: #000;
        }

        .filter-group {
            display: flex;
            flex-direction: column;
            gap: 12px;
        }

        .checkbox-label {
            display: flex;
            align-items: center;
            gap: 10px;
            cursor: pointer;
            font-size: 15px;
            color: #333;
            padding: 8px;
            border-radius: 6px;
            transition: background 0.2s;
        }

        .checkbox-label:hover {
            background: #f8f9fa;
        }

        .checkbox-label input[type="checkbox"] {
            width: 18px;
            height: 18px;
            cursor: pointer;
            accent-color: #1aa8ba;
        }

        .sort-select {
            width: 100%;
            padding: 12px;
            border: 1px solid #e0e0e0;
            border-radius: 8px;
            font-size: 15px;
            font-family: inherit;
            cursor: pointer;
            outline: none;
        }

        .sort-select:focus {
            border-color: #1aa8ba;
        }

        .filter-buttons {
            display: flex;
            flex-direction: column;
            gap: 10px;
            margin-top: 20px;
        }

        .apply-button, .reset-button {
            width: 100%;
            padding: 12px;
            border: none;
            border-radius: 8px;
            font-size: 15px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.2s;
        }

        .apply-button {
            background: #1aa8ba;
            color: white;
        }

        .apply-button:hover {
            background: #158a99;
        }

        .reset-button {
            background: white;
            color: #666;
            border: 1px solid #e0e0e0;
        }

        .reset-button:hover {
            background: #f8f9fa;
        }

        .products-section {
            min-height: 400px;
        }

        .title {
            font-size: 32px;
            font-weight: 600;
            margin-bottom: 25px;
        }

        .section-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 25px;
        }

        .section-title {
            font-size: 20px;
            font-weight: 600;
            color: #333;
        }

        .product-count {
            font-size: 16px;
            color: #666;
        }

        .active-filters {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
            margin-bottom: 20px;
        }

        .filter-tag {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 8px 14px;
            background: #e3f6f9;
            color: #1aa8ba;
            border-radius: 20px;
            font-size: 14px;
            font-weight: 500;
        }

        .filter-tag button {
            background: none;
            border: none;
            color: #1aa8ba;
            cursor: pointer;
            font-size: 16px;
            padding: 0;
            display: flex;
            align-items: center;
        }

        .products-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(260px, 1fr));
            gap: 25px;
        }

        .product-card {
            background: white;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 2px 8px rgba(0,0,0,0.08);
            transition: transform 0.2s, box-shadow 0.2s;
            cursor: pointer;
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
            font-size: 15px;
            font-weight: 500;
            color: #333;
            margin-bottom: 8px;
        }

        .product-price {
            font-size: 18px;
            font-weight: 600;
            color: #000;
            margin-bottom: 8px;
        }

        .product-meta {
            font-size: 13px;
            color: #666;
        }

        @media (max-width: 1024px) {
            .content-wrapper {
                grid-template-columns: 1fr;
            }

            .sidebar {
                position: static;
            }

            .filter-section {
                margin-bottom: 30px;
            }

            .products-grid {
                grid-template-columns: repeat(auto-fill, minmax(220px, 1fr));
            }
        }

        @media (max-width: 768px) {
            .products-grid {
                grid-template-columns: repeat(2, 1fr);
            }

            .header-container {
                flex-direction: column;
                gap: 15px;
            }
        }

        @media (max-width: 480px) {
            .products-grid {
                grid-template-columns: 1fr;
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

    <div class="search-container">
        <form method="GET" action="{{ route('products.index') }}" class="search-box">
            <input type="text" name="search" class="search-input" placeholder="Suche nach „Laptop", „Buch, ..." value="{{ request('search') }}">
            <button type="submit" class="search-button">🔍</button>
        </form>
    </div>

    <main class="main-content">
        <h1 class="title">Alle Produkte</h1>

        <div class="content-wrapper">
            <!-- Sidebar Filters -->
            <aside class="sidebar">
                <form method="GET" action="{{ route('products.index') }}" id="filterForm">
                    @if(request('search'))
                        <input type="hidden" name="search" value="{{ request('search') }}">
                    @endif

                    <!-- Sort Filter -->
                    <div class="filter-section">
                        <h3 class="filter-title">Sortieren</h3>
                        <select name="sort" class="sort-select" onchange="document.getElementById('filterForm').submit()">
                            <option value="latest" {{ request('sort') === 'latest' || !request('sort') ? 'selected' : '' }}>Neueste zuerst</option>
                            <option value="oldest" {{ request('sort') === 'oldest' ? 'selected' : '' }}>Älteste zuerst</option>
                            <option value="price_asc" {{ request('sort') === 'price_asc' ? 'selected' : '' }}>Preis: Niedrig → Hoch</option>
                            <option value="price_desc" {{ request('sort') === 'price_desc' ? 'selected' : '' }}>Preis: Hoch → Niedrig</option>
                        </select>
                    </div>

                    <!-- Category Filter -->
                    @if($categories->count() > 0)
                    <div class="filter-section">
                        <h3 class="filter-title">Kategorien</h3>
                        <div class="filter-group">
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
                            <label class="checkbox-label">
                                <input type="checkbox"
                                       name="categories[]"
                                       value="{{ $category->id }}"
                                       {{ in_array($category->id, request('categories', [])) ? 'checked' : '' }}>
                                <span>{{ $emoji }} {{ $category->name }}</span>
                            </label>
                            @endforeach
                        </div>
                    </div>
                    @endif

                    <!-- School Filter -->
                    @if($schools->count() > 0)
                    <div class="filter-section">
                        <h3 class="filter-title">Schulen</h3>
                        <div class="filter-group">
                            @foreach($schools as $school)
                            <label class="checkbox-label">
                                <input type="checkbox"
                                       name="schools[]"
                                       value="{{ $school->id }}"
                                       {{ in_array($school->id, request('schools', [])) ? 'checked' : '' }}>
                                <span>{{ $school->name }}</span>
                            </label>
                            @endforeach
                        </div>
                    </div>
                    @endif

                    <div class="filter-buttons">
                        <button type="submit" class="apply-button">Filter anwenden</button>
                        <a href="{{ route('products.index') }}" class="reset-button" style="text-align: center; text-decoration: none; display: block;">Filter zurücksetzen</a>
                    </div>
                </form>
            </aside>

            <!-- Products Section -->
            <section class="products-section">
                <!-- Active Filters -->
                @php
                    $hasActiveFilters = request()->has('search') || request()->has('categories') || request()->has('schools') || (request('sort') && request('sort') !== 'latest');
                @endphp

                @if($hasActiveFilters)
                <div class="active-filters">
                    @if(request()->has('search') && !empty(request('search')))
                    <span class="filter-tag">
                        Suche: "{{ request('search') }}"
                        <button type="button" onclick="removeSearchFilter()">×</button>
                    </span>
                    @endif

                    @if(request()->has('categories'))
                        @foreach(request('categories') as $catId)
                            @php $cat = $categories->find($catId); @endphp
                            @if($cat)
                            <span class="filter-tag">
                                {{ $cat->name }}
                                <button type="button" onclick="removeFilter('categories[]', '{{ $catId }}')">×</button>
                            </span>
                            @endif
                        @endforeach
                    @endif

                    @if(request()->has('schools'))
                        @foreach(request('schools') as $schoolId)
                            @php $school = $schools->find($schoolId); @endphp
                            @if($school)
                            <span class="filter-tag">
                                {{ $school->name }}
                                <button type="button" onclick="removeFilter('schools[]', '{{ $schoolId }}')">×</button>
                            </span>
                            @endif
                        @endforeach
                    @endif
                </div>
                @endif

                <div class="section-header">
                    <h2 class="section-title">Verfügbare Produkte</h2>
                    <span class="product-count">{{ $products->count() }} {{ $products->count() === 1 ? 'Produkt' : 'Produkte' }}</span>
                </div>

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
                            <div class="product-meta">
                                {{ $product->category->name }}
                                @if($product->school)
                                    • {{ $product->school->name }}
                                @endif
                            </div>
                        </div>
                    </a>
                    @endforeach
                </div>
                @else
                <div style="text-align: center; padding: 60px 20px; color: #666;">
                    <div style="font-size: 48px; margin-bottom: 20px;">🔍</div>
                    <h3 style="font-size: 20px; margin-bottom: 10px;">Keine Produkte gefunden</h3>
                    <p style="margin-bottom: 20px;">Versuche andere Filter oder <a href="{{ route('products.index') }}" style="color: #1aa8ba;">setze die Suche zurück</a>.</p>
                    @auth
                    <a href="{{ route('products.create') }}" style="display: inline-block; background: #1aa8ba; color: white; padding: 12px 30px; border-radius: 8px; text-decoration: none; font-weight: 600;">
                        Produkt inserieren
                    </a>
                    @endauth
                </div>
                @endif
            </section>
        </div>
    </main>

    <script>
        function removeFilter(name, value) {
            const form = document.getElementById('filterForm');
            const inputs = form.querySelectorAll(`input[name="${name}"][value="${value}"]`);
            inputs.forEach(input => input.checked = false);
            form.submit();
        }

        function removeSearchFilter() {
            const url = new URL(window.location.href);
            url.searchParams.delete('search');
            window.location.href = url.toString();
        }
    </script>
</body>
</html>
