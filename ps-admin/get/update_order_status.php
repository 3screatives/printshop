<?php
// header('Content-Type: application/json');
// require_once '../db_function.php';

// if (!isset($_POST['order_id'], $_POST['status_id'])) {
//     echo json_encode(['success' => false, 'error' => 'Missing parameters']);
//     exit;
// }

// $conn = db_connect();

// $order_id = intval($_POST['order_id']);
// $status_id = intval($_POST['status_id']);

// if($status_id === 9) {

// }

// $sql = "UPDATE ps_orders SET status_id = ? WHERE order_id = ?";
// $success = execute_query($conn, $sql, "ii", $status_id, $order_id);

// echo json_encode(['success' => $success]);

// mysqli_close($conn);

header('Content-Type: application/json');
require_once '../db_function.php';

if (!isset($_POST['order_id'], $_POST['status_id'])) {
    echo json_encode(['success' => false, 'error' => 'Missing parameters']);
    exit;
}

$conn = db_connect();

$order_id  = (int) $_POST['order_id'];
$status_id = (int) $_POST['status_id'];

if ($status_id === 9) {
    // Mark order as completed with current timestamp
    $sql = "
        UPDATE ps_orders 
        SET status_id = ?, 
            order_completed = NOW()
        WHERE order_id = ?
    ";
    $success = execute_query($conn, $sql, "ii", $status_id, $order_id);
} else {
    // Normal status update
    $sql = "
        UPDATE ps_orders 
        SET status_id = ?
        WHERE order_id = ?
    ";
    $success = execute_query($conn, $sql, "ii", $status_id, $order_id);
}

echo json_encode(['success' => $success]);
mysqli_close($conn);