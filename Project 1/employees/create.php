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
$name = $address = $salary = $office = "";
$name_err = $address_err = $salary_err = $office_err = "";

// Grab office id
// Prepare an insert statement
$sql = "SELECT *from offices";
$QueryResult = mysqli_query($link, $sql);

 
// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST")
{
    // Validate name
    $input_name = trim($_POST["name"]);
    if(empty($input_name))
	{
        $name_err = "Please enter a name.";
    } 
	elseif(!filter_var($input_name, FILTER_VALIDATE_REGEXP, array("options"=>array("regexp"=>"/^[a-zA-Z\s]+$/"))))
	{
        $name_err = "Please enter a valid name.";
    } 
	else
	{
        $name = $input_name;
    }
    
    // Validate address
    $input_address = trim($_POST["address"]);
    if(empty($input_address))
	{
        $address_err = "Please enter an address.";     
    } 
	else
	{
        $address = $input_address;
    }
    
    // Validate salary
    $input_salary = trim($_POST["salary"]);
    if(empty($input_salary))
	{
        $salary_err = "Please enter the salary amount.";     
    } 
	elseif(!ctype_digit($input_salary))
	{
        $salary_err = "Please enter a positive integer value.";
    } 
	else
	{
        $salary = $input_salary;
    }
	
	// Validate office
	$office = trim($_POST["ddloffice"]);
	echo $_POST["ddloffice"];
	exit;
    
    // Check input errors before inserting in database
    if(empty($name_err) && empty($address_err) && empty($salary_err))
	{
        // Prepare an insert statement
        $sql = "INSERT INTO employees (name, address, salary, officeid) VALUES (?, ?, ?, ?)";
         
        if($stmt = mysqli_prepare($link, $sql))
		{
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "sssi", $param_name, $param_address, $param_salary, $param_office);
            
            // Set parameters
            $param_name = $name;
            $param_address = $address;
            $param_salary = $salary;
			$param_office = $office;
            
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
                    <p>Please fill this form and submit to add employee record to the database.</p>
                    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                        <div class="form-group <?php echo (!empty($name_err)) ? 'has-error' : ''; ?>">
                            <label>Name</label>
                            <input type="text" name="name" class="form-control" value="<?php echo $name; ?>">
                            <span class="help-block"><?php echo $name_err;?></span>
                        </div>
                        <div class="form-group <?php echo (!empty($address_err)) ? 'has-error' : ''; ?>">
                            <label>Address</label>
                            <textarea name="address" class="form-control"><?php echo $address; ?></textarea>
                            <span class="help-block"><?php echo $address_err;?></span>
                        </div>
                        <div class="form-group <?php echo (!empty($salary_err)) ? 'has-error' : ''; ?>">
                            <label>Salary</label>
                            <input type="text" name="salary" class="form-control" value="<?php echo $salary; ?>">
                            <span class="help-block"><?php echo $salary_err;?></span>
                        </div>
						<div class="form-group <?php echo (!empty($salary_err)) ? 'has-error' : ''; ?>">
                            <label>Office</label>
				
							<?php
								$ddl = "";
								if(mysqli_num_rows($QueryResult)> 0){
									$ddl = $ddl."<select name='ddloffice'>";
									while($Row = mysqli_fetch_array($QueryResult))
									{
										$ddl=$ddl."<option value=".$Row['id'].">".$Row['city']." ".$Row['state']." ".$Row['country']."</option>";
									}
									$ddl=$ddl."</select>";
									
								}
								echo $ddl;
							?>
                            <span class="help-block"><?php echo $office_err;?></span>
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