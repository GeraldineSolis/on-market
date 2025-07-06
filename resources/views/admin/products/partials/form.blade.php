<div class="row">
    <div class="col-md-6 mb-3">
        <label for="name" class="form-label">Nombre</label>
        <input type="text" name="name" class="form-control" value="{{ old('name', $product->name ?? '') }}" required>
    </div>

    <div class="col-md-6 mb-3">
        <label for="category" class="form-label">Categoría</label>
        <input type="text" name="category" class="form-control" value="{{ old('category', $product->category ?? '') }}" required>
    </div>

    <div class="col-md-12 mb-3">
        <label for="description" class="form-label">Descripción</label>
        <textarea name="description" class="form-control" rows="4" required>{{ old('description', $product->description ?? '') }}</textarea>
    </div>

    <div class="col-md-4 mb-3">
        <label for="price" class="form-label">Precio</label>
        <input type="number" name="price" class="form-control" step="0.01" value="{{ old('price', $product->price ?? '') }}" required>
    </div>

    <div class="col-md-4 mb-3">
        <label for="stock" class="form-label">Stock</label>
        <input type="number" name="stock" class="form-control" value="{{ old('stock', $product->stock ?? '') }}" required>
    </div>

    <div class="col-md-4 mb-3">
        <label for="active" class="form-label">Activo</label>
        <select name="active" class="form-select">
            <option value="1" {{ old('active', $product->active ?? 1) == 1 ? 'selected' : '' }}>Sí</option>
            <option value="0" {{ old('active', $product->active ?? 1) == 0 ? 'selected' : '' }}>No</option>
        </select>
    </div>

    <div class="col-md-6 mb-3">
        <label for="image" class="form-label">Imagen</label>
        <input type="file" name="image" class="form-control">
        @if(isset($product) && $product->image)
            <small class="text-muted d-block mt-2">Imagen actual: <br>
                <img src="{{ asset('images/' . $product->image) }}" width="100">
            </small>
        @endif
    </div>

    <div class="col-12">
        <button type="submit" class="btn btn-purple">{{ $buttonText }}</button>
        <a href="{{ route('admin.products') }}" class="btn btn-secondary">Cancelar</a>
    </div>
</div>
