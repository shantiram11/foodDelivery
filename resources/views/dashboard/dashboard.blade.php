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

            <!-- Order Charts Section -->
            <div class="row mb-4">
                <!-- Order Trend Chart -->
                <div class="col-lg-8 mb-4">
                    <div class="card shadow">
                        <div class="card-header">
                            <h6 class="card-title mb-0">
                                <svg class="icon me-2 text-primary">
                                    <use xlink:href="{{ asset('vendors/@coreui/icons/svg/free.svg') }}#cil-chart-line"></use>
                                </svg>
                                Daily Order Trends
                            </h6>
                            <small class="text-muted">Order Count by Status (Last 14 Days)</small>
                        </div>
                        <div class="card-body">
                            <div id="orderTrendChart"></div>
                        </div>
                    </div>
                </div>

                <!-- Order Status Chart -->
                <div class="col-lg-4 mb-4">
                    <div class="card shadow">
                        <div class="card-header">
                            <h6 class="card-title mb-0">
                                <svg class="icon me-2 text-info">
                                    <use xlink:href="{{ asset('vendors/@coreui/icons/svg/free.svg') }}#cil-chart"></use>
                                </svg>
                                Order Status Distribution
                            </h6>
                        </div>
                        <div class="card-body">
                            <div id="statusChart"></div>
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

@push('styles')
<style>
/* CoreUI Icon Styling */
.icon {
  width: 1rem;
  height: 1rem;
  fill: currentColor;
  display: inline-block;
}

/* Chart containers */
.card-header {
    background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
    border-bottom: 1px solid #dee2e6;
}

.card-title {
    font-weight: 600;
    color: #495057;
    display: flex;
    align-items: center;
}

.card {
    transition: all 0.3s ease;
}

.card:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 25px rgba(0,0,0,0.1) !important;
}
</style>
@endpush

@push('scripts')
<!-- ApexCharts -->
<script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>

<script>
$(document).ready(function() {
    // Order Trend Chart
    const orderTrendData = @json($chartData['orderTrend']);
    const orderLabels = Object.keys(orderTrendData);
    const completedData = Object.values(orderTrendData).map(day => day.completed);
    const confirmedData = Object.values(orderTrendData).map(day => day.confirmed);
    const preparingData = Object.values(orderTrendData).map(day => day.preparing);
    const cancelledData = Object.values(orderTrendData).map(day => day.cancelled);

    const orderTrendChart = new ApexCharts(document.querySelector("#orderTrendChart"), {
        series: [
            {
                name: 'Completed',
                data: completedData
            },
            {
                name: 'Confirmed',
                data: confirmedData
            },
            {
                name: 'Preparing',
                data: preparingData
            },
            {
                name: 'Cancelled',
                data: cancelledData
            }
        ],
        chart: {
            height: 350,
            type: 'area',
            stacked: false,
            toolbar: {
                show: true
            },
            dropShadow: {
                enabled: true,
                color: '#000',
                top: 18,
                left: 7,
                blur: 10,
                opacity: 0.2
            }
        },
        colors: ['#28a745', '#17a2b8', '#fd7e14', '#dc3545'],
        stroke: {
            width: [3, 3, 3, 3],
            curve: 'smooth'
        },
        fill: {
            type: 'gradient',
            gradient: {
                shade: 'light',
                type: "vertical",
                shadeIntensity: 0.25,
                gradientToColors: undefined,
                inverseColors: true,
                opacityFrom: 0.85,
                opacityTo: 0.15,
                stops: [0, 100]
            }
        },
        markers: {
            size: 6,
            strokeWidth: 2,
            strokeColors: ['#ffffff', '#ffffff', '#ffffff', '#ffffff'],
            fillColors: ['#28a745', '#17a2b8', '#fd7e14', '#dc3545'],
            hover: {
                size: 8
            }
        },
        labels: orderLabels,
        xaxis: {
            type: 'category',
            labels: {
                style: {
                    colors: '#666',
                    fontSize: '12px'
                }
            }
        },
        yaxis: {
            title: {
                text: 'Number of Orders',
                style: {
                    color: '#666',
                    fontSize: '14px'
                }
            },
            min: 0,
            labels: {
                style: {
                    colors: '#666',
                    fontSize: '12px'
                }
            }
        },
        tooltip: {
            shared: true,
            intersect: false,
            theme: 'dark',
            style: {
                fontSize: '12px'
            },
            y: {
                formatter: function (y) {
                    if (typeof y !== "undefined") {
                        return y.toFixed(0) + " orders";
                    }
                    return y;
                }
            }
        },
        legend: {
            position: 'top',
            horizontalAlign: 'center',
            fontSize: '14px',
            fontFamily: 'Helvetica, Arial',
            markers: {
                width: 12,
                height: 12,
                strokeWidth: 0,
                strokeColor: '#fff',
                fillColors: ['#28a745', '#17a2b8', '#fd7e14', '#dc3545'],
                radius: 12
            }
        },
        grid: {
            strokeDashArray: 3,
            borderColor: '#f1f1f1',
            row: {
                colors: ['transparent', 'transparent'],
                opacity: 0.5
            }
        },
        plotOptions: {
            area: {
                fillTo: 'origin'
            }
        },
        dataLabels: {
            enabled: false
        }
    });
    orderTrendChart.render();

    // Order Status Chart
    const statusData = @json($chartData['orderStatus']);
    const statusLabels = Object.keys(statusData).map(key => statusData[key].status.charAt(0).toUpperCase() + statusData[key].status.slice(1));
    const statusCounts = Object.values(statusData).map(status => status.count);

    // Define color mapping to ensure consistency
    const statusColors = {
        'completed': '#28a745',    // Green
        'confirmed': '#17a2b8',    // Blue
        'preparing': '#fd7e14',    // Orange
        'cancelled': '#dc3545',    // Red
        'pending': '#ffc107'       // Yellow (fallback)
    };

    // Map colors based on status order
    const chartColors = statusLabels.map(label => {
        const status = label.toLowerCase();
        return statusColors[status] || '#6c757d'; // Default gray if status not found
    });

    const statusChart = new ApexCharts(document.querySelector("#statusChart"), {
        series: statusCounts,
        chart: {
            type: 'donut',
            height: 350
        },
        labels: statusLabels,
        colors: chartColors,
        responsive: [{
            breakpoint: 480,
            options: {
                chart: {
                    width: 200
                },
                legend: {
                    position: 'bottom'
                }
            }
        }],
        legend: {
            position: 'bottom'
        }
    });
    statusChart.render();
});
</script>

