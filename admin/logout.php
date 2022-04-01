<?php
session_start();
if(!empty($_SESSION['removecookie'])){
	setcookie("login", '', time()-3600,'/contentshare/');
}
session_destroy(); 
header("Location:index.php");
?>