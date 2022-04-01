<?php 
include('../include/db.php');
$Order = "Select logo from cs_admin where cs_id = '1'";
											$OrderResult = mysqli_query($con,$Order) or die(mysqli_connect_error());
											$Orderinfo = mysqli_fetch_array($OrderResult);
?>
<div class="title-section">
	<h3 class="setting-title">Edit Information</h3>
										
</div>
<form method="post" action="include/editlogo.php" enctype="multipart/form-data">
	

											<div class="site-logo" id="image_preview">
												<img src="<?php echo $Orderinfo['logo'];?>" alt="" style="width:280px;"/>
											</div> 
											<div class="form-group">
												<input type="file" id="file" name="file">
											</div>

	
											
<div class="form-group button-box" style="text-align: center;">
	<input class="btn btn-primary" type="submit" name="submit">
</div>
</form>