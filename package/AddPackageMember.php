<?php
require('../include/db.php');

$package_member = "INSERT into package_members(package_id, email) VALUES('".$_POST['package_id']."', '".$_POST['email']."')";
$package_member_result = mysqli_query($con,$package_member);
if($package_member_result){
    echo "true";
} else{
    echo "false";
}