<?php
    session_start();
    if(isset($_SESSION['currentPage'])) {
?> 
<?php include('home-header.php'); ?>
<?php include($_SESSION['currentPage']); ?>
<?php
}
else {    
    header('location: index.php');
}
?>