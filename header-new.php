<header class="header">
    <div class="sticky_header">
    	<a class="logo" href="dashboard.php"><img src="images/content-share-new-logo.png" alt="Logo" /></a>
    	<?php
      if($_SERVER['REQUEST_URI'] == '/dashboard.php' || $_SERVER['REQUEST_URI'] == '/' && !isset($_GET['s'])){ ?>
        <ul class="snip1143">
          <li><a class="slide_menu current" href="#slide1" data-id="1" data-hover="Introduction">Introduction</a></li>
          <li><a class="slide_menu" href="#slide5" data-id="5" data-hover="Integration">Integration</a></li>
          <li><a class="slide_menu" href="#slide7" data-id="7" data-hover="Features">Features</a></li>
          <li><a class="slide_menu" href="#slide9" data-id="12" data-hover="Pricing">Pricing</a></li>
        </ul>
      <?php
      }
        //echo '<pre>';
        //print_r($_SESSION);exit;
        if(isset($_SESSION['user']) && !empty($_SESSION['user'])){ 
          $sql = "SELECT * from cs_users where id = '" . $_SESSION["user"] . "' OR oauth_uid =  '" . $_SESSION["user"] . "'";
          $result = mysqli_query($con,$sql);
          $fetch_data = mysqli_fetch_array($result);
          ?>
       
    	<div class="menu_bar_icon tooltip_shows">
    		<a href="javascript:;">
    			<img src="images/menu_bar.png" alt="Menu Bar" />
    		</a>
    		<div class="left">
    			<span>Main menu</span>
    		</div>
    	</div>
	</div>
	
	<div class="menus">
			<div class="menus_icon tooltip_shows">
				<a class="share_icon upload_icon" href="dashboard.php?s=1" id="getcontent">
          <svg xmlns="http://www.w3.org/2000/svg" height="70px" viewBox="0 0 24 24" width="70px" fill="#ffffff"><path d="M0 0h24v24H0z" fill="none"/><path d="M19.35 10.04C18.67 6.59 15.64 4 12 4 9.11 4 6.6 5.64 5.35 8.04 2.34 8.36 0 10.91 0 14c0 3.31 2.69 6 6 6h13c2.76 0 5-2.24 5-5 0-2.64-2.05-4.78-4.65-4.96zM14 13v4h-4v-4H7l5-5 5 5h-3z"/></svg>
        </a>
				<div class="left">
					<span> Upload File</span>
				</div>
			</div>
		<div class="menus_icon tooltip_shows">
			<a href="reports.php" class="share_icon link_icon">
      <svg xmlns="http://www.w3.org/2000/svg" height="70px" viewBox="0 0 24 24" width="70px" fill="#ffffff"><path d="M0 0h24v24H0z" fill="none"></path><path d="M3.9 12c0-1.71 1.39-3.1 3.1-3.1h4V7H7c-2.76 0-5 2.24-5 5s2.24 5 5 5h4v-1.9H7c-1.71 0-3.1-1.39-3.1-3.1zM8 13h8v-2H8v2zm9-6h-4v1.9h4c1.71 0 3.1 1.39 3.1 3.1s-1.39 3.1-3.1 3.1h-4V17h4c2.76 0 5-2.24 5-5s-2.24-5-5-5z"></path></svg>
      </a>
			<div class="left">
				<span>View Links</span>
			</div>
		</div>

    <div class="menus_icon tooltip_shows package_box">
    <a href="AddPackage.php" class="share_icon package_icon">
      <svg xmlns="http://www.w3.org/2000/svg" width="70px" fill="#ffffff" xmlns:xlink="http://www.w3.org/1999/xlink" version="1.1" id="Layer_1" x="0px" y="0px" viewBox="0 0 512 512" style="enable-background:new 0 0 512 512;" xml:space="preserve">
        <g>
          <path d="M171.456,201.1c-3.729,4.954-9.453,8.014-15.645,8.361l-83.291,4.669v185.115l162.719,31.602V116.336L171.456,201.1z"/>
        </g>
        <g>
          <path d="M356.767,209.461c-6.194-0.347-11.917-3.406-15.645-8.361l-63.778-84.759v314.506l162.716-31.602V214.131L356.767,209.461    z"/>
        </g>
        <g>
          <polygon points="447.804,101.376 303.61,81.218 312.862,93.515 368.885,167.969 427.28,171.243 512,175.993   "/>
        </g>
        <g>
          <polygon points="63.129,101.373 0,176.025 85.299,171.242 143.69,167.969 199.713,93.519 209.018,81.152   "/>
        </g>
        </svg>
      </a>
      	<div class="left">
				<span>Create Package</span>
			</div>
    </div>

    <div class="menus_icon tooltip_shows">
      <a href="UserCustomDashboard.php" class="share_icon dashboard_icon">
        <svg xmlns="http://www.w3.org/2000/svg" height="70px" viewBox="0 0 24 24" width="70px" fill="#ffffff"><path d="M0 0h24v24H0z" fill="none"/><path d="M3 13h8V3H3v10zm0 8h8v-6H3v6zm10 0h8V11h-8v10zm0-18v6h8V3h-8z"/></svg>
      </a>
      	<div class="left">
				<span>Create Dashboard</span>
			</div>
    </div>

    <div class="menus_icon tooltip_shows">
      <a href="setting.php" class="share_icon setting_icon">
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" width="72"><path fill="none" d="M0 0h20v20H0V0z"/><path d="M15.95 10.78c.03-.25.05-.51.05-.78s-.02-.53-.06-.78l1.69-1.32c.15-.12.19-.34.1-.51l-1.6-2.77c-.1-.18-.31-.24-.49-.18l-1.99.8c-.42-.32-.86-.58-1.35-.78L12 2.34a.4.4 0 0 0-.4-.34H8.4c-.2 0-.36.14-.39.34l-.3 2.12c-.49.2-.94.47-1.35.78l-1.99-.8c-.18-.07-.39 0-.49.18l-1.6 2.77c-.1.18-.06.39.1.51l1.69 1.32c-.04.25-.07.52-.07.78s.02.53.06.78L2.37 12.1c-.15.12-.19.34-.1.51l1.6 2.77c.1.18.31.24.49.18l1.99-.8c.42.32.86.58 1.35.78l.3 2.12c.04.2.2.34.4.34h3.2c.2 0 .37-.14.39-.34l.3-2.12c.49-.2.94-.47 1.35-.78l1.99.8c.18.07.39 0 .49-.18l1.6-2.77c.1-.18.06-.39-.1-.51l-1.67-1.32zM10 13c-1.65 0-3-1.35-3-3s1.35-3 3-3 3 1.35 3 3-1.35 3-3 3z"/></svg>   
      </a>
      <div class="left">
        <span>User settings</span>
      </div>
    </div>

		<div class="menus_icon tooltip_shows">
			<a href="UserAdmin.php" class="share_icon user_setting_icon">
        <svg id="Layer_1" data-name="Layer 1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 122.88 114.37" width="50"><defs><style>.cls-1{fill-rule:evenodd;}</style></defs><title>manage</title><path class="cls-1" d="M0,105.3C0,65.76,37.33,87.65,40.17,63.42c.31-2.64-5.91-9.61-7.34-14.43-3-4.87-4.15-12.6-.81-17.74,1.33-2.05.77-7.44.77-10.25,0-28,49.05-28,49.05,0,0,3.54-.82,8,1.11,10.76C86.17,36.42,84.5,44.67,81.79,49,80.06,54.05,73.44,60.55,74,63.42a15.9,15.9,0,0,0,2.82,6.74l-.48.47a8.54,8.54,0,0,0-1.84,2.73l-.12.31a8.22,8.22,0,0,0-.54,2.93,8.42,8.42,0,0,0,.68,3.28l.27.57a10.13,10.13,0,0,0-1.26.39,8.65,8.65,0,0,0-4.63,4.63l-.2.59a8.34,8.34,0,0,0-.42,2.61V94a8.23,8.23,0,0,0,.65,3.22l.24.52a8.69,8.69,0,0,0,1.51,2.13l.14.14a8.52,8.52,0,0,0,2.64,1.79l.67.24a6.94,6.94,0,0,0-.57,1.08,8.29,8.29,0,0,0-.62,2.14ZM115.16,75a2.16,2.16,0,0,0-1.55-.65,2.12,2.12,0,0,0-1.55.65L109.7,77.4a16.2,16.2,0,0,0-2-1.09,20.57,20.57,0,0,0-2.14-.83V71.86a2.17,2.17,0,0,0-2.18-2.19H98.83a2.12,2.12,0,0,0-1.53.64,2.09,2.09,0,0,0-.65,1.55v3.31a16.48,16.48,0,0,0-2.2.68,15.72,15.72,0,0,0-2,.94L89.8,74.21a2,2,0,0,0-1.51-.65,2.14,2.14,0,0,0-1.55.65L83.56,77.4a2.15,2.15,0,0,0,0,3.1l2.35,2.36a15.33,15.33,0,0,0-1.08,2A21.56,21.56,0,0,0,84,87H80.37a2.15,2.15,0,0,0-2.18,2.18v4.55a2.19,2.19,0,0,0,2.18,2.17h3.32a15.6,15.6,0,0,0,.67,2.2,20.6,20.6,0,0,0,.94,2.08l-2.58,2.57a2,2,0,0,0-.65,1.51,2.12,2.12,0,0,0,.65,1.55L85.91,109a2.2,2.2,0,0,0,1.55.61A2.17,2.17,0,0,0,89,109l2.36-2.4a16.2,16.2,0,0,0,2,1.09,21.31,21.31,0,0,0,2.13.83v3.62a2.19,2.19,0,0,0,2.19,2.19h4.54a2.12,2.12,0,0,0,1.53-.64,2.09,2.09,0,0,0,.65-1.55v-3.31a16.48,16.48,0,0,0,2.2-.68,21.65,21.65,0,0,0,2.08-.94l2.57,2.58a2,2,0,0,0,1.52.65,2,2,0,0,0,1.54-.65l3.22-3.19a2.19,2.19,0,0,0,.62-1.55,2.15,2.15,0,0,0-.62-1.55l-2.39-2.36a15.33,15.33,0,0,0,1.08-2,21.56,21.56,0,0,0,.84-2.14h3.62a2.15,2.15,0,0,0,2.18-2.18V90.31a2.13,2.13,0,0,0-.63-1.52,2.07,2.07,0,0,0-1.55-.65h-3.32a19.5,19.5,0,0,0-.67-2.18,16.93,16.93,0,0,0-.94-2.06l2.57-2.61a2,2,0,0,0,.66-1.52,2.11,2.11,0,0,0-.66-1.54L115.16,75Zm-14.63,8.08a8.89,8.89,0,0,1,3.48.69,8.81,8.81,0,0,1,4.73,4.74,9,9,0,0,1,0,6.94,8.81,8.81,0,0,1-4.73,4.74,9.1,9.1,0,0,1-7,0,8.81,8.81,0,0,1-4.73-4.74,9,9,0,0,1,0-6.94,8.81,8.81,0,0,1,4.73-4.74,8.88,8.88,0,0,1,3.47-.69Z"></path></svg>   
      </a>
			<div class="left">
				<span>User Admin</span>
			</div>
		</div>
    <?php if($fetch_data['user_role'] == 'Admin'){?>
    <div class="menus_icon tooltip_shows">
      <a href="SystemAdmin.php" class="admin_panel">
        <svg xmlns="http://www.w3.org/2000/svg" enable-background="new 0 0 24 24" height="72px" viewBox="0 0 24 24" width="72px" fill="#FFFFFF"><g><rect fill="none" height="24" width="24"/></g><g><g><path d="M17,11c0.34,0,0.67,0.04,1,0.09V6.27L10.5,3L3,6.27v4.91c0,4.54,3.2,8.79,7.5,9.82c0.55-0.13,1.08-0.32,1.6-0.55 C11.41,19.47,11,18.28,11,17C11,13.69,13.69,11,17,11z"/><path d="M17,13c-2.21,0-4,1.79-4,4c0,2.21,1.79,4,4,4s4-1.79,4-4C21,14.79,19.21,13,17,13z M17,14.38c0.62,0,1.12,0.51,1.12,1.12 s-0.51,1.12-1.12,1.12s-1.12-0.51-1.12-1.12S16.38,14.38,17,14.38z M17,19.75c-0.93,0-1.74-0.46-2.24-1.17 c0.05-0.72,1.51-1.08,2.24-1.08s2.19,0.36,2.24,1.08C18.74,19.29,17.93,19.75,17,19.75z"/></g></g></svg>
      </a>
      <div class="left">
        <span>System Settings</span>
      </div>
    </div>
		<?php }?>
		<div class="menus_icon logout">
			<div class="tooltip_shows">
				<a href="logout.php" class="share_icon">
          <svg xmlns="http://www.w3.org/2000/svg" width="55" height="55" viewBox="0 0 20 20">
            <title>
              log out
            </title>
            <path d="M3 3h8V1H3a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h8v-2H3z"/>
            <path d="M19 10l-6-5v4H5v2h8v4l6-5z"/>
          </svg>
        </a>
				<div class="left">
					<span>Logout</span>
				</div>
			</div>
		</div>
		<div class="menus_icon deleteaccount">
			<div class="tooltip_shows">
				<a href="javascript:;" id="delete-account" class="share_icon">
          <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="65" height="65"><path d="M6 19c0 1.1.9 2 2 2h8c1.1 0 2-.9 2-2V7H6v12zM19 4h-3.5l-1-1h-5l-1 1H5v2h14V4z"/><path d="M0 0h24v24H0z" fill="none"/></svg>    
        </a>
				<div class="left">
					<span>Delete Account</span>
				</div>
			</div>
		</div>
	</div>
	 <?php 
    } else{ 
      if($_SERVER['REQUEST_URI'] != '/dashboard.php' && $_SERVER['REQUEST_METHOD'] == 'GET'){
        header("Location: dashboard.php");
      }

    ?>
	<div class="menu_bar_icon tooltip_shows">
		<a href="#" class="user_login_info" id="login_tab_btn"><i class="fa fa-user" aria-hidden="true"></i></a>
		<div class="left">
			<span>Login</span>
		</div>
	</div>
    <?php } ?>
