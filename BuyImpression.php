<?php 

// Include configuration file  

//require_once 'config.php'; 

session_start();

require('./include/db.php');

require('./include/inc/defined_variables.php');





$id = $_POST['user_id'];

$email = "";

$commision_data = "SELECT * from system_data where system_id = '1' ";
$commision_data_result = mysqli_query($con,$commision_data);
$commision_data_fetch_data = mysqli_fetch_array($commision_data_result);
$impressions_cost = (int)$commision_data_fetch_data['impression_cost_per_1k'];
$existing_impression = '';

//$id = $_SESSION['user'];

$sql = "Select * from cs_users where id = '".$id."'";

 $result = mysqli_query($con,$sql);

 $user = mysqli_fetch_assoc($result);



if($user) {

 $email = $user['email']; 

 $existing_impression = $user['impressions']; 

}

    

// Product Details 

// Minimum amount is $0.50 US 

$itemName = "Impression"; 

$itemNumber = $_POST['user_id']; 

$itemPrice = $_POST['price']; 

$currency = "USD"; 

$transactionID = '';

$paidAmount = '';

$paidCurrency = '';

$payment_status = '';

 

 

$payment_id = $statusMsg = ''; 

$ordStatus = 'error'; 

 

// Check whether stripe token is not empty 

if(!empty($_POST['stripeToken'])){ 

     

    // Retrieve stripe token, card and user info from the submitted form data 

    $token  = $_POST['stripeToken']; 

    //$name = $_POST['name']; 

    

     

    // Include Stripe PHP library 

    require_once './vendor/stripe/stripe-php/init.php'; 

     

    // Set API key 

    \Stripe\Stripe::setApiKey(STRIPE_API_KEY); 



    // \Stripe\Stripe::setApiKey('sk_test_ZHBPscwQ2uvawFY7Fq1E3DAC');

    // $customer = \Stripe\BillingPortal\Session::create([

    //    'customer' => 'cus_IsRc2ZUgMNCb7l',

    //    'return_url' => 'https://example.com/subscription',

    // ]);

    // echo '<pre>';

    // print_r($customer);

    //  exit;

    // Add customer to stripe 

    try {  

        $customer = \Stripe\Customer::create(array( 

            'email' => $email, 

            'source'  => $token 

        )); 

    }catch(Exception $e) {  

        $api_error = $e->getMessage();  

    } 

     

    if(empty($api_error) && $customer){  

         

        // Convert price to cents 

        $itemPriceCents = ($itemPrice*100); 

         

        // Charge a credit or a debit card 

        try {  

            $charge = \Stripe\Charge::create(array( 

                'customer' => $customer->id, 

                'amount'   => $itemPriceCents, 

                'currency' => $currency, 

                'description' => $itemName 

            )); 

        }catch(Exception $e) {  

            $api_error = $e->getMessage();  

        } 

         

        if(empty($api_error) && $charge){ 

         

            $chargeJson = $charge->jsonSerialize(); 

          

            if($chargeJson['amount_refunded'] == 0 && empty($chargeJson['failure_code']) && $chargeJson['paid'] == 1 && $chargeJson['captured'] == 1){

                $array = array();

                $card = array();

                $array = $chargeJson['payment_method_details'];

                $card = $array['card'];

                $card['brand'];

                

                $transactionID = $chargeJson['balance_transaction']; 

                $paidAmount = $chargeJson['amount']; 

                $paidAmount = ($paidAmount/100); 

                $paidCurrency = $chargeJson['currency']; 

                $payment_status = $chargeJson['status']; 

                $card_type = $card['brand'];

                 

                if($payment_status == 'succeeded'){ 

                    $impression = ($itemPrice * 1000 / $impressions_cost);

                    $ordStatus = 'success'; 

                    $date = date('Y-m-d H:i:s');

                    $_SESSION['date'] = $date;

                    $payment = "INSERT INTO License(`UserID`,`Date/Time`,`ImpressionsPurchased`) VALUES('".$id."','".$date."','".$impression."')"; 



                    $insert = mysqli_query($con,$payment); 

                    $new_impression = $existing_impression + $impression;

                    $user_data = "UPDATE cs_users SET impressions = '".$new_impression."' where id = '".$id."'"; 



                    $user_data_update = mysqli_query($con,$user_data); 

                    $_SESSION['useraccess'] = $name;

                    setcookie('purchased'.$fileid, "Yes", time() + (86400 * 30), "/contentshare/file/");

                    $statusMsg = 'Your Payment has been Successful!'; 

                    $_SESSION['paymentsuccess'] = $statusMsg;

                }else{ 

                    $statusMsg = "Your Payment has Failed!";

                    $_SESSION['paymenterror'] = $statusMsg; 

                } 

            }else{ 

                $statusMsg = "Transaction has been failed!";

                $_SESSION['paymenterror'] = $statusMsg; 

            } 

        }else{ 

            $statusMsg = "Charge creation failed! $api_error"; 

            $_SESSION['paymenterror'] = $statusMsg; 

        } 

    }else{  

        $statusMsg = "Invalid card details! $api_error";

        $_SESSION['paymenterror'] = $statusMsg;  

    } 

}else{ 

    $statusMsg = "Error on form submission.";

    $_SESSION['paymenterror'] = $statusMsg; 

} 

header("Location: setting.php");

?>

