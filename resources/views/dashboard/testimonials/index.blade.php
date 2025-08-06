@extends('layouts.dashboard.master')
@section('title','Testimonials')
@section('content')
    <div class="container mt-4">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h4>Testimonials List</h4>
            <a href="{{ route('dashboard.testimonials.create') }}" class="btn btn-primary">
                <i class="fas fa-plus"></i> Add Testimonial
            </a>
        </div>

        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        <div class="d-flex align-items-center position-relative my-1 mb-3">
            <input type="text" class="form-control table-search form-control-solid w-250px ps-15" placeholder="Search testimonials..." />
        </div>

        <table id="testimonialDatatable" class="table table-bordered table-striped table-hover align-middle">
            <thead class="bg-light-primary text-dark">
            <tr>
                <th>Image</th>
                <th>Name</th>
                <th>Title</th>
                <th>Content</th>
                <th>Rating</th>
                <th>Status</th>
                <th>SortOrder</th>
                <th class="min-w-70px">Actions</th>
            </tr>
            </thead>
            <tbody>
            <!-- DataTables will populate data here -->
            </tbody>
        </table>
    </div>

@endsection

@push('styles')
<style>
    #testimonialDatatable th {
        background-color: #f8f9fa !important;
        border-color: #dee2e6 !important;
        font-weight: 600;
        font-size: 0.875rem;
        text-transform: uppercase;
        letter-spacing: 0.05em;
        padding: 0.75rem;
    }

    #testimonialDatatable td {
        padding: 0.75rem;
        vertical-align: middle;
        border-color: #dee2e6 !important;
    }

    .table-search {
        border-radius: 0.375rem;
        border: 1px solid #d1d5db;
        box-shadow: 0 1px 2px 0 rgba(0, 0, 0, 0.05);
    }

    .table-search:focus {
        border-color: #3b82f6;
        box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
        outline: none;
    }

        .btn-group .btn {
        margin-right: 2px;
        min-width: 32px;
    }

    .btn-group .btn:last-child {
        margin-right: 0;
    }

    .btn-group .btn i {
        font-size: 0.875rem;
    }
</style>
@endpush

@push('scripts')
    <script>
        $(document).ready(function() {
            console.log('ready');
            const BASE_URL = "{{ url('/') }}";
            const CSRF_TOKEN = "{{ csrf_token() }}";
            let table = $('#testimonialDatatable').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: BASE_URL + '/dashboard/testimonials',
                    type: 'GET',
                    data: function(d) {
                        d._token = CSRF_TOKEN;
                    },
                    error: function(xhr, textStatus, errorThrown) {
                        console.error('AJAX error:', errorThrown);
                    }
                },
                columns: [
                    {
                        data: 'image',
                        name: 'image',
                        orderable: false,
                        searchable: false,
                        render: function(data, type, row) {
                            if (data) {
                                return '<div class="d-flex justify-content-center"><img src="' + BASE_URL + '/storage/' + data + '" alt="' + row.name + '" style="width: 40px; height: 40px; object-fit: cover;" class="rounded-circle border"></div>';
                            } else {
                                return '<div class="d-flex justify-content-center"><div class="bg-primary text-white d-flex align-items-center justify-content-center rounded-circle" style="width: 40px; height: 40px; font-size: 1rem; font-weight: bold;">' + row.name.charAt(0).toUpperCase() + '</div></div>';
                            }
                        }
                    },
                    { data: 'name', name: 'name' },
                    { data: 'title', name: 'title' },
                    {
                        data: 'content',
                        name: 'content',
                        render: function(data, type, row) {
                            return data ? (data.length > 50 ? data.substring(0, 50) + '...' : data) : '';
                        }
                    },
                    {
                        data: 'rating',
                        name: 'rating',
                        orderable: false,
                        render: function(data, type, row) {
                            let stars = '';
                            for(let i = 1; i <= 5; i++) {
                                if(i <= data) {
                                    stars += '<i class="bi bi-star-fill text-warning me-1"></i>';
                                } else {
                                    stars += '<i class="bi bi-star text-muted me-1"></i>';
                                }
                            }
                            return '<div class="d-flex align-items-center">' + stars + '<span class="ms-1 small text-muted">(' + data + ')</span></div>';
                        }
                    },
                    {
                        data: 'is_active',
                        name: 'is_active',
                        render: function(data, type, row) {
                            let badgeClass = data ? 'bg-success' : 'bg-secondary';
                            let status = data ? 'Active' : 'Inactive';
                            return '<span class="badge ' + badgeClass + '">' + status + '</span>';
                        }
                    },
                    { data: 'sort_order', name: 'sort_order' },
                    {
                        data: 'action',
                        name: 'action',
                        orderable: false,
                        searchable: false,
                        width: '120px'
                    },
                ],
                order: [[6, 'asc']], // Sort by sort_order by default
                lengthMenu: [[25, 50, 100, 500], [25, 50, 100, 500]],
                pageLength: 25,
                language: {
                    emptyTable: 'No testimonials found.'
                },
                dom: '<"top">rt<"bottom d-md-flex justify-content-between"lip><"clear">',
                fixedHeader: true,
            });

            // Global search input
            $('.table-search').on('keyup', function() {
                table.search(this.value).draw();
            });
        });

        // Delete testimonial function
        function deleteTestimonial(id) {
            if (confirm('Are you sure you want to delete this testimonial?')) {
                // Create a form and submit it
                let form = document.createElement('form');
                form.method = 'POST';
                form.action = BASE_URL + '/dashboard/testimonials/' + id;
                form.style.display = 'none';

                // Add CSRF token
                let csrfInput = document.createElement('input');
                csrfInput.type = 'hidden';
                csrfInput.name = '_token';
                csrfInput.value = CSRF_TOKEN;
                form.appendChild(csrfInput);

                // Add method override
                let methodInput = document.createElement('input');
                methodInput.type = 'hidden';
                methodInput.name = '_method';
                methodInput.value = 'DELETE';
                form.appendChild(methodInput);

                document.body.appendChild(form);
                form.submit();
            }
        }

    </script>
@endpush