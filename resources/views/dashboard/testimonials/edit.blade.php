@extends('layouts.dashboard.master')
@section('title','Edit Testimonial')
@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h4 class="card-title mb-0">Edit Testimonial: {{ $testimonial->name }}</h4>
                        <a href="{{ route('dashboard.testimonials.index') }}" class="btn btn-secondary">
                            <i class="fas fa-arrow-left"></i> Back to List
                        </a>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('dashboard.testimonials.update', $testimonial) }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            @include('dashboard.testimonials._form', ['testimonial' => $testimonial])

                            <div class="row mt-4">
                                <div class="col-12">
                                    <button type="submit" class="btn btn-primary">
                                        <i class="fas fa-save"></i> Update Testimonial
                                    </button>
                                    <a href="{{ route('dashboard.testimonials.index') }}" class="btn btn-secondary ms-2">
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

@push('scripts')
<script>
function previewImage(input) {
    const preview = document.getElementById('image-preview');
    const previewImg = document.getElementById('preview-img');
    const currentImage = document.getElementById('current-image');

    if (input.files && input.files[0]) {
        const reader = new FileReader();

        reader.onload = function(e) {
            previewImg.src = e.target.result;
            preview.style.display = 'block';
            if (currentImage) {
                currentImage.style.opacity = '0.5';
            }
        }

        reader.readAsDataURL(input.files[0]);
    } else {
        preview.style.display = 'none';
        if (currentImage) {
            currentImage.style.opacity = '1';
        }
    }
}
</script>
@endpush