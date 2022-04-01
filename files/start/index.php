<?php
ini_set('error_reporting', 0);
session_start();
require('../../include/inc/defined_variables.php');
require('../../include/db.php');
$_SESSION['memberlogin'] = 'true';
$_SESSION['member_audio_file'] = 'true';
require('../../config.php');
require('../../facebook_config.php');
require('../../hotmail/hotmail.php');
require('../../linkedin/auth.php');
if(!class_exists('S3'))require_once('../../include/S3Bucket_config.php');

require_once('../../Aws-api/aws-autoloader.php');



use Aws\S3\S3Client;  

use Aws\Exception\AwsException;

?>
<html>
<?php

$content_possword = '';

$price = "Select * from sentfile where file_hash = '".$_REQUEST['file']."'";

$result = mysqli_query($con,$price);

if(mysqli_num_rows($result) > 0){

  $_SESSION['url'] = $_REQUEST['file'];

  $priceResultinfo = mysqli_fetch_array($result);



  if($priceResultinfo['browser_enabled'] == 0){

    header("Location: filenotfound.php?browser=1");

    exit;

  }

  

  $check_content = "SELECT * FROM feedback where fileid = '".$priceResultinfo['file_id']."' AND flag_count != ''";

  $check_content_result = mysqli_query($con,$check_content);

    if(mysqli_num_rows($check_content_result) >= 20){

        header("Location: filenotfound.php?block=1");

        exit;

    }



  if($priceResultinfo['ip_dns'] != ''){

    $ip = $_SERVER['REMOTE_ADDR'];

    if($priceResultinfo['ip_dns'] != $ip){

      header("Location: filenotfound.php?ip=1");

      exit;

    }

  }





  if($priceResultinfo['password'] != ''){ 

    $content_possword = $priceResultinfo['password'];

    ?>



  <div id="delete-modal" class="modal fade in" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">

    <div class="modal-dialog modal-dialog-centered">



    <!-- Modal content-->

      <div class="modal-content">

        <div class="modal-header">

          

        </div>

        <div class="modal-body">

          <div class="container-fluid" id="delete-model-popup">

            <p>Enter Password to view the content.</p>

            <input type="password" name="password" id="password">

            <label id="error-pass"></label>

            <ul class="cd-buttons">

              <li><a href="javascript:;" id="pass-submit">SUBMIT</a></li>

            </ul>

          </div>

        </div>

      </div>

    </div>

  </div>
  <script>
    $(document).ready(function(){
      $(".evaluation_banner").addClass("add_blur");
    });
  </script>


<?php

  }

function resolveIP($ip) {

        $string = file_get_contents("http://ipinfo.io/{$ip}?token=385d79682c9165");

        $json = json_decode($string);

        return $json;

}

function getIPAddress() {  

    //whether ip is from the share internet  

     if(!empty($_SERVER['HTTP_CLIENT_IP'])) {  

                $ip = $_SERVER['HTTP_CLIENT_IP'];  

        }  

    //whether ip is from the proxy  

    elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {  

                $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];  

     }  

//whether ip is from the remote address  

    else{  

             $ip = $_SERVER['REMOTE_ADDR'];  

     }  

     return $ip;  

} 

// echo '<pre>';

// print_r($_SERVER);

$ip = getIPAddress();

$new_arr[]= unserialize(file_get_contents('http://www.geoplugin.net/php.gp?ip='.$ip));

$lat = $new_arr[0]['geoplugin_latitude'];

$long = $new_arr[0]['geoplugin_longitude'];

$referer = isset($_SERVER['HTTP_REFERER'])?$_SERVER['HTTP_REFERER']:'';

$json = resolveIP($ip);

$timezone = $json->timezone;

date_default_timezone_set($timezone);

$latlong = explode(",", $json->loc);
$lat = $latlong[0];
$long = $latlong[1];
//Restrict Country View
$countries = json_decode($priceResultinfo['block_countries']);
if(in_array($json->country, $countries)){
  header("Location: filenotfound.php?country=1");
  exit;
} 
//unset($_SESSION['member_audio_file']);
$_SESSION['contenturl'] = 'files/start/'.$_REQUEST['file'];
$_SESSION['fileid'] = $priceResultinfo['file_id'];
$_SESSION['filetype'] = 'audio';
$date = '';

$view = '';

//$date = $priceResultinfo['date_time'];

$viewname = $_REQUEST['file'].'view';

if(isset($_COOKIE[$viewname])){

  $view = $_COOKIE[$viewname];

  $new = $view + 1;

  setcookie($viewname, $new, time() + (86400 * 30), "/files/start");

}else{

  $view = 1;

  setcookie($viewname, "2", time() + (86400 * 30), "/files/start"); // 86400 = 1 day

}



if(isset($_COOKIE[$_REQUEST['file']])){

  $date = $_COOKIE[$_REQUEST['file']];

}else{



  $cookie_value = date("Y-m-d H:i:s");

  $date = date("Y-m-d H:i:s");

  setcookie($_REQUEST['file'], $cookie_value, time() + (86400 * 30), "/files/start"); // 86400 = 1 day

}

  $impressions = '';
  $check_impression = "SELECT * FROM cs_users where id = '".$priceResultinfo['added_by']."' OR oauth_uid = '".$priceResultinfo['added_by']."'";
  $result = mysqli_query($con,$check_impression);
  if(mysqli_num_rows($result) > 0){
    $data = mysqli_fetch_array($result);
    $impressions = $data['impressions'];
    if($impressions < 1 || $impressions == '0' || $impressions == ''){  
      $user = $data['fname'];
      header("Location: filenotfound.php?imp=1&&user=".$user."");
        exit;
    } else{
      $imp = (int)$impressions - 1;
      $imp_update = "UPDATE cs_users set impressions = '".$imp."' where oauth_uid = '".$priceResultinfo['added_by']."'";
      $imp_update_result = mysqli_query($con,$imp_update);

      $imp_date = date('Y-m-d');
      $imp_query = "INSERT INTO file_impression(
          file_id,
          impression,
          imp_date
          ) VALUES(
          '" . addslashes($priceResultinfo['file_id']) . "',
          '1',
          '" . addslashes($imp_date) . "'
          )";
      $imp_query_result = mysqli_query($con,$imp_query);
    }
  } else{
    header("Location: filenotfound.php?del=1");
  exit;
  }



  $trial_query = "SELECT * FROM trial_setting where fileid = '".$priceResultinfo['file_id']."'";

  $trial_result = mysqli_query($con,$trial_query);

  $trial_data = mysqli_fetch_array($trial_result);

  if($priceResultinfo['file_type'] == "application/pdf"){

    $t_start = $trial_data['page_start'];

    $t_end = $trial_data['page_end'];

  } else{

    $t_start = $trial_data['t_start'];

    $t_end = $trial_data['t_end'];



  }

  $thumbnailImage = $priceResultinfo['file_thumbnail'];

  $content_price = $priceResultinfo['file_price'];

  $eva_type = '';

  $eva_value = '';

  $eva_date = '';

  $file_download = $priceResultinfo['download'];

  if($priceResultinfo['paused'] == '1'){ ?>

    <script>

      window.location = "filenotfound.php?err=1";

    </script>

  <?php

  exit;

   } ?>

