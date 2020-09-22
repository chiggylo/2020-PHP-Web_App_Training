<?php
// check if logged in
session_start();
if(!isset($_SESSION["username"]))
{
	echo "Please login to continue. Redirecting to login page.";
	header("Refresh:2; URL=../index.html");
	exit();
}
require_once "../db/config.php";

function default_table($link){
	//require 
	// Attempt select query execution
	$sql = "SELECT * FROM payments limit 0, 10";
	if($result = mysqli_query($link, $sql)){
		if(mysqli_num_rows($result) > 0){
			echo "<table class='table table-bordered table-striped'>";
				echo "<thead>";
					echo "<tr>";
						echo "<th>Customer #</th>";
						echo "<th>Check #</th>";
						echo "<th>Payment Date</th>";
						echo "<th>Amount</th>";
						echo "<th>Action</th>";
					echo "</tr>";
				echo "</thead>";
				echo "<tbody>";
				while($row = mysqli_fetch_array($result)){
					echo "<tr>";
						echo "<td>" . $row['customerNumber'] . "</td>";
						echo "<td>" . $row['checkNumber'] . "</td>";
						echo "<td>" . $row['paymentDate'] . "</td>";
						echo "<td>" . $row['amount'] . "</td>";
						echo "<td>";
							//echo "<a href='read.php?id=". $row['id'] ."' title='View Record' data-toggle='tooltip'><span class='glyphicon glyphicon-eye-open'></span></a>";
							//echo "<a href='update.php?id=". $row['id'] ."' title='Update Record' data-toggle='tooltip'><span class='glyphicon glyphicon-pencil'></span></a>";
							//echo "<a href='delete.php?id=". $row['id'] ."' title='Delete Record' data-toggle='tooltip'><span class='glyphicon glyphicon-trash'></span></a>";
							//echo "<a href='uploadpic.php?id=". $row['id'] ."' title='Upload/Update Picture' data-toggle='tooltip'><span class='glyphicon glyphicon-export'></span></a>";
						echo "</td>";
					echo "</tr>";
				}
				echo "</tbody>";                            
			echo "</table>";
			// Free result set
			mysqli_free_result($result);
		} else{
			echo "<p class='lead'><em>No records were found.</em></p>";
		}
	} 
	else{
		echo "ERROR: Could not able to execute $sql. " . mysqli_error($link);
	}
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Dashboard</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.js"></script>
    <style type="text/css">
        .wrapper{
            width: 650px;
            margin: 0 auto;
        }
        .page-header h2{
            margin-top: 0;
        }
        table tr td:last-child a{
            margin-right: 15px;
        }
		img{
			width:100px;
			height:50px;
		}
    </style>
    <script type="text/javascript">
        $(document).ready(function(){
            $('[data-toggle="tooltip"]').tooltip();   
        });
    </script>
</head>
<body>
    <div class="wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="page-header clearfix">
                        <h2 class="pull-left">Payment Details</h2>
                        <!--<a href="create.php" class="btn btn-success pull-right">Add New Employee</a>-->
                    </div>
					 <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
						<div class="form-group">
                            <label>Search Customer #</label>
                            <input type="number" name="search" class="form-control" value="">
							<input type="submit" class="btn btn-primary" value="Submit">
                        </div>
					 </form>
					
                    <?php			
					// Processing form data when form is submitted
					if($_SERVER["REQUEST_METHOD"] == "POST")
					{
						//require "../db/config.php";	

						$search_input = "";
						
						$search_input = trim($_POST["search"]);
						
						//echo ctype_space($customerNumber); exit();
						if(!empty($search_input)){
							$customerNumber = $search_input;
														
							// Prepare a select statement
							$sql = "SELECT * FROM payments WHERE customerNumber = ? limit 0, 10";
							
							if($stmt = mysqli_prepare($link, $sql))
							{
								// Bind variables to the prepared statement as parameters
								mysqli_stmt_bind_param($stmt, "i", $param_id);
								
								// Set parameters
								$param_id = $customerNumber;
								
								// Attempt to execute the prepared statement
								if(mysqli_stmt_execute($stmt))
								{
									$result = mysqli_stmt_get_result($stmt);
									$customerNumber = "";
									if(mysqli_num_rows($result) > 0)
									{
										echo "<table class='table table-bordered table-striped'>";
											echo "<thead>";
												echo "<tr>";
													echo "<th>Customer #</th>";
													echo "<th>Check #</th>";
													echo "<th>Payment Date</th>";
													echo "<th>Amount</th>";
													echo "<th>Action</th>";
												echo "</tr>";
											echo "</thead>";
											echo "<tbody>";
											while($row = mysqli_fetch_array($result))
											{
												echo "<tr>";
													echo "<td>" . $row['customerNumber'] . "</td>";
													$customerNumber = $row['customerNumber'];
													echo "<td>" . $row['checkNumber'] . "</td>";
													echo "<td>" . $row['paymentDate'] . "</td>";
													echo "<td>" . $row['amount'] . "</td>";
													echo "<td>";
														//echo "<a href='read.php?id=". $row['id'] ."' title='View Record' data-toggle='tooltip'><span class='glyphicon glyphicon-eye-open'></span></a>";
														//echo "<a href='update.php?id=". $row['id'] ."' title='Update Record' data-toggle='tooltip'><span class='glyphicon glyphicon-pencil'></span></a>";
														//echo "<a href='delete.php?id=". $row['id'] ."' title='Delete Record' data-toggle='tooltip'><span class='glyphicon glyphicon-trash'></span></a>";
														//echo "<a href='uploadpic.php?id=". $row['id'] ."' title='Upload/Update Picture' data-toggle='tooltip'><span class='glyphicon glyphicon-export'></span></a>";
													echo "</td>";
												echo "</tr>";
											}
											echo "</tbody>";                            
										echo "</table>";
										
										echo "<form action=\"generatePDF.php?customerNumber=".$customerNumber."\" method=\"post\">";
										echo "<div class=\"form-group\">";
										echo "<input type=\"submit\" class=\"btn btn-primary\" value=\"Generate PDF\">";
										echo "</div>";
										echo "</form>";
										// Free result set
										mysqli_free_result($result);
									} 
									else
									{
										echo "<p class='lead'><em>No records were found.</em></p>";
									}
								}
							}
							
						}
						else{
						default_table($link);
						}
					}

                    else{
						default_table($link);
					}
 
                    // Close connection
                    //mysqli_close($link);
                    ?>
                </div>
            </div>        
        </div>
    </div>
</body>
</html>