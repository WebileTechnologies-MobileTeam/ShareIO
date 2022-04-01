<?php

include("class.phpmailer.php");


$html               = $message;
$mail_from          = 'noreply@webiletechnologies.com';
$mail_from_name     = 'ShareIO';

$mail               = new PHPMailer(); // create a new object
$mail->IsSMTP(true); // enable SMTP
$mail->IsHTML(true);
$mail->SMTPDebug    = false; // debugging: 1 = errors and messages, 2 = messages only
$mail->SMTPAuth     = true; // authentication enabled
$mail->SMTPSecure = false; // secure transfer enabled REQUIRED for GMail
$mail->Host         = 'mail.webiletechnologies.com'; //email-smtp.us-west-2.amazonaws.com
$mail->Port         =  587; // or 587
$mail->Username     = 'noreply@webiletechnologies.com'; //AKIAU3PF3ROQRP4PXPE4
$mail->Password     = 'webile123#'; //BAxxNvfb4LCaRjgWfr6YMSM0jouMhW9hrkIHob9pZGbB
$mail->SetFrom($mail_from, $mail_from_name);
$mail->Subject      = $subject;
$mail->Body         = $html;
$mail->AddAddress($email);

$response = $mail->Send();
?>