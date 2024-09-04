<?php


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    include "../config/db_conn.php";

 
    
    $name = $_POST['name'];
    $description = $_POST['description'];
    $price = $_POST['price'];

  
    $sql = "INSERT INTO `$product_tbl` (`name`, `description`, `price`) VALUES ('$name', '$description', '$price')";
    mysqli_query($conn,$sql);
    
    
    header('Location: ../add_product.php');
    exit();

}



?>