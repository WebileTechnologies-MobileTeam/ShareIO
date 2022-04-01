<?php
require('../include/db.php');
require('../include/inc/defined_variables.php');

$check_package = "Select * from package_list where pkg_id  = '".$_POST['package_id']."'";
$check_package_result = mysqli_query($con,$check_package);
if(mysqli_num_rows($check_package_result) > 0){ ?>
    <div class="imgal-container">
    <?php
    $data = mysqli_fetch_array($check_package_result);
    $file_list_query = "Select * from package_file_list where pkg_fid  = '".$_POST['package_id']."'";
    $file_list_result = mysqli_query($con,$file_list_query);
    if(mysqli_num_rows($file_list_result) > 0){
        while($file_list = mysqli_fetch_array($file_list_result)){
            $file_query = "Select * from sentfile where file_id  = '".$file_list['file_fid']."'";
            $file_result = mysqli_query($con,$file_query);
            $file_data = mysqli_fetch_array($file_result); 
            $imgurl = str_replace('contentshare.me', 'shareio.com', $file_data['file_thumbnail']);
            $fileurl = '';
            if($file_data['file_type'] == 'audio/mpeg' || $file_data['file_type'] == 'audio/mp3'){
                $fileurl = SITE_URL.'/files/start/'.$file_data['file_hash'];
            } else{
                $fileurl = SITE_URL.'/file/'.$file_data['file_hash'];
            }
            $filename = '';
            if(strlen($file_data['file_name']) > 20){
                $filename = substr_replace($file_data['file_name'], "...", 20);
            } else{
                $filename = $file_data['file_name'];
            }
            ?>
            <a href="<?php echo $fileurl;?>" <?php if($file_data['file_type'] == 'application/pdf'){?> class="pdf_package_file" <?php }?>>
                <?php 
                if($file_data['file_type'] == 'video/mp4' || $file_data['file_type'] == 'video/webm'){ ?>
                        <video src="<?php echo $file_data['file_url'];?>#t=5"></video>
                <?php
                } else{ ?>
                        <img src="<?php echo $imgurl;?>" alt="ShareIO" class="imgal-img">
                <?php }
                ?>
                <div class="aligment">
                    <div class="aligment">
                        <?php 
                        if($file_data['file_type'] == 'video/mp4' || $file_data['file_type'] == 'video/webm' || $file_data['file_type'] == 'audio/mp3' || $file_data['file_type'] == 'audio/mpeg'){ ?>
                        <p class="package_file_name">
                            <svg xmlns="http://www.w3.org/2000/svg" enable-background="new 0 0 24 24" height="24px" viewBox="0 0 24 24" width="24px" fill="#ffffff"><g><rect fill="none" height="24" width="24"/></g><g><path d="M12,2C6.48,2,2,6.48,2,12s4.48,10,10,10s10-4.48,10-10S17.52,2,12,2z M9.5,16.5v-9l7,4.5L9.5,16.5z"/></g></svg>
                        </p>
                        <?php }?>
                        <p class="package_file_name"><?php echo $filename;?></p>
                    </div>
                </div>
            </a>
        <?php
        }        
    } else{
        echo "file";
    } ?>
    </div>
<?php    
} else{
	echo "false";
	//header("Location: filenotfound.php");
}