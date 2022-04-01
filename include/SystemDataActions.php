<?php
require('./db.php');
session_start();
$ids = implode(",", $_POST['ids']);
if($_POST["action"] == 'delete'){
    $sql = "DELETE FROM cs_users WHERE id IN ($ids)";
    $result = mysqli_query($con,$sql);
    if($result){
        echo "Users Deleted Successfully";
    } else{
        echo "error";
    }
} else if($_POST["action"] == 'unblock'){
    $sql = "UPDATE cs_users SET is_blocked = '0' WHERE id IN ($ids)";
    $result = mysqli_query($con,$sql);
    if($result){
        echo "Selected Users are Unblocked Successfully";
    } else{
        echo "error";
    }
} else{
    $sql = "UPDATE cs_users SET is_blocked = '1' WHERE id IN ($ids)";
    $result = mysqli_query($con,$sql);
    if($result){
        echo "Selected Users are Blocked Successfully";
    } else{
        echo "error";
    }
}