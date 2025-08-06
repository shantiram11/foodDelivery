@extends('layouts.dashboard.master')
@section('title','Order Details')
@section('content')
    <div class="container mt-4">
        <div class="d-flex justify-content-between align-items-center mb-4

            <div class="btn-group">
                <a href="{{ route('orders.index') }}" class="btn btn-secondary">
                    <i class="bi bi-arrow-left"></i> Back to Orders
                </a>
            </div>
        </div>

                <!-- Order Overview -->
        <div class="card mb-4">
            <div class="card-body p-4">
                <div class="row g-4">
                    <div class="col-md-3">
                        <div class="text-center text-md-start">
                            <h6 class="text-muted mb-1">Order Number</h6>
                            <h5 class="text-primary mb-0">{{ $order->order_number }}</h5>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="text-center text-md-start">
                            <h6 class="text-muted mb-1">Status</h6>
                            @switch($order->status)
                                @case('confirmed')
                                    <span class="badge bg-info">Confirmed</span>
                                    @break
                                @case('preparing')
                                    <span class="badge bg-warning">Preparing</span>
                                    @break
                                @case('completed')
                                    <span class="badge bg-success">Completed</span>
                                    @break
                                @case('cancelled')
                                    <span class="badge bg-danger">Cancelled</span>
                                    @break
                                @default
                                    <span class="badge bg-secondary">Unknown</span>
                            @endswitch
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="text-center text-md-start">
                            <h6 class="text-muted mb-1">Date</h6>
                            <p class="mb-0">{{ $order->created_at->format('M d, Y') }}</p>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="text-center text-md-start">
                            <h6 class="text-muted mb-1">Delivery Staff</h6>
                            <div id="current-delivery-staff-overview">
                                @if($order->deliveryStaff)
                                    <p class="mb-0 text-success">{{ $order->deliveryStaff->name }}</p>
                                @else
                                    <p class="mb-0 text-muted">Not assigned</p>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="text-center text-md-end">
                            <h6 class="text-muted mb-1">Total Amount</h6>
                            <h4 class="text-success mb-0">Rs. {{ number_format($order->total_amount, 2) }}</h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Main Content Row -->
        <div class="row">
            <!-- Left Column - Order Management -->
            <div class="col-lg-4 col-xl-3 mb-4">
                                <!-- Delivery Staff -->
                <div class="card mb-4">
                    <div class="card-header">
                        <h6 class="mb-0">Delivery Staff</h6>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <label class="text-muted small">Current Assignment</label>
                            <div id="current-delivery-staff" class="mt-2">
                                @if($order->deliveryStaff)
                                    <p class="mb-0 fw-medium">{{ $order->deliveryStaff->name }}</p>
                                    <small class="text-success">Assigned</small>
                                @else
                                    <p class="mb-0 text-muted">No staff assigned</p>
                                @endif
                            </div>
                        </div>

                        @if(!auth()->user()->isDeliveryStaff())
                            @if($deliveryStaff->count() > 0)
                            <div class="mb-3">
                                <label for="delivery-staff-select" class="form-label">Assign Staff</label>
                                <select class="form-select" id="delivery-staff-select">
                                    <option value="">Choose staff...</option>
                                    @foreach($deliveryStaff as $staff)
                                        <option value="{{ $staff->id }}" {{ $order->delivery_staff_id == $staff->id ? 'selected' : '' }}>
                                            {{ $staff->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <button class="btn btn-primary btn-sm" id="assign-delivery-staff" data-order-id="{{ $order->id }}">
                                Assign Staff
                            </button>
                            @else
                            <div class="alert alert-warning">
                                <small>No delivery staff available.</small>
                            </div>
                            @endif
                        @else
                            @if($order->delivery_staff_id === auth()->user()->id)
                                <div class="alert alert-info">
                                    <small>This order is assigned to you.</small>
                                </div>
                            @endif
                        @endif
                    </div>
                </div>

                <!-- Payment Details -->
                <div class="card mb-4">
                    <div class="card-header">
                        <h6 class="mb-0">Payment Details</h6>
                    </div>
                    <div class="card-body">
                        <div class="mb-2">
                            <small class="text-muted">Payment Method</small>
                            <p class="mb-0">{{ ucfirst($order->payment_method ?? 'N/A') }}</p>
                        </div>
                        <div class="mb-3">
                            <small class="text-muted">Payment Status</small>
                            <div id="current-payment-status" class="mt-2">
                                @switch($order->payment_status)
                                    @case('pending')
                                        <span class="badge bg-warning">Pending</span>
                                        @break
                                    @case('paid')
                                        <span class="badge bg-success">Paid</span>
                                        @break
                                    @default
                                        <span class="badge bg-secondary">N/A</span>
                                @endswitch
                            </div>
                        </div>

                        @if(!auth()->user()->isDeliveryStaff() && $order->payment_method === 'cod' && $order->payment_status === 'pending')
                            <div class="mt-3">
                                <small class="text-muted d-block mb-2">COD Payment Collection</small>
                                <div class="d-grid gap-2" id="payment-status-buttons">
                                    <button class="btn btn-success btn-sm update-payment-status" data-id="{{ $order->id }}" data-payment-status="paid">
                                        <i class="bi bi-cash-coin me-1"></i>Mark as Paid
                                    </button>
                                </div>
                                <small class="text-muted mt-1">Click when payment is collected on delivery</small>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Status Update -->
                @if(!in_array($order->status, ['completed', 'cancelled']))
                <div class="card">
                    <div class="card-header">
                        <h6 class="mb-0">Update Status</h6>
                    </div>
                    <div class="card-body">
                        <div class="d-grid gap-2">
                            @if($order->status === 'confirmed')
                                <button class="btn btn-warning btn-sm update-status" data-id="{{ $order->id }}" data-status="preparing">
                                    Mark as Preparing
                                </button>
                                <button class="btn btn-success btn-sm update-status" data-id="{{ $order->id }}" data-status="completed">
                                    Mark as Completed
                                </button>
                            @elseif($order->status === 'preparing')
                                <button class="btn btn-success btn-sm update-status" data-id="{{ $order->id }}" data-status="completed">
                                    Mark as Completed
                                </button>
                            @endif
                            <button class="btn btn-outline-danger btn-sm update-status" data-id="{{ $order->id }}" data-status="cancelled">
                                Cancel Order
                            </button>
                        </div>
                    </div>
                </div>
                @endif
            </div>

                        <!-- Right Column - Order Information -->
            <div class="col-lg-8 col-xl-9">
                <!-- Customer & Restaurant Info -->
                <div class="row mb-4">
                    <!-- Customer Information -->
                    <div class="col-md-6 mb-4">
                        <div class="card h-100">
                            <div class="card-header">
                                <h6 class="mb-0">Customer Information</h6>
                            </div>
                            <div class="card-body">
                                <div class="mb-3">
                                    <small class="text-muted">Name</small>
                                    <p class="mb-0">{{ $order->user ? $order->user->name : 'Guest Customer' }}</p>
                                </div>
                                <div class="mb-3">
                                    <small class="text-muted">Email</small>
                                    <p class="mb-0">{{ $order->user ? $order->user->email : 'N/A' }}</p>
                                </div>
                                <div>
                                    <small class="text-muted">Phone</small>
                                    <p class="mb-0">{{ $order->customer_phone ?? 'N/A' }}</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Restaurant Information -->
                    <div class="col-md-6 mb-4">
                        <div class="card h-100">
                            <div class="card-header">
                                <h6 class="mb-0">Restaurant Information</h6>
                            </div>
                            <div class="card-body">
                                <div class="mb-3">
                                    <small class="text-muted">Name</small>
                                    <p class="mb-0">{{ $order->restaurant ? $order->restaurant->name : 'N/A' }}</p>
                                </div>
                                <div class="mb-3">
                                    <small class="text-muted">Address</small>
                                    <p class="mb-0">{{ $order->restaurant ? $order->restaurant->address : 'N/A' }}</p>
                                </div>
                                <div>
                                    <small class="text-muted">Phone</small>
                                    <p class="mb-0">{{ $order->restaurant ? $order->restaurant->phone : 'N/A' }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                                <!-- Order Items -->
                <div class="card">
                    <div class="card-header">
                        <div class="d-flex justify-content-between align-items-center">
                            <h6 class="mb-0">Order Items</h6>
                            <span class="badge bg-primary">{{ $order->orderItems->count() }} items</span>
                        </div>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table mb-0">
                                <thead class="table-light">
                                    <tr>
                                        <th>Item</th>
                                        <th class="text-center">Price</th>
                                        <th class="text-center">Qty</th>
                                        <th class="text-end">Total</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($order->orderItems as $item)
                                        <tr>
                                            <td class="py-3">
                                                <div class="d-flex align-items-center">
                                                    @if($item->menu && $item->menu->image)
                                                        <img src="{{ asset('uploads/menus/' . $item->menu->image) }}"
                                                             alt="{{ $item->menu_name }}"
                                                             class="rounded me-3"
                                                             style="width: 40px; height: 40px; object-fit: cover;">
                                                    @else
                                                        <div class="bg-light rounded me-3 d-flex align-items-center justify-content-center"
                                                             style="width: 40px; height: 40px;">
                                                            <i class="bi bi-image text-muted"></i>
                                                        </div>
                                                    @endif
                                                    <div>
                                                        <h6 class="mb-0">{{ $item->menu_name }}</h6>
                                                        @if($item->menu && $item->menu->description)
                                                            <small class="text-muted">{{ Str::limit($item->menu->description, 50) }}</small>
                                                        @endif
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="text-center py-3">
                                                Rs. {{ number_format($item->unit_price, 2) }}
                                            </td>
                                            <td class="text-center py-3">
                                                <span class="badge bg-secondary">{{ $item->quantity }}</span>
                                            </td>
                                            <td class="text-end py-3">
                                                <strong>Rs. {{ number_format($item->total_price, 2) }}</strong>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="4" class="text-center py-4">
                                                <div class="text-muted">
                                                    <i class="bi bi-inbox fs-1"></i>
                                                    <p class="mt-2">No items found</p>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                                @if($order->orderItems->count() > 0)
                                <tfoot class="table-light">
                                    <tr class="table-success">
                                        <td colspan="3" class="text-end py-2">
                                            <strong>Total Amount:</strong>
                                        </td>
                                        <td class="text-end py-2">
                                            <strong class="text-success">Rs. {{ number_format($order->total_amount, 2) }}</strong>
                                        </td>
                                    </tr>
                                </tfoot>
                                @endif
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Status Update Success Modal -->
    <div class="modal fade" id="statusUpdateModal" tabindex="-1" aria-labelledby="statusUpdateModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0 shadow">
                <div class="modal-header border-0 bg-success text-white">
                    <h5 class="modal-title" id="statusUpdateModalLabel">
                        <i class="bi bi-check-circle-fill me-2"></i>Success
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body py-4">
                    <div class="text-center">
                        <div class="bg-success rounded-circle p-3 mx-auto mb-3" style="width: 60px; height: 60px;">
                            <i class="bi bi-check-lg text-white fs-3"></i>
                        </div>
                        <p id="statusUpdateMessage" class="mb-0 fs-5">Order status updated successfully!</p>
                    </div>
                </div>
                <div class="modal-footer border-0 justify-content-center">
                    <button type="button" class="btn btn-success px-4" data-bs-dismiss="modal" id="statusUpdateOkBtn">
                        <i class="bi bi-check-lg me-2"></i>OK
                    </button>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        $(document).ready(function() {
            const BASE_URL = "{{ url('/') }}";
            const CSRF_TOKEN = "{{ csrf_token() }}";

                        // Handle delivery staff assignment
            $('#assign-delivery-staff').on('click', function() {
                const orderId = $(this).data('order-id');
                const deliveryStaffId = $('#delivery-staff-select').val();
                const button = $(this);

                if (!deliveryStaffId) {
                    alert('Please select a delivery staff member.');
                    return;
                }

                // Disable button and show loading
                button.prop('disabled', true);
                const originalHtml = button.html();
                button.html('<i class="bi bi-hourglass-split"></i> Assigning...');

                $.ajax({
                    url: BASE_URL + '/dashboard/orders/' + orderId + '/assign-delivery-staff',
                    type: 'POST',
                    data: {
                        _token: CSRF_TOKEN,
                        delivery_staff_id: deliveryStaffId
                    },
                                        success: function(response) {
                        if (response.success) {
                                                        // Update the current assignment display
                            $('#current-delivery-staff').html(`
                                <p class="mb-0 fw-medium">${response.staff_name}</p>
                                <small class="text-success">Assigned</small>
                            `);

                            // Update the overview section
                            $('#current-delivery-staff-overview').html(`
                                <p class="mb-0 text-success">${response.staff_name}</p>
                            `);

                            // Show success modal
                            $('#statusUpdateMessage').text(response.message);
                            $('#statusUpdateModal').modal('show');
                        } else {
                            alert('Error: ' + response.message);
                        }
                    },
                    error: function(xhr) {
                        let errorMessage = 'An error occurred while assigning delivery staff.';
                        if (xhr.responseJSON && xhr.responseJSON.message) {
                            errorMessage = xhr.responseJSON.message;
                        }
                        alert('Error: ' + errorMessage);
                    },
                    complete: function() {
                        // Re-enable button and restore original content
                        button.prop('disabled', false);
                        button.html(originalHtml);
                    }
                });
            });

            // Handle status update buttons
            $('.update-status').on('click', function() {
                const orderId = $(this).data('id');
                const newStatus = $(this).data('status');
                const button = $(this);

                // Disable button and show loading
                button.prop('disabled', true);
                const originalHtml = button.html();
                button.html('<i class="bi bi-hourglass-split"></i> Updating...');

                $.ajax({
                    url: BASE_URL + '/dashboard/orders/' + orderId + '/update-status',
                    type: 'POST',
                    data: {
                        _token: CSRF_TOKEN,
                        status: newStatus
                    },
                    success: function(response) {
                        if (response.success) {
                            // Show success modal
                            $('#statusUpdateMessage').text(response.message);
                            $('#statusUpdateModal').modal('show');
                        } else {
                            alert('Error: ' + response.message);
                        }
                    },
                    error: function(xhr) {
                        let errorMessage = 'An error occurred while updating the order status.';
                        if (xhr.responseJSON && xhr.responseJSON.message) {
                            errorMessage = xhr.responseJSON.message;
                        }
                        alert('Error: ' + errorMessage);
                    },
                    complete: function() {
                        // Re-enable button and restore original content
                        button.prop('disabled', false);
                        button.html(originalHtml);
                    }
                });
            });

            // Handle payment status update buttons (using event delegation)
            $(document).on('click', '.update-payment-status', function() {
                const orderId = $(this).data('id');
                const newPaymentStatus = $(this).data('payment-status');
                const button = $(this);

                // Disable button and show loading
                button.prop('disabled', true);
                const originalHtml = button.html();
                button.html('<i class="bi bi-hourglass-split"></i> Updating...');

                $.ajax({
                    url: BASE_URL + '/dashboard/orders/' + orderId + '/update-payment-status',
                    type: 'POST',
                    data: {
                        _token: CSRF_TOKEN,
                        payment_status: newPaymentStatus
                    },
                                        success: function(response) {
                        if (response.success) {
                            // Update the payment status display to "Paid"
                            $('#current-payment-status').html('<span class="badge bg-success">Paid</span>');

                            // Hide the payment status update section since payment is now complete
                            $('#payment-status-buttons').parent().hide();

                            // Show success modal
                            $('#statusUpdateMessage').text(response.message);
                            $('#statusUpdateModal').modal('show');
                        } else {
                            alert('Error: ' + response.message);
                        }
                    },
                    error: function(xhr) {
                        let errorMessage = 'An error occurred while updating the payment status.';
                        if (xhr.responseJSON && xhr.responseJSON.message) {
                            errorMessage = xhr.responseJSON.message;
                        }
                        alert('Error: ' + errorMessage);
                    },
                    complete: function() {
                        // Re-enable button and restore original content
                        button.prop('disabled', false);
                        button.html(originalHtml);
                    }
                });
            });

            // Handle modal OK button and close events
            $('#statusUpdateModal').on('hidden.bs.modal', function() {
                location.reload();
            });

            // Handle modal OK button click explicitly
            $('#statusUpdateOkBtn').on('click', function() {
                $('#statusUpdateModal').modal('hide');
            });

            // Handle any other close buttons in the modal
            $('#statusUpdateModal [data-bs-dismiss="modal"]').on('click', function() {
                $('#statusUpdateModal').modal('hide');
            });
        });
    </script>
@endpush

@push('styles')
<style>
    .card {
        border: 1px solid #e9ecef;
        border-radius: 8px;
    }

    .card-header {
        background-color: #f8f9fa;
        border-bottom: 1px solid #e9ecef;
        padding: 1rem;
    }

    .card-body {
        padding: 1rem;
    }

    .badge {
        font-size: 0.75rem;
        padding: 0.375rem 0.75rem;
    }

    .table th {
        border-top: none;
        font-weight: 600;
        color: #495057;
        font-size: 0.875rem;
    }

    .table td {
        vertical-align: middle;
        border-color: #e9ecef;
    }

    .btn-sm {
        padding: 0.25rem 0.75rem;
        font-size: 0.875rem;
    }

    small {
        font-size: 0.75rem;
        color: #6c757d;
    }

    @media (max-width: 768px) {
        .text-end {
            text-align: left !important;
        }

        .text-center {
            text-align: left !important;
        }
    }

    /* Modal Improvements */
    .modal-content {
        border-radius: 10px;
    }

    .modal-header.bg-success {
        background: #198754 !important;
    }

    .modal-body .rounded-circle {
        width: 60px;
        height: 60px;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .btn-close-white {
        filter: brightness(0) invert(1);
    }
</style>
@endpush