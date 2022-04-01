<?php
require('http.php');
require('oauth_client.php');
require('config.php');
require('./include/db.php');
require_once './vendor/stripe/stripe-php/init.php'; 

define('REDIRECT_URL' , 'https://shareio.com/google_login.php');
$client = new oauth_client_class;

// set the offline access only if you need to call an API
// when the user is not present and the token may expire
$client->offline = FALSE;

$client->debug = false;
$client->debug_http = false;
$client->redirect_uri = REDIRECT_URL;

$client->client_id = '747030329023-bqdmr63b5us6msdeld12mutuelsrha4j.apps.googleusercontent.com';
//$application_line = __LINE__;
$client->client_secret = 'aaMMFu5Rc931m5a2g1bELpZe';

if (strlen($client->client_id) == 0 || strlen($client->client_secret) == 0)
  die('Please go to Google APIs console page ' .
          'http://code.google.com/apis/console in the API access tab, ' .
          'create a new client ID, and in the line ' . $application_line .
          ' set the client_id to Client ID and client_secret with Client Secret. ' .
          'The callback URL must be ' . $client->redirect_uri . ' but make sure ' .
          'the domain is valid and can be resolved by a public DNS.');

/* API permissions
 */
$client->scope = 'email';
if (($success = $client->Initialize())) {
  if (($success = $client->Process())) {
    if (strlen($client->authorization_error)) {
      $client->error = $client->authorization_error;
      $success = false;
    } elseif (strlen($client->access_token)) {
      $success = $client->CallAPI(
              'https://www.googleapis.com/oauth2/v1/userinfo', 'GET', array(), array('FailOnAccessError' => true), $user);
   // echo '<pre>';
   //  print_r($user);exit;
    }
  }
  $success = $client->Finalize($success);
}
if ($client->exit)
  exit;
if ($success) { 

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
          $_SESSION['useremail'] = $user->email;
          $_SESSION['succsessmsgmember'] = "You have Successfully logged in with Google";
          header("Location: ../".$_SESSION['contenturl']); 
          exit;
      } else{

          $date = date("Y-m-d H:i:s");
          $sql = "INSERT INTO cs_member(member_email,oauth_uid,create_date) VALUES('".$user->email."','".$user->id."','".$date."')";
          $res = mysqli_query($con,$sql);
          $_SESSION['member'] = $facebook_user_info['id'];
          $_SESSION['member_id'] = mysqli_insert_id($con);
          $_SESSION['checkout'] = 'true';
          $_SESSION['useremail'] = $user->email;
          $_SESSION['succsessmsgmember'] = "You have Successfully logged in with Google";
          header("Location: ../".$_SESSION['contenturl']);  
          exit;
      }
    } else{
      unset($_SESSION['is_blocked']);
//$cons = mysqli_connect("localhost","magehpj7_cshare","xU+moC9FZ)lu","magehpj7_contentshare");
  $sql = "SELECT COUNT(*) AS count from cs_users where oauth_uid = '".$user->id."'";
$result = mysqli_query($con, $sql);

$row = $result->fetch_row();
    if ($row[0] > 0) {
        
        if($row['user_profile_url'] == ''){
            $profile_photo_url = str_replace('s96-c', 's200-c', $user->picture);
            $updatesql = "UPDATE cs_users SET user_profile_url = '".$user->picture."' WHERE oauth_uid = '".$user->id."'";
            $updres = mysqli_query($con,$updatesql);
          }
      if($row['is_blocked'] == '1'){
         $_SESSION['is_blocked'] = "true";
      }
          
      $_SESSION["name"] = $user->name;
      $_SESSION["email"] = $user->email;
      $_SESSION["succsessmsg"] = "You have Successfully logged in with Google";
      $_SESSION["user"] = $user->id;
      header("location:dashboard.php?s=1");
      exit;
    } else {

      \Stripe\Stripe::setApiKey('sk_test_ZHBPscwQ2uvawFY7Fq1E3DAC');


      $account = \Stripe\Account::create([
        'country' => 'US',
        'type' => 'express',
      ]);

      $id = $account['id'];

      $account_links = \Stripe\AccountLink::create([
        'account' => $id,
        'refresh_url' => 'https://shareio.com/dashboard.php',
        'return_url' => 'https://shareio.com/dashboard.php',
        'type' => 'account_onboarding',
      ]);
      $url = $account_links['url'];
      $date = date("Y-m-d");
      // New user, Insert in database
      $profile_photo_url = str_replace('s96-c', 's200-c', $user->picture);
      $systemsql = "SELECT * FROM `system_data` WHERE system_id = '1'";
      $systemresult = mysqli_query($con,$systemsql);
      $system_data = mysqli_fetch_array($systemresult);
      if($system_data['block_signup'] == '1'){
        $_SESSION['is_blocked'] = "true";
      }
       $sql = "INSERT INTO `cs_users` (`email`,`active`,`oauth_uid`,`stripe_acc_id`,`stripe_acc_url`,`user_profile_url`,`create_date`,`impressions`,`is_blocked`) VALUES " . "('".$user->email."','1','".$user->id."','".$id."','".$url."','".$profile_photo_url."', '".$date."', '100','".$system_data['block_signup']."')";
       
      $result = mysqli_query($con, $sql);
      if ($result > 0) {
        $_SESSION["name"] = $user->name;
        $_SESSION["email"] = $user->email;
        $_SESSION["succsessmsg"] = "You have Successfully logged in with Google";
        $_SESSION["user"] = $user->id;
        header("location:dashboard.php?s=1");
        exit;
      }
    }
  }
 /* } catch (Exception $ex) {
    $_SESSION["error"] = $ex->getMessage();
  }*/
} else {
  $_SESSION["error"] = $client->error;
}
if(isset($_SESSION['contenturl'])){
  header("Location: ../".$_SESSION['contenturl']); 
  exit;
} else{
  header("Location: ../dashboard.php");
  exit;
}
?>