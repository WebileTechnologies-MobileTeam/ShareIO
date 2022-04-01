<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0">
  <title>Audio Player Preview</title>
  <base href="../">
  <link href="./libs/bootstrap/bootstrap.min.css" rel="stylesheet">
  <link rel='stylesheet' type="text/css" href="./style/style.css"/>
  <script src="./libs/jquery/jquery.js" type="text/javascript"></script>
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">

</head>
<body>
<div class="content-wrapper">

  <section class="mcon-mainmenu" style="z-index: 5;">

    <!--
    -->
    <div class="container">
      <div class="row" style="margin-left:0; margin-right: 0;">
        <div class="logo-con ">

        </div>
        </div>
      </div>
  </section>

  <?php

  $trackUrl = 'http://devsite/zoomsounds/source/sounds/steph1.mp3';
//  $trackUrl = '';

  if(isset($_GET['track_url'])){
    $trackUrl = $_GET['track_url'];
  }

  if(isset($_GET) && $_GET && count($_GET)){
    echo '<pre>'.print_r($_GET, true).'</pre>';
  }
  if(isset($_POST) && $_POST && count($_POST)){
    echo '<pre>'.print_r($_POST, true).'</pre>';
  }
  ?>
  <style>
    .wavegenerator-con h6{
      margin-top: 10px;
    }
    .wavegenerator-con form.disabled-inputs input{
      opacity: 0.5;
    }
  </style>
  <div class="con-maindemo wavegenerator-con" id="a-demo">
    <div class="container">
      <div class="row">
        <div class="col-md-12">

          <form name="track-info" class="<?= $trackUrl ? 'disabled-inputs' : '' ?>" method="GET">

            <h4>Track info</h4>
            <h6>url</h6>
            <input name="track_url" value="<?= htmlspecialchars($trackUrl, ENT_QUOTES) ?>"/>
            <h6>id</h6>
            <input name="track_id" value="321"/>
            <h6>url id</h6>
            <input name="track_url_id" value="httpdevsitezoomsoundssourcesoundssteph1mp3"/>

            <br>
            <br>
            <button>Get wavedata</button>
          </form>

          <?php


          if($trackUrl){

            ?>
            <br>
            <br>
            <br>

            <form name="track-waveform-meta" method="POST">

              <h4>Track meta</h4>



              <input name="wavedata_track_url"  type="hidden"/>
              <input name="wavedata_track_id"   type="hidden"/>
              <input name="wavedata_track_url_id" type="hidden"/>
              <br>
              <br>
              <div class="dzsap-wave-generator auto-init" data-options='{"source":"<?= $trackUrl ?>", "selectorWaveData":"textarea[name=wavedata_pcm]"}'>
                <div class="dzsap-wave-generator--status">waiting init</div>
                <div class="dzsap-wave-generator--wave"></div>
              </div>
              <br>
              <h6>pcm data</h6>
              <textarea name="wavedata_pcm" style="display: block; width: 100%; height: 50px;"></textarea>
              <br>
              <button>Submit</button>
            </form>
          <?php

          }

          ?>

        </div>
      </div>
    </div>
  </div>




  <div class="con-footer">
    <div class="container">
      <div class="row">
        <div class="span6">
          &copy; copyright <a href="http://bit.ly/nM4R6u">ZoomIt</a> 2013

        </div>
        <div class="span6" style="text-align: right">

        </div>
      </div>
    </div>
  </div>

</div>
<script>
  jQuery(document).ready(function ($) {

    function updateFields(){
      $('*[name=wavedata_track_url]').val($('*[name=track_url]').val())
      $('*[name=wavedata_track_id]').val($('*[name=track_id]').val())
      $('*[name=wavedata_track_url_id]').val($('*[name=track_url_id]').val())
    }

    updateFields();
    $('*[name=track_url],*[name=track_id],*[name=track_url_id]').on('keyup',function(){
      updateFields();
    })
  });

</script>
<!--<link rel='stylesheet' type="text/css" href="./audioplayer/audioplayer.css"/>-->
<!--<script src="./audioplayer/audioplayer.js" type="text/javascript"></script>-->
<script src="./audioplayer/wavesurfer.js" type="text/javascript"></script>
<script src="./audioplayer/dzsap-wave-generator.js" type="text/javascript"></script>
</body>
</html>
