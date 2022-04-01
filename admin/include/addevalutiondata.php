<?php
require('../../include/db.php');
session_start();
$name = $_POST['evaluation_name'];
$Order = "INSERT into tbl_evaluation(evaluation_name) VALUES('".$name."')";
$OrderResult = mysqli_query($con,$Order) or die(mysqli_connect_error());

$_SESSION['message'] = "You have successfuly Added new Evalution.!";

header("Location: ../viewEvalution.php");