<head>

<meta property="og:image" content="<?php echo $thumbnailImage;?>">

<meta name="twitter:card" content="summary_large_image">

<meta name="twitter:title" content="ShareIO">

<meta name="twitter:image" content="<?php echo $thumbnailImage;?>">

<meta name="viewport" content="width=device-width, initial-scale=1.0"> 

<meta http-equiv="X-UA-COMPATIBLE" content="IE=EDGE">

<title>ShareIO</title>

<link rel="shortcut icon" href="<?php echo SITE_URL;?>/images/favicon.ico" />

<link href="<?php echo SITE_URL;?>/css/style.css?var=<?php echo time();?>" rel="stylesheet">

<link rel="stylesheet" href="<?php echo SITE_URL;?>/Cube-Countdown/CubicCountdown/css/CubicCountdown.css">

<link href="<?php echo SITE_URL;?>/css/bootstrap.min.css" rel="stylesheet">

<link href="<?php echo SITE_URL;?>/css/bootstrap-responsive.min.css" rel="stylesheet">

<link href="<?php echo SITE_URL;?>/css/font-awesome.min.css" rel="stylesheet">
<link href="<?php echo SITE_URL;?>/css/cute-alert.css" rel="stylesheet" />
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>

<script src="https://js.stripe.com/v3/"></script>

<!--<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.js"></script>-->

<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.9.2/jquery-ui.min.js"></script>

<link rel="stylesheet" type="text/css"  href="content/global.css"/>

<script src="<?php echo SITE_URL;?>/Cube-Countdown/CubicCountdown/js/CubicCountdown.js"></script>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js" integrity="sha512-qTXRIMyZIFb8iQcfjXWCO8+M5Tbc38Qi5WzdPOYZHIlZpzBHG3L3by84BBBOiRGiEb7KKtAOAs5qYdUiZiQNNQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script type="text/javascript" src="<?php echo SITE_URL;?>/js/cute-alert.js"></script>
<style>

  /* Some page styles*/

  

  body {

    background: none;

    margin: 0;

    padding: 0;

  }



</style>

</head>

<div style="display: none;">

@if (Model.IsJavascriptOn == true)

    <noscript>

        <meta http-equiv="Set-Cookie" content="hasjs=false; path=/">

        <meta http-equiv="refresh" content="0.0;url=nojs.php">

    </noscript>



else //Client indicates javascript is disabled (cookie "hasjs=false" exists)

    <script>

        document.cookie = "hasjs=; expires=Thu, 01 Jan 1970 00:00:00 UTC; path=/";

        //console.log("test");

    </script>

</div>



<input type="hidden" id="member_id" name="member_id" value="<?php echo $_SESSION['member_id'];?>">
<?php
$useraccess = 'No';
if(isset($_SESSION['useremail'])){
  $check_user = "SELECT * FROM cs_member where member_email = '".$_SESSION['useremail']."'";
  $result = mysqli_query($con,$check_user);
  if(mysqli_num_rows($result) > 0){
    $userdata = mysqli_fetch_array($result);
    $added_by = '';
    if($userdata['added_by'] == ''){
      $added_by = $priceResultinfo['added_by'];
    } else{
      $added_by = $userdata['added_by'];
      if(!in_array($priceResultinfo['added_by'], explode(',', $added_by))){
        $added_by .= ','.$priceResultinfo['added_by'];
      }
    }

    $updatememberdetail = "UPDATE cs_member SET added_by = '".$added_by."' WHERE cs_member_id = '".$userdata['cs_member_id']."'";
    $updatememberdetailresult = mysqli_query($con,$updatememberdetail);
    
    $user_access_query = "member_id = '".$userdata['cs_member_id']."'";
    $check_user_group = "SELECT * FROM cs_group_rlt_member INNER JOIN cs_groups ON cs_groups.group_name = cs_group_rlt_member.group_name where member_id = '".$userdata['cs_member_id']."'";
    $result_user_group = mysqli_query($con,$check_user_group);
    if(mysqli_num_rows($result_user_group) > 0){
      $user_group_data = mysqli_fetch_array($result_user_group);
      $user_access_query = "(member_id = '".$userdata['cs_member_id']."' OR group_id = '".$user_group_data['group_id']."')";
    }

    $user_access_check = "SELECT * FROM access_list WHERE file_id = '".$priceResultinfo['file_id']."' AND $user_access_query";
    $user_access_check_result = mysqli_query($con,$user_access_check);
    if(mysqli_num_rows($user_access_check_result) > 0){
      $useraccess = 'Yes';
      unset($_SESSION['checkout']);
      $_SESSION['loginsessionchecked'.$priceResultinfo['file_id']] = 'true';
      if(!isset($_SESSION['accesschecked'.$priceResultinfo['file_id']])){
      ?>
        <script>
          jQuery(document).ready(function($) {
            cuteAlert({
              type: "success",
              title: "Success !",
              message: 'You have access to this content.',
              buttonText: "Close"
            }) 
          });
        </script>
      <?php
        $_SESSION['accesschecked'.$priceResultinfo['file_id']] = "true";
      }
    } else{
	      if(isset($_COOKIE['purchased'.$priceResultinfo['file_id']])){
	        unset($_COOKIE['purchased'.$priceResultinfo['file_id']]); 
	        setcookie('purchased'.$priceResultinfo['file_id'], '', time()-3600, "/files/start"); 
	      }
	  }
	
  } else{
    $date = date("Y-m-d H:i:s");
    $insertmemberdetail = "INSERT into cs_member(added_by,member_email,create_date) VALUES('".$added_by."','".$_SESSION['useremail']."','".$date."')";
    $insertmemberdetailresult = mysqli_query($con,$insertmemberdetail);
    
  }
}
if(isset($_SESSION['checkout']) && !isset($_SESSION['purchasedalr'])){?>
  <script>
    jQuery(document).ready(function($) {
      $('#checkout').click(); 
    });
  </script>
<?php 
unset($_SESSION['checkout']);
}

