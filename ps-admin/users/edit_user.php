<?php
include 'auth_check.php';
include '../db_function.php';
$conn = db_connect();
$id = $_GET['id'];
$user = select_query($conn, "SELECT * FROM ps_users WHERE user_id = ?", "i", $id)[0];


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['user_name'];
    $email = $_POST['user_email'];
    $type = $_POST['user_type'];


    $sql = "UPDATE ps_users SET user_name=?, user_email=?, user_type=? WHERE user_id=?";
    execute_query($conn, $sql, "sssi", $name, $email, $type, $id);


    header('Location: manage_users.php');
    exit();
}
?>
<!DOCTYPE html>
<html>

<body>
    <h2>Edit User</h2>
    <form method="post">
        <input type="text" name="user_name" value="<?= $user['user_name'] ?>" required><br>
        <input type="email" name="user_email" value="<?= $user['user_email'] ?>" required><br>
        <select name="user_type" required>
            <option value="manager" <?= $user['user_type'] == 'manager' ? 'selected' : '' ?>>Manager</option>
            <option value="viewer" <?= $user['user_type'] == 'viewer' ? 'selected' : '' ?>>Viewer</option>
        </select><br>
        <button type="submit">Save Changes</button>
    </form>
</body>

</html>