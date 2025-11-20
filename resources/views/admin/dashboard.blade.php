<x-app-layout>
    <style>
        .admin-container {
            max-width: 1200px;
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

        .admin-badge {
            background: #1aa8ba;
            color: white;
            padding: 8px 16px;
            border-radius: 6px;
            font-size: 14px;
            font-weight: 500;
        }

        .stats-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 25px;
            margin-bottom: 40px;
        }

        .stat-card {
            background: white;
            border-radius: 12px;
            padding: 30px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.08);
            transition: transform 0.2s, box-shadow 0.2s;
        }

        .stat-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 4px 12px rgba(0,0,0,0.15);
        }

        .stat-icon {
            width: 60px;
            height: 60px;
            background: #f0f0f0;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 30px;
            margin-bottom: 20px;
        }

        .stat-card.primary .stat-icon {
            background: #e3f6f8;
        }

        .stat-card.success .stat-icon {
            background: #d4edda;
        }

        .stat-card.warning .stat-icon {
            background: #fff3cd;
        }

        .stat-value {
            font-size: 36px;
            font-weight: 700;
            color: #000;
            margin-bottom: 8px;
        }

        .stat-label {
            font-size: 15px;
            color: #666;
            font-weight: 500;
        }

        .admin-section {
            background: white;
            border-radius: 12px;
            padding: 30px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.08);
            margin-bottom: 30px;
        }

        .section-title {
            font-size: 24px;
            font-weight: 600;
            color: #000;
            margin-bottom: 20px;
        }

        .quick-actions {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 20px;
        }

        .action-button {
            background: #f8f9fa;
            border: 1px solid #e0e0e0;
            border-radius: 12px;
            padding: 25px 20px;
            text-align: center;
            text-decoration: none;
            color: #333;
            transition: all 0.2s;
            cursor: pointer;
        }

        .action-button:hover {
            background: #1aa8ba;
            color: white;
            border-color: #1aa8ba;
            transform: translateY(-3px);
        }

        .action-icon {
            font-size: 32px;
            margin-bottom: 12px;
        }

        .action-label {
            font-size: 14px;
            font-weight: 500;
        }

        @media (max-width: 768px) {
            .admin-container {
                padding: 0 20px;
            }

            .stats-grid {
                grid-template-columns: 1fr;
            }

            .quick-actions {
                grid-template-columns: repeat(2, 1fr);
            }

            .admin-header {
                flex-direction: column;
                gap: 15px;
                align-items: flex-start;
            }
        }
    </style>

    <div class="admin-container">
        <div class="admin-header">
            <h1 class="admin-title">Admin Dashboard</h1>
            <span class="admin-badge">Admin-Bereich</span>
        </div>

        <div class="stats-grid">
            <div class="stat-card primary">
                <div class="stat-icon">=e</div>
                <div class="stat-value">{{ $totalUsers }}</div>
                <div class="stat-label">Gesamte Benutzer</div>
            </div>

            <div class="stat-card success">
                <div class="stat-icon">P</div>
                <div class="stat-value">{{ $adminUsers }}</div>
                <div class="stat-label">Administratoren</div>
            </div>

            <div class="stat-card warning">
                <div class="stat-icon">=d</div>
                <div class="stat-value">{{ $regularUsers }}</div>
                <div class="stat-label">Normale Benutzer</div>
            </div>
        </div>

        <div class="admin-section">
            <h2 class="section-title">Schnellzugriff</h2>
            <div class="quick-actions">
                <a href="{{ route('admin.categories.index') }}" class="action-button">
                    <div class="action-icon">=e</div>
                    <div class="action-label">Kategorien verwalten</div>
                </a>
                <a href="{{ route('admin.schools.index') }}" class="action-button">
                    <div class="action-icon">=�</div>
                    <div class="action-label">Schulen verwalten</div>
                </a>
                <a href="#" class="action-button">
                    <div class="action-icon">=�</div>
                    <div class="action-label">Statistiken</div>
                </a>
                <a href="#" class="action-button">
                    <div class="action-icon">�</div>
                    <div class="action-label">Einstellungen</div>
                </a>
            </div>
        </div>

        <div class="admin-section">
            <h2 class="section-title">Willkommen im Admin-Bereich</h2>
            <p style="color: #666; line-height: 1.6;">
                Hier k�nnen Sie alle wichtigen Funktionen der StudyBuy-Plattform verwalten.
                Nutzen Sie die Schnellzugriff-Buttons oben, um direkt zu den wichtigsten Bereichen zu gelangen.
            </p>
        </div>
    </div>
</x-app-layout>
