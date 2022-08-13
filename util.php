<?php
    // This file is only for utility functions

    // Checks if the data entry is valid
    function validateInput($data) {
        $data = trim($data);        
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return strtoupper($data);
    }

    // Setups fullname base on the given parameter
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

    // Error message when uploading image
    function getImageErrorMsg($imageName) {
        return 'Problem uploading ' . $imageName . '. Only JPG, JPEG, PNG, WEBP, & GIF files are allowed to be uploaded.';
    }

    function validating($phone){
        $regex =  '~(?:\+?98|0)(?:\s*\d{3}){2}\s*\d{4}~';
        if(strlen($phone)!=11 || !preg_match($regex, $phone)) {
            return "Please provide a valid 11 digit phone number. Example: 09123456789";
        }
        else {
            return "";
        }
    }
?>