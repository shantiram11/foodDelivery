@extends('layouts.dashboard.master')
@section('title','All Orders')
@section('content')
    <div class="container mt-4">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h4>All Orders</h4>
            <div class="btn-group" role="group">
                <a href="{{ route('orders.index') }}" class="btn btn-outline-primary {{ request()->routeIs('orders.index') ? 'active' : '' }}">
                    All Orders
                </a>
                <a href="{{ route('orders.pending') }}" class="btn btn-outline-warning {{ request()->routeIs('orders.pending') ? 'active' : '' }}">
                    Pending
                </a>
                <a href="{{ route('orders.completed') }}" class="btn btn-outline-success {{ request()->routeIs('orders.completed') ? 'active' : '' }}">
                    Completed
                </a>
                <a href="{{ route('orders.declined') }}" class="btn btn-outline-danger {{ request()->routeIs('orders.declined') ? 'active' : '' }}">
                    Cancelled
                </a>
            </div>
        </div>

        <div class="d-flex align-items-center position-relative my-1 mb-3">
            <input type="text" class="form-control table-search form-control-solid w-250px ps-15" placeholder="Search orders..." />
        </div>

        <table id="orderDatatable" class="table table-bordered table-striped table-hover align-middle">
            <thead class="bg-light-primary text-dark">
            <tr>
                <th>Order #</th>
                <th>Customer</th>
                <th>Restaurant</th>
                <th>Items</th>
                <th>Total</th>
                <th>Delivery Staff</th>
                <th>Status</th>
                <th>Date</th>
                <th class="min-w-100px">Actions</th>
            </tr>
            </thead>
            <tbody>
            <!-- DataTables will populate data here -->
            </tbody>
        </table>
    </div>

    <!-- Status Update Success Modal -->
    <div class="modal fade" id="statusUpdateModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="statusUpdateModalLabel">Status Updated</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <p id="statusUpdateMessage">Order status updated successfully!</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" data-bs-dismiss="modal">OK</button>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        $(document).ready(function() {
            console.log('Orders DataTable ready');
            const BASE_URL = "{{ url('/') }}";
            const CSRF_TOKEN = "{{ csrf_token() }}";

            let table = $('#orderDatatable').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: BASE_URL + '/dashboard/orders',
                    type: 'GET',
                    data: function(d) {
                        d._token = CSRF_TOKEN;
                    },
                    error: function(xhr, textStatus, errorThrown) {
                        console.error('AJAX error:', errorThrown);
                    }
                },
                columns: [
                    { data: 'order_number', name: 'order_number' },
                    { data: 'customer', name: 'customer' },
                    { data: 'restaurant', name: 'restaurant' },
                    { data: 'items_count', name: 'items_count', orderable: false },
                    { data: 'total_amount', name: 'total_amount' },
                    { data: 'delivery_staff', name: 'delivery_staff', orderable: false },
                    { data: 'status', name: 'status', orderable: false },
                    { data: 'created_at', name: 'created_at' },
                    { data: 'action', name: 'action', orderable: false, searchable: false },
                ],
                order: [[7, 'desc']], // Sort by date descending
                lengthMenu: [[25, 50, 100, 500], [25, 50, 100, 500]],
                pageLength: 25,
                language: {
                    emptyTable: 'No orders found.'
                },
                dom: '<"top">rt<"bottom d-md-flex justify-content-between"lip><"clear">',
                fixedHeader: true,
            });

            // Global search input
            $('.table-search').on('keyup', function() {
                table.search(this.value).draw();
            });

            // Handle status update buttons
            $(document).on('click', '.update-status', function() {
                const orderId = $(this).data('id');
                const newStatus = $(this).data('status');
                const button = $(this);

                // Disable button and show loading
                button.prop('disabled', true);
                const originalHtml = button.html();
                button.html('<i class="bi bi-hourglass-split"></i>');

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

                            // Refresh the table
                            table.ajax.reload(null, false);
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
        });
    </script>
@endpush
