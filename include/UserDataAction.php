<?php
require('./db.php');
session_start();
$id = $_POST['id'];
$date = date('Y-m-d H:i:s');

if($_POST["action"] == 'search'){
	$name = $_POST['search'];
	$userlistsql = "SELECT * FROM `cs_member`  LEFT JOIN cs_group_rlt_member ON cs_group_rlt_member.member_id = cs_member.cs_member_id WHERE FIND_IN_SET('".$_SESSION['user']."',added_by) AND member_email LIKE '%$name%' ORDER BY member_email ASC";
	$userlistresult = mysqli_query($con,$userlistsql);
	echo "<ul>";
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
		} ?>
	</ul>
<?php
}

if($_POST["action"] == 'searchsettings'){
	$name = $_POST['search'];
	$ids = '';
	$filter = "AND member_email LIKE '%$name%' AND  cs_member_id NOT IN('".$ids."')";
	if(isset($_POST['ids'])){
		$ids = implode(',', $_POST['ids']);
		$filter = "AND member_email LIKE '%$name%' AND  cs_member_id NOT IN($ids)";
	}
	$userlistsql = "SELECT * FROM `cs_member` WHERE FIND_IN_SET('".$_SESSION['user']."',added_by) $filter ORDER BY member_email ASC";
	$userlistresult = mysqli_query($con,$userlistsql);
	echo "<ul id='view_user_list'>";
	while($userlist_data = mysqli_fetch_array($userlistresult)){ 
		?>
	<li data-id="<?php echo $userlist_data['cs_member_id'];?>">
      <input type="checkbox" name="viewer_list[]" value="<?php echo $userlist_data['cs_member_id'];?>"> 
      <span>
        <?php echo $userlist_data['member_email'];?>
      </span>
    </li>
	<?php } ?>
	</ul>
<?php
}

if($_POST["action"] == 'searchgroup'){
	$name = $_POST['search'];
	$ids = '';
	$filter = "AND group_name LIKE '%$name%' AND  group_id NOT IN('".$ids."')";
	if(isset($_POST['ids'])){
		$ids = implode(',', $_POST['ids']);
		$filter = "AND group_name LIKE '%$name%' AND  group_id NOT IN($ids)";
	}
	$grouplistsql = "SELECT * FROM `cs_groups` WHERE added_by = '".$_SESSION['user']."' $filter ORDER BY group_name ASC";
	$grouplistresult = mysqli_query($con,$grouplistsql);
	echo "<ul id='group_user_list'>";
	while($grouplist_data = mysqli_fetch_array($grouplistresult)){ 
		?>
	<li data-id="<?php echo $grouplist_data['group_id'];?>">
      <input type="checkbox" name="group_viewer_list[]" value="<?php echo $grouplist_data['group_id'];?>"> 
      <span>
        <?php echo $grouplist_data['group_name'];?>
      </span>
    </li>
	<?php } ?>
	</ul>
<?php
}

if($_POST["action"] == 'adduser'){
	$checkuser = "SELECT * FROM cs_member where member_email = '".$_POST["email"]."'";
	$checkuserresult = mysqli_query($con, $checkuser);
	if (mysqli_num_rows($checkuserresult) > 0) { 
		echo "exist";
	} else{
		$addusersql = "INSERT INTO cs_member(added_by,member_email,create_date) VALUES('".$id."', '".$_POST["email"]."', '".$date."')";
		$result = mysqli_query($con, $addusersql);
		if($result){
			echo "true";
		} else{
			echo "error";
		}
	}	
}

if($_POST["action"] == 'addgroup'){
	$checkgroup = "SELECT * FROM cs_groups where group_name = '".$_POST["groupName"]."'";
	$checkgroupresult = mysqli_query($con, $checkgroup);
	if (mysqli_num_rows($checkgroupresult) > 0) { 
		echo "exist";
	} else{
		$addgroupsql = "INSERT INTO cs_groups(added_by,group_name) VALUES('".$id."', '".$_POST["groupName"]."')";
		$result = mysqli_query($con, $addgroupsql);
		if($result){
			echo "true";
		} else{
			echo "error";
		}
	}
}

if($_POST["action"] == 'deleteuser'){
	$ids = implode(",", $_POST['ids']);
	$deleteusersql = "DELETE FROM cs_member where cs_member_id IN($ids)";
	$result = mysqli_query($con, $deleteusersql);
	if($result){
		echo "true";
	} else{
		echo "error";
	}
}

