<?php
require('../../include/db.php');
session_start();


	$email = $_POST['email'];
	$ccemail = $_POST['ccemail'];
	echo $Order = "UPDATE email_setting set email = '".$email."', ccemail = '".$ccemail."' where id = '1'";
	$OrderResult = mysqli_query($con,$Order) or die(mysqli_connect_error());



$_SESSION['message'] = "You have successfuly Updated the Details.!";

header("Location: ../Setting.php");