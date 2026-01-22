<?php
session_start();

// If already logged in, redirect to appropriate dashboard
if (isset($_SESSION['user_id'])) {
    if ($_SESSION['user_type'] === 'client') {
        header("Location: dashboard.php");
        exit;
    } else {
        header("Location: ../ps-admin/index.php");
        exit;
    }
}

include '../include/head.php';
?>

<div class="login-page">
    <div class="login-box">

        <?php if (!empty($_GET['error'])): ?>
            <p style="color:red;"><?= htmlspecialchars($_GET['error']) ?></p>
        <?php endif; ?>

        <form action="/printshop/users/login_check.php" method="POST">
            <div class="form-group mb-2">
                <label>Email:</label>
                <input class="form-control" type="email" name="email" required>
            </div>

            <div class="form-group mb-3">
                <label>Password:</label>
                <input class="form-control" type="password" name="password" required>
            </div>

            <button class="thm-btn gray w-100" type="submit">
                <span>Login</span>
            </button>
        </form>
    </div>
</div>

</body>

</html>