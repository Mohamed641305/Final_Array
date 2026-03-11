<?php
session_start();
if (!isset($_SESSION['admin_login'])) {
  $_SESSION['message_login'] = "Login First";
  header("Location: ../login.php");
  exit;
}

include('init.php');

$page = isset($_GET['page']) ? $_GET['page'] : "All";

/* ========================= ALL POSTS ========================= */
if ($page === "All") {
  $stmt = $connect->prepare("
        SELECT posts.*, categories.title AS category_title, users.user_name AS author_name
        FROM posts
        JOIN categories ON posts.category_id = categories.category_id
        JOIN users ON posts.author_id = users.user_id
    ");
  $stmt->execute();
  $posts = $stmt->fetchAll();
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
          <h3>Posts <span class="badge bg-primary"><?= $count ?></span></h3>
          <a href="?page=create" class="btn btn-success"><i class="fas fa-plus"></i> Add Post</a>
        </div>

        <div class="table-responsive shadow-sm rounded">
          <table class="table table-hover table-bordered align-middle text-center">
            <thead class="table-dark">
              <tr>
                <th>ID</th>
                <th>Title</th>
                <th>Category</th>
                <th>Status</th>
                <th>Created At</th>
                <th>Actions</th>
              </tr>
            </thead>
            <tbody>
              <?php foreach ($posts as $row): ?>
                <tr>
                  <td><?= $row['post_id'] ?></td>
                  <td><?= htmlspecialchars($row['title']) ?></td>
                  <td><?= htmlspecialchars($row['category_title']) ?></td>
                  <td>
                    <?= $row['status'] == 1 ? '<span class="badge bg-success">Active</span>' : '<span class="badge bg-danger">Inactive</span>' ?>
                  </td>
                  <td><?= $row['created_at'] ?></td>
                  <td>
                    <a href="?page=show&id=<?= $row['post_id'] ?>" class="btn btn-sm btn-success me-1"><i class="fas fa-eye"></i></a>
                    <a href="?page=edit&id=<?= $row['post_id'] ?>" class="btn btn-sm btn-primary me-1"><i class="fas fa-edit"></i></a>
                    <a href="?page=delete&id=<?= $row['post_id'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure to delete this post?');"><i class="fas fa-trash"></i></a>
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

/* ========================= SHOW POST ========================= */ elseif ($page === "show" && isset($_GET['id'])) {
  $id = $_GET['id'];
  $stmt = $connect->prepare("
        SELECT posts.*, categories.title AS category_title, users.user_name AS author_name
        FROM posts
        JOIN categories ON posts.category_id = categories.category_id
        JOIN users ON posts.author_id = users.user_id
        WHERE post_id = ?
    ");
  $stmt->execute(array($id));
  $row = $stmt->fetch();
?>

  <div class="container mt-5 pt-5">
    <div class="row justify-content-center">
      <div class="col-md-10">
        <h4 class="text-center">Post Details</h4>
        <table class="table table-dark table-bordered text-center mt-4">
          <thead>
            <tr>
              <th>ID</th>
              <th>Title</th>
              <th>Category</th>
              <th>Author</th>
              <th>Status</th>
              <th>Created At</th>
              <th>Updated At</th>
              <th>Actions</th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <td><?= $row['post_id'] ?></td>
              <td><?= htmlspecialchars($row['title']) ?></td>
              <td><?= htmlspecialchars($row['category_title']) ?></td>
              <td><?= htmlspecialchars($row['author_name']) ?></td>
              <td>
                <?= $row['status'] == 1 ? '<span class="badge bg-success">Active</span>' : '<span class="badge bg-danger">Inactive</span>' ?>
              </td>
              <td><?= $row['created_at'] ?></td>
              <td><?= $row['updated_at'] ?></td>
              <td>
                <a href="posts.php" class="btn btn-success"><i class="fas fa-house"></i></a>
              </td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>
  </div>

<?php
}

/* ========================= CREATE POST ========================= */ elseif ($page === "create") {
  $title = $content = $category = $status = "";
  $message = "";

  if ($_SERVER['REQUEST_METHOD'] === "POST") {
    $title = $_POST['title'];
    $content = $_POST['content'];
    $category = $_POST['category'];
    $status = $_POST['status'];
    $author = $_SESSION['admin_id']; // تأكد من وجود admin_id في السيشن

    if ($title === "" || $content === "" || $category === "") {
      $message = "Please fill all fields.";
    } else {
      $_SESSION['post_title'] = $title;
      $_SESSION['post_content'] = $content;
      $_SESSION['post_category'] = $category;
      $_SESSION['post_status'] = $status;
      $_SESSION['post_author'] = $author;
      header("Location: posts.php?page=savenew");
      exit;
    }
  }

  // جلب الفئات
  $categories_stmt = $connect->prepare("SELECT * FROM categories");
  $categories_stmt->execute();
  $all_categories = $categories_stmt->fetchAll();
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
          <label>Title</label>
          <input type="text" name="title" class="form-control mb-3" value="<?= htmlspecialchars($title) ?>">

          <label>Content</label>
          <textarea name="content" class="form-control mb-3"><?= htmlspecialchars($content) ?></textarea>

          <label>Category</label>
          <select name="category" class="form-control mb-3">
            <?php foreach ($all_categories as $cat): ?>
              <option value="<?= $cat['category_id'] ?>" <?= $category == $cat['category_id'] ? 'selected' : '' ?>><?= htmlspecialchars($cat['title']) ?></option>
            <?php endforeach; ?>
          </select>

          <label>Status</label>
          <select name="status" class="form-control mb-3">
            <option value="1" <?= $status == 1 ? 'selected' : '' ?>>Active</option>
            <option value="0" <?= $status == 0 ? 'selected' : '' ?>>Inactive</option>
          </select>

          <button type="submit" class="btn btn-success btn-block">Create Post</button>
        </form>
      </div>
    </div>
  </div>

<?php
}

/* ========================= SAVE NEW POST ========================= */ elseif ($page === "savenew") {
  $stmt = $connect->prepare("INSERT INTO posts (title, content, category_id, author_id, status, created_at) VALUES (?, ?, ?, ?, ?, NOW())");
  $stmt->execute(array($_SESSION['post_title'], $_SESSION['post_content'], $_SESSION['post_category'], $_SESSION['post_author'], $_SESSION['post_status']));

  unset($_SESSION['post_title'], $_SESSION['post_content'], $_SESSION['post_category'], $_SESSION['post_status'], $_SESSION['post_author']);
  $_SESSION['message'] = "Post Created Successfully";
  header("Location: posts.php");
}

/* ========================= EDIT POST ========================= */ elseif ($page === "edit" && isset($_GET['id'])) {
  $id = $_GET['id'];
  $message = "";

  $stmt = $connect->prepare("SELECT * FROM posts WHERE post_id = ?");
  $stmt->execute(array($id));
  $row = $stmt->fetch();

  $title = $row['title'];
  $content = $row['content'];
  $category = $row['category_id'];
  $status = $row['status'];

  if ($_SERVER['REQUEST_METHOD'] === "POST") {
    $title = $_POST['title'];
    $content = $_POST['content'];
    $category = $_POST['category'];
    $status = $_POST['status'];

    if ($title === "" || $content === "" || $category === "") {
      $message = "Please fill all fields.";
    } else {
      $stmt = $connect->prepare("UPDATE posts SET title = ?, content = ?, category_id = ?, status = ?, updated_at = NOW() WHERE post_id = ?");
      $stmt->execute(array($title, $content, $category, $status, $id));

      $_SESSION['message'] = "Post Updated Successfully";
      header("Location: posts.php");
      exit;
    }
  }

  $categories_stmt = $connect->prepare("SELECT * FROM categories");
  $categories_stmt->execute();
  $all_categories = $categories_stmt->fetchAll();
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
          <label>Title</label>
          <input type="text" name="title" class="form-control mb-3" value="<?= htmlspecialchars($title) ?>">

          <label>Content</label>
          <textarea name="content" class="form-control mb-3"><?= htmlspecialchars($content) ?></textarea>

          <label>Category</label>
          <select name="category" class="form-control mb-3">
            <?php foreach ($all_categories as $cat): ?>
              <option value="<?= $cat['category_id'] ?>" <?= $category == $cat['category_id'] ? 'selected' : '' ?>><?= htmlspecialchars($cat['title']) ?></option>
            <?php endforeach; ?>
          </select>

          <label>Status</label>
          <select name="status" class="form-control mb-3">
            <option value="1" <?= $status == 1 ? 'selected' : '' ?>>Active</option>
            <option value="0" <?= $status == 0 ? 'selected' : '' ?>>Inactive</option>
          </select>

          <button type="submit" class="btn btn-primary btn-block">Update Post</button>
        </form>
      </div>
    </div>
  </div>

<?php
}

/* ========================= DELETE POST ========================= */ elseif ($page === "delete" && isset($_GET['id'])) {
  $id = $_GET['id'];
  $stmt = $connect->prepare("DELETE FROM posts WHERE post_id = ?");
  $stmt->execute(array($id));
  $_SESSION['message'] = "Post Deleted Successfully";
  header("Location: posts.php");
}

include('includes/temp/footer.php');
?>