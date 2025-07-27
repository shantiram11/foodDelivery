@extends('layouts.dashboard.master')
@section('title','Restaurants')
@section('content')
    <div class="container mt-4">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h4>Restaurants List</h4>
            <a href="{{ route('restaurants.create') }}" class="btn btn-primary">
                <i class="fas fa-plus"></i> Add Restaurant
            </a>
        </div>

        @if(session('status'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                @if(session('status') == 'restaurant-created')
                    Restaurant created successfully!
                @elseif(session('status') == 'restaurant-updated')
                    Restaurant updated successfully!
                @elseif(session('status') == 'restaurant-deleted')
                    Restaurant deleted successfully!
                @endif
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        <div class="d-flex align-items-center position-relative my-1 mb-3">
            <input type="text" class="form-control table-search form-control-solid w-250px ps-15" placeholder="Search restaurants..." />
        </div>

        <table id="restaurantDatatable" class="table table-bordered table-striped table-hover align-middle">
            <thead class="bg-light-primary text-dark">
            <tr>
                <th>Name</th>
                <th>Address</th>
                <th>Phone</th>
                <th>Email</th>
                <th>Status</th>
                <th>Rating</th>
                <th class="min-w-70px">Actions</th>
            </tr>
            </thead>
            <tbody>
            <!-- DataTables will populate data here -->
            </tbody>
        </table>
    </div>

@endsection
@push('scripts')
    <script>
        $(document).ready(function() {
            console.log('ready');
            const BASE_URL = "{{ url('/') }}";
            const CSRF_TOKEN = "{{ csrf_token() }}";
            let table = $('#restaurantDatatable').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: BASE_URL + '/dashboard/restaurants',
                    type: 'GET',
                    data: function(d) {
                        d._token = CSRF_TOKEN; // if needed for GET (usually not)
                    },
                    error: function(xhr, textStatus, errorThrown) {
                        console.error('AJAX error:', errorThrown);
                    }
                },
                columns: [
                    { data: 'name', name: 'name' },
                    { data: 'address', name: 'address' },
                    { data: 'phone', name: 'phone' },
                    { data: 'email', name: 'email' },
                    { 
                        data: 'status', 
                        name: 'status',
                        render: function(data, type, row) {
                            return data === 'active' 
                                ? '<span class="badge bg-success">Active</span>' 
                                : '<span class="badge bg-danger">Inactive</span>';
                        }
                    },
                    { data: 'rating', name: 'rating' },
                    { data: 'action', name: 'action', orderable: false, searchable: false },
                ],
                order: [[0, 'asc']],
                lengthMenu: [[25, 50, 100, 500], [25, 50, 100, 500]],
                pageLength: 25,
                language: {
                    emptyTable: 'No restaurants found.'
                },
                dom: '<"top">rt<"bottom d-md-flex justify-content-between"lip><"clear">',
                fixedHeader: true,
            });

            // Global search input (your existing input with data-kt-customer-table-filter="search")
            $('.table-search').on('keyup', function() {
                table.search(this.value).draw();
            });
        });

    </script>
@endpush 