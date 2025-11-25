<?php
include '../db_function.php';
$conn = db_connect();

$action = $_POST['action'] ?? '';

if ($action == 'save') {
    $client_id = $_POST['n_client_id'];
    $business_name = $_POST['mbusiness_name'];
    $business_address = $_POST['mbusiness_address'];
    $contact_name = $_POST['contact_name'];
    $contact_phone = $_POST['contact_phone'];
    $contact_email = $_POST['contact_email'];
    $client_stma_id = $_POST['client_stma_id'];
    $tax_exempt_id = $_POST['tax_exempt_id']; // NEW
    $tax_exempt = (!empty($tax_exempt_id) && $tax_exempt_id != "0") ? 1 : 0;


    if (empty($client_id)) {
        $sql = "INSERT INTO ps_clients 
        (business_name, business_address, contact_name, contact_phone, contact_email, client_stma_id, tax_exempt, tax_exempt_id) 
        VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
        $success = execute_query(
            $conn,
            $sql,
            "sssssiis",   // <-- 8 params
            $business_name,
            $business_address,
            $contact_name,
            $contact_phone,
            $contact_email,
            $client_stma_id,
            $tax_exempt,
            $tax_exempt_id
        );
        echo $success ? "Client added successfully!" : "Error adding client.";
    } else {
        $sql = "UPDATE ps_clients 
        SET business_name=?, business_address=?, contact_name=?, contact_phone=?, contact_email=?, client_stma_id=?, tax_exempt=?, tax_exempt_id=? 
        WHERE client_id=?";
        $success = execute_query(
            $conn,
            $sql,
            "sssssiiii",   // <-- 9 params
            $business_name,
            $business_address,
            $contact_name,
            $contact_phone,
            $contact_email,
            $client_stma_id,
            $tax_exempt,
            $tax_exempt_id,
            $client_id
        );
        echo $success ? "Client updated successfully!" : "Error updating client.";
    }
} elseif ($action == 'fetch') {
    $clients = select_query($conn, "SELECT * FROM ps_clients ORDER BY client_id DESC");
    if ($clients) {
        foreach ($clients as $row) {
            echo "<tr>
                <td>{$row['client_id']}</td>
                <td>{$row['client_stma_id']}</td>
                <td>{$row['business_name']}</td>
                <td>{$row['business_address']}</td>
                <td>{$row['contact_name']}</td>
                <td>{$row['contact_phone']}</td>
                <td>{$row['contact_email']}</td>
                <td>{$row['tax_exempt_id']}</td> <!-- NEW COLUMN -->
                <td>" . (!empty($row['client_since']) ? date('M d, Y', strtotime($row['client_since'])) : '-') . "</td>
                <td>
                    <button class='btn btn-outline-primary btn-sm me-2 editClient' data-id='{$row['client_id']}'>
                        <span class='bi bi-pencil'></span>
                    </button>
                    <button class='btn btn-outline-danger btn-sm deleteClient' data-id='{$row['client_id']}'>
                        <span class='bi bi-trash'></span>
                    </button>
                </td>
            </tr>";
        }
    } else {
        echo "<tr><td colspan='10' class='text-center'>No clients found</td></tr>";
    }
} elseif ($action == 'get') {
    $client_id = $_POST['client_id'];
    $result = select_query($conn, "SELECT * FROM ps_clients WHERE client_id=?", "i", $client_id);
    echo json_encode($result[0] ?? []);
} elseif ($action == 'delete') {
    $client_id = $_POST['client_id'];
    $success = execute_query($conn, "DELETE FROM ps_clients WHERE client_id=?", "i", $client_id);
    echo $success ? "Client deleted successfully!" : "Error deleting client.";
}

mysqli_close($conn);