</header>
<?php

function formatSizeUnits($bytes) {
    if ($bytes >= 1073741824) {
        $bytes = number_format($bytes / 1073741824, 2) . ' GB';
    } elseif ($bytes >= 1048576) {
        $bytes = number_format($bytes / 1048576, 2) . ' MB';
    } elseif ($bytes >= 1024) {
        $bytes = number_format($bytes / 1024, 2) . ' KB';
    } elseif ($bytes > 1) {
        $bytes = $bytes . ' bytes';
    } elseif ($bytes == 1) {
        $bytes = $bytes . ' byte';
    } else {
        $bytes = '0 bytes';
    }
    return $bytes;
}

?>
<!-- <div id="clouds" class="fullscreen-preview"></div> -->


<script>
$(document).ready(function(){
	$(".menu_bar_icon").click(function(){
		$(".menus").toggleClass("menu_open");
	});

  $('.slide_menu').on('click', function(){
    $('.slide_menu').removeClass('current');
    $(this).addClass('current');
  });
});

// $('#login_tab_btn').on('click', function(){
//    $('.owl-carousel').trigger('to.owl.carousel', 4) 
// });

$('#login_tab_btn').on('click', function(){
  var html = $('.login_with_social_media');
  html.show();
  Swal.fire({
    customClass: { popup : 'login_popup'},
    html: html,
    showConfirmButton: false
  }) 
  html.hide();
});

