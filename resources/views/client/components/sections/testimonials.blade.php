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
          "loop": true,
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
              "slidesPerView": 3,
              "spaceBetween": 20
            }
          }
        }
      </script>
      <div class="swiper-wrapper">

        <div class="swiper-slide">
          <div class="testimonial-item">
            <p>
              <i class="bi bi-quote quote-icon-left"></i>
              <span>Absolutely amazing food and lightning-fast delivery! The grilled chicken was perfectly seasoned and the truffle fries were to die for. Will definitely be ordering again soon.</span>
              <i class="bi bi-quote quote-icon-right"></i>
            </p>
            <img src="{{ asset('assets/img/testimonials/testimonials-1.jpg') }}" class="testimonial-img" alt="">
            <h3>Sarah Johnson</h3>
            <h4>Regular Customer</h4>
          </div>
        </div><!-- End testimonial item -->

        <div class="swiper-slide">
          <div class="testimonial-item">
            <p>
              <i class="bi bi-quote quote-icon-left"></i>
              <span>Foodymat catered our wedding and it was absolutely perfect! The food was exceptional and the service was flawless. All our guests raved about the meal. Highly recommend!</span>
              <i class="bi bi-quote quote-icon-right"></i>
            </p>
            <img src="{{ asset('assets/img/testimonials/testimonials-2.jpg') }}" class="testimonial-img" alt="">
            <h3>Michael Chen</h3>
            <h4>Wedding Client</h4>
          </div>
        </div><!-- End testimonial item -->

        <div class="swiper-slide">
          <div class="testimonial-item">
            <p>
              <i class="bi bi-quote quote-icon-left"></i>
              <span>As a vegetarian, I appreciate the variety of plant-based options. The quinoa-stuffed peppers are incredible and the salads are always fresh. Great healthy choices!</span>
              <i class="bi bi-quote quote-icon-right"></i>
            </p>
            <img src="{{ asset('assets/img/testimonials/testimonials-3.jpg') }}" class="testimonial-img" alt="">
            <h3>Emma Rodriguez</h3>
            <h4>Health Enthusiast</h4>
          </div>
        </div><!-- End testimonial item -->

        <div class="swiper-slide">
          <div class="testimonial-item">
            <p>
              <i class="bi bi-quote quote-icon-left"></i>
              <span>I order from Foodymat for all my corporate meetings. The food is always fresh, arrives on time, and impresses my clients. Professional service every time.</span>
              <i class="bi bi-quote quote-icon-right"></i>
            </p>
            <img src="{{ asset('assets/img/testimonials/testimonials-4.jpg') }}" class="testimonial-img" alt="">
            <h3>David Thompson</h3>
            <h4>Business Owner</h4>
          </div>
        </div><!-- End testimonial item -->

        <div class="swiper-slide">
          <div class="testimonial-item">
            <p>
              <i class="bi bi-quote quote-icon-left"></i>
              <span>The best food delivery service in town! Quality ingredients, creative dishes, and excellent customer service. The Maryland crab cakes are restaurant-quality.</span>
              <i class="bi bi-quote quote-icon-right"></i>
            </p>
            <img src="{{ asset('assets/img/testimonials/testimonials-5.jpg') }}" class="testimonial-img" alt="">
            <h3>Jennifer Wilson</h3>
            <h4>Food Blogger</h4>
          </div>
        </div><!-- End testimonial item -->

      </div>
      <div class="swiper-pagination"></div>
    </div>

  </div>

</section><!-- /Testimonials Section --> 