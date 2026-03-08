<?php
session_start();
if (isset($_SESSION['admin_login'])) {


  include('init.php');

  $q1 = $connect->prepare("SELECT * From users");
  $q1->execute();
  $userCount = $q1->rowCount();

  $q2 = $connect->prepare("SELECT * From categories");
  $q2->execute();
  $cateCount = $q2->rowCount();

  $q3 = $connect->prepare("SELECT * From posts");
  $q3->execute();
  $postCount = $q3->rowCount();

  $q3 = $connect->prepare("SELECT * From comments");
  $q3->execute();
  $commentCount = $q3->rowCount();
?>

  <div class="container mt-5 pt-5">

    <div class="row">

      <div class="col-md-3 text-center">
        <div class="box">
          <i class="fa-solid fa-user fa-2xl"></i>
          <h3 class="mt-3">Users</h3>
          <h5><?php echo $userCount ?></h5>
          <a href="users.php" class="btn btn-success">Show</a>
        </div>
      </div>

      <div class="col-md-3 text-center">
        <div class="box">
          <i class="fa-solid fa-layer-group fa-2xl"></i>
          <h3 class="mt-3">Categories</h3>
          <h5><?php echo $cateCount ?></h5>
          <a href="categories.php" class="btn btn-primary">Show</a>
        </div>
      </div>

      <div class="col-md-3 text-center">
        <div class="box">
          <i class="fa-solid fa-address-card fa-2xl"></i>
          <h3 class="mt-3">Posts</h3>
          <h5><?php echo $postCount ?></h5>
          <a href="posts.php" class="btn btn-warning">Show</a>
        </div>
      </div>

      <div class="col-md-3 text-center">
        <div class="box">
          <i class="fa-solid fa-comment fa-2xl"></i>
          <h3 class="mt-3">Comments</h3>
          <h5><?php echo $commentCount ?></h5>
          <a href="comments.php" class="btn btn-danger">Show</a>
        </div>
      </div>

    </div>

  </div>

<?php
  include('includes/temp/footer.php');
}else {
  $_SESSION['message_login'] = "Login First";
  header("Location: ../login.php");
}
?>