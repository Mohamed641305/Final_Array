<?php
session_start();
if (!isset($_SESSION['admin_login'])) {
  $_SESSION['message_login'] = "Login First";
  header("Location: ../login.php");
  exit;
}

include('init.php');

$page = isset($_GET['page']) ? $_GET['page'] : "All";

/* ========================= ALL USERS ========================= */
if ($page === "All") {
  $stmt = $connect->prepare("SELECT * FROM users");
  $stmt->execute();
  $users = $stmt->fetchAll();
  $count = $stmt->rowCount();
?>

  <div class="container mt-5 pt-5">
    <div class="row justify-content-center">
      <div class="col-md-12">

        <?php if (isset($_SESSION['message'])): ?>
          <div class="alert alert-success alert-dismissible fade show text-center" role="alert">
            <?= $_SESSION['message'] ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
          </div>
        <?php unset($_SESSION['message']);
        endif; ?>

        <div class="d-flex justify-content-between align-items-center mb-4">
          <h3>Users <span class="badge bg-primary"><?= $count ?></span></h3>
          <a href="?page=create" class="btn btn-success"><i class="fas fa-plus"></i> Add User</a>
        </div>

        <div class="table-responsive shadow-sm rounded">
          <table class="table table-hover table-bordered align-middle text-center">
            <thead class="table-dark">
              <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Email</th>
                <th>Role</th>
                <th>Status</th>
                <th>Created At</th>
                <th>Actions</th>
              </tr>
            </thead>
            <tbody>
              <?php foreach ($users as $row): ?>
                <tr>
                  <td><?= $row['user_id'] ?></td>
                  <td><?= htmlspecialchars($row['user_name']) ?></td>
                  <td><?= htmlspecialchars($row['email']) ?></td>
                  <td><?= ucfirst($row['role']) ?></td>
                  <td>
                    <?= $row['status'] == 1
                      ? '<span class="badge bg-success">Active</span>'
                      : '<span class="badge bg-danger">Blocked</span>' ?>
                  </td>
                  <td><?= $row['created_at'] ?></td>
                  <td>
                    <a href="?page=show&id=<?= $row['user_id'] ?>" class="btn btn-sm btn-success me-1"><i class="fas fa-eye"></i></a>
                    <a href="?page=edit&id=<?= $row['user_id'] ?>" class="btn btn-sm btn-primary me-1"><i class="fas fa-edit"></i></a>
                    <a href="?page=delete&id=<?= $row['user_id'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure to delete this user?');"><i class="fas fa-trash"></i></a>
                  </td>
                </tr>
              <?php endforeach; ?>
            </tbody>
          </table>
        </div>

      </div>
    </div>
  </div>

<?php
}

/* ========================= SHOW USER ========================= */ elseif ($page === "show" && isset($_GET['id'])) {
  $id = $_GET['id'];
  $stmt = $connect->prepare("SELECT * FROM users WHERE user_id = ?");
  $stmt->execute([$id]);
  $row = $stmt->fetch();
?>

  <div class="container mt-5 pt-5">
    <div class="row justify-content-center">
      <div class="col-md-10">
        <h4 class="text-center">User Details</h4>
        <table class="table table-dark table-bordered text-center mt-4">
          <thead>
            <tr>
              <th>ID</th>
              <th>Name</th>
              <th>Email</th>
              <th>Role</th>
              <th>Status</th>
              <th>Created At</th>
              <th>Actions</th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <td><?= $row['user_id'] ?></td>
              <td><?= htmlspecialchars($row['user_name']) ?></td>
              <td><?= htmlspecialchars($row['email']) ?></td>
              <td><?= ucfirst($row['role']) ?></td>
              <td>
                <?= $row['status'] == 1 ? '<span class="badge bg-success">Active</span>' : '<span class="badge bg-danger">Blocked</span>' ?>
              </td>
              <td><?= $row['created_at'] ?></td>
              <td>
                <a href="users.php" class="btn btn-success"><i class="fas fa-house"></i></a>
              </td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>
  </div>

<?php
}