if(!isset($_SESSION['checkout']) && !isset($_SESSION['loginsessionchecked'.$priceResultinfo['file_id']]) && isset($_SESSION['member_id'])){?>
  <script>
    jQuery(document).ready(function($) {
      cuteAlert({
        type: "success",
        title: "Success !",
        message: 'You are already logged in.',
        buttonText: "Close"
      }) 
    });
  </script>
<?php 
  $_SESSION['loginsessionchecked'.$priceResultinfo['file_id']] = 'true';
}

if(isset($_SESSION['paymentsuccess'])){?>

    <input type="hidden" id="succsessmsg" name="succsessmsg" value="<?php echo $_SESSION['paymentsuccess'];?>">

    <script>

      jQuery(document).ready(function($) {

            var msg = $('#succsessmsg').val();

            if(msg != ''){

               cuteAlert({
                type: "success",
                title: "Success !",
                message: 'Thank you for purchasing this content it can be viewed without restriction.',
                buttonText: "Close"
              })

              }

            });

    </script>

 <?php 

  unset($_SESSION['paymentsuccess']);

  }

  if(isset($_SESSION['paymenterror'])){?>

  <div class="alert alert-error fade in">

      <a href="#" class="close" data-dismiss="alert">&times;</a>

      <strong>The payment failed please try again.</strong> 

  </div>

 <?php 

  unset($_SESSION['paymenterror']);

  }



?>

<?php 

  $userconfig = "SELECT * from user_config WHERE user_id = '" . $priceResultinfo['added_by'] . "'";

  $configresult = mysqli_query($con,$userconfig);

  $config_data = mysqli_fetch_array($configresult);

  $banner_bg = '#222222';

  $pagebg = 'linear-gradient(160deg, #0093E9 0%, #80D0C7 100%)';

  if($config_data['banner_color'] != ''){

    $banner_bg = $config_data['banner_color'];

  }

  if($config_data['page_bg_color_1'] != ''){

    $pagebg = 'linear-gradient(160deg, '.$config_data['page_bg_color_1'].' 0%, '.$config_data['page_bg_color_2'].' 100%)';

  }

  

?>

<script>

    var linear = <?php echo json_encode($pagebg);?>;

    $('body').css('background', linear);

</script>

<?php

if(isset($_COOKIE['purchased'.$priceResultinfo['file_id']])){

  $useraccess = 'Yes';
  if(isset($_SESSION['purchasedalr'])){ ?>
    <script>
      jQuery(document).ready(function($) {
          var addfilelink = <?php echo json_encode($priceResultinfo['additional_file_url']);?>;
               cuteAlert({
                type: "success",
                title: "Activation",
                message: 'This item has been activated and can be used without restrictions.',
                buttonText: "Close"
              })
            });
    </script>
  <?php
  }
  unset($_SESSION['purchasedalr']);
  if($priceResultinfo['additional_file_url'] != ''){ ?>

      <script>

      jQuery(document).ready(function($) {

          var addfilelink = <?php echo json_encode($priceResultinfo['additional_file_url']);?>;

               cuteAlert({
                type: "success",
                title: "Success !",
                message: 'This share has an additional file please download it.',
                buttonText: '<a href="'+addfilelink+'" download>Download</a>'
              })

            });

    </script>

  <?php }

  unset($_SESSION['useraccess']);

}



?>

<div class="audio_loader"></div>

<div class="evaluation_banner"> 



<a style="text-decoration: none;" id="restriction-view" data-toggle="modal" data-target="#restriction-view-modal" data-id="<?php echo $priceResultinfo['file_id'];?>" ></a>

  <?php if($content_price > 0 && $useraccess == "No"){?>

  <div id="edit-price-modal" class="modal fade audio_edit_price_modal" role="dialog">

  <div class="modal-dialog">



  <!-- Modal content-->

    <div class="modal-content">

      <div class="modal-header">

        <div class="edit-price-modal-header">

            <a href="#">

                <img src="<?php echo SITE_URL;?>/images/content-share-new-logo.png" />

            </a>

            <div class="paymentresponse_btn">

                <a href="#"><i class="fa fa-lock" aria-hidden="true"></i></a>

                <button type="button" id="edit-price-close" class="close" data-dismiss="modal">×</button>

            </div>

        </div>

      </div>

      <div class="modal-body">

      <div class="container-fluid" id="contentshare-model-popup">



      </div>

      </div>

    </div>

  </div>

</div>



<div id="restriction-view-modal" class="modal fade" role="dialog" tabindex="-1">

  <div class="modal-dialog">



  <!-- Modal content-->

    <div class="modal-content">

      <div class="modal-header">

            <button type="button" class="close" data-dismiss="modal">×</button>

      </div>

      <div class="modal-body">

          <div class="container-fluid" id="restriction-view-modal-popup">

            <p>This content is restricted you need to purchase for full access.</p>

            <p>Do you want to Buy ?</p>

            <ul class="cd-buttons">

                <li><a href="javascript:;" id="restriction_yes">Yes</a></li>

                <li><a class="close" data-dismiss="modal">No</a></li>

              </ul>

          </div>

      </div>

    </div>

  </div>

</div>

<?php }?>





