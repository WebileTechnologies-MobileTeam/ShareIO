<?php    
//require('http.php');
require('./include/db.php');
require('./include/inc/defined_variables.php');
session_start();
if($_GET['content'] == 'tab1'){?>
<div class="ui-v3_upload_content_leftside">
    <button class="ui-v3_close-button" aria-label="Close alert" type="button" style="display: none;">
        <span aria-hidden="true">&times;</span>
    </button>             <!-- File upload form -->		
    <form class="uploadForm" action="test.php" enctype="multipart/form-data">
        <div style="clear:both; display:none;" class="viewer-file">
            
        </div>
        <div class="form-group ui-v3_files ui-v3_tooltip_shows file_upload">
            <img src="images/file_upload.png" alt="File upload" />
            <label>Click or drag file to upload </label>
            <input type="file" name="uploadfile" class="fileInput" accept="application/pdf, image/jpeg, image/png, image/jpg, image/gif, video/mp4, video/webm, .mp3, mpeg">
                <div class="ui-v3_bottom">
                    <span>Upload content to share</span> 
                </div>
        </div>
        
        <label id="errorfile" style="color: red;"></label>
        <div id="container" style="display: none;"></div><div class="loader" style="display: none;"></div>
    </form>
    <div id="uploadStatus" style="display: none;"></div>
</div>
<div class="ui-v3_upload_content_rightside">
        <!-- /widget-header -->            
        <div class="ui-v3_upload-contents">
        <div class="ui-v3_upload_content_form upload_content_form1">
            <div class="ui-v3_upload-content">
                <div class="form-row">
                    <div class="evprunclock form-group">
                        <input type="hidden" name ="fileurl" id = "fileurl">
                        <label for="selectpage" class="col-form-label">Evaluation
                            <div class="ui-v3_tooltip_shows">
                                <i class="fa fa-question-circle" aria-hidden="true"></i>
                                <div class="ui-v3_bottom">
                                    <span>Evaluation type for showing content</span> 
                                </div>
                            </div>
                        </label>
                        <input type="hidden" id="file_type" name="file_type" class="form-control">											                           
                        <div class="ui-v3_select_box">
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
                            <div class="ui-v3_tooltip_shows">
                                <i class="fa fa-question-circle" aria-hidden="true"></i>
                                <div class="ui-v3_bottom">
                                    <span>Evaluation settings</span> 
                                </div>
                            </div>
                        </label>
                        <input class="form-control" id="number" type="hidden" name="number" value="1">
                        <input class="form-control" id="evaluation_value" type="text" name="evaluation_value">
                        <input class="form-control" id="evaluation_date" type="date" name="evaluation_date" style="display: none;">
                        <label id="errorevl" style="color: red;"></label>
                    </div>
                    <div class="evprunclock form-group price_field">
                        <label for="selectpage" class="col-form-label">Price ($)
                            <div class="ui-v3_tooltip_shows">
                                <i class="fa fa-question-circle" aria-hidden="true"></i>
                                <div class="ui-v3_bottom">
                                    <span>Price to purchase the content</span> 
                                </div>
                            </div>
                        </label>
                        <input type="text" id="price" name="price" class="form-control" value="1">
                    </div>
                    <label id="error" style="color: red;"></label>									                     
                </div>
                <div class="form-row">
                    <div class="col-half form-group">
                        <label for="selectpage" class="col-form-label">Watermark
                            <div class="ui-v3_tooltip_shows">
                                <i class="fa fa-question-circle" aria-hidden="true"></i>
                                <div class="ui-v3_top">
                                    <span>Watermark overlay on your content</span> 
                                </div>
                            </div>
                        </label>
                        <div class="ui-v3_select_box">
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
                            <div class="ui-v3_tooltip_shows">
                                <i class="fa fa-question-circle" aria-hidden="true"></i>
                                <div class="ui-v3_top">
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
                            <div class="ui-v3_tooltip_shows">
                                <i class="fa fa-question-circle" aria-hidden="true"></i>
                                <div class="ui-v3_top">
                                    <span>Watermark text or image overlayed over your content</span> 
                                </div>
                            </div>
                        </label>
                        <div class="custom-file">
                            <input type="file" class="custom-file-input" id="file" name="file">
                            <label class="custom-file-label label-watermark" for="inputGroupFile01">Browse</label>
                        </div>
                    </div>
                    <label id="errorw" style="color: red;"></label>									                     
                </div>
                <!--<div class="form-row">										<div class="form-group paused">											<label for="selectpage" class="col-form-label">Paused</label>											<div class="pause-action">												<span class="left">													<input type="radio" id="yes" name="paused" value="yes">													<label for="yes">Yes</label>												</span>												<span class="left">													<input type="radio" id="no" name="paused" value="no" checked>													<label for="no">No</label>												</span>                        </div>                        </div>									</div> -->                     
                <div class="form-row">
                    <div class="col-full form-group fileUpload">
                        <label for="selectpage" class="col-form-label">Additional File(s)
                            <div class="ui-v3_tooltip_shows">
                                <i class="fa fa-question-circle" aria-hidden="true"></i>
                                <div class="ui-v3_top">
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
        
        <div class="ui-v3_forms_icons">
            <div class="text-center processbutton ui-v3_addfile_button">
                <button type="button" onclick="submitfiledata()">
                <img src="images/check_btn.png" alt="Checkbtn" />
                </button>
            </div>
        </div>
        </div>
</div>
<?php } elseif($_GET['content'] == 'tab2'){?>
<div class="ui-v3_upload_content_leftside">
    <button class="ui-v3_close-button" aria-label="Close alert" type="button" style="display: none;">
        <span aria-hidden="true">&times;</span>
    </button>
    <!-- File upload form -->		
    <form id="uploadForm" action="test.php" enctype="multipart/form-data">
        <div style="clear:both;display:none;" class="viewer-file">
            
        </div>
        <div class="form-group ui-v3_files ui-v3_tooltip_shows file_upload">
            <img src="images/file_upload.png" alt="File upload" />
            <label>Click or drag file to upload </label>
            <input type="file" name="uploadfile" class="fileInput" accept="application/pdf, image/jpeg, image/png, image/jpg, image/gif, video/mp4, video/webm, .mp3, mpeg">
                <div class="ui-v3_bottom">
                    <span>Upload content to share</span> 
                </div>
        </div>
        
        <label id="errorfile" style="color: red;"></label>
        <div id="container" style="display: none;"></div><div class="loader" style="display: none;"></div>
    </form>
    <div id="uploadStatus" style="display: none;"></div>
</div>
<div class="ui-v3_upload_content_rightside">
        <!-- /widget-header -->            
        <div class="ui-v3_upload-contents">
        <div class="ui-v3_upload_content_form ui-v3_upload_content_form2">
            <div class="ui-v3_upload-content">
                <div class="form-row" id="trial_setting">
                    <div class="form-group">
                        <label for="selectpage" class="col-form-label" id="trial_s">Start (page)
                            <div class="ui-v3_tooltip_shows">
                                <i class="fa fa-question-circle" aria-hidden="true"></i>
                                <div class="ui-v3_bottom">
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
                            <div class="ui-v3_tooltip_shows">
                                <i class="fa fa-question-circle" aria-hidden="true"></i>
                                <div class="ui-v3_bottom">
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
                            <div class="ui-v3_tooltip_shows">
                                <i class="fa fa-question-circle" aria-hidden="true"></i>
                                <div class="ui-v3_top">
                                    <span>Downloadable after purchase</span> 
                                </div>
                            </div>
                        </label>
                        <div class="ui-v3_select_box">
                            <select class="form-control select2" data-toggle="select2" id="download" name="download">
                                <option value="1">Yes</option>
                                <option value="0" selected>No</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group ui-v3_social_share">
                        <label for="selectpage" class="col-form-label">Social Share
                            <div class="ui-v3_tooltip_shows">
                                <i class="fa fa-question-circle" aria-hidden="true"></i>
                                <div class="ui-v3_top">
                                    <span>Display social share buttons one shared content</span> 
                                </div>
                            </div>
                        </label>
                        <div class="ui-v3_select_box">
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
                            <div class="ui-v3_tooltip_shows">
                                <i class="fa fa-question-circle" aria-hidden="true"></i>
                                <div class="ui-v3_top">
                                    <span>Disable view via browser and force view via mobile app</span> 
                                </div>
                            </div>
                        </label>
                        <div class="ui-v3_select_box">
                            <select class="form-control select2" data-toggle="select2" id="browser_view" name="browser_view">
                                <option value="1" selected>Yes</option>
                                <option value="0">No</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group ui-v3_notifications">
                        <label for="selectpage" class="col-form-label">Notifications
                            <div class="ui-v3_tooltip_shows">
                                <i class="fa fa-question-circle" aria-hidden="true"></i>
                                <div class="ui-v3_top">
                                    <span>Display notifications on shared content if parameters are updated</span> 
                                </div>
                            </div>
                        </label>
                        <div class="ui-v3_select_box">
                            <select class="form-control select2" data-toggle="select2" id="notification" name="notification">
                                <option value="1">Yes</option>
                                <option value="0" selected>No</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="form-row ui-v3_password_dns">
                    <div class="form-group ui-v3_password">
                        <label class="col-form-label">Password
                            <div class="ui-v3_tooltip_shows">
                                <i class="fa fa-question-circle" aria-hidden="true"></i>
                                <div class="ui-v3_top">
                                    <span>Require password shared content can be opened</span> 
                                </div>
                            </div>
                        </label>
                        <input type="password" class="form-control" name="password" id="password">
                    </div>
                    <div class="form-group ui-v3_ip_dns_lock">
                        <label class="col-form-label">IP / DNS lock
                            <div class="ui-v3_tooltip_shows">
                                <i class="fa fa-question-circle" aria-hidden="true"></i>
                                <div class="ui-v3_top">
                                    <span>Force the content to be only opened on set IP / DNS</span> 
                                </div>
                            </div>
                        </label>
                        <input type="text" class="form-control" name="ip_dns" id="ip_dns">
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group">
                        <label for="selectpage" class="col-form-label">Hide Banner
                            <div class="ui-v3_tooltip_shows">
                                <i class="fa fa-question-circle" aria-hidden="true"></i>
                                <div class="ui-v3_top">
                                    <span>Hide the banner when link is displayed.</span> 
                                </div>
                            </div>
                        </label>
                        <div class="ui-v3_select_box">
                            <select class="form-control select2" data-toggle="select2" id="hide_banner" name="hide_banner">
                                <option value="1">Yes</option>
                                <option value="0" selected>No</option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="ui-v3_forms_icons">
            <div class="text-center processbutton ui-v3_addfile_button">
                <button type="button" onclick="submitfiledata()">
                <img src="images/check_btn.png" alt="Checkbtn" />
                </button>
            </div>
        </div>
        </div>
</div>
<?php } else{?>
<div class="ui-v3_upload_content_rightside ui-v3_upload_content_component3">
    <!-- /widget-header -->            
    <div class="ui-v3_upload-contents">
        <div class="ui-v3_upload_content_form ui-v3_upload_content_form3">
            <div class="ui-v3_upload-content"> 
                <div class="ui-v3_upload_content_form3_leftside">
                    <div class="ui-v3_view_countries_title"><span>Countries this content is viewable : </span></div>
                    <div class="ui-v3_view_countries">
                        <select id="countries" size="16" aria-label="size 3 select example"></select>
                    </div> 
                </div>

                <div class="ui-v3_upload_content_form3_middleside">
                    <div class="arrow_icon">
                        <svg xmlns="http://www.w3.org/2000/svg" enable-background="new 0 0 24 24" viewBox="0 0 24 24" fill="#000000"><g><rect fill="none" height="24" width="24" x="0"/></g><g><g><a href="javascript:void(0)" class="arrow_left"><polygon points="7.41,13.41 6,12 2,16 6,20 7.41,18.59 5.83,17 21,17 21,15 5.83,15"/></a><a href="javascript:void(0)" class="arrow_right"><polygon points="16.59,10.59 18,12 22,8 18,4 16.59,5.41 18.17,7 3,7 3,9 18.17,9"/></a></g></g></svg>
                    </div> 
                </div>

                <div class="ui-v3_upload_content_form3_rightside">
                    <div class="block_countries_title"><span>Countries this content is blocked : </span></div>
                    <div class="block_countries">
                        <select id="block_country" size="16" aria-label="size 3 select example"></select>
                    </div> 
                    <div id="block_country_db"></div>
                </div>


            </div>
        </div>
    </div>
</div>
<script type="text/javascript" src="js/countryList.js"></script>
<script type="text/javascript">
    
    $(document).ready(function() {
    var wrapper = $("#block_country");
    $('.arrow_right').click(function(e){ 
        var x = $('#countries :selected').text(); 
        var xx = $('#countries :selected').val(); 
        if(x != "") {
        $(wrapper).append('<option class="blk-country" value="'+xx+'">'+x+'</option>');
        $('#countries option:selected').remove();
        }
        var my_options = $("#block_country option");
        my_options.sort(function(a,b) {
            if (a.text > b.text) return 1;
            if (a.text < b.text) return -1;
            return 0
        })
        $("#block_country").empty().append( my_options );
    }); 

        $('.arrow_left').click(function(e){ 
        var x = $('#block_country :selected').text();
        var xx = $('#block_country :selected').val();
        $('#block_country option:selected').remove(); 
        if(x != "") {
            $('#countries').append('<option value="'+xx+'">'+x+'</option>');
        }
        var my_options = $("#countries option");
        my_options.sort(function(a,b) {
            if (a.text > b.text) return 1;
            if (a.text < b.text) return -1;
            return 0
        })
        $("#countries").empty().append( my_options );
    });
    });
</script>
<?php }?>

