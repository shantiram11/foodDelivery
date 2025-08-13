@extends('layouts.frontend-master')

@section('content')
<div class="d-flex align-items-center" style="background: #fafbfc; margin-top: 80px; min-height: 60vh; padding: 2rem 0;">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-5 col-lg-4">

                                <div class="clean-card text-center">

                    <!-- Success Icon -->
                    <div class="success-icon mb-3">
                        <i class="bi bi-check-circle-fill text-success"></i>
                    </div>

                    {{-- Check if we have single order or multiple orders --}}
                    @if(isset($order))
                        {{-- SINGLE ORDER DISPLAY --}}
                        <!-- Success Message -->
                        <h2 class="mb-2 text-black">Order Placed Successfully!</h2>
                        <p class="text-muted mb-4">Thank you for your order</p>

                        <!-- Single Order Info -->
                        <div class="order-info mb-4">
                            <div class="mb-2">
                                <small class="text-muted">Order Code</small>
                            </div>
                            <div class="mb-2">
                                <span class="order-id">{{ $order->order_number }}</span>
                            </div>
                            <div class="mb-2">
                                <small class="text-muted">Restaurant</small>
                            </div>
                            <div class="mb-2">
                                <small class="text-muted">{{ $order->restaurant->name }}</small>
                            </div>
                            @if($order->payment_method === 'esewa' && $order->esewa_reference_id)
                                <div class="mb-2">
                                    <small class="text-muted">eSewa Reference ID</small>
                                </div>
                                <div class="mb-2">
                                    <span class="order-id">{{ $order->esewa_reference_id }}</span>
                                </div>
                            @endif
                            <div class="mb-2">
                                <small class="text-muted">Payment Status</small>
                            </div>
                            <div class="mb-2">
                                <small class="text-muted">{{ ucfirst($order->payment_status) }}</small>
                            </div>
                            <div class="total-price">Rs. {{ number_format($order->total_amount, 2) }}</div>
                        </div>

                    @elseif(isset($orders))
                        {{-- MULTIPLE ORDERS DISPLAY --}}
                        <!-- Success Message -->
                        <h2 class="mb-2 text-black">Orders Placed Successfully!</h2>
                        <p class="text-muted mb-4">Thank you for your orders</p>

                        <!-- Multiple Orders Summary -->
                        <div class="order-info mb-4">
                            <div class="mb-2">
                                <small class="text-muted">{{ count($orders) }} Orders Placed</small>
                            </div>
                            @php
                                $ref = $orders->pluck('esewa_reference_id')->filter()->first();
                            @endphp
                            @if($ref)
                                <div class="mb-2">
                                    <small class="text-muted">eSewa Reference ID</small>
                                </div>
                                <div class="mb-2">
                                    <span class="order-id">{{ $ref }}</span>
                                </div>
                            @endif
                            <div class="total-price mb-3">Rs. {{ number_format($orders->sum('total_amount'), 2) }}</div>
                        </div>

                        <!-- Individual Orders List -->
                        <div class="orders-list mb-4">
                            @foreach($orders as $singleOrder)
                                <div class="order-item">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div class="text-start">
                                            <div class="order-id-small">{{ $singleOrder->order_number }}</div>
                                            <small class="text-muted">{{ $singleOrder->restaurant->name }}</small>
                                        </div>
                                        <div class="order-amount">Rs. {{ number_format($singleOrder->total_amount, 2) }}</div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endif

                    <!-- Action Button -->
                    <a href="{{ route('home') }}" class="btn btn-success">
                        Continue Shopping
                    </a>

                </div>

            </div>
        </div>
    </div>
</div>

<style>
/* Main card styling */
.clean-card {
    background: white;
    border-radius: 8px;
    padding: 2rem 1.5rem;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
    max-width: 350px;
    margin: 0 auto;
}

/* Success icon */
.success-icon i {
    font-size: 3rem;
}

/* Order info container */
.order-info {
    background: #f8f9fa;
    border-radius: 6px;
    padding: 1rem;
}

/* Single order ID styling */
.order-id {
    font-family: 'Courier New', monospace;
    background: #e9ecef;
    padding: 0.3rem 0.6rem;
    border-radius: 4px;
    font-size: 0.9rem;
    color: #495057;
}

/* Price display */
.total-price {
    font-size: 1.3rem;
    font-weight: 600;
    color: #28a745;
}

/* Multiple orders list styling */
.orders-list {
    border-top: 1px solid #e9ecef;
    padding-top: 1rem;
}

.order-item {
    padding: 0.75rem 0;
    border-bottom: 1px solid #f0f0f0;
}

.order-item:last-child {
    border-bottom: none;
    padding-bottom: 0;
}

/* Small order ID for multiple orders */
.order-id-small {
    font-family: 'Courier New', monospace;
    font-size: 0.85rem;
    color: #495057;
    font-weight: 500;
}

/* Individual order amount */
.order-amount {
    font-size: 1rem;
    font-weight: 600;
    color: #28a745;
}

/* Mobile responsive */
@media (max-width: 768px) {
    .clean-card {
        margin: 1rem;
        padding: 1.5rem;
    }
}
</style>
@endsection