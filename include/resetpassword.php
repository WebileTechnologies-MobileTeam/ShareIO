<!DOCTYPE html>
<html lang="en">
<?php 
require('../header.php'); ?>
<?php
require('./db.php');
session_start();


?>
<body>

<div class="account-container">
	
	<div class="login-content">
	
		<div class="loginCenter">
			<div class="content clearfix">
				
				<form action="changepassword.php" method="post" id="form">
					
					<div class="login-fields">
						
						<h4 class="welcomeCS">Enter New Password</h4>
						
						<div class="field">
							<input type="hidden" name="email" value="<?php echo $_GET['email'];?>">
							<label for="password">Password:</label>
							<input type="password" id="password" name="password" value="" placeholder="Password" class="login password-field"/>
						</div> <!-- /password -->
						<div class="field">
							<label for="confirmpassword">Confirm Password:</label>
							<input type="password" id="confirmpassword" name="confirmpassword" value="" placeholder="Confirm Password" class="login password-field"/>
						</div> <!-- /field -->
						
					</div> <!-- /login-fields -->
					
					<div class="login-actions loginButton">
						<button class="button btn btn-success btn-large">Submit</button>
					</div>	

				</form>
				
			</div>
		</div>		
	</div> <!-- /content -->
	
</div> <!-- /account-container -->

</body>

</html>