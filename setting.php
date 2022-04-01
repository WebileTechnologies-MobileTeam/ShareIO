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
<title>Setting - ShareIO</title>

<?php require('./include/db.php');
	session_start(); ?>
<?php require('head.php'); ?>
<head>
<link href="css/wcolpick.css" rel="stylesheet" type="text/css">
<style>
    #colorSelector2 {
    	top: 0;
    	left: 0;
    	width: 36px;
    	height: 36px;
    	background: url(images/select2.png);
    }
    #colorSelector2 div {
    	position: absolute;
    	top: 4px;
    	left: 4px;
    	width: 28px;
    	height: 28px;
    	background: url(images/select2.png) center;
    }
    
    #colorSelector3 {
    	top: 0;
    	left: 0;
    	width: 36px;
    	height: 36px;
    	background: url(images/select2.png);
    }
    #colorSelector3 div {
    	position: absolute;
    	top: 4px;
    	left: 4px;
    	width: 28px;
    	height: 28px;
    	background: url(images/select2.png) center;
    }
</style>
</head>
	<body>
		<?php require('header-new.php'); 
		?>
		<main>
			<div class="container new_container">
				<div class="row">
					<div class="col-md-12">
						<div class="main_content hidden">
							 <?php if (isset($_SESSION['paymentsuccess'])){ ?>  
					            <input type="hidden" id="succsessmsg" name="succsessmsg" value="<?php echo $_SESSION['paymentsuccess'];?>">
					            <a style="text-decoration: none;" id="getcontent" data-toggle="modal" data-target="#paymentsuccess-modal" data-id="1"></a>
					              <script>
					                jQuery(document).ready(function($) {
					                  var msg = $('#succsessmsg').val();
					                  if(msg != ''){
											cuteAlert({
												type: "success",
												title: "Thank You !",
												message: "Impressions Added to your account.",
												buttonText: "Close"
											})
					                      }
					                    });
					              </script>
					            <?php 
					               unset($_SESSION['paymentsuccess']);
					               }?>
					               <?php 
					               if (isset($_SESSION['succsessmsg'])){ ?>  
					            <input type="hidden" id="succsessmsg" name="succsessmsg" value="<?php echo $_SESSION['succsessmsg'];?>">
					              <script>
					                jQuery(document).ready(function($) {
					                  var msg = $('#succsessmsg').val();
					                  if(msg != ''){
					                     	var html = '<img src="<?php echo SITE_URL;?>/image/paymentsuccess.png" style="height: 100px;"><h1>Success !</h1><p>Password Changed Successfully.</p><a href="#0" class="cd-popup-close img-replace">Close</a>';
					                        $('.cd-popup').addClass('is-visible');
		
											$(".cd-popup-container").html(html);
											//$(".close").css("display", "none");
					                      }
					                    });
					              </script>
					            <?php 
					               unset($_SESSION['succsessmsg']);
					               }?>
							<div class="cd-popup" role="alert">
								<div class="cd-popup-container payment_modal_popup">

								</div> <!-- cd-popup-container -->
							</div>

							<div id="paymentsuccess-modal" class="modal fade" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
				                  <div class="modal-dialog modal-dialog-centered">

				                  <!-- Modal content-->
				                    <div class="modal-content">
				                      <div class="modal-header">
				                        <button type="button" class="close" data-dismiss="modal">×</button>
				                      </div>
				                      <div class="modal-body">
				                        <div class="container-fluid" id="paymentsuccess-model-popup">
				                          <img src="<?php echo SITE_URL;?>/image/paymentsuccess.png" style="height: 100px;">
                    					  <h1>Success !</h1>
				                        </div>
				                      </div>
				                    </div>
				                  </div>
				               </div>



							<div class="stripe_bg">
							    <div class="top_default_icons">
                                    <div class="icons university_icon active tooltip_shows">
                                        <a onclick="university_icon()" href="javascript:;" class="active">
                                           <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 0 24 24" width="24px" fill="#000000"><path d="M0 0h24v24H0V0z" fill="none"/><path d="M6.5 10h-2v7h2v-7zm6 0h-2v7h2v-7zm8.5 9H2v2h19v-2zm-2.5-9h-2v7h2v-7zm-7-6.74L16.71 6H6.29l5.21-2.74m0-2.26L2 6v2h19V6l-9.5-5z"/>
                                            </svg>
                                        </a>
                                        <div class="top">
											<span>General settings</span> 
										</div>
                                    </div>
                                    <div class="icons dashboard_icon tooltip_shows">
                                        <a onclick="dashboard_icon()" href="javascript:;">
                                           <svg xmlns="http://www.w3.org/2000/svg" enable-background="new 0 0 24 24" height="24px" viewBox="0 0 24 24" width="24px" fill="#000000"><g><rect fill="none" height="24" width="24"/></g><g><g><g><g><path d="M12,22C6.49,22,2,17.51,2,12S6.49,2,12,2s10,4.04,10,9c0,3.31-2.69,6-6,6h-1.77c-0.28,0-0.5,0.22-0.5,0.5 c0,0.12,0.05,0.23,0.13,0.33c0.41,0.47,0.64,1.06,0.64,1.67C14.5,20.88,13.38,22,12,22z M12,4c-4.41,0-8,3.59-8,8s3.59,8,8,8 c0.28,0,0.5-0.22,0.5-0.5c0-0.16-0.08-0.28-0.14-0.35c-0.41-0.46-0.63-1.05-0.63-1.65c0-1.38,1.12-2.5,2.5-2.5H16 c2.21,0,4-1.79,4-4C20,7.14,16.41,4,12,4z"/><circle cx="6.5" cy="11.5" r="1.5"/><circle cx="9.5" cy="7.5" r="1.5"/><circle cx="14.5" cy="7.5" r="1.5"/><circle cx="17.5" cy="11.5" r="1.5"/></g></g></g></g>
                                           </svg>
                                        </a>
										<div class="top">
											<span>Viewing settings</span> 
										</div>	
                                    </div>
                                    
                        
                                  
                                    <div class="icons close_icon">
                                        <a href="dashboard.php">
                                           <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 0 24 24" width="24px" fill="#000000"><path d="M0 0h24v24H0V0z" fill="none"></path><path d="M19 6.41L17.59 5 12 10.59 6.41 5 5 6.41 10.59 12 5 17.59 6.41 19 12 13.41 17.59 19 19 17.59 13.41 12 19 6.41z"></path>
                                           </svg>
                                        </a>
                                        
                                    </div>

                                </div>
                                <?php
    									$sql = "SELECT * from cs_users where id = '" . $_SESSION["user"] . "' OR oauth_uid =  '" . $_SESSION["user"] . "'";
                                        $result = mysqli_query($con,$sql);
                                        $fetch_data = mysqli_fetch_array($result);
                                   		$stripe = \Stripe\Account::retrieve(
    									  $fetch_data['stripe_acc_id']
    									);
    									$status = '';
    									if($stripe['charges_enabled'] != '1'){
    										$status = "Disabled";
    									}else{
    										$status = "Enabled";
    									}
    									$impressions = '';
    									if($fetch_data['impressions'] == ''){
    										$impressions = '0';
    									} else{
    										$impressions = $fetch_data['impressions'];
    									}
    
    									$files = 0;
    									$sales = 0;
    
    									$file_data = "SELECT * from sentfile where added_by = '" . $_SESSION["user"] . "' ";
    					                $file_data_result = mysqli_query($con,$file_data);
    					                if (mysqli_num_rows($file_data_result) > 0) { 
    	                                	while($file_data_fetch_data = mysqli_fetch_array($file_data_result)){
    	                                		$files++;
    	                                		$sale_data = "SELECT SUM(transfer_amount) as totalsale from payments where file_id = '" . $file_data_fetch_data["file_id"] . "' ";
    							                $sale_data_result = mysqli_query($con,$sale_data);
    							                $sale_data_fetch_data = mysqli_fetch_array($sale_data_result);
    							                $sales = $sales + $sale_data_fetch_data['totalsale'];
    
    	                                	}
    	                                }
    
    	                                $commision_data = "SELECT * from system_data where system_id = '1' ";
    				                    $commision_data_result = mysqli_query($con,$commision_data);
    				                    $commision_data_fetch_data = mysqli_fetch_array($commision_data_result);
    				                    $percent = (int)$commision_data_fetch_data['sales_commision'];
                                        $impressions_cost = (int)$commision_data_fetch_data['impression_cost_per_1k'];
                                        $impressions_value = 1000 * 100 / $impressions_cost;
    									?>
                                <div class="stripe_inner_containt">
    							    <div class="stripe_content_left">
    									<div class="stripe_status">
    									    <div class="stripe_status_user">
    									        <?php if($fetch_data['user_profile_url'] == ''){ ?>
    									        <img src="images/user_icon.png" alt="User">
    									        <?php } else{ ?>
    									        <img src="<?php echo $fetch_data['user_profile_url'];?>" alt="User" ismap>
    									        <?php }?>
    									    </div>
    										<p><span>User :</span> <?php echo $fetch_data['fname'].' '.$fetch_data['lname'];?> </p>
    										<p><span>Joined :</span> <?php echo $fetch_data['create_date'];?></p>
    										<p><span>Shared :</span> <?php echo $files;?> files</p>
    										<p><span>Impressions :</span> <?php echo $impressions;?></p>
    										<p><span>Sales :</span> <?php echo '$'.number_format($sales);?></p>
    									    <div class="update-org">
                                                <input type="text" name="organization" class="form-control" id="organization" value="<?php echo $fetch_data['organization'];?>">
                                                <a id="update-org" class="change_stipe_account">Update Organization</a>   
                                            </div>
    									</div>
    								</div>
    								<div class="stripe_content_right">
    									
    									<div class="stripe_content_list">
    										<p>Any sales you make will be transfered to your Stripe account minus our commission of <span><?php echo $percent.'%';?></span></p>
    										<div class="stripe_id">	
    											<label>Stripe Account: <?php if($status == 'Enabled'){;?>
    												<span class='badge badge-success'>Enabled <svg aria-hidden="true" class="SVGInline-svg SVGInline--cleaned-svg SVG-svg Icon-svg Icon--check-svg Icon-color-svg Icon-color--blue500-svg" height="12" width="12" viewBox="0 0 16 16" xmlns="http://www.w3.org/2000/svg"><path d="M5.297 13.213L.293 8.255c-.39-.394-.39-1.033 0-1.426s1.024-.394 1.414 0l4.294 4.224 8.288-8.258c.39-.393 1.024-.393 1.414 0s.39 1.033 0 1.426L6.7 13.208a.994.994 0 0 1-1.402.005z" fill-rule="evenodd"></path></svg></span>
													<div class="stripe_account_info">
														<a id="change_stripe_acc" class="change_stipe_account">Change Account</a>
														<?php
														$loginlink = \Stripe\Account::createLoginLink($fetch_data['stripe_acc_id']);
														?>
														<a id="view_stripe_dashboard" class="change_stipe_account" href="<?php echo $loginlink['url'];?>" target="_blank">View Dashboard</a>
													</div>
												<?php } else{
    												$url = '#';
    												if($fetch_data['stripe_acc_id'] != ''){
														
    													$account_links = \Stripe\AccountLink::create([
    													  'account' => $fetch_data['stripe_acc_id'],
    													  'refresh_url' => 'https://shareio.com/setting.php',
    													  'return_url' => 'https://shareio.com/dashboard.php',
    													  'type' => 'account_onboarding',
    													]);
    													$url = $account_links['url'];
    												}
    												?>
    												<span class='badge badge-danger'>Disabled <svg aria-hidden="true" class="SVGInline-svg SVGInline--cleaned-svg SVG-svg Icon-svg Icon--block-svg Icon-color-svg Icon-color--red500-svg" height="15" width="15" viewBox="0 0 16 16" xmlns="http://www.w3.org/2000/svg"><path d="M8 16A8 8 0 1 1 8 0a8 8 0 0 1 0 16zm-3.477-3.11a6 6 0 0 0 8.367-8.367zM3.11 11.478l8.368-8.368a6 6 0 0 0-8.367 8.367z"></path></svg>
    												</span>
    											</label>
    
    											<a href="<?php echo $url;?>" class="activate_account">Activate Account</a>
    											<?php }?>
    										</div>
    									</div>
    									<div class="stripe_content_list currently_impressions">
    										<p>You currently have <span><?php echo $impressions;?></span> impressions left top-up anytime <?php echo '$'.$impressions_cost;?> buys <span>1000</span> impressions (shares)</p>
    										<div class="stripe_id">	
    											<label>Top-up Amount</label>
    											<input type="text" class="form-control" value="100" name="price" id="price">
    											<span id="top-up">Buys you <?php echo number_format($impressions_value);?> impressions.</span>
    											<span id="price_valid" style="display: none;color: red;">Please Enter Amount greater than $1.</span>
    											<a href="#0" class="cd-popup-trigger" id="getcontent">Buy</a>
    										</div>
    									</div>
    								</div>
								</div>
								<?php
								$userconfig = "SELECT * from user_config WHERE user_id = '" . $_SESSION["user"] . "'";
                                $configresult = mysqli_query($con,$userconfig);
                                $config_data = mysqli_fetch_array($configresult);
                                $banner_bg = '#222';
                                $page_bg1 = '#3c63ae';
                                $page_bg2 = '#34b3e8';

                                if($config_data['banner_color'] != ''){
                                    $banner_bg = $config_data['banner_color'];
                                }
                                if($config_data['page_bg_color_1'] != ''){
                                    $page_bg1 = $config_data['page_bg_color_1'];
                                }
                                if($config_data['page_bg_color_2'] != ''){
                                    $page_bg2 = $config_data['page_bg_color_2'];
                                }
								?>
								<div class="user_content_change">
								    <p>Customize how your users view content <span>(click to change):</span> <a class="save_btn" href="javascript:;" style="display: none;">
								            <i class="fa fa-check" aria-hidden="true"></i>
								            <span>Save</span>
								        </a></p>
								    <div class="user_customize_header" <?php if($config_data['banner_color'] != ''){?>style="background: <?php echo $config_data['banner_color'];?>;"<?php }?> id="colorSelector">
								        <a href="javascript:;" id="logo_change">
								            <?php if($config_data['banner_logo_url'] != ''){ ?>
								           <img src="<?php echo $config_data['banner_logo_url'];?>" id="logo" alt="Logo">
								           <?php } else{?>
								           <img src="images/content-share-new-logo.png" id="logo" alt="Logo">
								           <?php }?>
								        </a>
								        
								        
								        <input type="hidden" id="banner_bg" value="<?php echo $banner_bg;?>">
								    </div>
								    <input type="file" id="user_config_logo" name="config_logo" style="display: none;">
								    <div class="user_customize_content" style="background: linear-gradient(180deg, <?php echo $page_bg1;?> 3%, <?php echo $page_bg2;?> 80%);">
								        <div class="user_customize_content_container">
								            <h1>Content</h1>
								        </div>
								    </div>
								    <div class="page_bg_configration" style="display: none;">
								        <b>Choose Colors for Page backgraund:</b>
								        <label>Color 1<div id="colorSelector2" style="background-color: <?php echo $page_bg1;?>"></div></label>
								        <label>Color 2<div id="colorSelector3" style="background-color: <?php echo $page_bg2;?>"></div></label>
								        <input type="hidden" id="page_bg_1" value="<?php echo $page_bg1;?>">
								        <input type="hidden" id="page_bg_2" value="<?php echo $page_bg2;?>">
								    </div>
								    <div class="refresh_icon" <?php if(mysqli_num_rows($configresult) < 1){?> style="display: none;" <?php }?>>
								    <a href="javascript:;" id="reset_config">
								        <svg xmlns="http://www.w3.org/2000/svg" enable-background="new 0 0 24 24" height="24px" viewBox="0 0 24 24" width="24px" fill="#000000"><g><path d="M0,0h24v24H0V0z" fill="none"/></g><g><g><path d="M6,13c0-1.65,0.67-3.15,1.76-4.24L6.34,7.34C4.9,8.79,4,10.79,4,13c0,4.08,3.05,7.44,7,7.93v-2.02 C8.17,18.43,6,15.97,6,13z M20,13c0-4.42-3.58-8-8-8c-0.06,0-0.12,0.01-0.18,0.01l1.09-1.09L11.5,2.5L8,6l3.5,3.5l1.41-1.41 l-1.08-1.08C11.89,7.01,11.95,7,12,7c3.31,0,6,2.69,6,6c0,2.97-2.17,5.43-5,5.91v2.02C16.95,20.44,20,17.08,20,13z"/></g></g>
							            </svg>
								    </a>
								</div>
								</div>

							</div>
							
								
						</div>
					</div>
				</div>
			</div>
		</main>
		<?php require('footer-new.php'); ?>
	</body>
