<!DOCTYPE html>
<html lang="en">
<?php require('../include/db.php');
require('../include/inc/defined_variables.php');
session_start(); ?>
<?php require('head.php'); 
?>
<body class="setting-cls">

<div class="main">
  <div class="main-inner">
    <div class="container">
    	<?php
    	if (isset($_SESSION['message'])){ ?>  
              <div class="alert alert-success fade in">
                    <a href="#" class="close" data-dismiss="alert">&times;</a>
                    <strong><?php echo $_SESSION['message']; ?></strong> 
                </div>
              <?php 
               unset($_SESSION['message']);
               } ?>
      <div class="row">

      	<div id="edit-order-modal" class="modal fade setting-model" role="dialog">
						<div class="modal-dialog">

							<!-- Modal content-->
							<div class="modal-content">
								<div class="modal-header">
									<button type="button" class="close" data-dismiss="modal">×</button>
									<!--<h4 class="modal-title">Add</h4>-->
								</div>
								<div class="modal-body">
									<div class="container-fluid" id="orderform">
										<script>
											jQuery(document).ready(function($) {
													$("#googleon").on('click',function() {
															$.ajax({
																	type: "POST",
																	url: "edit-user-info.php",
																	data: {action: "google"},
																	success: function(html){ 
																		$("#orderform").html(html);
																	}
																});
														});
														$("#facebookon").on('click',function() {
															$.ajax({
																	type: "POST",
																	url: "edit-user-info.php",
																	data: {action: "facebook"},
																	success: function(html){ 
																		$("#orderform").html(html);
																	}
																});
														});
														$("#hotmailon").on('click',function() {
															$.ajax({
																	type: "POST",
																	url: "edit-user-info.php",
																	data: {action: "hotmail"},
																	success: function(html){ 
																		$("#orderform").html(html);
																	}
																});
														});
														$("#stripeon").on('click',function() {
															$.ajax({
																	type: "POST",
																	url: "edit-user-info.php",
																	data: {action: "stripe"},
																	success: function(html){ 
																		$("#orderform").html(html);
																	}
																});
														});
												});
										</script>	
									</div>
								</div>
							</div>
						</div>
					</div>



					<!-- Email Setting Model -->
					<div id="edit-email-modal" class="modal fade setting-model" role="dialog">
						<div class="modal-dialog">

							<!-- Modal content-->
							<div class="modal-content">
								<div class="modal-header">
									<button type="button" class="close" data-dismiss="modal">×</button>
									<!--<h4 class="modal-title">Add</h4>-->
								</div>
								<div class="modal-body">
									<div class="container-fluid" id="emailform">
										<script>
											jQuery(document).ready(function($) {
													$("#emailon").on('click',function() {
															$.ajax({
																	type: "POST",
																	url: "edit-email-info.php",
																	success: function(html){ 
																		$("#emailform").html(html);
																	}
																});
														});
													});
										</script>	
									</div>
								</div>
							</div>
						</div>
					</div>

					<!-- Logo Edit Model -->
					<div id="edit-logo-modal" class="modal fade setting-model" role="dialog">
						<div class="modal-dialog">

							<!-- Modal content-->
							<div class="modal-content">
								<div class="modal-header">
									<button type="button" class="close" data-dismiss="modal">×</button>
									<!--<h4 class="modal-title">Add</h4>-->
								</div>
								<div class="modal-body">
									<div class="container-fluid" id="logoform">
										<script>
											jQuery(document).ready(function($) {
													$("#edit-image").on('click',function() {
															$.ajax({
																	type: "POST",
																	url: "edit-logo-info.php",
																	success: function(html){ 
																		$("#logoform").html(html);
																	}
																});
														});
													});
										</script>	
									</div>
								</div>
							</div>
						</div>
					</div>

					<!-- Edit Content Price -->
					<div id="edit-price-modal" class="modal fade setting-model" role="dialog">
						<div class="modal-dialog">

							<!-- Modal content-->
							<div class="modal-content">
								<div class="modal-header">
									<button type="button" class="close" data-dismiss="modal">×</button>
									<!--<h4 class="modal-title">Add</h4>-->
								</div>
								<div class="modal-body">
									<div class="container-fluid" id="priceform">
										<script>
											jQuery(document).ready(function($) {
													$("#priceedit").on('click',function() {
															$.ajax({
																	type: "POST",
																	url: "edit-price-info.php",
																	success: function(html){ 
																		$("#priceform").html(html);
																	}
																});
														});
													});
										</script>	
									</div>
								</div>
							</div>
						</div>
					</div>

		<div class="span12">

	      	<div class="setting-box">
			
				<div class="row">
					<div class="col span4">
						<div class="card">
							<div class="logo-upload">
								<form class="form-horizontal" method="POST" id="uploadimage" style="text-align: center;" enctype="multipart/form-data">
									<div class="site-logo" id="image_preview">
										<?php
										$sql = "Select * from cs_admin where cs_id = '1' ";
					                    $result = mysqli_query($con,$sql);
					                    if (mysqli_num_rows($result) > 0) { 
					               	     while($fetch_data = mysqli_fetch_array($result)){
	               	      	?>
										<img src="<?php echo $fetch_data['logo'];?>" alt="" style="width:280px;"/>
									<?php }
								}?>
									</div> 
									<a class="edit image" data-toggle="modal" data-target="#edit-logo-modal" id="edit-image"> Edit </a>
								</form>
							</div>
						</div> <!-- /widget -->
					</div>
					<?php
						$price = "Select * from System where SystemID = '1'";
						$priceResult = mysqli_query($con,$price) or die(mysqli_connect_error());
						$priceResultinfo = mysqli_fetch_array($priceResult);
						?>
					<div class="col span8 setting-info">
					
						<div class="googleInfo">
							<div class="title-section">
								<h3 class="setting-title">Commission Rate Setting</h3>
							</div>
							<div class="edit-button-section">
								<a class="edit price info" data-toggle="modal" data-target="#edit-price-modal" id="priceedit"> Edit </a>
							</div>
							<div class="form-group">
								<label>Commission Rate:</label>
								<input type="text" readonly="" name="comrate" class="form-control" value="<?php echo $priceResultinfo['SalesCommision'].' %'; ?>" id="comrate">

							</div>
						</div>
					
						<?php //" . $_SESSION["csuser"] . "
	                    $sql = "Select * from cs_admin where cs_id = '1' ";
	                        $result = mysqli_query($con,$sql);
	                      if (mysqli_num_rows($result) > 0) { 
	               	      while($fetch_data = mysqli_fetch_array($result)){
	                    ?>
						<div class="googleInfo">
							<div class="title-section">
								<h3 class="setting-title">Google Configuration</h3>
							</div>
							<div class="edit-button-section">
								<a class="edit google info" data-toggle="modal" data-target="#edit-order-modal" id="googleon"> Edit </a>
							</div>
							<div class="form-group">
								<label>Token:</label>
								<input type="text" readonly="" name="statetax" class="form-control" value="<?php echo $fetch_data['google_token']; ?>" id="strate">

							</div>
							<div class="form-group">
								<label>Secret Key:</label>
								<input type="text" readonly="" name="ctax" value="<?php echo $fetch_data['google_key']; ?>" class="form-control" id="ctax">
							</div>
						</div>
						
						<div class="facebookInfo">
							<div class="title-section">
								<h3 class="setting-title">Facebook Configuration</h3>
							</div>
							<div class="edit-button-section">
								<a class="edit facebook info" data-toggle="modal" data-target="#edit-order-modal" id="facebookon"> Edit </a>
							</div>
							<div class="form-group">
								<label>Token:</label>
								<input type="text" readonly="" name="statetax" class="form-control" value="<?php echo $fetch_data['facebook_token']; ?>" id="strate">

							</div>
							<div class="form-group">
								<label>Secret Key:</label>
								<input type="text" readonly="" name="ctax" value="<?php echo $fetch_data['facebook_key']; ?>" class="form-control" id="ctax">
							</div>
						</div>
						
						<div class="hotmailInfo">
							<div class="title-section">
								<h3 class="setting-title">Hotmail Configuration</h3>
							</div>
							<div class="edit-button-section">
								<a class="edit hotmail info" data-toggle="modal" data-target="#edit-order-modal" id="hotmailon"> Edit </a>
							</div>
							<div class="form-group">
								<label>Token:</label>
								<input type="text" readonly="" name="statetax" class="form-control" value="<?php echo $fetch_data['hotmail_token']; ?>" id="strate">

							</div>
							<div class="form-group">
								<label>Secret Key:</label>
								<input type="text" readonly="" name="ctax" value="<?php echo $fetch_data['hotmail_key']; ?>" class="form-control" id="ctax">
							</div>
						</div>
						
						<div class="stripInfo">
							<div class="title-section">
								<h3 class="setting-title">Stripe Configuration</h3>
							</div>
							<div class="edit-button-section">
								<a class="edit strip info" data-toggle="modal" data-target="#edit-order-modal" id="stripeon"> Edit </a>
							</div>
							<div class="form-group">
								<label>Public Key:</label>
								<input type="text" readonly="" name="statetax" class="form-control" value="<?php echo $fetch_data['stripe_public_key']; ?>" id="strate">

							</div>
							<div class="form-group">
								<label>Private Key:</label>
								<input type="text" readonly="" name="ctax" value="<?php echo $fetch_data['stripe_secret_key']; ?>" class="form-control" id="ctax">
							</div>
						</div>
						<?php
					}
				}?>
						
						<?php
						$email = "Select * from email_setting where id = '1'";
											$emailResult = mysqli_query($con,$email) or die(mysqli_connect_error());
											$emailResultinfo = mysqli_fetch_array($emailResult);
						?>
						<div class="emailinfo">
							<div class="title-section">
								<h3 class="setting-title">Email Configuration</h3>
							</div>
							
							<div class="edit-button-section">
								<a class="edit email info" data-toggle="modal" data-target="#edit-email-modal" id="emailon"> Edit </a>
							</div>
							<div class="form-group">
								<label>Admin Email</label>
								<input type="text" readonly="" name="adminemail" class="form-control" value="<?php echo $emailResultinfo['email'];?>" id="adminemail">
							</div>
							<div class="form-group">
								<label>cc Email</label>
								<input type="text" readonly="" name="ccemail" class="form-control" value="<?php echo $emailResultinfo['ccemail'];?>" id="ccemail">
							</div>
							
						</div>
						

						
						
						
						
					</div>
				</div>				

             </div>
               
         </div>
       
      </div>
      <!-- /row --> 
    </div>
    <!-- /container --> 
  </div>
  <!-- /main-inner --> 
