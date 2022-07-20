<?php
    // 'home.php' controls all the pages to be displayed
    // This checks if there is a currentPage being set to displayed
    // If none, it will redirect the user to index.php
    // This prevents unauthorize access to the system.
    
    session_start();
    if(isset($_SESSION['currentPage'])) {
        include('home-header.php');
        include($_SESSION['currentPage']);
    }
    else {    
        header('location: index.php');
    }
?>