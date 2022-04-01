<?php
require_once './db.php';
require_once '../vendor/stripe/stripe-php/init.php'; 
session_start();
if(isset($_POST['addnew'])){
	$firstname = $_POST['firstname'];
	$lastname = $_POST['lastname'];
	$email = $_POST['emailaddress'];
	$organization = $_POST['organizationname'];
	$password = md5($_POST['password']);
	$link = "https://contentshare.me/include/activateuser.php?email=".$email;
	$sql="SELECT * FROM `cs_users` WHERE email='$email'";

	
        $res=mysqli_query($con,$sql);
        if (mysqli_num_rows($res) > 0) {
        // output data of each row
        echo "<div class='alert alert-danger'>Email already exists</div>";
		}
        else{

        	\Stripe\Stripe::setApiKey('sk_test_ZHBPscwQ2uvawFY7Fq1E3DAC');


			$account = \Stripe\Account::create([
			  'country' => 'US',
			  'type' => 'express',
			]);

			$id = $account['id'];

			$account_links = \Stripe\AccountLink::create([
			  'account' => $id,
			  'refresh_url' => 'https://contentshare.me/',
			  'return_url' => 'https://contentshare.me/dashboard.php',
			  'type' => 'account_onboarding',
			]);
			$url = $account_links['url'];

			$date = date("Y-m-d");
			 $sql = "INSERT INTO cs_users(fname,lname,email,password,active,organization,stripe_acc_id,stripe_acc_url,create_date,impressions) VALUES('$firstname','$lastname','$email','$password','0','$organization','$id','$url','$date','100')";

		if( $con->query($sql) === TRUE ){

			 $subject = 'Activate Your Account';
	         $message = '<div style="background-color:#cccccc30;padding:30px;">
				<img src="http://3.135.223.154/image/logo.png" style="display: block;min-width:50px;max-width:150px;height: auto;margin: 30px auto;">
				
				<div style="max-width: 480px;margin: auto; padding: 15px;margin-bottom: 15px;display:block;background-color: #fff;">
					<div>
						<p style="text-align:center;font-size: 24px;margin-bottom: 30px;">Hi, <strong>'.$firstname.'!</strong></p>
						 <center>
                        <p><span style="font-family: Muli, &quot;Arial Narrow&quot;, Arial; font-size: 25px; text-align: center; background-color: rgb(255, 255, 255);">Activate Your Account</span></p>
                        <p><span style="font-family: Muli, &quot;Arial Narrow&quot;, Arial; font-size: 15px; text-align: center; background-color: rgb(255, 255, 255);">Press the button to activate your account by activating you are able to login to your account.</span></p>
                       <a href=' . $link . ' style=" display: block;width: 115px;height: 25px;background: #44b3ea;padding: 10px;text-align: center;border-radius: 5px;color: white;font-weight: bold;line-height: 25px;text-decoration: none;"> Activate </a>
                       </center>
					</div>
				    
				</div>
				<div>
					<p style="text-align:center;margin-bottom:0; font-family:avenir; font-size: 14px;">Powered by <a href="#" style="font-weight:bold;color:#44b3ea;text-decoration: none;">CONTENTSHARE</a></p>
				</div>
			</div>';
	        include('mail_code/sentMail.php');
            if ($response){
	            $_SESSION['succsessmsg'] = "Thank you for signing up. Please activate your account via the email link we have sent on your email.";
	             header('Location: ../login.php');
	        }else{
	            $_SESSION['error'] = "Sorry, email was not send. Please try again.";
                header('Location: ../login.php');
	        }
			}else{
				echo "<div class='alert alert-danger'>Error: There was an error while adding new user</div>";
			}
        }

	

}