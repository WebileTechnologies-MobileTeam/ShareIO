<?php 
include('../include/db.php');
$action = $_POST['action'];
$Order = "Select * from cs_admin where cs_id = '1'";
											$OrderResult = mysqli_query($con,$Order) or die(mysqli_connect_error());
											$Orderinfo = mysqli_fetch_array($OrderResult);
?>
<div class="title-section">
	<h3 class="setting-title">Edit Information</h3>
										
</div>
<form method="post" action="include/edituserdata.php">
	<input type="hidden" name="action" value="<?php echo $action;?>">
	<?php if($action == "google"){ 
	?>

											<div class="form-group">
												<label>Google Token</label>
												<input type="text" name="google_token" class="form-control" id="google_token" value="<?php echo $Orderinfo['google_token'];  ?>">
											</div> 
											<div class="form-group">
												<label>Secret Key</label>
												<input type="text" name="google_key" class="form-control" id="google_key" value="<?php echo $Orderinfo['google_key'];  ?>">
											</div>
	<?php }?>
	<?php if($action == "facebook"){ 
	?>
											<div class="form-group">
												<label>Facebook Token</label>
												<input type="text" name="facebook_token" class="form-control" id="facebook_token" value="<?php echo $Orderinfo['facebook_token'];  ?>">
											</div> 
											<div class="form-group">
												<label>Secret Key</label>
												<input type="text" name="facebook_key" class="form-control" id="facebook_key" value="<?php echo $Orderinfo['facebook_key'];  ?>">
											</div>
	<?php }?>
	<?php if($action == "hotmail"){ 
	?>
											<div class="form-group">
												<label>Hotmail Token</label>
												<input type="text" name="facebook_token" class="form-control" id="facebook_token" value="<?php echo $Orderinfo['hotmail_token'];  ?>">
											</div> 
											<div class="form-group">
												<label>Secret Key</label>
												<input type="text" name="facebook_key" class="form-control" id="facebook_key" value="<?php echo $Orderinfo['hotmail_key'];  ?>">
											</div>
	<?php }?>
	<?php if($action == "stripe"){ 
	?>
											<div class="form-group">
												<label>Public key</label>
												<input type="text" name="facebook_token" class="form-control" id="facebook_token" value="<?php echo $Orderinfo['stripe_public_key'];  ?>">
											</div> 
											<div class="form-group">
												<label>Secret Key</label>
												<input type="text" name="facebook_key" class="form-control" id="facebook_key" value="<?php echo $Orderinfo['stripe_secret_key'];  ?>">
											</div>
	<?php }?>
											
<div class="form-group button-box" style="text-align: center;">
	<input class="btn btn-primary" type="submit" name="submit">
</div>
</form>