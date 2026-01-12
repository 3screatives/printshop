<?php
session_start();
$cart = $_SESSION['cart'] ?? [];
if (!$cart) {
    echo "<p>Your cart is empty.</p>";
} else {
    echo "<ul class='list-group'>";
    foreach ($cart as $item) {
        echo "<li class='list-group-item'>
                {$item['quantity']} x Material #{$item['material_id']} - $" . number_format($item['total_price'], 2) . "
              </li>";
    }
    echo "</ul>";
}
