<?php
header('Content-Type: application/json');
include('../db_function.php'); // your DB connection file
$conn = db_connect();

// Read raw POST JSON
$data = json_decode(file_get_contents('php://input'), true);
$action = $data['action'] ?? '';
$order_id = intval($data['order_id'] ?? 0);

if ($action === 'delete') {
    if ($order_id <= 0) {
        echo json_encode(['status' => 'error', 'message' => 'Invalid order ID.']);
        exit;
    }

    // Delete order items first
    $stmt = mysqli_prepare($conn, "DELETE FROM ps_order_items WHERE order_id = ?");
    mysqli_stmt_bind_param($stmt, "i", $order_id);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);

    // Delete order itself
    $stmt = mysqli_prepare($conn, "DELETE FROM ps_orders WHERE order_id = ?");
    mysqli_stmt_bind_param($stmt, "i", $order_id);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);

    echo json_encode(['status' => 'success', 'message' => 'Order deleted successfully!']);
    mysqli_close($conn);
    exit;
}
