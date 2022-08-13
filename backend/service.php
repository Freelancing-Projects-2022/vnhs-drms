<?php
	// This controls the pages to be displayed
	// this works with home.php (front-end)

	session_start();
	if(isset($_POST['currentPage'])) {
		if(isset($_POST['currentPage']) && $_POST['currentPage'] != "") {
			$_SESSION['currentPage'] = $_POST['currentPage'];
		}
		if(isset($_POST['title']) && $_POST['title'] != "") {
			$_SESSION['menuTitle'] = $_POST['title'];
		}
	}
	header('location: ../home.php');    
?>