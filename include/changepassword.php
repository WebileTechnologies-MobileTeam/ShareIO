<?php
require_once './db.php';
session_start();
if(isset($_POST['email'])){
	$email = $_POST['email'];
	$password = md5($_POST['password']);

	 $sql = "UPDATE cs_users SET password = '".$password."' where email = '".$email."'";

		if( $con->query($sql) === TRUE ){
			    $_SESSION['succsessmsg'] = 'Password Changed successfully';
				header("Location: ../login.php");
			}else{
				echo "<div class='alert alert-danger'>Error: There was an error while adding new user</div>";
			}
        }
