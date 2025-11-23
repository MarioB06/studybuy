<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Zahlung erfolgreich - StudyBuy</title>
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

        .success-container {
            max-width: 600px;
            background: white;
            border-radius: 16px;
            padding: 50px;
            text-align: center;
            box-shadow: 0 4px 20px rgba(0,0,0,0.1);
        }

        .success-icon {
            width: 80px;
            height: 80px;
            background: linear-gradient(135deg, #1aa8ba 0%, #158a99 100%);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 48px;
            margin: 0 auto 30px;
        }

        .success-title {
            font-size: 32px;
            font-weight: 600;
            color: #000;
            margin-bottom: 15px;
        }

        .success-message {
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
            color: #1aa8ba;
            margin-bottom: 15px;
        }

        .info-row {
            display: flex;
            justify-content: space-between;
            padding: 10px 0;
            border-top: 1px solid #e0e0e0;
        }

        .info-label {
            color: #666;
        }

        .info-value {
            font-weight: 600;
            color: #333;
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
            .success-container {
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
    <div class="success-container">
        <div class="success-icon">✓</div>
        <h1 class="success-title">Zahlung erfolgreich!</h1>
        <p class="success-message">
            Vielen Dank für deinen Kauf! Deine Zahlung wurde erfolgreich verarbeitet.
            Der Verkäufer wird sich in Kürze bei dir melden.
        </p>

        <div class="product-info">
            <div class="product-title">{{ $product->title }}</div>
            <div class="product-price">{{ number_format($product->price, 2, '.', '\'') }} CHF</div>

            @if(isset($session))
            <div class="info-row">
                <span class="info-label">Status:</span>
                <span class="info-value">Bezahlt</span>
            </div>
            @endif

            <div class="info-row">
                <span class="info-label">Verkäufer:</span>
                <span class="info-value">{{ $product->user->name }}</span>
            </div>
        </div>

        @if(isset($error))
        <div style="background: #ffebee; color: #c62828; padding: 15px; border-radius: 8px; margin-bottom: 20px;">
            {{ $error }}
        </div>
        @endif

        <div class="button-group">
            <a href="{{ route('dashboard') }}" class="button button-primary">Zum Dashboard</a>
            <a href="{{ route('products.index') }}" class="button button-secondary">Weitere Produkte</a>
        </div>
    </div>
</body>
</html>
