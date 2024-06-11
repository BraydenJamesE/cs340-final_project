<?php
require_once "config.php";

session_start();
if(!isset($_SESSION['id'])) {
    header("location: login.php");
}
$member_id = $_SESSION['id'];

$Rname = $Rtime = $Rsize = null;
$Rname_err = $Rtime_err = $Rsize_err = $ingredients_err = $cookware_err = "";

$ingredientOptions = "";
$sql = "SELECT `ingredient name` FROM ingredient";
$result = mysqli_query($link, $sql);
if (!$result) {
    die("Error fetching ingredients: " . mysqli_error($link));
}
while ($row = mysqli_fetch_assoc($result)) {
    $ingredientOptions .= "<option value='" . htmlspecialchars($row['ingredient name']) . "'>" . htmlspecialchars($row['ingredient name']) . "</option>";
}

$cookwareOptions = "";
$sql_cookware = "SELECT `cookware name` FROM cookware";
$result_cookware = mysqli_query($link, $sql_cookware);
if (!$result_cookware) {
    die("Error fetching cookware: " . mysqli_error($link));
}
while ($row_cookware = mysqli_fetch_assoc($result_cookware)) {
    $cookwareOptions .= "<option value='" . htmlspecialchars($row_cookware['cookware name']) . "'>" . htmlspecialchars($row_cookware['cookware name']) . "</option>";
}

if($_SERVER["REQUEST_METHOD"] == "POST"){
    $Rname = trim($_POST["Rname"]);
    if(empty($Rname)){
        $Rname_err = "Please enter a name for your recipe..";
    } elseif(!preg_match("/^[a-zA-Z\s]+$/", $Rname)){
        $Rname_err = "Please enter a valid name.";
    } 

    $Rtime = trim($_POST["Rtime"]);
    if(empty($Rtime)){
        $Rtime_err = "Please enter a time.";
    } elseif(!ctype_digit($Rtime)){
        $Rtime_err = "Please enter a valid time";
    } 

    $Rsize = trim($_POST["Rsize"]);
    if(empty($Rsize)){
        $Rsize_err = "Please enter a serving size.";
    } elseif(!ctype_digit($Rsize)){
        $Rsize_err = "Please enter a valid serving size.";
    }

    $Ringredients = $_POST['ingredients'];
    if(empty($Ringredients)){
        $ingredients_err = "Please select at least one ingredient.";
    }

    $Rcookware = $_POST['cookware'];
    if(empty($Rcookware)){
        $cookware_err = "Please select at least one cookware.";
}

    if(empty($Rtime_err) && empty($Rsize_err) && empty($Rname_err) && empty($ingredients_err) && empty($cookware_err)){
        $sql = "INSERT INTO recipe (`recipe name`, `cook time`, `serving size`, `member id`) VALUES (?, ?, ?, ?)";
         
        if($stmt = mysqli_prepare($link, $sql)){
            mysqli_stmt_bind_param($stmt, "siii", $param_Rname, $param_Rtime, $param_Rsize, $param_member_id);
            
            $param_Rname = $Rname;
            $param_Rtime = $Rtime;
            $param_Rsize = $Rsize;
            $param_member_id = $member_id;

            if(mysqli_stmt_execute($stmt)){

                $sql_contains = "INSERT INTO contains (`recipe name`, `ingredient name`) VALUES (?, ?)";
                if($stmt_contains = mysqli_prepare($link, $sql_contains)){
                    mysqli_stmt_bind_param($stmt_contains, "ss", $param_recipe_name, $param_ingredient_name);

                    foreach($Ringredients as $ingredient_name){
                        $param_recipe_name = $Rname;
                        $param_ingredient_name = $ingredient_name;
                        mysqli_stmt_execute($stmt_contains);
                    }
                }

                mysqli_stmt_close($stmt_contains);

                $sql_uses = "INSERT INTO uses (`recipe`, `cookware`) VALUES (?, ?)";
                if($stmt_uses = mysqli_prepare($link, $sql_uses)){
                    mysqli_stmt_bind_param($stmt_uses, "ss", $param_recipe_name, $param_cookware_name);

                    foreach($Rcookware as $cookware_name){
                        $param_recipe_name = $Rname;
                        $param_cookware_name = $cookware_name;
                        mysqli_stmt_execute($stmt_uses);
                    }
                }

                mysqli_stmt_close($stmt_uses);

                header("location: index.php");
                exit();
            } else{
                echo "<center><h4>Error while creating new recipe</h4></center>";
            }
        }

        mysqli_stmt_close($stmt);
    }

    mysqli_close($link);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Add Recipe</title>
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
        <div class="container-flRname">
            <div class="row">
                <div class="col-md-12">
                    <div class="page-header">
                        <h2>Add Recipe</h2>
                    </div>
                    <p>Please fill this form and confirm to add your recipe.</p>
                    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                        <div class="form-group <?php echo (!empty($Rname_err)) ? 'has-error' : ''; ?>">
                            <label>Recipe Name</label>
                            <input type="text" name="Rname" class="form-control" value="<?php echo $Rname; ?>">
                            <span class="help-block"><?php echo $Rname_err;?></span>
                        </div>
                        <div class="form-group <?php echo (!empty($Rtime_err)) ? 'has-error' : ''; ?>">
                            <label>Cook Time</label>
                            <input type="text" name="Rtime" class="form-control" value="<?php echo $Rtime; ?>">
                            <span class="help-block"><?php echo $Rtime_err;?></span>
                        </div>
                        <div class="form-group <?php echo (!empty($Rsize_err)) ? 'has-error' : ''; ?>">
                            <label>Serving Size</label>
                            <input type="text" name="Rsize" class="form-control" value="<?php echo $Rsize; ?>">
                            <span class="help-block"><?php echo $Rsize_err;?></span>
                        </div>
                        <div class="form-group <?php echo (!empty($ingredients_err)) ? 'has-error' : ''; ?>">
                            <label>Ingredients (Press Ctrl/Cmd to select multiple)</label>
                            <select name="ingredients[]" class="form-control" multiple>
                                <?php echo $ingredientOptions; ?>
                            </select>
                            <span class="help-block"><?php echo $ingredients_err;?></span>
                        </div>
                        <div class="form-group <?php echo (!empty($cookware_err)) ? 'has-error' : ''; ?>">
                            <label>Cookware (Press Ctrl/Cmd to select multiple)</label>
                            <select name="cookware[]" class="form-control" multiple>
                                <?php echo $cookwareOptions; ?>
                            </select>
                            <span class="help-block"><?php echo $cookware_err;?></span>
                        </div>
                        <input type="submit" class="btn btn-primary" value="Add">
                        <a href="index.php" class="btn btn-default">Cancel</a>
                    </form>
                </div>
            </div>        
        </div>
    </div>
</body>
</html>
