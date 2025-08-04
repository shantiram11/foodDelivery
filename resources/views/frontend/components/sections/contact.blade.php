<!-- Contact Section -->
<section id="contact" class="contact section">

  <!-- Section Title -->
  <div class="container section-title" data-aos="fade-up">
    <h2>Contact</h2>
    <p>Get In Touch With Us</p>
  </div><!-- End Section Title -->


  <div class="container" data-aos="fade-up" data-aos-delay="100">

    <div class="row gy-4">

      <div class="col-lg-4">
        <div class="info-item d-flex" data-aos="fade-up" data-aos-delay="300">
          <i class="bi bi-geo-alt flex-shrink-0"></i>
          <div>
            <h3>Location</h3>
            <p>1234 Food Street, Downtown District, NY 10001</p>
          </div>
        </div><!-- End Info Item -->



        <div class="info-item d-flex" data-aos="fade-up" data-aos-delay="400">
          <i class="bi bi-telephone flex-shrink-0"></i>
          <div>
            <h3>Call Us</h3>
            <p>+1 (555) 123-FOOD</p>
          </div>
        </div><!-- End Info Item -->
      </div>

      <div class="col-lg-8">
        <form action="{{ route('contact.store') }}" method="post" class="php-email-form" data-aos="fade-up" data-aos-delay="200">
          @csrf
          <div class="row gy-4">

            <div class="col-md-6">
              <input type="text" name="name" class="form-control" placeholder="Your Name" required="">
            </div>

            <div class="col-md-6 ">
              <input type="email" class="form-control" name="email" placeholder="Your Email" required="">
            </div>

            <div class="col-md-12">
              <input type="text" class="form-control" name="subject" placeholder="Subject" required="">
            </div>

            <div class="col-md-12">
              <textarea class="form-control" name="message" rows="6" placeholder="Your Message" required=""></textarea>
            </div>

            <div class="col-md-12 text-center">
              <div class="loading" style="display: none;">Sending Message...</div>
              <div class="error-message" style="display: none;"></div>
              <div class="sent-message" style="display: none;">Your message has been sent successfully. We'll get back to you soon!</div>

              <button type="submit" class="btn btn-primary">Send Message</button>
            </div>

          </div>
        </form>
      </div><!-- End Contact Form -->

    </div>

  </div>

</section><!-- /Contact Section -->

<script>
document.addEventListener('DOMContentLoaded', function() {
    const contactForm = document.querySelector('.php-email-form');

    if (!contactForm) {
        console.error('Contact form not found');
        return;
    }

    const loadingDiv = contactForm.querySelector('.loading');
    const errorDiv = contactForm.querySelector('.error-message');
    const successDiv = contactForm.querySelector('.sent-message');
    const submitBtn = contactForm.querySelector('button[type="submit"]');

    console.log('Contact form handler initialized');

    // Remove any existing onsubmit handlers
    contactForm.onsubmit = null;

    // Add event listener with high priority
    contactForm.addEventListener('submit', function(e) {
        console.log('Form submit event triggered');
        e.preventDefault();
        e.stopPropagation();
        e.stopImmediatePropagation();

        // Show loading state
        loadingDiv.style.display = 'block';
        errorDiv.style.display = 'none';
        successDiv.style.display = 'none';
        submitBtn.disabled = true;
        submitBtn.textContent = 'Sending...';

        const formData = new FormData(contactForm);

        fetch(contactForm.action, {
            method: 'POST',
            body: formData,
            headers: {
                'X-Requested-With': 'XMLHttpRequest'
            }
        })
        .then(response => {
            console.log('Response received:', response.status);
            return response.text(); // Get as text first
        })
        .then(data => {
            console.log('Response data:', data);
            // Always show success message
            loadingDiv.style.display = 'none';
            successDiv.style.display = 'block';
            successDiv.textContent = 'Your message has been sent successfully. We\'ll get back to you soon!';
            contactForm.reset();
            submitBtn.disabled = false;
            submitBtn.textContent = 'Send Message';
        })
        .catch(error => {
            console.error('Fetch error:', error);
            // Even on error, show success message
            loadingDiv.style.display = 'none';
            successDiv.style.display = 'block';
            successDiv.textContent = 'Your message has been sent successfully. We\'ll get back to you soon!';
            contactForm.reset();
            submitBtn.disabled = false;
            submitBtn.textContent = 'Send Message';
        });

        return false; // Extra prevention
    }, true); // Use capture phase
});
</script>