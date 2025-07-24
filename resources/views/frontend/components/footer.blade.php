<footer id="footer" class="footer">

  <div class="container footer-top">
    <div class="row gy-4">
      <div class="col-lg-4 col-md-6 footer-about">
        <a href="{{ url('/') }}" class="logo d-flex align-items-center">
          <img src="{{ asset('frontend/img/logo.svg') }}" alt="Foodymat" style="height: 32px; width: auto;">
        </a>
        <div class="footer-contact pt-2">
          <p class="mt-3"><strong>Phone:</strong> <span>+1 (555) 123-FOOD</span></p>
          <p><strong>Email:</strong> <span>orders@foodymat.com</span></p>
        </div>
        <div class="social-links d-flex mt-4">
          <a href=""><i class="bi bi-twitter-x"></i></a>
          <a href=""><i class="bi bi-facebook"></i></a>
          <a href=""><i class="bi bi-instagram"></i></a>
          <a href=""><i class="bi bi-linkedin"></i></a>
        </div>
      </div>

                    <div class="col-lg-2 col-md-3 footer-links">
                <h4>Quick Links</h4>
                <ul>
                  <li><a href="{{ route('home') }}">Home</a></li>
                  <li><a href="{{ route('home') }}#about">About Us</a></li>
                  <li><a href="{{ route('home') }}#menu">Our Menu</a></li>
                  <li><a href="{{ route('home') }}#order-online">Order Online</a></li>
                  <li><a href="{{ route('home') }}#contact">Contact</a></li>
                </ul>
              </div>

      <div class="col-lg-2 col-md-3 footer-links">
        <h4>Our Services</h4>
        <ul>
          <li><a href="#">Food Delivery</a></li>
          <li><a href="#">Gift Cards</a></li>
        </ul>
      </div>

      <div class="col-lg-4 col-md-12 footer-newsletter">
        <h4>Stay Updated</h4>
        <p>Subscribe to our newsletter for special offers, new menu items, and exclusive deals!</p>
        <form action="{{ url('forms/newsletter') }}" method="post" class="php-email-form">
          @csrf
          <div class="newsletter-form">
            <input type="email" name="email" placeholder="Enter your email" required>
            <input type="submit" value="Subscribe">
          </div>
          <div class="loading">Processing</div>
          <div class="error-message"></div>
          <div class="sent-message">Thank you for subscribing! Check your email for exclusive offers.</div>
        </form>
      </div>

    </div>
  </div>
</footer> 