<style>
/* Dark mode text color fixes for dashboard */
[data-coreui-theme="dark"] .card-title,
[data-coreui-theme="dark"] .card-header h6,
[data-coreui-theme="dark"] .card-header strong,
[data-coreui-theme="dark"] .breadcrumb-item,
[data-coreui-theme="dark"] .breadcrumb-item a,
[data-coreui-theme="dark"] .text-muted,
[data-coreui-theme="dark"] .form-label,
[data-coreui-theme="dark"] .dropdown-item,
[data-coreui-theme="dark"] .btn {
  color: inherit !important;
}

/* Dark mode specific overrides */
[data-coreui-theme="dark"] .text-gray-800,
[data-coreui-theme="dark"] .card-title,
[data-coreui-theme="dark"] .card-header h6,
[data-coreui-theme="dark"] .card-header strong,
[data-coreui-theme="dark"] .breadcrumb-item,
[data-coreui-theme="dark"] .breadcrumb-item a,
[data-coreui-theme="dark"] .text-muted,
[data-coreui-theme="dark"] .form-label,
[data-coreui-theme="dark"] .dropdown-item {
  color: #ffffff !important;
}

[data-coreui-theme="dark"] .text-muted {
  color: #adb5bd !important;
}

[data-coreui-theme="dark"] .card-body {
  color: #ffffff !important;
}

[data-coreui-theme="dark"] .card-header {
  color: #ffffff !important;
}

/* Ensure chart text is visible in dark mode */
[data-coreui-theme="dark"] .apexcharts-text,
[data-coreui-theme="dark"] .apexcharts-title-text,
[data-coreui-theme="dark"] .apexcharts-legend-text {
  fill: #ffffff !important;
  color: #ffffff !important;
}

[data-coreui-theme="dark"] .apexcharts-xaxis-label,
[data-coreui-theme="dark"] .apexcharts-yaxis-label {
  fill: #adb5bd !important;
}

/* Fix chart data labels and tooltips */
[data-coreui-theme="dark"] .apexcharts-data-labels text,
[data-coreui-theme="dark"] .apexcharts-datalabel,
[data-coreui-theme="dark"] .apexcharts-datalabel-label,
[data-coreui-theme="dark"] .apexcharts-datalabel-value {
  fill: #ffffff !important;
  color: #ffffff !important;
}

/* Fix chart tooltip text */
[data-coreui-theme="dark"] .apexcharts-tooltip {
  background-color: #2b3035 !important;
  border-color: #495057 !important;
  color: #ffffff !important;
}

[data-coreui-theme="dark"] .apexcharts-tooltip-title,
[data-coreui-theme="dark"] .apexcharts-tooltip-y-label,
[data-coreui-theme="dark"] .apexcharts-tooltip-y-value {
  color: #ffffff !important;
}

/* Fix chart grid lines and axis lines */
[data-coreui-theme="dark"] .apexcharts-gridline {
  stroke: #495057 !important;
}

[data-coreui-theme="dark"] .apexcharts-xaxis line,
[data-coreui-theme="dark"] .apexcharts-yaxis line {
  stroke: #495057 !important;
}

