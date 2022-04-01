<?php

include('qrlib.php');
include('../../include/db.php');

$tempDir = '../../upload/';

$codeContents = 'http://3.135.223.154/file/'.$_POST['hash'];

$fileName = $_POST['hash'].'qrcode.png';

$pngAbsoluteFilePath = $tempDir.$fileName;
$urlRelativeFilePath = $tempDir.$fileName;

QRcode::png($codeContents, $pngAbsoluteFilePath); 

$path = "http://3.135.223.154/upload/".$fileName;

$sql = "UPDATE sentfile set file_qr = '".$path."' where file_id = '".$_POST['id']."'";
if( $con->query($sql) === TRUE ){
	echo "true";
} else{
	echo "false";
}

?>