<div id="edit-success-modal" class="modal fade" role="dialog">

  <div class="modal-dialog">



    <!-- Modal content-->

    <div class="modal-content">

      <div class="modal-header">

        <button type="button" class="close" data-dismiss="modal">×</button>

        <!--<h4 class="modal-title">Add</h4>-->

      </div>

      <div class="modal-body">

        <div class="container-fluid" id="successform">

          

        </div>

      </div>

    </div>

  </div>

</div>







  <?php if($useraccess == "No"){?>
  <?php if($priceResultinfo['hide_banner'] == '0' || $priceResultinfo['hide_banner'] == ''){ ?>
  <div class="down_arrow_bg" style="background: <?php echo $banner_bg;?>;">

  <a onclick="showbanner();" class="down_arrow" style="display: none;"></a>

  </div>

  <div class="header_content">

    <div class="pdf_header" style="background: <?php echo $banner_bg;?>;">    

    <div class="pdf_header_left tooltip_shows">     

      <a href="https://shareio.com/"> 

      <?php if($config_data['banner_logo_url'] != ''){ ?>

       <img src="<?php echo $config_data['banner_logo_url'];?>">

       <?php } else{?>

       <img src="<?php echo SITE_URL;?>/images/content-share-new-logo.png">

       <?php }?>

      </a> 

      <div class="bottom">

          <span>ShareIO the secure way to share and sell content online.</span>

      </div> 

    </div>    

    <div class="pdf_header_right">

      <a style="text-decoration: none;" id="getcontent" data-id="<?php echo $priceResultinfo['file_id'];?>" >

    <?php 

      $evaluation_query = "SELECT * FROM tbl_evaluation where evaluation_id = '".$priceResultinfo['evalution_type']."'";

      $evaluation_result = mysqli_query($con,$evaluation_query);

      $evaluation_data = mysqli_fetch_array($evaluation_result);

      $eva_type = $evaluation_data['evaluation_name'];

      $eva_value = $priceResultinfo['evalution_value'];

      if($eva_type == 'Date'){  

      $eva_date = $priceResultinfo['evalution_date'];

      ?>

      <h1>Expires on <?php echo $priceResultinfo['evalution_date'];?></h1>  

      <?php } elseif($eva_type == 'Views'){

      $views = $eva_value - $view;

      if($views <= '0'){?>

        <h1>Opps.. Content Expired.</h1>

      <?php exit;

       }

      ?>

      <h1>Expires in <?php echo $views.' Views';?></h1>  

      <?php } elseif($eva_type == 'None'){

      ?>

      <?php }else{?>

      <h1>Expires in</h1>

      <!-- <section class="wrapper">

      <section id="countdown-container" class="countdown-container">

        <article id="js-countdown" class="countdown">

        <section id="js-days" class="number"></section>

        <section id="js-separator" class="separator">:</section>

        <section id="js-hours" class="number"></section>

        <section id="js-separator" class="separator">:</section>

        <section id="js-minutes" class="number"></section>

        <section id="js-separator" class="separator">:</section>

        <section id="js-seconds" class="number"></section>

        </article>

      </section>

      </section> --> 

      <div id="cubic-container"></div>

      <?php }?> 

      <?php if($content_price > 0){?>

      <div class="ribbon-wrapper">

          <p class="ribbon" id="payBtn">Buy Now</p>
          <p id="checkout" style="display: none;">Pay</p>
        </div>

      <?php }?>   

      </a>

    </div>  

    </div>

  </div>
<?php }?>
<?php }?>

<div class="watermark">

<?php if($priceResultinfo['watermark_type'] == 'Text'){?>

      <div id="watermark-text" class="watermark-text">

        <?php echo $priceResultinfo["watermark_text"];?>

      </div>

    <?php } else if($priceResultinfo['watermark_type'] == 'Image'){?>

      <div id="watermark-image" class="watermark-image">

        <img width="200px" height="300px" id="watermark" src="<?php echo $priceResultinfo["watermark_image"];?>">

      </div>

<?php }else{}?>

</div>
<div class="login_with_social_media" style="display:none;">
  <label>Login With Social Media</label>
  <ul>
    <li class="facebook">
    <?php require('../../facebook/facebook_auth.php'); ?>
    <?php echo $facebook_login_url; ?></li>
    <li class="linkedin"><a href="<?php echo $loginUrl;?>"><i class="fa fa-linkedin" aria-hidden="true"></i> <span>Login with Linkedin</span></a></li>
    <li class="twitter"><a href="javascript:(0)" id="twitter-login"><i class="fa fa-twitter" aria-hidden="true"></i> <span>Login with Twitter</span></a></li>
    <li class="google"><?php require('../../google/auth.php'); ?>
    <?php echo $login_button; ?></li>     

    <li class="hotmail"> 
      <a href="<?php echo $urls; ?>">
        <svg xmlns="http://www.w3.org/2000/svg" enable-background="new 0 0 24 24" viewBox="0 0 24 24"><path d="M13.5,23.625c-0.034,0-0.068-0.002-0.102-0.007l-12.75-1.75C0.276,21.817,0,21.5,0,21.125v-18c0-0.369,0.269-0.684,0.634-0.741l12.75-2c0.217-0.036,0.437,0.028,0.604,0.171s0.263,0.351,0.263,0.57v21.75c0,0.217-0.094,0.423-0.257,0.565C13.855,23.56,13.68,23.625,13.5,23.625z M1.5,20.471l11.25,1.544V2.002L1.5,3.767V20.471z"/><path d="M7 16.625c-1.93 0-3.5-2.019-3.5-4.5s1.57-4.5 3.5-4.5 3.5 2.019 3.5 4.5S8.93 16.625 7 16.625zM7 9.125c-1.084 0-2 1.374-2 3s.916 3 2 3 2-1.374 2-3S8.084 9.125 7 9.125zM22.25 19.875H13.5c-.414 0-.75-.336-.75-.75v-14c0-.414.336-.75.75-.75h8.75c.429 0 .841.156 1.159.44C23.781 5.134 24 5.615 24 6.125v12C24 19.09 23.215 19.875 22.25 19.875zM14.25 18.375h8c.136 0 .25-.114.25-.25v-12c0-.072-.028-.138-.078-.181-.056-.049-.109-.069-.172-.069h-8V18.375z"/><path d="M16.6,11.915c-0.174,0-0.349-0.061-0.489-0.182l-3.1-2.67c-0.314-0.271-0.35-0.744-0.079-1.058c0.271-0.315,0.744-0.349,1.058-0.079l2.595,2.235l5.819-5.339c0.304-0.278,0.778-0.261,1.06,0.046c0.28,0.305,0.26,0.779-0.046,1.06l-6.311,5.79C16.964,11.849,16.781,11.915,16.6,11.915z"/></svg>
        <span>Login with Outlook</span>
      </a></li>
  </ul>
