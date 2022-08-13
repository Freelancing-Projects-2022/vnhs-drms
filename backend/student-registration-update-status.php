<?php
	session_start();
	include('../dbcon.php');
	include('../util.php');
	//include('../sendEmail.php');
	include('../sendSMS.php');
	
    if(isset($_POST['statusStr']) && isset($_POST['userIdStr'])) {        
        $status = $_POST['statusStr'];
        $userId = $_POST['userIdStr'];      
        $date = date("Y-m-d");
        
        $result = mysqli_query($conn,"SELECT * FROM student_registration WHERE id = '$userId'"); 
        $row = mysqli_fetch_array($result);  
        $fullName = getFullName($row['last_name'], $row['first_name'], $row['middle_name'], false, true);
		//$emailAddress = $row['email_address'];
        // $emailRecipient = $emailAddress;
        $cpNumber = $row['cp_number'];
        $lrn = $row['lrn'];
        $password = $row['password'];
        $smsRecipient = substr($cpNumber, 1);

        $msgStatus = "";
        $msgType = "";
        $msgTitle = "";

        if($status == 'DECLINED') {
            $msgStatus = "Student registration of " . $fullName . " has been Declined.";
            // $emailSubject = "Account Registration Declined";
            // $emailBody = "<h2>Account Registration Declined</h2> ";
            // $emailBody .= "<p>Hi <b>" . $fullName . "</b>! ";
            // $emailBody .= "I'm sorry, your application has been declined.</p>";

            $smsBody = "Account Registration Declined. Hi " . $fullName . "! I'm sorry, your application has been declined.";
        }
        else if($status == 'INACTIVE') {
            $msgStatus = "Account of " . $fullName . " has been Set to Inactive";
            // $emailSubject = "Account Status Update";
            // $emailBody = "<h2>Account Status Set To Inactive</h2> ";
            // $emailBody .= "<p>Hi <b>" . $fullName . "</b>! ";
            // $emailBody .= "Your account has been set to inactive.</p>";
            
            $smsBody = "Account Status Update. Hi " . $fullName . "! Your account has been set to inactive.";
        }
        else if($status == 'ACTIVE') {
            $status = "ACTIVE";
            $msgStatus = "Account of " . $fullName . " has been Set to Active";
            // $emailSubject = "Account Status Update";
            // $emailBody = "<h2>Account Status Set To Active</h2> ";
            // $emailBody .= "<p>Hi <b>" . $fullName . "</b>! Your account has been set to active. You can sign in using your account details below:</p>";
            // $emailBody .= "<b>Username / LRN: " . $lrn . "</b>";
            // $emailBody .= "<br><b>Password: " . $password . "</b>";

            $smsBody = "Account Status Set To Active. Hi " . $fullName . "! Your account has been set to active. You can sign in using your account details.";
            $smsBody .= " Username/LRN: " . $lrn . " and Password: " . $password;
        }
        else  if($status == 'APPROVED') {
            $msgStatus = "Student registration of " . $fullName . " has been Approved.";
            $status = "ACTIVE";
            // $emailSubject = "Account Approved";
            // $emailBody = "<h2>Account Approval</h2> ";
            // $emailBody .= "<p>Hi <b>" . $fullName . "</b>!";
            // $emailBody .= "Your application was been approved. You can sign in using your account details below:</p>";
            // $emailBody .= "<b>Username / LRN: " . $lrn . "</b>";
            // $emailBody .= "<br><b>Password: " . $password . "</b>";

            $smsBody = "Account Approval. Hi " . $fullName . "! Your application was been approved. You can sign in using your account details.";
            $smsBody .= " Username/LRN: " . $lrn . " and Password: " . $password;
        }
        else  if($status == 'CANCEL APPROVAL') {
            $msgStatus = "Approval of Student registration of " . $fullName . " has been withrawn.";
            $status = "FOR APPROVAL";
            // $emailSubject = "Account Approval Withdrawn";
            // $emailBody = "<h2>Account Approval Withdrawn</h2> ";
            // $emailBody .= "<p>Hi <b>" . $fullName . "</b>!";
            // $emailBody .= "Your application approval has been withrawn. </p>";
            
            $smsBody = "Account Approval Withdrawn. Hi " . $fullName . "! Your application approval has been withrawn.";
        }
        else  if($status == 'CANCEL REJECTION') {
            $msgStatus = "Rejection of Student registration of " . $fullName . " has been withrawn.";
            $status = "FOR APPROVAL";
            // $emailSubject = "Account Rejection Withdrawn";
            // $emailBody = "<h2>Account Rejection Withdrawn</h2> ";
            // $emailBody .= "<p>Hi <b>" . $fullName . "</b>!";
            // $emailBody .= "Your application rejection has been withrawn. </p>";

            $smsBody = "Account Rejection Withdrawn. Hi " . $fullName . "! Your application rejection has been withrawn.";
        }

        mysqli_query($conn,"UPDATE `student_registration` SET status = '$status', updated_timestamp='$date' WHERE id = '$userId'");   
        $query=mysqli_query($conn,"SELECT * from `user` where lrn='$lrn'");
        $isExisting = false;
        
        if(mysqli_num_rows($query) > 0 && $status == 'APPROVE'){
            $isExisting = true;
        }

        if($isExisting) {
            $msgType  = "error";   
            $msgStatus = "There is an existing record with the given LRN.";
            $msgTitle = "Action Failed!";
        }
        else {
            $msgType  = "success";   
            $msgStatus = "Student account has been activated";
            $msgTitle = "Successfully Updated!";      
            //sendEmail($emailRecipient, $emailSubject, $emailBody);
            sendSMS($smsRecipient, $smsBody);
        }

        $resultJson = array('msgStr' => $msgStatus,
                            'msgType' => $msgType,
                            'msgTitle' => $msgTitle
        );

        echo json_encode($resultJson);
        exit;
    }
?>