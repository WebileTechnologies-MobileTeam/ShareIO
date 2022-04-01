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
                        
                        <th class="th-lg span3"><a>RECORD_ID<i class="fas fa-sort ml-1"></i></a></th>
                        <th class="th-lg span3"><a>USER_ID<i class="fas fa-sort ml-1"></i></a></th>
                        <th class="th-lg span3"><a>Name<i class="fas fa-sort ml-1"></i></a></th>
                        <th class="th-lg span3"><a>LOGIN_AT<i class="fas fa-sort ml-1"></i></a></th>
                        <th class="th-lg span3"><a>LOGOUT_AT<i class="fas fa-sort ml-1"></i></a></th>

                      </tr>
                    </thead>

                    <?php
                    $sql = "SELECT * FROM loginrecord where user_id = '".$_GET['id']."' ";
                        $result = mysqli_query($con,$sql);
                      if (mysqli_num_rows($result) > 0) { 
                    while($row = mysqli_fetch_array($result)){
                      $q="SELECT fname FROM cs_users WHERE id='".$row['user_id']."'";
                      $result1 = mysqli_query($con,$q);
                      $row1 = mysqli_fetch_array($result1);
                      
                      // echo "<pre>";
                      // print_r($fetch_data);
                      
                    ?>
                    <!-- Table head -->

                    <!-- Table body -->
          <div>
                    <tbody class="report-data">
          
                      <tr>
                        <td class="span3 date"><?php echo $row["record_id"];?></td>
                        <td class="span3 date"><?php echo $row["user_id"];?></td>
                        <td class="span3 date"><?php echo $row1["fname"];?></td>
                        <td class="span3 date"><?php echo $row["login_at"];?></td>
                        <?php if($row["logout_at"] == '0000-00-00 00:00:00'){ ?>
                        <td class="span3 date"><i class="fa fa-circle" aria-hidden="true" style="color: green;"></i> Active Now</td>
                      <?php } else{
                        ?>
                        <td class="span3 date"><?php echo $row["logout_at"];?></td>
                        <?php
                      }
                        ?>
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
<script src="js/jquery-1.7.2.min.js"></script> 
<script src="js/excanvas.min.js"></script> 
<script src="js/chart.min.js" type="text/javascript"></script> 
<script src="js/bootstrap.js"></script>
<script language="javascript" type="text/javascript" src="js/full-calendar/fullcalendar.min.js"></script>
 
<script src="js/base.js"></script> 

<script>
  function viewcontent(id){             
        var id = id;
                  
             jQuery.ajax({
          type: "POST",
          url: "view-content.php?id="+id,          
          success: function(html) {
            $("#edit-data").html(html);
            $("#myModal").attr("style" , "display: block");
          }
        });
                
         
      }
      $("#close").click(function() {
        $("#myModal").attr("style" , "display: none");
      });
</script>
<script>
  function carddetail(id){             
        var id = id;
                  
             jQuery.ajax({
          type: "POST",
          url: "carddetail.php?id="+id,          
          success: function(html) {
            $("#edit-data").html(html);
            $("#myModal").attr("style" , "display: block");
          }
        });
                
         
      }
      $("#close").click(function() {
        $("#myModal").attr("style" , "display: none");
      });
</script>
<script>     

        var lineChartData = {
            labels: ["January", "February", "March", "April", "May", "June", "July"],
            datasets: [
				{
				    fillColor: "rgba(220,220,220,0.5)",
				    strokeColor: "rgba(220,220,220,1)",
				    pointColor: "rgba(220,220,220,1)",
				    pointStrokeColor: "#fff",
				    data: [65, 59, 90, 81, 56, 55, 40]
				},
				{
				    fillColor: "rgba(151,187,205,0.5)",
				    strokeColor: "rgba(151,187,205,1)",
				    pointColor: "rgba(151,187,205,1)",
				    pointStrokeColor: "#fff",
				    data: [28, 48, 40, 19, 96, 27, 100]
				}
			]

        }

        var myLine = new Chart(document.getElementById("area-chart").getContext("2d")).Line(lineChartData);


        var barChartData = {
            labels: ["January", "February", "March", "April", "May", "June", "July"],
            datasets: [
				{
				    fillColor: "rgba(220,220,220,0.5)",
				    strokeColor: "rgba(220,220,220,1)",
				    data: [65, 59, 90, 81, 56, 55, 40]
				},
				{
				    fillColor: "rgba(151,187,205,0.5)",
				    strokeColor: "rgba(151,187,205,1)",
				    data: [28, 48, 40, 19, 96, 27, 100]
				}
			]

        }    

        $(document).ready(function() {
        var date = new Date();
        var d = date.getDate();
        var m = date.getMonth();
        var y = date.getFullYear();
        var calendar = $('#calendar').fullCalendar({
          header: {
            left: 'prev,next today',
            center: 'title',
            right: 'month,agendaWeek,agendaDay'
          },
          selectable: true,
          selectHelper: true,
          select: function(start, end, allDay) {
            var title = prompt('Event Title:');
            if (title) {
              calendar.fullCalendar('renderEvent',
                {
                  title: title,
                  start: start,
                  end: end,
                  allDay: allDay
                },
                true // make the event "stick"
              );
            }
            calendar.fullCalendar('unselect');
          },
          editable: true,
          events: [
            {
              title: 'All Day Event',
              start: new Date(y, m, 1)
            },
            {
              title: 'Long Event',
              start: new Date(y, m, d+5),
              end: new Date(y, m, d+7)
            },
            {
              id: 999,
              title: 'Repeating Event',
              start: new Date(y, m, d-3, 16, 0),
              allDay: false
            },
            {
              id: 999,
              title: 'Repeating Event',
              start: new Date(y, m, d+4, 16, 0),
              allDay: false
            },
            {
              title: 'Meeting',
              start: new Date(y, m, d, 10, 30),
              allDay: false
            },
            {
              title: 'Lunch',
              start: new Date(y, m, d, 12, 0),
              end: new Date(y, m, d, 14, 0),
              allDay: false
            },
            {
              title: 'Birthday Party',
              start: new Date(y, m, d+1, 19, 0),
              end: new Date(y, m, d+1, 22, 30),
              allDay: false
            },
            {
              title: 'EGrappler.com',
              start: new Date(y, m, 28),
              end: new Date(y, m, 29),
              url: 'http://EGrappler.com/'
            }
          ]
        });
      });
    </script><!-- /Calendar -->
</body>
</html>
