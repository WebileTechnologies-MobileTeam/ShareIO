<?php 
session_start();

// Include configuration file   
require('include/inc/defined_variables.php');

require('include/db.php'); 
 
$payment_id = $statusMsg = ''; 
$ordStatus = 'error'; 
 
// Check whether stripe checkout session is not empty 
if(!empty($_GET['session_id'])){ 
    $session_id = $_GET['session_id']; 
     
    // Fetch transaction data from the database if already exists 
    $sql = "SELECT * FROM payments WHERE checkout_session_id = '".$session_id."'"; 
    $result = mysqli_query($con,$sql);
    if(mysqli_num_rows($result) > 0){
        $data = mysqli_fetch_array($result);          
        $paymentID = $data['id']; 
        $transactionID = $data['transaction_id']; 
        $paidAmount = $data['amount'];
         
        $ordStatus = 'success'; 
        $statusMsg = 'Your Payment has been Successful!'; 
        $_SESSION['paymentsuccess'] = $statusMsg;
    }else{ 
        // Include Stripe PHP library  
        require_once './vendor/stripe/stripe-php/init.php'; 
         
        // Set API key 
        \Stripe\Stripe::setApiKey(STRIPE_API_KEY); 
         
        // Fetch the Checkout Session to display the JSON result on the success page 
        try { 
            $checkout_session = \Stripe\Checkout\Session::retrieve($session_id); 
        }catch(Exception $e) {  
            $api_error = $e->getMessage();  
        } 
         
        if(empty($api_error) && $checkout_session){ 
            // Retrieve the details of a PaymentIntent 
            try { 
                $intent = \Stripe\PaymentIntent::retrieve($checkout_session->payment_intent); 
            } catch (\Stripe\Exception\ApiErrorException $e) { 
                $api_error = $e->getMessage(); 
            } 
             
            // Retrieves the details of customer 
            try { 
                // Create the PaymentIntent 
                $customer = \Stripe\Customer::retrieve($checkout_session->customer); 
            } catch (\Stripe\Exception\ApiErrorException $e) { 
                $api_error = $e->getMessage(); 
            } 
             
            if(empty($api_error) && $intent){  


                //echo "<pre>"; print_r($intent); exit;


                $file_data = "SELECT * from sentfile where file_id = '" . $_GET['fileid'] . "' ";

                $file_data_result = mysqli_query($con,$file_data);

                $file_data_fetch_data = mysqli_fetch_array($file_data_result);

                $user_data = "SELECT * from cs_users where id = '" . $file_data_fetch_data["added_by"] . "' OR oauth_uid =  '" . $file_data_fetch_data["added_by"] . "'";

                $user_data_result = mysqli_query($con,$user_data);

                $user_data_fetch_data = mysqli_fetch_array($user_data_result);


                // Check whether the charge is successful 
                if($intent->status == 'succeeded'){ 

                    // Customer details 
                    $name = $customer->name; 
                    $email = $customer->email; 
                     
                    // Transaction details  
                    $transactionID = $intent->id; 
                    $paidAmount = $file_data_fetch_data['file_price'];//$intent->amount; 
                    $paidAmount = ($paidAmount/100); 
                    $paidCurrency = $intent->currency; 
                    $paymentStatus = $intent->status; 

                    $commision_data = "SELECT * from system_data where system_id = '1' ";

                    $commision_data_result = mysqli_query($con,$commision_data);

                    $commision_data_fetch_data = mysqli_fetch_array($commision_data_result);

                    // //Transfer payment to file owner

                    $percent = (int)$commision_data_fetch_data['sales_commision'];

                    //$percent = 5;

                    $pay = (($intent->amount * $percent) / 100); 

                    $pay_out = round($intent->amount - $pay);

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

                    $payment = "INSERT INTO payments(file_id,user_id,amount,card_type,transaction_id,transfer_transaction_id,transfer_amount,p_date) VALUES('".$_GET['fileid']."','".$email."','".$_GET['itemPrice']."','','".$transactionID."','".$transfer_transaction_id."','".$pay_out."','".$date."')"; 

                    $insert = mysqli_query($con,$payment); 

                    $sales = "INSERT INTO sales(member_id,file_id,price,sale_date) VALUES('".$_GET['memberid']."','".$_GET['fileid']."','".$_GET['itemPrice']."','".$date."')"; 

                    $salesinsert = mysqli_query($con,$sales); 
                    
                    $access_list = "INSERT INTO access_list(member_id,file_id,status) VALUES('".$_SESSION['member_id']."','".$_GET['fileid']."','1')"; 

                    $access_list_insert = mysqli_query($con,$access_list);

                    $_SESSION['useraccess'] = $email;

                    if($_GET['file_type'] != ''){

                        setcookie('purchased'.$_GET['fileid'], "Yes", time() + (86400 * 30), "/files/start");

                    } else{

                        setcookie('purchased'.$_GET['fileid'], "Yes", time() + (86400 * 30), "/file/");

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
            $statusMsg = "Unable to fetch the transaction details! $api_error";  
            $_SESSION['paymenterror'] = $statusMsg; 
        } 
             
        $ordStatus = 'success';
    } 
}else{ 
    $statusMsg = "Invalid Request!"; 
    $_SESSION['paymenterror'] = $statusMsg; 
} 


if($_GET['file_type'] != '' || $_SESSION['filetype'] == 'audio'){

    header("Location: files/start/".$_SESSION['url']."");

    exit;

} else{

    header("Location: file/".$_SESSION['url']."");

}

?>
