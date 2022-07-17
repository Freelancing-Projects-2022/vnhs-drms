<?php
	session_start();
	include('../dbcon.php');
	include('../util.php');
	include('../sendEmail.php');
	
    if(isset($_POST['lrn']) && isset($_POST['emailAddress']) && isset($_POST['recoveryCode'])) {        
        $lrn = $_POST['lrn'];
        $emailAddress = validateInput($_POST['emailAddress']);    
        $recoverCode = validateInput($_POST['recoveryCode']);    
        $msgType = "success";
        $msgStatus = "";

        $query=mysqli_query($conn,"SELECT * FROM student_registration WHERE lrn='$lrn'");   
        if(mysqli_num_rows($query)==0) {
            $msgType = "error";
            $msgStatus = "The LRN and email address you have entered is not found in our database.";
        }
        else {
            $userResult = mysqli_fetch_array($query); 
            $fullName = getFullName($userResult['last_name'], $userResult['first_name'], $userResult['middle_name'], false, true);
            $recoverCodeSaved = $userResult['remarks'];
            $emailRecipient = $userResult['email_address'];
            if($recoverCode != $recoverCodeSaved) {
                $msgStatus = "The recovery code doesn't matched. Please try again.";
                $msgType = "error";
            }
            else {
                $emailSubject = "Account Recovery";
                $emailBody = "<h2>Account Recovery</h2> ";
                $emailBody .= "<p>Hi <b>" . $fullName . "</b>! ";
                $emailBody .= "Thank you for verifying! Here is your acccount: <br>";
                $emailBody .= "<b>Username / LRN: " . $userResult['username'] . "</b>";
                $emailBody .= "<br><b>Password: " . $userResult['password'] . "</b>";
                mysqli_query($conn,"UPDATE student_registration SET remarks='', updated_timestamp='NOW()' WHERE lrn = '$lrn'");
                sendEmail($emailRecipient, $emailSubject, $emailBody);                
                $msgStatus = "Thank you for verifying! Please check your email for your account credentials.";
            }
        }
        $resultJson = array('msgStr' => $msgStatus,
                            'msgType' => $msgType
        );

        echo json_encode($resultJson);
        exit;
    }    
?>