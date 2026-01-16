<?php
include '../db_function.php';
$conn = db_connect();

$categories = select_query($conn, "SELECT cat_id, cat_name FROM ps_categories ORDER BY cat_name ASC");

foreach ($categories as $cat) {
    echo "<option value='{$cat['cat_id']}'>{$cat['cat_name']}</option>";
}
