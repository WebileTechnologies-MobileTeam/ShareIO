<?php

if ($_SERVER['HTTP_HOST'] == 'localhost') {
    define('SITE_URL', 'http://' . $_SERVER['HTTP_HOST']);
} else {
    define('SITE_URL', 'https://' . $_SERVER['HTTP_HOST']);
}

define('SITE_NAME', 'ShareIO');

//Stripe Keys sk_live_5rREMOf7I0iFPCGnvhLaokC8
define('STRIPE_API_KEY', 'sk_test_ZHBPscwQ2uvawFY7Fq1E3DAC'); 
define('STRIPE_PUBLISHABLE_KEY', 'pk_test_oTruSCZTRDEeYT4vlRt529vG'); 

define('AWS_S3_KEY', 'AKIAU3PF3ROQZWVWZAE7');
define('AWS_S3_SECRET', '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');
define('AWS_S3_REGION', 'us-east-2');
define('AWS_S3_BUCKET', 'contentshare-files');
define('AWS_S3_URL', 'http://s3.'.AWS_S3_REGION.'.amazonaws.com/'.AWS_S3_BUCKET.'/');