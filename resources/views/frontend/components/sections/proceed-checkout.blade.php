@extends('layouts.frontend-master')

@section('content')
<div class="min-h-screen" style="background: linear-gradient(135deg, #fff7ed 0%, #fef2f2 100%); margin-top: 80px;">

    <div class="container py-4">
        <div class="row g-4">
            <!-- Left Column - Delivery Info & Payment -->
            <div class="col-lg-8">
                <!-- Compact User Information -->
                <div class="card modern-card mb-4">
                    <div class="card-body p-4">
                        <div class="d-flex align-items-center justify-content-between mb-3">
                            <h2 class="card-title">Delivery Details</h2>
                            <button class="btn btn-edit">
                                <i class="bi bi-pencil me-1"></i>
                                <a href="">Edit</a>
                            </button>
                        </div>

                        <div class="row g-3">
                            <div class="col-md-4">
                                <div class="info-card info-card-orange">
                                    <div class="info-icon">
                                        <i class="bi bi-person-circle"></i>
                                    </div>
                                    <div class="info-content">
                                        <div class="info-title">{{ auth()->user()->name}}</div>
                                        <div class="info-subtitle">Customer</div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="info-card info-card-blue">
                                    <div class="info-icon">
                                        <i class="bi bi-telephone"></i>
                                    </div>
                                    <div class="info-content">
                                        <div class="info-title">{{ auth()->user()->phone ?? '9841234567'}}</div>
                                        <div class="info-subtitle">Phone</div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="info-card info-card-green">
                                    <div class="info-icon">
                                        <i class="bi bi-geo-alt"></i>
                                    </div>
                                    <div class="info-content">
                                        <div class="info-title">{{ auth()->user()->address ?? 'Thamel, Kathmandu 44600'}}</div>
                                        <div class="info-subtitle">Address</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Compact Payment Method -->
                <div class="card modern-card">
                    <div class="card-body p-4">
                        <h2 class="card-title mb-3">Payment Method</h2>

                        <div class="payment-methods">
                            <!-- Cash on Delivery -->
                            <div class="payment-option selected" data-payment="cod">
                                <input type="radio" name="payment_method" id="cod" value="cod" checked class="d-none">
                                <label for="cod" class="payment-label payment-label-green">
                                    <div class="payment-icon">
                                        <i class="bi bi-truck"></i>
                                    </div>
                                    <div class="payment-content">
                                        <div class="payment-title">Cash on Delivery</div>
                                        <div class="payment-subtitle">Pay when order arrives</div>
                                    </div>
                                    <span class="payment-badge badge-selected">Selected</span>
                                </label>
                            </div>

                            <!-- Khalti -->
                            <div class="payment-option" data-payment="khalti">
                                <input type="radio" name="payment_method" id="khalti" value="khalti" class="d-none">
                                <label for="khalti" class="payment-label payment-label-purple">
                                    <div class="payment-logo">
                                        <img src="{{ asset('frontend/img/payment/khalti.png') }}" alt="Khalti" class="payment-method-img">
                                    </div>
                                    <div class="payment-content">
                                        <div class="payment-title">Khalti Digital Wallet</div>
                                        <div class="payment-subtitle">Pay instantly with Khalti</div>
                                    </div>
                                </label>
                            </div>

                            <!-- eSewa -->
                            <div class="payment-option" data-payment="esewa">
                                <input type="radio" name="payment_method" id="esewa" value="esewa" class="d-none">
                                <label for="esewa" class="payment-label payment-label-blue">
                                    <div class="payment-logo">
                                        <img src="{{ asset('frontend/img/payment/esewa.png') }}" alt="eSewa" class="payment-method-img">
                                    </div>
                                    <div class="payment-content">
                                        <div class="payment-title">eSewa Digital Payment</div>
                                        <div class="payment-subtitle">Quick payment with eSewa</div>
                                    </div>
                                </label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Right Column - Compact Order Summary -->
            <div class="col-lg-4">
                <div class="card modern-card sticky-card">
                    <div class="card-body p-4">
                        <h2 class="card-title mb-4">Order Summary</h2>

                        <!-- Order Items -->
                        <div class="order-items mb-4">
                            @if(isset($cart) && count($cart) > 0)
                                @foreach($cart as $item)
                                    <div class="order-item">
                                        <div class="item-image-container">
                                            <img src="{{ asset('uploads/menus/' . $item['image']) }}" alt="{{ $item['menu_name'] }}" class="item-image">
                                            <span class="item-quantity">{{ $item['quantity'] }}</span>
                                        </div>
                                        <div class="item-details">
                                            <h3 class="item-name">{{ $item['menu_name'] }}</h3>
                                            <p class="item-description">From: {{ $item['restaurant_name'] }}</p>
                                            <div class="item-pricing">
                                                <span class="item-unit-price">Rs. {{ number_format($item['unit_price'], 2) }} each</span>
                                                <span class="item-total-price">Rs. {{ number_format($item['total_price'], 2) }}</span>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            @endif
                        </div>

                        <!-- Price Breakdown -->
                        <div class="price-breakdown">
                            <div class="price-row">
                                <span class="price-label">Subtotal</span>
                                <span class="price-value">Rs. {{ number_format($subtotal ?? 0, 2) }}</span>
                            </div>
                            <div class="price-row price-total">
                                <span class="price-label">Total</span>
                                <span class="price-value total-amount">Rs. {{ number_format($total_amount ?? 0, 2) }}</span>
                            </div>
                        </div>

                        <!-- Order Form and Place Order Button -->
                        <form action="{{ route('checkout.store') }}" method="POST" id="checkoutForm">
                            @csrf
                            <input type="hidden" name="payment_method" id="selectedPaymentMethod" value="cod">
                            <button type="submit" class="btn btn-place-order w-100" id="placeOrderBtn">
                                Place Order • Rs. {{ number_format($total_amount ?? 0, 2) }}
                            </button>
                        </form>

                        <!-- Compact Pickup Info -->
                        <div class="delivery-info-card mt-3">
                            <div class="delivery-info-content">
                                <i class="bi bi-bag me-2"></i>
                                <span>Takeaway - Ready in: 20-30 minutes</span>
                            </div>
                        </div>

                        <p class="terms-text text-center mt-3">
                            By placing this order, you agree to our Terms & Privacy Policy
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
/* Modern Design System */
:root {
    --primary-50: #e6f5f2;
    --primary-100: #ccebe6;
    --primary-500: #19a087;
    --primary-600: #158972;
    --primary-700: #10725e;
    --red-50: #fef2f2;
    --red-500: #ef4444;
    --red-600: #dc2626;
    --blue-50: #eff6ff;
    --blue-100: #dbeafe;
    --blue-600: #2563eb;
    --blue-700: #1d4ed8;
    --green-50: #f0fdf4;
    --green-100: #dcfce7;
    --green-600: #16a34a;
    --green-700: #15803d;
    --purple-50: #faf5ff;
    --purple-100: #f3e8ff;
    --purple-600: #9333ea;
    --purple-700: #7c3aed;
    --gray-50: #f9fafb;
    --gray-200: #e5e7eb;
    --gray-500: #6b7280;
    --gray-600: #4b5563;
    --gray-700: #374151;
    --gray-900: #111827;
}

