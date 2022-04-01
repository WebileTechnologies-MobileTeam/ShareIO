<!DOCTYPE html>
<html lang="en">
<title>Reports - ShareIO</title>
<?php require('./include/db.php');
session_start(); ?>
<?php require('head.php'); ?>
<style>
  #preview{
  position:absolute;
  border:3px solid #ccc;
  background:#333;
  padding:5px;
  display:none;
  color:#fff;
  box-shadow: 4px 4px 3px rgba(103, 115, 130, 1);
  max-height: 200px;
  max-width: 200px;
  }
</style>
	<body>
		<?php require('header-new.php'); ?>
		<main>
			<div class="container new_container">
				<div class="row">
					<div class="col-md-12">
						<div class="main_content hidden">
							<div class="alert alert-success fade in" id="message" style="display: none;">
                <a href="#" class="close" data-dismiss="alert">&times;</a>
                <strong id="msg"></strong>
              </div>
              <?php 
              if(isset($_SESSION['succsessmsg'])){?>
                <input type="hidden" id="succsessmsg" name="succsessmsg" value="<?php echo $_SESSION['succsessmsg'];?>">
              <script>
                jQuery(document).ready(function($) {
                  var msg = $('#succsessmsg').val();
                  if(msg != ''){
                      cuteAlert({
                          type: "success",
                          title: "Thank You !",
                          message: "Settings saved your content can now be shared.",
                          buttonText: "Close"
                      })
                      }
                    });
              </script>
               <?php 
                unset($_SESSION['succsessmsg']);
                }
                if(isset($_SESSION['msgdashboard'])){?>
                <input type="hidden" id="msgdashboard" name="msgdashboard" value="<?php echo $_SESSION['msgdashboard'];?>">
              <script>
                jQuery(document).ready(function($) {
                  var msg = $('#msgdashboard').val();
                  if(msg != ''){
                      cuteAlert({
                          type: "success",
                          title: "Thank You !",
                          message: msg,
                          buttonText: "Close"
                      })
                      }
                    });
              </script>
               <?php 
                unset($_SESSION['msgdashboard']);
                }
                if(isset($_SESSION['msgdashboard'])){?>
                  <input type="hidden" id="msgdashboard" name="msgdashboard" value="<?php echo $_SESSION['msgdashboard'];?>">
                  <script>
                  jQuery(document).ready(function($) {
                  var msg = $('#msgdashboard').val();
                  if(msg != ''){
                      cuteAlert({
                          type: "success",
                          title: "Thank You !",
                          message: msg,
                          buttonText: "Close"
                      })
                      }
                      });
                  </script>
                  <?php 
                  unset($_SESSION['msgdashboard']);
                  }
                if(isset($_GET['p'])){?>
                  <script>
                    $(document).ready(function(){
                      package_tab();
                    });
                  </script>
                <?php
                }
                if(isset($_GET['d'])){?>
                  <script>
                    $(document).ready(function(){
                      dashboard_tab();
                    });
                  </script>
                <?php
                }
                ?>
               
                <div class="reports_bg">
                  <div class="top_default_icons">
                      <div class="icons description_icon tooltip_shows">
                          <a onclick="file_tab()" href="javascript:;" class="active">
                            <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 0 24 24" width="24px" fill="#000000"><path d="M0 0h24v24H0V0z" fill="none"/><path d="M8 16h8v2H8zm0-4h8v2H8zm6-10H6c-1.1 0-2 .9-2 2v16c0 1.1.89 2 1.99 2H18c1.1 0 2-.9 2-2V8l-6-6zm4 18H6V4h7v5h5v11z"/>
                              </svg>
                          </a>
                          <div class="top">
                            <span>File List</span> 
                          </div>
                      </div>
                      <div class="icons setting tooltip_shows">
                          <a onclick="package_tab()" href="javascript:;">
                            <svg xmlns="http://www.w3.org/2000/svg" width="70px" fill="#ffffff" xmlns:xlink="http://www.w3.org/1999/xlink" version="1.1" id="Layer_1" x="0px" y="0px" viewBox="0 0 512 512" style="enable-background:new 0 0 512 512;" xml:space="preserve">
                                <g>
                                    <path d="M171.456,201.1c-3.729,4.954-9.453,8.014-15.645,8.361l-83.291,4.669v185.115l162.719,31.602V116.336L171.456,201.1z"></path>
                                </g>
                                <g>
                                    <path d="M356.767,209.461c-6.194-0.347-11.917-3.406-15.645-8.361l-63.778-84.759v314.506l162.716-31.602V214.131L356.767,209.461    z"></path>
                                </g>
                                <g>
                                    <polygon points="447.804,101.376 303.61,81.218 312.862,93.515 368.885,167.969 427.28,171.243 512,175.993   "></polygon>
                                </g>
                                <g>
                                    <polygon points="63.129,101.373 0,176.025 85.299,171.242 143.69,167.969 199.713,93.519 209.018,81.152   "></polygon>
                                </g>
                            </svg>
                          </a>
                          <div class="top">
                            <span>Package List</span> 
                          </div>
                      </div>
                      <div class="icons dashboard tooltip_shows">
                          <a onclick="dashboard_tab()" href="javascript:;">
                            <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 0 24 24" width="24px" fill="#ffffff"><path d="M0 0h24v24H0z" fill="none"/><path d="M3 13h8V3H3v10zm0 8h8v-6H3v6zm10 0h8V11h-8v10zm0-18v6h8V3h-8z"/></svg>
                          </a>
                          <div class="top">
                            <span>Dashboard List</span> 
                          </div>
                      </div>
                  </div>


                  <div class="reports1">
                    <div class="filter-file d-flex flex-wrap">
                      <div class="w-50">
                        <span>File Type :</span>
                        <div class="select_box">
                          <?php
                          $content_type = '';
                          if(isset($_GET["type"])){
                          $content_type = $_GET["type"];
                          }
                          ?>
                          <select class="form-control" id="type" name="type">
                            <option value="">All Types</option>
                            <option value="application" <?php if($content_type == "application"){?> selected <?php }?>>PDF</option>
                            <option value="image" <?php if($content_type == "image"){?> selected <?php }?>>IMAGE</option>
                            <option value="audio" <?php if($content_type == "audio"){?> selected <?php }?>>AUDIO</option>
                            <option value="video" <?php if($content_type == "video"){?> selected <?php }?>>VIDEO</option>
                          </select>
                        </div>
                      </div>
                      <div class="w-50">
                        <div class="search-bar">
                          <?php
                          $search = '';
                          if(isset($_GET['search'])){
                          $search = $_GET['search'];?>
                          <script>
                            jQuery(document).ready(function($) {
                              var name = $('#search').val();
                              var page = '<?php echo $_GET['page']; ?>';
                              var url = "search-report.php?search="+name+"&&page="+page;            
                              $.ajax({
                                type: "POST",
                                url: url,
                                data: {
                                search: name,
                                page:page
                              },
                              success: function(html) {
                              $("#data").html(html);
                              }
                              });
                            });
                          </script>
                          <?php }
                          ?>
                          <input type="search" id="search" value="<?php echo $search;?>" class="form-control" placeholder="Search..." aria-label="Search" />
                        </div>
                      </div>
                    </div>
                    <div id="data">
                      <div class="report-box">
                          <div class="table-responsive">
                          <table class="table table-hover mb-0">
                            <thead>
                              <tr>
                                <th class="th-lg"></th>
                                <th class="th-lg">Date / Time</th>
                                <th class="th-lg"></th>
                                <th class="th-lg">Filename</th>
                                <th class="th-lg">Views</th>
                                <th class="th-lg">Sales</th>
                              </tr>
                            </thead>
                                  <!-- Table head -->
                                  <tbody id="file_list">
                                  <?php
                                  if(isset($_GET["page"])){ $page  = $_GET["page"]; } else{ $page=1; };
                                  $results_per_page = 10;
                                  $start_from = ($page-1) * $results_per_page;
                                  $ctype = '';
                                  if(isset($_GET["type"])){
                                    $name = $_GET["type"];
                                    $ctype = "and file_type LIKE '%$name%'";
                                  }
                                  $data_d = '';

                                  $sql = "Select * from sentfile where added_by = '" . $_SESSION["user"] . "' $ctype ORDER BY file_id DESC LIMIT $start_from,$results_per_page";
                                      $result = mysqli_query($con,$sql);
                                    if (mysqli_num_rows($result) > 0) { 
                                      while($fetch_data = mysqli_fetch_array($result)){
                                  ?>
                              <tr class="report-data">
                                <td><input type="checkbox" name="file_ids[]" value="<?php echo $fetch_data["file_id"];?>"></td>
                                <td class="date" width="220"><?php echo date_format(date_create($fetch_data["date_time"]),"H:i:s m/d/Y");?></td>
                                <td class="link_icon">
                                    <a href="edit-file.php?id=<?php echo $fetch_data["file_id"];?>">
                                    <svg xmlns="http://www.w3.org/2000/svg" height="30px" viewBox="0 0 24 24" width="30px" fill="#ffffff"><path d="M0 0h24v24H0z" fill="none"/><path d="M3.9 12c0-1.71 1.39-3.1 3.1-3.1h4V7H7c-2.76 0-5 2.24-5 5s2.24 5 5 5h4v-1.9H7c-1.71 0-3.1-1.39-3.1-3.1zM8 13h8v-2H8v2zm9-6h-4v1.9h4c1.71 0 3.1 1.39 3.1 3.1s-1.39 3.1-3.1 3.1h-4V17h4c2.76 0 5-2.24 5-5s-2.24-5-5-5z"/></svg>
                                    </a>

                                </td>
                                <?php
                                $imgurl = str_replace('contentshare.me', 'shareio.com', $fetch_data['file_thumbnail']); 
                                if($fetch_data['file_type'] == 'video/mp4' || $file_data['file_type'] == 'video/webm'){
                                ?>
                                <td class="file file_name"><a href="edit-file.php?id=<?php echo $fetch_data["file_id"];?>" class="thumb_preview" data-url="<?php echo $fetch_data['file_url'];?>#t=5" data-type="video">
                                  <?php echo $fetch_data['file_name'];?></a>
                                </td>
                                <?php }else{ ?>
                                <td class="file"><a href="edit-file.php?id=<?php echo $fetch_data["file_id"];?>" class="thumb_preview" data-url="<?php echo $imgurl;?>" data-type="image">
                                  <?php echo $fetch_data['file_name'];?></a>
                                </td>
                                <?php }?>

                                <td class="file">
                                  <?php 
                                  $view_sql = "SELECT COUNT(log_id) as total from cs_log where fileid = '" . $fetch_data['file_id'] . "'";
                                      $view_result = mysqli_query($con,$view_sql);
                                    if (mysqli_num_rows($view_result) > 0) { 
                                      while($fetch_total = mysqli_fetch_array($view_result)){
                                        echo $fetch_total['total'];
                                      }
                                    } else{
                                        echo "-";
                                    }
                                  ?>

                                </td>
                                
                                <td class="file">
                                  
                                  <?php 
                                  $sales_sql = "SELECT SUM(transfer_amount) as total from payments where file_id = '" . $fetch_data['file_id'] . "'";
                                      $sale_result = mysqli_query($con,$sales_sql);
                                    if (mysqli_num_rows($sale_result) > 0) { 
                                      while($sale_result_fetch_total = mysqli_fetch_array($sale_result)){
                                        echo number_format($sale_result_fetch_total['total']);
                                      }
                                    } else{
                                        echo "-";
                                    }
                                  ?>
                                </td>
                              
                              </tr>                          
                            
                              <?php }
                              } else{
                                $data_d = 'No Data';
                                ?>
                                <tr class="report-data no_found">
                                  <td colspan="6">No Data Found.</td>
                                </tr>
                              <?php }?>
                            </tbody>
                          </table>
                          </div>
                      </div>

                      <div class="row" id="pagination">
                        <div class ="col-md-12">

                          <?php
                          $type = '';
                          if(isset($_GET['type'])){
                          $type = $_GET['type'];
                          }
                          $sqlrecords = "SELECT COUNT(file_id) as total from sentfile where added_by = '" . $_SESSION["user"] . "' $ctype";
                          $resultrecords = $con->query($sqlrecords);
                          $rowrecords = $resultrecords->fetch_assoc();
                          $total_records = $rowrecords["total"] ;  
                          ?>
                          <p style="display:none;">1 of 10 showing from <?php echo $total_records; ?> total.</p>
                        </div>
                        <div class ="col-md-12">
                          <a id="upload_files" class="upload_files" href="dashboard.php?s=1">Upload file</a>
                          <a class="delete-selected files-delete" data-type="File" style="display: none;">Delete</a>
                          <div class="pagination justify-content-end">
                              <div class="page-list">
                                <?php 
                                $start_from = ($page-1) * $results_per_page;    
                                $c = 0;
                                $sql = "Select * from sentfile where added_by = '" . $_SESSION["user"] . "' $ctype";
                                $result = $con->query($sql);
                                while ( $row = $result->fetch_assoc()) {
                                $c++;
                                }

                                  $total_pages = ceil($c / $results_per_page);
                                  if($total_pages > 1 ){ echo '<div class="page-label" >Pages :</div>'; 

                                  if ($page <4){
                                    if ($total_pages<9)
                                    {
                                        for($i = 1; $i <=  $total_pages; $i++)
                                        {

                                            if ($i == $page)
                                            {
                                            $sel= "pager selected"; 
                                  echo "<a class='".$sel."' href='reports.php?page=".$i."&&type=".$type."'>".$i."</a>";    
                                            } else { 
                                            $sel= "pager"; 
                                  echo "<a class='".$sel."' href='reports.php?page=".$i."&&type=".$type."'>".$i."</a>";    
                                            }
                                        }
                                    }
                                    else
                                    {
                                        for($i = 1; $i <=  9; $i++)
                                        {

                                            if ($i == $page)
                                            { 
                                              $sel= "pager selected"; 
                                  echo "<a class='".$sel."' href='reports.php?page=".$i."&&type=".$type."'>".$i."</a>";    
                                            } else { 
                                            $sel= "pager"; 
                                  echo "<a class='".$sel."' href='reports.php?page=".$i."&&type=".$type."'>".$i."</a>";    
                                            }
                                        }
                                    }
                                  }
                                  elseif ($page >$total_pages-4)
                                  {
                                    if ($total_pages<9)
                                    {
                                        for($i = 1; $i <=  $total_pages; $i++){

                                            if ($i == $page){ 
                                            $sel= "pager selected"; 
                                  echo "<a class='".$sel."' href='reports.php?page=".$i."&&type=".$type."'>".$i."</a>";    
                                            } else { 
                                            $sel= "pager"; 
                                  echo "<a class='".$sel."' href='reports.php?page=".$i."&&type=".$type."'>".$i."</a>";    
                                            }
                                        }
                                    }else{
                                        for($i = $total_pages-8; $i <=  $total_pages; $i++){

                                            if ($i == $page){ 
                                            $sel= "pager selected"; 
                                  echo "<a class='".$sel."' href='reports.php?page=".$i."&&type=".$type."'>".$i."</a>";    
                                            } else { 
                                            $sel= "pager"; 
                                  echo "<a class='".$sel."' href='reports.php?page=".$i."&&type=".$type."'>".$i."</a>";    
                                              }
                                        }
                                    }

                                  }else{
                                    for($i = max(1, $page - 4); $i <= min($page + 4, $total_pages); $i++){

                                        if ($i == $page){
                                          $sel= "pager selected"; 
                                  echo "<a class='".$sel."' href='reports.php?page=".$i."&&type=".$type."'>".$i."</a>";    
                                          } else { 
                                          $sel= "pager"; 
                                  echo "<a class='".$sel."' href='reports.php?page=".$i."&&type=".$type."'>".$i."</a>";    
                                            }
                                    }
                                  }
                                }
                                  ?>
                                  <?php if($data_d == ''){?>
                                  <a class="refresh" id="refresh" style="cursor: pointer;">
                                    <svg fill="#adadad" xmlns="http://www.w3.org/2000/svg" width="48" height="48" viewBox="0 0 48 48">
                                        <path d="M35.3 12.7c-2.89-2.9-6.88-4.7-11.3-4.7-8.84 0-15.98 7.16-15.98 16s7.14 16 15.98 16c7.45 0 13.69-5.1 15.46-12h-4.16c-1.65 4.66-6.07 8-11.3 8-6.63 0-12-5.37-12-12s5.37-12 12-12c3.31 0 6.28 1.38 8.45 3.55l-6.45 6.45h14v-14l-4.7 4.7z"/>
                                        <path d="M0 0h48v48h-48z" fill="none"/>
                                    </svg>
                                  </a>
                                <?php }?>
                              </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="reports2" style="display:none">
                    
                    <div id="data">
                      <div class="report-box">
                          <div class="table-responsive">
                          <table class="table table-hover mb-0">
                            <thead>
                              <tr>
                                <th class="th-lg"></th>
                                <th class="th-lg">Date / Time</th>
                                <th class="th-lg"></th>
                                <th class="th-lg">Package Name</th>
                                <th class="th-lg">Views</th>
                                <th class="th-lg">Sales</th>
                              </tr>
                            </thead>
                                  <!-- Table head -->
                                  <tbody id="package_list">
                              <?php
                                $pkgsql = "Select * from package_list where user_id = '" . $_SESSION["user"] . "' ORDER BY pkg_id DESC";
                                      $pgkresult = mysqli_query($con,$pkgsql);
                                    if (mysqli_num_rows($pgkresult) > 0) { 
                                  while($pkgfetch_data = mysqli_fetch_array($pgkresult)){
                              ?>
                              <tr class="report-data">
                                <td><input type="checkbox" name="package_ids[]" value="<?php echo $pkgfetch_data["pkg_id"];?>"></td>
                                <td class="date" width="220"><?php echo date_format(date_create($pkgfetch_data["pkg_created_date"]),"H:i:s m/d/Y");?></td>
                                <td>
                                    <a href="EditPackage.php?pkgid=<?php echo $pkgfetch_data["pkg_id"];?>">
                                    <svg xmlns="http://www.w3.org/2000/svg" height="30px" viewBox="0 0 24 24" width="30px" fill="#ffffff"><path d="M0 0h24v24H0z" fill="none"/><path d="M3.9 12c0-1.71 1.39-3.1 3.1-3.1h4V7H7c-2.76 0-5 2.24-5 5s2.24 5 5 5h4v-1.9H7c-1.71 0-3.1-1.39-3.1-3.1zM8 13h8v-2H8v2zm9-6h-4v1.9h4c1.71 0 3.1 1.39 3.1 3.1s-1.39 3.1-3.1 3.1h-4V17h4c2.76 0 5-2.24 5-5s-2.24-5-5-5z"/></svg>
                                    </a>

                                </td>
                                <?php /* <td class="span3 url"><a style="text-decoration: none;" onclick="preview_image(<?php echo $fetch_data["file_id"];?>);" id="getcontent" data-toggle="modal" data-target="#edit-price-modal" data-id="<?php echo $fetch_data["file_id"];?>" >Contentshare/<?php echo $fetch_data['file_hash'];?> </a></td> */?>
                                <td class="file"><a href="EditPackage.php?pkgid=<?php echo $pkgfetch_data["pkg_id"];?>">
                                  <?php echo $pkgfetch_data["pkg_name"];?></a>
                                </td><!-- edit-file.php?id=<?php //echo $fetch_data['file_id'];?> -->
                                <td class="file">-</td>
                                <td class="file">-</td>
                              </tr>
                             <?php }
                              } else{
                                $data_d = 'No Data';
                                ?>
                                <tr class="report-data no_found">
                                  <td colspan="6">No Data Found.</td>
                                </tr>
                              <?php }?>                          
                            </tbody>
                          </table>
                          </div>
                      </div>

                      <div class="row" id="pagination">
                        <div class ="col-md-12">

                          <?php
                          $type = '';
                          if(isset($_GET['type'])){
                          $type = $_GET['type'];
                          }
                          $sqlrecords = "SELECT COUNT(pkg_id) as total from package_list where user_id = '" . $_SESSION["user"] . "'";
                          $resultrecords = $con->query($sqlrecords);
                          $rowrecords = $resultrecords->fetch_assoc();
                          $total_records = $rowrecords["total"] ;  
                          ?>
                          <p style="display:none;">1 of 10 showing from <?php echo $total_records; ?> total.</p>
                        </div>
                        <div class ="col-md-12">
                          <a id="create_package" class="create_package" href="AddPackage.php">Create package</a>
                          <a class="delete-selected packages-delete" data-type="Package" style="display: none;">Delete</a>
                          <div class="pagination justify-content-end">
                              <div class="page-list">
                                <?php 
                                $start_from = ($page-1) * $results_per_page;    
                                $c = 0;
                                $sql = "Select * from package_list where user_id = '" . $_SESSION["user"] . "'";
                                $result = $con->query($sql);
                                while ( $row = $result->fetch_assoc()) {
                                $c++;
                                }

                                  $total_pages = ceil($c / $results_per_page);
                                  if($total_pages > 1 ){ echo '<div class="page-label" >Pages :</div>'; 

                                  if ($page <4){
                                    if ($total_pages<9)
                                    {
                                        for($i = 1; $i <=  $total_pages; $i++)
                                        {

                                            if ($i == $page)
                                            {
                                            $sel= "pager selected"; 
                                  echo "<a class='".$sel."' href='reports.php?p=1&&page=".$i."&&type=".$type."'>".$i."</a>";    
                                            } else { 
                                            $sel= "pager"; 
                                  echo "<a class='".$sel."' href='reports.php?p=1&&page=".$i."&&type=".$type."'>".$i."</a>";    
                                            }
                                        }
                                    }
                                    else
                                    {
                                        for($i = 1; $i <=  9; $i++)
                                        {

                                            if ($i == $page)
                                            { 
                                              $sel= "pager selected"; 
                                  echo "<a class='".$sel."' href='reports.php?p=1&&page=".$i."&&type=".$type."'>".$i."</a>";    
                                            } else { 
                                            $sel= "pager"; 
                                  echo "<a class='".$sel."' href='reports.php?p=1&&page=".$i."&&type=".$type."'>".$i."</a>";    
                                            }
                                        }
                                    }
                                  }
                                  elseif ($page >$total_pages-4)
                                  {
                                    if ($total_pages<9)
                                    {
                                        for($i = 1; $i <=  $total_pages; $i++){

                                            if ($i == $page){ 
                                            $sel= "pager selected"; 
                                  echo "<a class='".$sel."' href='reports.php?p=1&&page=".$i."&&type=".$type."'>".$i."</a>";    
                                            } else { 
                                            $sel= "pager"; 
                                  echo "<a class='".$sel."' href='reports.php?p=1&&page=".$i."&&type=".$type."'>".$i."</a>";    
                                            }
                                        }
                                    }else{
                                        for($i = $total_pages-8; $i <=  $total_pages; $i++){

                                            if ($i == $page){ 
                                            $sel= "pager selected"; 
                                  echo "<a class='".$sel."' href='reports.php?p=1&&page=".$i."&&type=".$type."'>".$i."</a>";    
                                            } else { 
                                            $sel= "pager"; 
                                  echo "<a class='".$sel."' href='reports.php?p=1&&page=".$i."&&type=".$type."'>".$i."</a>";    
                                              }
                                        }
                                    }

                                  }else{
                                    for($i = max(1, $page - 4); $i <= min($page + 4, $total_pages); $i++){

                                        if ($i == $page){
                                          $sel= "pager selected"; 
                                  echo "<a class='".$sel."' href='reports.php?p=1&&page=".$i."&&type=".$type."'>".$i."</a>";    
                                          } else { 
                                          $sel= "pager"; 
                                  echo "<a class='".$sel."' href='reports.php?p=1&&page=".$i."&&type=".$type."'>".$i."</a>";    
                                            }
                                    }
                                  }
                                }
                                  ?>
                                  <?php if($data_d == ''){?>
                                  <a class="refresh" id="refresh" style="cursor: pointer;display:none;">
                                    <svg fill="#adadad" xmlns="http://www.w3.org/2000/svg" width="48" height="48" viewBox="0 0 48 48">
                                        <path d="M35.3 12.7c-2.89-2.9-6.88-4.7-11.3-4.7-8.84 0-15.98 7.16-15.98 16s7.14 16 15.98 16c7.45 0 13.69-5.1 15.46-12h-4.16c-1.65 4.66-6.07 8-11.3 8-6.63 0-12-5.37-12-12s5.37-12 12-12c3.31 0 6.28 1.38 8.45 3.55l-6.45 6.45h14v-14l-4.7 4.7z"/>
                                        <path d="M0 0h48v48h-48z" fill="none"/>
                                    </svg>
                                  </a>
                                <?php }?>
                              </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="reports3" style="display:none"> 
                    <div id="dashboarddata">
                      <div class="report-box">
                          <div class="table-responsive">
                          <table class="table table-hover mb-0">
                            <thead>
                              <tr>
                                <th class="th-lg"></th>
                                <th class="th-lg">Date / Time</th>
                                <th class="th-lg"></th>
                                <th class="th-lg">Dashboard</th>
                                <th class="th-lg">Views</th>
                              </tr>
                            </thead>
                            <tbody id="dashboard_list">
                              <?php
                                $page = '';
                                if(isset($_GET["page"])){ $page  = $_GET["page"]; } else{ $page=1; };
                                $results_per_page = 10;
                                $start_from = ($page-1) * $results_per_page;
                                $dashboardsql = "Select * from user_dashboard where user_id = '" . $_SESSION["user"] . "' ORDER BY us_dash_id DESC LIMIT $start_from,$results_per_page";
                                $dashboardresult = mysqli_query($con,$dashboardsql);
                                if (mysqli_num_rows($dashboardresult) > 0) { 
                                  while($dashboardfetch_data = mysqli_fetch_array($dashboardresult)){
                              ?>
                              <tr class="report-data">
                                <td><input type="checkbox" name="dashboard_ids[]" value="<?php echo $dashboardfetch_data["us_dash_id"];?>"></td>
                                <td class="date" width="220"><?php echo date_format(date_create($dashboardfetch_data["created_date"]),"H:i:s m/d/Y");?></td>
                                <td>
                                    <a href="EditDashboard.php?id=<?php echo $dashboardfetch_data["us_dash_id"];?>">
                                    <svg xmlns="http://www.w3.org/2000/svg" height="30px" viewBox="0 0 24 24" width="30px" fill="#ffffff"><path d="M0 0h24v24H0z" fill="none"/><path d="M3.9 12c0-1.71 1.39-3.1 3.1-3.1h4V7H7c-2.76 0-5 2.24-5 5s2.24 5 5 5h4v-1.9H7c-1.71 0-3.1-1.39-3.1-3.1zM8 13h8v-2H8v2zm9-6h-4v1.9h4c1.71 0 3.1 1.39 3.1 3.1s-1.39 3.1-3.1 3.1h-4V17h4c2.76 0 5-2.24 5-5s-2.24-5-5-5z"/></svg>
                                    </a>

                                </td>
                                <?php /* <td class="span3 url"><a style="text-decoration: none;" onclick="preview_image(<?php echo $fetch_data["file_id"];?>);" id="getcontent" data-toggle="modal" data-target="#edit-price-modal" data-id="<?php echo $fetch_data["file_id"];?>" >Contentshare/<?php echo $fetch_data['file_hash'];?> </a></td> */?>
                                <td class="file"><a href="EditDashboard.php?id=<?php echo $dashboardfetch_data["us_dash_id"];?>">
                                  <?php echo $dashboardfetch_data["dashboard_name"];?></a>
                                </td><!-- edit-file.php?id=<?php //echo $fetch_data['file_id'];?> -->
                                <td class="file">-</td>
                              </tr>
                              <?php }
                              } else{
                                $data_d = 'No Data';
                                ?>
                                <tr class="report-data no_found">
                                  <td colspan="6">No Data Found.</td>
                                </tr>
                              <?php }?>                           
                            </tbody>
                          </table>
                          </div>
                      </div>
                      <div class="row" id="pagination">
                        <div class ="col-md-12">

                          <?php
                          $type = '';
                          if(isset($_GET['type'])){
                          $type = $_GET['type'];
                          }
                          $sqlrecords = "SELECT COUNT(us_dash_id ) as total from user_dashboard where user_id = '" . $_SESSION["user"] . "'";
                          $resultrecords = $con->query($sqlrecords);
                          $rowrecords = $resultrecords->fetch_assoc();
                          $total_records = $rowrecords["total"] ;  
                          ?>
                          <p style="display:none;">1 of 10 showing from <?php echo $total_records; ?> total.</p>
                        </div>
                        <div class ="col-md-12">
                          <a id="create_package" class="create_package" href="UserCustomDashboard.php">Create dashboard</a>
                          <a class="delete-selected dashboards-delete" data-type="Dashboard" style="display: none;">Delete</a>
                          <div class="pagination justify-content-end">
                              <div class="page-list">
                                <?php 
                                $start_from = ($page-1) * $results_per_page;    
                                $c = 0;
                                $sql = "Select * from user_dashboard where user_id = '" . $_SESSION["user"] . "'";
                                $result = $con->query($sql);
                                while ( $row = $result->fetch_assoc()) {
                                $c++;
                                }

                                  $total_pages = ceil($c / $results_per_page);
                                  if($total_pages > 1 ){ echo '<div class="page-label" >Pages :</div>'; 

                                  if ($page <4){
                                    if ($total_pages<9)
                                    {
                                        for($i = 1; $i <=  $total_pages; $i++)
                                        {

                                            if ($i == $page)
                                            {
                                            $sel= "pager selected"; 
                                  echo "<a class='".$sel."' href='reports.php?d=1&&page=".$i."&&type=".$type."'>".$i."</a>";    
                                            } else { 
                                            $sel= "pager"; 
                                  echo "<a class='".$sel."' href='reports.php?d=1&&page=".$i."&&type=".$type."'>".$i."</a>";    
                                            }
                                        }
                                    }
                                    else
                                    {
                                        for($i = 1; $i <=  9; $i++)
                                        {

                                            if ($i == $page)
                                            { 
                                              $sel= "pager selected"; 
                                  echo "<a class='".$sel."' href='reports.php?d=1&&page=".$i."&&type=".$type."'>".$i."</a>";    
                                            } else { 
                                            $sel= "pager"; 
                                  echo "<a class='".$sel."' href='reports.php?d=1&&page=".$i."&&type=".$type."'>".$i."</a>";    
                                            }
                                        }
                                    }
                                  }
                                  elseif ($page >$total_pages-4)
                                  {
                                    if ($total_pages<9)
                                    {
                                        for($i = 1; $i <=  $total_pages; $i++){

                                            if ($i == $page){ 
                                            $sel= "pager selected"; 
                                  echo "<a class='".$sel."' href='reports.php?d=1&&page=".$i."&&type=".$type."'>".$i."</a>";    
                                            } else { 
                                            $sel= "pager"; 
                                  echo "<a class='".$sel."' href='reports.php?d=1&&page=".$i."&&type=".$type."'>".$i."</a>";    
                                            }
                                        }
                                    }else{
                                        for($i = $total_pages-8; $i <=  $total_pages; $i++){

                                            if ($i == $page){ 
                                            $sel= "pager selected"; 
                                  echo "<a class='".$sel."' href='reports.php?d=1&&page=".$i."&&type=".$type."'>".$i."</a>";    
                                            } else { 
                                            $sel= "pager"; 
                                  echo "<a class='".$sel."' href='reports.php?d=1&&page=".$i."&&type=".$type."'>".$i."</a>";    
                                              }
                                        }
                                    }

                                  }else{
                                    for($i = max(1, $page - 4); $i <= min($page + 4, $total_pages); $i++){

                                        if ($i == $page){
                                          $sel= "pager selected"; 
                                  echo "<a class='".$sel."' href='reports.php?d=1&&page=".$i."&&type=".$type."'>".$i."</a>";    
                                          } else { 
                                          $sel= "pager"; 
                                  echo "<a class='".$sel."' href='reports.php?d=1&&page=".$i."&&type=".$type."'>".$i."</a>";    
                                            }
                                    }
                                  }
                                }
                                  ?>
                                  <?php if($data_d == ''){?>
                                  <a class="refresh" id="refresh" style="cursor: pointer;display:none;">
                                    <svg fill="#adadad" xmlns="http://www.w3.org/2000/svg" width="48" height="48" viewBox="0 0 48 48">
                                        <path d="M35.3 12.7c-2.89-2.9-6.88-4.7-11.3-4.7-8.84 0-15.98 7.16-15.98 16s7.14 16 15.98 16c7.45 0 13.69-5.1 15.46-12h-4.16c-1.65 4.66-6.07 8-11.3 8-6.63 0-12-5.37-12-12s5.37-12 12-12c3.31 0 6.28 1.38 8.45 3.55l-6.45 6.45h14v-14l-4.7 4.7z"/>
                                        <path d="M0 0h48v48h-48z" fill="none"/>
                                    </svg>
                                  </a>
                                <?php }?>
                              </div>
                          </div>
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
		<?php require('footer-new.php'); ?>
		
		
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
  <script>
    jQuery(document).ready(function($) {
      $( ".main_content" ).removeClass("hidden");
        $("#search").keyup(function() {
            var name = $('#search').val();
            var type = <?php echo json_encode($type);?>;
            var url = "search-report.php?search="+name+"&&type="+type;            
            $.ajax({
                type: "POST",
                url: url,
                data: {
                  search: name,
                  type:type
                },
                success: function(html) {
                  $("#data").html(html);
                }
              });
          });
      });

    jQuery(document).ready(function($) {
        $("#refresh").on('click', function() {
            var user = <?php echo json_encode($_SESSION["user"]);?>;
            var start_from = <?php echo json_encode($start_from);?>;
            var results_per_page = <?php echo json_encode($results_per_page);?>;
            var url = "include/getAllfiledata.php?user="+user;            
            $.ajax({
                type: "POST",
                url: url,
                data: {
                  user: user,
                  start_from:start_from,
                  results_per_page:results_per_page
                },
                success: function(html) {
                  $('table tbody#file_list').replaceWith(html);  
                }
              });
          });
      });

    $('.delete-selected').on('click', function(){
      var type = $(this).data('type');
      if(type == "File"){
          cuteAlert({
              type: "question",
              title: "Delete",
              message: "Do you wish to delete selected Files?",
              confirmText: "Yes, delete it!",
              cancelText: "Cancel"
          }).then((e)=>{
            if ( e == ("confirm")){
                var ids = [];
                $('input[name="file_ids[]"]:checked').each(function() {
                    ids.push(this.value);
                });
                $.ajax({
                    type: "POST",
                    url: "include/MultipleContentDelete.php",
                    data:{
                        ids:ids
                    },
                    success: function(res){ 
                        if(res.replace(/\s/g, "") == 'error'){
                          cuteAlert({
                            type: "error",
                            title: "Oops...",
                            message: "There is some issue please try again.",
                            buttonText: "Close"
                          })
                        } else {
                          window.location = 'reports.php';
                        }          
                    }
                });
            }
          })
      } else if(type == "Package"){
          cuteAlert({
              type: "question",
              title: "Delete",
              message: "Do you wish to delete selected Packages?",
              confirmText: "Yes, delete it!",
              cancelText: "Cancel"
          }).then((e)=>{
            if ( e == ("confirm")){
                  var ids = [];
                  $('input[name="package_ids[]"]:checked').each(function() {
                      ids.push(this.value);
                  });
                  $.ajax({
                      type: "POST",
                      url: "include/MultipleContentDelete.php",
                      data:{
                          package:'package',
                          ids:ids
                      },
                      success: function(res){ 
                          if(res.replace(/\s/g, "") == 'error'){
                            cuteAlert({
                              type: "error",
                              title: "Oops...",
                              message: "There is some issue please try again.",
                              buttonText: "Close"
                            })
                          } else {
                            window.location = 'reports.php?p=1';
                          }          
                      }
                  });
              }
          })
      } else{
          cuteAlert({
              type: "question",
              title: "Delete",
              message: "Do you wish to delete selected Dashboards?",
              confirmText: "Yes, delete it!",
              cancelText: "Cancel"
          }).then((e)=>{
              if ( e == ("confirm")){
                  var ids = [];
                  $('input[name="dashboard_ids[]"]:checked').each(function() {
                      ids.push(this.value);
                  });
                  $.ajax({
                      type: "POST",
                      url: "include/MultipleContentDelete.php",
                      data:{
                          dahsboard:'dahsboard',
                          ids:ids
                      },
                      success: function(res){ 
                          if(res.replace(/\s/g, "") == 'error'){
                            cuteAlert({
                              type: "error",
                              title: "Oops...",
                              message: "There is some issue please try again.",
                              buttonText: "Close"
                            })
                          } else {
                            window.location = 'reports.php?d=1';
                          }          
                      }
                  });
              }
          })
      }
    });

    $('input[name="file_ids[]"]').on('click', function(){
        if($('input[name="file_ids[]"]:checked').length > 0){
          $('.delete-selected.files-delete').show();
        } else {
          $('.delete-selected.files-delete').hide();
        }
    });

    $('input[name="package_ids[]"]').on('click', function(){
        if($('input[name="package_ids[]"]:checked').length > 0){
          $('.delete-selected.packages-delete').show();
        } else {
          $('.delete-selected.packages-delete').hide();
        }
    });

    $('input[name="dashboard_ids[]"]').on('click', function(){
        if($('input[name="dashboard_ids[]"]:checked').length > 0){
          $('.delete-selected.dashboards-delete').show();
        } else {
          $('.delete-selected.dashboards-delete').hide();
        }
    });

    jQuery('#type').change(function(){
      if(jQuery(this).val() != ''){
        window.location.href = "reports.php?type="+jQuery(this).val();
      }else{
        window.location.href = "reports.php";
      }   
    });

    function file_tab(){
      $('.reports1').show();
      $('.reports2').hide();
      $('.reports3').hide();
      $(".top_default_icons .description_icon a").addClass("active");
      $(".top_default_icons .setting a").removeClass("active");
      $(".top_default_icons .dashboard a").removeClass("active");
    }

    function package_tab(){
      $('.reports2').show();
      $('.reports1').hide();
      $('.reports3').hide();
      $(".top_default_icons .description_icon a").removeClass("active");
      $(".top_default_icons .setting a").addClass("active");
      $(".top_default_icons .dashboard a").removeClass("active");
    }

    function dashboard_tab(){
      $('.reports3').show();
      $('.reports2').hide();
      $('.reports1').hide();
      $(".top_default_icons .description_icon a").removeClass("active");
      $(".top_default_icons .setting a").removeClass("active");
      $(".top_default_icons .dashboard a").addClass("active");
    }


    $(document).ready(function() {
      ShowImagePreview();
    });
    // Configuration of the x and y offsets
    function ShowImagePreview() {
    xOffset = -20;
    yOffset = 40;

    $("a.thumb_preview").hover(function(e) {
            var url = $(this).data('url');
            var type = $(this).data('type');
            if(type == 'video'){
              $("body").append("<p id='preview'><video src='"+url+"' style='width:100%;height:100%'></video></p>");
            } else{
              $("body").append("<p id='preview'><img src='"+url+"' alt='Image preview' style='width:100%;height:100%' /></p>");
            }
            

            var left = getLeft(e,$(this));
            var top = getTop(e,$(this));

            $("#preview")
            .css("top", (top) + "px")
            .css("left", (left) + "px")
            .fadeIn("slow");
        },
        function() {
            $("#preview").remove();
    });

    $("a.preview").mousemove(function(e) {

        var left = getLeft(e,$(this));
        var top = getTop(e,$(this));

        $("#preview")
        .css("top", (top) + "px")
        .css("left", (left) + "px");
        });

    };

    function getLeft(e,obj){
        var left = e.pageX + yOffset;
        var prevWidth = $("#preview").width();
        if((left+prevWidth +50) > $(document).width())
        {
            left = $(obj).offset().left - yOffset - prevWidth;
        }
        return left;
    }

    function getTop(e,obj){
        var top = e.pageY - xOffset;
        var prevHeigth = $("#preview").height();
        if((top+prevHeigth +50) > $(document).height())
        {
            top = $(obj).offset().top - xOffset - prevHeigth;
        }
        return top;
    }
    
  </script>
	</body>

</html>