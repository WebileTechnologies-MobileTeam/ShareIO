<?php



// Generate The key at: https://account.live.com/developers/applications/create?tou=1

$client_id 		= '0000000040678D4F';
$client_secret 	= 'ewiPOCTU31}eswtWC858=*!';
$redirect_uri 	= 'https://contentshare.me/login.php';


$urls = 'https://login.live.com/oauth20_authorize.srf?client_id='.$client_id.'&scope=wl.signin%20wl.basic%20wl.emails%20wl.contacts_emails&response_type=code&redirect_uri='.$redirect_uri;


function curl_file_get_contents($url) {
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_AUTOREFERER, TRUE);
	curl_setopt($ch, CURLOPT_HEADER, 0);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($ch, CURLOPT_URL, $url);
	curl_setopt($ch, CURLOPT_FOLLOWLOCATION, TRUE);
	$data = curl_exec($ch);
	curl_close($ch);
	return $data;
}


$auth_code = $_GET["code"];

if($auth_code){
	$fields=array(
		'code'=>  urlencode($auth_code),
		'client_id'=>  urlencode($client_id),
		'client_secret'=>  urlencode($client_secret),
		'redirect_uri'=>  urlencode($redirect_uri),
		'grant_type'=>  urlencode('authorization_code')
	);

	$post = '';
	foreach($fields as $key=>$value) { $post .= $key.'='.$value.'&'; }
	$post = rtrim($post,'&');
	$curl = curl_init();
	curl_setopt($curl,CURLOPT_URL,'https://login.live.com/oauth20_token.srf');
	curl_setopt($curl,CURLOPT_POST,5);
	curl_setopt($curl,CURLOPT_POSTFIELDS,$post);
	curl_setopt($curl, CURLOPT_RETURNTRANSFER,TRUE);
	curl_setopt($curl, CURLOPT_SSL_VERIFYPEER,0);
	$result = curl_exec($curl);
	curl_close($curl);
	$response =  json_decode($result);
	$accesstoken = $response->access_token;
	//$accesstoken = $_SESSION['accesstoken'] ;//= $_GET['access_token'];
	$get_profile_url='https://apis.live.net/v5.0/me?access_token='.$accesstoken;
	$xmlprofile_res=curl_file_get_contents($get_profile_url);
	$profile_res = json_decode($xmlprofile_res, true);
	print_r($profile_res); exit;
	
	$userid 	= $profile_res['id'];
	$fname		= $profile_res['first_name'];
	$lname		= $profile_res['last_name'];
	$email		= $profile_res['emails']['account'];
	$loginwith	= "Hotmail";
	
	/*$sql = mysql_query("select userid from register where passcode='".$userid."'");
	$numrow = mysql_num_rows($sql);
	
	if($numrow > 0){
		header('Location:myaccount.php');
		exit();
	}*/

}



/*if($_POST['register']){

	$fname 		= mysql_real_escape_string($_POST['fname']);
	$lname 		= mysql_real_escape_string($_POST['lname']);
	$email 		= mysql_real_escape_string($_POST['email']);	
	$passcode	= mysql_real_escape_string($_POST['passcode']);
	$loginwith	= mysql_real_escape_string($_POST['loginwith']);
	$status 	= 'active';
	
	$mysql = mysql_query("insert into register set	fastname	=	'".$fname."', 
													lastname	=	'".$lname."',
													email		=	'".$email."',
													passcode	=	'".$passcode."',
													loginwith	=	'".$loginwith."',
													status		= 	'".$status."'");
	
	header('Location:myaccount.php');*/