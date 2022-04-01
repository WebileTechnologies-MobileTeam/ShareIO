<?php
session_start();
require_once './include/db.php';
require_once './vendor/stripe/stripe-php/init.php'; 

$id = $_POST['id'];

\Stripe\Stripe::setApiKey('sk_test_ZHBPscwQ2uvawFY7Fq1E3DAC');

$account = \Stripe\Account::create([
    'country' => 'US',
    'type' => 'express',
]);
$stripeid = $account['id'];

$update_user = "UPDATE cs_users SET stripe_acc_id = '".$stripeid."' where id = '".$id."' OR oauth_uid = '".$id."'";
$result = mysqli_query($con,$update_user);

$account_links = \Stripe\AccountLink::create([
    'account' => $stripeid,
    'refresh_url' => 'https://shareio.com/setting.php',
    'return_url' => 'https://shareio.com/setting.php',
    'type' => 'account_onboarding',
]);
$url = $account_links['url'];

echo $url;