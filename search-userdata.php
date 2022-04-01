<?php require('./include/db.php');
$name = $_POST['search'];
?>
<tbody id="user-data">
    <?php
    $sql = "SELECT * from cs_users where oauth_uid != '' and (fname LIKE '%$name%' or email LIKE '%$name%')";
    $result = mysqli_query($con,$sql);

    if (mysqli_num_rows($result) > 0) {
	    while($fetch_data = mysqli_fetch_array($result)){ ?>
	        <tr <?php if($fetch_data['is_blocked'] == '1'){?> class="is-blocked-user"<?php }?>>
	            <td style="background: unset;"><input type="checkbox" class="select_table_list" name="user_list[]" value="<?php echo $fetch_data['id'];?>"></td>
	            <td><span>
	                <?php if($fetch_data['email'] != ''){ 
	                    echo $fetch_data['email']; 
	                } else{
	                    echo $fetch_data['fname']; 
	                }?>
	                </span></td>
	            <td><span><?php echo $fetch_data['organization'];?></span></td>
	            <td><span><?php echo $fetch_data['create_date'];?></span></td>
	            <?php
	            $impressionssql = "SELECT SUM(file_impression.impression) as impression FROM `file_impression` LEFT JOIN sentfile ON sentfile.file_id = file_impression.file_id LEFT JOIN package_list ON package_list.pkg_id = file_impression.package_id LEFT JOIN user_dashboard ON user_dashboard.us_dash_id  = file_impression.dashboard_id WHERE sentfile.added_by = '".$fetch_data['oauth_uid']."' OR package_list.user_id = '".$fetch_data['oauth_uid']."' OR user_dashboard.user_id = '".$fetch_data['oauth_uid']."'";
                $impressionsresult = mysqli_query($con,$impressionssql);
                $impressions_data = mysqli_fetch_array($impressionsresult);
                                                            
	            $sharesql = "SELECT COUNT(file_id) as total from sentfile where added_by = '".$fetch_data['oauth_uid']."'";
	            $shareresult = mysqli_query($con,$sharesql);
	            $share_data = mysqli_fetch_array($shareresult);

	            $revenue = '';
	            $paymentsql = "SELECT SUM(payments.transfer_amount) as revenue FROM `payments` LEFT JOIN sentfile  ON sentfile.file_id = payments.file_id LEFT JOIN package_list ON package_list.pkg_id = payments.package_id WHERE sentfile.added_by = '".$fetch_data['oauth_uid']."' OR package_list.user_id = '".$fetch_data['oauth_uid']."'";
	            $paymentresult = mysqli_query($con,$paymentsql);
	            $payment_data = mysqli_fetch_array($paymentresult);

	            $flagsql = "SELECT SUM(like_count + flag_count) as total FROM `feedback` INNER JOIN sentfile on sentfile.file_id = feedback.fileid WHERE sentfile.added_by = '".$fetch_data['oauth_uid']."'";
                $flagresult = mysqli_query($con,$flagsql);
                $flag_data = mysqli_fetch_array($flagresult);
	            ?>
	            <td><span><?php echo $impressions_data['impression'];?></span></td>
	            <td><span><?php echo $share_data['total'];?></span></td>
	            <td><span><?php echo round($payment_data['revenue']);?></span></td>
	            <td><span><?php if($flag_data['total'] == ''){?>0<?php } else{ echo $flag_data['total']; }?></span></td>
	        </tr>
	    <?php }
	} else{?>
		<tr>
			<td colspan="8">No Data Found</td>
		</tr>
	<?php }?>
</tbody>