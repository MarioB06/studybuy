<section>
    <header>
        <h2 style="font-size: 20px; font-weight: 600; color: #000; margin-bottom: 8px;">
            Stripe Connect - Automatische Auszahlungen
        </h2>
        <p style="font-size: 14px; color: #666; margin-bottom: 24px;">
            Verbinde dein Stripe-Konto, um automatische Auszahlungen für verkaufte Produkte zu erhalten.
        </p>
    </header>

    @if(session('success'))
        <div style="background: #d4edda; color: #155724; padding: 12px 16px; border-radius: 8px; margin-bottom: 20px; border: 1px solid #c3e6cb;">
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div style="background: #f8d7da; color: #721c24; padding: 12px 16px; border-radius: 8px; margin-bottom: 20px; border: 1px solid #f5c6cb;">
            {{ session('error') }}
        </div>
    @endif

    @if(session('warning'))
        <div style="background: #fff3cd; color: #856404; padding: 12px 16px; border-radius: 8px; margin-bottom: 20px; border: 1px solid #ffeaa7;">
            {{ session('warning') }}
        </div>
    @endif

    @if(auth()->user()->stripe_connect_enabled)
        <!-- Connected State -->
        <div style="background: #d4edda; padding: 20px; border-radius: 8px; border: 1px solid #c3e6cb; margin-bottom: 20px;">
            <div style="display: flex; align-items: center; gap: 12px; margin-bottom: 12px;">
                <svg style="width: 24px; height: 24px; color: #28a745;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                <span style="font-size: 16px; font-weight: 600; color: #155724;">
                    Stripe Connect verbunden
                </span>
            </div>
            <p style="font-size: 14px; color: #155724; margin-bottom: 0;">
                Dein Stripe-Konto ist erfolgreich verbunden. Du erhältst automatische Auszahlungen, sobald eine Transaktion abgeschlossen ist.
            </p>
            @if(auth()->user()->stripe_connect_created_at)
                <p style="font-size: 12px; color: #666; margin-top: 8px; margin-bottom: 0;">
                    Verbunden seit: {{ auth()->user()->stripe_connect_created_at->format('d.m.Y H:i') }}
                </p>
            @endif
        </div>

        <div style="display: flex; gap: 12px; flex-wrap: wrap;">
            <a href="{{ route('stripe-connect.dashboard') }}"
               style="display: inline-block; padding: 10px 20px; background: #1aa8ba; color: white; border-radius: 8px; text-decoration: none; font-weight: 500; transition: background 0.2s;">
                Stripe Dashboard öffnen
            </a>

            <form method="POST" action="{{ route('stripe-connect.disconnect') }}" style="display: inline;">
                @csrf
                <button type="submit"
                        onclick="return confirm('Möchtest du Stripe Connect wirklich trennen? Du erhältst dann keine automatischen Auszahlungen mehr.')"
                        style="padding: 10px 20px; background: #dc3545; color: white; border: none; border-radius: 8px; font-weight: 500; cursor: pointer; transition: background 0.2s;">
                    Verbindung trennen
                </button>
            </form>
        </div>
    @else
        <!-- Not Connected State -->
        <div style="background: #f8f9fa; padding: 20px; border-radius: 8px; border: 1px solid #dee2e6; margin-bottom: 20px;">
            <h3 style="font-size: 16px; font-weight: 600; color: #000; margin-bottom: 12px;">
                Warum Stripe Connect?
            </h3>
            <ul style="font-size: 14px; color: #666; margin-bottom: 0; padding-left: 20px;">
                <li style="margin-bottom: 8px;">✓ Automatische Auszahlungen nach abgeschlossenen Transaktionen</li>
                <li style="margin-bottom: 8px;">✓ Sicher und zuverlässig durch Stripe</li>
                <li style="margin-bottom: 8px;">✓ Direkt auf dein Bankkonto</li>
                <li style="margin-bottom: 8px;">✓ Transparente Übersicht über deine Verkäufe</li>
                <li style="margin-bottom: 0;">✓ Keine monatlichen Gebühren</li>
            </ul>
        </div>

        @php
            $platformFee = env('PLATFORM_FEE_PERCENTAGE', 5);
            $stripeProcessingFee = 2.9;
            $stripeFixedFee = 0.30;
            $totalStripeFee = $platformFee + $stripeProcessingFee;
        @endphp

        <div style="background: #e7f3ff; padding: 16px; border-radius: 8px; border: 1px solid #b3d9ff; margin-bottom: 20px;">
            <h4 style="font-size: 14px; font-weight: 600; color: #004085; margin-bottom: 12px;">
                💰 Gebührenstruktur mit Stripe Connect
            </h4>
            <div style="font-size: 13px; color: #004085; line-height: 1.6;">
                <strong>Bei jedem Verkauf werden folgende Gebühren abgezogen:</strong>
                <br>• {{ $platformFee }}% Plattformgebühr (StudyBuy)
                <br>• {{ $stripeProcessingFee }}% + CHF {{ number_format($stripeFixedFee, 2) }} Zahlungsabwicklung (Stripe)
                <br>• <strong>Total: ~{{ number_format($totalStripeFee, 1) }}% + CHF {{ number_format($stripeFixedFee, 2) }}</strong>
                <br><br>
                <strong>Beispiel:</strong> Bei einem Verkauf von CHF 100 erhältst du automatisch <strong>~CHF {{ number_format(100 - (100 * $totalStripeFee / 100) - $stripeFixedFee, 2) }}</strong> direkt auf dein Bankkonto.
            </div>
        </div>

        <div style="background: #fff3cd; padding: 16px; border-radius: 8px; border: 1px solid #ffeaa7; margin-bottom: 20px;">
            <p style="font-size: 14px; color: #856404; margin-bottom: 0;">
                <strong>Hinweis:</strong> Ohne Stripe Connect landen deine Verkäufe zu 100% in deinem Wallet. Bei Auszahlung per IBAN fallen dann {{ env('MANUAL_PAYOUT_FEE_PERCENTAGE', 7) }}% + CHF {{ number_format(env('MANUAL_PAYOUT_FIXED_FEE', 3.00), 2) }} Gebühren an.
            </p>
        </div>

        <form method="POST" action="{{ route('stripe-connect.connect') }}">
            @csrf
            <button type="submit"
                    style="padding: 12px 24px; background: #635bff; color: white; border: none; border-radius: 8px; font-size: 16px; font-weight: 600; cursor: pointer; transition: background 0.2s; display: inline-flex; align-items: center; gap: 8px;">
                <svg style="width: 20px; height: 20px;" fill="currentColor" viewBox="0 0 24 24">
                    <path d="M13.976 9.15c-2.172-.806-3.356-1.426-3.356-2.409 0-.831.683-1.305 1.901-1.305 2.227 0 4.515.858 6.09 1.631l.89-5.494C18.252.975 15.697 0 12.165 0 9.667 0 7.589.654 6.104 1.872 4.56 3.147 3.757 4.992 3.757 7.218c0 4.039 2.467 5.76 6.476 7.219 2.585.92 3.445 1.574 3.445 2.583 0 .98-.84 1.545-2.354 1.545-1.875 0-4.965-.921-6.99-2.109l-.9 5.555C5.175 22.99 8.385 24 11.714 24c2.641 0 4.843-.624 6.328-1.813 1.664-1.305 2.525-3.236 2.525-5.732 0-4.128-2.524-5.851-6.594-7.305h.003z"/>
                </svg>
                Mit Stripe verbinden
            </button>
        </form>

        <p style="font-size: 12px; color: #999; margin-top: 12px;">
            Du wirst zu Stripe weitergeleitet, um dein Konto einzurichten. Dies dauert nur wenige Minuten.
        </p>
    @endif
</section>