/* Fix chart background */
[data-coreui-theme="dark"] .apexcharts-canvas {
  background-color: transparent !important;
}

[data-coreui-theme="dark"] .apexcharts-svg {
  background-color: transparent !important;
}

/* Fix chart annotations and markers */
[data-coreui-theme="dark"] .apexcharts-annotation-label,
[data-coreui-theme="dark"] .apexcharts-annotation-text {
  fill: #ffffff !important;
  color: #ffffff !important;
}

/* Fix chart zoom controls */
[data-coreui-theme="dark"] .apexcharts-zoom-icon,
[data-coreui-theme="dark"] .apexcharts-zoom-in-icon,
[data-coreui-theme="dark"] .apexcharts-zoom-out-icon,
[data-coreui-theme="dark"] .apexcharts-reset-zoom-icon {
  fill: #adb5bd !important;
}

[data-coreui-theme="dark"] .apexcharts-zoom-icon:hover,
[data-coreui-theme="dark"] .apexcharts-zoom-in-icon:hover,
[data-coreui-theme="dark"] .apexcharts-zoom-out-icon:hover,
[data-coreui-theme="dark"] .apexcharts-reset-zoom-icon:hover {
  fill: #ffffff !important;
}

/* Fix chart menu icon */
[data-coreui-theme="dark"] .apexcharts-menu-icon {
  fill: #adb5bd !important;
}

[data-coreui-theme="dark"] .apexcharts-menu-icon:hover {
  fill: #ffffff !important;
}

/* Fix chart selection */
[data-coreui-theme="dark"] .apexcharts-selection {
  fill: rgba(13, 110, 253, 0.3) !important;
}

/* Fix chart crosshair */
[data-coreui-theme="dark"] .apexcharts-crosshair {
  stroke: #adb5bd !important;
}

/* Fix chart area background */
[data-coreui-theme="dark"] .apexcharts-area {
  fill: rgba(255, 255, 255, 0.1) !important;
}

/* Additional dark mode fixes */
[data-coreui-theme="dark"] .h5,
[data-coreui-theme="dark"] .h6,
[data-coreui-theme="dark"] .card-title,
[data-coreui-theme="dark"] .font-weight-bold {
  color: #ffffff !important;
}

[data-coreui-theme="dark"] .small,
[data-coreui-theme="dark"] .text-muted {
  color: #adb5bd !important;
}

[data-coreui-theme="dark"] .dropdown-menu {
  background-color: #2b3035 !important;
  border-color: #495057 !important;
}

[data-coreui-theme="dark"] .dropdown-item:hover {
  background-color: #495057 !important;
  color: #ffffff !important;
}

[data-coreui-theme="dark"] .form-control {
  background-color: #2b3035 !important;
  border-color: #495057 !important;
  color: #ffffff !important;
}

[data-coreui-theme="dark"] .form-control:focus {
  background-color: #2b3035 !important;
  border-color: #0d6efd !important;
  color: #ffffff !important;
}

[data-coreui-theme="dark"] .btn-outline-primary {
  color: #0d6efd !important;
  border-color: #0d6efd !important;
}

[data-coreui-theme="dark"] .btn-outline-primary:hover {
  background-color: #0d6efd !important;
  color: #ffffff !important;
}

[data-coreui-theme="dark"] .btn-outline-secondary {
  color: #6c757d !important;
  border-color: #6c757d !important;
}

[data-coreui-theme="dark"] .btn-outline-secondary:hover {
  background-color: #6c757d !important;
  color: #ffffff !important;
}

/* Comprehensive dark mode fixes for all elements */
[data-coreui-theme="dark"] .card {
  background-color: #2b3035 !important;
  border-color: #495057 !important;
}

[data-coreui-theme="dark"] .card-header {
  background-color: #343a40 !important;
  border-bottom-color: #495057 !important;
  color: #ffffff !important;
}

[data-coreui-theme="dark"] .card-body {
  background-color: #2b3035 !important;
  color: #ffffff !important;
}

/* Hover states for all interactive elements */
[data-coreui-theme="dark"] .card:hover {
  box-shadow: 0 0.125rem 0.25rem rgba(255, 255, 255, 0.075) !important;
}

[data-coreui-theme="dark"] .dropdown-item {
  color: #ffffff !important;
}

[data-coreui-theme="dark"] .dropdown-item:hover,
[data-coreui-theme="dark"] .dropdown-item:focus {
  background-color: #495057 !important;
  color: #ffffff !important;
}

[data-coreui-theme="dark"] .dropdown-item:active {
  background-color: #0d6efd !important;
  color: #ffffff !important;
}

/* Form elements dark mode */
[data-coreui-theme="dark"] input[type="date"],
[data-coreui-theme="dark"] input[type="text"],
[data-coreui-theme="dark"] select {
  background-color: #2b3035 !important;
  border-color: #495057 !important;
  color: #ffffff !important;
}

