<!DOCTYPE html>
<html lang="en">
<?php require('../include/db.php');
require('../include/inc/defined_variables.php');
session_start(); ?>
<?php require('head.php'); 
?>

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
		<div class="span12">

	      	<div class="analytics-box">
			

				<div class="col views col-md-4 col-sm-6 col-xs-12">
					<div class="card">
						<h4 class="header-title mb-4">Views</h4>
						<div class="card-body">
							<?php 
							$users_data = array();
							$views_data = mysqli_query($con,"SELECT DISTINCT user_name FROM `cs_log` where user_name != ''");
							while($users_da = mysqli_fetch_array($views_data)){
								$user = mysqli_query($con,"SELECT * FROM `cs_users` where id = '".$users_da['user_name']."' or oauth_uid = '".$users_da['user_name']."'");
								$user_data = mysqli_fetch_array($user);?>
								<div class="media mt-3">
								<img class="mr-3 rounded-circle" src="../image/avatar-2.jpg" width="60" alt="profile image">
								<div class="media-body">
									<a href="#" class="btn btn-primary bluebtn float-right">View</a>
									<h5 class="mt-0 mb-1"><?php echo $user_data['email'];?></h5>
								</div>
							</div>
							<?php }
							?>
								
						</div>
						<!-- end card-body -->
					</div> <!-- /widget -->
				</div>

				<div class="col map-views col-md-4 col-sm-6 col-xs-12">
					<div class="card">
						<h4 class="header-title mb-4">Map View</h4>
						<div class="card-body">
							<div id="map-canvas" style="width: 375px; height: 340px;">
    						</div>
						</div>
					</div> <!-- /widget -->
				</div>
				<div class="col views col-md-4 col-sm-6 col-xs-12">
					<div class="card">
						<h4 class="header-title mb-4">Purchase</h4>
						<div class="card-body">
							<?php 
							$users_data = array();
							$purchse = mysqli_query($con,"SELECT DISTINCT user_id FROM `payments` LIMIT 0,5");
							while($users_da = mysqli_fetch_array($purchse)){
								$purchse_data = mysqli_query($con,"SELECT sum(amount) as total, card_type FROM `payments` where user_id = '".$users_da['user_id']."'");
								$a = mysqli_fetch_array($purchse_data);
								$amount = $a['total'];
								$user = mysqli_query($con,"SELECT * FROM `cs_users` where id = '".$users_da['user_id']."' or oauth_uid = '".$users_da['user_id']."'");
								$user_data = mysqli_fetch_array($user);?>
								<div class="media">
								<img class="mr-3 rounded-circle" src="../image/avatar-2.jpg" width="60" alt="profile image">
								<div class="media-body">
									<h5 class="mt-0 mb-1 float-right"><?php echo '$'.$amount;?></h5>
									<h5 class="mr-3 mt-0 mb-1 float-right"><?php echo $a['card_type'];?></h5>
									<h5 class="mt-0 mb-1"><?php echo $user_data['email'];?></h5>
								</div>
							</div>
							<?php }
							?>
							
								
						</div>
					</div> <!-- /widget -->
				</div>

				<div class="clearfix"></div>

				<div class="col map-views col-md-4 col-sm-6 col-xs-12">
					<div class="card">
						<h4 class="header-title mb-4">Graph View</h4>
						<div class="card-body">
							
							<div id="chartContainer" style="height: 370px; max-width:380px; margin: 0px auto;"></div>

						</div>
					</div> <!-- /widget -->
				</div>
					
				<div class="col views col-md-4 col-sm-6 col-xs-12">
					<div class="card">
						<h4 class="header-title mb-4">Organisation where content view</h4>
						<div class="card-body">
							<?php 
							$users_data = array();
							$org = mysqli_query($con,"SELECT DISTINCT user_name FROM `cs_log`");
							$users_da = mysqli_fetch_array($org);
							$users_data[] = $users_da['user_name'];
							foreach ($users_data as $users_id) {
								$purchse_data = mysqli_query($con,"SELECT organization FROM `cs_users` where id = '".$users_id."'");
								$a = mysqli_fetch_array($purchse_data);
								?>
								<div class="card-row-body">
								<h4 class="card-row-title"><?php echo $a['organization'];?></h5>
								<p class="card-row-text">This card has supporting text below as a natural lead-in to additional content.</p>
							</div>
							<?php }
							?>
							
						</div>
					</div> <!-- /card -->
				</div>
				<div class="col views col-md-4 col-sm-6 col-xs-12">
					<div class="card">
						<h4 class="header-title mb-4">Cities where content view</h4>
						<div class="card-body">
							<?php 
							$users_data = array();
							$city = mysqli_query($con,"SELECT DISTINCT ip FROM `cs_log`");
							$users_da = mysqli_fetch_array($city);
							$users_data[] = $users_da['ip'];
							foreach ($users_data as $users_id) {
								$city_data = mysqli_query($con,"SELECT city FROM `location` where ip = '".$users_id."'");
								$a = mysqli_fetch_array($city_data);
								?>
								<div class="card-row-body">
								<h4 class="card-row-title"><?php echo $a['city'];?></h5>
								<p class="card-row-text">This card has supporting text below as a natural lead-in to additional content.</p>
							</div>
							<?php }
							?>
						</div>
					</div> <!-- /card -->
				</div>								<div class="clearfix"></div>
				<div class="col map-views col-md-4 col-sm-6 col-xs-12">
					<div class="card">
						<h4 class="header-title mb-4">Funnel View</h4>
						<div class="card-body">
							<div id="chart-container">FusionCharts will render here</div>
						</div>
					</div> <!-- /widget -->
				</div>
				<div class="col views col-md-4 col-sm-6 col-xs-12">
					<div class="card">
						<h4 class="header-title mb-4">Purchase</h4>
						<div class="card-body">
						
							<div class="media">
								<img class="mr-3 rounded-circle" src="../image/avatar-2.jpg" width="60" alt="profile image">
								<div class="media-body">
									<div class="small-info soc-link float-right">
										<ul>
											<li class="globe"><a href="#"><i class="icon-large icon-globe"></i></a></li>
											<li class="fbicon"><a href="#"><i class="icon-large icon-facebook"></i></a></li>
											<li class="linkedin"><a href="#"><i class="icon-large icon-linkedin"></i></a></li>
										</ul>
									</div>
									<h5 class="mt-0 mb-1">Risa Pearson</h5>
								</div>
							</div>
							<div class="media mt-3">
								<img class="mr-3 rounded-circle" src="../image/avatar-2.jpg" width="60" alt="profile image">
								<div class="media-body">
									<div class="small-info soc-link float-right">
										<ul>
											<li class="globe"><a href="#"><i class="icon-large icon-globe"></i></a></li>
											<li class="fbicon"><a href="#"><i class="icon-large icon-facebook"></i></a></li>
											<li class="linkedin"><a href="#"><i class="icon-large icon-linkedin"></i></a></li>
										</ul>
									</div>
									<h5 class="mt-0 mb-1">Risa Pearson</h5>
								</div>
							</div>
							<div class="media mt-3">
								<img class="mr-3 rounded-circle" src="../image/avatar-2.jpg" width="60" alt="profile image">
								<div class="media-body">
									<div class="small-info soc-link float-right">
										<ul>
											<li class="globe"><a href="#"><i class="icon-large icon-globe"></i></a></li>
											<li class="fbicon"><a href="#"><i class="icon-large icon-facebook"></i></a></li>
											<li class="linkedin"><a href="#"><i class="icon-large icon-linkedin"></i></a></li>
										</ul>
									</div>
									<h5 class="mt-0 mb-1">Risa Pearson</h5>
								</div>
							</div>
							<div class="media mt-3">
								<img class="mr-3 rounded-circle" src="../image/avatar-2.jpg" width="60" alt="profile image">
								<div class="media-body">
									<div class="small-info soc-link float-right">
										<ul>
											<li class="globe"><a href="#"><i class="icon-large icon-globe"></i></a></li>
											<li class="fbicon"><a href="#"><i class="icon-large icon-facebook"></i></a></li>
											<li class="linkedin"><a href="#"><i class="icon-large icon-linkedin"></i></a></li>
										</ul>
									</div>
									<h5 class="mt-0 mb-1">Risa Pearson</h5>
								</div>
							</div>
							<div class="media mt-3">
								<img class="mr-3 rounded-circle" src="../image/avatar-2.jpg" width="60" alt="profile image">
								<div class="media-body">
									<div class="small-info soc-link float-right">
										<ul>
											<li class="globe"><a href="#"><i class="icon-large icon-globe"></i></a></li>
											<li class="fbicon"><a href="#"><i class="icon-large icon-facebook"></i></a></li>
											<li class="linkedin"><a href="#"><i class="icon-large icon-linkedin"></i></a></li>
										</ul>
									</div>
									<h5 class="mt-0 mb-1">Risa Pearson</h5>
								</div>
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
<?php
$sel_inv = mysqli_query($con,"SELECT * FROM `files`");


