<?php
    session_start();
    require_once "config.php";
?>
<html>
    <head>
        <title>View Users</title>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    </head>
    <body>
        <h1>Users</h1>
        <div>
            <a href="index.php" class="btn btn-success">Home</a>
        </div>
        <?php
            $query = "SELECT m.`member name`, m.`email`, l.`city`, l.`state`, l.`country` FROM `member` m LEFT JOIN `location` l ON m.`member id` = l.`member id`;";
            $result = mysqli_query($link, $query);
            echo "<table class='table table-bordered table-striped''>";
            echo "<td><b>Member Name</b></td>";
            echo "<td><b>Email</b></td>";
            echo "<td><b>City</b></td>";
            echo "<td><b>State</b></td>";
            echo "<td><b>Country</b></td>";
            $num_row = mysqli_num_rows($result);
            for ($i = 0; $i < $num_row; $i++) {
                $row = mysqli_fetch_row($result);
                echo "<tr>";
                echo "<td>$row[0]</td>";
                echo "<td>$row[1]</td>";
                echo "<td>$row[2]</td>";
                echo "<td>$row[3]</td>";
                echo "<td>$row[4]</td>";
            }
            mysqli_free_result($result);
            mysqli_close($link);
        ?>
    </body>
</html>
