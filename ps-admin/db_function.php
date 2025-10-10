<?php
// Connection Function
function db_connect() {
    $conn = mysqli_connect("localhost", "root", "", "invoice_new");
    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }
    return $conn;
}

// INSERT / UPDATE / DELETE Function (All use same logic)
function execute_query($conn, $sql, $types, ...$params) {
    $stmt = mysqli_prepare($conn, $sql);
    if (!$stmt) {
        die("Prepare failed: " . mysqli_error($conn));
    }

    if (!empty($types)) {
        mysqli_stmt_bind_param($stmt, $types, ...$params);
    }

    $success = mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
    return $success;
}

// SELECT Function (with optional parameters)
function select_query($conn, $sql, $types = "", ...$params) {
    $stmt = mysqli_prepare($conn, $sql);
    if (!$stmt) {
        die("Prepare failed: " . mysqli_error($conn));
    }

    if (!empty($types)) {
        mysqli_stmt_bind_param($stmt, $types, ...$params);
    }

    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $data = [];

    while ($row = mysqli_fetch_assoc($result)) {
        $data[] = $row;
    }

    mysqli_stmt_close($stmt);
    return $data;
}