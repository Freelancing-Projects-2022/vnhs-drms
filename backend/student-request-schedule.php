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
  
        $approveDate = "--";
        $pickupDate = "--";
        $statusStr = "";
        $modalTitle = "Schedule Appointment";
        $actionsStr = "<button type=\"button\" class=\"btn btn-primary\" onClick=\"confirmRequestSchedule(". $requestId .", '" . date('m/d/Y', strtotime($row['approved_date'])) . "')\">Confirm Schedule</button>";
        if($row['status'] == 'FOR APPROVAL') {
            $statusStr = "<span class=\"label label-success\">For Approval</span>";
        }
        else if($row['status'] == 'FOR RELEASING') {
            $statusStr = "<span class=\"label label-primary\">For Releasing</span>";
            $approveDate = date('d M Y', strtotime($row['approved_date']));
            if($row['pickup_date'] != '') {
                $pickupDate = date('d M Y', strtotime($row['pickup_date']));
                $modalTitle = "Reschedule Appointment";
                $actionsStr = "<button type=\"button\" class=\"btn btn-primary\" onClick=\"confirmRequestSchedule(". $requestId .", '" . date('m/d/Y', strtotime($row['approved_date'])) . "')\">Confirm Reschedule</button>";
            }
        }
        else if($row['status'] == 'DECLINED') {
            $statusStr = "<span class=\"label label-muted text-danger\">Declined</span>";
        }
        else if($row['status'] == 'CANCELLED') {
            $statusStr = "<span class=\"label label-danger\">Cancelled</span>";
        }
        else if($row['status'] == 'COMPLETED') {
            $statusStr = "<span class=\"label label-muted text-muted\">Completed</span>";
            $approveDate = date('d M Y', strtotime($row['approved_date']));
            if($row['pickup_date'] != '') {
                $pickupDate = date('d M Y', strtotime($row['pickup_date']));
            }
        }
        $actionsStr .= "<button type=\"button\" class=\"btn btn-white m-l-xs\" data-dismiss=\"modal\">Cancel</button>";
        
        $result = array('requestId' => $_POST['requestId'],
                        'userId' => $userId,
                        'userFullName' => getFullName($row2['last_name'], $row2['first_name'], $row2['middle_name'], true, true),
                        'documentName' => $row['documentName'],
                        'remarks' => $row['remarks'],
                        'requestDate' => date('d M Y', strtotime($row['request_date'])),
                        'approvedDate' => $approveDate,
                        'pickupDate' => $pickupDate,
                        'documentRequirementName' => $row['document_requirement_name'],
                        'documentRequirementSubmitted' => $row['document_requirement_submitted'],
                        'isRequirementImage' => $row['is_requirement_image'],
                        'statusStr' => $statusStr,
                        'actionsStr' => $actionsStr,
                        'modalTitle' => $modalTitle,
                        'modalStatus' => 'show'
                    );
        echo json_encode($result);
        exit;
    }
?>