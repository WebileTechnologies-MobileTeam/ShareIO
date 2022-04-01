<style>
    /* Adding gvnix styles css - NO COPIAR */
  @import 'https://geo-gvnix.rhcloud.com/resources/styles/standard.css';
 /* Custom fixed navs */

   header.navbar+nav.navbar{
   /* margin-top: 20px;same margin-bottom .navbar */
   }
   .navbar.navbar-default.navbar-fixed-top{
   margin-top: 50px;
   }
   .sidebar.navbar-fixed-top{
    margin-top: 100px;
   }

   @media (min-width: 768px) and (max-width: 998px){
       .navbar.navbar-default.navbar-fixed-top{
       margin-top: 100px;
       }
       .sidebar.navbar-fixed-top{
        margin-top: 150px;
       }
    }

  /* Custom navbar default: global*/

  .navbar.navbar-default{
    background-color: #f8f8f8;
    border-color: #e7e7e7;
    margin: 0;
    border-radius: 0;
  }
  .navbar.navbar-default .navbar-brand {
    color: #666;
    text-shadow: none;
    min-width: 150px;
    }
   .navbar.navbar-default .navbar-nav > li > a {
    color: #666;
    text-shadow: none;
    }
    .navbar.navbar-default .navbar-nav > li > a {
    color: #666;
    text-shadow: none;
    }
    .navbar.navbar-default .navbar-nav > li > a:hover{
    color: #acc47f;
    }
    .navbar.navbar-default .navbar-nav > .active > a{
    color: #fff;
    background-color: #acc47f;
    }
    .navbar.navbar-default .navbar-nav > .active > a:hover{
    color: #608224;
    background-color: #acc47f;
    }
    .navbar.navbar-default .caret {
    border-top-color: #ccc;
    border-bottom-color: #ccc;
    }
    .navbar.navbar-default .caret:hover {
    border-top-color: #333;
    border-bottom-color: #333;
    }


