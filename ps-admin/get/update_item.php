<?php
header('Content-Type: application/json');
include('../db_function.php');
$conn = db_connect();

$item_id = intval($_POST['item_id'] ?? 0);
$item_is_design = intval($_POST['item_is_design'] ?? 0);
$item_is_printed = intval($_POST['item_is_printed'] ?? 0);

if ($item_id > 0) {
    $sql = "UPDATE ps_order_items SET item_is_design=?, item_is_printed=? WHERE item_id=?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "iii", $item_is_design, $item_is_printed, $item_id);
    if (mysqli_stmt_execute($stmt)) {
        echo json_encode(['status' => 'success']);
    } else {
        echo json_encode(['status' => 'error', 'message' => mysqli_stmt_error($stmt)]);
    }
    mysqli_stmt_close($stmt);
} else {
    echo json_encode(['status' => 'error', 'message' => 'Invalid item ID']);
}

mysqli_close($conn);
