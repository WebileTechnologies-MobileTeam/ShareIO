<!DOCTYPE html>
<?php
  ini_set('error_reporting', 1);
  session_start();
  unset($_SESSION['memberlogin']);
  unset($_SESSION['contenturl']);
  unset($_SESSION['member_audio_file']);
  if(isset($_COOKIE['loginuser'])){
      $_SESSION["user"] = $_COOKIE['loginuser'];
  }else{
      $cookie_value = $_SESSION["user"];
      setcookie("loginuser", $cookie_value, time() + (86400 * 30), "/"); // 86400 = 1 day
  }
  
  ?>
<html lang="en" class="dashboard_landing">
  <title>Shareio &mdash; Empower Digital Asset | Digital Asset Secure, Share and Sell by Shareio</title>
  <?php require('./include/db.php');
    include('config.php');
    include('facebook_config.php');
    include('./hotmail/hotmail.php');
    include('./linkedin/auth.php');
    //include('Twitter/index.php');
    ?>
  <style>
    #container {
    margin: 20px;
    width: 200px;
    height: 200px;
    position: relative;
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
    /* Chrome, Safari, Edge, Opera */
    input::-webkit-outer-spin-button,
    input::-webkit-inner-spin-button {
    -webkit-appearance: none;
    margin: 0;
    }
    /* Firefox */
    input[type=number] {
    -moz-appearance: textfield;
    }
  </style>
  <?php require('head.php'); 
    $sql = "SELECT * from cs_users where id = '" . $_SESSION["user"] . "' OR oauth_uid =  '" . $_SESSION["user"] . "'";
    $result = mysqli_query($con,$sql);
    $response = mysqli_fetch_array($result);
    
    if(isset($_SESSION['is_blocked']) || $response['is_blocked'] == '1'){?>
  <script>
    jQuery(document).ready(function($) {
      cuteAlert({
        type: "error",
        title: "Oops...",
        message: "User ID is blocked please contact shareio for more information.",
        buttonText: "Close"
      })
    });
  </script>
  <?php 
    //unset($_SESSION['is_blocked']);
    unset($_SESSION["user"]);
    }
    ?>
  <body class="landing_page_body slides horizontal simplifiedMobile animated default-background">
    <?php require('header-new.php'); ?>
    <?php 
      if (isset($_SESSION['succsessmsg'])){ ?>  
    <input type="hidden" id="succsessmsg" name="succsessmsg" value="<?php echo $_SESSION['succsessmsg'];?>">
    <script>
      jQuery(document).ready(function($) {
        var msg = $('#succsessmsg').val();
        if(msg != ''){
            cuteAlert({
                type: "success",
                title: "Success",
                message: msg,
                buttonText: "Close"
            })
        }
      });
    </script>
    <?php 
      unset($_SESSION['succsessmsg']);
      }
      if(isset($_SESSION['error'])){?>
    <input type="hidden" id="errormsg" name="errormsg" value="<?php echo $_SESSION['error'];?>">
    <script>
      jQuery(document).ready(function($) {
        var msg = $('#errormsg').val();
        if(msg != ''){
            cuteAlert({
              type: "error",
              title: "Oops...",
              message: msg,
              buttonText: "Close"
            })
        }
      });
    </script>
    <?php 
      unset($_SESSION['error']);
      }
      if(isset($_SESSION['errormsgimp'])){ ?>
    <input type="hidden" id="errormsgimp" name="errormsgimp" value="<?php echo $_SESSION['errormsgimp'];?>">
    <script>
      jQuery(document).ready(function($) {
         var msg = $('#errormsgimp').val();
         if(msg != ''){
            cuteAlert({
                type: "question",
                title: "Buy Impression",
                message: "Your impressions tokens have expired. Please update your tokens by going to your settings page.",
                confirmText: "Yes",
                cancelText: "Cancel"
            }).then((e)=>{
              if ( e == ("confirm")){
                window.location = "setting.php";
              }
            })
            }
         });
    </script>
    <?php 
      unset($_SESSION['errormsgimp']);
      }  
      if(isset($_GET['s']) && isset($_SESSION['user']) && !empty($_SESSION['user'])){ ?>
    <main>
      <div class="container new_container">
        <div class="row">
          <div class="col-md-12">
            <div class="main_content hidden">
              <script type="text/javascript">
                $('body').removeClass('default-background');
                $(document).ready(function(){
                  var ajax = $.ajax({
                      type: "POST",
                      url: "index.php",
                    });
                  $( ".main_content" ).addClass( "hidden" );     
                  ajax.then(function(data) {
                        $( ".main_content" ).html(data).removeClass("hidden");
                        $('body').removeClass('landing_page_body');
                    })
                });
              </script>
            </div>
          </div>
        </div>
      </div>
    </main>
    <?php } else{ ?>
    <?php
      if(isset($_SESSION['user']) && !empty($_SESSION['user'])){
       $sql = "SELECT * from cs_users where id = '" . $_SESSION["user"] . "' OR oauth_uid =  '" . $_SESSION["user"] . "'";
       $result = mysqli_query($con,$sql);
       $fetch_data = mysqli_fetch_array($result);
       $imp = $fetch_data['impressions']; 
       //echo $imp;exit;
      
       if(!isset($_SESSION['imp'])){?>
    <script>
      jQuery(document).ready(function($) {
        var imp = <?php echo json_encode($imp);?>;
        if(imp == 0){
             cuteAlert({
                  type: "question",
                  title: "Buy Impression",
                  message: "Your impressions tokens have expired. Please update your tokens by going to your settings page.",
                  confirmText: "Yes",
                  cancelText: "Cancel"
              }).then((e)=>{
                if ( e == ("confirm")){
                  window.location = "setting.php";
                }
              })
            }
          });
    </script>
    <?php 
      $_SESSION['imp'] = $imp;
      }
      }
      ?>
    <script>
      if(screen.width > 768){
      	document.write("<link href='<?php echo SITE_URL;?>/shareiolandingpage/css/slides.min.css' rel='stylesheet' type='text/css'>");
      	$('body').removeClass('mobilecustom');
      } else{
      	document.write("<link href='<?php echo SITE_URL;?>/shareiolandingpage/css/mobileslides.css' rel='stylesheet' type='text/css'>");
      	$('body').addClass('mobilecustom');
      }
    </script>
    <script src="<?php echo SITE_URL;?>/shareiolandingpage/js/slides.min.js" type="text/javascript"></script>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@100;300;400;500;700;900&display=swap" rel="stylesheet">
    <link href="http://vjs.zencdn.net/c/video-js.css" rel="stylesheet">
    <script src="http://vjs.zencdn.net/c/video.js"></script> 
    <svg xmlns="http://www.w3.org/2000/svg" style="display:none">
      <symbol id="arrow-left" viewBox="0 0 29 56">
        <path d="M28.7.3c.4.4.4 1 0 1.4l-26.3 26.3 26.3 26.3c.4.4.4 1 0 1.4-.4.4-1 .4-1.4 0l-27-27c-.4-.4-.4-1 0-1.4l27-27c.3-.3 1-.4 1.4 0z" />
      </symbol>
      <symbol id="arrow-right" viewBox="0 0 29 56">
        <path d="M.3 55.7c-.4-.4-.4-1 0-1.4l26.3-26.3-26.3-26.3c-.4-.4-.4-1 0-1.4.4-.4 1-.4 1.4 0l27 27c.4.4.4 1 0 1.4l-27 27c-.3.3-1 .4-1.4 0z" />
      </symbol>
      <symbol id="back" viewBox="0 0 20 20">
        <path d="M2.3 10.7l5 5c.4.4 1 .4 1.4 0s.4-1 0-1.4l-3.3-3.3h11.6c.6 0 1-.4 1-1s-.4-1-1-1h-11.6l3.3-3.3c.4-.4.4-1 0-1.4-.2-.2-.4-.3-.7-.3s-.5.1-.7.3l-5 5c-.2.2-.3.5-.3.7 0 .2.1.5.3.7z" />
      </symbol>
      <symbol id="arrow-down" viewBox="0 0 24 24">
        <path d="M12 18c-.2 0-.5-.1-.7-.3l-11-10c-.4-.4-.4-1-.1-1.4.4-.4 1-.4 1.4-.1l10.4 9.4 10.3-9.4c.4-.4 1-.3 1.4.1.4.4.3 1-.1 1.4l-11 10c-.1.2-.4.3-.6.3z" />
      </symbol>
      <symbol id="arrow-up" viewBox="0 0 24 24">
        <path d="M11.9 5.9c.2 0 .5.1.7.3l11 10c.4.4.4 1 .1 1.4-.4.4-1 .4-1.4.1l-10.4-9.4-10.3 9.4c-.4.4-1 .3-1.4-.1-.4-.4-.3-1 .1-1.4l11-10c.1-.2.4-.3.6-.3z" />
      </symbol>
      <symbol id="arrow-top" viewBox="0 0 18 18">
        <path d="M15.7 7.3l-6-6c-.4-.4-1-.4-1.4 0l-6 6c-.4.4-.4 1 0 1.4.4.4 1 .4 1.4 0l4.3-4.3v11.6c0 .6.4 1 1 1s1-.4 1-1v-11.6l4.3 4.3c.2.2.4.3.7.3s.5-.1.7-.3c.4-.4.4-1 0-1.4z" />
      </symbol>
      <symbol id="sound-on" viewBox="0 0 18 18">
        <path d="M8.5,0.1C8.1-0.1,7.7,0,7.4,0.2L3.7,3H2C0.9,3,0,3.9,0,5v6c0,1.1,0.9,2,2,2h1.7l3.7,2.8C7.6,15.9,7.8,16,8,16 c0.2,0,0.3,0,0.4-0.1C8.8,15.7,9,15.4,9,15V1C9,0.6,8.8,0.3,8.5,0.1z M7,13l-2.4-1.8C4.4,11.1,4.2,11,4,11l-2,0l0-6h2 c0.2,0,0.4-0.1,0.6-0.2L7,3V13z M11.7,9.9l0.7,1.9C13.9,11.2,15,9.7,15,8c0-1.7-1.1-3.2-2.7-3.8l-0.7,1.9C12.5,6.4,13,7.2,13,8C13,8.9,12.5,9.6,11.7,9.9z M12.2,1.1l-0.3,2C14.3,3.5,16,5.6,16,8s-1.8,4.5-4.2,4.9l0.3,2C15.6,14.3,18,11.4,18,8C18,4.6,15.6,1.7,12.2,1.1z" />
      </symbol>
      <symbol id="sound-off" viewBox="0 0 18 18">
        <path d="M15.9,8l1.8-1.8c0.4-0.4,0.4-1,0-1.4s-1-0.4-1.4,0l-1.8,1.8l-1.8-1.8c-0.4-0.4-1-0.4-1.4,0s-0.4,1,0,1.4L13.1,8l-1.8,1.8 c-0.4,0.4-0.4,1,0,1.4c0.2,0.2,0.5,0.3,0.7,0.3s0.5-0.1,0.7-0.3l1.8-1.8l1.8,1.8c0.2,0.2,0.5,0.3,0.7,0.3s0.5-0.1,0.7-0.3 c0.4-0.4,0.4-1,0-1.4L15.9,8z M8.5,0.1C8.1-0.1,7.7,0,7.4,0.2L3.7,3H2C0.9,3,0,3.9,0,5v6c0,1.1,0.9,2,2,2h1.7l3.7,2.8C7.6,15.9,7.8,16,8,16 c0.2,0,0.3,0,0.4-0.1C8.8,15.7,9,15.4,9,15V1C9,0.6,8.8,0.3,8.5,0.1z M7,13l-2.4-1.8C4.4,11.1,4.2,11,4,11l-2,0l0-6h2 c0.2,0,0.4-0.1,0.6-0.2L7,3V13z" />
      </symbol>
    </svg>
    <!-- Panel Top #05 -->
    <nav class="panel top">
      <div class="sections compact hidden">
        <div class="left">
          <a href="#" title="Slides Framework">
            <svg style="width:82px;height:24px">
              <use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#logo"></use>
            </svg>
          </a>
        </div>
        <div class="right">
          <span class="button actionButton sidebarTrigger" data-sidebar-id="1">
            <svg>
              <use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#menu"></use>
            </svg>
          </span>
        </div>
      </div>
    </nav>
    <!-- Slide 1 (#34) -->
    <section id="slide1" class="slide fade-6 kenBurns videoslide">
      <div class="Asset">
        <div class="container">
          <div class="wrap">
            <div class="fix-12-12">
              <ul class="flex fixedSpaces verticalCenter reverse">
                <li class="col-6-12 left middle">
                  <h1 class="typewriter-text-sec ae-1 fromLeft">
                    <span>
                    <a href="" class="typewrite" data-period="2000" data-type='[ "empower", "protect", "sell", "distribute", "share" ]'>
                    <span class="wrap"></span>
                    </a>
                    </span>
                    <span class="digital-static">digital assets</span>
                  </h1>
                </li>
                <li class="col-6-12 ae-4">
                  <img class="ae-4" width="370" src="shareiolandingpage/assets/img/content-share-new-logo-small.png" alt="using shareio" />
                </li>
              </ul>
            </div>
          </div>
        </div>
      </div>
      <video id="slide1-video" autoplay loop muted style="margin: auto;position: absolute;z-index: -1;top: 50%;left: 50%;transform: translate(-50%, -50%);visibility: visible;opacity: 1;width: 100%;height: auto;">
        <source src="shareiolandingpage/assets/img/background/video-background-original-2.mp4" type="video/mp4">
      </video>
    </section>
    <!-- Slide 2 -->
    <section id="slide2" class="full-width-slide slide fade-6 kenBurns">
      <div class="content">
        <div class="container">
          <div class="wrap">
            <div class="fix-12-12">
              <div class="top-text ae-5 fromTop">
                <h1>Secure, Share and Sell</h1>
                <p class="using-shareio opacity-8">
                  <img class="small-logo" src="shareiolandingpage/assets/img/content-share-new-logo-small.png" alt="Shareio Logo" />
                </p>
              </div>
              <div class="selected ae-3 fromCenter">
                <img class="main-center-img wide fromCenter" src="shareiolandingpage/assets/img/computer02.png" alt="Monetize Platforms" />
              </div>
              <h3 class="alldigitalcontent ae-7 fromBottom">
                All<span class="light"> your </span>digital assets <span class="light">across multiple devices</span>
              </h3>
            </div>
          </div>
        </div>
      </div>
      <div class="background" style="background-image:url(shareiolandingpage/assets/img/background/img-26.jpg)"></div>
    </section>
    <!-- Slide 3 -->
    <section id="slide3" class="simple-steps-sec slide fade-6 kenBurns">
      <div class="content">
        <div class="container">
          <div class="wrap">
            <div class="fix-12-12">
              <ul class="flex reverse">
                <li class="col-6-12 left ae-1 fromRight left-col">
                  <ul class="slider animated" data-slider-id="60-1">
                    <li class="selected">
                      <h3 class="alldigitalcontent ae-2 fromRight"><label>Simple <span class="light">steps to</span> distribute <span class="light">and </span> sell <span class="light">your assets using SHAREIO</span></label></span>
                      </h3>
                      <img class="wide fromCenter ae-3" src="shareiolandingpage/assets/img/steps-screen.png" alt="Data Secure" />
                    </li>
                  </ul>
                </li>
                <li class="col-6-12 left right-col">
                  <div class="relative">
                    <div class="text">
                      <div class="steps-sequance ae-5 fromRight">
                        <span class="step-img">
                        <img class="wide fromCenter ae-3" src="shareiolandingpage/assets/img/lock.png" alt="Secure" />
                        </span>
                        <div class="steps-text-grp">
                          <h3 class="alldigitalcontent">Secure</h3>
                          <p>Upload any asset to the ShareIO website, <b>allow it to be evaluated</b> and share the unique URL. It's really quick and simple! </p>
                        </div>
                        <span class="steps-numbers-right">1</span>
                      </div>
                      <div class="steps-sequance ae-7 fromRight">
                        <span class="step-img">
                        <img class="wide fromCenter ae-3" src="shareiolandingpage/assets/img/world.png" alt="Share" />
                        </span>
                        <div class="steps-text-grp">
                          <h3 class="alldigitalcontent">Share</h3>
                          <p><b>Share the URL</b> to your assets via any channel such as a <b>website, social media or email</b></p>
                        </div>
                        <span class="steps-numbers-right">2</span>
                      </div>
                      <div class="steps-sequance ae-9 fromRight">
                        <span class="step-img">
                        <img class="wide fromCenter ae-3" src="shareiolandingpage/assets/img/card.png" alt="Sell" />
                        </span>
                        <div class="steps-text-grp">
                          <h3 class="alldigitalcontent">Sell</h3>
                          <p>Allow your assets to be optionally <b>converted into a paid version</b> from any platform it's being viewed on. </p>
                        </div>
                        <span class="steps-numbers-right">3</span>
                      </div>
                    </div>
                  </div>
                </li>
              </ul>
            </div>
          </div>
        </div>
      </div>
      <div class="background" style="background-image:url(shareiolandingpage/assets/img/background/img-26.jpg)"></div>
    </section>
    <!-- Slide 4 -->
    <section id="slide4" class="full-width-slide slide fade-6 kenBurns">
      <div class="content">
        <div class="container">
          <div class="wrap">
            <div class="fix-12-12">
              <div class="top-text ae-3 fromTop">
                <h1>Reach a Global Market</h1>
                <p class="using-shareio opacity-8">
                  <img class="small-logo" src="shareiolandingpage/assets/img/content-share-new-logo-small.png" alt="Shareio Logo" />
                </p>
              </div>
              <div class="selected ae-6 fromCenter">
                <img class="main-center-img wide fromCenter" src="shareiolandingpage/assets/img/global-market.png" alt="Global Market" />
              </div>
              <h3 class="alldigitalcontent ae-9 fromBottom">
                $208bn<span class="light"> of digital assets was sold in 2020 and rises to </span><span class="yellowtext">$414bn</span> <span class="light">in 2025</span>
              </h3>
            </div>
          </div>
        </div>
      </div>
      <div class="background" style="background-image:url(shareiolandingpage/assets/img/background/img-26.jpg)"></div>
    </section>
    <!-- Slide 5 -->
    <section id="slide5" class="full-width-slide slide fade-6 kenBurns">
      <div class="content">
        <div class="container">
          <div class="wrap">
            <div class="fix-12-12">
              <div class="top-text ae-5 fromTop">
                <h1>Monetize Popular Platforms</h1>
                <p class="using-shareio opacity-8">
                  <img class="small-logo" src="shareiolandingpage/assets/img/content-share-new-logo-small.png" alt="Shareio Logo" />
                </p>
              </div>
              <div class="selected ae-3 fromCenter">
                <img class="wide fromCenter" src="shareiolandingpage/assets/img/social.png" alt="Monetize Platforms" />
              </div>
              <h3 class="alldigitalcontent ae-7 fromBottom">
                <span class="light">Works with </span> all <span class="light">leading social media, email and messenger platforms</span>
              </h3>
            </div>
          </div>
        </div>
      </div>
      <div class="background" style="background-image:url(shareiolandingpage/assets/img/background/img-26.jpg)"></div>
    </section>
    <!-- Slide 6 -->
    <section id="slide6" class="full-width-slide slide fade-6 kenBurns">
      <div class="content">
        <div class="bubbles">
          <div class="bubble"></div>
          <div class="bubble"></div>
          <div class="bubble"></div>
          <div class="bubble"></div>
          <div class="bubble"></div>
          <div class="bubble"></div>
          <div class="bubble"></div>
          <div class="bubble"></div>
          <div class="bubble"></div>
          <div class="bubble"></div>
        </div>
        <div class="container">
          <div class="wrap">
            <div class="fix-12-12">
              <div class="top-text ae-5 fromTop">
                <h1>Capture New Revenue</h1>
                <p class="using-shareio opacity-8">
                  <img class="small-logo" src="shareiolandingpage/assets/img/content-share-new-logo-small.png" alt="Shareio Logo" />
                </p>
              </div>
              <div class="selected ae-3 fromCenter">
                <img class="main-center-img wide fromCenter" src="shareiolandingpage/assets/img/hooksss-(1).png" alt="New Revenue" />
              </div>
              <h3 class="alldigitalcontent ae-7 fromBottom">
                <span class="light">An </span>innovative technology <span class="light">to enhance your existing revenue streams</span>
              </h3>
            </div>
          </div>
        </div>
      </div>
      <div class="background" style="background-image:url(shareiolandingpage/assets/img/background/img-26.jpg)"></div>
    </section>
    <style>
    </style>
    <!-- Slide7 -->
    <section id="slide7" class="slide fade-6 kenBurns">
      <div class="content">
        <div class="container">
          <div class="wrap">
            <div class="fix-12-12">
              <ul class="flex reverse verticalCenter">
                <li class="col-6-12 left cell-26 innovative-features">
                  <h1 class="ae-1 fromLeft">Innovative Features</h1>
                  <div class="ae-2 fromLeft">
                    <p class="using-shareio opacity-8">
                      <img class="small-logo" src="shareiolandingpage/assets/img/content-share-new-logo-small.png" alt="Shareio Logo">
                    </p>
                  </div>
                  <div class="relative">
                    <div class="text">
                      <p><span class="featurescount">1</span><span class="feature_content">Upload any asset and specify how it can be viewed. Set a price and add additional files that can be unpackaged on purchase. Watermark your files with text or an image.</span></p>
                      <p><span class="featurescount">2</span><span class="feature_content">Update your assets in real time to make sure your recipients have the latest version. Suspend shares in real time to your assets giving you full control.</span></p>
                    </div>
                  </div>
                </li>
                <li class="col-6-12 left ae-5 fromRight">
                  <ul class="slider animated" data-slider-id="60-1">
                    <li class="selected">
                      <div class="innovative_desktop_step innovative_step1">
                        <div class="innovative_desktop_step_img">
                          <img class="innovative_desktop_img" src="shareiolandingpage/assets/img/innovative_step1.png" alt="Data Secure">
                          <img class="innovative_desktop_gif_img" src="shareiolandingpage/assets/gif/innovative_screen1.gif" alt="Data Secure">
                        </div>
                        <div class="innovative_mobile_step_img">
                          <img class="innovative_mobile_img" src="shareiolandingpage/assets/img/innovative_step1_phone_blank.png" alt="Data Secure">
                          <img class="innovative_mobile_gif_img" src="shareiolandingpage/assets/gif/innovative_mobile_screen1.gif" alt="Data Secure">
                        </div>
                      </div>
                      <div class="innovative_desktop_step_dot">
                        <img class="center fromCenter ae-6" src="shareiolandingpage/assets/img/sliderdot1.png" alt="Data Secure">
                      </div>
                    </li>
                  </ul>
                </li>
              </ul>
            </div>
          </div>
        </div>
      </div>
      <div class="background" style="background-image:url(shareiolandingpage/assets/img/background/img-26.jpg)"></div>
    </section>
    <!-- Slide7-2 -->
    <section id="slide7" class="slide fade-6 kenBurns">
      <div class="content">
        <div class="container">
          <div class="wrap">
            <div class="fix-12-12">
              <ul class="flex reverse verticalCenter">
                <li class="col-6-12 left cell-26 innovative-features">
                  <h1 class="ae-1 fromLeft">Innovative Features</h1>
                  <div class="ae-2 fromLeft">
                    <p class="using-shareio opacity-8">
                      <img class="small-logo" src="shareiolandingpage/assets/img/content-share-new-logo-small.png" alt="Shareio Logo">
                    </p>
                  </div>
                  <div class="relative">
                    <div class="text">
                      <p><span class="featurescount">3</span><span class="feature_content">Control restrictions to assets such as download access, and watermarks. Also lock it to a password, domain and  country block.</span></p>
                      <p><span class="featurescount">4</span><span class="feature_content">All assets are updated in real-time so all the changes you make are instantly reflected on the recipients devices.</span></p>
                    </div>
                  </div>
                </li>
                <li class="col-6-12 left ae-5 fromRight">
                  <ul class="slider animated" data-slider-id="60-1">
                    <li class="selected">
                      <div class="innovative_desktop_step innovative_step2">
                        <div class="innovative_desktop_step_img">
                          <img class="innovative_desktop_img" src="shareiolandingpage/assets/img/innovative_step1.png" alt="Data Secure">
                          <img class="innovative_desktop_gif_img" src="shareiolandingpage/assets/gif/innovative_screen2.gif" alt="Data Secure">
                        </div>
                        <div class="innovative_mobile_step_img">
                          <img class="innovative_mobile_img" src="shareiolandingpage/assets/img/innovative_step1_phone_blank.png" alt="Data Secure">
                          <img class="innovative_mobile_gif_img" src="shareiolandingpage/assets/gif/innovative_mobile_screen2.gif" alt="Data Secure">
                        </div>
                      </div>
                      <div class="innovative_desktop_step_dot">
                        <img class="fromCenter ae-6 center" src="shareiolandingpage/assets/img/sliderdot2.png" alt="Data Secure">
                      </div>
                    </li>
                  </ul>
                </li>
              </ul>
            </div>
          </div>
        </div>
      </div>
      <div class="background" style="background-image:url(shareiolandingpage/assets/img/background/img-26.jpg)"></div>
    </section>
    <!-- Slide7-3 -->
    <section id="slide7" class="slide fade-6 kenBurns">
      <div class="content">
        <div class="container">
          <div class="wrap">
            <div class="fix-12-12">
              <ul class="flex reverse verticalCenter">
                <li class="col-6-12 left cell-26 innovative-features">
                  <h1 class="ae-1 fromLeft">Innovative Features</h1>
                  <div class="ae-2 fromLeft">
                    <p class="using-shareio opacity-8">
                      <img class="small-logo" src="shareiolandingpage/assets/img/content-share-new-logo-small.png" alt="Shareio Logo">
                    </p>
                  </div>
                  <div class="relative">
                    <div class="text">
                      <p><span class="featurescount">5</span><span class="feature_content">Package different assets into one easy distributable link that your users can pay for via a subscription model.</span></p>
                      <p><span class="featurescount">6</span><span class="feature_content">Add new files giving your users a easy way to receive new assets in real-time.</span></p>
                    </div>
                  </div>
                </li>
                <li class="col-6-12 left ae-5 fromRight">
                  <ul class="slider animated" data-slider-id="60-1">
                    <li class="selected">
                      <div class="innovative_desktop_step innovative_step3">
                        <div class="innovative_desktop_step_img">
                          <img class="innovative_desktop_img" src="shareiolandingpage/assets/img/innovative_step1.png" alt="Data Secure">
                          <img class="innovative_desktop_gif_img" src="shareiolandingpage/assets/gif/innovative_screen3.gif" alt="Data Secure">
                        </div>
                        <div class="innovative_mobile_step_img">
                          <img class="innovative_mobile_img" src="shareiolandingpage/assets/img/innovative_step1_phone_blank.png" alt="Data Secure">
                          <img class="innovative_mobile_gif_img" src="shareiolandingpage/assets/gif/innovative_mobile_screen3.gif" alt="Data Secure">
                        </div>
                      </div>
                      <div class="innovative_desktop_step_dot">
                        <img class="fromCenter ae-6 center" src="shareiolandingpage/assets/img/sliderdot3.png" alt="Data Secure">
                      </div>
                    </li>
                  </ul>
                </li>
              </ul>
            </div>
          </div>
        </div>
      </div>
      <div class="background" style="background-image:url(shareiolandingpage/assets/img/background/img-26.jpg)"></div>
    </section>
    <!-- Slide7-3 -->
    <section id="slide7" class="slide fade-6 kenBurns">
      <div class="content">
        <div class="container">
          <div class="wrap">
            <div class="fix-12-12">
              <ul class="flex reverse verticalCenter">
                <li class="col-6-12 left cell-26 innovative-features">
                  <h1 class="ae-1 fromLeft">Innovative Features</h1>
                  <div class="ae-2 fromLeft">
                    <p class="using-shareio opacity-8">
                      <img class="small-logo" src="shareiolandingpage/assets/img/content-share-new-logo-small.png" alt="Shareio Logo">
                    </p>
                  </div>
                  <div class="relative">
                    <div class="text">
                      <p><span class="featurescount">7</span><span class="feature_content">Detailed analytics on when, where and how your assets is viewed.</span></p>
                      <p><span class="featurescount">8</span><span class="feature_content">Integrate directly into popular social media platforms.</span></p>
                    </div>
                  </div>
                </li>
                <li class="col-6-12 left ae-5 fromRight">
                  <ul class="slider animated" data-slider-id="60-1">
                    <li class="selected">
                      <div class="innovative_desktop_step innovative_step3">
                        <div class="innovative_desktop_step_img">
                          <img class="innovative_desktop_img" src="shareiolandingpage/assets/img/innovative_step1.png" alt="Data Secure">
                          <img class="innovative_desktop_gif_img" src="shareiolandingpage/assets/gif/innovative_screen4.gif" alt="Data Secure">
                        </div>
                        <div class="innovative_mobile_step_img">
                          <img class="innovative_mobile_img" src="shareiolandingpage/assets/img/innovative_step1_phone_blank.png" alt="Data Secure">
                          <img class="innovative_mobile_gif_img" src="shareiolandingpage/assets/gif/innovative_mobile_screen4.png" alt="Data Secure">
                        </div>
                      </div>
                      <div class="innovative_desktop_step_dot">
                        <img class="fromCenter ae-6 center" src="shareiolandingpage/assets/img/sliderdot4.png" alt="Data Secure">
                      </div>
                    </li>
                  </ul>
                </li>
              </ul>
            </div>
          </div>
        </div>
      </div>
      <div class="background" style="background-image:url(shareiolandingpage/assets/img/background/img-26.jpg)"></div>
    </section>
    <!-- Slide 8 -->
    <section id="slide8" class="example-slides slide fade-6 kenBurns">
      <div class="content">
        <div class="container">
          <div class="wrap">
            <div class="fix-12-12">
              <h1 class="ae-2 fromTop tittle-top">Examples in</h1>
              <p class="using-shareio opacity-8 ae-2">
                <img class="small-logo" src="shareiolandingpage/assets/img/content-share-new-logo-small.png" alt="Shareio Logo">
              </p>
              <ul class="flex reverse verticalCenter">
                <li class="col-4-12 left ae-3 distribution-col fromLeft">
                  <h1 class="rotate">Distribution</h1>
                  <div class="relative">
                    <div class="text ae-3 fromCenter">
                      <h3>Medical</h3>
                      <p class="opacity">Distribution medical material</p>
                    </div>
                    <div class="text ae-5 fromCenter">
                      <h3>Tech</h3>
                      <p class="opacity">Distribution of specs and reports</p>
                    </div>
                    <div class="text ae-7 fromCenter">
                      <h3>Marketing</h3>
                      <p class="opacity">Controlled distribution of assets</p>
                    </div>
                    <div class="text ae-9 fromCenter">
                      <h3>Accounts</h3>
                      <p class="opacity">Securely distribute M&A material</p>
                    </div>
                    <div class="text ae-10 fromCenter">
                      <h3>Finanace</h3>
                      <p class="opacity">Distribute investor prospectus</p>
                    </div>
                  </div>
                </li>
                <li class="col-4-12 cell-26 ae-9 example-img fromBottom">
                  <div class="slider8_mobile">
                    <div class="slider8_animation">
                      <img src="shareiolandingpage/assets/img/innovative_step1_phone_blank.png" alt="Phone">
                    </div>
                    <div class="slider8_content">
                      <img src="images/timer.gif" alt="Timer" />
                      <div class="slider8_inner_content_img">
                        <img src="images/pin.png" alt="Pin" >
                        <strong>Your<span>Assets</span>Here</strong>
                      </div>
                    </div>
                  </div>
                </li>
                <li class="col-4-12 left ae-3 selling-col fromRight">
                  <h1 class="rotate">Selling</h1>
                  <div class="relative">
                    <div class="text ae-3 fromCenter">
                      <h3>Producer</h3>
                      <p class="opacity">Share & sell mixed assets</p>
                    </div>
                    <div class="text ae-5 fromCenter">
                      <h3>Musicians</h3>
                      <p class="opacity">Share & sell new tracks / videos</p>
                    </div>
                    <div class="text ae-7 fromCenter">
                      <h3>Artists</h3>
                      <p class="opacity">Share & sell your art, photos or videos</p>
                    </div>
                    <div class="text ae-9 fromCenter">
                      <h3>Retail</h3>
                      <p class="opacity">Share & sell mixed assets</p>
                    </div>
                    <div class="text ae-10 fromCenter">
                      <h3>Trainers</h3>
                      <p class="opacity">Share & sell training materials</p>
                    </div>
                  </div>
                </li>
              </ul>
            </div>
          </div>
        </div>
      </div>
      <div class="background" style="background-image:url(shareiolandingpage/assets/img/background/img-26.jpg)"></div>
    </section>
    <!-- Slide 9 
      <section id="slide9" class="full-width-slide slide fade-6 kenBurns">
        <div class="content">
        <div class="container">
          <div class="wrap">
          <div class="fix-12-12">
          <div class="top-text ae-5 fromTop">
            <h1>Pricing Plan</h1>
            <p class="using-shareio opacity-8">
              <img class="small-logo" src="assets/img/content-share-new-logo-small.png" alt="Shareio Logo" />
            </p>
          </div>
            <div class="selected ae-3 fromCenter">
              <img class="wide fromCenter" src="assets/img/pricing-detail-screen.png" alt="Monetize Platforms" />
            </div>
             <h3 class="alldigitalcontent ae-7 fromBottom">
              <span class="light">1000 </span> free impressions <span class="light">are provided on sign up. An account can be created in seconds.</span>
              </h3>
          </div>
          </div>
        </div>
        </div>
        <div class="background" style="background-image:url(assets/img/background/img-26.jpg)"></div>
      </section> -->
    <!-- Slide 9 DYNAMICS-->
    <section id="slide9" class="full-width-slide slide fade-6 kenBurns">
      <div class="content">
        <div class="container">
          <div class="wrap">
            <div class="fix-12-12">
              <div class="top-text ae-5 fromTop">
                <h1>Pricing Plan</h1>
                <p class="using-shareio opacity-8">
                  <img class="small-logo" src="shareiolandingpage/assets/img/content-share-new-logo-small.png" alt="Shareio Logo" />
                </p>
              </div>
              <div class="selected ae-3 fromCenter">
                <?php 
                  $pricing_calculator = "SELECT * from system_data where system_id = '1' ";
                  $pricing_calculator_result = mysqli_query($con,$pricing_calculator);
                  $pricing_calculator_fetch_data = mysqli_fetch_array($pricing_calculator_result);
                  $commision_percent = (int)$pricing_calculator_fetch_data['sales_commision'];
                  $impressions_cost = (int)$pricing_calculator_fetch_data['impression_cost_per_1k'];
                  ?>
                <div class="pricing-calc-main">
                  <form method="" id="pricecalculation" name="pricecalculation" action="">
                    <div class="row form-row">
                      <div class="form-group form-left-col">
                        <h4>Pricing Calculator ($)</h4>
                        <div class="pricing-block">
                          <div class="row">
                            <div class="form-group">
                              <label class="col-form-label">Volume</label>
                              <input type="number" class="form-control" name="Volume" id="volume" value="1000">
                            </div>
                            <div class="form-group">
                              <label class="col-form-label">Price</label>
                              <input type="number" class="form-control" name="Price" id="price" value="10">
                            </div>
                          </div>
                          <div class="row">
                            <div class="form-group">
                              <label class="col-form-label">Payment Fee (<?php echo $commision_percent;?>%)</label>
                              <input type="text" class="form-control" name="Payment" id="payment" value="500" disabled>
                            </div>
                            <div class="form-group">
                              <label class="col-form-label">Impression Cost</label>
                              <input type="text" class="form-control" name="Cost" id="cost" value="1" disabled>
                            </div>
                          </div>
                          <div class="row">
                            <div class="form-group-full">
                              <label class="col-form-label">You make</label>
                              <input type="text" class="form-control" name="Make" id="make" value="9499" disabled>
                            </div>
                          </div>
                        </div>
                      </div>
                      <div class="form-group form-right-col">
                        <ul>
                          <li>
                            <img class="fromCenter" src="shareiolandingpage/assets/img/arrow.png" alt="price arrow">
                            <p>How much do you expect to sell and for what price</p>
                          </li>
                          <li>
                            <img class="fromCenter" src="shareiolandingpage/assets/img/arrow.png" alt="price arrow">
                            <p>Our payment fee and a very low impression cost</p>
                          </li>
                          <li>
                            <img class="fromCenter" src="shareiolandingpage/assets/img/arrow.png" alt="price arrow">
                            <p>Direct payment to you as soon as transaction occurs</p>
                          </li>
                        </ul>
                      </div>
                    </div>
                  </form>
                  <div class="overlay-img-pricing-col left-overlay"><img class="fromCenter" src="shareiolandingpage/assets/img/phone1.png" alt="price arrow"></div>
                  <div class="overlay-img-pricing-col right-overlay"><img class="fromCenter" src="shareiolandingpage/assets/img/card_pricing.png" alt="price arrow"></div>
                </div>
              </div>
              <h3 class="alldigitalcontent ae-7 fromBottom">
                <span class="light">1000 </span> free impressions <span class="light">are provided on sign up. An account can be created in seconds.</span>
              </h3>
            </div>
          </div>
        </div>
      </div>
      <div class="background" style="background-image:url(shareiolandingpage/assets/img/background/img-26.jpg)"></div>
    </section>
    <!-- Slide 10 -->
    <section id="slide10" class="full-width-slide slide fade-6 kenBurns">
      <div class="content">
        <div class="container">
          <div class="wrap 6th Standard student vocational course">
            <div class="fix-12-12">
              <div class="selected ae-3 fromCenter">
                <img class="wide fromCenter" src="shareiolandingpage/assets/img/slide10-logo.png" alt="Monetize Platforms" />
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="background" style="background-image:url(shareiolandingpage/assets/img/background/img-26.jpg)"></div>
    </section>
    <!-- Panel Bottom #01 -->
    <nav class="panel bottom forceMobileView">
      <div class="sections desktop">
        <div class="center">
          <span class="nextSlide">
            <svg>
              <use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#arrow-down">
              </use>
            </svg>
          </span>
        </div>
      </div>
      <div class="sections compact hidden">
        <div class="right">
          <span data-dropdown-id="2" class="button actionButton dropdownTrigger">
            <svg>
              <use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#share">
              </use>
            </svg>
          </span>
        </div>
      </div>
    </nav>
    <!-- Loading Progress Bar -->
    <div class="progress-bar blue"></div>
    <div class="container new_container">
      <div class="row">
        <div class="col-md-12">
          <div class="login_with_social_media" style="display:none;">
            <label>Login With Social Media</label>
            <ul>
              <li class="facebook"><?php require('./facebook/facebook_auth.php'); ?>
                <?php echo $facebook_login_url; ?>
              </li>
              <li class="linkedin"><a href="<?php echo $loginUrl;?>"><i class="fa fa-linkedin" aria-hidden="true"></i> <span>Login with Linkedin</span></a></li>
              <li class="twitter"><a href="javascript:(0)" id="twitter-login"><i class="fa fa-twitter" aria-hidden="true"></i> <span>Login with Twitter</span></a></li>
              <li class="google"><?php require('./google/auth.php'); ?>
                <?php echo $login_button; ?>
              </li>
              <li class="hotmail">
                <a href="<?php echo $urls; ?>">
                  <svg xmlns="http://www.w3.org/2000/svg" enable-background="new 0 0 24 24" viewBox="0 0 24 24">
                    <path d="M13.5,23.625c-0.034,0-0.068-0.002-0.102-0.007l-12.75-1.75C0.276,21.817,0,21.5,0,21.125v-18c0-0.369,0.269-0.684,0.634-0.741l12.75-2c0.217-0.036,0.437,0.028,0.604,0.171s0.263,0.351,0.263,0.57v21.75c0,0.217-0.094,0.423-0.257,0.565C13.855,23.56,13.68,23.625,13.5,23.625z M1.5,20.471l11.25,1.544V2.002L1.5,3.767V20.471z"/>
                    <path d="M7 16.625c-1.93 0-3.5-2.019-3.5-4.5s1.57-4.5 3.5-4.5 3.5 2.019 3.5 4.5S8.93 16.625 7 16.625zM7 9.125c-1.084 0-2 1.374-2 3s.916 3 2 3 2-1.374 2-3S8.084 9.125 7 9.125zM22.25 19.875H13.5c-.414 0-.75-.336-.75-.75v-14c0-.414.336-.75.75-.75h8.75c.429 0 .841.156 1.159.44C23.781 5.134 24 5.615 24 6.125v12C24 19.09 23.215 19.875 22.25 19.875zM14.25 18.375h8c.136 0 .25-.114.25-.25v-12c0-.072-.028-.138-.078-.181-.056-.049-.109-.069-.172-.069h-8V18.375z"/>
                    <path d="M16.6,11.915c-0.174,0-0.349-0.061-0.489-0.182l-3.1-2.67c-0.314-0.271-0.35-0.744-0.079-1.058c0.271-0.315,0.744-0.349,1.058-0.079l2.595,2.235l5.819-5.339c0.304-0.278,0.778-0.261,1.06,0.046c0.28,0.305,0.26,0.779-0.046,1.06l-6.311,5.79C16.964,11.849,16.781,11.915,16.6,11.915z"/>
                  </svg>
                  <span>Login with Outlook</span>
                </a>
              </li>
            </ul>
          </div>
        </div>
      </div>
    </div>
    <?php }?>
    <?php require('footer-new.php'); ?>
    <script src="https://rawgit.com/kimmobrunfeldt/progressbar.js/1.0.0/dist/progressbar.js"></script>
    <!-- <script src="js/jquery-3.5.1.slim.min.js"></script>
      <script src="js/bootstrap.bundle.min.js"></script> -->
    <script>
      jQuery(document).ready(function($){
      $('#getcontent').on("click", function(){ 
          var ajax = $.ajax({
              type: "POST",
              url: "index.php",
            });
          $( ".main_content" ).addClass( "hidden" );     
          ajax.then(function(data) {
                $( ".main_content" ).html(data).removeClass("hidden");
          })
      });
      
      $(document).on("click", "#twitter-login", function(){
          $.ajax({
               type: "POST",
               url: "Twitter/index.php",          
               success: function(resp) {
                  window.location = resp;
               }
              });
       });
      
      });
    </script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script>
      $(document).ready(function(){
         $( ".main_content" ).removeClass("hidden");
         var video = document.getElementById("slide1-video");
         checkVideo = setInterval(function(){
      if ( video?.readyState === 4 ) {
      $("body").removeClass("default-background");
      clearInterval(checkVideo);
      }
         }, 500);
      });
    </script>
    <script> 
      jQuery.noConflict();
           
      function videoduration(){
           var x = document.getElementById("myVideo").duration;
           var h = Math.floor(x % (3600*24) / 3600);
           var m = Math.floor(x % 3600 / 60);
           var s = Math.floor(x % 60);
      
           var hDisplay = h > 0 ? h + (h == 9 ? ":" : ":") : "";
           var mDisplay = m > 0 ? m + (m == 1 ? ":" : ":") : "";
           var sDisplay = s > 0 ? s + (s == 1 ? " " : " ") : "";
           if(hDisplay == ''){
             hDisplay = "00:";
           }
           if(mDisplay <= '9'){
             mDisplay = "0"+mDisplay;
           }
           var video_duration = hDisplay + mDisplay + sDisplay;
           $('#number').val(video_duration);
           $('#trial_start').val('00:00:01');
           $('#trial_end').val(video_duration);
           $('#getduration').attr('style', 'display: none');
           $('#number').removeAttr('style');
         }

      function getDuration(src) {
        return new Promise(function(resolve) {
            var audio = new Audio();
            $(audio).on("loadedmetadata", function(){
                resolve(audio.duration);
            });
            audio.src = src;
        });
      }
      
      function validateForm() {
       var number = document.forms["uploadFormcontent"]["number"].value;
       var price = document.forms["uploadFormcontent"]["price"].value;
       var fileurl = document.forms["uploadFormcontent"]["fileurl"].value;
       var w_type = document.forms["uploadFormcontent"]["w_type"].value;
       var evaluation_type = document.forms["uploadFormcontent"]["evaluation_type"].value;
       var error = document.getElementById("error");
       var errorfile = document.getElementById("errorfile");
       var errorw = document.getElementById("errorw");
       var errorevl = document.getElementById("errorevl");
       if (fileurl == "") {
         errorfile.style.display = "block";
         errorfile.innerHTML =  
          "Please Select a file to upload.";
         return false;
       }else {
         errorfile.style.display = "none";
         errorfile.innerHTML =  
          "";
       }
       if (number == "") {
         error.style.display = "block";
         error.innerHTML =  
          "Please enter total pages.";
         return false;
       }else {
         error.style.display = "none";
         error.innerHTML =  
          "";
       }
       if (price == "") {
         error.style.display = "block";
         error.innerHTML =  
          "Please enter file price.";
         return false;
       }else {
         error.style.display = "none";
         error.innerHTML =  
          "";
       }
       if(evaluation_type == '14'){
      
       } else{
         if(evaluation_type == '10'){
           var evaluation_date = document.forms["uploadFormcontent"]["evaluation_date"].value;
           if (evaluation_date == "") {
             errorevl.style.display = "block";
             errorevl.innerHTML =  
             "Please enter Evaluation Setting.";
             return false;
           }
         } else{
           var evaluation_value = document.forms["uploadFormcontent"]["evaluation_value"].value;
           if (evaluation_value == "") {
             errorevl.style.display = "block";
             errorevl.innerHTML =  
             "Please enter Evaluation Setting.";
             return false;
           }
         }
       }
      
       if (w_type == "None") {
         
       } else{
       if (w_type == "Text") {
         var watermark_text = document.forms["uploadFormcontent"]["watermark_text"].value;
         if (watermark_text == "") {
           errorw.style.display = "block";
         errorw.innerHTML =  
          "Please enter watermark.";
         return false;
       }
       } else{
         var file = document.forms["uploadFormcontent"]["file"].value;
         if (file == "") {
           errorw.style.display = "block";
         errorw.innerHTML =  
          "Please select watermark file.";
         return false;
       }
       }
      }
      
       $('.submit-action.loader').show();
       $('body').addClass('submit-loader');
      }
      
    </script>
    <script>
      function advance(){
        $('.upload_content_form2').show();
        $('.upload_content_leftside').show();
        $('.upload-contents .forms_icons').show();
        $('.upload_content_form1').hide();
        $('.upload_content_form3').hide();
        $('.upload_content_form4').hide();
        $('.upload_content_rightside').addClass('advance_setting');
        $('.upload_content_rightside').removeClass('countries_advance_setting');
        $('.upload_content_rightside').removeClass('users_advance_setting');
        $(".top_default_icons .setting a").addClass("active");
        $(".top_default_icons .description_icon a").removeClass("active");
        $(".top_default_icons .world a").removeClass("active");
        $(".top_default_icons .user a").removeClass("active");
      }
      
      function advancehide(){
        $('.upload_content_form2').hide();
        $('.upload_content_form1').show();
        $('.default_back_arrow').show();
      }
      
      function descritpion_icon(){
        $('.upload_content_form1').show();
        $('.upload_content_leftside').show();
        $('.upload-contents .forms_icons').show();
        $('.upload_content_form2').hide();
        $('.upload_content_form3').hide();
        $('.upload_content_form4').hide();
        $(".top_default_icons .description_icon a").addClass("active");
        $(".top_default_icons .setting a").removeClass("active");
        $(".top_default_icons .world a").removeClass("active");
        $(".top_default_icons .user a").removeClass("active");
        $('.upload_content_rightside').removeClass('countries_advance_setting');
        $('.upload_content_rightside').removeClass('users_advance_setting');
        $('.upload_content_rightside').removeClass('advance_setting');
      }
      
      function countries(){
        $('.upload_content_form3').show();
        $('.upload_content_form1').hide();
        $('.upload_content_form2').hide();
        $('.upload_content_form4').hide();
        $('.upload_content_leftside').hide();
        $('.upload-contents .forms_icons').hide();
        $('.upload_content_rightside').addClass('countries_advance_setting');
        $('.upload_content_rightside').removeClass('users_advance_setting');
        $('.upload_content_rightside').removeClass('advance_setting');
        $(".top_default_icons .world a").addClass("active");
        $(".top_default_icons .user a").removeClass("active");
        $(".top_default_icons .description_icon a").removeClass("active");
        $(".top_default_icons .setting a").removeClass("active");
      }
      
      function users(){
        $('.upload_content_form4').show();
        $('.upload_content_form1').hide();
        $('.upload_content_form2').hide();
        $('.upload_content_form3').hide();
        $('.upload_content_leftside').hide();
        $('.upload-contents .forms_icons').hide();
        $('.upload_content_rightside').addClass('users_advance_setting');
        $('.upload_content_rightside').removeClass('advance_setting');
        $('.upload_content_rightside').removeClass('countries_advance_setting');
        $(".top_default_icons .user a").addClass("active");
        $(".top_default_icons .world a").removeClass("active");
        $(".top_default_icons .description_icon a").removeClass("active");
        $(".top_default_icons .setting a").removeClass("active");
      }
      
      $(document).on('keyup', '#volume, #price', function(){
      var volume = $('#volume').val();
      var price = $('#price').val();
      var commission = <?php echo json_encode($commision_percent);?>;
      var impression = <?php echo json_encode($impressions_cost);?>;
      var total;
      if(volume != '' && price != ''){
      total = volume * price;
      var totalComm = (total * commission) / 100;
      var totalImpression = (volume * impression) / 1000;
      $('#payment').val(totalComm);
      $('#cost').val(totalImpression);
      $('#make').val(total - (totalComm + totalImpression));	
      }
      });
    </script>
    <!--Start of Tawk.to Script-->
    <script type="text/javascript">
      var Tawk_API=Tawk_API||{}, Tawk_LoadStart=new Date();
      (function(){
        var s1=document.createElement("script"),s0=document.getElementsByTagName("script")[0];
        s1.async=true;
        s1.src='https://embed.tawk.to/61718dc0f7c0440a591f600d/1fihp3es8';
        s1.charset='UTF-8';
        s1.setAttribute('crossorigin','*');
        s0.parentNode.insertBefore(s1,s0);
      })();
      
      var customize_tawk = "";
      function customize_tawk_widget(){
          jQuery("iframe[title='chat widget']").eq(0).addClass("custom-chat-widget");
          //jQuery("iframe[title='chat widget']").eq(0).css({ 'width': '45px', 'height': '45px','max-width': '45px', 'max-height': '45px','min-width': '45px', 'min-height': '45px'});
          clearInterval(customize_tawk);
      }
      
      Tawk_API = Tawk_API || {};
      Tawk_API.onLoad = function(){
        /*Only for mobile version
        if(/android|webos|iphone|ipad|ipod|blackberry|iemobile|opera mini/i.test(navigator.userAgent) ) {
            var customize_tawk = setInterval(customize_tawk_widget, 100);
        }*/
        var customize_tawk = setInterval(customize_tawk_widget, 100);
      };
      
      Tawk_API = Tawk_API || {};
      Tawk_API.onChatMinimized = function(){
        var customize_tawk = setInterval(customize_tawk_widget, 100);
      };
    </script>
    <!--End of Tawk.to Script-->
    <script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.10.3/jquery-ui.min.js"></script>
    <script type="text/javascript">
      (function($){
      
        $.fn.multiselect_sortable = function(options){
      
            var defaults = {
                selectable:{
                    title:''
                },
                selection :{
                    title:''
                }
            };
      
            var me = this;
      
            var select_name = me.attr('name');
            var classes     = $(me).attr('class');
      
            var select = document.createElement('select');
            select.setAttribute('multiple', '');
            select.setAttribute('name', select_name+'[]');
            select.setAttribute('class', classes);
            select.setAttribute('style', "display:none");
      
            var settings = $.extend(true, defaults, options);
            var parent   = this.parent();
      
            $(me).attr('class', '');
            this.addClass('multiselect_sortable_hide');
            $(me).prop('disabled', true);
      
            var selectable = '';
            var selection  = '';
            $.each($(' option', me), function(i, e){
      
                var name              = $(e).html();
                var value             = $(e).attr('value');
                var selected          = $(e).attr('selected');
                var disabled          = $(e).attr('disabled');
                var data              = $(e).data();
                var element_data_list = '';
                var create_id         = 'id'+Math.floor(Math.random()*999);
      
                $(e).attr('data-unit_id', create_id)
      
                $.each(data, function(i, e){
                    element_data_list += 'data-'+i+'="'+e+'"';
                })
      
                if(selected!=undefined){
                    selection += '<li class="select_li '+(disabled?'disabled':'')+'" data-uniq_id="'+create_id+'" data-name="'+name+'" data-value="'+value+'" '+element_data_list+'>'+name+'</li>';
                }
                else{
                    selectable += '<li class="select_li '+(disabled?'disabled':'')+'" data-uniq_id="'+create_id+'" data-name="'+name+'" data-value="'+value+'" '+element_data_list+'>'+name+'</li>';
                }
            });
      
            var content = `
                <div class="multiselect_sortable_content">
                    <div class="selectable">
                        <ul class="selectable_content">
                            ${selectable}
                        </ul>
                    </div>
                </div>
            `;
      
            $(parent).append(content)
      
            $(document).on('click', '.selectable_content .select_li', function(){
              $('.select_li').attr('data-type', '');
              $('.select_li').removeClass('liSelected');
              $(this).addClass('liSelected');
              $(this).attr('data-type', 'insert');
            });
      
            $(document).on('click', '.selection_content .select_li', function(){
              $('.select_li').attr('data-type', '');
              $('.select_li').removeClass('liSelected');
              $(this).addClass('liSelected');
              $(this).attr('data-type', 'remove');
            });
      
            $('.arrow_right').click(function(e){ 
              if($('*[data-type="insert"]').length > 0){ 
                  const html = $('*[data-type="insert"]')[0].outerHTML;
                  $('.selection_content').append(html);
                  $('.selection_content li').removeClass('liSelected');
                  $('.selectable_content li[data-type="insert"]').remove();
                  sortable_selectbox();
                  var mylist = $('.selection_content');
                  var listitems = mylist.children('li').get();
                  listitems.sort(function(a, b) {
                     return $(a).text().toUpperCase().localeCompare($(b).text().toUpperCase());
                  })
                  $.each(listitems, function(idx, itm) { mylist.append(itm); });
                  $('*[data-type="insert"]').attr('data-type', '');
              }
            }); 
      
            $('.arrow_left').click(function(e){ 
              if($('*[data-type="remove"]').length > 0){ 
                  const html = $('*[data-type="remove"]')[0].outerHTML;
                  $('.selectable_content').append(html);
                  $('.selectable_content li').removeClass('liSelected');
                  $('.selection_content li[data-type="remove"]').remove();
                  sortable_selectbox();
                  var mylist = $('.selectable_content');
                  var listitems = mylist.children('li').get();
                  listitems.sort(function(a, b) {
                     return $(a).text().toUpperCase().localeCompare($(b).text().toUpperCase());
                  })
                  $.each(listitems, function(idx, itm) { mylist.append(itm); });
                  $('*[data-type="remove"]').attr('data-type', '');
              }
            }); 
      
            $("#search").keyup(function() {
              var name = $('#search').val();
              var ids = [];
              $('input[name="viewer_access_list[]"]').each(function(){
                ids.push(this.value);
              });
              var url = "include/UserDataAction.php";            
              $.ajax({
                  type: "POST",
                  url: url,
                  data: {
                    search: name,
                    ids:ids,
                    action:'searchsettings'
                  },
                  success: function(html) {
                    $("#view_user_list").replaceWith(html);
                  }
              });
            });
      
            $("#group-search").keyup(function() {
              var name = $('#group-search').val();
              var ids = [];
              $('input[name="group_access_list[]"]').each(function(){
                ids.push(this.value);
              });
              var url = "include/UserDataAction.php";            
              $.ajax({
                  type: "POST",
                  url: url,
                  data: {
                    search: name,
                    ids:ids,
                    action:'searchgroup'
                  },
                  success: function(html) {
                    $("#group_user_list").replaceWith(html);
                  }
              });
            });
      
            $(document).on('click', '.user_item_select_right_arrow', function(){
              $('input[name="viewer_list[]"]:checked').each(function(){
                var email = $(this).parent().children('span').html();
                var html = "<li data-id='"+this.value+"'><input type='checkbox' name='activated_viewer_list[]' value='"+this.value+"'><span>"+email+"</span></li>";
                $(this).parent().remove();
                $('#view_activated_user_list').append(html);
              });
              loadAccessList();
           });
      
          $(document).on('click', '.user_item_select_left_arrow', function(){
              $('input[name="activated_viewer_list[]"]:checked').each(function(){
                var email = $(this).parent().children('span').html();
                var html = "<li data-id='"+this.value+"'><input type='checkbox' name='viewer_list[]' value='"+this.value+"'><span>"+email+"</span></li>";
                $(this).parent().remove();
                $('#view_user_list').append(html);
              });
              loadAccessList();
           });
      
          $(document).on('click', '.group_item_select_right_arrow', function(){
              $('input[name="group_viewer_list[]"]:checked').each(function(){
                var email = $(this).parent().children('span').html();
                var html = "<li data-id='"+this.value+"'><input type='checkbox' name='activated_group_list[]' value='"+this.value+"'><span>"+email+"</span></li>";
                $(this).parent().remove();
                $('#view_activated_group_list').append(html);
              });
              loadAccessList();
           });
      
          $(document).on('click', '.group_item_select_left_arrow', function(){
              $('input[name="activated_group_list[]"]:checked').each(function(){
                var email = $(this).parent().children('span').html();
                var html = "<li data-id='"+this.value+"'><input type='checkbox' name='group_viewer_list[]' value='"+this.value+"'><span>"+email+"</span></li>";
                $(this).parent().remove();
                $('#group_user_list').append(html);
              });
              loadAccessList();
           });
      
          function loadAccessList(){
            $('input[name="viewer_access_list[]"]').remove();
            $('input[name="activated_viewer_list[]"]').each(function(){
              var html = "<input type='hidden' name='viewer_access_list[]' value='"+this.value+"'>";
              $('.activated_viewer_list').append(html);
            });
      
            $('input[name="group_access_list[]"]').remove();
            $('input[name="activated_group_list[]"]').each(function(){
              var html = "<input type='hidden' name='group_access_list[]' value='"+this.value+"'>";
              $('.activated_group_list').append(html);
            });
          }
      
          $(document).on('change', '#select_user_type', function(){
            if($(this).val() == 'member'){
              $('.member_list_setting').show();
              $('.group_list_setting').hide();
            } else{
              $('.member_list_setting').hide();
              $('.group_list_setting').show();
            }
          });
      
      
            $(".sortable").sortable({
                connectWith:"ul",
                axis       :'y',
                start      :function(e){
                    sortable_selectbox();
                },
                change     :function(e){
                    sortable_selectbox();
                },
                update     :function(e){
                    sortable_selectbox();
                },
            });
      
            sortable_selectbox();
      
            function sortable_selectbox(){
                $('.multiselect_sortable_content select option').remove();
                $('.selection_content .select_li').each(function(i, e){
                    var value = $(e).data('value');
                    if(value!==undefined){
                        var opt      = document.createElement("option");
                        opt.text     = value;
                        opt.value    = value;
                        opt.selected = true;
                        select.appendChild(opt);
                    }
                })
                $('.multiselect_sortable_content').append(select)
            }
        }
      
        }(jQuery));
    </script>
  </body>
</html>