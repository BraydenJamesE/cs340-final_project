<?php
    session_start();
    require_once "config.php";
    
    if(isset($_SESSION['id'])) {
        header("location: index.php");
    }

    if ($_SERVER ["REQUEST_METHOD"] == "POST") {
        $email = $_POST['email'];
        $password = $_POST['password'];
        
        $query = "SELECT * FROM member WHERE email = '$email' AND password = '$password'";
        $result = mysqli_query($link, $query);
        $num_row = mysqli_num_rows($result);

        if ($num_row == 1) {
            $query2 = "SELECT `member id` FROM member WHERE email = '$email' AND password = '$password'";
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
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    </head>
    <body>
    <div class="container">
        <h1>Login</h1>
        <div>
            <a href="index.php" class="btn btn-success">Home</a>
        </div>
        <p></p>
        <form method="post" action="login.php">
            <input type="text" name="email" required placeholder="Email">
            <input type="password" name="password" required placeholder="Password">
            <button type="submit">Login</button>
        </form>
    </div>
    </body>
</html>