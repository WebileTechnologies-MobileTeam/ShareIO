<?php

//config.php

//Include Google Client Library for PHP autoload file
require_once 'vendor/autoload.php';

//Make object of Google API Client for call Google API
$google_client = new Google_Client();

//Set the OAuth 2.0 Client ID
$google_client->setClientId('747030329023-bqdmr63b5us6msdeld12mutuelsrha4j.apps.googleusercontent.com');

//Set the OAuth 2.0 Client Secret key
$google_client->setClientSecret('aaMMFu5Rc931m5a2g1bELpZe');

//Set the OAuth 2.0 Redirect URI
$google_client->setRedirectUri('https://shareio.com/google_login.php');

//
$google_client->addScope('email');

$google_client->addScope('profile');

//start session on web page
//session_start();

?>