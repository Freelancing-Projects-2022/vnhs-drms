<?php
	session_start();
	include('../dbcon.php');
	include('../util.php');
	//include('../sendEmail.php');
	include('../sendSMS.php');
	
    if(isset($_POST['submit'])) {
		$lastName = validateInput($_POST['txtLastName']);
		$firstName = validateInput($_POST['txtFirstName']);
		$middleName = validateInput($_POST['txtMiddleName']);
		$emailAddress = validateInput($_POST['txtEmailAddress']);
		$cpNumber = validateInput($_POST['txtCPNumber']);
        $userName = validateInput($_POST['txtLRN']);
		$password = validateInput($_POST['txtPassword']);
		$lrn = validateInput($_POST['txtLRN']);
        $profilePicture = 'images/no-pp.png';
        $status = "FOR APPROVAL";
        $remarks = "";
        $fullName = "";

        $query=mysqli_query($conn,"select * from `student_registration` where lrn='$lrn'");            
        if (validating($cpNumber) != "") {
            $_SESSION['msgType']  = "error";       
            $_SESSION['msgTitle']  = "Invalid Phone Number!";   
            $_SESSION['msg'] = validating($cpNumber);
            header('location: ../pages/student/register.php');
        }
        else if(mysqli_num_rows($query) > 0){
            $row=mysqli_fetch_array($query);
             $fullName = getFullName($row['last_name'], $row['first_name'], $row['middle_name'], false, true);
            if($row['status'] == "ACTIVE") {
                $_SESSION['msgType']  = "error";       
                $_SESSION['msgTitle']  = "Student Exist!";   
                $_SESSION['msg'] = "There is currently an existing account with the LRN: " . $lrn . ". Registered under " . $fullName  . ".";
                header('location: ../pages/student/register.php');
            }
            else if($row['status'] == "FOR APPROVAL") {
                $_SESSION['msgType']  = "error";       
                $_SESSION['msgTitle']  = "Student Exist!";   
                $_SESSION['msg'] = "There is currently a pending account with the LRN: " . $lrn . ". Registered under " .  $fullName . ".";
                header('location: ../pages/student/register.php');
            }
        }
        else {        
            
            $fullName = getFullName($lastName, $firstName, $middleName, false, true);    
            $sql = "INSERT INTO student_registration (last_name, first_name, middle_name, email_address, cp_number, username, password, lrn, status, profile_picture, remarks, added_timestamp, updated_timestamp)
            VALUES ('$lastName', '$firstName','$middleName','$emailAddress', '$cpNumber', '$userName', '$password', '$lrn', '$status', '$profilePicture', '$remarks', NOW(), NOW())";
        
            if (mysqli_query($conn, $sql)) {    
                $_SESSION['msgType']  = "success";       
                $_SESSION['msgTitle']  = "Account Created!";                   
                $_SESSION['msg'] = "Your request to create an account was been sent to Registrar. Please wait for the confirmation to activate your account."; 

                // $emailRecipient = $_POST['txtEmailAddress'];
                // $emailSubject = "Account Registration";
                // $emailBody = "<h2>Account Registration</h2>";
                // $emailBody .= "<p>Hi <b>" . $fullName . "</b>! Thank you for registering in our Online Document Request Management System.<br>";
                // $emailBody .= "Your application is currently pending for approval. We will let you know if it is already been approved. Please save your account details below:</p>";
                // $emailBody .= "<b>Username / LRN: " . $userName . "</b>";
                // $emailBody .= "<br><b>Password: " . $password . "</b>";
                //sendEmail($emailRecipient, $emailSubject, $emailBody);

                $smsRecipient = substr($_POST['txtCPNumber'], 1);
                $smsBody = "Account Registration. Hi " . $fullName . "! Thank you for registering in our Online Document Request Management System.";
                $smsBody .= "Your application is currently pending for approval. Please save your account details. Username/LRN: " . $userName . " and Password: " . $password;
                sendSMS($smsRecipient, $smsBody);
            } else{
                header('location: history.back()');
                $_SESSION['msgType']  = "error";       
                $_SESSION['msgTitle']  = "Failed Creating Account!";     
                $_SESSION['msg'] = "There is a problem in creating your account.";               
            }
            header('location: ../index.php');
            mysqli_close($conn);
        }
    }
?>