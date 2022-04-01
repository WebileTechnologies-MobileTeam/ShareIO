<?php 
require('./include/db.php');
session_start();
?>
<style type="text/css">
  .mapboxgl-canvas {
    position: unset;
  }
</style>
<?php

function resolveIP($ip) {
        $string = file_get_contents("http://ipinfo.io/{$ip}?token=385d79682c9165");
        $json = json_decode($string);
        return $json;
}

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
$file_impression = array();
$file_download = array();
$facebook_views = array();
$twitter_sales = array();
$linkedin_views = array();
$google_views = array();
$referrer_total = array();
$country_views = array();
$country_list = array();
$page_count = array();
$page_number = array();
$city_views = array();
$city_list = array();
$device_views = array();
$device_list = array();
$total = array();
$dates = array();

if(isset($_POST['sdate']) && !empty($_POST['sdate'])){
  $your_date = $day = strtotime($_POST['sdate']);
} else{
  $your_date = $day = strtotime($filedata['date_time']);
}

if(isset($_POST['edate']) && !empty($_POST['edate'])){
  $now = strtotime($_POST['edate']);
} else{
  $now = time();
}

$datediff = $now - $your_date;
$totalDays = round($datediff / (60 * 60 * 24));

if($totalDays > 30){
  $skip = $totalDays - 30;
  $day = strtotime("+".$skip." day", $day);
  $totalDays = 30;
}
$i = 0;

if($_POST['chart'] == 'share'){
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
  }?>
  <div id="chart">
    <div id="barChart1" style="height:600px; margin-bottom: 20px;"></div>
  <script>
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
  </script>
  </div>
