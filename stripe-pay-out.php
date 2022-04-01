<?php
 require_once './vendor/stripe/stripe-php/init.php'; 


\Stripe\Stripe::setApiKey('sk_test_ZHBPscwQ2uvawFY7Fq1E3DAC');


// $account = \Stripe\Account::create([
//   'country' => 'US',
//   'type' => 'express',
// ]);

// $id = $account['id'];\Stripe\AccountLink::retrieve
// $stripe = \Stripe\Account::retrieve(
//   'acct_1IRBdZR8HllJN0AQ'
// );
// if($stripe['charges_enabled'] != '1'){
// 	echo "Enable";
// }else{
// 	echo "no";
// }

$stripe = \Stripe\Customer::retrieve(
  'cus_K4ZC3n8tTi2ckA',
  []
);

echo "<pre>";
print_r($stripe);
exit;
$account = \Stripe\Account::create([
  'country' => 'US',
  'type' => 'express',
]);

$id = $account['id'];

$account_links = \Stripe\AccountLink::create([
  'account' => $id,
  'refresh_url' => 'http://3.135.223.154/setting.php',
  'return_url' => 'http://3.135.223.154/dashboard.php',
  'type' => 'account_onboarding',
]);
echo "<pre>";
print_r($account_links);exit;

$transfer = \Stripe\Transfer::create([
  "amount" => 1000,
  "currency" => "usd",
  "destination" => "acct_1IRBdZR8HllJN0AQ",
]);

echo "<pre>";
print_r($transfer);