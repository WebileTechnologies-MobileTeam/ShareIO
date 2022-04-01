<!DOCTYPE html>
<?php
session_start();

//ini_set('display_errors', 1);
if(!isset($_SESSION['user']) && empty($_SESSION['user'])){  
  header("Location: dashboard.php");
}
include_once('./include/inc/defined_variables.php');
require_once './vendor/stripe/stripe-php/init.php'; 
\Stripe\Stripe::setApiKey(STRIPE_API_KEY);
?>
<html lang="en">
<title>Edit Dashboard - ShareIO</title>

<?php require('./include/db.php');
	session_start(); ?>
<?php require('head.php'); ?>
<link rel="stylesheet" href="Gridstack/demo.css" />
<link rel="stylesheet" href="Gridstack/dist/gridstack-extra.css" />
<link href="css/wcolpick.css" rel="stylesheet" type="text/css">
<style>
    .changefile input {
        width: 100% !important;
        outline: none;
        padding: 0;
        opacity: 0;
        border: none !important;
        position: absolute;
        left: 0;
        background: #fff;
        top: 0;
        height: 100%;
    }
    .grid-stack-item-removing {
        opacity: 0.8;
        filter: blur(5px);
    }
    #trash {
        background: rgba(255, 0, 0, 0.4);
    }
