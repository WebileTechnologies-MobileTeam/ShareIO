<!DOCTYPE html>
<?php
session_start();

ini_set('display_errors', 0);
if(!isset($_SESSION['user']) && empty($_SESSION['user'])){  
  header("Location: dashboard.php");
}
include_once('./include/inc/defined_variables.php');
?>
<html lang="en">
<title>User Admin - ShareIO</title>

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
		<?php require('header-new.php'); 
		?>
		<main>
			<div class="container new_container">
				<div class="row">
					<div class="col-md-12">
						<div class="main_content hidden">
                                                      
                            <div class="upload_content_bg user_admin_section">
                                <div class="top_default_icons">
                                  <span class="user_admin_title">User Admin</span>
                                    <div class="icons close_icon">
                                        <a href="dashboard.php">
                                           <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 0 24 24" width="24px" fill="#000000"><path d="M0 0h24v24H0V0z" fill="none"></path><path d="M19 6.41L17.59 5 12 10.59 6.41 5 5 6.41 10.59 12 5 17.59 6.41 19 12 13.41 17.59 19 19 17.59 13.41 12 19 6.41z"></path>
                                           </svg>
                                        </a> 
                                    </div>
                                </div>
                                <form>
                                    <div class="user_admin_section_content_left">
                                        <div class="form-group user_list_field user_list_search">
                                            <label>User List:</label>
                                            <input type="text" id="search" class="form-control" placeholder="Search">
                                        </div>
                                        <div class="user_admin_viewer_list">
                                          <ul>
                                          <?php
                                          $userlistsql = "SELECT * FROM `cs_member`  LEFT JOIN cs_group_rlt_member ON cs_group_rlt_member.member_id = cs_member.cs_member_id WHERE FIND_IN_SET('".$_SESSION['user']."',added_by) ORDER BY member_email ASC";
                                          $userlistresult = mysqli_query($con,$userlistsql);
                                          while($userlist_data = mysqli_fetch_array($userlistresult)){ 
                                          		if($userlist_data['relation_id'] == ''){
                                          	?>
                                            <li data-id="<?php echo $userlist_data['cs_member_id'];?>">
                                              <input type="checkbox" name="viewer_list[]" value="<?php echo $userlist_data['cs_member_id'];?>"> 
                                              <span>
                                                <?php echo $userlist_data['member_email'];?>
                                              </span>
                                            </li>
                                          <?php }
                                      		}
                                          ?> 
                                          </ul>
                                        </div>
                                        <div class="custom-control user_list_field">
                                          <input type="text" id="user_add" class="form-control" placeholder="User Email">
                                          <a href="javascript:;" class="add_user"><i class="fa fa-plus" aria-hidden="true"></i></a>
                                          <a href="javascript:;" class="delete_user"><i class="fa fa-minus" aria-hidden="true"></i></a>
                                        </div>
                                    </div>
                                    <div class="user_admin_section_content_middle">
                                        <a href="javascript:;" class="user_admin_item_select_right_arrow">
                                          <i class="fa fa-angle-right"></i>
                                        </a>
                                        <a href="javascript:;" class="user_admin_item_select_left_arrow">
                                          <i class="fa fa-angle-left"></i>
                                        </a>
                                        
                                    </div>
                                    <div class="user_admin_section_content_right">
                                        <div class="form-group user_list_field">
                                          <select id="groups" class="form-control">
                                          	<?php
                      											$gruoplistsql = "SELECT * FROM `cs_groups` WHERE FIND_IN_SET('".$_SESSION['user']."',added_by) ORDER BY group_name ASC";
                      											$gruoplistresult = mysqli_query($con,$gruoplistsql);
                      											while($gruoplist_data = mysqli_fetch_array($gruoplistresult)){ ?>
	                                            <option><?php echo $gruoplist_data['group_name'];?></option>
                                        	<?php }?>
                                          </select>
                                          <input class="form-control group_list" name="group_list_input" id="group_list_input">

                                          <a href="javascript:;" class="add_group"><i class="fa fa-plus" aria-hidden="true"></i></a>
                                          <a href="javascript:;" class="delete_group"><i class="fa fa-minus" aria-hidden="true"></i></a>
                                        </div>
                                        <div class="activated_viewer_list">
											
                                        </div>
                                        <div class="user_admin_data_setting">
                                            <div class="users_button">
                                              <div class="users_file">
                                            	 <input type="file" id="userimport" name="userimport" class="form-control" accept=".csv" required />
                                               <label>Choose File</label>
                                              </div>
                                                <button type="button" class="import-users">Import User</button>
                                            </div>
                                            <a class="sample_import_file" href="<?php echo SITE_URL;?>/include/SampleFile-ShareIO-UserImport.csv" download>Sample Import File</a>
                                            <div class="text-center processbutton tooltip_shows" style="display: none;">
                                              <button type="submit" id="submit">
                                                  <svg xmlns="http://www.w3.org/2000/svg" version="1.2" viewBox="0 0 18 18" width="18" height="18">
                                                      <path id="Layer" class="s0" d="m-3-3h24v24h-24z"/>
                                                      <path id="Layer" fill-rule="evenodd" class="s1" d="m18 4v12c0 1.1-0.9 2-2 2h-14c-1.1 0-2-0.9-2-2v-14c0-1.1 0.9-2 2-2h12zm-6 9c0-1.7-1.3-3-3-3c-1.7 0-3 1.3-3 3c0 1.7 1.3 3 3 3c1.7 0 3-1.3 3-3zm0-11h-10v4h10z"/>
                                                  </svg>
                                              </button>
                                              <div class="left">
                                                  <span>Save</span>
                                              </div>
                                          </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
					    </div>
				    </div>
			    </div>
            </div>
		</main>
		<?php require('footer-new.php'); ?>
	</body>
