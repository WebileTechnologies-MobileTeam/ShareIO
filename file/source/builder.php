<?php
require_once(dirname(__FILE__).'/class-builder.php');


$dzszvp_builder = new DZSzvp_Builder();

$struct_item_default = str_replace(array("\r","\r\n","\n"),'',$dzszvp_builder->generate_layer_item(array('class' => '{{jsreplace_class}}', 'nodename' => '{{jsreplace_nodename}}', 'href' => '{{jsreplace_href}}', 'innerhtml' => '{{jsreplace_innerhtml}}', 'width' => '{{jsreplace_width}}', 'height' => '{{jsreplace_height}}', 'top' => '{{jsreplace_top}}', 'left' => '{{jsreplace_left}}', 'bottom' => 'auto', 'right' => 'auto'
        ,'background_color' => '{{jsreplace_backgroundColor}}','margin_right' => '{{jsreplace_marginRight}}')));
?><!doctype html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <title>Zoom Video Player - Skin Builder</title>
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=2">
        <link href="./bootstrap/bootstrap.css" rel="stylesheet">
        <link rel='stylesheet' type="text/css" href="style/style.css"/>
        <!--<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js" type="text/javascript"></script>-->
        <script src="js/jquery.js" type="text/javascript"></script>

        <script>
            var dzszvp_builder_settings = {
                struct_layer: '<?php echo $struct_item_default; ?>'
                , currSkin: '<?php echo $dzszvp_builder->currSkin; ?>'
                , thepath: ''
            }
        </script>
        <!--[if lt IE 9]><script src="../assets/js/ie8-responsive-file-warning.js"></script><![endif]-->

        <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
        <![endif]-->


        <link rel='stylesheet' type="text/css" href="zoomplayer/zoomplayer.css"/>
        <link rel='stylesheet' type="text/css" href="style/builder.css"/>
        <script src="js/builder.js" type="text/javascript"></script>
        <link href='http://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css'>
        
        
    </head>
    <body>


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
                            <li class=" "><a href="builder.html">Builder</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </section>
        <!--===end mainmenu
        -->


        <section class="mcon-maindemo" style="position: relative; padding-top:100px; padding-bottom:50px;">
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <br/>
                        <br/>
                        <?php
                        foreach ($dzszvp_builder->frontend_errors as $err) {
                            echo $err;
                        }
                        ?>
                    </div>
                    <div class="col-md-6">
                        <h3 style="margin-top: 0; padding-top: 0;">Customize <strong>skin-<?php echo $dzszvp_builder->currSkin; ?></strong> - <span class='btn-preview'>preview</span></h3>
                    </div>
                    <div class="col-md-6">
                        <div class="super-select float-right">
                            <span class="btn-show-select"><span class='arrow-symbol'>↳</span> Current Skin <strong>skin-<?php echo $dzszvp_builder->currSkin; ?></strong> </span>
                            <div class="super-select--inner">
                                <div class='scroller-con super-select--options'>
                                    <div class="inner">
                                        <div class='skin-option button-secondary'><a href="builder.php?skin=custom">skin-custom</a></div><?php
                                        foreach ($dzszvp_builder->db_skins as $skin) {
                                            echo '<div class="skin-option button-secondary"><a href="builder.php?skin='.$skin.'">skin-'.$skin.'</a></div>';
                                        }
                                        ?><div class='skin-option button-secondary'>skin-<form id='create-custom-skin' method="POST" action="builder.php?skin=" style="display: inline-block; opacity: 0.5; width: 90px;"><input class="subtile" type="text" name="builder_skin_name" placeholder="skin name" style="width: 100%;"/></form></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <form name="builder-form" class="builder-form">

                    <div class="row">
                        <div class="dzszvp-builder-con">
                            <div class="col-md-8">
                                
                                <style class="style-for--canvas-area "></style>
                                <div class="dzszvp-builder-con--canvas-area " style="opacity: 0;"></div>
                                <div class="dzszvp-builder-con--add-area">
                                    <?php
                                    
$dir    = dirname(__FILE__).'/db/components/';
$files1 = scandir($dir);