</div>
<div id="content">

<?php

$s3 = new S3Client([

    'version' => 'latest',

    'region'  => AWS_S3_REGION,

    'credentials' => [

        'key'    => AWS_S3_KEY,

        'secret' => AWS_S3_SECRET,

    ]

]);



$key = 'Files/'.$priceResultinfo['file_name'];



$cmd = $s3->getCommand('GetObject', [

    'Bucket' => AWS_S3_BUCKET,

    'Key' => $key

]);



$request = $s3->createPresignedRequest($cmd, '+10 seconds');



// Get the actual presigned-url

$presignedUrl = (string)$request->getUri();



$request_artist = $s3->createPresignedRequest($cmd, '+10 hours');

$presignedUrlArtist = (string)$request_artist->getUri();



$url = $priceResultinfo['file_url'];

$file_id = $priceResultinfo['file_id'];

$total_page = $priceResultinfo['file_length'];

$filename = $priceResultinfo['file_name'];

$str_time = $priceResultinfo['file_length'];

$thumbnailImage = $priceResultinfo['file_thumbnail'];

sscanf($str_time, "%d:%d:%d", $hours, $minutes, $seconds);

$time_seconds = isset($seconds) ? $hours * 3600 + $minutes * 60 + $seconds : $hours * 60 + $minutes;



sscanf($t_end, "%d:%d:%d", $hours, $minutes, $seconds);

$t_end_seconds = isset($seconds) ? $hours * 3600 + $minutes * 60 + $seconds : $hours * 60 + $minutes;



if($priceResultinfo['file_type'] == "audio/mp3" || $priceResultinfo['file_type'] == "audio/mpeg"){

?>

<script>

var file_id = <?php echo json_encode($file_id);?>;

var url = <?php echo json_encode($url);?>;

var presignedUrl = <?php echo json_encode($presignedUrlArtist);?>;

var pdfurl = <?php echo json_encode($csurl);?>;

var t_start = <?php echo json_encode($t_start);?>;

var t_end = <?php echo json_encode($t_end);?>;

var total_page = <?php echo json_encode($total_page);?>;

var thumbnailImage = <?php echo json_encode($thumbnailImage);?>;

var useraccess = <?php echo json_encode($useraccess);?>;

var content_price = <?php echo json_encode($content_price);?>;

var file_download = <?php echo json_encode($file_download);?>;

var file_name = <?php echo json_encode($filename);?>;

var time_seconds = <?php echo json_encode($time_seconds);?>;

$.ajax({

    type: "POST",

    url: "../examples/index.php",

    data:{

      file_id:file_id,

      url:url,

      presignedUrl:presignedUrl,

      pdfurl:pdfurl,

      file_name:file_name,

      t_start:t_start,

      t_end:t_end,

      thumbnailImage:thumbnailImage,

      time_seconds:time_seconds,

      total_page:total_page,

      useraccess:useraccess

    },

    success: function(resp){ 

      $('#content').html(resp);

      $(".next-btn").hide();

      $(".prev-btn").hide();

      $('.audio_loader').fadeOut();

      if(useraccess == 'No'){  

        if(content_price > 0){

            $('#presentationMode').hide();

        //$("#toolbarViewerLeft").css("display", "none");

        //$('.toolbar').css("display", "none");

        //$("#toolbarViewerRight").css("display", "none");

      }

    }

    

    $('.loader').hide();

    navarrow();

  }

  });

</script> 

<?php } ?>

</div> 

<?php if($priceResultinfo["social_share"] == '1'){?>

<div class="icons link_icon social_icons_show_hide social_share social_share_audio">

    <a href="javascript:;">

       <img class="link_icon_img" src="../../images/link_icon.png" alt="Link" style="">

       <img class="close_icon" src="../../images/close_icons.png" alt="Link" style="display: none;">

    </a>

    <div class="icons social_icons" style="display: none;">

      <div class="social_share_list">

        <div class="social_icons_list">

          <a href="https://www.facebook.com/sharer/sharer.php?u=<?php echo SITE_URL;?>/file/<?php echo $priceResultinfo["file_hash"];?>" target="_blank">

           <img src="../../images/facebook.png" alt="Link">

          </a>

        </div>

        <div class="social_icons_list">

          <a href="https://twitter.com/share?url=<?php echo SITE_URL;?>/file/<?php echo $priceResultinfo["file_hash"];?>" target="_blank">

           <img src="../../images/twitter.png" alt="Link">

          </a>

        </div>

        <div class="social_icons_list">

          <a href="http://www.linkedin.com/shareArticle?mini=true&amp;url=<?php echo SITE_URL;?>/file/<?php echo $priceResultinfo["file_hash"];?>&amp;summary=some%20summary%20if%20you%20want&amp;source=https://magehubextensions.com" target="_blank">

           <img src="../../images/linkedin.png" alt="Link">

          </a>

        </div>

        

      </div>

   </div>

 </div> 

<?php }?>

<?php

        $ip = getIPAddress();

        $check_flag = "SELECT * FROM feedback where fileid = '".$priceResultinfo['file_id']."' AND ip_address = '".$ip."'";

        $check_flag_result = mysqli_query($con,$check_flag);

        $check_flag_row = mysqli_fetch_array($check_flag_result);

    ?>

    <div class="flag_icon" <?php if($check_flag_row['flag_count'] != ''){?> style="pointer-events: none;" <?php }?>>

      <a href="javascript:;" <?php if($check_flag_row['flag_count'] != ''){?> class="flag_active" <?php }?>>

          <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 0 24 24" width="24px" fill="#000000"><path d="M0 0h24v24H0z" fill="none"/><path d="M14.4 6L14 4H5v17h2v-7h5.6l.4 2h7V6z"/>

          </svg>

      </a>

    </div>

    <div class="like_icon" <?php if($check_flag_row['like_count'] != ''){?> style="pointer-events: none;" <?php }?>>

      <a href="javascript:;" <?php if($check_flag_row['like_count'] != ''){?> class="flag_active" <?php }?>>

          <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 0 24 24" width="24px" fill="#000000"><path d="M0 0h24v24H0z" fill="none"/><path d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z"/>

          </svg>

      </a>

    </div>