/* Custom sidebar menu */

 /*Remove rounded coners*/

  nav.sidebar.navbar {
    border-radius: 0px;
  }

  nav.sidebar, .main{
    -webkit-transition: margin 200ms ease-out;
      -moz-transition: margin 200ms ease-out;
      -o-transition: margin 200ms ease-out;
      transition: margin 200ms ease-out;
  }

  /* Add gap to nav and right windows.*/
  .main{
    padding: 10px 10px 0 10px;
  }

  /* .....NavBar: Icon only with coloring/layout.....*/

  /*small/medium side display*/
  @media (min-width: 768px) {

    /*Allow main to be next to Nav*/
    .main{
      position: absolute;
      width: calc(100% - 40px); /*keeps 100% minus nav size*/
      margin-left: 40px;
      float: right;
    }

    /*lets nav bar to be showed on mouseover*/
    nav.sidebar:hover + .main{
      margin-left: 200px;
    }

    /*Center Brand*/
    nav.sidebar.navbar.sidebar>.container .navbar-brand, .navbar>.container-fluid .navbar-brand {
      margin-left: 0px;
    }
    /*Center Brand*/
    nav.sidebar .navbar-brand, nav.sidebar .navbar-header{
      text-align: center;
      width: 100%;
      margin-left: 0px;
    }

    /*Center Icons*/
    nav.sidebar a{
      padding-right: 13px;
            min-width: 100px;
    }

    /*custom sidebar nav*/
        nav.sidebar ul.nav.navbar-nav{
            margin: 0;
        }
        nav.sidebar.navbar-inverse .navbar-nav .open .dropdown-menu>li>a {
            color: white;
        }

    /*adds border top to first nav box */
    nav.sidebar .navbar-nav > li:first-child{
      border-top: 1px #e5e5e5 solid;
    }

    /*adds border to bottom nav boxes*/
    nav.sidebar .navbar-nav > li{
      border-bottom: 1px #e5e5e5 solid;
    }
    /*adds background on hover*/
    nav.sidebar .navbar-nav > li:hover{
        color: #fff;
            background-color: #43600E;
    }
    /*removes border last element*/
    nav.sidebar .navbar-nav > li.last{
      border-bottom: none;
    }

    /* Colors/style dropdown box*/
    nav.sidebar .navbar-nav .open .dropdown-menu {
      position: static;
      float: none;
      width: auto;
      margin-top: 0;
      background-color: transparent;
      border: 0;
      -webkit-box-shadow: none;
      box-shadow: none;
    }

    /*allows nav box to use 100% width*/
    nav.sidebar .navbar-collapse, nav.sidebar .container-fluid{
      padding: 0 0px 0 0px;
    }

    /*colors dropdown box text */
    .navbar-inverse .navbar-nav .open .dropdown-menu>li>a {
      color: #777;
    }

/*O quanto o menu irá esconder á esquerda*/
    /*gives sidebar width/height*/
    nav.sidebar{
      width: 200px;
      height: 100%;
      margin-left: -270px;
      float: left;
      z-index: 8000;
      margin-bottom: 0px;
    }

    /*give sidebar 100% width;*/
    nav.sidebar li {
      width: 100%; border: none;
    border-bottom: 1px solid #23282e;
    }

    /* Move nav to full on mouse over*/
    nav.sidebar:hover{
      margin-left: 0px;
    }
    /*for hiden things when navbar hidden*/
    .forAnimate{
      opacity: 0;
    }
  }

  /* .....NavBar: Fully showing nav bar..... */

  @media (min-width: 1330px) {

/*     Allow main to be next to Nav
    .main{
      width: calc(100% - 200px); keeps 100% minus nav size
      margin-left: 200px;
    }

    Show all nav
    nav.sidebar{
      margin-left: 0px;
      float: left;
    }
    Show hidden items on nav
    nav.sidebar .forAnimate{
      opacity: 1;
    } */
  }

  nav.sidebar .navbar-nav .open .dropdown-menu>li>a:hover, nav.sidebar .navbar-nav .open .dropdown-menu>li>a:focus {
    color: #CCC;
    background-color: transparent;
  }

  nav:hover .forAnimate{
    opacity: 1;
  }
  
  
  /*---- FIM SLIDE MENU*/
  
  .nav-side-menu {
  overflow: auto;
  font-family: verdana;
  font-size: 12px;
  font-weight: 200;
  background-color: #2e353d;
  position: fixed;
  top: 0px;
  width: 300px;
  height: 100%;
  color: #e1ffff;
}
.nav-side-menu .brand {
  background-color: #23282e;
  line-height: 50px;
  display: block;
  text-align: center;
  font-size: 14px;
}
.nav-side-menu ul,
.nav-side-menu li {
  list-style: none;
  padding: 0px;
  margin: 0px;
  line-height: 35px;
  cursor: pointer;
  /*    
    .collapsed{
       .arrow:before{
                 font-family: FontAwesome;
                 content: "\f053";
                 display: inline-block;
                 padding-left:10px;
                 padding-right: 10px;
                 vertical-align: middle;
                 float:right;
            }
     }
*/
}
.nav-side-menu ul :not(collapsed) .arrow:before,
.nav-side-menu li :not(collapsed) .arrow:before {
  font-family: FontAwesome;
  content: "\f078";
  display: inline-block;
  padding-left: 10px;
  padding-right: 10px;
  vertical-align: middle;
  float: right;
}
.nav-side-menu ul .active,
.nav-side-menu li .active {
  border-left: 3px solid #d19b3d;
  background-color: #4f5b69;
}
.nav-side-menu ul .sub-menu li.active,
.nav-side-menu li .sub-menu li.active {
  color: #d19b3d;
}
.nav-side-menu ul .sub-menu li.active a,
.nav-side-menu li .sub-menu li.active a {
  color: #d19b3d;
}
.nav-side-menu ul .sub-menu li,
.nav-side-menu li .sub-menu li {
  background-color: #181c20;
  border: none;
  line-height: normal;
  border-bottom: 1px solid #23282e;
  margin-left: 0px;
}
.nav-side-menu ul .sub-menu li:hover,
.nav-side-menu li .sub-menu li:hover {
  background-color: #020203;
}

