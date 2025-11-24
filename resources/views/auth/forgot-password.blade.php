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

        .form-group {
            margin-bottom: 20px;
        }

        .form-label {
            display: block;
            font-size: 14px;
            font-weight: 500;
            color: #333;
            margin-bottom: 8px;
        }

        .form-input {
            width: 100%;
            padding: 12px 15px;
            border: 1px solid #e0e0e0;
            border-radius: 8px;
            font-size: 15px;
            outline: none;
            transition: border-color 0.2s;
        }

        .form-input:focus {
            border-color: #1aa8ba;
        }

        .error-message {
            color: #e74c3c;
            font-size: 13px;
            margin-top: 5px;
        }

        .status-message {
            background: #d4edda;
            color: #155724;
            padding: 12px;
            border-radius: 8px;
            margin-bottom: 20px;
            font-size: 14px;
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

        .login-link {
            text-align: center;
            margin-top: 25px;
            font-size: 14px;
            color: #666;
        }

        .login-link a {
            color: #1aa8ba;
            text-decoration: none;
            font-weight: 500;
        }

        .login-link a:hover {
            text-decoration: underline;
        }
    </style>

    <h2 class="form-title">Passwort vergessen</h2>

    <div class="form-description">
        Kein Problem! Gib uns einfach deine E-Mail-Adresse und wir senden dir einen Link zum Zurücksetzen deines Passworts.
    </div>

    <!-- Session Status -->
    @if (session('status'))
        <div class="status-message">
            {{ session('status') }}
        </div>
    @endif

    <form method="POST" action="{{ route('password.email') }}">
        @csrf

        <!-- Email Address -->
        <div class="form-group">
            <label for="email" class="form-label">E-Mail</label>
            <input id="email" class="form-input" type="email" name="email" value="{{ old('email') }}" required autofocus>
            @error('email')
                <div class="error-message">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-actions">
            <button type="submit" class="submit-button">
                Link zum Zurücksetzen senden
            </button>
        </div>
    </form>

    <div class="login-link">
        Zurück zur <a href="{{ route('login') }}">Anmeldung</a>
    </div>
</x-guest-layout>