</div>

<div id="expire" style="display: none;">

<h1>Opps.. Content Expired.</h1>

</div>

<div id="removed" style="display: none;">

<h1>Sorry, The content has been removed.</h1>

</div>

<?php    

} else{ 

?>

<!-- <h1>Content not found.</h1> -->

<?php

header("Location: filenotfound.php");

} ?>



<script>

$(document).ready(function(){

    function restrictInterval(){

        var restrict = setInterval(function(){

         var time = $('.curr-time').html();

         var end = <?php echo json_encode($t_end_seconds);?>;

         if(moment(time,'mm:ss').seconds() >= end){

             $('#restriction-view')[0].click();

             $('.playing .playbtn').click();

             $('.con-playpause').css({"pointer-events":"none","opacity":"0.4"});

             clearInterval(restrict);

         }

      },1000);

    }

    

    var useraccess = <?php echo json_encode($useraccess);?>;

    if(useraccess == 'No'){

        restrictInterval();

    }

    

  

  // $("#restriction_yes").on("click", function(){

  //       $("#restriction-view-modal").addClass("importantclass");

  //       $('#restriction-view-modal').hide();

  //       $(".restriction-body").addClass("normal_body");

  //       $(".modal-backdrop.in").hide();

  //       $('#restriction-view-modal').removeClass('in');

  //       $('body').removeClass('modal-open');

  //       $("#getcontent")[0].click();

  //   });

    

    $("#restriction-view-modal .close, #edit-price-close").on("click", function(){

        $("#restriction-view-modal").addClass("importantclass");

        $(".restriction-body").addClass("normal_body");

        $(".modal-backdrop.in").hide();

        $('#restriction-view-modal').removeClass('in');

        $('body').removeClass('modal-open');

        var file_id = <?php echo json_encode($file_id);?>;

        var url = <?php echo json_encode($url);?>;

        var presignedUrl = <?php echo json_encode($presignedUrlArtist);?>;

        var pdfurl = <?php echo json_encode($csurl);?>;

        var t_start = <?php echo json_encode($t_start);?>;

        var t_end = <?php echo json_encode($t_end);?>;

        var total_page = <?php echo json_encode($total_page);?>;

        var thumbnailImage = <?php echo json_encode($thumbnailImage);?>;

        var useraccess = <?php echo json_encode($useraccess);?>;

        var content_price = <?php echo json_encode($content_price);?>;

        var file_download = <?php echo json_encode($file_download);?>;

        var file_name = <?php echo json_encode($filename);?>;

        var time_seconds = <?php echo json_encode($time_seconds);?>;

        $.ajax({

            type: "POST",

            url: "examples/index.php",

            data:{

              file_id:file_id,

              url:url,

              presignedUrl:presignedUrl,

              pdfurl:pdfurl,

              file_name:file_name,

              t_start:t_start,

              t_end:t_end,

              thumbnailImage:thumbnailImage,

              time_seconds:time_seconds,

              total_page:total_page,

              useraccess:useraccess

            },

            success: function(resp){ 

              $('#content').html(resp);

              $(".next-btn").hide();

              $(".prev-btn").hide();

              $('.audio_loader').fadeOut();

              if(useraccess == 'No'){  

                if(content_price > 0){

                    $('#presentationMode').hide();

                //$("#toolbarViewerLeft").css("display", "none");

                //$('.toolbar').css("display", "none");

                //$("#toolbarViewerRight").css("display", "none");

              }

            }

            

            $('.loader').hide();

            navarrow();

            restrictInterval();

          }

        });

    });

});



  $('#pass-submit').on("click", function(){

    var password = <?php echo json_encode($content_possword);?>;

    var pass = $('#password').val();

    if(pass == password){

      $('#delete-modal').removeClass('in');

      $('#delete-modal').css('display', 'none');
      $(function() {
          $({blurRadius: 15}).animate({blurRadius: 0}, {
              duration: 1500,
              easing: 'linear', 
                              
              step: function() {
                  $('.add_blur').css({
                      "-webkit-filter": "blur("+this.blurRadius+"px)",
                      "filter": "blur("+this.blurRadius+"px)"
                  });
              },
              complete: function() {
                     $(".evaluation_banner").removeClass("add_blur");
              }
          });
      });
    } else{

      $('#error-pass').html('Enter Valid Password');

    }

  });

  

  $('#getcontent').on("click", function(){

    var price = <?php echo json_encode($content_price);?>;

    var file_type = <?php echo json_encode($priceResultinfo['file_type']);?>;

    if(price > 0){

    var id = <?php echo json_encode($file_id);?>; 

              $.ajax({

                  type: "POST",

                  url: "../../include/purchase.php",

                  data:{

                    id:id,

                    file_type:file_type

                  },

                  success: function(html){ 

                    $("#contentshare-model-popup").html(html);

                    //$(".close").css("display", "none");

                  }

                });

      } 

  });

  

  

  $(".flag_icon a").on("click", function(){

        $(this).toggleClass("flag_active");

        $(".flag_icon").css("pointer-events", "none");

        // if($(".flag_icon a").hasClass("flag_active")){

        // console.log("test");

        // }

        var id = <?php echo json_encode($file_id);?>;

        $.ajax({

            type: "POST",

            url: "start/log.php",

            data:{

              id:id,

              flag:'flag'

            },

            success: function(resp){ 

                if(resp == "block"){

                    window.location = "filenotfound.php?block=1";

                }

            }

          });

    });

    

    $(".like_icon a").on("click", function(){

        $(this).toggleClass("like_active"); 

        $(".like_icon").css("pointer-events", "none");

        var id = <?php echo json_encode($file_id);?>;

        $.ajax({

            type: "POST",

            url: "start/log.php",

            data:{

              id:id,

              like:'like'

            },

            success: function(resp){ 

            }

          });

    });



  $(document).on("click", '.fwdrap-icon-download', function(){

    //alert("test")

          var file_id = <?php echo json_encode($file_id);?>; 



              $.ajax({

                  type: "POST",

                  url: "start/Insert-download.php",

                  data:{

                    id:file_id

                  },

                  success: function(html){ 

                  }

                });

        });



  setTimeout(function() {

   jQuery('.alert-success').fadeOut('slow');

}, 8000); // <-- time in milliseconds

  setTimeout(function() {

   jQuery('.alert-error').fadeOut('slow');

}, 8000); // <-- time in milliseconds

