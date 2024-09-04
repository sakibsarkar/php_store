<?php
session_start();
include "../config/db_conn.php";

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    // If the user is not an admin, return an error
    echo json_encode(["success" => false, "message" => "Unauthorized"]);
    exit;
}

if (isset($_GET['_id'])) {
    $productId = mysqli_real_escape_string($conn, $_GET['_id']);
    
    // Query to delete the product
    $sql = "DELETE FROM `$product_tbl` WHERE `_id` = '$productId'";
    
    if (mysqli_query($conn, $sql)) {
        echo json_encode(["success" => true, "message" => "Product deleted successfully"]);
    } else {
        echo json_encode(["success" => false, "message" => "Error deleting product: " . mysqli_error($conn)]);
    }
} else {
    echo json_encode(["success" => false, "message" => "Product ID not provided"]);
}
?>
