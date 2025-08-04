@extends('layouts.dashboard.master')
@section('title','Contact Messages')
@section('content')
    <div class="container mt-4">
        <h4>Contact Messages</h4>

        <div class="d-flex align-items-center position-relative my-1 mb-3">
            <input type="text" class="form-control table-search form-control-solid w-250px ps-15" placeholder="Search contacts..." />
        </div>

        <table id="contactDatatable" class="table table-bordered table-striped table-hover align-middle">
            <thead class="bg-light-primary text-dark">
            <tr>
                <th>Status</th>
                <th>Name</th>
                <th>Email</th>
                <th>Subject</th>
                <th>Date</th>
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
            console.log('Contact DataTable ready');
            const BASE_URL = "{{ url('/') }}";
            const CSRF_TOKEN = "{{ csrf_token() }}";
            let table = $('#contactDatatable').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: BASE_URL + '/dashboard/contacts',
                    type: 'GET',
                    data: function(d) {
                        d._token = CSRF_TOKEN;
                    },
                    error: function(xhr, textStatus, errorThrown) {
                        console.error('AJAX error:', errorThrown);
                    }
                },
                columns: [
                    { data: 'status', name: 'status', orderable: false },
                    { data: 'name', name: 'name' },
                    { data: 'email', name: 'email' },
                    { data: 'subject', name: 'subject' },
                    { data: 'created_at', name: 'created_at' },
                    { data: 'action', name: 'action', orderable: false, searchable: false },
                ],
                order: [[4, 'desc']], // Sort by date descending
                lengthMenu: [[25, 50, 100, 500], [25, 50, 100, 500]],
                pageLength: 25,
                language: {
                    emptyTable: 'No contact messages found.'
                },
                dom: '<"top">rt<"bottom d-md-flex justify-content-between"lip><"clear">',
                fixedHeader: true,
            });

            // Global search input
            $('.table-search').on('keyup', function() {
                table.search(this.value).draw();
            });
        });
    </script>
@endpush