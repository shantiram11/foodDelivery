<footer id="footer" class="footer">

  <div class="container footer-top">
    <div class="row gy-4">
      <div class="col-lg-4 col-md-6 footer-about">
        <a href="{{ url('/') }}" class="logo d-flex align-items-center">
          <span class="sitename">Foodymat</span>
        </a>
        <div class="footer-contact pt-3">
          <p>1234 Food Street</p>
          <p>Downtown District, NY 10001</p>
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
          <li><a href="#">Home</a></li>
          <li><a href="#">About Us</a></li>
          <li><a href="#">Our Menu</a></li>
          <li><a href="#">Order Online</a></li>
          <li><a href="#">Contact</a></li>
        </ul>
      </div>

      <div class="col-lg-2 col-md-3 footer-links">
        <h4>Our Services</h4>
        <ul>
          <li><a href="#">Food Delivery</a></li>
          <li><a href="#">Catering Services</a></li>
          <li><a href="#">Party Planning</a></li>
          <li><a href="#">Corporate Events</a></li>
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