</div>
<!-- /main -->

<div class="footer">
  <div class="footer-inner">
    <div class="container">
      <div class="row">
        <div class="span12"> &copy; 2020 <a href="#">ContentShare</a>. </div>
        <!-- /span12 --> 
      </div>
      <!-- /row --> 
    </div>
    <!-- /container --> 
  </div>
  <!-- /footer-inner --> 
</div>
<!-- /footer --> 
<!-- Le javascript
================================================== --> 
<!-- Placed at the end of the document so the pages load faster --> 
<script>
		$('#audio_price').hide();
		 $('#video_price').hide();
		 $('#file_price').hide();
	$(document).ready(function() {
		$('#content-type').on('change', function(){
		var price = $('#content-type').val();
		if(price == 'Image'){
		 $('#image_price').show();
		 $('#audio_price').hide();
		 $('#video_price').hide();
		 $('#file_price').hide();
		}
		if(price == 'Audio'){
		 $('#image_price').hide();
		 $('#audio_price').show();
		 $('#video_price').hide();
		 $('#file_price').hide();
		}
		if(price == 'Videos'){
		 $('#image_price').hide();
		 $('#audio_price').hide();
		 $('#video_price').show();
		 $('#file_price').hide();
		}
		if(price == 'File'){
		 $('#image_price').hide();
		 $('#audio_price').hide();
		 $('#video_price').hide();
		 $('#file_price').show();
		}
		});
	});
