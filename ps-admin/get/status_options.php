<?php
header('Content-Type: application/json');
require_once '../db_function.php';

$conn = db_connect();
$sql = "SELECT status_id, status_name FROM ps_status ORDER BY status_id ASC";
$data = select_query($conn, $sql);

echo json_encode($data);
mysqli_close($conn);