<script src="js/wcolpick.js"></script>
<script>
	jQuery(function() {
        $('#colorSelector').loads({
            layout: 'hex',
            flat: false,
            enableAlpha: false,
            color: '317dd4',
            onChange: function(ev) {
                $('#colorSelector').css('backgroundColor', '#' + ev.hex);
				$('#banner_bg').val('#'+ev.hex);
				$('.save_btn').show();
            }
        });

        $('#colorSelector2').loads({
            layout: 'hex',
            flat: false,
            enableAlpha: false,
            color: $('#page_bg_1').val(),
            onChange: function(ev) {
                var pageBg2 = $('#page_bg_2').val();
				$('.user_customize_content').css('background', 'linear-gradient(180deg, #'+ev.hex+' 3%, '+pageBg2+' 80%)');
				$('#colorSelector2').css('backgroundColor', '#' + ev.hex);
				$('#page_bg_1').val('#'+ev.hex);
				$('.save_btn').show();
            }
        });

		$('#colorSelector3').loads({
            layout: 'hex',
            flat: false,
            enableAlpha: false,
            color: $('#page_bg_2').val(),
            onChange: function(ev) {
                var pageBg1 = $('#page_bg_1').val();
				$('.user_customize_content').css('background', 'linear-gradient(180deg, '+pageBg1+' 3%, #'+ev.hex+' 80%)');
				$('#colorSelector3').css('backgroundColor', '#' + ev.hex);
				$('#page_bg_2').val('#'+ev.hex);
				$('.save_btn').show();
            }
        });
    });
    
    $('.user_customize_content').on('click', function(){
    	$('.page_bg_configration').show();
    });

    $("#update-org").on('click', function() {
        var organization = $('#organization').val();
        var userId = <?php echo json_encode($fetch_data['id']);?>;
        var url = "include/SaveUserConfig.php";            
        $.ajax({
            type: "POST",
            url: url,
            data: {
              updateorg: 'updateorg',
              userId:userId,
              organization:organization
            },
            success: function(res) {
              if(res.replace(/\s/g, "") == 'error'){
                  cuteAlert({
                    type: "error",
                    title: "Oops...",
                    message: "There is some issue please try again.",
                    buttonText: "Close"
                  })
                } else {
                    cuteAlert({
                        type: "success",
                        title: "Thank You !",
                        message: res,
                        buttonText: "Close"
                    })
                }  
            }
        });
    });

    $('.save_btn').on('click', function(){
       var userId = <?php echo json_encode($_SESSION["user"]);?>;
       var bannerBg = $('#banner_bg').val();
       var pageBg1 = $('#page_bg_1').val();
       var pageBg2 = $('#page_bg_2').val();

       
       $.ajax({
		type: "POST",
		url: "include/SaveUserConfig.php",
		data:{
			userId:userId,
			bannerBg:bannerBg,
			pageBg1:pageBg1,
			pageBg2:pageBg2
		},
		success: function(resp){ 
			//if(resp == 'true'){
			    $('.save_btn').hide();
			    $('.page_bg_configration').hide();
			    $('.refresh_icon').show();
			    Swal.fire({
                  title: 'Layout Now Saved.',
                  icon: 'success',
                  showConfirmButton: false,
                  timer: 3000
                });
			}
			//}
		});
    });

	$("#change_stripe_acc").on("click", function(){
		var userId = <?php echo json_encode($_SESSION["user"]);?>;
		$.ajax({
		type: "POST",
		url: "changestripeacc.php",
		data:{
			id:userId
		},
		success: function(resp){ 
			window.location = resp;
		}
		});
	});
    
    $('#logo_change').on('click', function() {
        $('#colorSelector').ColorPickerHide();
        $('#user_config_logo').click();
    });
    
    $('#user_config_logo').change(function(){
        var fd = new FormData();
        var files = $('#user_config_logo')[0].files[0];
        var userId = <?php echo json_encode($_SESSION["user"]);?>;
        var bannerBg = $('#banner_bg').val();
        var pageBg1 = $('#page_bg_1').val();
        var pageBg2 = $('#page_bg_2').val();
        fd.append('file',files);
        fd.append('userId',userId);
        fd.append('action','logo');
        fd.append('bannerBg',bannerBg);
        fd.append('pageBg1',pageBg1);
        fd.append('pageBg2',pageBg2);
        $.ajax({
            url: 'include/SaveUserConfig.php',
            type: 'post',
            data: fd,
            contentType: false,
            processData: false,
            success: function(response){
                $('#logo').attr("src", response);
                $('#colorSelector').ColorPickerHide();
                $('.refresh_icon').show();
                Swal.fire({
                  title: 'Logo Changed Successfully.',
                  icon: 'success',
                  showConfirmButton: false,
                  timer: 3000
                });
            }
        });
    });
    
    $('#reset_config').on('click', function(){
        var userId = <?php echo json_encode($_SESSION["user"]);?>;
        cuteAlert({
              type: "question",
              title: "Reset",
              message: "Do you wish to reset to default layout?",
              confirmText: "Yes",
              cancelText: "Cancel"
          }).then((e)=>{
            if ( e == ("confirm")){
            $.ajax({
    		type: "POST",
    		url: "include/SaveUserConfig.php",
    		data:{
    			userId:userId,
    			reset:'true'
    		},
    		success: function(resp){ 
    			//if(resp == 'true'){
    			    $('.save_btn').hide();
    			    $('#logo').attr("src", 'images/content-share-new-logo.png');
    			    $('#colorSelector').css('backgroundColor', '#222');
    			    $('.user_customize_content').css('background', 'linear-gradient(180deg, #3c63ae 3%, #34b3e8 80%)');
    			    $('#banner_bg').val('#222');
    			    $('#page_bg_1').val('#3c63ae');
    			    $('#page_bg_2').val('#34b3e8');
    			    $('.refresh_icon').hide();
    			    Swal.fire({
                      title: 'Layout Reset Successfully.',
                      icon: 'success',
                      showConfirmButton: false,
                      timer: 3000
                    });
    			//}
    			}
    		});
          }
        })
       
    });

	jQuery(document).ready(function($){

	$( ".main_content" ).removeClass("hidden");
	//open popup
	$('.cd-popup-trigger').on('click', function(event){
		event.preventDefault();

		var id = <?php echo json_encode($fetch_data['id'])?>;
		var price = $('#price').val();
		if(price == ''){
			$('#price_valid').show();
			return;
		}

		$('.cd-popup').addClass('is-visible');
		
		$.ajax({
		type: "POST",
		url: "include/purchase-impression.php",
		data:{
			id:id,
			price:price
		},
		success: function(html){ 
			$(".cd-popup-container").html(html);
			//$(".close").css("display", "none");
			}
		});
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

	function addCommas(nStr)
	{
	    nStr += '';
	    x = nStr.split('.');
	    x1 = x[0];
	    x2 = x.length > 1 ? '.' + x[1] : '';
	    var rgx = /(\d+)(\d{3})/;
	    while (rgx.test(x1)) {
	        x1 = x1.replace(rgx, '$1' + ',' + '$2');
	    }
	    return x1 + x2;
	}

	$('#price').on('keyup',function(){
        var cost = <?php echo json_encode($impressions_cost);?>;
	    var tot = $('#price').val() * 1000 / cost;
	    var topup = addCommas(tot)
	    $('#top-up').html('Buys you '+topup+' impressions.');
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

</script>
</html>