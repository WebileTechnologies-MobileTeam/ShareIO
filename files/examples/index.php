  <base href="../"/>
  <script src="./libs/jquery/jquery.js"></script>
  <link href="./libs/bootstrap/bootstrap.min.css" rel="stylesheet">
  <link rel='stylesheet' type="text/css" href="style/style.css"/>
  <link href='http://fonts.googleapis.com/css?family=Open+Sans:400,700' rel='stylesheet' type='text/css'>
  <link href='http://fonts.googleapis.com/css?family=PT+Sans:400,700' rel='stylesheet' type='text/css'>


  <script>
    window.dzsvg_settings = {
      merge_share_and_embed_into_one: "on"
    }
    
  </script>

  <!-- scripts needed for audioplayer -->

  <link rel='stylesheet' type="text/css" href="audioplayer/audioplayer.css"/>
  <script src="audioplayer/audioplayer.js" type="text/javascript"></script>

  <!-- scripts needed for audioplayer END -->
<?php
require_once('../../getid3/getid3.php');
?>

    
<div class="content-wrapper video_content_wrapper">


  <style>
    body .zoomsounds-nav.skin-default .menu-item {
      background-color: #fff;
      color: #444;
    }

    body .zoomsounds-nav.skin-default .menu-item:nth-child(odd) {
      background-color: #efefef;
    }

    body .zoomsounds-nav.skin-default .menu-item.active, body .zoomsounds-nav.skin-default .menu-item:hover {
      background-color: #accfe0;
    }
  </style>

    <div class="video_photo_img">
        <?php
        
        file_put_contents('test.mp3',file_get_contents($_POST['presignedUrl']));
        $path = "/www/wwwroot/contentshare.me/files/examples/test.mp3"; //example. local file path to mp3
        $getID3 = new getID3;
        $tags = $getID3->analyze($path);
        $artist = 'contentshare';
        if(isset($tags['tags']['id3v2']['artist']['0'])){
            $artist = $tags['tags']['id3v2']['artist']['0'];
        }
        unlink('/www/wwwroot/contentshare.me/files/examples/test.mp3');
        $thumb = '';
        if($_POST['thumbnailImage'] != ''){ 
        $thumb = str_replace('contentshare.me', 'shareio.com', $_POST['thumbnailImage']);
        ?>
            <img src="<?php echo str_replace('contentshare.me', 'shareio.com', $_POST['thumbnailImage']);?>" />
        <?php } else{ 
        $thumb = 'https://previews.customer.envatousercontent.com/files/274338180/img/thumb_demo2.jpg';
        ?>
            <!--<img src="img/default_img_gradient.jpg" />-->
            <svg xmlns="http://www.w3.org/2000/svg" enable-background="new 0 0 24 24" height="24px" viewBox="0 0 24 24" width="24px" fill="#000000"><g><rect fill="none" height="24" width="24"/></g><g><path d="M12,3c-4.97,0-9,4.03-9,9v7c0,1.1,0.9,2,2,2h4v-8H5v-1c0-3.87,3.13-7,7-7s7,3.13,7,7v1h-4v8h4c1.1,0,2-0.9,2-2v-7 C21,7.03,16.97,3,12,3z M7,15v4H5v-4H7z M19,19h-2v-4h2V19z"/></g></svg>  
        <?php }  
        ?>
        
    </div>
  <div class="con-maindemo" id="a-demo">
    <div class="ap-wrapper center-ap" style="width:100%;">
      <div class="the-bg" style=" ;"></div>

      <div id="ag1" class="audiogallery skin-wave" style="opacity:0;">
        <div class="items">
          <div id="ap1000" class="audioplayer-tobe  skin-wave          " style=" " data-thumb=<?php echo $thumb;?>  data-thumb_link="" data-videoTitle="Audio Video" data-type="audio"
               data-source="<?php echo $_POST['url'];?>" data-wrapper-image="" data-sample_time_total="<?php echo $_POST['time_seconds'];?>">
            <!--  data-sourceogg="sounds/adg3.ogg" http://www.stephaniequinn.com/Music/Commercial%20DEMO%20-%2011.mp3 -->
            <div class="meta-artist">
              <span class="the-artist"><?php echo $artist;?></span><span
              class="the-name"><?php echo $_POST['file_name'];//mb_strimwidth($_POST['file_name'], 0, 15, "...");?></span>
            </div>


            <div class="extra-html-in-controls-right"><span>ceva</span></div>
            
            <div class="extra-html-in-controls-right">

            </div>

            <?php if($_POST['file_download'] == '1'){ ?>
            <div class="feed-dzsap extra-html-extra"><a href="<?php echo $_POST['url'];?>" class=" btn-zoomsounds btn-download " download><span
              class="the-icon"><i class="fa fa-download"></i></span><span class="the-label ">Download</span></a></div>
            <?php }?>
          </div>
        </div>
      </div>

    </div>

  </div>



</div>



