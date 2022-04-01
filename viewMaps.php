<!DOCTYPE html>
<html>
<head>
<title>Map View - ShareIO</title>
</head>
<?php 
require('./include/db.php');
session_start();
require('head.php');
require('header-new.php'); ?>  
<body>
    <main>
        <div class="container new_container">
            <div class="row">
                <div class="col-md-12">
                    <div class="main_content file-stats hidden">
                        <div id="page-content-wrapper">
                            <div class="ui grid">
                                <div class="column">
                                    <div class="ui segment file-stats-bg view_maps">
                                        <div id="map-canvas"></div> 
                                        <div class="icons back_arrow pull-right" style="">
                                            <?php 
                                            if(isset($_GET['package_id'])){ ?>
                                            <a href="Package-stats.php?id=<?php echo $_GET['package_id'];?>">
                                                <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 0 24 24" width="24px" fill="#000000"><path d="M0 0h24v24H0V0z" fill="none"></path><path d="M19 6.41L17.59 5 12 10.59 6.41 5 5 6.41 10.59 12 5 17.59 6.41 19 12 13.41 17.59 19 19 17.59 13.41 12 19 6.41z"></path>
                               					</svg>
                                            </a>
                                            <?php
                                            } else{
                                            ?>
                                            <a href="File-stats.php?id=<?php echo $_GET['fileid'];?>">
                                                <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 0 24 24" width="24px" fill="#000000"><path d="M0 0h24v24H0V0z" fill="none"></path><path d="M19 6.41L17.59 5 12 10.59 6.41 5 5 6.41 10.59 12 5 17.59 6.41 19 12 13.41 17.59 19 19 17.59 13.41 12 19 6.41z"></path>
                               					</svg>
                                            </a>
                                            <?php }?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div> 
            </div>
        </div>
    </main>
<?php 

$users_data = array();
$org = '';
if(isset($_GET['package_id'])){
    $org = mysqli_query($con,"SELECT DISTINCT ip, lattitude , longitude , user_name, package_id FROM `cs_log` where package_id = '".$_GET['package_id']."'");
} else{
    $org = mysqli_query($con,"SELECT DISTINCT ip, lattitude , longitude , user_name, fileid FROM `cs_log` where fileid = '".$_GET['fileid']."'");
}
while($users_da = mysqli_fetch_array($org)){
    if($users_da['lattitude'] != ''){
        $data['lat'] = $users_da['lattitude'];
        $data['lng'] = $users_da['longitude'];
        $users_data[] = $data;
    }
}?>
<link href="https://api.mapbox.com/mapbox-gl-js/v2.4.1/mapbox-gl.css" rel="stylesheet">
<script src="https://api.mapbox.com/mapbox-gl-js/v2.4.1/mapbox-gl.js"></script>
<script>
    $(document).ready(function(){
        $( ".main_content" ).removeClass("hidden");
    });

	mapboxgl.accessToken = 'pk.eyJ1Ijoic2FmYWoiLCJhIjoiY2t0YmIyYzRyMXU0bzJ1bGFycXh5cDh2diJ9.H2iYCWsVGzdln5M8LZobKw';
    const map = new mapboxgl.Map({
        container: 'map-canvas', 
        style: 'mapbox://styles/safaj/cktbb9jbp642i17ofrvr37600', 
        center: [-0.20248249999999998, 51.4754218], 
        zoom: 1 
    });

    var markers = <?php echo json_encode($users_data);?>;
    $.each( markers, function( key, value ) {
      const marker = new mapboxgl.Marker()
        .setLngLat([value['lng'], value['lat']])
        .addTo(map);
    });
</script>
<?php include('footer-new.php');?>
</body>
</html>
