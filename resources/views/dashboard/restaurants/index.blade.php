@extends('layouts.dashboard.master')
@section('title','All Restaurants')
@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h4 class="card-title mb-0">All Restaurants</h4>
                        <a href="{{ route('restaurants.create') }}" class="btn btn-primary">
                            <i class="fas fa-plus"></i> Add Restaurant
                        </a>
                    </div>
                    <div class="card-body">
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

                        <div class="table-responsive">
                            <table class="table table-striped" id="restaurantsTable">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Name</th>
                                        <th>Category</th>
                                        <th>Address</th>
                                        <th>Phone</th>
                                        <th>Status</th>
                                        <th>Rating</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        $(document).ready(function() {
            $('#restaurantsTable').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: "{{ route('restaurants.index') }}",
                    type: 'GET'
                },
                columns: [
                    { data: 'id', name: 'id' },
                    { data: 'name', name: 'name' },
                    { data: 'category', name: 'category' },
                    { data: 'address', name: 'address' },
                    { data: 'phone', name: 'phone' },
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
                    { data: 'action', name: 'action', orderable: false, searchable: false }
                ],
                order: [[0, 'desc']],
                pageLength: 10,
                responsive: true
            });
        });
    </script>
    @endpush
@endsection 