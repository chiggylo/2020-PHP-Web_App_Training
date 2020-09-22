<?php
$date = new DateTime();
$target_dir = "uploads/";
$target_file = $target_dir .$date->format('Y-m-d-H-i-s')."_".basename($_FILES["fileToUpload"]["name"]);


$uploadOk = 1;
$imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));

// Check if image file is a actual image or fake image
if(isset($_POST["submit"])) {
  $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
  if($check !== false) {
    echo "File is an image - " . $check["mime"] . ".";
    $uploadOk = 1;
  } else {
    echo "File is not an image.";
    $uploadOk = 0;
  }
}

// Check if file already exists
if (file_exists($target_file)) {
  echo "Sorry, file already exists.";
  $uploadOk = 0;
}

// Check file size
if ($_FILES["fileToUpload"]["size"] > 500000) {
  echo "Sorry, your file is too large.";
  $uploadOk = 0;
}

// Allow certain file formats
if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
&& $imageFileType != "gif" ) {
  echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
  $uploadOk = 0;
}

// Check if $uploadOk is set to 0 by an error
if ($uploadOk == 0) {
  echo "Sorry, your file was not uploaded.";
// if everything is ok, try to upload file
} 
else 
{
	if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) 
	{
		echo "The file ". basename( $_FILES["fileToUpload"]["name"]). " has been uploaded.";
		// Include config file
		require_once "../db/config.php";


		// Get URL parameter
		$id =  trim($_GET["id"]);
		// Prepare an update statement
		$sql = "UPDATE employees SET image=? WHERE id=?";
		if($stmt = mysqli_prepare($link, $sql))
		{
			// Bind variables to the prepared statement as parameters
			mysqli_stmt_bind_param($stmt, "si", $param_path, $param_id);

			// Set parameters
			$param_path = $target_file;
			$param_id = $id;

			// Attempt to execute the prepared statement
			if(mysqli_stmt_execute($stmt))
			{
				// Records updated successfully. Redirect to landing page
				header("Refresh:2; URL=index.php");
				exit();
			} 
			else
			{
				echo "Something went wrong. Please try again later.";
			}
		} 
	}
	else 
	{
		echo "Sorry, there was an error uploading your file.";
	}
}
?>