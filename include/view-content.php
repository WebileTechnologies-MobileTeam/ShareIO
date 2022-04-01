<?php
require('./db.php');
session_start();
$userid = $_SESSION["user"];
$lat = $_SESSION['lat'];
$long = $_SESSION['long'];
$browser = $_SESSION['browser'];
$device = $_SESSION['device'];
$date = date('Y-m-d h:i:sa');

//Getting user location from ip address
function resolveIP($ip) {
			  $string = file_get_contents("http://ipinfo.io/{$ip}");
			  $json = json_decode($string);
			  return $json;
}
// echo '<pre>';
// print_r($_SERVER);
$ip = $_SERVER['REMOTE_ADDR'];
$json = resolveIP($ip);
$country = $json->country;
$city = $json->city;

if($userid != ''){

//Inserting log of viewer
$log = "INSERT into cs_log(fileid,date_time,browser,device,user_name,ip,country,referrer,lattitude,longitude) VALUES('".$_GET["id"]."','".$date."','".$browser."','".$device."','".$userid."','".$ip."','".$country."','".$_SERVER['HTTP_REFERER']."','".$lat."','".$long."')";
$results = mysqli_query($con,$log);

//Insert into location table
$location = "INSERT into location(ip,city,country) VALUES('".$ip."','".$city."','".$country."')";
$locations = mysqli_query($con,$location);
}

if(!empty($_GET["id"])) {
	
	$sql = "Select * from sentfile where file_id = '" . $_GET["id"] . "' ";
    $result = mysqli_query($con,$sql);
	$user = mysqli_fetch_assoc($result);

	if($user) { ?>
		<div class="model-text"><p>ContentShare</p></div>
		<?php
		$allowedTypes = array('image/jpeg', 'image/png', 'image/jpg', 'image/gif');
        $allowedTypesvideo = array('video/mp4');
        $filetype = $user["file_type"]; 
 		if(in_array($filetype, $allowedTypes)){?>
 			<div class="watermark">
 			<?php if($user['watermark_type'] == 'Text'){?>
 			<div id="watermark-text" class="watermark-text">
 				<?php echo $user["watermark_text"];?>
 			</div>
 		<?php } else{?>
 			<div id="watermark-image" class="watermark-image">
 				<img width="200px" height="300px" id="watermark" src="<?php echo $user["watermark_image"];?>">
 			</div>
 		<?php }?>
 			<div id="view-remove" class="file-image">
			<img width="570px" height="600px" id="viewer" src="<?php echo $user["file_url"];?>">
			</div>
		</div>
 		<?php }else if(in_array($filetype, $allowedTypesvideo)){ ?>
 			<div id="view-remove" class="file-image">
				<video id="myVideo" width="570px" height="600px" controls>
				<source id="viewer" src="<?php echo $user["file_url"];?>"></video>
			</div>
 		<?php }else{ ?>
 			<div class="watermark">
 			<?php if($user['watermark_type'] == 'Text'){?>
 			<div id="watermark-text" class="watermark-text">
 				<?php echo $user["watermark_text"];?>
 			</div>
 		<?php } else{?>
 			<div id="watermark-image" class="watermark-image">
 				<img width="50px" height="60px" id="watermark" src="<?php echo $user["watermark_image"];?>">
 			</div>
 		<?php }?>
 			<div style="clear:both" id="viewer-file">
        <iframe id="viewer" frameborder="0" scrolling="no" width="570" height="300" src="<?php echo $user["file_url"];?>"></iframe>
        
		</div>
		</div>
 		<?php } ?>
      
		<?php
		$sql1 = "Select * from payments where user_id = '" . $userid . "' and file_id = '". $_GET["id"] ."' ";
	    $result1 = mysqli_query($con,$sql1);
		$user1 = mysqli_fetch_assoc($result1);
		if($user1) {
		} else{
		?>
		<div class="purchase"><a id="getpurchase" data-toggle="modal" data-target="#edit-payment-modal" data-id="<?php echo $_GET["id"];?>" ><button>Purchase</button></a></div>

		<input type="hidden" name="time" id="time">
	<?php }?>

<script>
						jQuery(document).ready(function($) {
                          $("#getpurchase").on('click',function() {
                            var id = $(this).attr("data-id");
                              $.ajax({
                                  type: "POST",
                                  url: "include/purchase.php?id="+id,
                                  success: function(html){ 
                                    $("#contentshare-model-popup").html(html);
                                  }
                                });
                            });
                          });


			//For counting time
			var minutesLabel = document.getElementById("time");
			var totalSeconds = 0;
			setInterval(setTime, 1000);

			function setTime() {
			  ++totalSeconds;
			  minutesLabel.value = pad(parseInt(totalSeconds / 60))+':'+pad(totalSeconds % 60);
			}

			function pad(val) {
			  var valString = val + "";
			  if (valString.length < 2) {
			    return "0" + valString;
			  } else {
			    return valString;
			  }
			}
	
			
</script>



<?php }
}?>