$product = array();
$sold = array();
$available = array();
$productTypes = array(0, 0, 0,0);
$topProductsSold = array();
$topProductsLabels = array();
$topPercentages = array();
$i = 0;

while ($f_inv = mysqli_fetch_array($sel_inv)) {
    switch ($f_inv['type']) {
        case "application/pdf":
            $productTypes[0] += 1;
            break;
        case "image/jpeg":
            $productTypes[1] += 1;
            break;  
        case "audio/mp3":
            $productTypes[2] += 1;
            break;
        case "audio/mpeg":
            $productTypes[2] += 1;
            break; 
        case "video/mp4":
             $productTypes[3] += 1;
             break;
    }
   
}

?>
<?php include('footer.php'); ?>
<?php
$p_data = array();
$logdata = mysqli_query($con,"SELECT * FROM `cs_log`");
$logdata_da = mysqli_num_rows($logdata);
$paymentdata = mysqli_query($con,"SELECT * FROM `payments`");
$paymentdata_da = mysqli_num_rows($paymentdata);
?>
<!-- /footer --> 
<!-- Le javascript
================================================== --> 
<!-- Placed at the end of the document so the pages load faster --> 
<script src="http://3.135.223.154/js/excanvas.min.js"></script> 
<script src="http://3.135.223.154/js/chart.min.js" type="text/javascript"></script> 
<script src="http://3.135.223.154/js/chartcanvasjs.min.js" type="text/javascript"></script> 
<script src="http://3.135.223.154/js/chartcanvasjs.min.js" type="text/javascript"></script> 
<!-- <script src="http://3.135.223.154/js/bootstrap.js"></script> -->
<script language="javascript" type="text/javascript" src="http://3.135.223.154/js/full-calendar/fullcalendar.min.js"></script>
<script src="http://3.135.223.154/js/base.js"></script> 
<script src="https://cdn.fusioncharts.com/fusioncharts/latest/fusioncharts.js"></script>
<script src="https://cdn.fusioncharts.com/fusioncharts/latest/themes/fusioncharts.theme.fusion.js"></script>
<script type="text/javascript">
	window.onload = function () {

	var chart = new CanvasJS.Chart("chartContainer", {
		theme: "light1", // "light2", "dark1", "dark2"
		animationEnabled: false, // change to true		
		title:{
			text: ""
		},
		data: [
		{
			// Change type to "bar", "area", "spline", "pie", "column",etc.
			type: "column",
			dataPoints: [
				{ label: "Pages",  y: <?php echo json_encode($productTypes[0])?>  },
				{ label: "Images", y: <?php echo json_encode($productTypes[1])?>  },
				{ label: "Audio", y: <?php echo json_encode($productTypes[2])?>  },
				{ label: "Video",  y: <?php echo json_encode($productTypes[3])?>  },
			]
		}
		]
	});
	chart.render();

	}



	FusionCharts.ready(function() {
  var wealthChart = new FusionCharts({
      type: 'pyramid',
      renderAt: 'chart-container',
      id: 'wealth-pyramid-chart',
      width: '100%',
      height: '400',
      dataFormat: 'json',
      dataSource: {
        "chart": {
          "theme": "fusion",
          "captionOnTop": "0",
          "captionPadding": "25",
          "alignCaptionWithCanvas": "1",
          "subCaptionFontSize": "12",
          "borderAlpha": "20",
          "is2D": "0",
          "bgColor": "#ffffff",
          "showValues": "1",
          "numberPrefix": "$",
          "numberSuffix": "M",
          "showPercentValues": "1",
          "chartLeftMargin": "40"
        },
        "data": [{
            "label": "Purchase",
            "value": '<?php echo json_encode($paymentdata_da); ?>'
          },
          {
            "label": "Clicked",
            "value": '<?php echo json_encode($logdata_da); ?>'
          },
          {
            "label": "Viewed",
            "value": '<?php echo json_encode($logdata_da); ?>'
          }
        ]
      }
    })
    .render();
});

