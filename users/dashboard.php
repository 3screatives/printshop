<?php
session_start();

include '../ps-admin/db_function.php';
$conn = db_connect();

if (!isset($_SESSION['user_id'], $_SESSION['user_type'])) {
    header("Location: login.php");
    exit;
}

if ($_SESSION['user_type'] !== 'client') {
    header("Location: ../ps-admin/index.php");
    exit;
}

include '../include/head.php';
include '../include/header.php';
?>

<section class="my-cart" style="min-height: 50vh; padding-bottom: 96px;">
    <div class="container">
        <div class="sec-head">
            <div class="quick-links">
                <a href="./">Home</a>
                <i class="bi bi-chevron-right"></i>
                Dashboard
            </div>

            <h2>Dashboard</h2>
        </div>
    </div>
    <div class="container">
        User is here!
    </div>
</section>

<?php include '../include/footer.php'; ?>