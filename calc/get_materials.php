<?php
require_once '../ps-admin/get/db_function.php';
header('Content-Type: application/json');

$conn = db_connect();

$sql = "SELECT mat_id, mat_name FROM ps_materials";
$result = mysqli_query($conn, $sql);

while ($row = mysqli_fetch_assoc($result)) {
    echo "<option value='" . $row['mat_id'] . "'>" . $row['mat_name'] . "</option>";
}