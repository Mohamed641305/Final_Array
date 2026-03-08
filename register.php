<?php
session_start();
include("includes/db/db.php");
include("includes/temp/header.php");


$message = "";
$name = "";
$email = "";
$pass = "";
$confirm_pass = "";

if ($_SERVER['REQUEST_METHOD'] == "POST") {

  $name = $_POST['name'];
  $email = $_POST['email'];
  $pass = $_POST['pass'];
  $confirm_pass = $_POST['confirm_pass'];

  /* ========================= VALIDATION ========================= */
  if (empty($name) && empty($email) && empty($pass) && empty($confirm_pass)) {
    $message = "Please fill in all fields.";
  } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $message = "Enter a valid email address.";
  } elseif (strlen($pass) < 5) {
    $message = "Password must be at least 5 characters long.";
  } elseif ($pass !== $confirm_pass) {
    $message = "Passwords do not match.";
  }

  /* ========================= REGISTER ========================= */
  if (empty($message)) {
    // تحقق هل الإيميل موجود بالفعل
    $stmt = $connect->prepare("SELECT * FROM users WHERE email=?");
    $stmt->execute(array($email));

    if ($stmt->rowCount() > 0) {
      $message = "Email already exists.";
    } else {
      // إدخال المستخدم الجديد (كلمة المرور كـ نص عادي)
      $stmt = $connect->prepare("INSERT INTO users (user_name, email, `password`, `role`, `status`, created_at) VALUES (?, ?, ?, 'user', '1', now())");
      $stmt->execute(array($name, $email, $pass));
      $_SESSION['user_login'] = $email;
      $_SESSION['message_login'] = "Registration successful. Please login.";
      header("Location: login.php");
    }
  }
}
?>


<div class="container mt-5 pt-5">
  <div class="row">
    <div class="col-md-6 m-auto">
      <div class="register-card">

        <h4 class="text-center mt-4 mb-5">Register New Account</h4>

        <!-- رسائل الخطأ -->
        <?php if (!empty($message)) {
        ?>
          <div class="alert alert-danger"><?php echo $message ?></div>
        <?php
        }
        ?>

        <form method="post">
          <input type="text" name="name" value="<?php echo $name ?>" placeholder="Full Name" class="form-control mb-4">
          <input type="email" name="email" value="<?php echo $email ?>" placeholder="Email" class="form-control mb-4">
          <input type="password" name="pass" placeholder="Password" class="form-control mb-4">
          <input type="password" name="confirm_pass" placeholder="Confirm Password" class="form-control mb-5">
          <input type="submit" value="Register" class="btn btn-primary btn-block">
        </form>

        <p class="text-center mt-4 mb-3">
          Already have an account? <a href="login.php">Login here</a>
        </p>

      </div>
    </div>
  </div>
</div>

<?php
include("includes/temp/footer.php");
?>