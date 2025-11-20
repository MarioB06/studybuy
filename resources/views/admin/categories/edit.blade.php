<x-app-layout>
    <style>.admin-container{max-width:800px;margin:40px auto;padding:0 40px}.form-card{background:#fff;border-radius:12px;padding:40px;box-shadow:0 2px 8px rgba(0,0,0,.08)}.form-group{margin-bottom:20px}.form-label{display:block;font-size:15px;font-weight:600;margin-bottom:8px}.form-input{width:100%;padding:12px 15px;border:1px solid #e0e0e0;border-radius:8px;font-size:15px}.btn{padding:12px 24px;border-radius:8px;font-weight:600;border:none;cursor:pointer}.btn-primary{background:#1aa8ba;color:#fff}</style>
    <div class="admin-container">
        <h1 style="font-size:32px;font-weight:600;margin-bottom:30px">Kategorie bearbeiten</h1>
        <div class="form-card">
            <form method="POST" action="{{ route('admin.categories.update', $category) }}">
                @csrf
                @method('PUT')
                <div class="form-group">
                    <label class="form-label">Name*</label>
                    <input type="text" name="name" class="form-input" value="{{ old('name', $category->name) }}" required>
                    @error('name')<div style="color:#e74c3c;font-size:14px;margin-top:5px">{{ $message }}</div>@enderror
                </div>
                <div class="form-group">
                    <label class="form-label">FontAwesome Icon</label>
                    <input type="text" name="icon" class="form-input" value="{{ old('icon', $category->icon) }}" placeholder="z.B. fas fa-laptop">
                    @error('icon')<div style="color:#e74c3c;font-size:14px;margin-top:5px">{{ $message }}</div>@enderror
                </div>
                <button type="submit" class="btn btn-primary">Aktualisieren</button>
            </form>
        </div>
    </div>
</x-app-layout>
