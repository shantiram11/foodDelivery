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

        <div class="row">
            <div class="col-md-6">
                <div class="mb-3">
                    <label for="category" class="form-label">Category <span class="text-danger">*</span></label>
                    <select class="form-select @error('category') is-invalid @enderror" id="category" name="category" required>
                        <option value="">Select Category</option>
                        <option value="Fast Food" {{ old('category', $restaurant->category ?? '') == 'Fast Food' ? 'selected' : '' }}>Fast Food</option>
                        <option value="Fine Dining" {{ old('category', $restaurant->category ?? '') == 'Fine Dining' ? 'selected' : '' }}>Fine Dining</option>
                        <option value="Casual Dining" {{ old('category', $restaurant->category ?? '') == 'Casual Dining' ? 'selected' : '' }}>Casual Dining</option>
                        <option value="Cafe" {{ old('category', $restaurant->category ?? '') == 'Cafe' ? 'selected' : '' }}>Cafe</option>
                        <option value="Pizza" {{ old('category', $restaurant->category ?? '') == 'Pizza' ? 'selected' : '' }}>Pizza</option>
                        <option value="Asian" {{ old('category', $restaurant->category ?? '') == 'Asian' ? 'selected' : '' }}>Asian</option>
                        <option value="Italian" {{ old('category', $restaurant->category ?? '') == 'Italian' ? 'selected' : '' }}>Italian</option>
                        <option value="Mexican" {{ old('category', $restaurant->category ?? '') == 'Mexican' ? 'selected' : '' }}>Mexican</option>
                    </select>
                    @error('category')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>
            <div class="col-md-6">
                <div class="mb-3">
                    <label for="rating" class="form-label">Rating (1-5)</label>
                    <input type="number" class="form-control @error('rating') is-invalid @enderror" id="rating" name="rating" 
                           min="1" max="5" step="0.1" value="{{ old('rating', $restaurant->rating ?? '') }}">
                    @error('rating')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>
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

        <div class="row">
            <div class="col-md-6">
                <div class="mb-3">
                    <label for="opening_time" class="form-label">Opening Time <span class="text-danger">*</span></label>
                    <input type="time" class="form-control @error('opening_time') is-invalid @enderror" id="opening_time" name="opening_time" 
                           value="{{ old('opening_time', isset($restaurant->opening_time) ? $restaurant->opening_time->format('H:i') : '') }}" required>
                    @error('opening_time')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>
            <div class="col-md-6">
                <div class="mb-3">
                    <label for="closing_time" class="form-label">Closing Time <span class="text-danger">*</span></label>
                    <input type="time" class="form-control @error('closing_time') is-invalid @enderror" id="closing_time" name="closing_time" 
                           value="{{ old('closing_time', isset($restaurant->closing_time) ? $restaurant->closing_time->format('H:i') : '') }}" required>
                    @error('closing_time')
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