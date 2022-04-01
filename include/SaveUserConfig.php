<?php

session_start();

require_once './db.php';

require_once './inc/defined_variables.php';

if(!class_exists('S3'))require_once('S3Bucket_config.php');



if(isset($_POST['updateorg'])){
  $updateorg = "UPDATE cs_users SET organization = '".$_POST['organization']."' where id = '".$_POST['userId']."'";
  if( $con->query($updateorg) === TRUE){
    echo "Organization Updated Successfully";
  } else{
    echo "error";
  }
  exit;
}

$sql = "SELECT * FROM user_config WHERE user_id = '".$_POST['userId']."'";

$result = mysqli_query($con,$sql);

if(isset($_POST['action'])){

   $tmpfile = $_FILES['file']['tmp_name'];

   $file = $_FILES['file']['name']; 

   

   S3::setAuth(AWS_S3_KEY, AWS_S3_SECRET);

   (new S3)->setRegion(AWS_S3_REGION);

   S3::setSignatureVersion('v4');

   if((new S3)->putObjectFile($tmpfile, AWS_S3_BUCKET, 'UserConfig/'.$file, S3::ACL_PUBLIC_READ)){

      echo $furl = 'https://'.AWS_S3_BUCKET.".s3.amazonaws.com/UserConfig/".$file;

   }

   if(mysqli_num_rows($result) > 0){

        $updateconfig = "UPDATE user_config SET banner_logo_url = '".$furl."' where user_id = '".$_POST['userId']."'";

    	if( $con->query($updateconfig) === TRUE){

    	    $update_file = "UPDATE sentfile set updated = '1' where added_by = '".$_POST['userId']."'";

			$update_file_result = mysqli_query($con,$update_file);

			$update_package = "UPDATE package_list set updated = '1' where user_id = '".$_POST['userId']."'";

			$update_package_result = mysqli_query($con,$update_package);

    		//echo "true";

    	}else{

    		//echo "false";

    	}

    } else{

        $insertconfig = "INSERT into user_config(user_id,banner_logo_url,banner_color,page_bg_color_1,page_bg_color_2) VALUES('".$_POST['userId']."', '".$furl."', '".$_POST['bannerBg']."', '".$_POST['pageBg1']."', '".$_POST['pageBg2']."')";

        if( $con->query($insertconfig) === TRUE){

            $update_file = "UPDATE sentfile set updated = '1' where added_by = '".$_POST['userId']."'";

			$update_file_result = mysqli_query($con,$update_file);

			$update_package = "UPDATE package_list set updated = '1' where user_id = '".$_POST['userId']."'";

			$update_package_result = mysqli_query($con,$update_package);

    		//echo "true";

    	}else{

    		//echo "false";

    	}

    }

   exit;

}

if(isset($_POST['reset'])){

    $config_del = "DELETE from user_config where user_id = '" . $_POST['userId'] . "' ";

    $config_results = mysqli_query($con,$config_del);

    $update_file = "UPDATE sentfile set updated = '1' where added_by = '".$_POST['userId']."'";

	$update_file_result = mysqli_query($con,$update_file);

	$update_package = "UPDATE package_list set updated = '1' where user_id = '".$_POST['userId']."'";

	$update_package_result = mysqli_query($con,$update_package);

    if( $con->query($config_results) === TRUE){

		echo "true";

	}else{

		echo "false";

	}

    exit;

}

if(mysqli_num_rows($result) > 0){

    $updateconfig = "UPDATE user_config SET banner_color = '".$_POST['bannerBg']."', page_bg_color_1 = '".$_POST['pageBg1']."', page_bg_color_2 = '".$_POST['pageBg2']."' where user_id = '".$_POST['userId']."'";

	if( $con->query($updateconfig) === TRUE){

	    $update_file = "UPDATE sentfile set updated = '1' where added_by = '".$_POST['userId']."'";

		$update_file_result = mysqli_query($con,$update_file);

		$update_package = "UPDATE package_list set updated = '1' where user_id = '".$_POST['userId']."'";

		$update_package_result = mysqli_query($con,$update_package);

		echo "true";

	}else{

		echo "false";

	}

} else{

    $insertconfig = "INSERT into user_config(user_id,banner_color,page_bg_color_1,page_bg_color_2) VALUES('".$_POST['userId']."', '".$_POST['bannerBg']."', '".$_POST['pageBg1']."', '".$_POST['pageBg2']."')";

    if( $con->query($insertconfig) === TRUE){

        $update_file = "UPDATE sentfile set updated = '1' where added_by = '".$_POST['userId']."'";

		$update_file_result = mysqli_query($con,$update_file);

		$update_package = "UPDATE package_list set updated = '1' where user_id = '".$_POST['userId']."'";

		$update_package_result = mysqli_query($con,$update_package);

		echo "true";

	}else{

		echo "false";

	}

}