@php
    $wallet = auth()->user()->wallet()->first() ?? auth()->user()->wallet()->create(['balance' => 0, 'currency' => 'CHF']);
    $stripeConnected = auth()->user()->stripe_connect_enabled;
    $stripeFee = env('PLATFORM_FEE_PERCENTAGE', 7);
    $manualFee = env('MANUAL_PAYOUT_FEE_PERCENTAGE', 12);
    $manualFixedFee = env('MANUAL_PAYOUT_FIXED_FEE', 2.50);
@endphp

<section>
    <header>
        <h2 style="font-size: 20px; font-weight: 600; color: #000; margin-bottom: 8px;">
            Wallet & Auszahlungen
        </h2>
        <p style="font-size: 14px; color: #666; margin-bottom: 24px;">
            Dein Guthaben aus Verkäufen und Auszahlungsoptionen
        </p>
    </header>

    {{-- Wallet Balance --}}
    <div style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); padding: 30px; border-radius: 12px; margin-bottom: 24px; color: white;">
        <div style="font-size: 14px; opacity: 0.9; margin-bottom: 8px;">Verfügbares Guthaben</div>
        <div style="font-size: 42px; font-weight: 700; margin-bottom: 4px;">
            CHF {{ number_format($wallet->balance, 2, '.', "'") }}
        </div>
        <div style="font-size: 12px; opacity: 0.8;">
            Stand: {{ now()->format('d.m.Y H:i') }} Uhr
        </div>
    </div>

    {{-- Fee Comparison --}}
    <div style="background: #f8f9fa; padding: 20px; border-radius: 8px; border: 1px solid #dee2e6; margin-bottom: 24px;">
        <h3 style="font-size: 16px; font-weight: 600; color: #000; margin-bottom: 16px;">
            Auszahlungsoptionen im Vergleich
        </h3>

        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 16px; margin-bottom: 0;">
            {{-- Stripe Connect Option --}}
            <div style="background: white; padding: 16px; border-radius: 8px; border: 2px solid {{ $stripeConnected ? '#28a745' : '#dee2e6' }};">
                <div style="display: flex; align-items: center; gap: 8px; margin-bottom: 8px;">
                    @if($stripeConnected)
                        <svg style="width: 20px; height: 20px; color: #28a745;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    @endif
                    <strong style="font-size: 14px; color: #000;">Stripe Connect (Automatisch)</strong>
                </div>
                <div style="font-size: 13px; color: #666; margin-bottom: 12px;">
                    Automatische Auszahlung direkt auf dein Bankkonto
                </div>
                <div style="font-size: 20px; font-weight: 600; color: #28a745; margin-bottom: 8px;">
                    {{ $stripeFee }}% Gebühr
                </div>
                <ul style="font-size: 12px; color: #666; padding-left: 18px; margin: 0;">
                    <li>Sofortige Auszahlung</li>
                    <li>Niedrigste Gebühren</li>
                    <li>Vollautomatisch</li>
                </ul>
            </div>

            {{-- Manual IBAN Option --}}
            <div style="background: white; padding: 16px; border-radius: 8px; border: 2px solid #dee2e6;">
                <strong style="font-size: 14px; color: #000; display: block; margin-bottom: 8px;">Manuelle Auszahlung (IBAN)</strong>
                <div style="font-size: 13px; color: #666; margin-bottom: 12px;">
                    Auszahlung per Banküberweisung auf deine IBAN
                </div>
                <div style="font-size: 20px; font-weight: 600; color: #dc3545; margin-bottom: 8px;">
                    {{ $manualFee }}% + CHF {{ number_format($manualFixedFee, 2) }}
                </div>
                <ul style="font-size: 12px; color: #666; padding-left: 18px; margin: 0;">
                    <li>Bearbeitungszeit 2-5 Tage</li>
                    <li>Höhere Gebühren</li>
                    <li>Manuelle Prüfung</li>
                </ul>
            </div>
        </div>
    </div>

    {{-- How It Works --}}
    <div style="background: #e7f3ff; padding: 16px; border-radius: 8px; border: 1px solid #b3d9ff; margin-bottom: 24px;">
        <h4 style="font-size: 14px; font-weight: 600; color: #004085; margin-bottom: 12px;">
            💡 Wie funktioniert es?
        </h4>
        <div style="font-size: 13px; color: #004085; line-height: 1.6;">
            @if($stripeConnected)
                <strong>✓ Stripe Connect aktiv:</strong> Deine Verkäufe werden automatisch mit {{ $stripeFee }}% Gebühr auf dein verbundenes Bankkonto überwiesen.
                <br><br>
                Wallet-Guthaben kannst du ebenfalls per IBAN auszahlen lassen ({{ $manualFee }}% + CHF {{ number_format($manualFixedFee, 2) }} Gebühr).
            @else
                <strong>Ohne Stripe Connect:</strong> Deine Verkäufe landen in deinem Wallet. Von hier kannst du das Guthaben per IBAN auszahlen lassen ({{ $manualFee }}% + CHF {{ number_format($manualFixedFee, 2) }} Gebühr).
                <br><br>
                <strong>Empfehlung:</strong> Verbinde Stripe Connect für automatische Auszahlungen mit nur {{ $stripeFee }}% Gebühr! 💰
            @endif
        </div>
    </div>

    {{-- Payout Request Form --}}
    @if($wallet->balance >= 10)
        <div style="background: white; padding: 20px; border-radius: 8px; border: 1px solid #dee2e6;">
            <h3 style="font-size: 16px; font-weight: 600; color: #000; margin-bottom: 16px;">
                Auszahlung beantragen (IBAN)
            </h3>

            <form method="POST" action="{{ route('wallet.payout-request') }}">
                @csrf

                <div style="margin-bottom: 16px;">
                    <label style="font-size: 14px; font-weight: 500; color: #000; display: block; margin-bottom: 8px;">
                        Auszahlungsbetrag
                    </label>
                    <input type="number"
                           name="amount"
                           step="0.01"
                           min="10"
                           max="{{ $wallet->balance }}"
                           value="{{ $wallet->balance }}"
                           required
                           style="width: 100%; padding: 10px; border: 1px solid #dee2e6; border-radius: 6px; font-size: 14px;">
                    <div style="font-size: 12px; color: #666; margin-top: 4px;">
                        Mindestbetrag: CHF 10.00 | Verfügbar: CHF {{ number_format($wallet->balance, 2) }}
                    </div>
                </div>

                @php
                    $exampleAmount = min(50, $wallet->balance);
                    $exampleFee = ($exampleAmount * $manualFee / 100) + $manualFixedFee;
                    $exampleNet = $exampleAmount - $exampleFee;
                @endphp

                <div style="background: #fff3cd; padding: 12px; border-radius: 6px; margin-bottom: 16px; font-size: 13px; color: #856404;">
                    <strong>Beispiel:</strong> Bei CHF {{ number_format($exampleAmount, 2) }} erhältst du CHF {{ number_format($exampleNet, 2) }} (Gebühr: CHF {{ number_format($exampleFee, 2) }})
                </div>

                <div style="margin-bottom: 16px;">
                    <label style="font-size: 14px; font-weight: 500; color: #000; display: block; margin-bottom: 8px;">
                        IBAN
                    </label>
                    <input type="text"
                           name="iban"
                           placeholder="CH93 0076 2011 6238 5295 7"
                           required
                           pattern="[A-Z]{2}[0-9]{2}[A-Z0-9]+"
                           style="width: 100%; padding: 10px; border: 1px solid #dee2e6; border-radius: 6px; font-size: 14px; text-transform: uppercase;">
                </div>

                <div style="margin-bottom: 20px;">
                    <label style="font-size: 14px; font-weight: 500; color: #000; display: block; margin-bottom: 8px;">
                        Kontoinhaber Name
                    </label>
                    <input type="text"
                           name="account_holder_name"
                           value="{{ auth()->user()->name }}"
                           required
                           style="width: 100%; padding: 10px; border: 1px solid #dee2e6; border-radius: 6px; font-size: 14px;">
                </div>

                <button type="submit"
                        style="width: 100%; padding: 12px; background: #1aa8ba; color: white; border: none; border-radius: 8px; font-size: 16px; font-weight: 600; cursor: pointer;">
                    Auszahlung beantragen
                </button>

                <div style="font-size: 11px; color: #999; margin-top: 12px; text-align: center;">
                    Die Auszahlung wird innerhalb von 2-5 Werktagen bearbeitet
                </div>
            </form>
        </div>
    @else
        <div style="background: #f8f9fa; padding: 20px; border-radius: 8px; text-align: center; color: #666;">
            <div style="font-size: 48px; margin-bottom: 12px;">💰</div>
            <div style="font-size: 14px;">
                Mindestbetrag für Auszahlung: CHF 10.00
                <br>
                Aktuelles Guthaben: CHF {{ number_format($wallet->balance, 2) }}
            </div>
        </div>
    @endif

    {{-- Recent Transactions --}}
    @php
        $recentTransactions = $wallet->transactions()->limit(5)->get();
    @endphp

    @if($recentTransactions->count() > 0)
        <div style="margin-top: 32px;">
            <h3 style="font-size: 16px; font-weight: 600; color: #000; margin-bottom: 16px;">
                Letzte Transaktionen
            </h3>
            <div style="background: white; border-radius: 8px; border: 1px solid #dee2e6; overflow: hidden;">
                @foreach($recentTransactions as $transaction)
                    <div style="padding: 12px 16px; border-bottom: 1px solid #f0f0f0; display: flex; justify-content: space-between; align-items: center;">
                        <div>
                            <div style="font-size: 14px; color: #000; margin-bottom: 4px;">
                                {{ $transaction->description }}
                            </div>
                            <div style="font-size: 12px; color: #999;">
                                {{ $transaction->created_at->format('d.m.Y H:i') }}
                            </div>
                        </div>
                        <div style="font-size: 16px; font-weight: 600; color: {{ $transaction->type === 'credit' ? '#28a745' : '#dc3545' }};">
                            {{ $transaction->type === 'credit' ? '+' : '-' }} CHF {{ number_format($transaction->amount, 2) }}
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    @endif
</section>
