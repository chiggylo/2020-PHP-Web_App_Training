<?php 
// Include config file
require_once "db/config.php";

// check if logged in
session_start();
if(!isset($_SESSION["username"]))
{
	echo "Please login to continue. Redirecting to login page.";
	header("Refresh:2; URL=index.html");
	exit();
}

// Declare name
$name = "";
	
// Check existence of username parameter before processing further
if(isset($_GET["username"]) && !empty(trim($_GET["username"])))
{
	// Get URL parameter
	$username =  trim($_GET["username"]);
	// Prepare a select statement
	$sql = "SELECT name FROM login WHERE username = ?";
	if($stmt = mysqli_prepare($link, $sql)){
		// Bind variables to the prepared statement as parameters
		mysqli_stmt_bind_param($stmt, "i", $param_username);
		
		// Set parameters
		$param_username = $username;
		
		// Attempt to execute the prepared statement
		if(mysqli_stmt_execute($stmt)){
			$result = mysqli_stmt_get_result($stmt);

			if(mysqli_num_rows($result) == 1){
				/* Fetch result row as an associative array. Since the result set contains only one row, we don't need to use while loop */
				$row = mysqli_fetch_array($result, MYSQLI_ASSOC);
				
				// Retrieve individual field value
				$name = $row["name"];
			}
			else
			{
				// URL doesn't contain valid id. Redirect to error page
				header("location: error.php");
				exit();
			}
			
		} else{
			echo "Oops! Something went wrong. Please try again later.";
		}
	}
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Bootstrap All in One Navbar</title>
<link href="https://fonts.googleapis.com/css?family=Merienda+One" rel="stylesheet">
<link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
<style>
	body {
		background: #eeeeee;
	}
    .form-inline {
        display: inline-block;
    }
	.navbar {		
		background: #fff;
		padding-left: 16px;
		padding-right: 16px;
		border-bottom: 1px solid #d6d6d6;
		box-shadow: 0 0 4px rgba(0,0,0,.1);
	}
	.nav img {
		border-radius: 50%;
		width: 36px;
		height: 36px;
		margin: -8px 0;
		float: left;
		margin-right: 10px;
	}
	.navbar .navbar-brand {
		color: #555;
		padding-left: 0;
		padding-right: 50px;
		font-family: 'Merienda One', sans-serif;
	}
	.navbar .navbar-brand i {
		font-size: 20px;
		margin-right: 5px;
	}
	.search-box {
        position: relative;
    }	
    .search-box input {
		box-shadow: none;
        padding-right: 35px;
        border-radius: 3px !important;
    }
	.search-box .input-group-addon {
        min-width: 35px;
        border: none;
        background: transparent;
        position: absolute;
        right: 0;
        z-index: 9;
        padding: 7px;
		height: 100%;
    }
    .search-box i {
        color: #a0a5b1;
		font-size: 19px;
    }
	.navbar ul li i {
		font-size: 18px;
	}
	.navbar .dropdown-menu i {
		font-size: 16px;
		min-width: 22px;
	}
	.navbar .dropdown.open > a {
		background: none !important;
	}
	.navbar .dropdown-menu {
		border-radius: 1px;
		border-color: #e5e5e5;
		box-shadow: 0 2px 8px rgba(0,0,0,.05);
	}
	.navbar .dropdown-menu li a {
		color: #777;
		padding: 8px 20px;
		line-height: normal;
	}
	.navbar .dropdown-menu li a:hover, .navbar .dropdown-menu li a:active {
		color: #333;
	}	
	.navbar .dropdown-menu .material-icons {
		font-size: 21px;
		line-height: 16px;
		vertical-align: middle;
		margin-top: -2px;
	}
	.navbar .badge {
		background: #f44336;
		font-size: 11px;
		border-radius: 20px;
		position: absolute;
		min-width: 10px;
		padding: 4px 6px 0;
		min-height: 18px;
		top: 5px;
	}
	.navbar ul.nav li a.notifications, .navbar ul.nav li a.messages {
		position: relative;
		margin-right: 10px;
	}
	.navbar ul.nav li a.messages {
		margin-right: 20px;
	}
	.navbar a.notifications .badge {
		margin-left: -8px;
	}
	.navbar a.messages .badge {
		margin-left: -4px;
	}	
	.navbar .active a, .navbar .active a:hover, .navbar .active a:focus {
		background: transparent !important;
	}
	@media (min-width: 1200px){
		.form-inline .input-group {
			width: 300px;
			margin-left: 30px;
		}
	}
	@media (max-width: 1199px){
		.form-inline {
			display: block;
			margin-bottom: 10px;
		}
		.input-group {
			width: 100%;
		}
	}
</style>
</head> 
<body>
<nav class="navbar navbar-default">
	<div class="navbar-header">
		<a class="navbar-brand" href="#"><i class="fa fa-cube"></i>APU<b>Database</b></a>  		
		<button type="button" data-target="#navbarCollapse" data-toggle="collapse" class="navbar-toggle">
			<span class="navbar-toggler-icon"></span>
			<span class="icon-bar"></span>
			<span class="icon-bar"></span>
			<span class="icon-bar"></span>
		</button>
	</div>
	<!-- Collection of nav links, forms, and other content for toggling -->
	<div id="navbarCollapse" class="collapse navbar-collapse">
		<ul class="nav navbar-nav">
						<?php 
						if(isset($_GET["username"]))
						{ 
							echo "<li><a href=\"employees/index.php?username=".trim($_GET["username"]);
						}
						else
						{
							echo "<li><a href=\"employees/index.php";
						}
						?>
						">Employees</a></li>
						<?php 
						if(isset($_GET["username"]))
						{ 
							echo "<li><a href=\"offices/index.php?username=".trim($_GET["username"]);
						}
						else
						{
							echo "<li><a href=\"offices/index.php";
						}
						?>
						">Offices</a></li>
						<?php 
						if(isset($_GET["username"]))
						{ 
							echo "<li><a href=\"payments/index.php?username=".trim($_GET["username"]);
						}
						else
						{
							echo "<li><a href=\"payments/index.php";
						}
						?>
						">Payments</a></li>
		</ul>

		<ul class="nav navbar-nav navbar-right">
			
			<li class="dropdown">
				<a href="#" data-toggle="dropdown" class="dropdown-toggle user-action">
				<?php 
				if(isset($_SESSION["username"]))
				{
					echo $name;
				} 
				?><b class="caret"></b></a>
				<ul class="dropdown-menu">
					<li><a href="#"><i class="fa fa-user-o"></i> Profile</a></li>
					<li><a href="#"><i class="fa fa-calendar-o"></i> Calendar</a></li>
					<li><a href="#"><i class="fa fa-sliders"></i> Settings</a></li>
					<li class="divider"></li>
					<li><a href="logout.php"><i class="material-icons">&#xE8AC;</i> Logout</a></li>
				</ul>
			</li>
		</ul>
	</div>
</nav>
</body>
</html>                            