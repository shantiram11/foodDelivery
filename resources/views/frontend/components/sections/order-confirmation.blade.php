@extends('layouts.frontend-master')

@section('content')
<div class="min-h-screen" style="background: linear-gradient(135deg, #fff7ed 0%, #fef2f2 100%); margin-top: 80px;">
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card modern-card">
                    <div class="card-body text-center p-5">
                        <!-- Success Icon -->
                        <div class="success-icon mb-4">
                            <i class="bi bi-check-circle-fill text-success" style="font-size: 4rem;"></i>
                        </div>
                        
                        <h2 class="text-success mb-4">Order Confirmed!</h2>
                        <p class="lead mb-4">Thank you for your order. We're preparing it now!</p>
                        
                        <!-- Order Details Card -->
                        <div class="order-details-card bg-light p-4 rounded mb-4">
                            <div class="row text-start">
                                <div class="col-md-6">
                                    <h5 class="mb-3">Order Information</h5>
                                    <p><strong>Order Number:</strong> {{ $order->order_number }}</p>
                                    <p><strong>Restaurant:</strong> {{ $order->restaurant->name }}</p>
                                    <p><strong>Status:</strong> <span class="badge bg-warning">{{ ucfirst($order->status) }}</span></p>
                                    <p><strong>Payment:</strong> Cash on Delivery</p>
                                </div>
                                <div class="col-md-6">
                                    <h5 class="mb-3">Customer Details</h5>
                                    <p><strong>Name:</strong> {{ $order->user->name }}</p>
                                    <p><strong>Phone:</strong> {{ $order->customer_phone }}</p>
                                    <p><strong>Order Type:</strong> Takeaway</p>
                                    <p><strong>Estimated Ready Time:</strong> 20-30 minutes</p>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Order Items -->
                        <div class="order-items-card bg-white border rounded p-4 mb-4">
                            <h5 class="text-start mb-3">Items Ordered</h5>
                            <div class="table-responsive">
                                <table class="table table-borderless">
                                    <thead class="table-light">
                                        <tr>
                                            <th>Item</th>
                                            <th>Quantity</th>
                                            <th>Unit Price</th>
                                            <th>Total</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($order->orderItems as $item)
                                        <tr>
                                            <td class="text-start">{{ $item->menu_name }}</td>
                                            <td>{{ $item->quantity }}</td>
                                            <td>Rs. {{ number_format($item->unit_price, 2) }}</td>
                                            <td><strong>Rs. {{ number_format($item->total_price, 2) }}</strong></td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                    <tfoot class="table-light">
                                        <tr>
                                            <th colspan="3" class="text-end">Total Amount:</th>
                                            <th class="text-success">Rs. {{ number_format($order->total_amount, 2) }}</th>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>
                        
                        <!-- Action Buttons -->
                        <div class="action-buttons">
                            <a href="{{ route('home') }}" class="btn btn-primary me-3">
                                <i class="bi bi-house me-2"></i>Back to Home
                            </a>
                            <button onclick="window.print()" class="btn btn-outline-secondary">
                                <i class="bi bi-printer me-2"></i>Print Receipt
                            </button>
                        </div>
                        
                        <!-- Additional Info -->
                        <div class="additional-info mt-4 p-3 bg-info bg-opacity-10 rounded">
                            <p class="mb-1"><strong>Important:</strong></p>
                            <p class="mb-0 small">Please arrive at the restaurant within the estimated time. Have your order number ready for pickup.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
/* Modern Card Design */
.modern-card {
    border: 0;
    border-radius: 16px;
    box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
    background: rgba(255, 255, 255, 0.9);
    backdrop-filter: blur(10px);
}

.success-icon {
    animation: bounceIn 0.6s ease-out;
}

@keyframes bounceIn {
    0% {
        transform: scale(0.3);
        opacity: 0;
    }
    50% {
        transform: scale(1.05);
    }
    70% {
        transform: scale(0.9);
    }
    100% {
        transform: scale(1);
        opacity: 1;
    }
}

.order-details-card {
    border: 1px solid #e9ecef;
}

.order-items-card {
    border: 1px solid #e9ecef;
}

.action-buttons .btn {
    min-width: 150px;
}

@media print {
    .action-buttons {
        display: none !important;
    }
    
    .modern-card {
        box-shadow: none !important;
        border: 1px solid #000 !important;
    }
}

@media (max-width: 768px) {
    .action-buttons .btn {
        width: 100%;
        margin-bottom: 10px;
    }
    
    .action-buttons .me-3 {
        margin-right: 0 !important;
    }
}
</style>
@endsection