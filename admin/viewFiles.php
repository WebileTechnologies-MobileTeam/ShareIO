<!DOCTYPE html>
<style>
  .switch {
    position: relative;
    display: inline-block;
    width: 60px;
    height: 34px;
  }

  .switch input { 
    opacity: 0;
    width: 0;
    height: 0;
  }

  .slider {
    position: absolute;
    cursor: pointer;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background-color: #ccc;
    -webkit-transition: .4s;
    transition: .4s;
  }

  .slider:before {
    position: absolute;
    content: "";
    height: 26px;
    width: 26px;
    left: 4px;
    bottom: 4px;
    background-color: white;
    -webkit-transition: .4s;
    transition: .4s;
  }

  input:checked + .slider {
    background-color: #2196F3;
  }

  input:focus + .slider {
    box-shadow: 0 0 1px #2196F3;
  }

  input:checked + .slider:before {
    -webkit-transform: translateX(26px);
    -ms-transform: translateX(26px);
    transform: translateX(26px) !important;
  }

  /* Rounded sliders */
  .slider.round {
    border-radius: 34px;
  }

  .slider.round:before {
    border-radius: 50%;
  }
  td.last-action {
    display: flex;
  }
  td.last-action label.switch {
    margin-bottom: 0 !important;
  }
  td.last-action a.edit-icon-customer {
    margin: auto;
  }

</style>
<html lang="en">
<?php require('../include/db.php');
require('../include/inc/defined_variables.php');
session_start(); ?>
<?php require('head.php'); 
?>
<body>

<!-- /navbar -->

<div class="main">
  <div class="main-inner">
    <div class="container">

     <div class="row">
    <div class="span12">

          <div class="report-box">
                <div class="table-responsive">

                  <!--Table-->
                  <table class="table table-hover mb-0">

                    <!-- Table head -->
                    <thead>
                      <tr>
                        
                        <th class="th-lg span3"><a>FILE_ID</a></th>
                        <th class="th-lg span3"><a>User</a></th>
                        <th class="th-lg span3"><a>File Name</a></th>
                        <th class="th-lg span3"><a>File URl</a></th>
                        <th class="th-lg span3"><a>Browser</a></th>

                      </tr>
                    </thead>

                    <?php
                    $sql = "SELECT * FROM sentfile
                    INNER JOIN cs_users on cs_users.id = sentfile.added_by ORDER BY file_id DESC";
                        $result = mysqli_query($con,$sql);
                      if (mysqli_num_rows($result) > 0) { 
                    while($row = mysqli_fetch_array($result)){
                      
                      // echo "<pre>";
                      // print_r($fetch_data);
                      
                    ?>
                    <!-- Table head -->

                    <!-- Table body -->
          <div>
                    <tbody class="report-data">
          
                      <tr>
                        <td class="span3 date"><?php echo $row["file_id"];?></td>
                        <td class="span3 date"><?php echo $row["fname"];?></td>
                        <td class="span3 date"><?php echo $row["file_name"];?></td>
                        <td class="span3 date"><a href="http://3.135.223.154/file/<?php echo $row["file_hash"];?>">http://3.135.223.154/file/<?php echo $row["file_hash"];?></td>
                        <td class="span3 date">
                          <label class="switch">
                              <input type="checkbox" id="<?php echo $row['file_id']; ?>" onchange="<?php if($row['browser_enabled']=='1'){ ?>pending(<?php echo $row['file_id']; ?>);<?php } else{?>active(<?php echo $row['file_id']; ?>); <?php } ?>" <?php if($row['browser_enabled']=='1'){ echo 'checked'; } ?> value="<?php if($row['browser_enabled']=='1'){ echo 'enable'; }else{ echo 'pending'; } ?>">
                              <span class="slider round"></span>
                        </label>
                        </td>
                      </tr>
            
           <?php }
                  }?>

                    </tbody>
          </div>
                    <!-- Table body -->

                  </table>
                  <!-- Table -->

                </div><!-- Bottom Table UI -->
                
                <!-- Bottom Table UI -->

             </div>
               
         </div>
       
      </div> 

<!-- Modal -->


<!-- Modal content -->








      
      <!-- /row --> 
    </div>
    <!-- /container --> 
  </div>
  <!-- /main-inner --> 
</div>
<!-- /main -->

<div class="footer">
  <div class="footer-inner">
    <div class="container">
      <div class="row">
        <div class="span12"> &copy; 2020 <a href="#">ContentShare</a>. </div>
        <!-- /span12 --> 
      </div>
      <!-- /row --> 
    </div>
    <!-- /container --> 
  </div>
  <!-- /footer-inner --> 
</div>
<!-- /footer --> 
<!-- Le javascript
================================================== --> 
<!-- Placed at the end of the document so the pages load faster --> 

<script>
  

      function active(file_id){  
              //alert(driver_id);
                jQuery.ajax({
                    type: "POST",
                    url: "filestatusupdate.php",
                    data: {
                      file_id: file_id,
                      action:'Active'
                    },
                    success: function(html) {
                      location.reload(true);
                    }
                  });
              }
              function pending(file_id){
                //alert(driver_id); 
                jQuery.ajax({
                    type: "POST",
                    url: "filestatusupdate.php",
                    data: {
                      file_id: file_id,
                      action:'Deactive'
                    },
                    success: function(html) {
                      location.reload(true);
                    }
                  });
              }
</script>

</body>
</html>

<?php include('footer.php'); ?>