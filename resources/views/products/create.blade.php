<x-app-layout>
    <style>
        .product-create-container {
            max-width: 1200px;
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

        .image-upload-container {
            margin-bottom: 25px;
        }

        .image-previews {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(150px, 1fr));
            gap: 15px;
            margin-top: 15px;
        }

        .image-preview {
            position: relative;
            aspect-ratio: 1;
            border: 2px solid #e0e0e0;
            border-radius: 8px;
            overflow: hidden;
            background: #f5f5f5;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .image-preview img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .image-preview .remove-btn {
            position: absolute;
            top: 5px;
            right: 5px;
            background: rgba(231, 76, 60, 0.9);
            color: white;
            border: none;
            border-radius: 50%;
            width: 28px;
            height: 28px;
            cursor: pointer;
            font-size: 18px;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: background 0.2s;
        }

        .image-preview .remove-btn:hover {
            background: rgba(192, 57, 43, 1);
        }

        .image-preview .main-badge {
            position: absolute;
            bottom: 5px;
            left: 5px;
            background: rgba(26, 168, 186, 0.9);
            color: white;
            padding: 3px 8px;
            border-radius: 4px;
            font-size: 11px;
            font-weight: 600;
        }

        .add-image-btn {
            aspect-ratio: 1;
            border: 2px dashed #1aa8ba;
            border-radius: 8px;
            background: #f0f9fa;
            color: #1aa8ba;
            cursor: pointer;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            font-size: 14px;
            font-weight: 600;
            transition: all 0.2s;
        }

        .add-image-btn:hover {
            background: #e1f4f6;
            border-color: #158a99;
        }

        .add-image-btn svg {
            width: 40px;
            height: 40px;
            margin-bottom: 8px;
        }

        #images {
            display: none;
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
            <form method="POST" action="{{ route('products.store') }}" enctype="multipart/form-data">
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

                <div class="form-group">
                    <label class="form-label">
                        Produktfotos<span class="required">*</span>
                    </label>
                    <div class="form-help" style="margin-bottom: 15px;">
                        Laden Sie mindestens 1 und maximal 5 Fotos hoch. Das erste Foto wird als Hauptbild verwendet.
                    </div>
                    <input
                        type="file"
                        id="images"
                        name="images[]"
                        multiple
                        accept="image/jpeg,image/jpg,image/png,image/webp,image/heic"
                        required
                    >
                    <div class="image-previews" id="imagePreviews">
                        <label for="images" class="add-image-btn">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                            </svg>
                            Fotos hinzufügen
                        </label>
                    </div>
                    @error('images')
                        <div class="error-message">{{ $message }}</div>
                    @enderror
                    @if($errors->has('images.0') || $errors->has('images.1') || $errors->has('images.2') || $errors->has('images.3') || $errors->has('images.4'))
                        @foreach($errors->get('images.*') as $messages)
                            @foreach($messages as $message)
                                <div class="error-message">{{ $message }}</div>
                            @endforeach
                        @endforeach
                    @endif
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

    <script>
        const MAX_IMAGES = 5;

        const imageInput = document.getElementById('images');
        const previewContainer = document.getElementById('imagePreviews');
        const addButton = previewContainer.querySelector('.add-image-btn');

        imageInput.addEventListener('change', function(e) {
            const files = Array.from(e.target.files);

            // Check if files exceed the limit
            if (files.length > MAX_IMAGES) {
                alert(`Sie können maximal ${MAX_IMAGES} Fotos hochladen.`);
                imageInput.value = '';
                return;
            }

            if (files.length > 0) {
                updatePreviews(files);
            }
        });

        function updatePreviews(files) {
            // Remove all previews but keep the add button
            const previews = previewContainer.querySelectorAll('.image-preview');
            previews.forEach(preview => preview.remove());

            // Add previews for each selected file
            files.forEach((file, index) => {
                const reader = new FileReader();

                reader.onload = function(e) {
                    const previewDiv = document.createElement('div');
                    previewDiv.className = 'image-preview';

                    previewDiv.innerHTML = `
                        <img src="${e.target.result}" alt="Vorschau ${index + 1}">
                        ${index === 0 ? '<span class="main-badge">Hauptbild</span>' : ''}
                    `;

                    // Insert before the add button
                    previewContainer.insertBefore(previewDiv, addButton);
                };

                reader.readAsDataURL(file);
            });

            // Show or hide add button based on count
            if (files.length >= MAX_IMAGES) {
                addButton.style.display = 'none';
            } else {
                addButton.style.display = 'flex';
            }
        }
    </script>
</x-app-layout>
