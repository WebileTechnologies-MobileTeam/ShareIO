<?php
//ini_set('display_errors', 0);
error_reporting(0);
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
    header("Location: ../dashboard.php?s=1");
    exit;
}


if(isset($_POST['file_type'])){
	$fileuploadlink = '';
	$URLforimagick = '';
	$file_name = basename($_POST['fileurl']);
	if(!empty($_POST['fileurl'])){
	$fileuploadlink = $_POST['fileurl']; 
    	if (strpos($fileuploadlink, SITE_URL) == false) {
            $URLforimagick = 'https://contentshare-files.s3.amazonaws.com/Files/'.urlencode($file_name);
        } else{
            $URLforimagick = $fileuploadlink;
        }
	}
	$file_type = $_POST['file_type'];
	//echo $file_type;exit;
	$number = $_POST['number'];
	if($_POST['price'] != ''){
		$price = $_POST['price'];
	} else{
		$price = '0';
	}
	$w_type = $_POST['w_type'];
	$trial_start = $_POST['trial_start'];
	$trial_end = $_POST['trial_end'];
	$evaluation_type = $_POST['evaluation_type'];
	$evaluation_value = $_POST['evaluation_value'];
	$evaluation_date = $_POST['evaluation_date'];
	$password = $_POST['password'];
	$ip_dns = $_POST['ip_dns'];
	$watermark = '';
	$image_path = '';
	$file_path = '';
	$addfile_path = '';
	$paused = '0';
	$browser_enabled = $_POST['browser_view'];
	$notification = $_POST['notification'];
	$social_share = $_POST['social_share'];
	$download = $_POST['download'];
	$hide_banner = $_POST['hide_banner'];
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
			//echo "<span id='invalid'>***Invalid file Size or Type***<span>";
		}
	}
	$watermark = $image_path;
	}
}
	
    $additional_file_url = '';
    if(isset($_FILES["addfile"]["type"]) && !empty($_FILES["addfile"])){
	//For Additional file upload
    	$tmpfile = $_FILES['addfile']['tmp_name'];
        $file = $_FILES['addfile']['name'];
        
    //if (defined('AWS_S3_URL')) {
      // Persist to AWS S3 and delete uploaded file
      S3::setAuth(AWS_S3_KEY, AWS_S3_SECRET);
      (new S3)->setRegion(AWS_S3_REGION);
      S3::setSignatureVersion('v4');
      if((new S3)->putObjectFile($tmpfile, AWS_S3_BUCKET, 'AdditionalFiles/'.$file, S3::ACL_PUBLIC_READ)){
         $additional_file_url = 'https://'.AWS_S3_BUCKET.".s3.amazonaws.com/AdditionalFiles/".$file;
      } else {
	
		$validextensions = array("pdf", "doc", "docx","jpeg", "jpg", "png");
		$temporary = explode(".", $_FILES["addfile"]["name"]);
		$file_extension = end($temporary);
		if((($_FILES["addfile"]["type"] == "application/pdf") || ($_FILES["addfile"]["type"] == "application/doc") || ($_FILES["addfile"]["type"] == "application/docx") || ($_FILES["addfile"]["type"] == "image/png") || ($_FILES["addfile"]["type"] == "image/jpg") || ($_FILES["addfile"]["type"] == "image/jpeg")
			) && ($_FILES["addfile"]["size"] < 11097152)//Approx. 11mb files can be uploaded.
			){
			if($_FILES["addfile"]["error"] > 0){
				//echo "Return Code: " . $_FILES["addfile"]["error"] . "<br/><br/>";
			}
			else{
				if(file_exists("upload/" . $_FILES["addfile"]["name"])){
					$msg =  $_FILES["addfile"]["name"] . " <span id='invalid'><b>already exists.</b></span> ";
				}
				else{
					$sourcePath = $_FILES['addfile']['tmp_name']; // Storing source path of the file in a variable
					$targetPath = "../upload/".date("dmyhis").$_FILES['addfile']['name']; // Target path where file is to be stored
					move_uploaded_file($sourcePath,$targetPath) ; // Moving Uploaded file
					$additional_file_url = SITE_URL.'/upload/'.date("dmyhis").$_FILES['addfile']['name'];
				}
			}
		}
		else{
			//$addfile_path = '';
			//echo "<span id='invalid'>***Invalid123 file Size or Type***<span>";
		}
	}
    }
	
	date_default_timezone_set('Europe/London');
	$datetime = gmdate("Y-m-d H:i:s");
	$hash = $file_name;
	$hash .= $fileuploadlink;
	$file_md5 = md5($hash)	;

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
	$thumbnailImage = '';
	if($file_type == 'image/jpeg' || $file_type == 'image/png' || $file_type == 'image/jpg' || $file_type == 'image/gif'){
		$im = new imagick($URLforimagick);
		$im->setImageFormat('jpg');
		//$im->thumbnailImage(600, 315, true, true);
		//$image->setCompressionQuality(90);
		$im->writeImage('../upload/thumb'.$file_md.'.jpg');

		$thumbnailImage = $im;
	} elseif ($file_type == 'application/pdf') {
	    $pdffile = file_get_contents($URLforimagick);
	    //echo $URLforimagick;
		$im = new imagick($URLforimagick);
		$im->setIteratorIndex(0);
		$im->setImageFormat('jpg');
		//$im->thumbnailImage(800, 800, true, true);
		//$image->setCompressionQuality(90);
		$im->writeImage('../upload/thumb'.$file_md.'.jpg');

		$thumbnailImage = $im;
	}
	$thumbnailImage = SITE_URL.'/upload/thumb'.$file_md.'.jpg';
	if($file_type == 'audio/mp3' || $file_type == 'audio/mpeg'){
	    if(isset($_SESSION['thuburl'])){
	        $thumbnailImage = $_SESSION['thuburl'];
	    } else{
	        $thumbnailImage = '';
	    }
	}
	
	//$sql = "UPDATE files SET type = '" . addslashes($user) . "', pages = '" . addslashes($number) . "', price = '" . addslashes($price) . "', watermark_type = '" . addslashes($w_type) . "', watermark = '" . addslashes($watermark) . "', file = '" . addslashes($file_path) . "', additional_file = '" . addslashes($addfile_path) . "'";



	$query = "INSERT INTO sentfile(
	added_by,
	file_type,
	watermark_type,
	watermark_text,
	file_name,
	file_thumbnail,
	file_url,
	file_md5,
	file_length,
	evalution_type,
	evalution_value,
	evalution_date,
	file_price,
	file_hash,
	additional_file_url,
	password,
	ip_dns,
	paused,
	date_time,
	browser_enabled,
	notification,
	social_share,
	download,
	hide_banner,
	block_countries
	) VALUES(
	'" . addslashes($user) . "',
	'" . addslashes($file_type) . "',
	'" . addslashes($w_type) . "',
	'" . addslashes($watermark) . "',
	'" . addslashes($file_name) . "',
	'" . addslashes($thumbnailImage) . "',
	'" . addslashes($fileuploadlink) . "',
	'" . addslashes($file_md) . "',
	'" . addslashes($number) . "',
	'" . addslashes($evaluation_type) . "',
	'" . addslashes($evaluation_value) . "',
	'" . addslashes($evaluation_date) . "',
	'" . addslashes($price) . "',
	'" . addslashes($file_md) . "',
	'" . addslashes($additional_file_url) . "',
	'" . addslashes($password) . "',
	'" . addslashes($ip_dns) . "',
	'" . addslashes($paused) . "',
	'" . addslashes($datetime) . "',
	'" . addslashes($browser_enabled) . "',
	'" . addslashes($notification) . "',
	'" . addslashes($social_share) . "',
	'" . addslashes($download) . "',
	'" . addslashes($hide_banner) . "',
	'" . addslashes($block_country) . "'
	)";


		if( $con->query($query) === TRUE ){
			$last_id = $con->insert_id;
            unset($_SESSION['thuburl']);
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


			if(!empty($trial_start) && !empty($trial_end)){
				if($file_type == "application/pdf"){
					$trial_query = "INSERT INTO trial_setting(
					fileid,
					page_start,
					page_end
					) VALUES(
					'" . addslashes($last_id) . "',
					'" . addslashes($trial_start) . "',
					'" . addslashes($trial_end) . "'
					)";
					$result = $con->query($trial_query);
				} else{
					$trial_query = "INSERT INTO trial_setting(
					fileid,
					t_start,
					t_end
					) VALUES(
					'" . addslashes($last_id) . "',
					'" . addslashes($trial_start) . "',
					'" . addslashes($trial_end) . "'
					)";
					$result = $con->query($trial_query);
				}
		    }

		    if(isset($_POST['viewer_access_list'])){
				foreach ($_POST['viewer_access_list'] as $viewer) {
					$viewer_access_query = "INSERT INTO access_list(
					file_id,
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
					file_id,
					group_id
					) VALUES(
					'" . addslashes($last_id) . "',
					'" . addslashes($group) . "'
					)";
					$result = $con->query($group_access_query);
				}
			}


		    $tempDir = '../upload/';

		    $codeContents = '';
		    if($file_type == 'audio/mpeg' || $file_type == 'audio/mp3'){
				$codeContents = SITE_URL.'/files/start/'.$file_md;
			} else{
				$codeContents = SITE_URL.'/file/'.$file_md;
			}
			$fileName = $file_md.'qrcode.png';

			$pngAbsoluteFilePath = $tempDir.$fileName;
			$urlRelativeFilePath = $tempDir.$fileName;

			QRcode::png($codeContents, $pngAbsoluteFilePath); 

			$path = SITE_URL."/upload/".$fileName;

			$sql = "UPDATE sentfile set file_qr = '".$path."' where file_id = '".$last_id."'";
			$result = $con->query($sql);
		
			$_SESSION['succsessmsg'] = 'Data Added Successfully';
			//echo "1";
		    header("Location: ../reports.php");
			}else{
				$_SESSION['error'] = 'There is some issue please try again.';
				//echo "0";
			    header("Location: ../dashboard.php?s=1");
			}
        }

	

