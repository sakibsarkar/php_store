<?php
session_start(); // Start the session

// Check if the user is logged in
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    // Redirect to login page if not logged in
    header("Location: ../login.php");
    exit();
}

// Handle logout action
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['logout'])) {
    // Unset session variables
    unset($_SESSION['loggedin']);
    unset($_SESSION['email']);
    unset($_SESSION['role']);

    // Destroy the session
    session_destroy();

    // Redirect to the login page after logout
    header("Location: ../login.php");
    exit();
}
?>