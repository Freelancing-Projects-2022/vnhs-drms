<?php
	session_start();
	include('../dbcon.php');
	include('../util.php');
	
    $statusMsg = ''; 
    $logo = '';
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
                    $logo = 'uploads/' . $newFileName;
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
            $logo = $_POST['txtOrigPicture'];
        }

        if($statusMsg === '') {
            $systemDisplayName = validateInput($_POST['txtSystemDisplayName']);
            $organizationName = validateInput($_POST['txtOrganizationName']);
            $maxCountOfRequestPerDay = validateInput($_POST['txtMaxNumOfRequestPerDay']);
            $settingsId = validateInput($_POST['txtId']);

            $sql = "UPDATE settings SET logo = '$logo', system_display_name = '$systemDisplayName', organization_name ='$organizationName',
                    max_count_of_request_per_day = '$maxCountOfRequestPerDay' WHERE id = '$settingsId'";
            if (mysqli_query($conn, $sql)) {    
                $_SESSION['msgType']  = "success";       
                $_SESSION['msgTitle']  = "Successfully Updated!";                   
                $_SESSION['msg'] = "System settings has been updated."; 
                unset($_FILES['uploadedFile']);
                
            } else{
                $_SESSION['msgType']  = "error";       
                $_SESSION['msgTitle']  = "Failed Updating Settings!";         
                $_SESSION['msg'] = $statusMsg;   
            }
        }
        else {
            $_SESSION['msgType']  = "error";       
            $_SESSION['msgTitle']  = "Failed Updating System Settings!";            
            $_SESSION['msg'] = $statusMsg;   
        }
        
        $_SESSION['currentPage'] = "pages/admin/settings.php";
        header('location: service.php');    
        mysqli_close($conn);
    }
?>