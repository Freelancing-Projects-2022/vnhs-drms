<?php
	session_start();
	include('../dbcon.php');
	include('../util.php');
	include('../sendEmail.php');
	
    if(isset($_POST['statusStr']) && isset($_POST['requestId']) && isset($_POST['studentName'])) {        
        $status = $_POST['statusStr'];
        $requestId = $_POST['requestId'];    
        $studentName = $_POST['studentName'];     
        $date = date("Y-m-d H:i:s");
        $remarks = "";
        $msgType = "success";

        $result = mysqli_query($conn, "SELECT *, request.id AS requestId, request.user_id as userId, document.name AS documentName FROM request INNER JOIN document on request.document_id = document.id WHERE request.id =  $requestId");
        $row=mysqli_fetch_array($result);   
        $userId = $row['userId'];
        $query=mysqli_query($conn,"SELECT * FROM student_registration WHERE id='$userId'");          
        $userResult=mysqli_fetch_array($query); 
        $fullName = getFullName($userResult['last_name'], $userResult['first_name'], $userResult['middle_name'], false, true);
        $emailRecipient = $userResult['email_address'];
        $emailSubject = "Document Request Update";
        $emailBody = "<h2>Document Request Update</h2> ";
        $emailBody .= "<p>Hi <b>" . $fullName . "</b>! ";

        $msgStatus = "Request of " . $studentName . " has been ";
        if($status == 'DECLINED') {
            $msgStatus .= "Declined.";
            $remarks = "REQUEST DECLINED BY THE REGISTRAR.";
            mysqli_query($conn,"UPDATE request SET status = '$status', remarks = '$remarks' WHERE id = '$requestId'");   
            $emailBody .= "Your request for <b>" . $row['documentName'] . "</b> was been <b>DECLINED</b> by the Registrar.</p>";
        }
        else if($status == 'FOR RELEASING') {
            if($row['status'] == 'CANCELLED') {
                $msgStatus .= "reverted to FOR RELEASING status.";
                $remarks = "REQUEST REVERTED TO FOR RELEASING BY THE REGISTRAR."; 
                $emailBody .= "Your request for <b>" . $row['documentName'] . "</b> was reverted to <b>FOR RELEASING</b> status by the Registrar.</p>";
            }
            else {
                $msgStatus .= "Approved.";
                $remarks = "REQUEST APPROVED BY THE REGISTRAR.";
                $emailBody .= "Your request for <b>" . $row['documentName'] . "</b> was been <b>APPROVED</b> by the Registrar. Please set an appointment for your pickup using our app.</p>";
            }
            mysqli_query($conn,"UPDATE `request` SET status = '$status', remarks = '$remarks', is_cancelled_by_admin = false, approved_date = '$date' WHERE id = '$requestId'");   
        }
        else if($status == 'FOR APPROVAL') {
            $msgStatus .= "reverted to FOR APPROVAL status.";
            $remarks = "REQUEST REVERTED TO FOR APPROVED STATUS BY THE REGISTRAR.";
            mysqli_query($conn,"UPDATE `request` SET status = '$status', remarks = '$remarks', is_cancelled_by_admin = false, approved_date = NULL WHERE id = '$requestId'");   
            $emailBody .= "Your request for <b>" . $row['documentName'] . "</b> was reverted to <b>FOR APPROVAL</b> status by the Registrar.</p>";
        }
        else if($status == 'RESUBMISSION') {
            $msgStatus .= "requested for Resubmission.";
            if(isset($_POST['remarksStr'])) {
                $remarks = validateInput($_POST['remarksStr']);
                mysqli_query($conn,"UPDATE request SET status = '$status', remarks = '$remarks' WHERE id = '$requestId'");   
                $emailBody .= "Your request for <b>" . $row['documentName'] . "</b> was been requested for <b>RESUBMISSION</b> of the sent requirements. You can resend your requirements on our app. Thank you!</p>";
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
            $emailBody .= "Your request for <b>" . $row['documentName'] . "</b> was been <b>CANCELLED</b> by the Registrar. You can reschedule your pickup date using the app.</p>";
        }
        else if($status == 'COMPLETED') {
            $msgStatus .= "Completed";
            $remarks = "REQUEST HAS BEEN COMPLETED.";
            mysqli_query($conn,"UPDATE request SET status = '$status', remarks = '$remarks', is_cancelled_by_admin	= false WHERE id = '$requestId'");  
            $emailBody .= "Your request for <b>" . $row['documentName'] . "</b> was been <b>COMPLETED</b>. Thank you for using our online system.</p>"; 
        }
        
        
        sendEmail($emailRecipient, $emailSubject, $emailBody);

        $resultJson = array('msgStr' => $msgStatus,
                            'msgType' => $msgType
        );

        echo json_encode($resultJson);
        exit;
    }    
?>