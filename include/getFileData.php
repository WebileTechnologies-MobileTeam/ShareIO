<?php
include_once('./inc/defined_variables.php');
require('./db.php');
ini_set( 'upload_max_size' , '64M' );
ini_set('display_errors', 1);
require_once('../getid3/getid3.php');
if(!class_exists('S3'))require_once('S3Bucket_config.php');
$upload = 'err'; 
$image_path = 'test';
if(isset($_GET['file-id'])){
    $file = "Select * from sentfile where file_id = '" . $_GET['file-id'] . "'";
    $fileresult = mysqli_query($con,$file);
    $fetch_data = mysqli_fetch_array($fileresult);
    $fileurl = '';
    if($fetch_data['file_type'] == 'audio/mpeg' || $fetch_data['file_type'] == 'audio/mp3'){
        $fileurl = SITE_URL.'/files/start/'.$fetch_data['file_hash'];
    } else{
        $fileurl = SITE_URL.'/file/'.$fetch_data['file_hash'];
    }
    $imgurl = str_replace('contentshare.me', 'shareio.com', $fetch_data['file_thumbnail']);
    $content = '';
    $class = '';
    $type = "";
    if($fetch_data['file_type'] == 'video/mp4' || $fetch_data['file_type'] == 'video/webm'){ 
        $content = '<video src="'.$fetch_data['file_url'].'#t=5" style="height: 100%;width: 100%;"></video>';
        $class = 'video_file';
        $type = "File";
    } else{ 
        $type = "File";
        $content = '<img src='.$imgurl.' style="height: 100%;width: 100%;">';
    }
    $html = '<a class="remove-stack" onclick="grid.removeWidget(this.parentNode.parentNode)"><i class="fa fa-times" aria-hidden="true"></i></a><a class="changefile '.$class.'" data-href='.$fileurl.' data-image="show" data-id="'.$_GET['file-id'].'" data-type="'.$type.'">'.$content.'<p id="title"></p></a>';
    echo $html;
}

if(isset($_POST['reset'])){
    if($_POST['type'] == 'File'){
        $file = "Select * from sentfile where file_id = '" . $_POST['id'] . "'";
        $fileresult = mysqli_query($con,$file);
        $fetch_data = mysqli_fetch_array($fileresult);
        $imgurl = str_replace('contentshare.me', 'shareio.com', $fetch_data['file_thumbnail']);
        $content = '';
        $type = "";
        if($fetch_data['file_type'] == 'video/mp4' || $fetch_data['file_type'] == 'video/webm'){ 
            $content = '<video src="'.$fetch_data['file_url'].'#t=5" style="height: 100%;width: 100%;" id="backgroud_img"></video>';
            $tileHtml = '<video src="'.$fetch_data['file_url'].'#t=5" style="height: 100%;width: 100%;"></video>';
            $type = "video";
        } else{ 
            $content = '<img src='.$imgurl.' style="height:100%;width:100%;" id="backgroud_img">';
            $tileHtml = '<img src='.$imgurl.' style="height:100%;width:100%;">';
            $type = "image";
        }
        $data = array(
            'type' => $type,
            'html' => $content,
            'tileHtml' => $tileHtml
        );
        echo json_encode($data);
    } else{
        $type = "image";
        $content = '<img src="https://shareio.com/upload/thumb624a6dd45de61087ba1f587QTvI8rum2.jpg" id="backgroud_img" />';
        $tileHtml = '<img src="https://shareio.com/upload/thumb624a6dd45de61087ba1f587QTvI8rum2.jpg"/>';
        $data = array(
            'type' => $type,
            'html' => $content,
            'tileHtml' => $tileHtml
        );
        echo json_encode($data);
    }
}

if(!empty($_FILES['upload_file'])){ 
    define('AWS_S3_KEY', 'AKIAU3PF3ROQZWVWZAE7');
    define('AWS_S3_SECRET', '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');
    define('AWS_S3_REGION', 'us-east-2');
    define('AWS_S3_BUCKET', 'contentshare-files');
    define('AWS_S3_URL', 'http://s3.'.AWS_S3_REGION.'.amazonaws.com/'.AWS_S3_BUCKET.'/');
    $tmpfile = $_FILES['upload_file']['tmp_name'];
    $file = $_FILES['upload_file']['name'];
    $ext = pathinfo($file, PATHINFO_EXTENSION);

    S3::setAuth(AWS_S3_KEY, AWS_S3_SECRET);
    (new S3)->setRegion(AWS_S3_REGION);
    S3::setSignatureVersion('v4');

    if((new S3)->putObjectFile($tmpfile, AWS_S3_BUCKET, 'UserCustomDashboard/'.$file, S3::ACL_PUBLIC_READ)){
        echo $furl = 'https://'.AWS_S3_BUCKET.".s3.amazonaws.com/UserCustomDashboard/".$file;
    }
}

?>