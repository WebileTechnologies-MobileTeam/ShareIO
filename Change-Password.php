<!DOCTYPE html>
<?php
//ini_set('display_errors', 1);
if(isset($_SESSION['user'])){  
  header("Location: login.php");
}
 require_once './vendor/stripe/stripe-php/init.php'; 
\Stripe\Stripe::setApiKey('sk_test_ZHBPscwQ2uvawFY7Fq1E3DAC');
?>
<html lang="en">
	<?php require('./include/db.php');
		session_start(); ?>
	<?php require('head.php'); ?>
<style>
#frmCheckPassword {
    border-top: #F0F0F0 2px solid;
    background: #808080;
    padding: 10px;
}

.demoInputBox {
    padding: 7px;
    border: #F0F0F0 1px solid;
    border-radius: 4px;
}

#password-strength-status {
    padding: 5px 10px;
    color: #FFFFFF;
    border-radius: 4px;
    margin-top: 5px;
}

.medium-password {
    background-color: #ffd35e;
    border: #ffd35e 1px solid;
}

.weak-password {
    background-color: #ff4545;
    border: #ff4545 1px solid;
}

.strong-password {
    background-color: #3abb1c;
    border: #3abb1c 1px solid;
}
</style>
	<body>
		<?php require('header-new.php'); 
		?>
		<main>
			<div class="container new_container">
				<div class="row">
					<div class="col-md-12">
						<div class="main_content hidden">
							 

							<div class="stripe_bg">
							    	<?php
									$sql = "SELECT * from cs_users where id = '" . $_SESSION["user"] . "' OR oauth_uid =  '" . $_SESSION["user"] . "'";
                                    $result = mysqli_query($con,$sql);
                                    $fetch_data = mysqli_fetch_array($result);?>
                                <div class="change_password_container"> 
                                    <div class="change_password">
                                        <h1>Change Password</h1>
                                            <div class="form-group">
                                                <label>Old Password</label>
                                                <input type="password" class="form-control" id="oldpass" name="oldpass">
                                                <label id="oldpass-err"></label>
                                            </div>
                                            <div class="form-group">
                                                <label>New Password</label>
                                                <input type="password" class="form-control" onkeyup="checkPasswordStrength()" id="newpassword" name="newpassword">
                                                <label id="newpass-err"></label>
                                                <div id="password-strength-status"></div>
                                            </div>
                                            <div class="form-group">
                                                <label>Confirm Password</label>
                                                <input type="password" class="form-control" id="cnfpass" name="cnfpass">
                                                <label id="err"></label>
                                            </div>
                                            <a class="btn btn-primary" id="submit">Submit</a>
                                    </div>
                                </div>
						    </div>
					</div>
				</div>
			</div>
		</main>
		<?php require('footer-new.php'); ?>
	</body>
<script>

	jQuery(document).ready(function($){

	$( ".main_content" ).removeClass("hidden");
	//open popup
	$('.cd-popup-trigger').on('click', function(event){
		event.preventDefault();

		var id = <?php echo json_encode($fetch_data['id'])?>;
		var price = $('#price').val();
		if(price == ''){
			$('#price_valid').show();
			return;
		}

		$('.cd-popup').addClass('is-visible');
		
		$.ajax({
		type: "POST",
		url: "include/purchase-impression.php",
		data:{
			id:id,
			price:price
		},
		success: function(html){ 
			$(".cd-popup-container").html(html);
			//$(".close").css("display", "none");
			}
		});
	});
	
	//close popup
	$('.cd-popup').on('click', function(event){
		if( $(event.target).is('.cd-popup-close') || $(event.target).is('.cd-popup') ) {
			event.preventDefault();
			$(this).removeClass('is-visible');
		}
	});
	//close popup when clicking the esc keyboard button
	$(document).keyup(function(event){
    	if(event.which=='27'){
    		$('.cd-popup').removeClass('is-visible');
	    }
    });

	});
	
	function checkPasswordStrength() {
            var number = /([0-9])/;
            var alphabets = /([a-zA-Z])/;
            var special_characters = /([~,!,@,#,$,%,^,&,*,-,_,+,=,?,>,<])/;
            if ($('#newpassword').val().length < 6) {
                $('#password-strength-status').removeClass();
                $('#password-strength-status').addClass('weak-password');
                $('#password-strength-status').html("Weak (should be atleast 6 characters.)");
                $("#create").prop('disabled', true);
            } else {
                if ($('#newpassword').val().match(number) && $('#newpassword').val().match(alphabets) && $('#newpassword').val().match(special_characters)) {
                    $('#password-strength-status').removeClass();
                    $('#password-strength-status').addClass('strong-password');
                    $('#password-strength-status').html("Strong");
                    $("#create").prop('disabled', false);
                } else {
                    $('#password-strength-status').removeClass();
                    $('#password-strength-status').addClass('medium-password');
                    $('#password-strength-status').html("Medium (should include alphabets, numbers and special characters.)");
                    $("#create").prop('disabled', true);
                }
            }
        }
    
    $('#submit').on('click', function(){
       var oldpass = $('#oldpass').val();
       var newpass = $('#newpassword').val();
       var cnfpass = $('#cnfpass').val();
       if(oldpass == ''){
         $('#oldpass-err').addClass('alert alert-danger').show();
         $('#oldpass-err').html('Please Enter Old Password.');  
         setInterval(function(){ 
             $('#oldpass-err').fadeOut();
         }, 6000);
         return false;
       }
       if(newpass == ''){
         $('#newpass-err').addClass('alert alert-danger').show();
         $('#newpass-err').html('Please Enter Password.');
         setInterval(function(){ 
             $('#newpass-err').fadeOut();
         }, 6000);
         return false;
       }
       if(cnfpass == ''){
         $('#err').addClass('alert alert-danger').show();
         $('#err').html('Please Enter Confirm Password.');  
         setInterval(function(){ 
             $('#err').fadeOut();
         }, 6000);
         return false;
       }
       if(cnfpass == newpass){
           $.ajax({
    		type: "POST",
    		url: "include/update-password.php",
    		data:{
    			oldpass:oldpass,
    			newpass:newpass
    		},
    		success: function(resp){ 
    			if(resp == 'false'){
    			     $('#oldpass-err').addClass('alert alert-danger').show();
                     $('#oldpass-err').html('Please Enter Correct Password.');  
                     setInterval(function(){ 
                         $('#oldpass-err').fadeOut();
                     }, 6000);
    			} else{
    			    window.location = "setting.php";
    			}
    			}
    		});
       } else{
           $('#err').html('Confirm Password need to match Password');
           return;
       }
    });
	

</script>
</html>