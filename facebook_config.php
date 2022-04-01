<?php



require_once 'vendor/autoload.php';



if (!session_id())

{

    session_start();

}



// Call Facebook API



$facebook = new \Facebook\Facebook([

  'app_id'      => '664545274758449',

  'app_secret'     => '6cba7a46bf950b789f8f7106122b7341',

  'default_graph_version'  => 'v2.10'

]);



?>