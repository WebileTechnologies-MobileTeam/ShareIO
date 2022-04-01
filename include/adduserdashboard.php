<?php
//ini_set('display_errors', 1);
session_start();
require_once './db.php';
require_once './inc/defined_variables.php';
include('../QRcode/phpqrcode/qrlib.php');

$user = $_SESSION['user'];

$check_impression = "SELECT * FROM cs_users where id = '".$user."' OR oauth_uid = '".$user."'";
$result = mysqli_query($con,$check_impression);
$data = mysqli_fetch_array($result);
$impressions = $data['impressions'];
if($impressions <1 || $impressions == '0' || $impressions == ''){	
	$_SESSION['errormsgimp'] = 'You not have enough impressions.';
    header("Location: ../UserCustomDashboard.php");
    exit;
}

$dashboard_name = $_POST['dashboard_name'];

if(isset($_POST['checkname'])){
    $check_dash_name = "SELECT * FROM user_dashboard where dashboard_name = '".$dashboard_name."' && user_id = '".$user."'";
    $check_result = mysqli_query($con,$check_dash_name);
    $rows = mysqli_num_rows($check_result);
    if($rows >= 1){	
        echo "false";
        exit;
    }
}

$data = $_POST['dashboard_data'];
$browser_enabled = $_POST['browser_view'];
$notification = $_POST['notification'];
$social_share = $_POST['social_share'];
$password = $_POST['password'];
$ip_dns = $_POST['ip_dns'];
$bg_color = $_POST['bg_color'];
$hide_banner = $_POST['hide_banner'];
$block_country = json_encode(array_unique($_POST['block_country']));

function generateRandomString($length = 10) {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    // for ($i = 0; $i < 23; $i++) {
    //     $randomString .= $file_md5[rand(0, $charactersLength - 1)];
    // }
    return $randomString;
}

$url = generateRandomString();
$file_md5 = md5($url);
$file_md5 .= $url;
$file_md5 = substr($file_md5, 10);
date_default_timezone_set('Europe/London');
$datetime = gmdate("Y-m-d H:i:s");

$query = "INSERT INTO user_dashboard(
                                user_id,
                                dashboard_name,
                                dashboard_data,
                                dashboard_url,
                                bg_color,
                                password,
                                ip_dns,
                                browser_enabled,
                                notification,
                                social_share,
                                hide_banner,
                                block_countries,
                                created_date) 
                                VALUES(
                                '" . addslashes($user) . "',
                                '" . addslashes($dashboard_name) ."',
                                '" . addslashes($data) . "',
                                '" . addslashes($file_md5) . "',
                                '" . addslashes($bg_color) . "',
                                '" . addslashes($password) . "',
                                '" . addslashes($ip_dns) . "',
                                '" . addslashes($browser_enabled) . "',
                                '" . addslashes($notification) . "',
                                '" . addslashes($social_share) . "',
                                '" . addslashes($hide_banner) . "',
                                '" . addslashes($block_country) ."',
                                '" . addslashes($datetime) . "')";

if( $con->query($query) === TRUE ){

    $last_id = $con->insert_id;
    $imp = (int)$impressions - 1;
    $imp_update = "UPDATE cs_users set impressions = '".$imp."' where id = '".$user."' OR oauth_uid = '".$user."'";
    $imp_update_result = $con->query($imp_update);

    $imp_date = date('Y-m-d');
    $imp_query = "INSERT INTO file_impression(
            file_id,
            impression,
            imp_date
            ) VALUES(
            '" . addslashes($last_id) . "',
            '1',
            '" . addslashes($imp_date) . "'
            )";
    $imp_query_result = $con->query($imp_query);

    $tempDir = '../upload/';

    $codeContents = SITE_URL.'/dashboard/'.$file_md5;
    $fileName = $file_md5.'qrcode.png';

    $pngAbsoluteFilePath = $tempDir.$fileName;
    $urlRelativeFilePath = $tempDir.$fileName;

    QRcode::png($codeContents, $pngAbsoluteFilePath); 

    $path = SITE_URL."/upload/".$fileName;

    $sql = "UPDATE user_dashboard set dashboard_qr = '".$path."' where us_dash_id  = '".$last_id."'";
    $result = $con->query($sql);
    $_SESSION['succsessmsg'] = 'Dashboard Saved Successfully';
	header("Location: ../reports.php?d=1");
} else{
    $_SESSION['error'] = 'There is some issue please try again.';
    //echo("Error description: " . $con -> error);
	header("Location: ../UserCustomDashboard.php");
}
