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

$q4 = $connect->prepare("SELECT * From comments");
$q4->execute();
$commentCount = $q4->rowCount();
?>

<style>

.dashboard-card{
    border-radius:15px;
    padding:30px;
    color:white;
    transition:0.3s;
    box-shadow:0 10px 25px rgba(0,0,0,.2);
}

.dashboard-card:hover{
    transform:translateY(-10px);
    box-shadow:0 20px 40px rgba(0,0,0,.3);
}

.card-users{
    background:linear-gradient(45deg,#4e73df,#224abe);
}

.card-categories{
    background:linear-gradient(45deg,#1cc88a,#13855c);
}

.card-posts{
    background:linear-gradient(45deg,#f6c23e,#dda20a);
}

.card-comments{
    background:linear-gradient(45deg,#e74a3b,#be2617);
}

.dashboard-icon{
    font-size:45px;
    margin-bottom:15px;
}

.dashboard-number{
    font-size:40px;
    font-weight:bold;
}

.dashboard-btn{
    margin-top:15px;
    border-radius:20px;
}

</style>


<div class="container mt-5 pt-5">

<div class="text-center mb-5">
<h1 class="fw-bold text-primary">Admin Dashboard</h1>
<p class="text-muted">Control Your Website Easily</p>
</div>

<div class="row g-4">

<div class="col-md-3">
<div class="dashboard-card card-users text-center">

<i class="fa-solid fa-user dashboard-icon"></i>

<h4>Users</h4>

<div class="dashboard-number">
<?php echo $userCount ?>
</div>

<a href="users.php" class="btn btn-light dashboard-btn">Manage</a>

</div>
</div>


<div class="col-md-3">
<div class="dashboard-card card-categories text-center">

<i class="fa-solid fa-layer-group dashboard-icon"></i>

<h4>Categories</h4>

<div class="dashboard-number">
<?php echo $cateCount ?>
</div>

<a href="categories.php" class="btn btn-light dashboard-btn">Manage</a>

</div>
</div>


<div class="col-md-3">
<div class="dashboard-card card-posts text-center">

<i class="fa-solid fa-address-card dashboard-icon"></i>

<h4>Posts</h4>

<div class="dashboard-number">
<?php echo $postCount ?>
</div>

<a href="posts.php" class="btn btn-light dashboard-btn">Manage</a>

</div>
</div>


<div class="col-md-3">
<div class="dashboard-card card-comments text-center">

<i class="fa-solid fa-comment dashboard-icon"></i>

<h4>Comments</h4>

<div class="dashboard-number">
<?php echo $commentCount ?>
</div>

<a href="comments.php" class="btn btn-light dashboard-btn">Manage</a>

</div>
</div>

</div>

</div>

<?php
include('includes/temp/footer.php');

}else{
$_SESSION['message_login'] = "Login First";
header("Location: ../login.php");
}
?>