<?php
require('../../include/db.php');
session_start();


$file_price = $_POST['com_rate'];
echo $Order = "UPDATE System set SalesCommision = '".$file_price."' where SystemID = '1'";
$OrderResult = mysqli_query($con,$Order) or die(mysqli_connect_error());

$_SESSION['message'] = "You have successfuly Updated the Details.!";

header("Location: ../Setting.php");