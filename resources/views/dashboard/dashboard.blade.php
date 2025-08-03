{{-- resources/views/dashboard.blade.php --}}
@extends('layouts.dashboard.master')


@section('title', 'Dashboard')

@section('content')
            <div class="row g-4 mb-4">
                <div class="col-sm-6 col-xl-3">
                    <div class="card text-white bg-primary">
                        <div class="card-body pb-0 d-flex justify-content-between align-items-start">
                            <div>
                                <div class="fs-4 fw-semibold">{{ $stats['total_users'] }}</div>
                                <div>{{ auth()->user()->isAdmin() ? 'Total Users' : 'Restaurant Staff' }}</div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-sm-6 col-xl-3">
                    <div class="card text-white bg-success">
                        <div class="card-body pb-0 d-flex justify-content-between align-items-start">
                            <div>
                                <div class="fs-4 fw-semibold">{{ $stats['total_menus'] }}</div>
                                <div>{{ auth()->user()->isAdmin() ? 'Total Menus' : 'Menu Items' }}</div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-sm-6 col-xl-3">
                    <div class="card text-white bg-warning">
                        <div class="card-body pb-0 d-flex justify-content-between align-items-start">
                            <div>
                                <div class="fs-4 fw-semibold">{{ $stats['total_orders'] }}</div>
                                <div>{{ auth()->user()->isAdmin() ? 'Total Orders' : 'Restaurant Orders' }}</div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-sm-6 col-xl-3">
                    <div class="card text-white bg-danger">
                        <div class="card-body pb-0 d-flex justify-content-between align-items-start">
                            <div>
                                <div class="fs-4 fw-semibold">{{ $stats['total_restaurants'] }}</div>
                                <div>{{ auth()->user()->isAdmin() ? 'Total Restaurants' : 'My Restaurant' }}</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            @if($stats['recent_orders']->count() > 0)
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <strong>{{ auth()->user()->isAdmin() ? 'Recent Orders' : 'Recent Restaurant Orders' }}</strong>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th>Order #</th>
                                            <th>Customer</th>
                                            @if(auth()->user()->isAdmin())
                                            <th>Restaurant</th>
                                            @endif
                                            <th>Status</th>
                                            <th>Total</th>
                                            <th>Date</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($stats['recent_orders'] as $order)
                                        <tr>
                                            <td>#{{ $order->order_number }}</td>
                                            <td>{{ $order->user->name }}</td>
                                            @if(auth()->user()->isAdmin())
                                            <td>{{ $order->restaurant->name }}</td>
                                            @endif
                                            <td>
                                                <span class="badge bg-{{ $order->status === 'completed' ? 'success' : ($order->status === 'cancelled' ? 'danger' : 'warning') }}">
                                                    {{ ucfirst($order->status) }}
                                                </span>
                                            </td>
                                            <td>${{ number_format($order->total_amount, 2) }}</td>
                                            <td>{{ $order->created_at->format('M d, Y') }}</td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @endif
@endsection
