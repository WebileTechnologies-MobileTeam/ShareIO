<?php
require_once './db.php';
session_start();
if(isset($_GET['email'])){
	$email = $_GET['email'];

	 $sql = "UPDATE cs_users SET active = '1' where email = '".$email."'";

		if( $con->query($sql) === TRUE ){
			    $_SESSION['succsessmsg'] = 'Your account has been activated successfully. You can now login.';
				header("Location: ../login.php");
			}else{
				echo "<div class='alert alert-danger'>Error: There was an error while activating your account.</div>";
			}
        }