<?php  
} elseif($_POST['chart'] == 'country'){
  while($i <= $totalDays){
    $date = date('Y-F-d', $day);
    $dates[] = $date;
    $day = strtotime("+1 day", $day);

    $country = "SELECT COUNT(log_id) as views, country from cs_log WHERE fileid = '".$id."' and DATE_FORMAT( date_time, '%Y-%M-%d' ) = '".$date."' and country != '' GROUP BY country";
    $country_results = mysqli_query($con,$country);
    if (mysqli_num_rows($country_results) == 1) {
      $view_arr = array();
      $country_arr = array();
      while($country_filedata = mysqli_fetch_array($country_results)){
        $view_arr[$country_filedata['country']] = $country_filedata['views'];
        $country_arr[] = $country_filedata['country'];
      }
      $country_views[] = $view_arr;
      $country_list[] = $country_arr;
    } else if(mysqli_num_rows($country_results) > 1){
      $view_arr = array();
      $country_arr = array();
      while($country_filedata = mysqli_fetch_array($country_results)){
        $view_arr[$country_filedata['country']] = $country_filedata['views'];
        $country_arr[] = $country_filedata['country'];
      }
      $country_views[] = $view_arr;
      $country_list[] = $country_arr;
    } else{
      $country_views[] = "";
      $country_list[] = "";
    }
    $i++;
  }
  $country_name = array();
  foreach ($country_list as $value) {
    if ($value != '') {
        if(is_array($value)){
            foreach ($value as $values) {
             $country_name[] = $values;
            }
        } else{
            $country_name[] = $value;
        }
    }
  }
  $country_name = array_unique($country_name);
  $country_view_data = array();
  foreach ($country_name as $name) {
    $array = array();
    foreach ($country_views as $key => $value) {
      if(is_array($value)){
        foreach ($value as $arr_key => $arr_value) {
          if ($arr_key == $name){
                $array[] = (int)$arr_value;
            } 
        }
      }else{
        if ($key == $name){
            $array[] = (int)$value;
        } else{
            $array[] = 0;
        }
      }
   }
   //array_shift($array);
   $country_view_data[$name] = $array;
  }
  $sumArray = array();
  foreach ($country_view_data as $k => $subArray) {
    foreach ($subArray as $id => $value) {
      if ( ! isset($sumArray[$id])) {
         $sumArray[$id] = 0;
      }
      $sumArray[$id] += $value;
    }
  }
  ?>
  <div id="chart" >                                   
    <div id="barChart2" style="height:600px; margin-bottom: 20px;"></div>
    <script>
      var series = [];
      var countryname = [];
      var country = <?php echo json_encode($country_name);?>;
      var countryview = <?php echo json_encode($country_view_data);?>;
      var regionName = new Intl.DisplayNames(['en'], {type: 'region'});
      $.each( country, function( key, value ) {
        $.each( countryview, function( arrkey, arrvalue ) {  
         if(arrkey == value){
          series.push({
              "name": regionName.of(value),
              "type": "bar",
              "stack": "Total",
              "barMaxWidth": 35,
              "barGap": "10%",
              "itemStyle": {
                  "normal": {
                      "color": getRandomColor(),
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
              "data": countryview[value],
          });
         }
        });
      });    
      $.each( country, function( key, value ) {
        countryname.push({
          "name": regionName.of(value)
        });
      });
      countryname.push({
        "name": 'Total'
      });
      series.push({
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
        "data": <?php echo json_encode($sumArray);?>
      });
      var chartliexample0 = echarts.init(document.getElementById('barChart2'));
      var xData = function () {
          var mou = <?php echo json_encode($diff);?>;
          var data = [];
          data = <?php echo json_encode($dates);?>;
          return data;
      }();
      option = {
        backgroundColor: "#273E47",
        // "title": {
        //     "text": "Country Statistics",
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
            "data": countryname,
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
        "series": series
      }
      chartliexample0.setOption(option);
    </script>
  </div>
<?php  
} elseif($_POST['chart'] == 'city'){
  while($i <= $totalDays){
    $date = date('Y-F-d', $day);
    $dates[] = $date;
    $day = strtotime("+1 day", $day);

    //Content view according to city
       $city = "SELECT ip from cs_log WHERE fileid = '".$id."' and DATE_FORMAT( date_time, '%Y-%M-%d' ) = '".$date."'";
       $city_results = mysqli_query($con,$city);
       if (mysqli_num_rows($city_results) > 1) {
        $view_arr = array();
        while($city_filedata = mysqli_fetch_array($city_results)){
          $ip = $city_filedata['ip']; 
          $query = resolveIP($ip);
          if(!in_array($query->city, $city_list)){
              $city_list[] = $query->city;
          }
          $view_arr[$query->city] = $view_arr[$query->city] + 1;
        }
        $city_views[] = $view_arr;
        } else{
          $city_views[] = "";
        }
    $i++;
  }
  $city_view_data = array();
  foreach ($city_list as $name) {
    $array = array();
    foreach ($city_views as $key => $value) {
      if(is_array($value)){
        foreach ($value as $arr_key => $arr_value) {
          if ($arr_key == $name){
                $array[] = (int)$arr_value;
            } 
        }
      }else{
        if ($key == $name){
            $array[] = (int)$value;
        } else{
            $array[] = 0;
        }
      }
   }
   //array_shift($array);
   $city_view_data[$name] = $array;
  }

  $sumArray_city = array();
  foreach ($city_view_data as $k => $subArray) {
    foreach ($subArray as $id => $value) {
      if ( ! isset($sumArray_city[$id])) {
         $sumArray_city[$id] = 0;
      }
      $sumArray_city[$id] += $value;
    }
  }
?>
<div id="chart" >                                   
  <div class="city_statics">
    <div class="row">
      <div class="col-lg-3 col-md-3 col-sm-4 col-12 ml-auto">
        <div class="evpageqty form-group">
          <select name="city" id="city" class="form-control">
            <?php foreach ($city_list as $value) { ?>
              <option value="<?php echo $value;?>"><?php echo $value;?></option>
            <?php } ?>
          </select>
        </div>
      </div> 
    </div>
    <div id="barChart7" style="height:600px; margin-bottom: 20px;"></div>
  </div>
  <script>
   $(document).on('change', '#city', function(){
    var seriescity = [];
    var city = [];
    city = [$('#city').val()];
    var cityview = <?php echo json_encode($city_view_data);?>;
    $.each( city, function( key, value ) {
      $.each( cityview, function( arrkey, arrvalue ) {  
       if(arrkey == value){
        seriescity.push({
            "name": value,
            "type": "bar",
            "stack": "Total",
            "barMaxWidth": 35,
            "barGap": "10%",
            "itemStyle": {
                "normal": {
                    "color": getRandomColor(),
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
            "data": cityview[value],
        });
       }
      });
    });    
    var chartliexample0 = echarts.init(document.getElementById('barChart7'));
    var xData = function () {
        var mou = <?php echo json_encode($diff);?>;
        var data = [];
        data = <?php echo json_encode($dates);?>;
        return data;
    }();
    option = {
        backgroundColor: "#273E47",
        // "title": {
        //     "text": "City Statistics",
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
            top: topcsscity,
            textStyle: {
                color: '#90979c',
            },
            "data": city,
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
        "series": seriescity
      }
      chartliexample0.setOption(option);
    }).change();
    $('#city').change();
  </script>
</div>
<?php
} elseif($_POST['chart'] == 'device'){
  while($i <= $totalDays){
    $date = date('Y-F-d', $day);
    $dates[] = $date;
    $day = strtotime("+1 day", $day);

    //Content view according to device
    $device = "SELECT COUNT(log_id) as views, device from cs_log WHERE fileid = '".$id."' and DATE_FORMAT( date_time, '%Y-%M-%d' ) = '".$date."' and device != '' GROUP BY device";
    $device_results = mysqli_query($con,$device);
    if (mysqli_num_rows($device_results) == 1) {
      $view_arr = array();
      $device_arr = array();
      while($device_filedata = mysqli_fetch_array($device_results)){
        $view_arr[$device_filedata['device']] = $device_filedata['views'];
        $device_arr[] = $device_filedata['device'];
      }
      $device_views[] = $view_arr;
      $device_list[] = $device_arr;
    } else if(mysqli_num_rows($device_results) > 1){
      $view_arr = array();
      $device_arr = array();
      while($device_filedata = mysqli_fetch_array($device_results)){
        $view_arr[$device_filedata['device']] = $device_filedata['views'];
        $device_arr[] = $device_filedata['device'];
      }
      $device_views[] = $view_arr;
      $device_list[] = $device_arr;
    } else{
      $device_views[] = "";
      $device_list[] = "";
    }
    $i++;
  }

  $device_name = array();
  foreach ($device_list as $value) {
    if ($value != '') {
      if(is_array($value)){
        foreach ($value as $values) {
         $device_name[] = $values;
        }
      } else{
        $device_name[] = $value;
      }
    }
  }

  $device_view_data = array();
  foreach ($device_name as $name) {
    $array = array();
    foreach ($device_views as $key => $value) {
      if(is_array($value)){
        foreach ($value as $arr_key => $arr_value) {
          if ($arr_key == $name){
                $array[] = (int)$arr_value;
            } 
        }
      }else{
        if ($key == $name){
            $array[] = (int)$value;
        } else{
            $array[] = 0;
        }
      }
   }
   //array_shift($array);
   $device_view_data[$name] = $array;
  }

  $device_sumArray = array();
  foreach ($device_view_data as $k => $subArray) {
    foreach ($subArray as $id => $value) {
      if ( ! isset($device_sumArray[$id])) {
         $device_sumArray[$id] = 0;
      }
      $device_sumArray[$id] += $value;
    }
  }
  $device_name = array_unique($device_name);
  ?>
  <div id="chart">
    <div id="barChart3" style="height:600px; margin-bottom: 20px;"></div>
    <script>
      var seriesdevice = [];
      var devicename = [];
      var device = <?php echo json_encode($device_name);?>;
      var deviceview = <?php echo json_encode($device_view_data);?>;
      var regionNames = new Intl.DisplayNames(['en'], {type: 'region'});
      $.each( device, function( key, value ) {
        $.each( deviceview, function( arrkey, arrvalue ) {  
         if(arrkey == value){
          seriesdevice.push({
              "name": value,
              "type": "bar",
              "stack": "Total",
              "barMaxWidth": 35,
              "barGap": "10%",
              "itemStyle": {
                  "normal": {
                      "color": getRandomColor(),
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
              "data": deviceview[value],
          });
         }
        });
      });    
      $.each( device, function( key, value ) {
          devicename.push({
              "name": value
          });
      });
      devicename.push({
          "name": 'Total'
      });
      seriesdevice.push({
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
              "data": <?php echo json_encode($device_sumArray);?>
          });
      var chartliexample0 = echarts.init(document.getElementById('barChart3'));
      var xData = function () {
          var mou = <?php echo json_encode($diff);?>;
          var data = [];
          data = <?php echo json_encode($dates);?>;
          return data;
      }();
      option = {
          backgroundColor: "#273E47",
          // "title": {
          //     "text": "Device Statistics",
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
              "data": devicename,
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
          "series": seriesdevice
      }
      chartliexample0.setOption(option);
    </script>
  </div>
<?php
} elseif($_POST['chart'] == 'referrer'){
  while($i <= $totalDays){
    $date = date('Y-F-d', $day);
    $dates[] = $date;
    $day = strtotime("+1 day", $day);

    //Content Referer views over time
    $facebook = "SELECT COUNT(log_id) as views from cs_log WHERE fileid = '".$id."' and referrer LIKE '%facebook%' and DATE_FORMAT( date_time, '%Y-%M-%d' ) = '".$date."'";
    $facebook_results = mysqli_query($con,$facebook);
    while($facebook_resultsdata = mysqli_fetch_array($facebook_results)){
      if($facebook_resultsdata['views'] == ''){
        $facebook_views[] = 0;
      } else{
        $facebook_views[] = $facebook_resultsdata['views'];
      }
    }

    $twitter = "SELECT COUNT(log_id) as views from cs_log WHERE fileid = '".$id."' and referrer LIKE '%t.co%' and DATE_FORMAT( date_time, '%Y-%M-%d' ) = '".$date."'";
    $twitter_results = mysqli_query($con,$twitter);
    while($twitter_resultsdata = mysqli_fetch_array($twitter_results)){
      if($twitter_resultsdata['views'] == ''){
        $twitter_views[] = 0;
      } else{
        $twitter_views[] = $twitter_resultsdata['views'];
      }
    }

    $linkedin = "SELECT COUNT(log_id) as views from cs_log WHERE fileid = '".$id."' and referrer LIKE '%lnkd%' and DATE_FORMAT( date_time, '%Y-%M-%d' ) = '".$date."'";
    $linkedin_results = mysqli_query($con,$linkedin);
    while($linkedin_resultsdata = mysqli_fetch_array($linkedin_results)){
      if($linkedin_resultsdata['views'] == ''){
        $linkedin_views[] = 0;
      } else{
        $linkedin_views[] = $linkedin_resultsdata['views'];
      }
    }
    $google = "SELECT COUNT(log_id) as views from cs_log WHERE fileid = '".$id."' and referrer LIKE '%google%' and DATE_FORMAT( date_time, '%Y-%M-%d' ) = '".$date."'";
    $google_results = mysqli_query($con,$google);
    while($google_resultsdata = mysqli_fetch_array($google_results)){
      if($google_resultsdata['views'] == ''){
        $google_views[] = 0;
      } else{
        $google_views[] = $google_resultsdata['views'];
      }
    }
    $referrer_total[] = $facebook_views[$i] + $twitter_views[$i] + $linkedin_views[$i] + $google_views[$i];

    $i++;
  }?>
  <div id="chart">
    <div id="barChart4" style="height:600px; margin-bottom: 20px;"></div>
    <script>
      var chartliexample0 = echarts.init(document.getElementById('barChart4'));
      var xData = function () {
          var mou = <?php echo json_encode($diff);?>;
          var data = [];
          data = <?php echo json_encode($dates);?>;
          return data;
      }();
      option = {
          backgroundColor: "#273E47",
          // "title": {
          //     "text": "Referrer Views Statistics",
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
              "data": ['Facebook', 'Twitter', 'Linked In', 'Google', 'Total'],
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
              "name": "Facebook",
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
              "data": <?php echo json_encode($facebook_views);?>,
          },
          {
              "name": "Twitter",
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
              "data": <?php echo json_encode($twitter_views);?>,
          }, {
              "name": "Linked In",
              "type": "bar",
              "stack": "Total",
              "itemStyle": {
                  "normal": {
                      "color": "#483b04",
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
              "data": <?php echo json_encode($linkedin_views);?>,
          }, {
              "name": "Google",
              "type": "bar",
              "stack": "Total",
              "itemStyle": {
                  "normal": {
                      "color": "#483b54",
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
              "data": <?php echo json_encode($google_views);?>,
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
              "data": <?php echo json_encode($referrer_total);?>
          },
          ]
      }
      chartliexample0.setOption(option);
    </script>
  </div>
<?php
} elseif($_POST['chart'] == 'impression'){
  while($i <= $totalDays){
    $date = date('Y-F-d', $day);
    $dates[] = $date;
    $day = strtotime("+1 day", $day);

    //Content impression view over time
    $impression = "SELECT COUNT(imp_id) as imp from file_impression WHERE file_id = '".$id."' and DATE_FORMAT( imp_date, '%Y-%M-%d' ) = '".$date."'";
    $impression_results = mysqli_query($con,$impression);
    while($impressiondata = mysqli_fetch_array($impression_results)){
      $file_impression[] = $impressiondata['imp'];
    }
    $i++;
  }?>
  <div id="chart">
    <div id="barChart5" style="height:600px; margin-bottom: 20px;"></div>
    <script>
      var chartliexample0 = echarts.init(document.getElementById('barChart5'));
      var xData = function () {
          var mou = <?php echo json_encode($diff);?>;
          var data = [];
          data = <?php echo json_encode($dates);?>;
          return data;
      }();
      option = {
          backgroundColor: "#273E47",
          // "title": {
          //     "text": "Impression Statistics",
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
              "data": ['Impression'],
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
              "name": "Impression",
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
              "data": <?php echo json_encode($file_impression);?>,
          }
          ]
      }
      chartliexample0.setOption(option);
    </script>
  </div>
<?php
} elseif($_POST['chart'] == 'download'){
  while($i <= $totalDays){
    $date = date('Y-F-d', $day);
    $dates[] = $date;
    $day = strtotime("+1 day", $day);

    //Content Download over time
    $download = "SELECT COUNT(download) as download from file_download WHERE file_id = '".$id."' and DATE_FORMAT( download_date, '%Y-%M-%d' ) = '".$date."'";
    $download_results = mysqli_query($con,$download);
    while($downloaddata = mysqli_fetch_array($download_results)){
      $file_download[] = $downloaddata['download'];
    }
    $i++;
  }?>
  <div id="chart">
    <div id="barChart6" style="height:600px; margin-bottom: 20px;"></div>
    <script>
      var chartliexample0 = echarts.init(document.getElementById('barChart6'));
      var xData = function () {
          var mou = <?php echo json_encode($diff);?>;
          var data = [];
          data = <?php echo json_encode($dates);?>;
          return data;
      }();
      option = {
          backgroundColor: "#273E47",
          // "title": {
          //     "text": "Download Statistics",
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
              "data": ['Download'],
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
              "name": "Download",
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
              "data": <?php echo json_encode($file_download);?>,
          }
          ]
      }
      chartliexample0.setOption(option);
    </script>
  </div>
<?php  
} elseif($_POST['chart'] == 'page'){
  while($i <= $totalDays){
    $date = date('Y-F-d', $day);
    $dates[] = $date;
    $day = strtotime("+1 day", $day);

    //Content view according to page count
    $file_stats = "SELECT page_number, page_time from document_stats WHERE fileid = '".$id."' and DATE_FORMAT( date_time, '%Y-%M-%d' ) = '".$date."' ORDER BY page_number";
    $file_stats_results = mysqli_query($con,$file_stats);
    if (mysqli_num_rows($file_stats_results) > 0) {
      $count = array();
      $number = array();
      while($file_stats_filedata = mysqli_fetch_array($file_stats_results)){
          $count['Page-'.$file_stats_filedata['page_number']] = $file_stats_filedata['page_time'];
          $number[] = 'Page-'.$file_stats_filedata['page_number'];
      }
      $page_number[] = $number;
      $page_count[] = $count;
    } else{
      $page_count[] = "";
    }
    $i++;
  }
  $page_list = array();
  foreach ($page_number as $value) {
      if ($value != '') {
          if(is_array($value)){
              foreach ($value as $values) {
               $page_list[] = $values;
              }
          } else{
              $page_list[] = $value;
          }
      }
  }
  $page_list = array_unique($page_list);

  $page_view_data = array();
  foreach ($page_list as $number) {
      $array = array();
      foreach ($page_count as $key => $value) {
          if(is_array($value)){
              foreach ($value as $arr_key => $arr_value) {
                if ($arr_key == $number){
                      $array[] = (int)$arr_value;
                  } 
              }
          }else{
              if ($key == $name){
                  $array[] = (int)$value;
              } else{
                  $array[] = 0;
              }
          }
     }
     //array_shift($array);
     $page_view_data[$number] = $array;
  }

  $sumArray_pageCount = array();
  foreach ($page_view_data as $k => $subArray) {
    foreach ($subArray as $id => $value) {
      if ( ! isset($sumArray[$id])) {
         $sumArray[$id] = 0;
      }
      $sumArray_pageCount[$id] += $value;
    }
  }
  ?>
  <div id="chart">
    <div id="barChart8" style="height:600px; margin-bottom: 20px;"></div>
    <script>
      var series = [];
      var page = [];
      var pagenumber = <?php echo json_encode($page_list);?>;
      var pagedata = <?php echo json_encode($page_view_data);?>;
      $.each( pagenumber, function( key, value ) {
        $.each( pagedata, function( arrkey, arrvalue ) {  
         if(arrkey == value){
          series.push({
              "name": value,
              "type": "bar",
              "stack": "Total",
              "barMaxWidth": 35,
              "barGap": "10%",
              "itemStyle": {
                  "normal": {
                      "color": getRandomColor(),
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
              "data": pagedata[value],
          });
         }
        });
      });    
      $.each( pagenumber, function( key, value ) {
          page.push({
              "name": value
          });
      });
      page.push({
          "name": 'Total'
      });
      series.push({
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
              "data": <?php echo json_encode($sumArray_pageCount);?>
          });
      console.log(series);
      var chartliexample0 = echarts.init(document.getElementById('barChart8'));
      var xData = function () {
          var mou = <?php echo json_encode($diff);?>;
          var data = [];
          data = <?php echo json_encode($dates);?>;
          return data;
      }();
      option = {
          backgroundColor: "#273E47",
          // "title": {
          //     "text": "Page Statistics",
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
              "data": page,
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
          "series": series
      }
      chartliexample0.setOption(option);
    </script>
  </div>
<?php
} elseif($_POST['chart'] == 'map'){
	$users_data = array();
	$org = mysqli_query($con,"SELECT DISTINCT ip, lattitude , longitude , user_name, fileid FROM `cs_log` where fileid = '".$id."'");
	while($users_da = mysqli_fetch_array($org)){
	    if($users_da['lattitude'] != ''){
	        $data['lat'] = $users_da['lattitude'];
	        $data['lng'] = $users_da['longitude'];
	        $users_data[] = $data;
	    }
	} ?>
	<div id="chart">
		<div id="map-canvas" class="map_canvas"></div>
		<script>

			mapboxgl.accessToken = 'pk.eyJ1Ijoic2FmYWoiLCJhIjoiY2t0YmIyYzRyMXU0bzJ1bGFycXh5cDh2diJ9.H2iYCWsVGzdln5M8LZobKw';
		    var map = new mapboxgl.Map({
		        container: 'map-canvas', 
		        style: 'mapbox://styles/safaj/cktbb9jbp642i17ofrvr37600', 
		        center: [-0.20248249999999998, 51.4754218], 
		        zoom: 1 
		    });

		    var markers = <?php echo json_encode($users_data);?>;
		    $.each( markers, function( key, value ) {
		      var marker = new mapboxgl.Marker()
		        .setLngLat([value['lng'], value['lat']])
		        .addTo(map);
		    });
		</script>
	</div>
<?php
} elseif($_POST['chart'] == 'global-map'){
	
	$users_data = array();
	$org = mysqli_query($con,"SELECT DISTINCT ip, lattitude , longitude FROM `cs_log` where fileid = '".$id."' AND lattitude != ''");
	while($users_da = mysqli_fetch_array($org)){
	    if($users_da['lattitude'] != ''){
	        $data['lat'] = $users_da['lattitude'];
	        $data['lng'] = $users_da['longitude'];
	        $users_data[] = array(
	            "location" => $data);
	    }
	}?>
	<div id="chart" style="background:#0e120f;">
		<div id="myearth" class="myearth">
	        <div id="glow"></div>
	    </div>
		<script>
			if ( location.protocol == 'file:' ) {
			    alert( 'This demo does not work with the file protocol due to browser security restrictions.' );
			}


			var myearth;
			var sprites = [];

			//window.addEventListener( 'load', function() {

			    myearth = new Earth( 'myearth', {
			    
			        location : { lat: 20, lng : 20 },
			    
			        light: 'none',

			        mapImage: 'image/hologram/hologram-map.svg',
			        transparent: true,
			        
			        autoRotate : true,
			        autoRotateSpeed: 1.2,
			        autoRotateDelay: 100,
			        autoRotateStart: 2000,          
			        
			    } );
			    
			    var photos = <?php echo json_encode($users_data);?>;
			    myearth.addEventListener( "ready", function() {

			        this.startAutoRotate();

			        for ( var i=0; i < photos.length; i++ ) {
			        
			            var marker = this.addMarker( {
			            
			                mesh : "Marker",
			                color: (i % 2 == 0) ? '#afcde5' : '#afcde5',
			                location : photos[i].location,
			                scale: 0.01,
			                offset: 1.6,
			                visible: false,
			                transparent: true,
			                hotspot: true,
			                hotspotRadius : 0.75,
			                hotspotHeight : 0.3,
			                
			                // custom property
			                photo_info: photos[i]
			                
			            } );
			            
			            //marker.addEventListener('click', openPhoto);
			            
			            // animate marker
			            setTimeout( (function() {
			                this.visible = true;
			                this.animate( 'scale', 0.2, { duration: 140 } );
			                this.animate( 'offset', 0, { duration: 1100, easing: 'bounce' } );
			            }).bind(marker), 280 );
			            
			        }
			        
			        
			    } );
			    
			    
			//} );


			function getRandomInt(min, max) {
			    min = Math.ceil(min);
			    max = Math.floor(max);
			    return Math.floor(Math.random() * (max - min)) + min;
			}


			function pulse( index ) {
			    var random_location = connections[ getRandomInt(0, connections.length-1) ];
			    sprites[index].location = { lat: random_location[0] , lng: random_location[1] };
			    
			    sprites[index].animate( 'scale', 0.5, { duration: 320, complete : function(){
			        this.animate( 'scale', 0.01, { duration: 320, complete : function(){
			            setTimeout( function(){ pulse( index ); }, getRandomInt(100, 400) );
			        } });
			    } });
			}
		</script>
	</div>
<?php
}
?>