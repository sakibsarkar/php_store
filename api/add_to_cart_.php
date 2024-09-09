<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['_id'])) {
    $_id = $_POST['_id'];
    $quantity = $_POST['quantity'];

    // Initialize the cart if it doesn't exist
    if (!isset($_SESSION['cart'])) {
        $_SESSION['cart'] = [];
    }

    // If the product is already in the cart, update the quantity
    if (isset($_SESSION['cart'][$_id])) {
        $_SESSION['cart'][$_id] += $quantity;
    } else {
        $_SESSION['cart'][$_id] = $quantity;
    }
}

// Redirect back to the products page
header('Location: ../products.php');
exit();
?>
