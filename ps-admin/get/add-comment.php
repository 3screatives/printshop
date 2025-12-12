<?php
require_once '../db_function.php';
header('Content-Type: application/json');

$conn = db_connect();

$order_id = intval($_POST['order_id'] ?? 0);
$comment = trim($_POST['comment'] ?? '');

if ($order_id <= 0 || $comment === '') {
    echo json_encode(['status' => 'error', 'message' => 'Invalid input']);
    exit;
}

$sql = "INSERT INTO ps_order_comments (order_id, comment_text, created_at) VALUES (?, ?, NOW())";
$stmt = mysqli_prepare($conn, $sql);
mysqli_stmt_bind_param($stmt, "is", $order_id, $comment);

if (mysqli_stmt_execute($stmt)) {
    $created_at = date('m/d/Y h:i A'); // Format timestamp for JS
    echo json_encode(['status' => 'success', 'created_at' => $created_at]);
} else {
    echo json_encode(['status' => 'error', 'message' => mysqli_stmt_error($stmt)]);
}

mysqli_stmt_close($stmt);
mysqli_close($conn);
