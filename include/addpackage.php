<?php
//ini_set('display_errors', 1);
session_start();
require_once './db.php';
require_once './inc/defined_variables.php';
include('../QRcode/phpqrcode/qrlib.php');
if(!class_exists('S3'))require_once('S3Bucket_config.php');

$user = $_SESSION['user'];

$check_impression = "SELECT * FROM cs_users where id = '".$user."' OR oauth_uid = '".$user."'";
$result = mysqli_query($con,$check_impression);
$data = mysqli_fetch_array($result);
$impressions = $data['impressions'];
if($impressions <1 || $impressions == '0' || $impressions == ''){	
	$_SESSION['errormsgimp'] = 'You not have enough impressions.';
    header("Location: ../AddPackage.php");
    exit;
}

	$package_name = $_POST['Package_Name'];
	$w_type = $_POST['w_type'];
	$evaluation_type = $_POST['evaluation_type'];
	$evaluation_value = $_POST['evaluation_value'];
	$evaluation_date = $_POST['evaluation_date'];
    $subscription_type = $_POST['subscription_type'];
	$browser_enabled = $_POST['browser_view'];
	$notification = $_POST['notification'];
	$social_share = $_POST['social_share'];
	$password = $_POST['password'];
	$ip_dns = $_POST['ip_dns'];
	$hide_banner = $_POST['hide_banner'];
    $subscription_price_day = '';
    $subscription_price_week = '';
    $subscription_price_month = '';
    $subscription_price_year = '';
    if($subscription_type == 'Day'){
		$subscription_price_day = $_POST['price'];
	} elseif($subscription_type == 'Week'){
		$subscription_price_week = $_POST['price'];
	} elseif($subscription_type == 'Month'){
		$subscription_price_month = $_POST['price'];
	} elseif($subscription_type == 'Year'){
		$subscription_price_year = $_POST['price'];
	}
	$watermark = '';
	$image_path = '';
	$file_path = '';
	
	$block_country = json_encode($_POST['block_country']);
	// print_r($block_country);
	// exit;
	if($w_type == 'None'){

	} else{
	//For watermark text or image file upload
	if($w_type == 'Text'){
		$watermark = $_POST['watermark_text'];
	}else{
	if(isset($_FILES["file"]["type"])){
		$validextensions = array("jpeg", "jpg", "png");
		$temporary = explode(".", $_FILES["file"]["name"]);
		$file_extension = end($temporary);
		if((($_FILES["file"]["type"] == "image/png") || ($_FILES["file"]["type"] == "image/jpg") || ($_FILES["file"]["type"] == "image/jpeg")
			) && ($_FILES["file"]["size"] < 11097152)//Approx. 11mb files can be uploaded.
			&& in_array($file_extension, $validextensions)){
			if($_FILES["file"]["error"] > 0){
				echo "Return Code: " . $_FILES["file"]["error"] . "<br/><br/>";
			}
			else{
				if(file_exists("upload/" . $_FILES["file"]["name"])){
					$msg =  $_FILES["file"]["name"] . " <span id='invalid'><b>already exists.</b></span> ";
				}
				else{
					$sourcePath = $_FILES['file']['tmp_name']; // Storing source path of the file in a variable
					$targetPath = "../upload/".date("dmyhis").$_FILES['file']['name']; // Target path where file is to be stored
					move_uploaded_file($sourcePath,$targetPath) ; // Moving Uploaded file
					$image_path = SITE_URL.'/upload/'.date("dmyhis").$_FILES['file']['name'];
				}
			}
		}
		else{
			echo "<span id='invalid'>***Invalid file Size or Type***<span>";
		}
	}
	$watermark = $image_path;
	}
}
	
    	
	date_default_timezone_set('Europe/London');
	$datetime = gmdate("Y-m-d H:i:s");
	$hash = $package_name;
	$file_md5 = md5($hash);

	function generateRandomString($length = 10) {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    // for ($i = 0; $i < 23; $i++) {
    //     $randomString .= $file_md5[rand(0, $charactersLength - 1)];
    // }
    return $randomString;
	}

	$url = generateRandomString();
	$new = substr($file_md5,10);
	$file_md = $new;
	$file_md .= $url;
		
	$query = "INSERT INTO package_list(
	pkg_name,
	user_id,
	evalution_type,
	evalution_value,
	evalution_date,
	sub_type,
	sub_price_day,
	sub_price_week,
	sub_price_month,
	sub_price_year,
	watermark_type,
	watermark_text,
	password,
	ip_dns,
	browser_enabled,
	notification,
	social_share,
	hide_banner,
	pkg_url,
	pkg_created_date,
	block_countries
	) VALUES(
	'" . addslashes($package_name) . "',
	'" . addslashes($user) . "',
	'" . addslashes($evaluation_type) . "',
	'" . addslashes($evaluation_value) . "',
	'" . addslashes($evaluation_date) . "',
	'" . addslashes($subscription_type) . "',
	'" . addslashes($subscription_price_day) . "',
	'" . addslashes($subscription_price_week) . "',
	'" . addslashes($subscription_price_month) . "',
	'" . addslashes($subscription_price_year) . "',
	'" . addslashes($w_type) . "',
	'" . addslashes($watermark) . "',
	'" . addslashes($password) . "',
	'" . addslashes($ip_dns) . "',
	'" . addslashes($browser_enabled) . "',
	'" . addslashes($notification) . "',
	'" . addslashes($social_share) . "',
	'" . addslashes($hide_banner) . "',
	'" . addslashes($file_md) . "',
	'" . addslashes($datetime) . "',
	'" . addslashes($block_country) ."'
	)";


		if( $con->query($query) === TRUE ){
			$last_id = $con->insert_id;
			$imp = (int)$impressions - 1;
			$imp_update = "UPDATE cs_users set impressions = '".$imp."' where id = '".$user."' OR oauth_uid = '".$user."'";
			$imp_update_result = $con->query($imp_update);

			$imp_date = date('Y-m-d');
			$imp_query = "INSERT INTO file_impression(
					file_id,
					impression,
					imp_date
					) VALUES(
					'" . addslashes($last_id) . "',
					'1',
					'" . addslashes($imp_date) . "'
					)";
			$imp_query_result = $con->query($imp_query);
            
            $file_list = $_POST['file_list'];

            foreach($file_list as $file){
                echo $file_query = "INSERT INTO package_file_list(
                pkg_fid,
                file_fid
                ) VALUES(
                '" . addslashes($last_id) . "',
                '" . addslashes($file) . "'
                )";
                $result = $con->query($file_query);
            }

            if(isset($_POST['viewer_access_list'])){
				foreach ($_POST['viewer_access_list'] as $viewer) {
					$viewer_access_query = "INSERT INTO access_list(
					package_id,
					member_id
					) VALUES(
					'" . addslashes($last_id) . "',
					'" . addslashes($viewer) . "'
					)";
					$result = $con->query($viewer_access_query);
				}
			}

			if(isset($_POST['group_access_list'])){
				foreach ($_POST['group_access_list'] as $group) {
					$group_access_query = "INSERT INTO access_list(
					package_id,
					group_id
					) VALUES(
					'" . addslashes($last_id) . "',
					'" . addslashes($group) . "'
					)";
					$result = $con->query($group_access_query);
				}
			}

		    $tempDir = '../upload/';

			$codeContents = SITE_URL.'/package/'.$file_md;
			$fileName = $file_md.'qrcode.png';

			$pngAbsoluteFilePath = $tempDir.$fileName;
			$urlRelativeFilePath = $tempDir.$fileName;

			QRcode::png($codeContents, $pngAbsoluteFilePath); 

			$path = SITE_URL."/upload/".$fileName;

			$sql = "UPDATE package_list set pkg_qr = '".$path."' where pkg_id  = '".$last_id."'";
			$result = $con->query($sql);
		
			$_SESSION['succsessmsg'] = 'Package Added Successfully';
		    header("Location: ../reports.php?p=1");
			}else{
				$_SESSION['error'] = 'There is some issue please try again.';
			    header("Location: ../AddPackage.php");
			}
        

	