/* Header Section */
.header-section {
    background: rgba(255, 255, 255, 0.9);
    backdrop-filter: blur(10px);
    border-bottom: 1px solid var(--orange-100);
    position: sticky;
    top: 0;
    z-index: 10;
}

.btn-ghost {
    background: transparent;
    border: none;
    padding: 8px;
    border-radius: 8px;
    color: var(--gray-700);
    transition: all 0.2s ease;
}

.btn-ghost:hover {
    background: var(--primary-100);
    color: var(--primary-700);
}

.gradient-text {
    font-size: 1.25rem;
    font-weight: 700;
    background: linear-gradient(135deg, var(--primary-500), var(--primary-600));
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
}

.badge-time {
    background: var(--primary-50);
    color: var(--primary-700);
    border: 1px solid var(--primary-100);
    padding: 4px 12px;
    border-radius: 20px;
    font-size: 0.75rem;
    font-weight: 500;
}

/* Modern Card Design */
.modern-card {
    border: 0;
    border-radius: 16px;
    box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
    background: rgba(255, 255, 255, 0.8);
    backdrop-filter: blur(10px);
}

.card-title {
    font-size: 1.125rem;
    font-weight: 600;
    color: var(--gray-900);
    margin-bottom: 0;
}

.btn-edit {
    background: transparent;
    border: none;
    color: var(--primary-600);
    font-size: 0.875rem;
    font-weight: 500;
    padding: 4px 8px;
    border-radius: 6px;
    transition: all 0.2s ease;
}

.btn-edit:hover {
    background: var(--primary-50);
    color: var(--primary-700);
}

/* Info Cards */
.info-card {
    display: flex;
    align-items: center;
    gap: 12px;
    padding: 12px;
    border-radius: 12px;
    transition: all 0.2s ease;
}

.info-card-orange {
    background: linear-gradient(135deg, var(--primary-50), var(--primary-100));
}

