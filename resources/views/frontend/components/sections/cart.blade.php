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
                                    <form action="{{ route('cart.update') }}" method="POST" class="d-inline">
                                        @csrf
                                        <input type="hidden" name="menu_id" value="{{ $key }}">
                                        <input type="hidden" name="quantity" value="{{ max(1, $item['quantity'] - 1) }}">
                                        <button type="submit" class="btn-quantity" {{ $item['quantity'] <= 1 ? 'disabled' : '' }}>
                                            <i class="bi bi-dash"></i>
                                        </button>
                                    </form>
                                    <span class="quantity mx-2">{{ $item['quantity'] }}</span>
                                    <form action="{{ route('cart.update') }}" method="POST" class="d-inline">
                                        @csrf
                                        <input type="hidden" name="menu_id" value="{{ $key }}">
                                        <input type="hidden" name="quantity" value="{{ $item['quantity'] + 1 }}">
                                        <button type="submit" class="btn-quantity">
                                            <i class="bi bi-plus"></i>
                                        </button>
                                    </form>
                                </div>
                                <form action="{{ route('cart.remove') }}" method="POST" class="d-inline">
                                    @csrf
                                    <input type="hidden" name="menu_id" value="{{ $key }}">
                                    <button type="submit" class="btn-remove">
                                        <i class="bi bi-trash3"></i>
                                    </button>
                                </form>
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
// Global function to reload cart content when items are added from menu
window.loadCartData = function() {
    // Simply reload the page to refresh cart content
    location.reload();
};
</script>

 