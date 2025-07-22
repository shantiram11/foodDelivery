<header id="header" class="header fixed-top">
  <div class="branding d-flex align-items-cente">

    <div class="container position-relative d-flex align-items-center justify-content-between">
      <a href="{{ url('/') }}" class="logo d-flex align-items-center me-auto me-xl-0">
        <!-- Uncomment the line below if you also wish to use an image logo -->
        <img src="{{ asset('frontend/img/logo.svg') }}" alt="">

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
      <a class="btn-clean d-none d-xl-block ms-2" href="{{ route('login') }}">
        <i class="bi bi-person"></i>Login
      </a>
      <a class="btn-clean d-none d-xl-block ms-2" href="{{ route('register') }}">
        <i class="bi bi-person-plus"></i>Signup
      </a>

    </div>

  </div>

</header> 