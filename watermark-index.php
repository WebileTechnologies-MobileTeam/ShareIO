<?php 

require('./include/db.php');

session_start();

?>



<link href="UI-Chart/css/semantic.css" rel="stylesheet" />

<link href="UI-Chart/css/demo.css" rel="stylesheet" />



<?php

$id = $_GET['id'];

$file = "SELECT * FROM `sentfile` where file_id = '".$id."'";

$results = mysqli_query($con,$file);

$filedata = mysqli_fetch_array($results);

$type = $filedata['file_type'];

$fileurl = $filedata['file_url'];



$date1 = $filedata['date_time'];

$date2 = date("Y-m-d");



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



$start = $day = strtotime($_POST['sdate']);

$end = strtotime($_POST['edate']);

$your_date = strtotime($_POST['sdate']); // or your date as well

$now = strtotime($_POST['edate']);

$datediff = $now - $your_date;



$totalDays = round($datediff / (60 * 60 * 24));



$i = 0;



while($i <= $totalDays)

{

   

   $date = date('Y-F-d', $day);

   $dates[] = $date;

   $day = strtotime("+1 day", $day);



   $view = "SELECT COUNT(log_id) as views from cs_log WHERE fileid = '".$id."' and DATE_FORMAT( date_time, '%Y-%M-%d' ) = '".$date."'";

   $results = mysqli_query($con,$view);

   while($filedata = mysqli_fetch_array($results)){

    $file_views[] = $filedata['views'];

    }



    //Content impression view over time

    $impression = "SELECT COUNT(imp_id) as imp from file_impression WHERE file_id = '".$id."' and DATE_FORMAT( imp_date, '%Y-%M-%d' ) = '".$date."'";

    $impression_results = mysqli_query($con,$impression);

       while($impressiondata = mysqli_fetch_array($impression_results)){

            $file_impression[] = $impressiondata['imp'];

        }



    //Content Download over time

    $download = "SELECT COUNT(download) as download from file_download WHERE file_id = '".$id."' and DATE_FORMAT( download_date, '%Y-%M-%d' ) = '".$date."'";

    $download_results = mysqli_query($con,$download);

       while($downloaddata = mysqli_fetch_array($download_results)){

            $file_download[] = $downloaddata['download'];

        }



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



     //Content view according to city

       $city = "SELECT ip from cs_log WHERE fileid = '".$id."' and DATE_FORMAT( date_time, '%Y-%M-%d' ) = '".$date."'";

       $city_results = mysqli_query($con,$city);

       if (mysqli_num_rows($city_results) > 1) {

           $view_arr = array();

           while($city_filedata = mysqli_fetch_array($city_results)){

               $ip = $city_filedata['ip']; // your ip address here

                $query = @unserialize(file_get_contents('http://ip-api.com/php/'.$ip));

                if($query && $query['status'] == 'success')

                {

                    if(!in_array($query['city'], $city_list)){

                        $city_list[] = $query['city'];

                    }



                    $view_arr[$query['city']] = $view_arr[$query['city']] + 1;

                }

            }

           $city_views[] = $view_arr;

        } else{

            $city_views[] = "";

        }

    

    

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







    $sale = "SELECT SUM(transfer_amount) as amounts from payments WHERE file_id = '".$id."' and DATE_FORMAT( p_date, '%Y-%M-%d' ) = '".$date."'";

    $sale_results = mysqli_query($con,$sale);

    while($sale_resultsdata = mysqli_fetch_array($sale_results)){

        if($sale_resultsdata['amounts'] == ''){

            $file_sales[] = 0;

        } else{

            $file_sales[] = round($sale_resultsdata['amounts']);

        }

    }



$total[] = $file_views[$i] + $file_sales[$i];

$referrer_total[] = $facebook_views[$i] + $twitter_views[$i] + $linkedin_views[$i] + $google_views[$i];

$i++;



}



//Country Chart Arrays



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

// echo "<pre>";

// print_r($country_name);

// print_r($country_views);

// print_r($country_view_data);exit;

$sumArray = array();



foreach ($country_view_data as $k => $subArray) {

  foreach ($subArray as $id => $value) {

    if ( ! isset($sumArray[$id])) {

       $sumArray[$id] = 0;

    }

    $sumArray[$id] += $value;

  }

}



//Page Count Arrays



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

//City Chart Arrays



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

//Device Chart Arrays



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

// echo "<pre>";

// print_r($country_list);

// print_r($country_name);

// print_r($country_view_data);

// exit;



?>

<div id="chart" >

    <div id="barChart1" style="height:600px; margin-bottom: 20px;"></div>
</div>                                  



    <script src="UI-Chart/js/chartli.js"></script>

    

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

            "title": {

                "text": "Share Statistics",

                x: "1%",



                textStyle: {

                    color: '#fff',

                    fontSize: '22'

                },

                subtextStyle: {

                    color: '#90979c',

                    fontSize: '16',



                },

            },

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

                top: '1%',

                textStyle: {

                    color: '#90979c',

                },

                "data": ['Views', 'Sales', 'Total'],

                itemGap: 20

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

                    "interval": 0,



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


    

    