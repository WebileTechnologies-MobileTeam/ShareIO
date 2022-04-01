<?php
require_once './db.php';
session_start();

if(isset($_POST['newpass'])){
    $sql = "SELECT * from cs_users where id = '" . $_SESSION["user"] . "' OR oauth_uid =  '" . $_SESSION["user"] . "'";
    $result = mysqli_query($con,$sql);
    $fetch_data = mysqli_fetch_array($result);
    $oldpss =  md5($_POST['oldpass']);
    //echo $oldpss.'--'.$fetch_data['password'];
    if($fetch_data['password'] == $oldpss){
      $password = md5($_POST['newpass']);

	  $sql = "UPDATE cs_users SET password = '".$password."' where id = '" . $_SESSION["user"] . "'";

	  if( $con->query($sql) === TRUE ){
		    $_SESSION['succsessmsg'] = 'Password Changed successfully';
		    echo $_SESSION['succsessmsg'];
		}else{
			echo "<div class='alert alert-danger'>Error: There was an error while changing your password.</div>";
		} 
    } else{
        echo "false";
    }


}