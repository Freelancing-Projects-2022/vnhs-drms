<?php

use Symfony\Component\Mailer\Transport;
use Symfony\Component\Mailer\Mailer;
use Symfony\Component\Mime\Email;
 
// sendEmail('pearlica09@gmail.com', 'Random Tile', 'This is a body of the email');
 
function sendEmail($toEmail, $subject, $msgBody) {
    require_once 'config.php';
 
    $db = new DB();
    $arr_token = (array) $db->get_access_token();
 
    try {
        $transport = Transport::fromDsn('gmail+smtp://vnhs.drms@gmail.com:'.urlencode($arr_token['access_token']).'@default');
 
        $mailer = new Mailer($transport);
 
        $message = (new Email())
            ->from('VNHS DRMS <vnhs.drms@gmail.com>')
            ->to($toEmail)
            ->subject($subject)
            ->html($msgBody);
 
        // Send the message
        $mailer->send($message);
 
        //echo 'Email sent successfully.';
    } catch (Exception $e) {
        if( !$e->getCode() ) {
            // $refresh_token = $db->get_refersh_token();
 
            // $response = $adapter->refreshAccessToken([
            //     "grant_type" => "refresh_token",
            //     "refresh_token" => $refresh_token,
            //     "client_id" => GOOGLE_CLIENT_ID,
            //     "client_secret" => GOOGLE_CLIENT_SECRET,
            // ]);
             
            // $data = (array) json_decode($response);
            // $data['refresh_token'] = $refresh_token;
 
            // $db->update_access_token(json_encode($data));

            require 'callback.php';
 
            sendEmail($toEmail, $subject, $msgBody);
        } else {
            //echo $e->getMessage(); //print the error
        }
    }
}

?>