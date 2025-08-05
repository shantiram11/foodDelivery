@extends('layouts.dashboard.master')
@section('title','Sales Report')
@section('content')

<div class="container-fluid mt-4">
  <!-- Page Header -->
  <div class="d-flex justify-content-between align-items-center mb-4">
    <div>
      <h4 class="mb-1">
        <svg class="icon me-2 text-primary">
          <use xlink:href="{{ asset('vendors/@coreui/icons/svg/free.svg') }}#cil-chart-line"></use>
        </svg>
        Sales Analytics
      </h4>
      <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
          <li class="breadcrumb-item">
            <a href="{{ route('dashboard') }}">
              <svg class="icon me-1">
                <use xlink:href="{{ asset('vendors/@coreui/icons/svg/free.svg') }}#cil-home"></use>
              </svg>Dashboard
            </a>
          </li>
          <li class="breadcrumb-item">
            <a href="{{ route('reports.index') }}">
              <svg class="icon me-1">
                <use xlink:href="{{ asset('vendors/@coreui/icons/svg/free.svg') }}#cil-chart"></use>
              </svg>Reports
            </a>
          </li>
          <li class="breadcrumb-item active">
            <svg class="icon me-1">
              <use xlink:href="{{ asset('vendors/@coreui/icons/svg/free.svg') }}#cil-notes"></use>
            </svg>Sales Report
          </li>
        </ol>
      </nav>
    </div>

    <div class="d-flex gap-2">
      <!-- Date Range Filter -->
      <div class="dropdown">
        <button class="btn btn-outline-primary dropdown-toggle" type="button" id="dateRangeDropdown" data-bs-toggle="dropdown" aria-expanded="false">
          <svg class="icon">
            <use xlink:href="{{ asset('vendors/@coreui/icons/svg/free.svg') }}#cil-calendar"></use>
          </svg>
          <span id="dateRangeText">Date Range</span>
        </button>
        <div class="dropdown-menu p-3 date-filter-dropdown">
          <form method="GET" action="{{ route('reports.index') }}" id="dateFilterForm">
            <div class="row g-2 mb-3">
              <div class="col-6">
                <label class="form-label">Start Date</label>
                <input type="date" class="form-control" name="start_date" id="startDate" value="{{ $startDate ?? '' }}">
              </div>
              <div class="col-6">
                <label class="form-label">End Date</label>
                <input type="date" class="form-control" name="end_date" id="endDate" value="{{ $endDate ?? '' }}">
              </div>
            </div>

            <div class="quick-filters mb-3">
              <button type="button" class="btn btn-outline-secondary btn-sm" onclick="dateFilter.setQuickFilter('today')">
                <svg class="icon me-1">
                  <use xlink:href="{{ asset('vendors/@coreui/icons/svg/free.svg') }}#cil-sun"></use>
                </svg>Today
              </button>
              <button type="button" class="btn btn-outline-secondary btn-sm" onclick="dateFilter.setQuickFilter('yesterday')">
                <svg class="icon me-1">
                  <use xlink:href="{{ asset('vendors/@coreui/icons/svg/free.svg') }}#cil-arrow-left"></use>
                </svg>Yesterday
              </button>
              <button type="button" class="btn btn-outline-secondary btn-sm" onclick="dateFilter.setQuickFilter('this_week')">
                <svg class="icon me-1">
                  <use xlink:href="{{ asset('vendors/@coreui/icons/svg/free.svg') }}#cil-calendar"></use>
                </svg>This Week
              </button>
              <button type="button" class="btn btn-outline-secondary btn-sm" onclick="dateFilter.setQuickFilter('last_week')">
                <svg class="icon me-1">
                  <use xlink:href="{{ asset('vendors/@coreui/icons/svg/free.svg') }}#cil-calendar"></use>
                </svg>Last Week
              </button>
              <button type="button" class="btn btn-outline-secondary btn-sm" onclick="dateFilter.setQuickFilter('this_month')">
                <svg class="icon me-1">
                  <use xlink:href="{{ asset('vendors/@coreui/icons/svg/free.svg') }}#cil-calendar"></use>
                </svg>This Month
              </button>
              <button type="button" class="btn btn-outline-secondary btn-sm" onclick="dateFilter.setQuickFilter('last_month')">
                <svg class="icon me-1">
                  <use xlink:href="{{ asset('vendors/@coreui/icons/svg/free.svg') }}#cil-calendar"></use>
                </svg>Last Month
              </button>
            </div>

            <div class="d-flex gap-2">
              <button type="submit" class="btn btn-primary btn-sm flex-fill">
                <svg class="icon me-1">
                  <use xlink:href="{{ asset('vendors/@coreui/icons/svg/free.svg') }}#cil-check-circle"></use>
                </svg>Apply Filter
              </button>
              <button type="button" class="btn btn-outline-secondary btn-sm" onclick="dateFilter.reset()">
                <svg class="icon me-1">
                  <use xlink:href="{{ asset('vendors/@coreui/icons/svg/free.svg') }}#cil-reload"></use>
                </svg>Reset
              </button>
            </div>
          </form>
        </div>
      </div>

      <!-- Restaurant Filter -->
      @if(auth()->user()->isAdmin() && isset($restaurants))
      <div class="dropdown">
        <button class="btn btn-outline-secondary dropdown-toggle" type="button" id="restaurantDropdown" data-bs-toggle="dropdown" aria-expanded="false">
          <svg class="icon text-secondary">
            <use xlink:href="{{ asset('vendors/@coreui/icons/svg/free.svg') }}#cil-restaurant"></use>
          </svg>
          <span class="ms-1">Restaurant</span>
        </button>
        <div class="dropdown-menu">
          <a class="dropdown-item" href="#" onclick="filterByRestaurant('all')">
            <svg class="icon me-2">
              <use xlink:href="{{ asset('vendors/@coreui/icons/svg/free.svg') }}#cil-building"></use>
            </svg>All Restaurants
          </a>
          <div class="dropdown-divider"></div>
          @foreach($restaurants as $restaurant)
            <a class="dropdown-item" href="#" onclick="filterByRestaurant({{ $restaurant->id }})">
              <svg class="icon me-2">
                <use xlink:href="{{ asset('vendors/@coreui/icons/svg/free.svg') }}#cil-restaurant"></use>
              </svg>{{ $restaurant->name }}
            </a>
          @endforeach
        </div>
      </div>
      @endif

      <!-- Export Button -->
              {{-- <div class="dropdown">
        <button class="btn btn-success dropdown-toggle" type="button" id="exportDropdown" data-bs-toggle="dropdown" aria-expanded="false">
          <svg class="icon text-white">
            <use xlink:href="{{ asset('vendors/@coreui/icons/svg/free.svg') }}#cil-cloud-download"></use>
          </svg>
          <span class="ms-1">Export</span>
        </button>
        <ul class="dropdown-menu" aria-labelledby="exportDropdown">
          <li><a class="dropdown-item export-btn" href="#" data-format="pdf">
            <svg class="icon text-danger me-2">
              <use xlink:href="{{ asset('vendors/@coreui/icons/svg/free.svg') }}#cil-description"></use>
            </svg>Export as PDF
          </a></li>
          <li><a class="dropdown-item export-btn" href="#" data-format="excel">
            <svg class="icon text-success me-2">
              <use xlink:href="{{ asset('vendors/@coreui/icons/svg/free.svg') }}#cil-spreadsheet"></use>
            </svg>Export as Excel
          </a></li>
          <li><a class="dropdown-item export-btn" href="#" data-format="csv">
            <svg class="icon text-info me-2">
              <use xlink:href="{{ asset('vendors/@coreui/icons/svg/free.svg') }}#cil-file"></use>
            </svg>Export as CSV
          </a></li>
        </ul>
      </div> --}}
    </div>
  </div>

  <!-- Summary Cards -->
  <div class="row mb-4">
    <!-- Total Revenue -->
    <div class="col-xl-3 col-md-6 mb-4">
      <div class="card border-left-success shadow h-100 py-2">
        <div class="card-body">
          <div class="row no-gutters align-items-center">
            <div class="col mr-2">
              <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Total Revenue</div>
              <div class="h5 mb-0 font-weight-bold text-gray-800" id="totalRevenue">Rs. {{ number_format($totalRevenue ?? 0, 2) }}</div>
              <div class="metric-growth">
                <span class="badge bg-success" id="revenueGrowth">
                  <svg class="icon">
                    <use xlink:href="{{ asset('vendors/@coreui/icons/svg/free.svg') }}#cil-arrow-top"></use>
                  </svg> {{ number_format($revenueGrowth ?? 0, 1) }}%
                </span>
                <small class="text-muted">vs last month</small>
              </div>
            </div>
            <div class="col-auto">
              <div class="icon-shape bg-success text-white rounded-circle">
                <svg class="icon icon-lg">
                  <use xlink:href="{{ asset('vendors/@coreui/icons/svg/free.svg') }}#cil-dollar"></use>
                </svg>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Total Orders -->
    <div class="col-xl-3 col-md-6 mb-4">
      <div class="card border-left-primary shadow h-100 py-2">
        <div class="card-body">
          <div class="row no-gutters align-items-center">
            <div class="col mr-2">
              <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Total Orders</div>
              <div class="h5 mb-0 font-weight-bold text-gray-800" id="totalOrders">{{ number_format($totalOrders ?? 0) }}</div>
              <div class="text-muted small">orders processed</div>
            </div>
            <div class="col-auto">
              <div class="icon-shape bg-primary text-white rounded-circle">
                <svg class="icon icon-lg">
                  <use xlink:href="{{ asset('vendors/@coreui/icons/svg/free.svg') }}#cil-basket"></use>
                </svg>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Average Order Value -->
    <div class="col-xl-3 col-md-6 mb-4">
      <div class="card border-left-info shadow h-100 py-2">
        <div class="card-body">
          <div class="row no-gutters align-items-center">
            <div class="col mr-2">
              <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Avg Order Value</div>
              <div class="h5 mb-0 font-weight-bold text-gray-800" id="averageOrderValue">Rs. {{ number_format($averageOrderValue ?? 0, 2) }}</div>
              <div class="text-muted small">per order</div>
            </div>
            <div class="col-auto">
              <div class="icon-shape bg-info text-white rounded-circle">
                <svg class="icon icon-lg">
                  <use xlink:href="{{ asset('vendors/@coreui/icons/svg/free.svg') }}#cil-chart"></use>
                </svg>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Completion Rate -->
    <div class="col-xl-3 col-md-6 mb-4">
      <div class="card border-left-warning shadow h-100 py-2">
        <div class="card-body">
          <div class="row no-gutters align-items-center">
            <div class="col mr-2">
              <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">Completion Rate</div>
              <div class="h5 mb-0 font-weight-bold text-gray-800" id="completionRate">{{ number_format($completionRate ?? 0, 1) }}%</div>
              <div class="text-muted small">orders completed</div>
            </div>
            <div class="col-auto">
              <div class="icon-shape bg-warning text-white rounded-circle">
                <svg class="icon icon-lg">
                  <use xlink:href="{{ asset('vendors/@coreui/icons/svg/free.svg') }}#cil-check"></use>
                </svg>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Charts Section -->
  <div class="row mb-4">
    <!-- Daily Sales Chart -->
    <div class="col-lg-8 mb-4">
      <div class="card shadow">
        <div class="card-header">
          <h6 class="card-title mb-0">Daily Sales & Orders Trend</h6>
          <small class="text-muted">Revenue & Order Count Analysis</small>
        </div>
        <div class="card-body">
          <div id="dailySalesChart"></div>
        </div>
      </div>
    </div>

    <!-- Order Status Chart -->
    <div class="col-lg-4 mb-4">
      <div class="card shadow">
        <div class="card-header">
          <h6 class="card-title mb-0">Order Status Distribution</h6>
        </div>
        <div class="card-body">
          <div id="statusChart"></div>
        </div>
      </div>
    </div>
  </div>

  <!-- Top Performing Restaurants -->
  @if(auth()->user()->isAdmin() && isset($topRestaurants))
  <div class="row mb-4">
    <div class="col-12">
      <div class="card shadow">
        <div class="card-header">
          <h6 class="card-title mb-0">Top Performing Restaurants</h6>
        </div>
        <div class="card-body p-0">
          <div class="table-responsive">
            <table class="table table-striped mb-0">
              <thead class="table-light">
                <tr>
                  <th>Restaurant</th>
                  <th class="text-center">Total Orders</th>
                  <th class="text-end">Total Revenue</th>
                  <th class="text-end">Avg Order Value</th>
                  <th class="text-center">Performance</th>
                </tr>
              </thead>
              <tbody>
                @forelse($topRestaurants as $restaurant)
                <tr>
                  <td>
                    <div class="d-flex align-items-center">
                      <div class="bg-primary rounded-circle p-2 me-3">
                        <svg class="icon text-white">
                          <use xlink:href="{{ asset('vendors/@coreui/icons/svg/free.svg') }}#cil-restaurant"></use>
                        </svg>
                      </div>
                      <div>
                        <h6 class="mb-0">{{ $restaurant['name'] }}</h6>
                        <small class="text-muted">ID: {{ $restaurant['id'] }}</small>
                      </div>
                    </div>
                  </td>
                  <td class="text-center">
                    <span class="badge bg-primary">{{ number_format($restaurant['total_orders']) }}</span>
                  </td>
                  <td class="text-end">
                    <strong class="text-success">Rs. {{ number_format($restaurant['total_revenue'], 2) }}</strong>
                  </td>
                  <td class="text-end">
                    <span class="text-info">Rs. {{ number_format($restaurant['avg_order_value'], 2) }}</span>
                  </td>
                  <td class="text-center">
                    <div class="progress" style="height: 8px;">
                      <div class="progress-bar bg-success" role="progressbar" style="width: {{ $restaurant['performance_percentage'] }}%"></div>
                    </div>
                    <small class="text-muted">{{ number_format($restaurant['performance_percentage'], 1) }}%</small>
                  </td>
                </tr>
                @empty
                <tr>
                  <td colspan="5" class="text-center text-muted py-4">No restaurant data available</td>
                </tr>
                @endforelse
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
  @endif

  <!-- Revenue Trend Chart -->
  <div class="row mb-4">
    <div class="col-12">
      <div class="card shadow">
        <div class="card-header">
          <h6 class="card-title mb-0">12-Month Revenue Trend</h6>
        </div>
        <div class="card-body">
          <div id="revenueChart"></div>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- Export Modal -->
