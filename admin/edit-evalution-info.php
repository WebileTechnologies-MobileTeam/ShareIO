<?php 
include('../include/db.php');
$Order = "Select * from tbl_evaluation where evaluation_id = '".$_POST['id']."'";
$OrderResult = mysqli_query($con,$Order) or die(mysqli_connect_error());
$Orderinfo = mysqli_fetch_array($OrderResult);
?>
<div class="title-section">
	<h3 class="setting-title">Edit Evalution</h3>
										
</div>
<form method="post" action="include/editevalutiondata.php">
	<div class="form-group">
		<label>Evalution Name</label>
		<input type="text" name="evaluation_name" class="form-control" id="evaluation_name" value="<?php echo $Orderinfo['evaluation_name'];?>">
		<input type="hidden" name="id" value="<?php echo $Orderinfo['evaluation_id'];?>">
	</div>														
<div class="form-group button-box" style="text-align: center;">
	<input class="btn btn-primary" type="submit" name="submit">
</div>
</form>