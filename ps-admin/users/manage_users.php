<?php
include 'auth_check.php';
include '../db_function.php';
$conn = db_connect();
$users = select_query($conn, "SELECT * FROM ps_users", "");
?>
<!DOCTYPE html>
<html>

<body>
    <h2>User Management</h2>
    <a href="add_user.php">Add New User</a>
    <table border="1" cellpadding="8">
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Email</th>
            <th>Type</th>
            <th>Created</th>
            <th>Actions</th>
        </tr>
        <?php foreach ($users as $u): ?>
            <tr>
                <td><?= $u['user_id'] ?></td>
                <td><?= $u['user_name'] ?></td>
                <td><?= $u['user_email'] ?></td>
                <td><?= $u['user_type'] ?></td>
                <td><?= $u['user_creation_date'] ?></td>
                <td>
                    <a href="edit_user.php?id=<?= $u['user_id'] ?>">Edit</a> |
                    <a href="delete_user.php?id=<?= $u['user_id'] ?>" onclick="return confirm('Delete user?')">Delete</a>
                </td>
            </tr>
        <?php endforeach; ?>
    </table>
</body>

</html>