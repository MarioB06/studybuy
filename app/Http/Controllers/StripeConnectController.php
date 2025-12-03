<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Stripe\Stripe;
use Stripe\Account;
use Stripe\AccountLink;

class StripeConnectController extends Controller
{
    public function __construct()
    {
        Stripe::setApiKey(env('STRIPE_SECRET'));
    }

    /**
     * Show Stripe Connect status in profile
     */
    public function index(): View
    {
        $user = auth()->user();
        $stripeAccount = null;

        if ($user->stripe_connect_id) {
            try {
                $stripeAccount = Account::retrieve($user->stripe_connect_id);
            } catch (\Exception $e) {
                // Account not found or error
            }
        }

        return view('stripe-connect.index', compact('stripeAccount'));
    }

    /**
     * Start Stripe Connect onboarding
     */
    public function connect(): RedirectResponse
    {
        $user = auth()->user();

        try {
            // Create or retrieve Stripe Connect account
            if ($user->stripe_connect_id) {
                $accountId = $user->stripe_connect_id;
            } else {
                $account = Account::create([
                    'type' => 'express',
                    'country' => 'CH',
                    'email' => $user->email,
                    'capabilities' => [
                        'card_payments' => ['requested' => true],
                        'transfers' => ['requested' => true],
                    ],
                ]);

                $accountId = $account->id;

                // Save to user
                $user->update([
                    'stripe_connect_id' => $accountId,
                ]);
            }

            // Create account link for onboarding
            $accountLink = AccountLink::create([
                'account' => $accountId,
                'refresh_url' => route('stripe-connect.refresh'),
                'return_url' => route('stripe-connect.return'),
                'type' => 'account_onboarding',
            ]);

            return redirect($accountLink->url);

        } catch (\Exception $e) {
            return redirect()->route('profile.edit')
                ->with('error', 'Fehler beim Verbinden mit Stripe: ' . $e->getMessage());
        }
    }

    /**
     * Handle return from Stripe onboarding
     */
    public function returnUrl(): RedirectResponse
    {
        $user = auth()->user();

        try {
            $account = Account::retrieve($user->stripe_connect_id);

            // Check if onboarding is complete
            if ($account->details_submitted) {
                $user->update([
                    'stripe_connect_enabled' => true,
                    'stripe_connect_created_at' => now(),
                ]);

                return redirect()->route('profile.edit')
                    ->with('success', 'Stripe Connect erfolgreich verbunden! Du kannst jetzt automatische Auszahlungen erhalten.');
            }

            return redirect()->route('profile.edit')
                ->with('warning', 'Stripe Connect Einrichtung noch nicht abgeschlossen. Bitte vervollständige alle Schritte.');

        } catch (\Exception $e) {
            return redirect()->route('profile.edit')
                ->with('error', 'Fehler beim Überprüfen des Stripe-Kontos.');
        }
    }

    /**
     * Handle refresh during onboarding
     */
    public function refresh(): RedirectResponse
    {
        return $this->connect();
    }

    /**
     * Disconnect Stripe account
     */
    public function disconnect(): RedirectResponse
    {
        $user = auth()->user();

        $user->update([
            'stripe_connect_id' => null,
            'stripe_connect_enabled' => false,
            'stripe_connect_created_at' => null,
        ]);

        return redirect()->route('profile.edit')
            ->with('success', 'Stripe Connect wurde getrennt.');
    }

    /**
     * Open Stripe Express Dashboard
     */
    public function dashboard(): RedirectResponse
    {
        $user = auth()->user();

        if (!$user->stripe_connect_id) {
            return redirect()->route('profile.edit')
                ->with('error', 'Kein Stripe Connect Konto verbunden.');
        }

        try {
            $loginLink = \Stripe\Account::createLoginLink($user->stripe_connect_id);
            return redirect($loginLink->url);
        } catch (\Exception $e) {
            return redirect()->route('profile.edit')
                ->with('error', 'Fehler beim Öffnen des Stripe Dashboards.');
        }
    }
}
