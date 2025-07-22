@extends('layouts.dashboard.master')
@section('title','Users')
@section('content')
    <div class="container mt-4">
        <h4>Users List</h4>

        <div class="d-flex align-items-center position-relative my-1 mb-3">
            <input type="text" class="form-control table-search form-control-solid w-250px ps-15" placeholder="Search users..." />
        </div>

        <table id="userDatatable" class="table table-bordered table-striped table-hover align-middle">
            <thead class="bg-light-primary text-dark">
            <tr>
                <th> Name</th>
                <th>Email</th>
                <th>Role</th>
                <th>Created Date</th>
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
            let table = $('#userDatatable').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: BASE_URL + '/dashboard/users',
                    type: 'GET',
                    data: function(d) {
                        d._token = CSRF_TOKEN; // if needed for GET (usually not)
                    },
                    error: function(xhr, textStatus, errorThrown) {
                        console.error('AJAX error:', errorThrown);
                    }
                },
                columns: [
                    { data: 'name', name: 'first_name' },
                    { data: 'email', name: 'email' },
                    { data: 'role', name: 'role' },
                    { data: 'created_at', name: 'created_at' },
                    { data: 'action', name: 'action', orderable: false, searchable: false },
                ],
                order: [[0, 'asc']],
                lengthMenu: [[25, 50, 100, 500], [25, 50, 100, 500]],
                pageLength: 25,
                language: {
                    emptyTable: 'No users found.'
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
