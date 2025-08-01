<!-- Cart Section -->
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
<div class="cart-section clean-cart" id="cartSection">
    <div class="cart-header d-flex justify-content-between align-items-center mb-4 sticky-top bg-white" style="z-index:2;">
        <h2 class="m-0">My Cart</h2>
        <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>

    <!-- Delivery Options -->
    <div class="delivery-options mb-4">
        <div class="btn-group w-100" role="group">
            <button type="button" class="btn btn-option active" data-type="delivery">
                <i class="bi bi-truck"></i>
                <span class="ms-2">Takeaway</span>
            </button>
        </div>
    </div>

    <!-- Cart Items -->
    <div class="cart-items" id="cart-items-container">
        @php
            $cart = session('cart', []);
            $subtotal = 0;
            $itemCount = 0;
        @endphp

        @if(count($cart) > 0)
            @foreach($cart as $key => $item)
                @php
                    $subtotal += $item['total_price'];
                    $itemCount += $item['quantity'];
                @endphp
                <div class="cart-item mb-4 pb-3 border-bottom">
                    <div class="d-flex align-items-center">
                        <img src="{{ asset('uploads/menus/' . $item['image']) }}" alt="{{ $item['menu_name'] }}" class="cart-item-img me-3">
                        <div class="flex-grow-1">
                            <div class="d-flex justify-content-between mb-1">
                                <h5 class="cart-item-title mb-0">{{ $item['menu_name'] }}</h5>
                                <div class="item-price">Rs. {{ number_format($item['unit_price'], 2) }}</div>
                            </div>
                            <div class="text-muted small mb-2">From: {{ $item['restaurant_name'] }}</div>
                            <div class="d-flex justify-content-between align-items-center">
                                <div class="quantity-controls">
                                    <button class="btn-quantity quantity-decrease"
                                            data-menu-id="{{ $key }}"
                                            data-quantity="{{ max(1, $item['quantity'] - 1) }}"
                                            {{ $item['quantity'] <= 1 ? 'disabled' : '' }}>
                                            <i class="bi bi-dash"></i>
                                        </button>
                                    <span class="quantity mx-2" id="qty-{{ $key }}">{{ $item['quantity'] }}</span>
                                    <button class="btn-quantity quantity-increase"
                                            data-menu-id="{{ $key }}"
                                            data-quantity="{{ $item['quantity'] + 1 }}">
                                            <i class="bi bi-plus"></i>
                                        </button>
                                </div>
                                <button class="btn-remove cart-remove-btn" data-menu-id="{{ $key }}">
                                        <i class="bi bi-trash3"></i>
                                    </button>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        @else
            <div class="empty-cart-message text-center">
                <i class="bi bi-cart-x"></i>
                <p>Your cart is empty</p>
            </div>
        @endif
    </div>

    <!-- Cart Footer -->
    @if(count($cart) > 0)
        <div class="cart-footer mt-auto pt-3 border-top bg-white">
            <div class="subtotal d-flex justify-content-between mb-3">
                <span>Subtotal</span>
                <span class="subtotal-amount">Rs. {{ number_format($subtotal, 2) }}</span>
            </div>
            <a href="{{ route('checkout') }}" class="btn-checkout w-100 d-block text-center text-decoration-none">
                Proceed To Checkout • Rs. {{ number_format($subtotal, 2) }}
            </a>
        </div>
    @endif
</div>

<style>
.clean-cart {
    background: #fff;
    border-radius: 16px;
    box-shadow: none;
    padding: 0 0 1.5rem 0;
    min-height: 100vh;
    font-family: 'Poppins', Arial, sans-serif;
}
.cart-header, .delivery-options, .cart-items, .cart-footer {
    font-family: 'Poppins', Arial, sans-serif;
}

.cart-header {
    background: #fff;
    border-bottom: 1px solid #f0f0f0;
    padding: 1.5rem 1.5rem 1rem 1.5rem;
}

.cart-header h2 {
    color: #222;
    font-size: 1.4rem;
    font-weight: 700;
    letter-spacing: 0.01em;
}

.btn-close {
    background: none;
    color: #888;
    opacity: 0.7;
    font-size: 1.5rem;
    padding: 0;
    transition: all 0.3s;
}
.btn-close:hover {
    opacity: 1;
    color: #222;
    transform: rotate(90deg);
}

.delivery-options {
    padding: 0 1.5rem;
}
.delivery-options .btn-group {
    border-radius: 12px;
    overflow: hidden;
    background: #f7f7f7;
    box-shadow: none;
    padding: 2px;
}
.btn-option {
    flex: 1;
    padding: 0.7rem 0;
    background: transparent;
    color: #555;
    border: none;
    border-radius: 10px !important;
    font-weight: 500;
    font-size: 1rem;
    transition: all 0.2s;
}
.btn-option.active {
    background: var(--accent-color);
    color: #fff;
    box-shadow: none;
}
.btn-option:hover:not(.active) {
    background: #f0f0f0;
}