</style>
<script src="Gridstack/dist/gridstack-h5.js"></script>
<body>
		<?php require('header-new.php'); 
		?>
		<main>
			<div class="container new_container">
				<div class="row">
					<div class="col-md-12">
						<div class="main_content hidden">
                            <?php 
                            if (isset($_SESSION['succsessmsg'])){ ?>  
                            <input type="hidden" id="succsessmsg" name="succsessmsg" value="<?php echo $_SESSION['succsessmsg'];?>">
                            <script>
                            jQuery(document).ready(function($) {
                                var msg = $('#succsessmsg').val();
                                if(msg != ''){
                                    //  $('#login-success-msg').html(msg);
                                    //  $('.loginmsg').addClass('is-visible');
                                    cuteAlert({
                                        type: "success",
                                        title: "Thank You !",
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
                            if(isset($_SESSION['errormsgsamename'])){?>
                            <input type="hidden" id="errormsgsamename" name="errormsgsamename" value="<?php echo $_SESSION['errormsgsamename'];?>">
                            <script>
                            jQuery(document).ready(function($) {
                            var msg = $('#errormsgsamename').val();
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
                            unset($_SESSION['errormsgsamename']);
                            } 
                            ?>
                            
                            <div class="alert alert-success" id="copyurl" style="display: none;">
                                <a href="#" class="close" data-dismiss="alert">&times;</a>
                                <strong>Link Copied to clipboard...!</strong> 
                            </div>
                            <form method="post" id="uploadFormcontent" name="uploadFormcontent" action="include/editdashboard.php">
                                <div class="upload_content_bg user_custom_dashboard">
                                    
                                    <div class="top_default_icons">
                                        <div class="icons description_icon tooltip_shows">
                                            <a onclick="descritpion_icon()" href="javascript:;" class="active">
                                            <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 0 24 24" width="24px" fill="#000000"><path d="M0 0h24v24H0z" fill="none"/><path d="M3 13h8V3H3v10zm0 8h8v-6H3v6zm10 0h8V11h-8v10zm0-18v6h8V3h-8z"/></svg>
                                            </a>
                                            <div class="top">
                                                <span>Standard settings</span> 
                                            </div>
                                        </div>

                                        <div class="icons setting tooltip_shows">
                                            <a onclick="advance()" href="javascript:;">
                                            <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 0 24 24" width="24px" fill="#000000"><path d="M0 0h24v24H0V0z" fill="none"/><path d="M19.43 12.98c.04-.32.07-.64.07-.98 0-.34-.03-.66-.07-.98l2.11-1.65c.19-.15.24-.42.12-.64l-2-3.46c-.09-.16-.26-.25-.44-.25-.06 0-.12.01-.17.03l-2.49 1c-.52-.4-1.08-.73-1.69-.98l-.38-2.65C14.46 2.18 14.25 2 14 2h-4c-.25 0-.46.18-.49.42l-.38 2.65c-.61.25-1.17.59-1.69.98l-2.49-1c-.06-.02-.12-.03-.18-.03-.17 0-.34.09-.43.25l-2 3.46c-.13.22-.07.49.12.64l2.11 1.65c-.04.32-.07.65-.07.98 0 .33.03.66.07.98l-2.11 1.65c-.19.15-.24.42-.12.64l2 3.46c.09.16.26.25.44.25.06 0 .12-.01.17-.03l2.49-1c.52.4 1.08.73 1.69.98l.38 2.65c.03.24.24.42.49.42h4c.25 0 .46-.18.49-.42l.38-2.65c.61-.25 1.17-.59 1.69-.98l2.49 1c.06.02.12.03.18.03.17 0 .34-.09.43-.25l2-3.46c.12-.22.07-.49-.12-.64l-2.11-1.65zm-1.98-1.71c.04.31.05.52.05.73 0 .21-.02.43-.05.73l-.14 1.13.89.7 1.08.84-.7 1.21-1.27-.51-1.04-.42-.9.68c-.43.32-.84.56-1.25.73l-1.06.43-.16 1.13-.2 1.35h-1.4l-.19-1.35-.16-1.13-1.06-.43c-.43-.18-.83-.41-1.23-.71l-.91-.7-1.06.43-1.27.51-.7-1.21 1.08-.84.89-.7-.14-1.13c-.03-.31-.05-.54-.05-.74s.02-.43.05-.73l.14-1.13-.89-.7-1.08-.84.7-1.21 1.27.51 1.04.42.9-.68c.43-.32.84-.56 1.25-.73l1.06-.43.16-1.13.2-1.35h1.39l.19 1.35.16 1.13 1.06.43c.43.18.83.41 1.23.71l.91.7 1.06-.43 1.27-.51.7 1.21-1.07.85-.89.7.14 1.13zM12 8c-2.21 0-4 1.79-4 4s1.79 4 4 4 4-1.79 4-4-1.79-4-4-4zm0 6c-1.1 0-2-.9-2-2s.9-2 2-2 2 .9 2 2-.9 2-2 2z"/>
                                                </svg>
                                            </a>
                                            <div class="top">
                                            <span>Advanced settings</span> 
                                            </div>
                                        </div>
                                        
                                        <div class="icons world tooltip_shows">
                                            <a onclick="countries()" href="javascript:;">
                                                <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 0 24 24" width="24px" fill="#000000"><path d="M0 0h24v24H0V0z" fill="none"/><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zM4 12c0-.61.08-1.21.21-1.78L8.99 15v1c0 1.1.9 2 2 2v1.93C7.06 19.43 4 16.07 4 12zm13.89 5.4c-.26-.81-1-1.4-1.9-1.4h-1v-3c0-.55-.45-1-1-1h-6v-2h2c.55 0 1-.45 1-1V7h2c1.1 0 2-.9 2-2v-.41C17.92 5.77 20 8.65 20 12c0 2.08-.81 3.98-2.11 5.4z"/></svg>
                                            </a>
                                            <div class="top">
                                                <span>Geo location restrictions</span> 
                                            </div>
                                        </div>
                                        
                                        
                                    </div>
                                
                                    <div class="upload_content_leftside">
                                        <div class="grid-stack grid-stack-12"></div>
                                        <a id="view_package" class="view_package view_dashboard" href="reports.php?d=1">View Dashboards</a>
                                    </div>
                                    <div class="upload_content_rightside items">
                                        <div class="upload-contents">
                                            <div class="upload_content_form upload_content_form1 items">
                                                <div class="form-group">
                                                    <label class="col-form-label">Files</label>
                                                    <div class="select_box">
                                                        <select name="file_list" id="file_list">
                                                        <option selected>Select File</option>
                                                            <?php
                                                                $sql = "Select * from sentfile where added_by = '" . $_SESSION["user"] . "' order by file_name ASC";
                                                                $result = mysqli_query($con,$sql);
                                                                if (mysqli_num_rows($result) > 0) { 
                                                                while($fetch_data = mysqli_fetch_array($result)){
                                                                    $filename = '';
                                                                    if(strlen($fetch_data['file_name']) > 20){
                                                                        $filename = substr_replace($fetch_data['file_name'], "...", 20);
                                                                    } else{
                                                                        $filename = $fetch_data['file_name'];
                                                                    }
                                                            ?> 
                                                            <option value=<?php echo $fetch_data['file_id'];?>><?php echo $filename;?></option>
                                                            <?php }
                                                            }?>                 
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label class="col-form-label">Packages</label>
                                                    <div class="select_box">
                                                        <select name="pakage_list" id="pakage_list">
                                                            <option selected>Select Package</option>
                                                            <?php
                                                            $pkgsql = "Select * from package_list where user_id = '" . $_SESSION["user"] . "' order by pkg_name ASC";
                                                            $pkgresult = mysqli_query($con,$pkgsql);
                                                            if (mysqli_num_rows($pkgresult) > 0) { 
                                                            while($fetch_pkgdata = mysqli_fetch_array($pkgresult)){
                                                                $filename = '';
                                                                if(strlen($fetch_pkgdata['pkg_name']) > 20){
                                                                    $filename = substr_replace($fetch_pkgdata['pkg_name'], "...", 20);
                                                                } else{
                                                                    $filename = $fetch_pkgdata['pkg_name'];
                                                                }
                                                            ?> 
                                                            <option value=<?php echo $fetch_pkgdata['pkg_url'];?>><?php echo $filename;?></option>
                                                            <?php }
                                                            }?>                  
                                                        </select>
                                                    </div>
                                                </div>
                                                <input type="hidden" id="dashboard_data" name="dashboard_data">
                                                <input type="hidden" id="dashboard_id" name="dashboard_id" value="<?php echo $_GET["id"];?>">
                                                <div class="default_box green_box">
                                                    <div class="loader show-loader" style="display: none;"></div>
                                                    <div class="sidebar">
                                                        <div class="grid-stack-item">
                                                            <div class="grid-stack-item-content">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <?php
                                                $dashboard_data = '';
                                                $sql = "Select * from user_dashboard where us_dash_id  = '" . $_GET["id"] . "'";
                                                $result = mysqli_query($con,$sql); 
                                                $fetch_data = mysqli_fetch_array($result);
                                                $dashboard_data = $fetch_data['dashboard_data'];
                                                ?>
                                                <input type="hidden" id="bg_color" name="bg_color" value="<?php echo $fetch_data["bg_color"];?>">
                                                <div class="form-group">
                                                    <label class="col-form-label">Dashboard Name</label>
                                                    <input type="text" id="dashboard_name" name="dashboard_name" class="form-control" value="<?php echo $fetch_data['dashboard_name'];?>">
                                                    <label id="nameerror" style="color: red; display: none;"></label>
                                                </div>
                                                <div class="form-group color_list">
                                                    <label class="col-form-label">Background Color</label>
                                                    <div id="colorSelector3"></div>
                                                </div>
                                                <div class="col-full form-group fileUpload">
                                                    <label for="selectpage" class="col-form-label">ShareIO URL
                                                        <div class="tooltip_shows">
                                                            <i class="fa fa-question-circle" aria-hidden="true"></i>
                                                            <div class="top">
                                                            <span>URL for the shared content</span> 
                                                            </div>
                                                        </div>
                                                    </label>                                                    
                                                    <div class="socialShare-icons custom-dashboard-social">
                                                        <div class="socialCircle-container">
                                                        <?php $url = SITE_URL.'/dashboard/'.$fetch_data['dashboard_url']; ?>
                                                        <div class="socialCircle-item socialcircle_facebook"><a href="https://www.facebook.com/sharer/sharer.php?u=<?php echo $url;?>" title="Share by Facebook" target="_blank"><i class="fa fa-facebook"></i></a></div>
                                                        <div class="socialCircle-item socialcircle_twitter"><a href="https://twitter.com/share?url=<?php echo $url;?>" title="Share by Twitter" target="_blank"><i class="fa fa-twitter"></i></a></div>
                                                        <div class="socialCircle-item socialcircle_email"><a href="mailto:?subject=?&amp;body=<?php echo $url;?>" title="Share by Email"><i class="fa fa-envelope-o"></i></a></div>
                                                        <div class="socialCircle-item socialcircle_linkedin"><a href="https://www.linkedin.com/shareArticle?mini=true&url=<?php echo $url;?>&title=ShareIo&source=https://shareio.com" title="Share by LinkedIn" target="_blank"><i class="fa fa-linkedin"></i></a></div>
                                                        <div class="socialCircle-item socialcircle_whatsapp"><a href="whatsapp://send?text=<?php echo $url;?>" title="Share by WhatsApp"><i class="fa fa-whatsapp"></i></a></div>
                                                        <div class="socialCircle-item socialcircle_clipboard"><a href="javascript:;" onclick="CopyURL()" title="Copy to Clipboard"><i class="fa fa-clipboard" aria-hidden="true"></i></a></div>
                                                        </div>
                                                        <div class="icons link_url social_icons_show_hide socialCircle-center closed">
                                                        <input type="text" class="form-control" id="url" value="<?php echo SITE_URL;?>/dashboard/<?php echo $fetch_data['dashboard_url'];?>" readonly>
                                                        <a href="javascript:;" class="copy_clipboard">
                                                        <svg xmlns="http://www.w3.org/2000/svg" fill="#6b6b6b" viewBox="0 0 24 24" width="52" fill="#ffffff"><path d="M0 0h24v24H0z" fill="none"></path><path d="M3.9 12c0-1.71 1.39-3.1 3.1-3.1h4V7H7c-2.76 0-5 2.24-5 5s2.24 5 5 5h4v-1.9H7c-1.71 0-3.1-1.39-3.1-3.1zM8 13h8v-2H8v2zm9-6h-4v1.9h4c1.71 0 3.1 1.39 3.1 3.1s-1.39 3.1-3.1 3.1h-4V17h4c2.76 0 5-2.24 5-5s-2.24-5-5-5z"></path></svg>
                                                        </a>

                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="upload_content_form upload_content_form1 settings" style="display:none;">
                                                <div id="properties">
                                                    <div class="form-group">
                                                        <label class="col-form-label">Title:</label>
                                                        <input type="text" id="title_text" class="form-control">
                                                    </div>
                                                    <div class="form-group color_list">
                                                        <label class="col-form-label">Title Color</label>
                                                        <div id="colorSelector1"></div>
                                                    </div>
                                                    <div class="form-group color_list">
                                                        <label class="col-form-label">Background Color</label>
                                                        <div id="colorSelector2"></div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="col-form-label">Background Image</label>
                                                        <div class="choose_img">
                                                            <img src="images/no-image.png" id="backgroud_img" />
                                                            <input type="file" name="file" class="upload_file" id="upload_file">
                                                            <a class="reset_img" style="display:none;">
                                                                <svg xmlns="http://www.w3.org/2000/svg" width="122.878px" height="122.88px" viewBox="0 0 48 48">
                                                                    <path d="M35.3 12.7c-2.89-2.9-6.88-4.7-11.3-4.7-8.84 0-15.98 7.16-15.98 16s7.14 16 15.98 16c7.45 0 13.69-5.1 15.46-12h-4.16c-1.65 4.66-6.07 8-11.3 8-6.63 0-12-5.37-12-12s5.37-12 12-12c3.31 0 6.28 1.38 8.45 3.55l-6.45 6.45h14v-14l-4.7 4.7z"></path>
                                                                    <path d="M0 0h48v48h-48z" fill="none"></path>
                                                                </svg>
                                                            </a>
                                                            <a class="remove_img">
                                                                <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" version="1.1" id="Layer_1" x="0px" y="0px" width="122.878px" height="122.88px" viewBox="0 0 122.878 122.88" enable-background="new 0 0 122.878 122.88" xml:space="preserve"><g><path d="M1.426,8.313c-1.901-1.901-1.901-4.984,0-6.886c1.901-1.902,4.984-1.902,6.886,0l53.127,53.127l53.127-53.127 c1.901-1.902,4.984-1.902,6.887,0c1.901,1.901,1.901,4.985,0,6.886L68.324,61.439l53.128,53.128c1.901,1.901,1.901,4.984,0,6.886 c-1.902,1.902-4.985,1.902-6.887,0L61.438,68.326L8.312,121.453c-1.901,1.902-4.984,1.902-6.886,0 c-1.901-1.901-1.901-4.984,0-6.886l53.127-53.128L1.426,8.313L1.426,8.313z"/></g>
                                                                </svg>
                                                            </a>
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="col-form-label">Link:</label>
                                                        <input type="text" id="tile_link" class="form-control">
                                                    </div>
                                                    <div class="form-group d-flex flex-wrap">
                                                        <a id="save_properties" class="btn">Update</a>
                                                        <button type="button" class="close_btn_properties">Close</button>
                                                    </div>                                                                                
                                                </div>
                                            </div>
                                            <div class="upload_content_form upload_content_form2" style="display:none;">
                                                <div class="form-row">
                                                    <div class="form-group">
                                                        <label for="selectpage" class="col-form-label">Browser view
                                                            <div class="tooltip_shows">
                                                                <i class="fa fa-question-circle" aria-hidden="true"></i>
                                                                <div class="top">
                                                                    <span>Disable view via browser and force view via mobile app</span> 
                                                                </div>
                                                            </div>
                                                        </label>
                                                        <div class="select_box">
                                                            <select class="form-control select2" data-toggle="select2" id="browser_view" name="browser_view">
                                                                <option value="1" <?php
                                                                if ($fetch_data['browser_enabled'] == '1') { ?> selected="selected" <?php } ?>>Yes</option>
                                                                <option value="0" <?php
                                                                if ($fetch_data['browser_enabled'] == '0') { ?> selected="selected" <?php } ?>>No</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="form-group notifications">
                                                        <label for="selectpage" class="col-form-label">Notifications
                                                            <div class="tooltip_shows">
                                                                <i class="fa fa-question-circle" aria-hidden="true"></i>
                                                                <div class="top">
                                                                    <span>Display notifications on shared content if parameters are updated</span> 
                                                                </div>
                                                            </div>
                                                        </label>
                                                        <div class="select_box">
                                                            <select class="form-control select2" data-toggle="select2" id="notification" name="notification">
                                                                <option value="1" <?php
                                                                if ($fetch_data['notification'] == '1') { ?> selected="selected" <?php } ?>>Yes</option>
                                                                <option value="0" <?php
                                                                if ($fetch_data['notification'] == '0') { ?> selected="selected" <?php } ?>>No</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-row">
                                                    <div class="form-group">
                                                        <label for="selectpage" class="col-form-label">Social Share
                                                            <div class="tooltip_shows">
                                                                <i class="fa fa-question-circle" aria-hidden="true"></i>
                                                                <div class="top">
                                                                    <span>Display social share buttons one shared content</span> 
                                                                </div>
                                                            </div>
                                                        </label>
                                                        <div class="select_box">
                                                            <select class="form-control select2" data-toggle="select2" id="social_share" name="social_share">
                                                                <option value="1" <?php
                                                                if ($fetch_data['social_share'] == '1') { ?> selected="selected" <?php } ?>>Yes</option>
                                                                <option value="0" <?php
                                                                if ($fetch_data['social_share'] == '0') { ?> selected="selected" <?php } ?>>No</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="form-group hidebanner_field">
                                                        <label for="selectpage" class="col-form-label">Hide Banner
                                                            <div class="tooltip_shows">
                                                                <i class="fa fa-question-circle" aria-hidden="true"></i>
                                                                <div class="top">
                                                                <span>Hide the banner when link is displayed.</span> 
                                                                </div>
                                                            </div>
                                                        </label>
                                                        <div class="select_box">
                                                            <select class="form-control select2" data-toggle="select2" id="hide_banner" name="hide_banner">
                                                                <option value="1" <?php
                                                                if ($fetch_data['hide_banner'] == '1') { ?> selected="selected" <?php } ?>>Yes</option>
                                                                <option value="0" <?php
                                                                if ($fetch_data['hide_banner'] == '0' || $fetch_data['hide_banner'] == '') { ?> selected="selected" <?php } ?>>No</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-row">
                                                    <div class="form-group password_dns">
                                                        <label class="col-form-label">Password
                                                            <div class="tooltip_shows">
                                                                <i class="fa fa-question-circle" aria-hidden="true"></i>
                                                                <div class="top">
                                                                    <span>Require password shared content can be opened</span> 
                                                                </div>
                                                            </div>
                                                        </label>
                                                        <input type="password" class="form-control" name="password" id="password" value="<?php echo $fetch_data['password'];?>">
                                                    </div>
                                                    <div class="form-group ip_dns_lock">
                                                        <label class="col-form-label">IP / DNS lock
                                                            <div class="tooltip_shows">
                                                                <i class="fa fa-question-circle" aria-hidden="true"></i>
                                                                <div class="top">
                                                                    <span>Force the content to be only opened on set IP / DNS</span> 
                                                                </div>
                                                            </div>
                                                        </label>
                                                        <input type="text" class="form-control" name="ip_dns" id="ip_dns" value="<?php echo $fetch_data['ip_dns'];?>">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="upload_content_form upload_content_form3" style="display:none;">
                                                <div class="upload_content_form3_leftside">
                                                    <div class="view_countries_title"><span>Countries this content is viewable : </span></div>
                                                    <div class="view_countries">
                                                        <select id="countries" name="multiselectsortable" class="multiselectsortable" size="16" aria-label="size 3 select example"></select>
                                                    </div> 
                                                </div>

                                                <div class="upload_content_form3_middleside">
                                                    <div class="arrow_icon country_section_content_middle">
                                                        <a class="arrow_right"><i class="fa fa-angle-right"></i></a>
                                                        <a class="arrow_left"><i class="fa fa-angle-left"></i></a>
                                                        <!-- <svg xmlns="http://www.w3.org/2000/svg" enable-background="new 0 0 24 24" viewBox="0 0 24 24" fill="#000000"><g><rect fill="none" height="24" width="24" x="0"/></g><g><g><a href="javascript:void(0)" class="arrow_left"><polygon points="7.41,13.41 6,12 2,16 6,20 7.41,18.59 5.83,17 21,17 21,15 5.83,15"/></a><a href="javascript:void(0)" class="arrow_right"><polygon points="16.59,10.59 18,12 22,8 18,4 16.59,5.41 18.17,7 3,7 3,9 18.17,9"/></a></g></g></svg> -->
                                                    </div>
                                                </div>
                                                <div class="upload_content_form3_rightside">
                                                    <div class="block_countries_title"><span>Countries this content is blocked : </span></div>
                                                    <div class="block_countries">
                                                        <div class="multiselect_sortable_content">
                                                           <div class="selection">
                                                               <ul class="selection_content sortable">
                                                                   <?php if(!empty($fetch_data['block_countries']) && $fetch_data['block_countries'] != 'null'){ 
                                                                       $json_array = json_decode($fetch_data['block_countries'], true);
                                                                       foreach($json_array as $key => $value){ ?>
                                                                       <li class="select_li" data-name="<?php echo Locale::getDisplayRegion('-'.$value.'', 'en'); ?>" data-value="<?php echo $value; ?>"><?php echo Locale::getDisplayRegion('-'.$value.'', 'en'); ?></li>
                                                                    <?php } } ?>      
                                                               </ul>
                                                           </div>
                                                       </div>
                                                    </div> 
                                                    <div id="block_country_db"></div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="edit_dashboard_button">
                                            <div class="icons delete_items tooltip_shows">
                                                <a href="javascript:;" id="delete-content">
                                                <svg xmlns="http://www.w3.org/2000/svg" fill="#6b6b6b" viewBox="0 0 24 24" width="65" height="65"><path d="M6 19c0 1.1.9 2 2 2h8c1.1 0 2-.9 2-2V7H6v12zM19 4h-3.5l-1-1h-5l-1 1H5v2h14V4z"></path><path d="M0 0h24v24H0z" fill="none"></path>
                                                </svg>
                                                </a>
                                                <div class="left">
                                                <span>Delete dashboard</span>
                                                </div> 
                                            </div>

                                            <div class="icons qr_icon tooltip_shows">
                                                <a href="javascript:;" id="getqr">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="44" xmlns:xlink="http://www.w3.org/1999/xlink" fill="#6b6b6b" version="1.1" x="0px" y="0px" viewBox="0 0 1000 1000" enable-background="new 0 0 1000 1000" xml:space="preserve">
                                                <g><g transform="translate(0.000000,511.000000) scale(0.100000,-0.100000)"><path d="M100,2797.1V584.2h2212.9h2212.9v2212.9V5010H2312.9H100V2797.1z M3577.4,2797.1V1532.6H2312.9H1048.4v1264.5v1264.5h1264.5h1264.5V2797.1z"/><path d="M1680.6,2797.1v-632.3h632.3h632.3v632.3v632.3h-632.3h-632.3V2797.1z"/><path d="M5474.2,2797.1V584.2h2212.9H9900v2212.9V5010H7687.1H5474.2V2797.1z M8951.6,2797.1V1532.6H7687.1H6422.6v1264.5v1264.5h1264.5h1264.5V2797.1z"/><path d="M7054.8,2797.1v-632.3h632.3h632.3v632.3v632.3h-632.3h-632.3V2797.1z"/><path d="M100-2577.1V-4790h2212.9h2212.9v2212.9v2212.9H2312.9H100V-2577.1z M3577.4-2577.1v-1264.5H2312.9H1048.4v1264.5v1264.5h1264.5h1264.5V-2577.1z"/><path d="M1680.6-2577.1v-632.3h632.3h632.3v632.3v632.3h-632.3h-632.3V-2577.1z"/><path d="M5474.2-917.4v-553.2h553.2h553.2v-553.2v-553.2h-553.2h-553.2v-553.2v-553.2h553.2h553.2v-553.2V-4790h553.2h553.2v553.2v553.2h553.2h553.2v-553.2V-4790h553.2H9900v553.2v553.2h-553.2h-553.2v553.2v553.2h553.2H9900v553.2v553.2h-553.2h-553.2v553.2v553.2h-553.2h-553.2v-553.2v-553.2h-553.2h-553.2v553.2v553.2h-553.2h-553.2V-917.4z M8793.5-2023.9v-553.2h-553.2h-553.2v-553.2v-553.2h-553.2h-553.2v553.2v553.2h553.2h553.2v553.2v553.2h553.2h553.2V-2023.9z"/></g></g>
                                                </svg>
                                                </a>
                                                <div class="left">
                                                <span>QR code link to share</span>
                                                </div>
                                            </div>
                                            
                                            <div class="processbutton tooltip_shows">
                                                <button type="button" onclick="checkname()">
                                                <svg xmlns="http://www.w3.org/2000/svg" version="1.2" viewBox="0 0 18 18" width="18" height="18">
                                                      <path id="Layer" class="s0" d="m-3-3h24v24h-24z"/>
                                                      <path id="Layer" fill-rule="evenodd" class="s1" d="m18 4v12c0 1.1-0.9 2-2 2h-14c-1.1 0-2-0.9-2-2v-14c0-1.1 0.9-2 2-2h12zm-6 9c0-1.7-1.3-3-3-3c-1.7 0-3 1.3-3 3c0 1.7 1.3 3 3 3c1.7 0 3-1.3 3-3zm0-11h-10v4h10z"/>
                                              </svg>
                                            </button>
                                            <button type="submit" id="submit" style="display: none;" onclick="displayResult()">
                                                <svg xmlns="http://www.w3.org/2000/svg" version="1.2" viewBox="0 0 18 18" width="18" height="18">
                                                      <path id="Layer" class="s0" d="m-3-3h24v24h-24z"/>
                                                      <path id="Layer" fill-rule="evenodd" class="s1" d="m18 4v12c0 1.1-0.9 2-2 2h-14c-1.1 0-2-0.9-2-2v-14c0-1.1 0.9-2 2-2h12zm-6 9c0-1.7-1.3-3-3-3c-1.7 0-3 1.3-3 3c0 1.7 1.3 3 3 3c1.7 0 3-1.3 3-3zm0-11h-10v4h10z"/>
                                              </svg>
                                            </button>
                                                <div class="left">
                                                <span>Save dashboard</span>
                                                </div>
                                            </div>
                                            
                                        </div>
                                    </div>
                                </div>
                            </form>
					    </div>
				    </div>
			    </div>
            </div>
		</main>
		<?php require('footer-new.php'); ?>
	</body>
<script type="text/javascript" src="js/countryList.js"></script>

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
        }); 

        $('.arrow_left').click(function(e){ 
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

<script type="text/javascript">
   function displayResult() {
        var wrapper_db = $("#block_country_db");
        $('.selection_content .select_li').each(function(i, obj) {
            var val = $(this).data('value');
            $(wrapper_db).append('<input type="hidden" value="'+val+'" name="block_country[]" />');
        });
    }
    
    jQuery(function($){
        $('.multiselectsortable').multiselect_sortable({
            selectable:{
                title:''
            },
            selection :{
                title:''
            }
        });
    })

   jQuery(document).ready(function($){
       $('.selection_content .select_li').each(function(i, obj) {
            var val = $(this).data('value');
            $('.selectable_content li[data-value="'+val+'"]').remove();
       });
   });
</script>

<script src="js/socialCircle.js"></script> 
<script type="text/javascript">
$(document).ready(function(){
   if($(window).width() < 640){
      $( ".socialCircle-center" ).socialCircle({
         rotate: 180,
         radius:100,
         circleSize: 2,
         speed:500,
         siblingClass:'.socialCircle-item'
      });
   }else if($(window).width() < 1450){
        $( ".socialCircle-center" ).socialCircle({
         rotate: 90,
         radius:120,
         circleSize: 2,
         speed:500,
         siblingClass:'.socialCircle-item'
      });
   }else{
      $( ".socialCircle-center" ).socialCircle({
         rotate: 90,
         radius:150,
         circleSize: 2,
         speed:500,
         siblingClass:'.socialCircle-item'
      });
   }
  

});
</script>
<script src="js/wcolpick.js"></script>
<script>

	jQuery(document).ready(function($){
	    $( ".main_content" ).removeClass("hidden");
	});
	
    let options = {
        column: 12,
        disableOneColumnMode: true,
        acceptWidgets: function (el) { return true; },
    };
    let items = <?php echo $dashboard_data;?>;

    let grid = GridStack.init(options)

    grid.load(items);

    grid.on('dropped', function (event, previousWidget, newWidget) {
        if (event.dataTransfer) {
            console.log('gridstack dropped: ', event.dataTransfer.getData('message'));
            var div = newWidget['el'];
            $(div).children('div').addClass('remove-tile');
            if($(div).children('div').children().length == 0){
                $(div).children('div').html('<a class="remove-stack" onclick="grid.removeWidget(this.parentNode.parentNode)"><i class="fa fa-times" aria-hidden="true"></i></a><a class="changefile properties"><p id="title"></p></a>');
            }
        }
    });

    grid.on('added removed', function(e, items) {
        let str = '';
        items.forEach(function(item) { str += ' (x,y)=' + item.x + ',' + item.y; });
        console.log(e.type + ' ' + items.length + ' items:' + str );
    });

    GridStack.setupDragIn(
        '.green_box .sidebar .grid-stack-item',
        {
            revert: 'invalid',
            scroll: false,
            appendTo: 'body',
            helper: clone,
            start: start
        }
    );

    function clone(event) {
        return event.target.cloneNode(true);
    }

    function start(event) {
        if (event.dataTransfer) {
            event.dataTransfer.setData('message', 'Hello World');
        }
    }

    checkname = function() {
        if($('#dashboard_name').val() == ''){
            $('#nameerror').css("display", "block");
            
            $('#nameerror').html('Please enter dashboard name.');
        } else{
            var dashboardName = $('#dashboard_name').val();
            var oldDashboardName = <?php echo json_encode($fetch_data['dashboard_name']);?>;
            if(oldDashboardName != dashboardName){
                $.ajax({
                    type: "POST",
                    url: 'include/adduserdashboard.php',
                    data: {
                      dashboard_name: dashboardName,
                      checkname : 'checkname'
                    },
                    success: function(resp) {
                      if (resp == 'false') {
                        cuteAlert({
                            type: "error",
                            title: "Oops...",
                            message: 'Dashboard name has been already used.',
                            buttonText: "Close"
                        })
                      } else{
                        saveFullGrid();
                        $("#submit").click();
                      }
                    }
                });
            } else{
                saveFullGrid();
                $("#submit").click();
            }
        }
    }

    saveFullGrid = function() {
        if($('#dashboard_name').val() == ''){
            $('#nameerror').css("display", "block");
            $('#nameerror').html('Please enter dashboard name.');
            return false;
        }
        //$(".upload_file").remove();
        serializedFull = grid.save(true, true);
        serializedData = serializedFull.children;
        var data = $.parseJSON(JSON.stringify(serializedFull, null, '  '));
        $('#dashboard_data').val(JSON.stringify(data['children']));
    }

    $('#dashboard_name').on('keyup', function(){
        $('#nameerror').hide();
    });

    jQuery(function() {
        $('#colorSelector1').loads({
            layout: 'hex',
            flat: false,
            enableAlpha: false,
            color: '317dd4',
            onChange: function(ev) {
                $('.properties p').css('color', '#' + ev.hex);
                $('#colorSelector1').css('backgroundColor', '#' + ev.hex);
            }
        });

        $('#colorSelector2').loads({
            layout: 'hex',
            flat: false,
            enableAlpha: false,
            color: '317dd4',
            onChange: function(ev) {
                $('.properties').css('backgroundColor', '#' + ev.hex);
                $('#colorSelector2').css('backgroundColor', '#' + ev.hex);
            }
        });

        var bgColor = <?php echo json_encode($fetch_data["bg_color"]);?>;
        if((bgColor == '') || (bgColor == null)){
            bgColor = '#4e5f78';
        }

        $('#colorSelector3').loads({
            layout: 'hex',
            flat: false,
            enableAlpha: false,
            color: bgColor,
            onChange: function(ev) {
                $('#bg_color').val('#' + ev.hex);
                $('#colorSelector3').css('backgroundColor', '#' + ev.hex);
                $('.grid-stack').css('background', '#' + ev.hex);
            }
        });

        $('#colorSelector3').css('backgroundColor', bgColor);
        $('.grid-stack').css('background', bgColor);
    });

    $('#pakage_list').on('change', function(){
        var package_url = $('#pakage_list').val();
        if(package_url == ''){
            $('.green_box .grid-stack-item-content').html('');
        } else{
            var grid_item = '<a class="remove-stack" onclick="grid.removeWidget(this.parentNode.parentNode)"><i class="fa fa-times" aria-hidden="true"></i></a><a class="changefile" data-href="https://shareio.com/package/'+package_url+'"><svg xmlns="http://www.w3.org/2000/svg" width="70px" fill="#ffffff" xmlns:xlink="http://www.w3.org/1999/xlink" version="1.1" id="Layer_1" x="0px" y="0px" viewBox="0 0 512 512" style="enable-background:new 0 0 512 512;" xml:space="preserve"><g><path d="M171.456,201.1c-3.729,4.954-9.453,8.014-15.645,8.361l-83.291,4.669v185.115l162.719,31.602V116.336L171.456,201.1z"></path></g><g><path d="M356.767,209.461c-6.194-0.347-11.917-3.406-15.645-8.361l-63.778-84.759v314.506l162.716-31.602V214.131L356.767,209.461    z"></path></g><g><polygon points="447.804,101.376 303.61,81.218 312.862,93.515 368.885,167.969 427.28,171.243 512,175.993   "></polygon></g><g><polygon points="63.129,101.373 0,176.025 85.299,171.242 143.69,167.969 199.713,93.519 209.018,81.152"></polygon></g></svg><p id="title"></p></a>';
            $('.green_box .grid-stack-item-content').html(grid_item);
        }
    });

    $('#file_list').on('change', function(){
        var file_id = $('#file_list').val();
        if(file_id == ''){
            $('.green_box .grid-stack-item-content').html('');
        } else{
            $('.loader').show();
            $.ajax({
                type: "GET",
                url: 'include/getFileData.php?file-id='+file_id,
                data: {
                  file_id: file_id
                },
                success: function(html) {
                  $('.green_box .grid-stack-item-content').html(html);
                  $('.loader').hide();
                }
              });
        }
    });

    $(document).on('change', 'input[name="file"]', function(e){
        var file = this.files[0];
        var file_name = $(this).val().split('\\').pop();
        var parent = $('.properties');
        parent.append('<div class="loader show-loader"></div>');
        parent.addClass('loading');
        if(parent.hasClass( "video_file" )){
            parent.children('video').remove();
            $('#backgroud_img').remove();
            $('.choose_img').append('<img src="" id="backgroud_img" />');
            parent.removeClass("video_file");
            parent.prepend('<img src="" style="height: 100%;width: 100%;"/>');
        }
        $('.properties').prepend('<img src="" style="height: 100%;width: 100%;"/>');
        var image = $('.properties').children('img');
        
        if (file) {
            $('#backgroud_img').attr("src", URL.createObjectURL(file));            
        } 
        var data = new FormData();
        data.append('upload_file', $(this).prop('files')[0]);

        $.ajax({
            type: 'POST',               
            processData: false, 
            contentType: false, 
            data: data,
            url: 'include/getFileData.php',
            dataType : 'script',  
            success: function(resp){
                image.attr("src", "https://contentshare-files.s3.amazonaws.com/UserCustomDashboard/"+file_name);
                parent.children('.loader').remove();
                parent.removeClass('loading');
            }
        });
    });

    $(document).on('click', '.close_btn_properties, .remove-stack', function(){
        $(".upload_content_form1.settings").hide();
        $(".upload_content_form1.items").show();
    });

    $(document).on('click', '#save_properties', function(){
        var link = $('#tile_link').val();
        $('.properties').attr("data-href", link);
        cuteAlert({
            type: "success",
            title: "Success !",
            message: "Settings saved.",
            buttonText: "Close"
        })
    });

    function CopyURL(){
        var copyText = document.getElementById("url");
        copyText.select();
        copyText.setSelectionRange(0, 99999)
        document.execCommand("copy");
        $('.socialCircle-center').click();
        //alert("Copied the text: " + copyText.value);
        $('#copyurl').removeAttr("style");
        $('#copyurl').addClass("in");
        setInterval(function(){ 
            $('#copyurl').hide();
        }, 4000);
    }

    $(document).on('click', '.changefile', function(){
        $('.changefile').removeClass("properties");
        $(this).addClass("properties");
        var image;
        if($('.properties').hasClass( "video_file" )){
            $('#backgroud_img').remove();
            image = $(this).children('video').attr('src');
            $('.choose_img').append('<video src="'+image+'#t=5" style="height: 100%;width: 100%;" id="backgroud_img"></video>');
        } else{
            image = $(this).children('img').attr('src');
            $('#backgroud_img').remove();
            $('.choose_img').append('<img src="" id="backgroud_img" />');
            if (image == null){
                $('#backgroud_img').attr('src', 'images/no-image.png');
            } else{
                $('#backgroud_img').attr('src', image);
            }
            
        }
        $('.reset_img').hide();
        var resetImg = $(this).data('image');
        if(resetImg == "show"){
            $('.reset_img').show();
        }
        $('#title_text').val($(this).children('p').html());
        var color = $(this).children('p').css("color");
        $('#colorSelector1').css('backgroundColor', color);
        if($(this).attr("style")){
            $('#colorSelector2').css('backgroundColor', $(this).css("backgroundColor"));
        }
        $("#upload_file").val('');
        var link = $(this).data("href");
        $('#tile_link').val(link);
        $('.upload_content_form1.settings').removeAttr('style');
        $('.upload_content_form1.items').hide();
    });

    $(document).on('click', '.reset_img', function(){
        var id = $('.properties').data('id');
        var type = $('.properties').data('type');
        $.ajax({
            type: "POST",
            url: 'include/getFileData.php',
            data: {
                reset: 'reset',
                id:id,
                type:type
            },
            success: function(data) {
                var data = jQuery.parseJSON( data );
                $('#backgroud_img').remove();
                $('.properties').children('img').remove();
                $('.choose_img').append(data.html);
                $('.properties').append(data.tileHtml);
                $("#upload_file").val('');
                if(data.type == "video"){
                    $('.properties').addClass('video_file');
                }
            }
        });
    });

    $('.remove_img').on('click', function(){
        if($('.properties').hasClass( "video_file" )){
            $('.properties').children('video').remove();
            $('.choose_img').children('video').remove();
            $('.choose_img').append('<img src="" id="backgroud_img" />');
            $('.properties').removeClass("video_file");
        } else{
            $('.properties').children('img').remove();
        }
        $('#backgroud_img').attr('src', 'images/no-image.png');
    });

    $(document).on('keyup', '#title_text', function(e){
        var title = $('.properties').children('p');
        title.html($("#title_text").val());
    });

    $(document).on('click', '.remove-stack', function(){
        $(this).parent().parent().remove();
    });

    function advance(){
        $('.upload_content_form2').show();
        $('.upload_content_leftside').hide();
        $('.upload-contents .forms_icons').show();
        $('.upload_content_form1').hide();
        $('.upload_content_form3').hide();
        $('.upload_content_rightside').addClass('advance_setting');
        $('.upload_content_rightside').removeClass('countries_advance_setting');
        $(".top_default_icons .setting a").addClass("active");
        $(".top_default_icons .description_icon a").removeClass("active");
        $(".top_default_icons .world a").removeClass("active");
    }
        
    function descritpion_icon(){
        $('.upload_content_form1.items').show();
        $('.upload_content_leftside').show();
        $('.upload-contents .forms_icons').show();
        $('.upload_content_form2').hide();
        $('.upload_content_form3').hide();
        $(".top_default_icons .description_icon a").addClass("active");
        $(".top_default_icons .setting a").removeClass("active");
        $(".top_default_icons .world a").removeClass("active");
        $('.upload_content_rightside').removeClass('countries_advance_setting');
        $('.upload_content_rightside').removeClass('advance_setting');
    }

    function countries(){
        $('.upload_content_form3').show();
        $('.upload_content_form1').hide();
        $('.upload_content_form2').hide();
        $('.upload_content_leftside').hide();
        $('.upload-contents .forms_icons').hide();
        $('.upload_content_rightside').addClass('countries_advance_setting');
        $('.upload_content_rightside').removeClass('advance_setting');
        $(".top_default_icons .world a").addClass("active");
        $(".top_default_icons .description_icon a").removeClass("active");
        $(".top_default_icons .setting a").removeClass("active");
    }

    $('#delete-content').on('click', function(){
        var id = <?php echo json_encode($_GET['id']);?>;
        cuteAlert({
            type: "question",
            title: "Delete",
            message: "Do you wish to delete this dashboard?",
            confirmText: "Yes, delete it!",
            cancelText: "Cancel"
         }).then((e)=>{
            if ( e == ("confirm")){
               $.ajax({
               type: "POST",
               url: "include/delete-content.php?dahsboardid="+id,
               success: function(res){ 
                  window.location = "reports.php?d=1"; 
                }
               });
            }
         })
      });

      $('#getqr').on('click', function(){
         var imageUrl = <?php echo json_encode($fetch_data['dashboard_qr']);?>;
         if(imageUrl.includes("contentshare.me")){
            imageUrl = imageUrl.replace("contentshare.me", "shareio.com");
         }
          
         Swal.fire({
          title: 'ShareIO',
          imageUrl: imageUrl,
          imageWidth: 300,
          imageHeight: 300,
          html:
            '<a href="'+imageUrl+'" download>Download</a>'
        })
      });
</script>
</html>