<?php
include 'db_function.php';
$conn = db_connect();

$search = isset($_GET['q']) ? mysqli_real_escape_string($conn, $_GET['q']) : '';
$sql = "SELECT client_id, client_name, client_address, client_phone, client_email, client_stma_id FROM ps_clients WHERE client_name LIKE ? LIMIT 10";

$stmt = mysqli_prepare($conn, $sql);
$param = "%$search%";
mysqli_stmt_bind_param($stmt, "s", $param);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);

$data = [];
while ($row = mysqli_fetch_assoc($result)) {
    $data[] = $row;
}
echo json_encode($data);
