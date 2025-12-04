<?php
include 'auth_check.php';
include '../db_function.php';
$conn = db_connect();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['user_name'];
    $email = $_POST['user_email'];
    $password = password_hash($_POST['user_password'], PASSWORD_DEFAULT);
    $type = $_POST['user_type'];

    $sql = "INSERT INTO ps_users (user_name, user_email, user_password, user_type, user_creation_date) VALUES (?, ?, ?, ?, CURDATE())";
    execute_query($conn, $sql, "ssss", $name, $email, $password, $type);

    header('Location: manage_users.php');
    exit();
}
?>
<!DOCTYPE html>
<html>

<body>
    <h2>Add User</h2>
    <form method="post">
        <input type="text" name="user_name" placeholder="Name" required><br>
        <input type="email" name="user_email" placeholder="Email" required><br>
        <input type="password" name="user_password" placeholder="Password" required><br>
        <select name="user_type" required>
            <option value="manager">Manager</option>
            <option value="viewer">Viewer</option>
        </select><br>
        <button type="submit">Add User</button>
    </form>
</body>

</html>