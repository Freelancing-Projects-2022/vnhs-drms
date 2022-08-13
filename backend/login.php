<?php
	session_start();
	include('../dbcon.php');
	include('../util.php');   
	
	if ($_SERVER["REQUEST_METHOD"] == "POST") {
		$username = validateInput($_POST['txtUserName']);
		
		if (!preg_match("/^[a-zA-Z0-9_]*$/",$username)) {
            $_SESSION['msgType']  = "error";        
            $_SESSION['msgTitle'] = "Login Failed!";                                 
			$_SESSION['msg'] = "Username should not contain space and special characters!"; 
			header('location: ../index.php');
		}
		else{
            $isSuccess = true;
            $password = validateInput($_POST["txtPassword"]);            
            $_SESSION['userGroup'] = 'ADMIN';

            $query=mysqli_query($conn,"select * from `user` where username='$username' and password='$password'");
            if(mysqli_num_rows($query)==0){                
                $query = mysqli_query($conn,"select * from `student_registration` where username='$username' and password='$password'");                
                $_SESSION['userGroup'] = 'STUDENT';
                if(mysqli_num_rows($query)==0){                      
                    $_SESSION['msgType'] = "error";       
                    $_SESSION['msgTitle'] = "Login Failed!";                   
                    $_SESSION['msg'] = "Invalid Username &amp; password."; 
                    header('location: ../index.php');
                    $isSuccess = false;
                }
                else {          
                    $row=mysqli_fetch_array($query);
                    if($row['status'] == 'ACTIVE') {   
                        $isSuccess = true;
                    }
                    else {            
                        $_SESSION['msgType'] = "error";       
                        $_SESSION['msgTitle'] = "Login Failed!";                   
                        $_SESSION['msg'] = "Account is not yet approved or is inactive."; 
                        header('location: ../index.php');
                        $isSuccess = false;
                    }
                }
            }

            if($isSuccess){			
                if ($_SESSION['userGroup'] == 'ADMIN'){
                    $_SESSION['currentPage']  = "pages/admin/home.php";
                    $query=mysqli_query($conn,"select * from `user` where username='$username' and password='$password'");
                }
                else{
                    $_SESSION['currentPage']  = "pages/student/home.php";
                    $query = mysqli_query($conn,"select * from `student_registration` where username='$username' and password='$password'"); 
                }   
                $row=mysqli_fetch_array($query);
                $_SESSION['userId'] = $row['id'];
                $_SESSION['fullName'] =  getFullName($row['last_name'], $row['first_name'], $row['middle_name'], true, true);
                $_SESSION['firstName'] =  $row['first_name'];
                $_SESSION['profilePicture'] = $row['profile_picture'];
                $_SESSION['pageTitle'] = "DASHBOARD";
                header('location: ../home.php');

                $_SESSION['menuTitle']  = "DASHBOARD";
            }		
		}
	}
?>