<div class="modal fade" id="exportModal" tabindex="-1" aria-labelledby="exportModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exportModalLabel">Export Sales Report</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <p>Export sales report for the selected date range:</p>
        <ul class="list-unstyled">
          <li><strong>Start Date:</strong> <span id="exportStartDate"></span></li>
          <li><strong>End Date:</strong> <span id="exportEndDate"></span></li>
          <li><strong>Total Records:</strong> <span id="exportRecordCount"></span></li>
        </ul>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
        <button type="button" class="btn btn-primary" id="confirmExport">Export</button>
      </div>
    </div>
  </div>
</div>

<!-- Loading Overlay -->
<div class="loading-overlay d-none" id="loadingOverlay">
  <div class="spinner-border text-primary" role="status">
    <span class="visually-hidden">Loading...</span>
  </div>
  <div class="mt-3">Loading report data...</div>
</div>
<style>
    .border-left-primary {
  border-left: 0.25rem solid #4e73df !important;
}

.border-left-success {
  border-left: 0.25rem solid #1cc88a !important;
}

.border-left-info {
  border-left: 0.25rem solid #36b9cc !important;
}

.border-left-warning {
  border-left: 0.25rem solid #f6c23e !important;
}

.icon-shape {
  display: inline-flex;
  align-items: center;
  justify-content: center;
  text-align: center;
  vertical-align: middle;
  width: 3rem;
  height: 3rem;
}

