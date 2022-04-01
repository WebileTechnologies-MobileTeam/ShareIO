<?php
ini_set('error_reporting', 0);
session_start();
require('../include/inc/defined_variables.php');
require('../include/db.php');
if(!class_exists('S3'))require_once('../include/S3Bucket_config.php');
require_once('../Aws-api/aws-autoloader.php');

use Aws\S3\S3Client;  
use Aws\Exception\AwsException;
?>
<html>
<head>
<title>ShareIO</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0"> 
<link rel="shortcut icon" href="<?php echo SITE_URL;?>/images/favicon.ico" />
<link rel="stylesheet" href="<?php echo SITE_URL;?>/Cube-Countdown/CubicCountdown/css/CubicCountdown.css">
<link href="<?php echo SITE_URL;?>/css/bootstrap.min.css" rel="stylesheet">
<link href="<?php echo SITE_URL;?>/css/bootstrap-responsive.min.css" rel="stylesheet">
<link href="<?php echo SITE_URL;?>/css/style.css?ver=<?php echo time();?>" rel="stylesheet">
<link href="<?php echo SITE_URL;?>/css/font-awesome.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://shareio.com/pdf/web/viewer.css">
<!-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0-alpha.1/css/materialize.min.css"> -->
<!-- <link rel="stylesheet" href="<?php //echo SITE_URL;?>/Tata-notification/index.css"> -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
<script src="https://js.stripe.com/v3/"></script>
<script src="<?php echo SITE_URL;?>/Cube-Countdown/CubicCountdown/js/CubicCountdown.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.9.2/jquery-ui.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script defer src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0-alpha.1/js/materialize.min.js"></script>
<script src="<?php echo SITE_URL;?>/Tata-notification/tata.js"></script>
<script src="<?php echo SITE_URL;?>/Tata-notification/index.js"></script>
<style type="text/css">
  #delete-modal .modal-dialog {
    background: #fff;
    padding: unset;
  }
  #delete-modal .modal-header {
    display: none;
    padding: unset;
  }
  #delete-modal .modal-body {
    padding: 25px 30px;
  }
  #delete-modal .modal-content {
    border-radius: unset;
  }
