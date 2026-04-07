<?php
session_start();
if (isset($_SESSION['admin_login'])) {

    include('init.php'); // اتأكد إنه فيه $connect

    // جلب البيانات
    $q1 = $connect->prepare("SELECT * FROM users");
    $q1->execute();
    $userCount = $q1->rowCount();

    $q2 = $connect->prepare("SELECT * FROM categories");
    $q2->execute();
    $cateCount = $q2->rowCount();

    $q3 = $connect->prepare("SELECT * FROM posts");
    $q3->execute();
    $postCount = $q3->rowCount();

    $q4 = $connect->prepare("SELECT * FROM comments");
    $q4->execute();
    $commentCount = $q4->rowCount();

    // استدعاء الـ navbar مرة واحدة
    // include('includes/navbar.php'); 
?>

<style>
/* ===== تعديل spacing للـ fixed navbar ===== */
body {
    /* padding-top: 80px; ارتفاع navbar */
    background: #f4f6f9;
}

/* ===== Dashboard Cards ===== */
.dashboard-card {
    border-radius: 15px;
    padding: 30px;
    color: white;
    transition: 0.3s;
    box-shadow: 0 10px 25px rgba(0, 0, 0, .2);
    position: relative;
    overflow: hidden;
    opacity: 0;
    transform: translateY(40px);
    animation: smoothFade 0.8s ease forwards;
}

.dashboard-card:hover {
    transform: translateY(-10px);
    box-shadow: 0 20px 40px rgba(0, 0, 0, .3);
}

.card-users { background: linear-gradient(45deg, #4e73df, #224abe); }
.card-categories { background: linear-gradient(45deg, #1cc88a, #13855c); }
.card-posts { background: linear-gradient(45deg, #f6c23e, #dda20a); }
.card-comments { background: linear-gradient(45deg, #e74a3b, #be2617); }

.dashboard-icon {
    font-size: 45px;
    margin-bottom: 15px;
    transition: 0.4s ease;
}

.dashboard-card:hover .dashboard-icon {
    transform: scale(1.15) rotate(8deg);
}

.dashboard-number {
    font-size: 40px;
    font-weight: bold;
    letter-spacing: 1px;
    transition: 0.3s;
}

.dashboard-card:hover .dashboard-number {
    transform: scale(1.1);
}

.dashboard-btn {
    margin-top: 15px;
    border-radius: 20px;
    transition: all 0.3s ease;
}

.dashboard-btn:hover {
    background: #fff;
    color: #000;
    transform: translateY(-3px);
}

/* Glow effect */
.dashboard-card::before {
    content: "";
    position: absolute;
    top: -50%;
    left: -50%;
    width: 200%;
    height: 200%;
    background: linear-gradient(120deg, transparent, rgba(255, 255, 255, 0.2), transparent);
    transform: rotate(25deg);
    transition: 0.6s;
    opacity: 0;
}

.dashboard-card:hover::before {
    opacity: 1;
    animation: shine 1s ease;
}

@keyframes shine {
    0% { transform: translateX(-100%) rotate(25deg); }
    100% { transform: translateX(100%) rotate(25deg); }
}

@keyframes smoothFade {
    to { opacity: 1; transform: translateY(0); }
}

/* Responsive */
@media (max-width: 991px) {
    .col-md-3 { flex: 0 0 50%; max-width: 50%; }
}

@media (max-width: 575px) {
    .col-md-3 { flex: 0 0 100%; max-width: 100%; }
    .dashboard-card { padding: 20px; }
    .dashboard-icon { font-size: 30px; }
    .dashboard-number { font-size: 28px; }
}

/* Animation delay لكل كرت */
.col-md-3:nth-child(1) .dashboard-card { animation-delay: 0.1s; }
.col-md-3:nth-child(2) .dashboard-card { animation-delay: 0.2s; }
.col-md-3:nth-child(3) .dashboard-card { animation-delay: 0.3s; }
.col-md-3:nth-child(4) .dashboard-card { animation-delay: 0.4s; }

</style>

<div class="container mt-5 pt-3">

    <div class="text-center mb-5">
        <h1 class="fw-bold text-primary">Admin Dashboard</h1>
        <p class="text-muted">Control Your Website Easily</p>
    </div>

    <div class="row g-4">
        <div class="col-md-3">
            <div class="dashboard-card card-users text-center">
                <i class="fa-solid fa-user dashboard-icon"></i>
                <h4>Users</h4>
                <div class="dashboard-number"><?php echo $userCount ?></div>
                <a href="users.php" class="btn btn-light dashboard-btn">Manage</a>
            </div>
        </div>

        <div class="col-md-3">
            <div class="dashboard-card card-categories text-center">
                <i class="fa-solid fa-layer-group dashboard-icon"></i>
                <h4>Categories</h4>
                <div class="dashboard-number"><?php echo $cateCount ?></div>
                <a href="categories.php" class="btn btn-light dashboard-btn">Manage</a>
            </div>
        </div>

        <div class="col-md-3">
            <div class="dashboard-card card-posts text-center">
                <i class="fa-solid fa-address-card dashboard-icon"></i>
                <h4>Posts</h4>
                <div class="dashboard-number"><?php echo $postCount ?></div>
                <a href="posts.php" class="btn btn-light dashboard-btn">Manage</a>
            </div>
        </div>

        <div class="col-md-3">
            <div class="dashboard-card card-comments text-center">
                <i class="fa-solid fa-comment dashboard-icon"></i>
                <h4>Comments</h4>
                <div class="dashboard-number"><?php echo $commentCount ?></div>
                <a href="comments.php" class="btn btn-light dashboard-btn">Manage</a>
            </div>
        </div>
    </div>

</div>

<?php
    include('includes/temp/footer.php');

} else {
    $_SESSION['message_login'] = "Login First";
    header("Location: ../login.php");
}
?>