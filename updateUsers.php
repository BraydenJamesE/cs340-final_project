<?php
session_start();
require_once "config.php";

$memberName_err = $email_err = $password_err = $city_err = $state_err = $country_err = "";

if(!isset($_SESSION['id'])) {
    header("location: login.php");
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $memberId = $_SESSION['id'];
    $query = "SELECT m.`member name`, m.`email`, m.`password`, l.`city`, l.`state`, l.`country` 
              FROM `member` m 
              LEFT JOIN `location` l ON m.`member id` = l.`member id` 
              WHERE m.`member id` = $memberId;";
    $result = mysqli_query($link, $query);
    $row = mysqli_fetch_row($result);

    $memberName = trim($_POST['memberName']);
    if (empty($memberName)) {
        $memberName = $row[0];
    } elseif (!preg_match("/^[a-zA-Z\s]+$/", $memberName)) {
        $memberName_err = "Please enter a valid name.";
    }

    $email = trim($_POST['email']);
    if (empty($email)) {
        $email = $row[1];
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $email_err = "Please enter a valid email address.";
    }

    $password = trim($_POST['password']);
    if (empty($password)) {
        $password = $row[2];
    }

    $city = trim($_POST['city']);
    if (empty($city)) {
        $city = $row[3];
    }

    $state = trim($_POST['state']);
    if (empty($state)) {
        $state = $row[4];
    }

    $country = trim($_POST['country']);
    if (empty($country)) {
        $country = $row[5];
    }

    if (empty($memberName_err) && empty($email_err)) {
        $query = "UPDATE `member` SET `member name` = '$memberName', `email` = '$email', `password` = '$password' WHERE `member id` = $memberId;";
        mysqli_query($link, $query);
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Update Users</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <style type="text/css">
        .wrapper{
            width: 500px;
            margin: 0 auto;
        }
    </style>
</head>
<div class="wrapper">
        <div class="container-field">
            <div class="row">
                <div class="col-md-12">
                        <div class="page-header">
                            <h2>Update Users</h2>
                        </div>
                        <body>
                            <div>
                                <a href="index.php" class="btn btn-success">Home</a>
                            </div>
                            <?php
                            $memberId = $_SESSION['id'];
                            $query = "SELECT m.`member name`, m.`email`, m.`password`, l.`city`, l.`state`, l.`country` 
                                    FROM `member` m 
                                    LEFT JOIN `location` l ON m.`member id` = l.`member id` 
                                    WHERE m.`member id` = $memberId;";
                            $result = mysqli_query($link, $query);
                            $row = mysqli_fetch_row($result);
                            ?>
                            <form method="POST" action="updateUsers.php">
                                <div class="form-group">
                                    <label for="memberName">Member Name</label>
                                    <input type="text" name="memberName" class="form-control" placeholder="<?php echo htmlspecialchars($row[0], ENT_QUOTES, 'UTF-8'); ?>">
                                    <span class="text-danger"><?php echo $memberName_err; ?></span>
                                </div>
                                <div class="form-group">
                                    <label for="email">Email</label>
                                    <input type="text" name="email" class="form-control" placeholder="<?php echo htmlspecialchars($row[1], ENT_QUOTES, 'UTF-8'); ?>">
                                    <span class="text-danger"><?php echo $email_err; ?></span>
                                </div>
                                <div class="form-group">
                                    <label for="password">Password</label>
                                    <input type="text" name="password" class="form-control" placeholder="password">
                                </div>
                                <div class="form-group">
                                    <label for="city">City</label>
                                    <input type="text" name="city" class="form-control" placeholder="<?php echo htmlspecialchars($row[3], ENT_QUOTES, 'UTF-8'); ?>">
                                </div>
                                <div class="form-group">
                                    <label for="state">State</label>
                                    <input type="text" name="state" class="form-control" placeholder="<?php echo htmlspecialchars($row[4], ENT_QUOTES, 'UTF-8'); ?>">
                                </div>
                                <div class="form-group">
                                    <label for="country">Country</label>
                                    <input type="text" name="country" class="form-control" placeholder="<?php echo htmlspecialchars($row[5], ENT_QUOTES, 'UTF-8'); ?>">
                                </div>
                                <button type="submit" class="btn btn-primary">Update</button>
                            </form>
                        </body>
                    </div>
                </div>
            </div>
        </div>
    </div>
</html>
