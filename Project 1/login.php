<?php
// Include config file
require_once "db/config.php";

//start session
session_start();
 
// Define variables and initialize with empty values
$username = $password = "";
$username_err = $password_err = "";

// Grab values from form and validate
$username = $_POST["username"]; 
$password = $_POST["password"];


// Process login

// Prepare an insert statement
$sql = "SELECT username, name from login where username=? and password=?";
$statement = mysqli_prepare($link, $sql);
mysqli_stmt_bind_param($statement, "ss", $param_username, $param_password);
$param_username = $username;
$param_password = $password;

if(mysqli_stmt_execute($statement)){
	$result = mysqli_stmt_get_result($statement);
	if(mysqli_num_rows($result) == 1)
	{
		$row = mysqli_fetch_array($result);
		// Records created successfully. Redirect to landing page
		$_SESSION["username"]= $row['username'];
		header("location: mainmenu.php?username=".$row['username']);
		exit();
	}
}
echo "Invalid login";
header("Refresh:2; URL=index.html");

?>