<?php
ini_set('display_errors', 1);
session_start();
require_once './db.php';
require_once './inc/defined_variables.php';
if(!class_exists('S3'))require_once('S3Bucket_config.php');

$user = $_SESSION['user'];

$check_impression = "SELECT * FROM cs_users where id = '".$user."' OR oauth_uid = '".$user."'";
$result = mysqli_query($con,$check_impression);
$data = mysqli_fetch_array($result);
$impressions = $data['impressions'];
if($impressions <1 || $impressions == '0' || $impressions == ''){	
	$_SESSION['errormsgimp'] = 'You not have enough impressions.';
    header("Location: ../edit-file.php?id=".$_POST['file_id']);
    exit;
}

if(isset($_POST['file_id'])){
	 
	$fileuploadlink = '';
	$URLforimagick = '';
	$file_name = '';
	$thumbnailImage = '';
	$thumbnailImage_qer = '';
	$file_type = $_POST['file_type'];
	if(!empty($_POST['fileurl'])){
	$fileuploadlink = $_POST['fileurl']; 
	if (strpos($fileuploadlink, SITE_URL) == false) {
        $file_name = substr($_POST['fileurl'],54);
        $URLforimagick = 'https://contentshare-files.s3.us-east-2.amazonaws.com/Files/'.urlencode($file_name);
    } else{
        $file_name = substr($_POST['fileurl'],43);
        $URLforimagick = $fileuploadlink;
    }
	
	$datetime = date("Y-m-d h:i:s");
	$hash = $file_name;
	$hash .= $fileuploadlink;
	$file_md5 = md5($hash);
	if($file_type == 'image/jpeg' || $file_type == 'image/png' || $file_type == 'image/jpg'){
        echo $URLforimagick;
		$im = new imagick($URLforimagick);
		$im->setImageFormat('jpg');
		$im->thumbnailImage(600, 315, true, true);
		//$image->setCompressionQuality(90);
		$im->writeImage('../upload/thumb'.$file_md5.'.jpg');

		$thumbnailImage = $im;
	} elseif ($file_type == 'application/pdf') {
		$im = new imagick($URLforimagick);
		$im->setIteratorIndex(0);
		$im->setImageFormat('jpg');
		$im->thumbnailImage(800, 515, true, true);
		//$image->setCompressionQuality(90);
		$im->writeImage('../upload/thumb'.$file_md5.'.jpg');

		$thumbnailImage = $im;
	}
	$thumbnailImage = SITE_URL.'/upload/thumb'.$file_md5.'.jpg';
	if($file_type == 'mp3' || $file_type == 'mpeg'){
	    if(isset($_SESSION['thuburl'])){
	        $thumbnailImage = $_SESSION['thuburl'];
	    } else{
	        $thumbnailImage = '';
	    }
	}
	$thumbnailImage_qer = ", file_thumbnail = '".$thumbnailImage."'";
	} else{
	$fileuploadlink = $_POST['file_url']; 
	$file_name = $_POST['filename'];
	}
	//$file_name = $_FILES['addfile']['name'];
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
	$watermark_image = '';
	$image_path = $_POST['watermark_image'];
	$file_path = '';
	$addfile_path = '';
	$paused = '';
	$browser_enabled = $_POST['browser_view'];
	$notification = $_POST['notification'];
	$social_share = $_POST['social_share'];
	$download = $_POST['download'];
	$hide_banner = $_POST['hide_banner'];
	$block_country = json_encode($_POST['block_country']);
	
	if($w_type == 'None'){

	} else{
	//For watermark text or image file upload
	if($w_type == 'Text'){
		$watermark = $_POST['watermark_text'];
		$image_path = '';
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
	$watermark_image = $image_path;
	}
}


	//For Additional file upload
	$additional_file_url = $_POST['addfileUrl'];
    if(isset($_FILES["addfile"]["type"])){
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
				echo "Return Code: " . $_FILES["addfile"]["error"] . "<br/><br/>";
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
			echo "<span id='invalid'>***Invalid123 file Size or Type***<span>";
		}
	}
    }
	
	$datetime = date("Y-m-d h:i:s");
	$hash = $file_name;
	$hash .= $fileuploadlink;
	$file_md5 = md5($hash);

	function generateRandomString($length = 10) {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
	}

	$url = generateRandomString();
	$new = substr($file_md5,10);
	$file_md = $new;
	$file_md .= $url;

	 $sql = "UPDATE sentfile SET file_type = '" . addslashes($file_type) . "', watermark_type = '" . addslashes($w_type) . "', watermark_text = '" . addslashes($watermark) . "',watermark_image = '" . addslashes($watermark_image) . "', file_name = '" . addslashes($file_name) . "', file_url = '" . addslashes($fileuploadlink) . "', file_md5 = '" . addslashes($file_md) . "', file_length = '" . addslashes($number) . "', evalution_type = '". addslashes($evaluation_type) ."', evalution_value = '". addslashes($evaluation_value) ."', evalution_date = '". addslashes($evaluation_date) ."', file_price = '". addslashes($price) ."', additional_file_url = '". addslashes($additional_file_url) ."', password = '". addslashes($password) ."', ip_dns = '". addslashes($ip_dns) ."' $thumbnailImage_qer, browser_enabled = '" . addslashes($browser_enabled) . "', notification = '" . addslashes($notification) . "', social_share = '" . addslashes($social_share) . "', download = '" . addslashes($download) . "', hide_banner = '" . addslashes($hide_banner) . "', block_countries = '" . addslashes($block_country) . "', updated = '1' where file_id = '".$_POST['file_id']."'";
		if( $con->query($sql) === TRUE){
			$_SESSION['succsessmsg'] = 'Data Updated Successfully';

					$imp = (int)$impressions - 1;
					$imp_update = "UPDATE cs_users set impressions = '".$imp."' where id = '".$user."' OR oauth_uid = '".$user."'";
					$imp_update_result = $con->query($imp_update);

					$imp_date = date('Y-m-d');
					$imp_query = "INSERT INTO file_impression(
								file_id,
								impression,
								imp_date
								) VALUES(
								'" . addslashes($_POST['file_id']) . "',
								'1',
								'" . addslashes($imp_date) . "'
								)";
					$imp_query_result = $con->query($imp_query);


				if(!empty($trial_start) && !empty($trial_end)){
					if($file_type == "application/pdf"){
						$trial_query = "UPDATE trial_setting SET page_start = '".$trial_start."', page_end = '".$trial_end."' where fileid = '".$_POST['file_id']."'";
						$result = $con->query($trial_query);
					} else{
						$trial_query = "UPDATE trial_setting SET t_start = '".$trial_start."', t_end = '".$trial_end."' where fileid = '".$_POST['file_id']."'";
						$result = $con->query($trial_query);
					}
				}

				$deleteaccessview = "DELETE FROM access_list WHERE file_id = '".$_POST['file_id']."'";
				$deleteaccessviewresult = $con->query($deleteaccessview);

				if(isset($_POST['viewer_access_list'])){
					foreach ($_POST['viewer_access_list'] as $viewer) {
						$viewer_access_query = "INSERT INTO access_list(
						file_id,
						member_id
						) VALUES(
						'" . addslashes($_POST['file_id']) . "',
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
						'" . addslashes($_POST['file_id']) . "',
						'" . addslashes($group) . "'
						)";
						$result = $con->query($group_access_query);
					}
				}


		
				header("Location: ../edit-file.php?id=".$_POST['file_id']."");
			}else{
			    header("Location: ../index.php");
			}
        }

