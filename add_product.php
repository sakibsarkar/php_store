<?php
    session_start();

    // Check if the user is logged in
    if (!isset($_SESSION['loggedin']) || !$_SESSION['loggedin']) {
        echo 'Login requred <a href="login.php">Login now</a> ';

        exit;
    }

    // Check if the role is set and if the user is an admin
    if (!isset($_SESSION["role"]) || $_SESSION["role"] != 'admin') {
        echo 'Forbidden access';
        exit;
    }
?>

<!DOCTYPE html>
<html>
<head>
    <title>Add Product</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.4.1/dist/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
</head>
<body><script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.4.1/dist/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
    <?php require "components/navbar.php" ?>

    <h2>Add Product</h2>
    <form action="api/add_product_.php" method="POST">
        <label for="name">Product Name:</label>
        <input type="text" id="name" name="name" required><br><br>
        
        <label for="price">Product Price:</label>
        <input type="text" id="price" name="price" required><br><br>
        
        <label for="description">Product Description:</label>
        <textarea id="description" name="description" required></textarea><br><br>
        
        <input type="submit" value="Add Product">
    </form>
</body>
</html>
