<?php
session_start();
require('../include/db.php');
require_once '../vendor/stripe/stripe-php/init.php'; 


$client_id 		= '0000000040678D4F';

$client_secret 	= 'ewiPOCTU31}eswtWC858=*!';

$redirect_uri 	= 'https://shareio.com/hotmail/callback.php';

$accesstoken = '';



$urls = 'https://login.live.com/oauth20_authorize.srf?client_id='.$client_id.'&scope=wl.signin%20wl.basic%20wl.emails%20wl.contacts_emails&response_type=code&redirect_uri='.$redirect_uri;


function curl_file_get_contents($url) {

	$ch = curl_init();

	curl_setopt($ch, CURLOPT_AUTOREFERER, TRUE);

	curl_setopt($ch, CURLOPT_HEADER, 0);

	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

	curl_setopt($ch, CURLOPT_URL, $url);

	curl_setopt($ch, CURLOPT_FOLLOWLOCATION, TRUE);

	$data = curl_exec($ch);

	curl_close($ch);

	return $data;

}

$auth_code = '';

if(isset($_GET["code"])){

$auth_code = $_GET["code"];

}



if(!empty($auth_code)){

	$fields=array(

		'code'=>  urlencode($auth_code),

		'client_id'=>  urlencode($client_id),

		'client_secret'=>  urlencode($client_secret),

		'redirect_uri'=>  urlencode($redirect_uri),

		'grant_type'=>  urlencode('authorization_code')

	);



	$post = '';

	foreach($fields as $key=>$value) { $post .= $key.'='.$value.'&'; }

	$post = rtrim($post,'&');

	$curl = curl_init();

	curl_setopt($curl,CURLOPT_URL,'https://login.live.com/oauth20_token.srf');

	curl_setopt($curl,CURLOPT_POST,5);

	curl_setopt($curl,CURLOPT_POSTFIELDS,$post);

	curl_setopt($curl, CURLOPT_RETURNTRANSFER,TRUE);

	curl_setopt($curl, CURLOPT_SSL_VERIFYPEER,0);

	$result = curl_exec($curl);

	curl_close($curl);

	$response =  json_decode($result);

	$accesstoken = $response->access_token;

	//$_SESSION['accesstoken'] = $accesstoken;

	$get_profile_url='https://apis.live.net/v5.0/me?access_token='.$accesstoken;

	$xmlprofile_res=curl_file_get_contents($get_profile_url);

	$profile_res = json_decode($xmlprofile_res, true);



	$userid 	= $profile_res['id'];

	$fname		= $profile_res['first_name'];

	$lname		= $profile_res['last_name'];

	$email		= $profile_res['emails']['account'];

	$loginwith	= "Hotmail";

	

	if(isset($_SESSION['contenturl'])){

      $sql="SELECT * FROM `cs_member` WHERE oauth_uid = '".$userid."'";
      $res=mysqli_query($con,$sql);
      if (mysqli_num_rows($res) > 0) {

		  $response = mysqli_fetch_array($res);
		  if(isset($_SESSION['fileid'])){

		    $checkpurchasesql="SELECT * FROM `sales` WHERE member_id = '".$response['cs_member_id']."' and file_id = '".$_SESSION['fileid']."'";
		    $checkpurchaseres=mysqli_query($con,$checkpurchasesql);
		    if (mysqli_num_rows($checkpurchaseres) > 0) {
		      $_SESSION['purchasedalr'] = 'true';
		      if(isset($_SESSION['filetype'])){
		        setcookie('purchased'.$_SESSION['fileid'], "Yes", time() + (86400 * 30), "/files/start");
		      } else{
		        setcookie('purchased'.$_SESSION['fileid'], "Yes", time() + (86400 * 30), "/file/");
		      }
		      $checkaccess = "SELECT * FROM access_list WHERE file_id = '".$_SESSION['fileid']."' AND member_id = '".$response['cs_member_id']."'";
              $checkaccessresult = mysqli_query($con,$checkaccess);
              if (mysqli_num_rows($checkaccessresult) > 0) {} else{
                $viewer_access_query = "INSERT INTO access_list(
                file_id,
                member_id
                ) VALUES(
                '" . addslashes($_SESSION['fileid']) . "',
                '" . addslashes($response['cs_member_id']) . "'
                )";
                $result = $con->query($viewer_access_query); 
              }
            }

            $checkaccess = "SELECT * FROM access_list WHERE file_id = '".$_SESSION['fileid']."' AND member_id = '".$response['cs_member_id']."'";
            $checkaccessresult = mysqli_query($con,$checkaccess);
            if (mysqli_num_rows($checkaccessresult) > 0) {
              $_SESSION['purchasedalr'] = 'true';
              if(isset($_SESSION['filetype'])){
                setcookie('purchased'.$_SESSION['fileid'], "Yes", time() + (86400 * 30), "/files/start");
              } else{
                setcookie('purchased'.$_SESSION['fileid'], "Yes", time() + (86400 * 30), "/file/");
              }
            }
		  }

		  if(isset($_SESSION['pkg_id'])){
            $checkpurchasesql="SELECT * FROM `sales` WHERE member_id = '".$response['cs_member_id']."' and package_id = '".$_SESSION['pkg_id']."'";
            $checkpurchaseres=mysqli_query($con,$checkpurchasesql);
            if (mysqli_num_rows($checkpurchaseres) > 0) {
              $checkpurchaseresponse = mysqli_fetch_array($checkpurchaseres);

              $package_data = "SELECT * from package_list where pkg_id  = '" . $_SESSION['pkg_id'] . "' ";
              $package_data_result = mysqli_query($con,$package_data);
              $package_data_fetch_data = mysqli_fetch_array($package_data_result);

              $now = time(); 
              $datediff = $now - strtotime($checkpurchaseresponse['sale_date']);
              $totalDays = round($datediff / (60 * 60 * 24));

              $period = '';
              if($package_data_fetch_data['sub_type'] == 'Day'){
                  $period = '1';
              } elseif($package_data_fetch_data['sub_type'] == 'Week'){
                  $period = '7';
              } elseif($package_data_fetch_data['sub_type'] == 'Month'){
                  $period = '30';
              } else{
                  $period = '365';
              }

              if($period >= $totalDays){
                $_SESSION['purchasedalr'] = 'true';
                $period = $period - $totalDays;
                setcookie('purchased'.$_SESSION['pkg_id'], "Yes", time() + (86400 * $period), "/package/");

                $file_list_query = "SELECT * FROM package_file_list WHERE pkg_fid = '".$_SESSION['pkg_id']."'";
                $file_list_query_result = mysqli_query($con,$file_list_query);
                while($file_list = mysqli_fetch_array($file_list_query_result)){
                    $file_query = "SELECT * FROM sentfile where file_id = '" . $file_list['file_fid'] . "'";
                    $file_query_result = mysqli_query($con,$file_query);
                    $file = mysqli_fetch_array($file_query_result);
                    if($file['file_type'] == 'audio/mpeg' || $file['file_type'] == 'audio/mp3'){
                        setcookie('purchased'.$file_list['file_fid'], "Yes", time() + (86400 * $period), "/files/start");
                    } else{
                        setcookie('purchased'.$file_list['file_fid'], "Yes", time() + (86400 * $period), "/file/");
                    }
                }
              }
              $checkaccess = "SELECT * FROM access_list WHERE package_id = '".$_SESSION['pkg_id']."' AND member_id = '".$response['cs_member_id']."'";
              $checkaccessresult = mysqli_query($con,$checkaccess);
              if (mysqli_num_rows($checkaccessresult) > 0) {} else{
                $viewer_access_query = "INSERT INTO access_list(
                package_id,
                member_id
                ) VALUES(
                '" . addslashes($_SESSION['pkg_id']) . "',
                '" . addslashes($response['cs_member_id']) . "'
                )";
                $result = $con->query($viewer_access_query);
              }
            } 
            $checkaccess = "SELECT * FROM access_list WHERE package_id = '".$_SESSION['pkg_id']."' AND member_id = '".$response['cs_member_id']."'";
            $checkaccessresult = mysqli_query($con,$checkaccess);
            if (mysqli_num_rows($checkaccessresult) > 0) {
              $status = 1;
              $checkpurchaseresponse = mysqli_fetch_array($checkpurchaseres);

              $package_data = "SELECT * from package_list where pkg_id  = '" . $_SESSION['pkg_id'] . "' ";
              $package_data_result = mysqli_query($con,$package_data);
              $package_data_fetch_data = mysqli_fetch_array($package_data_result);

              $now = time(); 
              $datediff = $now - strtotime($checkpurchaseresponse['sale_date']);
              $totalDays = round($datediff / (60 * 60 * 24));

              $period = '';
              if($package_data_fetch_data['sub_type'] == 'Day'){
                  $period = '1';
              } elseif($package_data_fetch_data['sub_type'] == 'Week'){
                  $period = '7';
              } elseif($package_data_fetch_data['sub_type'] == 'Month'){
                  $period = '30';
              } else{
                  $period = '365';
              }

              if($period >= $totalDays){
                $_SESSION['purchasedalr'] = 'true';
                $period = $period - $totalDays;
                setcookie('purchased'.$_SESSION['pkg_id'], "Yes", time() + (86400 * $period), "/package/");

                $file_list_query = "SELECT * FROM package_file_list WHERE pkg_fid = '".$_SESSION['pkg_id']."'";
                $file_list_query_result = mysqli_query($con,$file_list_query);
                while($file_list = mysqli_fetch_array($file_list_query_result)){
                    $file_query = "SELECT * FROM sentfile where file_id = '" . $file_list['file_fid'] . "'";
                    $file_query_result = mysqli_query($con,$file_query);
                    $file = mysqli_fetch_array($file_query_result);
                    if($file['file_type'] == 'audio/mpeg' || $file['file_type'] == 'audio/mp3'){
                        setcookie('purchased'.$file_list['file_fid'], "Yes", time() + (86400 * $period), "/files/start");
                    } else{
                        setcookie('purchased'.$file_list['file_fid'], "Yes", time() + (86400 * $period), "/file/");
                    }
                }
              } 
            }
          }

		  $_SESSION['member'] = $facebook_user_info['id'];
		  $_SESSION['member_id'] = $response['cs_member_id'];
		  $_SESSION['checkout'] = 'true';
		  $_SESSION['useremail'] = $email;
		  $_SESSION['succsessmsg'] = "You have Successfully logged in with Hotmail";
		  header("Location: ../".$_SESSION['contenturl']); 
		  exit;
		} else{

		  $date = date("Y-m-d H:i:s");
		  $sql = "INSERT INTO cs_member(member_email,oauth_uid,create_date) VALUES('".$email."','".$userid."','".$date."')";
		  $res = mysqli_query($con,$sql);
		  $_SESSION['member'] = $facebook_user_info['id'];
		  $_SESSION['member_id'] = mysqli_insert_id($con);
		  $_SESSION['checkout'] = 'true';
		  $_SESSION['useremail'] = $email;
		  $_SESSION['succsessmsgmember'] = "You have Successfully logged in with Hotmail";
		  header("Location: ../".$_SESSION['contenturl']);  
		  exit;
		}
    } else{
    	unset($_SESSION['is_blocked']);
		$sql="SELECT * FROM `cs_users` WHERE oauth_uid = '".$userid."'";
		$res=mysqli_query($con,$sql);
		if (mysqli_num_rows($res) > 0) {
			$response = mysqli_fetch_array($res);
			if($response['is_blocked'] == '1'){
	           $_SESSION['is_blocked'] = "true";
	        }
			$_SESSION['user'] = $userid;
			$_SESSION['succsessmsgmember'] = "You have Successfully logged in with Hotmail";
			$_SESSION['succses'] = "You have Successfully logged in with Hotmail";
			header("Location: ../dashboard.php?s=1"); 
		    exit;
		}

		else{
			\Stripe\Stripe::setApiKey('sk_test_ZHBPscwQ2uvawFY7Fq1E3DAC');
			$account = \Stripe\Account::create([
				'country' => 'US',
				'type' => 'express',
			]);

			$id = $account['id'];
			$account_links = \Stripe\AccountLink::create([
				'account' => $id,
				'refresh_url' => 'https://shareio.com/',
				'return_url' => 'https://shareio.com/dashboard.php',
				'type' => 'account_onboarding',
			]);
			$url = $account_links['url'];
			$date = date("Y-m-d");

			$systemsql = "SELECT * FROM `system_data` WHERE system_id = '1'";
			$systemresult = mysqli_query($con,$systemsql);
			$system_data = mysqli_fetch_array($systemresult);
	        if($system_data['block_signup'] == '1'){
	           $_SESSION['is_blocked'] = "true";
	        }  
			$sql = "INSERT INTO cs_users(fname,lname,email,active,oauth_uid,stripe_acc_id,stripe_acc_url,create_date,impressions,is_blocked) VALUES('".$fname."','".$lname."','".$email."','1','".$userid."','".$id."','".$url."', '".$date."','100','".$system_data['block_signup']."')";
			$res=mysqli_query($con,$sql);
			$_SESSION['succsessmsg'] = "You have Successfully logged in with Hotmail";
			$_SESSION['succses'] = "You have Successfully logged in with Hotmail";
			$_SESSION['user'] = $userid;
			header("Location: ../dashboard.php?s=1"); 
		    exit;
		}
	}



}