</script>

<script>

$(document).ready(function() {

    $(function() {
        $("#password").focus();
      });
    $("body").on("contextmenu",function(){

       return false;

    }); 

    

    document.onkeydown = function (e) {

 

        // disable F12 key

        if(e.keyCode == 123) {

            return false;

        }

 

        // disable I key

        if(e.ctrlKey && e.shiftKey && e.keyCode == 73){

            return false;

        }

 

        // disable J key

        if(e.ctrlKey && e.shiftKey && e.keyCode == 74) {

            return false;

        }

 

        // disable U key

        if(e.ctrlKey && e.keyCode == 85) {

            return false;

        }

        

        // disable C key

        if(e.ctrlKey && e.shiftKey && e.keyCode == 67) {

            return false;

        }

        if (event.keyCode === 13) {
          // Cancel the default action, if needed
          event.preventDefault();
          // Trigger the button element with a click
          document.getElementById("pass-submit").click();
        }

    }

});





setInterval(function(){

   var id = <?php echo json_encode($file_id);?>;
   var notification = <?php echo json_encode($priceResultinfo['notification']);?>;

      $.ajax({

        type: "POST",

        url: "start/check-content.php",

        data: {

          id:id

        },

        success: 

          function(resp){

           if(resp == 'false'){

            window.location = "start/filenotfound.php";

           } else if(resp == 'false1'){

            window.location = "start/filenotfound.php?err=1";

           } else if(resp == 'updated'){

            if(notification == '1'){
                cuteToast({
                    type: "info",
                    message: "The author has just modified the settings of this content.",
                    timer: 5000
                })
                setInterval(() => {
                  location.reload();
                }, 5000);
              } else{
                location.reload();
              }

           } else{



           }

        },

    });

},5000)

</script>

<!-- New CountDown -->

<script>

    function convertTZ(date) {
        var tzString = <?php echo json_encode($timezone);?>;
        return new Date((typeof date === "string" ? new Date(date) : date).toLocaleString("en-US", {timeZone: tzString}));   
    }
    
    var db_date = <?php echo json_encode($date);?>;

    var eva_type = <?php echo json_encode($eva_type);?>;

    var eva_value = Math.round(<?php echo json_encode($eva_value);?>);

    var d1  = new Date(db_date);

      var d2 = new Date ( d1 );

    if(eva_type == 'Seconds'){

        d2.setSeconds ( d1.getSeconds() + eva_value );

      } else if(eva_type == 'Minutes'){

        d2.setMinutes ( d1.getMinutes() + eva_value );

      } else if(eva_type == 'Hours'){

        d2.setHours ( d1.getHours() + eva_value );

      } else if(eva_type == 'Day'){

        d2.setDate ( d1.getDate() + eva_value );

      }

      //d2.setDate ( d1.getDate() + 10 );

      //alert(d2);

      var targetDate = new Date( d2 );

      //alert(targetDate);

    /*Countdown initialization with ALL options*/

    var myCount = new Cubic({

      element: "#cubic-container",

      toTime: targetDate, /*60 sec countdown since page loaded*/

      cubeSize: 70,

      cubeSideMargin: 20,

      shadowIntensity: 100,

      showDays: true,

      showHours: true,

      showMinutes: true,

      showSeconds: true,

      labelTextSize: 15,

      labelOnTop: false,

      labelOffset: 0,

      cubeTextSize: 30,

      leadingZero: true,

      colonSize: 15,

      animationPreset: 0,

      animationDelay: 50,

      continiousAnimation: false,

      colonAnimation: true,

      shadowColor: "#414141",

      daysLabel: "days",

      hoursLabel: "hours",

      minutesLabel: "minutes",

      secondsLabel: "seconds",

      cssClass: "zzcubic",

      autoStart: true,

      cubeTopMargin: 15,

      onFinish: function(){

        myCount.stop();

        window.location = "filenotfound.php?exp=1";

      },

      mobileFirst: false,

      responsive: [

        {

          breakpoint: 991,

          options: {

            cubeSize: 50,

            cubeSideMargin: 15,

            labelTextSize: 15,

            labelOffset: 0,

            cubeTextSize: 25,

            colonSize: 15,

          },

        },

        {

          breakpoint: 480,

          options: {

            cubeSize: 42,

            cubeSideMargin: 15,

            labelTextSize: 15,

            labelOffset: 0,

            cubeTextSize: 25,

            colonSize: 10,

          },

        },

      ],

    });

  </script>







<script>

var geo;

var lat;

var long;

var device_session;

var browser_session;

      const getUA = () => {

      let device = "Unknown";

      const ua = {

      "Generic Linux": /Linux/i,

      "Android": /Android/i,

      "BlackBerry": /BlackBerry/i,

      "Bluebird": /EF500/i,

      "Chrome OS": /CrOS/i,

      "Datalogic": /DL-AXIS/i,

      "Honeywell": /CT50/i,

      "iPad": /iPad/i,

      "iPhone": /iPhone/i,

      "iPod": /iPod/i,

      "macOS": /Macintosh/i,

      "Windows": /IEMobile|Windows/i,

      "Zebra": /TC70|TC55/i,

      }

      Object.keys(ua).map(v => navigator.userAgent.match(ua[v]) && (device = v));

      return device;

      }



      device_session = getUA();





 function getLocation() {

  if (navigator.geolocation) {

    navigator.geolocation.getCurrentPosition(showPosition,showError);

  } else {



  }

  if((navigator.userAgent.indexOf("Opera") || navigator.userAgent.indexOf('OPR')) != -1 ) 

    {

        browser_session = 'Opera';

    }

    else if(navigator.userAgent.indexOf("Chrome") != -1 )

    {

        browser_session = 'Chrome';

    }

    else if(navigator.userAgent.indexOf("Safari") != -1)

    {

        browser_session = 'Safari';

    }

    else if(navigator.userAgent.indexOf("Firefox") != -1 ) 

    {

         browser_session = 'Firefox';

    }

    else if((navigator.userAgent.indexOf("MSIE") != -1 ) || (!!document.documentMode == true )) //IF IE > 10

    {

      browser_session = 'IE';

    }  

    else 

    {

       browser_session = 'unknown';

    }



}



