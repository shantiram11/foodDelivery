<!-- @extends('layouts.dashboard.master')
@section('title','Delete User')
@section('content')
    <div class="container">
        <h4>Delete User</h4>
        <form action="{{ route('users.destroy', $user->id) }}" method="POST">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn btn-danger">Delete</button>
        </form>
    </div>
@endsection -->
