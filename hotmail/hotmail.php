<?php

if(isset($_SESSION['memberlogin']) && $_SERVER['PHP_SELF'] != '/dashboard.php'){
	if(isset($_SESSION['member_audio_file'])){
		require_once '../../vendor/stripe/stripe-php/init.php'; 
	} else{
		require_once '../vendor/stripe/stripe-php/init.php'; 
	}
} else{
	require_once './vendor/stripe/stripe-php/init.php'; 
}

// Generate The key at: https://account.live.com/developers/applications/create?tou=1



$client_id 		= '0000000040678D4F';

$client_secret 	= 'ewiPOCTU31}eswtWC858=*!';

$redirect_uri 	= 'https://shareio.com/hotmail/callback.php';

$accesstoken = '';



$urls = 'https://login.live.com/oauth20_authorize.srf?client_id='.$client_id.'&scope=wl.signin%20wl.basic%20wl.emails%20wl.contacts_emails&response_type=code&redirect_uri='.$redirect_uri;



