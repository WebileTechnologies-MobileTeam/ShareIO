<!DOCTYPE html>
<html lang="en">
<?php
require('../include/db.php');
session_start();
?>
<head>
    <meta charset="utf-8">
    <title>Dashboard - CONTENTSHARE</title>

	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <meta name="apple-mobile-web-app-capable" content="yes"> 
    
<link href="http://3.135.223.154/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
<link href="http://3.135.223.154/css/bootstrap-responsive.min.css" rel="stylesheet" type="text/css" />
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">


<link href="http://3.135.223.154/css/font-awesome.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:400italic,600italic,400,600" rel="stylesheet">
    
<link href="http://3.135.223.154/css/style.css" rel="stylesheet" type="text/css">
<link href="http://3.135.223.154/css/pages/signin.css" rel="stylesheet" type="text/css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.0/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.0/jquery.validate.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="http://3.135.223.154/js/main.js"></script>

</head>

<div class="logo">
<center>
	<h1><a href="index.php"> <img src="http://3.135.223.154/image/logo.png"> </a></h1>
	</center>
</div>


<script>
  // if (window.location.protocol != "https:")
  //   window.location.href = "https:" + window.location.href.substring(window.location.protocol.length);
</script>
<body>


<div class="account-container">
	
	<div class="login-content">
	
		<div class="loginCenter">
			<div class="content clearfix">
				
				<form action="login.php" method="post" id="login">
				
					
					<div class="login-fields">
						
						<h4 class="welcomeCS">Welcome to ContentShare</h4>
						<?php if (isset($_SESSION['succsessmsg'])){ ?>	
							<div class="alert alert-success fade in">
								    <a href="#" class="close" data-dismiss="alert">&times;</a>
								    <strong><?php echo $_SESSION['succsessmsg']; ?></strong> 
								</div>
							<?php 
							 unset($_SESSION['succsessmsg']);
							 }
							if(isset($_SESSION['error'])){ ?>

							<div class="alert alert-error fade in">
								    <a href="#" class="close" data-dismiss="alert">&times;</a>
								    <strong style="color:red;"><?php echo $_SESSION['error']; ?></strong>
								</div>
							<?php 
							unset($_SESSION['error']);
							} 
							?>
						<div class="field">
							<label for="username">Username</label>
							<input type="text" id="username" name="username" value="" placeholder="Email Address" class="login username-field" />
						</div> <!-- /field -->
						
						<div class="field">
							<label for="password">Password:</label>
							<input type="password" id="password" name="password" value="" placeholder="Password" class="login password-field"/>
							<!-- <span class="forgot-password"><a href="forgotpassword.php" target="">Forgot?</a></span> -->
						</div> <!-- /password -->
						
					</div> <!-- /login-fields -->
					
					
					<div class="login-actions loginButton">
						<button name="login" class="button btn btn-success btn-large">Login</button>
					</div>	
				</form>
		
				<!-- <div class="card-footer text-center">
					<div class="small"><a href="signup.php">Create new account</a></div>
				</div> -->
				
			</div>
		</div>		
	</div> <!-- /content -->
	
</div> <!-- /account-container -->



</body>
</html>