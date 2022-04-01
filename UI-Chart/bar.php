<?php 
require('../include/db.php');
session_start();
?>

<?php
$id = '211';
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
$total = array();
$dates = array();


$start = $day = strtotime($filedata['date_time']);
$end = strtotime(date("Y-m-d"));
$i = 0;
while($day < $end)
{
     $date = date('Y-F-d', $day);
     $dates[] = $date;
     $day = strtotime("+1 day", $day);
     $view = "SELECT COUNT(log_id) as views from cs_log WHERE fileid = '211' and DATE_FORMAT( date_time, '%Y-%M-%d' ) = '".$date."'";
     $results = mysqli_query($con,$view);
        while($filedata = mysqli_fetch_array($results)){
            $file_views[] = $filedata['views'];
        }

     $sale = "SELECT SUM(transfer_amount) as amounts from payments WHERE file_id = '211' and DATE_FORMAT( p_date, '%Y-%M-%d' ) = '".$date."'";
     $sale_results = mysqli_query($con,$sale);
        while($sale_resultsdata = mysqli_fetch_array($sale_results)){
            if($sale_resultsdata['amounts'] == ''){
                $file_sales[] = 0;
            } else{
                $file_sales[] = $sale_resultsdata['amounts'];
            }
        }

    $total[] = $file_views[$i] + $file_sales[$i];
    $i++;

}
// print_r($total);
// exit;

?>
<!DOCTYPE html>
<html>
<head>
    <!-- Standard Meta -->
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
    <meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=1">
    <link rel="image_src" type="image/jpeg" href="/images/logo.png" />
    <link rel="icon" href="img/favicon.ico" type="image/x-icon" />
    <link rel="shortcut icon" href="img/favicon.ico" type="image/x-icon" />
    <!-- Site Properities -->
    <meta name="generator" content="Visual Studio 2015" />
    <title>Chartli | Interactive Chart</title>
    <meta name="description" content="Chartli Interactive Chart" />
    <meta name="keywords" content="html5,chart,ui, library, framework, javascript,jquery,graphic,interactive" />
    <link href="css/semantic.css" rel="stylesheet" />
    <link href="css/demo.css" rel="stylesheet" />
</head>
<body>
    <div id="wrapper">

        <!-- Page Content -->
        <div id="page-content-wrapper">
            <div class="ui grid">
                <!-- <div class="row">
                    <div class="column">
                        <div class="ui segment">
                            <div id="barChart0" style="height:600px;"></div>
                        </div>
                    </div>
                </div> -->
                <div class="row">
                    <div class="column">
                        <div class="ui segment">

                            <div id="barChart1" style="height:600px;"></div>
                        </div>
                    </div>
                </div>
                <!--  -->
            </div>
        </div>
        <!-- /#page-content-wrapper -->
    </div>

    <script src="js/jquery-2.1.4.min.js"></script>
    <script src="js/chartli.js"></script>
    
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
                "data": ['Views', 'Sales', 'Avarage'],
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
    
</body>
</html>