.nav-side-menu li {
  padding-left: 0px;
  border-left: 3px solid #2e353d;
  border-bottom: 1px solid #23282e;
}
.nav-side-menu li a {
  text-decoration: none;
  color: #e1ffff;
}
.nav-side-menu li a i {
  padding-left: 10px;
  width: 20px;
  padding-right: 20px;
}
.nav-side-menu li:hover {
  border-left: 3px solid #d19b3d;
  background-color: #4f5b69;
  -webkit-transition: all 1s ease;
  -moz-transition: all 1s ease;
  -o-transition: all 1s ease;
  -ms-transition: all 1s ease;
  transition: all 1s ease;
}
@media (max-width: 767px) {
  .nav-side-menu {
    position: relative;
    width: 100%;
    margin-bottom: 10px;
  }
  .nav-side-menu .toggle-btn {
	
    cursor: pointer;
    position: absolute;
    right: 10px;
    top: 10px;
    z-index: 10 !important;
    padding: 3px;
    background-color: #ffffff;
    color: #000;
    width: 40px;
    text-align: center;
  }
  .brand {
    text-align: left !important;
    font-size: 22px;
    padding-left: 20px;
    line-height: 50px !important;
  }
}
@media (min-width: 767px) {
  .nav-side-menu .menu-list .menu-content {
    display: block;
  }
}
body {
  margin: 0px;
  padding: 0px;
}
.nav-side-menu li .sub-menu li a span {
    position: static;
}
.nav-side-menu ul.sub-menu {
    border-top: 1px solid #23282e; display: none;
}
div.nav-side-menu li .sub-menu li a,.nav-open-hover nav.sidebar .nav-side-menu li .sub-menu li a {
    padding: 15px 30px;
}
.nav-open-hover nav.sidebar .nav-side-menu ul.sub-menu {
    display: block;
}


</style>
<link href="//netdna.bootstrapcdn.com/bootstrap/3.0.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
<script src="//netdna.bootstrapcdn.com/bootstrap/3.0.0/js/bootstrap.min.js"></script>
<!------ Include the above in your HEAD tag ---------->

<!--nav sidebar -->
<div class="left-sidebar">
<aside>
  <nav class="navbar navbar-inverse sidebar navbar-fixed-top" role="navigation">
      <link href="//maxcdn.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css" rel="stylesheet">

<div class="nav-side-menu">
    <div class="brand">
		<a class="brand" href="Dashboard.php">
			<img class="big_logo" src="http://3.135.223.154/image/logo.png" />
			<img class="small_logo" src="http://3.135.223.154/image/logo-icon.png">
		</a>
	</div>
    
  
        <div class="menu-list">
  
            <ul id="menu-content" class="menu-content collapse out">
                <li>
                  <a href="Dashboard.php">
					<i class="fa fa-dashboard fa-lg"></i>
					<span>Dashboard</span>
                  </a>
                </li>

                 <li>
                  <a href="UserDetails.php">
          <i class="fa fa-users fa-lg"></i>
          <span>Users</span>
                  </a>
                </li>

                <li>
                  <a href="viewFiles.php" id="hover">
          <i class="fa fa-file fa-lg"></i>
          <span>Manage Content</span>
                  </a>
                  <ul class="sub-menu">
                  <li>
                  <a href="viewEvalution.php">
                  <span>Evaluation</span>
                  </a>
                  </ul>
                </li>

                <li>
                  <a href="Setting.php">
					<i class="fa fa-cog fa-lg"></i>
						<span>Settings</span>
                  </a>
                  </li>
            </ul>
     </div>
</div>
  </nav>
  
</aside>
</div>

<script>
      function htmlbodyHeightUpdate(){
    var height3 = $( window ).height()
    var height1 = $('.nav').height()+50
    height2 = $('.main').height()
    if(height2 > height3){
      $('html').height(Math.max(height1,height3,height2)+10);
      $('body').height(Math.max(height1,height3,height2)+10);
    }
    else
    {
      $('html').height(Math.max(height1,height3,height2));
      $('body').height(Math.max(height1,height3,height2));
    }
    
  }
  $(document).ready(function () {
    htmlbodyHeightUpdate()
    $( window ).resize(function() {
      htmlbodyHeightUpdate()
    });
    $( window ).scroll(function() {
      height2 = $('.main').height()
        htmlbodyHeightUpdate()
    });
  });
</script>