<?php
// check if logged in
session_start();
if(!isset($_SESSION["username"]))
{
	echo "Please login to continue. Redirecting to login page.";
	header("Refresh:2; URL=../index.html");
	exit();
}

// Include config file
require_once "../db/config.php";
 
// Define variables and initialize with empty values
$city = $state = $country = "";
$city_err = $state_err = $country_err = "";
 
// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST")
{
    // Validate city
    $input_name = trim($_POST["city"]);
    if(empty($input_name)){
        $city_err = "Please enter a city.";
    } elseif(!filter_var($input_name, FILTER_VALIDATE_REGEXP, array("options"=>array("regexp"=>"/^[a-zA-Z\s]+$/")))){
        $city_err = "Please enter a valid city.";
    } else{
        $city = $input_name;
    }
	
	// Validate state
    $input_name = trim($_POST["state"]);
    if(empty($input_name)){
        $state_err = "Please enter a state.";
    } elseif(!filter_var($input_name, FILTER_VALIDATE_REGEXP, array("options"=>array("regexp"=>"/^[a-zA-Z\s]+$/")))){
        $state_err = "Please enter a valid state.";
    } else{
        $state = $input_name;
    }
	
	// Validate country
    $input_name = trim($_POST["country"]);
    if(empty($input_name)){
        $country_err = "Please enter a country.";
    } elseif(!filter_var($input_name, FILTER_VALIDATE_REGEXP, array("options"=>array("regexp"=>"/^[a-zA-Z\s]+$/")))){
        $country_err = "Please enter a valid country.";
    } else{
        $country = $input_name;
    }
    
    // Check input errors before inserting in database
    if(empty($city_err) && empty($state_err) && empty($country_err))
	{
        // Prepare an insert statement
        $sql = "INSERT INTO offices (city, state, country) VALUES (?, ?, ?)";
         
        if($stmt = mysqli_prepare($link, $sql))
		{
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "sss", $param_city, $param_state, $param_country);
            
            // Set parameters
            $param_city = $city;
            $param_state = $state;
            $param_country = $country;
            
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt))
			{
                // Records created successfully. Redirect to landing page
                header("location: index.php");
                exit();
            } 
			else
			{
                echo "Something went wrong. Please try again later.";
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
                        <h2>Create Record</h2>
                    </div>
                    <p>Please fill this form and submit to add office record to the database.</p>
                    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                        <div class="form-group <?php echo (!empty($city_err)) ? 'has-error' : ''; ?>">
                            <label>City</label>
                            <input type="text" name="city" class="form-control" value="<?php echo $city; ?>">
                            <span class="help-block"><?php echo $city_err;?></span>
                        </div>
                        <div class="form-group <?php echo (!empty($state_err)) ? 'has-error' : ''; ?>">
                            <label>State</label>
                            <textarea name="state" class="form-control"><?php echo $state; ?></textarea>
                            <span class="help-block"><?php echo $state_err;?></span>
                        </div>
                        <div class="form-group <?php echo (!empty($country_err)) ? 'has-error' : ''; ?>">
                            <label>Country</label>
                            <input type="text" name="country" class="form-control" value="<?php echo $country; ?>">
                            <span class="help-block"><?php echo $country_err;?></span>
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