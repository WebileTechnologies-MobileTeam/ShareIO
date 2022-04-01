<?php
require('./db.php');
session_start();

if(!empty($_POST["username"])) {
	$sql = "Select * from cs_users where email = '" . $_POST["username"] . "' AND password = '" . md5($_POST["password"]) . "' OR password = '" . $_POST["password"] . "'";
    $result = mysqli_query($con,$sql);
	$user = mysqli_fetch_assoc($result);
	//print_r($user);
	
	if($user) {
			if($user['active'] != '1'){
				$_SESSION['error']= "You have not activated your account. Please activate your account via the email link we have sent on your email.";
				header("Location: ../login.php");
			}else{
		  $_SESSION['user']= $user['id'];

		if(!empty($_POST["remember"])) {
				setcookie ("login",$user['id'],time()+ (10 * 365 * 24 * 60 * 60),'/');
				
			} else {
				if(isset($_COOKIE["login"])) {
					$_SESSION['removecookie'] = "Remove";			
				}
			}

			$currentDateTime = date('Y-m-d H:i:s');

		    $sql1 = "INSERT INTO loginrecord(
			user_id,
			login_at,
			logout_at
			) VALUES(
			'" . addslashes($_SESSION['user']) . "',
			'" . addslashes($currentDateTime) . "',
			'Active'
			)";
			$result1 = mysqli_query($con,$sql1);//$_SESSION['success']= "Login Successfully.";
			$last_id = $con->insert_id;

			$_SESSION['last_id']= $last_id;
			 //$_SESSION['success']= "Login Successfully."; 
			header("Location: ../dashboard.php");
			//print_r($_COOKIE);
	} 
	}else {
		$_SESSION['error']= "Please Enter Correct Username & Password.";
		header("Location: ../login.php");
	}
}