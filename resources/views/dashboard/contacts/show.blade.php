@extends('layouts.dashboard.master')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex justify-content-between align-items-center">
                        <h4 class="card-title mb-0">Contact Message Details</h4>
                        <div>
                            <a href="{{ route('contacts.index') }}" class="btn btn-secondary btn-sm">
                                <i class="bi bi-arrow-left"></i> Back to List
                            </a>
                            @if($contact->status !== 'replied')
                                <a href="{{ route('contacts.reply', $contact->id) }}" class="btn btn-success btn-sm">
                                    <i class="bi bi-reply"></i> Mark as Replied
                                </a>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-8">
                            <!-- Message Content -->
                            <div class="mb-4">
                                <h5 class="border-bottom pb-2">{{ $contact->subject }}</h5>
                                <div class="message-content bg-dark border text-white p-3 rounded">
                                    {!! nl2br(e($contact->message)) !!}
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <!-- Contact Information -->
                            <div class="card">
                                <div class="card-header">
                                    <h6 class="mb-0">Contact Information</h6>
                                </div>
                                <div class="card-body">
                                    <div class="mb-3">
                                        <label class="form-label text-muted">Name</label>
                                        <div class="fw-bold">{{ $contact->name }}</div>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label text-muted">Email</label>
                                        <div>
                                            <a href="mailto:{{ $contact->email }}" class="text-decoration-none">
                                                {{ $contact->email }}
                                            </a>
                                        </div>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label text-muted">Status</label>
                                        <div>
                                            @if($contact->status === 'new')
                                                <span class="badge bg-danger">New</span>
                                            @elseif($contact->status === 'read')
                                                <span class="badge bg-warning">Read</span>
                                            @else
                                                <span class="badge bg-success">Replied</span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label text-muted">Received</label>
                                        <div>{{ $contact->created_at->format('M d, Y H:i A') }}</div>
                                        <small class="text-muted">{{ $contact->created_at->diffForHumans() }}</small>
                                    </div>
                                    @if($contact->replied_at)
                                        <div class="mb-3">
                                            <label class="form-label text-muted">Replied</label>
                                            <div>{{ $contact->replied_at->format('M d, Y H:i A') }}</div>
                                            <small class="text-muted">{{ $contact->replied_at->diffForHumans() }}</small>
                                        </div>
                                    @endif
                                </div>
                            </div>

                            <!-- Quick Actions -->
                            <div class="card mt-3">
                                <div class="card-header">
                                    <h6 class="mb-0">Quick Actions</h6>
                                </div>
                                <div class="card-body">
                                    <div class="d-grid gap-2">
                                        <a href="mailto:{{ $contact->email }}?subject=Re: {{ $contact->subject }}"
                                           class="btn btn-primary btn-sm">
                                            <i class="bi bi-envelope"></i> Reply via Email
                                        </a>
                                        @if($contact->status !== 'replied')
                                            <a href="{{ route('contacts.reply', $contact->id) }}"
                                               class="btn btn-success btn-sm">
                                                <i class="bi bi-check-circle"></i> Mark as Replied
                                            </a>
                                        @endif
                                        <form action="{{ route('contacts.destroy', $contact->id) }}"
                                              method="POST"
                                              onsubmit="return confirm('Are you sure you want to delete this contact message?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm w-100">
                                                <i class="bi bi-trash"></i> Delete Message
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show position-fixed" style="top: 20px; right: 20px; z-index: 9999;" role="alert">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif

<style>
.message-content {
    min-height: 200px;
    line-height: 1.6;
}
</style>
@endsection