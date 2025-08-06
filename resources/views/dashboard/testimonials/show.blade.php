@extends('layouts.dashboard.master')
@section('title','Testimonial Details')
@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h4 class="card-title mb-0">Testimonial Details</h4>
                        <div>
                            <a href="{{ route('dashboard.testimonials.edit', $testimonial) }}" class="btn btn-primary">
                                <i class="fas fa-edit"></i> Edit
                            </a>
                            <a href="{{ route('dashboard.testimonials.index') }}" class="btn btn-secondary">
                                <i class="fas fa-arrow-left"></i> Back to List
                            </a>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-8">
                                <table class="table table-bordered">
                                    <tr>
                                        <th width="200">Customer Name</th>
                                        <td>{{ $testimonial->name }}</td>
                                    </tr>
                                    <tr>
                                        <th>Customer Title</th>
                                        <td>{{ $testimonial->title }}</td>
                                    </tr>
                                    <tr>
                                        <th>Testimonial Content</th>
                                        <td>
                                            <div class="p-3 bg-light rounded">
                                                <i class="bi bi-quote text-primary"></i>
                                                {{ $testimonial->content }}
                                                <i class="bi bi-quote text-primary float-end" style="transform: rotate(180deg);"></i>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>Rating</th>
                                        <td>
                                            @for($i = 1; $i <= 5; $i++)
                                                @if($i <= $testimonial->rating)
                                                    <i class="fas fa-star text-warning"></i>
                                                @else
                                                    <i class="far fa-star text-muted"></i>
                                                @endif
                                            @endfor
                                            <span class="ms-2">({{ $testimonial->rating }}/5)</span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>Status</th>
                                        <td>
                                            <span class="badge {{ $testimonial->is_active ? 'bg-success' : 'bg-secondary' }}">
                                                {{ $testimonial->is_active ? 'Active' : 'Inactive' }}
                                            </span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>Sort Order</th>
                                        <td>{{ $testimonial->sort_order }}</td>
                                    </tr>
                                    <tr>
                                        <th>Created By</th>
                                        <td>{{ $testimonial->creator->name ?? 'N/A' }}</td>
                                    </tr>
                                    <tr>
                                        <th>Created At</th>
                                        <td>{{ $testimonial->created_at->format('M d, Y g:i A') }}</td>
                                    </tr>
                                    <tr>
                                        <th>Last Updated</th>
                                        <td>{{ $testimonial->updated_at->format('M d, Y g:i A') }}</td>
                                    </tr>
                                </table>
                            </div>
                            <div class="col-md-4">
                                <div class="text-center">
                                    <h6>Customer Photo</h6>
                                    @if($testimonial->image)
                                        <img src="{{ Storage::url($testimonial->image) }}"
                                             alt="{{ $testimonial->name }}"
                                             class="img-thumbnail"
                                             style="max-width: 100%; height: auto; border-radius: 10px;">
                                    @else
                                        <div class="bg-secondary text-white d-flex align-items-center justify-content-center mx-auto"
                                             style="width: 150px; height: 150px; border-radius: 50%; font-size: 3rem;">
                                            {{ substr($testimonial->name, 0, 1) }}
                                        </div>
                                        <small class="text-muted d-block mt-2">No image uploaded</small>
                                    @endif
                                </div>

                                <div class="mt-4">
                                    <h6>Frontend Preview</h6>
                                    <div class="card">
                                        <div class="card-body">
                                            <div class="testimonial-preview p-3" style="background: #f8f9fa; border-radius: 0.5rem;">
                                                <p class="mb-3 fst-italic">"{{ Str::limit($testimonial->content, 100) }}"</p>
                                                @if($testimonial->image)
                                                    <img src="{{ Storage::url($testimonial->image) }}"
                                                         alt="{{ $testimonial->name }}"
                                                         class="testimonial-img rounded-circle mb-2"
                                                         style="width: 60px; height: 60px; object-fit: cover;">
                                                @endif
                                                <h6 class="mb-1">{{ $testimonial->name }}</h6>
                                                <small class="text-muted">{{ $testimonial->title }}</small>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="mt-3">
                                    <form action="{{ route('dashboard.testimonials.toggle-status', $testimonial) }}"
                                          method="POST" class="d-inline w-100">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit"
                                                class="btn {{ $testimonial->is_active ? 'btn-warning' : 'btn-success' }} w-100">
                                            <i class="fas {{ $testimonial->is_active ? 'fa-eye-slash' : 'fa-eye' }}"></i>
                                            {{ $testimonial->is_active ? 'Deactivate' : 'Activate' }}
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection