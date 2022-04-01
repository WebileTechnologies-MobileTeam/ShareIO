<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <title>Zoom Video Player - Example</title>
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=2">
    <link href="./bootstrap/bootstrap.css" rel="stylesheet">
    <link rel='stylesheet' type="text/css" href="style/style.css"/>
    <!--<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js" type="text/javascript"></script>-->

    <script src="js/jquery.js"></script>
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



<section class="mcon-mainmenu" style="position: absolute; z-index: 5;">

    <!--
    -->
    <div class="container">
        <div class="row">
            <div class="logo-con col-md-3">
                <img src="img/dzsplugins.png" alt="wordpress video gallery" style="margin:0 auto"/>
            </div>
            <div class="main-menu-con">
                <ul class="main-menu">
                    <li class=" "><a href="index.html">Home</a></li>
                    <li class=" "><a href="index-skins.html">Skins</a></li>
                    <li class=" active"><a href="index-ads.html">Ad Capabilities</a></li>
                    <li class=" "><a href="builder.php">Builder</a></li>
                </ul>
            </div>
        </div>
    </div>
</section>
<!--===end mainmenu
-->




<section class="mcon-maindemo" style="position: relative; padding-top:100px; padding-bottom:200px;">
    <div class="container">
        <div class="row">

            <h2 style="text-align: center;">Mid Roll Video Ad.</h2>
        </div>
        <div class="row">
            <!--data-hd_source="video/advideo.mp4"-->
            <style>
                /*.zoomvideoplayer.skin-new.inited .controls-bg{ background-color:rgba(50, 50, 50, 0.9);}*/
            </style>
            <div class="col-md-12" style="float:none; margin:0 auto; position: relative;">
                <?php 
                include_once 'class-front.php';
                $dzszvp = new DZSzvp_frontend();
                
                //{ cue: "off", autoplay: "on", settings_otherSocialIcons:"", settings_suggestedQuality: "large", settings_enableAutoHide:"on"}
                echo $dzszvp->read_rss('mrss1.xml','{design_menu_enable_easing:"on"}');
               
                ?>
            </div>
        </div>
    </div>
</section>




<section class="mcon-features">

    <div class="pat-bg">
        <div class="pat-bg-inner">

        </div>
    </div>
    <div class="container">
        <div class="row">
            <div class="col-md-3">
                <div class="bigfeature"><i class="fa fa-thumbs-up"></i></div>
                <h4>Easy Install</h4>
                <p style="text-align: center">Install DZS ZoomPlayer in just a couple of minutes. <a href="http://digitalzoomstudio.net/docs/zoomtabsandaccordions/" target="_blank">Docs</a> are also there.</p>
            </div>
            <div class="col-md-3">
                <div class="bigfeature"><i class="fa fa-desktop"></i></div>
                <h4>Responsive</h4>
                <p style="text-align: center">From mobile to HD, DZS ZoomPlayer are ultra responsive. Also has retina graphics.</p>
            </div>
            <div class="col-md-3">
                <div class="bigfeature"><i class="fa fa-pencil"></i></div>
                <h4>Customizable</h4>
                <p style="text-align: center">Customize DZS ZoomPlayer with the many options included.</p>
            </div>
            <div class="col-md-3">
                <div class="bigfeature"><i class="fa fa-briefcase"></i></div>
                <h4>SEO Friendly</h4>
                <p style="text-align: center">Built with SEO in mind, DZS ZoomPlayer parses html content into working magic.</p>
            </div>
        </div>
    </div>
</section>



<section class="mcon-footer">
    <div class="container">
        <div class="row">
            <div class="col-md-6">
                &copy; copyright <a href="http://bit.ly/nM4R6u">ZoomIt</a> 2014

            </div>
            <div class="col-md-6" style="text-align: right">
                <iframe src="//www.facebook.com/plugins/like.php?href=https%3A%2F%2Fwww.facebook.com%2Fdigitalzoomstudio&amp;width=150&amp;height=21&amp;colorscheme=light&amp;layout=button_count&amp;action=like&amp;show_faces=true&amp;send=false&amp;appId=569360426428348" scrolling="no" frameborder="0" style="border:none; overflow:hidden; width:150px; height:21px;" allowTransparency="true"></iframe>
            </div>
        </div>
    </div>
</section>

</div>

<link rel="stylesheet" href="fontawesome/font-awesome.min.css">

<link rel='stylesheet' type="text/css" href="zoomplayer/zoomplayer.css"/>
<script src="zoomplayer/zoomplayer.js"></script>

<link rel='stylesheet' type="text/css" href="db/skins.css"/>
<script src="db/skins.js"></script>

<script src="js/main.js"></script>

<script src="https://www.youtube.com/iframe_api"></script>
<script>
</script>
</body>
</html>