<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get all form data
    $client_id = $_POST['c_client_id'] ?? '';
    $materials = $_POST['material'] ?? [];
    $details = $_POST['details'] ?? [];
    $qty = $_POST['qty'] ?? [];
    $price = $_POST['price'] ?? [];
    $status = $_POST['status'] ?? [];

    // Example: insert into DB (pseudo)
    // include 'db.php';
    // foreach($materials as $i => $m) {
    //     $sql = "INSERT INTO orders (client_id, material, details, qty, price, status) VALUES (...)";
    // }

    echo json_encode(['status' => 'ok', 'message' => 'Draft saved']);
}