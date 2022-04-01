<?php 
require_once '../include/db.php';
$email = $_GET['email'];
 $resId1 = mysqli_query($con,"SELECT * FROM cs_users WHERE email ='" . $email . "'") or die(mysql_error());
 	if (mysqli_num_rows($resId1) == 1) {?>
	<span><div class='alert alert-danger'>email already exists</div></span>	
<?php	} ?>