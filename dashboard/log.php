<?php

require('../include/db.php');

$id = $_POST['id'];
$referer = $_POST['referer'];
$userid = '1';
$lat = $_POST['lat'];
$long = $_POST['long'];
$browser = $_POST['browser'];
$device = $_POST['device'];

function getIPAddress() {  
    //whether ip is from the share internet  
     if(!empty($_SERVER['HTTP_CLIENT_IP'])) {  
                $ip = $_SERVER['HTTP_CLIENT_IP'];  
        }  
    //whether ip is from the proxy  
    elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {  
                $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];  
     }  
//whether ip is from the remote address  
    else{  
             $ip = $_SERVER['REMOTE_ADDR'];  
     }  
     return $ip;  
} 
//Getting user location from ip address

function resolveIP($ip) {
    $string = file_get_contents("http://ipinfo.io/{$ip}?token=385d79682c9165");
    $json = json_decode($string);
    return $json;
}

$ip = getIPAddress();
$json = resolveIP($ip);
$country = $json->country;
$city = $json->city;
$timezone = $json->timezone;
date_default_timezone_set($timezone);
$date = date('Y-m-d H:i:s');

$log = "INSERT into cs_log(dashboard_id,date_time,browser,device,user_name,ip,country,referrer,lattitude,longitude) VALUES('".$id."','".$date."','".$browser."','".$device."','".$userid."','".$ip."','".$country."','".$referer."','".$lat."','".$long."')";

$results = mysqli_query($con,$log);

if($results){
	echo "true";
} else{
	echo "false";
}