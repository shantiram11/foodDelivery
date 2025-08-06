@php
    $testimonials = \App\Models\Testimonial::active()->ordered()->get();
@endphp

@if($testimonials->count() > 0)
<!-- Testimonials Section -->
<section id="testimonials" class="testimonials section">

  <!-- Section Title -->
  <div class="container section-title" data-aos="fade-up">
    <h2>Customer Reviews</h2>
    <p>What Our Customers Say About Us</p>
  </div><!-- End Section Title -->

  <div class="container" data-aos="fade-up" data-aos-delay="100">

    <div class="swiper init-swiper" data-speed="600" data-delay="5000" data-breakpoints="{ &quot;320&quot;: { &quot;slidesPerView&quot;: 1, &quot;spaceBetween&quot;: 40 }, &quot;1200&quot;: { &quot;slidesPerView&quot;: 3, &quot;spaceBetween&quot;: 40 } }">
      <script type="application/json" class="swiper-config">
        {
          "loop": {{ $testimonials->count() > 1 ? 'true' : 'false' }},
          "speed": 600,
          "autoplay": {
            "delay": 5000
          },
          "slidesPerView": "auto",
          "pagination": {
            "el": ".swiper-pagination",
            "type": "bullets",
            "clickable": true
          },
          "breakpoints": {
            "320": {
              "slidesPerView": 1,
              "spaceBetween": 40
            },
            "1200": {
              "slidesPerView": {{ min($testimonials->count(), 3) }},
              "spaceBetween": 20
            }
          }
        }
      </script>
      <div class="swiper-wrapper">

        @foreach($testimonials as $testimonial)
        <div class="swiper-slide">
          <div class="testimonial-item">
            <p>
              <i class="bi bi-quote quote-icon-left"></i>
              <span>{{ $testimonial->content }}</span>
              <i class="bi bi-quote quote-icon-right"></i>
            </p>
            @if($testimonial->image)
              <img src="{{ Storage::url($testimonial->image) }}" class="testimonial-img" alt="{{ $testimonial->name }}">
            @else
              <div class="testimonial-img-placeholder">
                <span>{{ substr($testimonial->name, 0, 1) }}</span>
              </div>
            @endif
            <h3>{{ $testimonial->name }}</h3>
            <h4>{{ $testimonial->title }}</h4>
            @if($testimonial->rating)
              <div class="testimonial-rating">
                @for($i = 1; $i <= 5; $i++)
                  @if($i <= $testimonial->rating)
                    <i class="bi bi-star-fill"></i>
                  @else
                    <i class="bi bi-star"></i>
                  @endif
                @endfor
              </div>
            @endif
          </div>
        </div><!-- End testimonial item -->
        @endforeach

      </div>
      <div class="swiper-pagination"></div>
    </div>

  </div>

</section><!-- /Testimonials Section -->

@push('styles')
<style>
  .testimonial-img-placeholder {
    width: 100px;
    height: 100px;
    border-radius: 50%;
    background: var(--accent-color, #ce1212);
    color: white;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 2rem;
    font-weight: bold;
    margin: 0 auto 20px;
    text-transform: uppercase;
  }

  .testimonial-rating {
    margin-top: 20px;
    text-align: center;
    color: #ffc107;
  }

  .testimonial-rating i {
    font-size: 0.9rem;
    margin-right: 2px;
  }
</style>
@endpush
@endif