@extends('layouts.dashboard.master')
@section('title','Edit User')
@section('content')
    <div class="container">
        <h4>Edit User</h4>
        <form action="{{ route('users.update', $user->id) }}" method="POST">
            @csrf
            @method('PATCH')
            @include('dashboard.users._form', ['user' => $user])
            <button type="submit" class="btn btn-success">Update</button>
        </form>
    </div>
@endsection
