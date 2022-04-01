<?php
require('./include/db.php');

if(isset($_GET['c'])){
	$sql = "Select * from sentfile where file_md5 = '" . $_GET["c"] . "' ";
    $result = mysqli_query($con,$sql);
	$user = mysqli_fetch_assoc($result);

	header("Location:".$user['file_url']);
}