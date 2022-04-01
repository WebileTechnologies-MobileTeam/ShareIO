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
    header("Location: ../EditDashboard.php?id=".$_POST['dashboard_id']);
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

$query = "UPDATE user_dashboard set dashboard_name = '" . addslashes($dashboard_name) ."',
                                    dashboard_data = '" . addslashes($data) . "', 
                                    bg_color = '" . addslashes($bg_color) . "', 
                                    password = '" . addslashes($password) . "',
                                    ip_dns = '" . addslashes($ip_dns) . "',
                                    browser_enabled = '" . addslashes($browser_enabled) . "',
                                    notification = '" . addslashes($notification) . "',
                                    social_share = '" . addslashes($social_share) . "',
                                    hide_banner = '" . addslashes($hide_banner) . "',
                                    block_countries = '" . addslashes($block_country) ."',
                                    updated = '1'
                                    where us_dash_id = '".$_POST['dashboard_id']."'";

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
    $_SESSION['succsessmsg'] = 'Dashboard Updated Successfully';
	header("Location: ../EditDashboard.php?id=".$_POST['dashboard_id']);
} else{
    $_SESSION['error'] = 'There is some issue please try again.';
    //echo("Error description: " . $con -> error);
	header("Location: ../EditDashboard.php?id=".$_POST['dashboard_id']);
}
