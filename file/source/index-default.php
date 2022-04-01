<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <title>Zoom Video Player - Example</title>
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=2">
    <link href="./source/bootstrap/bootstrap.css" rel="stylesheet">
    <link rel='stylesheet' type="text/css" href="source/style/style.css"/>
    <!--<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js" type="text/javascript"></script>-->

    <script src="source/js/jquery.js"></script>
    <!--[if lt IE 9]><script src="../assets/js/ie8-responsive-file-warning.js"></script><![endif]-->

    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->

    <!--<link href='http://fonts.googleapis.com/css?family=Open+Sans:300,400,700' rel='stylesheet' type='text/css'>-->
    <script>
        zoombox_settings = {
        }
    </script>
</head>
<body>
<div class="mwrap-wrapper">





<section class="mcon-maindemo" style="position: relative;">
            <!--data-hd_source="video/advideo.mp4" data-cover="img/bbbcover.jpg" data-hd_sourceogg="video/test.ogv" -->
            <style>
                /*.zoomvideoplayer.skin-new.inited .controls-bg{ background-color:rgba(50, 50, 50, 0.9);}  data-source="audio/adg3.mp3" data-sourceogg="audio/adg3.ogg"  data-ad_source="video/advideo.mp4" data-ad_sourceogg="video/advideo.ogv" data-ad_type="video" data-ad_time="3" data-ad_skip_delay="5"

                 data-ad_array='[{"source":"video/advideo.mp4","sourceogg":"video/advideo.ogv","ad_type":"video","ad_time":"3","ad_skip_delay":"5","ad_link":"http://google.com"},{"source":"video/advideo.mp4","sourceogg":"video/advideo.ogv","ad_type":"video","ad_time":"10","ad_skip_delay":"5","ad_link":"http://google.com"}]'  data-hd_source="video/test.m4v"

https://www.youtube.com/embed/JfvxAgDyDWQ
                */
            </style>



                <style>
                    .zoomvideoplayer .custom-color-hover-fill:hover path,.zoomvideoplayer .custom-color-hover-fill:hover polygon,.zoomvideoplayer .custom-color-hover-fill:hover rect{


                        fill: red!important;

                    }
                    .zoomvideoplayer .custom-color-bg{


                        background-color: red!important;

                    }
                </style>



 <!--&#45;&#45; this can be included in the player for fullsize cover-->
                <!--<div class="cover-image" style="background-image: url(img/bbbcover.jpg); ">-->
                    <!--<svg class="cover-play-btn" version="1.1" baseProfile="tiny" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"-->
	 <!--x="0px" y="0px" width="120px" height="120px" viewBox="0 0 120 120" overflow="auto" xml:space="preserve">-->
<!--<path fill-rule="evenodd" fill="#ffffff" d="M79.295,56.914c2.45,1.705,2.45,4.468,0,6.172l-24.58,17.103-->
	<!--c-2.45,1.704-4.436,0.667-4.436-2.317V42.129c0-2.984,1.986-4.022,4.436-2.318L79.295,56.914z M0.199,54.604-->
	<!--c-0.265,2.971-0.265,7.821,0,10.792c2.57,28.854,25.551,51.835,54.405,54.405c2.971,0.265,7.821,0.265,10.792,0-->
	<!--c28.854-2.57,51.835-25.551,54.405-54.405c0.265-2.971,0.265-7.821,0-10.792C117.231,25.75,94.25,2.769,65.396,0.198-->
	<!--c-2.971-0.265-7.821-0.265-10.792,0C25.75,2.769,2.769,25.75,0.199,54.604z M8.816,65.394c-0.309-2.967-0.309-7.82,0-10.787-->
	<!--c2.512-24.115,21.675-43.279,45.79-45.791c2.967-0.309,7.821-0.309,10.788,0c24.115,2.512,43.278,21.675,45.79,45.79-->
	<!--c0.309,2.967,0.309,7.821,0,10.788c-2.512,24.115-21.675,43.279-45.79,45.791c-2.967,0.309-7.821,0.309-10.788,0-->
	<!--C30.491,108.672,11.328,89.508,8.816,65.394z"/>-->
<!--</svg>-->
                <!--</div> #t=00:00:05,00:00:08 data-thumbnaildir="source/video/imagesfortest/"-->




                <input type="hidden" name="file_download" id="file_download" value="<?php echo $_POST['file_download'];?>">
                <input type="hidden" name="file_id" id="file_id" value="<?php echo $_POST['file_id'];?>">
                <input type="hidden" name="useraccess" id="useraccess" value="<?php echo $_POST['useraccess'];?>">
                <div class="zoomvideoplayer skin-default auto-init " data-source="<?php echo $_POST['url'];?>"  data-options='{ "cue": "on", autoplay: "off", settings_otherSocialIcons:"", settings_suggestedQuality: "large", settings_enableAutoHide:"off",
                design_attachTotalTimeAfterScrub: "off",
                design_hideScrubBoxProg: "on"
                , responsive_ratio: "none"
                ,design_specialContainer: "off"}'
                     

                     data-ad_array='[{"source":"<?php echo $_POST['url'];?>"}]'  data-hd_source="<?php echo $_POST['url'];?>"

                     data-arg_downloadlink="<?php echo $_POST['videourl'];?>"  data-ad_link="https://contentshare.me"  >
