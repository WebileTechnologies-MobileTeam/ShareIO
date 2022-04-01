<?php
require('../../include/db.php');
session_start();
$id = $_GET['id'];
$Order = "DELETE from tbl_evaluation where evaluation_id = '".$id."'";
$OrderResult = mysqli_query($con,$Order) or die(mysqli_connect_error());
$_SESSION['message'] = "You have successfuly Deleted the Evalution.!";
echo $_SESSION['message'];
