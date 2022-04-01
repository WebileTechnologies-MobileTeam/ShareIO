<?php 

session_start();

// Include configuration file   
require('include/inc/defined_variables.php');

require('include/db.php'); 
 
$response = array( 
    'status' => 0, 
    'error' => array( 
        'message' => 'Invalid Request!'    
    ) 
); 
 
if ($_SERVER['REQUEST_METHOD'] == 'POST') { 
    $input = file_get_contents('php://input'); 
    $request = json_decode($input);     
} 

//print_r($request);
 
if (json_last_error() !== JSON_ERROR_NONE) { 
    http_response_code(400); 
    echo json_encode($response); 
    exit; 
} 
 
$email = $request->name;

$itemName = "File"; 

$itemNumber = $request->fileid;

$itemPrice = 0; 

$currency = "USD"; 

$transactionID = '';

$paidAmount = '';

$paidCurrency = '';

$payment_status = '';

$memberid = $request->memberid;

$sql1 = "Select * from sentfile where file_id = '".$request->fileid."'";

    $result1 = mysqli_query($con,$sql1);

    $file = mysqli_fetch_assoc($result1);

    if($file) {

    $itemPrice = $file['file_price']; 

    $fileid = $request->fileid;

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
//$ip = '161.185.160.93';

//$ip_details = json_decode(file_get_contents("http://api.ipstack.com/".$ip."?access_key=61d1a1a440ca8bb7537bdfd1c2bfe781"));

$new_arr[]= unserialize(file_get_contents('http://www.geoplugin.net/php.gp?ip='.$ip));
$lat = $new_arr[0]['geoplugin_latitude'];
$long = $new_arr[0]['geoplugin_longitude'];

//$lat = '40.7143';
//$long = '-74.0060';
$mapApi = "https://api.mapbox.com/geocoding/v5/mapbox.places/".$long.",".$lat.".json??types=address&access_token=pk.eyJ1Ijoic2FmYWoiLCJhIjoiY2t0YmIyYzRyMXU0bzJ1bGFycXh5cDh2diJ9.H2iYCWsVGzdln5M8LZobKw&limit=1";
$addressData = json_decode(file_get_contents($mapApi),true);

$address = [];
if(isset($addressData['features'][0]['place_name'])){
	$address = explode(',',$addressData['features'][0]['place_name']);
}

$line = '';
if(isset($address[0])){
	$line = $address[0];
}
$postcode = '';
if(isset($addressData['features'][0]['context'][1]['text'])){
	$postcode = $addressData['features'][0]['context'][1]['text'];
}
$city = '';
if(isset($addressData['features'][0]['context'][3]['text'])){
	$city = $addressData['features'][0]['context'][3]['text'];
}
$region = '';
if(isset($addressData['features'][0]['context'][5]['text'])){
	$region = $addressData['features'][0]['context'][5]['text'];
}
$country = '';
if(isset($addressData['features'][0]['context'][6]['text'])){
	$country = $addressData['features'][0]['context'][6]['text'];
}

$isAddress = true;
if($country != '' && $country == 'uk'){
	if($line == '' || $postcode == '' || $city == ''){
		$isAddress = false;
	}
}else{
	if($line == '' || $postcode == '' || $city == '' || $region == '' || $country == ''){
		$isAddress = false;
	}
}


$customer_address = ['customer_update' => ['address' => 'auto']];
if($isAddress){
	$customer_address = ['billing_address_collection' => 'auto'];
}

if(!empty($request->checkoutSession)){ 

    $name = $request->name;

    // Include Stripe PHP library 

    require_once 'vendor/stripe/stripe-php/init.php'; 

    // Set API key 

    \Stripe\Stripe::setApiKey(STRIPE_API_KEY); 

    $itemPriceCents = round($itemPrice*100); 

    // $tax_rate = \Stripe\TaxRate::create([
    //   'display_name' => 'Sales Tax',
    //   'inclusive' => false,
    //   'percentage' => 7.25,
    //   'country' => 'US',
    //   'state' => 'CA',
    //   'jurisdiction' => 'US - CA',
    //   'description' => 'CA Sales Tax',
    // ]);

    // Create new Checkout Session for the order 
    
    if($request->isAddress){
	    try {
	    	
	    	if($country != '' && $country == 'uk'){
				$customerAddress = ['address' => [
	                'country' => $country,
	                'city' => $city,
	                'postal_code' => $postcode,
	                'line1' => $line,
	            ]];
			}else{
				$customerAddress = ['address' => [
	                'country' => $country,
	                'state' => $region,
	                'city' => $city,
	                'postal_code' => $postcode,
	                'line1' => $line,
	            ]];
			}
		
			$customer = \Stripe\Customer::create(array( 
	            'email' => $email,  
	            $customerAddress,
	            /*'address' => [
	                 'country' => 'US',
	                 'state' => 'New York',
	                 'city' => 'New York',
	                 'postal_code' => '10005',
	                 'line1' => '63 wall st',
	            ],*/
	            /*'address' => [
	                 'country' => 'UK',
	                 //'state' => '',
	                 'city' => 'Birmingham',
	                 'postal_code' => 'B3 1DX',
	                 'line1' => '24 Ludgate Hill',
	            ],*/
	        ));
	        
	        $session = \Stripe\Checkout\Session::create([ 
	            'payment_method_types' => ['card'], 
	            'line_items' => [[ 
	                'price_data' => [ 
	                    'product_data' => [ 
	                        'name' => $itemName,
	                        'metadata' => [ 
	                            'file_id' => $fileid 
	                        ] 
	                    ], 
	                    'unit_amount' => $itemPriceCents, 
	                    'currency' => $currency, 
	                    'tax_behavior' => 'exclusive',                        
	                ], 
	                'quantity' => 1, 
	                //'tax_rates' => ['txr_1JfIkkByQ4PggRtgXst9NFPN'],
	                'description' => $itemName, 
	            ]], 
	            'customer' => $customer->id,  
	            /*'customer_update' => [
	                'address' => 'auto',
	            ],*/
	            //'billing_address_collection' => 'auto',
	            $customer_address,
	            'mode' => 'payment', 
	            'success_url' => 'https://shareio.com/chk-payment-response.php?session_id={CHECKOUT_SESSION_ID}&&fileid='.$fileid.'&&itemPrice='.$itemPrice.'&&file_type='.$_POST['file_type'].'&&memberid='.$memberid.'',
	            'cancel_url' => 'https://shareio.com/chk-payment-response.php', 
	        ]);

	    }catch(Exception $e) {
	    	
	        $api_error = $e->getMessage();  
	    }
	}else{
		
		try {
	
			$customer = \Stripe\Customer::create(array( 
	            'email' => $email
	        ));
	        
	        $session = \Stripe\Checkout\Session::create([ 
	            'payment_method_types' => ['card'], 
	            'line_items' => [[ 
	                'price_data' => [ 
	                    'product_data' => [ 
	                        'name' => $itemName,
	                        'metadata' => [ 
	                            'file_id' => $fileid 
	                        ] 
	                    ], 
	                    'unit_amount' => $itemPriceCents, 
	                    'currency' => $currency, 
	                    'tax_behavior' => 'exclusive',                        
	                ], 
	                'quantity' => 1, 
	                //'tax_rates' => ['txr_1JfIkkByQ4PggRtgXst9NFPN'],
	                'description' => $itemName, 
	            ]], 
	            'customer' => $customer->id,  
	            'customer_update' => [
	                'address' => 'auto',
	            ],
	            'mode' => 'payment', 
	            'success_url' => 'https://shareio.com/chk-payment-response.php?session_id={CHECKOUT_SESSION_ID}&&fileid='.$fileid.'&&itemPrice='.$itemPrice.'&&file_type='.$_POST['file_type'].'&&memberid='.$memberid.'',
	            'cancel_url' => 'https://shareio.com/chk-payment-response.php', 
	        ]);

	    }catch(Exception $e) {
	    	
	        $api_error = $e->getMessage();  
	    }
		
	}
     
    if(empty($api_error) && $session){ 
        $response = array( 
            'status' => 1, 
            'message' => 'Checkout Session created successfully!', 
            'sessionId' => $session['id'] 
        ); 
    }else{
        $response = array( 
            'status' => 0, 
            'error' => array( 
                'message' => 'Checkout Session creation failed! '.$api_error    
            ) 
        ); 
    } 
} 
 
// Return response 
echo json_encode($response);
