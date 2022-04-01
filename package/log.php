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

// echo '<pre>';

// print_r($_SERVER);

$ip = getIPAddress();

$json = resolveIP($ip);

$country = $json->country;

$city = $json->city;

$timezone = $json->timezone;

date_default_timezone_set($timezone);

$date = date('Y-m-d H:i:s');



if(isset($_POST['flag'])){

    

    $check_content = "SELECT * FROM feedback where fileid = '".$id."' AND flag_count != ''";

    $check_content_result = mysqli_query($con,$check_content);

    if(mysqli_num_rows($check_content_result) >= 20){

        echo "block";

    } else{

        $check_flag = "SELECT * FROM feedback where fileid = '".$id."' AND ip_address = '".$ip."'";

        $check_flag_result = mysqli_query($con,$check_flag);

        if(mysqli_num_rows($check_flag_result) < 1){

            $flag_count = "INSERT into feedback(fileid,flag_count,ip_address,date_time) VALUES('".$id."','1','".$ip."','".date('Y-m-d')."')";

            $flag_result = mysqli_query($con,$flag_count);

            if($flag_result){

            	echo "true";

            } else{

            	echo "false";

            } 

        } else{

            $check_flag_row = mysqli_fetch_array($check_flag_result);

            if($check_flag_row['flag_count'] != ''){

                $flag_count_update = "UPDATE feedback SET flag_count = '1' where fileid = '".$id."' AND ip_address = '".$ip."'";

                $flag_update_result = mysqli_query($con,$flag_count_update);

            } else{

                $flag_count_update = "UPDATE feedback SET flag_count = '0' where fileid = '".$id."' AND ip_address = '".$ip."'";

                $flag_update_result = mysqli_query($con,$flag_count_update);

            }

        }

    }

    exit;

}



if(isset($_POST['like'])){

    $check_like = "SELECT * FROM feedback where fileid = '".$id."' AND ip_address = '".$ip."'";

    $check_like_result = mysqli_query($con,$check_like);

    if(mysqli_num_rows($check_like_result) < 1){

        $like_count = "INSERT into feedback(fileid,like_count,ip_address,date_time) VALUES('".$id."','1','".$ip."','".date('Y-m-d')."')";

        $like_result = mysqli_query($con,$like_count);

        if($like_result){

        	echo "true";

        } else{

        	echo "false";

        } 

    } else{

        $check_like_row = mysqli_fetch_array($check_like_result);

        if($check_like_row['like_count'] == ''){

            $like_count_update = "UPDATE feedback SET like_count = '1' where fileid = '".$id."' AND ip_address = '".$ip."'";

            $like_update_result = mysqli_query($con,$like_count_update);

        } else{

            $like_count_update = "UPDATE feedback SET like_count = '0' where fileid = '".$id."' AND ip_address = '".$ip."'";

            $like_update_result = mysqli_query($con,$like_count_update);

        }

    }

    exit;

}





$log = "INSERT into cs_log(package_id,date_time,browser,device,user_name,ip,country,referrer,lattitude,longitude) VALUES('".$id."','".$date."','".$browser."','".$device."','".$userid."','".$ip."','".$country."','".$referer."','".$lat."','".$long."')";

$results = mysqli_query($con,$log);

if($results){

	echo "true";

} else{

	echo "false";

}