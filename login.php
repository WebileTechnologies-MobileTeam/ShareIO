<!DOCTYPE html>
<html lang="en">
<?php 
session_start();
echo "<pre>";
print_r($_SESSION);
// echo "hii";
// //header("Location: dashboard.php");
// exit;
require('header.php'); ?>
<?php
require('./include/db.php');

// include('config.php');
// include('facebook_config.php');
// include('./hotmail/hotmail.php');
//require('./google_login.php');
//session_start();
$user = '';
if(!empty($_COOKIE["login"])){
	$user = $_COOKIE["login"];
}
?>
<body>


<div class="account-container">
	
	<div class="login-content">
        <div class="login_social_media_container">
            <h4 class="welcomeCS">Welcome to ContentShare</h4>
            <div class="login_with_social_media">
                <label>Login With Social Media</label>
                <ul>
                    <li class="facebook"><?php require('./facebook/facebook_auth.php'); ?>
                    <?php echo $facebook_login_url; ?></li>
                    <li class="linkedin"><a href="#"><i class="fa fa-linkedin" aria-hidden="true"></i> <span>Login with Linkedin</span></a></li>
                    <li class="instagram"><a href="#"><i class="fa fa-instagram" aria-hidden="true"></i> <span>Login with Instagram</span></a></li>
                    <li class="google"><?php require('./google/auth.php'); ?>
                    <?php echo $login_button; ?></li>     
                    
                    <li class="hotmail"> <a href="<?php echo $urls; ?>"><span>Login with Outlook</span></a></li>
                </ul>
    
            </div>
        </div>




	
        <?php /* <div class="loginCenter">
			<div class="content clearfix">
				
				<form action="./include/login.php" method="post" id="login">
				
					
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
							<?php 
							$sql = "Select * from cs_users where id = '" . $user . "' ";
						    $result = mysqli_query($con,$sql);
							$users = mysqli_fetch_assoc($result);
							?>

						<div class="field">
							<label for="username">Username</label>
							<input type="text" id="username" name="username" value="<?php echo $users['email'];?>" placeholder="Email Address" class="login username-field" />

						</div> <!-- /field -->
						
						<div class="field">
							<label for="password">Password:</label>
							<input type="password" id="password" name="password" value="<?php echo $users['password'];?>" placeholder="Password" class="login password-field"/>
							<span class="forgot-password"><a href="forgotpassword.php" target="">Forgot?</a></span>
						</div> <!-- /password -->
						
					</div> <!-- /login-fields -->
					
					<div class="login-actions keepmesignin">
						
						<span class="login-checkbox">
							<input id="remember" name="remember" type="checkbox" class="field login-checkbox" value="First Choice" tabindex="4" />
							<label class="choice" for="remember">Keep me signed in</label>
						</span>
					</div> <!-- .actions -->
					<input type="hidden" name="lat" id="lat">
					<input type="hidden" name="long" id="long">
					<input type="hidden" name="browser" id="browser">
					<input type="hidden" name="device" id="device">
					<div class="login-actions loginButton">
						<button name="login" class="button btn btn-success btn-large">Login</button>
					</div>	
				</form>
				
				<div class="login-with center">
					<!-- <span class="or">OR</span> -->
					<h5>Login with Social Account</h5>
					<div class="login-with-social">
						<ul>
							<li class="facebook"><?php require('./facebook/facebook_auth.php'); ?>
					<?php echo $facebook_login_url; ?></li>
							<li class="google"><?php require('./google/auth.php'); ?>
						<?php echo $login_button; ?></li>     
							
							<li class="hotmail"> <a href="<?php echo $urls; ?>"><i class="far fa-lg fa-envelope"></i></a></li>
						</ul>
					</div>
				</div>
				
				
				
			

				
				<!-- <div class="card-footer text-center">
					<div class="small"><a href="signup.php">Need an account? Sign up!</a></div>
				</div> -->
				
			</div>
		</div>  */ ?>		
	</div> <!-- /content -->
	
</div> <!-- 
<script>
var device_session;
var browser_session;
var lat = document.getElementById("lat");
var long = document.getElementById("long");
var browser = document.getElementById("browser");

var devicename = document.getElementById("device");
			const getUA = () => {
			let device = "Unknown";
			const ua = {
			"Generic Linux": /Linux/i,
			"Android": /Android/i,
			"BlackBerry": /BlackBerry/i,
			"Bluebird": /EF500/i,
			"Chrome OS": /CrOS/i,
			"Datalogic": /DL-AXIS/i,
			"Honeywell": /CT50/i,
			"iPad": /iPad/i,
			"iPhone": /iPhone/i,
			"iPod": /iPod/i,
			"macOS": /Macintosh/i,
			"Windows": /IEMobile|Windows/i,
			"Zebra": /TC70|TC55/i,
			}
			Object.keys(ua).map(v => navigator.userAgent.match(ua[v]) && (device = v));
			return device;
			}

			devicename.value = getUA();
			device_session = getUA();


window.onload = function getLocation() {
  if (navigator.geolocation) {
    navigator.geolocation.getCurrentPosition(showPosition);
  } else { 
    lat.value = "-";
    long.value = "-";
  }
  if((navigator.userAgent.indexOf("Opera") || navigator.userAgent.indexOf('OPR')) != -1 ) 
    {
        browser.value = 'Opera';
        browser_session = 'Opera';
    }
    else if(navigator.userAgent.indexOf("Chrome") != -1 )
    {
        browser.value = 'Chrome';
        browser_session = 'Chrome';
    }
    else if(navigator.userAgent.indexOf("Safari") != -1)
    {
        browser.value = 'Safari';
        browser_session = 'Safari';
    }
    else if(navigator.userAgent.indexOf("Firefox") != -1 ) 
    {
         browser.value = 'Firefox';
         browser_session = 'Firefox';
    }
    else if((navigator.userAgent.indexOf("MSIE") != -1 ) || (!!document.documentMode == true )) //IF IE > 10
    {
      browser.value = 'IE'; 
      browser_session = 'IE';
    }  
    else 
    {
       browser.value = 'unknown';
       browser_session = 'unknown';
    }
}

function showPosition(position) {
	lat.value = position.coords.latitude;
	long.value = position.coords.longitude;
	$.ajax({
	 url: 'session_set.php',
	 type: 'POST',
	 data: {
	 	lat:position.coords.latitude,
	 	long:position.coords.longitude,
	 	device:device_session,
	 	browser:browser_session
	 },
	 success: function(resp) {
	      
	  }
	});
}


</script>
-->

</body>
</html>
