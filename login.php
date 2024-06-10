<?php
    session_start();
    require_once "config.php";
    
    if ($_SERVER ["REQUEST_METHOD"] == "POST") {
        $username = $_POST['username'];
        $password = $_POST['password'];
        
        $query = "SELECT * FROM member WHERE email = '$username' AND password = '$password'";
        $result = mysqli_query($link, $query);
        $num_row = mysqli_num_rows($result);

        if ($num_row == 1) {
            $query2 = "SELECT `member id` FROM member WHERE email = '$username' AND password = '$password'";
            $result2 = mysqli_query($link, $query2);
            $row = mysqli_fetch_row($result2);
            $_SESSION['id'] = $row[0];
            header("location: index.php");
        } else {
            echo "Login failed";
        }
    }
?>
<html>
    <head>
        <title>Login</title>
        <link rel="stylesheet" type="text/css" href="style.css">
    </head>
    <body>
        <div>
            <a href="index.php">Home</a>
        </div>
        <form method="post" action="login.php">
            <input type="text" name="username" required placeholder="Username">
            <input type="password" name="password" required placeholder="Password">
            <button type="submit">Login</button>
        </form>
    </body>
</html>