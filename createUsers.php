<?php
require_once "config.php";

$Uname = $Uemail = $Upass = $City = $State = $Country = null;
$Uname_err = $Uemail_err = $Upass_err = $City_err = $State_err = $Country_err = "";

if($_SERVER["REQUEST_METHOD"] == "POST"){

    $Uname = trim($_POST["Uname"]);
    if(empty($Uname)){
        $Uname_err = "Please enter your name.";
    } elseif(!preg_match("/^[a-zA-Z\s]+$/", $Uname)){
        $Uname_err = "Please enter a valid name.";
    } 

    $Uemail = trim($_POST["Uemail"]);
    if(empty($Uemail)){
        $Uemail_err = "Please enter an email.";
    } elseif(!filter_var($Uemail, FILTER_VALIDATE_EMAIL)){
        $Uemail_err = "Please enter a valid email address.";
    } else {
        $checkEmailQuery = "SELECT CheckEmail('$Uemail') AS message";
        $result = mysqli_query($link, $checkEmailQuery);
        if ($result) {
            $row = mysqli_fetch_assoc($result);
            $message = $row['message'];
            if (!empty($message)) {
                $Uemail_err = $message;
            }
        }
    }

    $Upass = trim($_POST["Upass"]);
    if(empty($Upass)){
        $Upass_err = "Please enter a password.";     
    }

    $City = trim($_POST["City"]);

    $State = trim($_POST["State"]);

    $Country = trim($_POST["Country"]);

    if(empty($Uid_err) && empty($Uname_err) && empty($Uemail_err) && empty($Upass_err) && empty($City_err) && empty($State_err) && empty($Country_err)){
        $sql = "INSERT INTO member (`member name`, `email`, `password`) VALUES (?, ?, ?)";
         
        if($stmt = mysqli_prepare($link, $sql)){
            mysqli_stmt_bind_param($stmt, "sss", $param_Uname, $param_Uemail, $param_Upass);
            
            $param_Uname = $Uname;
            $param_Uemail = $Uemail;
            $param_Upass = $Upass;



            if(mysqli_stmt_execute($stmt)){

                $mem_id = mysqli_insert_id($link);

                $sql_location = "INSERT INTO location (`member id`, `city`, `state`, `country`) VALUES (?, ?, ?, ?)";
                if($stmt_location = mysqli_prepare($link, $sql_location)){
                    mysqli_stmt_bind_param($stmt_location, "isss", $param_Uid, $param_City, $param_State, $param_Country);


                    $param_Uid = $mem_id;
                    $param_City = $City;
                    $param_State = $State;
                    $param_Country = $Country;
                    mysqli_stmt_execute($stmt_location);
                    }
                }

                mysqli_stmt_close($stmt_location);

                header("location: index.php");
                exit();
            } else{
                echo "<center><h4>Error while creating new user</h4></center>";
            }
            mysqli_stmt_close($stmt);
        }
         
    }

    mysqli_close($link);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Create Record</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.css">
    <style type="text/css">
        .wrapper{
            width: 500px;
            margin: 0 auto;
        }
    </style>
</head>
<body>
    <div class="wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="page-header">
                        <h2>Create User</h2>
                    </div>
                    <p>Please fill this form and confirm to create a user.</p>
                    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                        <div class="form-group <?php echo (!empty($Uname_err)) ? 'has-error' : ''; ?>">
                            <label>Name</label>
                            <input type="text" name="Uname" class="form-control" value="<?php echo $Uname; ?>">
                            <span class="help-block"><?php echo $Uname_err;?></span>
                        </div>
                        <div class="form-group <?php echo (!empty($Uemail_err)) ? 'has-error' : ''; ?>">
                            <label>Email</label>
                            <input type="text" name="Uemail" class="form-control" value="<?php echo $Uemail; ?>">
                            <span class="help-block"><?php echo $Uemail_err;?></span>
                        </div>
                        <div class="form-group <?php echo (!empty($Upass_err)) ? 'has-error' : ''; ?>">
                            <label>Password</label>
                            <input type="password" name="Upass" class="form-control" value="<?php echo $Upass; ?>">
                            <span class="help-block"><?php echo $Upass_err;?></span>
                        </div>
                        <div class="form-group <?php echo (!empty($City_err)) ? 'has-error' : ''; ?>">
                            <label>City</label>
                            <input type="text" name="City" class="form-control" value="<?php echo $City; ?>">
                            <span class="help-block"><?php echo $City_err;?></span>
                        </div>
                        <div class="form-group <?php echo (!empty($State_err)) ? 'has-error' : ''; ?>">
                            <label>State</label>
                            <input type="text" name="State" class="form-control" value="<?php echo $State; ?>">
                            <span class="help-block"><?php echo $State_err;?></span>
                        </div>
                        <div class="form-group <?php echo (!empty($Country_err)) ? 'has-error' : ''; ?>">
                            <label>Country</label>
                            <input type="text" name="Country" class="form-control" value="<?php echo $Country; ?>">
                            <span class="help-block"><?php echo $Country_err;?></span>
                        </div>
                        <input type="submit" class="btn btn-primary" value="Register">
                        <a href="index.php" class="btn btn-default">Cancel</a>
                    </form>
                </div>
            </div>        
        </div>
    </div>
</body>
</html>
