<?php
session_start();
// If already logged in, redirect
if (isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>

    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@700&display=swap" rel="stylesheet" />
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;500;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.2/css/bootstrap.min.css" />
    <link href="../../css/main.css" rel="stylesheet" rel="preload" as="style" />
</head>

<body>

    <div class="login-page">

        <div class="login-box text-center">
            <h5 class="text-uppercase mb-4">Dashboard Login</h5>
            <?php
            if (!empty($_GET['error'])):
            ?>
                <p style="color:red;"><?= htmlspecialchars($_GET['error']) ?></p>
            <?php
            endif;
            ?>

            <form action="login_check.php" method="POST">
                <div class="form-group mb-2">
                    <label>Username/Email:</label><br>
                    <input class="form-control" type="email" name="email" required>
                </div>

                <div class="form-group mb-3">
                    <label>Password:</label><br>
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