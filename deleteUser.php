<?php
    session_start(); // Starting the session
    require_once "config.php";

    if(!isset($_SESSION['id'])) { // if the user is not logged
        header("location: login.php"); // return the user to the main page
    }

    $userid = $_SESSION['id']; // getting the user id
    $query = "DELETE FROM member WHERE `member id` = $userid;"; // deleting the user from the database (preparing the query)
    mysqli_query($link, $query); // sending the query
    session_destroy(); // destroying the session because they deleted their account
    header("location: index.php"); // sending the user back to the main page
?>