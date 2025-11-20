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
        <h2 class="section-title">Passwort aktualisieren</h2>
        <p class="section-description">
            Stellen Sie sicher, dass Ihr Konto ein langes, zufälliges Passwort verwendet, um sicher zu bleiben.
        </p>
    </header>

    <form method="post" action="{{ route('password.update') }}">
        @csrf
        @method('put')

        <div class="form-group">
            <label for="update_password_current_password" class="form-label">Aktuelles Passwort</label>
            <input id="update_password_current_password" name="current_password" type="password" class="form-input" autocomplete="current-password">
            @error('current_password', 'updatePassword')
                <div class="error-message">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label for="update_password_password" class="form-label">Neues Passwort</label>
            <input id="update_password_password" name="password" type="password" class="form-input" autocomplete="new-password">
            @error('password', 'updatePassword')
                <div class="error-message">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label for="update_password_password_confirmation" class="form-label">Passwort bestätigen</label>
            <input id="update_password_password_confirmation" name="password_confirmation" type="password" class="form-input" autocomplete="new-password">
            @error('password_confirmation', 'updatePassword')
                <div class="error-message">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-actions">
            <button type="submit" class="submit-button">Speichern</button>

            @if (session('status') === 'password-updated')
                <span class="saved-text">Gespeichert.</span>
            @endif
        </div>
    </form>
</section>
