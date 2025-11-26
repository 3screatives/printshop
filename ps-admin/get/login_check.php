<?php
session_start();
include '../db_function.php';

$conn = db_connect();

$email = $_POST['email'] ?? '';
$password = $_POST['password'] ?? '';

// Query user
$sql = "SELECT user_id, user_name, user_email, user_password, user_type 
        FROM ps_users 
        WHERE user_email = ? 
        LIMIT 1";

$result = select_query($conn, $sql, "s", $email);

if (count($result) == 1) {

    $user = $result[0];

    // For now comparing plain text since your DB is plain text
    if ($password === $user['user_password']) {

        // Set login session
        $_SESSION['user_id'] = $user['user_id'];
        $_SESSION['user_name'] = $user['user_name'];
        $_SESSION['user_type'] = $user['user_type'];

        header("Location: ../index.php");
        exit;
    } else {
        header("Location: ../login.php?error=Invalid password");
        exit;
    }
} else {
    header("Location: ../login.php?error=User not found");
    exit;
}