.text-xs {
  font-size: 0.75rem;
}

/* Dark mode text color fixes */
.text-gray-800 {
  color: rgb(255, 255, 255) !important;
}

/* Ensure text visibility in dark mode */
.card-title,
.card-header h6,
.breadcrumb-item,
.breadcrumb-item a,
.text-muted,
.form-label,
.dropdown-item,
.btn {
  color: inherit !important;
}

/* Dark mode specific overrides */
[data-coreui-theme="dark"] .text-gray-800,
[data-coreui-theme="dark"] .card-title,
[data-coreui-theme="dark"] .card-header h6,
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
[data-coreui-theme="dark"] #dailySalesChart,
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

/* Form Controls */
.w-200px {
  width: 200px !important;
}

.w-250px {
  width: 250px !important;
}

.form-control-solid {
  background-color: #f8f9fa;
  border: 1px solid #e9ecef;
}

.ps-15 {
  padding-left: 15px !important;
}

/* Table Styling */
.bg-light-primary {
  background-color: rgba(78, 115, 223, 0.1) !important;
}

/* Badge Styling */
.badge {
  font-size: 0.75rem;
  padding: 0.35em 0.65em;
  font-weight: 500;
}

.badge.bg-light {
  color: #6c757d !important;
  background-color: #f8f9fa !important;
}

