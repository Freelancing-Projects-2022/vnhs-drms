<?php

use Symfony\Component\Mailer\Transport;
use Symfony\Component\Mailer\Mailer;
use Symfony\Component\Mime\Email;
 
// Ucomment the sendMail() function below.
// Change the recipient email first and then open browser
// Type in http://localhost/vnhs-drms/sendEmail.php to test the sending email facility
// ------------------------------------------------------------------------------------>
sendEmail('pearlica09@gmail.com', 'Sample ulit', '<h1>This is a body of the email</h1>');
 
function sendEmail($toEmail, $subject, $msgBody) {
    require_once 'config.php';
 
    $db = new DB();
    $arr_token = (array) $db->get_access_token();
 
    try {
        $transport = Transport::fromDsn('gmail+smtp://' . GOOGLE_EMAIL_ACCOUNT . ':'.urlencode($arr_token['access_token']).'@default');
 
        $mailer = new Mailer($transport);
 
        $message = (new Email())
            ->from(GOOGLE_EMAIL_DISPLAY_NAME. ' <' . GOOGLE_EMAIL_ACCOUNT . '>')
            ->to($toEmail)
            ->subject($subject)
            ->html($msgBody);
 
        $mailer->send($message);

    } catch (Exception $e) {
        if( !$e->getCode() ) {
            $refresh_token = $db->get_refersh_token();
 
            $response = $adapter->refreshAccessToken([
                "grant_type" => "refresh_token",
                "refresh_token" => $refresh_token,
                "client_id" => GOOGLE_CLIENT_ID,
                "client_secret" => GOOGLE_CLIENT_SECRET,
            ]);
             
            $data = (array) json_decode($response);
            $data['refresh_token'] = $refresh_token;
 
            $db->update_access_token(json_encode($data)); 
            sendEmail($toEmail, $subject, $msgBody);
        } else {
            echo $e->getMessage(); //print the error
        }
    }
}

?>