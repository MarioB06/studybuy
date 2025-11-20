<x-app-layout>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    <style>
        .admin-container { max-width: 1200px; margin: 40px auto; padding: 0 40px; }
        .page-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 30px; }
        .page-title { font-size: 32px; font-weight: 600; color: #000; }
        .btn { padding: 12px 24px; border-radius: 8px; font-weight: 600; text-decoration: none; border: none; cursor: pointer; display: inline-block; }
        .btn-primary { background: #1aa8ba; color: white; }
        .btn-primary:hover { background: #158a99; }
        .table-card { background: white; border-radius: 12px; padding: 30px; box-shadow: 0 2px 8px rgba(0,0,0,0.08); }
        table { width: 100%; border-collapse: collapse; }
        th { background: #f8f9fa; padding: 15px; text-align: left; font-weight: 600; border-bottom: 2px solid #e0e0e0; }
        td { padding: 15px; border-bottom: 1px solid #f0f0f0; }
        .actions { display: flex; gap: 10px; }
        .btn-sm { padding: 6px 12px; font-size: 14px; }
        .btn-warning { background: #ffc107; color: #000; }
        .btn-danger { background: #e74c3c; color: white; }
        .alert { padding: 15px; border-radius: 8px; margin-bottom: 20px; }
        .alert-success { background: #d4edda; color: #155724; }
        .alert-error { background: #f8d7da; color: #721c24; }
    </style>

    <div class="admin-container">
        <div class="page-header">
            <h1 class="page-title">Kategorien verwalten</h1>
            <a href="{{ route('admin.categories.create') }}" class="btn btn-primary">Neue Kategorie</a>
        </div>

        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif
        @if(session('error'))
            <div class="alert alert-error">{{ session('error') }}</div>
        @endif

        <div class="table-card">
            <table>
                <thead>
                    <tr>
                        <th>Icon</th>
                        <th>Name</th>
                        <th>Produkte</th>
                        <th>Erstellt</th>
                        <th>Aktionen</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($categories as $category)
                        <tr>
                            <td><i class="{{ $category->icon ?? 'fas fa-box' }}"></i></td>
                            <td>{{ $category->name }}</td>
                            <td>{{ $category->products_count }}</td>
                            <td>{{ $category->created_at->format('d.m.Y') }}</td>
                            <td>
                                <div class="actions">
                                    <a href="{{ route('admin.categories.edit', $category) }}" class="btn btn-sm btn-warning">Bearbeiten</a>
                                    <form method="POST" action="{{ route('admin.categories.destroy', $category) }}" onsubmit="return confirm('Sicher löschen?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger">Löschen</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="5" style="text-align: center; color: #999;">Keine Kategorien vorhanden</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</x-app-layout>
