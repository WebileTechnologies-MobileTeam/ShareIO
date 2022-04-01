<?php
require('../../include/db.php');
session_start();


	$id = $_POST['id'];
	$name = $_POST['evaluation_name'];
	$Order = "UPDATE tbl_evaluation set evaluation_name = '".$name."' where evaluation_id = '".$id."'";
	$OrderResult = mysqli_query($con,$Order) or die(mysqli_connect_error());



$_SESSION['message'] = "You have successfuly Updated the Evalution Details.!";

header("Location: ../viewEvalution.php");