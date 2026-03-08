<?php
session_start();
include("includes/temp/init_user.php");
?>


<!-- Hero Start -->
<div class="container-fluid bg-primary hero-header mb-5">
  <div class="container text-center">
    <h1 class="display-4 text-white mb-3 animated slideInDown">About Us</h1>
    <nav aria-label="breadcrumb">
      <ol class="breadcrumb justify-content-center mb-0 animated slideInDown">
        <li class="breadcrumb-item"><a class="text-white" href="#">Home</a></li>
        <li class="breadcrumb-item"><a class="text-white" href="#">Pages</a></li>
        <li class="breadcrumb-item text-white active" aria-current="page">About</li>
      </ol>
    </nav>
  </div>
</div>
<!-- Hero End -->


<!-- Feature Start -->
<div class="container-fluid py-5">
  <div class="container">
    <div class="row g-4">
      <div class="col-lg-4 wow fadeIn" data-wow-delay="0.1s">
        <div class="feature-item position-relative bg-primary text-center p-3">
          <div class="border py-5 px-3">
            <i class="fa fa-leaf fa-3x text-dark mb-4"></i>
            <h5 class="text-white mb-0">100% Natural</h5>
          </div>
        </div>
      </div>
      <div class="col-lg-4 wow fadeIn" data-wow-delay="0.3s">
        <div class="feature-item position-relative bg-primary text-center p-3">
          <div class="border py-5 px-3">
            <i class="fa fa-tint-slash fa-3x text-dark mb-4"></i>
            <h5 class="text-white mb-0">Anti Hair Fall</h5>
          </div>
        </div>
      </div>
      <div class="col-lg-4 wow fadeIn" data-wow-delay="0.5s">
        <div class="feature-item position-relative bg-primary text-center p-3">
          <div class="border py-5 px-3">
            <i class="fa fa-times fa-3x text-dark mb-4"></i>
            <h5 class="text-white mb-0">Hypoallergenic</h5>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<!-- Feature End -->


<!-- About Start -->
<div class="container-fluid py-5">
  <div class="container">
    <div class="row g-5 align-items-center">
      <div class="col-lg-6 wow fadeIn" data-wow-delay="0.1s">
        <img class="img-fluid animated pulse infinite" src="includes/assets/img/shampoo-1.png">
      </div>
      <div class="col-lg-6 wow fadeIn" data-wow-delay="0.5s">
        <h1 class="text-primary mb-4">Healthy Hair <span class="fw-light text-dark">Is A Symbol Of Our
            Beauty</span></h1>
        <p class="mb-4">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Duis aliquet, erat non
          malesuada consequat, nibh erat tempus risus, vitae porttitor purus nisl vitae purus. Praesent
          tristique odio ut rutrum pellentesque. Fusce eget molestie est, at rutrum est.</p>
        <p class="mb-4">Aliqu diam amet diam et eos labore. Clita erat ipsum et lorem et sit, sed stet no
          labore lorem sit. Sanctus clita duo justo et tempor.</p>
        <a class="btn btn-primary py-2 px-4" href="">Shop Now</a>
      </div>
    </div>
  </div>
</div>
<!-- About End -->


<!-- Newsletter Start -->
<div class="container-fluid newsletter bg-primary py-5 my-5">
  <div class="container py-5">
    <div class="mx-auto text-center wow fadeIn" data-wow-delay="0.1s" style="max-width: 600px;">
      <h1 class="text-white mb-3"><span class="fw-light text-dark">Let's Subscribe</span> The Newsletter</h1>
      <p class="text-white mb-4">Subscribe now to get 30% discount on any of our products</p>
    </div>
    <div class="row justify-content-center">
      <div class="col-md-7 wow fadeIn" data-wow-delay="0.5s">
        <div class="position-relative w-100 mt-3 mb-2">
          <input class="form-control w-100 py-4 ps-4 pe-5" type="text" placeholder="Enter Your Email"
            style="height: 48px;">
          <button type="button" class="btn shadow-none position-absolute top-0 end-0 mt-1 me-2"><i
              class="fa fa-paper-plane text-white fs-4"></i></button>
        </div>
      </div>
    </div>
  </div>
