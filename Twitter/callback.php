<?php
session_start();
require 'autoload.php';
include('../include/db.php');
require_once '../vendor/stripe/stripe-php/init.php'; 

use Abraham\TwitterOAuth\TwitterOAuth;

define('CONSUMER_KEY', 'UZdhZG8Fs6oXPn1GyAt7kzhuO'); 	// add your app consumer key between single quotes
define('CONSUMER_SECRET', 'UjM8gzoTWamBq0lffrkzwPLJpPyZyfjeICu0ISzhTgWy0Atv5d'); // add your app consumer 																			secret key between single quotes
define('OAUTH_CALLBACK', 'https://shareio.com/Twitter/callback.php'); // your app callback URL i.e. page

if (isset($_REQUEST['oauth_verifier'], $_REQUEST['oauth_token']) && $_REQUEST['oauth_token'] == $_SESSION['oauth_token']) {			   //In project use this session to change login header after successful login 
	$request_token = [];
	$request_token['oauth_token'] = $_SESSION['oauth_token'];
	$request_token['oauth_token_secret'] = $_SESSION['oauth_token_secret'];
	$connection = new TwitterOAuth(CONSUMER_KEY, CONSUMER_SECRET, $request_token['oauth_token'], $request_token['oauth_token_secret']);
	$access_token = $connection->oauth("oauth/access_token", array("oauth_verifier" => $_REQUEST['oauth_verifier']));
	$_SESSION['access_token'] = $access_token;
	$connection = new TwitterOAuth(CONSUMER_KEY, CONSUMER_SECRET, $access_token['oauth_token'], $access_token['oauth_token_secret']);
	$user = $connection->get("account/verify_credentials", ['include_email' => 'true']);
//    $user1 = $connection->get("https://api.twitter.com/1.1/account/verify_credentials.json", ['include_email' => true]);
//     echo "<img src='$user->profile_image_url'>";echo "<br>";		//profile image twitter link
//     echo $user->name;echo "<br>";									//Full Name
//     echo $user->location;echo "<br>";								//location
//     echo $user->screen_name;echo "<br>";							//username
//     echo $user->created_at;echo "<br>";
// //    echo $user->profile_image_url;echo "<br>";
//     echo $user->email;echo "<br>";									//Email, note you need to check permission on Twitter App Dashboard and it will take max 24 hours to use email 
//     echo "<pre>";
//     print_r($user);
//     echo "<pre>";
    if(isset($_SESSION['contenturl'])){

      $sql="SELECT * FROM `cs_member` WHERE oauth_uid = '".$user->id."'";
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
          $_SESSION['succsessmsgmember'] = "You have Successfully logged in with Twitter";
          header("Location: ../".$_SESSION['contenturl']); 
      } else{

          $date = date("Y-m-d H:i:s");
          $sql = "INSERT INTO cs_member(member_email,oauth_uid,create_date) VALUES('".$email."','".$user->id."','".$date."')";
          $res = mysqli_query($con,$sql);
          $_SESSION['member'] = $facebook_user_info['id'];
          $_SESSION['member_id'] = mysqli_insert_id($con);
          $_SESSION['checkout'] = 'true';
          $_SESSION['succsessmsgmember'] = "You have Successfully logged in with Twitter";
          header("Location: ../".$_SESSION['contenturl']);  
      }
    } else{
      unset($_SESSION['is_blocked']);
      $sql="SELECT * FROM `cs_users` WHERE oauth_uid = '".$user->id."'";

    
          $res=mysqli_query($con,$sql);
          if (mysqli_num_rows($res) > 0) {
              $response = mysqli_fetch_array($res);
              
              if($response['user_profile_url'] == ''){
                  $profile_photo_url = str_replace('_normal', '_200x200', $user->profile_image_url);
                $updatesql = "UPDATE cs_users SET user_profile_url = '".$profile_photo_url."' WHERE oauth_uid = '".$user->id."'";
                $updres = mysqli_query($con,$updatesql);
            }
          // output data of each row
            $response = mysqli_fetch_array($res);
            if($response['is_blocked'] == '1'){
               $_SESSION['is_blocked'] = "true";
            }
            $_SESSION['user'] = $user->id;
            $_SESSION['user_id'] = $response['id'];
            $_SESSION['succsessmsg'] = "You have Successfully logged in with Twitter";
            
            header("Location: ../dashboard.php?s=1");
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
            
            $profile_photo_url = str_replace('_normal', '_200x200', $user->profile_image_url);
            $systemsql = "SELECT * FROM `system_data` WHERE system_id = '1'";
            $systemresult = mysqli_query($con,$systemsql);
            $system_data = mysqli_fetch_array($systemresult);
            if($system_data['block_signup'] == '1'){
              $_SESSION['is_blocked'] = "true";
            }
            $sql = "INSERT INTO cs_users(fname,active,oauth_uid,stripe_acc_id,stripe_acc_url,user_profile_url,create_date,impressions,is_blocked) VALUES('".$user->name."','1','".$user->id."','".$id."','".$url."','".$profile_photo_url."','".$date."','100','".$system_data['block_signup']."')";

            $res = mysqli_query($con,$sql);
            $_SESSION['user'] = $user->id;
            $_SESSION['user_id'] = mysqli_insert_id($con);;
            $_SESSION['succsessmsg'] = "You have Successfully logged in with Twitter";
            header("Location: ../dashboard.php?s=1");
          }
        }
	// redirect user back to index page
	//header("location:index.php");
}
if(isset($_REQUEST['denied'])){
  if(isset($_SESSION['contenturl'])){
    header("Location: ../".$_SESSION['contenturl']); 
    exit;
  } else{
    header("Location: ../dashboard.php");
    exit;
  }
}