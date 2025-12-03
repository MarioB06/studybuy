<?php

namespace App\Http\Controllers;

use App\Models\PayoutRequest;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;

class WalletController extends Controller
{
    /**
     * Create a payout request
     */
    public function createPayoutRequest(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'amount' => 'required|numeric|min:10',
            'iban' => 'required|string|regex:/^[A-Z]{2}[0-9]{2}[A-Z0-9]+$/',
            'account_holder_name' => 'required|string|max:255',
        ], [
            'amount.min' => 'Der Mindestbetrag beträgt CHF 10.00',
            'iban.regex' => 'Bitte gib eine gültige IBAN ein (z.B. CH93 0076 2011 6238 5295 7)',
        ]);

        $user = auth()->user();
        $wallet = $user->wallet()->first();

        if (!$wallet || $wallet->balance < $validated['amount']) {
            return redirect()->route('profile.edit')
                ->with('error', 'Unzureichendes Guthaben für diese Auszahlung.');
        }

        // Calculate fees
        $amount = $validated['amount'];
        $feePercentage = env('MANUAL_PAYOUT_FEE_PERCENTAGE', 12);
        $fixedFee = env('MANUAL_PAYOUT_FIXED_FEE', 2.50);
        $feeAmount = ($amount * $feePercentage / 100) + $fixedFee;
        $netAmount = $amount - $feeAmount;

        // Check if net amount is reasonable
        if ($netAmount < 5) {
            return redirect()->route('profile.edit')
                ->with('error', 'Nach Abzug der Gebühren wäre der Auszahlungsbetrag zu gering. Bitte erhöhe den Betrag.');
        }

        try {
            // Deduct from wallet
            $wallet->debit(
                $amount,
                "Auszahlungsanfrage (IBAN: " . substr($validated['iban'], -4) . ")",
                'PayoutRequest'
            );

            // Create payout request
            PayoutRequest::create([
                'user_id' => $user->id,
                'amount' => $amount,
                'fee_amount' => $feeAmount,
                'net_amount' => $netAmount,
                'iban' => strtoupper(str_replace(' ', '', $validated['iban'])),
                'account_holder_name' => $validated['account_holder_name'],
                'status' => 'pending',
            ]);

            return redirect()->route('profile.edit')
                ->with('success', "Auszahlungsanfrage über CHF {$amount} wurde erfolgreich erstellt. Du erhältst CHF " . number_format($netAmount, 2) . " auf dein Konto.");

        } catch (\Exception $e) {
            \Log::error("Payout request failed for user {$user->id}: " . $e->getMessage());

            return redirect()->route('profile.edit')
                ->with('error', 'Fehler beim Erstellen der Auszahlungsanfrage: ' . $e->getMessage());
        }
    }
}
