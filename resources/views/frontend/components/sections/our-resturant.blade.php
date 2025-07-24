<!-- Restaurant Locations Section -->
<section id="locations" class="chefs section">

  <!-- Section Title -->
  <div class="container section-title" data-aos="fade-up">
    <h2>OUR LOCATIONS</h2>
    <p class="golden-text">Visit Us Across the City</p>
  </div><!-- End Section Title -->

  <div class="container">
    <div class="row g-4">
      <div class="col-lg-3 col-md-6" data-aos="fade-up" data-aos-delay="100">
        <div class="member h-100">
          <a href="#menu" class="location-link" data-restaurant="downtown">
          <img src="{{ asset('frontend/img/gallery/gallery-1.jpg') }}" class="img-fluid" alt="Downtown Restaurant">
          </a>
          <div class="member-info">
            <div class="member-info-content">
              <h4>Downtown Branch</h4>
              <span>1234 Main Street, City Center</span>
            </div>
            <div class="social">
              <a href="tel:+1234567890"><i class="bi bi-telephone"></i></a>
              <a href="https://maps.google.com" target="_blank"><i class="bi bi-geo-alt"></i></a>
              <a href="#menu" class="menu-link" data-restaurant="downtown"><i class="bi bi-menu-button"></i></a>
              <a href="mailto:downtown@foodymat.com"><i class="bi bi-envelope"></i></a>
            </div>
          </div>
        </div>
      </div>

      <div class="col-lg-3 col-md-6" data-aos="fade-up" data-aos-delay="200">
        <div class="member h-100">
          <a href="#menu" class="location-link" data-restaurant="uptown">
          <img src="{{ asset('frontend/img/gallery/gallery-2.jpg') }}" class="img-fluid" alt="Uptown Restaurant">
          </a>
          <div class="member-info">
            <div class="member-info-content">
              <h4>Uptown Branch</h4>
              <span>567 Park Avenue, Upper District</span>
            </div>
            <div class="social">
              <a href="tel:+1234567891"><i class="bi bi-telephone"></i></a>
              <a href="https://maps.google.com" target="_blank"><i class="bi bi-geo-alt"></i></a>
              <a href="#menu" class="menu-link" data-restaurant="uptown"><i class="bi bi-menu-button"></i></a>
              <a href="mailto:uptown@foodymat.com"><i class="bi bi-envelope"></i></a>
            </div>
          </div>
        </div>
      </div>

      <div class="col-lg-3 col-md-6" data-aos="fade-up" data-aos-delay="300">
        <div class="member h-100">
          <a href="#menu" class="location-link" data-restaurant="riverside">
          <img src="{{ asset('frontend/img/gallery/gallery-3.jpg') }}" class="img-fluid" alt="Riverside Restaurant">
          </a>
          <div class="member-info">
            <div class="member-info-content">
              <h4>Riverside Branch</h4>
              <span>890 River View Road, Waterfront</span>
            </div>
            <div class="social">
              <a href="tel:+1234567892"><i class="bi bi-telephone"></i></a>
              <a href="https://maps.google.com" target="_blank"><i class="bi bi-geo-alt"></i></a>
              <a href="#menu" class="menu-link" data-restaurant="riverside"><i class="bi bi-menu-button"></i></a>
              <a href="mailto:riverside@foodymat.com"><i class="bi bi-envelope"></i></a>
            </div>
          </div>
        </div>
      </div>

      <div class="col-lg-3 col-md-6" data-aos="fade-up" data-aos-delay="400">
        <div class="member h-100">
          <a href="#menu" class="location-link" data-restaurant="mall">
          <img src="{{ asset('frontend/img/gallery/gallery-4.jpg') }}" class="img-fluid" alt="Mall Branch Restaurant">
          </a>
          <div class="member-info">
            <div class="member-info-content">
              <h4>Mall Branch</h4>
              <span>456 Shopping Plaza, Level 3</span>
            </div>
            <div class="social">
              <a href="tel:+1234567893"><i class="bi bi-telephone"></i></a>
              <a href="https://maps.google.com" target="_blank"><i class="bi bi-geo-alt"></i></a>
              <a href="#menu" class="menu-link" data-restaurant="mall"><i class="bi bi-menu-button"></i></a>
              <a href="mailto:mall@foodymat.com"><i class="bi bi-envelope"></i></a>
            </div>
          </div>
        </div>
      </div>

    </div>
  </div>

</section><!-- /Restaurant Locations Section -->

<style>
.golden-text {
  color: var(--accent-color) !important;
  font-size: 2.5rem !important;
  margin-top: 0.5rem !important;
  text-align: left !important;
}
.section-title {
  text-align: left !important;
  padding-left: 1rem;
}
.section-title h2 {
  font-size: 1rem !important;
  letter-spacing: 2px !important;
  text-align: left !important;
}
.member {
  border-radius: 8px;
  overflow: hidden;
  box-shadow: 0 0 20px rgba(0,0,0,0.1);
}
.member img {
  height: 250px;
  object-fit: cover;
  width: 100%;
  transition: transform 0.3s ease;
}
.member:hover img {
  transform: scale(1.05);
}
.location-link {
  display: block;
  cursor: pointer;
}
.menu-link {
  background: var(--accent-color);
  color: var(--contrast-color) !important;
}
.menu-link:hover {
  background: color-mix(in srgb, var(--accent-color), transparent 20%);
}
</style> 

<script>
document.addEventListener('DOMContentLoaded', function() {
  // Handle location link clicks
  document.querySelectorAll('.location-link, .menu-link').forEach(link => {
    link.addEventListener('click', function(e) {
      const restaurant = this.getAttribute('data-restaurant');
      // Find and click the corresponding menu filter
      const filterButton = document.querySelector(`[data-filter=".filter-${restaurant}"]`);
      if (filterButton) {
        setTimeout(() => {
          filterButton.click();
        }, 100);
      }
    });
  });
});
</script> 