<x-guest-layout>
    <style>
        .form-title {
            font-size: 24px;
            font-weight: 600;
            color: #000;
            margin-bottom: 30px;
            text-align: center;
        }

        .form-description {
            font-size: 14px;
            color: #666;
            margin-bottom: 25px;
            text-align: center;
            line-height: 1.5;
        }

        .status-message {
            background: #d4edda;
            color: #155724;
            padding: 12px;
            border-radius: 8px;
            margin-bottom: 20px;
            font-size: 14px;
            text-align: center;
        }

        .form-actions {
            margin-top: 25px;
        }

        .submit-button {
            background: #1aa8ba;
            color: white;
            border: none;
            padding: 12px 30px;
            border-radius: 8px;
            font-size: 15px;
            font-weight: 500;
            cursor: pointer;
            transition: background 0.2s;
            width: 100%;
        }

        .submit-button:hover {
            background: #158a99;
        }

        .logout-button {
            background: transparent;
            color: #1aa8ba;
            border: none;
            padding: 12px 30px;
            border-radius: 8px;
            font-size: 15px;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.2s;
            width: 100%;
            margin-top: 10px;
        }

        .logout-button:hover {
            text-decoration: underline;
        }
    </style>

    <h2 class="form-title">E-Mail bestätigen</h2>

    <div class="form-description">
        Danke für deine Registrierung! Bevor du loslegst, bestätige bitte deine E-Mail-Adresse, indem du auf den Link klickst, den wir dir gerade per E-Mail gesendet haben. Falls du die E-Mail nicht erhalten hast, senden wir dir gerne eine neue.
    </div>

    @if (session('status') == 'verification-link-sent')
        <div class="status-message">
            Ein neuer Bestätigungslink wurde an die E-Mail-Adresse gesendet, die du bei der Registrierung angegeben hast.
        </div>
    @endif

    <form method="POST" action="{{ route('verification.send') }}">
        @csrf

        <div class="form-actions">
            <button type="submit" class="submit-button">
                Bestätigungs-E-Mail erneut senden
            </button>
        </div>
    </form>

    <form method="POST" action="{{ route('logout') }}">
        @csrf

        <button type="submit" class="logout-button">
            Abmelden
        </button>
    </form>
</x-guest-layout>
