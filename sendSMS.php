<?php

// require_once 'vendor/autoload.php';
require __DIR__ . '/twilio-php/src/Twilio/autoload.php';

use Twilio\Rest\Client; 

function sendSMS($receiver, $message) {
    // Send an SMS using Twilio's REST API and PHP
    $sid = "ACbdeac96d2e569c7bd09899f55d9f010c"; // Your Account SID from www.twilio.com/console
    $token = "87b7916b7ee32c7e5f1a6b68556275e0"; // Your Auth Token from www.twilio.com/console
    $senderNumber = "+18106349948";

    $twilio = new Client($sid, $token); 
    $message = $twilio->messages 
                    ->create("+63" . $receiver, // to 
                            array(        
                                    "from" =>  $senderNumber,
                                    "body" => $message 
                            ) 
                    );
}
 