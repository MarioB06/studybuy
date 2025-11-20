<x-app-layout>
    <style>
        .product-create-container {
            max-width: 800px;
            margin: 40px auto;
            padding: 0 40px;
        }

        .page-title {
            font-size: 32px;
            font-weight: 600;
            color: #000;
            margin-bottom: 15px;
        }

        .page-subtitle {
            font-size: 16px;
            color: #666;
            margin-bottom: 40px;
        }

        .form-card {
            background: white;
            border-radius: 12px;
            padding: 40px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.08);
        }

        .form-group {
            margin-bottom: 25px;
        }

        .form-label {
            display: block;
            font-size: 15px;
            font-weight: 600;
            color: #333;
            margin-bottom: 10px;
        }

        .required {
            color: #e74c3c;
            margin-left: 3px;
        }

        .form-input,
        .form-select,
        .form-textarea {
            width: 100%;
            padding: 14px 16px;
            border: 1px solid #e0e0e0;
            border-radius: 8px;
            font-size: 15px;
            outline: none;
            transition: border-color 0.2s;
            font-family: inherit;
        }

        .form-input:focus,
        .form-select:focus,
        .form-textarea:focus {
            border-color: #1aa8ba;
        }

        .form-textarea {
            min-height: 120px;
            resize: vertical;
        }

        .form-help {
            font-size: 13px;
            color: #999;
            margin-top: 6px;
        }

        .error-message {
            color: #e74c3c;
            font-size: 14px;
            margin-top: 6px;
        }

        .form-actions {
            display: flex;
            gap: 15px;
            margin-top: 35px;
            padding-top: 25px;
            border-top: 1px solid #e0e0e0;
        }

        .submit-button {
            background: #1aa8ba;
            color: white;
            border: none;
            padding: 14px 35px;
            border-radius: 8px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            transition: background 0.2s;
        }

        .submit-button:hover {
            background: #158a99;
        }

        .cancel-button {
            background: #e0e0e0;
            color: #333;
            border: none;
            padding: 14px 35px;
            border-radius: 8px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            transition: background 0.2s;
            text-decoration: none;
            display: inline-block;
        }

        .cancel-button:hover {
            background: #d0d0d0;
        }

        .form-row {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
        }

        @media (max-width: 768px) {
            .product-create-container {
                padding: 0 20px;
            }

            .form-card {
                padding: 25px;
            }

            .form-row {
                grid-template-columns: 1fr;
            }

            .form-actions {
                flex-direction: column;
            }

            .submit-button,
            .cancel-button {
                width: 100%;
                text-align: center;
            }
        }
    </style>

    <div class="product-create-container">
        <h1 class="page-title">Produkt inserieren</h1>
        <p class="page-subtitle">Erstellen Sie ein neues Inserat für Ihr Studienobjekt</p>

        <div class="form-card">
            <form method="POST" action="{{ route('products.store') }}">
                @csrf

                <div class="form-group">
                    <label for="title" class="form-label">
                        Titel<span class="required">*</span>
                    </label>
                    <input
                        type="text"
                        id="title"
                        name="title"
                        class="form-input"
                        value="{{ old('title') }}"
                        placeholder="z.B. iPad Pro 11 Zoll"
                        required
                    >
                    @error('title')
                        <div class="error-message">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label for="product_category_id" class="form-label">
                            Kategorie<span class="required">*</span>
                        </label>
                        <select id="product_category_id" name="product_category_id" class="form-select" required>
                            <option value="">Kategorie wählen</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}" {{ old('product_category_id') == $category->id ? 'selected' : '' }}>
                                    {{ $category->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('product_category_id')
                            <div class="error-message">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="school_id" class="form-label">
                            Schule/Universitat<span class="required">*</span>
                        </label>
                        <select id="school_id" name="school_id" class="form-select" required>
                            <option value="">Schule wahlen</option>
                            @foreach($schools as $school)
                                <option value="{{ $school->id }}" {{ old('school_id') == $school->id ? 'selected' : '' }}>
                                    {{ $school->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('school_id')
                            <div class="error-message">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="form-group">
                    <label for="description" class="form-label">
                        Beschreibung
                    </label>
                    <textarea
                        id="description"
                        name="description"
                        class="form-textarea"
                        placeholder="Beschreiben Sie Ihr Produkt im Detail..."
                    >{{ old('description') }}</textarea>
                    <div class="form-help">Geben Sie Details zum Zustand, Alter und weiteren Eigenschaften an</div>
                    @error('description')
                        <div class="error-message">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label for="price" class="form-label">
                            Preis (CHF)<span class="required">*</span>
                        </label>
                        <input
                            type="number"
                            id="price"
                            name="price"
                            class="form-input"
                            value="{{ old('price') }}"
                            step="0.01"
                            min="0"
                            placeholder="z.B. 450.00"
                            required
                        >
                        @error('price')
                            <div class="error-message">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="expires_at" class="form-label">
                            Verfügbar bis
                        </label>
                        <input
                            type="date"
                            id="expires_at"
                            name="expires_at"
                            class="form-input"
                            value="{{ old('expires_at') }}"
                        >
                        <div class="form-help">Optional: Wann soll das Inserat ablaufen?</div>
                        @error('expires_at')
                            <div class="error-message">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="form-actions">
                    <button type="submit" class="submit-button">
                        Produkt veröffentlichen
                    </button>
                    <a href="{{ route('dashboard') }}" class="cancel-button">
                        Abbrechen
                    </a>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
