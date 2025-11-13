<?php
include '../db_function.php';
$conn = db_connect();

$action = $_POST['action'] ?? '';

if ($action == 'save') {
    $mat_id = $_POST['mat_id'] ?? '';
    $mat_vendor = $_POST['mat_vendor'] ?? '';
    $mat_name = $_POST['mat_name'] ?? '';
    $mat_details = $_POST['mat_details'] ?? '';
    $mat_roll_size = $_POST['mat_roll_size'] ?? '';
    $mat_length = $_POST['mat_length'] ?? '';
    $mat_size = $_POST['mat_size'] ?? '';
    $mat_cost = $_POST['mat_cost'] ?? '';
    $ink_cost = $_POST['ink_cost'] ?? '';
    $mat_added_on = date('Y-m-d H:i:s');
    $cat_id = $_POST['cat_id'] ?? '';

    if (empty($mat_id)) {
        // Insert new material
        $sql = "INSERT INTO ps_materials 
        (mat_vendor, mat_name, mat_details, mat_roll_size, mat_length, mat_size, mat_cost, ink_cost, mat_added_on, cat_id) 
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $success = execute_query(
            $conn,
            $sql,
            "ssssssddsi",
            $mat_vendor,
            $mat_name,
            $mat_details,
            $mat_roll_size,
            $mat_length,
            $mat_size,
            $mat_cost,
            $ink_cost,
            $mat_added_on,
            $cat_id
        );
        echo $success ? "Material added successfully!" : "Error adding material.";
    } else {
        // Update existing material
        $sql = "UPDATE ps_materials 
                SET mat_vendor=?, mat_name=?, mat_details=?, mat_roll_size=?, mat_length=?, mat_size=?, mat_cost=?, ink_cost=?, cat_id=? 
                WHERE mat_id=?";
        $success = execute_query(
            $conn,
            $sql,
            "ssssssddii",
            $mat_vendor,
            $mat_name,
            $mat_details,
            $mat_roll_size,
            $mat_length,
            $mat_size,
            $mat_cost,
            $ink_cost,
            $cat_id,
            $mat_id
        );
        echo $success ? "Material updated successfully!" : "Error updating material.";
    }
} elseif ($action == 'fetch') {
    $materials = select_query($conn, "SELECT * FROM ps_materials ORDER BY mat_id DESC");
    if ($materials) {
        foreach ($materials as $row) {
            echo "<tr>
                <td>{$row['mat_id']}</td>
                <td>{$row['mat_vendor']}</td>
                <td>{$row['mat_name']}</td>
                <td>{$row['mat_details']}</td>
                <td>{$row['mat_roll_size']}</td>
                <td>{$row['mat_length']}</td>
                <td>{$row['mat_size']}</td>
                <td>\${$row['mat_cost']}</td>
                <td>\${$row['ink_cost']}</td>
                <td>{$row['cat_id']}</td>
                <td>" . (!empty($row['mat_added_on']) ? date('M d, Y', strtotime($row['mat_added_on'])) : '-') . "</td>
                <td>
                    <button class='btn btn-outline-primary btn-sm me-2 editMaterial' data-id='{$row['mat_id']}'>
                        <span class='bi bi-pencil'></span>
                    </button>
                    <button class='btn btn-outline-danger btn-sm deleteMaterial' data-id='{$row['mat_id']}'>
                        <span class='bi bi-trash'></span>
                    </button>
                </td>
            </tr>";
        }
    } else {
        echo "<tr><td colspan='12' class='text-center'>No materials found</td></tr>";
    }
} elseif ($action == 'get') {
    $mat_id = $_POST['mat_id'];
    $result = select_query($conn, "SELECT * FROM ps_materials WHERE mat_id=?", "i", $mat_id);
    echo json_encode($result[0] ?? []);
} elseif ($action == 'delete') {
    $mat_id = $_POST['mat_id'];
    $success = execute_query($conn, "DELETE FROM ps_materials WHERE mat_id=?", "i", $mat_id);
    echo $success ? "Material deleted successfully!" : "Error deleting material.";
}

mysqli_close($conn);
