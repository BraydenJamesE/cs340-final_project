<?php
session_start(); // starting the session
require_once "config.php";

$userid = $_SESSION['id']; // getting the user id
$RecipeName = isset($_GET['recipe_name']) ? urldecode($_GET['recipe_name']) : " "; // getting the recipe name from the url
if(!empty($RecipeName)) {
    $query = "CALL AddOrUpdateRating('$RecipeName', '$userid', '5')"; // calling our AddOrUpdateRating routine
    mysqli_query($link, $query); // calling the actual query in our database
}
header("location: index.php"); // redirecting the user back to the main page
?>