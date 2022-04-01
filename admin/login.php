<?php
require('../include/db.php');
session_start();
if(!empty($_POST["username"])) {
	
	$sql = "Select * from cs_admin where email = '" . $_POST["username"] . "' AND password = '" . md5($_POST["password"]) . "'";
    $result = mysqli_query($con,$sql);
	$user = mysqli_fetch_assoc($result);
	//print_r($user);
	
	if($user) {
			if($user['user_active'] != '1'){
				$_SESSION['error']= "You have not activated your account. Please activate your account via the email link we have sent on your email.";
				header("Location: login.php");
			}else{
		  $_SESSION['csuser'] = $user['cs_id'];


			 $_SESSION['message']= "Login Successfully."; 
			header("Location: Dashboard.php");
			//print_r($_COOKIE);
	} 
	}else {
		$_SESSION['error']= "Please Enter Correct Username & Password.";
		header("Location: index.php");
	}
}