<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Zahlung abgebrochen - StudyBuy</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, 'Helvetica Neue', Arial, sans-serif;
            background: #f8f9fa;
            display: flex;
            align-items: center;
            justify-content: center;
            min-height: 100vh;
            padding: 20px;
        }

        .cancel-container {
            max-width: 600px;
            background: white;
            border-radius: 16px;
            padding: 50px;
            text-align: center;
            box-shadow: 0 4px 20px rgba(0,0,0,0.1);
        }

        .cancel-icon {
            width: 80px;
            height: 80px;
            background: #ffebee;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 48px;
            margin: 0 auto 30px;
        }

        .cancel-title {
            font-size: 32px;
            font-weight: 600;
            color: #000;
            margin-bottom: 15px;
        }

        .cancel-message {
            font-size: 16px;
            color: #666;
            line-height: 1.6;
            margin-bottom: 30px;
        }

        .product-info {
            background: #f8f9fa;
            border-radius: 12px;
            padding: 25px;
            margin-bottom: 30px;
            text-align: left;
        }

        .product-title {
            font-size: 20px;
            font-weight: 600;
            color: #333;
            margin-bottom: 10px;
        }

        .product-price {
            font-size: 24px;
            font-weight: 700;
            color: #666;
        }

        .button-group {
            display: flex;
            gap: 15px;
            justify-content: center;
        }

        .button {
            padding: 14px 30px;
            border-radius: 8px;
            font-size: 16px;
            font-weight: 600;
            text-decoration: none;
            display: inline-block;
            transition: transform 0.2s;
        }

        .button:hover {
            transform: translateY(-2px);
        }

        .button-primary {
            background: #1aa8ba;
            color: white;
        }

        .button-secondary {
            background: white;
            color: #333;
            border: 2px solid #e0e0e0;
        }

        @media (max-width: 480px) {
            .cancel-container {
                padding: 30px 20px;
            }

            .button-group {
                flex-direction: column;
            }

            .button {
                width: 100%;
            }
        }
    </style>
</head>
<body>
    <div class="cancel-container">
        <div class="cancel-icon">✕</div>
        <h1 class="cancel-title">Zahlung abgebrochen</h1>
        <p class="cancel-message">
            Du hast den Kaufvorgang abgebrochen. Das Produkt ist weiterhin verfügbar,
            falls du es später kaufen möchtest.
        </p>

        <div class="product-info">
            <div class="product-title">{{ $product->title }}</div>
            <div class="product-price">{{ number_format($product->price, 2, '.', '\'') }} CHF</div>
        </div>

        <div class="button-group">
            <a href="{{ route('products.show', $product) }}" class="button button-primary">Zurück zum Produkt</a>
            <a href="{{ route('products.index') }}" class="button button-secondary">Weitere Produkte</a>
        </div>
    </div>
</body>
</html>
