<!DOCTYPE html>
<html>
<?php 
require('./include/db.php');
session_start();
require('head.php');
require('header-new.php'); ?>  
<title>Analytics - ShareIO</title>
<link href="UI-Chart/css/semantic.css" rel="stylesheet" />
<link href="UI-Chart/css/demo.css" rel="stylesheet" />
<link href="https://api.mapbox.com/mapbox-gl-js/v2.4.1/mapbox-gl.css" rel="stylesheet">
<script src="https://api.mapbox.com/mapbox-gl-js/v2.4.1/mapbox-gl.js"></script>
<link rel="stylesheet" href="image/hologram/style.css">
<script src="image/hologram/miniature.earth.core.js"></script>
<script src="image/hologram/miniature.earth.js"></script>
<style>

#back-link {
    position: fixed;
    top: 0;
    left: 0;
    background: #0d130e;
    padding: 0.5em;
    font-size: 26px;
    z-index: 10000;
    border-right: 1px RGBA(255,255,255,0.5) solid;
    border-bottom: 1px RGBA(255,255,255,0.5) solid;
}
#back-link img {
    display: block;
    width: 4em;
    height: auto;
}

@media (max-width: 1199px) {
    #back-link {
        font-size: 20px;
    }
}
@media (max-width: 511px) {
    #back-link {
        font-size: 16px;
    }
}

#legal-footer-wrap {
    position: relative;
    height: 0;
    z-index: 10002;
    font-family: Arial, sans-serif;
}

#legal-footer {
    position: absolute;
    bottom: 0.5em;
    right: 0.5em;
}

#legal-footer a {
    text-decoration: none;
    color: inherit;
    padding: 0 0.5em;
    font-size: 10px;
}


</style>
<?php

$id = $_GET['id'];

$file = "SELECT * FROM `sentfile` where file_id = '".$id."'";
$results = mysqli_query($con,$file);
$filedata = mysqli_fetch_array($results);
$type = $filedata['file_type'];
$fileurl = $filedata['file_url'];
$date1 = $filedata['date_time'];
$date2 = date("Y-m-d");
$min = date("Y-m-d", strtotime($filedata['date_time']));
$ts1 = strtotime($date1);
$ts2 = strtotime($date2);
$year1 = date('Y', $ts1);
$year2 = date('Y', $ts2);
$month1 = date('m', $ts1);
$month2 = date('m', $ts2);
$diff = (($year2 - $year1) * 12) + ($month2 - $month1);
$diff = (int)$diff + 1;

$file_views = array();
$file_sales = array();
$total = array();
$dates = array();

if(isset($_GET['sdate'])){
	$your_date = $day = strtotime($_GET['sdate']);
} else{
	$your_date = $day = strtotime($filedata['date_time']);
}

$now = time(); 
$datediff = $now - $your_date;
$totalDays = round($datediff / (60 * 60 * 24));

