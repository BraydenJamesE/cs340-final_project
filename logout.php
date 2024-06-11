<?php
    session_start();
    // Check if user is logged in
    if(!isset($_SESSION['id'])) {
        header("location: index.php");
    }
    // Destroy the session and redirect to the login page
    session_destroy();
    header("location: index.php");
?>