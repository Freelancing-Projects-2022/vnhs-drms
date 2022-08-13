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
        $actionsStr = "";
        if($row['status'] == 'FOR APPROVAL') {
            $statusStr = "<span class=\"label label-success\">For Approval</span>";
            if($row['is_requirement_image']) {
                $actionsStr .= "<button type=\"button\" class=\"btn btn-warning btn-sm m-r-xs\" onClick=\"updateRequestStatus('RESUBMISSION', '" . $requestId . "', '" . getFullName($row2['last_name'], $row2['first_name'], $row2['middle_name'], false, true) . "')\">Request Resubmission</button>";
            }
            $actionsStr .= "<button type=\"button\" class=\"btn btn-danger btn-sm m-r-xs\" onClick=\"updateRequestStatus('DECLINED', '" . $requestId . "', '" . getFullName($row2['last_name'], $row2['first_name'], $row2['middle_name'], false, true) . "')\">Decline</button>";
            $actionsStr .= "<button type=\"button\" class=\"btn btn-primary btn-sm m-r-xs\" onClick=\"updateRequestStatus('FOR RELEASING', '" . $requestId . "', '" . getFullName($row2['last_name'], $row2['first_name'], $row2['middle_name'], false, true) . "')\">Approve</button>";
        }
        else if($row['status'] == 'FOR RELEASING') {
            $statusStr = "<span class=\"label label-primary\">For Releasing</span>";
            $approveDate = date('d M Y', strtotime($row['approved_date']));
            if($row['pickup_date'] != '') {
                $pickupDate = date('d M Y', strtotime($row['pickup_date']));
                $actionsStr .= "<button type=\"button\" class=\"btn btn-danger btn-sm m-r-xs\" onClick=\"updateRequestStatus('CANCELLED', '" . $requestId . "', '" . getFullName($row2['last_name'], $row2['first_name'], $row2['middle_name'], false, true) . "')\">Cancel Appointment</button>";
                $actionsStr .= "<button type=\"button\" class=\"btn btn-primary btn-sm m-r-xs\" onClick=\"updateRequestStatus('COMPLETED', '" . $requestId . "', '" . getFullName($row2['last_name'], $row2['first_name'], $row2['middle_name'], false, true) . "')\">Complete Request</button>";
            }
            else {
                $actionsStr .= "<button type=\"button\" class=\"btn btn-danger btn-sm m-r-xs\" onClick=\"updateRequestStatus('FOR APPROVAL', '" . $requestId . "', '" . getFullName($row2['last_name'], $row2['first_name'], $row2['middle_name'], false, true) . "')\">Revert Approval</button>";
            }
        }
        else if($row['status'] == 'DECLINED') {
            $statusStr = "<span class=\"label label-muted text-danger\">Declined</span>";
            $actionsStr .= "    <li><a href=\"javascript:void(0)\" onClick=\"updateRequestStatus('FOR APPROVAL', '" . $row['requestId'] . "', '" . getFullName($row2['last_name'], $row2['first_name'], $row2['middle_name'], false, true) . "')\"><i class=\"fa fa-refresh m-r-xs\"></i>Revert Decline</a></li>";       
        }
        else if($row['status'] == 'CANCELLED') {
            $statusStr = "<span class=\"label label-danger\">Cancelled</span>";
            $requestedDate = $row['request_date'];
            $startDate = strtotime(date('Y-m-d', strtotime($requestedDate)));
            $currentDate = strtotime(date('Y-m-d'));
        
            if($row['is_cancelled_by_admin'] && $startDate >= $currentDate) {
                if(($row['pickup_date'] != '')) {
                    $actionsStr .= "    <li><a href=\"javascript:void(0)\" onClick=\"updateRequestStatus('FOR RELEASING', '" . $row['requestId'] . "', '" . getFullName($row2['last_name'], $row2['first_name'], $row2['middle_name'], false, true) . "')\"><i class=\"fa fa-refresh m-r-xs\"></i>Revert Cancel</a></li>";
                }
                else {
                    $actionsStr .= "    <li><a href=\"javascript:void(0)\" onClick=\"updateRequestStatus('FOR APPROVAL', '" . $row['requestId'] . "', '" . getFullName($row2['last_name'], $row2['first_name'], $row2['middle_name'], false, true) . "')\"><i class=\"fa fa-refresh m-r-xs\"></i>Revert Cancel</a></li>";
                }
            }
        }
        else if($row['status'] == 'COMPLETED') {
            $statusStr = "<span class=\"label label-muted text-muted\">Completed</span>";
            $approveDate = date('d M Y', strtotime($row['approved_date']));
            if($row['pickup_date'] != '') {
                $pickupDate = date('d M Y', strtotime($row['pickup_date']));
            }
        }
        else if ($row['status'] == 'RESUBMISSION') {
            $actionsStr .= "<button type=\"button\" class=\"btn btn-danger btn-sm m-t-xs m-b-xs m-r-xs\" onClick=\"updateRequestStatus('FOR APPROVAL', '" . $requestId . "', '" . getFullName($row2['last_name'], $row2['first_name'], $row2['middle_name'], false, true) . "')\">Revert Resubmission</button>";
        }

        $actionsStr .= "<button type=\"button\" class=\"btn btn-white m-r-xs\" data-dismiss=\"modal\">Close</button>";
        
        $result = array('requestId' => $_POST['requestId'],
                        'userId' => $userId,
                        'userFullName' => getFullName($row2['last_name'], $row2['first_name'], $row2['middle_name'], false, true),
                        'profilePicture' => $row2['profile_picture'],
                        'documentName' => $row['documentName'],
                        'remarks' => $row['remarks'],
                        'requestDate' => date('d M Y', strtotime($row['request_date'])),
                        'approvedDate' => $approveDate,
                        'pickupDate' => $pickupDate,
                        'documentRequirementName' => $row['document_requirement_name'],
                        'documentRequirementSubmitted' => $row['document_requirement_submitted'],
                        'isRequirementImage' => $row['is_requirement_image'],
                        'status' => $row['status'],
                        'statusStr' => $statusStr,
                        'actionsStr' => $actionsStr,
                        'modalStatus' => 'show'
                    );
        echo json_encode($result);
        exit;
    }
?>