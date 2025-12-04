<?php
include 'auth_check.php';
include '../db_function.php';
$conn = db_connect();
$id = $_GET['id'];
execute_query($conn, "DELETE FROM ps_users WHERE user_id=?", "i", $id);
header('Location: manage_users.php');
exit();
