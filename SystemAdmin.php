<!DOCTYPE html>
<?php
session_start();

ini_set('display_errors', 0);
if(!isset($_SESSION['user']) && empty($_SESSION['user'])){  
  header("Location: dashboard.php");
}
include_once('./include/inc/defined_variables.php');
require_once './vendor/stripe/stripe-php/init.php'; 
\Stripe\Stripe::setApiKey(STRIPE_API_KEY);

if(!class_exists('S3'))require_once('./include/S3Bucket_config.php');

$upload = 'err'; 

$image_path = 'test';
    

define('AWS_S3_KEY', 'AKIAU3PF3ROQZWVWZAE7');

define('AWS_S3_SECRET', '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');

define('AWS_S3_REGION', 'us-east-2');

define('AWS_S3_BUCKET', 'contentshare-files');

define('AWS_S3_URL', 'http://s3.'.AWS_S3_REGION.'.amazonaws.com/'.AWS_S3_BUCKET.'/');

S3::setAuth(AWS_S3_KEY, AWS_S3_SECRET);

(new S3)->setRegion(AWS_S3_REGION);

S3::setSignatureVersion('v4');
?>
<html lang="en">
<title>System Admin - ShareIO</title>

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
                                                      
                            <div class="upload_content_bg system_admin_section">
                                <div class="top_default_icons">
                                    <div class="icons user_icon tooltip_shows">
                                        <a onclick="user_tab()" href="javascript:;" class="active">
                                            <svg id="Layer_1" data-name="Layer 1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 122.88 114.37"><defs><style>.cls-1{fill-rule:evenodd;}</style></defs><title>manage</title><path class="cls-1" d="M0,105.3C0,65.76,37.33,87.65,40.17,63.42c.31-2.64-5.91-9.61-7.34-14.43-3-4.87-4.15-12.6-.81-17.74,1.33-2.05.77-7.44.77-10.25,0-28,49.05-28,49.05,0,0,3.54-.82,8,1.11,10.76C86.17,36.42,84.5,44.67,81.79,49,80.06,54.05,73.44,60.55,74,63.42a15.9,15.9,0,0,0,2.82,6.74l-.48.47a8.54,8.54,0,0,0-1.84,2.73l-.12.31a8.22,8.22,0,0,0-.54,2.93,8.42,8.42,0,0,0,.68,3.28l.27.57a10.13,10.13,0,0,0-1.26.39,8.65,8.65,0,0,0-4.63,4.63l-.2.59a8.34,8.34,0,0,0-.42,2.61V94a8.23,8.23,0,0,0,.65,3.22l.24.52a8.69,8.69,0,0,0,1.51,2.13l.14.14a8.52,8.52,0,0,0,2.64,1.79l.67.24a6.94,6.94,0,0,0-.57,1.08,8.29,8.29,0,0,0-.62,2.14ZM115.16,75a2.16,2.16,0,0,0-1.55-.65,2.12,2.12,0,0,0-1.55.65L109.7,77.4a16.2,16.2,0,0,0-2-1.09,20.57,20.57,0,0,0-2.14-.83V71.86a2.17,2.17,0,0,0-2.18-2.19H98.83a2.12,2.12,0,0,0-1.53.64,2.09,2.09,0,0,0-.65,1.55v3.31a16.48,16.48,0,0,0-2.2.68,15.72,15.72,0,0,0-2,.94L89.8,74.21a2,2,0,0,0-1.51-.65,2.14,2.14,0,0,0-1.55.65L83.56,77.4a2.15,2.15,0,0,0,0,3.1l2.35,2.36a15.33,15.33,0,0,0-1.08,2A21.56,21.56,0,0,0,84,87H80.37a2.15,2.15,0,0,0-2.18,2.18v4.55a2.19,2.19,0,0,0,2.18,2.17h3.32a15.6,15.6,0,0,0,.67,2.2,20.6,20.6,0,0,0,.94,2.08l-2.58,2.57a2,2,0,0,0-.65,1.51,2.12,2.12,0,0,0,.65,1.55L85.91,109a2.2,2.2,0,0,0,1.55.61A2.17,2.17,0,0,0,89,109l2.36-2.4a16.2,16.2,0,0,0,2,1.09,21.31,21.31,0,0,0,2.13.83v3.62a2.19,2.19,0,0,0,2.19,2.19h4.54a2.12,2.12,0,0,0,1.53-.64,2.09,2.09,0,0,0,.65-1.55v-3.31a16.48,16.48,0,0,0,2.2-.68,21.65,21.65,0,0,0,2.08-.94l2.57,2.58a2,2,0,0,0,1.52.65,2,2,0,0,0,1.54-.65l3.22-3.19a2.19,2.19,0,0,0,.62-1.55,2.15,2.15,0,0,0-.62-1.55l-2.39-2.36a15.33,15.33,0,0,0,1.08-2,21.56,21.56,0,0,0,.84-2.14h3.62a2.15,2.15,0,0,0,2.18-2.18V90.31a2.13,2.13,0,0,0-.63-1.52,2.07,2.07,0,0,0-1.55-.65h-3.32a19.5,19.5,0,0,0-.67-2.18,16.93,16.93,0,0,0-.94-2.06l2.57-2.61a2,2,0,0,0,.66-1.52,2.11,2.11,0,0,0-.66-1.54L115.16,75Zm-14.63,8.08a8.89,8.89,0,0,1,3.48.69,8.81,8.81,0,0,1,4.73,4.74,9,9,0,0,1,0,6.94,8.81,8.81,0,0,1-4.73,4.74,9.1,9.1,0,0,1-7,0,8.81,8.81,0,0,1-4.73-4.74,9,9,0,0,1,0-6.94,8.81,8.81,0,0,1,4.73-4.74,8.88,8.88,0,0,1,3.47-.69Z"/></svg>
                                        </a>
                                        <div class="top">
                                            <span>Users Setting</span> 
                                        </div>
                                    </div>
                                    <div class="icons setting tooltip_shows">
                                      <a onclick="system_tab()" href="javascript:;">
                                        <svg version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" width="122.88px" height="95.089px" viewBox="0 0 122.88 95.089" enable-background="new 0 0 122.88 95.089" xml:space="preserve"><g><path d="M66.605,9.676c-0.791-0.791-1.718-1.181-2.792-1.181c-1.073,0-2.013,0.39-2.791,1.181l-4.255,4.241 c-1.141-0.738-2.348-1.383-3.61-1.96c-1.261-0.577-2.55-1.072-3.852-1.502V3.931c0-1.1-0.375-2.026-1.141-2.791 C47.401,0.375,46.475,0,45.374,0h-8.187c-1.047,0-1.958,0.375-2.75,1.14c-0.778,0.765-1.168,1.691-1.168,2.791v5.973 c-1.368,0.321-2.697,0.724-3.973,1.221c-1.287,0.496-2.508,1.061-3.663,1.691l-4.711-4.644c-0.738-0.778-1.637-1.181-2.724-1.181 c-1.075,0-2,0.403-2.792,1.181l-5.73,5.745c-0.791,0.791-1.181,1.718-1.181,2.79c0,1.074,0.39,2.014,1.181,2.792l4.242,4.255 c-0.738,1.14-1.382,2.348-1.959,3.608c-0.578,1.262-1.073,2.552-1.504,3.853H3.933c-1.102,0-2.028,0.375-2.792,1.14 C0.376,33.121,0,34.047,0,35.148v8.187c0,1.045,0.376,1.959,1.14,2.751c0.764,0.777,1.691,1.167,2.792,1.167h5.971 c0.322,1.367,0.724,2.696,1.222,3.971c0.498,1.289,1.061,2.537,1.691,3.744l-4.644,4.63c-0.779,0.739-1.181,1.638-1.181,2.726 c0,1.073,0.402,2,1.181,2.792l5.745,5.811c0.791,0.738,1.717,1.102,2.792,1.102c1.072,0,2.011-0.363,2.791-1.102l4.254-4.321 c1.14,0.737,2.349,1.381,3.61,1.96c1.262,0.575,2.55,1.073,3.852,1.502v6.523c0,1.1,0.376,2.025,1.14,2.789 c0.765,0.767,1.692,1.143,2.792,1.143h8.186c1.047,0,1.959-0.376,2.751-1.143c0.777-0.764,1.167-1.689,1.167-2.789v-5.973 c1.369-0.321,2.697-0.724,3.972-1.222c1.289-0.496,2.538-1.061,3.744-1.691l4.63,4.645c0.739,0.778,1.65,1.181,2.753,1.181 c1.112,0,2.025-0.402,2.765-1.181l5.811-5.744c0.738-0.793,1.102-1.719,1.102-2.792s-0.363-2.013-1.102-2.791l-4.321-4.255 c0.738-1.141,1.382-2.348,1.96-3.609c0.575-1.261,1.072-2.551,1.502-3.852h6.523c1.1,0,2.025-0.378,2.789-1.141 c0.766-0.766,1.142-1.691,1.142-2.792v-8.186c0-1.047-0.376-1.958-1.142-2.752c-0.764-0.778-1.689-1.167-2.789-1.167h-5.973 c-0.322-1.315-0.725-2.63-1.222-3.931c-0.496-1.316-1.061-2.55-1.691-3.706l4.645-4.709c0.778-0.738,1.181-1.638,1.181-2.724 c0-1.075-0.402-2-1.181-2.792L66.605,9.676L66.605,9.676z M111.918,53.649c-0.506-0.355-1.044-0.479-1.627-0.376 c-0.583,0.101-1.057,0.401-1.401,0.904l-1.908,2.702c-0.688-0.292-1.402-0.526-2.144-0.721c-0.737-0.194-1.484-0.343-2.231-0.451 l-0.616-3.538c-0.105-0.596-0.395-1.063-0.884-1.406c-0.486-0.343-1.024-0.459-1.621-0.354l-4.441,0.774 c-0.566,0.099-1.025,0.39-1.383,0.879c-0.35,0.487-0.475,1.027-0.369,1.625l0.564,3.238c-0.713,0.303-1.395,0.648-2.037,1.038 c-0.654,0.392-1.263,0.812-1.828,1.264l-2.995-2.073c-0.476-0.352-0.999-0.484-1.59-0.383c-0.583,0.103-1.046,0.407-1.402,0.904 l-2.564,3.659c-0.354,0.504-0.479,1.044-0.377,1.623c0.102,0.585,0.402,1.057,0.905,1.404l2.703,1.907 c-0.292,0.687-0.527,1.402-0.721,2.144c-0.195,0.738-0.343,1.484-0.452,2.231l-3.538,0.616c-0.596,0.104-1.063,0.396-1.406,0.884 c-0.344,0.486-0.458,1.025-0.354,1.621l0.773,4.441c0.099,0.566,0.388,1.026,0.88,1.383c0.487,0.35,1.027,0.474,1.624,0.369 l3.239-0.564c0.304,0.713,0.648,1.394,1.038,2.039c0.392,0.652,0.815,1.274,1.272,1.869l-2.081,2.952 c-0.353,0.475-0.485,0.999-0.383,1.59c0.102,0.583,0.406,1.047,0.904,1.402l3.665,2.607c0.499,0.325,1.036,0.436,1.618,0.334 c0.583-0.101,1.059-0.389,1.41-0.862l1.899-2.746c0.688,0.293,1.403,0.528,2.144,0.721c0.738,0.194,1.484,0.343,2.23,0.45 l0.618,3.54c0.104,0.597,0.396,1.063,0.883,1.404c0.486,0.344,1.025,0.46,1.621,0.356l4.439-0.775 c0.569-0.1,1.028-0.389,1.386-0.879c0.349-0.488,0.474-1.025,0.368-1.624l-0.565-3.241c0.713-0.303,1.396-0.646,2.04-1.037 c0.651-0.393,1.274-0.814,1.87-1.27l2.951,2.081c0.475,0.352,1.008,0.483,1.604,0.378c0.604-0.104,1.061-0.409,1.388-0.901 l2.609-3.665c0.324-0.5,0.435-1.036,0.332-1.618c-0.101-0.583-0.387-1.059-0.86-1.41l-2.748-1.899 c0.294-0.688,0.528-1.403,0.722-2.144c0.194-0.738,0.342-1.484,0.452-2.232l3.537-0.616c0.597-0.104,1.063-0.394,1.405-0.883 c0.344-0.488,0.459-1.024,0.355-1.621l-0.775-4.441c-0.099-0.567-0.389-1.025-0.879-1.384c-0.487-0.351-1.027-0.473-1.624-0.369 l-3.239,0.565c-0.299-0.684-0.642-1.358-1.035-2.017c-0.395-0.667-0.816-1.283-1.267-1.85l2.074-2.995 c0.353-0.475,0.484-0.998,0.38-1.59c-0.101-0.583-0.405-1.045-0.904-1.401L111.918,53.649L111.918,53.649z M99.16,64.929 c1.071-0.188,2.118-0.162,3.147,0.075c1.025,0.246,1.953,0.657,2.777,1.231c0.825,0.582,1.523,1.316,2.101,2.198 c0.573,0.889,0.95,1.865,1.139,2.936c0.187,1.072,0.16,2.119-0.076,3.15c-0.246,1.023-0.655,1.949-1.233,2.776 c-0.582,0.823-1.314,1.522-2.196,2.1c-0.889,0.573-1.865,0.951-2.937,1.139c-1.07,0.186-2.117,0.159-3.148-0.077 c-1.025-0.246-1.95-0.655-2.777-1.232c-0.822-0.582-1.522-1.314-2.1-2.196c-0.572-0.889-0.952-1.866-1.138-2.937 c-0.188-1.07-0.162-2.117,0.075-3.148c0.246-1.025,0.657-1.951,1.231-2.778c0.583-0.821,1.316-1.521,2.198-2.099 C97.114,65.494,98.09,65.116,99.16,64.929L99.16,64.929z M40.262,24.224c2.201,0,4.28,0.417,6.252,1.248 c1.961,0.846,3.666,1.986,5.115,3.421c1.435,1.449,2.575,3.156,3.421,5.113c0.833,1.973,1.248,4.054,1.248,6.254 c0,2.201-0.415,4.282-1.248,6.254c-0.846,1.959-1.986,3.666-3.421,5.115c-1.449,1.436-3.154,2.575-5.115,3.421 c-1.972,0.833-4.051,1.248-6.252,1.248s-4.282-0.415-6.255-1.248c-1.958-0.846-3.664-1.985-5.112-3.421 c-1.437-1.449-2.577-3.155-3.423-5.115c-0.831-1.972-1.248-4.053-1.248-6.254c0-2.2,0.417-4.281,1.248-6.254 c0.846-1.958,1.986-3.664,3.423-5.113c1.448-1.435,3.154-2.576,5.112-3.421C35.979,24.641,38.061,24.224,40.262,24.224 L40.262,24.224z"/></g></svg>
                                      </a>
                                      <div class="top">
                                        <span>System Setting</span> 
                                      </div>
                                    </div>
                                    <div class="icons close_icon">
                                        <a href="dashboard.php">
                                           <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 0 24 24" width="24px" fill="#000000"><path d="M0 0h24v24H0V0z" fill="none"></path><path d="M19 6.41L17.59 5 12 10.59 6.41 5 5 6.41 10.59 12 5 17.59 6.41 19 12 13.41 17.59 19 19 17.59 13.41 12 19 6.41z"></path>
                                           </svg>
                                        </a> 
                                    </div>
                                </div>
                                <form>
                                    <div class="system_admin_section_content_left">
                                        <div class="form-group user_list_field">
                                            <label>User List:</label>
                                            <input type="text" id="search" class="form-control" placeholder="Search">
                                        </div>
                                        <div class="table-responsive system_admin_table">
                                            <table class="table" cellpadding="0" cellspacing="5" border="0">
                                                <thead>
                                                    <tr>
                                                        <th></th>
                                                        <th><span>USERNAME</span></th>
                                                        <th><span>ORG</span></th>
                                                        <th><span>JOIN</span></th>
                                                        <th><span>IMPRESSIONS</span></th>
                                                        <th><span>SHARES</span></th>
                                                        <th><span>REVENUE</span></th>
                                                        <th><span>FLAGS</span></th>
                                                    </tr>
                                                </thead>
                                                <tbody id="user-data">
                                                    <?php
                                                    $sql = "SELECT * from cs_users where oauth_uid != ''";
                                                    $result = mysqli_query($con,$sql);
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

                                                            $flagsql = "SELECT SUM(flag_count) as flagtotal, SUM(like_count) as liketotal FROM `feedback` INNER JOIN sentfile on sentfile.file_id = feedback.fileid WHERE sentfile.added_by = '".$fetch_data['oauth_uid']."'";
                                                            $flagresult = mysqli_query($con,$flagsql);
                                                            $flag_data = mysqli_fetch_array($flagresult);
                                                            $flagsum = $flag_data['flagtotal'] + $flag_data['liketotal'];
                                                            if($flagsum == ''){
                                                              $flagsum = 0;
                                                            } 
                                                            ?>
                                                            <td><span><?php echo $impressions_data['impression'];?></span></td>
                                                            <td><span><?php echo $share_data['total'];?></span></td>
                                                            <td><span><?php echo round($payment_data['revenue']);?></span></td>
                                                            <td><span><?php echo $flagsum;?></span></td>
                                                        </tr>
                                                    <?php }?>
                                                </tbody>
                                            </table>
                                        </div>
                                        <div class="custom-control custom-checkbox custom-control-inline block_new_signup">
                                          <input type="checkbox" class="custom-control-input" id="block_new_signup" name="block_new_signup" value="1" onchange="saveSystemData()">
                                          <label class="custom-control-label" for="block_new_signup">Block new signups</label>
                                        </div>
                                        <div class="users_button">
                                            <button type="button" class="delete-selected">Delete User</button>
                                            <button type="button" class="block-selected">Block</button>
                                            <button type="button" class="unblock-selected">Unblock</button>

                                        </div>
                                    </div>
                                    <div class="system_admin_section_content_right" style="display: none;">
                                        <label class="system_details_title">System Details :</label>
                                        <div class="system_data">
                                            <div class="system_admin_totalling_list">
                                            	<?php
                                            	$allsharesql = "SELECT COUNT(file_id) as total from sentfile";
                                                $allshareresult = mysqli_query($con,$allsharesql);
                                                $allshare_data = mysqli_fetch_array($allshareresult);

                                                $allimpressionssql = "SELECT SUM(impression) as total FROM `file_impression`";
                                                $allimpressionsresult = mysqli_query($con,$allimpressionssql);
                                                $allimpressions_data = mysqli_fetch_array($allimpressionsresult);

                                                $allsalessql = "SELECT COUNT(id) as total from payments";
                                                $allsalesresult = mysqli_query($con,$allsalessql);
                                                $allsales_data = mysqli_fetch_array($allsalesresult);

                                                $revenuesql = "SELECT SUM(amount) as totalamount FROM `payments` WHERE transfer_amount != ''";
                                                $revenueresult = mysqli_query($con,$revenuesql);
                                                $revenue_data = mysqli_fetch_array($revenueresult);
                                                $totalrevenue = $revenue_data['totalamount'];

                                                $user = "SELECT COUNT(id) as user from cs_users where oauth_uid != ''";
                                                $user_results = mysqli_query($con,$user);
                                                $user_filedata = mysqli_fetch_array($user_results);

                                                $bucket = (new S3)->getBucket(AWS_S3_BUCKET);
                          											$size = '';
                          											foreach ($bucket as $value) {
                          											    if($value['size'] > 0){
                          											        $size = $size + $value['size'];
                          											    }
                          											}
                          											$totalsize = formatSizeUnits($size);
                                            	?>
                                                <p>Users = <span><?php echo number_format($user_filedata['user']);?></span></p>
                                                <p>Total Shares = <span><?php echo $allshare_data['total'];?></span></p>
                                                <p>Total Impressions = <span><?php echo number_format($allimpressions_data['total']);?></span></p>
                                                <p>Sales = <span><?php echo $allsales_data['total'];?></span></p>
                                                <p>Revenue = <span><?php echo '$'.number_format($totalrevenue,2);?></span></p>
                                                <p>DataTransfer = <span><?php echo $totalsize;?></span></p>
                                            </div>
                                        </div>
                                        <?php
                                        $systemsql = "SELECT * FROM `system_data` WHERE system_id = '1'";
                                        $systemresult = mysqli_query($con,$systemsql);
                                        $system_data = mysqli_fetch_array($systemresult);
                                        ?>
                                        <div class="system_admin_data_setting">
                                            <div class="form-group row impression_cost">
                                                <label class="col-sm-6 col-form-label">Impression Cost($):</label>
                                                <div class="col-sm-6 cost_field">
                                                    <input type="text" class="form-control" name="impression_cost" id="impression_cost" value="<?php echo $system_data['impression_cost_per_1k'];?>">
                                                </div>
                                            </div>
                                            <div class="form-group row sales_commision">
                                                <label class="col-sm-6 col-form-label">Sales Commision(%):</label>
                                                <div class="col-sm-6 cost_field">
                                                    <input type="text" class="form-control" name="sales_commision" id="sales_commision" value="<?php echo $system_data['sales_commision'];?>">
                                                </div>
                                            </div>
                                            <a onclick="saveSystemData()" class="btn btn-save">Save</a>
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

      $("#search").keyup(function() {
  			var name = $('#search').val();
  			var url = "search-userdata.php";            
  			$.ajax({
  			    type: "POST",
  			    url: url,
  			    data: {
  			      search: name
  			    },
  			    success: function(html) {
  			      $("#user-data").replaceWith(html);
  			    }
  			});
  		});

  		$('.delete-selected').on('click', function(){
  			var type = $(this).data('type');
  			  cuteAlert({
  			      type: "question",
  			      title: "Delete",
  			      message: "Do you wish to delete selected Users?",
  			      confirmText: "Yes, delete!",
  			      cancelText: "Cancel"
  			  }).then((e)=>{
  			    if ( e == ("confirm")){
  			        var ids = [];
  			        $('input[name="user_list[]"]:checked').each(function() {
  			            ids.push(this.value);
  			        });
  			        $.ajax({
  			            type: "POST",
  			            url: "include/SystemDataActions.php",
  			            data:{
  			            	action:'delete',
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
  			                	var name = $('#search').val();
  								var url = "search-userdata.php";            
  								$.ajax({
  								    type: "POST",
  								    url: url,
  								    data: {
  								      search: name
  								    },
  								    success: function(html) {
  								      $("#user-data").replaceWith(html);
  								    }
  								});
  								cuteAlert({
  									type: "success",
  									title: "Thank You !",
  									message: res,
  									buttonText: "Close"
  								})
  			                }          
  			            }
  			        });
  			    }
  			  })
  		});

  		$('.block-selected').on('click', function(){
  			var type = $(this).data('type');
  			  cuteAlert({
  			      type: "question",
  			      title: "Delete",
  			      message: "Do you wish to block selected Users?",
  			      confirmText: "Yes, block!",
  			      cancelText: "Cancel"
  			  }).then((e)=>{
  			    if ( e == ("confirm")){
  			        var ids = [];
  			        $('input[name="user_list[]"]:checked').each(function() {
  			            ids.push(this.value);
  			        });
  			        $.ajax({
  			            type: "POST",
  			            url: "include/SystemDataActions.php",
  			            data:{
  			            	action:'block',
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
  			                	var name = $('#search').val();
          								var url = "search-userdata.php";            
          								$.ajax({
          								    type: "POST",
          								    url: url,
          								    data: {
          								      search: name
          								    },
          								    success: function(html) {
          								      $("#user-data").replaceWith(html);
          								    }
          								});
          								cuteAlert({
          									type: "success",
          									title: "Thank You !",
          									message: res,
          									buttonText: "Close"
          								})
  			                }          
  			            }
  			        });
  			    }
  			  })
  		});

  		$('.unblock-selected').on('click', function(){
  			var type = $(this).data('type');
  			  cuteAlert({
  			      type: "question",
  			      title: "Delete",
  			      message: "Do you wish to unblock selected Users?",
  			      confirmText: "Yes, unblock!",
  			      cancelText: "Cancel"
  			  }).then((e)=>{
  			    if ( e == ("confirm")){
  			        var ids = [];
  			        $('input[name="user_list[]"]:checked').each(function() {
  			            ids.push(this.value);
  			        });
  			        $.ajax({
  			            type: "POST",
  			            url: "include/SystemDataActions.php",
  			            data:{
  			            	action:'unblock',
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
  			                	var name = $('#search').val();
  								var url = "search-userdata.php";            
  								$.ajax({
  								    type: "POST",
  								    url: url,
  								    data: {
  								      search: name
  								    },
  								    success: function(html) {
  								      $("#user-data").replaceWith(html);
  								    }
  								});
  								cuteAlert({
  									type: "success",
  									title: "Thank You !",
  									message: res,
  									buttonText: "Close"
  								})
  			                }          
  			            }
  			        });
  			    }
  			  })
  		});
    });

    function user_tab(){
        $('.system_admin_section_content_left').show();
        $('.system_admin_section_content_right').hide();
        $(".top_default_icons .user_icon a").addClass("active");
        $(".top_default_icons .setting a").removeClass("active");
    }

    function system_tab(){
        $('.system_admin_section_content_right').show();
        $('.system_admin_section_content_left').hide();
        $(".top_default_icons .user_icon a").removeClass("active");
        $(".top_default_icons .setting a").addClass("active");
    }

    function saveSystemData(){
    	var impressionCost = $('#impression_cost').val();
    	var salesCommision = $('#sales_commision').val();
    	var newSignups = 0;
    	if($('#block_new_signup').is(':checked')){
		    newSignups = 1;
    	}

      	$.ajax({
    		type: "POST",
    		url: "include/SaveSystemData.php",
    		data:{
    			impressionCost:impressionCost,
    			salesCommision:salesCommision,
    			newSignups:newSignups
    		},
    		success: function(resp){ 
    			if(resp == 'true'){
    			    cuteAlert({
    					type: "success",
    					title: "Thank You !",
    					message: "System data is saved.",
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
    }
</script>
</html>