<?php
session_start();
require_once './db.php';
require_once './inc/defined_variables.php';

$paused = '';
if($_POST['paused'] == 'yes'){
	$paused = '1';
} else{
	$paused = '0';
}

if(isset($_POST['pkgid'])){
	$sql = "UPDATE package_list SET paused = '". addslashes($paused) ."', updated = '1' where pkg_id = '".$_POST['pkgid']."'";
	if( $con->query($sql) === TRUE){
		echo "true";
	}else{
		echo "false";
	}
} else{
	$sql = "UPDATE sentfile SET paused = '". addslashes($paused) ."', updated = '1' where file_id = '".$_POST['id']."'";
	if( $con->query($sql) === TRUE){
		echo "true";
	}else{
		echo "false";
	}
}






