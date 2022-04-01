<?php 
ini_set('error_reporting', 0);
require('./include/db.php');
require('./include/inc/defined_variables.php');
if(!class_exists('S3'))require('./include/S3Bucket_config.php');
require('./Aws-api/aws-autoloader.php');
session_start();

use Aws\S3\S3Client;  
use Aws\Exception\AwsException;
?>
<html lang="en">
<title>Edit Share - ShareIO</title>
<?php require('head.php');
require_once './vendor/stripe/stripe-php/init.php'; 
\Stripe\Stripe::setApiKey('sk_test_ZHBPscwQ2uvawFY7Fq1E3DAC');
?>

<?php require('header-new.php'); ?>   

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

   <!-- /navbar -->
<main>
   <div class="container new_container">
      <div class="row">
         <div class="col-md-12">
            <?php if (isset($_SESSION['succsessmsg'])){ ?>  
            <input type="hidden" id="succsessmsg" name="succsessmsg" value="<?php echo $_SESSION['succsessmsg'];?>">
              <script>
                jQuery(document).ready(function($) {
                  var msg = $('#succsessmsg').val();
                  if(msg != ''){
                      cuteAlert({
                          type: "success",
                          title: "Thank You !",
                          message: "Settings saved your content can now be shared.",
                          buttonText: "Close"
                      })
                      }
                    });
              </script>
            <?php 
               unset($_SESSION['succsessmsg']);
               }
               if(isset($_SESSION['error'])){ ?>
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
            <?php
            function setInterval($f, $milliseconds)
            {
               $seconds=(int)$milliseconds/1000;
               while(true)
               {
                  $f();
                  sleep($seconds);
               }
            }
            ?>
   
              
 
              <div class="main_content hidden">
                <div class="submit-action loader" style="display: none;"></div>
               <div id="edit-qr-modal" class="modal fade" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                  <div class="modal-dialog modal-dialog-centered">

                  <!-- Modal content-->
                    <div class="modal-content">
                      <div class="modal-header">
                        <h4 class="modal-title">ShareIO</h4>
                        <button type="button" class="close" data-dismiss="modal">×</button>
                      </div>
                      <div class="modal-body">
                        <div class="container-fluid" id="contentshare-model-popup">

                        </div>
                      </div>
                    </div>
                  </div>
               </div>

              
               <div class="alert alert-success" id="copyurl" style="display: none;">
                   <a href="#" class="close" data-dismiss="alert">&times;</a>
                   <strong>Link Copied to clipboard...!</strong> 
               </div>
               <div class="upload_content_bg"> 
                  <div class="top_default_icons">
                        <div class="icons description_icon tooltip_shows">
                            <a onclick="descritpion_icon()" href="javascript:;">
                               <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 0 24 24" width="24px" fill="#000000"><path d="M0 0h24v24H0V0z" fill="none"/><path d="M8 16h8v2H8zm0-4h8v2H8zm6-10H6c-1.1 0-2 .9-2 2v16c0 1.1.89 2 1.99 2H18c1.1 0 2-.9 2-2V8l-6-6zm4 18H6V4h7v5h5v11z"/>
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
                            <a href="reports.php">
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
                     <button class="close-button" aria-label="Close alert" type="button">
                        <span aria-hidden="true">&times;</span>
                     </button>
                     <form id="uploadForm" action="test.php" enctype="multipart/form-data" style="display: none;">
                        <div style="clear:both" id="viewer-file">
                        </div>
                        <div class="form-group files" id="file_upload" >
                           <img src="images/file_upload.png" alt="File upload" />
                           <label>Click or drag file to upload </label>
                           <input type="file" name="file" id="fileInput">
                        </div>
                        <label id="errorfile" style="color: red;"></label> 
                        <div id="container" style="display: none;"></div>
                     </form>
                     <div class="loader-content" style="display: none;z-index:10;"></div>
                     <div class="progress" style="display: none;">
                        <div class="progress-bar" style="background-color: #1ada1a;"></div>
                     </div>
                    <!--  <div id="uploadStatus"></div> -->
                     <?php
                     	$id = $_GET['id'];
                        $file = "SELECT * FROM `sentfile` where file_id = '".$_GET['id']."'";

                        $results = mysqli_query($con,$file);

                        $filedata = mysqli_fetch_array($results);

                        if($filedata['added_by'] != $_SESSION["user"]){ ?>
                        <script>
                           window.location = "dashboard.php";
                        </script>
                        <?php
                         exit;
                        }

                        $type = $filedata['file_type'];

                        $fileurl = $filedata['file_url'];?>

                       <div class="view-content" id="view-content">

                          <?php

                             $allowedTypes = array('image/jpeg', 'image/png', 'image/jpg', 'image/gif');

                             $allowedTypesvideo = array('video/mp4');
                             
                             $allowedTypesaudio = array('audio/mp3', 'audio/mpeg');

                             $filetype = $filedata["file_type"]; 

                             if(in_array($filetype, $allowedTypes)){?>

                              <div id="view-remove" class="file-image">

                              </div> 

                              <script>

                                 jQuery(document).ready(function($) {
                                  $('.loader-content').show();
                                  var msg = <?php echo json_encode($fileurl);?>;

                                  if(msg != ''){

                                      $.ajax({

                                          type: "POST",

                                          url: "Image-Zoom/Example/Image.php",

                                          data:{

                                            url:msg

                                          },

                                          success: function(html){ 

                                            $("#view-remove").html(html);
                                            var hide = setInterval(function(){ 
                                             $('.loader-content').hide();
                                             clearInterval(hide);
                                          }, 3000);
                                          }

                                        });

                                    }

                                  });

                               </script>                   

                         <?php }else if(in_array($filetype, $allowedTypesvideo)){ ?>

                              <div id="view-remove" class="file-image">

                                  <video id="myVideo" controls>

                                     <source id="viewer" src="<?php echo $filedata["file_url"];?>">

                                  </video>

                              </div>

                     <?php }else if(in_array($filetype, $allowedTypesaudio)){
                     $s3 = new S3Client([
                            'version' => 'latest',
                            'region'  => AWS_S3_REGION,
                            'credentials' => [
                                'key'    => AWS_S3_KEY,
                                'secret' => AWS_S3_SECRET,
                            ]
                        ]);
                        
                        $key = 'Files/'.$filedata['file_name'];
                        
                        $cmd = $s3->getCommand('GetObject', [
                            'Bucket' => AWS_S3_BUCKET,
                            'Key' => $key
                        ]);
                      
                        $request = $s3->createPresignedRequest($cmd, '+10 seconds');
                    
                    
                     $presignedUrl = (string)$request->getUri();
                     $file_name = basename($filedata['file_url']);
                     file_put_contents($file_name,file_get_contents($presignedUrl));
                     $url = str_replace('contentshare.me', 'shareio.com', $filedata['file_thumbnail']);
                     if($url == '') {
                        $bkc = '#000000';
                     } else {
                        $bkc = 'url('.$url.')';
                     }
                     ?>

                     <div style="clear:both;background:<?php echo $bkc;?>;" id="viewer-file"  class="view-audio">
                        <audio id="myAudio" controls="" name="media">
                           <source id="viewer" src="<?php echo $file_name;?>" type="audio/mpeg">
                        </audio>
                        <!-- <iframe id="viewer" frameborder="0" scrolling="no" width="570" height="300" src="<?php //echo $file_name;?>" sandbox></iframe> -->
                     </div>
                     <script>
                           var unlink = setInterval(function(){ 
                              $.ajax({
                              url: 'file/unlink.php',
                              data: {'link' : "<?php echo '/www/wwwroot/contentshare.me/'.$file_name;?>" },
                              success: function (response) {}
                           });
                           clearInterval(unlink);
                        }, 15000);
                     </script>

                     <?php } else{ 
                    
                     $s3 = new S3Client([
                        'version' => 'latest',
                        'region'  => AWS_S3_REGION,
                        'credentials' => [
                            'key'    => AWS_S3_KEY,
                            'secret' => AWS_S3_SECRET,
                        ]
                    ]);
                    
                    $key = 'Files/'.$filedata['file_name'];
                    
                    $cmd = $s3->getCommand('GetObject', [
                        'Bucket' => AWS_S3_BUCKET,
                        'Key' => $key
                    ]);
                  
                    $request = $s3->createPresignedRequest($cmd, '+10 seconds');
                    
                    
                     $presignedUrl = (string)$request->getUri();
                     $file_name = basename($filedata['file_url']);
                     file_put_contents($file_name,file_get_contents($presignedUrl));
                     ?>

                           <div style="clear:both" id="viewer-file" style="height: auto !important;">
                              
                              <iframe id="viewer" frameborder="0" scrolling="no" width="570" height="300" src="<?php echo $file_name;?>" ></iframe>

                           </div>
                           <script>
                               var unlink = setInterval(function(){ 
                                  $.ajax({
                                  url: 'file/unlink.php',
                                  data: {'link' : "<?php echo '/www/wwwroot/contentshare.me/'.$file_name;?>" },
                                  success: function (response) {
                                    
                                  }
                                });
                                clearInterval(unlink);
                              }, 15000);
                           </script>
                    <?php 
                     } ?>

                     </div>

                  </div>

                  <div class="upload_content_rightside">

                     <form method="post" id="uploadFormcontent" name="uploadFormcontent" action="include/updatefile.php" enctype="multipart/form-data">
                        <div class="widget">
                           <!-- /widget-header -->
                           <div class="upload-contents">
                              <div class="upload_content_form upload_content_form1">
                                 <div class="upload-content">
                                    <div class="form-row form-row1">
                                       <div class="evprunclock form-group">
                                          <input type="hidden" name ="file_id" id = "file_id" value="<?php echo $_GET['id'];?>">
                                          <input type="hidden" name ="fileurl" id = "fileurl">
                                          <input type="hidden" name="type" id="type" value="<?php echo $filedata['file_type'];?>">
                                          <input type="hidden" name="filename" id="filename" value="<?php echo $filedata['file_name'];?>">
                                          <input type="hidden" name="file_url" id="file_url" value="<?php echo $filedata['file_url'];?>">
                                          <label for="selectpage" class="col-form-label">Evaluation
                                             <div class="tooltip_shows">
                                                <i class="fa fa-question-circle" aria-hidden="true"></i>
                                                <div class="top">
                                                   <span>Evaluation type for showing content</span> 
                                                </div>
                                             </div>
                                          </label>
                                          <input type="hidden" id="file_type" name="file_type" class="form-control" value="<?php echo $filedata['file_type'];?>">
                                          <div class="select_box">
                                             <select name="evaluation_type" id="evaluation_type">
                                                <?php

                                                   $e_date_id = '';

                                                   $e_type = $filedata['evalution_type']; 

                                                   $evaluation = "SELECT * FROM `tbl_evaluation`";

                                                   $result = mysqli_query($con,$evaluation);

                                                   while ($row = mysqli_fetch_array($result)) {

                                                   if($row['evaluation_name'] == 'Date' || $row['evaluation_name'] == 'date'){

                                                   $e_date_id = $row['evaluation_id'];

                                                   }

                                                   ?>

                                                <option value="<?php echo $row['evaluation_id'];?>" <?php if($filedata['evalution_type'] == $row['evaluation_id']){?> selected="selected" <?php }?>><?php echo $row['evaluation_name'];?></option>

                                                <?php }?>

                                             </select>
                                          </div>

                                       </div>

                                       <div class="evpageqty form-group">

                                          <a class="btn" onclick="videoduration()" id="getduration" style="display: none">Get Duration</a>
                                          <label class="col-form-label">Setting
                                             <div class="tooltip_shows">
                                                <i class="fa fa-question-circle" aria-hidden="true"></i>
                                                <div class="top">
                                                   <span>Evaluation settings</span> 
                                                </div>
                                             </div>
                                          </label>
                                          <input class="form-control" id="number" type="hidden" name="number" value="<?php echo $filedata['file_length'];?>">

                                          <?php if($filedata['evalution_value'] == 0 && $filedata['evalution_date'] != ''){ 

                                             ?>

                                          <input class="form-control" id="evaluation_date" type="date" name="evaluation_date" value="<?php echo $filedata['evalution_date'];?>">

                                          <input class="form-control" id="evaluation_value" type="text" name="evaluation_value" max="100" value="<?php echo $filedata['evalution_value'];?>" style="display: none;">

                                          <?php } else{ ?>

                                          <input class="form-control" id="evaluation_value" type="text" name="evaluation_value" value="<?php echo $filedata['evalution_value'];?>" <?php if($filedata['evalution_type'] == '14'){ ?> style="display: none;" <?php }?>>

                                          <input class="form-control" id="evaluation_date" type="date" name="evaluation_date" max="100" style="display: none;">

                                          <?php }?>

                                       </div>

                                       <div class="evprunclock form-group price_field">
                                          <label for="selectpage" class="col-form-label">Price ($) 
                                             <div class="tooltip_shows">
                                                <i class="fa fa-question-circle" aria-hidden="true"></i>
                                                <div class="top">
                                                   <span>Price to purchase the content</span> 
                                                </div>
                                             </div>
                                          </label>
                                          <input type="text" id="price" name="price" class="form-control" value="<?php echo $filedata['file_price'];?>">
                                       </div>
                                       <label id="error" style="color: red; display: none;"></label>

                                    </div>

                                   

                                    <div class="form-row">

                                       <div class="col-half form-group watermark_info">

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

                                                <option value="None" <?php if($filedata['watermark_type'] == 'None'){?> selected="selected" <?php }?>>None</option>

                                                <option value="Text" <?php if($filedata['watermark_type'] == 'Text'){?> selected="selected" <?php }?>>Text</option>

                                                <option value="Image" <?php if($filedata['watermark_type'] == 'Image'){?> selected="selected" <?php }?>>Image</option>

                                             </select>
                                          </div>

                                       </div>

                                       <?php if($filedata['watermark_type'] == 'None'){?>

                                       <!-- <div class="col-half form-group watermark" id="None">

                                       </div> -->

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

                                             <input type="text" id="watermark_text" name="watermark_text" value="<?php echo $filedata['watermark_text'];?>">

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

                                             <?php if($filedata['watermark_image'] != ''){ ?>

                                             <img src="<?php echo $filedata['watermark_image'];?>">

                                             <?php }?>

                                             <input type="file" class="custom-file-input" id="file" name="file">

                                             <input type="hidden" name="watermark_image" value="<?php echo $filedata['watermark_image'];?>">

                                             <label class="custom-file-label label-watermark" for="inputGroupFile01">Browse</label>

                                          </div>

                                       </div>



                                       <?php } elseif($filedata['watermark_type'] == 'Text'){?>

                                       <div class="col-half form-group watermark" id="None" style="display: none">

                                       </div>

                                       <div class="col-half form-group watermark" id="Text">

                                          <label for="selectpage" class="col-form-label">Watermark Text
                                             <div class="tooltip_shows">
                                                <i class="fa fa-question-circle" aria-hidden="true"></i>
                                                <div class="top">
                                                   <span>Watermark text or image overlayed over your content</span> 
                                                </div>
                                             </div>

                                          </label>

                                          <div class="custom-file">

                                             <input type="text" id="watermark_text" name="watermark_text" value="<?php echo $filedata['watermark_text'];?>">

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

                                             <?php if($filedata['watermark_image'] != ''){ ?>

                                             <img src="<?php echo $filedata['watermark_image'];?>">

                                             <?php }?>

                                             <input type="file" class="custom-file-input" id="file" name="file">

                                             <input type="hidden" name="watermark_image" value="<?php echo $filedata['watermark_image'];?>">

                                             <label class="custom-file-label label-watermark" for="inputGroupFile01">Browse</label>

                                          </div>

                                       </div>

                                       <?php } else{ ?>

                                       <div class="col-half form-group watermark" id="None" style="display: none">

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

                                             <input type="text" id="watermark_text" name="watermark_text" value="<?php echo $filedata['watermark_text'];?>">

                                          </div>

                                       </div>

                                       <div class="col-half form-group watermark" id="Image">

                                          <label for="selectpage" class="col-form-label">Watermark Image
                                             <div class="tooltip_shows">
                                                <i class="fa fa-question-circle" aria-hidden="true"></i>
                                                <div class="top">
                                                   <span>Watermark text or image overlayed over your content</span> 
                                                </div>
                                             </div>

                                          </label>

                                          <div class="custom-file">

                                             <input type="file" class="custom-file-input" id="file" name="file">

                                             <input type="hidden" name="watermark_image" value="<?php echo $filedata['watermark_image'];?>">

                                             <label class="custom-file-label label-watermark" for="inputGroupFile01">Browse</label>

                                          </div>

                                       </div>

                                       <?php }?>

                                       <label id="errorw" style="color: red; display: none;"></label>

                                    </div>

                                    <div class="watermark_image_show" id="watermark_image_show" style="margin: 10px;">

                                       <?php if($filedata['watermark_image'] != ''){ ?>

                                       <label for="selectpage" class="col-form-label">Uploaded Watermark Image:</label>

                                       <img src="<?php echo $filedata['watermark_image'];?>" style="width: 50%;">

                                       <?php }?>

                                    </div>

                                   

                                    <div class="form-row">

                                       <div class="col-full form-group fileUpload file_uploadfield">

                                          <label for="selectpage" class="col-form-label">Additional File(s)
                                             <div class="tooltip_shows">
                                                <i class="fa fa-question-circle" aria-hidden="true"></i>
                                                <div class="top">
                                                   <span>Any additional files that are available after purchase</span> 
                                                </div>
                                             </div>

                                          </label>

                                          <div class="custom-file">

                                             <input type="file" class="custom-file-input" id="addfile" aria-describedby="inputGroupFileAddon01" name="addfile">
                                             
                                             <input type="hidden" name="addfileUrl" id="addfileUrl" value="<?php echo $filedata['additional_file_url'];?>">
                    
                                             <label class="custom-file-label label-additional" for="inputGroupFile01">...</label>

                                          </div>
                                          <?php if($filedata['additional_file_url'] != ''){?>
                                          <div class="additional_file_name">
                                             <label><?php echo basename($filedata['additional_file_url']);?></label>
                                             <a href="javascript:;" class="ml-auto" onclick="deleteAddFile()"><i class="fa fa-trash" ></i></a>
                                          </div>
                                          <?php } ?>
                                       </div>

                                    </div>
                                      <div class="form-row">
                                       <div class="col-full form-group fileUpload file_uploadfield">
                                          <label for="selectpage" class="col-form-label">ShareIO URL
                                             <div class="tooltip_shows">
                                                <i class="fa fa-question-circle" aria-hidden="true"></i>
                                                <div class="top">
                                                   <span>URL for the shared content</span> 
                                                </div>
                                             </div>

                                          </label>
                                          <?php
                                          if($filedata['file_type'] == 'audio/mpeg' || $filedata['file_type'] == 'audio/mp3'){
                                          ?>
                                             <input type="text" class="form-control" id="url" value="<?php echo SITE_URL;?>/files/start/<?php echo $filedata['file_hash'];?>" readonly>
                                          <?php } else{?>
                                            <input type="text" class="form-control" id="url" value="<?php echo SITE_URL;?>/file/<?php echo $filedata['file_hash'];?>" readonly>
                                          <?php }?>
                                       </div>
                                    </div>
                                                  							

                                    <div class="form-row success-btn">

                                       <div class="mb-3 loadSuccess">

                                          <div class="loading">Loading</div>

                                          <div class="error-message"></div>

                                          <div class="sent-message">Your message has been sent. Thank you!</div>

                                       </div>
                                     

                                    </div>

                                 </div>
                              </div>
                              <div class="upload_content_form upload_content_form2" style="display: none;">
                                <div class="form-row" style="display: none;">
                                       <div class="col-full form-group fileUpload">
                                          <label for="selectpage" class="col-form-label">ShareIO URL
                                             <div class="tooltip_shows">
                                                <i class="fa fa-question-circle" aria-hidden="true"></i>
                                                <div class="top">
                                                   <span>URL for the shared content</span> 
                                                </div>
                                             </div>
                                          </label>
                                          <?php
                                          if($filedata['file_type'] == 'audio/mpeg' || $filedata['file_type'] == 'audio/mp3'){
                                          ?>
                                             <input type="text" class="form-control" id="url" value="https://shareio.com/files/start/<?php echo $filedata['file_hash'];?>" readonly>
                                          <?php } else{?>
                                            <input type="text" class="form-control" id="url" value="https://shareio.com/file/<?php echo $filedata['file_hash'];?>" readonly>
                                          <?php }?>
                                       </div>
                                    </div>
                                 <div class="upload-content">
                                    <div class="form-row" id="trial_setting">

                                       <?php 

                                             $trial_query = "SELECT * FROM `trial_setting` where fileid = '".$_GET['id']."'";

                                             $trial_result = mysqli_query($con,$trial_query);

                                             $trial_row = mysqli_fetch_array($trial_result);

                                             if($filedata['file_type'] == "application/pdf"){ ?>

                                       <div class="form-group">
                                          <label for="selectpage" class="col-form-label" id="trial_s">Start (page)
                                             <div class="tooltip_shows">
                                                <i class="fa fa-question-circle" aria-hidden="true"></i>
                                                <div class="top">
                                                   <span>Start point of document or video while being evaluated</span> 
                                                </div>
                                             </div>
                                          </label>
                                          <div class="custom-file">
                                             <input type="text" id="trial_start" name="trial_start" value="<?php echo $trial_row['page_start'];?>">
                                          </div>
                                       </div>
                                       <div class="form-group watermark" id="Text">
                                          <label for="selectpage" class="col-form-label" id="trial_e">End (page)
                                             <div class="tooltip_shows">
                                                <i class="fa fa-question-circle" aria-hidden="true"></i>
                                                <div class="top">
                                                   <span>End point of document or video while being evaluated</span> 
                                                </div>
                                             </div>
                                          </label>
                                          <div class="custom-file">
                                             <input type="text" id="trial_end" name="trial_end" value="<?php echo $trial_row['page_end'];?>">
                                          </div>
                                       </div>

                                       <?php } else{ ?>

                                       <div class="form-group">
                                          <label for="selectpage" class="col-form-label" id="trial_s">Start (page)
                                             <div class="tooltip_shows">
                                                <i class="fa fa-question-circle" aria-hidden="true"></i>
                                                <div class="top">
                                                   <span>Start point of document or video while being evaluated</span> 
                                                </div>
                                             </div>
                                          </label>
                                          <div class="custom-file">
                                             <input type="text" id="trial_start" name="trial_start" value="<?php echo $trial_row['t_start'];?>">
                                          </div>
                                       </div>
                                       <div class="form-group">
                                          <label for="selectpage" class="col-form-label" id="trial_e">End (page)
                                             <div class="tooltip_shows">
                                                <i class="fa fa-question-circle" aria-hidden="true"></i>
                                                <div class="top">
                                                   <span>End point of document or video while being evaluated</span> 
                                                </div>
                                             </div>
                                          </label>
                                          <div class="custom-file">
                                             <input type="text" id="trial_end" name="trial_end" value="<?php echo $trial_row['t_end'];?>">
                                          </div>
                                       </div>

                                       <?php }?>

                                    </div>
                                    <div class="form-row">

                                       <div class="form-group">
                                          <label for="selectpage" class="col-form-label">Download
                                             <div class="tooltip_shows">
                                                <i class="fa fa-question-circle" aria-hidden="true"></i>
                                                <div class="top">
                                                   <span>Downloadable after purchase</span> 
                                                </div>
                                             </div>
                                          </label>
                                          <div class="select_box">
                                             <select class="form-control select2" data-toggle="select2" id="download" name="download">
                                                <option value="1" <?php
                                                if ($filedata['download'] == '1') { ?> selected="selected" <?php } ?>>Yes</option>
                                                <option value="0"<?php
                                                if ($filedata['download'] == '0') { ?> selected="selected" <?php } ?>>No</option>
                                             </select>
                                          </div>
                                       </div>

                                       <div class="form-group social_share"> 
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
                                                   if ($filedata['social_share'] == '1') { ?> selected="selected" <?php } ?>>Yes</option>
                                                <option value="0"<?php
                                                   if ($filedata['social_share'] == '0') { ?> selected="selected" <?php } ?>>No</option>
                                             </select>
                                          </div>
                                       </div>

                                       
                                    </div>
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
                                                   if ($filedata['browser_enabled'] == '1') { ?> selected="selected" <?php } ?>>Yes</option>
                                                <option value="0"<?php
                                                   if ($filedata['browser_enabled'] == '0') { ?> selected="selected" <?php } ?>>No</option>
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
                                                <option value="1" <?php
                                                   if ($filedata['notification'] == '1') { ?> selected="selected" <?php } ?>>Yes</option>
                                                <option value="0"<?php
                                                   if ($filedata['notification'] == '0') { ?> selected="selected" <?php } ?>>No</option>
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
                                        <input type="password" class="form-control" autocomplete="new-password" name="password" value="<?php echo $filedata['password'];?>">
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
                                        <input type="text" class="form-control" name="ip_dns" value="<?php echo $filedata['ip_dns'];?>">
                                      </div>
                                    </div>
                                    <div class="form-row">
                                       <div class="form-group">
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
                                                   if ($filedata['hide_banner'] == '1') { ?> selected="selected" <?php } ?>>Yes</option>
                                                <option value="0"<?php
                                                   if ($filedata['hide_banner'] == '0' || $filedata['hide_banner'] == '') { ?> selected="selected" <?php } ?>>No</option>
                                             </select>
                                          </div>
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
                                    <div class="multiselect_sortable_content">
                                       <div class="selection">
                                           <ul class="selection_content sortable">
                                               <?php if(!empty($filedata['block_countries']) && $filedata['block_countries'] != 'null'){  
                                                   $json_array = json_decode($filedata['block_countries'], true);
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
                                        $checkaccesslistsql = "SELECT * FROM `access_list` WHERE file_id = '".$_GET['id']."' AND member_id != ''";
                                        $checkaccesslistresult = mysqli_query($con,$checkaccesslistsql);
                                        $ids = '';
                                        if(mysqli_num_rows($checkaccesslistresult) > 0){
                                          $accessusers = array();
                                          while($checkaccesslist_data = mysqli_fetch_array($checkaccesslistresult)){ 
                                            $accessusers[] = $checkaccesslist_data['member_id'];
                                          }
                                          $ids = implode(',', $accessusers);
                                        }
                                        if($ids == ''){
                                          $ids = "NOT IN('".$ids."')";
                                        } else{
                                          $ids = "NOT IN($ids)";
                                        }
                                        $userlistsql = "SELECT * FROM `cs_member` WHERE FIND_IN_SET('".$_SESSION['user']."',cs_member.added_by) AND cs_member_id $ids ORDER BY member_email ASC";
                                        $userlistresult = mysqli_query($con,$userlistsql);
                                        while($userlist_data = mysqli_fetch_array($userlistresult)){  
                                          ?>
                                          <li data-id="<?php echo $userlist_data['cs_member_id'];?>">
                                            <input type="checkbox" name="viewer_list[]" value="<?php echo $userlist_data['cs_member_id'];?>"> 
                                            <span>
                                              <?php echo $userlist_data['member_email'];?>
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
                                  <a class="user_item_select_right_arrow"><i class="fa fa-angle-right"></i></a>
                                  <a class="user_item_select_left_arrow"><i class="fa fa-angle-left"></i></a>
                                </div>

                                <div class="upload_content_form4_rightside">
                                  <div class="view_activated_user_title"><span>Activated Users</span></div>
                                    <div class="activated_user activated_viewer_list">
                                    <ul id="view_activated_user_list">
                                      <?php
                                      $checkaccesslistsql = "SELECT * FROM `access_list` WHERE file_id = '".$_GET['id']."' AND member_id != ''";
                                      $checkaccesslistresult = mysqli_query($con,$checkaccesslistsql);
                                      $activeids = '';
                                      if(mysqli_num_rows($checkaccesslistresult) > 0){
                                        $accessusers = array();
                                        while($checkaccesslist_data = mysqli_fetch_array($checkaccesslistresult)){ 
                                          $accessusers[] = $checkaccesslist_data['member_id'];
                                        }
                                        $activeids = implode(',', $accessusers);
                                      }
                                      if($activeids == ''){
                                          $activeids = "IN('".$activeids."')";
                                      } else{
                                          $activeids = "IN($activeids)";
                                      }
                                      $activeuserlistsql = "SELECT * FROM `cs_member` WHERE FIND_IN_SET('".$_SESSION['user']."',cs_member.added_by) AND cs_member_id $activeids ORDER BY member_email ASC";
                                      $activeuserlistresult = mysqli_query($con,$activeuserlistsql);
                                      while($activeuserlist_data = mysqli_fetch_array($activeuserlistresult)){  
                                        ?>
                                        <li data-id="<?php echo $activeuserlist_data['cs_member_id'];?>">
                                          <input type="checkbox" name="activated_viewer_list[]" value="<?php echo $activeuserlist_data['cs_member_id'];?>"> 
                                          <span>
                                            <?php echo $activeuserlist_data['member_email'];?>
                                          </span>
                                        </li>
                                      <?php 
                                      }
                                      ?>
                                    </ul>
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
                                      $checkaccesslistsql = "SELECT * FROM `access_list` WHERE file_id = '".$_GET['id']."' AND group_id != ''";
                                      $checkaccesslistresult = mysqli_query($con,$checkaccesslistsql);
                                      $ids = '';
                                      if(mysqli_num_rows($checkaccesslistresult) > 0){
                                        $accessusers = array();
                                        while($checkaccesslist_data = mysqli_fetch_array($checkaccesslistresult)){ 
                                          $accessusers[] = $checkaccesslist_data['group_id'];
                                        }
                                        $ids = implode(',', $accessusers);
                                      }
                                      if($ids == ''){
                                        $ids = "NOT IN('".$ids."')";
                                      } else{
                                        $ids = "NOT IN($ids)";
                                      }
                                      $grouplistsql = "SELECT * FROM `cs_groups` WHERE FIND_IN_SET('".$_SESSION['user']."',added_by) AND group_id $ids ORDER BY group_name ASC";
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
                                    <ul id="view_activated_group_list">
                                      <?php
                                      $groupcheckaccesslistsql = "SELECT * FROM `access_list` WHERE file_id = '".$_GET['id']."' AND group_id != ''";
                                      $groupcheckaccesslistresult = mysqli_query($con,$groupcheckaccesslistsql);
                                      $groupactiveids = '';
                                      if(mysqli_num_rows($groupcheckaccesslistresult) > 0){
                                        $groupaccessusers = array();
                                        while($groupcheckaccesslist_data = mysqli_fetch_array($groupcheckaccesslistresult)){ 
                                          $groupaccessusers[] = $groupcheckaccesslist_data['group_id'];
                                        }
                                        $groupactiveids = implode(',', $groupaccessusers);
                                      }
                                      if($groupactiveids == ''){
                                          $groupactiveids = "IN('".$groupactiveids."')";
                                      } else{
                                          $groupactiveids = "IN($groupactiveids)";
                                      }
                                      $activatedgrouplistsql = "SELECT * FROM `cs_groups` WHERE FIND_IN_SET('".$_SESSION['user']."',added_by) AND group_id $groupactiveids ORDER BY group_name ASC";
                                      $activatedgrouplistresult = mysqli_query($con,$activatedgrouplistsql);
                                      while($activatedgrouplist_data = mysqli_fetch_array($activatedgrouplistresult)){ 
                                        ?>
                                        <li data-id="<?php echo $activatedgrouplist_data['group_id'];?>">
                                          <input type="checkbox" name="activated_group_list[]" value="<?php echo $activatedgrouplist_data['group_id'];?>"> 
                                          <span>
                                            <?php echo $activatedgrouplist_data['group_name'];?>
                                          </span>
                                        </li>
                                      <?php 
                                      }
                                      ?>
                                    </ul>
                                  </div> 
                                </div>
                              </div>
                            </div>
                          </div>

                              <div class="forms_icons">
                                 
                                 <!-- onclick="deletefile(<?php //echo $filedata['file_id'];?>)" -->
                                 <div class="icons delete_items tooltip_shows">
                                    <a href="javascript:;" id="delete-content">
                                       <svg xmlns="http://www.w3.org/2000/svg" fill="#6b6b6b" viewBox="0 0 24 24" width="65" height="65"><path d="M6 19c0 1.1.9 2 2 2h8c1.1 0 2-.9 2-2V7H6v12zM19 4h-3.5l-1-1h-5l-1 1H5v2h14V4z"></path><path d="M0 0h24v24H0z" fill="none"></path>
                                       </svg>
                                    </a>
                                    <div class="left">
                                       <span>Delete share</span>
                                    </div> 
                                 </div>
                                 <div class="icons play_pause_btn tooltip_shows">
                                    <div class="pause-action">
                                       <span>
                                          <input type="radio" id="yes" onclick="paused_icon()" name="paused" value="yes" <?php if($filedata['paused'] == '1'){?> checked <?php } else{?> style="display: none;" <?php }?>>
                                       </span>
                                       <span>
                                          <input type="radio" id="no" name="paused" onclick="play_icon()" value="no" <?php if($filedata['paused'] == '0'){?> checked <?php }else{?> style="display: none;" <?php }?>>
                                       </span>
                                    </div>
                                    <div class="left">
                                       <span>Toggle pause of shared link</span>
                                    </div> 
                                    
                                 </div> 
                                 <div class="icons chart_icon tooltip_shows">
                                    <a href="File-stats.php?id=<?php echo $filedata["file_id"];?>" id="share-stats">
                                       <svg xmlns="http://www.w3.org/2000/svg" width="44px" xmlns:xlink="http://www.w3.org/1999/xlink" fill="#6b6b6b" version="1.1" x="0px" y="0px" viewBox="0 0 1000 1000" enable-background="new 0 0 1000 1000" xml:space="preserve">
                                       <g><g transform="translate(0.000000,511.000000) scale(0.100000,-0.100000)"><path d="M4298.5,4979.9c-114.9-36.3-207.6-100.8-268.1-187.5l-48.4-72.6l-6-4564c-2-3032,2-4590.3,16.1-4640.7c28.2-104.8,169.3-229.8,304.4-270.1c86.7-26.2,219.7-32.3,705.6-32.3c358.8,0,643.1,8.1,703.5,22.2c131,28.2,260.1,125,318.5,239.9l44.4,88.7V111.5v4547.9l-44.4,88.7c-58.4,114.9-187.5,211.7-318.5,239.9C5550.4,5022.3,4409.3,5014.2,4298.5,4979.9z"/><path d="M7882.8,2169.7c-86.7-28.2-209.7-96.8-256-147.2c-112.9-121-106.8,74.6-106.8-3326.3c0-3001.7,2-3134.8,38.3-3213.4c48.4-104.8,167.3-203.6,292.3-239.9c149.2-44.4,1290.2-44.4,1441.4,2c133,38.3,276.2,165.3,304.4,268.1c12.1,46.4,20.2,1153.1,20.2,3197.2c0,2995.7-2,3128.7-38.3,3207.3c-20.2,44.3-72.6,110.9-114.9,145.1c-139.1,116.9-207.7,125-903.2,123C8215.4,2185.8,7911,2177.8,7882.8,2169.7z"/><path d="M702.1-178.8c-125-34.3-233.8-118.9-280.2-221.8c-36.3-78.6-38.3-171.3-38.3-2048.2c0-1262,8.1-1991.7,20.2-2038.1c28.2-102.8,171.4-229.8,304.4-268.1c86.7-26.2,221.8-32.3,723.7-32.3c685.4,0,756,10.1,895.1,125c163.3,135.1,153.2-20.2,153.2,2203.4v1977.6l-44.4,88.7c-52.4,104.8-141.1,169.3-284.2,211.7C2016.4-140.5,849.2-138.5,702.1-178.8z"/></g></g>
                                       </svg>
                                    </a>
                                    <div class="left">
                                       <span>Share stats</span>
                                    </div>
                                 </div>
                                 <?php
                                 $sql = "SELECT * from cs_users where id = '" . $_SESSION["user"] . "' OR oauth_uid =  '" . $_SESSION["user"] . "'";
                                 $result = mysqli_query($con,$sql);
                                 $fetch_data = mysqli_fetch_array($result);
                                 if($fetch_data['impressions'] >= 1){
                                    $stripe = \Stripe\Account::retrieve(
                                      $fetch_data['stripe_acc_id']
                                    );
                                      $status = '';
                                      if($stripe['charges_enabled'] != '1'){
                                        $status = "Disabled"; ?>
                                        <div class="icons qr_icon tooltip_shows">
                                          <a href="javascript:;" class="strip-acc">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="44" xmlns:xlink="http://www.w3.org/1999/xlink" fill="#6b6b6b" version="1.1" x="0px" y="0px" viewBox="0 0 1000 1000" enable-background="new 0 0 1000 1000" xml:space="preserve">
                                             <g><g transform="translate(0.000000,511.000000) scale(0.100000,-0.100000)"><path d="M100,2797.1V584.2h2212.9h2212.9v2212.9V5010H2312.9H100V2797.1z M3577.4,2797.1V1532.6H2312.9H1048.4v1264.5v1264.5h1264.5h1264.5V2797.1z"/><path d="M1680.6,2797.1v-632.3h632.3h632.3v632.3v632.3h-632.3h-632.3V2797.1z"/><path d="M5474.2,2797.1V584.2h2212.9H9900v2212.9V5010H7687.1H5474.2V2797.1z M8951.6,2797.1V1532.6H7687.1H6422.6v1264.5v1264.5h1264.5h1264.5V2797.1z"/><path d="M7054.8,2797.1v-632.3h632.3h632.3v632.3v632.3h-632.3h-632.3V2797.1z"/><path d="M100-2577.1V-4790h2212.9h2212.9v2212.9v2212.9H2312.9H100V-2577.1z M3577.4-2577.1v-1264.5H2312.9H1048.4v1264.5v1264.5h1264.5h1264.5V-2577.1z"/><path d="M1680.6-2577.1v-632.3h632.3h632.3v632.3v632.3h-632.3h-632.3V-2577.1z"/><path d="M5474.2-917.4v-553.2h553.2h553.2v-553.2v-553.2h-553.2h-553.2v-553.2v-553.2h553.2h553.2v-553.2V-4790h553.2h553.2v553.2v553.2h553.2h553.2v-553.2V-4790h553.2H9900v553.2v553.2h-553.2h-553.2v553.2v553.2h553.2H9900v553.2v553.2h-553.2h-553.2v553.2v553.2h-553.2h-553.2v-553.2v-553.2h-553.2h-553.2v553.2v553.2h-553.2h-553.2V-917.4z M8793.5-2023.9v-553.2h-553.2h-553.2v-553.2v-553.2h-553.2h-553.2v553.2v553.2h553.2h553.2v553.2v553.2h553.2h553.2V-2023.9z"/></g></g>
                                             </svg>
                                          </a>
                                          <div class="left">
                                            <span>QR code link to share</span>
                                          </div>
                                        </div>
                                        <div class="icons link_url tooltip_shows social_icons_show_hide">
                                          <a href="javascript:;" class="strip-acc">
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="#6b6b6b" viewBox="0 0 24 24" width="52" fill="#ffffff"><path d="M0 0h24v24H0z" fill="none"></path><path d="M3.9 12c0-1.71 1.39-3.1 3.1-3.1h4V7H7c-2.76 0-5 2.24-5 5s2.24 5 5 5h4v-1.9H7c-1.71 0-3.1-1.39-3.1-3.1zM8 13h8v-2H8v2zm9-6h-4v1.9h4c1.71 0 3.1 1.39 3.1 3.1s-1.39 3.1-3.1 3.1h-4V17h4c2.76 0 5-2.24 5-5s-2.24-5-5-5z"></path></svg>
                                          </a>
                                          <div class="left">
                                            <span>URL to share</span>
                                          </div>
                                        </div>
                                     <?php }else{
                                        $status = "Enabled";?>
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
                                 <div class="socialShare-icons">
                                    <div class="socialCircle-container">
                                       <?php
                                       $url = '';
                                       if($filedata['file_type'] == 'audio/mpeg' || $filedata['file_type'] == 'audio/mp3'){
                                       $url = SITE_URL.'/files/start/'.$filedata['file_hash'];
                                       } else{
                                       $url = SITE_URL.'/file/'.$filedata['file_hash'];
                                       }
                                       ?>
                                       <div class="socialCircle-item socialcircle_facebook"><a href="https://www.facebook.com/sharer/sharer.php?u=<?php echo $url;?>" title="Share by Facebook" target="_blank"><i class="fa fa-facebook"></i></a></div>
                                       <div class="socialCircle-item socialcircle_twitter"><a href="https://twitter.com/share?url=<?php echo $url;?>" title="Share by Twitter" target="_blank"><i class="fa fa-twitter"></i></a></div>
                                       <div class="socialCircle-item socialcircle_email"><a href="mailto:?subject=?&amp;body=<?php echo $url;?>" title="Share by Email"><i class="fa fa-envelope-o"></i></a></div>
                                       <div class="socialCircle-item socialcircle_linkedin"><a href="https://www.linkedin.com/shareArticle?mini=true&url=<?php echo $url;?>&title=ShareIo&source=https://shareio.com" title="Share by LinkedIn" target="_blank"><i class="fa fa-linkedin"></i></a></div>
                                       <div class="socialCircle-item socialcircle_whatsapp"><a href="whatsapp://send?text=<?php echo $url;?>" title="Share by WhatsApp"><i class="fa fa-whatsapp"></i></a></div>
                                       <div class="socialCircle-item socialcircle_clipboard"><a href="javascript:;" onclick="CopyURL()" title="Copy to Clipboard"><i class="fa fa-clipboard" aria-hidden="true"></i></a></div>
                                     </div>
                                    <div class="icons link_url tooltip_shows social_icons_show_hide socialCircle-center closed">
                                       <a href="javascript:;">
                                       <svg xmlns="http://www.w3.org/2000/svg" fill="#6b6b6b" viewBox="0 0 24 24" width="52" fill="#ffffff"><path d="M0 0h24v24H0z" fill="none"></path><path d="M3.9 12c0-1.71 1.39-3.1 3.1-3.1h4V7H7c-2.76 0-5 2.24-5 5s2.24 5 5 5h4v-1.9H7c-1.71 0-3.1-1.39-3.1-3.1zM8 13h8v-2H8v2zm9-6h-4v1.9h4c1.71 0 3.1 1.39 3.1 3.1s-1.39 3.1-3.1 3.1h-4V17h4c2.76 0 5-2.24 5-5s-2.24-5-5-5z"></path></svg>
                                       </a>
                                       <div class="left mobile-left">
                                          <span>URL to share</span>
                                       </div>
                                    </div>
                                 </div>
                                 <?php } 
                                  } else{ ?>
                                    <div class="icons qr_icon tooltip_shows">
                                    <a class="getimp">
                                       <svg xmlns="http://www.w3.org/2000/svg" width="44" xmlns:xlink="http://www.w3.org/1999/xlink" fill="#6b6b6b" version="1.1" x="0px" y="0px" viewBox="0 0 1000 1000" enable-background="new 0 0 1000 1000" xml:space="preserve">
                                       <g><g transform="translate(0.000000,511.000000) scale(0.100000,-0.100000)"><path d="M100,2797.1V584.2h2212.9h2212.9v2212.9V5010H2312.9H100V2797.1z M3577.4,2797.1V1532.6H2312.9H1048.4v1264.5v1264.5h1264.5h1264.5V2797.1z"/><path d="M1680.6,2797.1v-632.3h632.3h632.3v632.3v632.3h-632.3h-632.3V2797.1z"/><path d="M5474.2,2797.1V584.2h2212.9H9900v2212.9V5010H7687.1H5474.2V2797.1z M8951.6,2797.1V1532.6H7687.1H6422.6v1264.5v1264.5h1264.5h1264.5V2797.1z"/><path d="M7054.8,2797.1v-632.3h632.3h632.3v632.3v632.3h-632.3h-632.3V2797.1z"/><path d="M100-2577.1V-4790h2212.9h2212.9v2212.9v2212.9H2312.9H100V-2577.1z M3577.4-2577.1v-1264.5H2312.9H1048.4v1264.5v1264.5h1264.5h1264.5V-2577.1z"/><path d="M1680.6-2577.1v-632.3h632.3h632.3v632.3v632.3h-632.3h-632.3V-2577.1z"/><path d="M5474.2-917.4v-553.2h553.2h553.2v-553.2v-553.2h-553.2h-553.2v-553.2v-553.2h553.2h553.2v-553.2V-4790h553.2h553.2v553.2v553.2h553.2h553.2v-553.2V-4790h553.2H9900v553.2v553.2h-553.2h-553.2v553.2v553.2h553.2H9900v553.2v553.2h-553.2h-553.2v553.2v553.2h-553.2h-553.2v-553.2v-553.2h-553.2h-553.2v553.2v553.2h-553.2h-553.2V-917.4z M8793.5-2023.9v-553.2h-553.2h-553.2v-553.2v-553.2h-553.2h-553.2v553.2v553.2h553.2h553.2v553.2v553.2h553.2h553.2V-2023.9z"/></g></g>
                                       </svg>
                                    </a>
                                    <div class="left">
                                       <span>QR code link to share</span>
                                    </div>
                                 </div>
                                 <div class="icons link_url tooltip_shows social_icons_show_hide">
                                    <a class="getimp">
                                     <svg xmlns="http://www.w3.org/2000/svg" fill="#6b6b6b" viewBox="0 0 24 24" width="52" fill="#ffffff"><path d="M0 0h24v24H0z" fill="none"></path><path d="M3.9 12c0-1.71 1.39-3.1 3.1-3.1h4V7H7c-2.76 0-5 2.24-5 5s2.24 5 5 5h4v-1.9H7c-1.71 0-3.1-1.39-3.1-3.1zM8 13h8v-2H8v2zm9-6h-4v1.9h4c1.71 0 3.1 1.39 3.1 3.1s-1.39 3.1-3.1 3.1h-4V17h4c2.76 0 5-2.24 5-5s-2.24-5-5-5z"></path></svg>
                                    </a>
                                    <div class="left">
                                       <span>URL to share</span>
                                    </div>
                                 </div>
                                  <?php }?>


                                  <div class="text-center processbutton tooltip_shows">
                                    <button type="submit" id="submit" onclick="displayResult()">
                                      
                                      <svg xmlns="http://www.w3.org/2000/svg" version="1.2" viewBox="0 0 18 18" width="18" height="18">
                                              <path id="Layer" class="s0" d="m-3-3h24v24h-24z"/>
                                              <path id="Layer" fill-rule="evenodd" class="s1" d="m18 4v12c0 1.1-0.9 2-2 2h-14c-1.1 0-2-0.9-2-2v-14c0-1.1 0.9-2 2-2h12zm-6 9c0-1.7-1.3-3-3-3c-1.7 0-3 1.3-3 3c0 1.7 1.3 3 3 3c1.7 0 3-1.3 3-3zm0-11h-10v4h10z"/>
                                      </svg>
                                                   
                                    </button>
                                    <div class="left">
                                       <span>Save share</span>
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
      </div>
   </div>


            

   <!-- Le javascript

      ================================================== --> 

   <!-- Placed at the end of the document so the pages load faster --> 
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
  
   loadAccessList();
});
</script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
<script src="https://rawgit.com/kimmobrunfeldt/progressbar.js/1.0.0/dist/progressbar.js"></script>

<script>
    $(".top_default_icons .description_icon a").addClass("active");
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
          //$('.back_arrow').hide();
          //$('.setting').show();
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
    
    function deleteAddFile(){
        $('.additional_file_name').remove();
        $('#addfileUrl').val('');
    }
    
    $('#addfile').change(function(e){
        var fileName = e.target.files[0].name;
        if(fileName != ''){
            $('.label-additional').html(fileName);
            $('.additional_file_name').remove();
            $('#addfileUrl').val('');
        }
    });

    $('#file').change(function(e){
        var fileName = e.target.files[0].name;
        if(fileName != ''){
            $('.label-watermark').html(fileName);
        }
    });
    
    $('.strip-acc').on('click', function(){
        cuteAlert({
            type: "question",
            title: "Activate Stripe Account",
            message: "Your Stripe Account is not activated do you wish to activate your account?",
            confirmText: "Yes",
            cancelText: "Cancel"
        }).then((e)=>{
            if ( e == ("confirm")){
            window.location = "setting.php";
            }
        })
    });
    
    $('.getimp').on('click', function(){
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
    });

    $(document).on('change', '#select_user_type', function(){
      if($(this).val() == 'member'){
        $('.member_list_setting').show();
        $('.group_list_setting').hide();
      } else{
        $('.member_list_setting').hide();
        $('.group_list_setting').show();
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
        
</script>
<script>
    var bar = new ProgressBar.Circle(container, {
      color: '#aaa',
      // This has to be the same size as the maximum width to
      // prevent clipping
      strokeWidth: 4,
      trailWidth: 1,
      easing: 'easeInOut',
      duration: 1400,
      text: {
        autoStyleContainer: false
      },
      from: { color: '#aaa', width: 1 },
      to: { color: '#333', width: 4 },
      // Set default step function for all animate calls
      step: function(state, circle) {
        circle.path.setAttribute('stroke', state.color);
        circle.path.setAttribute('stroke-width', state.width);

        var value = Math.round(circle.value() * 100);
        if (value === 0) {
          circle.setText('');
        } else {
          circle.setText(value + '%');
        }

      }
    });
    bar.text.style.fontFamily = '"Raleway", Helvetica, sans-serif';
    bar.text.style.fontSize = '2rem';



      $(document).ready(function(){
        $( ".main_content" ).removeClass("hidden");
      // File upload via Ajax

         $("#fileInput").change(function(e){

            var file = this.files[0];

            var fileType = file.type;

            console.log(fileType);

            //File Validation

              var allowedTypes = ['application/pdf', 'image/jpeg', 'image/png', 'image/jpg', 'image/gif', 'video/mp4', 'video/webm', 'audio/mp3', 'audio/mpeg'];

              var file = this.files[0];

              var fileType = file.type;

              //alert(fileType);

              if(!allowedTypes.includes(fileType)){

                  Swal.fire('We are only supporting this formates (PDF/JPEG/JPG/PNG/GIF/MP4/WEBM/MP3).')

                  $("#fileInput").val('');

                  return false;

              } else{

               $("#file_type").val(fileType);

               e.preventDefault();

               $.ajax({

                  xhr: function() {

                     var xhr = new window.XMLHttpRequest();

                     xhr.upload.addEventListener("progress", function(evt) {
                      $('.loader-content').show();
                      $('#file_upload img').hide();
                      $('#file_upload label').hide();
                     if (evt.lengthComputable) {

                           var percentComplete = ((evt.loaded / evt.total) * 100);

                           var a = Math.round(percentComplete);

                           $(".progress-bar").width(a + '%');

                           $(".progress-bar").html(a +'%');
                           var t = (a / 100);
                           bar.animate(t);

                        }

                     }, false);

                     return xhr;

                  },

                  type: 'POST',

                  url: 'include/upload.php',

                  data: new FormData($(this).closest('form')[0]),

                  contentType: false,

                  cache: false,

                  processData:false,

                  beforeSend: function(){

                     $(".progress-bar").width('0%');

                     $('#uploadStatus').html('<img src="http://magehubextensions.com/contentshare/image/giphy.gif" style="height: 50px;"/>');

                  },

                  error:function(){

                     $('#uploadStatus').html('<p style="color:#EA4335;">File upload failed, please try again.</p>');

                     },

                  success: function(resp){

                     if(resp){

                        $('#fileurl').val(resp);

                        $('#uploadStatus img').attr('style','display: none');

                     }else if(resp == 'invalid'){

                        $('#uploadStatus').html('<p style="color:#red;">Invalid File Type, please try again.</p>');

                     }else if(resp == 'no'){

                        $('#uploadStatus').html('<p style="color:#EA4335;">File already exists, please try again.</p>');

                     }

                     $('#file_upload').hide();

                     $('.close-button').show();

                     //span6()addClass();

                     $('#uploadForm').addClass('form-file-upload');

                     $('#span6').addClass('files-uploaded');

                     if(fileType == 'application/msword'){

                      PreviewDocs(resp);

                     }else if(fileType == 'application/vnd.openxmlformats-officedocument.wordprocessingml.document'){

                        PreviewDocs(resp);

                     

                     }else{

                        PreviewImage();

                     }

                     if(fileType == 'audio/mp3' || fileType == 'audio/mpeg'){

                        getDuration(resp)
                        .then(function(length) {
                          length = Math.floor(length);
                          var h = Math.floor(length % (3600*24) / 3600);
                          var m = Math.floor(length % 3600 / 60);
                          var s = Math.floor(length % 60);

                          var hDisplay = h > 0 ? h + (h == 9 ? ":" : ":") : "";
                          var mDisplay = m > 0 ? m + (m == 1 ? ":" : ":") : "";
                          var sDisplay = s > 0 ? s + (s == 1 ? " " : " ") : "";
                          if(hDisplay == ''){
                           hDisplay = "00:";
                          }
                          if(mDisplay <= '9'){
                           mDisplay = "0"+mDisplay;
                          }
                          var audio_duration = hDisplay + mDisplay + sDisplay;
                            document.getElementById("number").value = audio_duration;
                        });

                     } 

                  $('.loader-content').hide();
                  bar.animate(0.0);

                  }

               });

         }

      });

      

      // File type validation

      // $("#fileInput").change(function(){

      // //'application/msword', 'application/vnd.ms-office', 'application/vnd.openxmlformats-officedocument.wordprocessingml.document',,'audio/mpeg','audio/mp3'

      // var allowedTypes = ['application/pdf', 'image/jpeg', 'image/png', 'image/jpg', 'image/gif','video/mp4'];

      // var file = this.files[0];

      // var fileType = file.type;

      // //alert(fileType);

      // if(!allowedTypes.includes(fileType)){

      // alert('Please select a valid file (PDF/DOC/DOCX/JPEG/JPG/PNG/GIF/MP3/MP4).');

      // $("#fileInput").val('');

      // return false;

      // } else{

      // $("#file_type").val(fileType);

      // }

      // });

      });



      $(document).ready(function(){

         var type = $('#file_type').val();

         var allowedTypes = ['image/jpeg', 'image/png', 'image/jpg', 'image/gif'];

         if(allowedTypes.includes(type)){

            $('#trial_setting').hide();

         }

      });

   </script>

   <script type="text/javascript">

      function myTrim(x) {
      return x.replace(/^\s+|\s+$/gm,'');
    }
   function PreviewImage() {
   	var allowedTypes = ['image/jpeg', 'image/png', 'image/jpg', 'image/gif'];
   	var allowedTypesvideo = ['video/mp4'];
   	var allowedTypesaudio = ['audio/mp3','audio/mpeg'];
   	pdffile = document.getElementById("fileInput").files[0];
   	var fileType = pdffile.type;
   	pdffile_url = URL.createObjectURL(pdffile);
   	if (!allowedTypes.includes(fileType) && !allowedTypesvideo.includes(fileType) && !allowedTypesaudio.includes(fileType)) {
   		$('#viewer-file').html('<div id="view-remove"><a href="javascript:void(0);" onclick="fileupload();"><iframe id="viewer" frameborder="0" scrolling="no" autoplay=""></iframe></a></div>');
   		var input = document.getElementById("fileInput");
   		var reader = new FileReader();
   		reader.readAsBinaryString(input.files[0]);
   		reader.onloadend = function () {
   			var count = reader.result.match(/\/Type[\s]*\/Page[^s]/g).length;
   			document.getElementById("trial_start").value = '1';
   			document.getElementById("trial_end").value = count;
   			document.getElementById("number").value = count;
   		}
   		$('#trial_setting').show();
   		$('#trial_s').html('From Page');
   		$('#trial_e').html('To Page');
   	} else if (!allowedTypesvideo.includes(fileType) && !allowedTypesaudio.includes(fileType)) {
   		$('#viewer-file').html('<div id="view-remove" class="file-image"><a href="javascript:void(0);" onclick="fileupload();"><img width="570px" height="600px" id="viewer"></a></div>');
   		$('#trial_setting').hide();
		$.ajax({
			type: "POST",
			url: "Image-Zoom/Example/Image.php",
			data:{
				url:pdffile_url
			},
			success: function(html){ 
				$("#view-remove").html(html);
			}
		});
   	} else if (allowedTypesaudio.includes(fileType)) {
   		$('#viewer-file').html('<div id="view-remove" class="file-image"><a id="myAudio" href="javascript:void(0);" onclick="fileupload();" class="audio"><audio controls="" id="viewer" name="media"><source type="audio/mpeg" id="viewer"></audio></a></div>');
   		$.ajax({
			type: "POST",
			url: "include/upload.php",
			data:{
				thuburl:'thuburl'
			},
			success: function(resp){ 
				$('#myAudio').css({"background":"url("+myTrim(resp)+")","justify-content":"center"});
			}
		});
   		$(document).ready(function () {
   			
   			setTimeout(function () {
   
   				$("#getduration").click();
   
   
   			}, 2000);
   
   		});
   		$('#number').attr('style', 'display: none');
   		$('#trial_setting').show();
   		$('#trial_s').html('Start time');
   		$('#trial_e').html('End time');
   	} else {
   		$('#viewer-file').html('<div id="view-remove" class="file-image"><a href="javascript:void(0);" onclick="fileupload();"><video id="myVideo" width="570px" height="600px" controls><source id="viewer"></video></a></div>');
   		$(document).ready(function () {
   
   			setTimeout(function () {
   
   				$("#getduration").click();
   
   
   			}, 2000);
   
   		});
   		$('#number').attr('style', 'display: none');
   		$('#trial_setting').show();
   		$('#trial_s').html('Start time');
   		$('#trial_e').html('End time');
   	}
   
   	$('#viewer').attr('src', pdffile_url);
   
   }

      function PreviewDocs(resp) {

      var siteurl = '<?php echo SITE_URL; ?>';

      $('#viewer-file').html('<div id="view-remove"><a href="javascript:void(0);" onclick="setSelectedTestPlan(this);"><iframe id="docsviewer" frameborder="0" scrolling="no" width="570" height="600"></iframe></a></div>');

      docs_url =  'https://view.officeapps.live.com/op/embed.aspx?src='+siteurl+resp;

      $('#docsviewer').attr('src',docs_url);

      }

      

      var iframe = $('#viewer').contents();

      iframe.click(function(event){

      $('#fileInput').click();

      });

      

      

      jQuery('.close-button').on('click', function(){
        cuteAlert({
            type: "question",
            title: "Change File",
            message: "Do you wish to change this file?",
            confirmText: "Yes",
            cancelText: "Cancel"
         }).then((e)=>{
            if ( e == ("confirm")){
              jQuery('#view-remove').remove();
              $('#file_upload').show();
              $('.close-button').hide();
              $('#view-content').hide();
              $('#uploadForm').removeClass('form-file-upload').show();
              $('#span6').removeClass('files-uploaded');
          }
        });

      });

      

      

      

      function getDuration(src) {
        return new Promise(function(resolve) {
            var audio = new Audio();
            $(audio).on("loadedmetadata", function(){
                resolve(audio.duration);
            });
            audio.src = src;
        });
      }

      $('#getqr').on('click', function(){
         var imageUrl = <?php echo json_encode($filedata['file_qr']);?>;
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

   <script> 

      jQuery.noConflict();

      jQuery(document).ready(function($){

      jQuery(function() { 

      jQuery('#w_type').change(function(){

      jQuery('.watermark').hide();

      jQuery('#' + jQuery(this).val()).show();

      });

      

      });

      });

      

      jQuery(function() {

      jQuery('#number').change(function(){ 

      var file = jQuery('#file_type').val();  

      var page = jQuery('#number').val();

      

      if(file == 'PDF'){

      var total = (page * 5);

      }

      else{

      var total = (page * 10);

      }

      //var Total = "$".total;

      //alert(Total);

      jQuery('#price').val('$'+total);

      });

      });

      

      function videoduration(){

      var x = document.getElementById("myVideo").duration;

      var h = Math.floor(x % (3600*24) / 3600);

      var m = Math.floor(x % 3600 / 60);

      var s = Math.floor(x % 60);

      

      var hDisplay = h > 0 ? h + (h == 9 ? " : " : " : ") : "";

      var mDisplay = m > 0 ? m + (m == 1 ? " : " : " : ") : "";

      var sDisplay = s > 0 ? s + (s == 1 ? " " : " ") : "";

      var video_duration = hDisplay + mDisplay + sDisplay;

      $('#number').val(video_duration);

      $('#getduration').attr('style', 'display: none');

      $('#number').removeAttr('style');

      }

      

      function validateForm() {

        var number = document.forms["uploadFormcontent"]["number"].value;

        var fileurl = document.forms["uploadFormcontent"]["fileurl"].value;

        var w_type = document.forms["uploadFormcontent"]["w_type"].value;

        var error = document.getElementById("error");

        var errorfile = document.getElementById("errorfile");

        var errorw = document.getElementById("errorw");

        if (fileurl == "") {

        errorfile.innerHTML =  

        "Please Select a file to upload.";

        //alert("Name must be filled out");

        return false;

        }else {

        errorfile.innerHTML =  

        "";

        }

        if (number == "") {
        error.style.display = "block";
        error.innerHTML =  

        "Please enter total pages.";

        //alert("Name must be filled out");

        return false;

        }else {

        error.innerHTML =  

        "";

        }

        if (w_type == "Text") {

        var watermark_text = document.forms["uploadFormcontent"]["watermark_text"].value;

        if (watermark_text == "") {
          errorw.style.display = "block";
        errorw.innerHTML =  

        "Please enter watermark.";

        //alert("Name must be filled out");

        return false;

        }

        } else{

        var file = document.forms["uploadFormcontent"]["file"].value;

        if (file == "") {
        errorw.style.display = "block";
        errorw.innerHTML =  

        "Please select watermark file.";

        //alert("Name must be filled out");

        return false;

        }

        }

      }

      

      

      $('#evaluation_type').change(function () { 

      var id = <?php echo json_encode($e_date_id);?>;

      var e_type = <?php echo json_encode($e_type);?>;

      if ($(this).val() == id){

         $('#evaluation_value').hide();

         $('#evaluation_date').show();

      } else{

         $('#evaluation_value').show();

         $('#evaluation_date').hide();

      }

      if($('#evaluation_type').val() == '14'){

            $('#evaluation_value').hide();

      }

      });

      $('#delete-content').on('click', function(){
        var id = <?php echo json_encode($_GET['id']);?>;
        cuteAlert({
            type: "question",
            title: "Delete",
            message: "Do you wish to delete this share?",
            confirmText: "Yes, delete it!",
            cancelText: "Cancel"
         }).then((e)=>{
            if ( e == ("confirm")){
               $.ajax({
               type: "POST",
               url: "include/delete-content.php?id="+id,
               success: function(res){ 
                  window.location = "reports.php";
                  
               }
               });
            }
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

         function paused_icon() {
            $("input[name=paused][value=no]").attr('checked', 'checked');
            $("input[name=paused][value=yes]").removeAttr('checked', 'checked');
            $(".play_pause_btn #yes").hide();
            $(".play_pause_btn #no").show();
            var id = <?php echo json_encode($id);?>;
            var paused = 'no';
	          $.ajax({
	              type: "POST",
	              url: "include/Updatepause.php",
	              data:{
	              	id:id,
	              	paused:paused
	              },
	              success: function(res){ 
	               //window.location = "reports.php";
	     
	              }
	            });
         }
         function play_icon() {
            $("input[name=paused][value=yes]").attr('checked', 'checked');
            $("input[name=paused][value=no]").removeAttr('checked', 'checked');
            $(".play_pause_btn #no").hide();
            $(".play_pause_btn #yes").show();
            var id = <?php echo json_encode($id);?>;
            var paused = 'yes';
	          $.ajax({
	              type: "POST",
	              url: "include/Updatepause.php",
	              data:{
	              	id:id,
	              	paused:paused
	              },
	              success: function(res){ 
	               //window.location = "reports.php";
	     
	              }
	            });
         }

          function filestats(id){
            var id = id;
              $.ajax({
                  type: "POST",
                  url: "File-stats.php?id="+id,
                  success: function(res){ 
                                       
                  }
                });
          } 

   </script>

   <script>

        $(document).ready(function($){  
          $('.back_arrow').hide();


          $(".social_icons_show_hide a .link_icon_img").click(function(){
            $(".link_icon_img").hide();
            $(".close_icon").show();
            $(".social_icons").show();
          });
          $(".social_icons_show_hide a .close_icon").click(function(){
            $(".link_icon_img").show();
            $(".close_icon").hide();
            $(".social_icons").hide();
          });

          // $('#share-stats').click(function() {
          //   $(".loader").show();
          // });
        });



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
              $('*[data-type="remove"]').attr('data-type', '');
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
        $('.submit-action.loader').show();
        $('body').addClass('submit-loader');
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
       

   <!-- /Calendar -->

</main>
<?php include('footer-new.php');?>