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
          <a href="#"
             class="menu-details-link"
             role="button"
             data-menu-id="{{ $menu->id }}"
             data-restaurant-id="{{ $menu->restaurant->id }}"
             data-menu-name="{{ $menu->name }}"
             data-menu-price="{{ number_format($menu->price, 2) }}"
             data-menu-description="{{ e($menu->description) }}"
             data-restaurant-name="{{ $menu->restaurant->name }}"
             data-image-url="{{ asset('uploads/menus/' . $menu->image) }}"
          >{{ $menu->name }}</a><span>RS.{{ number_format($menu->price, 2) }}</span>
        </div>
        <div class="menu-ingredients menu-listing-desc">
          {{ \Illuminate\Support\Str::limit($menu->description, 140) }}
        </div>
        <div class="menu-ingredients text-white">
          <small class="text-white">{{$menu->restaurant->name }} Restaurant</small>
        </div>
        <div class="menu-action">
          <button class="add-to-cart-btn" data-menu-id="{{ $menu->id }}" data-restaurant-id="{{ $menu->restaurant->id }}">Add to Cart</button>
          <button class="buy-now-btn" data-menu-id="{{ $menu->id }}" data-restaurant-id="{{ $menu->restaurant->id }}">Buy Now</button>
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

.buy-now-btn {
  background-color: #0d6efd;
  color: #fff;
  border: none;
  padding: 0.5rem 1.5rem;
  border-radius: 25px;
  font-size: 0.9rem;
  cursor: pointer;
  transition: all 0.3s ease;
  margin-left: 0.5rem;
}
.buy-now-btn:hover {
  background-color: #0b5ed7;
  transform: translateY(-2px);
}

/* Short description styling in listing */
.menu-listing-desc {
  color: #9ca3af;
  font-size: 0.95rem;
  margin-top: 0.25rem;
}

/* Consistent thumbnails for menu listing */
.isotope-container .menu-item .menu-img {
  width: 74px;
  height: 74px;
  object-fit: cover;
  border-radius: 50%;
  display: block;
  border: 2px solid rgba(255,255,255,0.08);
}
@media (max-width: 576px) {
  .isotope-container .menu-item .menu-img {
    width: 72px;
    height: 72px;
  }
}

/* Menu details modal */
.menu-modal-overlay {
  position: fixed;
  inset: 0;
  background: rgba(0,0,0,0.6);
  display: none;
  align-items: center;
  justify-content: center;
  z-index: 1050;
  padding: 1rem;
}
.menu-modal-overlay.active {
  display: flex;
}
.menu-modal {
  background: #111827;
  color: #e5e7eb;
  border-radius: 12px;
  max-width: 880px;
  width: 100%;
  overflow: hidden;
  box-shadow: 0 20px 50px rgba(0,0,0,0.45);
}
.menu-modal-header {
  display: flex;
  align-items: center;
  justify-content: space-between;
  padding: 1rem 1.25rem;
  border-bottom: 1px solid rgba(255,255,255,0.08);
}
.menu-modal-title {
  margin: 0;
  font-size: 1.35rem;
  font-weight: 700;
  color: #f3f4f6;
}
.menu-modal-close {
  background: transparent;
  border: none;
  color: #e5e7eb;
  font-size: 1.25rem;
  line-height: 1;
  cursor: pointer;
}
.price-badge {
  display: inline-flex;
  align-items: center;
  background: #059669;
  color: #fff;
  padding: 0.25rem 0.6rem;
  border-radius: 999px;
  font-size: 0.85rem;
  font-weight: 600;
}
.menu-modal-body {
  display: grid;
  grid-template-columns: 240px 1fr;
  gap: 1rem;
  padding: 1rem 1.25rem 1.25rem;
}
@media (max-width: 768px) {
  .menu-modal-body {
    grid-template-columns: 1fr;
  }
}
.menu-modal-image {
  width: 100%;
  height: 220px;
  object-fit: cover;
  border-radius: 8px;
  border: 1px solid rgba(255,255,255,0.08);
}
.menu-modal-meta {
  margin: 0 0 0.25rem;
  color: #9ca3af;
}
.menu-modal-price {
  font-weight: 600;
  margin-bottom: 0.5rem;
}
.menu-modal-description {
  white-space: pre-wrap;
  line-height: 1.6;
  max-height: 260px;
  overflow: auto;
}
.menu-modal-description-heading {
  font-weight: 600;
  color: #e5e7eb;
  margin: 0.25rem 0 0.25rem;
}
.modal-actions {
  margin-top: 1rem;
  display: flex;
  gap: 0.5rem;
}
.rating {
  display: inline-flex;
  align-items: center;
  gap: 4px;
  color: #fbbf24; /* amber-400 */
  margin: 0.25rem 0 0.75rem;
}
.rating .score {
  color: #e5e7eb;
  font-weight: 600;
  margin-left: 6px;
}
</style>

