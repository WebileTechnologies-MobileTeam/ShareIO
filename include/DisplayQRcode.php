<?php

require('./db.php');	

$urlsql = "Select * from sentfile where file_id = '" . $_GET["id"] . "'";

$urlsqlresult = mysqli_query($con,$urlsql);

$url_data = mysqli_fetch_array($urlsqlresult);

?>

<img src="<?php echo $url_data['file_qr'];?>">