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
          <a class="btn-login" href="{{ route('login') }}">
            <i class="bi bi-person me-2"></i>Login
      </a>
          <a class="btn-signup" href="{{ route('register') }}">
            <i class="bi bi-person-plus me-2"></i>Signup
      </a>
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
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
  // Initialize cart count
  updateCartCount();

  // Listen for cart updates
  window.addEventListener('cartUpdated', function() {
    updateCartCount();
  });

  function updateCartCount() {
    const cartItems = document.querySelectorAll('.cart-item');
    const cartCount = document.querySelector('.cart-count');
    if (cartCount) {
      cartCount.textContent = cartItems.length;
    }
  }
});
</script> 