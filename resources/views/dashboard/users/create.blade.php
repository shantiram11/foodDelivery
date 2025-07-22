@extends('layouts.dashboard.master')
@section('title','Create User')
@section('content')
    <div class="container">
        <h4>Create User</h4>
        <form action="{{ route('users.store') }}" method="POST">
            @csrf
            @include('dashboard.users._form', ['user' => null])
            <button type="submit" class="btn btn-primary">Create</button>
        </form>
    </div>
@endsection

