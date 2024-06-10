<?php
// Retrieve the recipe name from the URL parameter

// Include config file
global $link;
require_once "config.php";

// Define variables and initialize with empty values
$RecipeName = $Mid = $Rating = "";

$RecipeName = isset($_GET['recipe_name']) ? urldecode($_GET['recipe_name']) : " ";

// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){
    // Validate First name
    $Mid = trim($_POST["Member Id"]);
    if(empty($Mid)){
        $Mid_err = "Please enter a your Member Id.";
    } elseif(!filter_var($Mid, FILTER_VALIDATE_REGEXP, array("options"=>array("regexp"=>"/^[a-zA-Z\s]+$/")))){
        $Mid_err = "Please enter a valid Member Id.";
    }
    // Validate Last name
    $Rating = trim($_POST["Rating"]);
    if(empty($Rating)){
        $Rating_err = "Please enter a your Rating.";
    } elseif(!filter_var($Mid, FILTER_VALIDATE_REGEXP, array("options"=>array("regexp"=>"/^[a-zA-Z\s]+$/")))){
        $Rating_err = "Please enter a your Rating.";
    }

    // Check input errors before inserting in database
    if(!empty($Mid) && !empty($Rating)) {
        // Prepare an insert statement
        $sql = "INSERT INTO Rates (`recipe name`, `member id`, `rating`) 
		        VALUES (?, ?, ?)";

        if($stmt = mysqli_prepare($link, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "isssdssi", $param_RecipeName, $param_MembId, $param_Rating);

            // Set parameters
            $param_RecipeName = $RecipeName;
            $param_MembId = $Mid;
            $param_Rating = $Rating;
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                // Records created successfully. Redirect to landing page
                header("location: index.php");
                exit();
            } else{
                echo "<center><h4>Error while entering rating</h4></center>";
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
    <title>Add Rating</title>
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
                    <h2>Create Record</h2>
                </div>
                <p>Please fill this form and submit to add an Employee record to the database.</p>
                <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>?recipe_name=<?php echo urlencode($RecipeName); ?>" method="post">
                    <div class="form-group">
                        <label>Recipe Name</label>
                        <input type="text" name="Recipe Name" class="form-control" value="<?php echo htmlspecialchars($RecipeName); ?>" disabled>
                    </div>
                    <div class="form-group">
                        <label>Member Id</label>
                        <input type="text" name="Member Id" class="form-control" value="<?php echo $Mid; ?>">
                        <span class="help-block"><?php echo $Mid_err;?></span>
                    </div>
                    <div class="form-group">
                        <label>Rating</label>
                        <select name="Rating" class="form-control">
                            <option value=""></option>
                            <option value="1" <?php if ($Rating == "1") echo "selected"; ?>>1</option>
                            <option value="2" <?php if ($Rating == "2") echo "selected"; ?>>2</option>
                            <option value="3" <?php if ($Rating == "3") echo "selected"; ?>>3</option>
                            <option value="4" <?php if ($Rating == "4") echo "selected"; ?>>4</option>
                            <option value="5" <?php if ($Rating == "5") echo "selected"; ?>>5</option>
                        </select>
                        <span class="help-block"><?php echo $Rating_err;?></span>
                    </div>
                    <input type="submit" class="btn btn-primary" value="Submit">
                    <a href="index.php" class="btn btn-default">Cancel</a>
                </form>
            </div>
        </div>
    </div>
</div>
</body>
</html>