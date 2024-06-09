<?php
global $link;
session_start();
//$currentpage="View Employees";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Company DB</title>
    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">

    <!-- jQuery library -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

    <!-- Latest compiled JavaScript -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>

    <style type="text/css">
        .wrapper{
            width: 70%;
            margin:0 auto;
        }
        table tr td:last-child a{
            margin-right: 15px;
        }
    </style>
    <script type="text/javascript">
        $(document).ready(function(){
            $('[data-toggle="tooltip"]').tooltip();
        });
        $('.selectpicker').selectpicker();
    </script>
</head>
<body>
<?php
// Include config file
require_once "config.php";
//		include "header.php";
?>
<div class="wrapper">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="page-header clearfix">
                    <h2> Final Project CS 340 </h2>
                    <h3> by Brayden Edwards, Anthony Ly, and Ben Sihavong </h3>
                    <p> Project should include CRUD operations. In this website you can:
                    <ol> 	<li> CREATE new users and recipes </li>
                        <li> RETRIEVE ratings and users for recipes </li>
                        <li> UPDATE </li>
                        <li> DELETE  </li>
                    </ol>
                    <div class = "button-group">
                        <a href="login.php" class="btn btn-success">Login</a>
                        <a href="createUsers.php" class="btn btn-success">Create Account</a>
                        <a href="createRating.php" class="btn btn-success">Add New Rating</a>
                        <a href="viewUsers.php" class="btn btn-success">View Our Current Users</a>
                    </div>
                    <h2 class="pull-left">Recipes</h2>
                </div>
                <?php
                // Include config file
                require_once "config.php";

                // Attempt select all employee query execution
                // *****
                // Insert your function for Salary Level
                /*
                    $sql = "SELECT Ssn,Fname,Lname,Salary, Address, Bdate, PayLevel(Ssn) as Level, Super_ssn, Dno
                        FROM EMPLOYEE";
                */
                $sql = "SELECT `recipe name` as 'Recipe Name', `Cook time`, `member id` as 'Created By', `serving size` as 'Serving Size' FROM recipe";
                if($result = mysqli_query($link, $sql)) {
                    if (mysqli_num_rows($result) > 0) {
                        echo "<table class='table table-bordered table-striped'>";
                        echo "<thead>";
                        echo "<tr>";
                        echo "<th width=8%>Recipe Name</th>";
                        echo "<th width=10%>Cook time</th>";
                        echo "<th width=10%>Created By</th>";
                        echo "<th width=10%>Serving Size</th>";
                        echo "</tr>";
                        echo "</thead>";
                        echo "<tbody>";
                        while ($row = mysqli_fetch_array($result)) {
                            echo "<tr>";
                            echo "<td>" . $row['Recipe Name'] . "</td>";
                            echo "<td>" . $row['Cook time'] . "</td>";
                            echo "<td>" . $row['Created By'] . "</td>";
                            echo "<td>" . $row['Serving Size'] . "</td>";
                            echo "</td>";
                            echo "</tr>";
                        }
                        echo "</tbody>";
                        echo "</table>";
                        // Free result set
                        mysqli_free_result($result);
                    } else {
                        echo "<p class='lead'><em>No records were found.</em></p>";
                    }
                } else {
                    echo "ERROR: could not execute $sql. <br>" . mysqli_error($link);
                }
                          /* Creating a sub database */
                echo "<br><h2> Here are some of our most used ingredients!</h2><br>";

                $sql2 = "SELECT c.`ingredient name` as 'Ingredient', COUNT(*) as 'Number of Recipes with this ingredient' 
                    FROM contains c
                    GROUP BY c.`ingredient name`
                    ORDER BY `Number of Recipes with this ingredient` DESC
                    LIMIT 3";
                if($result2 = mysqli_query($link, $sql2)) {
                    if (mysqli_num_rows($result2) > 0) {
                        echo "<div class='col-md-4'>";
                            echo "<table width=30% class='table table-bordered table-striped'>";
                                echo "<thead>";
                                    echo "<tr>";
                                        echo "<th width=20%>Ingredient</th>";
                                        echo "<th width = 20%>Number of Recipes with this ingredient</th>";
                                echo "</thead>";
                                echo "<tbody>";
                                while ($row = mysqli_fetch_array($result2)) {
                                    echo "<tr>";
                                        echo "<td>" . $row['Ingredient'] . "</td>";
                                        echo "<td>" . $row['Number of Recipes with this ingredient'] . "</td>";
                                    echo "</tr>";
                                }
                                echo "</tbody>";
                            echo "</table>";
                            mysqli_free_result($result2);
                        } else {
                            echo "<p class='lead'><em>No records were found for Ingredient amount.</em></p>";
                        }
                    } else {
                    echo "<p class='lead'><em>No records were found for ingredient amounts.<em></p>";
                }
                // Close connection
                mysqli_close($link);
                ?>
            </div>

</body>
</html>
