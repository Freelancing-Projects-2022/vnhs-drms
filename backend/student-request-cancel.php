<?php
	session_start();
	include('../dbcon.php');
	include('../util.php');
	//include('../sendEmail.php');
	include('../sendSMS.php');
	
    if(isset($_POST['statusStr']) && isset($_POST['requestId'])) {        
        $status = $_POST['statusStr'];
        $requestId = $_POST['requestId'];      
        $date = date("Y-m-d");
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
        // $emailBody .= "You just cancelled your request for <b>" . $row['documentName'] . "</b>.</p>";
        $cpNumber = $row['cp_number'];
        $smsRecipient = substr($cpNumber, 1);
        $smsBody = "Document Request Update. Hi " . $fullName . "! You just cancelled your request for " . $row['documentName'] . ".";
        
        $msgStatus = "You just have cancelled your request.";
        $remarks = "REQUEST HAS BEEN CANCELLED BY STUDENT.";
        mysqli_query($conn,"UPDATE request SET status = '$status', remarks = '$remarks', is_cancelled_by_admin	= false WHERE id = '$requestId'");   
               
        //sendEmail($emailRecipient, $emailSubject, $emailBody);
        sendSMS($smsRecipient, $smsBody);

        $resultJson = array('msgStr' => $msgStatus,
                            'msgType' => $msgType
        );

        echo json_encode($resultJson);
        exit;
    }    
?>