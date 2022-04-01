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
<title>Add Package - ShareIO</title>

<?php require('./include/db.php');
	session_start(); ?>
<?php require('head.php'); ?>
<style>
  #preview{
  position:absolute;
  border:3px solid #ccc;
  background:#333;
  padding:5px;
  display:none;
  color:#fff;
  box-shadow: 4px 4px 3px rgba(103, 115, 130, 1);
  max-height: 200px;
  max-width: 200px;
  }
</style>
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
                                        title: "Success !",
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
                            ?>
                            <form method="post" id="uploadFormcontent" name="uploadFormcontent" action="include/addpackage.php" enctype="multipart/form-data" onsubmit="return validateForm()">
                                <div class="upload_content_bg packages">
                                    
                                    <div class="top_default_icons">
                                        <div class="icons description_icon tooltip_shows">
                                            <a onclick="descritpion_icon()" href="javascript:;" class="active">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="70px" fill="#ffffff" xmlns:xlink="http://www.w3.org/1999/xlink" version="1.1" id="Layer_1" x="0px" y="0px" viewBox="0 0 512 512" style="enable-background:new 0 0 512 512;" xml:space="preserve">
                                                <g>
                                                    <path d="M171.456,201.1c-3.729,4.954-9.453,8.014-15.645,8.361l-83.291,4.669v185.115l162.719,31.602V116.336L171.456,201.1z"></path>
                                                </g>
                                                <g>
                                                    <path d="M356.767,209.461c-6.194-0.347-11.917-3.406-15.645-8.361l-63.778-84.759v314.506l162.716-31.602V214.131L356.767,209.461    z"></path>
                                                </g>
                                                <g>
                                                    <polygon points="447.804,101.376 303.61,81.218 312.862,93.515 368.885,167.969 427.28,171.243 512,175.993   "></polygon>
                                                </g>
                                                <g>
                                                    <polygon points="63.129,101.373 0,176.025 85.299,171.242 143.69,167.969 199.713,93.519 209.018,81.152   "></polygon>
                                                </g>
                                            </svg>
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

                                        <div class="icons user tooltip_shows">
                                            <a onclick="users()" href="javascript:;">
                                                <svg version="1.0" xmlns="http://www.w3.org/2000/svg" height="24px" width="24px" viewBox="0 0 100.000000 100.000000" preserveAspectRatio="xMidYMid meet"><path d="M0 0h24v24H0V0z" fill="none"/><g transform="translate(0.000000,100.000000) scale(0.100000,-0.100000)" fill="#ffffff" stroke="none"><path d="M350 824 c-71 -31 -101 -79 -101 -160 0 -101 63 -164 165 -164 63 0 104 17 135 55 111 142 -35 340 -199 269z"/><path d="M656 517 c-8 -42 -43 -62 -83 -46 -28 11 -30 9 -59 -44 -14 -27 -14 -29 10 -48 33 -26 33 -56 0 -90 l-25 -26 21 -37 c23 -37 30 -40 65 -27 28 11 62 -14 70 -50 6 -27 10 -29 56 -29 45 0 49 2 49 24 0 40 27 59 74 52 38 -6 42 -4 59 25 22 39 22 52 -3 74 -26 23 -25 53 2 82 21 22 21 23 3 63 -19 42 -26 44 -77 25 -20 -8 -58 32 -58 60 0 23 -4 25 -49 25 -47 0 -49 -1 -55 -33z m101 -129 c30 -34 35 -56 18 -87 -25 -50 -91 -57 -124 -15 -28 35 -26 69 4 99 31 32 75 33 102 3z"/><path d="M273 445 c-67 -18 -142 -56 -168 -85 -16 -18 -21 -39 -23 -111 l-4 -89 196 0 c108 0 196 4 196 8 0 4 -9 25 -20 46 -34 69 -36 147 -4 230 5 14 -3 16 -57 15 -35 0 -88 -7 -116 -14z"/></g></svg>
                                            </a>
                                            <div class="top">
                                                <span>User Access Setting</span> 
                                            </div>
                                        </div>

                                        <div class="icons default_back_arrow">
                                            <a href="reports.php?p=1">
                                                <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 0 24 24" width="24px" fill="#000000"><path d="M0 0h24v24H0V0z" fill="none"/><path d="M19 6.41L17.59 5 12 10.59 6.41 5 5 6.41 10.59 12 5 17.59 6.41 19 12 13.41 17.59 19 19 17.59 13.41 12 19 6.41z"/>
                                                </svg>
                                            </a>
                                            
                                        </div>
                                        
                                        <div class="icons back_arrow" style="display: none;">
                                            <a onclick="advancehide()">
                                            <img src="images/back_arrow.png" alt="Back Arrow" />
                                            </a>
                                            
                                        </div>
                                    </div>
                                    
                                        
                                    <div class="upload_content_leftside">
                                        <div class="form-group fields" id="Package-Name" style="">
                                            <label for="selectpage" class="col-form-label">Package Text
                                                <div class="tooltip_shows">
                                                    <i class="fa fa-question-circle" aria-hidden="true"></i>
                                                    <div class="top">
                                                        <span>Package Text</span> 
                                                    </div>
                                                </div>
                                            </label>
                                            <div class="custom-file">
                                                <input type="text" placeholder="Enter Package Name" name="Package_Name" id="Package_Name">
                                            </div>
                                            <label id="pnerror" style="color: red; display: none;"></label>
                                        </div>
                                        <div class="form-group fields links" id="Package-Links" style="">
                                            <label for="selectpage" class="col-form-label">Links:
                                                <div class="tooltip_shows">
                                                    <i class="fa fa-question-circle" aria-hidden="true"></i>
                                                    <div class="top">
                                                        <span>Links</span> 
                                                    </div>
                                                </div>
                                            </label>
                                            
                                            <div class="custom-file">
                                                <?php
                                                $sql = "Select * from sentfile where added_by = '" . $_SESSION["user"] . "' ORDER BY file_name ASC";
                                                $result = mysqli_query($con,$sql);
                                                $i = 0;
                                                if (mysqli_num_rows($result) > 0) { 
                                                    while($fetch_data = mysqli_fetch_array($result)){
                                                        $i++;
                                                ?>
                                                        <div class="form-check">
                                                            <input class="form-check-input" type="checkbox" name="file_list[]" value="<?php echo $fetch_data["file_id"];?>" id="file_<?php echo $i;?>">
                                                            <label class="form-check-label" for="file_<?php echo $i;?>">
                                                                <?php 
                                                                    $imgurl = str_replace('contentshare.me', 'shareio.com', $fetch_data['file_thumbnail']); 
                                                                    if($fetch_data['file_type'] == 'video/mp4' || $file_data['file_type'] == 'video/webm'){
                                                                ?>
                                                                <div class="package thumb_preview" data-url="<?php echo $fetch_data['file_url'];?>#t=5" data-type="video">
                                                                    <?php echo $fetch_data['file_name'];?>
                                                                </div>
                                                                <?php }else{ ?>
                                                                <div class="package thumb_preview" data-url="<?php echo $imgurl;?>" data-type="image">
                                                                    <?php echo $fetch_data['file_name'];?>
                                                                </div>
                                                                <?php } ?>
                                                            </label>
                                                        </div>
                                                <?php
                                                    }
                                                }
                                                ?>
                                            </div>
                                            <label id="errorlink" style="color: red;"></label>
                                        </div>

                                            
                                        <a id="view_package" class="view_package" href="reports.php?p=1">View Packages</a>    
                                    </div>
                                    <div class="upload_content_rightside">
                                            <!-- /widget-header -->            
                                            <div class="upload-contents">
                                                <div class="upload_content_form upload_content_form1">
                                                    <div class="upload-content">
                                                            <div class="form-row">
                                                                <div class="evprunclock form-group">
                                                                    <input type="hidden" name ="fileurl" id = "fileurl">
                                                                    <label for="selectpage" class="col-form-label">Evaluation
                                                                        <div class="tooltip_shows">
                                                                            <i class="fa fa-question-circle" aria-hidden="true"></i>
                                                                            <div class="top">
                                                                                <span>Evaluation type for showing content</span> 
                                                                            </div>
                                                                        </div>
                                                                    </label>
                                                                    <div class="select_box">
                                                                        <select name="evaluation_type" id="evaluation_type">
                                                                            <?php 
                                                                            $e_date_id = '';
                                                                            $evaluation = "SELECT * FROM `tbl_evaluation`"; 
                                                                            $result = mysqli_query($con,$evaluation); 
                                                                            while ($row = mysqli_fetch_array($result)) { 
                                                                            if($row['evaluation_name'] == 'Date' || $row['evaluation_name'] == 'date'){
                                                                            $e_date_id = $row['evaluation_id'];
                                                                            }
                                                                            ?>                                 
                                                                            <option value="<?php echo $row['evaluation_id'];?>">
                                                                            <?php echo $row['evaluation_name'];?>
                                                                            </option>
                                                                            <?php } ?>                             
                                                                        </select>
                                                                    </div>
                                                                </div>
                                                                <div class="evpageqty form-group evaluation_setting">
                                                                    <label class="col-form-label">Setting
                                                                        <div class="tooltip_shows">
                                                                            <i class="fa fa-question-circle" aria-hidden="true"></i>
                                                                            <div class="top">
                                                                                <span>Evaluation settings</span> 
                                                                            </div>
                                                                        </div>
                                                                    </label>
                                                                    <input class="form-control" id="evaluation_value" type="text" name="evaluation_value">
                                                                    <input class="form-control" id="evaluation_date" type="date" name="evaluation_date" style="display: none;">
                                                                    <label id="errorevl" style="color: red; display: none;"></label>
                                                                </div>									                     
                                                            </div>
                                                            <div class="form-row">
                                                                <div class="evprunclock form-group price_field">
                                                                    <label for="selectpage" class="col-form-label">Price ($)
                                                                        <div class="tooltip_shows">
                                                                            <i class="fa fa-question-circle" aria-hidden="true"></i>
                                                                            <div class="top">
                                                                                <span>Price to purchase the content</span> 
                                                                            </div>
                                                                        </div>
                                                                    </label>
                                                                    <input type="text" id="price" name="price" class="form-control" value="1">
                                                                    <label id="error" style="color: red; display: none;"></label>
                                                                </div>
                                                                <div class="evprunclock form-group">
                                                                    <label for="selectpage" class="col-form-label">Subscription
                                                                        <div class="tooltip_shows">
                                                                            <i class="fa fa-question-circle" aria-hidden="true"></i>
                                                                            <div class="top">
                                                                                <span>Evaluation type for showing content</span> 
                                                                            </div>
                                                                        </div>
                                                                    </label>
                                                                    <div class="select_box">
                                                                        <select name="subscription_type" id="subscription_type">
                                                                            <option value="Day">Day</option>
                                                                            <option value="Week">Week</option>
                                                                            <option value="Month">Month</option>
                                                                            <option value="Year">Year</option>
                                                                            <option value="None">None</option>
                                                                        </select>
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <div class="form-row" style="display:none;">
                                                                <div class="col-half form-group">
                                                                    <label for="selectpage" class="col-form-label">Watermark
                                                                        <div class="tooltip_shows">
                                                                            <i class="fa fa-question-circle" aria-hidden="true"></i>
                                                                            <div class="top">
                                                                                <span>Watermark overlay on your content</span> 
                                                                            </div>
                                                                        </div>
                                                                    </label>
                                                                    <div class="select_box">
                                                                        <select class="form-control select2" data-toggle="select2" id="w_type" name="w_type">
                                                                            <option value="None" selected>None</option>
                                                                            <option value="Text">Text</option>
                                                                            <option value="Image">Image</option>
                                                                        </select>
                                                                    </div>
                                                                </div>
                                                                <div class="col-half form-group watermark" id="None">

                                                                </div>
                                                                <div class="col-half form-group watermark" id="Text" style="display: none">
                                                                    <label for="selectpage" class="col-form-label">Watermark Text
                                                                        <div class="tooltip_shows">
                                                                            <i class="fa fa-question-circle" aria-hidden="true"></i>
                                                                            <div class="top">
                                                                                <span>Watermark text or image overlayed over your content</span> 
                                                                            </div>
                                                                        </div>
                                                                    </label>
                                                                    <div class="custom-file">
                                                                        <input type="text" id="watermark_text" name="watermark_text" placeholder="Enter Text">
                                                                    </div>
                                                                </div>
                                                                <div class="col-half form-group watermark" id="Image" style="display: none">
                                                                    <label for="selectpage" class="col-form-label">Watermark Image
                                                                        <div class="tooltip_shows">
                                                                            <i class="fa fa-question-circle" aria-hidden="true"></i>
                                                                            <div class="top">
                                                                                <span>Watermark text or image overlayed over your content</span> 
                                                                            </div>
                                                                        </div>
                                                                    </label>
                                                                    <div class="custom-file">
                                                                        <input type="text" class="custom-file-input" id="file" name="file">
                                                                        <label class="custom-file-label label-watermark" for="inputGroupFile01">Browse</label>
                                                                    </div>
                                                                </div>
                                                                <label id="errorw" style="color: red;"></label>									                     
                                                            </div>
                                                        
                                                    </div>
                                                </div>

                                                <div class="upload_content_form upload_content_form2" style="display: none;">
                                                    <div class="upload-content">
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
                                                                        <option value="1" selected>Yes</option>
                                                                        <option value="0">No</option>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                            <div class="form-group notification_field">
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
                                                                        <option value="1">Yes</option>
                                                                        <option value="0" selected>No</option>
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
                                                                        <option value="1">Yes</option>
                                                                        <option value="0" selected>No</option>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                            <div class="form-group hide_banner">
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
                                                                        <option value="1">Yes</option>
                                                                        <option value="0" selected>No</option>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="form-row password_dns">
                                                            <div class="form-group password_field">
                                                                <label class="col-form-label">Password
                                                                    <div class="tooltip_shows">
                                                                        <i class="fa fa-question-circle" aria-hidden="true"></i>
                                                                        <div class="top">
                                                                            <span>Require password shared content can be opened</span> 
                                                                        </div>
                                                                    </div>
                                                                </label>
                                                                <input type="password" class="form-control" name="password">
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
                                                                <input type="text" class="form-control" name="ip_dns">
                                                            </div>
                                                        </div>
                                                </div>
                                                </div>
                                                
                                                <div class="upload_content_form upload_content_form3" style="display: none;">
                                                    <div class="upload-content"> 
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
                                                                <!-- <select id="block_country" size="16" aria-label="size 3 select example"></select> -->
                                                                <div class="multiselect_sortable_content">
                                                                    <div class="selection">
                                                                        <ul class="selection_content sortable">
                                                                            <!-- ${selection} -->
                                                                        </ul>
                                                                    </div>
                                                                </div>
                                                            </div> 
                                                            <div id="block_country_db"></div>
                                                    </div>


                                                </div>
                                                </div>

                                                 <div class="upload_content_form upload_content_form4" style="display: none;">
                                                    <div class="upload_content_bg"> 
                                                        <div class="form-group user_list_field select_user_type_class">
                                                            <select class="form-control" name="select_user_type" id="select_user_type">
                                                                <option value="member" selected>Users</option>
                                                                <option value="group">Groups</option>
                                                            </select> 
                                                        </div>
                                                        <div class="member_list_setting">
                                                            <div class="upload_content_form4_leftside">
                                                                <div class="view_user_title form-group user_list_field user_list_search">
                                                                    <label>Users : </label>
                                                                    <input type="text" id="search" class="form-control" placeholder="Search">
                                                                </div>
                                                                <div class="list_user">
                                                                    <div class="user_viewer_list">
                                                                          <ul id="view_user_list">
                                                                          <?php
                                                                          $userlistsql = "SELECT * FROM `cs_member` WHERE cs_member.added_by = '".$_SESSION['user']."' ORDER BY member_email ASC";
                                                                          $userlistresult = mysqli_query($con,$userlistsql);
                                                                          while($userlist_data = mysqli_fetch_array($userlistresult)){ 
                                                                                if($userlist_data['relation_id'] == ''){
                                                                            ?>
                                                                            <li data-id="<?php echo $userlist_data['cs_member_id'];?>">
                                                                              <input type="checkbox" name="viewer_list[]" value="<?php echo $userlist_data['cs_member_id'];?>"> 
                                                                              <span>
                                                                                <?php echo $userlist_data['member_email'];?>
                                                                              </span>
                                                                            </li>
                                                                          <?php }
                                                                            }
                                                                          ?> 
                                                                          </ul>
                                                                    </div>
                                                                </div> 
                                                            </div>

                                                            <div class="upload_content_form4_middleside user_section_content_middle">
                                                                <a class="user_item_select_right_arrow"><i class="fa fa-angle-right"></i></a>
                                                                <a class="user_item_select_left_arrow"><i class="fa fa-angle-left"></i></a>
                                                            </div>

                                                           <div class="upload_content_form4_rightside">
                                                            <div class="view_activated_user_title"><span>Activated Users</span></div>
                                                                <div class="activated_user activated_viewer_list">
                                                                    <ul id="view_activated_user_list"></ul>
                                                                </div> 
                                                           </div>
                                                       </div>
                                                       <div class="group_list_setting" style="display: none;">
                                                        <div class="upload_content_form4_leftside">
                                                            <div class="view_group_title form-group group_list_field group_list_search">
                                                                <label>Groups : </label>
                                                                <input type="text" id="group-search" class="form-control" placeholder="Search">
                                                            </div>
                                                            <div class="list_user">
                                                                <div class="user_viewer_list">
                                                                      <ul id="group_user_list">
                                                                      <?php
                                                                      $grouplistsql = "SELECT * FROM `cs_groups` WHERE added_by = '".$_SESSION['user']."' ORDER BY group_name ASC";
                                                                      $grouplistresult = mysqli_query($con,$grouplistsql);
                                                                      while($grouplist_data = mysqli_fetch_array($grouplistresult)){ 
                                                                        ?>
                                                                        <li data-id="<?php echo $grouplist_data['group_id'];?>">
                                                                          <input type="checkbox" name="group_viewer_list[]" value="<?php echo $grouplist_data['group_id'];?>"> 
                                                                          <span>
                                                                            <?php echo $grouplist_data['group_name'];?>
                                                                          </span>
                                                                        </li>
                                                                      <?php 
                                                                        }
                                                                      ?> 
                                                                      </ul>
                                                                </div>
                                                            </div> 
                                                        </div>

                                                        <div class="upload_content_form4_middleside user_section_content_middle">
                                                            <a class="group_item_select_right_arrow"><i class="fa fa-angle-right"></i></a>
                                                            <a class="group_item_select_left_arrow"><i class="fa fa-angle-left"></i></a>
                                                        </div>

                                                        <div class="upload_content_form4_rightside">
                                                            <div class="view_activated_group_title"><span>Activated Groups</span></div>
                                                            <div class="activated_group activated_group_list">
                                                                <ul id="view_activated_group_list"></ul>
                                                            </div> 
                                                        </div>
                                                    </div>
                                                   </div>
                                                </div>

                                                <div class="forms_icons">
                                                    <div class="text-center processbutton tooltip_shows">
                                                        <button type="submit" id="submit" onclick="displayResult()">
                                                            <svg xmlns="http://www.w3.org/2000/svg" version="1.2" viewBox="0 0 18 18" width="18" height="18">
                                                                <path id="Layer" class="s0" d="m-3-3h24v24h-24z"/>
                                                                <path id="Layer" fill-rule="evenodd" class="s1" d="m18 4v12c0 1.1-0.9 2-2 2h-14c-1.1 0-2-0.9-2-2v-14c0-1.1 0.9-2 2-2h12zm-6 9c0-1.7-1.3-3-3-3c-1.7 0-3 1.3-3 3c0 1.7 1.3 3 3 3c1.7 0 3-1.3 3-3zm0-11h-10v4h10z"/>
                                                            </svg>
                                                        </button>
                                                        <div class="left">
                                                            <span>Save package</span>
                                                        </div>
                                                    </div>
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
<script>

	jQuery(document).ready(function($){
	    $( ".main_content" ).removeClass("hidden");
	});
	
    var file_list = '0';
    $('#subscription_type').on('change', function(){
        var type = $(this).val();
        if(type == 'None'){
            $('#price').prop('disabled', true);
            $('#price').css('background', '#ccc');
            $('#price').val('0');
        } else{
            $('#price').prop('disabled', false);
            $('#price').removeAttr('style');
            $('#price').val('1');
        }
    });
    
	function university_icon(){
	    $(".stripe_inner_containt").show();
	    $(".user_content_change").hide();
	     $(".dashboard_icon a").removeClass("active");
	     $(".university_icon a").addClass("active");
	}
	
	function dashboard_icon(){
	    $(".stripe_inner_containt").hide();
	    $(".user_content_change").show();
	    $(".dashboard_icon a").addClass("active");
	    $(".university_icon a").removeClass("active");
	}

    $(document).on('change', "input[name='file_list[]']", function() {
        if ($("input[type='checkbox'][name='file_list[]']:checked").length){
             file_list = $("input[type='checkbox'][name='file_list[]']:checked").length;
        }
    });

    function validateForm() {
        var Package_Name = document.forms["uploadFormcontent"]["Package_Name"].value;
        var price = document.forms["uploadFormcontent"]["price"].value;
        var subscription_type = document.forms["uploadFormcontent"]["subscription_type"].value;
        var w_type = document.forms["uploadFormcontent"]["w_type"].value;
        var evaluation_type = document.forms["uploadFormcontent"]["evaluation_type"].value;
        var error = document.getElementById("error");
        var errorlink = document.getElementById("errorlink");
        var pnerror = document.getElementById("pnerror");
        var errorfile = document.getElementById("errorfile");
        var errorw = document.getElementById("errorw");
        var errorevl = document.getElementById("errorevl");
        
        if (Package_Name == "") {
            pnerror.style.display = "block";
            pnerror.innerHTML =  
                "Please enter Package Name.";
            return false;
        }else {
            pnerror.innerHTML =  
                "";
        }

        if (file_list > 0){
            errorlink.innerHTML =  
            "";
        } else{
            errorlink.innerHTML =  
            "Please Select Link.";
            return false;
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

        if(subscription_type == 'None'){

        } else{
            if (price == "") {
                error.style.display = "block";
                error.innerHTML =  
                "Please enter Package price.";
                return false;
            }else {
                error.innerHTML =  
                "";
            }
        }

        if (w_type == "None") {
        
        } else{
            if (w_type == "Text") {
                var watermark_text = document.forms["uploadFormcontent"]["watermark_text"].value;
                if (watermark_text == "") {
                errorw.innerHTML =  
                    "Please enter watermark.";
                return false;
                }
            } else{
                var file = document.forms["uploadFormcontent"]["file"].value;
                if (file == "") {
                errorw.innerHTML =  
                    "Please select watermark file.";
                return false;
                }
            }
        }

        //displayResult();
        
    }
    

</script>
<script>

    $('#w_type').change(function(){
        $('.watermark').hide();
        var id = $(this).val();
        $('#'+id).show();
    });

    $('#file').change(function(e){
        var fileName = e.target.files[0].name;
        if(fileName != ''){
            $('.label-watermark').html(fileName);
        }
    });
    
	
</script>
<script type = "text/javascript" >
      
   $('#evaluation_type').change(function () {
   var id = "10";
   if ($('#evaluation_type').val() === id) {
   	$('#evaluation_value').hide();
   	$('#evaluation_date').show();
   } else {
   	$('#evaluation_value').show();
   	$('#evaluation_date').hide();
   }
   if ($('#evaluation_type').val() == '14') {
   	$('#evaluation_value').hide();
   }
   }); 

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
          $('.upload_content_rightside').removeClass('advance_setting');
          $('.upload_content_rightside').removeClass('users_advance_setting');
    }

    function countries(){
          $('.upload_content_form3').show();
          $('.upload_content_form1').hide();
          $('.upload_content_form2').hide();
          $('.upload_content_form4').hide();
          $('.upload_content_leftside').hide();
          $('.upload-contents .forms_icons').hide();
          $('.upload_content_rightside').addClass('countries_advance_setting');
          $('.upload_content_rightside').removeClass('advance_setting');
          $('.upload_content_rightside').removeClass('users_advance_setting');
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
</script>
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
              ('*[data-type="remove"]').attr('data-type', '');
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
                $('.upload_content_form4_rightside').append(html);
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
</script>

<script type="text/javascript">

    $(document).ready(function() {
      ShowImagePreview();
    });
    // Configuration of the x and y offsets
    function ShowImagePreview() {
    xOffset = -20;
    yOffset = 40;

    $(".package.thumb_preview").hover(function(e) {
        var url = $(this).data('url');
        var type = $(this).data('type');
        if(type == 'video'){
            $("body").append("<p id='preview'><video src='"+url+"' style='width:100%;height:100%'></video></p>");
        } else{
            $("body").append("<p id='preview'><img src='"+url+"' alt='Image preview' style='width:100%;height:100%' /></p>");
        }
        
        var left = getLeft(e,$(this));
        var top = getTop(e,$(this));

        $("#preview")
        .css("top", (top) + "px")
        .css("left", (left) + "px")
        .fadeIn("slow");
    },
    function() {
        $("#preview").remove();
    });

    $("a.preview").mousemove(function(e) {

        var left = getLeft(e,$(this));
        var top = getTop(e,$(this));

        $("#preview")
        .css("top", (top) + "px")
        .css("left", (left) + "px");
        });

    };

    function getLeft(e,obj){
        var left = e.pageX + yOffset;
        var prevWidth = $("#preview").width();
        if((left+prevWidth +50) > $(document).width())
        {
            left = $(obj).offset().left - yOffset - prevWidth;
        }
        return left;
    }

    function getTop(e,obj){
        var top = e.pageY - xOffset;
        var prevHeigth = $("#preview").height();
        if((top+prevHeigth +50) > $(document).height())
        {
            top = $(obj).offset().top - xOffset - prevHeigth;
        }
        return top;
    }
</script>
</html>