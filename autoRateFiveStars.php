<?php
session_start();
require_once "config.php";

$userid = $_SESSION['id'];
$RecipeName = isset($_GET['recipe_name']) ? urldecode($_GET['recipe_name']) : " ";
$Mid = $_SESSION['id'];
if(!empty($RecipeName)) {
    $query = "CALL AddOrUpdateRating('$RecipeName', '$userid', '5')";
    mysqli_query($link, $query);
}
header("location: index.php");
?>