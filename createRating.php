<?php
// Retrieve the recipe name from the URL parameter
    session_start();
// Include config file
global $link;
require_once "config.php";

// Define variables and initialize with empty values
$RecipeName = $Mid = $Rating = "";

$RecipeName = isset($_GET['recipe_name']) ? urldecode($_GET['recipe_name']) : " ";
$Mid = $_SESSION['id'];

// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){
    $Rating = trim($_POST["Rating"]);
    if(empty($Rating)){
        $Rating_err = "Please enter a your Rating.";
    } elseif(!filter_var($Mid, FILTER_VALIDATE_REGEXP, array("options"=>array("regexp"=>"/^[a-zA-Z\s]+$/")))){
        $Rating_err = "Please enter a your Rating.";
    }

    // Check input errors before inserting in database
    if(!empty($RecipeName) && !empty($Mid) && !empty($Rating)) {
        // Prepare an insert statement

        $sql = "CALL AddOrUpdateRating('$RecipeName', '$Mid', '$Rating')";
        mysqli_query($link, $sql);
    }
    // Close connection
    mysqli_close($link);
    header("location: index.php");
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
                <p>Please fill this form and submit to add a rating to the database.</p>
                <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>?recipe_name=<?php echo urlencode($RecipeName); ?>" method="post">
                    <div class="form-group">
                        <label>Recipe Name</label>
                        <input type="text" name="Recipe Name" class="form-control" value="<?php echo htmlspecialchars($RecipeName); ?>" disabled>
                    </div>
                    <div class="form-group">
                        <label>Member Id</label>
                        <input type="text" name="Member Id" class="form-control" value="<?php echo $Mid; ?>" disabled>
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