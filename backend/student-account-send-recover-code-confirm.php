<?php
	session_start();
	include('../dbcon.php');
	include('../util.php');
	//include('../sendEmail.php');
	include('../sendSMS.php');
	
    if(isset($_POST['lrn']) && isset($_POST['cpNumber']) && isset($_POST['recoveryCode'])) {        
        $lrn = $_POST['lrn'];
        // $emailAddress = validateInput($_POST['emailAddress']);    
        $smsRecipient = substr($_POST['cpNumber'], 1);
        $recoverCode = validateInput($_POST['recoveryCode']);    
        $msgType = "success";
        $msgStatus = "";

        $query=mysqli_query($conn,"SELECT * FROM student_registration WHERE lrn='$lrn'");   
        if(mysqli_num_rows($query)==0) {
            $msgType = "error";
            $msgStatus = "The LRN and mobile number you have entered is not found in our database.";
        }
        else {
            $userResult = mysqli_fetch_array($query); 
            $fullName = getFullName($userResult['last_name'], $userResult['first_name'], $userResult['middle_name'], false, true);
            $recoverCodeSaved = $userResult['remarks'];
            if($recoverCode != $recoverCodeSaved) {
                $msgStatus = "The recovery code doesn't matched. Please try again.";
                $msgType = "error";
            }
            else {
                // $emailSubject = "Account Recovery";
                // $emailBody = "<h2>Account Recovery</h2> ";
                // $emailBody .= "<p>Hi <b>" . $fullName . "</b>! ";
                // $emailBody .= "Thank you for verifying! Here is your acccount: <br>";
                // $emailBody .= "<b>Username / LRN: " . $userResult['username'] . "</b>";
                // $emailBody .= "<br><b>Password: " . $userResult['password'] . "</b>";
                
                $smsBody = "Account Recovery. Hi " . $fullName . "! Thank you for verifying! Here is your acccount: Username/LRN: " . $userResult['username'] .  " and Password: " . $userResult['password'];
                mysqli_query($conn,"UPDATE student_registration SET remarks='', updated_timestamp='NOW()' WHERE lrn = '$lrn'");
                //sendEmail($emailRecipient, $emailSubject, $emailBody);    
                sendSMS($smsRecipient, $smsBody);             
                $msgStatus = "Thank you for verifying! You will receive an sms notifation containing your account credentials.";
            }
        }
        $resultJson = array('msgStr' => $msgStatus,
                            'msgType' => $msgType
        );

        echo json_encode($resultJson);
        exit;
    }    
?>