</div>
<!-- Newsletter End -->


<!-- Footer Start -->
<div class="container-fluid bg-white footer">
  <div class="container py-5">
    <div class="row g-5">
      <div class="col-md-6 col-lg-3 wow fadeIn" data-wow-delay="0.1s">
        <a href="index.html" class="d-inline-block mb-3">
          <h1 class="text-primary">Hairnic</h1>
        </a>
        <p class="mb-0">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Duis aliquet, erat non
          malesuada consequat, nibh erat tempus risus, vitae porttitor purus nisl vitae purus.</p>
      </div>
      <div class="col-md-6 col-lg-3 wow fadeIn" data-wow-delay="0.3s">
        <h5 class="mb-4">Get In Touch</h5>
        <p><i class="fa fa-map-marker-alt me-3"></i>123 Street, New York, USA</p>
        <p><i class="fa fa-phone-alt me-3"></i>+012 345 67890</p>
        <p><i class="fa fa-envelope me-3"></i>info@example.com</p>
        <div class="d-flex pt-2">
          <a class="btn btn-square btn-outline-primary me-1" href=""><i class="fab fa-twitter"></i></a>
          <a class="btn btn-square btn-outline-primary me-1" href=""><i class="fab fa-facebook-f"></i></a>
          <a class="btn btn-square btn-outline-primary me-1" href=""><i class="fab fa-instagram"></i></a>
          <a class="btn btn-square btn-outline-primary me-1" href=""><i
              class="fab fa-linkedin-in"></i></a>
        </div>
      </div>
      <div class="col-md-6 col-lg-3 wow fadeIn" data-wow-delay="0.5s">
        <h5 class="mb-4">Our Products</h5>
        <a class="btn btn-link" href="">Hair Shining Shampoo</a>
        <a class="btn btn-link" href="">Anti-dandruff Shampoo</a>
        <a class="btn btn-link" href="">Anti Hair Fall Shampoo</a>
        <a class="btn btn-link" href="">Hair Growing Shampoo</a>
        <a class="btn btn-link" href="">Anti smell Shampoo</a>
      </div>
      <div class="col-md-6 col-lg-3 wow fadeIn" data-wow-delay="0.7s">
        <h5 class="mb-4">Popular Link</h5>
        <a class="btn btn-link" href="">About Us</a>
        <a class="btn btn-link" href="">Contact Us</a>
        <a class="btn btn-link" href="">Privacy Policy</a>
        <a class="btn btn-link" href="">Terms & Condition</a>
        <a class="btn btn-link" href="">Career</a>
      </div>
    </div>
  </div>
  <div class="container wow fadeIn" data-wow-delay="0.1s">
    <div class="copyright">
      <div class="row">
        <div class="col-md-6 text-center text-md-start mb-3 mb-md-0">
          &copy; <a class="border-bottom" href="#">Your Site Name</a>, All Right Reserved.

          <!--/*** This template is free as long as you keep the footer author’s credit link/attribution link/backlink. If you'd like to use the template without the footer author’s credit link/attribution link/backlink, you can purchase the Credit Removal License from "https://htmlcodex.com/credit-removal". Thank you for your support. ***/-->
          Designed By <a class="border-bottom" href="https://htmlcodex.com">HTML Codex</a>
        </div>
        <div class="col-md-6 text-center text-md-end">
          <div class="footer-menu">
            <a href="">Home</a>
            <a href="">Cookies</a>
            <a href="">Help</a>
            <a href="">FAQs</a>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<!-- Footer End -->


<!-- Back to Top -->
<a href="#" class="btn btn-lg btn-primary btn-lg-square back-to-top"><i class="bi bi-arrow-up"></i></a>





<?php
include("includes/temp/footer.php");
?>