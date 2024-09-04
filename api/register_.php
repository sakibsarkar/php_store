<?php

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    include "../config/db_conn.php";

    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $role = $_POST['role'];

    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    $user_query = "INSERT INTO `$user_tbl` (`name`, `role`, `email`, `password`) VALUES ('$name', '$role', '$email', '$hashed_password')";
    mysqli_query($conn, $user_query);

    header('Location: ../register.php');
    exit();
}

?>
