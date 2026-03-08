<!-- Navbar Start -->
<div class="container-fluid sticky-top">
  <div class="container">
    <nav class="navbar navbar-expand-lg navbar-light p-0">
      <a href="index.php" class="navbar-brand">
        <h2 class="text-white">Hairnic</h2>
      </a>

      <button type="button" class="navbar-toggler ms-auto me-0" data-bs-toggle="collapse"
        data-bs-target="#navbarCollapse">
        <span class="navbar-toggler-icon"></span>
      </button>

      <div class="collapse navbar-collapse" id="navbarCollapse">
        <div class="navbar-nav ms-auto">
          <a href="index.php" class="nav-item nav-link active">Home</a>
          <a href="about.php" class="nav-item nav-link">About</a>
          <a href="products.php" class="nav-item nav-link">Products</a>

          <?php if (isset($_SESSION['user_login'])) { ?>
            <div class="nav-item dropdown">
              <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown">Pages</a>
              <div class="dropdown-menu bg-light mt-2">
                <a href="feature.php" class="dropdown-item">Features</a>
                <a href="use.php" class="dropdown-item">How To Use</a>
                <a href="blog.php" class="dropdown-item">Blog Articles</a>
              </div>
            </div>

            <a href="contact.php" class="nav-item nav-link">Contact</a>
          <?php } ?>
        </div>

        <!-- Login / Register / Logout -->
        <div class="d-flex">
          <?php
          if (isset($_SESSION['user_login'])) {
            echo '
              <a title="logout" href="logout.php" class="btn btn-outline-danger">
                <i class="fa fa-sign-out-alt"></i>
              </a>
            ';
          } else {
            echo '
              <a title="login" href="login.php" class="btn btn-outline-light me-2">
                <i class="fa fa-sign-in-alt"></i>
              </a>
              <a title="register" href="register.php" class="btn btn-outline-light me-2">
                <i class="fa fa-user-plus"></i>
              </a>
            ';
          }
          ?>
        </div>

      </div>
    </nav>
  </div>
</div>
<!-- Navbar End -->