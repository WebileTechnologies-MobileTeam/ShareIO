<?php
require_once './db.php';
session_start();
$page = $_POST['page_id'];
$time = $_POST['time'];
$file_id = $_POST['file_id'];
$datetime = date("Y-m-d");
$file = "SELECT * FROM `document_stats` where fileid = '".$file_id."' and page_number = '".$page."' and date_time = '".$datetime."'";
$results = mysqli_query($con,$file);
if(mysqli_num_rows($results) > 0){
	$row = mysqli_fetch_array($results);
	$times = $row['page_time'] + 1;
	$timeupdate = "UPDATE `document_stats` set page_time = '".$times."' where fileid = '".$file_id."' and page_number = '".$page."' and date_time = '".$datetime."'";
	$time_result = mysqli_query($con,$timeupdate);
} else{
	$timeinsert = "INSERT into `document_stats`(fileid,page_number,page_time,date_time) VALUES('".$file_id."', '".$page."', '".$time."', '".$datetime."')";
	$time_result = mysqli_query($con,$timeinsert);
}

