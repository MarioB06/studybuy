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

        .danger-button {
            background: #e74c3c;
            color: white;
            border: none;
            padding: 12px 30px;
            border-radius: 8px;
            font-size: 15px;
            font-weight: 500;
            cursor: pointer;
            transition: background 0.2s;
        }

        .danger-button:hover {
            background: #c0392b;
        }

        .modal-overlay {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(0, 0, 0, 0.5);
            z-index: 1000;
            align-items: center;
            justify-content: center;
        }

        .modal-overlay.show {
            display: flex;
        }

        .modal-content {
            background: white;
            border-radius: 12px;
            padding: 30px;
            max-width: 500px;
            width: 90%;
            box-shadow: 0 4px 20px rgba(0,0,0,0.2);
        }

        .modal-title {
            font-size: 20px;
            font-weight: 600;
            color: #000;
            margin-bottom: 15px;
        }

        .modal-description {
            font-size: 14px;
            color: #666;
            margin-bottom: 20px;
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

        .modal-actions {
            display: flex;
            justify-content: flex-end;
            gap: 15px;
            margin-top: 25px;
        }

        .secondary-button {
            background: #e0e0e0;
            color: #333;
            border: none;
            padding: 12px 30px;
            border-radius: 8px;
            font-size: 15px;
            font-weight: 500;
            cursor: pointer;
            transition: background 0.2s;
        }

        .secondary-button:hover {
            background: #d0d0d0;
        }
    </style>

    <header class="section-header">
        <h2 class="section-title">Konto löschen</h2>
        <p class="section-description">
            Sobald Ihr Konto gelöscht wird, werden alle zugehörigen Ressourcen und Daten dauerhaft gelöscht.
            Bevor Sie Ihr Konto löschen, laden Sie bitte alle Daten oder Informationen herunter, die Sie behalten möchten.
        </p>
    </header>

    <button type="button" class="danger-button" onclick="document.getElementById('deleteModal').classList.add('show')">
        Konto löschen
    </button>

    <div id="deleteModal" class="modal-overlay" onclick="if(event.target === this) this.classList.remove('show')">
        <div class="modal-content">
            <form method="post" action="{{ route('profile.destroy') }}">
                @csrf
                @method('delete')

                <h2 class="modal-title">Sind Sie sicher, dass Sie Ihr Konto löschen möchten?</h2>

                <p class="modal-description">
                    Sobald Ihr Konto gelöscht wird, werden alle zugehörigen Ressourcen und Daten dauerhaft gelöscht.
                    Bitte geben Sie Ihr Passwort ein, um zu bestätigen, dass Sie Ihr Konto dauerhaft löschen möchten.
                </p>

                <div class="form-group">
                    <label for="password" class="form-label">Passwort</label>
                    <input id="password" name="password" type="password" class="form-input" placeholder="Passwort">
                    @error('password', 'userDeletion')
                        <div class="error-message">{{ $message }}</div>
                    @enderror
                </div>

                <div class="modal-actions">
                    <button type="button" class="secondary-button" onclick="document.getElementById('deleteModal').classList.remove('show')">
                        Abbrechen
                    </button>
                    <button type="submit" class="danger-button">
                        Konto löschen
                    </button>
                </div>
            </form>
        </div>
    </div>

    @if($errors->userDeletion->isNotEmpty())
        <script>
            document.getElementById('deleteModal').classList.add('show');
        </script>
    @endif
</section>
