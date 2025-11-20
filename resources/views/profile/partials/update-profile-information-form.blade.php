<section>
    <style>
        .section-header {
            margin-bottom: 25px;
        }

        .section-title {
            font-size: 20px;
            font-weight: 600;
            color: #000;
            margin-bottom: 8px;
        }

        .section-description {
            font-size: 14px;
            color: #666;
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

        .info-message {
            background: #fff3cd;
            color: #856404;
            padding: 12px;
            border-radius: 8px;
            margin-top: 10px;
            font-size: 14px;
        }

        .info-message button {
            background: none;
            border: none;
            color: #1aa8ba;
            text-decoration: underline;
            cursor: pointer;
            padding: 0;
            font-size: 14px;
        }

        .success-message {
            background: #d4edda;
            color: #155724;
            padding: 12px;
            border-radius: 8px;
            margin-top: 10px;
            font-size: 14px;
        }

        .form-actions {
            display: flex;
            align-items: center;
            gap: 15px;
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
        }

        .submit-button:hover {
            background: #158a99;
        }

        .saved-text {
            color: #155724;
            font-size: 14px;
            font-weight: 500;
        }
    </style>

    <header class="section-header">
        <h2 class="section-title">Profilinformationen</h2>
        <p class="section-description">
            Aktualisieren Sie die Profilinformationen und E-Mail-Adresse Ihres Kontos.
        </p>
    </header>

    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
        @csrf
    </form>

    <form method="post" action="{{ route('profile.update') }}">
        @csrf
        @method('patch')

        <div class="form-group">
            <label for="name" class="form-label">Name</label>
            <input id="name" name="name" type="text" class="form-input" value="{{ old('name', $user->name) }}" required autofocus autocomplete="name">
            @error('name')
                <div class="error-message">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label for="email" class="form-label">E-Mail</label>
            <input id="email" name="email" type="email" class="form-input" value="{{ old('email', $user->email) }}" required autocomplete="username">
            @error('email')
                <div class="error-message">{{ $message }}</div>
            @enderror

            @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
                <div class="info-message">
                    Ihre E-Mail-Adresse ist nicht verifiziert.
                    <button form="send-verification">
                        Klicken Sie hier, um die Verifizierungs-E-Mail erneut zu senden.
                    </button>
                </div>

                @if (session('status') === 'verification-link-sent')
                    <div class="success-message">
                        Ein neuer Verifizierungslink wurde an Ihre E-Mail-Adresse gesendet.
                    </div>
                @endif
            @endif
        </div>

        <div class="form-actions">
            <button type="submit" class="submit-button">Speichern</button>

            @if (session('status') === 'profile-updated')
                <span class="saved-text">Gespeichert.</span>
            @endif
        </div>
    </form>
</section>
