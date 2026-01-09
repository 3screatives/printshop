<?php
header('Content-Type: application/json');
include '../db_function.php';

$conn = db_connect();
$term = isset($_GET['term']) ? trim($_GET['term']) : '';

if ($term === '') {
    echo json_encode([]);
    exit;
}

$sql = "SELECT client_id, business_name, business_address, contact_name, contact_phone, contact_email, client_stma_id, tax_exempt, is_employee 
        FROM ps_clients 
        WHERE business_name LIKE CONCAT('%', ?, '%') 
           OR contact_name LIKE CONCAT('%', ?, '%')
           OR client_stma_id LIKE CONCAT('%', ?, '%')
        LIMIT 10";

// Bind all three placeholders
$results = select_query($conn, $sql, "sss", $term, $term, $term);

echo json_encode($results);
