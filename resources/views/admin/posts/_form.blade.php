<form method="POST"
      action="{{ isset($post) ? route('admin.posts.update', $post) : route('admin.posts.store') }}"
      enctype="multipart/form-data" novalidate>
    @csrf
    @isset($post)
        @method('PUT')
    @endisset

    <div class="row g-3">
        <div class="col-12">
            <div class="d-flex flex-wrap align-items-center justify-content-between gap-3 border rounded-3 p-3 bg-light">
                <div>
                    <span class="fw-semibold d-block"><i class="bi bi-eye text-primary me-1"></i>Estado de publicación</span>
                    <span class="text-muted small">Activala para mostrar la entrada en el blog público; desactivala para dejarla como borrador.</span>
                </div>
                <div class="form-check form-switch fs-3 m-0">
                    <input type="hidden" name="is_active" value="0">
                    <input type="checkbox" id="is_active" name="is_active" value="1" role="switch"
                           class="form-check-input" @checked(old('is_active', $post->is_active ?? true))>
                    <label for="is_active" class="form-check-label visually-hidden">Publicada (visible en el blog)</label>
                </div>
            </div>
        </div>

        <div class="col-md-8">
            <label for="title" class="form-label">Título</label>
            <input type="text" id="title" name="title"
                   class="form-control @error('title') is-invalid @enderror"
                   value="{{ old('title', $post->title ?? '') }}" required>
            @error('title') <span class="invalid-feedback d-block">{{ $message }}</span> @enderror
        </div>

        <div class="col-md-4">
            <label for="slug" class="form-label">Slug</label>
            <input type="text" id="slug" name="slug"
                   class="form-control @error('slug') is-invalid @enderror"
                   value="{{ old('slug', $post->slug ?? '') }}" required>
            @error('slug') <span class="invalid-feedback d-block">{{ $message }}</span> @enderror
        </div>

        <div class="col-md-6">
            <label for="category_id" class="form-label">Categoría</label>
            <select id="category_id" name="category_id"
                    class="form-select @error('category_id') is-invalid @enderror" required>
                <option value="">Elegí una categoría</option>
                @foreach ($categories as $category)
                    <option value="{{ $category->id }}" @selected(old('category_id', $post->category_id ?? '') == $category->id)>
                        {{ $category->name }}
                    </option>
                @endforeach
            </select>
            @error('category_id') <span class="invalid-feedback d-block">{{ $message }}</span> @enderror
        </div>

        <div class="col-md-6">
            <label for="tags" class="form-label">Etiquetas</label>
            @php($selectedTags = $errors->any() ? old('tags', []) : (isset($post) ? $post->tags->pluck('id')->all() : []))
            <select id="tags" name="tags[]" multiple size="4"
                    class="form-select @error('tags.*') is-invalid @enderror">
                @foreach ($tags as $tag)
                    <option value="{{ $tag->id }}" @selected(in_array($tag->id, $selectedTags))>{{ $tag->name }}</option>
                @endforeach
            </select>
            <span class="form-text">Mantené Ctrl (Cmd en Mac) para elegir varias.</span>
            @error('tags.*') <span class="invalid-feedback d-block">{{ $message }}</span> @enderror
        </div>

        <div class="col-12">
            <label for="excerpt" class="form-label">Extracto</label>
            <textarea id="excerpt" name="excerpt" rows="2"
                      class="form-control @error('excerpt') is-invalid @enderror" required>{{ old('excerpt', $post->excerpt ?? '') }}</textarea>
            @error('excerpt') <span class="invalid-feedback d-block">{{ $message }}</span> @enderror
        </div>

        <div class="col-12">
            <label for="content" class="form-label">Contenido</label>
            <textarea id="content" name="content" rows="8"
                      class="form-control @error('content') is-invalid @enderror" required>{{ old('content', $post->content ?? '') }}</textarea>
            @error('content') <span class="invalid-feedback d-block">{{ $message }}</span> @enderror
        </div>

        <div class="col-12">
            <label for="image" class="form-label">
                Imagen
                @isset($post)<span class="text-muted fw-normal">(opcional — dejá vacío para conservar la actual)</span>@endisset
            </label>
            <input type="file" id="image" name="image" accept="image/*"
                   class="form-control @error('image') is-invalid @enderror">
            @error('image') <span class="invalid-feedback d-block">{{ $message }}</span> @enderror
            <img id="image-preview" src="{{ $post->image_url ?? '' }}" alt="Vista previa de la imagen"
                 class="img-thumbnail mt-2 {{ (isset($post) && $post->image_url) ? '' : 'd-none' }}"
                 style="max-height: 160px;">
        </div>
    </div>

    <div class="mt-4 d-flex gap-2">
        <button type="submit" class="btn btn-primary">
            {{ isset($post) ? 'Guardar cambios' : 'Crear entrada' }}
        </button>
        <a href="{{ route('admin.posts.index') }}" class="btn btn-outline-secondary">Cancelar</a>
    </div>
</form>

<script>
    (function () {
        const input = document.getElementById('image');
        const preview = document.getElementById('image-preview');
        if (!input || !preview) return;
        input.addEventListener('change', function () {
            const file = input.files[0];
            if (!file) return;
            preview.src = URL.createObjectURL(file);
            preview.classList.remove('d-none');
        });
    })();
</script>
