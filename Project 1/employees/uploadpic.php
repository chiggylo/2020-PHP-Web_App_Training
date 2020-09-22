<?php
// check if logged in
session_start();
if(!isset($_SESSION["username"]))
{
	echo "Please login to continue. Redirecting to login page.";
	header("Refresh:2; URL=../index.html");
	exit();
}

?>

<!DOCTYPE html>
<html>
<body>
<?php echo "<form action=\"upload.php?id=".trim($_GET["id"])."\" method=\"post\" enctype=\"multipart/form-data\">"; ?>

  Select image to upload:
  <input type="file" name="fileToUpload" id="fileToUpload">
  <input type="submit" value="Upload Image" name="submit">
</form>

</body>
</html>