<script>
  jQuery(document).ready(function($){
    $( ".main_content" ).removeClass("hidden");
    var group = $('#groups').val();
    $.ajax({
      type: "POST",
      url: 'include/UserDataAction.php',
      data: {
        group: group,
        action:'refreshusergroup'
      },
      success: function(html) {
        $(".activated_viewer_list").html(html);
      }
    });  

    $("#search").keyup(function() {
		var name = $('#search').val();
		var url = "include/UserDataAction.php";            
		$.ajax({
		    type: "POST",
		    url: url,
		    data: {
		      search: name,
		      action:'search'
		    },
		    success: function(html) {
		      $(".user_admin_viewer_list").html(html);
		    }
		});
	});

	$('.add_user').on('click', function(){
		var email = $('#user_add').val();
    if(email == ''){
        cuteAlert({
          type: "error",
          title: "Oops...",
          message: "Please Enter Email.",
          buttonText: "Close"
      })
    }
		var id = <?php echo json_encode($_SESSION["user"]);?>;
		$.ajax({
			type: "POST",
			url: 'include/UserDataAction.php',
			data: {
			id: id,
			email:email,
			action:'adduser'
			},
			success: function(resp) {
				if(resp == 'true'){
				  $('#user_add').val('');
				  refreshUsers('refreshuser');
				  cuteAlert({
				    type: "success",
				    title: "Thank You !",
				    message: "User added successfully.",
				    buttonText: "Close"
				  })
				} else if(resp == 'exist'){
          cuteAlert({
            type: "error",
            title: "Oops...",
            message: "User with the same email exist.",
            buttonText: "Close"
          })
        } else{
				  cuteAlert({
				    type: "error",
				    title: "Oops...",
				    message: "Something went wrong please try again.",
				    buttonText: "Close"
				  })
				}
			}
		});  
	});

    $('.delete_user').on('click', function(){
      cuteAlert({
          type: "question",
          title: "Delete",
          message: "Do you wish to delete selected Users?",
          confirmText: "Yes, delete it!",
          cancelText: "Cancel"
      }).then((e)=>{
        if ( e == ("confirm")){
            var ids = [];
            $('input[name="viewer_list[]"]:checked').each(function() {
                ids.push(this.value);
            });
            $.ajax({
                type: "POST",
                url: "include/UserDataAction.php",
                data:{
                    ids:ids,
                    action:'deleteuser'
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
                      refreshUsers('refreshuser');
                      cuteAlert({
                        type: "success",
                        title: "Success !",
                        message: "User deleted successfully.",
                        buttonText: "Close"
                      })
                    }          
                }
            });
        }
      })
    });

    $('.add_group').on('click', function(){
		var group = $('#group_list_input').val();
    var id = <?php echo json_encode($_SESSION["user"]);?>;
    if(group == ''){
        cuteAlert({
          type: "error",
          title: "Oops...",
          message: "Please Enter Group Name.",
          buttonText: "Close"
      })
    } else {
  		$.ajax({
  			type: "POST",
  			url: 'include/UserDataAction.php',
  			data: {
  			id: id,
  			groupName:group,
  			action:'addgroup'
  			},
  			success: function(resp) {
  				if(resp == 'true'){
  				  refreshGroups('refreshgroups');
  				  cuteAlert({
  				    type: "success",
  				    title: "Thank You !",
  				    message: "Group added successfully.",
  				    buttonText: "Close"
  				  })
            $('#group_list_input').val('');
  				} else if(resp == 'exist'){
  				  cuteAlert({
  				    type: "error",
  				    title: "Oops...",
  				    message: "Group with the same name exist.",
  				    buttonText: "Close"
  				  })
            $('#group_list_input').val('');
  				} else{
  				  cuteAlert({
  				    type: "error",
  				    title: "Oops...",
  				    message: "Something went wrong please try again.",
  				    buttonText: "Close"
  				  })
            $('#group_list_input').val('');
  				}
  			}
  		});  
    }
	});

	$('.delete_group').on('click', function(){
      cuteAlert({
          type: "question",
          title: "Delete",
          message: "Do you wish to delete selected Users?",
          confirmText: "Yes, delete it!",
          cancelText: "Cancel"
      }).then((e)=>{
        if ( e == ("confirm")){
            var group = $('#groups').val();
            $.ajax({
                type: "POST",
                url: "include/UserDataAction.php",
                data:{
                    group:group,
                    action:'deletegroup'
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
                      refreshGroups('refreshgroups');
                      $('#groups').val('');
                      $('#groups').change();
	                  refreshUsers('refreshuser');
                      cuteAlert({
                        type: "success",
                        title: "Success !",
                        message: "Group deleted successfully.",
                        buttonText: "Close"
                      })
                    }          
                }
            });
        }
      })
    });

    $('.user_admin_item_select_right_arrow').on('click', function(){
    	var ids = [];
        $('input[name="viewer_list[]"]:checked').each(function() {
            ids.push(this.value);
        });

        var group = $('#groups').val();
        if(group == ''){
        	cuteAlert({
				type: "error",
				title: "Oops...",
				message: "Please Select Group.",
				buttonText: "Close"
			})
        } else {
	        $.ajax({
	            type: "POST",
	            url: "include/UserDataAction.php",
	            data:{
	                group:group,
	                users:ids,
	                action:'addusertogroup'
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
	                  $('#groups').change();
	                  refreshUsers('refreshuser');
	                  cuteAlert({
	                    type: "success",
	                    title: "Success !",
	                    message: "Users Added to the group successfully.",
	                    buttonText: "Close"
	                  })
	                }          
	            }
	        });
	    }
    });

    $('.user_admin_item_select_left_arrow').on('click', function(){

    	if($('input[name="activated_viewer_list[]"]:checked').length > 0){
	    	var ids = [];
	        $('input[name="activated_viewer_list[]"]:checked').each(function() {
	            ids.push(this.value);
	        });

	        var group = $('#groups').val();
	        $.ajax({
	            type: "POST",
	            url: "include/UserDataAction.php",
	            data:{
	                group:group,
	                users:ids,
	                action:'removeusertogroup'
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
	                  $('#groups').change();
	                  refreshUsers('refreshuser');
	                  cuteAlert({
	                    type: "success",
	                    title: "Success !",
	                    message: "Users has been from the group successfully.",
	                    buttonText: "Close"
	                  })
	                }          
	            }
	        });
	    } else{
	    	cuteAlert({
				type: "error",
				title: "Oops...",
				message: "Please Select User.",
				buttonText: "Close"
			})
	    }
    });

    $('#groups').on('change', function(){
    	var group = $(this).val();
	    $.ajax({
	      type: "POST",
	      url: 'include/UserDataAction.php',
	      data: {
	        group: group,
	        action:'refreshusergroup'
	      },
	      success: function(html) {
	        $(".activated_viewer_list").html(html);
	      }
	    });  
    });

    $(document).on("click", ".import-users", function() {
    	var id = <?php echo json_encode($_SESSION["user"]);?>;
		var file_data = $("#userimport").prop("files")[0]; 
		var form_data = new FormData(); 
		form_data.append("file", file_data);
		form_data.append("id", id);
		form_data.append("action", "import");
		$.ajax({
			url: "include/UserDataAction.php", 
			dataType: 'script',
			cache: false,
			contentType: false,
			processData: false,
			data: form_data, 
			type: 'post',
			success: function(resp) {
				if(resp == 'true'){
				  $('#user_add').val('');
				  $('#userimport').val('');
				  refreshUsers('refreshuser');
				  cuteAlert({
				    type: "success",
				    title: "Thank You !",
				    message: "User added successfully.",
				    buttonText: "Close"
				  })
				} else{
				  cuteAlert({
				    type: "error",
				    title: "Oops...",
				    message: "Something went wrong please try again.",
				    buttonText: "Close"
				  })
				}
			}
		});
	});

  });

  function refreshUsers(type){
  	$("#search").val('');
    var id = <?php echo json_encode($_SESSION["user"]);?>;
    $.ajax({
      type: "POST",
      url: 'include/UserDataAction.php',
      data: {
        id: id,
        action:type
      },
      success: function(html) {
        $(".user_admin_viewer_list").html(html);
      }
    });  
  }

  function refreshGroups(type){
    var id = <?php echo json_encode($_SESSION["user"]);?>;
    $.ajax({
      type: "POST",
      url: 'include/UserDataAction.php',
      data: {
        id: id,
        action:type
      },
      success: function(html) {
        $("#groups").html(html);
      }
    });  
  }
  		
</script>
</html>