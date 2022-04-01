<?php
ini_set('error_reporting', 0);
session_start();
require('../include/inc/defined_variables.php');
require('../include/db.php');
?>
<html>
<head>
<title>ShareIO</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0"> 
<link rel="shortcut icon" href="<?php echo SITE_URL;?>/images/favicon.ico" />
<link href="<?php echo SITE_URL;?>/css/bootstrap.min.css" rel="stylesheet">
<link href="<?php echo SITE_URL;?>/css/bootstrap-responsive.min.css" rel="stylesheet">
<link href="<?php echo SITE_URL;?>/css/style.css?ver=<?php echo time();?>" rel="stylesheet">
<link href="<?php echo SITE_URL;?>/css/font-awesome.min.css" rel="stylesheet">
<link rel="stylesheet" href="<?php echo SITE_URL;?>/Gridstack/demo.css" />
<link rel="stylesheet" href="<?php echo SITE_URL;?>/Gridstack/dist/gridstack-extra.css" />
<link href="<?php echo SITE_URL;?>/css/cute-alert.css" rel="stylesheet" />
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.9.2/jquery-ui.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script type="text/javascript" src="<?php echo SITE_URL;?>/js/cute-alert.js"></script>
<script src="<?php echo SITE_URL;?>/Gridstack/dist/gridstack-h5.js"></script>
<?php
$price = "Select * from user_dashboard where dashboard_url = '".$_REQUEST['file']."'";
$result = mysqli_query($con,$price);
if(mysqli_num_rows($result) > 0){
  $_SESSION['url'] = $_REQUEST['file'];
  $priceResultinfo = mysqli_fetch_array($result);
  $us_dash_id  = $priceResultinfo['us_dash_id'];
  $dashboard_data = $priceResultinfo['dashboard_data'];

  if($priceResultinfo['browser_enabled'] == 0){
    header("Location: filenotfound.php?browser=1");
    exit;
  }

  if($priceResultinfo['ip_dns'] != ''){
    $ip = $_SERVER['REMOTE_ADDR'];
    if($priceResultinfo['ip_dns'] != $ip){
      header("Location: filenotfound.php?ip=1");
      exit;
    }
  }

  $impressions = '';
  $check_impression = "SELECT * FROM cs_users where id = '".$priceResultinfo['user_id']."' OR oauth_uid = '".$priceResultinfo['user_id']."'";
  $result = mysqli_query($con,$check_impression);
  if(mysqli_num_rows($result) > 0){
    $data = mysqli_fetch_array($result);
    $impressions = $data['impressions'];
    //echo $impressions;exit;
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
          dashboard_id,
          impression,
          imp_date
          ) VALUES(
          '" . addslashes($priceResultinfo['us_dash_id']) . "',
          '1',
          '" . addslashes($imp_date) . "'
          )";
      $imp_query_result = mysqli_query($con,$imp_query);
    }
  } else{
    header("Location: filenotfound.php?del=1");
  exit;
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
  $ip_city = $new_arr[0]['geoplugin_city'];
  $ip_region = $new_arr[0]['geoplugin_region'];
  $ip_countryName = $new_arr[0]['geoplugin_countryName'];
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
?>
<meta property="og:type" content="website" />
<meta property="og:title" content="ShareIo">
<meta property="og:image" content="<?php echo SITE_URL;?>/images/content-share-new-logo.png">
<meta property="og:description" content="ShareIo">
<meta property="og:url" content="<?php echo SITE_URL;?>/dashboard/<?php echo $_REQUEST['file'];?>">
<meta name="twitter:card" content="summary_large_image">
<meta name="twitter:title" content="ShareIO">
<meta name="twitter:image" content="<?php echo SITE_URL;?>/images/content-share-new-logo.png">
<title>ShareIO</title>
<link rel="stylesheet" type="text/css" href="css/flipbook.style.css">
<link rel="stylesheet" type="text/css" href="css/font-awesome.css">
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

<?php 
  $userconfig = "SELECT * from user_config WHERE user_id = '" . $priceResultinfo['user_id'] . "'";
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

  if($priceResultinfo['bg_color'] != ''){
    $pagebg = $priceResultinfo['bg_color'];
  }
  
?>
<script>
    var linear = <?php echo json_encode($pagebg);?>;
    $('body').css('background', linear);
</script>

<div class="evaluation_banner"> 
  <?php if($priceResultinfo['hide_banner'] == '0' || $priceResultinfo['hide_banner'] == ''){?>
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
      </div>
    </div>
  <?php }?>

<div class="loader"></div>
<div id="content">
  <div class="grid-stack grid-stack-12 dashboard_grid_stack"></div>
</div>

<div class="icons_list">
  <?php if($priceResultinfo["social_share"] == '1'){?>
    <div class="icons link_icon social_icons_show_hide social_share">
      <div class="link_icon_img">
        <a href="javascript:;" class="">
          <svg xmlns="http://www.w3.org/2000/svg" width="52" viewBox="0 0 24 24" width="70px" fill="#6b6b6b"><path d="M0 0h24v24H0z" fill="none"></path><path d="M3.9 12c0-1.71 1.39-3.1 3.1-3.1h4V7H7c-2.76 0-5 2.24-5 5s2.24 5 5 5h4v-1.9H7c-1.71 0-3.1-1.39-3.1-3.1zM8 13h8v-2H8v2zm9-6h-4v1.9h4c1.71 0 3.1 1.39 3.1 3.1s-1.39 3.1-3.1 3.1h-4V17h4c2.76 0 5-2.24 5-5s-2.24-5-5-5z"></path></svg>
        </a>
      </div>
      <div class="close_icon" style="display: none;">
        <a href="javascript:;" >
          <svg xmlns="http://www.w3.org/2000/svg" width="52" viewBox="0 0 24 24" width="24px" fill="#6b6b6b"><path d="M0 0h24v24H0V0z" fill="none"></path><path d="M19 6.41L17.59 5 12 10.59 6.41 5 5 6.41 10.59 12 5 17.59 6.41 19 12 13.41 17.59 19 19 17.59 13.41 12 19 6.41z"></path>
          </svg>
        </a>
      </div>
      <div class="icons social_icons" style="display: none;">
        <div class="social_share_list">
          <div class="social_icons_list">
            <a class="facebook_icon" href="https://www.facebook.com/sharer/sharer.php?u=<?php echo SITE_URL;?>/dashboard/<?php echo $priceResultinfo["dashboard_url"];?>" target="_blank">
              <svg xmlns="http://www.w3.org/2000/svg" fill="#6b6b6b" viewBox="0 0 24 24" width="24px" height="24px">    <path d="M17.525,9H14V7c0-1.032,0.084-1.682,1.563-1.682h1.868v-3.18C16.522,2.044,15.608,1.998,14.693,2 C11.98,2,10,3.657,10,6.699V9H7v4l3-0.001V22h4v-9.003l3.066-0.001L17.525,9z"/></svg>
            </a>
          </div>
          <div class="social_icons_list">
            <a class="twitter_icon" href="https://twitter.com/share?url=<?php echo SITE_URL;?>/dashboard/<?php echo $priceResultinfo["dashboard_url"];?>" target="_blank">
              <svg xmlns="http://www.w3.org/2000/svg" fill="#6b6b6b" viewBox="0 0 30 30" width="30px" height="30px">    <path d="M28,6.937c-0.957,0.425-1.985,0.711-3.064,0.84c1.102-0.66,1.947-1.705,2.345-2.951c-1.03,0.611-2.172,1.055-3.388,1.295 c-0.973-1.037-2.359-1.685-3.893-1.685c-2.946,0-5.334,2.389-5.334,5.334c0,0.418,0.048,0.826,0.138,1.215 c-4.433-0.222-8.363-2.346-10.995-5.574C3.351,6.199,3.088,7.115,3.088,8.094c0,1.85,0.941,3.483,2.372,4.439 c-0.874-0.028-1.697-0.268-2.416-0.667c0,0.023,0,0.044,0,0.067c0,2.585,1.838,4.741,4.279,5.23 c-0.447,0.122-0.919,0.187-1.406,0.187c-0.343,0-0.678-0.034-1.003-0.095c0.679,2.119,2.649,3.662,4.983,3.705 c-1.825,1.431-4.125,2.284-6.625,2.284c-0.43,0-0.855-0.025-1.273-0.075c2.361,1.513,5.164,2.396,8.177,2.396 c9.812,0,15.176-8.128,15.176-15.177c0-0.231-0.005-0.461-0.015-0.69C26.38,8.945,27.285,8.006,28,6.937z"/></svg>
            </a>
          </div>
          <div class="social_icons_list">
            <a class="linkedin_icon" href="http://www.linkedin.com/shareArticle?mini=true&amp;url=<?php echo SITE_URL;?>/dashboard/<?php echo $priceResultinfo["dashboard_url"];?>&amp;summary=some%20summary%20if%20you%20want&amp;source=<?php echo SITE_URL;?>/" target="_blank">
              <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" version="1.1" width="256" height="256" viewBox="0 0 256 256" fill="#6b6b6b" xml:space="preserve">
              <defs>
              </defs>
              <g transform="translate(128 128) scale(0.72 0.72)" style="">
                <g style="stroke: none; stroke-width: 0; stroke-dasharray: none; stroke-linecap: butt; stroke-linejoin: miter; stroke-miterlimit: 10; fill: none; fill-rule: nonzero; opacity: 1;" transform="translate(-175.05 -175.05000000000004) scale(3.89 3.89)">
                <path d="M 1.48 29.91 h 18.657 v 60.01 H 1.48 V 29.91 z M 10.809 0.08 c 5.963 0 10.809 4.846 10.809 10.819 c 0 5.967 -4.846 10.813 -10.809 10.813 C 4.832 21.712 0 16.866 0 10.899 C 0 4.926 4.832 0.08 10.809 0.08" style="stroke: none; stroke-width: 1; stroke-dasharray: none; stroke-linecap: butt; stroke-linejoin: miter; stroke-miterlimit: 10; fill: #6b6b6b; fill-rule: nonzero; opacity: 1;" transform=" matrix(1 0 0 1 0 0) " stroke-linecap="round"/>
                <path d="M 31.835 29.91 h 17.89 v 8.206 h 0.255 c 2.49 -4.72 8.576 -9.692 17.647 -9.692 C 86.514 28.424 90 40.849 90 57.007 V 89.92 H 71.357 V 60.737 c 0 -6.961 -0.121 -15.912 -9.692 -15.912 c -9.706 0 -11.187 7.587 -11.187 15.412 V 89.92 H 31.835 V 29.91 z" style="stroke: none; stroke-width: 1; stroke-dasharray: none; stroke-linecap: butt; stroke-linejoin: miter; stroke-miterlimit: 10; fill: #6b6b6b; fill-rule: nonzero; opacity: 1;" transform=" matrix(1 0 0 1 0 0) " stroke-linecap="round"/>
              </g>
              </g>
              </svg>
            </a>
          </div>
        </div>
      </div>
    </div>  
  <?php }?>
</div>

<script>
  let options = {
        column: 12,
        disableOneColumnMode: true,
        acceptWidgets: function (el) { return true; }
    };
    let items = <?php echo $dashboard_data;?>;

    let grid = GridStack.init(options)

    grid.load(items);
    grid.setStatic(true);
    grid.on('dropped', function (event, previousWidget, newWidget) {
        if (event.dataTransfer) {
            console.log('gridstack dropped: ', event.dataTransfer.getData('message'));
        }
    });

    grid.on('added removed', function(e, items) {
        let str = '';
        items.forEach(function(item) { str += ' (x,y)=' + item.x + ',' + item.y; });
        console.log(e.type + ' ' + items.length + ' items:' + str );
    });

    function clone(event) {
        return event.target.cloneNode(true);
    }

    function start(event) {
        if (event.dataTransfer) {
            event.dataTransfer.setData('message', 'Hello World');
        }
    }

    $(document).ready(function() {
      $('.changefile').each(function(){
        $(this).addClass('dashboard_tile');
        var href = $(this).data('href');
        $(this).attr('href', href);
      });
      $('.remove-stack').remove();
      $('.loader').hide();
    });
</script>
<?php
} else{ 
?>
<!-- <h1>Content not found.</h1> -->
<?php
header("Location: filenotfound.php");
} ?>

<script>    
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
  $(".social_icons_show_hide .link_icon_img").click(function(){
    $(".link_icon_img").hide(350);
    $(".close_icon").show(350);
    $(".social_icons").show(350);
  });
  $(".social_icons_show_hide .close_icon").click(function(){
    $(".link_icon_img").show(350);
    $(".close_icon").hide(350);
    $(".social_icons").hide(350);
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

setInterval(function(){
  var notification = <?php echo json_encode($priceResultinfo['notification']);?>;
   var id = <?php echo json_encode($us_dash_id);?>;
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
  var id = <?php echo json_encode($us_dash_id);?>;
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
</script>


</html>
