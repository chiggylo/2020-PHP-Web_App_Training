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

require('fpdf182/fpdf.php');

$customerNumber = $_GET["customerNumber"];


$pdf = new FPDF();
$pdf->AddPage();
$pdf->SetFont('Arial','B',16);

// header
$pdf->Cell(50,7, "Customer #" .$customerNumber, 1, 0, 'C');
$pdf->ln();
$pdf->ln();
$header = array("Check #","Payment Date","Amount");
$width = array(50,50,40);
for($i=0;$i<count($header);$i++)
{
	$pdf->Cell($width[$i],7,$header[$i],1,0,'C');	
}
$pdf->ln();

	

if(!empty($customerNumber)){
								
	// Prepare a select statement
	$sql = "SELECT checkNumber, paymentDate, amount FROM payments WHERE customerNumber = ?";
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
			if(mysqli_num_rows($result) > 0)
			{
				while($row = mysqli_fetch_array($result))
				{
					$pdf->Cell(50,7,$row['checkNumber'],1,0,'C');
					$pdf->Cell(50,7,$row['paymentDate'],1,0,'C');
					$pdf->Cell(40,7,$row['amount'],1,0,'C');
					$pdf->ln();
				}
				
			}
		}
	}
}
$pdf->Output();
?>