<script>
  jQuery(document).ready(function ($) {
    var playerid = 'ag1';

    var bar_len = 3;
    var bar_space = 1;
    var reflection_size = 0.5;

    bar_len = 1;
    bar_space = 1;
    reflection_size = 0.25;


    // bar_len = 300;

    function handle_start_play(arg) {
//            console.info('starting play', arg);
    }


    var settings_ap = {
      disable_volume: 'off'
      ,
      disable_scrub: 'default'
      ,
      design_skin: 'skin-wave'
      ,
      action_audio_play2: handle_start_play
      ,
      skinwave_dynamicwaves: 'off'
      //,skinwave_enableSpectrum:'on'
      ,
      settings_backup_type: 'full'
      ,
      skinwave_enableReflect: 'on'
      ,
      skinwave_comments_enable: 'off'
      ,
      skinwave_timer_static: 'off'
//            ,skinwave_comments_links_to:'http://google.com'
      ,
      disable_player_navigation: 'off'
      ,
      preload_method: 'metadata'
      ,
      default_volume: 'last' // -- number / set the default volume 0-1 or "last" for the last known volume
      ,
      gallery_gapless_play: 'on'
      ,
      skinwave_comments_retrievefromajax: 'on'
      ,
      skinwave_wave_mode_canvas_normalize: 'off'
      ,
      settings_php_handler: 'inc/php/publisher.php',
      pcm_data_try_to_generate: 'off',
      pcm_data_try_to_generate_wait_for_real_pcm: 'off',
      skinwave_wave_mode: "canvas"
//            ,skinwave_mode : 'small'
      ,
      skinwave_wave_mode_canvas_waves_number: bar_len // -- the number of waveform bars ( set this to a high number like 200 for 200 waves, or to a small number like 3 for 3px waves )
      ,
      skinwave_wave_mode_canvas_reflection_size: reflection_size // -- the percent of the reflection
      ,
      skinwave_wave_mode_canvas_waves_padding: bar_space // -- the spacing between waveforms
//            , design_color_bg: 'aaaaaa,000000' // --waveform background color..  000000,ffffff gradient is allowed
      ,
      design_color_bg: '444444' // --waveform background color..  000000,ffffff gradient is allowed
      ,
      design_color_highlight: 'aa4444,ff2222' // -- waveform progress color
      ,
      watermark_volume: '0.1' // -- waveform progress color

      ,
      soundcloud_apikey: "be48604d903aebd628b5bac968ffd14d"//insert api key here https://soundcloud.com/you/apps/
      //<div class="star-rating-con"><div class="star-rating-bg"></div><div class="star-rating-set-clip" style="width: 96.6px;"><div class="star-rating-prog"></div></div><div class="star-rating-prog-clip"><div class="star-rating-prog"></div></div></div>
      //<span class=" btn-zoomsounds btn-like"><span class="the-icon">{{heart_svg}}</span><span class="the-label hide-on-active">Like</span><span class="the-label show-on-active">Liked</span></span>                 <span class=" btn-zoomsounds btn-embed dzstooltip-con "> <span class="dzstooltip transition-slidein arrow-bottom align-left skin-black " style="width: 350px; "><span style="max-height: 150px; overflow:hidden; display: block; white-space: normal; font-weight: normal">{{embed_code}}</span> <span class="copy-embed-code-btn">Copy Embed</span></span> <span class="the-icon"><i class="fa fa-share"></i></span><span class="the-label ">Embed</span>  </span>                 <span class=" btn-zoomsounds btn-itunes "><span class="the-icon"><i class="fa fa-apple"></i></span><span class="the-label ">iTunes</span></span> </div>            <div class="counter-hits"><i class="fa fa-play"></i><span class="the-number">{{get_plays}}</span></div><div class="counter-likes"><i class="fa fa-heart"></i><span class="the-number">{{get_likes}}</span>
      ,
      settings_extrahtml: '<div class="float-left "> </div>'
//            ,settings_extrahtml:'<div class="btn-like skin-simple"><i class="fa fa-heart-o"></i>Like</div><a class="skin-simple" href="#"><i class="fa fa-download"></i>Download</a><div class="counter-hits"><span class="the-number">{{get_plays}}</span> plays</div><div class="counter-likes"><span class="the-number">{{get_likes}}</span> likes</div><div class="counter-rates"><span class="the-number">{{get_rates}}</span> rates</div>'
//            ,settings_useflashplayer : 'on'
//            ,settings_backup_type : 'full'
      ,
      embed_code: "test"
      ,
      enable_embed_button: "off"
      ,
      skinwave_comments_mode: 'outer-field' // -- inner-field or outer-field
      ,
      skinwave_comments_mode_outer_selector: $('.zoomsounds-comment-wrapper') // -- the outer selector if it has one

      ,
      settings_extrahtml_after_artist: '<span class="button-grad zoomsounds-btn-go-beginning">                                        <i class="fa fa-backward"></i>                                        <span class="i-label">Beggining</span>                                    </span>                                    <span class="button-grad zoomsounds-btn-step-backword">                                        <i class="fa fa-step-backward"></i>                                        <span class="i-label">Back 5 Sec.</span>                                    </span>                                    <span class="button-grad zoomsounds-btn-slow-playback">                                        <i class="fa fa-eraser"></i>                                        <span class="i-label">Slow</span>                                    </span>                                    <span class="button-grad zoomsounds-btn-reset">                                        <i class="fa fa-window-close"></i>                                        <span class="i-label">Reset</span>                                    </span>   '
      ,
      settings_extrahtml_in_float_right: '<div class="player-but dzstooltip-con" style=";"><span class="the-icon-bg"></span><span class="dzstooltip arrow-from-start transition-slidein arrow-bottom skin-black align-right" style="width: auto; white-space: nowrap;">Add to Cart</span><i class="fa fa-shopping-cart svg-icon"></i></div><div class="player-but dzstooltip-con" style=";"><span class="dzstooltip arrow-from-start transition-slidein arrow-bottom skin-black align-right" style="width: auto; white-space: nowrap;">Download</span><span class="the-icon-bg"></span><i class="svg-icon fa fa-download"></i></div>  <a onclick=\'window.dzs_open_social_link("http://www.facebook.com/sharer.php?u={{replaceurl}}&caption=Santigold&description=Disparate+Youth&picture=http%3A%2F%2Flocalhost%3A8888%2Fwordpress%2Fwp-content%2Fuploads%2F2017%2F05%2Faudio_image_46.jpg",this); return false;\' class="player-but sharer-dzsap-but"><div class="the-icon-bg"></div>{{svg_share_icon}}</a>  <a class="player-but sharer-dzsap-but dzsap-multisharer-but"><div class="the-icon-bg"></div>{{svg_share_icon}}</a>'
    };

    // console.info("settings_ap - ",settings_ap);
    dzsag_init('#' + playerid, {
      'transition': 'fade'
      , 'cueFirstMedia': 'on'
      , 'autoplay': 'off'
      , 'autoplayNext': 'off'
      , settings_enable_linking: 'onf'
      , skinwave_mode: "small"
      , design_menu_position: 'bottom'
      , 'settings_ap': settings_ap
      , embedded: 'off'
      , mode_normal_video_mode: 'one'
      , enable_easing: 'on'
      , force_autoplay_when_coming_from_share_link: 'onf'
      , design_menu_height: 200
//            ,design_menu_height: "auto"
//            ,settings_mode: "mode-showall"
      , design_menu_state: 'open' // -- options are "open" or "closed", this sets the initial state of the menu, even if the initial state is "closed", it can still be opened by a button if you set design_menu_show_player_state_button to "on"
      , design_menu_show_player_state_button: 'on' // -- show a button that allows to hide or show the menu

    });

    try {

      window.addEventListener('onload', function () {
        console.info('window loaded');
      })
    } catch (err) {
      console.info(err);
    }


    window.dzsap_social_feed_for_social_networks = '<h6 class="social-heading">Social Networks</h6> <a class="social-icon" href="#" onclick="window.dzs_open_social_link(&quot;https://www.facebook.com/sharer.php?u={{replacewithcurrurl}}&amp;title=test&quot;); return false;"><i class="fa fa-facebook-square"></i><span class="the-tooltip">SHARE ON FACEBOOK</span></a> <a class="social-icon" href="#" onclick="window.dzs_open_social_link(&quot;https://twitter.com/share?url={{replacewithcurrurl}}&amp;text=Check this out!&amp;via=ZoomPortal&amp;related=yarrcat&quot;); return false;"><i class="fa fa-twitter"></i><span class="the-tooltip">SHARE ON TWITTER</span></a> <a class="social-icon" href="#" onclick="window.dzs_open_social_link(&quot;https://plus.google.com/share?url={{replacewithcurrurl}}&quot;); return false; "><i class="fa fa-google-plus-square"></i><span class="the-tooltip">SHARE ON GOOGLE PLUS</span></a> <a class="social-icon" href="#" onclick="window.dzs_open_social_link(&quot;https://www.linkedin.com/shareArticle?mini=true&amp;url={{replacewithcurrurl}}&amp;title=Check%20this%20out%20&amp;summary=&amp;source=http://localhost:8888/soundportal/source/index.php?page=page&amp;page_id=20&quot;); return false; "><i class="fa fa-linkedin"></i><span class="the-tooltip">SHARE ON LINKEDIN</span></a> <a class="social-icon" href="#" onclick="window.dzs_open_social_link(&quot;https://pinterest.com/pin/create/button/?url={{replacewithcurrurl}}&amp;text=Check this out!&amp;via=ZoomPortal&amp;related=yarrcat&quot;); return false;"><i class="fa fa-pinterest"></i><span class="the-tooltip">SHARE ON PINTEREST</span></a>';


    window.dzsap_social_feed_for_share_link = '<h6 class="social-heading">Share Link</h6> <div class="field-for-view field-for-view-link-code">{{replacewithcurrurl}}</div>';


    window.dzsap_social_feed_for_embed_link = ' <h6 class="social-heading">Embed Code</h6> <div class="field-for-view field-for-view-embed-code">{{replacewithembedcode}}</div>';


//        setTimeout(function(){
//            document.getElementById('ap1').api_destroy();
//        }, 3000);
  });
</script>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">