</script>	
<?php 
$users_data = array();
$org = mysqli_query($con,"SELECT DISTINCT ip, lattitude , longitude , user_name, fileid FROM `cs_log`");
while($users_da = mysqli_fetch_array($org)){
	if($users_da['lattitude'] != ''){
	// $user = mysqli_query($con,"SELECT * FROM `cs_users` where id = '".$users_da['user_name']."' OR oauth_uid = '".$users_da['user_name']."'");
	// $a = mysqli_fetch_array($user);
	// $fileinfo = mysqli_query($con,"SELECT * FROM `sentfile` where file_id = '".$users_da['fileid']."'");
	// $file = mysqli_fetch_array($fileinfo);
	$data = array(
		'DisplayText' => "Viewer",
		'ADDRESS' => "",
		'LatitudeLongitude' => $users_da['lattitude'].",".$users_da['longitude'],
		'MarkerId' => "Viewer"
	);
	$users_data[] = $data;
}
}
   // echo '<pre>';
   // print_r($users_data);
?>
<script src="https://code.jquery.com/jquery-1.10.2.min.js" type="text/javascript"></script>
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyA7IZt-36CgqSGDFK8pChUdQXFyKIhpMBY&sensor=true" type="text/javascript"></script>
<script>
    var map;
        var geocoder;
        var marker;
        var people = new Array();
        var latlng;
        var infowindow;

        $(document).ready(function() {
            ViewCustInGoogleMap();
        });

        function ViewCustInGoogleMap() {

            var mapOptions = {
                center: new google.maps.LatLng(51.4754218, -0.20248249999999998),   
                zoom: 7,
                mapTypeId: google.maps.MapTypeId.ROADMAP
            };
            map = new google.maps.Map(document.getElementById("map-canvas"), mapOptions);

            var data = '<?php echo json_encode($users_data); ?>';
      
            people = JSON.parse(data); 

            for (var i = 0; i < people.length; i++) {
                setMarker(people[i]);
            }

        }

        function setMarker(people) {
            geocoder = new google.maps.Geocoder();
            infowindow = new google.maps.InfoWindow();
            if ((people["LatitudeLongitude"] == null) || (people["LatitudeLongitude"] == 'null') || (people["LatitudeLongitude"] == '')) {
                geocoder.geocode({ 'address': people["Address"] }, function(results, status) {
                    if (status == google.maps.GeocoderStatus.OK) {
                        latlng = new google.maps.LatLng(results[0].geometry.location.lat(), results[0].geometry.location.lng());
                        marker = new google.maps.Marker({
                            position: latlng,
                            map: map,
                            draggable: false,
                            html: people["DisplayText"],
                            icon: "images/marker/" + people["MarkerId"] + ".png"
                        });
                        //marker.setPosition(latlng);
                        //map.setCenter(latlng);
                        google.maps.event.addListener(marker, 'click', function(event) {
                            infowindow.setContent(this.html);
                            infowindow.setPosition(event.latLng);
                            infowindow.open(map, this);
                        });
                    }
                    else {
                        alert(people["DisplayText"] + " -- " + people["Address"] + ". This address couldn't be found");
                    }
                });
            }
            else {
                var latlngStr = people["LatitudeLongitude"].split(",");
                var lat = parseFloat(latlngStr[0]);
                var lng = parseFloat(latlngStr[1]);
                latlng = new google.maps.LatLng(lat, lng);
                marker = new google.maps.Marker({
                    position: latlng,
                    map: map,
                    draggable: false,               // cant drag it
                    html: people["DisplayText"]    // Content display on marker click
                    //icon: "images/marker.png"       // Give ur own image
                });
                //marker.setPosition(latlng);
                //map.setCenter(latlng);
                google.maps.event.addListener(marker, 'click', function(event) {
                    infowindow.setContent(this.html);
                    infowindow.setPosition(event.latLng);
                    infowindow.open(map, this);
                });
            }
        }
</script>


</body>
</html>




			
			