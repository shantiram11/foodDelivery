@extends('layouts.frontend-master')

@section('content')
<div class="container" style="margin-top: 120px; min-height: 50vh;">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card modern-card">
                <div class="card-body p-4 text-center">
                    <h2 class="card-title mb-3">Redirecting to eSewa</h2>
                    <p class="text-muted mb-4">Please wait while we redirect you to complete your payment securely.</p>
                    <form id="esewaForm" action="{{ $formUrl }}" method="POST">
                        @foreach($payload as $name => $value)
                            <input type="hidden" name="{{ $name }}" value="{{ $value }}">
                        @endforeach
                        <noscript>
                            <button type="submit" class="btn btn-primary">Continue to eSewa</button>
                        </noscript>
                    </form>
                    <div class="mt-3">
                        <a href="{{ route('checkout') }}" class="btn btn-link">Cancel and go back</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    document.getElementById('esewaForm').submit();
});
</script>
@endsection
