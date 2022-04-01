
<?php require('./include/db.php');

require('./include/inc/defined_variables.php');

session_start(); ?>




    <div class="report-box">
      <div class="table-responsive">
        <table class="table table-hover mb-0">
          <thead>
            <tr>
              <th class="th-lg"></th>
              <th class="th-lg">Date / Time</th>
              <th class="th-lg"></th>
              <th class="th-lg">Filename</th>
              <th class="th-lg">Views</th>
              <th class="th-lg">Sales</th>
            </tr>
          </thead>
            <tbody>
            <!-- Table head -->
            <?php

            if(isset($_GET["page"])){ $page  = $_GET["page"]; } else{ $page=1; };

            $results_per_page = 10;

            $start_from = ($page-1) * $results_per_page;
            $name = $_GET['search'];

            $sql = "Select * from sentfile where added_by = '" . $_SESSION["user"] . "' and file_name LIKE '%$name%' ORDER BY file_id DESC LIMIT $start_from,$results_per_page";

            $result = mysqli_query($con,$sql);

            if (mysqli_num_rows($result) > 0) { 

            while($fetch_data = mysqli_fetch_array($result)){

            ?>
              <tr class="report-data">
                <td><input type="checkbox" name="file_ids[]" value="<?php echo $fetch_data["file_id"];?>"></td>
                <td class="date"><?php echo date_format(date_create($fetch_data["date_time"]),"H:i:s m/d/Y");?></td>
                <td class="link_icon">
                    <a href="edit-file.php?id=<?php echo $fetch_data["file_id"];?>">
                    <svg xmlns="http://www.w3.org/2000/svg" height="30px" viewBox="0 0 24 24" width="30px" fill="#ffffff"><path d="M0 0h24v24H0z" fill="none"/><path d="M3.9 12c0-1.71 1.39-3.1 3.1-3.1h4V7H7c-2.76 0-5 2.24-5 5s2.24 5 5 5h4v-1.9H7c-1.71 0-3.1-1.39-3.1-3.1zM8 13h8v-2H8v2zm9-6h-4v1.9h4c1.71 0 3.1 1.39 3.1 3.1s-1.39 3.1-3.1 3.1h-4V17h4c2.76 0 5-2.24 5-5s-2.24-5-5-5z"/></svg>
                    </a>
                </td>
                <?php /*<td class="url"><a style="text-decoration: none;" onclick="preview_image(<?php echo $fetch_data["file_id"];?>);" id="getcontent" data-toggle="modal" data-target="#edit-price-modal" data-id="<?php echo $fetch_data["file_id"];?>" >Contentshare/<?php echo $fetch_data['file_hash'];?> </a></td> */?>
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
                <?php /*<td class="admin"><button class="btn btn-primary status">Stats</button><a href="edit-file.php?id=<?php echo $fetch_data['file_id'];?>"><button class="btn btn-primary properties">Properties</button></a><a title="Delete"><button class="btn btn-primary cancel" onclick="deletefile(<?php echo $fetch_data['file_id'];?>)">Cancel</button></a></td> */?>

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

          } else{?>

          <tr class="report-data">
            <td colspan="6">
              <span>No result found..</span>
            </td>
          </tr>

          <?php }?>





          </tbody>
        </table>
      </div><!-- Bottom Table UI -->
    </div>

       

    <div class="row" id="pagination">

      <div class ="col-md-12">
        <?php

        $type = '';

        if(isset($_GET['type'])){

        $type = $_GET['type'];

        }

        $sqlrecords = "Select COUNT(file_id) as total from sentfile where added_by = '" . $_SESSION["user"] . "' and file_name LIKE '%$name%'";

        $resultrecords = $con->query($sqlrecords);

        $rowrecords = $resultrecords->fetch_assoc();

        $total_records = $rowrecords["total"] ;  

        ?>

        <p style="display:none;">1 of 10 showing from <?php echo $total_records; ?> total.</p>

      </div>

      <div class ="col-md-12">
          <a id="upload_files" class="upload_files" href="dashboard.php?s=1">Upload file</a>
          <a class="delete-selected files-delete" data-type="File" style="display: none;">Delete</a>
          <div class="pagination justify-content-end">

            <div class="page-list">

                <?php 

                $start_from = ($page-1) * $results_per_page;    

                $c = '';

                $sql = "Select * from sentfile where added_by = '" . $_SESSION["user"] . "' and file_name LIKE '%$name%'";

                $result = $con->query($sql);

                while ( $row = $result->fetch_assoc()) {

                $c++;

                }

                $total_pages = ceil($row['total'] / $results_per_page);

                if($total_pages > 1 ){ echo '<div class="page-label" >Pages :</div>';  


                if ($page <4){

                  if ($total_pages<9)

                  {

                      for($i = 1; $i <=  $total_pages; $i++)

                      {



                          if ($i == $page)

                          {

                          $sel= "pager selected"; 

                echo "<a class='".$sel."' href='reports.php?search=".$name."&&page=".$i."&&type=".$type."'>".$i."</a>";    

                          } else { 

                          $sel= "pager"; 

                echo "<a class='".$sel."' href='reports.php?search=".$name."&&page=".$i."&&type=".$type."'>".$i."</a>";    

                          }

                      }

                  }

                  else

                  {

                      for($i = 1; $i <=  9; $i++)

                      {



                          if ($i == $page)

                          { 

                            $sel= "pager selected"; 

                echo "<a class='".$sel."' href='reports.php?search=".$name."&&page=".$i."&&type=".$type."'>".$i."</a>";    

                          } else { 

                          $sel= "pager"; 

                echo "<a class='".$sel."' href='reports.php?search=".$name."&&page=".$i."&&type=".$type."'>".$i."</a>";    

                          }

                      }

                  }

                }

                elseif ($page >$total_pages-4)

                {

                  if ($total_pages<9)

                  {

                      for($i = 1; $i <=  $total_pages; $i++){



                          if ($i == $page){ 

                          $sel= "pager selected"; 

                echo "<a class='".$sel."' href='reports.php?search=".$name."&&page=".$i."&&type=".$type."'>".$i."</a>";    

                          } else { 

                          $sel= "pager"; 

                echo "<a class='".$sel."' href='reports.php?search=".$name."&&page=".$i."&&type=".$type."'>".$i."</a>";    

                           }

                      }

                  }else{

                      for($i = $total_pages-8; $i <=  $total_pages; $i++){



                          if ($i == $page){ 

                          $sel= "pager selected"; 

                echo "<a class='".$sel."' href='reports.php?search=".$name."&&page=".$i."&&type=".$type."'>".$i."</a>";    

                           } else { 

                           $sel= "pager"; 

                echo "<a class='".$sel."' href='reports.php?search=".$name."&&page=".$i."&&type=".$type."'>".$i."</a>";    

                            }

                      }

                  }



                }else{

                  for($i = max(1, $page - 4); $i <= min($page + 4, $total_pages); $i++){



                      if ($i == $page){

                        $sel= "pager selected"; 

                echo "<a class='".$sel."' href='reports.php?search=".$name."&&page=".$i."&&type=".$type."'>".$i."</a>";    

                         } else { 

                         $sel= "pager"; 

                echo "<a class='".$sel."' href='reports.php?search=".$name."&&page=".$i."&&type=".$type."'>".$i."</a>";    

                          }

                  }

                }

              }

                ?>
                <a class="refresh" href="#"><img src="images/refresh.png" /></a>
            </div>



          </div>

      </div>

    </div>

      <!-- /row --> 

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

    