if($_POST["action"] == 'deletegroup'){
	$group = $_POST['group'];
	$deletegroupsql = "DELETE FROM cs_groups where group_name = '".$group."'";
	$result = mysqli_query($con, $deletegroupsql);

	$removeusertogroup = "DELETE FROM cs_group_rlt_member where group_name = '".$_POST["group"]."'";
	$result = mysqli_query($con, $removeusertogroup);
	if($result){
		echo "true";
	} else{
		echo "error";
	}
}

if($_POST["action"] == 'refreshuser'){
	$userlistsql = "SELECT * FROM `cs_member`  LEFT JOIN cs_group_rlt_member ON cs_group_rlt_member.member_id = cs_member.cs_member_id WHERE FIND_IN_SET('".$_SESSION['user']."',added_by) ORDER BY member_email ASC";
	$userlistresult = mysqli_query($con,$userlistsql);
	echo "<ul>";
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
		} ?>
	</ul>
<?php
}

if($_POST["action"] == 'refreshgroups'){
	$gruoplistsql = "SELECT * FROM `cs_groups` WHERE added_by = '".$_SESSION['user']."' ORDER BY group_name ASC";
	$gruoplistresult = mysqli_query($con,$gruoplistsql);
	while($gruoplist_data = mysqli_fetch_array($gruoplistresult)){ ?>
	    <option><?php echo $gruoplist_data['group_name'];?></option>
<?php }
}

if($_POST["action"] == 'addusertogroup'){
	$ids = $_POST['users'];
	$total_user = sizeof($ids);
	$status = 0;
	foreach ($ids as $id) {
		$addusertogroup = "INSERT INTO cs_group_rlt_member(member_id,group_name) VALUES('".$id."', '".$_POST["group"]."')";
		$result = mysqli_query($con, $addusertogroup);
		if($result){
			$status = $status + 1;
		}	
	}

	if($total_user == $status){
		echo "true";
	} else{
		echo "error";
	}
}

if($_POST["action"] == 'removeusertogroup'){
	$ids = $_POST['users'];
	$total_user = sizeof($ids);
	$status = 0;
	foreach ($ids as $id) {
		$removeusertogroup = "DELETE FROM cs_group_rlt_member where member_id = '".$id."' AND group_name = '".$_POST["group"]."'";
		$result = mysqli_query($con, $removeusertogroup);
		if($result){
			$status = $status + 1;
		}	
	}

	if($total_user == $status){
		echo "true";
	} else{
		echo "error";
	}
}


if($_POST["action"] == 'refreshusergroup'){
	$userlistsql = "SELECT * FROM `cs_group_rlt_member` INNER JOIN cs_member ON cs_member.cs_member_id = cs_group_rlt_member.member_id WHERE group_name = '".$_POST['group']."' ORDER BY member_email ASC";
	$userlistresult = mysqli_query($con,$userlistsql);?>
	<ul>
	<?php
	while($userlist_data = mysqli_fetch_array($userlistresult)){ ?>
		<li data-id="<?php echo $userlist_data['cs_member_id '];?>">
			<input type="checkbox" name="activated_viewer_list[]" value="<?php echo $userlist_data['cs_member_id'];?>">
			<span><?php echo $userlist_data['member_email']?></span>
		</li>
<?php } ?>
	</ul>
<?php
}


if($_POST['action'] == 'import'){
	$fileHandle = fopen($_FILES["file"]["tmp_name"], "r");
	$i = 0;
	$status = 1;
	while(($row = fgetcsv($fileHandle, 0, ",")) !== FALSE){
		if($i > 0){
			
			$email = mysqli_escape_string($con,$row[0]);
			
			if($email != '' ){
				$checkusersql = "SELECT * FROM `cs_member` WHERE member_email = '".$email."'";
				$result = mysqli_query($con,$checkusersql);
				if (mysqli_num_rows($result) > 0) { 
					$status = $status + 1;
				} else{
					$addusersql = "INSERT INTO cs_member(added_by,member_email,create_date) VALUES('".$_POST['id']."', '".$email."', '".$date."')";
					$result = mysqli_query($con, $addusersql);
					if($result){
						$status = $status + 1;
					}
				}
			}
		}
		$i++;
	}
	if($status == $i){
		echo "true";
	} else{
		echo "error";
	}

}