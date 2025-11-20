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
        <div class="search-box">
            <input type="text" class="search-input" placeholder="Suche nach „Laptop", „Buch, ...">
            <button class="search-button">🔍</button>
        </div>
    </div>

    <main class="main-content">
        <h1 class="title">Kaufe und verkaufe deine Studienobjekte</h1>

        <div class="categories">
            <div class="category-card">
                <div class="category-icon">💻</div>
                <div class="category-name">Elektronik</div>
            </div>
            <div class="category-card">
                <div class="category-icon">📚</div>
                <div class="category-name">Bücher</div>
            </div>
            <div class="category-card">
                <div class="category-icon">🖩</div>
                <div class="category-name">Rechner</div>
            </div>
            <div class="category-card">
                <div class="category-icon">🎒</div>
                <div class="category-name">Zubehör</div>
            </div>
        </div>

        <div class="products-grid">
            <div class="product-card">
                <div class="product-image" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); display: flex; align-items: center; justify-content: center; font-size: 80px;">
                    📱
                </div>
                <div class="product-info">
                    <div class="product-title">iPad Pro (11 Zoll, 20</div>
                    <div class="product-price">450 CHF</div>
                </div>
            </div>

            <div class="product-card">
                <div class="product-image" style="background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%); display: flex; align-items: center; justify-content: center; font-size: 80px;">
                    📚
                </div>
                <div class="product-info">
                    <div class="product-title">Bücher</div>
                    <div class="product-price">60 CHF</div>
                </div>
            </div>

            <div class="product-card">
                <div class="product-image" style="background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%); display: flex; align-items: center; justify-content: center; font-size: 80px;">
                    🖩
                </div>
                <div class="product-info">
                    <div class="product-title">Texas Instruments Ti-84 Plus</div>
                    <div class="product-price">75 CHF</div>
                </div>
            </div>

            <div class="product-card">
                <div class="product-image" style="background: linear-gradient(135deg, #43e97b 0%, #38f9d7 100%); display: flex; align-items: center; justify-content: center; font-size: 80px;">
                    🎒
                </div>
                <div class="product-info">
                    <div class="product-title">Rucksack von Herschel</div>
                    <div class="product-price">40 CHF</div>
                </div>
            </div>
        </div>
    </main>
</body>
</html>
