@extends('layouts.dashboard.master')
@section('title','Restaurant Details')
@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h4 class="card-title mb-0">Restaurant Details</h4>
                        <div>
                            <a href="{{ route('restaurants.edit', $restaurant->id) }}" class="btn btn-primary">
                                <i class="fas fa-edit"></i> Edit
                            </a>
                            <a href="{{ route('restaurants.index') }}" class="btn btn-secondary">
                                <i class="fas fa-arrow-left"></i> Back to List
                            </a>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-8">
                                <table class="table table-bordered">
                                    <tr>
                                        <th width="200">Name</th>
                                        <td>{{ $restaurant->name }}</td>
                                    </tr>
                                    <tr>
                                        <th>Description</th>
                                        <td>{{ $restaurant->description }}</td>
                                    </tr>
                                    <tr>
                                        <th>Address</th>
                                        <td>{{ $restaurant->address }}</td>
                                    </tr>
                                    <tr>
                                        <th>Phone</th>
                                        <td>
                                            <a href="tel:{{ $restaurant->phone }}">{{ $restaurant->phone }}</a>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>Email</th>
                                        <td>
                                            <a href="mailto:{{ $restaurant->email }}">{{ $restaurant->email }}</a>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>Opening Hours</th>
                                        <td>
                                            {{ $restaurant->opening_time ? $restaurant->opening_time->format('H:i') : 'N/A' }} - 
                                            {{ $restaurant->closing_time ? $restaurant->closing_time->format('H:i') : 'N/A' }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>Status</th>
                                        <td>
                                            @if($restaurant->status === 'active')
                                                <span class="badge bg-success">Active</span>
                                            @else
                                                <span class="badge bg-danger">Inactive</span>
                                            @endif
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>Rating</th>
                                        <td>
                                            @if($restaurant->rating)
                                                <div class="d-flex align-items-center">
                                                    <span class="me-2">{{ $restaurant->rating }}/5</span>
                                                    <div class="text-warning">
                                                        @for($i = 1; $i <= 5; $i++)
                                                            @if($i <= $restaurant->rating)
                                                                <i class="fas fa-star"></i>
                                                            @else
                                                                <i class="far fa-star"></i>
                                                            @endif
                                                        @endfor
                                                    </div>
                                                </div>
                                            @else
                                                <span class="text-muted">No rating yet</span>
                                            @endif
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>Created At</th>
                                        <td>{{ $restaurant->created_at->format('d M Y, H:i') }}</td>
                                    </tr>
                                    <tr>
                                        <th>Updated At</th>
                                        <td>{{ $restaurant->updated_at->format('d M Y, H:i') }}</td>
                                    </tr>
                                </table>
                            </div>
                            <div class="col-md-4">
                                @if($restaurant->image)
                                    <div class="mb-3">
                                        <h5>Restaurant Image</h5>
                                        <img src="{{ asset('uploads/restaurants/' . $restaurant->image) }}" 
                                             alt="{{ $restaurant->name }}" 
                                             class="img-fluid rounded shadow">
                                    </div>
                                @else
                                    <div class="mb-3">
                                        <h5>Restaurant Image</h5>
                                        <div class="bg-light p-4 text-center rounded">
                                            <i class="fas fa-image fa-3x text-muted"></i>
                                            <p class="text-muted mt-2">No image uploaded</p>
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection 