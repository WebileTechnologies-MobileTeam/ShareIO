<?php
ini_set('error_reporting', 0);
require('../include/inc/defined_variables.php');
if(!class_exists('S3'))require_once('../include/S3Bucket_config.php');
require_once('../Aws-api/aws-autoloader.php');

use Aws\S3\S3Client;  
use Aws\Exception\AwsException;

$s3 = new S3Client([
        'version' => 'latest',
        'region'  => AWS_S3_REGION,
        'credentials' => [
            'key'    => AWS_S3_KEY,
            'secret' => AWS_S3_SECRET,
        ]
    ]);
    
    $key = 'Files/'.$_POST['file_name'];
    
    $cmd = $s3->getCommand('GetObject', [
        'Bucket' => AWS_S3_BUCKET,
        'Key' => $key
    ]);
  
    $request = $s3->createPresignedRequest($cmd, '+60 seconds');
    
    // Get the actual presigned-url
    $presignedUrl = (string)$request->getUri();
    
    echo $presignedUrl;