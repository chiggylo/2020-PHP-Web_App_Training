<?php
session_start();
require_once "config.php";
if(isset($_POST['username']) && isset($_POST['password']))
{
	$username=$_POST['username'];
	$password=$_POST['password'];
	
	$sql = "SELECT username, name from login where username=? and password=?";
	if($stmt = mysqli_prepare($link, $sql))
	{
		mysqli_stmt_bind_param($stmt, "ss", $username,$password);
		if(mysqli_stmt_execute($stmt))
		{
			$result = mysqli_stmt_get_result($stmt);
			if(mysqli_num_rows($result) == 1)
			{
				//$row = mysqli_fetch_array($result);
				//$_SESSION["username"]= $row['username']; // can't destroy session in index.html onclick logout :C
				echo 1;
				exit();
			}
			else
			{
				echo 0;
				exit();
			}
		}
		else
		{
			echo 0;
			exit();
		}
	}
	else
	{
		echo 0;
		exit();
	}
}
?>