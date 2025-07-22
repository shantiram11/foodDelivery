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
          <li data-filter="*" class="filter-active">All Locations</li>
          <li data-filter=".filter-downtown">Downtown Branch</li>
          <li data-filter=".filter-uptown">Uptown Branch</li>
          <li data-filter=".filter-riverside">Riverside Branch</li>
          <li data-filter=".filter-mall">Mall Branch</li>
        </ul>
      </div>
    </div><!-- Location Filters -->

    <div class="row isotope-container" data-aos="fade-up" data-aos-delay="200">

      <!-- Downtown Menu Items -->
      <div class="col-lg-6 menu-item isotope-item filter-downtown">
        <img src="{{ asset('frontend/img/menu/lobster-bisque.jpg') }}" class="menu-img" alt="">
        <div class="menu-content">
          <a href="#">Downtown Special Bisque</a><span>$8.95</span>
        </div>
        <div class="menu-ingredients">
          Rich tomato base, fresh cream, herbs, garlic croutons
        </div>
        <div class="menu-action">
          <button class="add-to-cart-btn">Add to Cart</button>
        </div>
      </div>

      <!-- Uptown Menu Items -->
      <div class="col-lg-6 menu-item isotope-item filter-uptown">
        <img src="{{ asset('frontend/img/menu/bread-barrel.jpg') }}" class="menu-img" alt="">
        <div class="menu-content">
          <a href="#">Uptown Artisan Bread</a><span>$12.95</span>
        </div>
        <div class="menu-ingredients">
          Freshly baked sourdough, focaccia, herb butter, olive tapenade
        </div>
        <div class="menu-action">
          <button class="add-to-cart-btn">Add to Cart</button>
        </div>
      </div>

      <!-- Riverside Menu Items -->
      <div class="col-lg-6 menu-item isotope-item filter-riverside">
        <img src="{{ asset('frontend/img/menu/tuscan-grilled.jpg') }}" class="menu-img" alt="">
        <div class="menu-content">
          <a href="#">Riverside Grilled Salmon</a><span>$24.95</span>
        </div>
        <div class="menu-ingredients">
          Fresh salmon, herbs, grilled vegetables, lemon butter sauce
        </div>
        <div class="menu-action">
          <button class="add-to-cart-btn">Add to Cart</button>
        </div>
      </div>

      <!-- Mall Branch Menu Items -->
      <div class="col-lg-6 menu-item isotope-item filter-mall">
        <img src="{{ asset('frontend/img/menu/lobster-roll.jpg') }}" class="menu-img" alt="">
        <div class="menu-content">
          <a href="#">Mall Special Burger</a><span>$18.95</span>
        </div>
        <div class="menu-ingredients">
          Angus beef, aged cheddar, bacon, arugula, truffle fries
        </div>
        <div class="menu-action">
          <button class="add-to-cart-btn">Add to Cart</button>
        </div>
      </div>

      <!-- Additional Downtown Items -->
      <div class="col-lg-6 menu-item isotope-item filter-downtown">
        <img src="{{ asset('frontend/img/menu/caesar.jpg') }}" class="menu-img" alt="">
        <div class="menu-content">
          <a href="#">Downtown Caesar Salad</a><span>$14.95</span>
        </div>
        <div class="menu-ingredients">
          Crisp romaine, parmesan, house-made croutons, caesar dressing
        </div>
        <div class="menu-action">
          <button class="add-to-cart-btn">Add to Cart</button>
        </div>
      </div>

      <!-- Additional Uptown Items -->
      <div class="col-lg-6 menu-item isotope-item filter-uptown">
        <img src="{{ asset('frontend/img/menu/cake.jpg') }}" class="menu-img" alt="">
        <div class="menu-content">
          <a href="#">Uptown Special Cake</a><span>$16.95</span>
        </div>
        <div class="menu-ingredients">
          Fresh berries, cream cheese frosting, vanilla sponge
        </div>
        <div class="menu-action">
          <button class="add-to-cart-btn">Add to Cart</button>
        </div>
      </div>

      <!-- Additional Riverside Items -->
      <div class="col-lg-6 menu-item isotope-item filter-riverside">
        <img src="{{ asset('frontend/img/menu/spinach-salad.jpg') }}" class="menu-img" alt="">
        <div class="menu-content">
          <a href="#">Riverside Fresh Salad</a><span>$15.95</span>
        </div>
        <div class="menu-ingredients">
          Baby spinach, candied walnuts, dried cranberries, goat cheese
        </div>
      </div>

      <!-- Additional Mall Items -->
      <div class="col-lg-6 menu-item isotope-item filter-mall">
        <img src="{{ asset('frontend/img/menu/mozzarella.jpg') }}" class="menu-img" alt="">
        <div class="menu-content">
          <a href="#">Mall Cheese Platter</a><span>$13.95</span>
        </div>
        <div class="menu-ingredients">
          Selection of artisanal cheeses, honey, nuts, fresh fruits
        </div>
      </div>

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
  // Add to cart functionality
  const addToCartButtons = document.querySelectorAll('.add-to-cart-btn');
  addToCartButtons.forEach(button => {
    button.addEventListener('click', function() {
      const menuItem = this.closest('.menu-item');
      const itemName = menuItem.querySelector('.menu-content a').textContent;
      const itemPrice = menuItem.querySelector('.menu-content span').textContent;
      
      // Animation feedback
      this.textContent = 'Added!';
      this.style.backgroundColor = '#28a745';
      setTimeout(() => {
        this.textContent = 'Add to Cart';
        this.style.backgroundColor = '';
      }, 1000);
      
      // Here you can add your cart logic
      console.log('Added to cart:', itemName, itemPrice);
    });
  });
});
</script> 