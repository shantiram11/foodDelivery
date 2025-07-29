<div class="row">
    <div class="col-md-8">
        <div class="mb-3">
            <label for="name" class="form-label">Menu Name <span class="text-danger">*</span></label>
            <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" 
                   value="{{ old('name', $menu->name ?? '') }}" required>
            @error('name')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="description" class="form-label">Description</label>
            <textarea class="form-control @error('description') is-invalid @enderror" id="description" name="description" 
                      rows="4">{{ old('description', $menu->description ?? '') }}</textarea>
            @error('description')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="price" class="form-label">Price <span class="text-danger">*</span></label>
            <div class="input-group">
                <span class="input-group-text">$</span>
                <input type="number" class="form-control @error('price') is-invalid @enderror" id="price" name="price" 
                       min="0" step="0.01" value="{{ old('price', $menu->price ?? '') }}" required>
            </div>
            @error('price')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
    </div>

    <div class="col-md-4">
        <div class="mb-3">
            <label for="image" class="form-label">Menu Image</label>
            <input type="file" class="form-control @error('image') is-invalid @enderror" id="image" name="image" accept="image/*">
            @error('image')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
            <div class="form-text">Upload menu image (JPG, PNG, GIF, max 2MB)</div>
        </div>

        @if(isset($menu) && $menu->image)
            <div class="mb-3">
                <label class="form-label">Current Image</label>
                <div class="mt-2">
                    <img src="{{ asset('uploads/menus/' . $menu->image) }}" alt="Menu Image" 
                         class="img-thumbnail" style="max-width: 200px;">
                </div>
            </div>
        @endif
    </div>
</div> 