<?php
require('./db.php');
session_start();
$userid = $_SESSION["user"];

$ids = implode(",", $_POST['ids']);
if(isset($_POST["package"])){
    $sql = "DELETE FROM package_list WHERE pkg_id IN ($ids)";
    $result = mysqli_query($con,$sql);
    $filepackagelist = "DELETE FROM package_file_list WHERE pkg_fid IN ($ids)";
    $filepackagelist_result = mysqli_query($con,$filepackagelist);
    if($result){
        echo "Packages Deleted Successfully";
    } else{
        echo "error";
    }
} else if(isset($_POST["dahsboard"])){
    $sql = "DELETE FROM user_dashboard WHERE us_dash_id  IN ($ids)";
    $result = mysqli_query($con,$sql);
    if($result){
        $_SESSION['msgdashboard'] = "Dashboards Deleted Successfully";
    } else{
        echo "error";
    }
} else{
    $sql = "delete from sentfile where file_id IN ($ids)";
    $result = mysqli_query($con,$sql);
    $query = "delete from package_file_list where file_fid IN ($ids)";
    $pck_query = mysqli_query($con,$query);
    $trial = "DELETE from trial_setting where fileid IN ($ids)";
    $trial_result = mysqli_query($con,$trial);
    if($result){
        echo "Files Deleted Successfully";
    } else{
        echo "error";
    }
}
