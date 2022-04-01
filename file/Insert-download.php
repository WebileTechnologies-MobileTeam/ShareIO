<?php
ini_set('error_reporting', 1);
require('../include/db.php');

$id = $_POST['id'];
$date = date('Y-m-d');
$download = "INSERT into file_download (file_id,download,download_date) VALUES ('".$id."','1','".$date."')";
$results = mysqli_query($con,$download);
	if($results){
		echo "true";
	} else{
		echo "false";
	}