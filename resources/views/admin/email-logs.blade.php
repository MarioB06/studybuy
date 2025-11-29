<x-app-layout>
    <style>
        .admin-container {
            max-width: 1400px;
            margin: 40px auto;
            padding: 0 40px;
        }

        .admin-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 40px;
        }

        .admin-title {
            font-size: 32px;
            font-weight: 600;
            color: #000;
        }

        .back-link {
            color: #1aa8ba;
            text-decoration: none;
            font-weight: 500;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .back-link:hover {
            text-decoration: underline;
        }

        .admin-section {
            background: white;
            border-radius: 12px;
            padding: 30px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.08);
            margin-bottom: 30px;
        }

        .section-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 25px;
        }

        .section-title {
            font-size: 24px;
            font-weight: 600;
            color: #000;
        }

        .clear-logs-btn {
            background: #dc3545;
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 8px;
            cursor: pointer;
            font-weight: 500;
            transition: background 0.2s;
        }

        .clear-logs-btn:hover {
            background: #c82333;
        }

        .email-list {
            display: flex;
            flex-direction: column;
            gap: 20px;
        }

        .email-card {
            border: 1px solid #e0e0e0;
            border-radius: 10px;
            padding: 20px;
            background: #f8f9fa;
            transition: box-shadow 0.2s;
        }

        .email-card:hover {
            box-shadow: 0 4px 12px rgba(0,0,0,0.1);
        }

        .email-header {
            display: grid;
            grid-template-columns: auto 1fr;
            gap: 15px;
            margin-bottom: 15px;
            padding-bottom: 15px;
            border-bottom: 1px solid #dee2e6;
        }

        .email-label {
            font-weight: 600;
            color: #333;
        }

        .email-value {
            color: #666;
            word-break: break-all;
        }

        .email-timestamp {
            color: #1aa8ba;
            font-size: 14px;
            font-weight: 500;
        }

        .email-content {
            background: white;
            border: 1px solid #dee2e6;
            border-radius: 8px;
            padding: 15px;
            max-height: 400px;
            overflow-y: auto;
            font-family: 'Courier New', monospace;
            font-size: 13px;
            white-space: pre-wrap;
            word-break: break-word;
            color: #333;
        }

        .toggle-content {
            color: #1aa8ba;
            cursor: pointer;
            font-weight: 500;
            margin-top: 10px;
            display: inline-block;
        }

        .toggle-content:hover {
            text-decoration: underline;
        }

        .empty-state {
            text-align: center;
            padding: 60px 20px;
            color: #666;
        }

        .empty-state-icon {
            font-size: 64px;
            margin-bottom: 20px;
            opacity: 0.5;
        }

        .empty-state-text {
            font-size: 18px;
            font-weight: 500;
        }

        .alert {
            padding: 15px 20px;
            border-radius: 8px;
            margin-bottom: 20px;
        }

        .alert-success {
            background: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }

        .info-box {
            background: #e3f6f8;
            border-left: 4px solid #1aa8ba;
            padding: 15px 20px;
            border-radius: 8px;
            margin-bottom: 25px;
        }

        .info-box-title {
            font-weight: 600;
            color: #000;
            margin-bottom: 8px;
        }

        .info-box-text {
            color: #333;
            font-size: 14px;
            line-height: 1.6;
        }

        @media (max-width: 768px) {
            .admin-container {
                padding: 0 20px;
            }

            .admin-header {
                flex-direction: column;
                gap: 15px;
                align-items: flex-start;
            }

            .section-header {
                flex-direction: column;
                gap: 15px;
                align-items: flex-start;
            }

            .email-header {
                grid-template-columns: 1fr;
            }
        }
    </style>

    <div class="admin-container">
        <div class="admin-header">
            <h1 class="admin-title">E-Mail Logs</h1>
            <a href="{{ route('admin.dashboard') }}" class="back-link">
                ← Zurück zum Dashboard
            </a>
        </div>

        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        <div class="info-box">
            <div class="info-box-title">📧 E-Mail Log Modus aktiv</div>
            <div class="info-box-text">
                Aktuell ist der E-Mail-Versand auf "log" gestellt. Alle E-Mails werden in diese Log-Datei geschrieben
                statt versendet. Dies ist nützlich für die Entwicklung. Um echte E-Mails zu versenden, stelle
                MAIL_MAILER in der .env-Datei auf "smtp" um.
            </div>
        </div>

        <div class="admin-section">
            <div class="section-header">
                <h2 class="section-title">Letzte E-Mails (max. 50)</h2>
                <form action="{{ route('admin.email-logs.clear') }}" method="POST"
                      onsubmit="return confirm('Sind Sie sicher, dass Sie alle E-Mail-Logs löschen möchten?');">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="clear-logs-btn">Logs löschen</button>
                </form>
            </div>

            @if(count($emails) > 0)
                <div class="email-list">
                    @foreach($emails as $index => $email)
                        <div class="email-card">
                            <div class="email-header">
                                <span class="email-label">Zeitstempel:</span>
                                <span class="email-timestamp">{{ $email['timestamp'] }}</span>

                                <span class="email-label">An:</span>
                                <span class="email-value">{{ $email['to'] ?: 'N/A' }}</span>

                                <span class="email-label">Betreff:</span>
                                <span class="email-value">{{ $email['subject'] ?: 'N/A' }}</span>
                            </div>

                            <details>
                                <summary class="toggle-content">Vollständigen Inhalt anzeigen</summary>
                                <div class="email-content">{{ $email['content'] }}</div>
                            </details>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="empty-state">
                    <div class="empty-state-icon">📭</div>
                    <div class="empty-state-text">Keine E-Mail-Logs gefunden</div>
                    <p style="color: #999; margin-top: 10px;">
                        Sende eine Test-E-Mail (z.B. Passwort zurücksetzen), um Einträge zu sehen.
                    </p>
                </div>
            @endif
        </div>
    </div>

    <script>
        // Auto-refresh every 10 seconds if user wants
        // Uncomment to enable
        // setTimeout(() => location.reload(), 10000);
    </script>
</x-app-layout>
