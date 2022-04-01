<?php require('../include/db.php');

$id = $_POST['file_id'];
$action = $_POST['action'];
if($action == 'Active'){
	$sql = "UPDATE sentfile SET browser_enabled = '1' where file_id = '".$id."'";
 	$result = mysqli_query($con,$sql);
} else{
	$sql = "UPDATE sentfile SET browser_enabled = '0' where file_id = '".$id."'";
 	$result = mysqli_query($con,$sql);
}
 

