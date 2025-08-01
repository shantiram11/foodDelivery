<!-- Menu Section -->
<section id="menu" class="menu section">

  <!-- Section Title -->
  <div class="container section-title" data-aos="fade-up">
    <h2>Our Menu</h2>
    <p>Discover Our Delicious Offerings</p>
  </div><!-- End Section Title -->

  <div class="container isotope-layout" data-default-filter="*" data-layout="masonry" data-sort="original-order">

    <div class="row" data-aos="fade-up" data-aos-delay="100">
      <div class="col-lg-12 d-flex justify-content-center">
        <ul class="menu-filters isotope-filters">
          <li data-filter="*" class="filter-active">All Restaurants</li>
          @foreach ($restaurants as $restaurant)
          <li data-filter=".filter-{{ $restaurant->id }}">{{ $restaurant->name }}</li>
          @endforeach
        </ul>
      </div>
    </div><!-- Restaurant Filters -->

    <div class="row isotope-container" data-aos="fade-up" data-aos-delay="200">

      <!-- Menu Items from All Restaurants -->
      @foreach ($menus as $menu)
      <div class="col-lg-6 menu-item isotope-item filter-{{ $menu->restaurant->id }}">
        <img src="{{ asset('uploads/menus/' . $menu->image) }}" class="menu-img" alt="{{ $menu->name }}">
        <div class="menu-content">
          <a href="#">{{ $menu->name }}</a><span>${{ number_format($menu->price, 2) }}</span>
        </div>
        <div class="menu-ingredients">
          {{ $menu->description }}
        </div>
        <div class="menu-ingredients text-white"
          <small class="text-white">{{$menu->restaurant->name }} Restaurant</small>
        </div>
        <div class="menu-action">
          <button class="add-to-cart-btn" data-menu-id="{{ $menu->id }}" data-restaurant-id="{{ $menu->restaurant->id }}">Add to Cart</button>
        </div>
      </div>
      @endforeach
    </div><!-- Menu Container -->

  </div>

</section><!-- /Menu Section -->

<style>
.section-title {
  text-align: left !important;
  padding-left: 1rem;
}
.section-title h2 {
  font-size: 1rem !important;
  letter-spacing: 2px !important;
  text-align: left !important;
}
.section-title p {
  font-size: 2.5rem !important;
  color: var(--accent-color) !important;
  text-align: left !important;
}
.menu-action {
  padding: 0.5rem 1rem;
  text-align: right;
}
.menu-restaurant {
  padding: 0.25rem 1rem;
  font-style: italic;
}
.menu-restaurant.hide-restaurant-info {
  display: none;
}
.add-to-cart-btn {
  background-color: var(--accent-color);
  color: var(--contrast-color);
  border: none;
  padding: 0.5rem 1.5rem;
  border-radius: 25px;
  font-size: 0.9rem;
  cursor: pointer;
  transition: all 0.3s ease;
}
.add-to-cart-btn:hover {
  background-color: color-mix(in srgb, var(--accent-color), transparent 20%);
  transform: translateY(-2px);
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const csrfToken = document.querySelector('meta[name="csrf-token"]')?.content;

    // Enhanced event delegation for add to cart buttons
    document.addEventListener('click', function(e) {
        // Check if clicked element or its parent is an add-to-cart button
        const btn = e.target.closest('.add-to-cart-btn');
        if (!btn) return;

        // Prevent all default behaviors and event bubbling
        e.preventDefault();
        e.stopPropagation();
        e.stopImmediatePropagation();

        const menuId = btn.dataset.menuId;
        if (!menuId) return;

        // Prevent multiple clicks
        if (btn.disabled) return;

        addToCart(btn, menuId);
    });

    // Add to cart function
    async function addToCart(btn, menuId) {
        const originalText = btn.textContent;
        const originalBg = btn.style.backgroundColor;

        // Show loading state immediately
        btn.textContent = 'Adding...';
        btn.disabled = true;
        btn.style.pointerEvents = 'none'; // Prevent any clicking
        btn.style.opacity = '0.7';

        try {
            const formData = new FormData();
            formData.append('menu_id', menuId);
            formData.append('quantity', 1);
            formData.append('_token', csrfToken);

            const response = await fetch('{{ route("cart.add") }}', {
                method: 'POST',
                body: formData,
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'application/json'
                }
            });

            if (!response.ok) {
                throw new Error(`HTTP error! status: ${response.status}`);
            }

            const data = await response.json();

            if (data.success) {
                // Success state
                btn.textContent = 'Added!';
                btn.style.backgroundColor = '#28a745';
                btn.style.color = '#fff';

                // Show success message
                showMessage(data.message || 'Item added to cart!', 'success');

                // Update cart counter in header
                updateHeaderCartCount(data.cart_count);

                // Refresh cart sidebar if it exists
                if (window.refreshCartSidebar) {
                    window.refreshCartSidebar();
                }

                // Reset button after delay
                setTimeout(() => {
                    btn.textContent = originalText;
                    btn.style.backgroundColor = originalBg;
                    btn.style.color = '';
                    btn.style.opacity = '';
                    btn.style.pointerEvents = '';
                    btn.disabled = false;
                }, 2000);
            } else {
                throw new Error(data.message || 'Failed to add item to cart');
            }
        } catch (error) {
            console.error('Add to cart error:', error);
            showMessage(error.message || 'Failed to add item to cart', 'error');

            // Reset button immediately on error
            btn.textContent = originalText;
            btn.style.backgroundColor = originalBg;
            btn.style.color = '';
            btn.style.opacity = '';
            btn.style.pointerEvents = '';
            btn.disabled = false;
        }
    }

    // Show message function
    function showMessage(message, type) {
        // Remove existing alerts
        const existingAlerts = document.querySelectorAll('.cart-alert');
        existingAlerts.forEach(alert => alert.remove());

        const alert = document.createElement('div');
        alert.className = `alert alert-${type === 'success' ? 'success' : 'danger'} position-fixed cart-alert`;
        alert.style.cssText = 'top:100px;right:20px;z-index:9999;min-width:250px;box-shadow:0 4px 12px rgba(0,0,0,0.15);';
        alert.innerHTML = `<i class="bi bi-${type === 'success' ? 'check-circle' : 'x-circle'} me-2"></i>${message}`;

        document.body.appendChild(alert);

        // Auto remove after 3 seconds
        setTimeout(() => {
            if (alert.parentNode) {
                alert.style.opacity = '0';
                setTimeout(() => alert.remove(), 300);
            }
        }, 3000);
    }

    // Update header cart count
    function updateHeaderCartCount(count) {
        const cartCountElements = document.querySelectorAll('.cart-count, .cart-counter, .cart-badge');
        cartCountElements.forEach(element => {
            if (element) {
                element.textContent = count || 0;
                element.style.display = (count && count > 0) ? 'flex' : 'none';
            }
        });

        // Dispatch custom event for other components
        window.dispatchEvent(new CustomEvent('cartCountUpdated', {
            detail: { count: count || 0 }
        }));
    }

    // Global function for other scripts to update cart count
    window.updateCartCount = updateHeaderCartCount;
});
</script>