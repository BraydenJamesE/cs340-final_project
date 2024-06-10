<?php
global $link;
session_start();
require_once "config.php";
$RecipeName = isset($_GET['recipe_name']) ? urldecode($_GET['recipe_name']) : " ";
?>
<html>
<head>
    <title>Additional Info</title>
    <link rel="stylesheet" type="text/css" href="style.css">
</head>
    <body>
        <h2>Ingredients</h2>
        <?php
            $query = "SELECT c.`ingredient name` AS 'Needed Ingredients'
                                FROM recipe r
                                INNER JOIN contains c ON c.`recipe name` = r.`recipe name`
                                WHERE r.`recipe name` = '$RecipeName'";
            $result = mysqli_query($link, $query);
            $num_row = mysqli_num_rows($result);
            echo "<table id='t01'>";
            while ($row = mysqli_fetch_row($result)) {
                echo "<tr><td>$row[0]</td></tr>";
            }
            echo "</table>";
        ?>
        <h2>Cookware</h2>
        <?php
        $query2 = "SELECT u.`cookware` AS 'Recommended Cookware' 
                                FROM recipe r
                                INNER JOIN uses u ON u.`recipe` = r.`recipe name`
                                WHERE r.`recipe name` = '$RecipeName'";
        $result2 = mysqli_query($link, $query2);
        $num_row1 = mysqli_num_rows($result2);
        echo "<table id='t02'>";
        while ($row = mysqli_fetch_row($result2)) {
            echo "<tr><td>$row[0]</td></tr>";
        }
        echo "</table>";
        ?>
    </body>
</html>