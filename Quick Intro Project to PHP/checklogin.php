<?php

$host = 'localhost';
$user = 'root';
$pass = '';
$db = 'classicmodels';


// Create connection
$conn = mysqli_connect($host, $user, $pass);

// Check connection
if (!$conn) 
{
	echo "Failed to connect";
}
else
{
	echo "Connected successfully";
}


// Check database
$DBSelect  = mysqli_select_db($conn, $db);
if(!$DBSelect)
{
	echo "Failed to reach database";
}
else
{
	echo "Opened database";
}


// Query database
$SQLstring = "Select * from customers";

$QueryResult = mysqli_query($conn, $SQLstring);

$NumRows = mysqli_num_rows($QueryResult);
$NumFields = mysqli_num_fields($QueryResult);

if($NumRows != 0 && $NumFields != 0)
{
	echo "<p>Your query returned " . $NumRows . " rows and " . $NumFields . " fields </p>";
}
else
	echo "<p>Your query returned no results.</p>";


// Accessing each rows
$Row = mysqli_fetch_row($QueryResult);

echo "<tr><td>{$Row[0]}</td>";
echo "<td>{$Row[1]}</td>";
echo "<td>{$Row[2]}</td></tr>";

$Row = mysqli_fetch_row($QueryResult);

// SQL injection protection

$email = $_POST["email"];
$password = $_POST["password");

// $sql = "Select userid FROM users WHERE email ='$email' AND password='$password'";
$sql = "Select userid FROM users WHERE email = ? AND password= ?";
$statement = mysqli_prepare($conn, $sql);
mysqli_stmt_bind_param($statement, "ss", $email, $password);
mysqli_stmt_execute($statement);

$result = mysqli_stmt_get_result($statement);

mysqli_close($conn);


?>