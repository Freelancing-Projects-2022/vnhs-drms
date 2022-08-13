<?php
	session_start();
	include('../dbcon.php');
	include('../util.php');
	//include('../sendEmail.php');
	include('../sendSMS.php');
	
    $statusMsg = ''; 
    $requestedDocumentId = '';
    $requirementName = '';
    $submittedRequirement = '';
    $isRequirementImage = false;
    if(isset($_POST['submit'])) {
        $requestedDocumentId = validateInput($_POST['cboDocument']);
        $requirementName = validateInput($_POST['txtRequirementName']);
        if($requestedDocumentId == 0) {
            $statusMsg = 'Please select Requesting Document!';
        }
        else if($requestedDocumentId > 2) {
            if (isset($_FILES['uploadedFile']) && $_FILES['uploadedFile']['error'] === UPLOAD_ERR_OK) {
                // get details of the uploaded file
                $fileTmpPath = $_FILES['uploadedFile']['tmp_name'];
                $fileName = $_FILES['uploadedFile']['name'];
                $fileSize = $_FILES['uploadedFile']['size'];
                $fileType = $_FILES['uploadedFile']['type'];
                $fileNameCmps = explode(".", $fileName);
                $fileExtension = strtolower(end($fileNameCmps));
            
                // sanitize file-name
                $newFileName = md5(time() . $fileName) . '.' . $fileExtension;
            
                // check if file has one of the following extensions
                $allowedfileExtensions = array('jpg', 'jpeg', 'gif', 'png');
            
                if (in_array($fileExtension, $allowedfileExtensions)) {
                    // directory in which the uploaded file will be moved
                    $uploadFileDir = '../uploads/';
                    $dest_path = $uploadFileDir . $newFileName;
            
                    if(move_uploaded_file($fileTmpPath, $dest_path)) {
                        $submittedRequirement = 'uploads/' . $newFileName;
                        $isRequirementImage = true;
                    }
                    else {
                        $statusMsg = 'There was some error moving the file to upload directory. Please make sure the upload directory is writable by web server.';
                    }
                }
                else {
                    $statusMsg = 'Upload failed. Allowed file types: ' . implode(',', $allowedfileExtensions);
                }
            }
            else {
                $_SESSION['msgType']  = "error";       
                $_SESSION['msgTitle']  = "Empty!";         
                $_SESSION['msg'] = "Please provide pequirement.";   
            }
        }
        else {
            $submittedRequirement = validateInput($_POST['taPurpose']);
        }

        if($statusMsg === '') {
            $isValid = true;
            $userId = validateInput($_POST['txtId']);
            $query=mysqli_query($conn,"SELECT * FROM request WHERE user_id = $userId AND document_id = $requestedDocumentId");
            if(mysqli_num_rows($query) > 0){
                while ($row = mysqli_fetch_array($query)) {
                    if($row['status'] != 'CANCELLED') {
                        $isValid = false;
                        break;
                    } 
                }
                               
            }

            if($isValid) {
                $sql = "INSERT INTO request (`user_id`, `document_id`, `document_requirement_name`, `document_requirement_submitted`, `status`, `request_date`, `is_requirement_image`) VALUES ($userId, $requestedDocumentId, '$requirementName', '$submittedRequirement', 'FOR APPROVAL', NOW(), '$isRequirementImage')";
                if (mysqli_query($conn, $sql)) {    
                    $_SESSION['msgType']  = "success";       
                    $_SESSION['msgTitle']  = "Request Sent!";                   
                    $_SESSION['msg'] = "Please wait for the approval of your request."; 
                    unset($_FILES['uploadedFile']);

                    $query=mysqli_query($conn,"SELECT * FROM student_registration WHERE id='$userId'");          
                    $row=mysqli_fetch_array($query);  
                    $query2=mysqli_query($conn,"SELECT * FROM document WHERE id='$requestedDocumentId'");          
                    $row2=mysqli_fetch_array($query2);  
                    $fullName = getFullName($row['last_name'], $row['first_name'], $row['middle_name'], false, true);
                    // $emailRecipient = $row['email_address'];
                    // $emailSubject = "Document Request";
                    // $emailBody = "<h2>Document Request</h2> ";
                    // $emailBody .= "<p>Hi <b>" . $fullName . "</b>! ";
                    // $emailBody .= "Your request for <b>" . $row2['name'] . "</b> is currently pending for approval. We will let you know if it is already been approved. Thank you!</p>";
                    // sendEmail($emailRecipient, $emailSubject, $emailBody);
                    
                    $cpNumber = $row['cp_number'];
                    $smsRecipient = substr($cpNumber, 1);
                    $smsBody = "Account Status Set To Active. Hi " . $fullName . "! Your request for " . $row2['name'] . " is currently pending for approval. We will let you know if it is already been approved. Thank you!";
                    sendSMS($smsRecipient, $smsBody);
                } else{
                    // echo "<script language='javascript'>alert('" . mysqli_error($conn) . "')</script>";
                    $_SESSION['msgType']  = "error";       
                    $_SESSION['msgTitle']  = "Failed Requesting Document!";         
                    $_SESSION['msg'] = $statusMsg;   
                }
            }
            else {
                $_SESSION['msgType']  = "error";       
                $_SESSION['msgTitle']  = "Existing Request!";         
                $_SESSION['msg'] = "You can only request document one at a time.";   
            }
        }
        else {
            $_SESSION['msgType']  = "error";       
            $_SESSION['msgTitle']  = "Failed Uploading Photo!";            
            $_SESSION['msg'] = $statusMsg;   
        }
        
        $_SESSION['currentPage'] = "pages/student/requests.php";
        header('location: service.php');    
        mysqli_close($conn);
    }
?>