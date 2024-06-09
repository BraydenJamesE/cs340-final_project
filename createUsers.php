<?php
// Include config file
require_once "config.php";

$Uid = $Uname = $Uemail = $Upass = null;
$Uid_err = $Uname_err = $Uemail_err = $Upass_err = "";

// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){
    $Uid = trim($_POST["Uid"]);
    if(empty($Uid)){
        $Uid_err = "Please enter a member Id.";
    } elseif(!ctype_digit($Uid)){
        $Uid_err = "Please enter a valid name.";
    } 

    // Validate Name
    $Uname = trim($_POST["Uname"]);
    if(empty($Uname)){
        $Uname_err = "Please enter your name.";
    } elseif(!preg_match("/^[a-zA-Z\s]+$/", $Uname)){
        $Uname_err = "Please enter a valid name.";
    } 

    // Validate Email
    $Uemail = trim($_POST["Uemail"]);
    if(empty($Uemail)){
        $Uemail_err = "Please enter an email.";
    } elseif(!filter_var($Uemail, FILTER_VALIDATE_EMAIL)){
        $Uemail_err = "Please enter a valid email address.";
    }

    // Validate Password
    $Upass = trim($_POST["Upass"]);
    if(empty($Upass)){
        $Upass_err = "Please enter a password.";     
    }

    // Check input errors before inserting in database
    if(empty($Uname_err) && empty($Uemail_err) && empty($Upass_err)){
        // Prepare an insert statement
        $sql = "INSERT INTO member (`member id`, `member name`, `email`, `password`) VALUES (?, ?, ?, ?)";
         
        if($stmt = mysqli_prepare($link, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "isss", $param_Uid, $param_Uname, $param_Uemail, $param_Upass);
            
            // Set parameters
            $param_Uid = $Uid;
            $param_Uname = $Uname;
            $param_Uemail = $Uemail;
            $param_Upass = password_hash($Upass, PASSWORD_DEFAULT); // Creates a password hash



            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                // Records created successfully. Redirect to landing page
                header("location: index.php");
                exit();
            } else{
                echo "<center><h4>Error while creating new user</h4></center>";
            }
        }
         
        // Close statement
        mysqli_stmt_close($stmt);
    }

    // Close connection
    mysqli_close($link);
}
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
                        <div class="form-group <?php echo (!empty($Uid_err)) ? 'has-error' : ''; ?>">
                            <label>ID</label>
                            <input type="text" name="Uid" class="form-control" value="<?php echo $Uid; ?>">
                            <span class="help-block"><?php echo $Uid_err;?></span>
                        </div>
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
                        <input type="submit" class="btn btn-primary" value="Register">
                        <a href="index.php" class="btn btn-default">Cancel</a>
                    </form>
                </div>
            </div>        
        </div>
    </div>
</body>
</html>
