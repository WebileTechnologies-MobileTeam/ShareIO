<?php 
include('../include/db.php');
$Order = "Select * from System where SystemID = '1'";
$OrderResult = mysqli_query($con,$Order) or die(mysqli_connect_error());
$Orderinfo = mysqli_fetch_array($OrderResult);
?>
<div class="title-section">
	<h3 class="setting-title">Edit Information</h3>
										
</div>
<form method="post" action="include/editconpricedata.php">
	
<div class="form-group">
	<label>Commission Rate</label>
	<input type="text" name="com_rate" class="form-control" id="com_rate" value="<?php echo $Orderinfo['SalesCommision'];  ?>">
</div> 
							
<div class="form-group button-box" style="text-align: center;">
	<input class="btn btn-primary" type="submit" name="submit">
</div>
</form>