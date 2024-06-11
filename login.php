<?php
    session_start();
    require_once "config.php";
    
    // Check if user is logged in
    if(isset($_SESSION['id'])) {
        header("location: index.php");
    }

    // Process form data when form is submitted
    if ($_SERVER ["REQUEST_METHOD"] == "POST") {
        $email = $_POST['email'];
        $password = $_POST['password'];
        
        // Check if the email and password match a user in the database
        $query = "SELECT * FROM member WHERE email = '$email' AND password = '$password'";
        $result = mysqli_query($link, $query);
        $num_row = mysqli_num_rows($result);

        // If the email and password match a user, save the user's id in the session and redirect to the home page
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