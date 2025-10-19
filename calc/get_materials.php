<?php
require_once '../ps-admin/get/db_function.php';
header('Content-Type: text/html; charset=UTF-8');

$conn = db_connect();

$sql = "SELECT mat_id, mat_name FROM ps_materials ORDER BY mat_name";
$materials = select_query($conn, $sql);

if (empty($materials)) {
    echo "<option value=''>No materials found</option>";
    exit;
}

foreach ($materials as $row) {
    echo "<option value='{$row['mat_id']}'>{$row['mat_name']}</option>";
}
