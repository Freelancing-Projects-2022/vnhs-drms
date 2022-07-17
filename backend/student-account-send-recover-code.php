<?php
	session_start();
	include('../dbcon.php');
	include('../util.php');
	include('../sendEmail.php');
	
    if(isset($_POST['lrn']) && isset($_POST['emailAddress'])) {        
        $lrn = validateInput($_POST['lrn']);
        $emailAddress = validateInput($_POST['emailAddress']);    
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
            $emailRecipient = $userResult['email_address'];
            if($emailRecipient != $emailAddress) {
                $msgStatus = "The LRN and email address doesn't matched with a record in our database.";
                $msgType = "error";
            }
            else {
                $emailSubject = "Account Recovery";
                $emailBody = "<h2>Account Recovery</h2> ";
                $emailBody .= "<p>Hi <b>" . $fullName . "</b>! ";
        
                $recoverCode = validateInput(substr(str_shuffle(str_repeat("0123456789abcdefghijklmnopqrstuvwxyz", 5)), 0, 5));
                $emailBody .= "To recover your account, use the code below:<br><h2 style='background-color: #f1f1f1; border: 1px solid #e5e5e5;border-radius: 5px; font-family: monospace;" .
                            "padding: 3px 20px;display: inline;letter-spacing: 2px;'><b>" . $recoverCode . "</b></h2>";
                
                $msgStatus = "Check your email for the recovery code.";
                mysqli_query($conn,"UPDATE student_registration SET remarks='$recoverCode', updated_timestamp='NOW()' WHERE lrn = '$lrn'");
                sendEmail($emailRecipient, $emailSubject, $emailBody);
            }
            
        }
       

        $resultJson = array('msgStr' => $msgStatus,
                            'msgType' => $msgType
        );

        echo json_encode($resultJson);
        exit;
    }    
?>