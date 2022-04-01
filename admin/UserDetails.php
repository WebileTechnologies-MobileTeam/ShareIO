<!DOCTYPE html>
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
                        
                        <th class="th-lg span3"><a>USER_ID<i class="fas fa-sort ml-1"></i></a></th>
                        <th class="th-lg span3"><a>Name<i class="fas fa-sort ml-1"></i></a></th>
                        <th class="th-lg span3"><a>Email<i class="fas fa-sort ml-1"></i></a></th>
                        <th class="th-lg span3"><a>Log Record<i class="fas fa-sort ml-1"></i></a></th>

                      </tr>
                    </thead>

                    <?php
                    $sql = "SELECT * FROM cs_users";
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
                        <td class="span3 date"><?php echo $row["id"];?></td>
                        <td class="span3 date"><?php echo $row["fname"];?></td>
                        <td class="span3 date"><?php echo $row["email"];?></td>
                        <td class="span3 date"><a href="logrecord.php?id=<?php echo $row["id"];?>"><button>View</button></a></td>
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
</body>
</html>
<?php include('footer.php'); ?>
