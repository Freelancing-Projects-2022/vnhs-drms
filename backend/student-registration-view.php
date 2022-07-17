<?php
	session_start();
	include('../dbcon.php');
	include('../util.php');
	
	if(isset($_POST['studentLRN'])) {
		$lrn = $_POST['studentLRN'];        
        $query=mysqli_query($conn,"SELECT * FROM `student_registration` WHERE lrn='$lrn'");            
        $row=mysqli_fetch_array($query);
        $statusStr = "<span class='label label-success'>For Approval</span>";
        $actionsStr = "<button type='button' class='btn btn-danger btn-sm m-t-xs m-b-xs m-r-xs' onClick=\"updateStatus('DECLINED', '" . $row['id'] . "')\">Decline</button>" .
                        "<button type='button' class='btn btn-primary btn-sm m-t-xs m-b-xs' onClick=\"updateStatus('APPROVED', '" . $row['id'] . "')\">Approve</button>";
        if($row['status'] == 'ACTIVE') {
            $statusStr = "<span class='label label-muted'>Active</span>";
            $actionsStr = "<button type='button' class='btn btn-warning btn-sm m-t-xs m-b-xs m-r-xs' onClick=\"updateStatus('INACTIVE', '" . $row['id'] . "')\">Set as Inactive</button>" .
                            "<button type='button' class='btn btn-primary btn-sm m-t-xs m-b-xs m-r-xs' onClick=\"updateStatus('CANCEL APPROVAL', '" . $row['id'] . "')\">Cancel Approval</button>";
        }
        else if($row['status'] == 'INACTIVE') {
            $statusStr = "<span class='label label-danger'>Inactive</span>";
            $actionsStr = "<button type='button' class='btn btn-primary btn-sm m-t-xs m-b-xs m-r-xs' onClick=\"updateStatus('ACTIVE', '" . $row['id'] . "')\">Set as Active</button>";
        }
        else if($row['status'] == 'DECLINED') {
            $statusStr = "<span class='label label-muted text-danger'>Declined</span>";
            $actionsStr = "<button type='button' class='btn btn-primary btn-sm m-t-xs m-b-xs m-r-xs' onClick=\"updateStatus('CANCEL REJECTION', '" . $row['id'] . "')\">Cancel Rejection</button>";
        }
        
        $result = array('userId' => $row['id'],
                        'fullName' => getFullName($row['last_name'], $row['first_name'], $row['middle_name'], false, true),
                        'lastName' => $row['last_name'],
                        'firstName' => $row['first_name'],
                        'middleName' => $row['middle_name'],
                        'emailAddress' => $row['email_address'],
                        'cpNumber' => $row['cp_number'],
                        'password' => $row['password'],
                        'lrn' => $row['lrn'],
                        'profilePicture' => $row['profile_picture'],
                        'actionsStr' => $actionsStr,
                        'statusStr' => $statusStr
                    );
        echo json_encode($result);
        exit;
    }
?>