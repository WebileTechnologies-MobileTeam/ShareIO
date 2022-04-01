<?php

$source = '';
$cover = '';

if(isset($_GET['source']) && $_GET['source']){
    $source = $_GET['source'];
}
if(isset($_GET['cover']) && $_GET['cover']){
    $cover = $_GET['cover'];
}
?>

<!doctype html>
<html lang="en">
<head>
    <style>/* http://meyerweb.com/eric/tools/css/reset/
   v2.0 | 20110126
   License: none (public domain)
*/

        html, body, div, span, applet, object, iframe,
        h1, h2, h3, h4, h5, h6, p, blockquote, pre,
        a, abbr, acronym, address, big, cite, code,
        del, dfn, em, img, ins, kbd, q, s, samp,
        small, strike, strong, sub, sup, tt, var,
        b, u, i, center,
        dl, dt, dd, ol, ul, li,
        fieldset, form, label, legend,
        table, caption, tbody, tfoot, thead, tr, th, td,
        article, aside, canvas, details, embed,
        figure, figcaption, footer, header, hgroup,
        menu, nav, output, ruby, section, summary,
        time, mark, audio, video {
            margin: 0;
            padding: 0;
            border: 0;
            font-size: 100%;
            font: inherit;
            vertical-align: baseline;
        }
        /* HTML5 display-role reset for older browsers */
        article, aside, details, figcaption, figure,
        footer, header, hgroup, menu, nav, section {
            display: block;
        }
        body {
            line-height: 1;
        }
        ol, ul {
            list-style: none;
        }
        blockquote, q {
            quotes: none;
        }
        blockquote:before, blockquote:after,
        q:before, q:after {
            content: '';
            content: none;
        }
        table {
            border-collapse: collapse;
            border-spacing: 0;
        }</style>
    <meta charset="utf-8" />
    <title>Zoom Video Player - Embed</title>
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=2">

    <script src="js/jquery.js"></script>
    <link rel="stylesheet" href="fontawesome/font-awesome.min.css">
    <link rel='stylesheet' type="text/css" href="zoomplayer/zoomplayer.css"/>
    <script src="zoomplayer/zoomplayer.js"></script>
</head>
<body>
<div class="mwrap-wrapper">






            <div class="col-md-8" style="float:none; margin:0 auto; position: relative;">



                <style>
                    .zoomvideoplayer .custom-color-hover-fill:hover path,.zoomvideoplayer .custom-color-hover-fill:hover polygon,.zoomvideoplayer .custom-color-hover-fill:hover rect{


                        fill: red!important;

                    }
                    .zoomvideoplayer .custom-color-bg{


                        background-color: red!important;

                    }
                </style>
                <div class="zoomvideoplayer skin-default auto-init " data-source="<?php echo $source; ?>"  data-options='{ cue: "on", autoplay: "off", settings_otherSocialIcons:"", settings_suggestedQuality: "large", settings_enableAutoHide:"off",
                design_attachTotalTimeAfterScrub: "off",
                design_hideScrubBoxProg: "on"
                , responsive_ratio: "none"
                , embedded: "on"
                ,design_specialContainer: "off"}'  style="height: 300px; " data-arg_downloadlink="http://digitalzoomstudio.net" data-arg_logoimg="img/logo.png" data-thumbnaildir="video/imagesfortest/" data-cover="<?php echo $cover; ?>"   >

                    <div class="feed-dzszvp feed-embed">

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

                </div>


</body>
</html>