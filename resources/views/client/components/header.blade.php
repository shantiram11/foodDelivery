<header id="header" class="header fixed-top">

  <div class="topbar d-flex align-items-center">
    <div class="container d-flex justify-content-center justify-content-md-between">
      <div class="contact-info d-flex align-items-center">
        <i class="bi bi-envelope d-flex align-items-center"><a href="mailto:orders@foodymat.com">orders@foodymat.com</a></i>
        <i class="bi bi-phone d-flex align-items-center ms-4"><span>+1 (555) 123-FOOD</span></i>
      </div>
      <div class="languages d-none d-md-flex align-items-center">
        <ul>
          <li>En</li>
          <li><a href="#">Nep</a></li>
        </ul>
      </div>
    </div>
  </div><!-- End Top Bar -->

  <div class="branding d-flex align-items-cente">

    <div class="container position-relative d-flex align-items-center justify-content-between">
      <a href="{{ url('/') }}" class="logo d-flex align-items-center me-auto me-xl-0">
        <!-- Uncomment the line below if you also wish to use an image logo -->
        <img src="{{ asset('assets/img/logo.svg') }}" alt="">

      </a>

      <nav id="navmenu" class="navmenu">
        <ul>
          <li><a href="#hero" class="active">Home<br></a></li>
          <li><a href="#about">About</a></li>
          <li><a href="#menu">Menu</a></li>
          <li><a href="#specials">Specials</a></li>
          <li><a href="#events">Events</a></li>
          <li><a href="#chefs">Chefs</a></li>
          <li><a href="#gallery">Gallery</a></li>
          <li class="dropdown"><a href="#"><span>Services</span> <i class="bi bi-chevron-down toggle-dropdown"></i></a>
            <ul>
              <li><a href="#">Food Delivery</a></li>
              <li class="dropdown"><a href="#"><span>Catering</span> <i class="bi bi-chevron-down toggle-dropdown"></i></a>
                <ul>
                  <li><a href="#">Corporate Catering</a></li>
                  <li><a href="#">Party Catering</a></li>
                  <li><a href="#">Wedding Catering</a></li>
                  <li><a href="#">Event Planning</a></li>
                  <li><a href="#">Custom Menus</a></li>
                </ul>
              </li>
              <li><a href="#">Meal Plans</a></li>
              <li><a href="#">Gift Cards</a></li>
              <li><a href="#">Corporate Orders</a></li>
            </ul>
          </li>
          <li><a href="#contact">Contact</a></li>
        </ul>
        <i class="mobile-nav-toggle d-xl-none bi bi-list"></i>
      </nav>

      <a class="btn-book-a-table d-none d-xl-block" href="#book-a-table">Order Now</a>

    </div>

  </div>

</header> 