<head>
<meta charset="utf-8">
<title>Dashboard - CONTENTSHARE</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
<meta name="apple-mobile-web-app-capable" content="yes">
<link href="http://3.135.223.154/css/bootstrap.min.css" rel="stylesheet">
<link href="http://3.135.223.154/css/bootstrap-responsive.min.css" rel="stylesheet">
<link href="https://fonts.googleapis.com/css?family=Open+Sans:400italic,600italic,400,600"
        rel="stylesheet">
<link href="http://3.135.223.154/css/font-awesome.css" rel="stylesheet">
<link href="http://3.135.223.154/css/style.css" rel="stylesheet">
<link href="http://3.135.223.154/css/pages/dashboard.css" rel="stylesheet">
<link href="http://3.135.223.154/css/pages/reports.css" rel="stylesheet">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="http://3.135.223.154/js/main.js"></script>
<script src="http://3.135.223.154/js/stripe.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.0/jquery.validate.min.js"></script>
<script src="http://3.135.223.154/js/jquery-1.7.2.min.js"></script> 
<script src="http://3.135.223.154/js/excanvas.min.js"></script> 
<script src="http://3.135.223.154/js/chart.min.js" type="text/javascript"></script> 
<script src="http://3.135.223.154/js/bootstrap.js"></script>
<script language="javascript" type="text/javascript" src="js/full-calendar/fullcalendar.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
<script src="https://code.jquery.com/jquery-1.11.3.min.js"></script>
<script src="https://js.stripe.com/v3/"></script>

 
<script src="http://3.135.223.154/js/base.js"></script> 
<!-- Le HTML5 shim, for IE6-8 support of HTML5 elements -->
<!--[if lt IE 9]>
      <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->
<script>

	$(document).ready(function(){
		$(".menu_bar a").click(function(){
			$("body").toggleClass("nav-open");
		});
		
		$("div.nav-side-menu").hover(function(){
			$("body").toggleClass("nav-open-hover");
		});
	});
</script>
</head>

<div class="navbar navbar-fixed-top">
  <div class="navbar-inner">
    <div class="container">
		<div class="menu_bar pull-left">
			<a href="javascript:;"><i class="fa fa-bars fa-2x toggle-btn" data-toggle="collapse" data-target="#menu-content"></i></a>
		</div>
		<div Class="logo">
			<a class="brand" href="Dashboard.php"><img src="http://3.135.223.154/image/logo-icon.png"/></a>
			<a class="brand brand-name" href="Dashboard.php">Welcome to ContentShare</a>
		</div>
      <div class="nav-collapse">
        <ul class="nav pull-right">
          <!-- <li class="dropdown"><a href="#" class="dropdown-toggle" data-toggle="dropdown"><i
                            class="icon-cog"></i> Account <b class="caret"></b></a>
            <ul class="dropdown-menu">
              <li><a href="javascript:;">Settings</a></li>
              <li><a href="javascript:;">Help</a></li>
            </ul>
          </li> -->
          <li class="dropdown"><a href="logout.php" class="dropdown-toggle" data-toggle="dropdown"><i
                            class="icon-user"></i>  <b class="caret"></b></a>
             <ul class="dropdown-menu">
              <li><a href="logout.php">Logout</a></li>
          </li>
        </ul>
       <!--  <form class="navbar-search pull-right">
          <input type="text" class="search-query" placeholder="Search">
        </form> -->
      </div>
      <!--/.nav-collapse --> 
    </div>
    <!-- /container --> 
  </div>
  <!-- /navbar-inner --> 
</div>
<?php
if(empty($_SESSION['csuser'])){
  header("Location: index.php");
} else{
  include('sidebar.php');
}

?>
