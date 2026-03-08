<?php
session_start();
include("includes/temp/init_user.php");
?>

<!-- عرض رسالة النجاح بعد التسجيل -->
<?php
if (isset($_SESSION['success_message'])) {
    echo '<div class="container mt-3"><div class="alert alert-success text-center">' . $_SESSION['success_message'] . '</div></div>';
    unset($_SESSION['success_message']); // إزالة الرسالة بعد العرض
}
?>

<!-- Hero Start -->
<div class="container-fluid bg-primary hero-header mb-5">
  <div class="container">
    <div class="row g-5 align-items-center">
      <div class="col-lg-6 text-center text-lg-start">
        <h3 class="fw-light text-white animated slideInRight">Natural & Organic</h3>
        <h1 class="display-4 text-white animated slideInRight">Hair <span class="fw-light text-dark">Shampoo</span> For Healthy Hair</h1>
        <p class="text-white mb-4 animated slideInRight">Lorem ipsum dolor sit amet, consectetur adipiscing
          elit. Etiam feugiat rutrum lectus, sed auctor ex malesuada id. Orci varius natoque penatibus et
          magnis dis parturient montes.</p>
        <a href="" class="btn btn-dark py-2 px-4 me-3 animated slideInRight">Shop Now</a>
        <a href="" class="btn btn-outline-dark py-2 px-4 animated slideInRight">Contact Us</a>
      </div>
      <div class="col-lg-6">
        <img class="img-fluid animated pulse infinite" src="includes/assets/img/shampoo.png" alt="">
      </div>
    </div>
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
        <p class="mb-4">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Duis aliquet, erat non malesuada consequat, nibh erat tempus risus, vitae porttitor purus nisl vitae purus. Praesent tristique odio ut rutrum pellentesque. Fusce eget molestie est, at rutrum est.</p>
        <p class="mb-4">Aliqu diam amet diam et eos labore. Clita erat ipsum et lorem et sit, sed stet no
          labore lorem sit. Sanctus clita duo justo et tempor.</p>
        <a class="btn btn-primary py-2 px-4" href="">Shop Now</a>
      </div>
    </div>
  </div>
</div>
<!-- About End -->

<!-- Deal Start -->
<div class="container-fluid deal bg-primary my-5 py-5">
  <div class="container py-5">
    <div class="row g-5 align-items-center">
      <div class="col-lg-6 wow fadeIn" data-wow-delay="0.1s">
        <img class="img-fluid animated pulse infinite" src="includes/assets/img/shampoo-2.png">
      </div>
      <div class="col-lg-6 wow fadeIn" data-wow-delay="0.5s">
        <div class="bg-white text-center p-4">
          <div class="border p-4">
            <p class="mb-2">Natural & Organic Shampoo</p>
            <h2 class="fw-bold text-uppercase mb-4">Deals of the Day</h2>
            <h1 class="display-4 text-primary mb-4">$99.99</h1>
            <h5>Fresh Organic Shampoo</h5>
            <p class="mb-4">Lorem ipsum dolor sit amet, consectetur adipiscing
              elit. Etiam feugiat rutrum lectus sed auctor.</p>
            <div class="row g-0 cdt mb-4">
              <div class="col-3">
                <h1 class="display-6" id="cdt-days"></h1>
              </div>
              <div class="col-3">
                <h1 class="display-6" id="cdt-hours"></h1>
              </div>
              <div class="col-3">
                <h1 class="display-6" id="cdt-minutes"></h1>
              </div>
              <div class="col-3">
                <h1 class="display-6" id="cdt-seconds"></h1>
              </div>
            </div>
            <a class="btn btn-primary py-2 px-4" href="">Shop Now</a>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<!-- Deal End -->

<!-- Feature Start -->
<div class="container-fluid py-5">
  <div class="container">
    <div class="mx-auto text-center wow fadeIn" data-wow-delay="0.1s" style="max-width: 600px;">
      <h1 class="text-primary mb-3"><span class="fw-light text-dark">Best Benefits Of Our</span> Natural Hair
        Shampoo</h1>
      <p class="mb-5">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Duis aliquet, erat non malesuada consequat, nibh erat tempus risus.</p>
    </div>
    <div class="row g-4 align-items-center">
      <div class="col-lg-4 wow fadeIn" data-wow-delay="0.3s">
        <div class="row g-5">
          <div class="col-12 d-flex">
            <div class="btn-square rounded-circle border flex-shrink-0"
              style="width: 80px; height: 80px;">
              <i class="fa fa-check fa-2x text-primary"></i>
            </div>
            <div class="ps-3">
              <h5>Natural & Organic</h5>
              <hr class="w-25 bg-primary my-2">
              <span>Lorem ipsum dolor sit amet adipiscing elit aliquet.</span>
            </div>
          </div>
          <div class="col-12 d-flex">
            <div class="btn-square rounded-circle border flex-shrink-0"
              style="width: 80px; height: 80px;">
              <i class="fa fa-check fa-2x text-primary"></i>
            </div>
            <div class="ps-3">
              <h5>Anti Hair Fall</h5>
              <hr class="w-25 bg-primary my-2">
              <span>Lorem ipsum dolor sit amet adipiscing elit aliquet.</span>
            </div>
          </div>
          <div class="col-12 d-flex">
            <div class="btn-square rounded-circle border flex-shrink-0"
              style="width: 80px; height: 80px;">
              <i class="fa fa-check fa-2x text-primary"></i>
            </div>
            <div class="ps-3">
              <h5>Anti-dandruff</h5>
              <hr class="w-25 bg-primary my-2">
              <span>Lorem ipsum dolor sit amet adipiscing elit aliquet.</span>
            </div>
          </div>
        </div>
      </div>
      <div class="col-lg-4 wow fadeIn" data-wow-delay="0.1s">
        <img class="img-fluid animated pulse infinite" src="includes/assets/img/shampoo.png">
      </div>
      <div class="col-lg-4 wow fadeIn" data-wow-delay="0.5s">
        <div class="row g-5">
          <div class="col-12 d-flex">
            <div class="btn-square rounded-circle border flex-shrink-0"
              style="width: 80px; height: 80px;">
              <i class="fa fa-check fa-2x text-primary"></i>
            </div>
            <div class="ps-3">
              <h5>No Internal Side Effect</h5>
              <hr class="w-25 bg-primary my-2">
              <span>Lorem ipsum dolor sit amet adipiscing elit aliquet.</span>
            </div>
          </div>
          <div class="col-12 d-flex">
            <div class="btn-square rounded-circle border flex-shrink-0"
              style="width: 80px; height: 80px;">
              <i class="fa fa-check fa-2x text-primary"></i>
            </div>
            <div class="ps-3">
              <h5>No Skin Irritation</h5>
              <hr class="w-25 bg-primary my-2">
              <span>Lorem ipsum dolor sit amet adipiscing elit aliquet.</span>
            </div>
          </div>
          <div class="col-12 d-flex">
            <div class="btn-square rounded-circle border flex-shrink-0"
              style="width: 80px; height: 80px;">
              <i class="fa fa-check fa-2x text-primary"></i>
            </div>
            <div class="ps-3">
              <h5>No Artificial Smell</h5>
              <hr class="w-25 bg-primary my-2">
              <span>Lorem ipsum dolor sit amet adipiscing elit aliquet.</span>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<!-- Feature End -->

<!-- باقي الصفحة كما هو بدون أي تغيير -->

<?php
include("includes/temp/footer.php");
?>