<!-- data-arg_logoimg="source/img/logo.png" data-cover="source/img/bbbcover.jpg" -->
                    <div class="feed-dzszvp feed-embed"><iframe id="dzszvp-frame-1" src="http://yoursite.com/zoomvideoplayer/bridge.php?source={{source}}&cover={{cover}}" style="width: 100%; height: 300px; border:0;" onload='window.addEventListener("message", function(args){ if(args.data.action=="dzszvp_adjust_height"){ document.getElementById("dzszvp-frame-1").style.height = args.data.val+"px"; } } , false);'></iframe></div>
                    <div class="dzstag-tobe" data-starttime="10" data-endtime="<?php echo $_POST['t_end'];?>" data-left="10%" data-top="50%" data-width="80" data-height="50">this is another tag
                    </div>
                    <?php
                    $str_time = $_POST['t_end'];

                    $str_time = preg_replace("/^([\d]{1,2})\:([\d]{2})$/", "00:$1:$2", $str_time);
                    
                    sscanf($str_time, "%d:%d:%d", $hours, $minutes, $seconds);
                    
                    $time_seconds = $hours * 3600 + $minutes * 60 + $seconds;
                    ?>
                    <div class="dzstag-tobe" data-starttime="<?php echo $time_seconds;?>" data-endtime="2000" data-left="20%" data-top="50%" data-width="70" data-height="70" data-link="http://contentshare.me">this a tag you set
                    </div>

                    <div class="info-window">

                        <canvas width="100%" height="100%" class="canvas-bg"></canvas>
                        <div class="second-bg"></div>

                        <span class="info-window--back-btn">back</span>
                        <div class="center-it">


                            <div class="dzszvp-hero-text">Get Instant Access to This Awesome Product</div>
                            <div class="dzszvp-hero-button-con">
                                <span class="dzszvp-hero-button">Get Instant Access Now</span>
                            </div>

                        </div>
                    </div>
                    <a href="http://3.135.223.154/upload/130321102628VID-20210313-WA0095.mp4" id="download" download>Download</a>

                </div>
</section>




</div>
<link rel="stylesheet" href="fontawesome/font-awesome.min.css">
<link rel='stylesheet' type="text/css" href="source/zoomplayer/zoomplayer.css"/>
<link rel='stylesheet' type="text/css" href="source/colorpicker/farbtastic.css"/>
<link rel='stylesheet' type="text/css" href="source/db/skins.css"/>
<script src="source/colorpicker/farbtastic.js"></script>
<script src="source/zoomplayer/zoomplayer.js"></script>
<script src="source/zoombox/zoombox.js"></script>
<link rel='stylesheet' type="text/css" href="source/zoombox/zoombox.css"/>
<script src="source/db/skins.js"></script>
<script src="source/advancedscroller/plugin.js"></script>
<script src="https://apis.google.com/js/platform.js" async defer></script>
<script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0],p=/^http:/.test(d.location)?'http':'https';if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src=p+'://platform.twitter.com/widgets.js';fjs.parentNode.insertBefore(js,fjs);}}(document, 'script', 'twitter-wjs');</script>

<script src="source/js/main.js"></script>

<script>
    window.init_zoombox_settings = {
        settings_zoom_doNotGoBeyond1X:'off'
        ,design_skin:'skin-gamma'
        ,settings_enableSwipe:'on'
        ,settings_enableSwipeOnDesktop:'on'
        ,settings_galleryMenu:'none'
        ,settings_useImageTag:'on'
        ,videoplayer_settings: {design_skin: 'skin-avanti'}
    };
    jQuery(document).ready(function($){
        //dzstaa_init('.dzs-tabs.auto-init', {init_each: true});
//    dzsas_init('.advancedscroller.auto-init', {init_each: true});


        $(window).bind('resize',handle_resize);
        handle_resize();

        function handle_resize(){
            $('.center-it-js').each(function(){
                var _t = $(this);
//            console.info(_t);
                var ww = $(window).width();
                var tw = _t.width();

                _t.css("margin-left", (ww-tw)/2)
            })

        }





        window.fbAsyncInit = function() {
            // init the FB JS SDK
            FB.init({
                appId: '240323199320847R',                        // App ID from the app dashboard
                channelUrl : window.location.href, // Channel file for x-domain comms
                status     : true,                                 // Check Facebook Login status
                xfbml      : true                                  // Look for social plugins on the page
            });

            // Additional initialization code such as adding Event Listeners goes here
        };

        // Load the SDK asynchronously
        (function(d, s, id){
            var js, fjs = d.getElementsByTagName(s)[0];
            if (d.getElementById(id)) {return;}
            js = d.createElement(s); js.id = id;
            js.src = "//connect.facebook.net/en_US/all.js";
            fjs.parentNode.insertBefore(js, fjs);
        }(document, 'script', 'facebook-jssdk'));
    });

    $('#download-btn').on("click", function(){
          var file_id = $('#file_id').val();

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
</script>
</body>
</html>