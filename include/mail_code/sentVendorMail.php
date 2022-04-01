<?php

include("class.phpmailer.php");
function sentvendorMail($email,$subject,$message){
	
$html               = $message;
//$mail_from          = EMIAL_FROM;
$conn = new mysqli('mysql.islandpharmz.shop', 'islandpharmzshop', 'D3icqXhm','staging');
$sel_loc1 = "SELECT * FROM email_setting WHERE id = '1'";	
$result1 = $conn->query($sel_loc1);
if($result1->num_rows > 0){ 
while($rows = $result1->fetch_assoc()){
		$adminemails = $rows['email'];
		$mail_from = $adminemails;
		
	}
	}

$mail_from_name     = EMIAL_FROM_NAME;

$mail               = new PHPMailer(); // create a new object
$mail->IsSMTP(true); // enable SMTP
$mail->IsHTML(true);
$mail->SMTPDebug    = false; // debugging: 1 = errors and messages, 2 = messages only
$mail->SMTPAuth     = true; // authentication enabled
$mail->SMTPSecure = 'tls'; // secure transfer enabled REQUIRED for GMail
$mail->Host         = 'smtp.sendgrid.net';
$mail->Port         =  SMTP_PORT; // or 587
$mail->Username     = SENDGRID_USERNAME;
$mail->Password     = SENDGRID_PASSWORD;
$mail->SetFrom($mail_from, $mail_from_name);
$mail->Subject      = $subject;
$mail->Body         = $html;
$mail->AddAddress($email);

$response = $mail->Send();
return $response;
}

?>