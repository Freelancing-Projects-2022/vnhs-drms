<?php
    function validateInput($data) {
        $data = trim($data);        
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return strtoupper($data);
    }

    function getFullName($lastName, $firstName, $middleName, $isLastNameFirst, $isMiddleInitial) {
        if(strlen($middleName)>0 && $isMiddleInitial) {
            $middleName = substr($middleName, 0, 1) . ".";
        }
        if($isLastNameFirst) {
            return $lastName . ", " . $firstName . " " . $middleName;
        }
        else {
            return $firstName . " " . $middleName . " " . $lastName;
        }
    }

    function getImageErrorMsg($imageName) {
        return 'Problem uploading ' . $imageName . '. Only JPG, JPEG, PNG, WEBP, & GIF files are allowed to be uploaded.';
    }

    function sendMail() {
        $to = "pearlica09@gmail.com";
        $subject = "REQUEST STATUs";

        $message = "
        <html>
        <head>
        <title>HTML email</title>
        </head>
        <body>
        <p>This email contains HTML Tags!</p>
        <table>
        <tr>
        <th>Firstname</th>
        <th>Lastname</th>
        </tr>
        <tr>
        <td>John</td>
        <td>Doe</td>
        </tr>
        </table>
        </body>
        </html>
        ";

        // Always set content-type when sending HTML email
        $headers = "MIME-Version: 1.0" . "\r\n";
        $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";

        // More headers
        $headers .= 'From: pearlica09@gmail.com' . "\r\n";

        mail($to,$subject,$message,$headers);
    }

?>