if($totalDays > 30){
  $skip = $totalDays - 30;
  $day = strtotime("+".$skip." day", $day);
  $totalDays = 30;
}
$i = 0;
while($i <= $totalDays){
  $date = date('Y-F-d', $day);
  $dates[] = $date;
  $day = strtotime("+1 day", $day);

  //Content total view per day
  $view = "SELECT COUNT(log_id) as views from cs_log WHERE fileid = '".$id."' and DATE_FORMAT( date_time, '%Y-%M-%d' ) = '".$date."'";
  $results = mysqli_query($con,$view);
  while($filedata = mysqli_fetch_array($results)){
    $file_views[] = $filedata['views'];
  }
  
  //Content sale per day
  $sale = "SELECT COUNT(transfer_amount) as amounts from payments WHERE file_id = '".$id."' and DATE_FORMAT( p_date, '%Y-%M-%d' ) = '".$date."'";
  $sale_results = mysqli_query($con,$sale);
  while($sale_resultsdata = mysqli_fetch_array($sale_results)){
      if($sale_resultsdata['amounts'] == ''){
          $file_sales[] = 0;
      } else{
          $file_sales[] = round($sale_resultsdata['amounts']);
      }
  }
  $total[] = $file_views[$i] + $file_sales[$i];
  $i++;
}
?>
<body>
  <main>
      <div class="container new_container">
          <div class="row">
              <div class="col-md-12">
                  <div class="main_content file-stats hidden">
                      <div id="page-content-wrapper">
                          <div class="ui grid">
                              <div class="column">
                                  <div class="ui segment file-stats-bg" id="full-screen">
                                      <div class="top_default_icons chart_info">
                                      		<!-- <button type="button" class="maximize" id="maximize">
                                      			<svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 0 24 24" width="24px" fill="#000000" style="&#10;"><path d="M0 0h24v24H0V0z" fill="none"/><path d="M3 3h18v2H3V3z"/></svg>
                                      		</button> -->
                                          <div class="icons back_arrow pull-right" style="">
                                              <a href="edit-file.php?id=<?php echo $_GET['id'];?>">
                                                 <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 0 24 24" width="24px" fill="#000000"><path d="M0 0h24v24H0V0z" fill="none"></path><path d="M19 6.41L17.59 5 12 10.59 6.41 5 5 6.41 10.59 12 5 17.59 6.41 19 12 13.41 17.59 19 19 17.59 13.41 12 19 6.41z"></path>
                                                 </svg>
                                              </a>
                                          </div>
                                      </div>
                                      <div class="row chart_filter">
                                          <div class="col-lg-3 col-md-6 col-sm-12">
                                            <div class="evpageqty form-group">
                                              <label class="col-form-label">Select Chart</label>
                                              <select class="form-control" name="select-chart" id="select-chart">
                                                <option value="share">Share Statistics</option>
                                                <option value="country">Country Statistics</option>
                                                <option value="city">City Statistics</option>
                                                <option value="device">Device Statistics</option>
                                                <option value="referrer">Referrer Views Statistics</option>
                                                <option value="impression">Impression Statistics</option>
                                                <option value="download">Download Statistics</option>
                                                <?php if($type == 'application/pdf'){?>
                                                  <option value="page">Page Statistics</option>
                                                <?php }?>
                        												<option value="map">Map</option>
                        												<option value="global-map">Global</option>
                                              </select>
                                            </div>
                                          </div>
                                          <div class="col-lg-3 col-md-6 col-sm-12">
                                            <div class="evpageqty filter-date-field form-group">
                                              <label class="col-form-label">Start Date</label>
                                              <input class="form-control" id="sdate" type="date" name="sdate" min="<?php echo $min;?>" max="<?php echo date("Y-m-d");?>">
                                            </div>
                                          </div>
                                          <div class="col-lg-3 col-md-6 col-sm-12">
                                            <div class="evpageqty filter-date-field form-group">
                                              <label class="col-form-label">End Date</label>
                                              <input class="form-control" id="edate" type="date" name="edate" min="<?php echo $min;?>" max="<?php echo date("Y-m-d");?>"></div>
                                          </div>
                                          <div class="col-lg-3 col-md-12 col-sm-12">
                                            <div class="evpageqty filter-date-field filter_view_btn form-group">
                                                <a class="btn" onclick="filter(<?php echo $_GET['id'];?>)">Filter</a>
                                                <!-- <a class="btn map_view" href="viewMaps.php?fileid=<?php echo $_GET['id'];?>">Map View <i class="fa fa-eye" aria-hidden="true"></i></a> -->
                                            </div>
                                          </div>
                                      </div>
                                      <div id="chart">
                                        <div id="barChart1" style="height:600px; margin-bottom: 20px;"></div>
                                      </div>
                                  </div>
                              </div>
                          </div>
                      </div>
                  </div>
              </div> 
          </div>
      </div>
  </main>
  <script src="UI-Chart/js/chartli.js"></script>
  <script>
      $(document).ready(function(){
          $( ".main_content" ).removeClass("hidden");
      });

      function getRandomColor() {
        var letters = '0123456789ABCDEF';
        var color = '#';
        for (var i = 0; i < 6; i++) {
          color += letters[Math.floor(Math.random() * 16)];
        }
        return color;
      } 
  </script>
  <script>
  	var font = '13';
    var topcss = '1%';
    var topcsscity = '15%';
    var itemgapcss = 8;
  	if($(window).width() > 640){
  		font = '18';
      topcss = '1%';
      topcsscity = '1%';
      itemgapcss = 20;
  	}

    var chartliexample0 = echarts.init(document.getElementById('barChart1'));
    var xData = function () {
      var mou = <?php echo json_encode($diff);?>;
      var data = [];
      data = <?php echo json_encode($dates);?>;
      return data;
    }();
    option = {
      backgroundColor: "#273E47",
      // "title": {
      //     "text": "Share Statistics",
      //     x: "1%",
      //     textStyle: {
      //         color: '#fff',
      //         fontSize: font
      //     },
      //     subtextStyle: {
      //         color: '#90979c',
      //         fontSize: '16',
      //     },
      // },
      grid: {
          show: false,
          containLabel: true,
          left: '20',
          right: '20',
          top: '80',
          bottom: '50'
      },
      "tooltip": {
          "trigger": "axis",
          "axisPointer": {
              "type": "shadow",
              textStyle: {
                  color: "#fff"
              }
          },
      },
      "legend": {
          x: 'center',
          top: topcss,
          textStyle: {
              color: '#90979c',
          },
          "data": ['Views', 'Sales', 'Total'],
          itemGap: itemgapcss
      },
      "calculable": true,
      "xAxis": [{
          "type": "category",
          "axisLine": {
              lineStyle: {
                  color: '#90979c'
              }
          },
          "splitLine": {
              "show": false
          },
          "axisTick": {
              "show": false
          },
          "splitArea": {
              "show": false
          },
          "axisLabel": {
              "show": false
          },
          "data": xData,
      }],
      "yAxis": [{
          "type": "value",
          "splitLine": {
              "show": false
          },
          "axisLine": {
              lineStyle: {
                  color: '#90979c'
              }
          },
          "axisTick": {
              "show": false
          },
          "axisLabel": {
              "interval": 0,
          },
          "splitArea": {
              "show": false
          },
      }],
      "dataZoom": [{
          "show": true,
          "height": 30,
          "xAxisIndex": [
            0
          ],
          bottom: 10,
          "start": 10,
          "end": 100,
          handleIcon: 'path://M306.1,413c0,2.2-1.8,4-4,4h-59.8c-2.2,0-4-1.8-4-4V200.8c0-2.2,1.8-4,4-4h59.8c2.2,0,4,1.8,4,4V413z',
          handleSize: '110%',
          handleStyle: {
              color: "#d3dee5",
          },
          textStyle: {
              color: "#fff"
          },
          borderColor: "#90979c"
      }, {
          "type": "inside",
          "show": true,
          "height": 15,
          "start": 1,
          "end": 35
      }],
      "series": [{
          "name": "Views",
          "type": "bar",
          "stack": "Total",
          "barMaxWidth": 35,
          "barGap": "10%",
          "itemStyle": {
              "normal": {
                  "color": "#D8973C",
                  "label": {
                      "show": true,
                      "textStyle": {
                          "color": "#fff"
                      },
                      "position": "insideTop",
                      formatter: function (p) {
                          return p.value > 0 ? (p.value) : '';
                      }
                  }
              }
          },
          "data": <?php echo json_encode($file_views);?>,
      },
      {
          "name": "Sales",
          "type": "bar",
          "stack": "Total",
          "itemStyle": {
              "normal": {
                  "color": "#D8C99B",
                  "barBorderRadius": 0,
                  "label": {
                      "show": true,
                      "position": "top",
                      formatter: function (p) {
                          return p.value > 0 ? (p.value) : '';
                      }
                  }
              }
          },
          "data": <?php echo json_encode($file_sales);?>,
      }, {
          "name": "Total",
          "type": "line",
          "stack": "Total",
          symbolSize: 10,
          symbol: 'circle',
          "itemStyle": {
              "normal": {
                  "color": "rgba(252,230,48,1)",
                  "barBorderRadius": 0,
                  "label": {
                      "show": true,
                      "position": "top",
                      formatter: function (p) {
                          return p.value > 0 ? (p.value) : '';
                      }
                  }
              }
          },
          "data": <?php echo json_encode($total);?>
      },
      ]
    }
    chartliexample0.setOption(option);

    $('#select-chart').on('change', function(){
      var id = <?php echo json_encode($_GET['id']);?>;
      var chart = $(this).val();
      var sdate = $('#sdate').val();
      var edate = $('#edate').val();
	  if(chart == "map" || chart == "global-map"){
	  	$('.filter-date-field').hide();
	  } else{
	  	$('.filter-date-field').show();
	  }
      $.ajax({
        type: "POST",
        url: "filter-file-stats.php?id="+id,
        data:{
          chart:chart,
          sdate:sdate,
          edate:edate
        },
        success: function(res){ 
         $('#chart').replaceWith(res);             
        }
      });
    });

    function filter(id){
        var id = id;
        var chart = $('#select-chart').val();
        var sdate = $('#sdate').val();
        var edate = $('#edate').val();
        $.ajax({
          type: "POST",
          url: "filter-file-stats.php?id="+id,
          data:{
            chart:chart,
            sdate:sdate,
            edate:edate
          },
          success: function(res){ 
           $('#chart').replaceWith(res);              
          }
        });
    }

    $(window).resize(function(){
      $('#select-chart').change();
    });
	
  </script>
<div class="file-stats-footer">
  <?php include('footer-new.php');?>
</div>
</body>
</html>