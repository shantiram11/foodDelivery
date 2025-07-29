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
          <li data-filter="*" class="filter-active">All Restaurants</li>
          @foreach ($restaurants as $restaurant)
          <li data-filter=".filter-{{ $restaurant->id }}">{{ $restaurant->name }}</li>
          @endforeach
        </ul>
      </div>
    </div><!-- Restaurant Filters -->

    <div class="row isotope-container" data-aos="fade-up" data-aos-delay="200">

      <!-- Menu Items from All Restaurants -->
      @foreach ($menus as $menu)
      <div class="col-lg-6 menu-item isotope-item filter-{{ $menu->restaurant->id }}">
        <img src="{{ asset('uploads/menus/' . $menu->image) }}" class="menu-img" alt="{{ $menu->name }}">
        <div class="menu-content">
          <a href="#">{{ $menu->name }}</a><span>${{ number_format($menu->price, 2) }}</span>
        </div>
        <div class="menu-ingredients">
          {{ $menu->description }}
        </div>
        <div class="menu-restaurant restaurant-info">
          <small class="text-white px-3 py-1">From: {{ $menu->restaurant->name }}</small>
        </div>

        <div class="menu-action">
          <button class="add-to-cart-btn" data-menu-id="{{ $menu->id }}" data-restaurant-id="{{ $menu->restaurant->id }}">Add to Cart</button>
        </div>
      </div>
      @endforeach
    </div><!-- Menu Container -->
    

  </div>

</section><!-- /Menu Section --> 

<style>
.section-title {
  text-align: left !important;
  padding-left: 1rem;
}
.section-title h2 {
  font-size: 1rem !important;
  letter-spacing: 2px !important;
  text-align: left !important;
}
.section-title p {
  font-size: 2.5rem !important;
  color: var(--accent-color) !important;
  text-align: left !important;
}
.menu-action {
  padding: 0.5rem 1rem;
  text-align: right;
}
.menu-restaurant {
  padding: 0.25rem 1rem;
  font-style: italic;
}
.menu-restaurant.hide-restaurant-info {
  display: none;
}
.add-to-cart-btn {
  background-color: var(--accent-color);
  color: var(--contrast-color);
  border: none;
  padding: 0.5rem 1.5rem;
  border-radius: 25px;
  font-size: 0.9rem;
  cursor: pointer;
  transition: all 0.3s ease;
}
.add-to-cart-btn:hover {
  background-color: color-mix(in srgb, var(--accent-color), transparent 20%);
  transform: translateY(-2px);
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
  // Handle filter clicks to show/hide restaurant info
  const filterButtons = document.querySelectorAll('.menu-filters li');
  const restaurantInfos = document.querySelectorAll('.restaurant-info');
  
  filterButtons.forEach(button => {
    button.addEventListener('click', function() {
      const filter = this.getAttribute('data-filter');
      
      if (filter === '*') {
        // Show restaurant info for "All Restaurants" filter
        restaurantInfos.forEach(info => {
          info.classList.remove('hide-restaurant-info');
        });
      } else {
        // Hide restaurant info for specific restaurant filters
        restaurantInfos.forEach(info => {
          info.classList.add('hide-restaurant-info');
        });
      }
    });
  });
  
  // Add to cart functionality
  const addToCartButtons = document.querySelectorAll('.add-to-cart-btn');
  addToCartButtons.forEach(button => {
    button.addEventListener('click', function() {
      const menuItem = this.closest('.menu-item');
      const itemName = menuItem.querySelector('.menu-content a').textContent;
      const itemPrice = parseFloat(menuItem.querySelector('.menu-content span').textContent.replace('$', ''));
      const itemImage = menuItem.querySelector('img').src;
      const itemId = this.getAttribute('data-menu-id');
      const restaurantId = this.getAttribute('data-restaurant-id');
      
      // Animation feedback
      this.textContent = 'Added!';
      this.style.backgroundColor = '#28a745';
      setTimeout(() => {
        this.textContent = 'Add to Cart';
        this.style.backgroundColor = '';
      }, 1000);
      
      // Dispatch cart event
      window.dispatchEvent(new CustomEvent('addToCart', {
        detail: {
          id: itemId,
          name: itemName,
          price: itemPrice,
          image: itemImage,
          restaurantId: restaurantId
        }
      }));
    });
  });
});
</script> 