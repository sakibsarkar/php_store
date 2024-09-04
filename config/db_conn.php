<?php

$server_name = "localhost";
    $user_name = "root";
    $password_db = ""; 
    $db_name = "e_commerce";
    $user_tbl = "user";
    $product_tbl = "products";

    // Connection
    $conn = mysqli_connect($server_name, $user_name, $password_db, $db_name);


    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }
?>