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


                $package_data = "SELECT * from package_list where pkg_id  = '" . $_GET['packageid'] . "' ";

                $package_data_result = mysqli_query($con,$package_data);

                $package_data_fetch_data = mysqli_fetch_array($package_data_result);

                $user_data = "SELECT * from cs_users where id = '" . $package_data_fetch_data["user_id"] . "' OR oauth_uid =  '" . $package_data_fetch_data["user_id"] . "'";

                $user_data_result = mysqli_query($con,$user_data);

                $user_data_fetch_data = mysqli_fetch_array($user_data_result);


                // Check whether the charge is successful 
                if($intent->status == 'succeeded'){ 

                    // Customer details 
                    $name = $customer->name; 
                    $email = $customer->email; 
                     
                    // Transaction details  
                    $transactionID = $intent->id; 
                    $paidAmount = $_GET['itemPrice'];//$intent->amount; 
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

                    $payment = "INSERT INTO payments(package_id,user_id,amount,card_type,transaction_id,transfer_transaction_id,transfer_amount,p_date) VALUES('".$_GET['packageid']."','".$email."','".$_GET['itemPrice']."','','".$transactionID."','".$transfer_transaction_id."','".$pay_out."','".$date."')"; 

                    $insert = mysqli_query($con,$payment); 

                    $sales = "INSERT INTO sales(member_id,package_id,price,sale_date) VALUES('".$_SESSION['member_id']."','".$_GET['packageid']."','".$_GET['itemPrice']."','".$date."')"; 

                    $salesinsert = mysqli_query($con,$sales);
                    
                    $access_list = "INSERT INTO access_list(member_id,package_id,status) VALUES('".$_SESSION['member_id']."','".$_GET['packageid']."','1')"; 

                    $access_list_insert = mysqli_query($con,$access_list);

                    $_SESSION['useraccess'] = $email;
                    $period = '';
                    if($package_data_fetch_data['sub_type'] == 'Day'){
                        $period = '1';
                    } elseif($package_data_fetch_data['sub_type'] == 'Week'){
                        $period = '7';
                    } elseif($package_data_fetch_data['sub_type'] == 'Month'){
                        $period = '30';
                    } else{
                        $period = '365';
                    }
                    setcookie('purchased'.$_GET['packageid'], "Yes", time() + (86400 * $period), "/package/");

                    $file_list_query = "SELECT * FROM package_file_list WHERE pkg_fid = '".$_GET['packageid']."'";
                    $file_list_query_result = mysqli_query($con,$file_list_query);
                    while($file_list = mysqli_fetch_array($file_list_query_result)){
                    	
                    	 $access_list_file = "INSERT INTO access_list(member_id,file_id,status) VALUES('".$_SESSION['member_id']."','".$file_list['file_fid']."','1')"; 

                    	 $access_list_file_insert = mysqli_query($con,$access_list_file);
                        $file_query = "SELECT * FROM sentfile where file_id = '" . $file_list['file_fid'] . "'";
                        $file_query_result = mysqli_query($con,$file_query);
                        $file = mysqli_fetch_array($file_query_result);
                        if($file['file_type'] == 'audio/mpeg' || $file['file_type'] == 'audio/mp3'){
                            setcookie('purchased'.$file_list['file_fid'], "Yes", time() + (86400 * $period), "/files/start");
                        } else{
                            setcookie('purchased'.$file_list['file_fid'], "Yes", time() + (86400 * $period), "/file/");
                        }
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

header("Location: package/".$_SESSION['url']."");

?>
