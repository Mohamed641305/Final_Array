<?php
session_start();
if (!isset($_SESSION['admin_login'])) {
  $_SESSION['message_login'] = "Login First";
  header("Location: ../login.php");
  exit;
}

include('init.php');

$page = isset($_GET['page']) ? $_GET['page'] : "All";

/* ========================= ALL CATEGORIES ========================= */
if ($page === "All") {
  $stmt = $connect->prepare("SELECT * FROM categories");
  $stmt->execute();
  $categories = $stmt->fetchAll();
  $count = $stmt->rowCount();
?>

  <div class="container mt-5 pt-5">
    <div class="row justify-content-center">
      <div class="col-md-10">

        <?php if (isset($_SESSION['message'])): ?>
          <div class="alert alert-success alert-dismissible fade show text-center" role="alert">
            <?= $_SESSION['message'] ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
          </div>
        <?php unset($_SESSION['message']);
        endif; ?>

        <div class="d-flex justify-content-between align-items-center mb-4">
          <h3>Categories <span class="badge bg-primary"><?= $count ?></span></h3>
          <a href="?page=create" class="btn btn-success"><i class="fas fa-plus"></i> Add Category</a>
        </div>

        <div class="table-responsive shadow-sm rounded">
          <table class="table table-hover table-bordered align-middle text-center">
            <thead class="table-dark">
              <tr>
                <th>ID</th>
                <th>Title</th>
                <th>Status</th>
                <th>Created At</th>
                <th>Actions</th>
              </tr>
            </thead>
            <tbody>
              <?php foreach ($categories as $row): ?>
                <tr>
                  <td><?= $row['category_id'] ?></td>
                  <td><?= htmlspecialchars($row['title']) ?></td>
                  <td>
                    <?= $row['status'] == 1 ? '<span class="badge bg-success">Active</span>' : '<span class="badge bg-danger">Inactive</span>' ?>
                  </td>
                  <td><?= $row['created_at'] ?></td>
                  <td>
                    <a href="?page=show&id=<?= $row['category_id'] ?>" class="btn btn-sm btn-success me-1">
                      <i class="fas fa-eye"></i>
                    </a>
                    <a href="?page=edit&id=<?= $row['category_id'] ?>" class="btn btn-sm btn-primary me-1">
                      <i class="fas fa-edit"></i>
                    </a>
                    <a href="?page=delete&id=<?= $row['category_id'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure to delete this category?');">
                      <i class="fas fa-trash"></i>
                    </a>
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

/* ========================= SHOW ========================= */ elseif ($page === "show" && isset($_GET['id'])) {
  $id = $_GET['id'];
  $stmt = $connect->prepare("SELECT * FROM categories WHERE category_id = ?");
  $stmt->execute(array($id));
  $row = $stmt->fetch();
?>

  <div class="container mt-5 pt-5">
    <div class="row justify-content-center">
      <div class="col-md-10">
        <h4 class="text-center">Category Details</h4>
        <table class="table table-dark table-bordered text-center mt-4">
          <thead>
            <tr>
              <th>ID</th>
              <th>Title</th>
              <th>Status</th>
              <th>Created At</th>
              <th>Actions</th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <td><?= $row['category_id'] ?></td>
              <td><?= htmlspecialchars($row['title']) ?></td>
              <td>
                <?= $row['status'] == 1 ? '<span class="badge bg-success">Active</span>' : '<span class="badge bg-danger">Inactive</span>' ?>
              </td>
              <td><?= $row['created_at'] ?></td>
              <td>
                <a href="categories.php" class="btn btn-success"><i class="fas fa-house"></i></a>
              </td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>
  </div>

<?php
}

/* ========================= EDIT ========================= */ elseif ($page === "edit" && isset($_GET['id'])) {
  $id = $_GET['id'];
  $message = "";

  // جلب بيانات الفئة الحالية
  $stmt = $connect->prepare("SELECT * FROM categories WHERE category_id = ?");
  $stmt->execute(array($id));
  $row = $stmt->fetch();

  // تهيئة القيم للعرض في الفورم
  $title = $row['title'];
  $status = $row['status'];

  if ($_SERVER['REQUEST_METHOD'] === "POST") {
    $title = $_POST['title'];
    $status = $_POST['status'];

    // تحقق من صحة الإدخال
    if ($title === "") {
      $message = "Please enter category title.";
    } else {
      // تحديث البيانات في قاعدة البيانات
      $stmt = $connect->prepare("UPDATE categories SET title = ?, status = ?, updated_at = NOW() WHERE category_id = ?");
      $stmt->execute(array($title, $status, $id));

      $_SESSION['message'] = "Category Updated Successfully";
      header("Location: categories.php");
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
          <label>Category Title</label>
          <input type="text" name="title" class="form-control mb-3" value="<?= htmlspecialchars($title) ?>">

          <label>Status</label>
          <select name="status" class="form-control mb-3">
            <option value="1" <?= $status == 1 ? 'selected' : '' ?>>Active</option>
            <option value="0" <?= $status == 0 ? 'selected' : '' ?>>Inactive</option>
          </select>

          <button type="submit" class="btn btn-primary btn-block">Update Category</button>
        </form>
      </div>
    </div>
  </div>

<?php
}

/* ========================= DELETE ========================= */ elseif ($page === "delete" && isset($_GET['id'])) {
  $id = $_GET['id'];
  $stmt = $connect->prepare("DELETE FROM categories WHERE category_id = ?");
  $stmt->execute(array($id));
  $_SESSION['message'] = "Category Deleted Successfully";
  header("Location: categories.php");
}

/* ========================= CREATE ========================= */ elseif ($page === "create") {
  $title = $status = "";
  $message = "";

  if ($_SERVER['REQUEST_METHOD'] === "POST") {
    $title = $_POST['title'];
    $status = $_POST['status'];

    if ($title === "") {
      $message = "Please enter category title.";
    } else {
      $_SESSION['title'] = $title;
      $_SESSION['status'] = $status;
      header("Location: categories.php?page=savenew");
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
          <label>Category Title</label>
          <input type="text" name="title" class="form-control mb-3" value="<?= $title ?>">
          <label>Status</label>
          <select name="status" class="form-control mb-3">
            <option value="1" <?= $status == 1 ? 'selected' : '' ?>>Active</option>
            <option value="0" <?= $status == 0 ? 'selected' : '' ?>>Inactive</option>
          </select>
          <button type="submit" class="btn btn-success btn-block">Create Category</button>
        </form>
      </div>
    </div>
  </div>

<?php
}

/* ========================= SAVE ========================= */ elseif ($page === "savenew") {
  $title = $_SESSION['title'];
  $status = $_SESSION['status'];

  $stmt = $connect->prepare("INSERT INTO categories (title, status, created_at) VALUES (?, ?, NOW())");
  $stmt->execute(array($title, $status));

  $_SESSION['message'] = "Category Created Successfully";
  header("Location: categories.php");
}

include('includes/temp/footer.php');
?>