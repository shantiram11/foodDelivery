@if($errors->any())
    {{ implode('', $errors->all('<div>:message</div>')) }}
@endif


<div class="mb-3">
    <label for="name" class="form-label">Name</label>
    <input type="text" name="name" class="form-control @error('name') is-invalid @enderror"
           id="name" value="{{ old('name', optional($user)->name) }}" required>
    @error('name')
    <div class="invalid-feedback">
        {{ $message }}
    </div>
    @enderror
</div>

<div class="mb-3">
    <label for="email" class="form-label">Email</label>
    <input type="email" name="email" class="form-control @error('email') is-invalid @enderror"
           id="email" value="{{ old('email', optional($user)->email) }}" required>
    @error('email')
    <div class="invalid-feedback">
        {{ $message }}
    </div>
    @enderror
</div>

@if(empty($user))
    <div class="mb-3">
        <label for="password" class="form-label">Password</label>
        <input type="password" name="password" class="form-control @error('password') is-invalid @enderror"
               id="password" required>
        @error('password')
        <div class="invalid-feedback">
            {{ $message }}
        </div>
        @enderror
    </div>
@else
    <div class="mb-3">
        <label for="password" class="form-label">Password (leave blank to keep current)</label>
        <input type="password" name="password" class="form-control @error('password') is-invalid @enderror"
               id="password">
        @error('password')
        <div class="invalid-feedback">
            {{ $message }}
        </div>
        @enderror
    </div>
@endif

<div class="mb-3">
    <label for="restaurant_id" class="form-label">Restaurant</label>
    <select name="restaurant_id" class="form-control @error('restaurant_id') is-invalid @enderror"
           id="restaurant_id" required>
        <option value="">Select Restaurant</option>
        @foreach($restaurants as $restaurant)
        <option value="{{ $restaurant->id }}" 
                {{ old('restaurant_id', optional($user)->restaurant_id) == $restaurant->id ? 'selected' : '' }}>
            {{ $restaurant->name }}
        </option>
        @endforeach
    </select>
    @error('restaurant_id')
    <div class="invalid-feedback">
        {{ $message }}
    </div>
    @enderror
</div>
