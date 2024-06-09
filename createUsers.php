<?php
// Include config file
require_once "config.php";

$Uid = $Uname = $Uemail = $Upass = "";
$Uname_err = $Uemail_err = $Upass_err = "";

if($_SERVER["REQUEST_METHOD"] == "POST"){
    // Validate First name
    $Uname = trim($_POST["Uname"]);
    if(empty($Uname)){
        $Uname_err = "Please enter your name.";
    } elseif(!filter_var($Uname, FILTER_VALIDATE_REGEXP, array("options"=>array("regexp"=>"/^[a-zA-Z\s]+$/")))){
        $Uname_err = "Please enter a valid Uname.";
    } 
    // Validate Last name
    $Uemail = trim($_POST["Uemail"]);
    if(empty($Uemail)){
        $Uemail_err = "Please enter an email.";
    } elseif(!filter_var($Uemail, FILTER_VALIDATE_EMAIL)){
        $Uemail_err = "Please enter a valid email.";
    } 

	// Validate Uemail
    $Upass = trim($_POST["Upass"]);
    if(empty($Upass)){
        $Upass_err = "Please enter a password.";     
    }

    // Check input errors before inserting in database
    if(empty($Ssn_err) && empty($Uemail_err) && empty($Upass_err) && empty($name_err)){
        // Prepare an insert statement
        $sql = "INSERT INTO EMPLOYEE (Ssn, Uname, Uemail, Upass) 
		        VALUES (?, ?, ?, ?)";
         
        if($stmt = mysqli_prepare($link, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "isssdssi", $param_Ssn, $param_Uname, $param_Uemail, 
				$param_Upass);
            
            // Set parameters
			$param_Ssn = $Ssn;
            $param_Uemail = $Uemail;
			$param_Uname = $Uname;
			$param_Upass = $Upass;
            
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                // Records created successfully. Redirect to landing page
				    header("location: index.php");
					exit();
            } else{
                echo "<center><h4>Error while creating new employee</h4></center>";
				$Ssn_err = "Enter a unique Ssn.";
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
                            <input type="text" name="Upass" class="form-control" value="<?php echo $Upass; ?>">
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