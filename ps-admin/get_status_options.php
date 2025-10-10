<?php
require_once 'db_function.php';
header("Content-Type: application/json");

$conn = db_connect();

$sql = "SELECT status_id, status_name FROM ps_status ORDER BY status_number ASC";
$data = select_query($conn, $sql);

echo json_encode($data);
