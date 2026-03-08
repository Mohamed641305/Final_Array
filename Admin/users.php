<?php
session_start();
if (isset($_SESSION['admin_login'])) {
  include('init.php');
  $page = 'All';

  if (isset($_GET['page'])) {
    $page = $_GET['page'];
  }

  if ($page === "All") {

    $statement = $connect->prepare("SELECT * From users");
    $statement->execute();
    $result = $statement->fetchAll();
    $userCount = $statement->rowCount();
?>

    <div class="container mt-5 pt-5">
      <div class="row">
        <div class="col-md-10 m-auto">
          <?php
          if (isset($_SESSION['message'])) {
          ?>
            <h4 class="alert alert-success text-center alert-dismissible fade show" role="alert">
              <?php echo $_SESSION['message'] ?>
              <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </h4>
          <?php
            unset($_SESSION['message']);
          }
          ?>
          <h3 class="text-center">
            Details Of Users <span class="badge badge-primary px-3 py-2 "><?php echo $userCount ?></span>
            <a href="?page=create" class="btn btn-success">
              <i class="fa-solid fa-user-plus"></i>
            </a>
          </h3>
          <table class="table table-dark text-center mt-4 ">
            <thead>
              <tr>
                <td>ID</td>
                <td>Name</td>
                <td>Email</td>
                <td>Operation</td>
              </tr>
            </thead>
            <tbody>
              <?php
              foreach ($result as $item) {
              ?>
                <tr>
                  <td><?php echo $item['user_id'] ?></td>
                  <td><?php echo $item['user_name'] ?></td>
                  <td><?php echo $item['email'] ?></td>
                  <td>
                    <a href="?page=show&user_id=<?php echo $item['user_id'] ?>" class="btn btn-success">
                      <i class="fa-solid fa-eye"></i>
                    </a>
                    <a href="?page=edit&user_id=<?php echo $item['user_id'] ?>" class="btn btn-primary">
                      <i class="fa-solid fa-pen-to-square"></i>
                    </a>
                    <a href="?page=delete&user_id=<?php echo $item['user_id'] ?>" class="btn btn-danger">
                      <i class="fa-solid fa-trash"></i>
                    </a>

                  </td>
                </tr>
              <?php
              }
              ?>
            </tbody>
          </table>
        </div>
      </div>
    </div>

  <?php
  }

  /* ========================= SHOW ========================= */ elseif ($page == "show") {

    if (isset($_GET['user_id'])) {
      $user_id = $_GET['user_id'];
    }

    $statement = $connect->prepare("SELECT * From users WHERE user_id=?");
    $statement->execute(array($user_id));
    $result = $statement->fetch();

  ?>
    <div class="container mt-5 pt-5">
      <div class="row">
        <div class="col-md-10 m-auto">
          <h4 class="text-center">User Details <span class="badge badge-primary">1</span></h4>
        </div>
        <table class="table table-dark text-center mt-4">
          <thead>
            <tr>
              <td>ID</td>
              <td>Name</td>
              <td>Email</td>
              <td>Password</td>
              <td>Role</td>
              <td>Status</td>
              <td>Created_at</td>
              <td>Operation</td>
            </tr>
          </thead>
          <tbody>
            <tr>
              <td><?php echo $result['user_id'] ?></td>
              <td><?php echo $result['user_name'] ?></td>
              <td><?php echo $result['email'] ?></td>
              <td><?php echo $result["password"] ?></td>
              <td><?php echo $result['role'] ?></td>
              <td><?php echo $result['status'] ?></td>
              <td><?php echo $result['created_at'] ?></td>
              <td>
                <a href="users.php" class="btn btn-success">
                  <i class="fa-solid fa-house"></i>
                </a>
              </td>
            </tr>
          </tbody>

        </table>
      </div>
    </div>

  <?php
  }

  /* ========================= DELETE ========================= */ elseif ($page == "delete") {

    if (isset($_GET['user_id'])) {
      $user_id = $_GET['user_id'];
    }

    $statement = $connect->prepare("DELETE From users WHERE user_id=?");
    $statement->execute(array($user_id));
    $_SESSION['message'] = "User Deleted Successfully";

    header("Location: users.php");
  }

  /* ========================= CREATE ========================= */ elseif ($page == "create") {

    $user_id = $user_name = $email = "";
    $message = "";

    if ($_SERVER['REQUEST_METHOD'] == "POST") {

      $user_id   = $_POST['user_id'];
      $user_name = $_POST['user_name'];
      $email     = $_POST['email'];
      $password  = $_POST['password'];
      $role      = $_POST['role'];
      $status    = $_POST['status'];

      /* ========================= VALIDATION ========================= */

      $fields = [$user_id, $user_name, $email, $password];
      $empty = 0;
      foreach ($fields as $f) {
        if ($f == "") $empty++;
      }

      if ($empty >= 2) {
        $message = "Please fill in all fields.";
      } else if ($user_id == "") {
        $message = "Please enter ID.";
      } else if ($user_name == "") {
        $message = "Please enter Name.";
      } else if ($email == "") {
        $message = "Please enter Email.";
      } else if ($password == "") {
        $message = "Please enter Password.";
      } else if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $message = "Enter a valid email address.";
      } else if (strlen($password) < 5) {
        $message = "Password must be at least 5 characters long.";
      } else {

        // فحص تكرار الـ ID
        $check = $connect->prepare("SELECT user_id FROM users WHERE user_id = ?");
        $check->execute(array($user_id));

        if ($check->rowCount() > 0) {
          $message = "This ID already exists.";
        } else {

          // حفظ البيانات مؤقتاً
          $_SESSION['user_id']   = $user_id;
          $_SESSION['user_name'] = $user_name;
          $_SESSION['email']     = $email;
          $_SESSION['password']  = $password;
          $_SESSION['role']      = $role;
          $_SESSION['status']    = $status;

          header("Location: users.php?page=savenew");
        }
      }
    }
  ?>

    <div class="container mt-5">
      <div class="row">
        <div class="col-md-10 m-auto">

          <!-- رسالة الخطأ بنفس عرض الفورم -->
          <?php
          if (!empty($message)) {
          ?>
            <h4 class="alert alert-danger alert-dismissible fade show text-center" role="alert">
              <?php echo $message ?>
              <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </h4>
          <?php
          }
          ?>

          <form method="post" action="?page=create">

            <label>ID</label>
            <input type="text" class="form-control mb-3" name="user_id" value="<?php echo $user_id ?>">

            <label>User Name</label>
            <input type="text" class="form-control mb-3" name="user_name" value="<?php echo $user_name ?>">

            <label>Email</label>
            <input type="email" class="form-control mb-3" name="email" value="<?php echo $email ?>">

            <label>Password</label>
            <input type="password" class="form-control mb-3" name="password">

            <label>Role</label>
            <select name="role" class="form-control mb-3">
              <option value="user">User</option>
              <option value="admin">Admin</option>
            </select>

            <label>Status</label>
            <select name="status" class="form-control mb-3">
              <option value="1">Active</option>
              <option value="0">Block</option>
            </select>

            <button type="submit" class="btn btn-primary btn-block mt-3">Create User</button>

          </form>

        </div>
      </div>
    </div>

  <?php
  }

  /* ========================= SAVE ========================= */ elseif ($page == "savenew") {

    $user_id   = $_SESSION['user_id'];
    $user_name = $_SESSION['user_name'];
    $email     = $_SESSION['email'];
    $password  = $_SESSION['password'];
    $role      = $_SESSION['role'];
    $status    = $_SESSION['status'];

    $statement = $connect->prepare("INSERT INTO users
  (user_id, user_name, email, `password`, `role`, `status`, created_at) VALUES (?, ?, ?, ?, ?, ?, NOW())");

    $statement->execute(array($user_id, $user_name, $email, $password, $role, $status));

    $_SESSION['message'] = "New User Created Successfully";
    header("Location: users.php");
  }

  /* ========================= Edit ========================= */ elseif ($page == "edit") {
    if (isset($_GET['user_id'])) {
      $user_id = ($_GET['user_id']);
    }

    $statement = $connect->prepare("SELECT * FROM USERS WHERE user_id =?");
    $statement->execute(array($user_id));
    $result = $statement->fetch();

    $user_id = $user_name = $email = "";
    $message = "";

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
      $old_id = $_POST['old_id'];
      $id = $_POST['user_id'];
      $user = $_POST['user_name'];
      $email = $_POST['email'];
      $pass = $_POST['pass'];
      $role = $_POST['role'];
      $status = $_POST['status'];

      /* ========================= VALIDATION ========================= */

      $fields = [$id, $user, $email, $pass];
      $empty = 0;
      foreach ($fields as $f) {
        if ($f == "") $empty++;
      }

      if ($empty >= 2) {
        $message = "Please fill in all fields.";
      } else if ($id == "") {
        $message = "Please enter ID.";
      } else if ($user == "") {
        $message = "Please enter Name.";
      } else if ($email == "") {
        $message = "Please enter Email.";
      } else if ($pass == "") {
        $message = "Please enter Password.";
      } else if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $message = "Enter a valid email address.";
      } else if (strlen($pass) < 5) {
        $message = "Password must be at least 5 characters long.";
      } else {

        // فحص تكرار الـ ID
        $check = $connect->prepare("SELECT user_id FROM users WHERE user_id = ? and user_id != ?");
        $check->execute(array($id, $old_id));

        if ($check->rowCount() > 0) {
          $message = "This ID already exists.";
        } else {

          // حفظ البيانات مؤقتاً
          $_SESSION['old_id']   = $old_id;
          $_SESSION['user_id']   = $id;
          $_SESSION['user_name'] = $user;
          $_SESSION['email']     = $email;
          $_SESSION['password']  = $pass;
          $_SESSION['role']      = $role;
          $_SESSION['status']    = $status;

          header("Location: users.php?page=saveupdate");
        }
      }
    }
  ?>
    <div class="container mt-5">
      <div class="row">
        <div class="col-md-10 m-auto">
          <!-- رسالة الخطأ بنفس عرض الفورم -->
          <?php
          if (!empty($message)) {
          ?>
            <h4 class="alert alert-danger alert-dismissible fade show text-center" role="alert">
              <?php echo $message ?>
              <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </h4>
          <?php
          }
          ?>

          <form method="post" action="?page=edit&user_id=<?php echo $result['user_id'] ?>">
            <input type="hidden" name="old_id" value="<?php echo $result['user_id'] ?>">
            <label>ID</label>
            <input type="text" name="user_id" class="form-control mb-4" value="<?php echo $result['user_id'] ?>">

            <label>Name</label>
            <input type="text" name="user_name" class="form-control mb-4" value="<?php echo $result['user_name'] ?>">

            <label>Email</label>
            <input type="email" name="email" class="form-control mb-4" value="<?php echo $result['email'] ?>">

            <label>Password</label>
            <input type="password" name="pass" class="form-control mb-4 " value="<?php echo $result['password'] ?>">

            <label>Role</label>
            <select class="form-control mb-4" name="role">
              <?php
              if ($result['role'] == "admin") {
                echo "<option value='user'>User</option>";
                echo "<option value='admin' selected>Admin</option>";
              } else {
                echo "<option value='user' selected>User</option>";
                echo "<option value='admin'>Admin</option>";
              }
              ?>
            </select>

            <label>Status</label>
            <select class="form-control mb-4" name="status">
              <?php
              if ($result['status'] == "1") {
                echo "<option value='0'>Block</option>";
                echo "<option value='1' selected>Active</option>";
              } else {
                echo "<option value='0' selected>Block</option>";
                echo "<option value='1'>Active</option>";
              }
              ?>
            </select>

            <input type="submit" value="Update" class="btn btn-block btn-success">
          </form>
        </div>
      </div>
    </div>
<?php
  }

  /* ========================= Update ========================= */ elseif ($page == "saveupdate") {

    $old_id = $_SESSION['old_id'];
    $id = $_SESSION['user_id'];
    $user = $_SESSION['user_name'];
    $email = $_SESSION['email'];
    $pass = $_SESSION['pass'];
    $role = $_SESSION['role'];
    $status = $_SESSION['status'];



    $statement = $connect->prepare("UPDATE users SET
    user_id=?,
    user_name=?,
    email=?,
    `password`=?,
    `role`=?,
    `status`=?,
    updated_at = now()
    WHERE user_id = ?
    ");
    $statement->execute(array($id, $user, $email, $pass, $role, $status, $old_id));
    $_SESSION['message'] = "Updated Successfully";
    header("location:users.php");
  }


  include('includes/temp/footer.php');
} else {
  $_SESSION['message_login'] = "Login First";
  header("Location: ../login.php");
}
?>