<?php    
//require('http.php');
require('./include/db.php');
require('./include/inc/defined_variables.php');
session_start(); 
// echo "<pre>";
// print_r($_SERVER);exit;
if($_SERVER['REQUEST_URI'] == '/' && $_SERVER['REQUEST_METHOD'] == 'GET'){
	header("Location: dashboard.php");
}
         //echo '<pre>' . print_r($_SESSION, TRUE) . '</pre>';   if(isset($_COOKIE['loginuser'])){      $_SESSION["user"] = $_COOKIE['loginuser'];   }else{      $cookie_value = $_SESSION["user"];      setcookie("loginuser", $cookie_value, time() + (86400 * 30), "/contentshare/"); // 86400 = 1 day    }
$sql = "SELECT * from cs_users where id = '" . $_SESSION["user"] . "' OR oauth_uid =  '" . $_SESSION["user"] . "'";
$result = mysqli_query($con,$sql);
$fetch_data = mysqli_fetch_array($result);
$imp = $fetch_data['impressions']; 
?>
	<?php 
	$err = '';
	//print_r($_SESSION);
      if (isset($_SESSION['errormsg'])){ 
      	$err = $_SESSION['errormsg'];?>  
      <input type="hidden" id="succsessmsg" name="succsessmsg" value="<?php echo $_SESSION['errormsg'];?>">
      <script>
      jQuery(document).ready(function($) {
        var msg = $('#succsessmsg').val();
        if(msg != ''){
             $('.cd-popup').addClass('is-visible');
            }
          });
      </script>
       <?php 
	   unset($_SESSION['errormsg']);
	  }

	  if (isset($_SESSION['error'])){ 
      	$err = $_SESSION['error'];?>  
      <input type="hidden" id="succsessmsg" name="succsessmsg" value="<?php echo $_SESSION['error'];?>">
      <script>
      jQuery(document).ready(function($) {
        var msg = $('#succsessmsg').val();
        if(msg != ''){
             $('.cd-popup').addClass('is-visible');
            }
          });
      </script>
       <?php 
	   unset($_SESSION['error']);
	  }
	  ?>
    <div class="cd-popup" role="alert">
      <div class="cd-popup-container">
        <h1>Sorry !</h1>
        <p><?php echo $err;?></p>
        <a href="#0" class="cd-popup-close img-replace">Close</a>
      </div> <!-- cd-popup-container -->
    </div>
    <div class="submit-action loader" style="display: none;"></div>
	<div class="upload_content_bg">
	    
	    <div class="top_default_icons">
            <div class="icons description_icon tooltip_shows">
                <a onclick="descritpion_icon()" href="javascript:;" class="active">
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
                <a href="dashboard.php">
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
			<button class="close-button" aria-label="Close alert" type="button" style="display: none;">
				<span aria-hidden="true">&times;</span>
			</button>             <!-- File upload form -->		
			<form id="uploadForm" action="test.php" enctype="multipart/form-data">
				<div style="clear:both" id="viewer-file">
					
				</div>
				<div class="form-group files tooltip_shows " id="file_upload">
					<img src="images/file_upload.png" alt="File upload" />
					<label>Click or drag file to upload </label>
					<input type="file" name="file" id="fileInput" accept="application/pdf, image/jpeg, image/png, image/jpg, image/gif, video/mp4, video/webm, .mp3, mpeg">
						<div class="top">
							<span>Upload content to share</span> 
						</div>
				</div>
				
				<label id="errorfile" style="color: red; display: none;"></label>
				<div id="container" style="display: none;"></div><div class="file-uploading loader" style="display: none;"></div>
			</form>
	      <!-- Progress bar -->      
			<!-- <div class="progress">
				<div class="progress-bar" style="background-color: #1ada1a; display: none;"></div>
			</div> -->
	      	<div id="uploadStatus" style="display: none;"></div>
	      	<a id="view_files" class="view_files" href="reports.php">View Links</a>
	   </div>
	   <div class="upload_content_rightside">
	      <form method="post" id="uploadFormcontent" name="uploadFormcontent" action="include/uploadfile.php" enctype="multipart/form-data" onsubmit="return validateForm()">
	         <!-- /widget-header -->            
	         <div class="upload-contents">
	            <div class="upload_content_form upload_content_form1">
	               <div class="upload-content">
	                  	<div class="form-row form-row1">
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
								<input type="hidden" id="file_type" name="file_type" class="form-control">											                           
								<div class="select_box">
									<select name="evaluation_type" id="evaluation_type">
										<?php $e_date_id = ''; $evaluation = "SELECT * FROM `tbl_evaluation`"; 
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
								<input class="form-control" id="number" type="hidden" name="number" value="1">
								<input class="form-control" id="evaluation_value" type="text" name="evaluation_value">
								<input class="form-control" id="evaluation_date" type="date" name="evaluation_date" style="display: none;">
								<label id="errorevl" style="color: red; display: none;"></label>
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
								<input type="text" id="price" name="price" class="form-control" value="1">
								<label id="error" style="color: red; display: none;"></label>
							</div>
	                    										                     
	                  	</div>
						<div class="form-row form-row2">
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
										<option value="None" selected>None</option>
										<option value="Text">Text</option>
										<option value="Image">Image</option>
									</select>
								</div>
							</div>
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
									<input type="file" class="custom-file-input" id="file" name="file">
									<label class="custom-file-label label-watermark" for="inputGroupFile01">Browse</label>
								</div>
							</div>
							<label id="errorw" style="color: red; display: none;"></label>									                     
						</div>
	                  <!--<div class="form-row">										<div class="form-group paused">											<label for="selectpage" class="col-form-label">Paused</label>											<div class="pause-action">												<span class="left">													<input type="radio" id="yes" name="paused" value="yes">													<label for="yes">Yes</label>												</span>												<span class="left">													<input type="radio" id="no" name="paused" value="no" checked>													<label for="no">No</label>												</span>                        </div>                        </div>									</div> -->                     
						<div class="form-row">
							<div class="col-full form-group fileUpload">
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
									<label class="custom-file-label label-additional" for="inputGroupFile01">...</label>
								</div>
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
	               	<div class="upload-content">
						<div class="form-row" id="trial_setting">
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
									<input type="text" id="trial_start" name="trial_start" class="form-control">
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
									<input type="text" id="trial_end" name="trial_end" class="form-control">
								</div>
							</div>
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
										<option value="1">Yes</option>
										<option value="0" selected>No</option>
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
										<option value="1">Yes</option>
										<option value="0" selected>No</option>
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
										<option value="1">Yes</option>
										<option value="0" selected>No</option>
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
								<select id="countries" class="multiselectsortable" name="multiselectsortable" size="16" aria-label="size 3 select example"></select>
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
                        <span>Save share</span>
                      </div>
	               </div>
	            </div>
	      </form>
	   </div>
	</div>
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

    $('#addfile').change(function(e){
        var fileName = e.target.files[0].name;
        $('.label-additional').html(fileName);
    });

    $('#file').change(function(e){
        var fileName = e.target.files[0].name;
        if(fileName != ''){
            $('.label-watermark').html(fileName);
        }
    });
    
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

   $(document).ready(function () {
   	// File upload via Ajax
   	$("#fileInput").change(function (e) {
   		var file = this.files[0];
   		var size = this.files[0].size;
   		var imp = <?php echo json_encode($imp);?>;
              if(imp < 100){
                  var limit = 2000000;
                  if(size > limit){
                      Swal.fire({
                          text: "The file upload size is restrcited to 2mb while your a free account or your impression counter is below 100. Do you wish to top up now?",
                          icon: 'warning',
                          showCancelButton: true,
                          confirmButtonColor: '#3085d6',
                          cancelButtonColor: '#d33',
                          confirmButtonText: 'Yes'
                        }).then((result) => {
                          if (result.isConfirmed) {
                            window.location = "setting.php";
                          }
                        })
                        $("#fileInput").val('');
                      return false;
                  }
               }
   		var fileType = file.type;
   		console.log(fileType);
   		//File Validation
   		var allowedTypes = ['application/pdf', 'image/jpeg', 'image/png', 'image/jpg', 'image/gif', 'video/mp4', 'video/webm', 'audio/mp3', 'audio/mpeg'];
   		var file = this.files[0];
   		var fileType = file.type;
   		//alert(fileType);
   		if (!allowedTypes.includes(fileType)) {
   			Swal.fire('We are only supporting this formates (PDF/JPEG/JPG/PNG/GIF/MP4/WEBM/MP3).')
   			$("#fileInput").val('');
   			return false;
   		} else {
   			$("#file_type").val(fileType);
   			e.preventDefault();
   			$.ajax({
   				xhr: function () {
   					var xhr = new window.XMLHttpRequest();
   					var t = 0;
   					var s = 0;
   					xhr.upload.addEventListener("progress", function (evt) {
   						$('.file-uploading.loader').show();
   						$('#file_upload img').hide();
   						$('#file_upload label').hide();
   						if (evt.lengthComputable) {
   							var percentComplete = ((evt.loaded / evt.total) * 100);
   							var a = Math.round(percentComplete);
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
   				processData: false,
   				beforeSend: function () {
   					//$(".progress-bar").width('0%');
   					$('#uploadStatus').html('<img src="https://shareio.com/image/giphy.gif" style="height: 50px;"/>');
   				},
   				error: function () {
   					$('#uploadStatus').html('<p style="color:#EA4335;">File upload failed, please try again.</p>');
   				},
   				success: function (resp) {
   					if (resp) {
   						$('#fileurl').val(myTrim(resp));
   						$('#uploadStatus img').attr('style', 'display: none');
   					} else if (resp == 'invalid') {
   						$('#uploadStatus').html('<p style="color:#red;">Invalid File Type, please try again.</p>');
   					} else if (resp == 'no') {
   						$('#uploadStatus').html('<p style="color:#EA4335;">File already exists, please try again.</p>');
   					}
   					$('#file_upload').hide();
   					$('.close-button').show();
   					//span6()addClass();
   					$('#uploadForm').addClass('form-file-upload');
   					$('#span6').addClass('files-uploaded');
   					if (fileType == 'application/msword') {
   						PreviewDocs(resp);
   					} else if (fileType == 'application/vnd.openxmlformats-officedocument.wordprocessingml.document') {
   						PreviewDocs(resp);
   
   					} else {
   						PreviewImage();
   					}
   					if (fileType == 'audio/mp3' || fileType == 'audio/mpeg') {
   						//audio_duration(resp);
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
   					$('.file-uploading.loader').hide();
   					bar.animate(0.0);
   				}
   			});
   		}
   	});
   }); 
</script>
<script type = "text/javascript" >
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
   
   				//$("#getduration").click();
   				//audio_duration(pdffile);
   
   
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
   docs_url = 'https://view.officeapps.live.com/op/embed.aspx?src=' + siteurl + resp;
   $('#docsviewer').attr('src', docs_url);
   }
   
   var iframe = $('#viewer').contents();
   iframe.click(function (event) {
   $('#fileInput').click();
   });
   
   
   jQuery('.close-button').on('click', function () {
   jQuery('#view-remove').remove();
   $('#file_upload').show();
   $('#file_upload img').show();
   $('#file_upload label').show();
   $('.close-button').hide();
   //$('.progress').hide();
   $('#uploadForm').removeClass('form-file-upload');
   $('#span6').removeClass('files-uploaded');
   });
   
   
   function audio_duration(resp) {
   var files = resp;
   
   jQuery.ajax({
   	type: "POST",
   	data: {
   		file: files,
   	},
   	url: "include/audio_duration/mp3file.class.php",
   	success: function (resp) {
   		$("#number").val(resp);
   		//$/("#myModal").attr("style" , "display: block");
   	}
   });
   }
   
   
   $('#evaluation_type').change(function () {
   var id = <?php echo json_encode($e_date_id);?>;
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
</script>

<script type="text/javascript" src="js/countryList.js"></script>

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

