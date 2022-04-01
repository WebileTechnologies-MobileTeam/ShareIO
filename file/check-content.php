<?php
require('../include/db.php');



$check_file = "Select * from sentfile where file_id = '".$_POST['id']."'";

$check_file_result = mysqli_query($con,$check_file);

if(mysqli_num_rows($check_file_result) > 0){

	$data = mysqli_fetch_array($check_file_result);

	if($data['paused'] == '1'){

		echo "false1";

	} else{
		
		if($data['updated'] == 1){

			$update_file = "UPDATE sentfile set updated = '0' where file_id = '".$_POST['id']."'";

			$update_file_result = mysqli_query($con,$update_file);
			echo "updated";

		} else{

			echo "true";

		}

	}

} else{

	echo "false";

	//header("Location: filenotfound.php");

}



