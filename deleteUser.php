<?php
    session_start();
    require_once "config.php";

    if(!isset($_SESSION['id'])) {
        header("location: login.php");
    }

    $userid = $_SESSION['id'];
    $query = "DELETE FROM member WHERE `member id` = $userid;";
    mysqli_query($link, $query);
    session_destroy();
    header("location: index.php");
?>