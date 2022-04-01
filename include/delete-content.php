<?php

require('./db.php');

session_start();

$userid = $_SESSION["user"];

if(isset($_GET["pkgid"])){
    $sql = "DELETE FROM package_list WHERE pkg_id = '".$_GET['pkgid']."'";
    $result = mysqli_query($con,$sql);
    $filepackagelist = "DELETE FROM package_file_list WHERE pkg_fid = '".$_GET['pkgid']."'";
    $filepackagelist_result = mysqli_query($con,$filepackagelist);
    if($result){
        echo "Package Deleted Successfully";
    } else{
        echo "error";
    }
} else if(isset($_GET["dahsboardid"])){
    $sql = "DELETE FROM user_dashboard WHERE us_dash_id  = '".$_GET['dahsboardid']."'";
    $result = mysqli_query($con,$sql);
    if($result){
        $_SESSION['msgdashboard'] = "Dashboard Deleted Successfully";
    } else{
        echo "error";
    }
} else{
    $sql = "delete from sentfile where file_id = '" . $_GET["id"] . "' ";
    $result = mysqli_query($con,$sql);
    $query = "delete from package_file_list where file_fid = '" . $_GET["id"] . "' ";
    $pck_query = mysqli_query($con,$query);
    $trial = "DELETE from trial_setting where fileid = '". $_GET["id"] ."'";
    $trial_result = mysqli_query($con,$trial);
    if($result){
        echo "Content Deleted Successfully";
    } else{
        echo "error";
    }
}