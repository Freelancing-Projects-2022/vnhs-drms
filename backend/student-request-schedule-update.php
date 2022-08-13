<?php
	session_start();
	include('../dbcon.php');
	include('../util.php');
	//include('../sendEmail.php');
	include('../sendSMS.php');
	
	if(isset($_POST['requestId'])) {
		$requestId = $_POST['requestId'];   
		$datePickUp = date('Y-m-d', strtotime($_POST['txtDatePickUp']));    
        $msgStr = "";
        $msgType = "success";

        $settingsQry = mysqli_query($conn,"SELECT * from settings");
        $settingsResult = mysqli_fetch_array($settingsQry);
        
        $query = mysqli_query($conn,"SELECT * FROM request WHERE DATE(pickup_date) = '$datePickUp' AND status <> 'CANCELLED'");
        if(mysqli_num_rows($query) >= $settingsResult['max_count_of_request_per_day']) {
            $msgStr = date('M d, Y', strtotime($_POST['txtDatePickUp'])) . " is fully booked. Please select other day.";
            $msgType = "error";
        }
        else {
            $updatePickUpDateQry = mysqli_query($conn,"UPDATE request SET pickup_date = '$datePickUp', status = 'FOR RELEASING', is_cancelled_by_admin = false WHERE id = '$requestId'");  
            $msgStr = "You have been scheduled on " . date('M d, Y', strtotime($_POST['txtDatePickUp'])) . " for releasing."; 
        }
        
        $query2=mysqli_query($conn,"SELECT document.name as documentName, request.user_id as userId FROM request INNER JOIN document on request.document_id = document.id WHERE request.id='$requestId'");          
        $row2=mysqli_fetch_array($query2);  
        
        $userId = $_SESSION['userId'];
        $query=mysqli_query($conn,"SELECT * FROM student_registration WHERE id='$userId'");          
        $row=mysqli_fetch_array($query);  

        $fullName = getFullName($row['last_name'], $row['first_name'], $row['middle_name'], false, true);        
        $datePickUpStr = date('M d, Y', strtotime($_POST['txtDatePickUp']));

        // $emailRecipient = $row['email_address'];
        // $emailSubject = "Appointment Schedule";
        // $emailBody = "<h2>Appointment Schedule</h2>";
        // $emailBody .= "<p>Hi <b>" . $fullName . "</b>! ";
        // $emailBody .= "You just set your schedule for pickup on <b>" . $datePickUpStr . "</b>. Please prepare the necessary physical documents to be presented on the day of releasing of your <b>" . $row2['documentName'] . "</b>. Thank you.</p>";
        // sendEmail($emailRecipient, $emailSubject, $emailBody);


        $cpNumber = $row['cp_number'];
        $smsRecipient = substr($cpNumber, 1);
        $smsBody = "Appointment Schedule. Hi " . $fullName . "! You just set your schedule for pickup on " . $datePickUpStr . ". Please prepare the necessary physical documents to be presented on the day of releasing of your " . $row2['documentName'] . " Thank you.";
        sendSMS($smsRecipient, $smsBody);

        $resultJson = array('msgStr' => $msgStr,
                            'msgType' => $msgType
                    );
        echo json_encode($resultJson);
        exit;
    }
?>