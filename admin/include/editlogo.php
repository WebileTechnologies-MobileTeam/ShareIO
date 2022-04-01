<?php
session_start();
require_once '../../include/db.php';
require_once '../../include/inc/defined_variables.php';

$image = '';

if(isset($_FILES["file"]["type"])){
		$validextensions = array("jpeg", "jpg", "png");
		$temporary = explode(".", $_FILES["file"]["name"]);
		$file_extension = end($temporary);
		if((($_FILES["file"]["type"] == "image/png") || ($_FILES["file"]["type"] == "image/jpg") || ($_FILES["file"]["type"] == "image/jpeg")
			) && ($_FILES["file"]["size"] < 11097152)//Approx. 11mb files can be uploaded.
			&& in_array($file_extension, $validextensions)){
			if($_FILES["file"]["error"] > 0){
				echo "Return Code: " . $_FILES["file"]["error"] . "<br/><br/>";
			}
			else{
				if(file_exists("image/" . $_FILES["file"]["name"])){
					$msg =  $_FILES["file"]["name"] . " <span id='invalid'><b>already exists.</b></span> ";
				}
				else{
					$sourcePath = $_FILES['file']['tmp_name']; // Storing source path of the file in a variable
					$targetPath = "../../image/".date("dmyhis").$_FILES['file']['name']; // Target path where file is to be stored
					move_uploaded_file($sourcePath,$targetPath) ; // Moving Uploaded file
					 $image_path = SITE_URL.'/image/'.date("dmyhis").$_FILES['file']['name'];
				}
			}
		}
		else{
			echo "<span id='invalid'>***Invalid file Size or Type***<span>";
		}
		$image = $image_path;
	}


	echo $Order = "UPDATE cs_admin set logo = '".$image."' where cs_id = '1'";
	$OrderResult = mysqli_query($con,$Order) or die(mysqli_connect_error());



	$_SESSION['message'] = "You have successfuly Updated the Details.!";

	header("Location: ../Setting.php");
