<?php
require('./db.php');
session_start();
if(!empty($_POST["username"])) {
	$sql = "Select * from cs_users where email = '" . $_POST["username"] . "'";
    $result = mysqli_query($con,$sql);
	$user = mysqli_num_rows($result);
	$email = $_POST["username"];
	//print_r($user);
	$link = "http://magehubextensions.com/contentshare/include/resetpassword.php?email=".$email;
	if($user > 0) {
			$row = mysqli_fetch_assoc($result);
			$name = $row['fname'];
		
             $subject = 'Forgot Password';
	        $message = '<div style="background-color:#cccccc30;padding:30px;">
				<img src="http://magehubextensions.com/contentshare/image/logo.png" style="display: block;min-width:50px;max-width:150px;height: auto;margin: 30px auto;">
				
				<div style="max-width: 480px;margin: auto; padding: 15px;margin-bottom: 15px;display:block;background-color: #fff;">
					<div>
						<p style="text-align:center;font-size: 24px;margin-bottom: 30px;">Hi, <strong>'.$name.'!</strong></p>
						 <center>
                        <p><span style="font-family: Muli, &quot;Arial Narrow&quot;, Arial; font-size: 25px; text-align: center; background-color: rgb(255, 255, 255);">Forgot your password?</span></p>
                        <p><span style="font-family: Muli, &quot;Arial Narrow&quot;, Arial; font-size: 15px; text-align: center; background-color: rgb(255, 255, 255);">Click on the button below to reset your password.</span></p>
                       <a href=' . $link . ' style=" display: block;width: 115px;height: 25px;background: #44b3ea;padding: 10px;text-align: center;border-radius: 5px;color: white;font-weight: bold;line-height: 25px;text-decoration: none;"> Reset Password </a>
                       </center>
					</div>
				    
				</div>
				<div>
					<p style="text-align:center;margin-bottom:0; font-family:avenir; font-size: 14px;">Powered by <a href="#" style="font-weight:bold;color:#44b3ea;text-decoration: none;">CONTENTSHARE</a></p>
				</div>
			</div>';

	        include('mail_code/sentMail.php');
            if ($response){
	            $_SESSION['success'] = "Please check your email for password reset link.";
                header('Location: ../forgotpassword.php');
	        }else{
	            $_SESSION['error'] = "Sorry, email was not send. Please try again.";
                header('Location: ../login.php');
	        }
        } else{
        	$_SESSION['error'] = "Sorry, you are not a registered user.";
        	header('Location: ../forgotpassword.php');
        }
    
    }
