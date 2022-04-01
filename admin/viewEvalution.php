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
  td.action a {
    font-size: 18px;
    cursor: pointer;
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
      <?php
      if (isset($_SESSION['message'])){ ?>  
              <div class="alert alert-success fade in">
                    <a href="#" class="close" data-dismiss="alert">&times;</a>
                    <strong><?php echo $_SESSION['message']; ?></strong> 
                </div>
              <?php 
               unset($_SESSION['message']);
               } ?>
        <div id="edit-evalution-modal" class="modal fade setting-model" role="dialog">
            <div class="modal-dialog">

              <!-- Modal content-->
              <div class="modal-content">
                <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal">×</button>
                  <!--<h4 class="modal-title">Add</h4>-->
                </div>
                <div class="modal-body">
                  <div class="container-fluid" id="evalutionform">
                    <script>
                      jQuery(document).ready(function($) {
                          $(".edit-evalution").on('click',function() {
                            var id = $(this).attr('data-id');
                              $.ajax({
                                  type: "POST",
                                  data:{
                                    id:id
                                  },
                                  url: "edit-evalution-info.php",
                                  success: function(html){ 
                                    $("#evalutionform").html(html);
                                  }
                                });
                            });
                          });
                    </script> 
                  </div>
                </div>
              </div>
            </div>
          </div>


          <div id="add-evalution-modal" class="modal fade setting-model" role="dialog">
            <div class="modal-dialog">

              <!-- Modal content-->
              <div class="modal-content">
                <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal">×</button>
                  <!--<h4 class="modal-title">Add</h4>-->
                </div>
                <div class="modal-body">
                  <div class="container-fluid" id="addevalutionform">
                    <form method="post" action="include/addevalutiondata.php">
                      <div class="form-group">
                        <label>Evalution Name</label>
                        <input type="text" name="evaluation_name" class="form-control" id="evaluation_name">
                      </div>                            
                      <div class="form-group button-box" style="text-align: center;">
                        <input class="btn btn-primary" type="submit" name="submit">
                      </div>
                    </form>
                  </div>
                </div>
              </div>
            </div>
          </div>

     <div class="row" style="margin: 15px;">
      <a class="btn" title="Add New" data-toggle="modal" data-target="#add-evalution-modal" id="add-evalution" style="float: right;">Add New</a>
       
     </div>
     <div class="row">
    <div class="span12">

          <div class="report-box">
                <div class="table-responsive">

                  <!--Table-->
                  <table class="table table-hover mb-0">

                    <!-- Table head -->
                    <thead>
                      <tr>
                        
                        <th class="th-lg span3"><a>ID</a></th>
                        <th class="th-lg span3"><a>Name</a></th>
                        <th class="th-lg span3"><a>Action</a></th>

                      </tr>
                    </thead>
          
                    <tbody class="report-data">
                      <?php
                    $sql = "SELECT * FROM `tbl_evaluation` ORDER BY evaluation_id DESC";
                        $result = mysqli_query($con,$sql);
                      if (mysqli_num_rows($result) > 0) { 
                    while($row = mysqli_fetch_array($result)){ ?>
          
                      <tr>
                        <td class="span3 date"><?php echo $row["evaluation_id"];?></td>
                        <td class="span3 date"><?php echo $row["evaluation_name"];?></td>
                        <td class="span3 date action"><a title="Edit" class="edit-evalution-modal edit-evalution" style="padding: 10px;" data-toggle="modal" data-target="#edit-evalution-modal" data-id="<?php echo $row["evaluation_id"];?>" id="<?php echo $row["evaluation_id"];?>"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>
                          <a title="Delete" onclick="deletefile(<?php echo $row["evaluation_id"];?>)"><i class="fa fa-trash" aria-hidden="true"></i></a>
                        </td>
                      </tr>
            
                <?php }
                  }?>

                    </tbody>
                  </table>
                </div>
             </div>
               
         </div>
       
      </div> 


      <!-- /row --> 
    </div>
    <!-- /container --> 
  </div>
  <!-- /main-inner --> 
</div>

 
<script>
                    function deletefile(id){
                      var id = id;
                      if (confirm("Are you sure want to delete Evaluation ?")) {
                        $.ajax({
                          type: "POST",
                          url: "include/delete-evalution.php?id="+id,
                          success: function(res){       
                          location.reload();                             
                          }
                        });
                      }
                      return false;
                    }
</script>

</body>
</html>

<?php include('footer.php'); ?>