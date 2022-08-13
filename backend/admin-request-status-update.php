<?php
	session_start();
	include('../dbcon.php');
	include('../util.php');
	//include('../sendEmail.php');
	include('../sendSMS.php');
	
    if(isset($_POST['statusStr']) && isset($_POST['requestId']) && isset($_POST['studentName'])) {        
        $status = $_POST['statusStr'];
        $requestId = $_POST['requestId'];    
        $studentName = $_POST['studentName'];     
        $tz = 'Asia/Manila';
        $timestamp = time();
        $dt = new DateTime("now", new DateTimeZone($tz)); //first argument "must" be a string
        $dt->setTimestamp($timestamp); //adjust the object to correct timestamp
        $date = $dt->format("Y-m-d H:i:s");
        $remarks = "";
        $msgType = "success";

        $result = mysqli_query($conn, "SELECT *, request.id AS requestId, request.user_id as userId, document.name AS documentName FROM request INNER JOIN document on request.document_id = document.id WHERE request.id =  $requestId");
        $row=mysqli_fetch_array($result);   
        $userId = $row['userId'];
        $query=mysqli_query($conn,"SELECT * FROM student_registration WHERE id='$userId'");          
        $userResult=mysqli_fetch_array($query); 
        $fullName = getFullName($userResult['last_name'], $userResult['first_name'], $userResult['middle_name'], false, true);
        
        // $emailRecipient = $userResult['email_address'];
        // $emailSubject = "Document Request Update";
        // $emailBody = "<h2>Document Request Update</h2> ";
        // $emailBody .= "<p>Hi <b>" . $fullName . "</b>! ";

        
        $cpNumber = $userResult['cp_number'];
        $smsRecipient = substr($cpNumber, 1);
        $smsBody = "Document Request Update. Hi " . $fullName . "!";

        $msgStatus = "Request of " . $studentName . " has been ";
        if($status == 'DECLINED') {
            $msgStatus .= "Declined.";
            $remarks = "REQUEST DECLINED BY THE REGISTRAR.";
            mysqli_query($conn,"UPDATE request SET status = '$status', remarks = '$remarks' WHERE id = '$requestId'");   
            // $emailBody .= "Your request for <b>" . $row['documentName'] . "</b> was been <b>DECLINED</b> by the Registrar.</p>";
            $smsBody .= "Your request for " . $row['documentName'] . " was been DECLINED by the Registrar.";
        }
        else if($status == 'FOR RELEASING') {
            if($row['status'] == 'CANCELLED') {
                $msgStatus .= "reverted to FOR RELEASING status.";
                $remarks = "REQUEST REVERTED TO FOR RELEASING BY THE REGISTRAR."; 
                // $emailBody .= "Your request for <b>" . $row['documentName'] . "</b> was reverted to <b>FOR RELEASING</b> status by the Registrar.</p>";
                $smsBody .= "Your request for " . $row['documentName'] . " was reverted to FOR RELEASING status by the Registrar.";
            }
            else {
                $msgStatus .= "Approved.";
                $remarks = "REQUEST APPROVED BY THE REGISTRAR.";
                // $emailBody .= "Your request for <b>" . $row['documentName'] . "</b> was been <b>APPROVED</b> by the Registrar. Please set an appointment for your pickup using our app.</p>";
                $smsBody .= "Your request for " . $row['documentName'] . " was been APPROVED by the Registrar. Please set an appointment for your pickup using our app.";
            }
            mysqli_query($conn,"UPDATE `request` SET status = '$status', remarks = '$remarks', is_cancelled_by_admin = false, approved_date = '$date' WHERE id = '$requestId'");   
        }
        else if($status == 'FOR APPROVAL') {
            $msgStatus .= "reverted to FOR APPROVAL status.";
            $remarks = "REQUEST REVERTED TO FOR APPROVED STATUS BY THE REGISTRAR.";
            mysqli_query($conn,"UPDATE `request` SET status = '$status', remarks = '$remarks', is_cancelled_by_admin = false, approved_date = NULL WHERE id = '$requestId'");   
            // $emailBody .= "Your request for <b>" . $row['documentName'] . "</b> was reverted to <b>FOR APPROVAL</b> status by the Registrar.</p>";
            $smsBody .= "Your request for " . $row['documentName'] . " was reverted to FOR APPROVAL status by the Registrar.";
        }
        else if($status == 'RESUBMISSION') {
            $msgStatus .= "requested for Resubmission.";
            if(isset($_POST['remarksStr'])) {
                $remarks = validateInput($_POST['remarksStr']);
                mysqli_query($conn,"UPDATE request SET status = '$status', remarks = '$remarks' WHERE id = '$requestId'");   
                // $emailBody .= "Your request for <b>" . $row['documentName'] . "</b> was been requested for <b>RESUBMISSION</b> of the sent requirements. You can resend your requirements on our app. Thank you!</p>";
                $smsBody .= "Your request for " . $row['documentName'] . " was been requested for RESUBMISSION of the sent requirements. You can resend your requirements on our app. Thank you!";
            }
            else {
                $msgType = "error";
                $msgStatus = "Please input PURPOSE/REMARKS for a request of RESUBMISSION.";
            }
        }
        else if($status == 'CANCELLED') {
            $msgStatus .= "Cancelled";
            $remarks = "REQUEST HAS BEEN CANCELLED BY THE REGISTRAR.";
            mysqli_query($conn,"UPDATE request SET status = '$status', remarks = '$remarks', is_cancelled_by_admin	= true WHERE id = '$requestId'");   
           //  $emailBody .= "Your request for <b>" . $row['documentName'] . "</b> was been <b>CANCELLED</b> by the Registrar. You can reschedule your pickup date using the app.</p>";
            $smsBody .= "Your request for " . $row['documentName'] . " was been CANCELLED by the Registrar. You can reschedule your pickup date using the app.";
        }
        else if($status == 'COMPLETED') {
            $msgStatus .= "Completed";
            $remarks = "REQUEST HAS BEEN COMPLETED.";
            mysqli_query($conn,"UPDATE request SET status = '$status', remarks = '$remarks', is_cancelled_by_admin	= false WHERE id = '$requestId'");  
            //$emailBody .= "Your request for <b>" . $row['documentName'] . "</b> was been <b>COMPLETED</b>. Thank you for using our online system.</p>"; 
            $smsBody .= "Your request for " . $row['documentName'] . " was been COMPLETED. Thank you for using our online system.";
        }
        
        
        // sendEmail($emailRecipient, $emailSubject, $emailBody);
        sendSMS($smsRecipient, $smsBody);

        $resultJson = array('msgStr' => $msgStatus,
                            'msgType' => $msgType
        );

        echo json_encode($resultJson);
        exit;
    }    
?>