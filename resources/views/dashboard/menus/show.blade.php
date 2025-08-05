@extends('layouts.dashboard.master')
@section('title','Menu Details')
@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h4 class="card-title mb-0">Menu Details</h4>
                        <div>
                            <a href="{{ route('menus.edit', $menu->id) }}" class="btn btn-primary">
                                <i class="fas fa-edit"></i> Edit
                            </a>
                            <a href="{{ route('menus.index') }}" class="btn btn-secondary">
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
                                        <td>{{ $menu->name }}</td>
                                    </tr>
                                    <tr>
                                        <th>Description</th>
                                        <td>{{ $menu->description ?: 'No description provided' }}</td>
                                    </tr>
                                    <tr>
                                        <th>Price</th>
                                        <td>
                                            <span class="h5 text-success">RS.{{ number_format($menu->price, 2) }}</span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>Restaurant</th>
                                        <td>
                                            <a href="{{ route('restaurants.show', $menu->restaurant->id) }}" class="text-decoration-none">
                                                {{ $menu->restaurant->name }}
                                            </a>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>Restaurant Address</th>
                                        <td>{{ $menu->restaurant->address }}</td>
                                    </tr>
                                    <tr>
                                        <th>Restaurant Phone</th>
                                        <td>
                                            <a href="tel:{{ $menu->restaurant->phone }}">{{ $menu->restaurant->phone }}</a>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>Created At</th>
                                        <td>{{ $menu->created_at->format('d M Y, H:i') }}</td>
                                    </tr>
                                    <tr>
                                        <th>Updated At</th>
                                        <td>{{ $menu->updated_at->format('d M Y, H:i') }}</td>
                                    </tr>
                                </table>
                            </div>
                            <div class="col-md-4">
                                @if($menu->image)
                                    <div class="mb-3">
                                        <h5>Menu Image</h5>
                                        <img src="{{ asset('uploads/menus/' . $menu->image) }}"
                                             alt="{{ $menu->name }}"
                                             class="img-fluid rounded shadow">
                                    </div>
                                @else
                                    <div class="mb-3">
                                        <h5>Menu Image</h5>
                                        <div class="bg-light p-4 text-center rounded">
                                            <i class="fas fa-utensils fa-3x text-muted"></i>
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