.info-card-blue {
    background: linear-gradient(135deg, var(--blue-50), #e0f2fe);
}

.info-card-green {
    background: linear-gradient(135deg, var(--green-50), #ecfdf5);
}

.info-icon {
    width: 32px;
    height: 32px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
}

.info-card-orange .info-icon {
    background: var(--primary-100);
    color: var(--primary-600);
}

.info-card-blue .info-icon {
    background: var(--blue-100);
    color: var(--blue-600);
}

.info-card-green .info-icon {
    background: var(--green-100);
    color: var(--green-600);
}

.info-content {
    min-width: 0;
    flex: 1;
}

.info-title {
    font-size: 0.875rem;
    font-weight: 500;
    color: var(--gray-900);
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
}

.info-subtitle {
    font-size: 0.75rem;
    color: var(--gray-600);
}

/* Payment Methods */
.payment-methods {
    display: flex;
    flex-direction: column;
    gap: 12px;
}

.payment-option {
    transition: all 0.2s ease;
}

.payment-label {
    display: flex;
    align-items: center;
    gap: 12px;
    padding: 12px;
    border: 2px solid var(--gray-200);
    border-radius: 12px;
    cursor: pointer;
    transition: all 0.2s ease;
    width: 100%;
}

.payment-label:hover {
    transform: translateY(-1px);
}

.payment-label-green:hover {
    border-color: #bbf7d0;
    background: rgba(34, 197, 94, 0.05);
}

.payment-label-purple:hover {
    border-color: #e9d5ff;
    background: rgba(147, 51, 234, 0.05);
}

.payment-label-blue:hover {
    border-color: #bfdbfe;
    background: rgba(37, 99, 235, 0.05);
}

.payment-option.selected .payment-label-green {
    border-color:rgb(23, 148, 173);
    background: linear-gradient(135deg, var(--green-50), #ecfdf5);
}

.payment-option.selected .payment-label-purple {
    border-color:rgb(150, 13, 61);
    background: linear-gradient(135deg, var(--purple-50), #faf5ff);
}

.payment-option.selected .payment-label-blue {
    border-color:rgb(36, 204, 95);
    background: linear-gradient(135deg, var(--blue-50), #f0f9ff);
}

.payment-icon {
    width: 40px;
    height: 40px;
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.25rem;
}

.payment-logo {
    width: 60px;
    height: 40px;
    display: flex;
    align-items: center;
    justify-content: center;
}

.payment-method-img {
    max-width: 100%;
    max-height: 100%;
    object-fit: contain;
}

.payment-label-green .payment-icon {
    background: var(--green-100);
    color: var(--green-600);
}

.payment-label-purple .payment-icon {
    background: var(--purple-100);
    color: var(--purple-600);
}

.payment-label-blue .payment-icon {
    background: var(--blue-100);
    color: var(--blue-600);
}

.payment-content {
    flex: 1;
}

.payment-title {
    font-size: 0.875rem;
    font-weight: 600;
    color: var(--gray-900);
}

.payment-subtitle {
    font-size: 0.75rem;
    color: var(--gray-600);
}

.payment-badge {
    padding: 2px 8px;
    border-radius: 12px;
    font-size: 0.75rem;
    font-weight: 500;
}

.badge-selected {
    background: var(--green-100);
    color: var(--green-700);
    border: 1px solid var(--green-200);
}

/* Order Items */
.order-items {
    display: flex;
    flex-direction: column;
    gap: 12px;
}

.order-item {
    display: flex;
    gap: 12px;
    padding: 12px;
    background: linear-gradient(135deg, var(--gray-50), rgba(255, 237, 213, 0.3));
    border-radius: 12px;
}

.item-image-container {
    position: relative;
    flex-shrink: 0;
}

.item-image {
    width: 60px;
    height: 60px;
    border-radius: 12px;
    object-fit: cover;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
}

.item-quantity {
    position: absolute;
    top: -4px;
    right: -4px;
    background: var(--primary-500);
    color: white;
    font-size: 0.75rem;
    font-weight: 600;
    padding: 2px 6px;
    border-radius: 10px;
    min-width: 20px;
    height: 20px;
    display: flex;
    align-items: center;
    justify-content: center;
}

.item-details {
    flex: 1;
    min-width: 0;
}

.item-name {
    font-size: 0.875rem;
    font-weight: 600;
    color: var(--gray-900);
    margin: 0 0 2px 0;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
}

.item-description {
    font-size: 0.75rem;
    color: var(--gray-600);
    margin: 0 0 8px 0;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
}

.item-pricing {
    display: flex;
    align-items: center;
    justify-content: space-between;
}

.item-unit-price {
    font-size: 0.75rem;
    color: var(--gray-500);
}

.item-total-price {
    font-size: 0.875rem;
    font-weight: 700;
    color: var(--primary-600);
}

/* Price Breakdown */
.price-breakdown {
    padding: 12px 0;
    border-top: 1px solid var(--gray-200);
    display: flex;
    flex-direction: column;
    gap: 8px;
}

.price-row {
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.price-row.price-total {
    padding-top: 8px;
    border-top: 1px solid var(--gray-200);
    font-size: 1.125rem;
    font-weight: 700;
}

.price-label {
    font-size: 0.875rem;
    color: var(--gray-600);
}

.price-total .price-label {
    color: var(--gray-900);
}

.price-value {
    font-size: 0.875rem;
    color: var(--gray-900);
}

.total-amount {
    color: var(--primary-600);
}

/* Place Order Button */
.btn-place-order {
    background: linear-gradient(135deg, var(--primary-500), var(--primary-600));
    border: none;
    color: white;
    padding: 16px 24px;
    font-size: 0.875rem;
    font-weight: 600;
    border-radius: 12px;
    box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
    transition: all 0.2s ease;
}

.btn-place-order:hover {
    background: linear-gradient(135deg, var(--primary-600), var(--primary-700));
    transform: translateY(-1px);
    box-shadow: 0 8px 15px -3px rgba(0, 0, 0, 0.1);
    color: white;
}

/* Delivery Info Card */
.delivery-info-card {
    padding: 12px;
    background: linear-gradient(135deg, var(--primary-50), var(--primary-100));
    border-radius: 12px;
}

.delivery-info-content {
    display: flex;
    align-items: center;
    color: var(--primary-700);
    font-size: 0.75rem;
    font-weight: 500;
}

/* Terms Text */
.terms-text {
    font-size: 0.75rem;
    color: var(--gray-500);
    line-height: 1.5;
}

/* Sticky Card */
.sticky-card {
    position: sticky;
    top: 120px; /* Increased to account for header */
}

/* Responsive Design */
@media (max-width: 1366px) {
    .container {
        max-width: 1100px;
    }
}

@media (max-width: 1024px) {
    .sticky-card {
        position: static;
    }
}

@media (max-width: 768px) {
    .info-card {
        margin-bottom: 8px;
    }

    .payment-methods {
        gap: 8px;
    }

    .order-items {
        gap: 8px;
    }
}

/* Custom Scrollbar */
::-webkit-scrollbar {
    width: 6px;
}

::-webkit-scrollbar-track {
    background: #f1f1f1;
}

::-webkit-scrollbar-thumb {
    background: #c1c1c1;
    border-radius: 3px;
}

::-webkit-scrollbar-thumb:hover {
    background: #a1a1a1;
}

/* Loading state */
.btn-place-order:disabled {
    opacity: 0.7;
    cursor: not-allowed;
}

.btn-place-order.loading {
    background: linear-gradient(135deg, #6b7280, #9ca3af) !important;
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const paymentOptions = document.querySelectorAll('.payment-option');
    const paymentRadios = document.querySelectorAll('input[type="radio"][name="payment_method"]');
    const paymentMethodInput = document.getElementById('selectedPaymentMethod');
    const checkoutForm = document.getElementById('checkoutForm');
    const placeOrderBtn = document.getElementById('placeOrderBtn');

    function applySelectionByMethod(method) {
        paymentOptions.forEach(opt => {
            const isSelected = opt.dataset.payment === method;
            opt.classList.toggle('selected', isSelected);
            const badge = opt.querySelector('.payment-badge');
            if (badge) badge.style.display = isSelected ? 'inline-block' : 'none';
            const radio = opt.querySelector('input[type="radio"]');
            if (radio) radio.checked = isSelected;
        });
        paymentMethodInput.value = method;
    }

    // Click anywhere on the option box
    paymentOptions.forEach(option => {
        option.addEventListener('click', function() {
            const method = this.dataset.payment;
            applySelectionByMethod(method);
        });
    });

    // Also respond to direct radio changes (extra safety)
    paymentRadios.forEach(radio => {
        radio.addEventListener('change', function() {
            applySelectionByMethod(this.value);
        });
    });

    // Handle form submission
    checkoutForm.addEventListener('submit', function() {
        placeOrderBtn.disabled = true;
        placeOrderBtn.classList.add('loading');
        placeOrderBtn.textContent = 'Processing Order...';
    });

    // Initialize badges and sync hidden field with any pre-checked radio
    const initiallyChecked = Array.from(paymentRadios).find(r => r.checked);
    applySelectionByMethod(initiallyChecked ? initiallyChecked.value : paymentMethodInput.value || 'cod');
});
</script>

@endsection