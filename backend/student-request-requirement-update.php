<?php
	session_start();
	include('../dbcon.php');
	include('../util.php');
	//include('../sendEmail.php');
	include('../sendSMS.php');
	
    $msgStr = "";     
    $submittedRequirement = "";
    $msgType = "success";
    $msgTitle = "Successfully Sent!";
    if(isset($_POST['txtRequestIdResubmit']) && isset($_POST['txtRequestIdResubmit'])) {   
        $requestId = $_POST['txtRequestIdResubmit'];
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
                    $msgStr = 'There was some error moving the file to upload directory. Please make sure the upload directory is writable by web server.';
                    $msgType = "error";
                    $msgTitle = "Failed Action!";
                }
            }
            else {
                $msgStr = 'Upload failed. Allowed file types: ' . implode(',', $allowedfileExtensions);
                $msgType = "error";
                $msgTitle = "Failed Action!";
            }
        }
    }
    
    if($msgStr === "") {
        $remarks = "RESUBMITTED REQUIREMENT (" . strtoupper(date('M d, Y')) . ")";
        $updatePickUpDateQry = mysqli_query($conn,"UPDATE request SET document_requirement_submitted = '$submittedRequirement', request_date = NOW(), status = 'FOR APPROVAL', remarks = '$remarks' WHERE id = '$requestId'");  
        $msgStr = "Resubmission of requirment has been saved."; 

        $userId = $_SESSION['userId'];
        $query=mysqli_query($conn,"SELECT * FROM student_registration WHERE id='$userId'");          
        $row=mysqli_fetch_array($query);  
        $query2=mysqli_query($conn,"SELECT document.name as documentName FROM request INNER JOIN document on request.document_id = document.id WHERE request.id='$requestId'");          
        $row2=mysqli_fetch_array($query2);  
        $fullName = getFullName($row['last_name'], $row['first_name'], $row['middle_name'], false, true);
        
        // $emailRecipient = $row['email_address'];
        // $emailSubject = "Document Requirement Resubmitted";
        // $emailBody = "<h2>Document Requirement Resubmitted</h2>";
        // $emailBody .= "<p>Hi <b>" . $fullName . "</b>!";
        // $emailBody .= "Thank you for resubmitting the needed requirements for your request -  <b>" . $row2['documentName'] . "</b>. It is still pending for approval. We will let you know if it is already been approved.</p>";
        // sendEmail($emailRecipient, $emailSubject, $emailBody);

        $cpNumber = $row['cp_number'];
        $smsRecipient = substr($cpNumber, 1);
        $smsBody = "Document Requirement Resubmitted. Hi " . $fullName . "! Thank you for resubmitting the needed requirements for your request - " . $row2['documentName'] . ". It is still pending for approval. We will let you know if it is already been approved.";
        sendSMS($smsRecipient, $smsBody);
    }
    
    $_SESSION['msgType']  = $msgType;       
    $_SESSION['msgTitle']  = $msgTitle;            
    $_SESSION['msg'] = $msgStr;  
    
    $_SESSION['currentPage'] = "pages/student/requests.php";
    header('location: service.php');    
    mysqli_close($conn);
?>