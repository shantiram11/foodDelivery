{{-- 
<!-- Order Form Section -->
<section id="order-online" class="book-a-table section">

  <!-- Section Title -->
  <div class="container section-title" data-aos="fade-up">
    <h2>ORDER ONLINE</h2>
    <p>Place Your Order</p>
  </div><!-- End Section Title -->

  <div class="container" data-aos="fade-up" data-aos-delay="100">

    <form action="{{ url('forms/book-a-table') }}" method="post" role="form" class="php-email-form">
      @csrf
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
          <input type="text" class="form-control" name="address" id="address" placeholder="Delivery Address" required="">
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

</section><!-- /Order Form Section  -->
--}}