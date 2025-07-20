
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">
  <title>Foodymat - Premium Food Delivery</title>
  <meta name="description" content="Order delicious meals from the comfort of your home. Fresh ingredients, fast delivery, and exceptional taste guaranteed.">
  <meta name="keywords" content="food delivery, restaurant, online ordering, fresh food, fast delivery">

  <!-- Favicons -->
  <link href="assets/img/logo_white.svg" rel="icon">
  <link href="assets/img/apple-touch-icon.png" rel="apple-touch-icon">

  <!-- Fonts -->
  <link href="https://fonts.googleapis.com" rel="preconnect">
  <link href="https://fonts.gstatic.com" rel="preconnect" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Playfair+Display:ital,wght@0,400;0,500;0,600;0,700;0,800;0,900;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">

  <!-- Vendor CSS Files -->
  <link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link href="assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
  <link href="assets/vendor/aos/aos.css" rel="stylesheet">
  <link href="assets/vendor/glightbox/css/glightbox.min.css" rel="stylesheet">
  <link href="assets/vendor/swiper/swiper-bundle.min.css" rel="stylesheet">

  <!-- Main CSS File -->
  <link href="assets/css/main.css" rel="stylesheet">
</head>

<body class="index-page">

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
            <li><a href="#">Es</a></li>
          </ul>
        </div>
      </div>
    </div><!-- End Top Bar -->

    <div class="branding d-flex align-items-cente">

      <div class="container position-relative d-flex align-items-center justify-content-between">
        <a href="index.html" class="logo d-flex align-items-center me-auto me-xl-0">
          <!-- Uncomment the line below if you also wish to use an image logo -->
          <img src="assets/img/logo_white.svg" alt="">
  
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

  <main class="main">

    <!-- Hero Section -->
    <section id="hero" class="hero section dark-background">

      <img src="assets/img/hero-bg.jpg" alt="" data-aos="fade-in">

      <div class="container">
        <div class="row">
          <div class="col-lg-8 d-flex flex-column align-items-center align-items-lg-start">
            <h2 data-aos="fade-up" data-aos-delay="100">Welcome to <span>Foodymat</span></h2>
            <p data-aos="fade-up" data-aos-delay="200">Serving exceptional cuisine with fresh ingredients and fast delivery for over 10 years!</p>
            <div class="d-flex mt-4" data-aos="fade-up" data-aos-delay="300">
              <a href="#menu" class="cta-btn">Browse Menu</a>
              <a href="#book-a-table" class="cta-btn">Order Online</a>
            </div>
          </div>
          <div class="col-lg-4 d-flex align-items-center justify-content-center mt-5 mt-lg-0">
            <a href="https://www.youtube.com/watch?v=Y7f98aduVJ8" class="glightbox pulsating-play-btn"></a>
          </div>
        </div>
      </div>

    </section><!-- /Hero Section -->

    <!-- About Section -->
    <section id="about" class="about section">

      <div class="container" data-aos="fade-up" data-aos-delay="100">

        <div class="row gy-4">
          <div class="col-lg-6 order-1 order-lg-2">
            <img src="assets/img/about.jpg" class="img-fluid about-img" alt="">
          </div>
          <div class="col-lg-6 order-2 order-lg-1 content">
            <h3>Fresh Ingredients, Exceptional Taste</h3>
            <p class="fst-italic">
              At Delicious Bites, we believe that great food starts with the finest ingredients. Our commitment to quality and freshness sets us apart in the food delivery industry.
            </p>
            <ul>
              <li><i class="bi bi-check2-all"></i> <span>Locally sourced organic ingredients from trusted farmers and suppliers.</span></li>
              <li><i class="bi bi-check2-all"></i> <span>Expert chefs with years of culinary experience and passion for innovation.</span></li>
              <li><i class="bi bi-check2-all"></i> <span>Lightning-fast delivery service ensuring your food arrives hot and fresh. We guarantee delivery within 30-45 minutes or your meal is free.</span></li>
            </ul>
            <p>
              Our kitchen operates with the highest standards of cleanliness and food safety. Every dish is prepared fresh to order, and we never compromise on quality. From our signature burgers to our gourmet salads, each item is crafted with care and attention to detail.
            </p>
          </div>
        </div>

      </div>

    </section><!-- /About Section -->

    <!-- Why Us Section -->
    <section id="why-us" class="why-us section">

      <!-- Section Title -->
      <div class="container section-title" data-aos="fade-up">
        <h2>WHY CHOOSE US</h2>
        <p>What Makes Foodymat Special</p>
      </div><!-- End Section Title -->

      <div class="container">

        <div class="row gy-4">

          <div class="col-lg-4" data-aos="fade-up" data-aos-delay="100">
            <div class="card-item">
              <span>01</span>
              <h4><a href="" class="stretched-link">Fast Delivery</a></h4>
              <p>Lightning-fast delivery service with GPS tracking. Your food arrives hot and fresh within 30-45 minutes guaranteed.</p>
            </div>
          </div><!-- Card Item -->

          <div class="col-lg-4" data-aos="fade-up" data-aos-delay="200">
            <div class="card-item">
              <span>02</span>
              <h4><a href="" class="stretched-link">Premium Quality</a></h4>
              <p>We source only the finest ingredients and our expert chefs prepare each dish with precision and care for exceptional taste.</p>
            </div>
          </div><!-- Card Item -->

          <div class="col-lg-4" data-aos="fade-up" data-aos-delay="300">
            <div class="card-item">
              <span>03</span>
              <h4><a href="" class="stretched-link">24/7 Service</a></h4>
              <p>Round-the-clock availability for your convenience. Order anytime, anywhere through our app or website.</p>
            </div>
          </div><!-- Card Item -->

        </div>

      </div>

    </section><!-- /Why Us Section -->

    <!-- Menu Section -->
    <section id="menu" class="menu section">

      <!-- Section Title -->
      <div class="container section-title" data-aos="fade-up">
        <h2>Our Menu</h2>
        <p>Discover Our Delicious Offerings</p>
      </div><!-- End Section Title -->

      <div class="container isotope-layout" data-default-filter="*" data-layout="masonry" data-sort="original-order">

        <div class="row" data-aos="fade-up" data-aos-delay="100">
          <div class="col-lg-12 d-flex justify-content-center">
            <ul class="menu-filters isotope-filters">
              <li data-filter="*" class="filter-active">All</li>
              <li data-filter=".filter-starters">Appetizers</li>
              <li data-filter=".filter-salads">Salads</li>
              <li data-filter=".filter-specialty">Main Courses</li>
            </ul>
          </div>
        </div><!-- Menu Filters -->

        <div class="row isotope-container" data-aos="fade-up" data-aos-delay="200">

          <div class="col-lg-6 menu-item isotope-item filter-starters">
            <img src="assets/img/menu/lobster-bisque.jpg" class="menu-img" alt="">
            <div class="menu-content">
              <a href="#">Creamy Tomato Bisque</a><span>$8.95</span>
            </div>
            <div class="menu-ingredients">
              Rich tomato base, fresh cream, herbs, garlic croutons
            </div>
          </div><!-- Menu Item -->

          <div class="col-lg-6 menu-item isotope-item filter-specialty">
            <img src="assets/img/menu/bread-barrel.jpg" class="menu-img" alt="">
            <div class="menu-content">
              <a href="#">Artisan Bread Basket</a><span>$12.95</span>
            </div>
            <div class="menu-ingredients">
              Freshly baked sourdough, focaccia, herb butter, olive tapenade
            </div>
          </div><!-- Menu Item -->

          <div class="col-lg-6 menu-item isotope-item filter-starters">
            <img src="assets/img/menu/cake.jpg" class="menu-img" alt="">
            <div class="menu-content">
              <a href="#">Maryland Crab Cakes</a><span>$16.95</span>
            </div>
            <div class="menu-ingredients">
              Fresh crab meat, panko crust, remoulade sauce, mixed greens
            </div>
          </div><!-- Menu Item -->

          <div class="col-lg-6 menu-item isotope-item filter-salads">
            <img src="assets/img/menu/caesar.jpg" class="menu-img" alt="">
            <div class="menu-content">
              <a href="#">Classic Caesar Salad</a><span>$14.95</span>
            </div>
            <div class="menu-ingredients">
              Crisp romaine, parmesan, house-made croutons, caesar dressing
            </div>
          </div><!-- Menu Item -->

          <div class="col-lg-6 menu-item isotope-item filter-specialty">
            <img src="assets/img/menu/tuscan-grilled.jpg" class="menu-img" alt="">
            <div class="menu-content">
              <a href="#">Tuscan Grilled Chicken</a><span>$22.95</span>
            </div>
            <div class="menu-ingredients">
              Herb-marinated chicken breast, roasted vegetables, balsamic glaze
            </div>
          </div><!-- Menu Item -->

          <div class="col-lg-6 menu-item isotope-item filter-starters">
            <img src="assets/img/menu/mozzarella.jpg" class="menu-img" alt="">
            <div class="menu-content">
              <a href="#">Truffle Mac & Cheese</a><span>$11.95</span>
            </div>
            <div class="menu-ingredients">
              Three-cheese blend, truffle oil, crispy breadcrumbs, chives
            </div>
          </div><!-- Menu Item -->

          <div class="col-lg-6 menu-item isotope-item filter-salads">
            <img src="assets/img/menu/greek-salad.jpg" class="menu-img" alt="">
            <div class="menu-content">
              <a href="#">Mediterranean Bowl</a><span>$17.95</span>
            </div>
            <div class="menu-ingredients">
              Quinoa, feta, olives, cherry tomatoes, cucumber, lemon vinaigrette
            </div>
          </div><!-- Menu Item -->

          <div class="col-lg-6 menu-item isotope-item filter-salads">
            <img src="assets/img/menu/spinach-salad.jpg" class="menu-img" alt="">
            <div class="menu-content">
              <a href="#">Harvest Spinach Salad</a><span>$15.95</span>
            </div>
            <div class="menu-ingredients">
              Baby spinach, candied walnuts, dried cranberries, goat cheese, poppy seed dressing
            </div>
          </div><!-- Menu Item -->

          <div class="col-lg-6 menu-item isotope-item filter-specialty">
            <img src="assets/img/menu/lobster-roll.jpg" class="menu-img" alt="">
            <div class="menu-content">
              <a href="#">Gourmet Burger Deluxe</a><span>$18.95</span>
            </div>
            <div class="menu-ingredients">
              Angus beef, aged cheddar, bacon, arugula, truffle fries
            </div>
          </div><!-- Menu Item -->

        </div><!-- Menu Container -->

      </div>

    </section><!-- /Menu Section -->

    <!-- Specials Section -->
    <section id="specials" class="specials section">

      <!-- Section Title -->
      <div class="container section-title" data-aos="fade-up">
        <h2>Daily Specials</h2>
        <p>Chef's Featured Creations</p>
      </div><!-- End Section Title -->

      <div class="container" data-aos="fade-up" data-aos-delay="100">

        <div class="row">
          <div class="col-lg-3">
            <ul class="nav nav-tabs flex-column">
              <li class="nav-item">
                <a class="nav-link active show" data-bs-toggle="tab" href="#specials-tab-1">Monday Special</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" data-bs-toggle="tab" href="#specials-tab-2">Tuesday Special</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" data-bs-toggle="tab" href="#specials-tab-3">Wednesday Special</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" data-bs-toggle="tab" href="#specials-tab-4">Thursday Special</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" data-bs-toggle="tab" href="#specials-tab-5">Weekend Special</a>
              </li>
            </ul>
          </div>
          <div class="col-lg-9 mt-4 mt-lg-0">
            <div class="tab-content">
              <div class="tab-pane active show" id="specials-tab-1">
                <div class="row">
                  <div class="col-lg-8 details order-2 order-lg-1">
                    <h3>Meatless Monday - Vegetarian Delight</h3>
                    <p class="fst-italic">Start your week with our healthy and delicious plant-based options featuring seasonal vegetables and creative preparations.</p>
                    <p>Our Monday special includes our famous quinoa-stuffed bell peppers, roasted vegetable pasta, and a fresh garden salad. All made with locally sourced organic produce and seasoned with house-made herb blends. Perfect for health-conscious diners looking for satisfying meat-free options.</p>
                  </div>
                  <div class="col-lg-4 text-center order-1 order-lg-2">
                    <img src="assets/img/specials-1.png" alt="" class="img-fluid">
                  </div>
                </div>
              </div>
              <div class="tab-pane" id="specials-tab-2">
                <div class="row">
                  <div class="col-lg-8 details order-2 order-lg-1">
                    <h3>Taco Tuesday Fiesta</h3>
                    <p class="fst-italic">Celebrate with authentic Mexican flavors featuring handmade tortillas, fresh salsas, and premium ingredients sourced from local Mexican markets.</p>
                    <p>Enjoy our signature carnitas, grilled fish, and vegetarian black bean tacos served with Mexican rice, refried beans, and our famous guacamole made fresh daily. Don't forget to try our house margaritas and agua frescas!</p>
                  </div>
                  <div class="col-lg-4 text-center order-1 order-lg-2">
                    <img src="assets/img/specials-2.png" alt="" class="img-fluid">
                  </div>
                </div>
              </div>
              <div class="tab-pane" id="specials-tab-3">
                <div class="row">
                  <div class="col-lg-8 details order-2 order-lg-1">
                    <h3>Wing Wednesday Extravaganza</h3>
                    <p class="fst-italic">Midweek comfort food at its finest with our famous chicken wings available in 12 different flavors from mild to blazing hot.</p>
                    <p>Choose from Buffalo, BBQ, honey garlic, teriyaki, cajun dry rub, and more. Served with celery sticks, carrots, and your choice of ranch or blue cheese dressing. Perfect for sharing or enjoying solo with our crispy seasoned fries.</p>
                  </div>
                  <div class="col-lg-4 text-center order-1 order-lg-2">
                    <img src="assets/img/specials-3.png" alt="" class="img-fluid">
                  </div>
                </div>
              </div>
              <div class="tab-pane" id="specials-tab-4">
                <div class="row">
                  <div class="col-lg-8 details order-2 order-lg-1">
                    <h3>Throwback Thursday Classics</h3>
                    <p class="fst-italic">Nostalgic comfort food favorites reimagined with modern techniques and premium ingredients for an elevated dining experience.</p>
                    <p>Featured dishes include our famous meatloaf with garlic mashed potatoes, classic fried chicken with mac and cheese, and our signature pot roast with root vegetables. All served with warm dinner rolls and honey butter.</p>
                  </div>
                  <div class="col-lg-4 text-center order-1 order-lg-2">
                    <img src="assets/img/specials-4.png" alt="" class="img-fluid">
                  </div>
                </div>
              </div>
              <div class="tab-pane" id="specials-tab-5">
                <div class="row">
                  <div class="col-lg-8 details order-2 order-lg-1">
                    <h3>Weekend Prime Time Steaks</h3>
                    <p class="fst-italic">Premium USDA Prime steaks grilled to perfection and served with gourmet sides for the ultimate weekend dining experience.</p>
                    <p>Choose from ribeye, filet mignon, or New York strip, all aged 28 days for maximum flavor and tenderness. Served with loaded baked potato or truffle fries, seasonal vegetables, and our signature steak sauce. Add lobster tail for the surf and turf experience.</p>
                  </div>
                  <div class="col-lg-4 text-center order-1 order-lg-2">
                    <img src="assets/img/specials-5.png" alt="" class="img-fluid">
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>

      </div>

    </section><!-- /Specials Section -->

    <!-- Events Section -->
    <section id="events" class="events section">

      <img class="slider-bg" src="assets/img/events-bg.jpg" alt="" data-aos="fade-in">

      <div class="container">

        <div class="swiper init-swiper" data-aos="fade-up" data-aos-delay="100">
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
              }
            }
          </script>
          <div class="swiper-wrapper">

            <div class="swiper-slide">
              <div class="row gy-4 event-item">
                <div class="col-lg-6">
                  <img src="assets/img/events-slider/events-slider-1.jpg" class="img-fluid" alt="">
                </div>
                <div class="col-lg-6 pt-4 pt-lg-0 content">
                  <h3>Birthday Party Catering</h3>
                  <div class="price">
                    <p><span>Starting at $299</span></p>
                  </div>
                  <p class="fst-italic">
                    Make your special day unforgettable with our comprehensive birthday party catering services, featuring customizable menus for all ages.
                  </p>
                  <ul>
                    <li><i class="bi bi-check2-circle"></i> <span>Custom birthday cakes and dessert stations with themed decorations.</span></li>
                    <li><i class="bi bi-check2-circle"></i> <span>Kid-friendly menu options including mini burgers, chicken tenders, and fruit platters.</span></li>
                    <li><i class="bi bi-check2-circle"></i> <span>Full setup and cleanup service with professional staff and decorations.</span></li>
                  </ul>
                  <p>
                    Our birthday packages include everything you need for a memorable celebration, from appetizers to desserts, with options for dietary restrictions and allergies.
                  </p>
                </div>
              </div>
            </div><!-- End Slider item -->

            <div class="swiper-slide">
              <div class="row gy-4 event-item">
                <div class="col-lg-6">
                  <img src="assets/img/events-slider/events-slider-2.jpg" class="img-fluid" alt="">
                </div>
                <div class="col-lg-6 pt-4 pt-lg-0 content">
                  <h3>Corporate Events</h3>
                  <div class="price">
                    <p><span>Starting at $450</span></p>
                  </div>
                  <p class="fst-italic">
                    Professional catering services for business meetings, conferences, and corporate celebrations with elegant presentation and reliable service.
                  </p>
                  <ul>
                    <li><i class="bi bi-check2-circle"></i> <span>Business lunch platters with gourmet sandwiches, salads, and sides.</span></li>
                    <li><i class="bi bi-check2-circle"></i> <span>Coffee and beverage service with premium brands and fresh pastries.</span></li>
                    <li><i class="bi bi-check2-circle"></i> <span>Flexible scheduling and delivery to accommodate your business needs.</span></li>
                  </ul>
                  <p>
                    Impress your clients and colleagues with our professional catering service, featuring fresh, high-quality ingredients and impeccable presentation.
                  </p>
                </div>
              </div>
            </div><!-- End Slider item -->

            <div class="swiper-slide">
              <div class="row gy-4 event-item">
                <div class="col-lg-6">
                  <img src="assets/img/events-slider/events-slider-3.jpg" class="img-fluid" alt="">
                </div>
                <div class="col-lg-6 pt-4 pt-lg-0 content">
                  <h3>Wedding Catering</h3>
                  <div class="price">
                    <p><span>Custom Pricing</span></p>
                  </div>
                  <p class="fst-italic">
                    Create the perfect wedding day with our elegant catering services, featuring customized menus and exceptional service for your special celebration.
                  </p>
                  <ul>
                    <li><i class="bi bi-check2-circle"></i> <span>Personalized menu consultations with our executive chef for your dream wedding meal.</span></li>
                    <li><i class="bi bi-check2-circle"></i> <span>Elegant plated dinners or buffet service with professional waitstaff.</span></li>
                    <li><i class="bi bi-check2-circle"></i> <span>Coordination with wedding planners and venues for seamless execution.</span></li>
                  </ul>
                  <p>
                    From intimate gatherings to grand celebrations, we work with you to create a memorable dining experience that reflects your style and preferences.
                  </p>
                </div>
              </div>
            </div><!-- End Slider item -->

          </div>
          <div class="swiper-pagination"></div>
        </div>

      </div>

    </section><!-- /Events Section -->

    <!-- Book A Table Section -->
    <section id="book-a-table" class="book-a-table section">

      <!-- Section Title -->
      <div class="container section-title" data-aos="fade-up">
        <h2>ORDER ONLINE</h2>
        <p>Place Your Order</p>
      </div><!-- End Section Title -->

      <div class="container" data-aos="fade-up" data-aos-delay="100">

        <form action="forms/book-a-table.php" method="post" role="form" class="php-email-form">
          <div class="row gy-4">
            <div class="col-lg-4 col-md-6">
              <input type="text" name="name" class="form-control" id="name" placeholder="Your Name" required="">
            </div>
            <div class="col-lg-4 col-md-6">
              <input type="email" class="form-control" name="email" id="email" placeholder="Your Email" required="">
            </div>
            <div class="col-lg-4 col-md-6">
              <input type="text" class="form-control" name="phone" id="phone" placeholder="Your Phone" required="">
            </div>
            <div class="col-lg-4 col-md-6">
              <input type="date" name="date" class="form-control" id="date" placeholder="Delivery Date" required="">
            </div>
            <div class="col-lg-4 col-md-6">
              <input type="time" class="form-control" name="time" id="time" placeholder="Delivery Time" required="">
            </div>
            <div class="col-lg-4 col-md-6">
              <input type="text" class="form-control" name="people" id="people" placeholder="Delivery Address" required="">
            </div>
          </div>

          <div class="form-group mt-3">
            <textarea class="form-control" name="message" rows="5" placeholder="Special Instructions (allergies, preferences, etc.)"></textarea>
          </div>

          <div class="text-center mt-3">
            <div class="loading">Processing Order</div>
            <div class="error-message"></div>
            <div class="sent-message">Your order has been received! We'll contact you shortly to confirm delivery details. Thank you!</div>
            <button type="submit">Place Order</button>
          </div>
        </form><!-- End Order Form -->

      </div>

    </section><!-- /Order Section -->

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
              <div class="testimonial-item" "="">
            <p>
              <i class=" bi bi-quote quote-icon-left"></i>
                <span>Absolutely amazing food and lightning-fast delivery! The grilled chicken was perfectly seasoned and the truffle fries were to die for. Will definitely be ordering again soon.</span>
                <i class="bi bi-quote quote-icon-right"></i>
                </p>
                <img src="assets/img/testimonials/testimonials-1.jpg" class="testimonial-img" alt="">
                <h3>Sarah Johnson</h3>
                <h4>Regular Customer</h4>
              </div>
            </div><!-- End testimonial item -->

            <div class="swiper-slide">
              <div class="testimonial-item">
                <p>
                  <i class="bi bi-quote quote-icon-left"></i>
                  <span>Delicious Bites catered our wedding and it was absolutely perfect! The food was exceptional and the service was flawless. All our guests raved about the meal. Highly recommend!</span>
                  <i class="bi bi-quote quote-icon-right"></i>
                </p>
                <img src="assets/img/testimonials/testimonials-2.jpg" class="testimonial-img" alt="">
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
                <img src="assets/img/testimonials/testimonials-3.jpg" class="testimonial-img" alt="">
                <h3>Emma Rodriguez</h3>
                <h4>Health Enthusiast</h4>
              </div>
            </div><!-- End testimonial item -->

            <div class="swiper-slide">
              <div class="testimonial-item">
                <p>
                  <i class="bi bi-quote quote-icon-left"></i>
                  <span>I order from Delicious Bites for all my corporate meetings. The food is always fresh, arrives on time, and impresses my clients. Professional service every time.</span>
                  <i class="bi bi-quote quote-icon-right"></i>
                </p>
                <img src="assets/img/testimonials/testimonials-4.jpg" class="testimonial-img" alt="">
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
                <img src="assets/img/testimonials/testimonials-5.jpg" class="testimonial-img" alt="">
                <h3>Jennifer Wilson</h3>
                <h4>Food Blogger</h4>
              </div>
            </div><!-- End testimonial item -->

          </div>
          <div class="swiper-pagination"></div>
        </div>

      </div>

    </section><!-- /Testimonials Section -->

    <!-- Gallery Section -->
    <section id="gallery" class="gallery section">

      <!-- Section Title -->
      <div class="container section-title" data-aos="fade-up">
        <h2>Photo Gallery</h2>
        <p>Delicious Moments From Our Kitchen</p>
      </div><!-- End Section Title -->

      <div class="container-fluid" data-aos="fade-up" data-aos-delay="100">

        <div class="row g-0">

          <div class="col-lg-3 col-md-4">
            <div class="gallery-item">
              <a href="assets/img/gallery/gallery-1.jpg" class="glightbox" data-gallery="images-gallery">
                <img src="assets/img/gallery/gallery-1.jpg" alt="" class="img-fluid">
              </a>
            </div>
          </div><!-- End Gallery Item -->

          <div class="col-lg-3 col-md-4">
            <div class="gallery-item">
              <a href="assets/img/gallery/gallery-2.jpg" class="glightbox" data-gallery="images-gallery">
                <img src="assets/img/gallery/gallery-2.jpg" alt="" class="img-fluid">
              </a>
            </div>
          </div><!-- End Gallery Item -->

          <div class="col-lg-3 col-md-4">
            <div class="gallery-item">
              <a href="assets/img/gallery/gallery-3.jpg" class="glightbox" data-gallery="images-gallery">
                <img src="assets/img/gallery/gallery-3.jpg" alt="" class="img-fluid">
              </a>
            </div>
          </div><!-- End Gallery Item -->

          <div class="col-lg-3 col-md-4">
            <div class="gallery-item">
              <a href="assets/img/gallery/gallery-4.jpg" class="glightbox" data-gallery="images-gallery">
                <img src="assets/img/gallery/gallery-4.jpg" alt="" class="img-fluid">
              </a>
            </div>
          </div><!-- End Gallery Item -->

          <div class="col-lg-3 col-md-4">
            <div class="gallery-item">
              <a href="assets/img/gallery/gallery-5.jpg" class="glightbox" data-gallery="images-gallery">
                <img src="assets/img/gallery/gallery-5.jpg" alt="" class="img-fluid">
              </a>
            </div>
          </div><!-- End Gallery Item -->

          <div class="col-lg-3 col-md-4">
            <div class="gallery-item">
              <a href="assets/img/gallery/gallery-6.jpg" class="glightbox" data-gallery="images-gallery">
                <img src="assets/img/gallery/gallery-6.jpg" alt="" class="img-fluid">
              </a>
            </div>
          </div><!-- End Gallery Item -->

          <div class="col-lg-3 col-md-4">
            <div class="gallery-item">
              <a href="assets/img/gallery/gallery-7.jpg" class="glightbox" data-gallery="images-gallery">
                <img src="assets/img/gallery/gallery-7.jpg" alt="" class="img-fluid">
              </a>
            </div>
          </div><!-- End Gallery Item -->

          <div class="col-lg-3 col-md-4">
            <div class="gallery-item">
              <a href="assets/img/gallery/gallery-8.jpg" class="glightbox" data-gallery="images-gallery">
                <img src="assets/img/gallery/gallery-8.jpg" alt="" class="img-fluid">
              </a>
            </div>
          </div><!-- End Gallery Item -->

        </div>

      </div>

    </section><!-- /Gallery Section -->

    <!-- Chefs Section -->
    <section id="chefs" class="chefs section">

      <!-- Section Title -->
      <div class="container section-title" data-aos="fade-up">
        <h2>Our Team</h2>
        <p>Meet Our Culinary Experts</p>
      </div><!-- End Section Title -->

      <div class="container">

        <div class="row gy-4">

          <div class="col-lg-4" data-aos="fade-up" data-aos-delay="100">
            <div class="member">
              <img src="assets/img/chefs/chefs-1.jpg" class="img-fluid" alt="">
              <div class="member-info">
                <div class="member-info-content">
                  <h4>Chef Alessandro Martinez</h4>
                  <span>Executive Chef</span>
                </div>
                <div class="social">
                  <a href=""><i class="bi bi-twitter-x"></i></a>
                  <a href=""><i class="bi bi-facebook"></i></a>
                  <a href=""><i class="bi bi-instagram"></i></a>
                  <a href=""><i class="bi bi-linkedin"></i></a>
                </div>
              </div>
            </div>
          </div><!-- End Team Member -->

          <div class="col-lg-4" data-aos="fade-up" data-aos-delay="200">
            <div class="member">
              <img src="assets/img/chefs/chefs-2.jpg" class="img-fluid" alt="">
              <div class="member-info">
                <div class="member-info-content">
                  <h4>Chef Sophia Chen</h4>
                  <span>Pastry Chef</span>
                </div>
                <div class="social">
                  <a href=""><i class="bi bi-twitter-x"></i></a>
                  <a href=""><i class="bi bi-facebook"></i></a>
                  <a href=""><i class="bi bi-instagram"></i></a>
                  <a href=""><i class="bi bi-linkedin"></i></a>
                </div>
              </div>
            </div>
          </div><!-- End Team Member -->

          <div class="col-lg-4" data-aos="fade-up" data-aos-delay="300">
            <div class="member">
              <img src="assets/img/chefs/chefs-3.jpg" class="img-fluid" alt="">
              <div class="member-info">
                <div class="member-info-content">
                  <h4>Chef Marcus Johnson</h4>
                  <span>Sous Chef</span>
                </div>
                <div class="social">
                  <a href=""><i class="bi bi-twitter-x"></i></a>
                  <a href=""><i class="bi bi-facebook"></i></a>
                  <a href=""><i class="bi bi-instagram"></i></a>
                  <a href=""><i class="bi bi-linkedin"></i></a>
                </div>
              </div>
            </div>
          </div><!-- End Team Member -->

        </div>

      </div>

    </section><!-- /Chefs Section -->

    <!-- Contact Section -->
    <section id="contact" class="contact section">

      <!-- Section Title -->
      <div class="container section-title" data-aos="fade-up">
        <h2>Contact</h2>
        <p>Get In Touch With Us</p>
      </div><!-- End Section Title -->

      <div class="mb-5" data-aos="fade-up" data-aos-delay="200">
        <iframe style="border:0; width: 100%; height: 400px;" src="https://www.google.com/maps/embed?pb=!1m14!1m8!1m3!1d48389.78314118045!2d-74.006138!3d40.710059!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x89c25a22a3bda30d%3A0xb89d1fe6bc499443!2sDowntown%20Conference%20Center!5e0!3m2!1sen!2sus!4v1676961268712!5m2!1sen!2sus" frameborder="0" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
      </div><!-- End Google Maps -->

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
              <i class="bi bi-clock flex-shrink-0"></i>
              <div>
                <h3>Open Hours</h3>
                <p>Monday-Sunday:<br>10:00 AM - 11:00 PM</p>
              </div>
            </div><!-- End Info Item -->

            <div class="info-item d-flex" data-aos="fade-up" data-aos-delay="400">
              <i class="bi bi-telephone flex-shrink-0"></i>
              <div>
                <h3>Call Us</h3>
                <p>+1 (555) 123-FOOD</p>
              </div>
            </div><!-- End Info Item -->

            <div class="info-item d-flex" data-aos="fade-up" data-aos-delay="500">
              <i class="bi bi-envelope flex-shrink-0"></i>
              <div>
                <h3>Email Us</h3>
                <p>orders@deliciousbites.com</p>
              </div>
            </div><!-- End Info Item -->

          </div>

          <div class="col-lg-8">
            <form action="forms/contact.php" method="post" class="php-email-form" data-aos="fade-up" data-aos-delay="200">
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
                  <div class="loading">Sending Message</div>
                  <div class="error-message"></div>
                  <div class="sent-message">Your message has been sent successfully. We'll get back to you soon!</div>

                  <button type="submit">Send Message</button>
                </div>

              </div>
            </form>
          </div><!-- End Contact Form -->

        </div>

      </div>

    </section><!-- /Contact Section -->

  </main>

  <footer id="footer" class="footer">

    <div class="container footer-top">
      <div class="row gy-4">
        <div class="col-lg-4 col-md-6 footer-about">
          <a href="index.html" class="logo d-flex align-items-center">
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
          <form action="forms/newsletter.php" method="post" class="php-email-form">
            <div class="newsletter-form"><input type="email" name="email" placeholder="Enter your email"><input type="submit" value="Subscribe"></div>
            <div class="loading">Processing</div>
            <div class="error-message"></div>
            <div class="sent-message">Thank you for subscribing! Check your email for exclusive offers.</div>
          </form>
        </div>

      </div>
    </div>

    <div class="container copyright text-center mt-4">
      <p>© <span>Copyright</span> <strong class="px-1 sitename">Foodymat</strong> <span>All Rights Reserved</span></p>
      <div class="credits">
        
        Designed by <a href="https://pawal.com.np">Pawal</a> Distributed by <a href="https://kyanitesoftware.com/" target="_blank">Kyanite Software</a>
      </div>
    </div>

  </footer>

  <!-- Scroll Top -->
  <a href="#" id="scroll-top" class="scroll-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

  <!-- Preloader -->
  <div id="preloader"></div>

  <!-- Vendor JS Files -->
  <script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="assets/vendor/php-email-form/validate.js"></script>
  <script src="assets/vendor/aos/aos.js"></script>
  <script src="assets/vendor/glightbox/js/glightbox.min.js"></script>
  <script src="assets/vendor/imagesloaded/imagesloaded.pkgd.min.js"></script>
  <script src="assets/vendor/isotope-layout/isotope.pkgd.min.js"></script>
  <script src="assets/vendor/swiper/swiper-bundle.min.js"></script>

  <!-- Main JS File -->
  <script src="assets/js/main.js"></script>

</body>

</html>