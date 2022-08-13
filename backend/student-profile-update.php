<?php
	session_start();
	include('../dbcon.php');
	include('../util.php');
	
    $statusMsg = ''; 
    $profilePicture = '';
    if(isset($_POST['submit'])) {
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
                    $profilePicture = 'uploads/' . $newFileName;
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
            $profilePicture = $_POST['txtOrigPicture'];
        }

        if($statusMsg === '') {
            $emailAddress = $_POST['txtEmailAddress'];
            $cpNumber = validateInput($_POST['txtCpNumber']);
            $password = validateInput($_POST['txtPassword']);
            $userId = validateInput($_POST['txtId']);

            $sql = "UPDATE student_registration SET email_address='$emailAddress', cp_number='$cpNumber', password='$password', profile_picture='$profilePicture', updated_timestamp='NOW()' WHERE id = '$userId'";
            if (mysqli_query($conn, $sql)) {    
                $_SESSION['msgType']  = "success";       
                $_SESSION['msgTitle']  = "Successfully Updated!";                   
                $_SESSION['msg'] = "Profile has been updated."; 
                $_SESSION['profilePicture'] = $profilePicture;
                unset($_FILES['uploadedFile']);
            } else{
                $_SESSION['msgType']  = "error";       
                $_SESSION['msgTitle']  = "Failed Updating Profile!";         
                $_SESSION['msg'] = $statusMsg;   
            }
        }
        else {
            $_SESSION['msgType']  = "error";       
            $_SESSION['msgTitle']  = "Failed Updating Profile!";            
            $_SESSION['msg'] = $statusMsg;   
        }
        
        $_SESSION['currentPage'] = "pages/student/user-account.php";
        header('location: service.php');    
        mysqli_close($conn);
    }
?>