</style>

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

  $check_impression = "SELECT * FROM cs_users where id = '".$priceResultinfo['added_by']."' OR oauth_uid = '".$priceResultinfo['added_by']."'";
  $result = mysqli_query($con,$check_impression);
  if(mysqli_num_rows($result) > 0){
	  $data = mysqli_fetch_array($result);
	  $impressions = $data['impressions'];
	  if($impressions == '0' || $impressions == ''){  
	    $user = $data['fname'];
	    header("Location: filenotfound.php?imp=1&&user=".$user."");
	      exit;
	  }
  } else{
  	header("Location: filenotfound.php?del=1");
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

//Restrict Country View
$countries = json_decode($priceResultinfo['block_countries']);
if(in_array($json->country, $countries)){
  header("Location: filenotfound.php?country=1");
  exit;
} 

$date = '';
$view = '';
//$date = $priceResultinfo['date_time'];
$viewname = $_REQUEST['file'].'view';
if(isset($_COOKIE[$viewname])){
  $view = $_COOKIE[$viewname];
  $new = $view + 1;
  setcookie($viewname, $new, time() + (86400 * 30), "/file/");
}else{
  $view = 1;
  setcookie($viewname, "2", time() + (86400 * 30), "/file/"); // 86400 = 1 day
}

if(isset($_COOKIE[$_REQUEST['file']])){
  $date = $_COOKIE[$_REQUEST['file']];
}else{

  $cookie_value = date("Y-m-d H:i:s");
  $date = date("Y-m-d H:i:s");
  setcookie($_REQUEST['file'], $cookie_value, time() + (86400 * 30), "/file/"); // 86400 = 1 day
}

  $imp = (int)$impressions - 1;
  $imp_update = "UPDATE cs_users set impressions = '".$imp."' where id = '".$priceResultinfo['added_by']."' OR oauth_uid = '".$priceResultinfo['added_by']."'";
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
<meta property="og:type" content="website" />
<meta property="og:title" content="ShareIo">
<meta property="og:image" content="<?php echo $thumbnailImage;?>">
<meta property="og:description" content="ShareIo">
<meta property="og:url" content="<?php echo SITE_URL;?>/file/<?php echo $_REQUEST['file'];?>">
<meta name="twitter:card" content="summary_large_image">
<meta name="twitter:title" content="ShareIO">
<meta name="twitter:image" content="<?php echo $thumbnailImage;?>">
<title>ShareIO</title>
<link rel="stylesheet" type="text/css" href="css/flipbook.style.css">
<link rel="stylesheet" type="text/css" href="css/font-awesome.css">

<script src="js/flipbook.min.js"></script>
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
<?php
if($priceResultinfo['password'] != ''){ 
    $content_possword = $priceResultinfo['password'];
  	?>

	<div id="delete-modal" class="modal fade in" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true" style="display: block;">
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
?>
<style>
.loader:before {
 width: 60px;
  height: 60px;
  -webkit-animation: spin 2s linear infinite;
  animation: spin 2s linear infinite;
  display: inline-block;
  border: 10px solid #f3f3f3;
  border-radius: 50%;
  border-top: 10px solid #3498db;
  content: "";
}
.loader {
    width: 100%;
    position: absolute;
    top: 0;
    bottom: 0;
    right: 0;
    left: 0;
    height: 100%;
    display: flex;
    align-items: center;
    justify-content: center;
    z-index: 1;
    background: rgba(0,0,0,.5);
}

/* Safari */
@-webkit-keyframes spin {
  0% { -webkit-transform: rotate(0deg); }
  100% { -webkit-transform: rotate(360deg); }
}

@keyframes spin {
  0% { transform: rotate(0deg); }
  100% { transform: rotate(360deg); }
}
</style>
<?php
if(isset($_SESSION['paymentsuccess'])){?>
    <input type="hidden" id="succsessmsg" name="succsessmsg" value="<?php echo $_SESSION['paymentsuccess'];?>">
    <script>
      jQuery(document).ready(function($) {
            var msg = $('#succsessmsg').val();
            if(msg != ''){
               Swal.fire({
                  text: "Thank you for purchasing this content it can be viewed without restriction.",
                  icon: 'success',
                  confirmButtonText: 'Close'
                });
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
$useraccess = 'No';
if(isset($_COOKIE['purchased'.$priceResultinfo['file_id']])){
  $useraccess = 'Yes';
  if($priceResultinfo['additional_file_url'] != ''){ ?>
      <script>
      jQuery(document).ready(function($) {
          var addfilelink = <?php echo json_encode($priceResultinfo['additional_file_url']);?>;
               Swal.fire({
                  title: "Thank you for purchasing this content it can be viewed without restriction.",
                  icon: 'success',
                  text: 'This share has a additional file please download it.',
                  footer: '<a href="'+addfilelink+'" download>Download</a>'
                })
            });
    </script>
  <?php }
  unset($_SESSION['useraccess']);
}

?>

<div class="evaluation_banner">	

  <?php if($content_price > 0 && $useraccess == "No"){?>
  <div id="edit-price-modal" class="modal fade" role="dialog" style="display: none;">
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


<div id="restriction-view-modal" class="modal fade" role="dialog" tabindex="-1" style="display: none;">
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


  <?php if($useraccess == "No"){?>
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
		    <a style="text-decoration: none;" id="restriction-view" data-toggle="modal" data-target="#restriction-view-modal" data-id="<?php echo $priceResultinfo['file_id'];?>" ></a>
		  <a style="text-decoration: none;" id="getcontent" data-toggle="modal" data-target="#edit-price-modal" data-id="<?php echo $priceResultinfo['file_id'];?>" >
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
		  <div id="cubic-container"></div>
		  <?php }?>	
		  <?php if($content_price > 0){?>
        <div class="ribbon-wrapper">
		      <p class="ribbon">Buy Now</p>
        </div>
		  <?php }?>		
		  </a>
		</div>	
	  </div>
  </div>
<?php }?>


<section class="row" style="display: none;">
  <section id="opts" class="col s12 m7 offset-m1 opts">
      <input placeholder="Input your title." name="title" id="title" type="text" class="validate" value="ShareIo">
      <input placeholder="Input your text." name="text" id="text" type="text" class="validate" value="The author has just modified the settings of this content.">
      <input type="range" id="duration" name="duration" min="0" max="10" value="5" />
        <input name="position" type="radio" checked value="tr" /><span>tr</span>
            <input type="checkbox" checked name="progress">
            <input type="checkbox" name="holding">
            <input type="checkbox" name="closeBtn" checked>
            <input type="checkbox" name="animate">
            <input type="checkbox" name="onClick">
            <input type="checkbox" name="onClose">
  </section>
  <section class="col s12 m3 offset-m1 btns" style="display: none;">
    <button class="btn btn-large waves-effect waves-light z-depth-3" id="notification" data-type="info">Info</button>
  </section>
</section>

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
<div class="loader"></div>
<div id="content">
</div>
<div class="icons_list">
  
  <?php if($priceResultinfo["social_share"] == '1'){?>
  <div class="icons link_icon social_icons_show_hide social_share">
      <a href="javascript:;">
        <img class="link_icon_img" src="../images/link_icon.png" alt="Link" style="">
        <img class="close_icon" src="../images/close_icons.png" alt="Link" style="display: none;">
      </a>
      <div class="icons social_icons" style="display: none;">
        <div class="social_share_list">
          <div class="social_icons_list">
            <a href="https://www.facebook.com/sharer/sharer.php?u=<?php echo SITE_URL;?>/file/<?php echo $priceResultinfo["file_hash"];?>" target="_blank">
            <img src="../images/facebook.png" alt="Link">
            </a>
          </div>
          <div class="social_icons_list">
            <a href="https://twitter.com/share?url=<?php echo SITE_URL;?>/file/<?php echo $priceResultinfo["file_hash"];?>" target="_blank">
            <img src="../images/twitter.png" alt="Link">
            </a>
          </div>
          <div class="social_icons_list">
            <a href="http://www.linkedin.com/shareArticle?mini=true&amp;url=<?php echo SITE_URL;?>/file/<?php echo $priceResultinfo["file_hash"];?>&amp;summary=some%20summary%20if%20you%20want&amp;source=<?php echo SITE_URL;?>/" target="_blank">
            <img src="../images/linkedin.png" alt="Link">
            </a>
          </div>
          
        </div>
    </div>
  </div>	
  <?php }?>
  <div class="download_icon" id="download_image" style="display: none;">
    <a href="#" id="download_image_button" download><img src="../images/download_icon.png" alt="Download" /></a>
  </div>
  </div>
  
    <?php
        $ip = getIPAddress();
        $check_flag = "SELECT * FROM feedback where fileid = '".$priceResultinfo['file_id']."' AND ip_address = '".$ip."'";
        $check_flag_result = mysqli_query($con,$check_flag);
        $check_flag_row = mysqli_fetch_array($check_flag_result);
    ?>
    <div class="flag_icon">
      <a href="javascript:;" <?php if($check_flag_row['flag_count'] != '' && $check_flag_row['flag_count'] != '0'){?> class="flag_active" <?php }?>>
          <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 0 24 24" width="24px" fill="#000000"><path d="M0 0h24v24H0z" fill="none"/><path d="M14.4 6L14 4H5v17h2v-7h5.6l.4 2h7V6z"/>
          </svg>
      </a>
    </div>
    <div class="like_icon">
      <a href="javascript:;" <?php if($check_flag_row['like_count'] != '' && $check_flag_row['like_count'] != '0'){?> class="like_active" <?php }?>>
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
  
    $request = $s3->createPresignedRequest($cmd, '+15 seconds');
    
    // Get the actual presigned-url
    $presignedUrl = (string)$request->getUri();
    
      $url = $presignedUrl;
      $csurl = $priceResultinfo['file_url'];
      $file_id = $priceResultinfo['file_id'];
      $total_page = $priceResultinfo['file_length'];
      $filename = $priceResultinfo['file_name'];
      $temp_pdffile_name = basename($csurl);
    if($priceResultinfo['file_type'] == "application/pdf"){
      ?>
      <script>
       window.onload = function viewpdf() {
        var file_id = <?php echo json_encode($file_id);?>;
        var url = <?php echo json_encode($url);?>;
        var pdfurl = <?php echo json_encode($csurl);?>;
        var t_start = <?php echo json_encode($t_start);?>;
        var t_end = <?php echo json_encode($t_end);?>;
        var total_page = <?php echo json_encode($total_page);?>;
        var useraccess = <?php echo json_encode($useraccess);?>;
        var content_price = <?php echo json_encode($content_price);?>;
        var file_download = <?php echo json_encode($file_download);?>;
        var file_name = <?php echo json_encode($filename);?>;
        //console.log(file_download);
        $.ajax({
            type: "POST",
            url: "../pdf/web/viewer.php",
            data:{
              file_id:file_id,
              url:url,
              pdfurl:pdfurl,
              file_name:file_name,
              t_start:t_start,
              t_end:t_end,
              total_page:total_page,
              useraccess:useraccess
            },
            success: function(resp){ 
              $('#content').html(resp);
              $('#openFile').hide();
              $('.toolbar').hide();
              var unlink = setInterval(function(){ 
                  $.ajax({
                  url: 'unlink.php',
                  data: {'file' : "<?php echo '/contentshare.me/pdf/'.$temp_pdffile_name;?>" },
                  success: function (response) {
                    
                  }
                });
                clearInterval(unlink);
              }, 8000);
              
              if(useraccess == 'No'){  
                if(content_price > 0){
                    $('#presentationMode').hide();
                //$("#toolbarViewerLeft").css("display", "none");
                //$('.toolbar').css("display", "none");
                //$("#toolbarViewerRight").css("display", "none");
              }
            }
            if(file_download == '0'){
                $('#download').hide();
                $('#print').hide();
            }
            
            navarrow();
          }
          });
      }
      </script>
      <?php } elseif($priceResultinfo['file_type'] == "video/mp4" || $priceResultinfo['file_type'] == "video/webm"){ 
      $requestvideo = $s3->createPresignedRequest($cmd, '+60 seconds');
      $presignedUrlVideo = (string)$requestvideo->getUri();
      ?>
      <script>
       window.onload = function viewvideo() {
        var file_id = <?php echo json_encode($file_id);?>;
        var url = <?php echo json_encode($presignedUrlVideo);?>;
        var videourl = <?php echo json_encode($csurl);?>;
        var t_start = <?php echo json_encode($t_start);?>;
        var t_end = <?php echo json_encode($t_end);?>;
        var useraccess = <?php echo json_encode($useraccess);?>;
        var content_price = <?php echo json_encode($content_price);?>;
        var file_download = <?php echo json_encode($file_download);?>;
        $.ajax({
            type: "POST",
            url: "source/index-default.php",
            data:{
              file_id:file_id,
              url:url,
              videourl:videourl,
              t_start:t_start,
              t_end:t_end,
              useraccess:useraccess,
              file_download:file_download
            },
            success: function(resp){ 
              $('#content').html(resp);
              if(useraccess == 'No'){ 
                if(content_price > 0){   
                  
                }     
               }
           	  
                $('.loader').hide();
                navarrow();
            }
          });
      }
      </script>

      <?php
    } elseif($priceResultinfo['file_type'] == "image/png" || $priceResultinfo['file_type'] == "image/jpeg"
            || $priceResultinfo['file_type'] == "image/gif" || $priceResultinfo['file_type'] == "image/jpg"){
       ?>
      <?php 
      ?>
      <script>
       window.onload = function viewimage() {
        var file_id = <?php echo json_encode($file_id);?>;
        var url = <?php echo json_encode($url);?>;
        var csurl = <?php echo json_encode($csurl);?>;
        var t_start = <?php echo json_encode($t_start);?>;
        var t_end = <?php echo json_encode($t_end);?>;
        var useraccess = <?php echo json_encode($useraccess);?>;
        var content_price = <?php echo json_encode($content_price);?>;
		    var file_download = <?php echo json_encode($file_download);?>;
        $.ajax({
            type: "POST",
            url: "../Image-component/Example/Image.php",
            data:{
              file_id:file_id,
              url:url,
              t_start:t_start,
              t_end:t_end,
              useraccess:useraccess
            },
            success: function(resp){ 
              $('#content').html(resp);
              if(useraccess == 'No'){ 
                if(file_download == '1'){
                if(content_price < 1){
                  $('#download_image').show();
                  $('#download_image_button').attr('href', csurl);
                }
              } else{
                //$('#download').hide();
              }
              } else{
                if(file_download == '1'){
                  $('#download_image').show();
                  $('#download_image_button').attr('href', csurl);
                }
              }
              $('.loader').hide();
              navarrow();
            }
          });
      }
      </script>

      <?php
    } else{
    ?>
<div class="content_iframe">
    <iframe src="<?php echo $priceResultinfo['file_url'];?>"></iframe>
</div>
<?php }?>
<?php
} else{ 
?>
<!-- <h1>Content not found.</h1> -->
<?php
header("Location: filenotfound.php");
} ?>

<script>
    $("#restriction-view-modal .close").on("click", function(){
        $("#restriction-view-modal").addClass("importantclass");
        $(".restriction-body").addClass("normal_body");
        $(".modal-backdrop.in").hide();
        $('#restriction-view-modal').removeClass('in');
        $('body').removeClass('modal-open');
        var type = <?php echo json_encode($priceResultinfo['file_type']);?>;
        if(type == "application/pdf"){
            $("#firstPage").click();
        }
        if(type == "video/mp4" || type == "video/webm"){
            var file_id = <?php echo json_encode($file_id);?>;
            var url;
            var videourl = <?php echo json_encode($csurl);?>;
            var t_start = <?php echo json_encode($t_start);?>;
            var t_end = <?php echo json_encode($t_end);?>;
            var useraccess = <?php echo json_encode($useraccess);?>;
            var content_price = <?php echo json_encode($content_price);?>;
            var file_download = <?php echo json_encode($file_download);?>;
            var file_name = <?php echo json_encode($filename);?>;

            $.ajax({
                type: "POST",
                url: "URLforVideo.php",
                data:{
                  file_name:file_name
                },
                success: function(resp){ 
                 url = resp;
                 $.ajax({
                    type: "POST",
                    url: "source/index-default.php",
                    data:{
                      file_id:file_id,
                      url:url,
                      videourl:videourl,
                      t_start:t_start,
                      t_end:t_end,
                      useraccess:useraccess,
                      file_download:file_download
                    },
                    success: function(resp){ 
                      $('#content').html(resp);
                      if(useraccess == 'No'){ 
                        if(content_price > 0){   
                        
                        }     
                       }
                   	  
                        $('.loader').hide();
                        navarrow();
                    }
                  });
                }
              });
        }
        
    });
    
    $('#edit-price-close').on('click', function(){
        var type = <?php echo json_encode($priceResultinfo['file_type']);?>;
        if(type == "application/pdf"){
            $("#firstPage").click();
        }
        if(type == "video/mp4" || type == "video/webm"){
            $('body').removeClass('restriction-body');
            var file_id = <?php echo json_encode($file_id);?>;
            var url;
            var videourl = <?php echo json_encode($csurl);?>;
            var t_start = <?php echo json_encode($t_start);?>;
            var t_end = <?php echo json_encode($t_end);?>;
            var useraccess = <?php echo json_encode($useraccess);?>;
            var content_price = <?php echo json_encode($content_price);?>;
            var file_download = <?php echo json_encode($file_download);?>;
            var file_name = <?php echo json_encode($filename);?>;

            $.ajax({
                type: "POST",
                url: "URLforVideo.php",
                data:{
                  file_name:file_name
                },
                success: function(resp){ 
                 url = resp;
                 $.ajax({
                    type: "POST",
                    url: "source/index-default.php",
                    data:{
                      file_id:file_id,
                      url:url,
                      videourl:videourl,
                      t_start:t_start,
                      t_end:t_end,
                      useraccess:useraccess,
                      file_download:file_download
                    },
                    success: function(resp){ 
                      $('#content').html(resp);
                      if(useraccess == 'No'){ 
                        if(content_price > 0){   
                        
                        }     
                       }
                   	  
                        $('.loader').hide();
                        navarrow();
                    }
                  });
                }
              });
              
        }
        
    });
    
    $("#restriction_yes").on("click", function(){
        $("#restriction-view-modal").addClass("importantclass");
        $('#restriction-view-modal').hide();
        $(".restriction-body").addClass("normal_body");
        $(".modal-backdrop.in").hide();
        $('#restriction-view-modal').removeClass('in');
        $('body').removeClass('modal-open');
        $("#getcontent")[0].click();
    });
    
    $(".flag_icon a").on("click", function(){
        $(this).toggleClass("flag_active");
        // if($(".flag_icon a").hasClass("flag_active")){
        // console.log("test");
        // }
        var id = <?php echo json_encode($file_id);?>;
        $.ajax({
            type: "POST",
            url: "log.php",
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
        //$(".like_icon").css("pointer-events", "none");
        var id = <?php echo json_encode($file_id);?>;
        $.ajax({
            type: "POST",
            url: "log.php",
            data:{
              id:id,
              like:'like'
            },
            success: function(resp){ 
            }
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
    if(price > 0){
    var id = <?php echo json_encode($file_id);?>; 
              $.ajax({
                  type: "POST",
                  url: "../include/purchase.php",
                  data:{
                    id:id
                  },
                  success: function(html){ 
                    $("#contentshare-model-popup").html(html);
                    //$(".close").css("display", "none");
                  }
                });
      } 
  });

  $('#download_image_button').on("click", function(){
          var file_id = <?php echo json_encode($file_id);?>;

              $.ajax({
                  type: "POST",
                  url: "Insert-download.php",
                  data:{
                    id:file_id
                  },
                  success: function(html){ 
                  }
                });
        });

  setTimeout(function() {
   jQuery('.alert-success').fadeOut('slow');
}, 8000); 
  setTimeout(function() {
   jQuery('.alert-error').fadeOut('slow');
}, 8000); 
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
        // if(e.keyCode == 123) {
        //     return false;
        // }
 
        // // disable I key
        // if(e.ctrlKey && e.shiftKey && e.keyCode == 73){
        //     return false;
        // }
 
        // // disable J key
        // if(e.ctrlKey && e.shiftKey && e.keyCode == 74) {
        //     return false;
        // }
 
        // // disable U key
        // if(e.ctrlKey && e.keyCode == 85) {
        //     return false;
        // }
        
        // // disable C key
        // if(e.ctrlKey && e.shiftKey && e.keyCode == 67) {
        //     return false;
        // }

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
        url: "check-content.php",
        data: {
          id:id
        },
        success: 
          function(resp){
           if(resp == 'false'){
            window.location = "filenotfound.php";
           } else if(resp == 'false1'){
            window.location = "filenotfound.php?err=1";
           } else if(resp == 'updated'){
             if(notification == '1'){
                $('#notification').click();
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
	  var d1  = new Date(db_date.replace(/-/g, "/"));
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
      //alert(new Date(db_date.replace(/-/g, "/")));
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
			onFinish: function(){
				myCount.stop();
				window.location = "filenotfound.php?exp=1";
			},
			mobileFirst: false,
			responsive: [

        {
					breakpoint: 1300,
					options: {
						cubeSize: 60,
						cubeSideMargin: 15,
						labelTextSize: 15,
						labelOffset: 0,
						cubeTextSize: 25,
						colonSize: 15,
					},
				},

        {
					breakpoint: 1199,
					options: {
						cubeSize: 55,
						cubeSideMargin: 15,
						labelTextSize: 15,
						labelOffset: 0,
						cubeTextSize: 25,
						colonSize: 15,
					},
				},

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

function viewerlog(){
  var id = <?php echo json_encode($file_id);?>;
  var referer = <?php echo json_encode($referer);?>;
  lat = <?php echo json_encode($lat);?>;
  long = <?php echo json_encode($long);?>;
  $.ajax({
   url: 'log.php',
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

//geo = getLocation();
geo = viewerlog();


 function showbanner(){
 	$('.down_arrow').hide();
    $('.header_content').show(1000);
    $('.evaluation_banner').addClass("pdf_viewer");
    navarrow();
 }

 function navarrow(){
  $('.evaluation_banner').addClass("pdf_viewer");
 	setTimeout(function () { 
        $('.down_arrow').show();
        $('.header_content').hide(); 
        $('.evaluation_banner').removeClass("pdf_viewer"); 
      }, 50000);
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
</script>
</html>
