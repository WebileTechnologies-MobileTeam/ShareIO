<?php
include("./include/db.php");
echo"hekj";
$sql = "SELECT emailaddress FROM users WHERE emailaddress = " .$_POST['email'];
$select = mysqli_query($con, $sql);
$row = mysqli_fetch_assoc($select);

if (mysqli_num_rows > 0) {
    echo "exist";
}else echo 'notexist';
?>