/* CoreUI Icon Styling */
.icon {
  width: 1rem;
  height: 1rem;
  fill: currentColor;
  display: inline-block;
}

.icon-lg {
  width: 1.5rem;
  height: 1.5rem;
}

/* Make sure icons are visible in shapes */
.icon-shape svg.icon {
  fill: currentColor;
  color: inherit;
}

/* Fix dropdown positioning */
.dropdown-menu {
  z-index: 1000;
}

.date-filter-dropdown {
  min-width: 300px;
}

/* Quick filters layout */
.quick-filters {
  display: flex;
  flex-wrap: wrap;
  gap: 0.5rem;
  justify-content: center;
}
</style>

@endsection



@push('scripts')
<!-- ApexCharts -->
<script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
<!-- Sales Report JavaScript -->
<script src="{{ asset('js/report.js') }}"></script>

<script>
// Initialize Sales Report Dashboard
$(document).ready(function() {
    const config = {
        routes: {
            sales: '{{ route("reports.sales") }}',
            revenue: '{{ route("reports.revenue") }}'
        },
        selectors: {
            dateFilterForm: "#dateFilterForm",
            startDate: "#startDate",
            endDate: "#endDate",
            dateRangeText: "#dateRangeText",
            loadingOverlay: "#loadingOverlay",
            exportModal: "#exportModal"
        },
        currentFilter: {
            start_date: '{{ $startDate ?? "" }}',
            end_date: '{{ $endDate ?? "" }}',
            restaurant_id: 'all'
        },
        initialData: {
            dailySales: @json($dailySales ?? []),
            statusDistribution: @json($statusDistribution ?? [])
        }
    };

    // Initialize the dashboard
    window.salesDashboard = new SalesReportDashboard(config);

    // Set up export button event listeners
    $('.export-btn').on('click', function(e) {
        e.preventDefault();
        const format = $(this).data('format');
        console.log('Export button clicked for format:', format);

        if (window.salesDashboard && window.salesDashboard.exportManager) {
            window.salesDashboard.exportManager.showExportModal(format);
        } else {
            console.error('Sales dashboard or export manager not initialized');
        }
    });

    // Wait for charts to be initialized before setting initial data
    setTimeout(() => {
        // Set initial data for charts
        if (config.initialData.dailySales && Object.keys(config.initialData.dailySales).length > 0) {
            const dailySales = config.initialData.dailySales;
            const labels = Object.keys(dailySales);
            const revenueData = Object.values(dailySales).map(day => day.total_revenue);
            const ordersData = Object.values(dailySales).map(day => day.total_orders);

            // Update daily sales chart with initial data
            if (window.salesDashboard.config.charts.dailySales) {
                window.salesDashboard.config.charts.dailySales.updateOptions({
                    xaxis: { categories: labels }
                });
                window.salesDashboard.config.charts.dailySales.updateSeries([
                    { name: 'Revenue (Rs.)', data: revenueData },
                    { name: 'Orders Count', data: ordersData }
                ]);
            }
        }

        if (config.initialData.statusDistribution) {
            const statusDistribution = config.initialData.statusDistribution;
            const data = [
                statusDistribution.completed?.count || 0,
                statusDistribution.confirmed?.count || 0,
                statusDistribution.preparing?.count || 0,
                statusDistribution.cancelled?.count || 0
            ];

            // Update status chart with initial data
            if (window.salesDashboard.config.charts.status) {
                window.salesDashboard.config.charts.status.updateSeries(data);
            }
        }
    }, 500);
});
</script>
@endpush