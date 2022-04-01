<?php 
include('../include/db.php');
$Order = "Select * from email_setting where id = '1'";
											$OrderResult = mysqli_query($con,$Order) or die(mysqli_connect_error());
											$Orderinfo = mysqli_fetch_array($OrderResult);
?>
<div class="title-section">
	<h3 class="setting-title">Edit Information</h3>
										
</div>
<form method="post" action="include/editemaildata.php">
	

											<div class="form-group">
												<label>Email</label>
												<input type="text" name="email" class="form-control" id="email" value="<?php echo $Orderinfo['email'];  ?>">
											</div> 
											<div class="form-group">
												<label>CC Mail</label>
												<input type="text" name="ccemail" class="form-control" id="ccemail" value="<?php echo $Orderinfo['ccemail'];  ?>">
											</div>

	
											
<div class="form-group button-box" style="text-align: center;">
	<input class="btn btn-primary" type="submit" name="submit">
</div>
</form>