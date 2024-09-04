<?php
session_start(); 

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    include "../config/db_conn.php";
    
    // Data
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Query to get the user based on email
    $sql = "SELECT * FROM $user_tbl WHERE email = '$email'";
    $result = mysqli_query($conn, $sql);

    if ($result && mysqli_num_rows($result) == 1) {
        // Fetch the row data
        $row = mysqli_fetch_assoc($result);
        


        // Verify the password with the hashed password in the database
        if (password_verify($password, $row['password'])) {
            $_SESSION['loggedin'] = true;
            $_SESSION['email'] = $email;
            $_SESSION['role'] = $row['role'];
            echo 'Login successful <a href="../index.php">Go to home</a> ';
        } else {
            echo "Invalid credentials 1";
        }
    } else {
        echo "Invalid credentials 2";
    }

    mysqli_close($conn); 
} else {
    echo "Invalid request method.";
}
?>