foreach($files1 as $file){
    if($file==='.' || $file==='..' || $file==='.DS_Store'){
        continue;
    }
        echo '<span class="add-area--component">';
        include_once($dir.$file);
        echo '</span>';
    
}
//print_r($files1);
                                    ?>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <?php
//                                print_r($dzszvp_builder->db_skin_data['bars']);
                                ?>
                                <div class="dzszvp-builder-con--layers-area"><!--begin layers area-->
                                    <?php
                                    if (isset($dzszvp_builder->db_skin_data['bars'])) {
                                        $bars = $dzszvp_builder->db_skin_data['bars'];
                                        foreach ($bars as $lab_bar => $val_bar) {
                                            if ($lab_bar !== 0 && $lab_bar == 'mainsettings') {
                                                continue;
                                            }
//                                        print_r($val_bar);
                                            $aux = $val_bar;
                                            echo $dzszvp_builder->generate_layer_item($aux);
                                        }
                                    }
                                    ?>
                                <!--end layers area--></div>
                            </div>

                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <?php
                            $mainsettings = array(
                                'position_type' => 'relative',
                                'index' => '0',
                                'width' => '100%',
                                'height' => 'auto',
                                'animation_time' => '2000',
                                'maxperc' => '100',
                                'margin_top' => '0',
                                'margin_right' => '0',
                                'margin_bottom' => '0',
                                'margin_left' => '0',
                                'color' => '#eeeeee',
                                'background_color' => '#285e8e',
                                'type' => 'rect',
                                'initon' => 'scroll',
                                'maxnr' => '100',
                            );

                            
                            $mainsettings_fromdb = array();

                            if (isset($dzszvp_builder->db_skin_data['bars']['mainsettings'])) {
                                $mainsettings_fromdb = $dzszvp_builder->db_skin_data['bars']['mainsettings'];
                            }
                            $mainsettings = array_merge($mainsettings,$mainsettings_fromdb);

//                        $mainsettings = array_merge();
                            ?>
                            <br>
                            <div class="sidenote"><p></p>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <br/>
                        <br/>
                        <div class="col-md-6">
                            <button class="button-primary btn-save-skin">Save Changes</button>
                        </div>
                        <div class="col-md-6" style="text-align: right;">
                            version 1.0
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                        <h3>Preview Examples</h3>
                        </div>
                        <br>
                        <div class="col-md-3">
                            <a href='?skin=defaultcustom'>
                                <div class='divimage preview-example' style='background-image: url(img/builder_e1.jpg);'></div>
                            </a>
                        </div>
                        <div class="col-md-3">
                            <a href='?skin=avanticustom'>
                                <div class='divimage preview-example' style='background-image: url(img/builder_e2.jpg);'></div>
                            </a>
                        </div>
                        <div class="col-md-3">
                            <a href='?skin=procustom'>
                                <div class='divimage preview-example' style='background-image: url(img/builder_e3.jpg);'></div>
                            </a>
                        </div>
                        <div class="col-md-3">
                            <a href='?skin=playbigcustom'>
                                <div class='divimage preview-example' style='background-image: url(img/builder_e4.jpg);'></div>
                            </a>
                        </div>
                        
                    </div>
                </form>
            </div>
        </section>
        <div class="saveconfirmer active" style=""><img alt="" style="" id="save-ajax-loading2" src="./img/wpspin_light.gif"/></div>

        <link rel="stylesheet" href="fontawesome/font-awesome.min.css">

        <script src="dzsscroller/scroller.js" type="text/javascript"></script>
        <link rel='stylesheet' type="text/css" href="dzsscroller/scroller.css"/>

        <link rel='stylesheet' type="text/css" href="jqueryui/jquery-ui.min.css"/>
        <script src="jqueryui/jquery-ui.min.js" type="text/javascript"></script>
        <link rel='stylesheet' type="text/css" href="dzstabsandaccordions/dzstabsandaccordions.css"/>
        <script src="dzstabsandaccordions/dzstabsandaccordions.js"></script>
        <link rel='stylesheet' type="text/css" href="colorpicker/farbtastic.css"/>
        <script src="colorpicker/farbtastic.js"></script>

    </body>
</html>