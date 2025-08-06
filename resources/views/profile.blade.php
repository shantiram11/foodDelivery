@extends('layouts.frontend-master')

@section('title', 'My Profile - Food Delivery')

@section('content')
<section class="py-5 bg-light" style="margin-top: 80px; min-height: 100vh;">
    <div class="container">
        <div class="row">
            <!-- Sidebar -->
            <div class="col-lg-3 mb-5">
                <div class="card shadow-sm mb-4">
                    <div class="card-body text-center py-4">
                        <div class="mb-4">
                            <div class="bg-primary text-white rounded-circle d-inline-flex align-items-center justify-content-center" style="width: 80px; height: 80px;">
                                <i class="bi bi-person-fill fs-2"></i>
                            </div>
                        </div>
                        <h5 class="card-title mb-2">{{ $user->name }}</h5>
                        <p class="text-muted small mb-3">{{ $user->email }}</p>
                        <span class="badge bg-success">Customer</span>
                    </div>
                </div>

                <div class="card shadow-sm mb-4">
                    <div class="card-body py-4">
                        <h6 class="card-title mb-4">Quick Stats</h6>
                        <div class="d-flex justify-content-between mb-3">
                            <span class="text-muted">Total Orders:</span>
                            <strong>{{ $orders->total() }}</strong>
                        </div>
                        <div class="d-flex justify-content-between mb-3">
                            <span class="text-muted">Active Orders:</span>
                            <strong>{{ $orders->where('status', '!=', 'completed')->where('status', '!=', 'cancelled')->count() }}</strong>
                        </div>
                        <div class="d-flex justify-content-between">
                            <span class="text-muted">Completed:</span>
                            <strong>{{ $orders->where('status', 'completed')->count() }}</strong>
                        </div>
                    </div>
                </div>

                <div class="card shadow-sm">
                    <div class="card-body py-4">
                        <h6 class="card-title mb-4">Contact Info</h6>
                        @if($user->phone)
                            <div class="d-flex align-items-center mb-3">
                                <i class="bi bi-telephone me-2 text-muted"></i>
                                <span class="small">{{ $user->phone }}</span>
                            </div>
                        @endif
                        @if($user->address)
                            <div class="d-flex align-items-start">
                                <i class="bi bi-geo-alt me-2 text-muted mt-1"></i>
                                <span class="small" title="{{ $user->address }}">{{ Str::limit($user->address, 50) }}</span>
                            </div>
                        @endif
                        @if(!$user->phone && !$user->address)
                            <p class="text-muted small mb-0">Update your contact information in profile settings.</p>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Main Content -->
            <div class="col-lg-9">
                <!-- Success/Error Messages -->
                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                @if(session('error'))
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        {{ session('error') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif


                <!-- Profile Information -->
                <div class="card shadow-sm mb-5">
                    <div class="card-header bg-g py-3">
                        <h5 class="mb-0">Edit Profile Information</h5>
                    </div>
                    <div class="card-body py-4">
                        <form method="POST" action="{{ route('profile.update') }}">
                            @csrf
                            @method('PATCH')

                            <div class="row mb-4">
                                <div class="col-md-6 mb-4">
                                    <label for="name" class="form-label">Full Name</label>
                                    <input type="text" class="form-control @error('name') is-invalid @enderror"
                                           id="name" name="name" value="{{ old('name', $user->name) }}" required>
                                    @error('name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-6 mb-4">
                                    <label for="email" class="form-label">Email Address</label>
                                    <input type="email" class="form-control @error('email') is-invalid @enderror"
                                           id="email" name="email" value="{{ old('email', $user->email) }}" required>
                                    @error('email')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-4">
                                <div class="col-md-6 mb-4">
                                    <label for="phone" class="form-label">Phone Number</label>
                                    <input type="tel" class="form-control @error('phone') is-invalid @enderror"
                                           id="phone" name="phone" value="{{ old('phone', $user->phone) }}"
                                           placeholder="e.g., +977-9800000000">
                                    @error('phone')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    <div class="form-text">Enter your phone number for delivery updates.</div>
                                </div>

                                <div class="col-md-6 mb-4">
                                    <label for="address" class="form-label">Delivery Address</label>
                                    <textarea class="form-control @error('address') is-invalid @enderror"
                                              id="address" name="address" rows="3"
                                              placeholder="Enter your full delivery address">{{ old('address', $user->address) }}</textarea>
                                    @error('address')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    <div class="form-text">This will be your default delivery address.</div>
                                </div>
                            </div>

                            <div class="d-flex justify-content-between pt-3">
                                <button type="submit" class="btn btn-primary px-4 py-2">Update Profile</button>
                                <a href="#" class="btn btn-outline-secondary px-4 py-2" data-bs-toggle="modal" data-bs-target="#changePasswordModal">
                                    Change Password
                                </a>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Order History -->
                <div class="card shadow-sm">
                    <div class="card-header bg-black d-flex justify-content-between align-items-center py-3">
                        <h5 class="mb-0">Order History</h5>
                        <span class="badge bg-primary">{{ $orders->total() }} Total Orders</span>
                    </div>
                    <div class="card-body py-4">
                        @if($orders->count() > 0)
                            <div class="row">
                                @foreach($orders as $order)
                                    <div class="col-12 mb-4">
                                        <div class="card border">
                                            <div class="card-body py-3">
                                                <div class="row align-items-center">
                                                    <div class="col-md-2">
                                                        <h6 class="mb-1">{{ $order->order_number }}</h6>
                                                        <small class="text-muted">{{ $order->created_at->format('M j, Y') }}</small>
                                                    </div>

                                                    <div class="col-md-3">
                                                        <strong>{{ $order->restaurant->name }}</strong>
                                                        <br>
                                                        <small class="text-muted">{{ $order->orderItems->count() }} items</small>
                                                    </div>

                                                    <div class="col-md-2">
                                                        <h6 class="mb-0">RS.{{ number_format($order->total_amount, 2) }}</h6>
                                                        <small class="text-muted">{{ ucfirst($order->payment_method) }}</small>
                                                    </div>

                                                    <div class="col-md-2">
                                                        @php
                                                            $statusColors = [
                                                                'confirmed' => 'warning',
                                                                'preparing' => 'info',
                                                                'ready' => 'primary',
                                                                'completed' => 'success',
                                                                'cancelled' => 'danger'
                                                            ];
                                                        @endphp
                                                        <span class="badge bg-{{ $statusColors[$order->status] ?? 'secondary' }}">
                                                            {{ ucfirst($order->status) }}
                                                        </span>
                                                        @if($order->deliveryStaff)
                                                            <br>
                                                            <small class="text-muted">{{ $order->deliveryStaff->name }}</small>
                                                        @endif
                                                    </div>

                                                    <div class="col-md-3">
                                                        <div class="btn-group" role="group">
                                                            <button type="button" class="btn btn-sm btn-outline-primary"
                                                                    data-bs-toggle="modal"
                                                                    data-bs-target="#orderModal{{ $order->id }}">
                                                                View Details
                                                            </button>

                                                            @if($order->status === 'confirmed')
                                                                <form method="POST" action="{{ route('profile.orders.cancel', $order->id) }}"
                                                                      class="d-inline"
                                                                      onsubmit="return confirm('Are you sure you want to cancel this order?')">
                                                                    @csrf
                                                                    <button type="submit" class="btn btn-sm btn-outline-danger">
                                                                        Cancel
                                                                    </button>
                                                                </form>
                                                            @endif
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Order Details Modal -->
                                    <div class="modal fade" id="orderModal{{ $order->id }}" tabindex="-1">
                                        <div class="modal-dialog modal-lg">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title">Order Details - {{ $order->order_number }}</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <div class="row mb-3">
                                                        <div class="col-md-6">
                                                            <h6>Order Information</h6>
                                                            <p class="mb-1"><strong>Restaurant:</strong> {{ $order->restaurant->name }}</p>
                                                            <p class="mb-1"><strong>Order Date:</strong> {{ $order->created_at->format('M j, Y \a\t g:i A') }}</p>
                                                            <p class="mb-1"><strong>Status:</strong>
                                                                <span class="badge bg-{{ $statusColors[$order->status] ?? 'secondary' }}">
                                                                    {{ ucfirst($order->status) }}
                                                                </span>
                                                            </p>
                                                            <p class="mb-1"><strong>Payment:</strong> {{ ucfirst($order->payment_method) }}</p>
                                                            <p class="mb-1"><strong>Phone:</strong> {{ $order->customer_phone }}</p>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <h6>Delivery Information</h6>
                                                            @if($order->deliveryStaff)
                                                                <p class="mb-1"><strong>Delivery Staff:</strong> {{ $order->deliveryStaff->name }}</p>
                                                                <p class="mb-1"><strong>Status:</strong>
                                                                    @if($order->status === 'preparing')
                                                                        Being prepared
                                                                    @elseif($order->status === 'ready')
                                                                        Ready for delivery
                                                                    @elseif($order->status === 'completed')
                                                                        Delivered
                                                                    @else
                                                                        Pending assignment
                                                                    @endif
                                                                </p>
                                                            @else
                                                                <p class="text-muted">Delivery staff not assigned yet</p>
                                                            @endif
                                                        </div>
                                                    </div>

                                                    <h6>Order Items</h6>
                                                    <div class="table-responsive">
                                                        <table class="table table-sm">
                                                            <thead>
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
                                                                        <td>{{ $item->menu_name }}</td>
                                                                        <td>{{ $item->quantity }}</td>
                                                                        <td>RS.{{ number_format($item->unit_price, 2) }}</td>
                                                                        <td>RS.{{ number_format($item->total_price, 2) }}</td>
                                                                    </tr>
                                                                @endforeach
                                                            </tbody>
                                                            <tfoot>
                                                                <tr>
                                                                    <th colspan="3">Total Amount</th>
                                                                    <th>RS.{{ number_format($order->total_amount, 2) }}</th>
                                                                </tr>
                                                            </tfoot>
                                                        </table>
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>

                            <!-- Pagination -->
                            <div class="d-flex justify-content-center">
                                {{ $orders->links() }}
                            </div>
                        @else
                            <div class="text-center py-5">
                                <i class="bi bi-cart-x fs-1 text-muted"></i>
                                <h5 class="text-muted mt-3">No orders found</h5>
                                <p class="text-muted">You haven't placed any orders yet.</p>
                                <a href="{{ route('home') }}" class="btn btn-primary">Start Ordering</a>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Change Password Modal -->
<div class="modal fade" id="changePasswordModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Change Password</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form method="POST" action="{{ route('password.update') }}">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="current_password" class="form-label">Current Password</label>
                        <input type="password" class="form-control @error('current_password', 'updatePassword') is-invalid @enderror"
                               id="current_password" name="current_password" required>
                        @error('current_password', 'updatePassword')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="password" class="form-label">New Password</label>
                        <input type="password" class="form-control @error('password', 'updatePassword') is-invalid @enderror"
                               id="password" name="password" required>
                        @error('password', 'updatePassword')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="password_confirmation" class="form-label">Confirm New Password</label>
                        <input type="password" class="form-control"
                               id="password_confirmation" name="password_confirmation" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Update Password</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
.card {
    border: none;
    border-radius: 12px;
    transition: all 0.3s ease;
}

.card:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 15px rgba(0,0,0,0.1);
}

.badge {
    font-size: 0.75rem;
    padding: 0.5rem 0.75rem;
}

.btn-group .btn {
    border-radius: 6px;
}

.btn-group .btn:not(:last-child) {
    margin-right: 5px;
}

.modal-content {
    border-radius: 12px;
}

.table th {
    border-top: none;
    font-weight: 600;
}

.form-control {
    border-radius: 8px;
    padding: 0.75rem;
    border: 1px solid #e3e6f0;
}

.form-control:focus {
    border-color: #4e73df;
    box-shadow: 0 0 0 0.2rem rgba(78, 115, 223, 0.25);
}

.btn {
    border-radius: 8px;
    font-weight: 500;
}

.alert {
    border-radius: 8px;
    border: none;
}

/* Section spacing improvements */
.profile-section {
    margin-bottom: 2rem;
}

/* Card header spacing */
.card-header {
    border-bottom: 1px solid #000000;
    background-color: #000000;
}

/* Better spacing for form elements */
.form-label {
    font-weight: 600;
    color: #5a5c69;
    margin-bottom: 0.75rem;
}

.form-text {
    font-size: 0.875rem;
    color: #6c757d;
    margin-top: 0.5rem;
}

/* Order card improvements */
.order-card {
    transition: all 0.2s ease;
}

.order-card:hover {
    border-color: #4e73df !important;
    box-shadow: 0 2px 8px rgba(0,0,0,0.1);
}

/* Responsive improvements */
@media (max-width: 768px) {
    .col-lg-3 {
        margin-bottom: 2rem;
    }

    .card-body {
        padding: 1.5rem !important;
    }
}
</style>
@endpush