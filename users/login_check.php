<?php
session_start();
require_once '../ps-admin/db_function.php';

$conn = db_connect();

$username = trim($_POST['email'] ?? '');
$password = trim($_POST['password'] ?? '');

if ($username === '' || $password === '') {
    header("Location: login.php?error=Missing credentials");
    exit;
}

// Fetch client by username
$client = select_query(
    $conn,
    "SELECT 
        client_id,
        contact_name,
        client_username,
        client_password,
        client_status
     FROM ps_clients
     WHERE client_username = ?
     LIMIT 1",
    "s",
    $username
);

if (count($client) !== 1) {
    header("Location: login.php?error=Client not found");
    exit;
}

$client = $client[0];

// ❌ Inactive client
if ((int)$client['client_status'] !== 1) {
    header("Location: login.php?error=Account inactive");
    exit;
}

// ⚠️ Plain-text password check (upgrade later)
if ($password !== $client['client_password']) {
    header("Location: login.php?error=Invalid password");
    exit;
}

// ✅ Client session
$_SESSION['client_id']          = $client['client_id'];
$_SESSION['contact_name']       = $client['contact_name'];
$_SESSION['client_username']    = $client['client_username'];
$_SESSION['client_user_type']   = 'client';

// Redirect
header("Location: dashboard.php");
exit;