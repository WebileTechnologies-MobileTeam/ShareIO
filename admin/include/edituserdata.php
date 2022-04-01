<?php
require('../../include/db.php');
session_start();

$action = $_POST['action'];
if($action == 'google'){
	$google_token = $_POST['google_token'];
	$google_key = $_POST['google_key'];
	echo $Order = "UPDATE cs_admin set google_token = '".$google_token."', google_key = '".$google_key."' where cs_id = '1'";
	$OrderResult = mysqli_query($con,$Order) or die(mysqli_connect_error());
}
if($action == 'facebook'){
	$facebook_token = $_POST['facebook_token'];
	$facebook_key = $_POST['facebook_key'];
	echo $Order = "UPDATE cs_admin set facebook_token = '".$facebook_token."', facebook_key = '".$facebook_key."' where cs_id = '1'";
	$OrderResult = mysqli_query($con,$Order) or die(mysqli_connect_error());
}
if($action == 'hotmail'){
	$hotmail_token = $_POST['hotmail_token'];
    $hotmail_key = $_POST['hotmail_key'];
    echo $Order = "UPDATE cs_admin set hotmail_token = '".$hotmail_token."', hotmail_key = '".$hotmail_key."' where cs_id = '1'";
	$OrderResult = mysqli_query($con,$Order) or die(mysqli_connect_error());
}
if($action == 'stripe'){
	$stripe_public_key = $_POST['stripe_public_key'];
	$stripe_secret_key = $_POST['stripe_secret_key'];
	echo $Order = "UPDATE cs_admin set stripe_public_key = '".$stripe_public_key."', stripe_secret_key = '".$stripe_secret_key."' where cs_id = '1'";
	$OrderResult = mysqli_query($con,$Order) or die(mysqli_connect_error());

}



$_SESSION['message'] = "You have successfuly Updated the Details.!";

header("Location: ../Setting.php");