@extends('layouts.dashboard.master')
@section('title','Add Restaurant')
@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h4 class="card-title mb-0">Add New Restaurant</h4>
                        <a href="{{ route('restaurants.index') }}" class="btn btn-secondary">
                            <i class="fas fa-arrow-left"></i> Back to List
                        </a>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('restaurants.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @include('dashboard.restaurants._form')
                            
                            <div class="row mt-4">
                                <div class="col-12">
                                    <button type="submit" class="btn btn-success">
                                        <i class="fas fa-save"></i> Create Restaurant
                                    </button>
                                    <a href="{{ route('restaurants.index') }}" class="btn btn-secondary ms-2">
                                        <i class="fas fa-times"></i> Cancel
                                    </a>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection 