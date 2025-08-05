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
        <label for="password" class="form-label">Password <span class="text-danger">*</span></label>
        <input type="password" name="password" class="form-control @error('password') is-invalid @enderror"
               id="password" required>
        @error('password')
        <div class="invalid-feedback">
            {{ $message }}
        </div>
        @enderror
        <div class="form-text">Password must be at least 8 characters long.</div>
    </div>
@endif

<div class="mb-3">
    <label for="role" class="form-label">Role</label>
    <select name="role" class="form-control @error('role') is-invalid @enderror"
           id="role" required onchange="toggleRestaurantField()">
        <option value="">Select Role</option>
        @foreach(\App\Http\Constants\UserRoleConstant::LIST as $roleKey => $roleData)
            @if(auth()->user()->isAdmin() || in_array($roleKey, ['restaurant_user', 'delivery_staff']))
            <option value="{{ $roleKey }}"
                    {{ old('role', optional($user)->role) == $roleKey ? 'selected' : '' }}>
                {{ $roleData['label'] }}
            </option>
            @endif
        @endforeach
    </select>
    @error('role')
    <div class="invalid-feedback">
        {{ $message }}
    </div>
    @enderror
</div>

@if(auth()->user()->isAdmin())
<div class="mb-3" id="restaurant-field" style="display: none;">
    <label for="restaurant_id" class="form-label">Restaurant</label>
    <select name="restaurant_id" class="form-control @error('restaurant_id') is-invalid @enderror"
           id="restaurant_id">
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
@endif

<script>
function toggleRestaurantField() {
    const roleSelect = document.getElementById('role');
    const restaurantField = document.getElementById('restaurant-field');
    const restaurantSelect = document.getElementById('restaurant_id');

    if (roleSelect.value === 'restaurant_user' || roleSelect.value === 'delivery_staff') {
        restaurantField.style.display = 'block';
        restaurantSelect.required = true;
    } else {
        restaurantField.style.display = 'none';
        restaurantSelect.required = false;
        restaurantSelect.value = '';
    }
}

// Call on page load to set initial state
document.addEventListener('DOMContentLoaded', function() {
    toggleRestaurantField();
});
</script>
