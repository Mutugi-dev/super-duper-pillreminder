<?php
session_start(); // Start the session

// Check if a session is active
if (isset($_SESSION['user_id'])) {
    // Destroy the session to log out the user
    session_unset();  // Unset session variables
    session_destroy(); // Destroy the session itself
}

// Redirect to the login page
header('Location: login.php');
exit();
?>