</script>
<script>     

        var lineChartData = {
            labels: ["January", "February", "March", "April", "May", "June", "July"],
            datasets: [
				{
				    fillColor: "rgba(220,220,220,0.5)",
				    strokeColor: "rgba(220,220,220,1)",
				    pointColor: "rgba(220,220,220,1)",
				    pointStrokeColor: "#fff",
				    data: [65, 59, 90, 81, 56, 55, 40]
				},
				{
				    fillColor: "rgba(151,187,205,0.5)",
				    strokeColor: "rgba(151,187,205,1)",
				    pointColor: "rgba(151,187,205,1)",
				    pointStrokeColor: "#fff",
				    data: [28, 48, 40, 19, 96, 27, 100]
				}
			]

        }

        var myLine = new Chart(document.getElementById("area-chart").getContext("2d")).Line(lineChartData);


        var barChartData = {
            labels: ["January", "February", "March", "April", "May", "June", "July"],
            datasets: [
				{
				    fillColor: "rgba(220,220,220,0.5)",
				    strokeColor: "rgba(220,220,220,1)",
				    data: [65, 59, 90, 81, 56, 55, 40]
				},
				{
				    fillColor: "rgba(151,187,205,0.5)",
				    strokeColor: "rgba(151,187,205,1)",
				    data: [28, 48, 40, 19, 96, 27, 100]
				}
			]

        }    

        $(document).ready(function() {
        var date = new Date();
        var d = date.getDate();
        var m = date.getMonth();
        var y = date.getFullYear();
        var calendar = $('#calendar').fullCalendar({
          header: {
            left: 'prev,next today',
            center: 'title',
            right: 'month,agendaWeek,agendaDay'
          },
          selectable: true,
          selectHelper: true,
          select: function(start, end, allDay) {
            var title = prompt('Event Title:');
            if (title) {
              calendar.fullCalendar('renderEvent',
                {
                  title: title,
                  start: start,
                  end: end,
                  allDay: allDay
                },
                true // make the event "stick"
              );
            }
            calendar.fullCalendar('unselect');
          },
          editable: true,
          events: [
            {
              title: 'All Day Event',
              start: new Date(y, m, 1)
            },
            {
              title: 'Long Event',
              start: new Date(y, m, d+5),
              end: new Date(y, m, d+7)
            },
            {
              id: 999,
              title: 'Repeating Event',
              start: new Date(y, m, d-3, 16, 0),
              allDay: false
            },
            {
              id: 999,
              title: 'Repeating Event',
              start: new Date(y, m, d+4, 16, 0),
              allDay: false
            },
            {
              title: 'Meeting',
              start: new Date(y, m, d, 10, 30),
              allDay: false
            },
            {
              title: 'Lunch',
              start: new Date(y, m, d, 12, 0),
              end: new Date(y, m, d, 14, 0),
              allDay: false
            },
            {
              title: 'Birthday Party',
              start: new Date(y, m, d+1, 19, 0),
              end: new Date(y, m, d+1, 22, 30),
              allDay: false
            },
            {
              title: 'EGrappler.com',
              start: new Date(y, m, 28),
              end: new Date(y, m, 29),
              url: 'http://EGrappler.com/'
            }
          ]
        });
      });
    </script><!-- /Calendar -->
</body>
</html>





