<?php
session_start();
if(!empty($_SESSION['removecookie'])){
	setcookie("login", '', time()-3600,'/');
}
if(isset($_COOKIE['loginuser'])){
	setcookie("loginuser", '', time()-3600,'/');
}
$currentDateTime = date('Y-m-d H:i:s');
$sql="UPDATE `loginrecord` SET `logout_at`='".$currentDateTime."' WHERE `record_id`='".$_SESSION['last_id']."'";
$result1 = mysqli_query($con,$sql);
session_destroy(); 
header("Location:dashboard.php");
?>