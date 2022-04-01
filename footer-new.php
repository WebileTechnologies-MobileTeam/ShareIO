<?php 
ini_set('display_errors', 0);
require('./include/db.php');
if(!class_exists('S3'))require_once('./include/S3Bucket_config.php');

$upload = 'err'; 

$image_path = 'test';
    

define('AWS_S3_KEY', 'AKIAU3PF3ROQZWVWZAE7');

define('AWS_S3_SECRET', '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');

define('AWS_S3_REGION', 'us-east-2');

define('AWS_S3_BUCKET', 'contentshare-files');

define('AWS_S3_URL', 'http://s3.'.AWS_S3_REGION.'.amazonaws.com/'.AWS_S3_BUCKET.'/');

S3::setAuth(AWS_S3_KEY, AWS_S3_SECRET);

(new S3)->setRegion(AWS_S3_REGION);

S3::setSignatureVersion('v4');



$view = "SELECT COUNT(log_id) as views from cs_log";
$results = mysqli_query($con,$view);
$filedata = mysqli_fetch_array($results);


$user = "SELECT COUNT(id) as user from cs_users where oauth_uid != ''";
$user_results = mysqli_query($con,$user);
$user_filedata = mysqli_fetch_array($user_results);


function formatBytes($size, $precision = 2)
{
    $base = log($size, 1024);
    $suffixes = array('', 'KB', 'MB', 'GB', 'TB');   

    return round(pow(1024, $base - floor($base)), $precision) .' '. $suffixes[floor($base)];
}

function GetDirectorySize($path){
    $bytestotal = 0;
    $path = realpath($path);
    if($path!==false && $path!='' && file_exists($path)){
        foreach(new RecursiveIteratorIterator(new RecursiveDirectoryIterator($path, FilesystemIterator::SKIP_DOTS)) as $object){
            $bytestotal += $object->getSize();
        }
    }
    return $bytestotal;
}

$f = 'upload';
$get = GetDirectorySize($f);
$gb = formatBytes($get);

// function formatSizeUnits($bytes) {
//     if ($bytes >= 1073741824) {
//         $bytes = number_format($bytes / 1073741824, 2) . ' GB';
//     } elseif ($bytes >= 1048576) {
//         $bytes = number_format($bytes / 1048576, 2) . ' MB';
//     } elseif ($bytes >= 1024) {
//         $bytes = number_format($bytes / 1024, 2) . ' KB';
//     } elseif ($bytes > 1) {
//         $bytes = $bytes . ' bytes';
//     } elseif ($bytes == 1) {
//         $bytes = $bytes . ' byte';
//     } else {
//         $bytes = '0 bytes';
//     }
//     return $bytes;
// }
$bucket = (new S3)->getBucket(AWS_S3_BUCKET);
$size = '';
foreach ($bucket as $value) {
    if($value['size'] > 0){
        $size = $size + $value['size'];
    }
}
$totalsize = formatSizeUnits($size);
 
?>

<footer>
	<!-- <ul>
		<li><a href="#">About</a></li>
		<li>:</li>
		<li><a href="#">Faq</a></li>
	</ul> -->
	<span><?php echo number_format($filedata['views']);?> views : <?php echo $totalsize;?> shared</span>
</footer>