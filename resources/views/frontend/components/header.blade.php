<header id="header" class="header fixed-top">
  <div class="branding d-flex align-items-center">
    <div class="container position-relative d-flex align-items-center justify-content-between">
      <!-- Logo -->
      <a href="{{ url('/') }}" class="logo d-flex align-items-center">
        <img src="{{ asset('frontend/img/logo.svg') }}" alt="Foodymat">
      </a>

      <!-- Main Navigation -->
      <nav id="navmenu" class="navmenu">
        <ul>
          <li><a href="{{ route('home') }}" class="{{ request()->routeIs('home') ? 'active' : '' }}">Home</a></li>
          <li><a href="{{ route('home') }}#about">About</a></li>
          <li><a href="{{ route('home') }}#order-online">Order Online</a></li>
          <li><a href="{{ route('home') }}#contact">Contact</a></li>
        </ul>
        <i class="mobile-nav-toggle d-xl-none bi bi-list"></i>
      </nav>

      <!-- Action Buttons -->
      <div class="header-actions d-none d-xl-flex align-items-center gap-3">
        <!-- Cart -->
        <button class="btn-book-a-table position-relative" type="button"
   data-bs-toggle="offcanvas" data-bs-target="#cartOffcanvas">
          <i class="bi bi-cart-check me-2"></i>
          Orders
          <span class="cart-count position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
            0
          </span>
        </button>

        <!-- Auth Buttons -->
        <div class="auth-buttons d-flex gap-2">
          @auth
            <!-- Profile Dropdown for Authenticated Users -->
            <div class="dropdown">
              <button class="btn-profile dropdown-toggle" type="button" id="profileDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                <i class="bi bi-person-circle me-2"></i>
                <span class="profile-name">{{ Auth::user()->name ?? 'Profile' }}</span>
              </button>
              <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="profileDropdown">
                <li>
                  <div class="dropdown-header">
                    <i class="bi bi-person-circle me-2"></i>
                    <div>
                      <div class="fw-semibold text-gray-800">{{ Auth::user()->name }}</div>
                      <small class="text-gray-500">{{ Auth::user()->email }}</small>
                    </div>
                  </div>
                </li>
                <li><hr class="dropdown-divider"></li>
                <li>
                  <a class="dropdown-item" href="{{ route('dashboard') }}">
                    <i class="bi bi-speedometer2"></i>Dashboard
                  </a>
                </li>
                <li>
                  <a class="dropdown-item" href="#">
                    <i class="bi bi-person"></i>My Profile
                  </a>
                </li>
                <li><hr class="dropdown-divider"></li>
                <li>
                  <a class="dropdown-item text-danger" href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                    <i class="bi bi-box-arrow-right"></i>Logout
                  </a>
                </li>
              </ul>
            </div>

            <!-- Hidden Logout Form -->
            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
              @csrf
            </form>
          @else
            <!-- Login/Signup for Guest Users -->
            <a class="btn-login" href="{{ route('login') }}">
              <i class="bi bi-person me-2"></i>Login
            </a>
            <a class="btn-signup" href="{{ route('register') }}">
              <i class="bi bi-person-plus me-2"></i>Signup
            </a>
          @endauth
        </div>
      </div>

    </div>
  </div>
</header>

<!-- Cart Offcanvas -->
<div class="offcanvas offcanvas-end cart-offcanvas" tabindex="-1" id="cartOffcanvas">
  <div class="offcanvas-body p-0">
    @include('frontend.components.sections.cart')
  </div>
</div>

<style>
/* Header Actions Styling */
.header-actions {
  margin-left: auto;
}

/* Base Button Styles */
.btn-clean,
.btn-book-a-table {
  height: 40px;
  padding: 0 1.25rem;
  display: inline-flex;
  align-items: center;
  justify-content: center;
  font-size: 1rem;
  font-weight: 500;
  border-radius: 20px;
  transition: all 0.3s ease;
  white-space: nowrap;
  border: 1.5px solid var(--accent-color);
}

.btn-clean {
  background: transparent;
  color: var(--default-color);
  min-width: 40px;
  padding: 0;
  border-radius: 50%;
}

.btn-clean i {
  font-size: 1.2rem;
}

.btn-clean:hover {
  background: var(--accent-color);
  color: var(--contrast-color);
  transform: translateY(-2px);
}

.btn-book-a-table {
  background: var(--accent-color);
  color: var(--contrast-color);
  min-width: 120px;
  padding: 0 1.5rem;
  font-weight: 600;
}

.btn-book-a-table:hover {
  background: color-mix(in srgb, var(--accent-color), transparent 20%);
  color: var(--contrast-color);
  transform: translateY(-2px);
  box-shadow: 0 4px 12px rgba(205, 164, 94, 0.3);
}

/* Cart Button Specific */
.cart-btn {
  position: relative;
}

.cart-count {
  position: absolute;
  top: -6px;
  right: -6px;
  background: var(--accent-color);
  color: var(--contrast-color);
  border-radius: 50%;
  width: 20px;
  height: 20px;
  font-size: 12px;
  display: flex;
  align-items: center;
  justify-content: center;
  border: 2px solid var(--background-color);
  font-weight: 600;
}

/* Cart Offcanvas Styling */
.cart-offcanvas {
  width: 400px;
  background: var(--background-color);
  border-left: 1px solid rgba(255,255,255,0.1);
}

.cart-offcanvas .offcanvas-body {
  overflow-x: hidden;
  padding: 0;
}

@media (max-width: 576px) {
  .cart-offcanvas {
    width: 100%;
  }
}

/* Responsive */
@media (max-width: 1199px) {
  .header-actions {
    display: none !important;
  }
}