.cart-items {
    flex: 1;
    overflow-y: auto;
    padding: 0 1.5rem;
}
.cart-item {
    background: none;
    border-radius: 0;
    box-shadow: none;
    padding: 0 0 1rem 0;
    border-bottom: 1px solid #f0f0f0;
    margin-bottom: 0;
    transition: none;
}
.cart-item-img {
    width: 70px;
    height: 70px;
    object-fit: cover;
    border-radius: 12px;
    background: #f7f7f7;
}
.cart-item-title {
    color: #222;
    font-size: 1.05rem;
    font-weight: 600;
    margin-bottom: 0;
}
.cart-item-size, .cart-item-instruction {
    color: #888;
    font-size: 0.92rem;
    font-weight: 400;
    margin-bottom: 0.1rem;
}
.item-price {
    color: var(--accent-color);
    font-weight: 700;
    font-size: 1.05rem;
}
.quantity-controls {
    display: flex;
    align-items: center;
    background: #f7f7f7;
    border-radius: 20px;
    padding: 2px 8px;
    box-shadow: none;
}
.btn-quantity {
    width: 26px;
    height: 26px;
    padding: 0;
    display: flex;
    align-items: center;
    justify-content: center;
    border-radius: 50%;
    background: #eee;
    color: #222;
    border: none;
    font-size: 1.1rem;
    transition: all 0.2s;
}
.btn-quantity:disabled {
    opacity: 0.5;
    cursor: not-allowed;
}
.btn-quantity:hover:not(:disabled) {
    background: var(--accent-color);
    color: #fff;
}
.quantity {
    font-weight: 500;
    color: #222;
    min-width: 24px;
    text-align: center;
    font-size: 1rem;
}
.btn-remove {
    background: none;
    border: none;
    color: #bbb;
    padding: 6px;
    border-radius: 50%;
    transition: all 0.2s;
    font-size: 1.1rem;
}
.btn-remove:disabled {
    opacity: 0.5;
    cursor: not-allowed;
}
.btn-remove:hover:not(:disabled) {
    background: #ffeaea;
    color: #dc3545;
}
.empty-cart-message {
    color: #bbb;
    padding: 3rem 0;
}
.empty-cart-message i {
    font-size: 2.5rem;
    color: #eee;
    opacity: 1;
    margin-bottom: 1rem;
}
.empty-cart-message p {
    font-size: 1.05rem;
    opacity: 0.8;
}
.cart-footer {
    margin: 0;
    padding: 1.5rem 1.5rem 0.5rem 1.5rem;
    background: #fff;
    border-top: 1px solid #f0f0f0;
    border-radius: 0 0 16px 16px;
}
.subtotal {
    color: #222;
    font-size: 1.05rem;
    font-weight: 500;
}
.subtotal-amount {
    color: var(--accent-color);
    font-weight: 700;
    font-size: 1.1rem;
}
.btn-checkout {
    background: var(--accent-color);
    color: #fff;
    padding: 0.9rem 0;
    font-weight: 600;
    font-size: 1.08rem;
    border-radius: 12px;
    border: none;
    transition: all 0.2s;
    box-shadow: none;
    margin-top: 0.5rem;
}
.btn-checkout:hover {
    background: #e6b85c;
    color: #fff;
    transform: translateY(-1px);
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const csrfToken = document.querySelector('meta[name="csrf-token"]')?.content;
    const cartContainer = document.getElementById('cart-items-container');

    // Handle all cart actions with event delegation
    cartContainer?.addEventListener('click', async function(e) {
        const btn = e.target.closest('button');
        if (!btn) return;

        e.preventDefault();
        const menuId = btn.dataset.menuId;
        if (!menuId || btn.disabled) return;

        btn.disabled = true;
        btn.style.opacity = '0.6';

        try {
            let url, formData = new FormData();
            formData.append('menu_id', menuId);
            formData.append('_token', csrfToken);

            if (btn.classList.contains('quantity-decrease') || btn.classList.contains('quantity-increase')) {
                formData.append('quantity', btn.dataset.quantity);
                url = '{{ route("cart.update") }}';
            } else if (btn.classList.contains('cart-remove-btn')) {
                url = '{{ route("cart.remove") }}';
            }

            const response = await fetch(url, {
                method: 'POST',
                body: formData,
                headers: { 'X-Requested-With': 'XMLHttpRequest' }
            });

            const data = await response.json();
            if (data.success) {
                if (btn.classList.contains('cart-remove-btn')) {
                    // Animate item removal
                    const cartItem = btn.closest('.cart-item');
                    cartItem.style.transition = 'all 0.3s ease';
                    cartItem.style.opacity = '0';
                    setTimeout(() => cartItem.remove(), 300);
                }

                // Update footer and header
                updateCartFooter(data.cart_total);
                if (window.updateHeaderCartCount) {
                    window.updateHeaderCartCount(data.cart_count || 0);
                }

                // Check if cart is empty
                if (data.cart_empty) showEmptyCart();

                showMessage(data.message);
            } else {
                throw new Error(data.message);
            }
        } catch (error) {
            showMessage(error.message || 'Operation failed', 'error');
        } finally {
            btn.disabled = false;
            btn.style.opacity = '';
        }
    });

    // Simplified cart refresh
    async function refreshCartDisplay() {
        try {
            const response = await fetch('{{ route("cart.data") }}', {
                headers: { 'X-Requested-With': 'XMLHttpRequest' }
            });
            const data = await response.json();

            if (data.success) {
                if (!data.cart_items || Object.keys(data.cart_items).length === 0) {
                    showEmptyCart();
                } else {
                    updateCartItems(data.cart_items);
                    updateCartFooter(data.cart_total);
                }

                if (window.updateHeaderCartCount) {
                    window.updateHeaderCartCount(data.cart_count || 0);
                }
            }
        } catch (error) {
            console.error('Cart refresh failed:', error);
        }
    }

    // Update cart items HTML
    function updateCartItems(items) {
        cartContainer.innerHTML = Object.entries(items).map(([key, item]) => `
            <div class="cart-item mb-4 pb-3 border-bottom">
                <div class="d-flex align-items-center">
                    <img src="{{ asset('uploads/menus/') }}/${item.image}" alt="${item.menu_name}" class="cart-item-img me-3">
                    <div class="flex-grow-1">
                        <div class="d-flex justify-content-between mb-1">
                            <h5 class="cart-item-title mb-0">${item.menu_name}</h5>
                            <div class="item-price">Rs. ${parseFloat(item.unit_price).toFixed(2)}</div>
                        </div>
                        <div class="text-muted small mb-2">From: ${item.restaurant_name}</div>
                        <div class="d-flex justify-content-between align-items-center">
                            <div class="quantity-controls">
                                <button class="btn-quantity quantity-decrease" data-menu-id="${key}" data-quantity="${Math.max(1, item.quantity - 1)}" ${item.quantity <= 1 ? 'disabled' : ''}>
                                    <i class="bi bi-dash"></i>
                                </button>
                                <span class="quantity mx-2">${item.quantity}</span>
                                <button class="btn-quantity quantity-increase" data-menu-id="${key}" data-quantity="${parseInt(item.quantity) + 1}">
                                    <i class="bi bi-plus"></i>
                                </button>
                            </div>
                            <button class="btn-remove cart-remove-btn" data-menu-id="${key}">
                                <i class="bi bi-trash3"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        `).join('');
    }

    // Update cart footer
    function updateCartFooter(total = 0) {
        const cartSection = document.getElementById('cartSection');
        if (!cartSection) return;

        cartSection.querySelector('.cart-footer')?.remove();
        if (total > 0) {
            cartSection.insertAdjacentHTML('beforeend', `
                <div class="cart-footer mt-auto pt-3 border-top bg-white">
                    <div class="subtotal d-flex justify-content-between mb-3">
                        <span>Subtotal</span>
                        <span class="subtotal-amount">Rs. ${parseFloat(total).toFixed(2)}</span>
                    </div>
                    <a href="{{ route('checkout') }}" class="btn-checkout w-100 d-block text-center text-decoration-none">
                        Proceed To Checkout • Rs. ${parseFloat(total).toFixed(2)}
                    </a>
                </div>
            `);
        }
    }

    // Show empty cart
    function showEmptyCart() {
        cartContainer.innerHTML = '<div class="empty-cart-message text-center"><i class="bi bi-cart-x"></i><p>Your cart is empty</p></div>';
        document.getElementById('cartSection')?.querySelector('.cart-footer')?.remove();
    }

    // Simple message display
    function showMessage(message, type = 'success') {
        const alert = document.createElement('div');
        alert.className = `alert alert-${type === 'success' ? 'success' : 'danger'} position-fixed`;
        alert.style.cssText = 'top:20px;right:20px;z-index:9999;';
        alert.textContent = message;
        document.body.appendChild(alert);
        setTimeout(() => alert.remove(), 3000);
    }

    // Global functions
    window.refreshCartSidebar = refreshCartDisplay;

    // Auto-refresh on cart open
    document.getElementById('cartOffcanvas')?.addEventListener('show.bs.offcanvas', refreshCartDisplay);
});
</script>
