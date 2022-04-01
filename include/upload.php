<?php

session_start();

ini_set( 'upload_max_size' , '64M' );

ini_set('display_errors', 1);

require_once('../getid3/getid3.php');

if(!class_exists('S3'))require_once('S3Bucket_config.php');

$upload = 'err'; 

$image_path = 'test';

if(!empty($_FILES['file'])){ 

     

     

 define('AWS_S3_KEY', 'AKIAU3PF3ROQZWVWZAE7');

 define('AWS_S3_SECRET', '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');

 define('AWS_S3_REGION', 'us-east-2');

 define('AWS_S3_BUCKET', 'contentshare-files');

 define('AWS_S3_URL', 'http://s3.'.AWS_S3_REGION.'.amazonaws.com/'.AWS_S3_BUCKET.'/');

 

    $tmpfile = $_FILES['file']['tmp_name'];

    $file = $_FILES['file']['name'];

    $ext = pathinfo($file, PATHINFO_EXTENSION);

    if($ext == 'mp3' || $ext == 'mpeg'){

        $getID3 = new getID3;

        $tags = $getID3->analyze($tmpfile);

        $file_md = md5($file);

        //print_r($tags);

        if (isset($tags['comments']['picture']['0']['data'])) {

            $image = $tags['comments']['picture']['0']['data'];

            if(file_put_contents('../upload/thumb'.$file_md.'.jpg', $image)) {

                $_SESSION['thuburl'] = 'https://shareio.com/upload/thumb'.$file_md.'.jpg';

            } else {

                

            }

        } else{
            $_SESSION['thuburl'] = '';
        }

    }

    //if (defined('AWS_S3_URL')) {

      // Persist to AWS S3 and delete uploaded file

      S3::setAuth(AWS_S3_KEY, AWS_S3_SECRET);

      (new S3)->setRegion(AWS_S3_REGION);

      S3::setSignatureVersion('v4');

      if((new S3)->putObjectFile($tmpfile, AWS_S3_BUCKET, 'Files/'.$file, S3::ACL_PUBLIC_READ)){

         echo $furl = 'https://'.AWS_S3_BUCKET.".s3.amazonaws.com/Files/".$file;

      } else {

     // Persist to disk

     

    

     // File upload configuration 

    $targetDir = "https://shareio.com/upload/"; 

    $allowTypes = array('pdf', 'doc', 'docx', 'jpg', 'png', 'jpeg', 'gif', 'mp3', 'mp4'); 

     

    $fileName = basename($_FILES['file']['name']); 

    $targetFilePath = $targetDir.$fileName; 

     

    // Check whether file type is valid 

    $fileType = pathinfo($targetFilePath, PATHINFO_EXTENSION); //in_array($fileType, $allowTypes) &&

    if(($_FILES["file"]["size"] < 1111097152)){ 

        // Upload file to the server 

        if(file_exists($targetDir . $_FILES["file"]["name"])){

                    $msg =  $_FILES["file"]["name"] . " <span id='invalid'><b>already exists.</b></span> ";

                    echo 'no';

                }

                else{

                    $sourcePath = $_FILES['file']['tmp_name']; // Storing source path of the file in a variable

                    $targetPath = "../upload/".date("dmyhis").$_FILES['file']['name']; // Target path where file is to be stored

                    if(move_uploaded_file($sourcePath,$targetPath)){

                        $image_path = SITE_URL.'/upload/'.date("dmyhis").$_FILES['file']['name'];  //'/upload/'.date("dmyhis").

                    } // Moving Uploaded file

                    

                    

                    echo $image_path;

                    //echo date("dmyhis").$_FILES['file']['name']; 

                }

    }else{

        echo 'invalid';

    } 

  }

 

    

} 

if(isset($_POST['thuburl'])){
    echo $_SESSION['thuburl'];
}
?>