[data-coreui-theme="dark"] input[type="date"]:focus,
[data-coreui-theme="dark"] input[type="text"]:focus,
[data-coreui-theme="dark"] select:focus {
  background-color: #2b3035 !important;
  border-color: #0d6efd !important;
  color: #ffffff !important;
  box-shadow: 0 0 0 0.2rem rgba(13, 110, 253, 0.25) !important;
}

/* Button states in dark mode */
[data-coreui-theme="dark"] .btn {
  color: inherit !important;
}

[data-coreui-theme="dark"] .btn-primary {
  background-color: #0d6efd !important;
  border-color: #0d6efd !important;
  color: #ffffff !important;
}

[data-coreui-theme="dark"] .btn-primary:hover {
  background-color: #0b5ed7 !important;
  border-color: #0a58ca !important;
  color: #ffffff !important;
}

[data-coreui-theme="dark"] .btn-success {
  background-color: #198754 !important;
  border-color: #198754 !important;
  color: #ffffff !important;
}

[data-coreui-theme="dark"] .btn-success:hover {
  background-color: #157347 !important;
  border-color: #146c43 !important;
  color: #ffffff !important;
}

/* Badge colors in dark mode */
[data-coreui-theme="dark"] .badge {
  color: #ffffff !important;
}

[data-coreui-theme="dark"] .badge.bg-success {
  background-color: #198754 !important;
  color: #ffffff !important;
}

[data-coreui-theme="dark"] .badge.bg-primary {
  background-color: #0d6efd !important;
  color: #ffffff !important;
}

[data-coreui-theme="dark"] .badge.bg-info {
  background-color: #0dcaf0 !important;
  color: #ffffff !important;
}

[data-coreui-theme="dark"] .badge.bg-warning {
  background-color: #ffc107 !important;
  color: #000000 !important;
}

[data-coreui-theme="dark"] .badge.bg-danger {
  background-color: #dc3545 !important;
  color: #ffffff !important;
}

/* Icon colors in dark mode */
[data-coreui-theme="dark"] .icon {
  fill: currentColor !important;
}

[data-coreui-theme="dark"] .text-primary .icon {
  fill: #0d6efd !important;
}

[data-coreui-theme="dark"] .text-success .icon {
  fill: #198754 !important;
}

[data-coreui-theme="dark"] .text-info .icon {
  fill: #0dcaf0 !important;
}

[data-coreui-theme="dark"] .text-warning .icon {
  fill: #ffc107 !important;
}

[data-coreui-theme="dark"] .text-danger .icon {
  fill: #dc3545 !important;
}

/* Breadcrumb dark mode */
[data-coreui-theme="dark"] .breadcrumb {
  background-color: transparent !important;
}

[data-coreui-theme="dark"] .breadcrumb-item + .breadcrumb-item::before {
  color: #adb5bd !important;
}

/* Loading spinner in dark mode */
[data-coreui-theme="dark"] .spinner-border {
  color: #0d6efd !important;
}

/* Metric growth text */
[data-coreui-theme="dark"] .metric-growth {
  color: #adb5bd !important;
}

[data-coreui-theme="dark"] .metric-growth .text-muted {
  color: #6c757d !important;
}

/* Quick filters dark mode */
[data-coreui-theme="dark"] .quick-filters .btn {
  border-color: #495057 !important;
  color: #adb5bd !important;
}

[data-coreui-theme="dark"] .quick-filters .btn:hover {
  background-color: #495057 !important;
  color: #ffffff !important;
  border-color: #6c757d !important;
}

/* Date filter dropdown dark mode */
[data-coreui-theme="dark"] .date-filter-dropdown {
  background-color: #2b3035 !important;
  border-color: #495057 !important;
}

[data-coreui-theme="dark"] .date-filter-dropdown .form-label {
  color: #ffffff !important;
}

/* Chart container dark mode */
[data-coreui-theme="dark"] #orderTrendChart,
[data-coreui-theme="dark"] #statusChart {
  background-color: transparent !important;
}

/* Ensure all text in cards is visible */
[data-coreui-theme="dark"] .text-xs,
[data-coreui-theme="dark"] .font-weight-bold,
[data-coreui-theme="dark"] .h5,
[data-coreui-theme="dark"] .h6 {
  color: #ffffff !important;
}

/* Small text and muted text */
[data-coreui-theme="dark"] .small,
[data-coreui-theme="dark"] .text-muted {
  color: #adb5bd !important;
}

/* Icon shapes in dark mode */
[data-coreui-theme="dark"] .icon-shape {
  background-color: inherit !important;
}

[data-coreui-theme="dark"] .icon-shape svg.icon {
  fill: #ffffff !important;
}
</style>
@endpush
