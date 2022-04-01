<?php
require('./db.php');
session_start();
$userid = $_SESSION["user"];	
$sql = "UPDATE cs_users SET terms_use = '1' WHERE id = '" . $userid . "' OR oauth_uid = '" . $userid . "'";
$result = mysqli_query($con,$sql);
if($result){
	echo "Accepted";

} else{
	echo "Decline";
}