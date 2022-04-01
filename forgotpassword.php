<!DOCTYPE html>
<html lang="en">
<?php require('header.php'); ?>
<?php
require('./include/db.php');
session_start();
?>
<body>

<div class="account-container">
	
	<div class="login-content">
	
		<div class="loginCenter">
			<div class="content clearfix">
				<!-- ./include/fogotpassword.php -->
				<form action="./include/fogotpassword.php" method="post">
					
					<div class="login-fields">
						
						<h4 class="welcomeCS">Forgot Password?</h4>
						<p>We will send you a link to reset your password.</p>

						<?php if(isset($_SESSION['error'])){ ?>

						<div class="alert alert-error fade in">
							    <a href="#" class="close" data-dismiss="alert">&times;</a>
							    <strong style="color:red;"><?php echo $_SESSION['error']; ?></strong>
							</div>
						<?php 
						unset($_SESSION['error']);
					} ?>

					<?php if(isset($_SESSION['success'])){ ?>

						<div class="alert alert-success fade in">
							    <a href="#" class="close" data-dismiss="alert">&times;</a>
							    <strong><?php echo $_SESSION['success']; ?></strong>
							</div>
						<?php 
						unset($_SESSION['success']);
					} ?>
						
						<div class="field">
							<label for="username">Email</label>
							<input class="login username-field" id="inputEmailAddress" name="username" type="email" aria-describedby="emailHelp" placeholder="Enter email address">
						</div> <!-- /field -->
						
					</div> <!-- /login-fields -->
					
					<div class="login-actions loginButton">
						<button class="button btn btn-success btn-large">Reset Password</button>
					</div>	

				</form>
				
			</div>
		</div>		
	</div> <!-- /content -->
	
</div> <!-- /account-container -->

</body>

</html>