<!-- Menu Details Modal -->
<div class="menu-modal-overlay" id="menuModal" aria-hidden="true">
  <div class="menu-modal" role="dialog" aria-modal="true" aria-labelledby="menuModalTitle">
    <div class="menu-modal-header">
      <h3 class="menu-modal-title" id="menuModalTitle">Menu Item</h3>
      <div style="display:flex;align-items:center;gap:.5rem;">
        <span class="price-badge" id="menuModalPriceHeader"></span>
        <button class="menu-modal-close" type="button" aria-label="Close" id="menuModalClose">
          <i class="bi bi-x-lg"></i>
        </button>
      </div>
    </div>
    <div class="menu-modal-body">
      <img src="" alt="Menu image" class="menu-modal-image" id="menuModalImage">
      <div>
        <p class="menu-modal-meta" id="menuModalRestaurant">Restaurant</p>
        <div class="rating" id="menuModalRating" aria-label="Rating">
          <span class="stars" aria-hidden="true">★★★★★</span>
          <span class="score">5.0</span>
        </div>
        <div class="menu-modal-price" id="menuModalPrice"></div>
        <div class="menu-modal-description-heading">Description</div>
        <div class="menu-modal-description" id="menuModalDescription"></div>
        <div class="modal-actions">
          <button class="modal-add-to-cart add-to-cart-btn" data-menu-id="" data-restaurant-id="">Add to Cart</button>
          <button class="modal-buy-now buy-now-btn" data-menu-id="" data-restaurant-id="">Buy Now</button>
        </div>
      </div>
    </div>
  </div>
  <!-- clicking outside modal content should close -->
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const csrfToken = document.querySelector('meta[name="csrf-token"]')?.content;
    const isAuthenticated = @json(auth()->check());

    // Enhanced event delegation for add to cart buttons
    document.addEventListener('click', function(e) {
        // Open menu details modal when menu name is clicked
        const detailsLink = e.target.closest('.menu-details-link');
        if (detailsLink) {
            e.preventDefault();
            e.stopPropagation();

            const name = detailsLink.dataset.menuName || '';
            const price = detailsLink.dataset.menuPrice || '';
            const description = detailsLink.dataset.menuDescription || '';
            const restaurant = detailsLink.dataset.restaurantName || '';
            const imageUrl = detailsLink.dataset.imageUrl || '';

            const overlay = document.getElementById('menuModal');
            if (!overlay) return;

            // Populate
            document.getElementById('menuModalTitle').textContent = name;
            document.getElementById('menuModalRestaurant').textContent = restaurant ? `${restaurant} Restaurant` : '';
            const priceText = price ? `RS. ${price}` : '';
            document.getElementById('menuModalPrice').textContent = priceText;
            const priceHeader = document.getElementById('menuModalPriceHeader');
            priceHeader.textContent = priceText;
            document.getElementById('menuModalDescription').textContent = description || '';
            const imgEl = document.getElementById('menuModalImage');
            imgEl.src = imageUrl;
            imgEl.alt = name;
            imgEl.onerror = function() {
              this.onerror = null;
              this.src = "{{ asset('frontend/img/menu/cake.jpg') }}";
            };

            // Generate a random rating between 4.0 and 5.0 (step 0.1)
            const ratingValue = (Math.round((Math.random() * 1 + 4) * 10) / 10).toFixed(1);
            const ratingEl = document.getElementById('menuModalRating');
            if (ratingEl) {
              const starsContainer = ratingEl.querySelector('.stars');
              const scoreContainer = ratingEl.querySelector('.score');
              const fullStars = Math.floor(ratingValue);
              const half = ratingValue - fullStars >= 0.5;
              let stars = '';
              for (let i = 0; i < 5; i++) {
                if (i < fullStars) stars += '★';
                else stars += '☆';
              }
              starsContainer.textContent = stars;
              scoreContainer.textContent = ratingValue;
            }

            // Wire modal action buttons with current ids
            const modalAdd = document.querySelector('.modal-add-to-cart');
            const modalBuy = document.querySelector('.modal-buy-now');
            if (modalAdd) {
              modalAdd.dataset.menuId = detailsLink.dataset.menuId || '';
              modalAdd.dataset.restaurantId = detailsLink.dataset.restaurantId || '';
            }
            if (modalBuy) {
              modalBuy.dataset.menuId = detailsLink.dataset.menuId || '';
              modalBuy.dataset.restaurantId = detailsLink.dataset.restaurantId || '';
            }

            // Show
            overlay.classList.add('active');
            overlay.setAttribute('aria-hidden', 'false');

            // Disable background scroll
            document.body.style.overflow = 'hidden';

            return;
        }

        // Check if clicked element or its parent is an add-to-cart button
        const btn = e.target.closest('.add-to-cart-btn');
        if (!btn) return;

        // Prevent all default behaviors and event bubbling
        e.preventDefault();
        e.stopPropagation();
        e.stopImmediatePropagation();

        if (!isAuthenticated) {
            window.location.href = '{{ route('login') }}';
            return;
        }

        const menuId = btn.dataset.menuId;
        if (!menuId) return;

        // Prevent multiple clicks
        if (btn.disabled) return;

        addToCart(btn, menuId);
    });

    // Event delegation for Buy Now buttons
    document.addEventListener('click', function(e) {
        // Close modal on overlay or close button click
        const overlay = document.getElementById('menuModal');
        if (overlay && overlay.classList.contains('active')) {
            const clickedClose = e.target.closest('#menuModalClose');
            const clickedOutside = e.target === overlay;
            if (clickedClose || clickedOutside) {
                overlay.classList.remove('active');
                overlay.setAttribute('aria-hidden', 'true');
                document.body.style.overflow = '';
                return;
            }
        }

        const buyBtn = e.target.closest('.buy-now-btn');
        if (!buyBtn) return;

        e.preventDefault();
        e.stopPropagation();
        e.stopImmediatePropagation();

        if (!isAuthenticated) {
            window.location.href = '{{ route('checkout') }}';
            return;
        }

        const menuId = buyBtn.dataset.menuId;
        if (!menuId) return;

        if (buyBtn.disabled) return;

        addToCart(buyBtn, menuId, true);
    });

    // Close modal on escape
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            const overlay = document.getElementById('menuModal');
            if (overlay && overlay.classList.contains('active')) {
                overlay.classList.remove('active');
                overlay.setAttribute('aria-hidden', 'true');
                document.body.style.overflow = '';
            }
        }
    });

    // Add to cart function
    async function addToCart(btn, menuId, proceedToCheckout = false) {
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

            // If backend redirected (e.g., to login), follow it
            if (response.redirected) {
                window.location.href = response.url;
                return;
            }

            if (!response.ok) {
                // If unauthorized or any failure, guide user
                if (response.status === 401 || response.status === 419) {
                    window.location.href = '{{ route('login') }}';
                    return;
                }
                showMessage('You need to login to add items to cart');
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

                if (proceedToCheckout) {
                    window.location.href = '{{ route('checkout') }}';
                    return;
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
                setTimeout(() => alert.remove(), 200);
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