@extends('layouts.dashboard.master')
@section('title','Order Report')
@section('content')
<div class="container mt-4">
  <!-- Page Header -->
  <div class="d-flex justify-content-between align-items-center mb-4">
    <h4>Order Report</h4>
    <div class="d-flex gap-2">
      <!-- Export Button -->
      <div class="dropdown">
        <button class="btn btn-success dropdown-toggle" type="button" data-coreui-toggle="dropdown">
          <svg class="icon me-1">
            <use xlink:href="{{ asset('vendors/@coreui/icons/svg/free.svg') }}#cil-cloud-download"></use>
          </svg>Export
        </button>
        <ul class="dropdown-menu">
          <li><a class="dropdown-item" href="#">Export as PDF</a></li>
          <li><a class="dropdown-item" href="#">Export as Excel</a></li>
          <li><a class="dropdown-item" href="#">Export as CSV</a></li>
        </ul>
      </div>
    </div>
  </div>

  <!-- Summary Cards -->
  <div class="row mb-4">
    <!-- Total Orders -->
    <div class="col-xl-3 col-md-6 mb-4">
      <div class="card border-left-primary shadow h-100 py-2">
        <div class="card-body">
          <div class="row no-gutters align-items-center">
            <div class="col mr-2">
              <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Total Orders</div>
              <div class="h5 mb-0 font-weight-bold text-gray-800">127</div>
            </div>
            <div class="col-auto">
              <div class="icon-shape bg-primary text-white rounded-circle">
                <svg class="icon icon-lg">
                  <use xlink:href="{{ asset('vendors/@coreui/icons/svg/free.svg') }}#cil-list"></use>
                </svg>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Pending Orders -->
    <div class="col-xl-3 col-md-6 mb-4">
      <div class="card border-left-warning shadow h-100 py-2">
        <div class="card-body">
          <div class="row no-gutters align-items-center">
            <div class="col mr-2">
              <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">Pending Orders</div>
              <div class="h5 mb-0 font-weight-bold text-gray-800">8</div>
            </div>
            <div class="col-auto">
              <div class="icon-shape bg-warning text-white rounded-circle">
                <svg class="icon icon-lg">
                  <use xlink:href="{{ asset('vendors/@coreui/icons/svg/free.svg') }}#cil-clock"></use>
                </svg>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Completed Orders -->
    <div class="col-xl-3 col-md-6 mb-4">
      <div class="card border-left-success shadow h-100 py-2">
        <div class="card-body">
          <div class="row no-gutters align-items-center">
            <div class="col mr-2">
              <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Completed Orders</div>
              <div class="h5 mb-0 font-weight-bold text-gray-800">112</div>
            </div>
            <div class="col-auto">
              <div class="icon-shape bg-success text-white rounded-circle">
                <svg class="icon icon-lg">
                  <use xlink:href="{{ asset('vendors/@coreui/icons/svg/free.svg') }}#cil-check"></use>
                </svg>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Cancelled Orders -->
    <div class="col-xl-3 col-md-6 mb-4">
      <div class="card border-left-danger shadow h-100 py-2">
        <div class="card-body">
          <div class="row no-gutters align-items-center">
            <div class="col mr-2">
              <div class="text-xs font-weight-bold text-danger text-uppercase mb-1">Cancelled Orders</div>
              <div class="h5 mb-0 font-weight-bold text-gray-800">7</div>
            </div>
            <div class="col-auto">
              <div class="icon-shape bg-danger text-white rounded-circle">
                <svg class="icon icon-lg">
                  <use xlink:href="{{ asset('vendors/@coreui/icons/svg/free.svg') }}#cil-x"></use>
                </svg>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Search and Filters -->
  <div class="d-flex align-items-center position-relative my-1 mb-3">
    <div class="me-3">
      <select class="form-select w-200px" id="date-filter">
        <option value="">All Dates</option>
        <option value="today">Today</option>
        <option value="yesterday">Yesterday</option>
        <option value="week">This Week</option>
        <option value="month">This Month</option>
      </select>
    </div>
    <div class="me-3">
      <select class="form-select w-200px" id="status-filter">
        <option value="">All Status</option>
        <option value="pending">Pending</option>
        <option value="confirmed">Confirmed</option>
        <option value="preparing">Preparing</option>
        <option value="ready">Ready</option>
        <option value="delivered">Delivered</option>
        <option value="cancelled">Cancelled</option>
      </select>
    </div>
  </div>

  <!-- Data Table -->
  <table id="orderDatatable" class="table table-bordered table-striped table-hover align-middle">
    <thead class="bg-light-primary text-dark">
      <tr>
        <th>ORDER ID</th>
        <th>CUSTOMER</th>
        <th>DATE</th>
        <th>ITEMS</th>
        <th>TOTAL</th>
        <th>STATUS</th>
      </tr>
    </thead>
    <tbody>
      <tr>
        <td>#29072517</td>
        <td>Pankaj Kumar</td>
        <td>02:15 PM, 29-07-2025</td>
        <td>3 items</td>
        <td>$24.50</td>
        <td><span class="badge bg-success">Delivered</span></td>
      </tr>
    </tbody>
  </table>
</div>

<style>
/* Summary Cards Styling */
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

.border-left-danger {
  border-left: 0.25rem solid #e74a3b !important;
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

.text-gray-800 {
  color: rgb(255, 255, 255) !important;
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

/* Order Status Badge Colors */
.badge.bg-warning {
  background-color: #f6c23e !important;
  color: #fff !important;
}

.badge.bg-secondary {
  background-color: #6c757d !important;
  color: #fff !important;
}

.badge.bg-info {
  background-color: #36b9cc !important;
  color: #fff !important;
}
</style>
@endsection