<?php

/**

 * linkedin-client

 * index.php

 *

 * PHP Version 5

 *

 * @category Production

 * @package  Default

 * @author   Philipp Tkachev <philipp@zoonman.com>

 * @date     8/17/17 22:47

 * @license  http://zoonman.com/license.txt linkedin-client License

 * @version  GIT: 1.0

 * @link     http://zoonman.com/projects/linkedin-client

 */



// add Composer autoloader

require('../include/db.php');

require_once '../vendor/autoload.php'; 

require_once '../vendor/stripe/stripe-php/init.php'; 





// import client class

use LinkedIn\Client;

use LinkedIn\Scope;



// import environment variables from the environment file

// you need a .env file in the parent folder

// read this document to learn how to create that file

// https://github.com/zoonman/linkedin-api-php-client/blob/master/examples/README.md

//

//$dotenv = new Dotenv\Dotenv(dirname(__DIR__));

//$dotenv->load();



// we need a session to keep intermediate results

// you can use your own session persistence management

// client doesn't depend on it

session_start();



// instantiate the Linkedin client

// you can setup keys using

$client = new Client(

    '86nwqcsyypia1f',

    'vL9wOC5YBAXr7lad'

);





if (isset($_GET['code'])) { // we are returning back from LinkedIn with the code

    if (isset($_GET['state']) &&  // and state parameter in place

        isset($_SESSION['state']) && // and we have have stored state

        $_GET['state'] === $_SESSION['state'] // and it is our request

    ) {

        try {

            // you have to set initially used redirect url to be able

            // to retrieve access token

            $client->setRedirectUrl($_SESSION['redirect_url']);

            // retrieve access token using code provided by LinkedIn

            $accessToken = $client->getAccessToken($_GET['code']);

            h1('Access token');

            pp($accessToken); // print the access token content

            h1('Profile');

            // perform api call to get profile information

            $profile = $client->get(        

                'me',                       

                ['fields' => 'id,firstName,lastName']

            );

            $profile_image = '';

            $profiles = $client->get(        

                'me',                       

                ['projection' => '(id,profilePicture(displayImage~digitalmediaAsset:playableStreams))']

            ); 

            $userid = $profile['id'];

            $fname  = $profile['firstName']['localized']['en_US'];

            $lname  = $profile['lastName']['localized']['en_US'];



            if($profiles['profilePicture']){

                $profile_image = $profiles['profilePicture']['displayImage~']['elements'][0]['identifiers'][0]['identifier'];

            }

            $emailInfo = $email = $client->get('emailAddress', ['q' => 'members', 'projection' => '(elements*(handle~))']);

            $email = $emailInfo['elements'][0]['handle~']['emailAddress'];

            //pp($emailInfo);

            
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
                    $status = 0;
                    $checkpurchasesql="SELECT * FROM `sales` WHERE member_id = '".$response['cs_member_id']."' and package_id = '".$_SESSION['pkg_id']."'";
                    $checkpurchaseres=mysqli_query($con,$checkpurchasesql);
                    if (mysqli_num_rows($checkpurchaseres) > 0) {
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
                  $_SESSION['succsessmsgmember'] = "You have Successfully logged in with LinkedIn";
                  header("Location: ../".$_SESSION['contenturl']); 
              } else{

                  $date = date("Y-m-d H:i:s");
                  $sql = "INSERT INTO cs_member(member_email,oauth_uid,create_date) VALUES('".$email."','".$userid."','".$date."')";
                  $res = mysqli_query($con,$sql);

                  // $viewer_access_query = "INSERT INTO access_list(
                  // file_id,
                  // member_id
                  // ) VALUES(
                  // '" . addslashes($_SESSION['fileid']) . "',
                  // '" . addslashes(mysqli_insert_id($con)) . "'
                  // )";
                  $result = $con->query($viewer_access_query); 
                  $_SESSION['member'] = $facebook_user_info['id'];
                  $_SESSION['member_id'] = mysqli_insert_id($con);
                  $_SESSION['checkout'] = 'true';
                  $_SESSION['useremail'] = $email;
                  $_SESSION['succsessmsgmember'] = "You have Successfully logged in with LinkedIn";
                  header("Location: ../".$_SESSION['contenturl']);  
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

                // output data of each row

                   $_SESSION['user'] = $userid;

                  //$_SESSION['user'] = $res['id'];

                   $_SESSION['succsessmsg'] = "You have Successfully logged in with LinkedIn";

                   $_SESSION['succses'] = "You have Successfully logged in with LinkedIn";

                   header("Location: ../dashboard.php?s=1");

                } else{

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
                   $sql = "INSERT INTO cs_users(fname,lname,email,active,oauth_uid,stripe_acc_id,stripe_acc_url,user_profile_url,create_date,impressions,is_blocked) VALUES('".$fname."','".$lname."','".$email."','1','".$userid."','".$id."','".$url."','".$profile_image."', '".$date."','100','".$system_data['block_signup']."')";

                   $res=mysqli_query($con,$sql);

                   if($res){

                    $_SESSION['succsessmsg'] = "You have Successfully logged in with LinkedIn";

                    $_SESSION['succses'] = "You have Successfully logged in with LinkedIn";

                    $_SESSION['user'] = $userid;   

                   }

                   header("Location: ../dashboard.php?s=1");

                }
            }



            

        } catch (\LinkedIn\Exception $exception) {

            // in case of failure, provide with details

            // pp($exception);

            // pp($_SESSION);

            if(isset($_SESSION['contenturl'])){
              header("Location: ../".$_SESSION['contenturl']); 
              exit;
            } else{
              header("Location: ../dashboard.php");
              exit;
            }

        }

    } else {

        // normally this shouldn't happen unless someone sits in the middle

        // and trying to override your state

        // or you are trying to change saved state during linking

        echo 'Invalid state!';

        pp($_GET);

        pp($_SESSION);

        echo '<a href="/">Start over</a>';

    }



} elseif (isset($_GET['error'])) {

    // if you cancel during linking

    // you will be redirected back with reason

    pp($_GET);

    echo '<a href="/">Start over</a>';

} 

/**

 * Pretty print whatever passed in

 *

 * @param mixed $anything

 */

function pp($anything)

{

    echo '<pre>' . print_r($anything, true) . '</pre>';

}



/**

 * Add header

 *

 * @param string $h

 */

function h1($h) {

    echo '<h1>' . $h . '</h1>';

}