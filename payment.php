<?php 

//ini_set('display_errors', 1);

// Include configuration file  

//require_once 'config.php'; 

session_start();

require('./include/db.php');

require('./include/inc/defined_variables.php');





$email = $_POST['name'];

// $id = $_SESSION['user'];

// $sql = "Select * from cs_users where id = '".$_SESSION['user']."'";

//     $result = mysqli_query($con,$sql);

//     $user = mysqli_fetch_assoc($result);



//     if($user) {

//      $email = $user['email']; 

//     }

    

// Product Details 

// Minimum amount is $0.50 US 

$itemName = "File"; 

$itemNumber = $_POST['fileid']; 

$itemPrice = 0; 

$currency = "USD"; 

$transactionID = '';

$paidAmount = '';

$paidCurrency = '';

$payment_status = '';

$sql1 = "Select * from sentfile where file_id = '".$_POST['fileid']."'";

    $result1 = mysqli_query($con,$sql1);

    $file = mysqli_fetch_assoc($result1);



    if($file) {

    $itemPrice = $file['file_price']; 

    $fileid = $_POST['fileid'];

    $itemName = $file['file_name'];

    }

 

 

$payment_id = $statusMsg = ''; 

$ordStatus = 'error'; 

function getIPAddress() {   
     if(!empty($_SERVER['HTTP_CLIENT_IP'])) {  
        $ip = $_SERVER['HTTP_CLIENT_IP'];  
    }  
    elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {  
        $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];  
    }  
    else{  
        $ip = $_SERVER['REMOTE_ADDR'];  
    }  
    return $ip;  
} 

$ip = getIPAddress();
//$ip_details = json_decode(file_get_contents("http://api.ipstack.com/".$ip."?access_key=61d1a1a440ca8bb7537bdfd1c2bfe781"));
 

// Check whether stripe token is not empty 

if(!empty($_POST['stripeToken'])){ 

     

    // Retrieve stripe token, card and user info from the submitted form data 

    $token  = $_POST['stripeToken']; 

    $name = $_POST['name']; 

    

     

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

            'source'  => $token,
            /*'tax' => [
            	//'ip_address' => $ip,
            	'ip_address' => '72.229.28.185',
            ],
            'tax_exempt' => 'exempt'*/
            /*'address' => [
                     'country' => 'US',
                     'state' => 'New York',
                     'city' => 'New York',
                     'postal_code' => '10005',
                     'line1' => '63 wall st',
                ],*/

        )); 

    }catch(Exception $e) {  

        $api_error = $e->getMessage();  

    } 

     

    if(empty($api_error) && $customer){  

         

        // Convert price to cents 

        $itemPriceCents = round($itemPrice*100); 

         

        // Charge a credit or a debit card 

        try {  

            $charge = \Stripe\Charge::create(array( 

                'customer' => $customer->id, 

                'amount'   => $itemPriceCents, 

                'currency' => $currency, 

                'description' => $itemName
                //'automatic_tax' => ['enabled'=>true] 

            )); 

        }catch(Exception $e) {  

            $api_error = $e->getMessage();  

        } 

         

        if(empty($api_error) && $charge){ 

         

            $chargeJson = $charge->jsonSerialize(); 

            

            if($chargeJson['amount_refunded'] == 0 && empty($chargeJson['failure_code']) && $chargeJson['paid'] == 1 && $chargeJson['captured'] == 1){



                $file_data = "SELECT * from sentfile where file_id = '" . $fileid . "' ";

                $file_data_result = mysqli_query($con,$file_data);

                $file_data_fetch_data = mysqli_fetch_array($file_data_result);



                

                $user_data = "SELECT * from cs_users where id = '" . $file_data_fetch_data["added_by"] . "' OR oauth_uid =  '" . $file_data_fetch_data["added_by"] . "'";

                $user_data_result = mysqli_query($con,$user_data);

                $user_data_fetch_data = mysqli_fetch_array($user_data_result);



                $array = array();

                $card = array();

                $array = $chargeJson['payment_method_details'];

                $card = $array['card'];

                $card['brand'];

                

                $transactionID = $chargeJson['id']; 

                $paidAmount = $chargeJson['amount']; 

                $paidAmount = ($paidAmount/100); 

                $paidCurrency = $chargeJson['currency']; 

                $payment_status = $chargeJson['status']; 

                $card_type = $card['brand'];



                if($payment_status == 'succeeded'){ 



                    $commision_data = "SELECT * from system_data where system_id = '1' ";

                    $commision_data_result = mysqli_query($con,$commision_data);

                    $commision_data_fetch_data = mysqli_fetch_array($commision_data_result);



                    // //Transfer payment to file owner

                    $percent = (int)$commision_data_fetch_data['sales_commision'];

                    //$percent = 5;

                    $pay = (($chargeJson['amount'] * $percent) / 100); 

                    $pay_out = round($chargeJson['amount'] - $pay);

                    $transfer = \Stripe\Transfer::create([

                      "amount" => $pay_out,

                      "currency" => "usd",

                      "destination" => $user_data_fetch_data['stripe_acc_id'],

                    ]);

                    

                    $transfer_transaction_id = $transfer['id'];

                    $pay_out = $pay_out / 100;

                    $ordStatus = 'success'; 

                    $date = date('Y-m-d H:i:s');

                    $_SESSION['date'] = $date;

                    $payment = "INSERT INTO payments(file_id,user_id,amount,card_type,transaction_id,transfer_transaction_id,transfer_amount,p_date) VALUES('".$fileid."','".$name."','".$itemPrice."','".$card_type."','".$transactionID."','".$transfer_transaction_id."','".$pay_out."','".$date."')"; 



                    $insert = mysqli_query($con,$payment); 

                    $_SESSION['useraccess'] = $name;

                    if($_POST['file_type'] != ''){

                        setcookie('purchased'.$fileid, "Yes", time() + (86400 * 30), "/files/start");

                    } else{

                        setcookie('purchased'.$fileid, "Yes", time() + (86400 * 30), "/file/");

                    }

                    

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

if($_POST['file_type'] != ''){

    header("Location: files/start/".$_SESSION['url']."");

    exit;

} else{

    header("Location: file/".$_SESSION['url']."");

}



?>

