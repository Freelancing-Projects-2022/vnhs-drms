<?php
	session_start();
	include('../dbcon.php');
	include('../util.php');
	
	if(isset($_POST['requestId'])) {
		$requestId = $_POST['requestId'];        
        $query=mysqli_query($conn,"SELECT *, document.name AS documentName FROM request INNER JOIN document on request.document_id = document.id WHERE request.id =  $requestId");
        $row=mysqli_fetch_array($query);
        $userId = $row['user_id'];
        $query2=mysqli_query($conn,"SELECT * FROM student_registration WHERE id=' $userId'");          
        $row2=mysqli_fetch_array($query2);   
  
        $approveDate = date('d M Y', strtotime($row['approved_date']));
        $actionsStr = "<button type=\"submit\" name=\"submit\"  class=\"btn btn-primary\">Confirm Resubmission</button>";
        $actionsStr .= "<button type=\"button\" class=\"btn btn-white m-l-xs\" onClick=\"cancelRequirementUpdate()\">Cancel</button>";
        
        $result = array('requestId' => $requestId,
                        'userFullName' => getFullName($row2['last_name'], $row2['first_name'], $row2['middle_name'], true, true),
                        'documentName' => $row['documentName'],
                        'remarks' => $row['remarks'],
                        'requestDate' => date('d M Y', strtotime($row['request_date'])),
                        'documentRequirementName' => $row['document_requirement_name'],
                        'documentRequirementSubmitted' => $row['document_requirement_submitted'],
                        'actionsStr' => $actionsStr,
                        'modalStatus' => 'show'
                    );
        echo json_encode($result);
        exit;
    }
?>