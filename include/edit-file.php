<?php 
require('./include/db.php');
session_start();
?>

<?php require('head.php');
require_once './vendor/stripe/stripe-php/init.php'; 
\Stripe\Stripe::setApiKey('sk_test_ZHBPscwQ2uvawFY7Fq1E3DAC');
?>

<?php require('header-new.php'); ?>   
<style>
.loader:before {
 width: 60px;
  height: 60px;
  -webkit-animation: spin 2s linear infinite;
  animation: spin 2s linear infinite;
  display: inline-block;
  border: 10px solid #3498db;
  border-radius: 50%;
  border-top: 10px solid #f3f3f3;
  content: "";
}
.loader {
    width: 100%;
    position: fixed;
    top: 0;
    bottom: 0;
    right: 0;
    left: 0;
    height: 100%;
    display: flex;
    align-items: center;
    justify-content: center;
    z-index: 12;
    background: rgba(0,0,0,.8);
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
</style>

   <!-- /navbar -->
<main>
<div class="loader" style="display: none;"></div>
   <div class="container new_container">
      <div class="row">
         <div class="col-md-12">
            <?php if (isset($_SESSION['succsessmsg'])){ ?>  
            <input type="hidden" id="succsessmsg" name="succsessmsg" value="<?php echo $_SESSION['succsessmsg'];?>">
              <script>
                jQuery(document).ready(function($) {
                  var msg = $('#succsessmsg').val();
                  if(msg != ''){
                       $('.cd-popup').addClass('is-visible');
                      }
                    });
              </script>
            <?php 
               unset($_SESSION['succsessmsg']);
               }
               if(isset($_SESSION['error'])){ ?>
            <div class="alert alert-error">
               <a href="#" class="close" data-dismiss="alert">&times;</a>
               <strong style="color:red;"><?php echo $_SESSION['error']; ?></strong>
            </div>
            <?php 
               unset($_SESSION['error']);
               } 
               if(isset($_SESSION['succses'])){ ?>
            <div class="alert alert-success">
               <a href="#" class="close" data-dismiss="alert">&times;</a>
               <strong><?php echo $_SESSION['succses']; ?></strong>
            </div>
            <?php 
               unset($_SESSION['succses']);
               } 
               ?>
   
              
 
              <div class="main_content hidden">

               <div id="edit-qr-modal" class="modal fade" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                  <div class="modal-dialog modal-dialog-centered">

                  <!-- Modal content-->
                    <div class="modal-content">
                      <div class="modal-header">
                        <h4 class="modal-title">ContentShare</h4>
                        <button type="button" class="close" data-dismiss="modal">×</button>
                      </div>
                      <div class="modal-body">
                        <div class="container-fluid" id="contentshare-model-popup">

                        </div>
                      </div>
                    </div>
                  </div>
               </div>

               <div class="cd-popup" role="alert">
                  <div class="cd-popup-container">
                    <img src="<?php echo SITE_URL;?>/image/paymentsuccess.png" style="height: 100px;">
                    <h1>Thank You !</h1>
                    <p>Settings saved your content can now be shared.</p>
                    <a href="#0" class="cd-popup-close img-replace">Close</a>
                  </div> <!-- cd-popup-container -->
                </div>


               <!-- Delete Confirmation Popup -->
               <div id="delete-modal" class="modal fade delete_share" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                  <div class="modal-dialog modal-dialog-centered">

                  <!-- Modal content-->
                    <div class="modal-content">
                      <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">×</button>
                      </div>
                      <div class="modal-body">
                        <div class="container-fluid" id="delete-model-popup">
                          <p>Do you wish to delete this share?</p>
                          <ul class="cd-buttons">
                            <li><a href="javascript:;" id="deletefile" onclick="deletefile(<?php echo $_GET['id'];?>)">Yes</a></li>
                            <li><a class="close" data-dismiss="modal">No</a></li>
                          </ul>
                        </div>
                      </div>
                    </div>
                  </div>
               </div>

               <!-- Stipre Connnect Popup -->
               <div id="stripe-modal" class="modal fade delete_share" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                  <div class="modal-dialog modal-dialog-centered">

                  <!-- Modal content-->
                    <div class="modal-content">
                      <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">×</button>
                      </div>
                      <div class="modal-body">
                        <script>
                          $(document).on('click', '.getimp', function(){
                            $('#stripe-buttons').css("display", "none");
                            $('#stripe-text').html('Your impressions tokens have expired any shared links will not be viewable. Please update your tokens by going to your settings page.');
                          });
                        </script>
                        <div class="container-fluid" id="delete-model-popup">
                          <p id="stripe-text">Your Stripe Account is not activated do you wish to activate your account?</p>
                          <ul class="cd-buttons" id="stripe-buttons">
                            <li><a href="setting.php" id="activate">Yes</a></li>
                            <li><a class="close" data-dismiss="modal">No</a></li>
                          </ul>
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
                     <div class="progress" style="display: none;">
                        <div class="progress-bar" style="background-color: #1ada1a;"></div>
                     </div>
                    <!--  <div id="uploadStatus"></div> -->
                     <?php
                     	$id = $_GET['id'];
                        $file = "SELECT * FROM `sentfile` where file_id = '".$_GET['id']."'";

                        $results = mysqli_query($con,$file);

                        $filedata = mysqli_fetch_array($results);

                        $type = $filedata['file_type'];

                        $fileurl = $filedata['file_url'];?>

                       <div class="view-content" id="view-content">

                          <?php

                             $allowedTypes = array('image/jpeg', 'image/png', 'image/jpg', 'image/gif');

                             $allowedTypesvideo = array('video/mp4');

                             $filetype = $filedata["file_type"]; 

                             if(in_array($filetype, $allowedTypes)){?>

                              <div id="view-remove" class="file-image">

                              </div> 

                              <script>

                                 jQuery(document).ready(function($) {

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

                                          }

                                        });

                                    }

                                  });

                               </script>                   

                         <?php }else if(in_array($filetype, $allowedTypesvideo)){ ?>

                              <div id="view-remove" class="file-image" style="height: auto !important;">

                                  <video id="myVideo" width="570px" height="600px" controls>

                                     <source id="viewer" src="<?php echo $filedata["file_url"];?>">

                                  </video>

                              </div>

                     <?php } else{ ?>

                           <div style="clear:both" id="viewer-file" style="height: auto !important;">

                              <iframe id="viewer" frameborder="0" scrolling="no" width="570" height="300" src="<?php echo $filedata["file_url"];?>"></iframe>

                           </div>
                     <?php } ?>

                     </div>

                  </div>

                  <div class="upload_content_rightside">

                     <form method="post" id="uploadFormcontent" name="uploadFormcontent" action="include/updatefile.php" enctype="multipart/form-data">
                        <div class="widget">
                           <!-- /widget-header -->
                           <div class="upload-contents">
                              <div class="upload_content_form upload_content_form1">
                                 <div class="upload-content">
                                    <div class="form-row">
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

                                       <div class="evprunclock form-group">
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
                                       <label id="error" style="color: red;"></label>

                                    </div>

                                   

                                    <div class="form-row">

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

                                                <option value="None" <?php if($filedata['watermark_type'] == 'None'){?> selected="selected" <?php }?>>None</option>

                                                <option value="Text" <?php if($filedata['watermark_type'] == 'Text'){?> selected="selected" <?php }?>>Text</option>

                                                <option value="Image" <?php if($filedata['watermark_type'] == 'Image'){?> selected="selected" <?php }?>>Image</option>

                                             </select>
                                          </div>

                                       </div>

                                       <?php if($filedata['watermark_type'] == 'None'){?>

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

                                             <label class="custom-file-label" for="inputGroupFile01">Browse</label>

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

                                             <label class="custom-file-label" for="inputGroupFile01">Browse</label>

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

                                             <label class="custom-file-label" for="inputGroupFile01">Browse</label>

                                          </div>

                                       </div>

                                       <?php }?>

                                       <label id="errorw" style="color: red;"></label>

                                    </div>

                                    <div class="watermark_image_show" id="watermark_image_show" style="margin: 10px;">

                                       <?php if($filedata['watermark_image'] != ''){ ?>

                                       <label for="selectpage" class="col-form-label">Uploaded Watermark Image:</label>

                                       <img src="<?php echo $filedata['watermark_image'];?>" style="width: 50%;">

                                       <?php }?>

                                    </div>

                                   

                                    <div class="form-row">

                                       <div class="col-full form-group fileUpload">

                                          <label for="selectpage" class="col-form-label">Additonal File(s)
                                             <div class="tooltip_shows">
                                                <i class="fa fa-question-circle" aria-hidden="true"></i>
                                                <div class="top">
                                                   <span>Any additional files that are available after purchase</span> 
                                                </div>
                                             </div>

                                          </label>

                                          <div class="custom-file">

                                             <input type="file" class="custom-file-input" id="addfile" aria-describedby="inputGroupFileAddon01" name="addfile">

                                             <label class="custom-file-label" for="inputGroupFile01">...</label>

                                          </div>

                                       </div>

                                    </div>
                                      <div class="form-row">
                                       <div class="col-full form-group fileUpload">
                                          <label for="selectpage" class="col-form-label">Content Share URL
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
                                          <label for="selectpage" class="col-form-label">Content Share URL
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
                                             <input type="text" class="form-control" id="url" value="https://contentshare.me/files/start/<?php echo $filedata['file_hash'];?>" readonly>
                                          <?php } else{?>
                                            <input type="text" class="form-control" id="url" value="https://contentshare.me/file/<?php echo $filedata['file_hash'];?>" readonly>
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
                                       <div class="form-group">
                                          <label for="selectpage" class="col-form-label">Notifications
                                             <div class="tooltip_shows">
                                                <i class="fa fa-question-circle" aria-hidden="true"></i>
                                                <div class="top">
                                                   <span>Display notifications on shared content if parameters are updated</span> 
                                                </div>
                                             </div>
                                          </label>
                                          <div class="select_box">
                                             <select class="form-control select2" data-toggle="select2">
                                                <option value="1" selected>Yes</option>
                                                <option value="0">No</option>
                                             </select>
                                          </div>
                                       </div>
                                    </div>
                                    <div class="form-row">
                                      <div class="form-group">
                                        <label class="col-form-label">Password
                                          <div class="tooltip_shows">
                                            <i class="fa fa-question-circle" aria-hidden="true"></i>
                                            <div class="top">
                                              <span>Require password shared content can be opened</span> 
                                            </div>
                                          </div>
                                        </label>
                                        <input type="password" class="form-control" name="password" value="<?php echo $filedata['password'];?>">
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
                                 </div>
                              </div>
                              <div class="forms_icons">
                                 <div class="icons default_back_arrow">
                                    <a href="reports.php">
                                       <img src="images/back_arrow.png" alt="Back Arrow" />
                                    </a>
                                    
                                 </div>
                                 <div class="icons setting tooltip_shows">
                                    <a onclick="advance()">
                                       <img src="images/setting.png" alt="Setting" />
                                    </a>
                                    <div class="left">
                                       <span>Advanced settings</span>
                                    </div>
                                 </div>
                                 <div class="icons back_arrow" style="display: none;">
                                    <a onclick="advancehide()">
                                       <img src="images/back_arrow.png" alt="Back Arrow" />
                                    </a>
                                    
                                 </div>
                                 <!-- onclick="deletefile(<?php //echo $filedata['file_id'];?>)" -->
                                 <div class="icons delete_icon tooltip_shows">
                                    <a href="javascript:;" id="delete-content" data-toggle="modal" data-target="#delete-modal" data-id="<?php echo $filedata["file_id"];?>">
                                       <img src="images/delete_icon.png" alt="Delete" />
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
                                       <img src="images/chart_icon.png" alt="Chart" />
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
                                 if($filedata['file_price'] == '0' || $filedata['file_price'] == ''){ ?>
                                  <div class="icons qr_icon tooltip_shows">
                                    <a href="javascript:;" id="getqr" data-toggle="modal" data-target="#edit-qr-modal" data-id="<?php echo $filedata["file_id"];?>">
                                       <img src="images/qr_icon.png" alt="Qr" />
                                    </a>
                                    <div class="left">
                                       <span>QR code link to share</span>
                                    </div>
                                 </div>
                                 <div class="icons link_icon tooltip_shows social_icons_show_hide">
                                    <a href="javascript:;" onclick="CopyURL()">
                                     <img src="images/link_icon.png" alt="Link" />
                                    </a>
                                    <div class="left">
                                       <span>URL to share</span>
                                    </div>
                                 </div>
                           <?php } else{
                                    $stripe = \Stripe\Account::retrieve(
                                      $fetch_data['stripe_acc_id']
                                    );
                                      $status = '';
                                      if($stripe['charges_enabled'] != '1'){
                                        $status = "Disabled"; ?>
                                        <div class="icons qr_icon tooltip_shows">
                                          <a href="javascript:;" id="getqr" data-toggle="modal" data-target="#stripe-modal">
                                            <img src="images/qr_icon.png" alt="Qr" />
                                          </a>
                                          <div class="left">
                                            <span>QR code link to share</span>
                                          </div>
                                        </div>
                                        <div class="icons link_icon tooltip_shows social_icons_show_hide">
                                          <a href="javascript:;" id="getqr" data-toggle="modal" data-target="#stripe-modal">
                                            <img src="images/link_icon.png" alt="Link" />
                                          </a>
                                          <div class="left">
                                            <span>URL to share</span>
                                          </div>
                                        </div>
                                     <?php }else{
                                        $status = "Enabled";?>
                                  <div class="icons qr_icon tooltip_shows">
                                    <a href="javascript:;" id="getqr" data-toggle="modal" data-target="#edit-qr-modal" data-id="<?php echo $filedata["file_id"];?>">
                                       <img src="images/qr_icon.png" alt="Qr" />
                                    </a>
                                    <div class="left">
                                       <span>QR code link to share</span>
                                    </div>
                                 </div>
                                 <div class="icons link_icon tooltip_shows social_icons_show_hide">
                                    <a href="javascript:;" onclick="CopyURL()">
                                     <img src="images/link_icon.png" alt="Link" />
                                    </a>
                                    <div class="left">
                                       <span>URL to share</span>
                                    </div>
                                 </div>
                                 <?php } }
                                  } else{ ?>
                                    <div class="icons qr_icon tooltip_shows">
                                    <a class="getimp" data-toggle="modal" data-target="#stripe-modal" data-id="1">
                                       <img src="images/qr_icon.png" alt="Qr" />
                                    </a>
                                    <div class="left">
                                       <span>QR code link to share</span>
                                    </div>
                                 </div>
                                 <div class="icons link_icon tooltip_shows social_icons_show_hide">
                                    <a class="getimp" data-toggle="modal" data-target="#stripe-modal" data-id="1">
                                     <img src="images/link_icon.png" alt="Link" />
                                    </a>
                                    <div class="left">
                                       <span>URL to share</span>
                                    </div>
                                 </div>
                                  <?php }?>


                                 <div class="text-center processbutton tooltip_shows">
                                    <button type="submit" id="submit"><img src="images/check_btn.png" alt="Checkbtn" /></button>
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
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
<script src="https://rawgit.com/kimmobrunfeldt/progressbar.js/1.0.0/dist/progressbar.js"></script>
<script>
  function advance(){
          $('.back_arrow').show();
          $('.setting').hide();
          $('.upload_content_form2').show();
          $('.upload_content_form1').hide();
          $('.default_back_arrow').hide();
         
        }

        function advancehide(){
          $('.back_arrow').hide();
          $('.setting').show();
          $('.upload_content_form2').hide();
          $('.upload_content_form1').show();
          $('.default_back_arrow').show();
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

              var allowedTypes = ['application/pdf', 'image/jpeg', 'image/png', 'image/jpg', 'image/gif','video/mp4'];

              var file = this.files[0];

              var fileType = file.type;

              //alert(fileType);

              if(!allowedTypes.includes(fileType)){

                  alert('Please select a valid file (PDF/JPEG/JPG/PNG/GIF/MP4).');

                  $("#fileInput").val('');

                  return false;

              } else{

               $("#file_type").val(fileType);

               e.preventDefault();

               $.ajax({

                  xhr: function() {

                     var xhr = new window.XMLHttpRequest();

                     xhr.upload.addEventListener("progress", function(evt) {
                      $('#container').show();
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

                        audio_duration(resp);

                     } 

                  $('#container').hide();
                  bar.animate(0.0);

                  }

               });

         }

      });

      

      // File type validation

      $("#fileInput").change(function(){

      //'application/msword', 'application/vnd.ms-office', 'application/vnd.openxmlformats-officedocument.wordprocessingml.document',,'audio/mpeg','audio/mp3'

      var allowedTypes = ['application/pdf', 'image/jpeg', 'image/png', 'image/jpg', 'image/gif','video/mp4'];

      var file = this.files[0];

      var fileType = file.type;

      //alert(fileType);

      if(!allowedTypes.includes(fileType)){

      alert('Please select a valid file (PDF/DOC/DOCX/JPEG/JPG/PNG/GIF/MP3/MP4).');

      $("#fileInput").val('');

      return false;

      } else{

      $("#file_type").val(fileType);

      }

      });

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

      function PreviewImage() {

      var allowedTypes = ['image/jpeg', 'image/png', 'image/jpg', 'image/gif'];

      var allowedTypesvideo = ['video/mp4'];

      pdffile=document.getElementById("fileInput").files[0];

      var fileType = pdffile.type;

      pdffile_url=URL.createObjectURL(pdffile);

      if(!allowedTypes.includes(fileType) && !allowedTypesvideo.includes(fileType)){

      $('#viewer-file').html('<div id="view-remove"><a href="javascript:void(0);" onclick="fileupload();"><iframe id="viewer" frameborder="0" scrolling="no" width="570" height="600"></iframe></a></div>');

      var input = document.getElementById("fileInput");

               var reader = new FileReader();

               reader.readAsBinaryString(input.files[0]);

               reader.onloadend = function(){

                   var count = reader.result.match(/\/Type[\s]*\/Page[^s]/g).length;

                   document.getElementById("trial_start").value = '1';

                   document.getElementById("trial_end").value = count;

                   document.getElementById("number").value = count;

               }

               $('#trial_setting').show();

               $('#trial_s').html('From Page');

               $('#trial_e').html('To Page');

      } else if(!allowedTypesvideo.includes(fileType)){

      $('#viewer-file').html('<div id="view-remove" class="file-image"><a href="javascript:void(0);" onclick="fileupload();"><img width="570px" height="600px" id="viewer"></a></div>');

         $('#trial_setting').hide();

      }

      else{

      $('#viewer-file').html('<div id="view-remove" class="file-image"><a href="javascript:void(0);" onclick="fileupload();"><video id="myVideo" width="570px" height="600px" controls><source id="viewer"></video></a></div>');   

      $(document).ready(function(){

      

      setTimeout(function(){

      

      $("#getduration").click();

      

      

      },2000);

      

      });

      $('#number').attr('style', 'display: none');

      $('#trial_setting').show();

      $('#trial_s').html('Start time');

      $('#trial_e').html('End time');



      }

      

      $('#viewer').attr('src',pdffile_url);

      

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

      jQuery('#view-remove').remove();

      $('#file_upload').show();

      //$('.close-button').hide();

      $('#view-content').hide();


      $('#uploadForm').removeClass('form-file-upload').show();

      $('#span6').removeClass('files-uploaded');

      });

      

      

      

      function audio_duration(resp){             

      var files = resp;

      

      jQuery.ajax({

      type: "POST",

      data: {

      file:files,

      },

      url: "include/audio_duration/mp3file.class.php",          

      success: function(resp) {

      $("#number").val(resp);

      //$/("#myModal").attr("style" , "display: block");

      }

      });

      }

      $('#getqr').on('click', function(){
         var id = $(this).attr("data-id");
         $.ajax({
              type: "POST",
              url: "include/DisplayQRcode.php?id="+id,
              success: function(res){ 
               $("#contentshare-model-popup").html(res);                
              }
            });
      });

      jQuery(document).ready(function($){
        //open popup
        $('.cd-popup-trigger').on('click', function(event){
        event.preventDefault();
        $('.cd-popup').addClass('is-visible');
      });

        //close popup
      $('.cd-popup').on('click', function(event){
        if( $(event.target).is('.cd-popup-close') || $(event.target).is('.cd-popup') ) {
        event.preventDefault();
        $(this).removeClass('is-visible');
        }
      });
        //close popup when clicking the esc keyboard button
      $(document).keyup(function(event){
        if(event.which=='27'){
        $('.cd-popup').removeClass('is-visible');
        }
        });
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

      errorw.innerHTML =  

      "Please enter watermark.";

      //alert("Name must be filled out");

      return false;

      }

      } else{

      var file = document.forms["uploadFormcontent"]["file"].value;

      if (file == "") {

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

      function deletefile(id){
        var id = id;
          $.ajax({
              type: "POST",
              url: "include/delete-content.php?id="+id,
              success: function(res){ 
               window.location = "reports.php";
                
              }
            });
      } 
      
      function CopyURL(){
            var copyText = document.getElementById("url");
            copyText.select();
            copyText.setSelectionRange(0, 99999)
            document.execCommand("copy");
            //alert("Copied the text: " + copyText.value);
            $('#copyurl').removeAttr("style");
            $('#copyurl').addClass("in");
            setInterval(function(){ 
			  $('#copyurl').hide();
			}, 2000);
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

          $('#share-stats').click(function() {
            $(".loader").show();
          });
        });



 </script>

                           

   <!-- /Calendar -->

</main>
<?php include('footer-new.php');?>