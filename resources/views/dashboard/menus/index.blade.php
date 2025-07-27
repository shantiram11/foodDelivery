@extends('layouts.dashboard.master')
@section('title','Menus')
@section('content')
    <div class="container mt-4">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h4>Menus List</h4>
            <a href="{{ route('menus.create') }}" class="btn btn-primary">
                <i class="fas fa-plus"></i> Add Menu
            </a>
        </div>

        @if(session('status'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                @if(session('status') == 'menu-created')
                    Menu created successfully!
                @elseif(session('status') == 'menu-updated')
                    Menu updated successfully!
                @elseif(session('status') == 'menu-deleted')
                    Menu deleted successfully!
                @endif
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        <div class="d-flex align-items-center position-relative my-1 mb-3">
            <div class="me-3">
                <select class="form-select w-200px" id="restaurant-filter">
                    <option value="">All Restaurants</option>
                    @foreach($restaurants as $restaurant)
                        <option value="{{ $restaurant->id }}">{{ $restaurant->name }}</option>
                    @endforeach
                </select>
            </div>
            <input type="text" class="form-control table-search form-control-solid w-250px ps-15" placeholder="Search menus..." />
        </div>

        <table id="menuDatatable" class="table table-bordered table-striped table-hover align-middle">
            <thead class="bg-light-primary text-dark">
            <tr>
                <th>Restaurant</th>
                <th>Menu Name</th>
                <th>Price</th>
                <th>Description</th>
                <th>Image</th>
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
            let table = $('#menuDatatable').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: BASE_URL + '/dashboard/menus',
                    type: 'GET',
                    data: function(d) {
                        d._token = CSRF_TOKEN; // if needed for GET (usually not)
                        d.restaurant_id = $('#restaurant-filter').val(); // Add restaurant filter
                    },
                    error: function(xhr, textStatus, errorThrown) {
                        console.error('AJAX error:', errorThrown);
                    }
                },
                columns: [
                    { data: 'restaurant_name', name: 'restaurant.name' },
                    { data: 'name', name: 'name' },
                    { 
                        data: 'price', 
                        name: 'price',
                        render: function(data, type, row) {
                            return '$' + parseFloat(data).toFixed(2);
                        }
                    },
                    { 
                        data: 'description', 
                        name: 'description',
                        render: function(data, type, row) {
                            return data ? (data.length > 50 ? data.substring(0, 50) + '...' : data) : '';
                        }
                    },
                    { 
                        data: 'image', 
                        name: 'image', 
                        orderable: false, 
                        searchable: false,
                        render: function(data, type, row) {
                            if (data) {
                                return '<img src="' + BASE_URL + '/uploads/menus/' + data + '" alt="Menu Image" style="width: 50px; height: 50px; object-fit: cover;" class="rounded">';
                            } else {
                                return '<span class="text-muted">No image</span>';
                            }
                        }
                    },
                    { data: 'action', name: 'action', orderable: false, searchable: false },
                ],
                order: [[0, 'asc']], // Sort by restaurant name by default
                lengthMenu: [[25, 50, 100, 500], [25, 50, 100, 500]],
                pageLength: 25,
                language: {
                    emptyTable: 'No menus found.'
                },
                dom: '<"top">rt<"bottom d-md-flex justify-content-between"lip><"clear">',
                fixedHeader: true,
            });

            // Global search input (your existing input with data-kt-customer-table-filter="search")
            $('.table-search').on('keyup', function() {
                table.search(this.value).draw();
            });

            // Restaurant filter
            $('#restaurant-filter').on('change', function() {
                table.ajax.reload();
            });
        });

    </script>
@endpush 