<nav class="navbar navbar-expand-lg navbar-dark admin-navbar">

  <div class="container">

    <a class="navbar-brand fw-bold" href="dashboard.php">
      <i class="fa-solid fa-gauge-high"></i> Admin Panel
    </a>

    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav">
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarNav">

      <ul class="navbar-nav ms-auto">

        <li class="nav-item">
          <a class="nav-link active-link" href="dashboard.php">
            <i class="fa-solid fa-house"></i> Dashboard
          </a>
        </li>

        <li class="nav-item">
          <a class="nav-link" href="users.php">
            <i class="fa-solid fa-users"></i> Users
          </a>
        </li>

        <li class="nav-item">
          <a class="nav-link" href="categories.php">
            <i class="fa-solid fa-layer-group"></i> Categories
          </a>
        </li>

        <li class="nav-item">
          <a class="nav-link" href="posts.php">
            <i class="fa-solid fa-file-lines"></i> Posts
          </a>
        </li>

        <li class="nav-item">
          <a class="nav-link" href="comments.php">
            <i class="fa-solid fa-comments"></i> Comments
          </a>
        </li>

        <li class="nav-item">
          <a class="nav-link logout" href="logout.php">
            <i class="fa-solid fa-right-from-bracket"></i> Logout
          </a>
        </li>

      </ul>

    </div>

  </div>

</nav>

<style>
  .admin-navbar {
    background: linear-gradient(90deg, #11998e, #38ef7d);
    /* ألوان جديدة جذابة */
    padding: 16px 0;
    box-shadow: 0 6px 20px rgba(0, 0, 0, .25);
    border-bottom: 2px solid #10c897;
    transition: 0.3s;
  }

  .navbar-brand {
    font-size: 24px;
    letter-spacing: 1px;
    color: white;
  }

  .nav-link {
    color: white !important;
    margin-left: 15px;
    font-weight: 600;
    position: relative;
    transition: .3s;
  }

  .nav-link:hover {
    color: #fff200 !important;
    transform: translateY(-3px);
  }

  .nav-link::after {
    content: '';
    position: absolute;
    width: 0%;
    height: 3px;
    left: 0;
    bottom: -5px;
    background: #fff200;
    transition: 0.3s;
  }

  .nav-link:hover::after,
  .nav-link.active-link::after {
    width: 100%;
  }

  .logout {
    color: #ff6b6b !important;
  }

  .logout:hover {
    color: #ff3b3b !important;
  }
</style>