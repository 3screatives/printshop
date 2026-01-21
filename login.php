<?php
session_start();

// If already logged in, redirect
// if (isset($_SESSION['user_id'])) {
//     header("Location: index.php");
//     exit;
// }

include 'ps-admin/db_function.php';
$conn = db_connect();

include 'include/head.php';
include 'include/header.php';
?>

<section class="order-page">
    <div class="container">
        <div class="sec-head">
            <div class="quick-links">
                <a href="./">Home</a>
                <i class="bi bi-chevron-right"></i>

                <?php if ($typeLabel): ?>
                    <span><?= htmlspecialchars($typeLabel) ?></span>
                    <i class="bi bi-chevron-right"></i>
                <?php endif; ?>

                <?= htmlspecialchars($cat_name) ?>
            </div>

            <h2><?= htmlspecialchars($cat_name) ?></h2>
        </div>
        <div class="row">
            <div class="col-6">
                <?php if (!empty($_GET['error'])): ?>
                    <p style="color:red;"><?= htmlspecialchars($_GET['error']) ?></p>
                <?php endif; ?>

                <form action="get/login_check.php" method="POST">
                    <label>Email:</label><br>
                    <input type="email" name="email" required><br><br>

                    <label>Password:</label><br>
                    <input type="password" name="password" required><br><br>

                    <button type="submit">Login</button>
                </form>
            </div>
        </div>
    </div>
</section>

<?php
include 'include/footer.php';
mysqli_close($conn);
?>