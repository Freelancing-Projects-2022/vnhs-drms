<?php
	session_start();
	include('../dbcon.php');
	include('../util.php');
	  
    $dateNow = Date('Y-m-d');
    $resultAppointments = mysqli_query($conn, "SELECT *, request.id AS requestId, request.user_id as userId, document.name AS documentName FROM request INNER JOIN document on request.document_id = document.id WHERE DATE(request.pickup_date) = '$dateNow' AND (request.status = 'FOR RELEASING' OR (request.status = 'CANCELLED' AND request.is_cancelled_by_admin = false))");
    if(mysqli_num_rows($resultAppointments)>0) {
        while ($row = mysqli_fetch_array($resultAppointments)) {
            $requestId = $row['requestId'];
            $remarks = "REQUEST HAS BEEN CANCELLED BY THE REGISTRAR.";
            mysqli_query($conn,"UPDATE `request` SET status = 'CANCELLED', remarks = '$remarks', is_cancelled_by_admin = true WHERE id = '$requestId'");

            $userId = $row['userId'];
            $query=mysqli_query($conn,"SELECT * FROM student_registration WHERE id='$userId'");          
            $userResult=mysqli_fetch_array($query); 
            $fullName = getFullName($userResult['last_name'], $userResult['first_name'], $userResult['middle_name'], false, true);
            $emailRecipient = $userResult['email_address'];
            $emailSubject = "Document Request Update";
            $emailBody = "<h2>Document Request Update</h2> ";
            $emailBody .= "<p>Hi <b>" . $fullName . "</b>! ";
            $emailBody .= "Your request for <b>" . $row['documentName'] . "</b>. was cancelled by the Registrar. You can reschedule your pickup date using the app.</p>";
                
            sendEmail($emailRecipient, $emailSubject, $emailBody);
        }
        $msgStr = "All appointments today were cancelled.";
        $msgType = "success";
    }
    else {
        $msgStr = "There is no appointment today.";
        $msgType = "erro";
    }
    $resultJson = array('msgStr' => $msgStr,
                        'msgType' => $msgType
    );

    echo json_encode($resultJson);
    exit;
?>