.btn-login {
  background: rgba(205, 164, 94, 0.12);
  color: var(--accent-color);
  border: 1.5px solid var(--accent-color);
  border-radius: 999px;
  padding: 0 1.5rem;
  height: 40px;
  display: inline-flex;
  align-items: center;
  font-size: 1rem;
  font-weight: 500;
  box-shadow: 0 2px 8px rgba(205, 164, 94, 0.07);
  transition: all 0.2s;
  letter-spacing: 0.01em;
}
.btn-login:hover {
  background: var(--accent-color);
  color: #fff;
  box-shadow: 0 4px 16px rgba(205, 164, 94, 0.13);
  transform: translateY(-1px);
}

.btn-signup {
  background: var(--accent-color);
  color: #fff;
  border: 1.5px solid var(--accent-color);
  border-radius: 999px;
  padding: 0 1.5rem;
  height: 40px;
  display: inline-flex;
  align-items: center;
  font-size: 1rem;
  font-weight: 600;
  box-shadow: 0 2px 12px rgba(205, 164, 94, 0.13);
  transition: all 0.2s;
  letter-spacing: 0.01em;
}
.btn-signup:hover {
  background: #e6b85c;
  color: #fff;
  box-shadow: 0 6px 18px rgba(205, 164, 94, 0.18);
  transform: translateY(-1px);
}

/* Profile Button Styles */
.btn-profile {
  background: rgba(205, 164, 94, 0.12);
  color: var(--accent-color);
  border: 1.5px solid var(--accent-color);
  border-radius: 999px;
  padding: 0 1.5rem;
  height: 40px;
  display: inline-flex;
  align-items: center;
  font-size: 1rem;
  font-weight: 500;
  box-shadow: 0 2px 8px rgba(205, 164, 94, 0.07);
  transition: all 0.2s;
  letter-spacing: 0.01em;
}

.btn-profile:hover {
  background: var(--accent-color);
  color: #fff;
  box-shadow: 0 4px 16px rgba(205, 164, 94, 0.13);
  transform: translateY(-1px);
}

.btn-profile:focus {
  outline: none;
  box-shadow: 0 0 0 3px rgba(205, 164, 94, 0.2);
}

/* Profile Dropdown Styles */
.dropdown-menu {
  border: 1px solid rgba(205, 164, 94, 0.2);
  border-radius: 12px;
  box-shadow: 0 8px 32px rgba(0, 0, 0, 0.1);
  padding: 0.5rem 0;
  min-width: 200px;
  background: #fff;
  margin-top: 8px;
}

.dropdown-item {
  padding: 0.75rem 1.25rem;
  font-size: 0.95rem;
  color: #333333;
  transition: all 0.2s;
  display: flex;
  align-items: center;
  text-decoration: none;
  font-weight: 500;
  white-space: nowrap;
}

.dropdown-item:hover {
  background: rgba(205, 164, 94, 0.1);
  color: #000000;
  text-decoration: none;
}

.dropdown-item:focus {
  background: rgba(205, 164, 94, 0.1);
  color: #000000;
  outline: none;
}

.dropdown-item i {
  width: 18px;
  color: var(--accent-color);
  font-size: 1.1rem;
  margin-right: 0.75rem;
  text-align: center;
}

.dropdown-divider {
  margin: 0.5rem 0;
  border-color: rgba(205, 164, 94, 0.2);
}

/* Dropdown Header Styles */
.dropdown-header {
  padding: 1rem 1.25rem 0.75rem;
  display: flex;
  align-items: center;
  background: rgba(205, 164, 94, 0.05);
  border-radius: 8px 8px 0 0;
  margin: -0.5rem -0rem 0;
}

.dropdown-header i {
  font-size: 2rem;
  color: var(--accent-color);
  margin-right: 0.75rem;
}

.dropdown-header .fw-semibold {
  font-size: 1rem;
  color: #000000;
  margin-bottom: 0.25rem;
}

.dropdown-header .text-muted {
  font-size: 0.85rem;
  color: #666666;
}

/* Profile Name in Button */
.profile-name {
  max-width: 120px;
  overflow: hidden;
  text-overflow: ellipsis;
  white-space: nowrap;
}

/* Logout Item Special Styling */
.dropdown-item.text-danger {
  color: #dc3545 !important;
}

.dropdown-item.text-danger:hover {
  background: rgba(220, 53, 69, 0.1);
  color: #dc3545 !important;
}

.dropdown-item.text-danger i {
  color: #dc3545 !important;
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
  // Update cart count display
  function updateCartCount(count = 0) {
    document.querySelectorAll('.cart-count, .cart-counter, .cart-badge').forEach(el => {
      el.textContent = count;
      el.style.display = count > 0 ? 'flex' : 'none';
      el.classList.toggle('d-none', count <= 0);
    });
  }

  // Load cart count from server
  async function loadCartCount() {
    try {
      const response = await fetch('{{ route("cart.data") }}', {
        headers: { 'X-Requested-With': 'XMLHttpRequest' }
      });
      const data = await response.json();
      if (data.success) updateCartCount(data.cart_count);
    } catch (error) {
      console.log('Cart count load failed:', error);
      updateCartCount(document.querySelectorAll('.cart-item').length);
    }
  }

  // Event listeners
  window.addEventListener('cartCountUpdated', (e) => updateCartCount(e.detail.count));
  window.addEventListener('cartUpdated', loadCartCount);

  // Cart button handler
  document.querySelector('[data-bs-target="#cartOffcanvas"]')?.addEventListener('click', () => {
    window.refreshCartSidebar?.();
  });

  // Global functions
  window.updateHeaderCartCount = updateCartCount;
  window.refreshHeaderCartCount = loadCartCount;

  // Initialize
  loadCartCount();
});
</script>