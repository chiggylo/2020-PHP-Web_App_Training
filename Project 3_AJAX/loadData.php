<?php
// Include config file
require_once "db/config.php";

// Attempt select query execution
$sql = "SELECT orderNumber, orderDate, requiredDate, shippedDate FROM orders";
if($result = mysqli_query($link, $sql)){
	if(mysqli_num_rows($result) > 0){
	echo "<table class='table table-bordered table-striped'>";
	echo "<thead>";
	echo "<tr>";
	echo "<th>#</th>";
	echo "<th>Order Date</th>";
	echo "<th>Required Date</th>";
	echo "<th>Shipped Date</th>";
	echo "</tr>";
	echo "</thead>";
	echo "<tbody>";
	while($row = mysqli_fetch_array($result)){
		echo "<tr>";
		echo "<td>" . $row['orderNumber'] . "</td>";
		echo "<td>" . $row['orderDate'] . "</td>";
		echo "<td>" . $row['requiredDate'] . "</td>";
		echo "<td>" . $row['shippedDate'] . "</td>";
		echo "</td>";
		echo "</tr>";
	}
		echo "</tbody>";                            
		echo "</table>";
		// Free result set
		mysqli_free_result($result);
	} 
	else
	{
		echo "<p class='lead'><em>No records were found.</em></p>";
	}
} 
else
{
	echo "ERROR: Could not able to execute $sql. " . mysqli_error($link);
}

// Close connection
mysqli_close($link);
?>