/* ========================= CREATE USER ========================= */ elseif ($page === "create") {
  $user_name = $email = $password = "";
  $role = "user";
  $status = 1;
  $message = "";

  if ($_SERVER['REQUEST_METHOD'] === "POST") {
    $user_name = $_POST['user_name'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $role = $_POST['role'];
    $status = $_POST['status'];

    if ($user_name === "" || $email === "" || $password === "") {
      $message = "Please fill all fields.";
    } else {
      $stmt = $connect->prepare("INSERT INTO users (user_name, email, `password`, `role`, `status`, created_at) VALUES (?, ?, ?, ?, ?, NOW())");
      $stmt->execute([$user_name, $email, $password, $role, $status]);
      $_SESSION['message'] = "User Created Successfully";
      header("Location: users.php");
      exit;
    }
  }
?>

  <div class="container mt-5 pt-5">
    <div class="row justify-content-center">
      <div class="col-md-6">
        <?php if (!empty($message)): ?>
          <div class="alert alert-danger alert-dismissible fade show text-center" role="alert">
            <?= $message ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
          </div>
        <?php endif; ?>

        <form method="post" action="?page=create">
          <label>Name</label>
          <input type="text" name="user_name" class="form-control mb-3" value="<?= htmlspecialchars($user_name) ?>">

          <label>Email</label>
          <input type="email" name="email" class="form-control mb-3" value="<?= htmlspecialchars($email) ?>">

          <label>Password</label>
          <input type="password" name="password" class="form-control mb-3">

          <label>Role</label>
          <select name="role" class="form-control mb-3">
            <option value="user" <?= $role == 'user' ? 'selected' : '' ?>>User</option>
            <option value="admin" <?= $role == 'admin' ? 'selected' : '' ?>>Admin</option>
          </select>

          <label>Status</label>
          <select name="status" class="form-control mb-3">
            <option value="1" <?= $status == 1 ? 'selected' : '' ?>>Active</option>
            <option value="0" <?= $status == 0 ? 'selected' : '' ?>>Blocked</option>
          </select>

          <button type="submit" class="btn btn-success btn-block">Create User</button>
        </form>
      </div>
    </div>
  </div>

<?php
}

/* ========================= EDIT USER ========================= */ elseif ($page === "edit" && isset($_GET['id'])) {
  $id = $_GET['id'];
  $stmt = $connect->prepare("SELECT * FROM users WHERE user_id = ?");
  $stmt->execute([$id]);
  $row = $stmt->fetch();

  $message = "";
  if ($_SERVER['REQUEST_METHOD'] === "POST") {
    $user_name = $_POST['user_name'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $role = $_POST['role'];
    $status = $_POST['status'];

    if ($user_name === "" || $email === "" || $password === "") {
      $message = "Please fill all fields.";
    } else {
      $stmt = $connect->prepare("UPDATE users SET user_name=?, email=?, `password`=?, `role`=?, `status`=?, updated_at=NOW() WHERE user_id=?");
      $stmt->execute([$user_name, $email, $password, $role, $status, $id]);
      $_SESSION['message'] = "User Updated Successfully";
      header("Location: users.php");
      exit;
    }
  }
?>

  <div class="container mt-5 pt-5">
    <div class="row justify-content-center">
      <div class="col-md-6">
        <?php if (!empty($message)): ?>
          <div class="alert alert-danger alert-dismissible fade show text-center" role="alert">
            <?= $message ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
          </div>
        <?php endif; ?>

        <form method="post" action="?page=edit&id=<?= $id ?>">
          <label>Name</label>
          <input type="text" name="user_name" class="form-control mb-3" value="<?= htmlspecialchars($row['user_name']) ?>">

          <label>Email</label>
          <input type="email" name="email" class="form-control mb-3" value="<?= htmlspecialchars($row['email']) ?>">

          <label>Password</label>
          <input type="password" name="password" class="form-control mb-3" value="<?= htmlspecialchars($row['password']) ?>">

          <label>Role</label>
          <select name="role" class="form-control mb-3">
            <option value="user" <?= $row['role'] == 'user' ? 'selected' : '' ?>>User</option>
            <option value="admin" <?= $row['role'] == 'admin' ? 'selected' : '' ?>>Admin</option>
          </select>

          <label>Status</label>
          <select name="status" class="form-control mb-3">
            <option value="1" <?= $row['status'] == 1 ? 'selected' : '' ?>>Active</option>
            <option value="0" <?= $row['status'] == 0 ? 'selected' : '' ?>>Blocked</option>
          </select>

          <button type="submit" class="btn btn-primary btn-block">Update User</button>
        </form>
      </div>
    </div>
  </div>

<?php
}

/* ========================= DELETE USER ========================= */ elseif ($page === "delete" && isset($_GET['id'])) {
  $id = $_GET['id'];
  $stmt = $connect->prepare("DELETE FROM users WHERE user_id = ?");
  $stmt->execute([$id]);
  $_SESSION['message'] = "User Deleted Successfully";
  header("Location: users.php");
}

include('includes/temp/footer.php');
?>