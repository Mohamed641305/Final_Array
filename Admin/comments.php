<?php
session_start();
if (!isset($_SESSION['admin_login'])) {
  $_SESSION['message_login'] = "Login First";
  header("Location: ../login.php");
  exit;
}

include('init.php');

$page = isset($_GET['page']) ? $_GET['page'] : "All";

/* ========================= ALL COMMENTS ========================= */
if ($page === "All") {
  $stmt = $connect->prepare("
        SELECT comments.*, users.user_name AS author_name, posts.title AS post_title
        FROM comments
        JOIN users ON comments.user_id = users.user_id
        JOIN posts ON comments.post_id = posts.post_id
    ");
  $stmt->execute();
  $comments = $stmt->fetchAll();
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
          <h3>Comments <span class="badge bg-primary"><?= $count ?></span></h3>
          <a href="?page=create" class="btn btn-success"><i class="fas fa-plus"></i> Add Comment</a>
        </div>

        <div class="table-responsive shadow-sm rounded">
          <table class="table table-hover table-bordered align-middle text-center">
            <thead class="table-dark">
              <tr>
                <th>ID</th>
                <th>Comment</th>
                <th>Post</th>
                <th>Status</th>
                <th>Created At</th>
                <th>Actions</th>
              </tr>
            </thead>
            <tbody>
              <?php foreach ($comments as $row): ?>
                <tr>
                  <td><?= $row['comment_id'] ?></td>
                  <td><?= htmlspecialchars($row['comment']) ?></td>
                  <td><?= htmlspecialchars($row['post_title']) ?></td>
                  <td>
                    <?= $row['status'] == 1 ? '<span class="badge bg-success">Approved</span>' : '<span class="badge bg-danger">Pending</span>' ?>
                  </td>
                  <td><?= $row['created_at'] ?></td>
                  <td>
                    <a href="?page=show&id=<?= $row['comment_id'] ?>" class="btn btn-sm btn-success me-1">
                      <i class="fas fa-eye"></i>
                    </a>
                    <a href="?page=edit&id=<?= $row['comment_id'] ?>" class="btn btn-sm btn-primary me-1">
                      <i class="fas fa-edit"></i>
                    </a>
                    <a href="?page=delete&id=<?= $row['comment_id'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure to delete this comment?');">
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
  $stmt = $connect->prepare("
        SELECT comments.*, users.user_name AS author_name, posts.title AS post_title
        FROM comments
        JOIN users ON comments.user_id = users.user_id
        JOIN posts ON comments.post_id = posts.post_id
        WHERE comment_id = ?
    ");
  $stmt->execute(array($id));
  $row = $stmt->fetch();
?>

  <div class="container mt-5 pt-5">
    <div class="row justify-content-center">
      <div class="col-md-10">
        <h4 class="text-center">Comment Details</h4>
        <table class="table table-dark table-bordered text-center mt-4">
          <thead>
            <tr>
              <th>ID</th>
              <th>Comment</th>
              <th>Author</th>
              <th>Post</th>
              <th>Status</th>
              <th>Created At</th>
              <th>Actions</th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <td><?= $row['comment_id'] ?></td>
              <td><?= htmlspecialchars($row['comment']) ?></td>
              <td><?= htmlspecialchars($row['author_name']) ?></td>
              <td><?= htmlspecialchars($row['post_title']) ?></td>
              <td>
                <?= $row['status'] == 1 ? '<span class="badge bg-success">Approved</span>' : '<span class="badge bg-danger">Pending</span>' ?>
              </td>
              <td><?= $row['created_at'] ?></td>
              <td>
                <a href="comments.php" class="btn btn-success"><i class="fas fa-house"></i></a>
              </td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>
  </div>

<?php
}

/* ========================= CREATE ========================= */ elseif ($page === "create") {
  $comment = $user_id = $post_id = "";
  $status = 1;
  $message = "";

  if ($_SERVER['REQUEST_METHOD'] === "POST") {
    $comment = $_POST['comment'];
    $user_id = $_POST['user_id'];
    $post_id = $_POST['post_id'];
    $status = $_POST['status'];

    if ($comment === "" || $user_id === "" || $post_id === "") {
      $message = "Please fill in all fields.";
    } else {
      $_SESSION['comment'] = $comment;
      $_SESSION['user_id'] = $user_id;
      $_SESSION['post_id'] = $post_id;
      $_SESSION['status'] = $status;
      header("Location: comments.php?page=savenew");
      exit;
    }
  }

  // جلب المستخدمين و البوستات للفورم
  $users = $connect->query("SELECT user_id, user_name FROM users")->fetchAll();
  $posts = $connect->query("SELECT post_id, title FROM posts")->fetchAll();
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
          <label>Comment</label>
          <textarea name="comment" class="form-control mb-3"><?= htmlspecialchars($comment) ?></textarea>

          <label>Author</label>
          <select name="user_id" class="form-control mb-3">
            <option value="">Select User</option>
            <?php foreach ($users as $u): ?>
              <option value="<?= $u['user_id'] ?>" <?= $user_id == $u['user_id'] ? 'selected' : '' ?>><?= htmlspecialchars($u['user_name']) ?></option>
            <?php endforeach; ?>
          </select>

          <label>Post</label>
          <select name="post_id" class="form-control mb-3">
            <option value="">Select Post</option>
            <?php foreach ($posts as $p): ?>
              <option value="<?= $p['post_id'] ?>" <?= $post_id == $p['post_id'] ? 'selected' : '' ?>><?= htmlspecialchars($p['title']) ?></option>
            <?php endforeach; ?>
          </select>

          <label>Status</label>
          <select name="status" class="form-control mb-3">
            <option value="1" <?= $status == 1 ? 'selected' : '' ?>>Approved</option>
            <option value="0" <?= $status == 0 ? 'selected' : '' ?>>Pending</option>
          </select>

          <button type="submit" class="btn btn-success btn-block">Add Comment</button>
        </form>
      </div>
    </div>
  </div>

<?php
}

/* ========================= SAVE ========================= */ elseif ($page === "savenew") {
  $comment = $_SESSION['comment'];
  $user_id = $_SESSION['user_id'];
  $post_id = $_SESSION['post_id'];
  $status = $_SESSION['status'];

  $stmt = $connect->prepare("INSERT INTO comments (comment, user_id, post_id, status, created_at) VALUES (?, ?, ?, ?, NOW())");
  $stmt->execute(array($comment, $user_id, $post_id, $status));

  $_SESSION['message'] = "Comment Added Successfully";
  header("Location: comments.php");
  exit;
}

/* ========================= EDIT ========================= */ elseif ($page === "edit" && isset($_GET['id'])) {
  $id = $_GET['id'];
  $stmt = $connect->prepare("SELECT * FROM comments WHERE comment_id = ?");
  $stmt->execute(array($id));
  $row = $stmt->fetch();

  $comment = $row['comment'];
  $user_id = $row['user_id'];
  $post_id = $row['post_id'];
  $status = $row['status'];
  $message = "";

  $users = $connect->query("SELECT user_id, user_name FROM users")->fetchAll();
  $posts = $connect->query("SELECT post_id, title FROM posts")->fetchAll();

  if ($_SERVER['REQUEST_METHOD'] === "POST") {
    $comment = $_POST['comment'];
    $user_id = $_POST['user_id'];
    $post_id = $_POST['post_id'];
    $status = $_POST['status'];

    if ($comment === "" || $user_id === "" || $post_id === "") {
      $message = "Please fill in all fields.";
    } else {
      $stmt = $connect->prepare("UPDATE comments SET comment = ?, user_id = ?, post_id = ?, status = ?, updated_at = NOW() WHERE comment_id = ?");
      $stmt->execute(array($comment, $user_id, $post_id, $status, $id));

      $_SESSION['message'] = "Comment Updated Successfully";
      header("Location: comments.php");
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
          <label>Comment</label>
          <textarea name="comment" class="form-control mb-3"><?= htmlspecialchars($comment) ?></textarea>

          <label>Author</label>
          <select name="user_id" class="form-control mb-3">
            <?php foreach ($users as $u): ?>
              <option value="<?= $u['user_id'] ?>" <?= $user_id == $u['user_id'] ? 'selected' : '' ?>><?= htmlspecialchars($u['user_name']) ?></option>
            <?php endforeach; ?>
          </select>

          <label>Post</label>
          <select name="post_id" class="form-control mb-3">
            <?php foreach ($posts as $p): ?>
              <option value="<?= $p['post_id'] ?>" <?= $post_id == $p['post_id'] ? 'selected' : '' ?>><?= htmlspecialchars($p['title']) ?></option>
            <?php endforeach; ?>
          </select>

          <label>Status</label>
          <select name="status" class="form-control mb-3">
            <option value="1" <?= $status == 1 ? 'selected' : '' ?>>Approved</option>
            <option value="0" <?= $status == 0 ? 'selected' : '' ?>>Pending</option>
          </select>

          <button type="submit" class="btn btn-primary btn-block">Update Comment</button>
        </form>
      </div>
    </div>
  </div>

<?php
}

/* ========================= DELETE ========================= */ elseif ($page === "delete" && isset($_GET['id'])) {
  $id = $_GET['id'];
  $stmt = $connect->prepare("DELETE FROM comments WHERE comment_id = ?");
  $stmt->execute(array($id));
  $_SESSION['message'] = "Comment Deleted Successfully";
  header("Location: comments.php");
  exit;
}

include('includes/temp/footer.php');
?>