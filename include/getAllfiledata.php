<?php require('./db.php');

session_start(); ?>

<tbody id="file_list">

<?php

$start_from = $_POST['start_from'];

$results_per_page = $_POST['results_per_page'];



$sql = "Select * from sentfile where added_by = '" . $_GET["user"] . "' ORDER BY file_id DESC LIMIT $start_from,$results_per_page";

$result = mysqli_query($con,$sql);

if (mysqli_num_rows($result) > 0) { 

while($fetch_data = mysqli_fetch_array($result)){

// echo "<pre>";

// print_r($fetch_data);

//$filename = substr($fetch_data['file'],62);

//$fileurl = $fetch_data['url'];

?>



<tr class="report-data">


<td><input type="checkbox" name="file_ids[]" value="<?php echo $fetch_data["file_id"];?>"></td>
<td class="date"><?php echo date_format(date_create($fetch_data["date_time"]),"H:i:s m/d/Y");?></td>
<td class="link_icon">
    <a href="edit-file.php?id=<?php echo $fetch_data["file_id"];?>">
    <svg xmlns="http://www.w3.org/2000/svg" height="30px" viewBox="0 0 24 24" width="30px" fill="#ffffff"><path d="M0 0h24v24H0z" fill="none"/><path d="M3.9 12c0-1.71 1.39-3.1 3.1-3.1h4V7H7c-2.76 0-5 2.24-5 5s2.24 5 5 5h4v-1.9H7c-1.71 0-3.1-1.39-3.1-3.1zM8 13h8v-2H8v2zm9-6h-4v1.9h4c1.71 0 3.1 1.39 3.1 3.1s-1.39 3.1-3.1 3.1h-4V17h4c2.76 0 5-2.24 5-5s-2.24-5-5-5z"/></svg>
    </a>
</td>
<?php /* <td class="span3 url"><a style="text-decoration: none;" onclick="preview_image(<?php echo $fetch_data["file_id"];?>);" id="getcontent" data-toggle="modal" data-target="#edit-price-modal" data-id="<?php echo $fetch_data["file_id"];?>" >Contentshare/<?php echo $fetch_data['file_hash'];?> </a></td> */?>

<?php
  $imgurl = str_replace('contentshare.me', 'shareio.com', $fetch_data['file_thumbnail']); 
  if($fetch_data['file_type'] == 'video/mp4' || $file_data['file_type'] == 'video/webm'){
  ?>
  <td class="file"><a href="edit-file.php?id=<?php echo $fetch_data["file_id"];?>" class="thumb_preview" data-url="<?php echo $fetch_data['file_url'];?>#t=5" data-type="video">
    <?php echo $fetch_data['file_name'];?></a>
  </td>
  <?php }else{ ?>
  <td class="file"><a href="edit-file.php?id=<?php echo $fetch_data["file_id"];?>" class="thumb_preview" data-url="<?php echo $imgurl;?>" data-type="image">
    <?php echo $fetch_data['file_name'];?></a>
  </td>
<?php }?>
                
                <!-- edit-file.php?id=<?php //echo $fetch_data['file_id'];?> -->

<?php /* <td class="span3 admin"><button class="btn btn-primary status">Stats</button><a href="edit-file.php?id=<?php echo $fetch_data['file_id'];?>"><button class="btn btn-primary properties">Properties</button></a><a title="Delete"><button class="btn btn-primary cancel" onclick="deletefile(<?php echo $fetch_data['file_id'];?>)">Cancel</button></a></td> */?>



<td class="file">

<?php 

$view_sql = "SELECT COUNT(log_id) as total from cs_log where fileid = '" . $fetch_data['file_id'] . "'";

    $view_result = mysqli_query($con,$view_sql);

  if (mysqli_num_rows($view_result) > 0) { 

    while($fetch_total = mysqli_fetch_array($view_result)){

      echo $fetch_total['total'];

    }

  } else{

      echo "-";

  }

?>



</td>

<td class="file">

<?php 

$sales_sql = "SELECT SUM(transfer_amount) as total from payments where file_id = '" . $fetch_data['file_id'] . "'";

    $sale_result = mysqli_query($con,$sales_sql);

  if (mysqli_num_rows($sale_result) > 0) { 

    while($sale_result_fetch_total = mysqli_fetch_array($sale_result)){

      echo number_format($sale_result_fetch_total['total']);

    }

  } else{

      echo "-";

  }

?>

</td>



</tr>                         

<?php }

}?>

</tbody>

<script>
  $('input[name="file_ids[]"]').on('click', function(){
      if($('input[name="file_ids[]"]:checked').length > 0){
        $('.delete-selected.files-delete').show();
      } else {
        $('.delete-selected.files-delete').hide();
      }
  });

  $('.delete-selected').on('click', function(){
      var type = $(this).data('type');
      if(type == "File"){
        cuteAlert({
            type: "question",
            title: "Delete",
            message: "Do you wish to delete selected Files?",
            confirmText: "Yes, delete it!",
            cancelText: "Cancel"
        }).then((e)=>{
          if ( e == ("confirm")){
              var ids = [];
              $('input[name="file_ids[]"]:checked').each(function() {
                  ids.push(this.value);
              });
              $.ajax({
                  type: "POST",
                  url: "include/MultipleContentDelete.php",
                  data:{
                      ids:ids
                  },
                  success: function(res){ 
                      if(res.replace(/\s/g, "") == 'error'){
                        cuteAlert({
                          type: "error",
                          title: "Oops...",
                          message: "There is some issue please try again.",
                          buttonText: "Close"
                        })
                      } else {
                        window.location = 'reports.php';
                      }          
                  }
              });
          }
        })
      }
  });
  
  $(document).ready(function() {
      ShowImagePreview();
    });
    // Configuration of the x and y offsets
    function ShowImagePreview() {
    xOffset = -20;
    yOffset = 40;

    $("a.thumb_preview").hover(function(e) {
            var url = $(this).data('url');
            var type = $(this).data('type');
            if(type == 'video'){
              $("body").append("<p id='preview'><video src='"+url+"' style='width:100%;height:100%'></video></p>");
            } else{
              $("body").append("<p id='preview'><img src='"+url+"' alt='Image preview' style='width:100%;height:100%' /></p>");
            }
            

            var left = getLeft(e,$(this));
            var top = getTop(e,$(this));

            $("#preview")
            .css("top", (top) + "px")
            .css("left", (left) + "px")
            .fadeIn("slow");
        },
        function() {
            $("#preview").remove();
    });

    $("a.preview").mousemove(function(e) {

        var left = getLeft(e,$(this));
        var top = getTop(e,$(this));

        $("#preview")
        .css("top", (top) + "px")
        .css("left", (left) + "px");
        });

    };

    function getLeft(e,obj){
        var left = e.pageX + yOffset;
        var prevWidth = $("#preview").width();
        if((left+prevWidth +50) > $(document).width())
        {
            left = $(obj).offset().left - yOffset - prevWidth;
        }
        return left;
    }

    function getTop(e,obj){
        var top = e.pageY - xOffset;
        var prevHeigth = $("#preview").height();
        if((top+prevHeigth +50) > $(document).height())
        {
            top = $(obj).offset().top - xOffset - prevHeigth;
        }
        return top;
    }
</script>