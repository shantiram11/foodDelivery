<div class="row">
    <div class="col-md-8">
        <div class="mb-3">
            <label for="name" class="form-label">Restaurant Name <span class="text-danger">*</span></label>
            <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" 
                   value="{{ old('name', $restaurant->name ?? '') }}" required>
            @error('name')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="description" class="form-label">Description <span class="text-danger">*</span></label>
            <textarea class="form-control @error('description') is-invalid @enderror" id="description" name="description" 
                      rows="4" required>{{ old('description', $restaurant->description ?? '') }}</textarea>
            @error('description')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="rating" class="form-label">Rating (1-5)</label>
            <input type="number" class="form-control @error('rating') is-invalid @enderror" id="rating" name="rating" 
                   min="1" max="5" step="0.1" value="{{ old('rating', $restaurant->rating ?? '') }}">
            @error('rating')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="address" class="form-label">Address <span class="text-danger">*</span></label>
            <textarea class="form-control @error('address') is-invalid @enderror" id="address" name="address" 
                      rows="3" required>{{ old('address', $restaurant->address ?? '') }}</textarea>
            @error('address')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="row">
            <div class="col-md-6">
                <div class="mb-3">
                    <label for="phone" class="form-label">Phone <span class="text-danger">*</span></label>
                    <input type="tel" class="form-control @error('phone') is-invalid @enderror" id="phone" name="phone" 
                           value="{{ old('phone', $restaurant->phone ?? '') }}" required>
                    @error('phone')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>
            <div class="col-md-6">
                <div class="mb-3">
                    <label for="email" class="form-label">Email <span class="text-danger">*</span></label>
                    <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" 
                           value="{{ old('email', $restaurant->email ?? '') }}" required>
                    @error('email')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>
        </div>


    </div>

    <div class="col-md-4">
        <div class="mb-3">
            <label for="image" class="form-label">Restaurant Image</label>
            <input type="file" class="form-control @error('image') is-invalid @enderror" id="image" name="image" accept="image/*">
            @error('image')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
            <div class="form-text">Upload restaurant image (JPG, PNG, GIF, max 2MB)</div>
        </div>

        @if(isset($restaurant) && $restaurant->image)
            <div class="mb-3">
                <label class="form-label">Current Image</label>
                <div class="mt-2">
                    <img src="{{ asset('uploads/restaurants/' . $restaurant->image) }}" alt="Restaurant Image" 
                         class="img-thumbnail" style="max-width: 200px;">
                </div>
            </div>
        @endif

        <div class="mb-3">
            <div class="form-check">
                <input class="form-check-input" type="checkbox" id="status" name="status" value="1" 
                       {{ old('status', $restaurant->status ?? 'active') == 'active' ? 'checked' : '' }}>
                <label class="form-check-label" for="status">
                    Active Status
                </label>
            </div>
            <div class="form-text">Check to make restaurant active</div>
        </div>
    </div>
</div> 