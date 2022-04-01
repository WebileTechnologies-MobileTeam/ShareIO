<?php

//session_start();

//index.php





if(isset($_GET['code']))

{

include('../include/db.php');

require_once '../vendor/stripe/stripe-php/init.php'; 

include('../facebook_config.php');



$facebook_output = '';

$facebook_login_url = "";

$facebook_helper = $facebook->getRedirectLoginHelper();

 if(isset($_SESSION['access_token']))

 {

  $access_token = $_SESSION['access_token'];

 }

 else

 {

  $access_token = $facebook_helper->getAccessToken();



  $_SESSION['access_token'] = $access_token;



  $facebook->setDefaultAccessToken($_SESSION['access_token']);

 }

 if (isset($_GET['state'])) {

    $facebook_helper->getPersistentDataHandler()->set('state', $_GET['state']);

 }



 $_SESSION['user_id'] = '';

 $_SESSION['user_name'] = '';

 $_SESSION['user_email_address'] = '';

 $_SESSION['user_image'] = '';



 $graph_response = $facebook->get("/me?fields=name,email", $access_token);



 $facebook_user_info = $graph_response->getGraphUser();

 if(!empty($facebook_user_info)){

    //echo "<pre>";print_r($facebook_user_info);exit;

    $firstname = $facebook_user_info['name'];
    $email = $facebook_user_info['email'];

    if(isset($_SESSION['contenturl'])){

      $sql="SELECT * FROM `cs_member` WHERE oauth_uid = '".$facebook_user_info['id']."'";
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
          $_SESSION['succsessmsgmember'] = "You have Successfully logged in with Facebook";
          header("Location: ../".$_SESSION['contenturl']); 
      } else{

          $date = date("Y-m-d");
          $sql = "INSERT INTO cs_member(member_email,oauth_uid,create_date) VALUES('".$email."','".$facebook_user_info['id']."','".$date."')";
          $res = mysqli_query($con,$sql);
          $_SESSION['member'] = $facebook_user_info['id'];
          $_SESSION['member_id'] = mysqli_insert_id($con);
          $_SESSION['checkout'] = 'true';
          $_SESSION['useremail'] = $email;
          $_SESSION['succsessmsgmember'] = "You have Successfully logged in with Facebook";
          header("Location: ../".$_SESSION['contenturl']);  
      }
    } else{
      unset($_SESSION['is_blocked']);
      $sql="SELECT * FROM `cs_users` WHERE oauth_uid = '".$facebook_user_info['id']."'";
      $res=mysqli_query($con,$sql);
      if (mysqli_num_rows($res) > 0) {
          $response = mysqli_fetch_array($res);
          // output data of each row
          if($response['user_profile_url'] == ''){
            $profileurl = 'https://graph.facebook.com/'.$response['oauth_uid'].'/picture?type=large';
            $updatesql = "UPDATE cs_users SET user_profile_url = '".$profileurl."' WHERE oauth_uid = '".$facebook_user_info['id']."'";
            $updres = mysqli_query($con,$updatesql);
          }
          if($response['is_blocked'] == '1'){
            $_SESSION['is_blocked'] = "true";
          }
          $_SESSION['user'] = $facebook_user_info['id'];
          $_SESSION['user_id'] = $response['id'];
          $_SESSION['succsessmsg'] = "You have Successfully logged in with Facebook";
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
          $date = date("Y-m-d H:i:s");         
          $profileurl = 'https://graph.facebook.com/'.$facebook_user_info['id'].'/picture?type=large';         

          $systemsql = "SELECT * FROM `system_data` WHERE system_id = '1'";
          $systemresult = mysqli_query($con,$systemsql);
          $system_data = mysqli_fetch_array($systemresult);
          if($system_data['block_signup'] == '1'){
            $_SESSION['is_blocked'] = "true";
          }

          $sql = "INSERT INTO cs_users(fname,email,active,oauth_uid,stripe_acc_id,stripe_acc_url,user_profile_url,create_date,impressions,is_blocked) VALUES('".$firstname."','".$email."','1','".$facebook_user_info['id']."','".$id."','".$url."','".$profileurl."','".$date."','100','".$system_data['block_signup']."')";
          $res = mysqli_query($con,$sql);
          $_SESSION['user'] = $facebook_user_info['id'];
          $_SESSION['user_id'] = mysqli_insert_id($con);;
          $_SESSION['succsessmsg'] = "You have Successfully logged in with Facebook";
          header("Location: ../dashboard.php?s=1");

      }
    }
 }

  if(!empty($facebook_user_info['id']))

 {

  $_SESSION['user_image'] = 'http://graph.facebook.com/'.$facebook_user_info['id'].'/picture';

  

 }



 if(!empty($facebook_user_info['name']))

 {

  $_SESSION['user_name'] = $facebook_user_info['name'];

 }



 if(!empty($facebook_user_info['email']))

 {

  $_SESSION['user_email_address'] = $facebook_user_info['email'];

 }

 $facebook_permissions = ['email'];

 $facebook_login_url = $facebook_helper->getLoginUrl('https://shareio.com/facebook/facebook_auth.php', $facebook_permissions);

    

    // Render Facebook login button

    $facebook_login_url = '<a href="'.$facebook_login_url.'" class="facebook-link"><i class="fa fa-facebook" aria-hidden="true"></i><span>Login with Facebook</span></a>';

 

}

else

{

if(isset($_SESSION['memberlogin']) && $_SERVER['REQUEST_URI'] != '/dashboard.php'){
  if(isset($_SESSION['member_audio_file'])){
    require_once '../../vendor/stripe/stripe-php/init.php'; 
  } else{
    require_once '../vendor/stripe/stripe-php/init.php'; 
  } 
} else{
  require_once './vendor/stripe/stripe-php/init.php'; 
}

$facebook_output = '';

$facebook_login_url = "";

$facebook_helper = $facebook->getRedirectLoginHelper();

 // Get login url

    $facebook_permissions = ['email']; // Optional permissions



    $facebook_login_url = $facebook_helper->getLoginUrl('https://shareio.com/facebook/facebook_auth.php', $facebook_permissions);

    

    // Render Facebook login button

    $facebook_login_url = '<a href="'.$facebook_login_url.'" class="facebook-link"><i class="fa fa-facebook" aria-hidden="true"></i><span>Login with Facebook</span></a>';

}



 // $outh = $_SESSION['id'];

 





?>