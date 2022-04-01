<?php

require('./db.php');

session_start();

$userid = $_SESSION["user"];	

 

$sql = "DELETE from cs_users where oauth_uid = '" . $userid . "'";
$result = mysqli_query($con,$sql);

if($result){

    $content_del = "DELETE from sentfile where added_by = '" . $userid . "' ";

    $results = mysqli_query($con,$content_del);

    $config_del = "DELETE from user_config where user_id = '" . $userid . "' ";

    $config_results = mysqli_query($con,$config_del);

	setcookie("login", '', time()-3600,'/');

	if(isset($_COOKIE['loginuser'])){

		setcookie("loginuser", '', time()-3600,'/');

	}

	session_destroy();

	echo "Account Deleted Successfully";

} else{

	echo "error";

}

 