$('#delete-account').on('click', function(){
    cuteAlert({
      type: "question",
      title: "Are you sure?",
      message: "You won't be able to revert this!",
      confirmText: "Yes, delete it!",
      cancelText: "Cancel"
   }).then((e)=>{
      if ( e == ("confirm")){
        $.ajax({
          type: "POST",
          url: "include/delete-account.php",
          success: function(res){ 
           window.location = "dashboard.php";
            
          }
        });
      }
    })
});
function deleteaccount(){
  $.ajax({
      type: "POST",
      url: "include/delete-account.php",
      success: function(res){ 
       window.location = "dashboard.php";
        
      }
    });
} 

// $(document).ready(function() {
// 	"use strict";
	
// 	var config = {
// 		imageCloud: "bgcloud-assets/images/themes/cloud-default.png",
// 		skyColor: "#8c9793",
// 		skyColorPower:100,
// 		cloudSpeed: 1.5,
// 		cameraControl: true,
// 		cloudData: [	
// 			{i:0,x:.5,y:.4,scale:3}, // 1
// 			{i:150,x:.5,y:.4,scale:5}, // 2
// 			{i:300,x:.5,y:.4,scale:6}, // 3
// 			{i:450,x:.5,y:.4,scale:6}, // 4
// 			{i:600,x:.5,y:.4,scale:7}, // 5
// 			{i:10,x:.35,y:.45,scale:2}, // 1
// 			{i:160,x:.35,y:.45,scale:4}, // 2
// 			{i:310,x:.35,y:.45,scale:5}, // 3
// 			{i:460,x:.35,y:.45,scale:5}, // 4
// 			{i:610,x:.35,y:.45,scale:6}, // 5
// 			{i:20,x:.65,y:.45,scale:2}, // 1
// 			{i:170,x:.65,y:.45,scale:4}, // 2
// 			{i:320,x:.65,y:.45,scale:5}, // 3
// 			{i:470,x:.65,y:.45,scale:5}, // 4
// 			{i:620,x:.65,y:.45,scale:6}, // 5
// 		]
// 	};
	
// 	var clouds = $("#clouds");
// 	clouds.clouds(config);
	
// });

  
    $(document).ready(function() {
      var owl = $('.dashboard_slider');
      if(owl.length)
      {
      	owl.owlCarousel({
              margin: 10,
              nav: false,
              loop: false,
              responsive: {
                0: {
                  items: 1
                },
                600: {
                  items: 1
                },
                1000: {
                  items: 1
                }
              }
            })
      }
    })


	$(document).ready(function() {
      var owl = $('.chart_slider');
      if(owl.length)
      {
      	owl.owlCarousel({
              margin: 10,
              nav: false,
              loop: false,
              responsive: {
                0: {
                  items: 1
                },
                600: {
                  items: 1
                },
                1000: {
                  items: 1
                }
              }
            })
      }
    })
</script>