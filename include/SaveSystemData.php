<?php
session_start();
require_once './db.php';
require_once './inc/defined_variables.php';

$update_package = "UPDATE system_data set sales_commision = '".$_POST['salesCommision']."', impression_cost_per_1k = '".$_POST['impressionCost']."', block_signup = '".$_POST['newSignups']."' where system_id  = '1'";
if( $con->query($update_package) === TRUE){
	echo 'true';
} else{
	echo 'false';
}