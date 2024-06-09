<?php
    require_once "config.php";
?>
<html>
    <head>
        <title>View Users</title>
        <link rel="stylesheet" type="text/css" href="style.css">
    </head>
    <body>
        <h1>Users</h1>
        <?php
            if($link === false){
                die("ERROR: Could not connect. " . mysqli_connect_error());
            }

            $query = "SELECT `member name` FROM member";
            $result = mysqli_query($link, $query);
            echo "<table id='t01'>";
            echo "<td><b>Member Name</b></td>";
            $num_row = mysqli_num_rows($result);
            for ($i = 0; $i < $num_row; $i++) {
                $row = mysqli_fetch_row($result);
                echo "<tr><td>$row[0]</td></tr>";
            }
        ?>
    </body>
</html>