function showPosition(position) {

  lat = position.coords.latitude;

  long = position.coords.longitude;

  viewerlog();

}



function showError(error) {

    switch(error.code) {

        case error.PERMISSION_DENIED:

            //viewerlog();

            break;

    }

}



window.onload = function viewerlog(){

  var id = <?php echo json_encode($file_id);?>;

  var referer = <?php echo json_encode($referer);?>;

  lat = <?php echo json_encode($lat);?>;

  long = <?php echo json_encode($long);?>;

  $.ajax({

   url: 'start/log.php',

   type: 'POST',

   data: {

    id:id,

    lat:lat,

    long:long,

    device:device_session,

    browser:browser_session,

    referer:referer

   },

   success: function(resp) {

        

    }

  });



}



//geo = viewerlog();





 function showbanner(){

  $('.down_arrow').hide();

  $('.header_content').addClass("header_big");

    $('.header_content').show(1000);

    navarrow();

 }



 function navarrow(){

  setTimeout(function () { 

        $('.header_content').removeClass("header_big");

        $('.down_arrow').show();

        $('.header_content').hide(); 

      }, 5000);

 }

 $(document).ready(function($){  

    $(".social_icons_show_hide a .link_icon_img").click(function(){

      $(".link_icon_img").hide(350);

      $(".close_icon").show(350);

      $(".social_icons").show(350);

    });

    $(".social_icons_show_hide a .close_icon").click(function(){

      $(".link_icon_img").show(350);

      $(".close_icon").hide(350);

      $(".social_icons").hide(350);

    });

  });  

 $('#payBtn').on('click', function(){
    var memberId = $('#member_id').val();
    if(memberId == ''){
      var html = $('.login_with_social_media');
      html.show();
      Swal.fire({
        customClass: { popup : 'login_popup memberlogin'},
        html: html,
        showConfirmButton: false
      }) 
      html.hide();
    } else{
      $('#checkout').click();
    }
  });

 $(document).on("click", "#twitter-login", function(){
      $.ajax({
         type: "POST",
         url: "../../Twitter/index.php",          
         success: function(resp) {
            window.location = resp;
         }
        });
  });

</script>
<script>
var buyBtn = document.getElementById('checkout');
var restYes = document.getElementById('restriction_yes');

var responseContainer = document.getElementById('paymentResponse');
    
// Create a Checkout Session with the selected product
var createCheckoutSession = function (stripe) {
    return fetch("../chk-payment.php", {
        method: "POST",
        headers: {
            "Content-Type": "application/json",
        },
        body: JSON.stringify({
            checkoutSession: 1,
            isAddress: 1,
            fileid: <?php echo json_encode($file_id);?>, 
            memberid: $("#member_id").val(),
        }),
    }).then(function (result) {
        return result.json();
    });
};
var file_type = <?php echo json_encode($priceResultinfo['file_type']);?>;
var createCheckoutSessionWithoutAddress = function (stripe) {
    return fetch("../chk-payment.php", {
        method: "POST",
        headers: {
            "Content-Type": "application/json",
        },
        body: JSON.stringify({
            checkoutSession: 1,
            isAddress: 0,
            fileid: <?php echo json_encode($file_id);?>, 
            memberid: $("#member_id").val(),
            file_type: file_type
        }),
    }).then(function (result) {
        return result.json();
    });
};

// Handle any errors returned from Checkout
var handleResult = function (result) {
    if (result.error) {
        responseContainer.innerHTML = '<p>'+result.error.message+'</p>';
    }
    buyBtn.disabled = false;
    buyBtn.textContent = 'Buy Now';
    $("#restriction-view-modal .close").click();
};

// Specify Stripe publishable key to initialize Stripe.js
var stripe = Stripe('<?php echo STRIPE_PUBLISHABLE_KEY; ?>');

buyBtn.addEventListener("click", function (evt) {
    buyBtn.disabled = true;
    buyBtn.textContent = 'Please wait...';
    
    createCheckoutSession().then(function (data) {
        if(data.sessionId){
            stripe.redirectToCheckout({
                sessionId: data.sessionId,
            }).then(handleResult);
        }else{
            //handleResult(data);
            createCheckoutSessionWithoutAddress().then(function (data) {
		        if(data.sessionId){
		            stripe.redirectToCheckout({
		                sessionId: data.sessionId,
		            }).then(handleResult);
		        }else{
		            handleResult(data);
		        }
		    });
        }
    });
});

restYes.addEventListener("click", function (evt) {
    var memberId = $('#member_id').val();
    if(memberId == ''){
        $("#restriction-view-modal .close").click();
        var html = $('.login_with_social_media');
        html.show();
        Swal.fire({
        customClass: { popup : 'login_popup memberlogin'},
        html: html,
        showConfirmButton: false
        }) 
        html.hide();
    } else{
        
        restYes.disabled = true;
        restYes.textContent = 'Please wait...';
        
        createCheckoutSession().then(function (data) {
            if(data.sessionId){
                stripe.redirectToCheckout({
                    sessionId: data.sessionId,
                }).then(handleResult);
            }else{
                //handleResult(data);
                createCheckoutSessionWithoutAddress().then(function (data) {
    		        if(data.sessionId){
    		            stripe.redirectToCheckout({
    		                sessionId: data.sessionId,
    		            }).then(handleResult);
    		        }else{
    		            handleResult(data);
    		        }
    		    });
            }
        });
    }
});
</script>

</html>


