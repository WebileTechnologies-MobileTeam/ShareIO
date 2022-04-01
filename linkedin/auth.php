<?php

/**

 * linkedin-client

 * index.php

 *

 * PHP Version 5

 *

 * @category Production

 * @package  Default

 * @author   Philipp Tkachev <philipp@zoonman.com>

 * @date     8/17/17 22:47

 * @license  http://zoonman.com/license.txt linkedin-client License

 * @version  GIT: 1.0

 * @link     http://zoonman.com/projects/linkedin-client

 */



// add Composer autoloader
if(isset($_SESSION['memberlogin']) && $_SERVER['REQUEST_URI'] != '/dashboard.php'){
	if(isset($_SESSION['member_audio_file'])){
		require_once '../../vendor/autoload.php';
	} else{
		require_once '../vendor/autoload.php'; 
	}
} else{
	require_once './vendor/autoload.php'; 
}



// import client class

use LinkedIn\Client;

use LinkedIn\Scope;



// import environment variables from the environment file

// you need a .env file in the parent folder

// read this document to learn how to create that file

// https://github.com/zoonman/linkedin-api-php-client/blob/master/examples/README.md

//

//$dotenv = new Dotenv\Dotenv(dirname(__DIR__));

//$dotenv->load();



// we need a session to keep intermediate results

// you can use your own session persistence management

// client doesn't depend on it



// instantiate the Linkedin client

// you can setup keys using

$client = new Client(

    '86nwqcsyypia1f',

    'vL9wOC5YBAXr7lad'

);



$scopes = [

    'r_liteprofile',

    'r_emailaddress',

];

$loginUrl = $client->getLoginUrl($scopes); // get url on LinkedIn to start linking

$_SESSION['state'] = $client->getState(); // save state for future validation

$_SESSION['redirect_url'] = $client->getRedirectUrl(); // save redirect url for future validation

//echo 'LoginUrl: <a href="'.$loginUrl.'">' . $loginUrl. '</a>';

