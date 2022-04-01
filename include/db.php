<?php
$localhost = "localhost"; //your host name
$username = "root"; // your database name
$password = "05033bda6444cb66"; // your database password
$dbname = "contentshareweb";

$con = new mysqli($localhost, $username, $password, $dbname);


if($con->connect_error) {
    die("connection failed : " . $con->connect_error);
}


/* end of file */
?>