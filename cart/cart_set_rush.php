<?php
session_start();

$rush = isset($_POST['process_time']) ? (int)$_POST['process_time'] : 0;

// Save rush selection globally for cart
$_SESSION['rush'] = $rush;

echo json_encode(['success' => true]);
